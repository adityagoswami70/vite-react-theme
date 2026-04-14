<?php
/**
 * Single post template.
 *
 * @package ViteReactTheme
 */
get_header();
?>

<?php while (have_posts()):
    the_post(); ?>

    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

        <div class="container">
            <header class="entry-header">
                <div class="entry-meta">
                    <span><?php the_category(', '); ?></span>
                    <span>·</span>
                    <time datetime="<?php echo get_the_date('c'); ?>"><?php echo get_the_date(); ?></time>
                    <span>·</span>
                    <span><?php echo esc_html(get_the_author()); ?></span>
                </div>
                <h1 class="entry-title"><?php the_title(); ?></h1>
            </header>
        </div>

        <?php if (has_post_thumbnail()): ?>
            <div class="container">
                <div class="entry-thumbnail">
                    <?php the_post_thumbnail('large'); ?>
                </div>
            </div>
        <?php endif; ?>

        <div class="container">
            <div class="content-area<?php echo is_active_sidebar('sidebar-1') ? '' : ' no-sidebar'; ?>">

                <div class="entry-content">
                    <?php
                    the_content();

                    wp_link_pages(array(
                        'before' => '<nav class="page-links">' . __('Pages:', 'vite-react-theme'),
                        'after' => '</nav>',
                    ));
                    ?>
                </div>

                <?php get_sidebar(); ?>

            </div>
        </div>

        <?php if (has_tag()): ?>
            <div class="container">
                <footer class="entry-footer">
                    <span>Tags: </span>
                    <?php
                    $tags = get_the_tags();
                    if ($tags) {
                        foreach ($tags as $tag) {
                            echo '<a href="' . esc_url(get_tag_link($tag->term_id)) . '" class="tag-link">' . esc_html($tag->name) . '</a> ';
                        }
                    }
                    ?>
                </footer>
            </div>
        <?php endif; ?>

    </article>

    <!-- Post Navigation -->
    <div class="container">
        <nav class="post-navigation">
            <?php
            $prev = get_previous_post();
            $next = get_next_post();
            ?>
            <?php if ($prev): ?>
                <a href="<?php echo get_permalink($prev); ?>">
                    <span class="nav-label">← Previous</span>
                    <?php echo esc_html(get_the_title($prev)); ?>
                </a>
            <?php else: ?>
                <span></span>
            <?php endif; ?>

            <?php if ($next): ?>
                <a href="<?php echo get_permalink($next); ?>" class="nav-next">
                    <span class="nav-label">Next →</span>
                    <?php echo esc_html(get_the_title($next)); ?>
                </a>
            <?php endif; ?>
        </nav>
    </div>

    <?php
    // Comments
    if (comments_open() || get_comments_number()) {
        echo '<div class="container" style="max-width: var(--container-narrow); margin: 2rem auto;">';
        comments_template();
        echo '</div>';
    }
    ?>

<?php endwhile; ?>

<?php get_footer(); ?>