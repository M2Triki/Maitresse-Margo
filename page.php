<?php

/**
 * Page template
 *
 * @package MaitresseMargo
 */

get_header();
?>

<main id="primary" class="site-main">
    <?php
    while (have_posts()) :
        the_post();
    ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <header class="entry-header">
                <div class="container">
                    <?php the_title('<h1 class="entry-title">', '</h1>'); ?>
                </div>
            </header><!-- .entry-header -->

            <div class="entry-content">
                <div class="container">
                    <?php the_content(); ?>
                </div>
            </div><!-- .entry-content -->
        </article><!-- #post-<?php the_ID(); ?> -->
    <?php
    endwhile;
    ?>
</main><!-- #primary -->

<?php
get_footer();
