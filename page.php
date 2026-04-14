<?php
/**
 * Page template.
 *
 * @package ViteReactTheme
 */
get_header();
?>

<?php while ( have_posts() ) : the_post(); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

    <div class="container">
        <header class="entry-header">
            <h1 class="entry-title"><?php the_title(); ?></h1>
        </header>
    </div>

    <?php if ( has_post_thumbnail() ) : ?>
    <div class="container">
        <div class="entry-thumbnail">
            <?php the_post_thumbnail( 'large' ); ?>
        </div>
    </div>
    <?php endif; ?>

    <div class="container">
        <div class="entry-content">
            <?php
            the_content();

            wp_link_pages( array(
                'before' => '<nav class="page-links">' . __( 'Pages:', 'vite-react-theme' ),
                'after'  => '</nav>',
            ) );
            ?>
        </div>
    </div>

</article>

<?php
if ( comments_open() || get_comments_number() ) {
    echo '<div class="container" style="max-width: var(--container-narrow); margin: 2rem auto;">';
    comments_template();
    echo '</div>';
}
?>

<?php endwhile; ?>

<?php get_footer(); ?>
