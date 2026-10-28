/**
 * SIGAPO - Sistema de Correspondencia Oficial
 * Gobierno Autónomo Departamental de Oruro (GADOR)
 * Módulo de Gestión de Tema: Modo Claro Institucional (Carmesí + Platino) / Modo Oscuro Zafiro
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
                    btnText.parentElement.setAttribute('title', 'Cambiar a Modo Oscuro (Azul Zafiro)');
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
})();
