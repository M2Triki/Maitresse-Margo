<?php

/**
 * Archive template
 *
 * @package MaitresseMargo
 */

get_header();
?>

<main id="primary" class="site-main">
    <div class="container">
        <header class="page-header">
            <?php
            the_archive_title('<h1 class="page-title">', '</h1>');
            the_archive_description('<div class="archive-description">', '</div>');
            ?>
        </header><!-- .page-header -->

        <div class="archive-content">
            <?php
            if (have_posts()) :
                echo '<div class="posts-grid">';
                while (have_posts()) :
                    the_post();
            ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class('post-card'); ?>>
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="post-thumbnail">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail('medium'); ?>
                                </a>
                            </div>
                        <?php endif; ?>

                        <div class="post-content">
                            <header class="entry-header">
                                <?php the_title('<h2 class="entry-title"><a href="' . esc_url(get_permalink()) . '">', '</a></h2>'); ?>
                                <div class="entry-meta">
                                    <span class="posted-on"><?php echo get_the_date(); ?></span>
                                </div>
                            </header>

                            <div class="entry-summary">
                                <?php the_excerpt(); ?>
                            </div>

                            <a href="<?php the_permalink(); ?>" class="read-more"><?php esc_html_e('Lire la suite', 'maitresse-margo'); ?></a>
                        </div>
                    </article>
                <?php
                endwhile;
                echo '</div>';

                the_posts_pagination(array(
                    'prev_text' => '&laquo; ' . esc_html__('Précédent', 'maitresse-margo'),
                    'next_text' => esc_html__('Suivant', 'maitresse-margo') . ' &raquo;',
                ));
            else :
                ?>
                <p><?php esc_html_e('Aucun contenu trouvé.', 'maitresse-margo'); ?></p>
            <?php
            endif;
            ?>
        </div>
    </div>
</main><!-- #primary -->

<?php
get_footer();
