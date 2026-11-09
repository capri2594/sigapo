/**
 * SIGAPO - Sistema de Correspondencia Oficial
 * Gobierno Autónomo Departamental de Oruro (GADOR)
 * 1. Módulo de Gestión de Tema: Modo Claro / Modo Oscuro (Opción 1: Guindo Imperial)
 * 2. Motor Global de Centrado Exacto (Punto Medio de Ventana = Punto Medio de Pantalla)
 */
(function() {
    function getStoredTheme() {
        try {
            return localStorage.getItem('sigapo_theme') || 'light';
        } catch(e) {
            return 'light';
        }
    }

    function updateDOM(theme) {
        // 1. Update current document
        if (document.documentElement) {
            document.documentElement.setAttribute('data-theme', theme);
        }
        if (document.body) {
            document.body.setAttribute('data-theme', theme);
        }

        // 2. Also update top window document if inside a frame/panel
        try {
            if (window.top && window.top !== window && window.top.document) {
                if (window.top.document.documentElement) {
                    window.top.document.documentElement.setAttribute('data-theme', theme);
                }
                if (window.top.document.body) {
                    window.top.document.body.setAttribute('data-theme', theme);
                }
            }
        } catch(e) {}

        // 3. Update all toggle buttons in current and parent DOM
        function updateButtons(doc) {
            if (!doc) return;
            var btnText = doc.getElementById('header_theme_text');
            var btnIcon = doc.getElementById('header_theme_icon');
            if (btnText && btnIcon) {
                if (theme === 'dark') {
                    btnIcon.textContent = '☀️';
                    btnText.textContent = 'Modo Claro';
                    btnText.parentElement.setAttribute('title', 'Cambiar a Modo Claro (Blanco/Platino)');
                } else {
                    btnIcon.textContent = '🌙';
                    btnText.textContent = 'Modo Oscuro';
                    btnText.parentElement.setAttribute('title', 'Cambiar a Modo Oscuro Institucional');
                }
            }

            var floatIcon = doc.getElementById('login_theme_icon');
            var floatText = doc.getElementById('login_theme_text');
            if (floatIcon && floatText) {
                if (theme === 'dark') {
                    floatIcon.textContent = '☀️';
                    floatText.textContent = 'Modo Claro';
                } else {
                    floatIcon.textContent = '🌙';
                    floatText.textContent = 'Modo Oscuro';
                }
            }
        }

        updateButtons(document);
        try {
            if (window.top && window.top !== window && window.top.document) {
                updateButtons(window.top.document);
            }
        } catch(e) {}
    }

    // Apply immediately to prevent flash
    var currentTheme = getStoredTheme();
    updateDOM(currentTheme);

    document.addEventListener('DOMContentLoaded', function() {
        updateDOM(getStoredTheme());
    });

    window.toggleSigapoTheme = function() {
        var current = getStoredTheme();
        var next = (current === 'light') ? 'dark' : 'light';
        try {
            localStorage.setItem('sigapo_theme', next);
        } catch(e) {}
        updateDOM(next);
    };

    // Listen to changes across tabs/windows
    window.addEventListener('storage', function(e) {
        if (e.key === 'sigapo_theme' && e.newValue) {
            updateDOM(e.newValue);
        }
    });

    // =========================================================================
    // MOTOR GLOBAL DE CENTRADO EXACTO DE VENTANAS EMERGENTES
    // Punto medio de la ventana (w/2, h/2) = Punto medio de la pantalla (screenW/2, screenH/2)
    // =========================================================================
    function buildCenteredFeatures(features) {
        var featStr = (typeof features === 'string') ? features.trim() : '';
        if (!featStr) {
            return null;
        }

        // Extraer width y height solicitados (por defecto 850x550)
        var wMatch = featStr.match(/width\s*=\s*(\d+)/i);
        var hMatch = featStr.match(/height\s*=\s*(\d+)/i);
        var w = wMatch ? parseInt(wMatch[1], 10) : 850;
        var h = hMatch ? parseInt(hMatch[1], 10) : 550;

        // Dimensiones totales reales de la pantalla disponible
        var availW = (window.screen && (window.screen.availWidth || window.screen.width)) || 1366;
        var availH = (window.screen && (window.screen.availHeight || window.screen.height)) || 768;

        // Compensación por bordes y barra de título del navegador (~16px ancho, ~68px alto)
        var totalWindowW = w + 16;
        var totalWindowH = h + 68;

        // Coordenada (left, top) de la esquina superior izquierda para que el CENTRO
        // de la ventana coincida exactamente con el CENTRO de la pantalla:
        // centroPantallaX - (anchoVentana / 2), centroPantallaY - (altoVentana / 2)
        var left = Math.max(0, Math.round((availW / 2) - (totalWindowW / 2)));
        var top  = Math.max(0, Math.round((availH / 2) - (totalWindowH / 2)));

        // Eliminar cualquier left/top/screenX/screenY previo
        var parts = featStr.split(',');
        var cleanParts = [];
        for (var i = 0; i < parts.length; i++) {
            var p = parts[i].trim();
            if (!p) continue;
            if (/^(left|top|screenX|screenY)\s*=/i.test(p)) continue;
            cleanParts.push(p);
        }
        if (!wMatch) cleanParts.push('width=' + w);
        if (!hMatch) cleanParts.push('height=' + h);
        cleanParts.push('left=' + left);
        cleanParts.push('top=' + top);
        cleanParts.push('screenX=' + left);
        cleanParts.push('screenY=' + top);

        return {
            features: cleanParts.join(','),
            left: left,
            top: top,
            width: w,
            height: h
        };
    }

    var _nativeWindowOpen = window.open;
    if (_nativeWindowOpen && !_nativeWindowOpen.__sigapoCentered) {
        var centeredOpen = function(url, name, features) {
            if (typeof features === 'string' && features.trim() !== '') {
                var centered = buildCenteredFeatures(features);
                if (centered) {
                    var win = _nativeWindowOpen.call(window, url, name || '', centered.features);
                    if (win) {
                        try {
                            win.moveTo(centered.left, centered.top);
                            win.focus();
                        } catch (e) {}
                    }
                    return win;
                }
            }
            return _nativeWindowOpen.apply(window, arguments);
        };
        centeredOpen.__sigapoCentered = true;
        window.open = centeredOpen;
    }

    window.MM_openBrWindow = function(theURL, winName, features) {
        var feat = (typeof features === 'string' && features.trim() !== '')
            ? features
            : 'menubar=yes,scrollbars=yes,resizable=yes,width=850,height=550';
        return window.open(theURL, winName || '', feat);
    };

    // Ajuste fino al terminar de cargar la ventana emergente (cuando outerWidth y outerHeight ya son reales)
    window.addEventListener('load', function() {
        try {
            if (window.opener && window === window.top) {
                var availW = (window.screen && (window.screen.availWidth || window.screen.width)) || 1366;
                var availH = (window.screen && (window.screen.availHeight || window.screen.height)) || 768;
                var realW  = window.outerWidth;
                var realH  = window.outerHeight;

                // Solo centrar si tenemos dimensiones reales de ventana emergente (> 250px y menor que pantalla completa)
                if (realW > 250 && realH > 150 && realW < availW * 0.95) {
                    var curX = (window.screenLeft !== undefined) ? window.screenLeft : (window.screenX || 0);
                    var curY = (window.screenTop !== undefined) ? window.screenTop : (window.screenY || 0);
                    var idealLeft = Math.max(0, Math.round((availW / 2) - (realW / 2)));
                    var idealTop  = Math.max(0, Math.round((availH / 2) - (realH / 2)));

                    // Si está desviada más de 40px del centro exacto, corregirla al centro
                    if (Math.abs(curX - idealLeft) > 40 || Math.abs(curY - idealTop) > 40) {
                        window.moveTo(idealLeft, idealTop);
                    }
                }
            }
        } catch (e) {}
    });
})();
