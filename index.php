<?php
/**
 * Main template — Homepage with drag-and-drop section ordering
 * @package ViteReactTheme
 */
get_header();

$section_order = vrt_get_section_order();

foreach ( $section_order as $section ) :
    if ( empty( $section['enabled'] ) ) continue;

    switch ( $section['id'] ) :

        // ── Hero ─────────────────────────────────────────────────────────
        case 'hero':
            if ( ! get_theme_mod( 'vrt_hero_show', true ) ) break;
            $badge    = get_theme_mod( 'vrt_hero_badge', '✨ Welcome to the future' );
            $title    = get_theme_mod( 'vrt_hero_title', 'Build Something Amazing' );
            $subtitle = get_theme_mod( 'vrt_hero_subtitle', 'A modern WordPress theme with clean design, powerful customization, and drag-and-drop section management.' );
            $btn1     = get_theme_mod( 'vrt_hero_btn1_text', 'Get Started' );
            $btn1url  = get_theme_mod( 'vrt_hero_btn1_url', '#features' );
            $btn2     = get_theme_mod( 'vrt_hero_btn2_text', 'Learn More' );
            $btn2url  = get_theme_mod( 'vrt_hero_btn2_url', '#latest-posts' );
            $bg_img   = get_theme_mod( 'vrt_hero_bg_image', '' );
            $bg_style = $bg_img ? ' style="background: url(' . esc_url( $bg_img ) . ') center/cover no-repeat;"' : '';
            ?>
            <section class="hero" id="hero"<?php echo $bg_style; ?>>
                <div class="container">
                    <div class="hero-inner">
                        <?php if ( $badge ) : ?><div class="hero-badge"><?php echo esc_html( $badge ); ?></div><?php endif; ?>
                        <h1 class="hero-title"><span class="hero-title-gradient"><?php echo esc_html( $title ); ?></span></h1>
                        <p class="hero-subtitle"><?php echo esc_html( $subtitle ); ?></p>
                        <div class="hero-actions">
                            <?php if ( $btn1 ) : ?><a href="<?php echo esc_url( $btn1url ); ?>" class="btn btn-primary" id="hero-btn-primary"><?php echo esc_html( $btn1 ); ?></a><?php endif; ?>
                            <?php if ( $btn2 ) : ?><a href="<?php echo esc_url( $btn2url ); ?>" class="btn btn-secondary" id="hero-btn-secondary"><?php echo esc_html( $btn2 ); ?></a><?php endif; ?>
                        </div>
                    </div>
                </div>
            </section>
            <?php break;

        // ── Features ─────────────────────────────────────────────────────
        case 'features':
            if ( ! get_theme_mod( 'vrt_features_show', true ) ) break;
            $label    = get_theme_mod( 'vrt_features_label', 'Why Choose Us' );
            $title    = get_theme_mod( 'vrt_features_title', 'Powerful Features' );
            $subtitle = get_theme_mod( 'vrt_features_subtitle', 'Everything you need to build modern, high-performance websites.' );
            $count    = vrt_get_feature_count();
            $defs     = array(
                1 => array( '⚡', 'Lightning Fast', 'Vite-powered builds with instant hot module replacement.' ),
                2 => array( '🎨', 'Beautiful Design', 'Clean, professional aesthetics with refined typography.' ),
                3 => array( '📱', 'Fully Responsive', 'Looks perfect on every device.' ),
                4 => array( '🔒', 'Secure & Reliable', 'Built with WordPress best practices.' ),
                5 => array( '🚀', 'SEO Optimized', 'Semantic HTML and fast load times.' ),
                6 => array( '🎯', 'Customizable', 'Change everything from the Customizer.' ),
            );
            ?>
            <section class="section features" id="features">
                <div class="container">
                    <div class="section-header">
                        <span class="section-label"><?php echo esc_html( $label ); ?></span>
                        <h2 class="section-title"><?php echo esc_html( $title ); ?></h2>
                        <p class="section-subtitle"><?php echo esc_html( $subtitle ); ?></p>
                    </div>
                    <div class="features-grid">
                        <?php for ( $i = 1; $i <= $count; $i++ ) :
                            $d = isset( $defs[$i] ) ? $defs[$i] : array( '✦', 'Feature ' . $i, 'Describe this feature.' );
                            $icon  = get_theme_mod( "vrt_feature_{$i}_icon", $d[0] );
                            $ftit  = get_theme_mod( "vrt_feature_{$i}_title", $d[1] );
                            $fdesc = get_theme_mod( "vrt_feature_{$i}_desc", $d[2] );
                            $delay = $i <= 6 ? ' reveal-delay-' . $i : '';
                        ?>
                        <div class="feature-card reveal<?php echo esc_attr( $delay ); ?>" data-card="<?php echo esc_attr( $i ); ?>">
                            <div class="feature-icon"><?php echo esc_html( $icon ); ?></div>
                            <h3><?php echo esc_html( $ftit ); ?></h3>
                            <p><?php echo esc_html( $fdesc ); ?></p>
                        </div>
                        <?php endfor; ?>
                    </div>
                </div>
            </section>
            <?php break;

        // ── Blog Posts ───────────────────────────────────────────────────
        case 'posts':
            if ( ! get_theme_mod( 'vrt_posts_show', true ) ) break;
            $plabel = get_theme_mod( 'vrt_posts_label', 'Blog' );
            $ptitle = get_theme_mod( 'vrt_posts_title', 'Latest Posts' );
            ?>
            <section class="section" id="latest-posts">
                <div class="container">
                    <div class="section-header">
                        <span class="section-label"><?php echo esc_html( $plabel ); ?></span>
                        <h2 class="section-title"><?php echo esc_html( $ptitle ); ?></h2>
                    </div>
                    <div class="posts-grid">
                        <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
                            <article <?php post_class( 'post-card reveal' ); ?>>
                                <?php if ( has_post_thumbnail() ) : ?>
                                    <a href="<?php the_permalink(); ?>">
                                        <img class="post-card-image" src="<?php the_post_thumbnail_url( 'medium_large' ); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy">
                                    </a>
                                <?php endif; ?>
                                <div class="post-card-body">
                                    <div class="post-card-meta">
                                        <span class="post-card-tag"><?php the_category( ', ' ); ?></span>
                                        <span class="post-card-date"><?php echo get_the_date(); ?></span>
                                    </div>
                                    <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                    <p class="post-card-excerpt"><?php echo wp_trim_words( get_the_excerpt(), 20 ); ?></p>
                                    <a href="<?php the_permalink(); ?>" class="post-card-link">Read more <span aria-hidden="true">→</span></a>
                                </div>
                            </article>
                        <?php endwhile; else : ?>
                            <p class="posts-empty">No posts yet. Create your first post from the WordPress dashboard.</p>
                        <?php endif; ?>
                    </div>
                    <?php the_posts_pagination( array( 'mid_size' => 2, 'prev_text' => '←', 'next_text' => '→' ) ); ?>
                </div>
            </section>
            <?php break;

        // ── CTA ──────────────────────────────────────────────────────────
        case 'cta':
            if ( ! get_theme_mod( 'vrt_cta_show', true ) ) break;
            $cta_title = get_theme_mod( 'vrt_cta_title', 'Ready to get started?' );
            $cta_sub   = get_theme_mod( 'vrt_cta_subtitle', 'Join thousands of users building amazing websites with our theme.' );
            $cta_btn   = get_theme_mod( 'vrt_cta_btn_text', 'Get Started Free' );
            $cta_url   = get_theme_mod( 'vrt_cta_btn_url', '#' );
            ?>
            <section class="cta-section" id="cta">
                <div class="container">
                    <div class="section-header">
                        <h2 class="section-title"><?php echo esc_html( $cta_title ); ?></h2>
                        <p class="section-subtitle"><?php echo esc_html( $cta_sub ); ?></p>
                    </div>
                    <div class="hero-actions">
                        <?php if ( $cta_btn ) : ?>
                            <a href="<?php echo esc_url( $cta_url ); ?>" class="btn btn-primary"><?php echo esc_html( $cta_btn ); ?></a>
                        <?php endif; ?>
                    </div>
                </div>
            </section>
            <?php break;

    endswitch;
endforeach;
?>

<div id="react-dashboard"></div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var els = document.querySelectorAll('.reveal');
    if ('IntersectionObserver' in window) {
        var obs = new IntersectionObserver(function(entries) {
            entries.forEach(function(e) { if (e.isIntersecting) { e.target.classList.add('visible'); obs.unobserve(e.target); } });
        }, { threshold: 0.1, rootMargin: '0px 0px -30px 0px' });
        els.forEach(function(el) { obs.observe(el); });
    } else {
        els.forEach(function(el) { el.classList.add('visible'); });
    }
});
</script>

<?php get_footer(); ?>
