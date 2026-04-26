<?php
/**
 * Vite React Theme — Customizer
 * Full React SPA theme customization — Colors, Typography, Hero, Features,
 * Testimonials, Stats, CTA, Blog, Social, Footer, Navbar, Layout, Animations, 404
 *
 * @package ViteReactTheme
 */

if ( class_exists( 'WP_Customize_Control' ) ) {
    class VRT_Number_Control extends WP_Customize_Control {
        public $type = 'vrt-number';
        public $min = 1;
        public $max = 12;
        public $step = 1;
        public function render_content() { ?>
            <label>
                <?php if ( $this->label ) : ?><span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span><?php endif; ?>
                <?php if ( $this->description ) : ?><span class="description customize-control-description"><?php echo esc_html( $this->description ); ?></span><?php endif; ?>
                <input type="number" min="<?php echo esc_attr( $this->min ); ?>" max="<?php echo esc_attr( $this->max ); ?>" step="<?php echo esc_attr( $this->step ); ?>" <?php $this->link(); ?> value="<?php echo esc_attr( $this->value() ); ?>" style="width:80px;" />
            </label>
        <?php }
    }

    class VRT_React_Structure_Control extends WP_Customize_Control {
        public $type = 'vrt-react-structure';
        public function render_content() { ?>
            <label>
                <?php if ( $this->label ) : ?><span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span><?php endif; ?>
                <?php if ( $this->description ) : ?><span class="description customize-control-description"><?php echo esc_html( $this->description ); ?></span><?php endif; ?>
            </label>
            <div id="vrt-customizer-structure-root" data-value="<?php echo esc_attr( $this->value() ); ?>"></div>
            <input type="hidden" id="vrt_structure_input" <?php $this->link(); ?> value="<?php echo esc_attr( $this->value() ); ?>" />
        <?php }
    }

    class VRT_React_Navbar_Control extends WP_Customize_Control {
        public $type = 'vrt-react-navbar';
        public function render_content() { ?>
            <label>
                <?php if ( $this->label ) : ?><span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span><?php endif; ?>
                <?php if ( $this->description ) : ?><span class="description customize-control-description"><?php echo esc_html( $this->description ); ?></span><?php endif; ?>
            </label>
            <div id="vrt-customizer-navbar-root" data-value="<?php echo esc_attr( $this->value() ); ?>"></div>
            <input type="hidden" id="vrt_navbar_links_input" <?php $this->link(); ?> value="<?php echo esc_attr( $this->value() ); ?>" />
        <?php }
    }
}


