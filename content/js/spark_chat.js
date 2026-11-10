/**
 * SIGAPO 2026 - Motor Cliente "SIGAPO Spark" (Chat Interno 1 a 1, Presencia por Unidades y Comunicados en Masa)
 * Sin dependencias externas, 100% compatible con Prototype.js 1.4.0 y todos los navegadores modernos.
 */
(function() {
    if (window.__sigapoSparkInitialized) return;
    window.__sigapoSparkInitialized = true;

    var state = {
        panelOpen: false,
        activeTab: 'roster', // 'roster' | 'broadcasts'
        filterMode: 'all',   // 'all' | 'online' | 'unread'
        searchQuery: '',
        soundEnabled: true,
        onlineCount: 1,
        unreadTotal: 0,
        unreadByUser: {},
        lastMsgId: 0,
        users: [],
        dependencias: [],
        broadcasts: [],
        activePeer: null,    // { cuenta, nombre, cargo, dep_nombre, online, avatar }
        lastChatId: 0,
        shownBroadcastId: 0,
        pollTimer: null
    };

    try {
        var savedSound = localStorage.getItem('sigapo_spark_sound');
        if (savedSound === 'off') state.soundEnabled = false;
    } catch (e) {}

    // =========================================================================
    // SONIDOS SINTETIZADOS (WEB AUDIO API - CERO ARCHIVOS EXTERNOS)
    // =========================================================================
    function playSparkSound(type) {
        if (!state.soundEnabled) return;
        try {
            var AudioCtx = window.AudioContext || window.webkitAudioContext;
            if (!AudioCtx) return;
            var ctx = new AudioCtx();

            if (type === 'zumbido' || type === 'broadcast') {
                var freqs = [587.33, 880, 587.33, 880];
                for (var i = 0; i < freqs.length; i++) {
                    (function(idx) {
                        var osc = ctx.createOscillator();
                        var gain = ctx.createGain();
                        osc.type = 'triangle';
                        osc.frequency.value = freqs[idx];
                        gain.gain.setValueAtTime(0.18, ctx.currentTime + idx * 0.11);
                        gain.gain.exponentialRampToValueAtTime(0.001, ctx.currentTime + (idx + 1) * 0.11);
                        osc.connect(gain);
                        gain.connect(ctx.destination);
                        osc.start(ctx.currentTime + idx * 0.11);
                        osc.stop(ctx.currentTime + (idx + 1) * 0.11);
                    })(i);
                }
            } else {
                // Sonido suave de mensaje nuevo (2 tonos armónicos)
                var osc1 = ctx.createOscillator();
                var gain1 = ctx.createGain();
                osc1.type = 'sine';
                osc1.frequency.setValueAtTime(523.25, ctx.currentTime);
                osc1.frequency.setValueAtTime(659.25, ctx.currentTime + 0.09);
                gain1.gain.setValueAtTime(0.14, ctx.currentTime);
                gain1.gain.exponentialRampToValueAtTime(0.001, ctx.currentTime + 0.26);
                osc1.connect(gain1);
                gain1.connect(ctx.destination);
                osc1.start(ctx.currentTime);
                osc1.stop(ctx.currentTime + 0.26);
            }
        } catch (e) {}
    }

    // =========================================================================
    // HELPER AJAX NATIVO
    // =========================================================================
    function sparkRequest(method, params, callback) {
        var xhr = new XMLHttpRequest();
        var url = 'content/ajax/spark_api.php';
        var queryParts = [];
        for (var k in params) {
            if (Object.prototype.hasOwnProperty.call(params, k) && typeof params[k] !== 'function') {
                queryParts.push(encodeURIComponent(k) + '=' + encodeURIComponent(params[k]));
            }
        }
        queryParts.push('_t=' + new Date().getTime());
        var queryString = queryParts.join('&');

        if (method.toUpperCase() === 'GET') {
            xhr.open('GET', url + '?' + queryString, true);
            xhr.send(null);
        } else {
            xhr.open('POST', url, true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8');
            xhr.send(queryString);
        }

        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4) {
                if (xhr.status >= 200 && xhr.status < 300) {
                    try {
                        var data = window.JSON && window.JSON.parse
                            ? JSON.parse(xhr.responseText)
                            : eval('(' + xhr.responseText + ')');
                        if (callback) callback(null, data);
                    } catch (err) {
                        if (callback) callback(err, null);
                    }
                } else {
                    if (callback) callback(new Error('HTTP ' + xhr.status), null);
                }
            }
        };
    }

    function escapeHtml(str) {
        if (str === null || str === undefined) return '';
        return String(str)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    // Formatear mensaje detectando códigos de Hoja de Ruta (ej: #ATI-99/2026 o [HR:ATI-99/2026])
    function formatSparkMessage(rawText) {
        var safe = escapeHtml(rawText);
        // Convertir [HR:CODIGO] o #CODIGO-HR (ej: #ATI-99/2026) en botón clicable
        safe = safe.replace(/\[HR:([A-Za-z0-9\-_\/\.]+)\]/g, function(_, code) {
            return '<span class="spark-hr-chip" onclick="window.openSparkHR(\'' + code.replace(/'/g, '') + '\')" title="Ver Hoja de Ruta ' + code + '">📄 H.R. ' + code + '</span>';
        });
        safe = safe.replace(/(^|\s)#([A-Za-z0-9]{2,12}-\d+\/\d{4})/g, function(m, prefix, code) {
            return prefix + '<span class="spark-hr-chip" onclick="window.openSparkHR(\'' + code.replace(/'/g, '') + '\')" title="Ver Hoja de Ruta ' + code + '">📄 ' + code + '</span>';
        });
        return safe.replace(/\n/g, '<br/>');
    }

    window.openSparkHR = function(hrCode) {
        if (!hrCode) return;
        var url = 'content/reporte_hr.php?hr=' + encodeURIComponent(hrCode);
        if (typeof window.MM_openBrWindow === 'function') {
            window.MM_openBrWindow(url, 'reporte_hr_spark', 'menubar=yes,scrollbars=yes,resizable=yes,width=900,height=620');
        } else {
            window.open(url, 'reporte_hr_spark', 'menubar=yes,scrollbars=yes,resizable=yes,width=900,height=620');
        }
    };

    // =========================================================================
    // CONSTRUCCIÓN DE LA INTERFAZ DOM DE SIGAPO SPARK
    // =========================================================================
    function buildSparkDOM() {
        if (document.getElementById('sigapo_spark_dock')) return;

        var dock = document.createElement('div');
        dock.id = 'sigapo_spark_dock';
        dock.innerHTML = [
            '<!-- VENTANA DE CONVERSACIÓN 1 A 1 -->',
            '<div id="sigapo_spark_chatbox" class="spark-chat-window" style="display:none;">',
            '  <div class="spark-header">',
            '    <div class="spark-header-title" style="min-width:0; flex:1;">',
            '      <div class="spark-avatar-wrap" style="width:28px !important; height:28px !important;">',
            '        <img id="spark_chat_peer_avatar" class="spark-avatar-img" src="perfiles/fotos/default_avatar013.jpg" style="width:28px !important; height:28px !important;" alt="" />',
            '        <span id="spark_chat_peer_dot" class="spark-status-dot offline"></span>',
            '      </div>',
            '      <div style="min-width:0; flex:1; overflow:hidden;">',
            '        <div id="spark_chat_peer_name" style="font-size:11px; font-weight:800; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">Funcionario</div>',
            '        <div id="spark_chat_peer_dep" style="font-size:9px; font-weight:500; opacity:0.85; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">Dependencia</div>',
            '      </div>',
            '    </div>',
            '    <div class="spark-header-actions">',
            '      <button type="button" class="spark-icon-btn" onclick="window.closeSparkChatbox();" title="Cerrar conversación">✕</button>',
            '    </div>',
            '  </div>',
            '  <div id="spark_chat_messages" class="spark-chat-messages"></div>',
            '  <div class="spark-chat-actions-bar">',
            '    <button type="button" class="spark-mini-tool-btn" onclick="window.sendSparkBuzz();" title="Enviar Zumbido de atención urgente (Estilo Spark)">⚡ Zumbido</button>',
            '    <button type="button" class="spark-mini-tool-btn" onclick="window.promptSparkHR();" title="Insertar referencia a una Hoja de Ruta">📎 Citar H.R.</button>',
            '  </div>',
            '  <div class="spark-chat-input-row">',
            '    <input type="text" id="spark_chat_input" class="spark-chat-input" placeholder="Escribe un mensaje interno..." maxlength="600" autocomplete="off" />',
            '    <button type="button" class="spark-send-btn" onclick="window.sendSparkTextMessage();">Enviar</button>',
            '  </div>',
            '</div>',

            '<!-- PANEL PRINCIPAL SIGAPO SPARK (DIRECTORIO + COMUNICADOS) -->',
            '<div id="sigapo_spark_panel" class="spark-panel-window" style="display:none;">',
            '  <div class="spark-header">',
            '    <div class="spark-header-title">',
            '      <span style="font-size:15px;">💬</span>',
            '      <span>SIGAPO SPARK</span>',
            '      <span id="spark_panel_online_pill" style="font-size:10px; background:rgba(16,185,129,0.22); border:1px solid rgba(16,185,129,0.5); color:#34d399; padding:1px 7px; border-radius:999px;">1 en línea</span>',
            '    </div>',
            '    <div class="spark-header-actions">',
            '      <button type="button" id="spark_sound_btn" class="spark-icon-btn" onclick="window.toggleSparkSound();" title="Activar/Silenciar sonidos de alerta">🔊</button>',
            '      <button type="button" class="spark-icon-btn" onclick="window.refreshSparkActiveTab();" title="Actualizar lista">↻</button>',
            '      <button type="button" class="spark-icon-btn" onclick="window.toggleSigapoSpark(false);" title="Minimizar ventana">―</button>',
            '    </div>',
            '  </div>',
            '  <div class="spark-tabs">',
            '    <div id="spark_tab_roster" class="spark-tab active" onclick="window.switchSparkTab(\'roster\');">👥 Funcionarios</div>',
            '    <div id="spark_tab_broadcasts" class="spark-tab" onclick="window.switchSparkTab(\'broadcasts\');">📢 Comunicados</div>',
            '  </div>',

            '  <!-- VISTA 1: DIRECTORIO DE FUNCIONARIOS -->',
            '  <div id="spark_view_roster" style="display:flex; flex-direction:column; flex:1; min-height:0;">',
            '    <div class="spark-toolbar">',
            '      <input type="text" id="spark_roster_search" class="spark-search-input" placeholder="🔍 Buscar funcionario, cargo o unidad..." autocomplete="off" />',
            '      <div class="spark-filter-pills">',
            '        <div id="spark_filter_all" class="spark-pill active" onclick="window.setSparkFilter(\'all\');">Todos</div>',
            '        <div id="spark_filter_online" class="spark-pill" onclick="window.setSparkFilter(\'online\');">🟢 En Línea</div>',
            '        <div id="spark_filter_unread" class="spark-pill" onclick="window.setSparkFilter(\'unread\');">💬 No Leídos</div>',
            '      </div>',
            '    </div>',
            '    <div id="spark_roster_list" class="spark-body-list">',
            '      <div style="padding:20px; text-align:center; font-size:12px; opacity:0.75;">Cargando directorio institucional...</div>',
            '    </div>',
            '  </div>',

            '  <!-- VISTA 2: COMUNICADOS EN MASA (BROADCAST) -->',
            '  <div id="spark_view_broadcasts" style="display:none; flex-direction:column; flex:1; min-height:0;">',
            '    <div class="spark-toolbar">',
            '      <button type="button" class="spark-new-broadcast-btn" onclick="window.openSparkBroadcastComposer();">',
            '        <span>📢 Emitir Comunicado en Masa</span>',
            '      </button>',
            '    </div>',
            '    <div id="spark_broadcast_list" class="spark-body-list">',
            '      <div style="padding:20px; text-align:center; font-size:12px; opacity:0.75;">Cargando comunicados...</div>',
            '    </div>',
            '  </div>',
            '</div>',

            '<!-- BOTÓN FLOTANTE MINIMIZADO (BARRA RÁPIDA ESTILO SPARK) -->',
            '<div id="sigapo_spark_fab" onclick="window.toggleSigapoSpark();">',
            '  <span class="spark-fab-dot"></span>',
            '  <span>💬 Spark Chat</span>',
            '  <span id="spark_fab_online" style="opacity:0.9; font-weight:600;">(1)</span>',
            '  <span id="spark_fab_unread" class="spark-fab-unread" style="display:none;">0</span>',
            '</div>'
        ].join('\n');

        document.body.appendChild(dock);

        // Modal para Comunicados Emergentes en Masa (Broadcast entrante)
        var broadOverlay = document.createElement('div');
        broadOverlay.id = 'sigapo_broadcast_overlay';
        broadOverlay.className = 'spark-modal-overlay';
        broadOverlay.style.display = 'none';
        broadOverlay.innerHTML = [
            '<div id="sigapo_broadcast_card" class="spark-modal-card">',
            '  <div id="sigapo_broadcast_header" class="spark-modal-header">',
            '    <div style="display:flex; align-items:center; gap:8px; font-size:13px; font-weight:800; text-transform:uppercase; letter-spacing:0.5px;">',
            '      <span id="sigapo_broadcast_icon">📢</span>',
            '      <span id="sigapo_broadcast_badge_text">COMUNICADO INSTITUCIONAL EN MASA</span>',
            '    </div>',
            '    <span id="sigapo_broadcast_date" style="font-size:11px; opacity:0.85;"></span>',
            '  </div>',
            '  <div class="spark-modal-body">',
            '    <div id="sigapo_broadcast_title" style="font-size:16px; font-weight:800; margin-bottom:10px;"></div>',
            '    <div id="sigapo_broadcast_msg" style="font-size:13px; line-height:1.6; padding:12px 14px; border-radius:8px; background:rgba(180,138,40,0.08); border:1px solid rgba(180,138,40,0.3); margin-bottom:14px; white-space:pre-wrap;"></div>',
            '    <div style="display:flex; align-items:center; justify-content:space-between; font-size:11px; opacity:0.85;">',
            '      <div><strong>Emitido por:</strong> <span id="sigapo_broadcast_author"></span></div>',
            '      <div><strong>Unidad:</strong> <span id="sigapo_broadcast_dep"></span></div>',
            '    </div>',
            '  </div>',
            '  <div class="spark-modal-footer">',
            '    <button type="button" class="spark-btn-ack" onclick="window.acknowledgeCurrentBroadcast();">✅ ENTERADO / CONFIRMAR LECTURA</button>',
            '  </div>',
            '</div>'
        ].join('\n');
        document.body.appendChild(broadOverlay);

        // Modal Compositor de Comunicados en Masa y Visor de Lecturas
        var compOverlay = document.createElement('div');
        compOverlay.id = 'sigapo_composer_overlay';
        compOverlay.className = 'spark-modal-overlay';
        compOverlay.style.display = 'none';
        compOverlay.innerHTML = [
            '<div class="spark-modal-card" style="width:500px !important;">',
            '  <div class="spark-modal-header">',
            '    <div id="sigapo_composer_modal_title" style="font-size:13px; font-weight:800; text-transform:uppercase; letter-spacing:0.5px;">📢 EMITIR COMUNICADO EN MASA (SPARK BROADCAST)</div>',
            '    <button type="button" class="spark-icon-btn" onclick="window.closeSparkComposerModal();">✕</button>',
            '  </div>',
            '  <div id="sigapo_composer_modal_body" class="spark-modal-body"></div>',
            '  <div id="sigapo_composer_modal_footer" class="spark-modal-footer"></div>',
            '</div>'
        ].join('\n');
        document.body.appendChild(compOverlay);

        // Eventos de teclado para buscador y envío de chat
        var searchInput = document.getElementById('spark_roster_search');
        if (searchInput) {
            searchInput.addEventListener('input', function() {
                state.searchQuery = this.value || '';
                renderRosterList();
            });
        }

        var chatInput = document.getElementById('spark_chat_input');
        if (chatInput) {
            chatInput.addEventListener('keydown', function(e) {
                if (e.key === 'Enter' || e.keyCode === 13) {
                    e.preventDefault();
                    window.sendSparkTextMessage();
                }
            });
        }

        updateSoundButtonUI();
    }

    function updateSoundButtonUI() {
        var btn = document.getElementById('spark_sound_btn');
        if (!btn) return;
        btn.textContent = state.soundEnabled ? '🔊' : '🔇';
        btn.title = state.soundEnabled ? 'Sonidos activados (Clic para silenciar)' : 'Sonidos silenciados (Clic para activar)';
    }

    window.toggleSparkSound = function() {
        state.soundEnabled = !state.soundEnabled;
        try {
            localStorage.setItem('sigapo_spark_sound', state.soundEnabled ? 'on' : 'off');
        } catch (e) {}
        updateSoundButtonUI();
    };

    // =========================================================================
    // CONTROL DE APERTURA, PESTAÑAS Y FILTROS DEL PANEL
    // =========================================================================
    window.toggleSigapoSpark = function(forceState) {
        buildSparkDOM();
        var panel = document.getElementById('sigapo_spark_panel');
        var fab = document.getElementById('sigapo_spark_fab');
        if (!panel || !fab) return;

        state.panelOpen = (typeof forceState === 'boolean') ? forceState : !state.panelOpen;
        if (state.panelOpen) {
            panel.style.display = 'flex';
            fab.style.display = 'none';
            if (state.activeTab === 'roster') {
                loadSparkRoster();
            } else {
                loadSparkBroadcasts();
            }
        } else {
            panel.style.display = 'none';
            fab.style.display = 'flex';
        }
    };

    window.switchSparkTab = function(tabName) {
        state.activeTab = tabName;
        var tRos = document.getElementById('spark_tab_roster');
        var tBro = document.getElementById('spark_tab_broadcasts');
        var vRos = document.getElementById('spark_view_roster');
        var vBro = document.getElementById('spark_view_broadcasts');

        if (tabName === 'broadcasts') {
            if (tRos) tRos.className = 'spark-tab';
            if (tBro) tBro.className = 'spark-tab active';
            if (vRos) vRos.style.display = 'none';
            if (vBro) vBro.style.display = 'flex';
            loadSparkBroadcasts();
        } else {
            if (tRos) tRos.className = 'spark-tab active';
            if (tBro) tBro.className = 'spark-tab';
            if (vRos) vRos.style.display = 'flex';
            if (vBro) vBro.style.display = 'none';
            loadSparkRoster();
        }
    };

    window.refreshSparkActiveTab = function() {
        if (state.activeTab === 'broadcasts') {
            loadSparkBroadcasts();
        } else {
            loadSparkRoster();
        }
    };

    window.setSparkFilter = function(mode) {
        state.filterMode = mode;
        var modes = ['all', 'online', 'unread'];
        for (var i = 0; i < modes.length; i++) {
            var el = document.getElementById('spark_filter_' + modes[i]);
            if (el) {
                el.className = (modes[i] === mode) ? 'spark-pill active' : 'spark-pill';
            }
        }
        renderRosterList();
    };

    // =========================================================================
    // DIRECTORIO DE FUNCIONARIOS (ROSTER POR DEPENDENCIAS)
    // =========================================================================
    function loadSparkRoster() {
        sparkRequest('GET', { action: 'roster' }, function(err, data) {
            if (err || !data || data.status !== 'ok') return;
            state.users = data.users || [];
            state.dependencias = data.dependencias || [];
            renderRosterList();
        });
    }

    function renderRosterList() {
        var container = document.getElementById('spark_roster_list');
        if (!container) return;

        var q = (state.searchQuery || '').toLowerCase().replace(/^\s+|\s+$/g, '');
        var filtered = [];

        for (var i = 0; i < state.users.length; i++) {
            var u = state.users[i];
            var unreadCnt = (state.unreadByUser[u.cuenta] !== undefined) ? state.unreadByUser[u.cuenta] : (u.unread || 0);
            u.unread = unreadCnt;

            if (state.filterMode === 'online' && !u.online) continue;
            if (state.filterMode === 'unread' && unreadCnt <= 0) continue;

            if (q !== '') {
                var hay = (u.nombre + ' ' + u.cuenta + ' ' + u.cargo + ' ' + u.dep_nombre + ' ' + u.dep_sigla).toLowerCase();
                if (hay.indexOf(q) === -1) continue;
            }
            filtered.push(u);
        }

        if (filtered.length === 0) {
            container.innerHTML = '<div style="padding:24px 12px; text-align:center; font-size:12px; opacity:0.75;">No se encontraron funcionarios con ese filtro.</div>';
            return;
        }

        // Agrupar por Dependencia manteniendo primero los que tienen mensajes no leídos o están en línea
        var groups = {};
        var groupOrder = [];
        for (var j = 0; j < filtered.length; j++) {
            var item = filtered[j];
            var gName = item.dep_nombre || 'Otras Unidades';
            if (!groups[gName]) {
                groups[gName] = [];
                groupOrder.push(gName);
            }
            groups[gName].push(item);
        }

        var html = [];
        for (var g = 0; g < groupOrder.length; g++) {
            var depName = groupOrder[g];
            var list = groups[depName];
            var onlineInDep = 0;
            for (var k = 0; k < list.length; k++) {
                if (list[k].online) onlineInDep++;
            }

            html.push('<div class="spark-dep-group-header">');
            html.push('  <span style="overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">🏢 ' + escapeHtml(depName) + '</span>');
            html.push('  <span style="flex-shrink:0; font-size:9px;">' + onlineInDep + '/' + list.length + '</span>');
            html.push('</div>');

            for (var m = 0; m < list.length; m++) {
                var usr = list[m];
                var dotClass = usr.online ? 'online' : 'offline';
                var statusLabel = usr.online ? '🟢 En línea' : '⚪ Offline';
                html.push('<div class="spark-user-item" onclick="window.openSparkChatWith(\'' + escapeHtml(usr.cuenta) + '\');">');
                html.push('  <div class="spark-avatar-wrap">');
                html.push('    <img class="spark-avatar-img" src="' + escapeHtml(usr.avatar) + '" onerror="this.src=\'perfiles/fotos/default_avatar013.jpg\'" alt="" />');
                html.push('    <span class="spark-status-dot ' + dotClass + '" title="' + statusLabel + '"></span>');
                html.push('  </div>');
                html.push('  <div class="spark-user-meta">');
                html.push('    <div class="spark-user-name">' + escapeHtml(usr.nombre) + '</div>');
                html.push('    <div class="spark-user-sub">' + escapeHtml(usr.cargo) + ' (' + escapeHtml(usr.cuenta) + ')</div>');
                html.push('  </div>');
                if (usr.unread > 0) {
                    html.push('  <div class="spark-user-unread">' + usr.unread + '</div>');
                }
                html.push('</div>');
            }
        }

        container.innerHTML = html.join('\n');
    }

    // =========================================================================
    // VENTANA DE CONVERSACIÓN 1 A 1 (CHATBOX)
    // =========================================================================
    window.openSparkChatWith = function(peerAccount) {
        if (!peerAccount) return;
        buildSparkDOM();

        var chatbox = document.getElementById('sigapo_spark_chatbox');
        var msgList = document.getElementById('spark_chat_messages');
        if (chatbox) chatbox.style.display = 'flex';
        if (msgList) msgList.innerHTML = '<div style="padding:20px; text-align:center; font-size:11px; opacity:0.75;">Cargando conversación...</div>';

        state.activePeer = { cuenta: peerAccount };
        state.lastChatId = 0;

        sparkRequest('GET', { action: 'history', peer: peerAccount }, function(err, data) {
            if (err || !data || data.status !== 'ok') return;

            state.activePeer = data.peer;
            updateChatboxHeader(data.peer);

            // Limpiar contador de no leídos de este usuario
            if (state.unreadByUser[peerAccount]) {
                state.unreadTotal = Math.max(0, state.unreadTotal - state.unreadByUser[peerAccount]);
                delete state.unreadByUser[peerAccount];
                updateGlobalBadges();
                renderRosterList();
            }

            renderChatMessages(data.messages || [], false);
            var input = document.getElementById('spark_chat_input');
            if (input) input.focus();
        });
    };

    function updateChatboxHeader(peer) {
        if (!peer) return;
        var nameEl = document.getElementById('spark_chat_peer_name');
        var depEl  = document.getElementById('spark_chat_peer_dep');
        var avEl   = document.getElementById('spark_chat_peer_avatar');
        var dotEl  = document.getElementById('spark_chat_peer_dot');

        if (nameEl) nameEl.textContent = peer.nombre || peer.cuenta;
        if (depEl)  depEl.textContent  = (peer.online ? '🟢 En línea · ' : '⚪ Desconectado · ') + (peer.dep_nombre || peer.cargo || '');
        if (avEl && peer.avatar) avEl.src = peer.avatar;
        if (dotEl) dotEl.className = 'spark-status-dot ' + (peer.online ? 'online' : 'offline');
    }

    window.closeSparkChatbox = function() {
        var chatbox = document.getElementById('sigapo_spark_chatbox');
        if (chatbox) chatbox.style.display = 'none';
        state.activePeer = null;
        state.lastChatId = 0;
    };

    function renderChatMessages(messages, append) {
        var container = document.getElementById('spark_chat_messages');
        if (!container) return;

        if (!append) {
            container.innerHTML = '';
        }

        if (!append && messages.length === 0) {
            container.innerHTML = '<div id="spark_chat_empty_hint" style="padding:26px 14px; text-align:center; font-size:11px; opacity:0.7;">Inicia la conversación con este funcionario.<br/>Puedes enviar mensajes o citar una Hoja de Ruta.</div>';
            return;
        }

        var emptyHint = document.getElementById('spark_chat_empty_hint');
        if (emptyHint && messages.length > 0) {
            emptyHint.parentNode.removeChild(emptyHint);
        }

        for (var i = 0; i < messages.length; i++) {
            var m = messages[i];
            if (m.id > state.lastChatId) {
                state.lastChatId = m.id;
            }
            if (document.getElementById('spark_msg_' + m.id)) continue;

            var row = document.createElement('div');
            row.id = 'spark_msg_' + m.id;
            row.className = 'spark-msg-row ' + (m.is_mine ? 'mine' : 'theirs');

            var bubbleClass = 'spark-msg-bubble' + (m.tipo === 'zumbido' ? ' zumbido' : '');
            var checkMark = m.is_mine ? (m.leido ? ' ✓✓' : ' ✓') : '';

            row.innerHTML = [
                '<div class="' + bubbleClass + '">' + formatSparkMessage(m.mensaje) + '</div>',
                '<div class="spark-msg-time">' + escapeHtml(m.hora || '') + checkMark + '</div>'
            ].join('');

            container.appendChild(row);
        }

        container.scrollTop = container.scrollHeight;
    }

    window.sendSparkTextMessage = function() {
        if (!state.activePeer || !state.activePeer.cuenta) return;
        var input = document.getElementById('spark_chat_input');
        if (!input) return;
        var text = (input.value || '').replace(/^\s+|\s+$/g, '');
        if (!text) return;

        input.value = '';
        sparkRequest('POST', {
            action: 'send_msg',
            to: state.activePeer.cuenta,
            mensaje: text,
            tipo: 'texto'
        }, function(err, data) {
            if (!err && data && data.status === 'ok' && data.message_item) {
                renderChatMessages([data.message_item], true);
            }
        });
    };

    window.sendSparkBuzz = function() {
        if (!state.activePeer || !state.activePeer.cuenta) return;
        var chatbox = document.getElementById('sigapo_spark_chatbox');
        if (chatbox) {
            chatbox.className = 'spark-chat-window spark-buzzing';
            setTimeout(function() {
                chatbox.className = 'spark-chat-window';
            }, 650);
        }
        playSparkSound('zumbido');

        sparkRequest('POST', {
            action: 'send_msg',
            to: state.activePeer.cuenta,
            mensaje: '⚡ Ha enviado un ZUMBIDO de atención urgente.',
            tipo: 'zumbido'
        }, function(err, data) {
            if (!err && data && data.status === 'ok' && data.message_item) {
                renderChatMessages([data.message_item], true);
            }
        });
    };

    window.promptSparkHR = function() {
        if (!state.activePeer || !state.activePeer.cuenta) return;
        var hr = prompt('Ingrese el código de Hoja de Ruta a citar (Ejemplo: ATI-99/2026):', '');
        if (!hr) return;
        hr = hr.replace(/^\s+|\s+$/g, '').toUpperCase();
        if (!hr) return;

        var input = document.getElementById('spark_chat_input');
        if (input) {
            input.value = (input.value ? input.value + ' ' : '') + '[HR:' + hr + '] ';
            input.focus();
        }
    };

    // =========================================================================
    // COMUNICADOS EN MASA (SPARK BROADCASTS)
    // =========================================================================
    function loadSparkBroadcasts() {
        sparkRequest('GET', { action: 'list_broadcasts' }, function(err, data) {
            if (err || !data || data.status !== 'ok') return;
            state.broadcasts = data.broadcasts || [];
            renderBroadcastList();
        });
    }

    function renderBroadcastList() {
        var container = document.getElementById('spark_broadcast_list');
        if (!container) return;

        if (!state.broadcasts || state.broadcasts.length === 0) {
            container.innerHTML = '<div style="padding:24px 12px; text-align:center; font-size:12px; opacity:0.75;">No hay comunicados masivos emitidos recientemente.</div>';
            return;
        }

        var html = [];
        for (var i = 0; i < state.broadcasts.length; i++) {
            var b = state.broadcasts[i];
            var prioBadge = '📢 Informativo';
            if (b.prioridad === 'urgente') prioBadge = '🚨 URGENTE';
            else if (b.prioridad === 'importante') prioBadge = '⚠️ Importante';

            html.push('<div class="spark-broadcast-card ' + escapeHtml(b.prioridad) + '">');
            html.push('  <div style="display:flex; justify-content:space-between; align-items:center; font-size:10px; font-weight:800; margin-bottom:4px;">');
            html.push('    <span>' + prioBadge + ' · ' + escapeHtml(b.alcance_label) + '</span>');
            html.push('    <span style="opacity:0.75;">' + escapeHtml(b.fecha) + '</span>');
            html.push('  </div>');
            html.push('  <div style="font-size:12px; font-weight:800; margin-bottom:4px;">' + escapeHtml(b.titulo) + '</div>');
            html.push('  <div style="font-size:11px; line-height:1.4; opacity:0.92; margin-bottom:6px; white-space:pre-wrap;">' + escapeHtml(b.mensaje) + '</div>');
            html.push('  <div style="display:flex; justify-content:space-between; align-items:center; font-size:10px; opacity:0.85; border-top:1px solid rgba(180,138,40,0.2); padding-top:5px;">');
            html.push('    <span>Por: ' + escapeHtml(b.autor_nombre) + '</span>');
            html.push('    <a href="javascript:void(0)" onclick="window.viewBroadcastReaders(' + b.id + ', \'' + escapeHtml(b.titulo) + '\');" style="color:#10b981; font-weight:800; text-decoration:underline;">👁️ ' + b.total_lecturas + ' confirmaron</a>');
            html.push('  </div>');
            html.push('</div>');
        }

        container.innerHTML = html.join('\n');
    }

    window.openSparkBroadcastComposer = function() {
        buildSparkDOM();
        // Asegurar tener la lista de dependencias cargada
        if (!state.dependencias || state.dependencias.length === 0) {
            sparkRequest('GET', { action: 'roster' }, function(err, data) {
                if (!err && data && data.dependencias) {
                    state.dependencias = data.dependencias;
                }
                showBroadcastComposerUI();
            });
        } else {
            showBroadcastComposerUI();
        }
    };

    function showBroadcastComposerUI() {
        var overlay = document.getElementById('sigapo_composer_overlay');
        var titleEl = document.getElementById('sigapo_composer_modal_title');
        var bodyEl  = document.getElementById('sigapo_composer_modal_body');
        var footEl  = document.getElementById('sigapo_composer_modal_footer');
        if (!overlay || !bodyEl || !footEl) return;

        titleEl.innerHTML = '📢 EMITIR COMUNICADO EN MASA (SPARK BROADCAST)';

        var depOptions = ['<option value="">-- Seleccione una Dependencia / Unidad --</option>'];
        for (var i = 0; i < state.dependencias.length; i++) {
            var d = state.dependencias[i];
            depOptions.push('<option value="' + escapeHtml(d.cod) + '">' + escapeHtml(d.nombre) + (d.sigla ? ' (' + escapeHtml(d.sigla) + ')' : '') + '</option>');
        }

        bodyEl.innerHTML = [
            '<div class="spark-form-group">',
            '  <label class="spark-form-label">Alcance del Comunicado (Destinatarios):</label>',
            '  <select id="spark_bc_alcance_tipo" class="spark-form-control" onchange="document.getElementById(\'spark_bc_dep_wrap\').style.display=(this.value===\'dependencia\'?\'flex\':\'none\');">',
            '    <option value="todos">🌐 Todos los Funcionarios del Sistema (Global)</option>',
            '    <option value="online">🟢 Solo Funcionarios Actualmente en Línea</option>',
            '    <option value="dependencia">🏢 Una Dependencia / Unidad Específica</option>',
            '  </select>',
            '</div>',
            '<div id="spark_bc_dep_wrap" class="spark-form-group" style="display:none;">',
            '  <label class="spark-form-label">Seleccionar Unidad / Dependencia:</label>',
            '  <select id="spark_bc_alcance_valor" class="spark-form-control">' + depOptions.join('') + '</select>',
            '</div>',
            '<div style="display:flex; gap:10px;">',
            '  <div class="spark-form-group" style="flex:1;">',
            '    <label class="spark-form-label">Nivel de Prioridad:</label>',
            '    <select id="spark_bc_prioridad" class="spark-form-control">',
            '      <option value="normal">📢 Informativo (Estándar)</option>',
            '      <option value="importante">⚠️ Importante (Destacado)</option>',
            '      <option value="urgente">🚨 Urgente (Alerta Prioritaria)</option>',
            '    </select>',
            '  </div>',
            '  <div class="spark-form-group" style="flex:1;">',
            '    <label class="spark-form-label">Vigencia del Aviso:</label>',
            '    <select id="spark_bc_vigencia" class="spark-form-control">',
            '      <option value="8">8 Horas (Jornada actual)</option>',
            '      <option value="24" selected="selected">24 Horas (1 Día)</option>',
            '      <option value="72">72 Horas (3 Días)</option>',
            '      <option value="168">7 Días (1 Semana)</option>',
            '    </select>',
            '  </div>',
            '</div>',
            '<div class="spark-form-group">',
            '  <label class="spark-form-label">Título del Comunicado:</label>',
            '  <input type="text" id="spark_bc_titulo" class="spark-form-control" placeholder="Ej: Corte programado de recepción / Reunión de coordinación..." maxlength="180" />',
            '</div>',
            '<div class="spark-form-group" style="margin-bottom:0 !important;">',
            '  <label class="spark-form-label">Mensaje Detallado:</label>',
            '  <textarea id="spark_bc_mensaje" class="spark-form-control" rows="4" placeholder="Escriba aquí el contenido del comunicado que aparecerá en el centro de la pantalla de los funcionarios..."></textarea>',
            '</div>'
        ].join('\n');

        footEl.innerHTML = [
            '<button type="button" class="spark-pill" style="padding:8px 14px !important; flex:0 !important;" onclick="window.closeSparkComposerModal();">Cancelar</button>',
            '<button type="button" class="spark-btn-ack" onclick="window.submitSparkBroadcast();">📢 EMITIR COMUNICADO AHORA</button>'
        ].join('\n');

        overlay.style.display = 'flex';
    }

    window.closeSparkComposerModal = function() {
        var overlay = document.getElementById('sigapo_composer_overlay');
        if (overlay) overlay.style.display = 'none';
    };

    window.submitSparkBroadcast = function() {
        var alcTipo = document.getElementById('spark_bc_alcance_tipo').value;
        var alcVal  = document.getElementById('spark_bc_alcance_valor').value;
        var prio    = document.getElementById('spark_bc_prioridad').value;
        var vig     = document.getElementById('spark_bc_vigencia').value;
        var titulo  = (document.getElementById('spark_bc_titulo').value || '').replace(/^\s+|\s+$/g, '');
        var mensaje = (document.getElementById('spark_bc_mensaje').value || '').replace(/^\s+|\s+$/g, '');

        if (!titulo || !mensaje) {
            alert('Por favor complete el título y el mensaje del comunicado.');
            return;
        }
        if (alcTipo === 'dependencia' && !alcVal) {
            alert('Por favor seleccione la Dependencia / Unidad destinataria.');
            return;
        }

        sparkRequest('POST', {
            action: 'send_broadcast',
            titulo: titulo,
            mensaje: mensaje,
            prioridad: prio,
            alcance_tipo: alcTipo,
            alcance_valor: alcVal,
            horas_vigencia: vig
        }, function(err, data) {
            if (err || !data || data.status !== 'ok') {
                alert('Error al emitir el comunicado: ' + (data && data.message ? data.message : 'Verifique su conexión'));
                return;
            }
            window.closeSparkComposerModal();
            window.switchSparkTab('broadcasts');
        });
    };

    window.viewBroadcastReaders = function(comId, comTitle) {
        buildSparkDOM();
        var overlay = document.getElementById('sigapo_composer_overlay');
        var titleEl = document.getElementById('sigapo_composer_modal_title');
        var bodyEl  = document.getElementById('sigapo_composer_modal_body');
        var footEl  = document.getElementById('sigapo_composer_modal_footer');
        if (!overlay || !bodyEl || !footEl) return;

        titleEl.innerHTML = '👁️ ACUSES DE LECTURA: ' + escapeHtml(comTitle);
        bodyEl.innerHTML = '<div style="padding:20px; text-align:center;">Consultando confirmaciones de lectura...</div>';
        footEl.innerHTML = '<button type="button" class="spark-send-btn" onclick="window.closeSparkComposerModal();">Cerrar</button>';
        overlay.style.display = 'flex';

        sparkRequest('GET', { action: 'broadcast_readers', comunicado_id: comId }, function(err, data) {
            if (err || !data || data.status !== 'ok') {
                bodyEl.innerHTML = '<div style="padding:16px; color:#ef4444;">No se pudo cargar el listado.</div>';
                return;
            }
            var readers = data.readers || [];
            if (readers.length === 0) {
                bodyEl.innerHTML = '<div style="padding:20px; text-align:center; opacity:0.75;">Aún ningún funcionario ha confirmado lectura de este comunicado.</div>';
                return;
            }
            var rows = ['<div style="max-height:320px; overflow-y:auto;">'];
            for (var i = 0; i < readers.length; i++) {
                var r = readers[i];
                rows.push('<div class="spark-user-item" style="cursor:default;">');
                rows.push('  <div class="spark-avatar-wrap"><img class="spark-avatar-img" src="' + escapeHtml(r.avatar) + '" onerror="this.src=\'perfiles/fotos/default_avatar013.jpg\'" alt=""/></div>');
                rows.push('  <div class="spark-user-meta">');
                rows.push('    <div class="spark-user-name">' + escapeHtml(r.nombre || r.cuenta) + '</div>');
                rows.push('    <div class="spark-user-sub">' + escapeHtml(r.dep || r.cuenta) + '</div>');
                rows.push('  </div>');
                rows.push('  <div style="font-size:10px; color:#10b981; font-weight:700;">✓ ' + escapeHtml(r.fecha) + '</div>');
                rows.push('</div>');
            }
            rows.push('</div>');
            bodyEl.innerHTML = rows.join('\n');
        });
    };

    // =========================================================================
    // MODAL EMERGENTE AUTOMÁTICO DE COMUNICADO ENTRANTE (BROADCAST POPUP)
    // =========================================================================
    function showIncomingBroadcastModal(bc) {
        if (!bc || !bc.id || state.shownBroadcastId === bc.id) return;
        buildSparkDOM();
        state.shownBroadcastId = bc.id;

        var overlay = document.getElementById('sigapo_broadcast_overlay');
        var header  = document.getElementById('sigapo_broadcast_header');
        var icon    = document.getElementById('sigapo_broadcast_icon');
        var badge   = document.getElementById('sigapo_broadcast_badge_text');
        var dateEl  = document.getElementById('sigapo_broadcast_date');
        var titleEl = document.getElementById('sigapo_broadcast_title');
        var msgEl   = document.getElementById('sigapo_broadcast_msg');
        var authEl  = document.getElementById('sigapo_broadcast_author');
        var depEl   = document.getElementById('sigapo_broadcast_dep');

        if (!overlay) return;

        header.className = 'spark-modal-header' + (bc.prioridad === 'urgente' ? ' urgente' : '');
        if (bc.prioridad === 'urgente') {
            icon.textContent = '🚨';
            badge.textContent = 'COMUNICADO URGENTE DE CUMPLIMIENTO INMEDIATO';
        } else if (bc.prioridad === 'importante') {
            icon.textContent = '⚠️';
            badge.textContent = 'COMUNICADO INSTITUCIONAL IMPORTANTE';
        } else {
            icon.textContent = '📢';
            badge.textContent = 'COMUNICADO INTERNO SIGAPO';
        }

        dateEl.textContent  = bc.fecha || '';
        titleEl.textContent = bc.titulo || '';
        msgEl.textContent   = bc.mensaje || '';
        authEl.textContent  = (bc.autor_nombre || bc.autor_cuenta) + ' (' + bc.autor_cuenta + ')';
        depEl.textContent   = bc.autor_dep || 'G.A.D.OR.';

        overlay.style.display = 'flex';
        playSparkSound('broadcast');
    }

    window.acknowledgeCurrentBroadcast = function() {
        var comId = state.shownBroadcastId;
        var overlay = document.getElementById('sigapo_broadcast_overlay');
        if (overlay) overlay.style.display = 'none';
        if (!comId) return;

        sparkRequest('POST', { action: 'ack_broadcast', comunicado_id: comId }, function() {
            if (state.activeTab === 'broadcasts' && state.panelOpen) {
                loadSparkBroadcasts();
            }
        });
    };

    // =========================================================================
    // SONDEO PERIÓDICO EN TIEMPO REAL (HEARTBEAT CADA 7 SEGUNDOS)
    // =========================================================================
    function updateGlobalBadges() {
        var onlineEl = document.getElementById('mostrar_usuarios_online');
        if (onlineEl) {
            onlineEl.innerHTML = '<span style="color:#10b981; margin-right:4px; font-size:10px;">●</span> ' + state.onlineCount + ' en línea';
        }

        var pillEl = document.getElementById('spark_panel_online_pill');
        if (pillEl) {
            pillEl.textContent = state.onlineCount + ' en línea';
        }

        var fabOn = document.getElementById('spark_fab_online');
        if (fabOn) {
            fabOn.textContent = '(' + state.onlineCount + ')';
        }

        var fabUn = document.getElementById('spark_fab_unread');
        if (fabUn) {
            if (state.unreadTotal > 0) {
                fabUn.style.display = 'inline-block';
                fabUn.textContent = state.unreadTotal > 99 ? '99+' : state.unreadTotal;
            } else {
                fabUn.style.display = 'none';
            }
        }

        var hdrBadge = document.getElementById('spark_header_badge');
        if (hdrBadge) {
            if (state.unreadTotal > 0) {
                hdrBadge.style.display = 'flex';
                hdrBadge.textContent = state.unreadTotal > 99 ? '99+' : state.unreadTotal;
            } else {
                hdrBadge.style.display = 'none';
            }
        }
    }

    function runSparkPoll() {
        var params = {
            action: 'poll',
            last_msg_id: state.lastMsgId
        };
        if (state.activePeer && state.activePeer.cuenta) {
            params.chat_with = state.activePeer.cuenta;
            params.last_chat_id = state.lastChatId;
        }

        sparkRequest('GET', params, function(err, data) {
            if (!err && data && data.status === 'ok') {
                state.onlineCount = parseInt(data.online_count, 10) || 1;
                state.unreadTotal = parseInt(data.unread_total, 10) || 0;
                state.unreadByUser = data.unread_by_user || {};

                if (data.max_msg_id && data.max_msg_id > state.lastMsgId) {
                    state.lastMsgId = data.max_msg_id;
                }

                updateGlobalBadges();

                // Si hay mensajes nuevos de la conversación activa, agregarlos en vivo
                if (state.activePeer && data.active_chat_messages && data.active_chat_messages.length > 0) {
                    renderChatMessages(data.active_chat_messages, true);
                }
                if (state.activePeer && typeof data.peer_online !== 'undefined') {
                    state.activePeer.online = data.peer_online ? 1 : 0;
                    updateChatboxHeader(state.activePeer);
                }

                // Procesar notificaciones de mensajes entrantes nuevos o zumbidos
                if (data.new_incoming && data.new_incoming.length > 0) {
                    var lastInc = data.new_incoming[data.new_incoming.length - 1];
                    var isBuzz = false;
                    for (var i = 0; i < data.new_incoming.length; i++) {
                        if (data.new_incoming[i].tipo === 'zumbido') isBuzz = true;
                    }

                    playSparkSound(isBuzz ? 'zumbido' : 'msg');

                    // Si no hay ventana de chat abierta o es un zumbido, abrir automáticamente la conversación con el remitente
                    if (!state.activePeer || isBuzz) {
                        window.openSparkChatWith(lastInc.from);
                    }

                    if (isBuzz) {
                        setTimeout(function() {
                            var chatbox = document.getElementById('sigapo_spark_chatbox');
                            if (chatbox) {
                                chatbox.className = 'spark-chat-window spark-buzzing';
                                setTimeout(function() {
                                    chatbox.className = 'spark-chat-window';
                                }, 650);
                            }
                        }, 150);
                    }

                    if (state.panelOpen && state.activeTab === 'roster') {
                        renderRosterList();
                    }
                }

                // Mostrar comunicado masivo (Broadcast) si hay uno pendiente
                if (data.pending_broadcast && data.pending_broadcast.id) {
                    showIncomingBroadcastModal(data.pending_broadcast);
                }
            }
        });

        state.pollTimer = setTimeout(runSparkPoll, 7000);
    }

    function initSparkModule() {
        buildSparkDOM();
        runSparkPoll();
    }

    if (document.readyState === 'complete' || document.readyState === 'interactive') {
        setTimeout(initSparkModule, 200);
    } else {
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(initSparkModule, 200);
        });
    }
})();

