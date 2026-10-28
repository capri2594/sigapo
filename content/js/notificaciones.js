/**
 * SIRC / SIGAPO 2026 - Módulo de Notificaciones en Vivo con Semáforo Interactivo
 * Compatible con Prototype.js 1.4.0 y todos los navegadores modernos
 */

var _notifDataCache = null;
var _notifFiltroActual = 'todos'; // 'todos' | 'normal' | 'alerta' | 'mora'

function notifAddClass(el, cls) {
    if (!el) return;
    if (el.classList && el.classList.add) {
        el.classList.add(cls);
    } else if (typeof Element !== 'undefined' && Element.addClassName) {
        Element.addClassName(el, cls);
    } else if (el.className.indexOf(cls) === -1) {
        el.className = (el.className + ' ' + cls).trim();
    }
}

function notifRemoveClass(el, cls) {
    if (!el) return;
    if (el.classList && el.classList.remove) {
        el.classList.remove(cls);
    } else if (typeof Element !== 'undefined' && Element.removeClassName) {
        Element.removeClassName(el, cls);
    } else {
        el.className = el.className.replace(new RegExp('\\b' + cls + '\\b', 'g'), ' ').trim();
    }
}

function notificaciones() {
    var url = 'content/ajax/notificaciones_check.php';
    var myRand = parseInt(Math.random() * 999999999999999);
    var pars = 'rand=' + myRand;

    new Ajax.Request(url, {
        method: 'get',
        parameters: pars,
        onSuccess: function(transport) {
            try {
                var respText = transport.responseText;
                var data = null;
                if (window.JSON && window.JSON.parse) {
                    data = JSON.parse(respText);
                } else {
                    data = eval('(' + respText + ')');
                }

                if (data && data.status === 'ok') {
                    _notifDataCache = data;
                    actualizarNotificacionesUI(data);
                } else if (data && data.status === 'unauthenticated') {
                    mostrarErrorNotificaciones('Sin sesión activa');
                } else {
                    mostrarErrorNotificaciones('Respuesta no válida');
                }
            } catch(e) {
                mostrarErrorNotificaciones('Error procesando datos: ' + (e.message || e));
            }
        },
        onFailure: function() {
            mostrarErrorNotificaciones('Error de conexión con el servidor');
        }
    });

    // Sondeo periódico cada 45 segundos
    setTimeout("notificaciones()", 45000);
}

function mostrarErrorNotificaciones(msg) {
    var list = $('notif_list');
    if (list) {
        list.innerHTML = '<div class="notif-empty-state">' +
            '<p style="color: #ef4444; font-size: 11px;">' + msg + '</p>' +
            '</div>';
    }
}

function actualizarNotificacionesUI(data) {
    var badge = $('notif_badge');
    var bell = $('notif_bell');
    var headerCount = $('notif_header_count');
    var semaforoBar = $('notif_semaforo_summary');

    if (!badge || !bell) return;

    var total = parseInt(data.total) || 0;
    var mora = parseInt(data.mora) || 0;
    var alerta = parseInt(data.alerta) || 0;
    var normal = parseInt(data.normal) || 0;

    if (total > 0) {
        badge.innerHTML = total > 99 ? '99+' : total;
        badge.style.display = 'flex';
        notifAddClass(bell, 'has-notifs');

        // Si hay documentos en mora crítica, el badge pulsa con mayor urgencia
        if (mora > 0) {
            notifAddClass(badge, 'badge-mora-critica');
        } else {
            notifRemoveClass(badge, 'badge-mora-critica');
        }
    } else {
        badge.style.display = 'none';
        notifRemoveClass(bell, 'has-notifs');
        notifRemoveClass(badge, 'badge-mora-critica');
    }

    // Cabecera interactiva del desplegable
    if (semaforoBar) {
        var actNormal = _notifFiltroActual === 'normal' ? ' semaforo-mini-active' : '';
        var actAlerta = _notifFiltroActual === 'alerta' ? ' semaforo-mini-active' : '';
        var actMora = _notifFiltroActual === 'mora' ? ' semaforo-mini-active' : '';

        semaforoBar.innerHTML = 
            '<span class="semaforo-mini semaforo-mini-normal' + actNormal + '" onclick="filtrarNotificaciones(\'normal\', event);" title="Clic para filtrar: En Plazo (0-2 días)">🟢 ' + normal + '</span>' +
            '<span class="semaforo-mini semaforo-mini-alerta' + actAlerta + '" onclick="filtrarNotificaciones(\'alerta\', event);" title="Clic para filtrar: Prioritario (3-5 días)">🟡 ' + alerta + '</span>' +
            '<span class="semaforo-mini semaforo-mini-mora' + actMora + '" onclick="filtrarNotificaciones(\'mora\', event);" title="Clic para filtrar: En Mora (>5 días)">🔴 ' + mora + '</span>';
    }

    renderizarListaNotificaciones();
}

function filtrarNotificaciones(tipo, e) {
    if (e && e.stopPropagation) {
        e.stopPropagation();
    } else if (window.event) {
        window.event.cancelBubble = true;
    }

    if (_notifFiltroActual === tipo) {
        // Al hacer clic sobre el filtro activo, vuelve a mostrar todos
        _notifFiltroActual = 'todos';
    } else {
        _notifFiltroActual = tipo;
    }

    if (_notifDataCache) {
        actualizarNotificacionesUI(_notifDataCache);
    }
}

