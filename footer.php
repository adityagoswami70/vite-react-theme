    </main>

<?php if ( get_theme_mod( 'vrt_footer_show', true ) ) : ?>
<footer class="site-footer" id="site-footer">
    <?php if ( is_active_sidebar( 'footer-widgets' ) ) : ?>
    <div class="container"><div class="footer-widgets"><?php dynamic_sidebar( 'footer-widgets' ); ?></div></div>
    <?php endif; ?>

    <div class="container">
        <div class="footer-main">
            <div class="footer-grid">
                <div class="footer-brand-col">
                    <div class="footer-brand-name"><?php bloginfo( 'name' ); ?></div>
                    <p><?php bloginfo( 'description' ); ?></p>
                    <?php
                    $socials = array(
                        'twitter'   => 'X',
                        'facebook'  => 'Fb',
                        'instagram' => 'Ig',
                        'linkedin'  => 'Li',
                        'github'    => 'Gh',
                        'youtube'   => 'Yt',
                    );
                    $has_social = false;
                    foreach ( $socials as $key => $lbl ) {
                        if ( get_theme_mod( "vrt_social_{$key}", '' ) ) { $has_social = true; break; }
                    }
                    if ( $has_social ) : ?>
                        <div class="social-links">
                            <?php foreach ( $socials as $key => $lbl ) :
                                $url = get_theme_mod( "vrt_social_{$key}", '' );
                                if ( ! $url ) continue; ?>
                                <a href="<?php echo esc_url( $url ); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php echo esc_attr( $lbl ); ?>"><?php echo esc_html( $lbl ); ?></a>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <?php
                $cols = array( 1 => 'Product', 2 => 'Company', 3 => 'Legal' );
                $locs = array( 1 => 'footer-1', 2 => 'footer-2', 3 => 'footer-3' );
                foreach ( $cols as $n => $def ) :
                    $heading = get_theme_mod( "vrt_footer_col{$n}_title", $def ); ?>
                <div class="footer-col" data-col="<?php echo esc_attr( $n ); ?>">
                    <h4><?php echo esc_html( $heading ); ?></h4>
                    <?php if ( has_nav_menu( $locs[$n] ) ) {
                        wp_nav_menu( array( 'theme_location' => $locs[$n], 'container' => false, 'depth' => 1 ) );
                    } else {
                        echo '<ul class="menu"><li><a href="#">' . esc_html__( 'Add menu →', 'vite-react-theme' ) . '</a></li></ul>';
                    } ?>
                </div>
                <?php endforeach; ?>
            </div>
            <div class="footer-bottom">
                <p class="footer-copyright"><?php
                    $c = get_theme_mod( 'vrt_footer_copyright', '' );
                    echo $c ? esc_html( $c ) : '&copy; ' . date('Y') . ' ' . get_bloginfo('name') . '. All rights reserved.';
                ?></p>
            </div>
        </div>
    </div>
</footer>
<?php endif; ?>

</div><!-- #page -->

<script>
document.addEventListener('DOMContentLoaded', function() {
    var t = document.getElementById('navbar-toggle'), m = document.getElementById('navbar-menu');
    if (t && m) t.addEventListener('click', function() { m.classList.toggle('open'); });
});
</script>

<?php wp_footer(); ?>
</body>
</html>