function vrt_customize_register( $wp_customize ) {

    // ── Panel ────────────────────────────────────────────────────────────────
    $wp_customize->add_panel( 'vrt_panel', array(
        'title' => __( 'Theme Options', 'vite-react-theme' ),
        'description' => __( 'Customize every section of your React SPA theme.', 'vite-react-theme' ),
        'priority' => 30,
    ) );

    // ══════════════════════════════════════════════════════════════════════════
    // SECTION: Site Structure
    // ══════════════════════════════════════════════════════════════════════════
    $wp_customize->add_section( 'vrt_structure', array(
        'title' => __( 'Site Structure', 'vite-react-theme' ), 'panel' => 'vrt_panel', 'priority' => 5,
    ) );

    $wp_customize->add_setting( 'vrt_theme_structure', array(
        'default' => '', 'sanitize_callback' => 'vrt_sanitize_json', 'transport' => 'postMessage',
    ) );
    $wp_customize->add_control( new VRT_React_Structure_Control( $wp_customize, 'vrt_theme_structure', array(
        'label' => __( 'Homepage Layout', 'vite-react-theme' ), 
        'description' => __( 'Move sections up/down to structure your homepage.', 'vite-react-theme' ),
        'section' => 'vrt_structure',
    ) ) );

    // ══════════════════════════════════════════════════════════════════════════
    // SECTION: Brand Colors
    // ══════════════════════════════════════════════════════════════════════════
    $wp_customize->add_section( 'vrt_colors', array(
        'title' => __( 'Brand Colors', 'vite-react-theme' ), 'panel' => 'vrt_panel', 'priority' => 10,
    ) );

    $colors = array(
        'vrt_color_primary'        => array( 'Primary Color', '#6366f1' ),
        'vrt_color_primary_hover'  => array( 'Primary Hover', '#4f46e5' ),
        'vrt_color_bg'             => array( 'Background', '#0a0a0f' ),
        'vrt_color_bg_alt'         => array( 'Alt Background', '#111119' ),
        'vrt_color_surface'        => array( 'Surface / Cards', '#16161f' ),
        'vrt_color_text'           => array( 'Text Color', '#f0f0f5' ),
        'vrt_color_text_secondary' => array( 'Text Secondary', '#9ca3b0' ),
        'vrt_color_border'         => array( 'Border Color', '#2a2a3a' ),
    );

    foreach ( $colors as $id => $data ) {
        $wp_customize->add_setting( $id, array( 'default' => $data[1], 'sanitize_callback' => 'sanitize_hex_color', 'transport' => 'postMessage' ) );
        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $id, array( 'label' => $data[0], 'section' => 'vrt_colors' ) ) );
    }

    // ══════════════════════════════════════════════════════════════════════════
    // SECTION: Typography
    // ══════════════════════════════════════════════════════════════════════════
    $wp_customize->add_section( 'vrt_typography', array(
        'title' => __( 'Typography', 'vite-react-theme' ), 'panel' => 'vrt_panel', 'priority' => 15,
    ) );

    $wp_customize->add_setting( 'vrt_font_family', array(
        'default' => 'Inter', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'postMessage',
    ) );
    $wp_customize->add_control( 'vrt_font_family', array(
        'label' => __( 'Font Family', 'vite-react-theme' ), 'section' => 'vrt_typography',
        'type' => 'select', 'choices' => array(
            'Inter' => 'Inter', 'Roboto' => 'Roboto', 'Open Sans' => 'Open Sans',
            'Lato' => 'Lato', 'Poppins' => 'Poppins', 'Nunito' => 'Nunito',
            'Outfit' => 'Outfit', 'DM Sans' => 'DM Sans', 'Plus Jakarta Sans' => 'Plus Jakarta Sans',
            'system-ui' => 'System Default',
        ),
    ) );

    $wp_customize->add_setting( 'vrt_font_size', array(
        'default' => '16', 'sanitize_callback' => 'absint', 'transport' => 'postMessage',
    ) );
    $wp_customize->add_control( new VRT_Number_Control( $wp_customize, 'vrt_font_size', array(
        'label' => __( 'Base Font Size (px)', 'vite-react-theme' ), 'section' => 'vrt_typography',
        'min' => 14, 'max' => 20, 'step' => 1,
    ) ) );

    // ══════════════════════════════════════════════════════════════════════════
    // SECTION: Navbar
    // ══════════════════════════════════════════════════════════════════════════
    $wp_customize->add_section( 'vrt_navbar', array(
        'title' => __( 'Navbar', 'vite-react-theme' ), 'panel' => 'vrt_panel', 'priority' => 18,
    ) );

    $wp_customize->add_setting( 'vrt_navbar_style', array( 'default' => 'glass', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'postMessage' ) );
    $wp_customize->add_control( 'vrt_navbar_style', array(
        'label' => __( 'Navbar Style', 'vite-react-theme' ), 'section' => 'vrt_navbar', 'type' => 'select',
        'choices' => array( 'solid' => 'Solid', 'transparent' => 'Transparent', 'glass' => 'Glassmorphism' ),
    ) );

    $wp_customize->add_setting( 'vrt_navbar_show', array( 'default' => true, 'sanitize_callback' => 'vrt_sanitize_checkbox', 'transport' => 'postMessage' ) );
    $wp_customize->add_control( 'vrt_navbar_show', array( 'label' => __( 'Show Navbar sitewide', 'vite-react-theme' ), 'section' => 'vrt_navbar', 'type' => 'checkbox' ) );

    $wp_customize->add_setting( 'vrt_navbar_logo_height', array( 'default' => 32, 'sanitize_callback' => 'absint', 'transport' => 'postMessage' ) );
    $wp_customize->add_control( new VRT_Number_Control( $wp_customize, 'vrt_navbar_logo_height', array(
        'label' => __( 'Logo Height (px)', 'vite-react-theme' ), 'section' => 'vrt_navbar', 'min' => 20, 'max' => 100,
    ) ) );

    $wp_customize->add_setting( 'vrt_navbar_sticky', array( 'default' => true, 'sanitize_callback' => 'vrt_sanitize_checkbox', 'transport' => 'postMessage' ) );
    $wp_customize->add_control( 'vrt_navbar_sticky', array( 'label' => __( 'Sticky Navbar', 'vite-react-theme' ), 'section' => 'vrt_navbar', 'type' => 'checkbox' ) );

    $wp_customize->add_setting( 'vrt_navbar_brand_title', array( 'default' => '', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'postMessage' ) );
    $wp_customize->add_control( 'vrt_navbar_brand_title', array( 'label' => __( 'Navbar Brand / Logo Title', 'vite-react-theme' ), 'description' => __( 'The name shown next to the logo. Leave empty to use the WordPress site title.', 'vite-react-theme' ), 'section' => 'vrt_navbar', 'type' => 'text' ) );

    $wp_customize->add_setting( 'vrt_navbar_preview_text', array( 'default' => '', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'postMessage' ) );
    $wp_customize->add_control( 'vrt_navbar_preview_text', array( 'label' => __( 'Navbar Preview / Tagline Text', 'vite-react-theme' ), 'description' => __( 'Optional tagline shown under the brand name on hover. Leave empty to hide.', 'vite-react-theme' ), 'section' => 'vrt_navbar', 'type' => 'text' ) );

    $wp_customize->add_setting( 'vrt_theme_navbar_links', array(
        'default' => '', 'sanitize_callback' => 'vrt_sanitize_json', 'transport' => 'postMessage',
    ) );
    $wp_customize->add_control( new VRT_React_Navbar_Control( $wp_customize, 'vrt_theme_navbar_links', array(
        'label' => __( 'Manage Navbar Links', 'vite-react-theme' ), 
        'description' => __( 'Add, remove, and reorder pages in your navigation bar.', 'vite-react-theme' ),
        'section' => 'vrt_navbar',
    ) ) );


    // ══════════════════════════════════════════════════════════════════════════
    // SECTION: Hero
    // ══════════════════════════════════════════════════════════════════════════
    $wp_customize->add_section( 'vrt_hero', array(
        'title' => __( 'Hero Section', 'vite-react-theme' ), 'panel' => 'vrt_panel', 'priority' => 20,
    ) );

    $wp_customize->add_setting( 'vrt_hero_show', array( 'default' => true, 'sanitize_callback' => 'vrt_sanitize_checkbox', 'transport' => 'postMessage' ) );
    $wp_customize->add_control( 'vrt_hero_show', array( 'label' => __( 'Show Hero Section', 'vite-react-theme' ), 'section' => 'vrt_hero', 'type' => 'checkbox' ) );

    $wp_customize->add_setting( 'vrt_hero_bg_image', array( 'default' => '', 'sanitize_callback' => 'esc_url_raw', 'transport' => 'postMessage' ) );
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'vrt_hero_bg_image', array(
        'label' => __( 'Hero Background Image', 'vite-react-theme' ), 'section' => 'vrt_hero',
    ) ) );

    foreach ( array(
        array( 'vrt_hero_badge', 'Badge Text', '✨ Welcome to the future', 'text' ),
        array( 'vrt_hero_title', 'Hero Title', 'Build Something Amazing', 'text' ),
        array( 'vrt_hero_subtitle', 'Hero Subtitle', 'A modern WordPress theme with clean design, powerful customization, and stunning animations.', 'textarea' ),
        array( 'vrt_hero_btn1_text', 'Primary Button Text', 'Get Started', 'text' ),
        array( 'vrt_hero_btn1_url', 'Primary Button URL', '#features', 'url' ),
        array( 'vrt_hero_btn2_text', 'Secondary Button Text', 'Learn More', 'text' ),
        array( 'vrt_hero_btn2_url', 'Secondary Button URL', '#latest-posts', 'url' ),
    ) as $ctrl ) {
        $san = $ctrl[3] === 'url' ? 'esc_url_raw' : ( $ctrl[3] === 'textarea' ? 'sanitize_textarea_field' : 'sanitize_text_field' );
        $wp_customize->add_setting( $ctrl[0], array( 'default' => $ctrl[2], 'sanitize_callback' => $san, 'transport' => 'postMessage' ) );
        $wp_customize->add_control( $ctrl[0], array( 'label' => __( $ctrl[1], 'vite-react-theme' ), 'section' => 'vrt_hero', 'type' => $ctrl[3] === 'textarea' ? 'textarea' : 'text' ) );
    }

    // ══════════════════════════════════════════════════════════════════════════
    // SECTION: Features
    // ══════════════════════════════════════════════════════════════════════════
    $wp_customize->add_section( 'vrt_features', array(
        'title' => __( 'Features Section', 'vite-react-theme' ), 'panel' => 'vrt_panel', 'priority' => 25,
    ) );

    $wp_customize->add_setting( 'vrt_features_show', array( 'default' => true, 'sanitize_callback' => 'vrt_sanitize_checkbox', 'transport' => 'postMessage' ) );
    $wp_customize->add_control( 'vrt_features_show', array( 'label' => __( 'Show Features', 'vite-react-theme' ), 'section' => 'vrt_features', 'type' => 'checkbox' ) );

    foreach ( array(
        array( 'vrt_features_label', 'Section Label', 'Why Choose Us' ),
        array( 'vrt_features_title', 'Section Title', 'Powerful Features' ),
        array( 'vrt_features_subtitle', 'Subtitle', 'Everything you need to build modern, high-performance websites.' ),
    ) as $ctrl ) {
        $wp_customize->add_setting( $ctrl[0], array( 'default' => $ctrl[2], 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'postMessage' ) );
        $wp_customize->add_control( $ctrl[0], array( 'label' => __( $ctrl[1], 'vite-react-theme' ), 'section' => 'vrt_features', 'type' => 'text' ) );
    }

    $wp_customize->add_setting( 'vrt_feature_count', array( 'default' => 6, 'sanitize_callback' => 'absint', 'transport' => 'postMessage' ) );
    $wp_customize->add_control( new VRT_Number_Control( $wp_customize, 'vrt_feature_count', array(
        'label' => __( 'Number of Cards (1–12)', 'vite-react-theme' ), 'section' => 'vrt_features', 'min' => 1, 'max' => 12,
    ) ) );

    $feature_defaults = array(
        1 => array( '⚡', 'Lightning Fast', 'Vite-powered builds with instant hot module replacement.' ),
        2 => array( '🎨', 'Beautiful Design', 'Clean, professional aesthetics with refined typography.' ),
        3 => array( '📱', 'Fully Responsive', 'Looks perfect on every device.' ),
        4 => array( '🔒', 'Secure & Reliable', 'Built with WordPress best practices.' ),
        5 => array( '🚀', 'SEO Optimized', 'Semantic HTML and fast load times.' ),
        6 => array( '🎯', 'Customizable', 'Change everything from the Customizer.' ),
    );

    for ( $i = 1; $i <= 12; $i++ ) {
        $di = isset( $feature_defaults[$i] ) ? $feature_defaults[$i] : array( '✦', 'Feature ' . $i, 'Describe this feature.' );
        $wp_customize->add_setting( "vrt_feature_{$i}_icon", array( 'default' => $di[0], 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'postMessage' ) );
        $wp_customize->add_control( "vrt_feature_{$i}_icon", array( 'label' => sprintf( 'Card %d — Icon/Emoji', $i ), 'section' => 'vrt_features', 'type' => 'text' ) );
        $wp_customize->add_setting( "vrt_feature_{$i}_title", array( 'default' => $di[1], 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'postMessage' ) );
        $wp_customize->add_control( "vrt_feature_{$i}_title", array( 'label' => sprintf( 'Card %d — Title', $i ), 'section' => 'vrt_features', 'type' => 'text' ) );
        $wp_customize->add_setting( "vrt_feature_{$i}_desc", array( 'default' => $di[2], 'sanitize_callback' => 'sanitize_textarea_field', 'transport' => 'postMessage' ) );
        $wp_customize->add_control( "vrt_feature_{$i}_desc", array( 'label' => sprintf( 'Card %d — Description', $i ), 'section' => 'vrt_features', 'type' => 'textarea' ) );
    }

    // ══════════════════════════════════════════════════════════════════════════
    // SECTION: Testimonials
    // ══════════════════════════════════════════════════════════════════════════
    $wp_customize->add_section( 'vrt_testimonials', array(
        'title' => __( 'Testimonials Section', 'vite-react-theme' ), 'panel' => 'vrt_panel', 'priority' => 28,
    ) );

    $wp_customize->add_setting( 'vrt_testimonials_show', array( 'default' => true, 'sanitize_callback' => 'vrt_sanitize_checkbox', 'transport' => 'postMessage' ) );
    $wp_customize->add_control( 'vrt_testimonials_show', array( 'label' => __( 'Show Testimonials', 'vite-react-theme' ), 'section' => 'vrt_testimonials', 'type' => 'checkbox' ) );

    $wp_customize->add_setting( 'vrt_testimonials_title', array( 'default' => 'What People Say', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'postMessage' ) );
    $wp_customize->add_control( 'vrt_testimonials_title', array( 'label' => __( 'Section Title', 'vite-react-theme' ), 'section' => 'vrt_testimonials', 'type' => 'text' ) );

    $wp_customize->add_setting( 'vrt_testimonials_subtitle', array( 'default' => 'Hear from developers and designers who love our theme.', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'postMessage' ) );
    $wp_customize->add_control( 'vrt_testimonials_subtitle', array( 'label' => __( 'Subtitle', 'vite-react-theme' ), 'section' => 'vrt_testimonials', 'type' => 'text' ) );

    $testimonial_defaults = array(
        1 => array( 'Sarah Chen', 'Product Designer', 'This theme completely transformed our website.' ),
        2 => array( 'Marcus Rivera', 'Full Stack Developer', 'Finally a WordPress theme that feels like a modern React app.' ),
        3 => array( 'Emily Watson', 'Creative Director', 'Our clients are blown away by the design quality.' ),
        4 => array( "James O'Brien", 'Startup Founder', 'Best theme investment we ever made.' ),
    );

    for ( $i = 1; $i <= 6; $i++ ) {
        $d = isset( $testimonial_defaults[$i] ) ? $testimonial_defaults[$i] : array( '', '', '' );
        $wp_customize->add_setting( "vrt_testimonial_{$i}_name", array( 'default' => $d[0], 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'postMessage' ) );
        $wp_customize->add_control( "vrt_testimonial_{$i}_name", array( 'label' => sprintf( 'Testimonial %d — Name', $i ), 'section' => 'vrt_testimonials', 'type' => 'text' ) );
        $wp_customize->add_setting( "vrt_testimonial_{$i}_role", array( 'default' => $d[1], 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'postMessage' ) );
        $wp_customize->add_control( "vrt_testimonial_{$i}_role", array( 'label' => sprintf( 'Testimonial %d — Role', $i ), 'section' => 'vrt_testimonials', 'type' => 'text' ) );
        $wp_customize->add_setting( "vrt_testimonial_{$i}_quote", array( 'default' => $d[2], 'sanitize_callback' => 'sanitize_textarea_field', 'transport' => 'postMessage' ) );
        $wp_customize->add_control( "vrt_testimonial_{$i}_quote", array( 'label' => sprintf( 'Testimonial %d — Quote', $i ), 'section' => 'vrt_testimonials', 'type' => 'textarea' ) );
    }

    // ══════════════════════════════════════════════════════════════════════════
    // SECTION: Stats Counter
    // ══════════════════════════════════════════════════════════════════════════
    $wp_customize->add_section( 'vrt_stats', array(
        'title' => __( 'Stats Counter', 'vite-react-theme' ), 'panel' => 'vrt_panel', 'priority' => 30,
    ) );

    $wp_customize->add_setting( 'vrt_stats_show', array( 'default' => true, 'sanitize_callback' => 'vrt_sanitize_checkbox', 'transport' => 'postMessage' ) );
    $wp_customize->add_control( 'vrt_stats_show', array( 'label' => __( 'Show Stats Section', 'vite-react-theme' ), 'section' => 'vrt_stats', 'type' => 'checkbox' ) );

    $stat_defaults = array(
        1 => array( '🚀', '10K+', 'Active Users' ),
        2 => array( '⭐', '4.9', 'Average Rating' ),
        3 => array( '🌍', '50+', 'Countries' ),
        4 => array( '💬', '1M+', 'Posts Created' ),
    );

    for ( $i = 1; $i <= 4; $i++ ) {
        $d = $stat_defaults[$i];
        $wp_customize->add_setting( "vrt_stat_{$i}_icon", array( 'default' => $d[0], 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'postMessage' ) );
        $wp_customize->add_control( "vrt_stat_{$i}_icon", array( 'label' => sprintf( 'Stat %d — Icon/Emoji', $i ), 'section' => 'vrt_stats', 'type' => 'text' ) );
        $wp_customize->add_setting( "vrt_stat_{$i}_number", array( 'default' => $d[1], 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'postMessage' ) );
        $wp_customize->add_control( "vrt_stat_{$i}_number", array( 'label' => sprintf( 'Stat %d — Number', $i ), 'section' => 'vrt_stats', 'type' => 'text' ) );
        $wp_customize->add_setting( "vrt_stat_{$i}_label", array( 'default' => $d[2], 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'postMessage' ) );
        $wp_customize->add_control( "vrt_stat_{$i}_label", array( 'label' => sprintf( 'Stat %d — Label', $i ), 'section' => 'vrt_stats', 'type' => 'text' ) );
    }

    // ══════════════════════════════════════════════════════════════════════════
    // SECTION: CTA
    // ══════════════════════════════════════════════════════════════════════════
    $wp_customize->add_section( 'vrt_cta', array(
        'title' => __( 'Call to Action Section', 'vite-react-theme' ), 'panel' => 'vrt_panel', 'priority' => 35,
    ) );

    $wp_customize->add_setting( 'vrt_cta_show', array( 'default' => true, 'sanitize_callback' => 'vrt_sanitize_checkbox', 'transport' => 'postMessage' ) );
    $wp_customize->add_control( 'vrt_cta_show', array( 'label' => __( 'Show CTA Section', 'vite-react-theme' ), 'section' => 'vrt_cta', 'type' => 'checkbox' ) );

    foreach ( array(
        array( 'vrt_cta_title', 'CTA Title', 'Ready to get started?', 'text' ),
        array( 'vrt_cta_subtitle', 'CTA Subtitle', 'Join thousands of users building amazing websites with our theme.', 'textarea' ),
        array( 'vrt_cta_btn_text', 'Button Text', 'Get Started Free', 'text' ),
        array( 'vrt_cta_btn_url', 'Button URL', '#', 'url' ),
    ) as $ctrl ) {
        $san = $ctrl[3] === 'url' ? 'esc_url_raw' : ( $ctrl[3] === 'textarea' ? 'sanitize_textarea_field' : 'sanitize_text_field' );
        $wp_customize->add_setting( $ctrl[0], array( 'default' => $ctrl[2], 'sanitize_callback' => $san, 'transport' => 'postMessage' ) );
        $wp_customize->add_control( $ctrl[0], array( 'label' => __( $ctrl[1], 'vite-react-theme' ), 'section' => 'vrt_cta', 'type' => $ctrl[3] === 'textarea' ? 'textarea' : 'text' ) );
    }

    $wp_customize->add_setting( 'vrt_cta_bg_color', array( 'default' => '', 'sanitize_callback' => 'sanitize_hex_color', 'transport' => 'postMessage' ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'vrt_cta_bg_color', array(
        'label' => __( 'Section Background Color', 'vite-react-theme' ), 'section' => 'vrt_cta'
    ) ) );

    $wp_customize->add_setting( 'vrt_cta_text_color', array( 'default' => '', 'sanitize_callback' => 'sanitize_hex_color', 'transport' => 'postMessage' ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'vrt_cta_text_color', array(
        'label' => __( 'Title & Subtitle Color', 'vite-react-theme' ), 'section' => 'vrt_cta'
    ) ) );

    // ══════════════════════════════════════════════════════════════════════════
    // SECTION: Blog / Posts
    // ══════════════════════════════════════════════════════════════════════════
    $wp_customize->add_section( 'vrt_posts', array(
        'title' => __( 'Blog Section', 'vite-react-theme' ), 'panel' => 'vrt_panel', 'priority' => 40,
    ) );

    $wp_customize->add_setting( 'vrt_posts_show', array( 'default' => true, 'sanitize_callback' => 'vrt_sanitize_checkbox', 'transport' => 'postMessage' ) );
    $wp_customize->add_control( 'vrt_posts_show', array( 'label' => __( 'Show Blog Section', 'vite-react-theme' ), 'section' => 'vrt_posts', 'type' => 'checkbox' ) );

    $wp_customize->add_setting( 'vrt_posts_label', array( 'default' => 'Blog', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'postMessage' ) );
    $wp_customize->add_control( 'vrt_posts_label', array( 'label' => __( 'Section Label', 'vite-react-theme' ), 'section' => 'vrt_posts', 'type' => 'text' ) );

    $wp_customize->add_setting( 'vrt_posts_title', array( 'default' => 'Latest Posts', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'postMessage' ) );
    $wp_customize->add_control( 'vrt_posts_title', array( 'label' => __( 'Section Title', 'vite-react-theme' ), 'section' => 'vrt_posts', 'type' => 'text' ) );

    $wp_customize->add_setting( 'vrt_posts_layout', array( 'default' => 'grid', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'postMessage' ) );
    $wp_customize->add_control( 'vrt_posts_layout', array(
        'label' => __( 'Blog Layout', 'vite-react-theme' ), 'section' => 'vrt_posts', 'type' => 'select',
        'choices' => array( 'grid' => 'Grid (Cards)', 'list' => 'List' ),
    ) );

    // ══════════════════════════════════════════════════════════════════════════
    // SECTION: Social Links
    // ══════════════════════════════════════════════════════════════════════════
    $wp_customize->add_setting( 'vrt_social_show', array( 'default' => true, 'sanitize_callback' => 'vrt_sanitize_checkbox', 'transport' => 'postMessage' ) );
    $wp_customize->add_control( 'vrt_social_show', array( 'label' => __( 'Show Social Links', 'vite-react-theme' ), 'section' => 'vrt_social', 'type' => 'checkbox' ) );

    foreach ( array( 'twitter' => 'Twitter / X', 'facebook' => 'Facebook', 'instagram' => 'Instagram', 'linkedin' => 'LinkedIn', 'github' => 'GitHub', 'youtube' => 'YouTube' ) as $key => $label ) {
        $wp_customize->add_setting( "vrt_social_{$key}", array( 'default' => '', 'sanitize_callback' => 'esc_url_raw', 'transport' => 'postMessage' ) );
        $wp_customize->add_control( "vrt_social_{$key}", array( 'label' => $label . ' URL', 'section' => 'vrt_social', 'type' => 'url' ) );
    }

    // ══════════════════════════════════════════════════════════════════════════
    // SECTION: Footer
    // ══════════════════════════════════════════════════════════════════════════
    $wp_customize->add_section( 'vrt_footer', array(
        'title' => __( 'Footer', 'vite-react-theme' ), 'panel' => 'vrt_panel', 'priority' => 50,
    ) );

    $wp_customize->add_setting( 'vrt_footer_show', array( 'default' => true, 'sanitize_callback' => 'vrt_sanitize_checkbox', 'transport' => 'postMessage' ) );
    $wp_customize->add_control( 'vrt_footer_show', array( 'label' => __( 'Show Footer', 'vite-react-theme' ), 'section' => 'vrt_footer', 'type' => 'checkbox' ) );

    for ( $c = 1; $c <= 3; $c++ ) {
        $defs = array( 1 => 'Product', 2 => 'Company', 3 => 'Legal' );
        $wp_customize->add_setting( "vrt_footer_col{$c}_title", array( 'default' => $defs[$c], 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'postMessage' ) );
        $wp_customize->add_control( "vrt_footer_col{$c}_title", array( 'label' => sprintf( 'Column %d Heading', $c ), 'section' => 'vrt_footer', 'type' => 'text' ) );
    }

    $wp_customize->add_setting( 'vrt_footer_copyright', array( 'default' => '', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'postMessage' ) );
    $wp_customize->add_control( 'vrt_footer_copyright', array( 'label' => __( 'Copyright Text', 'vite-react-theme' ), 'description' => __( 'Leave blank for default.', 'vite-react-theme' ), 'section' => 'vrt_footer', 'type' => 'text' ) );

    // ══════════════════════════════════════════════════════════════════════════
    // SECTION: Layout
    // ══════════════════════════════════════════════════════════════════════════
    $wp_customize->add_section( 'vrt_layout', array(
        'title' => __( 'Layout Settings', 'vite-react-theme' ), 'panel' => 'vrt_panel', 'priority' => 55,
    ) );

    $wp_customize->add_setting( 'vrt_layout_container_max', array( 'default' => 1200, 'sanitize_callback' => 'absint', 'transport' => 'postMessage' ) );
    $wp_customize->add_control( new VRT_Number_Control( $wp_customize, 'vrt_layout_container_max', array(
        'label' => __( 'Container Max Width (px)', 'vite-react-theme' ), 'section' => 'vrt_layout', 'min' => 900, 'max' => 1600, 'step' => 50,
    ) ) );

    $wp_customize->add_setting( 'vrt_layout_sidebar_position', array( 'default' => 'right', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'postMessage' ) );
    $wp_customize->add_control( 'vrt_layout_sidebar_position', array(
        'label' => __( 'Sidebar Position', 'vite-react-theme' ), 'section' => 'vrt_layout', 'type' => 'select',
        'choices' => array( 'right' => 'Right', 'left' => 'Left' ),
    ) );

    $wp_customize->add_setting( 'vrt_layout_blog_columns', array( 'default' => 3, 'sanitize_callback' => 'absint', 'transport' => 'postMessage' ) );
    $wp_customize->add_control( new VRT_Number_Control( $wp_customize, 'vrt_layout_blog_columns', array(
        'label' => __( 'Blog Columns', 'vite-react-theme' ), 'section' => 'vrt_layout', 'min' => 2, 'max' => 4,
    ) ) );

    $wp_customize->add_setting( 'vrt_layout_card_radius', array( 'default' => 16, 'sanitize_callback' => 'absint', 'transport' => 'postMessage' ) );
    $wp_customize->add_control( new VRT_Number_Control( $wp_customize, 'vrt_layout_card_radius', array(
        'label' => __( 'Card Border Radius (px)', 'vite-react-theme' ), 'section' => 'vrt_layout', 'min' => 0, 'max' => 32, 'step' => 2,
    ) ) );

    // ══════════════════════════════════════════════════════════════════════════
    // SECTION: Animations
    // ══════════════════════════════════════════════════════════════════════════
    $wp_customize->add_section( 'vrt_animations', array(
        'title' => __( 'Animations', 'vite-react-theme' ), 'panel' => 'vrt_panel', 'priority' => 60,
    ) );

    $wp_customize->add_setting( 'vrt_animations_enabled', array( 'default' => true, 'sanitize_callback' => 'vrt_sanitize_checkbox', 'transport' => 'postMessage' ) );
    $wp_customize->add_control( 'vrt_animations_enabled', array( 'label' => __( 'Enable Animations', 'vite-react-theme' ), 'section' => 'vrt_animations', 'type' => 'checkbox' ) );

    $wp_customize->add_setting( 'vrt_animations_style', array( 'default' => 'fade-up', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'postMessage' ) );
    $wp_customize->add_control( 'vrt_animations_style', array(
        'label' => __( 'Default Animation Style', 'vite-react-theme' ), 'section' => 'vrt_animations', 'type' => 'select',
        'choices' => array(
            'fade-up' => 'Fade Up', 'fade-in' => 'Fade In',
            'slide-left' => 'Slide Left', 'slide-right' => 'Slide Right',
            'zoom-in' => 'Zoom In', 'flip' => 'Flip',
        ),
    ) );

    $wp_customize->add_setting( 'vrt_animations_speed', array( 'default' => 'normal', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'postMessage' ) );
    $wp_customize->add_control( 'vrt_animations_speed', array(
        'label' => __( 'Animation Speed', 'vite-react-theme' ), 'section' => 'vrt_animations', 'type' => 'select',
        'choices' => array( 'slow' => 'Slow', 'normal' => 'Normal', 'fast' => 'Fast' ),
    ) );

    $wp_customize->add_setting( 'vrt_animations_stagger', array( 'default' => 80, 'sanitize_callback' => 'absint', 'transport' => 'postMessage' ) );
    $wp_customize->add_control( new VRT_Number_Control( $wp_customize, 'vrt_animations_stagger', array(
        'label' => __( 'Stagger Delay (ms)', 'vite-react-theme' ), 'section' => 'vrt_animations', 'min' => 0, 'max' => 300, 'step' => 10,
    ) ) );

    // ══════════════════════════════════════════════════════════════════════════
    // SECTION: About Page
    // ══════════════════════════════════════════════════════════════════════════
    $wp_customize->add_section( 'vrt_about', array(
        'title' => __( 'About Page', 'vite-react-theme' ), 'panel' => 'vrt_panel', 'priority' => 62,
    ) );

    $wp_customize->add_setting( 'vrt_about_show', array( 'default' => false, 'sanitize_callback' => 'vrt_sanitize_checkbox', 'transport' => 'postMessage' ) );
    $wp_customize->add_control( 'vrt_about_show', array( 'label' => __( 'Show in Navbar', 'vite-react-theme' ), 'section' => 'vrt_about', 'type' => 'checkbox' ) );

    // About Hero
    $wp_customize->add_setting( 'vrt_about_hero_title', array( 'default' => 'About Us', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'postMessage' ) );
    $wp_customize->add_control( 'vrt_about_hero_title', array( 'label' => __( 'About Hero Title', 'vite-react-theme' ), 'section' => 'vrt_about', 'type' => 'text' ) );
    $wp_customize->add_setting( 'vrt_about_nav_title', array( 'default' => 'About', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'postMessage' ) );
    $wp_customize->add_control( 'vrt_about_nav_title', array( 'label' => __( 'Navbar Link Text', 'vite-react-theme' ), 'section' => 'vrt_about', 'type' => 'text' ) );
    $wp_customize->add_setting( 'vrt_about_hero_subtitle', array( 'default' => "We're building the future of WordPress themes with React, animations, and unmatched customization.", 'sanitize_callback' => 'sanitize_textarea_field', 'transport' => 'postMessage' ) );
    $wp_customize->add_control( 'vrt_about_hero_subtitle', array( 'label' => __( 'Hero Subtitle', 'vite-react-theme' ), 'section' => 'vrt_about', 'type' => 'textarea' ) );

    // About Story
    $wp_customize->add_setting( 'vrt_about_story1', array( 'default' => 'We started with a simple idea: WordPress themes should be as modern as the rest of the web. Too many themes are stuck in the past — slow, rigid, and hard to customize. We set out to change that.', 'sanitize_callback' => 'sanitize_textarea_field', 'transport' => 'postMessage' ) );
    $wp_customize->add_control( 'vrt_about_story1', array( 'label' => __( 'Story Paragraph 1', 'vite-react-theme' ), 'section' => 'vrt_about', 'type' => 'textarea' ) );
    $wp_customize->add_setting( 'vrt_about_story2', array( 'default' => 'Our team combines deep expertise in React, WordPress, and modern web design to create themes that are fast, beautiful, and endlessly customizable. Every pixel is crafted, every animation is smooth, and every line of code is clean.', 'sanitize_callback' => 'sanitize_textarea_field', 'transport' => 'postMessage' ) );
    $wp_customize->add_control( 'vrt_about_story2', array( 'label' => __( 'Story Paragraph 2', 'vite-react-theme' ), 'section' => 'vrt_about', 'type' => 'textarea' ) );
    $wp_customize->add_setting( 'vrt_about_story3', array( 'default' => 'Today, we serve thousands of developers and businesses worldwide, helping them build websites that truly stand out.', 'sanitize_callback' => 'sanitize_textarea_field', 'transport' => 'postMessage' ) );
    $wp_customize->add_control( 'vrt_about_story3', array( 'label' => __( 'Story Paragraph 3', 'vite-react-theme' ), 'section' => 'vrt_about', 'type' => 'textarea' ) );

    // Team
    $wp_customize->add_setting( 'vrt_about_team_label', array( 'default' => 'Our Team', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'postMessage' ) );
    $wp_customize->add_control( 'vrt_about_team_label', array( 'label' => __( 'Team Label', 'vite-react-theme' ), 'section' => 'vrt_about', 'type' => 'text' ) );
    $wp_customize->add_setting( 'vrt_about_team_title', array( 'default' => 'Meet the Makers', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'postMessage' ) );
    $wp_customize->add_control( 'vrt_about_team_title', array( 'label' => __( 'Team Title', 'vite-react-theme' ), 'section' => 'vrt_about', 'type' => 'text' ) );

    $team_defs = array(
        1 => array('Alex Morgan', 'CEO & Founder', '👨‍💻'),
        2 => array('Sarah Chen', 'Lead Designer', '🎨'),
        3 => array('Marcus Rivera', 'CTO', '⚙️'),
        4 => array('Emily Watson', 'Head of Marketing', '📈'),
    );
    for ( $i = 1; $i <= 4; $i++ ) {
        $d = $team_defs[$i];
        $wp_customize->add_setting( "vrt_team_{$i}_name", array( 'default' => $d[0], 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'postMessage' ) );
        $wp_customize->add_control( "vrt_team_{$i}_name", array( 'label' => "Team $i Name", 'section' => 'vrt_about', 'type' => 'text' ) );
        $wp_customize->add_setting( "vrt_team_{$i}_role", array( 'default' => $d[1], 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'postMessage' ) );
        $wp_customize->add_control( "vrt_team_{$i}_role", array( 'label' => "Team $i Role", 'section' => 'vrt_about', 'type' => 'text' ) );
        $wp_customize->add_setting( "vrt_team_{$i}_emoji", array( 'default' => $d[2], 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'postMessage' ) );
        $wp_customize->add_control( "vrt_team_{$i}_emoji", array( 'label' => "Team $i Emoji", 'section' => 'vrt_about', 'type' => 'text' ) );
    }

    // Timeline
    $wp_customize->add_setting( 'vrt_about_timeline_label', array( 'default' => 'Our Journey', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'postMessage' ) );
    $wp_customize->add_control( 'vrt_about_timeline_label', array( 'label' => __( 'Timeline Label', 'vite-react-theme' ), 'section' => 'vrt_about', 'type' => 'text' ) );
    $wp_customize->add_setting( 'vrt_about_timeline_title', array( 'default' => 'Milestones', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'postMessage' ) );
    $wp_customize->add_control( 'vrt_about_timeline_title', array( 'label' => __( 'Timeline Title', 'vite-react-theme' ), 'section' => 'vrt_about', 'type' => 'text' ) );
    
    $timeline_defs = array(
        1 => array('2024', 'Company Founded', 'Started with a vision to create the best WordPress themes.'),
        2 => array('2024', 'First 1K Users', 'Reached our first thousand active users within 3 months.'),
        3 => array('2025', 'React Integration', 'Pioneered React-powered WordPress themes with Vite.'),
        4 => array('2026', '10K+ Users', 'Growing community of developers and designers worldwide.'),
    );
    for ( $i = 1; $i <= 4; $i++ ) {
        $d = $timeline_defs[$i];
        $wp_customize->add_setting( "vrt_timeline_{$i}_year", array( 'default' => $d[0], 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'postMessage' ) );
        $wp_customize->add_control( "vrt_timeline_{$i}_year", array( 'label' => "Timeline $i Year", 'section' => 'vrt_about', 'type' => 'text' ) );
        $wp_customize->add_setting( "vrt_timeline_{$i}_title", array( 'default' => $d[1], 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'postMessage' ) );
        $wp_customize->add_control( "vrt_timeline_{$i}_title", array( 'label' => "Timeline $i Title", 'section' => 'vrt_about', 'type' => 'text' ) );
        $wp_customize->add_setting( "vrt_timeline_{$i}_desc", array( 'default' => $d[2], 'sanitize_callback' => 'sanitize_textarea_field', 'transport' => 'postMessage' ) );
        $wp_customize->add_control( "vrt_timeline_{$i}_desc", array( 'label' => "Timeline $i Desc", 'section' => 'vrt_about', 'type' => 'textarea' ) );
    }

    // ══════════════════════════════════════════════════════════════════════════
    // SECTION: Blog Page (Dedicated)
    // ══════════════════════════════════════════════════════════════════════════
    $wp_customize->add_section( 'vrt_blog_page', array(
        'title' => __( 'Blog Page Settings', 'vite-react-theme' ), 'panel' => 'vrt_panel', 'priority' => 42,
    ) );

    $wp_customize->add_setting( 'vrt_blog_hero_show', array( 'default' => true, 'sanitize_callback' => 'vrt_sanitize_checkbox', 'transport' => 'postMessage' ) );
    $wp_customize->add_control( 'vrt_blog_hero_show', array( 'label' => __( 'Show Blog Hero', 'vite-react-theme' ), 'section' => 'vrt_blog_page', 'type' => 'checkbox' ) );

    $wp_customize->add_setting( 'vrt_blog_hero_title', array( 'default' => 'Our Blog', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'postMessage' ) );
    $wp_customize->add_control( 'vrt_blog_hero_title', array( 'label' => __( 'Blog Title', 'vite-react-theme' ), 'section' => 'vrt_blog_page', 'type' => 'text' ) );

    $wp_customize->add_setting( 'vrt_blog_nav_title', array( 'default' => 'Blog', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'postMessage' ) );
    $wp_customize->add_control( 'vrt_blog_nav_title', array( 'label' => __( 'Navbar Link Text', 'vite-react-theme' ), 'section' => 'vrt_blog_page', 'type' => 'text' ) );

    $wp_customize->add_setting( 'vrt_blog_hero_subtitle', array( 'default' => 'Stories, tips, and insights from our team', 'sanitize_callback' => 'sanitize_textarea_field', 'transport' => 'postMessage' ) );
    $wp_customize->add_control( 'vrt_blog_hero_subtitle', array( 'label' => __( 'Blog Subtitle', 'vite-react-theme' ), 'section' => 'vrt_blog_page', 'type' => 'textarea' ) );

    $wp_customize->add_setting( 'vrt_blog_sidebar_show', array( 'default' => true, 'sanitize_callback' => 'vrt_sanitize_checkbox', 'transport' => 'postMessage' ) );
    $wp_customize->add_control( 'vrt_blog_sidebar_show', array( 'label' => __( 'Show Sidebar', 'vite-react-theme' ), 'section' => 'vrt_blog_page', 'type' => 'checkbox' ) );

    $wp_customize->add_setting( 'vrt_blog_show', array( 'default' => false, 'sanitize_callback' => 'vrt_sanitize_checkbox', 'transport' => 'postMessage' ) );
    $wp_customize->add_control( 'vrt_blog_show', array( 'label' => __( 'Show in Navbar', 'vite-react-theme' ), 'section' => 'vrt_blog_page', 'type' => 'checkbox' ) );

    $wp_customize->add_setting( 'vrt_blog_per_page', array( 'default' => 9, 'sanitize_callback' => 'absint', 'transport' => 'postMessage' ) );
    $wp_customize->add_control( new VRT_Number_Control( $wp_customize, 'vrt_blog_per_page', array(
        'label' => __( 'Posts Per Page', 'vite-react-theme' ), 'section' => 'vrt_blog_page', 'min' => 3, 'max' => 24,
    ) ) );

    // Card Customization
    $wp_customize->add_setting( 'vrt_blog_card_show_image', array( 'default' => true, 'sanitize_callback' => 'vrt_sanitize_checkbox', 'transport' => 'postMessage' ) );
    $wp_customize->add_control( 'vrt_blog_card_show_image', array( 'label' => __( 'Show Featured Image', 'vite-react-theme' ), 'section' => 'vrt_blog_page', 'type' => 'checkbox' ) );

    $wp_customize->add_setting( 'vrt_blog_card_show_date', array( 'default' => true, 'sanitize_callback' => 'vrt_sanitize_checkbox', 'transport' => 'postMessage' ) );
    $wp_customize->add_control( 'vrt_blog_card_show_date', array( 'label' => __( 'Show Post Date', 'vite-react-theme' ), 'section' => 'vrt_blog_page', 'type' => 'checkbox' ) );

    $wp_customize->add_setting( 'vrt_blog_card_show_category', array( 'default' => true, 'sanitize_callback' => 'vrt_sanitize_checkbox', 'transport' => 'postMessage' ) );
    $wp_customize->add_control( 'vrt_blog_card_show_category', array( 'label' => __( 'Show Category Tag', 'vite-react-theme' ), 'section' => 'vrt_blog_page', 'type' => 'checkbox' ) );

    $wp_customize->add_setting( 'vrt_blog_card_show_excerpt', array( 'default' => true, 'sanitize_callback' => 'vrt_sanitize_checkbox', 'transport' => 'postMessage' ) );
    $wp_customize->add_control( 'vrt_blog_card_show_excerpt', array( 'label' => __( 'Show Excerpt', 'vite-react-theme' ), 'section' => 'vrt_blog_page', 'type' => 'checkbox' ) );

    $wp_customize->add_setting( 'vrt_blog_card_read_more', array( 'default' => 'Read more', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'postMessage' ) );
    $wp_customize->add_control( 'vrt_blog_card_read_more', array( 'label' => __( 'Read More Text', 'vite-react-theme' ), 'section' => 'vrt_blog_page', 'type' => 'text' ) );

    $wp_customize->add_setting( 'vrt_blog_card_excerpt_length', array( 'default' => 25, 'sanitize_callback' => 'absint', 'transport' => 'postMessage' ) );
    $wp_customize->add_control( new VRT_Number_Control( $wp_customize, 'vrt_blog_card_excerpt_length', array(
        'label' => __( 'Excerpt length (words)', 'vite-react-theme' ), 'section' => 'vrt_blog_page', 'min' => 10, 'max' => 100,
    ) ) );

    // ══════════════════════════════════════════════════════════════════════════
    // SECTION: Contact Page
    // ══════════════════════════════════════════════════════════════════════════
    $wp_customize->add_section( 'vrt_contact', array(
        'title' => __( 'Contact Page', 'vite-react-theme' ), 'panel' => 'vrt_panel', 'priority' => 63,
    ) );

    $wp_customize->add_setting( 'vrt_contact_show', array( 'default' => false, 'sanitize_callback' => 'vrt_sanitize_checkbox', 'transport' => 'postMessage' ) );
    $wp_customize->add_control( 'vrt_contact_show', array( 'label' => __( 'Show in Navbar', 'vite-react-theme' ), 'section' => 'vrt_contact', 'type' => 'checkbox' ) );

    // Contact Hero
    $wp_customize->add_setting( 'vrt_contact_hero_title', array( 'default' => 'Get in Touch', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'postMessage' ) );
    $wp_customize->add_control( 'vrt_contact_hero_title', array( 'label' => __( 'Hero Title', 'vite-react-theme' ), 'section' => 'vrt_contact', 'type' => 'text' ) );
    $wp_customize->add_setting( 'vrt_contact_hero_subtitle', array( 'default' => "Have a question or want to work together? We'd love to hear from you.", 'sanitize_callback' => 'sanitize_textarea_field', 'transport' => 'postMessage' ) );
    $wp_customize->add_control( 'vrt_contact_hero_subtitle', array( 'label' => __( 'Hero Subtitle', 'vite-react-theme' ), 'section' => 'vrt_contact', 'type' => 'textarea' ) );

    // Contact Info Grid
    $contact_defs = array(
        1 => array('📧', 'Email', 'hello@example.com'),
        2 => array('📱', 'Phone', '+1 (555) 123-4567'),
        3 => array('📍', 'Location', 'San Francisco, CA'),
        4 => array('⏰', 'Hours', 'Mon–Fri, 9AM–6PM PST'),
    );
    for ( $i = 1; $i <= 4; $i++ ) {
        $d = $contact_defs[$i];
        $wp_customize->add_setting( "vrt_contact_{$i}_icon", array( 'default' => $d[0], 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'postMessage' ) );
        $wp_customize->add_control( "vrt_contact_{$i}_icon", array( 'label' => "Contact Info $i Icon", 'section' => 'vrt_contact', 'type' => 'text' ) );
        $wp_customize->add_setting( "vrt_contact_{$i}_label", array( 'default' => $d[1], 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'postMessage' ) );
        $wp_customize->add_control( "vrt_contact_{$i}_label", array( 'label' => "Contact Info $i Label", 'section' => 'vrt_contact', 'type' => 'text' ) );
        $wp_customize->add_setting( "vrt_contact_{$i}_value", array( 'default' => $d[2], 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'postMessage' ) );
        $wp_customize->add_control( "vrt_contact_{$i}_value", array( 'label' => "Contact Info $i Value", 'section' => 'vrt_contact', 'type' => 'text' ) );
    }

    $wp_customize->add_setting( 'vrt_contact_form_title', array( 'default' => 'Send us a message', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'postMessage' ) );
    $wp_customize->add_control( 'vrt_contact_form_title', array( 'label' => __( 'Form Title', 'vite-react-theme' ), 'section' => 'vrt_contact', 'type' => 'text' ) );

    // ══════════════════════════════════════════════════════════════════════════
    // SECTION: 404 Page
    // ══════════════════════════════════════════════════════════════════════════
    $wp_customize->add_section( 'vrt_404', array(
        'title' => __( '404 Page', 'vite-react-theme' ), 'panel' => 'vrt_panel', 'priority' => 65,
    ) );

    $wp_customize->add_setting( 'vrt_404_title', array( 'default' => 'Page Not Found', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'postMessage' ) );
    $wp_customize->add_control( 'vrt_404_title', array( 'label' => __( '404 Title', 'vite-react-theme' ), 'section' => 'vrt_404', 'type' => 'text' ) );

    $wp_customize->add_setting( 'vrt_404_message', array( 'default' => "The page you're looking for doesn't exist or has been moved.", 'sanitize_callback' => 'sanitize_textarea_field', 'transport' => 'postMessage' ) );
    $wp_customize->add_control( 'vrt_404_message', array( 'label' => __( '404 Message', 'vite-react-theme' ), 'section' => 'vrt_404', 'type' => 'textarea' ) );

    // ══════════════════════════════════════════════════════════════════════════
    // SECTION: Extra Pages (Services, Portfolio, etc.)
    // ══════════════════════════════════════════════════════════════════════════
    $extra_pages = array(
        'services' => array('Services', 'Our Services', 'We provide a comprehensive suite of digital solutions designed to help your business thrive.'),
        'portfolio' => array('Portfolio', 'Our Portfolio', 'Discover our latest projects and see how we\'ve helped businesses achieve their digital goals.'),
        'pricing' => array('Pricing', 'Simple, Transparent Pricing', 'Choose the perfect plan for your business needs. No hidden fees or surprises.'),
        'team' => array('Team', 'Meet Our Team', 'We are a diverse group of passionate builders, creators, and thinkers dedicated to making the web a better place.'),
        'faq' => array('FAQ', 'Frequently Asked Questions', 'Everything you need to know about our product and billing.'),
        'careers' => array('Careers', 'Join Our Team', 'Help us build the next generation of digital products. We offer competitive salaries, equity, and remote-first flexibility.'),
        'testimonials' => array('Testimonials', 'Loved by Thousands', 'Don\'t just take our word for it. Here\'s what our incredible customers have to say.'),
        'features' => array('Features', 'Powerful Features', 'Everything you need to scale your business, manage your team, and delight your customers, all in one platform.'),
        'privacy' => array('Privacy Policy', 'Privacy Policy', 'Your privacy is important to us. Learn how we collect, use, and protect your data.'),
        'terms' => array('Terms of Service', 'Terms of Service', 'Please read our terms of service carefully before using our website.'),
    );

    foreach ($extra_pages as $slug => $data) {
        $wp_customize->add_section( "vrt_page_{$slug}", array(
            'title' => __( $data[0] . ' Page', 'vite-react-theme' ), 'panel' => 'vrt_panel', 'priority' => 64,
        ) );

        $wp_customize->add_setting( "vrt_{$slug}_show", array( 'default' => false, 'sanitize_callback' => 'vrt_sanitize_checkbox', 'transport' => 'postMessage' ) );
        $wp_customize->add_control( "vrt_{$slug}_show", array( 'label' => __( 'Show in Navbar', 'vite-react-theme' ), 'section' => "vrt_page_{$slug}", 'type' => 'checkbox' ) );

        $wp_customize->add_setting( "vrt_{$slug}_title", array( 'default' => $data[1], 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'postMessage' ) );
        $wp_customize->add_control( "vrt_{$slug}_title", array( 'label' => __( 'Page Title', 'vite-react-theme' ), 'section' => "vrt_page_{$slug}", 'type' => 'text' ) );

        $wp_customize->add_setting( "vrt_{$slug}_nav_title", array( 'default' => '', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'postMessage' ) );
        $wp_customize->add_control( "vrt_{$slug}_nav_title", array( 'label' => __( 'Navbar Link Text (Optional)', 'vite-react-theme' ), 'section' => "vrt_page_{$slug}", 'type' => 'text', 'description' => 'If blank, uses Page Title.' ) );

        $wp_customize->add_setting( "vrt_{$slug}_subtitle", array( 'default' => $data[2], 'sanitize_callback' => 'sanitize_textarea_field', 'transport' => 'postMessage' ) );
        $wp_customize->add_control( "vrt_{$slug}_subtitle", array( 'label' => __( 'Page Subtitle', 'vite-react-theme' ), 'section' => "vrt_page_{$slug}", 'type' => 'textarea' ) );

        // ── Services card controls ─────────────────────────────────────────
        if ( $slug === 'services' ) {
            $service_defs = array(
                1 => array( '💻', 'Web Development', 'Custom tailored modern websites built with React and WordPress.' ),
                2 => array( '🎨', 'UI/UX Design', 'Beautiful, user-centric interfaces focused on conversion and aesthetics.' ),
                3 => array( '🚀', 'SEO Optimization', 'Higher rankings through structural optimizations and sematic HTML.' ),
                4 => array( '📈', 'Marketing', 'Data-driven marketing strategies to grow your brand organically.' ),
                5 => array( '💡', 'Consulting', 'Expert guidance on tech stacks, architectures, and scaling systems.' ),
                6 => array( '🛒', 'E-Commerce', 'Secure, high-performance online stores that drive real sales.' ),
            );
            for ( $ci = 1; $ci <= 6; $ci++ ) {
                $cd = $service_defs[$ci];
                $wp_customize->add_setting( "vrt_services_card{$ci}_icon",  array( 'default' => $cd[0], 'sanitize_callback' => 'sanitize_text_field',     'transport' => 'postMessage' ) );
                $wp_customize->add_control( "vrt_services_card{$ci}_icon",  array( 'label' => sprintf( 'Card %d — Icon/Emoji', $ci ),  'section' => 'vrt_page_services', 'type' => 'text' ) );
                $wp_customize->add_setting( "vrt_services_card{$ci}_title", array( 'default' => $cd[1], 'sanitize_callback' => 'sanitize_text_field',     'transport' => 'postMessage' ) );
                $wp_customize->add_control( "vrt_services_card{$ci}_title", array( 'label' => sprintf( 'Card %d — Title', $ci ),       'section' => 'vrt_page_services', 'type' => 'text' ) );
                $wp_customize->add_setting( "vrt_services_card{$ci}_desc",  array( 'default' => $cd[2], 'sanitize_callback' => 'sanitize_textarea_field', 'transport' => 'postMessage' ) );
                $wp_customize->add_control( "vrt_services_card{$ci}_desc",  array( 'label' => sprintf( 'Card %d — Description', $ci ), 'section' => 'vrt_page_services', 'type' => 'textarea' ) );
            }
        }

        // ── Portfolio card controls ────────────────────────────────────────
        if ( $slug === 'portfolio' ) {
            $portfolio_defs = array(
                1 => array( 'Nova E-Commerce',  'Web Development', 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&q=80&w=800' ),
                2 => array( 'Nexus App',        'Product Design',  'https://images.unsplash.com/photo-1551288049-bebda4e38f71?auto=format&fit=crop&q=80&w=800' ),
                3 => array( 'Aura Branding',    'Identity',        'https://images.unsplash.com/photo-1542744173-8e7e53415bb0?auto=format&fit=crop&q=80&w=800' ),
                4 => array( 'Apex Analytics',   'SaaS Platform',   'https://images.unsplash.com/photo-1504868584819-f8e8b4b6d7e3?auto=format&fit=crop&q=80&w=800' ),
                5 => array( 'Zenith Studio',    'Web Design',      'https://images.unsplash.com/photo-1498050108023-c5249f4df085?auto=format&fit=crop&q=80&w=800' ),
                6 => array( 'Lumina Health',    'App Development', 'https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?auto=format&fit=crop&q=80&w=800' ),
            );
            for ( $ci = 1; $ci <= 6; $ci++ ) {
                $cd = $portfolio_defs[$ci];
                $wp_customize->add_setting( "vrt_portfolio_card{$ci}_title",    array( 'default' => $cd[0], 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'postMessage' ) );
                $wp_customize->add_control( "vrt_portfolio_card{$ci}_title",    array( 'label' => sprintf( 'Project %d — Title', $ci ),    'section' => 'vrt_page_portfolio', 'type' => 'text' ) );
                $wp_customize->add_setting( "vrt_portfolio_card{$ci}_category", array( 'default' => $cd[1], 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'postMessage' ) );
                $wp_customize->add_control( "vrt_portfolio_card{$ci}_category", array( 'label' => sprintf( 'Project %d — Category', $ci ), 'section' => 'vrt_page_portfolio', 'type' => 'text' ) );
                $wp_customize->add_setting( "vrt_portfolio_card{$ci}_img",      array( 'default' => $cd[2], 'sanitize_callback' => 'esc_url_raw',         'transport' => 'postMessage' ) );
                $wp_customize->add_control( "vrt_portfolio_card{$ci}_img",      array( 'label' => sprintf( 'Project %d — Image URL', $ci ), 'section' => 'vrt_page_portfolio', 'type' => 'url' ) );
            }
        }

        // ── Testimonials card controls ─────────────────────────────────────
        if ( $slug === 'testimonials' ) {
            $test_defs = array(
                1 => array( 'John Doe',    'TechCorp',       'An absolutely phenomenal experience from start to finish. The team is incredibly talented.', '5' ),
                2 => array( 'Jane Smith',  'DesignCo',       'Our conversion rates doubled after implementing their solutions. Highly recommended!',        '5' ),
                3 => array( 'Mike Johnson','Startup Inc',    'Fast, responsive, and beautifully designed. Worth every penny.',                              '4' ),
                4 => array( 'Emily Davis', 'Global LLC',    'The support team goes above and beyond. We feel truly valued as customers.',                  '5' ),
                5 => array( 'Chris Lee',   'Creative Studio','A game changer for our agency. It streamlined our entire workflow.',                          '5' ),
                6 => array( 'Sarah Wilson','Media Group',    'Very impressive attention to detail. The final product exceeded our expectations.',            '4' ),
            );
            for ( $ci = 1; $ci <= 6; $ci++ ) {
                $cd = $test_defs[$ci];
                $wp_customize->add_setting( "vrt_testimonials_card{$ci}_name",    array( 'default' => $cd[0], 'sanitize_callback' => 'sanitize_text_field',     'transport' => 'postMessage' ) );
                $wp_customize->add_control( "vrt_testimonials_card{$ci}_name",    array( 'label' => sprintf( 'Review %d — Name', $ci ),    'section' => 'vrt_page_testimonials', 'type' => 'text' ) );
                $wp_customize->add_setting( "vrt_testimonials_card{$ci}_company", array( 'default' => $cd[1], 'sanitize_callback' => 'sanitize_text_field',     'transport' => 'postMessage' ) );
                $wp_customize->add_control( "vrt_testimonials_card{$ci}_company", array( 'label' => sprintf( 'Review %d — Company', $ci ), 'section' => 'vrt_page_testimonials', 'type' => 'text' ) );
                $wp_customize->add_setting( "vrt_testimonials_card{$ci}_text",    array( 'default' => $cd[2], 'sanitize_callback' => 'sanitize_textarea_field', 'transport' => 'postMessage' ) );
                $wp_customize->add_control( "vrt_testimonials_card{$ci}_text",    array( 'label' => sprintf( 'Review %d — Quote', $ci ),   'section' => 'vrt_page_testimonials', 'type' => 'textarea' ) );
                $wp_customize->add_setting( "vrt_testimonials_card{$ci}_rating",  array( 'default' => $cd[3], 'sanitize_callback' => 'absint',                  'transport' => 'postMessage' ) );
                $wp_customize->add_control( new VRT_Number_Control( $wp_customize, "vrt_testimonials_card{$ci}_rating", array(
                    'label' => sprintf( 'Review %d — Rating (1-5)', $ci ), 'section' => 'vrt_page_testimonials', 'min' => 1, 'max' => 5,
                ) ) );
            }
        }

        // ── Pricing tier controls ──────────────────────────────────────────
        if ( $slug === 'pricing' ) {
            $pricing_defs = array(
                1 => array( 'Starter',      '$29',  '/mo', 'Perfect for small businesses starting their digital journey.',        '1 Project, Basic Analytics, 24-hour Support, 1GB Storage',                                               'Get Starter' ),
                2 => array( 'Professional', '$79',  '/mo', 'Ideal for growing companies needing advanced capabilities.',          '5 Projects, Advanced Analytics, Priority Support, 10GB Storage, Custom Domains',                         'Get Professional' ),
                3 => array( 'Enterprise',   '$199', '/mo', 'Dedicated solutions for large-scale operations.',                    'Unlimited Projects, Custom Reporting, 24/7 Dedicated Support, Unlimited Storage, API Access, SLA Guarantee', 'Contact Sales' ),
            );
            for ( $ci = 1; $ci <= 3; $ci++ ) {
                $cd = $pricing_defs[$ci];
                $wp_customize->add_setting( "vrt_pricing_tier{$ci}_title",    array( 'default' => $cd[0], 'sanitize_callback' => 'sanitize_text_field',     'transport' => 'postMessage' ) );
                $wp_customize->add_control( "vrt_pricing_tier{$ci}_title",    array( 'label' => sprintf( 'Tier %d — Plan Name', $ci ),       'section' => 'vrt_page_pricing', 'type' => 'text' ) );
                $wp_customize->add_setting( "vrt_pricing_tier{$ci}_price",    array( 'default' => $cd[1], 'sanitize_callback' => 'sanitize_text_field',     'transport' => 'postMessage' ) );
                $wp_customize->add_control( "vrt_pricing_tier{$ci}_price",    array( 'label' => sprintf( 'Tier %d — Price (e.g. $29)', $ci ), 'section' => 'vrt_page_pricing', 'type' => 'text' ) );
                $wp_customize->add_setting( "vrt_pricing_tier{$ci}_period",   array( 'default' => $cd[2], 'sanitize_callback' => 'sanitize_text_field',     'transport' => 'postMessage' ) );
                $wp_customize->add_control( "vrt_pricing_tier{$ci}_period",   array( 'label' => sprintf( 'Tier %d — Period (e.g. /mo)', $ci ), 'section' => 'vrt_page_pricing', 'type' => 'text' ) );
                $wp_customize->add_setting( "vrt_pricing_tier{$ci}_desc",     array( 'default' => $cd[3], 'sanitize_callback' => 'sanitize_textarea_field', 'transport' => 'postMessage' ) );
                $wp_customize->add_control( "vrt_pricing_tier{$ci}_desc",     array( 'label' => sprintf( 'Tier %d — Description', $ci ),     'section' => 'vrt_page_pricing', 'type' => 'textarea' ) );
                $wp_customize->add_setting( "vrt_pricing_tier{$ci}_features", array( 'default' => $cd[4], 'sanitize_callback' => 'sanitize_textarea_field', 'transport' => 'postMessage' ) );
                $wp_customize->add_control( "vrt_pricing_tier{$ci}_features", array( 'label' => sprintf( 'Tier %d — Features (comma separated)', $ci ), 'section' => 'vrt_page_pricing', 'type' => 'textarea' ) );
                $wp_customize->add_setting( "vrt_pricing_tier{$ci}_btn",      array( 'default' => $cd[5], 'sanitize_callback' => 'sanitize_text_field',     'transport' => 'postMessage' ) );
                $wp_customize->add_control( "vrt_pricing_tier{$ci}_btn",      array( 'label' => sprintf( 'Tier %d — Button Text', $ci ),      'section' => 'vrt_page_pricing', 'type' => 'text' ) );
            }
        }

        // ── FAQ item controls ──────────────────────────────────────────────
        if ( $slug === 'faq' ) {
            $faq_defs = array(
                1 => array( 'How does the 30-day money-back guarantee work?',       'If you are not entirely satisfied with our service, you can cancel within 30 days for a full refund, no questions asked.' ),
                2 => array( 'Do you offer technical support?',                       'Yes, our team provides 24/7 technical support for all Enterprise clients, and standard business-hours support for Pro and Starter tiers.' ),
                3 => array( 'Can I upgrade my plan later?',                          'Absolutely. You can upgrade or downgrade your plan at any time through your account dashboard. Prorated charges will apply.' ),
                4 => array( 'What payment methods do you accept?',                   'We accept all major credit cards, PayPal, and wire transfers for annual Enterprise billing.' ),
                5 => array( 'Is there a setup fee?',                                 'No, there are no hidden setup fees for Starter or Pro plans. Enterprise plans may incur setup fees depending on customization scope.' ),
            );
            for ( $ci = 1; $ci <= 5; $ci++ ) {
                $cd = $faq_defs[$ci];
                $wp_customize->add_setting( "vrt_faq_item{$ci}_q", array( 'default' => $cd[0], 'sanitize_callback' => 'sanitize_text_field',     'transport' => 'postMessage' ) );
                $wp_customize->add_control( "vrt_faq_item{$ci}_q", array( 'label' => sprintf( 'FAQ %d — Question', $ci ), 'section' => 'vrt_page_faq', 'type' => 'text' ) );
                $wp_customize->add_setting( "vrt_faq_item{$ci}_a", array( 'default' => $cd[1], 'sanitize_callback' => 'sanitize_textarea_field', 'transport' => 'postMessage' ) );
                $wp_customize->add_control( "vrt_faq_item{$ci}_a", array( 'label' => sprintf( 'FAQ %d — Answer', $ci ),   'section' => 'vrt_page_faq', 'type' => 'textarea' ) );
            }
        }

        // ── Careers job listing controls ───────────────────────────────────
        if ( $slug === 'careers' ) {
            $careers_defs = array(
                1 => array( 'Senior Frontend Engineer',   'Engineering', 'Remote',          'Full-time' ),
                2 => array( 'Product Designer',           'Design',      'San Francisco, CA','Full-time' ),
                3 => array( 'Backend Developer',          'Engineering', 'Remote',          'Contract' ),
                4 => array( 'Marketing Manager',          'Marketing',   'New York, NY',    'Full-time' ),
                5 => array( 'Customer Success Specialist','Support',     'Remote',          'Full-time' ),
            );
            $wp_customize->add_setting( 'vrt_careers_apply_btn', array( 'default' => 'Apply Now', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'postMessage' ) );
            $wp_customize->add_control( 'vrt_careers_apply_btn', array( 'label' => __( 'Apply Button Text', 'vite-react-theme' ), 'section' => 'vrt_page_careers', 'type' => 'text' ) );
            for ( $ci = 1; $ci <= 5; $ci++ ) {
                $cd = $careers_defs[$ci];
                $wp_customize->add_setting( "vrt_careers_job{$ci}_title", array( 'default' => $cd[0], 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'postMessage' ) );
                $wp_customize->add_control( "vrt_careers_job{$ci}_title", array( 'label' => sprintf( 'Job %d — Title', $ci ),      'section' => 'vrt_page_careers', 'type' => 'text' ) );
                $wp_customize->add_setting( "vrt_careers_job{$ci}_dept",  array( 'default' => $cd[1], 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'postMessage' ) );
                $wp_customize->add_control( "vrt_careers_job{$ci}_dept",  array( 'label' => sprintf( 'Job %d — Department', $ci ), 'section' => 'vrt_page_careers', 'type' => 'text' ) );
                $wp_customize->add_setting( "vrt_careers_job{$ci}_loc",   array( 'default' => $cd[2], 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'postMessage' ) );
                $wp_customize->add_control( "vrt_careers_job{$ci}_loc",   array( 'label' => sprintf( 'Job %d — Location', $ci ),   'section' => 'vrt_page_careers', 'type' => 'text' ) );
                $wp_customize->add_setting( "vrt_careers_job{$ci}_type",  array( 'default' => $cd[3], 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'postMessage' ) );
                $wp_customize->add_control( "vrt_careers_job{$ci}_type",  array( 'label' => sprintf( 'Job %d — Type', $ci ),       'section' => 'vrt_page_careers', 'type' => 'text' ) );
            }
        }

        // ── Team member controls ───────────────────────────────────────────
        if ( $slug === 'team' ) {
            $team_page_defs = array(
                1 => array( 'Alex Harper',  'CEO & Founder',    'https://images.unsplash.com/photo-1560250097-0b93528c311a?auto=format&fit=crop&q=80&w=400' ),
                2 => array( 'Sarah Chen',   'CTO',              'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&q=80&w=400' ),
                3 => array( 'Michael Ross', 'Lead Designer',    'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?auto=format&fit=crop&q=80&w=400' ),
                4 => array( 'Emma Wilson',  'Head of Growth',   'https://images.unsplash.com/photo-1580489944761-15a19d654956?auto=format&fit=crop&q=80&w=400' ),
                5 => array( 'David Kim',    'Senior Engineer',  'https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?auto=format&fit=crop&q=80&w=400' ),
                6 => array( 'Lisa Ray',     'Product Manager',  'https://images.unsplash.com/photo-1598550874175-4d0ef43ce418?auto=format&fit=crop&q=80&w=400' ),
            );
            for ( $ci = 1; $ci <= 6; $ci++ ) {
                $cd = $team_page_defs[$ci];
                $wp_customize->add_setting( "vrt_team_page_member{$ci}_name", array( 'default' => $cd[0], 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'postMessage' ) );
                $wp_customize->add_control( "vrt_team_page_member{$ci}_name", array( 'label' => sprintf( 'Member %d — Name', $ci ), 'section' => 'vrt_page_team', 'type' => 'text' ) );
                $wp_customize->add_setting( "vrt_team_page_member{$ci}_role", array( 'default' => $cd[1], 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'postMessage' ) );
                $wp_customize->add_control( "vrt_team_page_member{$ci}_role", array( 'label' => sprintf( 'Member %d — Role', $ci ), 'section' => 'vrt_page_team', 'type' => 'text' ) );
                $wp_customize->add_setting( "vrt_team_page_member{$ci}_img",  array( 'default' => $cd[2], 'sanitize_callback' => 'esc_url_raw',         'transport' => 'postMessage' ) );
                $wp_customize->add_control( "vrt_team_page_member{$ci}_img",  array( 'label' => sprintf( 'Member %d — Photo URL', $ci ), 'section' => 'vrt_page_team', 'type' => 'url' ) );
            }
        }

        // ── Features page card controls ────────────────────────────────────
        if ( $slug === 'features' ) {
            $feat_defs = array(
                1 => array( '⚡', 'Lightning Fast Performance', 'Built on Vite, experiencing zero-latency loads and absolute peak core web vitals.' ),
                2 => array( '🔒', 'Bank-Grade Security',        'End-to-end encryption with advanced CSRF and XSS protection built-in by default.' ),
                3 => array( '🔗', 'Seamless Integrations',      'Connect easily to your favorite tools via our native webhooks and REST APIs.' ),
                4 => array( '📈', 'Real-time Analytics',        'Watch your traffic grow with up-to-the-second dashboard metrics and reporting.' ),
                5 => array( '💾', 'Automated Backups',          'Never lose your data. We perform hourly snapshots securely stored in the cloud.' ),
                6 => array( '🌐', 'Global CDN',                 'Your assets are cached worldwide ensuring millisecond delivery anywhere.' ),
            );
            for ( $ci = 1; $ci <= 6; $ci++ ) {
                $cd = $feat_defs[$ci];
                $wp_customize->add_setting( "vrt_features_page_card{$ci}_icon",  array( 'default' => $cd[0], 'sanitize_callback' => 'sanitize_text_field',     'transport' => 'postMessage' ) );
                $wp_customize->add_control( "vrt_features_page_card{$ci}_icon",  array( 'label' => sprintf( 'Item %d — Icon/Emoji', $ci ),  'section' => 'vrt_page_features', 'type' => 'text' ) );
                $wp_customize->add_setting( "vrt_features_page_card{$ci}_title", array( 'default' => $cd[1], 'sanitize_callback' => 'sanitize_text_field',     'transport' => 'postMessage' ) );
                $wp_customize->add_control( "vrt_features_page_card{$ci}_title", array( 'label' => sprintf( 'Item %d — Title', $ci ),        'section' => 'vrt_page_features', 'type' => 'text' ) );
                $wp_customize->add_setting( "vrt_features_page_card{$ci}_desc",  array( 'default' => $cd[2], 'sanitize_callback' => 'sanitize_textarea_field', 'transport' => 'postMessage' ) );
                $wp_customize->add_control( "vrt_features_page_card{$ci}_desc",  array( 'label' => sprintf( 'Item %d — Description', $ci ),  'section' => 'vrt_page_features', 'type' => 'textarea' ) );
            }
        }
    }



    // ══════════════════════════════════════════════════════════════════════════
    // CORE WP SETTINGS: Switch to postMessage
    // ══════════════════════════════════════════════════════════════════════════
    $core_settings = array( 'blogname', 'blogdescription', 'custom_logo' );
    foreach ( $core_settings as $setting_id ) {
        $setting = $wp_customize->get_setting( $setting_id );
        if ( $setting ) {
            $setting->transport = 'postMessage';
        }
    }
}
add_action( 'customize_register', 'vrt_customize_register' );

