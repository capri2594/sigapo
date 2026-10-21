/**
 * SIRC / SIGAPO 2026 - Módulo de Notificaciones en Vivo
 * Controla el sondeo asíncrono y la interacción con la campanita de la cabecera.
 */

function notificaciones() {
    var url = 'content/ajax/notificaciones_check.php';
    var myRand = parseInt(Math.random() * 999999999999999);
    var pars = 'rand=' + myRand;

    new Ajax.Request(url, {
        method: 'get',
        parameters: pars,
        onSuccess: function(transport) {
            try {
                var data = transport.responseText.evalJSON();
                if (data && data.status === 'ok') {
                    actualizarNotificacionesUI(data);
                }
            } catch(e) {
                // Silencioso en caso de error de parseo JSON
            }
        }
    });

    // Sondeo ligero cada 45 segundos
    setTimeout("notificaciones()", 45000);
}

function actualizarNotificacionesUI(data) {
    var badge = $('notif_badge');
    var bell = $('notif_bell');
    var headerCount = $('notif_header_count');
    var list = $('notif_list');

    if (!badge || !bell) return;

    var total = parseInt(data.total) || 0;

    if (total > 0) {
        badge.innerHTML = total > 99 ? '99+' : total;
        badge.style.display = 'flex';
        bell.addClassName('has-notifs');
    } else {
        badge.style.display = 'none';
        bell.removeClassName('has-notifs');
    }

    if (headerCount) {
        headerCount.innerHTML = total + (total === 1 ? ' pendiente' : ' pendientes');
    }

    if (list) {
        if (!data.items || data.items.length === 0) {
            list.innerHTML = '<div class="notif-empty-state">' +
                '<svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="margin-bottom:6px;"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>' +
                '<div>¡Todo al día!</div>' +
                '<p>No tienes correspondencia pendiente de recepción.</p>' +
                '</div>';
        } else {
            var html = '';
            for (var i = 0; i < data.items.length; i++) {
                var it = data.items[i];
                html += '<div class="notif-item" onclick="abrirRecepcionDirecta(\'' + it.hr + '\');">' +
                    '<div class="notif-item-header">' +
                        '<span class="notif-item-hr">' + it.hr + '</span>' +
                        '<span class="notif-item-time">' + it.tiempo + '</span>' +
                    '</div>' +
                    '<div class="notif-item-sender">' + it.remitente + '</div>' +
                    '<div class="notif-item-proveido">' +
                        '<span class="notif-pill">' + it.proveido + '</span>' +
                    '</div>' +
                '</div>';
            }
            list.innerHTML = html;
        }
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
    
    // Abre directamente el libro de recepción o la hoja de ruta
    if (typeof MM_openBrWindow === 'function') {
        MM_openBrWindow('content/vistasTablas/MisRecibidosHoy.php', '', 'menubar=yes,scrollbars=yes,resizable=yes,width=700,height=500');
    } else {
        window.open('content/vistasTablas/MisRecibidosHoy.php', 'vrecib', 'menubar=yes,scrollbars=yes,resizable=yes,width=700,height=500');
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
