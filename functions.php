<?php
/**
 * Vite React Theme — functions and definitions
 *
 * @package ViteReactTheme
 * @version 4.0.0
 */

define( 'VRT_VERSION', wp_get_theme()->get( 'Version' ) );
define( 'IS_VITE_DEVELOPMENT', true );

// ──────────────────────────────────────────────────────────────────────────────
// 1. Theme Setup
// ──────────────────────────────────────────────────────────────────────────────
function vrt_setup() {
    add_theme_support( 'title-tag' );
    add_theme_support( 'custom-logo', array(
        'height' => 60, 'width' => 200, 'flex-height' => true, 'flex-width' => true,
    ) );
    add_theme_support( 'post-thumbnails' );
    set_post_thumbnail_size( 720, 400, true );
    add_theme_support( 'html5', array(
        'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script',
    ) );
    add_theme_support( 'automatic-feed-links' );
    add_theme_support( 'custom-background', array( 'default-color' => '0a0a0f' ) );

    register_nav_menus( array(
        'primary'  => __( 'Primary Menu (Header)', 'vite-react-theme' ),
        'footer-1' => __( 'Footer Column 1', 'vite-react-theme' ),
        'footer-2' => __( 'Footer Column 2', 'vite-react-theme' ),
        'footer-3' => __( 'Footer Column 3', 'vite-react-theme' ),
    ) );
}
add_action( 'after_setup_theme', 'vrt_setup' );

