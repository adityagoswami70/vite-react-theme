/**
 * Customizer Preview Script
 * Listens to customizer setting changes and dispatches custom events
 * This enables live preview of all customizer changes in the frontend preview pane
 */

(() => {
  if (!window.wp || !window.wp.customize) {
    return; // Exit if not in customizer context
  }

  const api = window.wp.customize;

  /**
   * Dispatch a custom event to trigger React theme state updates
   */
  const sendPreviewUpdate = (settingId, value) => {
    const event = new CustomEvent('vrt_live_update', {
      detail: { id: settingId, value: value }
    });
    window.dispatchEvent(event);
  };

  /**
   * When a page's "Show in Navbar" is toggled ON, navigate the preview to that page.
   * This gives instant visual feedback in the customizer live preview.
   */
  const pageShowToUrl = {
    vrt_blog_show:         '/blog',
    vrt_about_show:        '/about',
    vrt_contact_show:      '/contact',
    vrt_services_show:     '/services',
    vrt_portfolio_show:    '/portfolio',
    vrt_pricing_show:      '/pricing',
    vrt_team_show:         '/team',
    vrt_faq_show:          '/faq',
    vrt_careers_show:      '/careers',
    vrt_testimonials_show: '/testimonials',
    vrt_features_show:     '/features',
    vrt_privacy_show:      '/privacy',
    vrt_terms_show:        '/terms',
  };

  /**
   * Setup listeners for all customizer settings
   */
  const settingsToListen = [
    // Core WordPress Settings
    'blogname',
    'blogdescription',
    'custom_logo',

    // Navbar Settings
    'vrt_navbar_show',
    'vrt_navbar_style',
    'vrt_navbar_show_search',
    'vrt_navbar_sticky',
    'vrt_navbar_logo_height',
    'vrt_navbar_brand_title',
    'vrt_navbar_preview_text',
    'vrt_theme_navbar_links',

    // Colors
    'vrt_color_primary',
    'vrt_color_primary_hover',
    'vrt_color_bg',
    'vrt_color_bg_alt',
    'vrt_color_surface',
    'vrt_color_text',
    'vrt_color_text_secondary',
    'vrt_color_border',

    // Typography
    'vrt_font_family',
    'vrt_font_size',

    // Hero Section
    'vrt_hero_show',
    'vrt_hero_bg_image',
    'vrt_hero_badge',
    'vrt_hero_title',
    'vrt_hero_subtitle',
    'vrt_hero_btn1_text',
    'vrt_hero_btn1_url',
    'vrt_hero_btn2_text',
    'vrt_hero_btn2_url',

    // Features Section (homepage)
    'vrt_features_show',
    'vrt_features_label',
    'vrt_features_title',
    'vrt_features_subtitle',
    'vrt_feature_count',

    // Testimonials (homepage)
    'vrt_testimonials_show',
    'vrt_testimonials_title',
    'vrt_testimonials_subtitle',

    // Stats
    'vrt_stats_show',

    // CTA
    'vrt_cta_show',

    // Posts/Blog
    'vrt_posts_show',

    // Page show toggles — also trigger navigation
    'vrt_blog_show',
    'vrt_about_show',
    'vrt_contact_show',
    'vrt_services_show',
    'vrt_portfolio_show',
    'vrt_pricing_show',
    'vrt_team_show',
    'vrt_faq_show',
    'vrt_careers_show',
    'vrt_testimonials_show',
    'vrt_features_show',
    'vrt_privacy_show',
    'vrt_terms_show',

    // Careers apply button
    'vrt_careers_apply_btn',

    // Site Structure
    'vrt_theme_structure',
  ];

  /**
   * Listen to each explicitly listed setting
   */
  settingsToListen.forEach(settingId => {
    if (api.has(settingId)) {
      api(settingId).bind((value) => {
        sendPreviewUpdate(settingId, value);

        // If a page "show" toggle was turned ON, navigate the preview to that page
        if (pageShowToUrl[settingId]) {
          const isTruthy = value === true || value === '1' || value === 'true' || value === 1;
          if (isTruthy) {
            // Wait for React to process the state update and re-render routes,
            // then navigate. Two attempts in case the first fires too early.
            const targetUrl = pageShowToUrl[settingId];
            setTimeout(() => {
              window.dispatchEvent(new CustomEvent('vrt_request_navigate', {
                detail: { url: targetUrl }
              }));
            }, 200);
            setTimeout(() => {
              window.dispatchEvent(new CustomEvent('vrt_request_navigate', {
                detail: { url: targetUrl }
              }));
            }, 600);
          }
        }
      });
    }
  });

  /**
   * Listen to all remaining vrt_ prefixed settings (dynamic card/field settings)
   */
  api.each((setting) => {
    const id = setting.id;

    // Already handled by explicit list above — skip
    if (settingsToListen.includes(id)) return;

    // Listen to all dynamic vrt_ settings (feature items, testimonial items, page cards, etc.)
    if (id.startsWith('vrt_')) {
      setting.bind((value) => {
        sendPreviewUpdate(id, value);
      });
    }
  });
})();
