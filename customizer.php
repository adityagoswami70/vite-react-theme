<?php
/**
 * Vite React Theme — Customizer
 * Extended: Typography, Hero Image, CTA Section, Social Links, Layout
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
        'description' => __( 'Customize every section of your theme.', 'vite-react-theme' ),
        'priority' => 30,
    ) );

    // ══════════════════════════════════════════════════════════════════════════
    // SECTION: Brand Colors
    // ══════════════════════════════════════════════════════════════════════════
    $wp_customize->add_section( 'vrt_colors', array(
        'title' => __( 'Brand Colors', 'vite-react-theme' ), 'panel' => 'vrt_panel', 'priority' => 10,
    ) );

    $colors = array(
        'vrt_color_primary'        => array( 'Primary Color', '#4f46e5' ),
        'vrt_color_primary_hover'  => array( 'Primary Hover', '#4338ca' ),
        'vrt_color_bg'             => array( 'Background', '#ffffff' ),
        'vrt_color_bg_alt'         => array( 'Alt Background (Sections)', '#f8fafc' ),
        'vrt_color_surface'        => array( 'Surface / Cards', '#ffffff' ),
        'vrt_color_text'           => array( 'Text Color', '#1e293b' ),
        'vrt_color_text_secondary' => array( 'Text Secondary', '#64748b' ),
        'vrt_color_border'         => array( 'Border Color', '#e2e8f0' ),
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
    // SECTION: Hero
    // ══════════════════════════════════════════════════════════════════════════
    $wp_customize->add_section( 'vrt_hero', array(
        'title' => __( 'Hero Section', 'vite-react-theme' ), 'panel' => 'vrt_panel', 'priority' => 20,
    ) );

    // Show
    $wp_customize->add_setting( 'vrt_hero_show', array( 'default' => true, 'sanitize_callback' => 'vrt_sanitize_checkbox', 'transport' => 'refresh' ) );
    $wp_customize->add_control( 'vrt_hero_show', array( 'label' => __( 'Show Hero Section', 'vite-react-theme' ), 'section' => 'vrt_hero', 'type' => 'checkbox' ) );

    // Background image
    $wp_customize->add_setting( 'vrt_hero_bg_image', array( 'default' => '', 'sanitize_callback' => 'esc_url_raw', 'transport' => 'refresh' ) );
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'vrt_hero_bg_image', array(
        'label' => __( 'Hero Background Image', 'vite-react-theme' ), 'section' => 'vrt_hero', 'description' => __( 'Optional. Overrides the default gradient.', 'vite-react-theme' ),
    ) ) );

    // Badge
    $wp_customize->add_setting( 'vrt_hero_badge', array( 'default' => '✨ Welcome to the future', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'postMessage' ) );
    $wp_customize->add_control( 'vrt_hero_badge', array( 'label' => __( 'Badge Text', 'vite-react-theme' ), 'section' => 'vrt_hero', 'type' => 'text' ) );

    // Title
    $wp_customize->add_setting( 'vrt_hero_title', array( 'default' => 'Build Something Amazing', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'postMessage' ) );
    $wp_customize->add_control( 'vrt_hero_title', array( 'label' => __( 'Hero Title', 'vite-react-theme' ), 'section' => 'vrt_hero', 'type' => 'text' ) );

    // Subtitle
    $wp_customize->add_setting( 'vrt_hero_subtitle', array( 'default' => 'A modern WordPress theme with clean design, powerful customization, and drag-and-drop section management.', 'sanitize_callback' => 'sanitize_textarea_field', 'transport' => 'postMessage' ) );
    $wp_customize->add_control( 'vrt_hero_subtitle', array( 'label' => __( 'Hero Subtitle', 'vite-react-theme' ), 'section' => 'vrt_hero', 'type' => 'textarea' ) );

    // Buttons
    foreach ( array(
        array( 'vrt_hero_btn1_text', 'Primary Button Text', 'Get Started', 'text' ),
        array( 'vrt_hero_btn1_url', 'Primary Button URL', '#features', 'url' ),
        array( 'vrt_hero_btn2_text', 'Secondary Button Text', 'Learn More', 'text' ),
        array( 'vrt_hero_btn2_url', 'Secondary Button URL', '#latest-posts', 'url' ),
    ) as $ctrl ) {
        $wp_customize->add_setting( $ctrl[0], array( 'default' => $ctrl[2], 'sanitize_callback' => $ctrl[3] === 'url' ? 'esc_url_raw' : 'sanitize_text_field', 'transport' => 'postMessage' ) );
        $wp_customize->add_control( $ctrl[0], array( 'label' => __( $ctrl[1], 'vite-react-theme' ), 'section' => 'vrt_hero', 'type' => $ctrl[3] ) );
    }

    // ══════════════════════════════════════════════════════════════════════════
    // SECTION: Features
    // ══════════════════════════════════════════════════════════════════════════
    $wp_customize->add_section( 'vrt_features', array(
        'title' => __( 'Features Section', 'vite-react-theme' ), 'panel' => 'vrt_panel', 'priority' => 30,
    ) );

    $wp_customize->add_setting( 'vrt_features_show', array( 'default' => true, 'sanitize_callback' => 'vrt_sanitize_checkbox', 'transport' => 'refresh' ) );
    $wp_customize->add_control( 'vrt_features_show', array( 'label' => __( 'Show Features', 'vite-react-theme' ), 'section' => 'vrt_features', 'type' => 'checkbox' ) );

    foreach ( array(
        array( 'vrt_features_label', 'Section Label', 'Why Choose Us' ),
        array( 'vrt_features_title', 'Section Title', 'Powerful Features' ),
        array( 'vrt_features_subtitle', 'Subtitle', 'Everything you need to build modern, high-performance websites.' ),
    ) as $ctrl ) {
        $wp_customize->add_setting( $ctrl[0], array( 'default' => $ctrl[2], 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'postMessage' ) );
        $wp_customize->add_control( $ctrl[0], array( 'label' => __( $ctrl[1], 'vite-react-theme' ), 'section' => 'vrt_features', 'type' => 'text' ) );
    }

    // Card count
    $wp_customize->add_setting( 'vrt_feature_count', array( 'default' => 3, 'sanitize_callback' => 'absint', 'transport' => 'refresh' ) );
    $wp_customize->add_control( new VRT_Number_Control( $wp_customize, 'vrt_feature_count', array(
        'label' => __( 'Number of Cards (1–12)', 'vite-react-theme' ), 'description' => __( 'Add up to 12 feature cards.', 'vite-react-theme' ), 'section' => 'vrt_features', 'min' => 1, 'max' => 12,
    ) ) );

    // Dynamic cards
    $defaults = array(
        1 => array( '⚡', 'Lightning Fast', 'Vite-powered builds with instant hot module replacement.' ),
        2 => array( '🎨', 'Beautiful Design', 'Clean, professional aesthetics with refined typography.' ),
        3 => array( '📱', 'Fully Responsive', 'Looks perfect on every device — mobile, tablet, desktop.' ),
        4 => array( '🔒', 'Secure & Reliable', 'Built with WordPress best practices for security.' ),
        5 => array( '🚀', 'SEO Optimized', 'Semantic HTML and fast load times for higher ranking.' ),
        6 => array( '🎯', 'Customizable', 'Change everything from the WordPress Customizer.' ),
    );

    for ( $i = 1; $i <= 12; $i++ ) {
        $di = isset( $defaults[$i] ) ? $defaults[$i] : array( '✦', 'Feature ' . $i, 'Describe this feature.' );
        $wp_customize->add_setting( "vrt_feature_{$i}_icon", array( 'default' => $di[0], 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'postMessage' ) );
        $wp_customize->add_control( "vrt_feature_{$i}_icon", array( 'label' => sprintf( 'Card %d — Icon', $i ), 'section' => 'vrt_features', 'type' => 'text' ) );
        $wp_customize->add_setting( "vrt_feature_{$i}_title", array( 'default' => $di[1], 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'postMessage' ) );
        $wp_customize->add_control( "vrt_feature_{$i}_title", array( 'label' => sprintf( 'Card %d — Title', $i ), 'section' => 'vrt_features', 'type' => 'text' ) );
        $wp_customize->add_setting( "vrt_feature_{$i}_desc", array( 'default' => $di[2], 'sanitize_callback' => 'sanitize_textarea_field', 'transport' => 'postMessage' ) );
        $wp_customize->add_control( "vrt_feature_{$i}_desc", array( 'label' => sprintf( 'Card %d — Description', $i ), 'section' => 'vrt_features', 'type' => 'textarea' ) );
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
        $wp_customize->add_setting( $ctrl[0], array( 'default' => $ctrl[2], 'sanitize_callback' => $ctrl[3] === 'url' ? 'esc_url_raw' : ( $ctrl[3] === 'textarea' ? 'sanitize_textarea_field' : 'sanitize_text_field' ), 'transport' => 'postMessage' ) );
        $wp_customize->add_control( $ctrl[0], array( 'label' => __( $ctrl[1], 'vite-react-theme' ), 'section' => 'vrt_cta', 'type' => $ctrl[3] ) );
    }

    // ══════════════════════════════════════════════════════════════════════════
    // SECTION: Blog / Posts
    // ══════════════════════════════════════════════════════════════════════════
    $wp_customize->add_section( 'vrt_posts', array(
        'title' => __( 'Blog Section', 'vite-react-theme' ), 'panel' => 'vrt_panel', 'priority' => 40,
    ) );

    $wp_customize->add_setting( 'vrt_posts_show', array( 'default' => true, 'sanitize_callback' => 'vrt_sanitize_checkbox', 'transport' => 'refresh' ) );
    $wp_customize->add_control( 'vrt_posts_show', array( 'label' => __( 'Show Blog Section', 'vite-react-theme' ), 'section' => 'vrt_posts', 'type' => 'checkbox' ) );

    $wp_customize->add_setting( 'vrt_posts_label', array( 'default' => 'Blog', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'postMessage' ) );
    $wp_customize->add_control( 'vrt_posts_label', array( 'label' => __( 'Section Label', 'vite-react-theme' ), 'section' => 'vrt_posts', 'type' => 'text' ) );

    $wp_customize->add_setting( 'vrt_posts_title', array( 'default' => 'Latest Posts', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'postMessage' ) );
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
        $wp_customize->add_setting( "vrt_footer_col{$c}_title", array( 'default' => $defs[$c], 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'postMessage' ) );
        $wp_customize->add_control( "vrt_footer_col{$c}_title", array( 'label' => sprintf( 'Column %d Heading', $c ), 'section' => 'vrt_footer', 'type' => 'text' ) );
    }

    $wp_customize->add_setting( 'vrt_footer_copyright', array( 'default' => '', 'sanitize_callback' => 'sanitize_text_field', 'transport' => 'postMessage' ) );
    $wp_customize->add_control( 'vrt_footer_copyright', array( 'label' => __( 'Copyright Text', 'vite-react-theme' ), 'description' => __( 'Leave blank for default.', 'vite-react-theme' ), 'section' => 'vrt_footer', 'type' => 'text' ) );
}
add_action( 'customize_register', 'vrt_customize_register' );

function vrt_sanitize_checkbox( $value ) {
    return ( isset( $value ) && true == $value ) ? true : false;
}

function vrt_customize_preview_js() {
    wp_enqueue_script( 'vrt-customizer-preview', get_template_directory_uri() . '/customizer-preview.js', array( 'customize-preview' ), VRT_VERSION, true );
}
add_action( 'customize_preview_init', 'vrt_customize_preview_js' );
