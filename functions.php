<?php
/**
 * Vite React Theme functions and definitions
 */

// Toggle this to false for production
define( 'IS_VITE_DEVELOPMENT', true );

function vite_react_theme_scripts() {
    $theme_uri = get_template_directory_uri();
    $theme_dir = get_template_directory();

    // Default stylesheet
    wp_enqueue_style( 'vite-react-theme-style', get_stylesheet_uri(), array(), wp_get_theme()->get( 'Version' ) );

    if ( defined( 'IS_VITE_DEVELOPMENT' ) && IS_VITE_DEVELOPMENT === true ) {
        // Enqueue Vite client for HMR
        wp_enqueue_script( 'vite-client', 'http://localhost:5173/@vite/client', array(), null );
        
        // Enqueue our React application entry point
        wp_enqueue_script( 'vite-react-main', 'http://localhost:5173/src/main.jsx', array( 'vite-client' ), null );

    } else {
        // Production mode: Read the manifest file to find the hashed asset names
        $manifest_path = $theme_dir . '/dist/.vite/manifest.json';
        
        if ( file_exists( $manifest_path ) ) {
            $manifest = json_decode( file_get_contents( $manifest_path ), true );
            
            if ( isset( $manifest['src/main.jsx'] ) ) {
                $js_file = $manifest['src/main.jsx']['file'];
                wp_enqueue_script( 'vite-react-main', $theme_uri . '/dist/' . $js_file, array(), null, true );
                
                // Enqueue CSS injected by main.jsx if they exist
                if ( isset( $manifest['src/main.jsx']['css'] ) ) {
                    foreach ( $manifest['src/main.jsx']['css'] as $index => $css_file ) {
                        wp_enqueue_style( 'vite-react-main-style-' . $index, $theme_uri . '/dist/' . $css_file, array(), null );
                    }
                }
            }
        }
    }
}
add_action( 'wp_enqueue_scripts', 'vite_react_theme_scripts' );

// Add type="module" to our scripts so the browser knows they are ES Modules
function vite_react_theme_script_type_module( $tag, $handle, $src ) {
    if ( in_array( $handle, array( 'vite-client', 'vite-react-main' ) ) ) {
        return '<script type="module" src="' . esc_url( $src ) . '"></script>';
    }
    return $tag;
}
add_filter( 'script_loader_tag', 'vite_react_theme_script_type_module', 10, 3 );
