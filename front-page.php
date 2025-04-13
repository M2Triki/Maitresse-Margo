<?php

/**
 * Template Name: Page d'accueil
 * Template Post Type: page
 *
 * @package MaitresseMargo
 */

get_header();
?>

<main id="primary" class="site-main">
    <!-- Section Hero -->
    <?php get_template_part('template-parts/content', 'hero'); ?>

    <!-- Section Services -->
    <?php get_template_part('template-parts/content', 'services'); ?>

    <!-- Section Présentation -->
    <?php get_template_part('template-parts/content', 'presentation'); ?>

    <!-- Section Newsletter -->
    <?php get_template_part('template-parts/content', 'newsletter'); ?>

    <!-- Section À la une -->
    <?php get_template_part('template-parts/content', 'featured'); ?>

    <!-- Section À propos -->
    <?php get_template_part('template-parts/content', 'about'); ?>
</main>

<?php
get_footer();
