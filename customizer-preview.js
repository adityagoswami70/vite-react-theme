/**
 * Vite React Theme v3 — Customizer Live Preview
 */
(function ($) {
    'use strict';
    var api = wp.customize;

    function setCSSVar(prop, val) { document.documentElement.style.setProperty(prop, val); }
    function hexToRgb(hex) {
        return parseInt(hex.slice(1, 3), 16) + ',' + parseInt(hex.slice(3, 5), 16) + ',' + parseInt(hex.slice(5, 7), 16);
    }

    /**
     * Bind all settings to the live update event.
     * We use a helper function to ensure we don't duplicate listeners.
     */
    function bindSetting(setting) {
        // Initial log
        console.log('[VRT Live] Potential setting discovered:', setting.id);

        setting.bind(function (newVal) {
            console.log('[VRT Live] Dispatching update:', setting.id, newVal);
            window.dispatchEvent(new CustomEvent('vrt_live_update', {
                detail: { id: setting.id, value: newVal }
            }));
        });
    }

    // Wrap in wp.customize.ready to ensure all settings are fully initialized by WP
    api.ready(function() {
        console.log('[VRT Live] WordPress Customize Ready. Binding settings...');
        
        // Bind to all current settings
        api.each(bindSetting);

        // Bind to any settings added after this script runs
        api.bind('add', bindSetting);

        // Handle Custom Logo specifically to send the URL instead of just the ID
        api('custom_logo', function (v) {
            v.bind(function (id) {
                var url = '';
                if (id) {
                    var attachment = api.instance('custom_logo').attachment;
                    if (attachment) {
                        url = attachment.url;
                    } else {
                        // Fallback: try to get it from the control's params if available
                        var control = api.control('custom_logo');
                        if (control && control.params && control.params.attachment) {
                             url = control.params.attachment.url;
                        }
                    }
                }
                console.log('[VRT Live] Dispatching logo URL:', url);
                window.dispatchEvent(new CustomEvent('vrt_live_update', {
                    detail: { id: 'custom_logo', value: url }
                }));
            });
        });
    });

    // Special handling for legacy structure update (already exists, but we'll unify)
    api('vrt_theme_structure', function (v) {
        v.bind(function (newval) {
            if (newval) {
                try {
                    var parsed = JSON.parse(newval);
                    window.dispatchEvent(new CustomEvent('vrt_structure_update', { detail: parsed }));
                } catch (e) { }
            }
        });
    });

    // We can keep specific real-time CSS variable updates for colors/fonts 
    // to ensure there's NO jank while React re-renders.
    api('vrt_color_primary', function (v) {
        v.bind(function (c) {
            setCSSVar('--color-primary', c);
            var rgb = hexToRgb(c);
            setCSSVar('--color-primary-glow', 'rgba(' + rgb + ', 0.15)');
        });
    });
    api('vrt_font_size', function (v) { v.bind(function (s) { document.documentElement.style.fontSize = s + 'px'; }); });


})(jQuery);
