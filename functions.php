<?php
/**
 * Vite React Theme — functions and definitions
 *
 * @package ViteReactTheme
 * @version 3.0.0
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
    add_theme_support( 'custom-background', array( 'default-color' => 'ffffff' ) );

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

    wp_enqueue_style( 'vrt-base', get_stylesheet_uri(), array(), VRT_VERSION );
    wp_enqueue_style( 'vrt-styles', $theme_uri . '/styles.css', array( 'vrt-base' ), VRT_VERSION );

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
}
add_action( 'wp_enqueue_scripts', 'vrt_scripts' );

function vrt_script_type_module( $tag, $handle ) {
    if ( in_array( $handle, array( 'vite-client', 'vite-react-main', 'vrt-admin-app' ), true ) ) {
        return str_replace( ' src=', ' type="module" src=', $tag );
    }
    return $tag;
}
add_filter( 'script_loader_tag', 'vrt_script_type_module', 10, 2 );

// ──────────────────────────────────────────────────────────────────────────────
// 4. Customizer CSS
// ──────────────────────────────────────────────────────────────────────────────
function vrt_customizer_css() {
    $primary       = get_theme_mod( 'vrt_color_primary', '#4f46e5' );
    $primary_hover = get_theme_mod( 'vrt_color_primary_hover', '#4338ca' );
    $bg            = get_theme_mod( 'vrt_color_bg', '#ffffff' );
    $bg_alt        = get_theme_mod( 'vrt_color_bg_alt', '#f8fafc' );
    $surface       = get_theme_mod( 'vrt_color_surface', '#ffffff' );
    $text          = get_theme_mod( 'vrt_color_text', '#1e293b' );
    $text_sec      = get_theme_mod( 'vrt_color_text_secondary', '#64748b' );
    $border        = get_theme_mod( 'vrt_color_border', '#e2e8f0' );
    $font          = get_theme_mod( 'vrt_font_family', 'Inter' );
    $font_size     = get_theme_mod( 'vrt_font_size', '16' );

    list( $r, $g, $b ) = sscanf( $primary, '#%02x%02x%02x' );

    echo '<style id="vrt-customizer-css">
:root {
  --color-primary: ' . esc_attr( $primary ) . ';
  --color-primary-hover: ' . esc_attr( $primary_hover ) . ';
  --color-primary-light: ' . esc_attr( $primary ) . '10;
  --color-primary-glow: rgba(' . intval($r) . ',' . intval($g) . ',' . intval($b) . ', 0.15);
  --color-bg: ' . esc_attr( $bg ) . ';
  --color-bg-alt: ' . esc_attr( $bg_alt ) . ';
  --color-surface: ' . esc_attr( $surface ) . ';
  --color-text: ' . esc_attr( $text ) . ';
  --color-text-secondary: ' . esc_attr( $text_sec ) . ';
  --color-border: ' . esc_attr( $border ) . ';
  --font-sans: "' . esc_attr( $font ) . '", system-ui, -apple-system, sans-serif;
}
html { font-size: ' . intval( $font_size ) . 'px; }
body { background: var(--color-bg); color: var(--color-text); }
</style>';
}
add_action( 'wp_head', 'vrt_customizer_css', 100 );

// ──────────────────────────────────────────────────────────────────────────────
// 5. Include Customizer
// ──────────────────────────────────────────────────────────────────────────────
require_once get_template_directory() . '/customizer.php';

// ──────────────────────────────────────────────────────────────────────────────
// 6. Admin Page — Section Manager (Drag & Drop)
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
// 7. Helpers
// ──────────────────────────────────────────────────────────────────────────────
function vrt_get_feature_count() {
    return intval( get_theme_mod( 'vrt_feature_count', 3 ) );
}

function vrt_get_section_order() {
    $saved = get_option( 'vrt_section_order', '' );
    $default = array(
        array( 'id' => 'hero', 'enabled' => true ),
        array( 'id' => 'features', 'enabled' => true ),
        array( 'id' => 'posts', 'enabled' => true ),
        array( 'id' => 'cta', 'enabled' => true ),
    );

    if ( ! $saved ) return $default;

    $parsed = json_decode( $saved, true );
    return is_array( $parsed ) ? $parsed : $default;
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
