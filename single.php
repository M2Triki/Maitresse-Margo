<?php

/**
 * Single post template
 *
 * @package MaitresseMargo
 */

get_header();
?>

<main id="primary" class="site-main">
    <div class="container">
        <?php
        while (have_posts()) :
            the_post();
        ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="entry-header">
                    <?php the_title('<h1 class="entry-title">', '</h1>'); ?>
                    <div class="entry-meta">
                        <span class="posted-on">
                            <?php echo esc_html__('Publié le ', 'maitresse-margo') . get_the_date(); ?>
                        </span>
                        <span class="byline">
                            <?php echo esc_html__('par ', 'maitresse-margo') . get_the_author(); ?>
                        </span>
                    </div><!-- .entry-meta -->
                </header><!-- .entry-header -->

                <?php if (has_post_thumbnail()) : ?>
                    <div class="entry-thumbnail">
                        <?php the_post_thumbnail('large'); ?>
                    </div>
                <?php endif; ?>

                <div class="entry-content">
                    <?php the_content(); ?>
                </div><!-- .entry-content -->

                <footer class="entry-footer">
                    <?php
                    // Afficher les catégories et tags
                    $categories_list = get_the_category_list(', ');
                    if ($categories_list) {
                        echo '<span class="cat-links">' . esc_html__('Catégories: ', 'maitresse-margo') . $categories_list . '</span>';
                    }

                    $tags_list = get_the_tag_list('', ', ');
                    if ($tags_list) {
                        echo '<span class="tags-links">' . esc_html__('Tags: ', 'maitresse-margo') . $tags_list . '</span>';
                    }
                    ?>
                </footer><!-- .entry-footer -->
            </article><!-- #post-<?php the_ID(); ?> -->

        <?php
            // Navigation entre les articles
            the_post_navigation(array(
                'prev_text' => '<span class="nav-subtitle">' . esc_html__('Article précédent:', 'maitresse-margo') . '</span> <span class="nav-title">%title</span>',
                'next_text' => '<span class="nav-subtitle">' . esc_html__('Article suivant:', 'maitresse-margo') . '</span> <span class="nav-title">%title</span>',
            ));

            // Si les commentaires sont ouverts
            if (comments_open() || get_comments_number()) :
                comments_template();
            endif;
        endwhile;
        ?>
    </div>
</main><!-- #primary -->

<?php
get_footer();