function renderizarListaNotificaciones() {
    var list = $('notif_list');
    var headerCount = $('notif_header_count');
    if (!list || !_notifDataCache) return;

    var items = _notifDataCache.items || [];
    var totalGlobal = parseInt(_notifDataCache.total) || 0;

    // Aplicar filtro según el foquito seleccionado
    var itemsFiltrados = [];
    if (_notifFiltroActual === 'todos') {
        itemsFiltrados = items;
    } else {
        for (var f = 0; f < items.length; f++) {
            if (items[f].estado_semaforo === _notifFiltroActual) {
                itemsFiltrados.push(items[f]);
            }
        }
    }

    // Actualizar texto del contador
    if (headerCount) {
        if (_notifFiltroActual === 'todos') {
            headerCount.innerHTML = totalGlobal + (totalGlobal === 1 ? ' pendiente' : ' pendientes');
            headerCount.title = 'Mostrando todos los trámites';
            headerCount.onclick = null;
        } else {
            var labelFiltro = _notifFiltroActual === 'normal' ? '🟢 En Plazo' : (_notifFiltroActual === 'alerta' ? '🟡 Prioritario' : '🔴 En Mora');
            headerCount.innerHTML = itemsFiltrados.length + ' de ' + totalGlobal + ' (' + labelFiltro + ') <span style="font-weight:normal; text-decoration:underline; font-size:9px;">[Ver todos]</span>';
            headerCount.title = 'Clic para volver a mostrar todos';
            headerCount.onclick = function(e) { filtrarNotificaciones('todos', e); };
        }
        headerCount.style.display = 'inline-block';
    }

    // Renderizar tarjetas
    if (itemsFiltrados.length === 0) {
        var msgVacio = 'No tienes correspondencia pendiente de recepción.';
        if (_notifFiltroActual !== 'todos') {
            var colorTxt = _notifFiltroActual === 'normal' ? 'en plazo (0-2 días)' : (_notifFiltroActual === 'alerta' ? 'prioritarios (3-5 días)' : 'en mora (>5 días)');
            msgVacio = 'No tienes trámites ' + colorTxt + '.<br/><a href="javascript:void(0)" onclick="filtrarNotificaciones(\'todos\', event);" style="color:#fda4af; text-decoration:underline; font-size:11px; margin-top:6px; display:inline-block;">Mostrar todos los pendientes</a>';
        }

        list.innerHTML = '<div class="notif-empty-state">' +
            '<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="margin-bottom:6px;"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>' +
            '<div>¡Sin registros!</div>' +
            '<p>' + msgVacio + '</p>' +
            '</div>';
    } else {
        var html = '';
        for (var i = 0; i < itemsFiltrados.length; i++) {
            var it = itemsFiltrados[i];
            var semaforoClass = 'notif-item-' + (it.estado_semaforo || 'normal');
            var pillSemaforoClass = 'notif-semaforo-' + (it.estado_semaforo || 'normal');
            var hrSafe = (it.hr || '').replace(/'/g, "\\'");
            var remitente = (it.remitente || '').replace(/</g, "&lt;").replace(/>/g, "&gt;");
            var proveido = (it.proveido || '').replace(/</g, "&lt;").replace(/>/g, "&gt;");
            var tiempo = (it.tiempo || '');
            var badgeSemaforo = (it.badge_semaforo || 'En Plazo');

            html += '<div class="notif-item ' + semaforoClass + '" onclick="abrirRecepcionDirecta(\'' + hrSafe + '\');">' +
                '<div class="notif-item-header">' +
                    '<span class="notif-item-hr">' + hrSafe + '</span>' +
                    '<span class="notif-item-time">' + tiempo + '</span>' +
                '</div>' +
                '<div class="notif-item-sender">' + remitente + '</div>' +
                '<div class="notif-item-footer-row">' +
                    '<span class="notif-pill">' + proveido + '</span>' +
                    '<span class="notif-semaforo-pill ' + pillSemaforoClass + '">' + badgeSemaforo + '</span>' +
                '</div>' +
            '</div>';
        }
        list.innerHTML = html;
    }
}

function toggleNotifDropdown(e) {
    if (e && e.stopPropagation) {
        e.stopPropagation();
    } else if (window.event) {
        window.event.cancelBubble = true;
    }

    var dropdown = $('notif_dropdown');
    if (!dropdown) return;

    if (dropdown.style.display === 'none' || dropdown.style.display === '') {
        dropdown.style.display = 'block';
    } else {
        dropdown.style.display = 'none';
    }
}

function abrirRecepcionDirecta(hrCod) {
    var dropdown = $('notif_dropdown');
    if (dropdown) dropdown.style.display = 'none';
    
    if (!hrCod) return;

    var url = 'content/RecibirHojaRutaPersonalizado.php?cod=' + encodeURIComponent(hrCod);
    var features = 'menubar=yes,scrollbars=yes,resizable=yes,width=980,height=680,left=60,top=30';

    if (typeof MM_openBrWindow === 'function') {
        MM_openBrWindow(url, 'recibir_hr', features);
    } else {
        window.open(url, 'recibir_hr', features);
    }
}

function abrirBandejaEntrada() {
    var dropdown = $('notif_dropdown');
    if (dropdown) dropdown.style.display = 'none';
    
    if (typeof MM_openBrWindow === 'function') {
        MM_openBrWindow('content/vistasTablas/MisRecibidosHoy.php', '', 'menubar=yes,scrollbars=yes,resizable=yes,width=700,height=500');
    } else {
        window.open('content/vistasTablas/MisRecibidosHoy.php', 'vrecib', 'menubar=yes,scrollbars=yes,resizable=yes,width=700,height=500');
    }
}

// Cierre automático al hacer clic fuera del desplegable
Event.observe(document, 'click', function(e) {
    var dropdown = $('notif_dropdown');
    var container = $('notif_container');
    if (!dropdown || dropdown.style.display === 'none') return;

    var target = Event.element(e);
    if (!target.descendantOf(container) && target !== container) {
        dropdown.style.display = 'none';
    }
});
