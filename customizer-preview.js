/**
 * Vite React Theme v3 — Customizer Live Preview
 */
(function($) {
    'use strict';
    var api = wp.customize;

    function setCSSVar(prop, val) { document.documentElement.style.setProperty(prop, val); }
    function hexToRgb(hex) {
        return parseInt(hex.slice(1,3),16) + ',' + parseInt(hex.slice(3,5),16) + ',' + parseInt(hex.slice(5,7),16);
    }

    // Colors
    api('vrt_color_primary', function(v) { v.bind(function(c) {
        setCSSVar('--color-primary', c);
        var rgb = hexToRgb(c);
        setCSSVar('--color-primary-glow', 'rgba(' + rgb + ', 0.15)');
        setCSSVar('--color-primary-light', c + '10');
    }); });
    api('vrt_color_primary_hover', function(v) { v.bind(function(c) { setCSSVar('--color-primary-hover', c); }); });
    api('vrt_color_bg', function(v) { v.bind(function(c) { setCSSVar('--color-bg', c); document.body.style.background = c; }); });
    api('vrt_color_bg_alt', function(v) { v.bind(function(c) { setCSSVar('--color-bg-alt', c); }); });
    api('vrt_color_surface', function(v) { v.bind(function(c) { setCSSVar('--color-surface', c); }); });
    api('vrt_color_text', function(v) { v.bind(function(c) { setCSSVar('--color-text', c); }); });
    api('vrt_color_text_secondary', function(v) { v.bind(function(c) { setCSSVar('--color-text-secondary', c); }); });
    api('vrt_color_border', function(v) { v.bind(function(c) { setCSSVar('--color-border', c); }); });

    // Font size
    api('vrt_font_size', function(v) { v.bind(function(s) { document.documentElement.style.fontSize = s + 'px'; }); });

    // Hero
    api('vrt_hero_badge', function(v) { v.bind(function(t) { $('.hero-badge').text(t); }); });
    api('vrt_hero_title', function(v) { v.bind(function(t) { $('.hero-title').html('<span class="hero-title-gradient">' + t + '</span>'); }); });
    api('vrt_hero_subtitle', function(v) { v.bind(function(t) { $('.hero-subtitle').text(t); }); });
    api('vrt_hero_btn1_text', function(v) { v.bind(function(t) { $('#hero-btn-primary').text(t); }); });
    api('vrt_hero_btn1_url', function(v) { v.bind(function(u) { $('#hero-btn-primary').attr('href', u); }); });
    api('vrt_hero_btn2_text', function(v) { v.bind(function(t) { $('#hero-btn-secondary').text(t); }); });
    api('vrt_hero_btn2_url', function(v) { v.bind(function(u) { $('#hero-btn-secondary').attr('href', u); }); });

    // Features
    api('vrt_features_label', function(v) { v.bind(function(t) { $('#features .section-label').text(t); }); });
    api('vrt_features_title', function(v) { v.bind(function(t) { $('#features .section-title').text(t); }); });
    api('vrt_features_subtitle', function(v) { v.bind(function(t) { $('#features .section-subtitle').text(t); }); });

    for (var i = 1; i <= 12; i++) {
        (function(idx) {
            api('vrt_feature_' + idx + '_icon', function(v) { v.bind(function(t) { $('.feature-card[data-card="' + idx + '"] .feature-icon').text(t); }); });
            api('vrt_feature_' + idx + '_title', function(v) { v.bind(function(t) { $('.feature-card[data-card="' + idx + '"] h3').text(t); }); });
            api('vrt_feature_' + idx + '_desc', function(v) { v.bind(function(t) { $('.feature-card[data-card="' + idx + '"] p').text(t); }); });
        })(i);
    }

    // CTA
    api('vrt_cta_title', function(v) { v.bind(function(t) { $('#cta .section-title').text(t); }); });
    api('vrt_cta_subtitle', function(v) { v.bind(function(t) { $('#cta .section-subtitle').text(t); }); });
    api('vrt_cta_btn_text', function(v) { v.bind(function(t) { $('#cta .btn-primary').text(t); }); });
    api('vrt_cta_btn_url', function(v) { v.bind(function(u) { $('#cta .btn-primary').attr('href', u); }); });

    // Blog
    api('vrt_posts_label', function(v) { v.bind(function(t) { $('#latest-posts .section-label').text(t); }); });
    api('vrt_posts_title', function(v) { v.bind(function(t) { $('#latest-posts .section-title').text(t); }); });

    // Footer
    api('vrt_footer_col1_title', function(v) { v.bind(function(t) { $('.footer-col[data-col="1"] h4').text(t); }); });
    api('vrt_footer_col2_title', function(v) { v.bind(function(t) { $('.footer-col[data-col="2"] h4').text(t); }); });
    api('vrt_footer_col3_title', function(v) { v.bind(function(t) { $('.footer-col[data-col="3"] h4').text(t); }); });
    api('vrt_footer_copyright', function(v) { v.bind(function(t) { if (t) $('.footer-copyright').text(t); }); });

})(jQuery);