// ──────────────────────────────────────────────────────────────────────────────
// 2. Widget Areas
// ──────────────────────────────────────────────────────────────────────────────
function vrt_widgets_init() {
    register_sidebar( array(
        'name' => __( 'Main Sidebar', 'vite-react-theme' ), 'id' => 'sidebar-1',
        'description' => __( 'Drag widgets here for the blog sidebar.', 'vite-react-theme' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">', 'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title">', 'after_title' => '</h3>',
    ) );
    register_sidebar( array(
        'name' => __( 'Footer Widgets', 'vite-react-theme' ), 'id' => 'footer-widgets',
        'description' => __( 'Drag widgets here for the footer area.', 'vite-react-theme' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">', 'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title">', 'after_title' => '</h3>',
    ) );
}
add_action( 'widgets_init', 'vrt_widgets_init' );

// ──────────────────────────────────────────────────────────────────────────────
// 3. Enqueue Styles & Scripts
// ──────────────────────────────────────────────────────────────────────────────
function vrt_scripts() {
    $theme_uri = get_template_directory_uri();
    $theme_dir = get_template_directory();

    if ( IS_VITE_DEVELOPMENT ) {
        wp_enqueue_script( 'vite-client', 'http://localhost:5173/@vite/client', array(), null );
        wp_enqueue_script( 'vite-react-main', 'http://localhost:5173/src/main.jsx', array( 'vite-client' ), null );
    } else {
        $manifest_path = $theme_dir . '/dist/.vite/manifest.json';
        if ( file_exists( $manifest_path ) ) {
            $manifest = json_decode( file_get_contents( $manifest_path ), true );
            if ( isset( $manifest['src/main.jsx'] ) ) {
                $js = $manifest['src/main.jsx']['file'];
                wp_enqueue_script( 'vite-react-main', $theme_uri . '/dist/' . $js, array(), null, true );
                if ( isset( $manifest['src/main.jsx']['css'] ) ) {
                    foreach ( $manifest['src/main.jsx']['css'] as $i => $css ) {
                        wp_enqueue_style( 'vite-react-style-' . $i, $theme_uri . '/dist/' . $css, array(), null );
                    }
                }
            }
        }
    }

    // Pass all theme data to React
    wp_localize_script( IS_VITE_DEVELOPMENT ? 'vite-react-main' : 'vite-react-main', 'VRT_DATA', vrt_get_theme_data() );
}
add_action( 'wp_enqueue_scripts', 'vrt_scripts' );

function vrt_script_type_module( $tag, $handle ) {
    if ( in_array( $handle, array( 'vite-client', 'vite-react-main', 'vrt-admin-app' ), true ) ) {
        $tag = str_replace( ' src=', ' type="module" src=', $tag );
    }
    // Inject React Fast Refresh preamble before main.jsx in dev mode
    if ( IS_VITE_DEVELOPMENT && $handle === 'vite-react-main' ) {
        $preamble = '<script type="module">
import RefreshRuntime from "http://localhost:5173/@react-refresh"
RefreshRuntime.injectIntoGlobalHook(window)
window.$RefreshReg$ = () => {}
window.$RefreshSig$ = () => (type) => type
window.__vite_plugin_react_preamble_installed__ = true
</script>' . "\n";
        $tag = $preamble . $tag;
    }
    return $tag;
}
add_filter( 'script_loader_tag', 'vrt_script_type_module', 10, 2 );

// ──────────────────────────────────────────────────────────────────────────────
// 4. Theme Data for React (wp_localize_script)
// ──────────────────────────────────────────────────────────────────────────────
function vrt_get_theme_data() {
    $logo_id  = get_theme_mod( 'custom_logo' );
    $logo_url = $logo_id ? wp_get_attachment_image_url( $logo_id, 'full' ) : '';

    // Parse WordPress root-relative URL for SPA base
    $home_path = wp_parse_url( home_url(), PHP_URL_PATH );
    $base_url  = $home_path ? trailingslashit( $home_path ) : '/';

    return array(
        'siteInfo' => array(
            'name'        => get_bloginfo( 'name' ),
            'description' => get_bloginfo( 'description' ),
            'url'         => home_url( '/' ),
            'logoUrl'     => $logo_url,
            'baseUrl'     => $base_url,
        ),
        'restUrl' => esc_url_raw( rest_url( 'wp/v2' ) ),
        'nonce'   => wp_create_nonce( 'wp_rest' ),
        'menus'   => array(
            'primary' => vrt_get_menu_items( 'primary' ),
            'footer1' => vrt_get_menu_items( 'footer-1' ),
            'footer2' => vrt_get_menu_items( 'footer-2' ),
            'footer3' => vrt_get_menu_items( 'footer-3' ),
        ),
        'hero' => array(
            'show'     => (bool) get_theme_mod( 'vrt_hero_show', true ),
            'badge'    => get_theme_mod( 'vrt_hero_badge', '✨ Welcome to the future' ),
            'title'    => get_theme_mod( 'vrt_hero_title', 'Build Something Amazing' ),
            'subtitle' => get_theme_mod( 'vrt_hero_subtitle', 'A modern WordPress theme with clean design, powerful customization, and stunning animations.' ),
            'btn1Text' => get_theme_mod( 'vrt_hero_btn1_text', 'Get Started' ),
            'btn1Url'  => get_theme_mod( 'vrt_hero_btn1_url', '#features' ),
            'btn2Text' => get_theme_mod( 'vrt_hero_btn2_text', 'Learn More' ),
            'btn2Url'  => get_theme_mod( 'vrt_hero_btn2_url', '#latest-posts' ),
            'bgImage'  => get_theme_mod( 'vrt_hero_bg_image', '' ),
        ),
        'features' => vrt_get_features_data(),
        'testimonials' => vrt_get_testimonials_data(),
        'stats' => vrt_get_stats_data(),
        'cta' => array(
            'show'    => (bool) get_theme_mod( 'vrt_cta_show', true ),
            'title'   => get_theme_mod( 'vrt_cta_title', 'Ready to get started?' ),
            'subtitle'=> get_theme_mod( 'vrt_cta_subtitle', 'Join thousands of users building amazing websites with our theme.' ),
            'btnText' => get_theme_mod( 'vrt_cta_btn_text', 'Get Started Free' ),
            'btnUrl'  => get_theme_mod( 'vrt_cta_btn_url', '#' ),
        ),
        'posts' => array(
            'show'   => (bool) get_theme_mod( 'vrt_posts_show', true ),
            'label'  => get_theme_mod( 'vrt_posts_label', 'Blog' ),
            'title'  => get_theme_mod( 'vrt_posts_title', 'Latest Posts' ),
            'layout' => get_theme_mod( 'vrt_posts_layout', 'grid' ),
        ),
        'social' => array(
            'twitter'   => get_theme_mod( 'vrt_social_twitter', '' ),
            'facebook'  => get_theme_mod( 'vrt_social_facebook', '' ),
            'instagram' => get_theme_mod( 'vrt_social_instagram', '' ),
            'linkedin'  => get_theme_mod( 'vrt_social_linkedin', '' ),
            'github'    => get_theme_mod( 'vrt_social_github', '' ),
            'youtube'   => get_theme_mod( 'vrt_social_youtube', '' ),
        ),
        'footer' => array(
            'show'      => (bool) get_theme_mod( 'vrt_footer_show', true ),
            'col1Title' => get_theme_mod( 'vrt_footer_col1_title', 'Product' ),
            'col2Title' => get_theme_mod( 'vrt_footer_col2_title', 'Company' ),
            'col3Title' => get_theme_mod( 'vrt_footer_col3_title', 'Legal' ),
            'copyright' => get_theme_mod( 'vrt_footer_copyright', '' ),
        ),
        'navbar' => array(
            'style'      => get_theme_mod( 'vrt_navbar_style', 'glass' ),
            'showSearch' => (bool) get_theme_mod( 'vrt_navbar_show_search', true ),
            'sticky'     => (bool) get_theme_mod( 'vrt_navbar_sticky', true ),
        ),
        'layout' => array(
            'containerMax'   => intval( get_theme_mod( 'vrt_layout_container_max', 1200 ) ),
            'sidebarPosition'=> get_theme_mod( 'vrt_layout_sidebar_position', 'right' ),
            'blogColumns'    => intval( get_theme_mod( 'vrt_layout_blog_columns', 3 ) ),
            'cardRadius'     => intval( get_theme_mod( 'vrt_layout_card_radius', 16 ) ),
        ),
        'animations' => array(
            'enabled'      => (bool) get_theme_mod( 'vrt_animations_enabled', true ),
            'style'        => get_theme_mod( 'vrt_animations_style', 'fade-up' ),
            'speed'        => get_theme_mod( 'vrt_animations_speed', 'normal' ),
            'staggerDelay' => intval( get_theme_mod( 'vrt_animations_stagger', 80 ) ),
        ),
        'notFound' => array(
            'title'      => get_theme_mod( 'vrt_404_title', 'Page Not Found' ),
            'message'    => get_theme_mod( 'vrt_404_message', "The page you're looking for doesn't exist or has been moved." ),
            'showSearch' => (bool) get_theme_mod( 'vrt_404_show_search', true ),
        ),
        'sectionOrder' => vrt_get_section_order(),
    );
}

// ──────────────────────────────────────────────────────────────────────────────
// 5. Menu Helper
// ──────────────────────────────────────────────────────────────────────────────
function vrt_get_menu_items( $location ) {
    $locations = get_nav_menu_locations();
    if ( empty( $locations[ $location ] ) ) return array();

    $menu = wp_get_nav_menu_items( $locations[ $location ] );
    if ( ! $menu ) return array();

    $home_url = home_url();
    $result = array();
    foreach ( $menu as $item ) {
        // Convert absolute URLs to relative paths for React Router
        $url = $item->url;
        if ( strpos( $url, $home_url ) === 0 ) {
            $url = substr( $url, strlen( $home_url ) );
            if ( empty( $url ) ) $url = '/';
        }
        $result[] = array(
            'title' => $item->title,
            'url'   => $url,
        );
    }
    return $result;
}

// ──────────────────────────────────────────────────────────────────────────────
// 6. Feature Data Helper
// ──────────────────────────────────────────────────────────────────────────────
function vrt_get_features_data() {
    $count = intval( get_theme_mod( 'vrt_feature_count', 6 ) );
    $defaults = array(
        1 => array( '⚡', 'Lightning Fast', 'Vite-powered builds with instant hot module replacement.' ),
        2 => array( '🎨', 'Beautiful Design', 'Clean, professional aesthetics with refined typography.' ),
        3 => array( '📱', 'Fully Responsive', 'Looks perfect on every device — mobile, tablet, desktop.' ),
        4 => array( '🔒', 'Secure & Reliable', 'Built with WordPress best practices for security.' ),
        5 => array( '🚀', 'SEO Optimized', 'Semantic HTML and fast load times for higher ranking.' ),
        6 => array( '🎯', 'Customizable', 'Change everything from the WordPress Customizer.' ),
    );

    $items = array();
    for ( $i = 1; $i <= $count; $i++ ) {
        $d = isset( $defaults[ $i ] ) ? $defaults[ $i ] : array( '✦', 'Feature ' . $i, 'Describe this feature.' );
        $items[] = array(
            'icon'  => get_theme_mod( "vrt_feature_{$i}_icon", $d[0] ),
            'title' => get_theme_mod( "vrt_feature_{$i}_title", $d[1] ),
            'desc'  => get_theme_mod( "vrt_feature_{$i}_desc", $d[2] ),
        );
    }

    return array(
        'show'     => (bool) get_theme_mod( 'vrt_features_show', true ),
        'label'    => get_theme_mod( 'vrt_features_label', 'Why Choose Us' ),
        'title'    => get_theme_mod( 'vrt_features_title', 'Powerful Features' ),
        'subtitle' => get_theme_mod( 'vrt_features_subtitle', 'Everything you need to build modern, high-performance websites.' ),
        'count'    => $count,
        'items'    => $items,
    );
}

// ──────────────────────────────────────────────────────────────────────────────
// 7. Testimonial Data Helper
// ──────────────────────────────────────────────────────────────────────────────
function vrt_get_testimonials_data() {
    $defaults = array(
        1 => array( 'Sarah Chen', 'Product Designer', 'This theme completely transformed our website. The animations are buttery smooth and the customizer options are incredible.' ),
        2 => array( 'Marcus Rivera', 'Full Stack Developer', 'Finally a WordPress theme that feels like a modern React app. The code quality is outstanding.' ),
        3 => array( 'Emily Watson', 'Creative Director', 'Our clients are blown away by the design quality. It looks like a custom-built site but takes minutes to set up.' ),
        4 => array( "James O'Brien", 'Startup Founder', 'Best theme investment we ever made. The performance scores are through the roof.' ),
    );

    $items = array();
    for ( $i = 1; $i <= 6; $i++ ) {
        $d = isset( $defaults[ $i ] ) ? $defaults[ $i ] : array( 'User ' . $i, 'Role', 'Testimonial text...' );
        $name  = get_theme_mod( "vrt_testimonial_{$i}_name", $d[0] );
        $role  = get_theme_mod( "vrt_testimonial_{$i}_role", $d[1] );
        $quote = get_theme_mod( "vrt_testimonial_{$i}_quote", $d[2] );

        if ( empty( $name ) && $i > 4 ) continue; // Skip empty extra slots

        $initials = implode( '', array_map( function($w) { return mb_substr($w, 0, 1); }, explode( ' ', $name ) ) );
        $items[] = array(
            'name'     => $name,
            'role'     => $role,
            'quote'    => $quote,
            'initials' => strtoupper( $initials ),
        );
    }

    return array(
        'show'     => (bool) get_theme_mod( 'vrt_testimonials_show', true ),
        'title'    => get_theme_mod( 'vrt_testimonials_title', 'What People Say' ),
        'subtitle' => get_theme_mod( 'vrt_testimonials_subtitle', 'Hear from developers and designers who love our theme.' ),
        'items'    => $items,
    );
}

// ──────────────────────────────────────────────────────────────────────────────
// 8. Stats Data Helper
// ──────────────────────────────────────────────────────────────────────────────
function vrt_get_stats_data() {
    $defaults = array(
        1 => array( '🚀', '10K+', 'Active Users' ),
        2 => array( '⭐', '4.9', 'Average Rating' ),
        3 => array( '🌍', '50+', 'Countries' ),
        4 => array( '💬', '1M+', 'Posts Created' ),
    );

    $items = array();
    for ( $i = 1; $i <= 4; $i++ ) {
        $d = $defaults[ $i ];
        $items[] = array(
            'icon'   => get_theme_mod( "vrt_stat_{$i}_icon", $d[0] ),
            'number' => get_theme_mod( "vrt_stat_{$i}_number", $d[1] ),
            'label'  => get_theme_mod( "vrt_stat_{$i}_label", $d[2] ),
        );
    }

    return array(
        'show'  => (bool) get_theme_mod( 'vrt_stats_show', true ),
        'items' => $items,
    );
}

// ──────────────────────────────────────────────────────────────────────────────
// 9. Include Customizer
// ──────────────────────────────────────────────────────────────────────────────
require_once get_template_directory() . '/customizer.php';

// ──────────────────────────────────────────────────────────────────────────────
// 10. Admin Page — Section Manager (Drag & Drop)
// ──────────────────────────────────────────────────────────────────────────────
function vrt_admin_menu() {
    add_theme_page(
        __( 'Section Manager', 'vite-react-theme' ),
        __( 'Section Manager', 'vite-react-theme' ),
        'edit_theme_options',
        'vrt-section-manager',
        'vrt_admin_page_render'
    );
}
add_action( 'admin_menu', 'vrt_admin_menu' );

function vrt_admin_page_render() {
    $order = get_option( 'vrt_section_order', '' );
    ?>
    <div class="wrap">
        <h1><?php esc_html_e( 'Section Manager', 'vite-react-theme' ); ?></h1>
        <p class="description"><?php esc_html_e( 'Drag and drop to reorder your homepage sections. Toggle sections on/off.', 'vite-react-theme' ); ?></p>
        <div id="vrt-admin-app"
             data-section-order="<?php echo esc_attr( $order ); ?>"
             data-nonce="<?php echo esc_attr( wp_create_nonce( 'vrt_section_order' ) ); ?>"
             data-ajax-url="<?php echo esc_attr( admin_url( 'admin-ajax.php' ) ); ?>"
             style="margin-top: 20px;"></div>
    </div>
    <?php
}

function vrt_admin_scripts( $hook ) {
    if ( $hook !== 'appearance_page_vrt-section-manager' ) return;

    if ( IS_VITE_DEVELOPMENT ) {
        wp_enqueue_script( 'vite-client', 'http://localhost:5173/@vite/client', array(), null );
        wp_enqueue_script( 'vrt-admin-app', 'http://localhost:5173/src/admin.jsx', array( 'vite-client' ), null );
    } else {
        $theme_dir = get_template_directory();
        $theme_uri = get_template_directory_uri();
        $manifest_path = $theme_dir . '/dist/.vite/manifest.json';
        if ( file_exists( $manifest_path ) ) {
            $manifest = json_decode( file_get_contents( $manifest_path ), true );
            if ( isset( $manifest['src/admin.jsx'] ) ) {
                $js = $manifest['src/admin.jsx']['file'];
                wp_enqueue_script( 'vrt-admin-app', $theme_uri . '/dist/' . $js, array(), null, true );
                if ( isset( $manifest['src/admin.jsx']['css'] ) ) {
                    foreach ( $manifest['src/admin.jsx']['css'] as $i => $css ) {
                        wp_enqueue_style( 'vrt-admin-style-' . $i, $theme_uri . '/dist/' . $css, array(), null );
                    }
                }
            }
        }
    }
}
add_action( 'admin_enqueue_scripts', 'vrt_admin_scripts' );

// AJAX handler for saving section order
function vrt_save_section_order() {
    check_ajax_referer( 'vrt_section_order', 'nonce' );

    if ( ! current_user_can( 'edit_theme_options' ) ) {
        wp_send_json_error( 'Unauthorized' );
    }

    $order = sanitize_text_field( wp_unslash( $_POST['section_order'] ?? '' ) );
    update_option( 'vrt_section_order', $order );
    wp_send_json_success();
}
add_action( 'wp_ajax_vrt_save_section_order', 'vrt_save_section_order' );

// ──────────────────────────────────────────────────────────────────────────────
// 11. Section Order Helper
// ──────────────────────────────────────────────────────────────────────────────
function vrt_get_section_order() {
    $saved = get_option( 'vrt_section_order', '' );
    $default = array(
        array( 'id' => 'hero', 'enabled' => true ),
        array( 'id' => 'features', 'enabled' => true ),
        array( 'id' => 'stats', 'enabled' => true ),
        array( 'id' => 'testimonials', 'enabled' => true ),
        array( 'id' => 'posts', 'enabled' => true ),
        array( 'id' => 'cta', 'enabled' => true ),
    );

    if ( ! $saved ) return $default;

    $parsed = json_decode( $saved, true );
    return is_array( $parsed ) ? $parsed : $default;
}

// ──────────────────────────────────────────────────────────────────────────────
// 12. SPA Catch-All Rewrite
// ──────────────────────────────────────────────────────────────────────────────
function vrt_rewrite_rules() {
    // Let WordPress API and admin work normally
    // Route all other front-end requests to index.php for the SPA
    add_rewrite_rule( '^blog/?$', 'index.php', 'top' );
    add_rewrite_rule( '^blog/([^/]+)/?$', 'index.php', 'top' );
    add_rewrite_rule( '^about/?$', 'index.php', 'top' );
    add_rewrite_rule( '^contact/?$', 'index.php', 'top' );
    add_rewrite_rule( '^search/?$', 'index.php', 'top' );
    add_rewrite_rule( '^page/([^/]+)/?$', 'index.php', 'top' );
}
add_action( 'init', 'vrt_rewrite_rules' );

// Flush rewrite rules on theme activation
function vrt_activate() {
    vrt_rewrite_rules();
    flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'vrt_activate' );

// ──────────────────────────────────────────────────────────────────────────────
// 13. Allow REST API for comments without auth
// ──────────────────────────────────────────────────────────────────────────────
function vrt_allow_anonymous_comments( $result ) {
    // Allow unauthenticated REST API access (needed for frontend to fetch posts/pages)
    // Comment posting is handled by WordPress core's own auth checks
    return $result;
}
add_filter( 'rest_authentication_errors', 'vrt_allow_anonymous_comments', 10, 1 );

// ──────────────────────────────────────────────────────────────────────────────
// 14. Misc Helpers
// ──────────────────────────────────────────────────────────────────────────────
function vrt_get_feature_count() {
    return intval( get_theme_mod( 'vrt_feature_count', 6 ) );
}

function vrt_primary_menu_fallback() {
    echo '<ul class="menu">';
    echo '<li><a href="' . esc_url( home_url( '/' ) ) . '">Home</a></li>';
    wp_list_pages( array( 'title_li' => '', 'depth' => 1 ) );
    echo '</ul>';
}

function vrt_excerpt_length( $length ) { return 20; }
add_filter( 'excerpt_length', 'vrt_excerpt_length' );

function vrt_excerpt_more( $more ) { return '&hellip;'; }
add_filter( 'excerpt_more', 'vrt_excerpt_more' );

// Dynamically enqueue Google Fonts based on Customizer selection
function vrt_enqueue_google_font() {
    $font = get_theme_mod( 'vrt_font_family', 'Inter' );
    if ( $font && $font !== 'system-ui' ) {
        $font_slug = str_replace( ' ', '+', $font );
        wp_enqueue_style( 'vrt-google-font', "https://fonts.googleapis.com/css2?family={$font_slug}:wght@300;400;500;600;700;800&display=swap", array(), null );
    }
}
add_action( 'wp_enqueue_scripts', 'vrt_enqueue_google_font' );
