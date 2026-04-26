<?php
/**
 * Vite React Theme â€” functions and definitions
 *
 * @package ViteReactTheme
 * @version 4.0.0
 */

define( 'VRT_VERSION', wp_get_theme()->get( 'Version' ) );
define( 'IS_VITE_DEVELOPMENT', true );

// â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
// 1. Theme Setup
// â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
function vrt_setup() {
    add_theme_support( 'title-tag' );
    add_theme_support( 'custom-logo', array(
        'height' => 60, 'width' => 200, 'flex-height' => false, 'flex-width' => false,
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

// â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
// 2. Widget Areas
// â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
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

// â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
// 3. Enqueue Styles & Scripts
// â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
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
    wp_localize_script( 'vite-react-main', 'VRT_DATA', vrt_get_theme_data() );
}
add_action( 'wp_enqueue_scripts', 'vrt_scripts' );

function vrt_script_type_module( $tag, $handle ) {
    if ( in_array( $handle, array( 'vite-client', 'vite-react-main', 'vrt-admin-app', 'vrt-customizer-app' ), true ) ) {
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

// â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
// 4. Theme Data for React (wp_localize_script)
// â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
function vrt_get_theme_data() {
    $logo_id  = get_theme_mod( 'custom_logo' );
    $logo_url = $logo_id ? wp_get_attachment_image_url( $logo_id, 'custom-logo' ) : '';

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
        'colors' => array(
            'primary'        => get_theme_mod( 'vrt_color_primary', '#6366f1' ),
            'primaryHover'   => get_theme_mod( 'vrt_color_primary_hover', '#4f46e5' ),
            'bg'             => get_theme_mod( 'vrt_color_bg', '#0a0a0f' ),
            'bgAlt'          => get_theme_mod( 'vrt_color_bg_alt', '#111119' ),
            'surface'        => get_theme_mod( 'vrt_color_surface', '#16161f' ),
            'text'           => get_theme_mod( 'vrt_color_text', '#f0f0f5' ),
            'textSecondary'  => get_theme_mod( 'vrt_color_text_secondary', '#9ca3b0' ),
            'border'         => get_theme_mod( 'vrt_color_border', '#2a2a3a' ),
        ),
        'typography' => array(
            'fontFamily' => get_theme_mod( 'vrt_font_family', 'Inter' ),
            'fontSize'   => intval( get_theme_mod( 'vrt_font_size', 16 ) ),
        ),
        'menus'   => array(
            'primary' => vrt_get_menu_items( 'primary' ),
            'footer1' => vrt_get_menu_items( 'footer-1' ),
            'footer2' => vrt_get_menu_items( 'footer-2' ),
            'footer3' => vrt_get_menu_items( 'footer-3' ),
        ),
        'hero' => array(
            'show'     => (bool) get_theme_mod( 'vrt_hero_show', true ),
            'badge'    => get_theme_mod( 'vrt_hero_badge', 'âœ¨ Welcome to the future' ),
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
            'bgColor' => get_theme_mod( 'vrt_cta_bg_color', '' ),
            'textColor'=> get_theme_mod( 'vrt_cta_text_color', '' ),
        ),
        'posts' => array(
            'show'   => (bool) get_theme_mod( 'vrt_posts_show', true ),
            'label'  => get_theme_mod( 'vrt_posts_label', 'Blog' ),
            'title'  => get_theme_mod( 'vrt_posts_title', 'Latest Posts' ),
            'layout' => get_theme_mod( 'vrt_posts_layout', 'grid' ),
        ),
        'social' => array(
            'show'      => (bool) get_theme_mod( 'vrt_social_show', true ),
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
            'show'        => (bool) get_theme_mod( 'vrt_navbar_show', true ),
            'style'       => get_theme_mod( 'vrt_navbar_style', 'glass' ),
            'showSearch'  => (bool) get_theme_mod( 'vrt_navbar_show_search', true ),
            'sticky'      => (bool) get_theme_mod( 'vrt_navbar_sticky', true ),
            'logoHeight'  => intval( get_theme_mod( 'vrt_navbar_logo_height', 32 ) ),
            'brandTitle'  => get_theme_mod( 'vrt_navbar_brand_title', '' ),
            'previewText' => get_theme_mod( 'vrt_navbar_preview_text', '' ),
            'links'       => vrt_get_navbar_links(),
            'manualLinks' => json_decode(get_theme_mod('vrt_theme_navbar_links', '[]'), true),
        ),
        'blog' => array(
            'show'        => (bool) get_theme_mod( 'vrt_blog_show', false ),
            'heroShow'    => (bool) get_theme_mod( 'vrt_blog_hero_show', true ),
            'heroTitle'   => get_theme_mod( 'vrt_blog_hero_title', 'Blog' ),
            'heroSubtitle'=> get_theme_mod( 'vrt_blog_hero_subtitle', 'Stories, tips, and insights from our team' ),
            'sidebarShow' => (bool) get_theme_mod( 'vrt_blog_sidebar_show', true ),
            'perPage'     => intval( get_theme_mod( 'vrt_blog_per_page', 9 ) ),
            'card'        => array(
                'showImage'    => (bool) get_theme_mod( 'vrt_blog_card_show_image', true ),
                'showDate'     => (bool) get_theme_mod( 'vrt_blog_card_show_date', true ),
                'showCategory' => (bool) get_theme_mod( 'vrt_blog_card_show_category', true ),
                'showExcerpt'  => (bool) get_theme_mod( 'vrt_blog_card_show_excerpt', true ),
                'readMoreText' => get_theme_mod( 'vrt_blog_card_read_more', 'Read more' ),
                'excerptLength'=> intval( get_theme_mod( 'vrt_blog_card_excerpt_length', 25 ) ),
            ),
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
        'about' => vrt_get_about_data(),
        'contact' => vrt_get_contact_data(),
        'pages' => vrt_get_pages_data(),
    );
}

// ──────────────────────────────────────────────────────────────────────────────
// Helper Functions for Navbar & Extra Pages
// ──────────────────────────────────────────────────────────────────────────────
function vrt_get_navbar_links() {
    $links = array();
    
    // 1. Check for pages toggled "ON" in their respective sections
    $toggled_pages = array(
        'blog'      => array( 
            'title' => get_theme_mod('vrt_blog_nav_title') ?: get_theme_mod('vrt_blog_hero_title', 'Blog'), 
            'url'   => '/blog' 
        ),
        'about'     => array( 
            'title' => get_theme_mod('vrt_about_nav_title') ?: get_theme_mod('vrt_about_hero_title', 'About'), 
            'url'   => '/about' 
        ),
        'contact'   => array( 
            'title' => get_theme_mod('vrt_contact_nav_title') ?: get_theme_mod('vrt_contact_hero_title', 'Contact'), 
            'url'   => '/contact' 
        ),
    );

    foreach ( $toggled_pages as $slug => $data ) {
        if ( get_theme_mod( "vrt_{$slug}_show", false ) ) {
            $links[] = $data;
        }
    }

    // Extra pages from the loop
    $extra_pages = array(
        'services' => 'Services',
        'portfolio' => 'Portfolio',
        'pricing' => 'Pricing',
        'team' => 'Team',
        'faq' => 'FAQ',
        'careers' => 'Careers',
        'testimonials' => 'Testimonials',
        'features' => 'Features',
        'privacy' => 'Privacy',
        'terms' => 'Terms',
    );
    foreach ( $extra_pages as $slug => $short_title ) {
        if ( get_theme_mod( "vrt_{$slug}_show", false ) ) {
            $nav_title = get_theme_mod( "vrt_{$slug}_nav_title", '' );
            $links[] = array(
                'title' => $nav_title ?: get_theme_mod( "vrt_{$slug}_title", $short_title ),
                'url'   => '/' . $slug
            );
        }
    }

    // 2. Get manually saved links
    $saved = get_theme_mod( 'vrt_theme_navbar_links', '' );
    $manual_links = array();
    if ( $saved ) {
        $parsed = json_decode( $saved, true );
        if ( is_array( $parsed ) ) {
            $manual_links = $parsed;
        }
    }

    // 3. Merge and remove duplicates by URL
    $final_links = array();
    $seen_urls = array();

    // ENSURE HOME IS ALWAYS THERE (if not present)
    $home_present = false;
    foreach($manual_links as $l) if($l['url'] === '/') $home_present = true;
    if (!$home_present) {
        $final_links[] = array( 'title' => 'Home', 'url' => '/' );
        $seen_urls[] = '/';
    }

    // Prioritize manual links for order
    foreach ( $manual_links as $link ) {
        if ( ! in_array( $link['url'], $seen_urls ) ) {
            $final_links[] = $link;
            $seen_urls[] = $link['url'];
        }
    }

    foreach ( $links as $link ) {
        if ( ! in_array( $link['url'], $seen_urls ) ) {
            $final_links[] = $link;
            $seen_urls[] = $link['url'];
        }
    }

    return $final_links;
}

function vrt_get_pages_data() {
    $slugs = array('services', 'portfolio', 'pricing', 'team', 'faq', 'careers', 'testimonials', 'features', 'privacy', 'terms');
    $data = array();
    foreach ($slugs as $slug) {
        $data[$slug] = array(
            'show'     => (bool) get_theme_mod( "vrt_{$slug}_show", false ),
            'title'    => get_theme_mod( "vrt_{$slug}_title", ucfirst($slug) ),
            'navTitle' => get_theme_mod( "vrt_{$slug}_nav_title", '' ),
            'subtitle' => get_theme_mod( "vrt_{$slug}_subtitle", '' ),
        );

        // ── Services cards ─────────────────────────────────────────────────
        if ( $slug === 'services' ) {
            $defs = array(
                1 => array( '💻', 'Web Development', 'Custom tailored modern websites built with React and WordPress.' ),
                2 => array( '🎨', 'UI/UX Design', 'Beautiful, user-centric interfaces focused on conversion and aesthetics.' ),
                3 => array( '🚀', 'SEO Optimization', 'Higher rankings through structural optimizations and sematic HTML.' ),
                4 => array( '📈', 'Marketing', 'Data-driven marketing strategies to grow your brand organically.' ),
                5 => array( '💡', 'Consulting', 'Expert guidance on tech stacks, architectures, and scaling systems.' ),
                6 => array( '🛒', 'E-Commerce', 'Secure, high-performance online stores that drive real sales.' ),
            );
            for ( $ci = 1; $ci <= 6; $ci++ ) {
                $cd = $defs[$ci];
                $data['services']["card{$ci}Icon"]  = get_theme_mod( "vrt_services_card{$ci}_icon",  $cd[0] );
                $data['services']["card{$ci}Title"] = get_theme_mod( "vrt_services_card{$ci}_title", $cd[1] );
                $data['services']["card{$ci}Desc"]  = get_theme_mod( "vrt_services_card{$ci}_desc",  $cd[2] );
            }
        }

        // ── Portfolio cards ────────────────────────────────────────────────
        if ( $slug === 'portfolio' ) {
            $defs = array(
                1 => array( 'Nova E-Commerce',  'Web Development', 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&q=80&w=800' ),
                2 => array( 'Nexus App',        'Product Design',  'https://images.unsplash.com/photo-1551288049-bebda4e38f71?auto=format&fit=crop&q=80&w=800' ),
                3 => array( 'Aura Branding',    'Identity',        'https://images.unsplash.com/photo-1542744173-8e7e53415bb0?auto=format&fit=crop&q=80&w=800' ),
                4 => array( 'Apex Analytics',   'SaaS Platform',   'https://images.unsplash.com/photo-1504868584819-f8e8b4b6d7e3?auto=format&fit=crop&q=80&w=800' ),
                5 => array( 'Zenith Studio',    'Web Design',      'https://images.unsplash.com/photo-1498050108023-c5249f4df085?auto=format&fit=crop&q=80&w=800' ),
                6 => array( 'Lumina Health',    'App Development', 'https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?auto=format&fit=crop&q=80&w=800' ),
            );
            for ( $ci = 1; $ci <= 6; $ci++ ) {
                $cd = $defs[$ci];
                $data['portfolio']["card{$ci}Title"]    = get_theme_mod( "vrt_portfolio_card{$ci}_title",    $cd[0] );
                $data['portfolio']["card{$ci}Category"] = get_theme_mod( "vrt_portfolio_card{$ci}_category", $cd[1] );
                $data['portfolio']["card{$ci}Img"]      = get_theme_mod( "vrt_portfolio_card{$ci}_img",      $cd[2] );
            }
        }

        // ── Testimonials reviews ───────────────────────────────────────────
        if ( $slug === 'testimonials' ) {
            $defs = array(
                1 => array( 'John Doe',    'TechCorp',       'An absolutely phenomenal experience from start to finish. The team is incredibly talented.', '5' ),
                2 => array( 'Jane Smith',  'DesignCo',       'Our conversion rates doubled after implementing their solutions. Highly recommended!',        '5' ),
                3 => array( 'Mike Johnson','Startup Inc',    'Fast, responsive, and beautifully designed. Worth every penny.',                              '4' ),
                4 => array( 'Emily Davis', 'Global LLC',     'The support team goes above and beyond. We feel truly valued as customers.',                  '5' ),
                5 => array( 'Chris Lee',   'Creative Studio','A game changer for our agency. It streamlined our entire workflow.',                          '5' ),
                6 => array( 'Sarah Wilson','Media Group',    'Very impressive attention to detail. The final product exceeded our expectations.',            '4' ),
            );
            for ( $ci = 1; $ci <= 6; $ci++ ) {
                $cd = $defs[$ci];
                $data['testimonials']["card{$ci}Name"]    = get_theme_mod( "vrt_testimonials_card{$ci}_name",    $cd[0] );
                $data['testimonials']["card{$ci}Company"] = get_theme_mod( "vrt_testimonials_card{$ci}_company", $cd[1] );
                $data['testimonials']["card{$ci}Text"]    = get_theme_mod( "vrt_testimonials_card{$ci}_text",    $cd[2] );
                $data['testimonials']["card{$ci}Rating"]  = get_theme_mod( "vrt_testimonials_card{$ci}_rating",  $cd[3] );
            }
        }

        // ── Pricing tiers ──────────────────────────────────────────────────
        if ( $slug === 'pricing' ) {
            $defs = array(
                1 => array( 'Starter',      '$29',  '/mo', 'Perfect for small businesses starting their digital journey.',       '1 Project, Basic Analytics, 24-hour Support, 1GB Storage', 'Get Starter' ),
                2 => array( 'Professional', '$79',  '/mo', 'Ideal for growing companies needing advanced capabilities.',         '5 Projects, Advanced Analytics, Priority Support, 10GB Storage, Custom Domains', 'Get Professional' ),
                3 => array( 'Enterprise',   '$199', '/mo', 'Dedicated solutions for large-scale operations.',                   'Unlimited Projects, Custom Reporting, 24/7 Dedicated Support, Unlimited Storage, API Access, SLA Guarantee', 'Contact Sales' ),
            );
            for ( $ci = 1; $ci <= 3; $ci++ ) {
                $cd = $defs[$ci];
                $data['pricing']["tier{$ci}Title"]    = get_theme_mod( "vrt_pricing_tier{$ci}_title",    $cd[0] );
                $data['pricing']["tier{$ci}Price"]    = get_theme_mod( "vrt_pricing_tier{$ci}_price",    $cd[1] );
                $data['pricing']["tier{$ci}Period"]   = get_theme_mod( "vrt_pricing_tier{$ci}_period",   $cd[2] );
                $data['pricing']["tier{$ci}Desc"]     = get_theme_mod( "vrt_pricing_tier{$ci}_desc",     $cd[3] );
                $data['pricing']["tier{$ci}Features"] = get_theme_mod( "vrt_pricing_tier{$ci}_features", $cd[4] );
                $data['pricing']["tier{$ci}Btn"]      = get_theme_mod( "vrt_pricing_tier{$ci}_btn",      $cd[5] );
            }
        }

        // ── FAQ items ──────────────────────────────────────────────────────
        if ( $slug === 'faq' ) {
            $defs = array(
                1 => array( 'How does the 30-day money-back guarantee work?',       'If you are not entirely satisfied with our service, you can cancel within 30 days for a full refund, no questions asked.' ),
                2 => array( 'Do you offer technical support?',                       'Yes, our team provides 24/7 technical support for all Enterprise clients, and standard business-hours support for Pro and Starter tiers.' ),
                3 => array( 'Can I upgrade my plan later?',                          'Absolutely. You can upgrade or downgrade your plan at any time through your account dashboard. Prorated charges will apply.' ),
                4 => array( 'What payment methods do you accept?',                   'We accept all major credit cards, PayPal, and wire transfers for annual Enterprise billing.' ),
                5 => array( 'Is there a setup fee?',                                 'No, there are no hidden setup fees for Starter or Pro plans. Enterprise plans may incur setup fees depending on customization scope.' ),
            );
            for ( $ci = 1; $ci <= 5; $ci++ ) {
                $cd = $defs[$ci];
                $data['faq']["item{$ci}Q"] = get_theme_mod( "vrt_faq_item{$ci}_q", $cd[0] );
                $data['faq']["item{$ci}A"] = get_theme_mod( "vrt_faq_item{$ci}_a", $cd[1] );
            }
        }

        // ── Careers jobs ───────────────────────────────────────────────────
        if ( $slug === 'careers' ) {
            $data['careers']['applyBtnText'] = get_theme_mod( 'vrt_careers_apply_btn', 'Apply Now' );
            $defs = array(
                1 => array( 'Senior Frontend Engineer',   'Engineering', 'Remote',           'Full-time' ),
                2 => array( 'Product Designer',           'Design',      'San Francisco, CA', 'Full-time' ),
                3 => array( 'Backend Developer',          'Engineering', 'Remote',           'Contract' ),
                4 => array( 'Marketing Manager',          'Marketing',   'New York, NY',     'Full-time' ),
                5 => array( 'Customer Success Specialist','Support',     'Remote',           'Full-time' ),
            );
            for ( $ci = 1; $ci <= 5; $ci++ ) {
                $cd = $defs[$ci];
                $data['careers']["job{$ci}Title"] = get_theme_mod( "vrt_careers_job{$ci}_title", $cd[0] );
                $data['careers']["job{$ci}Dept"]  = get_theme_mod( "vrt_careers_job{$ci}_dept",  $cd[1] );
                $data['careers']["job{$ci}Loc"]   = get_theme_mod( "vrt_careers_job{$ci}_loc",   $cd[2] );
                $data['careers']["job{$ci}Type"]  = get_theme_mod( "vrt_careers_job{$ci}_type",  $cd[3] );
            }
        }

        // ── Team page members ──────────────────────────────────────────────
        if ( $slug === 'team' ) {
            $defs = array(
                1 => array( 'Alex Harper',  'CEO & Founder',   'https://images.unsplash.com/photo-1560250097-0b93528c311a?auto=format&fit=crop&q=80&w=400' ),
                2 => array( 'Sarah Chen',   'CTO',             'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&q=80&w=400' ),
                3 => array( 'Michael Ross', 'Lead Designer',   'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?auto=format&fit=crop&q=80&w=400' ),
                4 => array( 'Emma Wilson',  'Head of Growth',  'https://images.unsplash.com/photo-1580489944761-15a19d654956?auto=format&fit=crop&q=80&w=400' ),
                5 => array( 'David Kim',    'Senior Engineer', 'https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?auto=format&fit=crop&q=80&w=400' ),
                6 => array( 'Lisa Ray',     'Product Manager', 'https://images.unsplash.com/photo-1598550874175-4d0ef43ce418?auto=format&fit=crop&q=80&w=400' ),
            );
            for ( $ci = 1; $ci <= 6; $ci++ ) {
                $cd = $defs[$ci];
                $data['team']["member{$ci}Name"] = get_theme_mod( "vrt_team_page_member{$ci}_name", $cd[0] );
                $data['team']["member{$ci}Role"] = get_theme_mod( "vrt_team_page_member{$ci}_role", $cd[1] );
                $data['team']["member{$ci}Img"]  = get_theme_mod( "vrt_team_page_member{$ci}_img",  $cd[2] );
            }
        }

        // ── Features page items ────────────────────────────────────────────
        if ( $slug === 'features' ) {
            $defs = array(
                1 => array( '⚡', 'Lightning Fast Performance', 'Built on Vite, experiencing zero-latency loads and absolute peak core web vitals.' ),
                2 => array( '🔒', 'Bank-Grade Security',        'End-to-end encryption with advanced CSRF and XSS protection built-in by default.' ),
                3 => array( '🔗', 'Seamless Integrations',      'Connect easily to your favorite tools via our native webhooks and REST APIs.' ),
                4 => array( '📈', 'Real-time Analytics',        'Watch your traffic grow with up-to-the-second dashboard metrics and reporting.' ),
                5 => array( '💾', 'Automated Backups',          'Never lose your data. We perform hourly snapshots securely stored in the cloud.' ),
                6 => array( '🌐', 'Global CDN',                 'Your assets are cached worldwide ensuring millisecond delivery anywhere.' ),
            );
            for ( $ci = 1; $ci <= 6; $ci++ ) {
                $cd = $defs[$ci];
                $data['features']["card{$ci}Icon"]  = get_theme_mod( "vrt_features_page_card{$ci}_icon",  $cd[0] );
                $data['features']["card{$ci}Title"] = get_theme_mod( "vrt_features_page_card{$ci}_title", $cd[1] );
                $data['features']["card{$ci}Desc"]  = get_theme_mod( "vrt_features_page_card{$ci}_desc",  $cd[2] );
            }
        }
    }
    return $data;
}


// â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
// Helper Functions for About & Contact
// â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
function vrt_get_about_data() {
    $team = array();
    for ($i = 1; $i <= 4; $i++) {
        $name = get_theme_mod( "vrt_team_{$i}_name", '' );
        if ($name) {
            $team[] = array(
                'name' => $name,
                'role' => get_theme_mod( "vrt_team_{$i}_role", '' ),
                'emoji' => get_theme_mod( "vrt_team_{$i}_emoji", '' ),
            );
        }
    }
    if (empty($team)) {
        $team = array(
            array('name' => 'Alex Morgan', 'role' => 'CEO & Founder', 'emoji' => 'ðŸ‘¨â€ðŸ’»'),
            array('name' => 'Sarah Chen', 'role' => 'Lead Designer', 'emoji' => 'ðŸŽ¨'),
            array('name' => 'Marcus Rivera', 'role' => 'CTO', 'emoji' => 'âš™ï¸'),
            array('name' => 'Emily Watson', 'role' => 'Head of Marketing', 'emoji' => 'ðŸ“ˆ'),
        );
    }
    
    $timeline = array();
    for ($i = 1; $i <= 4; $i++) {
        $year = get_theme_mod( "vrt_timeline_{$i}_year", '' );
        if ($year) {
            $timeline[] = array(
                'year' => $year,
                'title' => get_theme_mod( "vrt_timeline_{$i}_title", '' ),
                'desc' => get_theme_mod( "vrt_timeline_{$i}_desc", '' ),
            );
        }
    }
    if (empty($timeline)) {
        $timeline = array(
            array('year' => '2024', 'title' => 'Company Founded', 'desc' => 'Started with a vision to create the best WordPress themes.'),
            array('year' => '2024', 'title' => 'First 1K Users', 'desc' => 'Reached our first thousand active users within 3 months.'),
            array('year' => '2025', 'title' => 'React Integration', 'desc' => 'Pioneered React-powered WordPress themes with Vite.'),
            array('year' => '2026', 'title' => '10K+ Users', 'desc' => 'Growing community of developers and designers worldwide.'),
        );
    }

    return array(
        'show' => (bool) get_theme_mod( 'vrt_about_show', false ),
        'hero' => array(
            'title' => get_theme_mod('vrt_about_hero_title', 'About Us'),
            'subtitle' => get_theme_mod('vrt_about_hero_subtitle', "We're building the future of WordPress themes with React, animations, and unmatched customization.")
        ),
        'story' => array(
            get_theme_mod('vrt_about_story1', 'We started with a simple idea: WordPress themes should be as modern as the rest of the web. Too many themes are stuck in the past â€” slow, rigid, and hard to customize. We set out to change that.'),
            get_theme_mod('vrt_about_story2', 'Our team combines deep expertise in React, WordPress, and modern web design to create themes that are fast, beautiful, and endlessly customizable. Every pixel is crafted, every animation is smooth, and every line of code is clean.'),
            get_theme_mod('vrt_about_story3', 'Today, we serve thousands of developers and businesses worldwide, helping them build websites that truly stand out.')
        ),
        'teamLabel' => get_theme_mod('vrt_about_team_label', 'Our Team'),
        'teamTitle' => get_theme_mod('vrt_about_team_title', 'Meet the Makers'),
        'team' => $team,
        'timelineLabel' => get_theme_mod('vrt_about_timeline_label', 'Our Journey'),
        'timelineTitle' => get_theme_mod('vrt_about_timeline_title', 'Milestones'),
        'timeline' => $timeline
    );
}

function vrt_get_contact_data() {
    $info = array();
    for ($i = 1; $i <= 4; $i++) {
        $icon = get_theme_mod( "vrt_contact_{$i}_icon", '' );
        if ($icon) {
            $info[] = array(
                'icon' => $icon,
                'label' => get_theme_mod( "vrt_contact_{$i}_label", '' ),
                'value' => get_theme_mod( "vrt_contact_{$i}_value", '' ),
            );
        }
    }
    if (empty($info)) {
        $info = array(
            array('icon' => 'ðŸ“§', 'label' => 'Email', 'value' => 'hello@example.com'),
            array('icon' => 'ðŸ“±', 'label' => 'Phone', 'value' => '+1 (555) 123-4567'),
            array('icon' => 'ðŸ“', 'label' => 'Location', 'value' => 'San Francisco, CA'),
            array('icon' => 'â°', 'label' => 'Hours', 'value' => 'Monâ€“Fri, 9AMâ€“6PM PST'),
        );
    }
    return array(
        'show' => (bool) get_theme_mod( 'vrt_contact_show', false ),
        'hero' => array(
            'title' => get_theme_mod('vrt_contact_hero_title', 'Get in Touch'),
            'subtitle' => get_theme_mod('vrt_contact_hero_subtitle', "Have a question or want to work together? We'd love to hear from you.")
        ),
        'info' => $info,
        'formTitle' => get_theme_mod('vrt_contact_form_title', 'Send us a message')
    );
}

// â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
// 5. Menu Helper
// â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
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

// â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
// 6. Feature Data Helper
// â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
function vrt_get_features_data() {
    $count = intval( get_theme_mod( 'vrt_feature_count', 6 ) );
    $defaults = array(
        1 => array( 'âš¡', 'Lightning Fast', 'Vite-powered builds with instant hot module replacement.' ),
        2 => array( 'ðŸŽ¨', 'Beautiful Design', 'Clean, professional aesthetics with refined typography.' ),
        3 => array( 'ðŸ“±', 'Fully Responsive', 'Looks perfect on every device â€” mobile, tablet, desktop.' ),
        4 => array( 'ðŸ”’', 'Secure & Reliable', 'Built with WordPress best practices for security.' ),
        5 => array( 'ðŸš€', 'SEO Optimized', 'Semantic HTML and fast load times for higher ranking.' ),
        6 => array( 'ðŸŽ¯', 'Customizable', 'Change everything from the WordPress Customizer.' ),
    );

    $items = array();
    for ( $i = 1; $i <= $count; $i++ ) {
        $d = isset( $defaults[ $i ] ) ? $defaults[ $i ] : array( 'âœ¦', 'Feature ' . $i, 'Describe this feature.' );
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

// â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
// 7. Testimonial Data Helper
// â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
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

// â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
// 8. Stats Data Helper
// â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
function vrt_get_stats_data() {
    $defaults = array(
        1 => array( 'ðŸš€', '10K+', 'Active Users' ),
        2 => array( 'â­', '4.9', 'Average Rating' ),
        3 => array( 'ðŸŒ', '50+', 'Countries' ),
        4 => array( 'ðŸ’¬', '1M+', 'Posts Created' ),
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

// â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
// 9. Include Customizer
// â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
require_once get_template_directory() . '/customizer.php';

// â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
// 10. Admin Page â€” Section Manager (Drag & Drop)
// â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
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

// â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
// Customizer UI Script Needs
// â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
function vrt_customize_controls_scripts() {
    if ( IS_VITE_DEVELOPMENT ) {
        wp_enqueue_script( 'vite-client', 'http://localhost:5173/@vite/client', array(), null );
        wp_enqueue_script( 'vrt-customizer-app', 'http://localhost:5173/src/customizer-structure.jsx', array( 'vite-client', 'customize-controls' ), null, true );
    } else {
        $theme_dir = get_template_directory();
        $theme_uri = get_template_directory_uri();
        $manifest_path = $theme_dir . '/dist/.vite/manifest.json';
        if ( file_exists( $manifest_path ) ) {
            $manifest = json_decode( file_get_contents( $manifest_path ), true );
            if ( isset( $manifest['src/customizer-structure.jsx'] ) ) {
                $js = $manifest['src/customizer-structure.jsx']['file'];
                wp_enqueue_script( 'vrt-customizer-app', $theme_uri . '/dist/' . $js, array( 'customize-controls' ), null, true );
                if ( isset( $manifest['src/customizer-structure.jsx']['css'] ) ) {
                    foreach ( $manifest['src/customizer-structure.jsx']['css'] as $i => $css ) {
                        wp_enqueue_style( 'vrt-customizer-app-style-' . $i, $theme_uri . '/dist/' . $css, array(), null );
                    }
                }
            }
        }
    }

    $pages = get_pages();
    $preset_pages = array(
        array( 'title' => 'Home', 'url' => '/' ),
        array( 'title' => 'Blog', 'url' => '/blog' ),
        array( 'title' => 'About', 'url' => '/about' ),
        array( 'title' => 'Contact', 'url' => '/contact' ),
        array( 'title' => 'Services', 'url' => '/services' ),
        array( 'title' => 'Portfolio', 'url' => '/portfolio' ),
        array( 'title' => 'Pricing', 'url' => '/pricing' ),
        array( 'title' => 'Team', 'url' => '/team' ),
        array( 'title' => 'FAQ', 'url' => '/faq' ),
        array( 'title' => 'Careers', 'url' => '/careers' ),
        array( 'title' => 'Testimonials', 'url' => '/testimonials' ),
        array( 'title' => 'Features', 'url' => '/features' ),
        array( 'title' => 'Privacy', 'url' => '/privacy' ),
        array( 'title' => 'Terms', 'url' => '/terms' ),
    );

    $page_data_map = array();
    foreach ( $preset_pages as $pp ) {
        $page_data_map[ $pp['url'] ] = $pp['title'];
    }

    $home_url = home_url();
    foreach ( $pages as $p ) {
        $url = str_replace( $home_url, '', get_permalink( $p->ID ) );
        if ( empty( $url ) ) $url = '/';
        $page_data_map[ $url ] = $p->post_title;
    }
    
    $final_page_data = array();
    foreach ( $page_data_map as $url => $title ) {
        $final_page_data[] = array( 'title' => $title, 'url' => $url );
    }

    wp_localize_script( 'customize-controls', 'VRT_AVAILABLE_PAGES', $final_page_data );
}
add_action( 'customize_controls_enqueue_scripts', 'vrt_customize_controls_scripts' );
// Customizer Preview Script for live updates
function vrt_customize_preview_scripts() {
    if ( IS_VITE_DEVELOPMENT ) {
        wp_enqueue_script( 'vrt-customizer-preview', 'http://localhost:5173/src/customizer-preview.js', array(), null, true );
    } else {
        $theme_dir = get_template_directory();
        $theme_uri = get_template_directory_uri();
        $manifest_path = $theme_dir . '/dist/.vite/manifest.json';
        if ( file_exists( $manifest_path ) ) {
            $manifest = json_decode( file_get_contents( $manifest_path ), true );
            if ( isset( $manifest['src/customizer-preview.js'] ) ) {
                $js = $manifest['src/customizer-preview.js']['file'];
                wp_enqueue_script( 'vrt-customizer-preview', $theme_uri . '/dist/' . $js, array(), null, true );
            }
        }
    }
}
add_action( 'customize_preview_init', 'vrt_customize_preview_scripts' );

// â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
// 11. Section Order Helper
// â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
function vrt_get_section_order() {
    $saved = get_theme_mod( 'vrt_theme_structure', '' );
    if ( ! $saved ) {
        $saved = get_option( 'vrt_section_order', '' );
    }

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

// â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
// 12. SPA Catch-All Rewrite
// â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
function vrt_rewrite_rules() {
    // Let WordPress API and admin work normally
    // Route all other front-end requests to index.php for the SPA
    add_rewrite_rule( '^blog/?$', 'index.php', 'top' );
    add_rewrite_rule( '^blog/([^/]+)/?$', 'index.php', 'top' );
    add_rewrite_rule( '^about/?$', 'index.php', 'top' );
    add_rewrite_rule( '^contact/?$', 'index.php', 'top' );
    add_rewrite_rule( '^services/?$', 'index.php', 'top' );
    add_rewrite_rule( '^portfolio/?$', 'index.php', 'top' );
    add_rewrite_rule( '^pricing/?$', 'index.php', 'top' );
    add_rewrite_rule( '^team/?$', 'index.php', 'top' );
    add_rewrite_rule( '^faq/?$', 'index.php', 'top' );
    add_rewrite_rule( '^careers/?$', 'index.php', 'top' );
    add_rewrite_rule( '^testimonials/?$', 'index.php', 'top' );
    add_rewrite_rule( '^features/?$', 'index.php', 'top' );
    add_rewrite_rule( '^privacy/?$', 'index.php', 'top' );
    add_rewrite_rule( '^terms/?$', 'index.php', 'top' );
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

// â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
// 13. Allow REST API for comments without auth
// â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
function vrt_allow_anonymous_comments( $result ) {
    // Allow unauthenticated REST API access (needed for frontend to fetch posts/pages)
    // Comment posting is handled by WordPress core's own auth checks
    return $result;
}
add_filter( 'rest_authentication_errors', 'vrt_allow_anonymous_comments', 10, 1 );

// â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
// 14. Misc Helpers
// â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€
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


