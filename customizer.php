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
}

function vrt_customize_register( $wp_customize ) {

    // ── Panel ────────────────────────────────────────────────────────────────
    $wp_customize->add_panel( 'vrt_panel', array(
        'title' => __( 'Theme Options', 'vite-react-theme' ),
        'description' => __( 'Customize every section of your React SPA theme.', 'vite-react-theme' ),
        'priority' => 30,
    ) );

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
        'default' => 'Inter', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'refresh',
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

    $wp_customize->add_setting( 'vrt_navbar_style', array( 'default' => 'glass', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'refresh' ) );
    $wp_customize->add_control( 'vrt_navbar_style', array(
        'label' => __( 'Navbar Style', 'vite-react-theme' ), 'section' => 'vrt_navbar', 'type' => 'select',
        'choices' => array( 'solid' => 'Solid', 'transparent' => 'Transparent', 'glass' => 'Glassmorphism' ),
    ) );

    $wp_customize->add_setting( 'vrt_navbar_show_search', array( 'default' => true, 'sanitize_callback' => 'vrt_sanitize_checkbox', 'transport' => 'refresh' ) );
    $wp_customize->add_control( 'vrt_navbar_show_search', array( 'label' => __( 'Show Search Button', 'vite-react-theme' ), 'section' => 'vrt_navbar', 'type' => 'checkbox' ) );

    $wp_customize->add_setting( 'vrt_navbar_sticky', array( 'default' => true, 'sanitize_callback' => 'vrt_sanitize_checkbox', 'transport' => 'refresh' ) );
    $wp_customize->add_control( 'vrt_navbar_sticky', array( 'label' => __( 'Sticky Navbar', 'vite-react-theme' ), 'section' => 'vrt_navbar', 'type' => 'checkbox' ) );

    // ══════════════════════════════════════════════════════════════════════════
    // SECTION: Hero
    // ══════════════════════════════════════════════════════════════════════════
    $wp_customize->add_section( 'vrt_hero', array(
        'title' => __( 'Hero Section', 'vite-react-theme' ), 'panel' => 'vrt_panel', 'priority' => 20,
    ) );

    $wp_customize->add_setting( 'vrt_hero_show', array( 'default' => true, 'sanitize_callback' => 'vrt_sanitize_checkbox', 'transport' => 'refresh' ) );
    $wp_customize->add_control( 'vrt_hero_show', array( 'label' => __( 'Show Hero Section', 'vite-react-theme' ), 'section' => 'vrt_hero', 'type' => 'checkbox' ) );

    $wp_customize->add_setting( 'vrt_hero_bg_image', array( 'default' => '', 'sanitize_callback' => 'esc_url_raw', 'transport' => 'refresh' ) );
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
        $wp_customize->add_setting( $ctrl[0], array( 'default' => $ctrl[2], 'sanitize_callback' => $san, 'transport' => 'refresh' ) );
        $wp_customize->add_control( $ctrl[0], array( 'label' => __( $ctrl[1], 'vite-react-theme' ), 'section' => 'vrt_hero', 'type' => $ctrl[3] === 'textarea' ? 'textarea' : 'text' ) );
    }

    // ══════════════════════════════════════════════════════════════════════════
    // SECTION: Features
    // ══════════════════════════════════════════════════════════════════════════
    $wp_customize->add_section( 'vrt_features', array(
        'title' => __( 'Features Section', 'vite-react-theme' ), 'panel' => 'vrt_panel', 'priority' => 25,
    ) );

    $wp_customize->add_setting( 'vrt_features_show', array( 'default' => true, 'sanitize_callback' => 'vrt_sanitize_checkbox', 'transport' => 'refresh' ) );
    $wp_customize->add_control( 'vrt_features_show', array( 'label' => __( 'Show Features', 'vite-react-theme' ), 'section' => 'vrt_features', 'type' => 'checkbox' ) );

    foreach ( array(
        array( 'vrt_features_label', 'Section Label', 'Why Choose Us' ),
        array( 'vrt_features_title', 'Section Title', 'Powerful Features' ),
        array( 'vrt_features_subtitle', 'Subtitle', 'Everything you need to build modern, high-performance websites.' ),
    ) as $ctrl ) {
        $wp_customize->add_setting( $ctrl[0], array( 'default' => $ctrl[2], 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'refresh' ) );
        $wp_customize->add_control( $ctrl[0], array( 'label' => __( $ctrl[1], 'vite-react-theme' ), 'section' => 'vrt_features', 'type' => 'text' ) );
    }

    $wp_customize->add_setting( 'vrt_feature_count', array( 'default' => 6, 'sanitize_callback' => 'absint', 'transport' => 'refresh' ) );
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
        $wp_customize->add_setting( "vrt_feature_{$i}_icon", array( 'default' => $di[0], 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'refresh' ) );
        $wp_customize->add_control( "vrt_feature_{$i}_icon", array( 'label' => sprintf( 'Card %d — Icon/Emoji', $i ), 'section' => 'vrt_features', 'type' => 'text' ) );
        $wp_customize->add_setting( "vrt_feature_{$i}_title", array( 'default' => $di[1], 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'refresh' ) );
        $wp_customize->add_control( "vrt_feature_{$i}_title", array( 'label' => sprintf( 'Card %d — Title', $i ), 'section' => 'vrt_features', 'type' => 'text' ) );
        $wp_customize->add_setting( "vrt_feature_{$i}_desc", array( 'default' => $di[2], 'sanitize_callback' => 'sanitize_textarea_field', 'transport' => 'refresh' ) );
        $wp_customize->add_control( "vrt_feature_{$i}_desc", array( 'label' => sprintf( 'Card %d — Description', $i ), 'section' => 'vrt_features', 'type' => 'textarea' ) );
    }

    // ══════════════════════════════════════════════════════════════════════════
    // SECTION: Testimonials
    // ══════════════════════════════════════════════════════════════════════════
    $wp_customize->add_section( 'vrt_testimonials', array(
        'title' => __( 'Testimonials Section', 'vite-react-theme' ), 'panel' => 'vrt_panel', 'priority' => 28,
    ) );

    $wp_customize->add_setting( 'vrt_testimonials_show', array( 'default' => true, 'sanitize_callback' => 'vrt_sanitize_checkbox', 'transport' => 'refresh' ) );
    $wp_customize->add_control( 'vrt_testimonials_show', array( 'label' => __( 'Show Testimonials', 'vite-react-theme' ), 'section' => 'vrt_testimonials', 'type' => 'checkbox' ) );

    $wp_customize->add_setting( 'vrt_testimonials_title', array( 'default' => 'What People Say', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'refresh' ) );
    $wp_customize->add_control( 'vrt_testimonials_title', array( 'label' => __( 'Section Title', 'vite-react-theme' ), 'section' => 'vrt_testimonials', 'type' => 'text' ) );

    $wp_customize->add_setting( 'vrt_testimonials_subtitle', array( 'default' => 'Hear from developers and designers who love our theme.', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'refresh' ) );
    $wp_customize->add_control( 'vrt_testimonials_subtitle', array( 'label' => __( 'Subtitle', 'vite-react-theme' ), 'section' => 'vrt_testimonials', 'type' => 'text' ) );

    $testimonial_defaults = array(
        1 => array( 'Sarah Chen', 'Product Designer', 'This theme completely transformed our website.' ),
        2 => array( 'Marcus Rivera', 'Full Stack Developer', 'Finally a WordPress theme that feels like a modern React app.' ),
        3 => array( 'Emily Watson', 'Creative Director', 'Our clients are blown away by the design quality.' ),
        4 => array( "James O'Brien", 'Startup Founder', 'Best theme investment we ever made.' ),
    );

    for ( $i = 1; $i <= 6; $i++ ) {
        $d = isset( $testimonial_defaults[$i] ) ? $testimonial_defaults[$i] : array( '', '', '' );
        $wp_customize->add_setting( "vrt_testimonial_{$i}_name", array( 'default' => $d[0], 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'refresh' ) );
        $wp_customize->add_control( "vrt_testimonial_{$i}_name", array( 'label' => sprintf( 'Testimonial %d — Name', $i ), 'section' => 'vrt_testimonials', 'type' => 'text' ) );
        $wp_customize->add_setting( "vrt_testimonial_{$i}_role", array( 'default' => $d[1], 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'refresh' ) );
        $wp_customize->add_control( "vrt_testimonial_{$i}_role", array( 'label' => sprintf( 'Testimonial %d — Role', $i ), 'section' => 'vrt_testimonials', 'type' => 'text' ) );
        $wp_customize->add_setting( "vrt_testimonial_{$i}_quote", array( 'default' => $d[2], 'sanitize_callback' => 'sanitize_textarea_field', 'transport' => 'refresh' ) );
        $wp_customize->add_control( "vrt_testimonial_{$i}_quote", array( 'label' => sprintf( 'Testimonial %d — Quote', $i ), 'section' => 'vrt_testimonials', 'type' => 'textarea' ) );
    }

    // ══════════════════════════════════════════════════════════════════════════
    // SECTION: Stats Counter
    // ══════════════════════════════════════════════════════════════════════════
    $wp_customize->add_section( 'vrt_stats', array(
        'title' => __( 'Stats Counter', 'vite-react-theme' ), 'panel' => 'vrt_panel', 'priority' => 30,
    ) );

    $wp_customize->add_setting( 'vrt_stats_show', array( 'default' => true, 'sanitize_callback' => 'vrt_sanitize_checkbox', 'transport' => 'refresh' ) );
    $wp_customize->add_control( 'vrt_stats_show', array( 'label' => __( 'Show Stats Section', 'vite-react-theme' ), 'section' => 'vrt_stats', 'type' => 'checkbox' ) );

    $stat_defaults = array(
        1 => array( '🚀', '10K+', 'Active Users' ),
        2 => array( '⭐', '4.9', 'Average Rating' ),
        3 => array( '🌍', '50+', 'Countries' ),
        4 => array( '💬', '1M+', 'Posts Created' ),
    );

    for ( $i = 1; $i <= 4; $i++ ) {
        $d = $stat_defaults[$i];
        $wp_customize->add_setting( "vrt_stat_{$i}_icon", array( 'default' => $d[0], 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'refresh' ) );
        $wp_customize->add_control( "vrt_stat_{$i}_icon", array( 'label' => sprintf( 'Stat %d — Icon/Emoji', $i ), 'section' => 'vrt_stats', 'type' => 'text' ) );
        $wp_customize->add_setting( "vrt_stat_{$i}_number", array( 'default' => $d[1], 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'refresh' ) );
        $wp_customize->add_control( "vrt_stat_{$i}_number", array( 'label' => sprintf( 'Stat %d — Number', $i ), 'section' => 'vrt_stats', 'type' => 'text' ) );
        $wp_customize->add_setting( "vrt_stat_{$i}_label", array( 'default' => $d[2], 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'refresh' ) );
        $wp_customize->add_control( "vrt_stat_{$i}_label", array( 'label' => sprintf( 'Stat %d — Label', $i ), 'section' => 'vrt_stats', 'type' => 'text' ) );
    }

    // ══════════════════════════════════════════════════════════════════════════
    // SECTION: CTA
    // ══════════════════════════════════════════════════════════════════════════
    $wp_customize->add_section( 'vrt_cta', array(
        'title' => __( 'Call to Action Section', 'vite-react-theme' ), 'panel' => 'vrt_panel', 'priority' => 35,
    ) );

    $wp_customize->add_setting( 'vrt_cta_show', array( 'default' => true, 'sanitize_callback' => 'vrt_sanitize_checkbox', 'transport' => 'refresh' ) );
    $wp_customize->add_control( 'vrt_cta_show', array( 'label' => __( 'Show CTA Section', 'vite-react-theme' ), 'section' => 'vrt_cta', 'type' => 'checkbox' ) );

    foreach ( array(
        array( 'vrt_cta_title', 'CTA Title', 'Ready to get started?', 'text' ),
        array( 'vrt_cta_subtitle', 'CTA Subtitle', 'Join thousands of users building amazing websites with our theme.', 'textarea' ),
        array( 'vrt_cta_btn_text', 'Button Text', 'Get Started Free', 'text' ),
        array( 'vrt_cta_btn_url', 'Button URL', '#', 'url' ),
    ) as $ctrl ) {
        $san = $ctrl[3] === 'url' ? 'esc_url_raw' : ( $ctrl[3] === 'textarea' ? 'sanitize_textarea_field' : 'sanitize_text_field' );
        $wp_customize->add_setting( $ctrl[0], array( 'default' => $ctrl[2], 'sanitize_callback' => $san, 'transport' => 'refresh' ) );
        $wp_customize->add_control( $ctrl[0], array( 'label' => __( $ctrl[1], 'vite-react-theme' ), 'section' => 'vrt_cta', 'type' => $ctrl[3] === 'textarea' ? 'textarea' : 'text' ) );
    }

    // ══════════════════════════════════════════════════════════════════════════
    // SECTION: Blog / Posts
    // ══════════════════════════════════════════════════════════════════════════
    $wp_customize->add_section( 'vrt_posts', array(
        'title' => __( 'Blog Section', 'vite-react-theme' ), 'panel' => 'vrt_panel', 'priority' => 40,
    ) );

    $wp_customize->add_setting( 'vrt_posts_show', array( 'default' => true, 'sanitize_callback' => 'vrt_sanitize_checkbox', 'transport' => 'refresh' ) );
    $wp_customize->add_control( 'vrt_posts_show', array( 'label' => __( 'Show Blog Section', 'vite-react-theme' ), 'section' => 'vrt_posts', 'type' => 'checkbox' ) );

    $wp_customize->add_setting( 'vrt_posts_label', array( 'default' => 'Blog', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'refresh' ) );
    $wp_customize->add_control( 'vrt_posts_label', array( 'label' => __( 'Section Label', 'vite-react-theme' ), 'section' => 'vrt_posts', 'type' => 'text' ) );

    $wp_customize->add_setting( 'vrt_posts_title', array( 'default' => 'Latest Posts', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'refresh' ) );
    $wp_customize->add_control( 'vrt_posts_title', array( 'label' => __( 'Section Title', 'vite-react-theme' ), 'section' => 'vrt_posts', 'type' => 'text' ) );

    $wp_customize->add_setting( 'vrt_posts_layout', array( 'default' => 'grid', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'refresh' ) );
    $wp_customize->add_control( 'vrt_posts_layout', array(
        'label' => __( 'Blog Layout', 'vite-react-theme' ), 'section' => 'vrt_posts', 'type' => 'select',
        'choices' => array( 'grid' => 'Grid (Cards)', 'list' => 'List' ),
    ) );

    // ══════════════════════════════════════════════════════════════════════════
    // SECTION: Social Links
    // ══════════════════════════════════════════════════════════════════════════
    $wp_customize->add_section( 'vrt_social', array(
        'title' => __( 'Social Links', 'vite-react-theme' ), 'panel' => 'vrt_panel', 'priority' => 45,
    ) );

    foreach ( array( 'twitter' => 'Twitter / X', 'facebook' => 'Facebook', 'instagram' => 'Instagram', 'linkedin' => 'LinkedIn', 'github' => 'GitHub', 'youtube' => 'YouTube' ) as $key => $label ) {
        $wp_customize->add_setting( "vrt_social_{$key}", array( 'default' => '', 'sanitize_callback' => 'esc_url_raw', 'transport' => 'refresh' ) );
        $wp_customize->add_control( "vrt_social_{$key}", array( 'label' => $label . ' URL', 'section' => 'vrt_social', 'type' => 'url' ) );
    }

    // ══════════════════════════════════════════════════════════════════════════
    // SECTION: Footer
    // ══════════════════════════════════════════════════════════════════════════
    $wp_customize->add_section( 'vrt_footer', array(
        'title' => __( 'Footer', 'vite-react-theme' ), 'panel' => 'vrt_panel', 'priority' => 50,
    ) );

    $wp_customize->add_setting( 'vrt_footer_show', array( 'default' => true, 'sanitize_callback' => 'vrt_sanitize_checkbox', 'transport' => 'refresh' ) );
    $wp_customize->add_control( 'vrt_footer_show', array( 'label' => __( 'Show Footer', 'vite-react-theme' ), 'section' => 'vrt_footer', 'type' => 'checkbox' ) );

    for ( $c = 1; $c <= 3; $c++ ) {
        $defs = array( 1 => 'Product', 2 => 'Company', 3 => 'Legal' );
        $wp_customize->add_setting( "vrt_footer_col{$c}_title", array( 'default' => $defs[$c], 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'refresh' ) );
        $wp_customize->add_control( "vrt_footer_col{$c}_title", array( 'label' => sprintf( 'Column %d Heading', $c ), 'section' => 'vrt_footer', 'type' => 'text' ) );
    }

    $wp_customize->add_setting( 'vrt_footer_copyright', array( 'default' => '', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'refresh' ) );
    $wp_customize->add_control( 'vrt_footer_copyright', array( 'label' => __( 'Copyright Text', 'vite-react-theme' ), 'description' => __( 'Leave blank for default.', 'vite-react-theme' ), 'section' => 'vrt_footer', 'type' => 'text' ) );

    // ══════════════════════════════════════════════════════════════════════════
    // SECTION: Layout
    // ══════════════════════════════════════════════════════════════════════════
    $wp_customize->add_section( 'vrt_layout', array(
        'title' => __( 'Layout Settings', 'vite-react-theme' ), 'panel' => 'vrt_panel', 'priority' => 55,
    ) );

    $wp_customize->add_setting( 'vrt_layout_container_max', array( 'default' => 1200, 'sanitize_callback' => 'absint', 'transport' => 'refresh' ) );
    $wp_customize->add_control( new VRT_Number_Control( $wp_customize, 'vrt_layout_container_max', array(
        'label' => __( 'Container Max Width (px)', 'vite-react-theme' ), 'section' => 'vrt_layout', 'min' => 900, 'max' => 1600, 'step' => 50,
    ) ) );

    $wp_customize->add_setting( 'vrt_layout_sidebar_position', array( 'default' => 'right', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'refresh' ) );
    $wp_customize->add_control( 'vrt_layout_sidebar_position', array(
        'label' => __( 'Sidebar Position', 'vite-react-theme' ), 'section' => 'vrt_layout', 'type' => 'select',
        'choices' => array( 'right' => 'Right', 'left' => 'Left' ),
    ) );

    $wp_customize->add_setting( 'vrt_layout_blog_columns', array( 'default' => 3, 'sanitize_callback' => 'absint', 'transport' => 'refresh' ) );
    $wp_customize->add_control( new VRT_Number_Control( $wp_customize, 'vrt_layout_blog_columns', array(
        'label' => __( 'Blog Columns', 'vite-react-theme' ), 'section' => 'vrt_layout', 'min' => 2, 'max' => 4,
    ) ) );

    $wp_customize->add_setting( 'vrt_layout_card_radius', array( 'default' => 16, 'sanitize_callback' => 'absint', 'transport' => 'refresh' ) );
    $wp_customize->add_control( new VRT_Number_Control( $wp_customize, 'vrt_layout_card_radius', array(
        'label' => __( 'Card Border Radius (px)', 'vite-react-theme' ), 'section' => 'vrt_layout', 'min' => 0, 'max' => 32, 'step' => 2,
    ) ) );

    // ══════════════════════════════════════════════════════════════════════════
    // SECTION: Animations
    // ══════════════════════════════════════════════════════════════════════════
    $wp_customize->add_section( 'vrt_animations', array(
        'title' => __( 'Animations', 'vite-react-theme' ), 'panel' => 'vrt_panel', 'priority' => 60,
    ) );

    $wp_customize->add_setting( 'vrt_animations_enabled', array( 'default' => true, 'sanitize_callback' => 'vrt_sanitize_checkbox', 'transport' => 'refresh' ) );
    $wp_customize->add_control( 'vrt_animations_enabled', array( 'label' => __( 'Enable Animations', 'vite-react-theme' ), 'section' => 'vrt_animations', 'type' => 'checkbox' ) );

    $wp_customize->add_setting( 'vrt_animations_style', array( 'default' => 'fade-up', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'refresh' ) );
    $wp_customize->add_control( 'vrt_animations_style', array(
        'label' => __( 'Default Animation Style', 'vite-react-theme' ), 'section' => 'vrt_animations', 'type' => 'select',
        'choices' => array(
            'fade-up' => 'Fade Up', 'fade-in' => 'Fade In',
            'slide-left' => 'Slide Left', 'slide-right' => 'Slide Right',
            'zoom-in' => 'Zoom In', 'flip' => 'Flip',
        ),
    ) );

    $wp_customize->add_setting( 'vrt_animations_speed', array( 'default' => 'normal', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'refresh' ) );
    $wp_customize->add_control( 'vrt_animations_speed', array(
        'label' => __( 'Animation Speed', 'vite-react-theme' ), 'section' => 'vrt_animations', 'type' => 'select',
        'choices' => array( 'slow' => 'Slow', 'normal' => 'Normal', 'fast' => 'Fast' ),
    ) );

    $wp_customize->add_setting( 'vrt_animations_stagger', array( 'default' => 80, 'sanitize_callback' => 'absint', 'transport' => 'refresh' ) );
    $wp_customize->add_control( new VRT_Number_Control( $wp_customize, 'vrt_animations_stagger', array(
        'label' => __( 'Stagger Delay (ms)', 'vite-react-theme' ), 'section' => 'vrt_animations', 'min' => 0, 'max' => 300, 'step' => 10,
    ) ) );

    // ══════════════════════════════════════════════════════════════════════════
    // SECTION: 404 Page
    // ══════════════════════════════════════════════════════════════════════════
    $wp_customize->add_section( 'vrt_404', array(
        'title' => __( '404 Page', 'vite-react-theme' ), 'panel' => 'vrt_panel', 'priority' => 65,
    ) );

    $wp_customize->add_setting( 'vrt_404_title', array( 'default' => 'Page Not Found', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'refresh' ) );
    $wp_customize->add_control( 'vrt_404_title', array( 'label' => __( '404 Title', 'vite-react-theme' ), 'section' => 'vrt_404', 'type' => 'text' ) );

    $wp_customize->add_setting( 'vrt_404_message', array( 'default' => "The page you're looking for doesn't exist or has been moved.", 'sanitize_callback' => 'sanitize_textarea_field', 'transport' => 'refresh' ) );
    $wp_customize->add_control( 'vrt_404_message', array( 'label' => __( '404 Message', 'vite-react-theme' ), 'section' => 'vrt_404', 'type' => 'textarea' ) );

    $wp_customize->add_setting( 'vrt_404_show_search', array( 'default' => true, 'sanitize_callback' => 'vrt_sanitize_checkbox', 'transport' => 'refresh' ) );
    $wp_customize->add_control( 'vrt_404_show_search', array( 'label' => __( 'Show Search Bar', 'vite-react-theme' ), 'section' => 'vrt_404', 'type' => 'checkbox' ) );
}
add_action( 'customize_register', 'vrt_customize_register' );

function vrt_sanitize_checkbox( $value ) {
    return ( isset( $value ) && true == $value ) ? true : false;
}

function vrt_customize_preview_js() {
    wp_enqueue_script( 'vrt-customizer-preview', get_template_directory_uri() . '/customizer-preview.js', array( 'customize-preview' ), VRT_VERSION, true );
}
add_action( 'customize_preview_init', 'vrt_customize_preview_js' );
