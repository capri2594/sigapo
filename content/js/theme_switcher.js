/**
 * SIGAPO - Sistema de Correspondencia Oficial
 * Gobierno Autónomo Departamental de Oruro (GADOR)
 * 1. Módulo de Gestión de Tema: Modo Claro / Modo Oscuro (Opción 1: Guindo Imperial)
 * 2. Motor Global de Centrado Exacto Multi-Monitor y Compatible con Brave Browser
 *    (Punto Medio de Ventana = Punto Medio de Pantalla Activa)
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
    // MOTOR GLOBAL DE CENTRADO EXACTO DE VENTANAS EMERGENTES (BRAVE & MULTI-MONITOR)
    // Punto medio de la ventana (w/2, h/2) = Punto medio del monitor activo
    // =========================================================================
    function getActiveScreenMetrics(refWin) {
        var w = refWin || window;
        try {
            if (w.top && w.top.outerWidth) {
                w = w.top;
            }
        } catch (e) {}

        var s = w.screen || window.screen || {};
        var availW = s.availWidth || s.width || 1920;
        var availH = s.availHeight || s.height || 1040;

        var winX = (typeof w.screenLeft === 'number') ? w.screenLeft : ((typeof w.screenX === 'number') ? w.screenX : 0);
        var winY = (typeof w.screenTop === 'number') ? w.screenTop : ((typeof w.screenY === 'number') ? w.screenY : 0);
        var winW = w.outerWidth || w.innerWidth || availW;
        var winH = w.outerHeight || w.innerHeight || availH;

        var monX = 0;
        var monY = 0;

        if (typeof s.availLeft === 'number' && s.availLeft !== 0) {
            monX = s.availLeft;
        } else {
            var winMidX = winX + (winW / 2);
            if (winMidX >= availW || winMidX < 0) {
                monX = Math.floor(winMidX / availW) * availW;
            }
        }

        if (typeof s.availTop === 'number' && s.availTop !== 0) {
            monY = s.availTop;
        } else {
            var winMidY = winY + (winH / 2);
            if (winMidY >= availH || winMidY < 0) {
                monY = Math.floor(winMidY / availH) * availH;
            }
        }

        return {
            monX: monX,
            monY: monY,
            availW: availW,
            availH: availH,
            centerX: monX + (availW / 2),
            centerY: monY + (availH / 2)
        };
    }

    window.getSigapoCenteredCoords = function(w, h, refWin) {
        var width = parseInt(w, 10) || 850;
        var height = parseInt(h, 10) || 550;
        var m = getActiveScreenMetrics(refWin || window);

        // Compensación por bordes y barra de título/direcciones del navegador (~16px ancho, ~68px alto)
        var totalW = width + 16;
        var totalH = height + 68;

        var left = Math.max(m.monX, Math.round(m.centerX - (totalW / 2)));
        var top  = Math.max(m.monY, Math.round(m.centerY - (totalH / 2)));

        return {
            left: left,
            top: top,
            width: width,
            height: height
        };
    };

    function buildCenteredFeatures(features) {
        var featStr = (typeof features === 'string') ? features.trim() : '';
        if (!featStr) {
            return null;
        }

        var wMatch = featStr.match(/width\s*=\s*(\d+)/i);
        var hMatch = featStr.match(/height\s*=\s*(\d+)/i);
        var w = wMatch ? parseInt(wMatch[1], 10) : 850;
        var h = hMatch ? parseInt(hMatch[1], 10) : 550;

        var coords = window.getSigapoCenteredCoords(w, h, window);

        // Eliminar cualquier left/top/screenX/screenY previo
        var parts = featStr.split(',');
        var cleanParts = [];
        for (var i = 0; i < parts.length; i++) {
            var p = parts[i].trim();
            if (!p) continue;
            if (/^(left|top|screenX|screenY)\s*=/i.test(p)) continue;
            cleanParts.push(p);
        }
        if (!wMatch) cleanParts.push('width=' + coords.width);
        if (!hMatch) cleanParts.push('height=' + coords.height);
        cleanParts.push('left=' + coords.left);
        cleanParts.push('top=' + coords.top);
        cleanParts.push('screenX=' + coords.left);
        cleanParts.push('screenY=' + coords.top);

        return {
            features: cleanParts.join(','),
            left: coords.left,
            top: coords.top,
            width: coords.width,
            height: coords.height
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

    // Ajuste fino al terminar de cargar la ventana emergente (usando el monitor de window.opener)
    window.addEventListener('load', function() {
        try {
            if (window.opener && window === window.top) {
                var m = getActiveScreenMetrics(window.opener);
                var realW = window.outerWidth;
                var realH = window.outerHeight;

                // Solo centrar si tenemos dimensiones reales de ventana emergente (> 300px y menor que el monitor)
                if (realW > 300 && realH > 200 && realW < m.availW * 0.95) {
                    var curX = (typeof window.screenLeft === 'number') ? window.screenLeft : ((typeof window.screenX === 'number') ? window.screenX : 0);
                    var curY = (typeof window.screenTop === 'number') ? window.screenTop : ((typeof window.screenY === 'number') ? window.screenY : 0);
                    var idealLeft = Math.max(m.monX, Math.round(m.centerX - (realW / 2)));
                    var idealTop  = Math.max(m.monY, Math.round(m.centerY - (realH / 2)));

                    if (Math.abs(curX - idealLeft) > 35 || Math.abs(curY - idealTop) > 35) {
                        window.moveTo(idealLeft, idealTop);
                    }
                }
            }
        } catch (e) {}
    });
})();
