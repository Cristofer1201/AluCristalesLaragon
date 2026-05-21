/**
 * AluCristales - Dark Mode Manager
 * Handles dark mode toggle with localStorage persistence
 */

(function() {
    'use strict';

    const THEME_KEY = 'alu-theme';
    const DARK_MODE_CLASS = 'dark-mode';

    // Get DOM elements
    const toggleButton = document.getElementById('toggle');
    const body = document.body;

    /**
     * Initialize theme based on saved preference or system preference
     */
    function initTheme() {
        const savedTheme = localStorage.getItem(THEME_KEY);

        if (savedTheme === 'dark') {
            body.classList.add(DARK_MODE_CLASS);
        } else if (savedTheme === 'light') {
            body.classList.remove(DARK_MODE_CLASS);
        } else {
            // No saved preference, check system preference
            if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
                body.classList.add(DARK_MODE_CLASS);
                localStorage.setItem(THEME_KEY, 'dark');
            }
        }
    }

    /**
     * Toggle dark mode and save preference
     */
    function toggleDarkMode() {
        body.classList.toggle(DARK_MODE_CLASS);

        // Save preference to localStorage
        const isDarkMode = body.classList.contains(DARK_MODE_CLASS);
        localStorage.setItem(THEME_KEY, isDarkMode ? 'dark' : 'light');
    }

    /**
     * Listen for system theme changes
     */
    function listenForSystemThemeChanges() {
        if (window.matchMedia) {
            window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', function(e) {
                // Only auto-switch if user hasn't set a preference
                if (!localStorage.getItem(THEME_KEY)) {
                    if (e.matches) {
                        body.classList.add(DARK_MODE_CLASS);
                    } else {
                        body.classList.remove(DARK_MODE_CLASS);
                    }
                }
            });
        }
    }

    // Initialize on DOM ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

    function init() {
        initTheme();
        listenForSystemThemeChanges();

        // Add click event listener to toggle button
        if (toggleButton) {
            toggleButton.addEventListener('click', toggleDarkMode);
        }
    }

})();
