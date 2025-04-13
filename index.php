<?php

/**
 * Main template file
 *
 * @package MaitresseMargo
 */

get_header();
?>

<main id="primary" class="site-main">
    <div class="container">
        <?php
        if (have_posts()) :
            while (have_posts()) :
                the_post();
        ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <header class="entry-header">
                        <?php the_title('<h1 class="entry-title">', '</h1>'); ?>
                    </header><!-- .entry-header -->

                    <?php if (has_post_thumbnail()) : ?>
                        <div class="entry-thumbnail">
                            <?php the_post_thumbnail('large'); ?>
                        </div>
                    <?php endif; ?>

                    <div class="entry-content">
                        <?php the_content(); ?>
                    </div><!-- .entry-content -->
                </article><!-- #post-<?php the_ID(); ?> -->
            <?php
            endwhile;

            the_posts_navigation();
        else :
            ?>
            <p><?php esc_html_e('Aucun contenu trouvé.', 'maitresse-margo'); ?></p>
        <?php
        endif;
        ?>
    </div>
</main><!-- #primary -->

<?php
get_footer();