function vrt_sanitize_checkbox( $value ) {
    return ( isset( $value ) && true == $value ) ? true : false;
}

/**
 * Inject the Customizer-to-React bridge inline.
 * This ensures the logic is always loaded in the preview iframe.
 */
function vrt_customize_preview_js() {
    if ( ! is_customize_preview() ) return;
    ?>
    <script type="text/javascript">
    (function() {
        var checkLimit = 50; 
        var checkCount = 0;

        function initBridge() {
            var api = window.wp && window.wp.customize;
            if (!api) {
                if (checkCount < checkLimit) {
                    checkCount++;
                    setTimeout(initBridge, 100);
                }
                return;
            }

            console.log('[VRT Bridge] Initialized and connected to WordPress Customizer.');

            var pageShowToUrl = {
                'vrt_blog_show': '/blog',
                'vrt_about_show': '/about',
                'vrt_contact_show': '/contact',
                'vrt_services_show': '/services',
                'vrt_portfolio_show': '/portfolio',
                'vrt_pricing_show': '/pricing',
                'vrt_team_show': '/team',
                'vrt_faq_show': '/faq',
                'vrt_careers_show': '/careers',
                'vrt_testimonials_show': '/testimonials',
                'vrt_features_show': '/features',
                'vrt_privacy_show': '/privacy',
                'vrt_terms_show': '/terms'
            };

            function bindSetting(setting) {
                setting.bind(function(newVal) {
                    // Dispatch regular update to React
                    window.dispatchEvent(new CustomEvent('vrt_live_update', {
                        detail: { id: setting.id, value: newVal }
                    }));

                    // If a "Show in Navbar" toggle was turned ON, navigate to that page
                    if (pageShowToUrl[setting.id]) {
                        var isTruthy = newVal === true || newVal === '1' || newVal === 'true' || newVal === 1;
                        if (isTruthy) {
                            var targetUrl = pageShowToUrl[setting.id];
                            // Wait for React state update before navigating
                            setTimeout(function() {
                                window.dispatchEvent(new CustomEvent('vrt_request_navigate', {
                                    detail: { url: targetUrl }
                                }));
                            }, 300);
                            setTimeout(function() {
                                window.dispatchEvent(new CustomEvent('vrt_request_navigate', {
                                    detail: { url: targetUrl }
                                }));
                            }, 800);
                        }
                    }
                });

                // Specialized handling for Logo URL
                if (setting.id === 'custom_logo') {
                    setting.bind(function(id) {
                        var url = '';
                        if (id) {
                            var attachment = api.instance('custom_logo').attachment;
                            if (attachment) url = attachment.url;
                        }
                        window.dispatchEvent(new CustomEvent('vrt_live_update', {
                            detail: { id: 'custom_logo', value: url }
                        }));
                    });
                }
            }

            api.each(bindSetting);
            api.bind('add', bindSetting);
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initBridge);
        } else {
            initBridge();
        }
    })();
    </script>
    <?php
}
add_action( 'wp_footer', 'vrt_customize_preview_js', 99 );
add_action( 'customize_preview_init', function() {
    // Force postMessage for core settings
    add_action( 'customize_register', function( $wp_customize ) {
        $core = array( 'blogname', 'blogdescription', 'custom_logo' );
        foreach ( $core as $id ) {
            $setting = $wp_customize->get_setting( $id );
            if ( $setting ) $setting->transport = 'postMessage';
        }
    }, 999 );
} );
