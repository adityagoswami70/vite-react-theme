<?php
/**
 * Sidebar template — renders the main sidebar widget area.
 *
 * @package ViteReactTheme
 */

if ( ! is_active_sidebar( 'sidebar-1' ) ) {
    return;
}
?>

<aside id="secondary" class="widget-area" role="complementary" aria-label="<?php esc_attr_e( 'Sidebar', 'vite-react-theme' ); ?>">
    <?php dynamic_sidebar( 'sidebar-1' ); ?>
</aside>
