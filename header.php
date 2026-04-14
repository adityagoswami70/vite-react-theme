<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">

    <!-- ── Navbar ──────────────────────────────────────────────────────── -->
    <header class="site-navbar" id="site-navbar">
        <div class="container">
            <div class="navbar-inner">

                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="navbar-brand">
                    <?php if ( has_custom_logo() ) : ?>
                        <?php
                        $logo_id  = get_theme_mod( 'custom_logo' );
                        $logo_url = wp_get_attachment_image_url( $logo_id, 'full' );
                        ?>
                        <img src="<?php echo esc_url( $logo_url ); ?>" alt="<?php bloginfo( 'name' ); ?>" class="custom-logo">
                    <?php endif; ?>
                    <?php bloginfo( 'name' ); ?>
                </a>

                <button class="navbar-toggle" id="navbar-toggle" aria-label="<?php esc_attr_e( 'Toggle navigation', 'vite-react-theme' ); ?>">
                    <span>☰</span>
                </button>

                <nav class="navbar-menu" id="navbar-menu" aria-label="<?php esc_attr_e( 'Primary navigation', 'vite-react-theme' ); ?>">
                    <?php
                    wp_nav_menu( array(
                        'theme_location' => 'primary',
                        'container'      => false,
                        'depth'          => 2,
                        'fallback_cb'    => 'vrt_primary_menu_fallback',
                    ) );
                    ?>
                </nav>

            </div>
        </div>
    </header>

    <main id="content" class="site-main">
