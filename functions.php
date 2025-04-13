<?php

/**
 * Maitresse Margo Theme Functions
 *
 * @package MaitresseMargo
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Définir les constantes du thème
define('MAITRESSE_MARGO_VERSION', '1.0.0');
define('MAITRESSE_MARGO_DIR', get_template_directory());
define('MAITRESSE_MARGO_URI', get_template_directory_uri());

/**
 * Configuration du thème
 */
function maitresse_margo_setup()
{
    // Ajouter la prise en charge des fonctionnalités WordPress
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));
    add_theme_support('customize-selective-refresh-widgets');
    add_theme_support('custom-logo', array(
        'height'      => 250,
        'width'       => 250,
        'flex-width'  => true,
        'flex-height' => true,
    ));

    // Enregistrer les menus de navigation
    register_nav_menus(array(
        'primary' => esc_html__('Menu Principal', 'maitresse-margo'),
        'footer'  => esc_html__('Menu Footer', 'maitresse-margo'),
    ));
}
add_action('after_setup_theme', 'maitresse_margo_setup');

/**
 * Enregistrer les scripts et styles
 */
function maitresse_margo_scripts()
{
    // Styles
    wp_enqueue_style('maitresse-margo-style', get_stylesheet_uri(), array(), MAITRESSE_MARGO_VERSION);
    wp_enqueue_style('maitresse-margo-main', MAITRESSE_MARGO_URI . '/assets/css/main.css', array(), MAITRESSE_MARGO_VERSION);
    wp_enqueue_style('maitresse-margo-responsive', MAITRESSE_MARGO_URI . '/assets/css/responsive.css', array(), MAITRESSE_MARGO_VERSION);
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css', array(), '5.15.3');

    // Scripts
    wp_enqueue_script('maitresse-margo-main', MAITRESSE_MARGO_URI . '/assets/js/main.js', array('jquery'), MAITRESSE_MARGO_VERSION, true);

    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'maitresse_margo_scripts');

/**
 * Inclure les fichiers des Custom Post Types
 */
require MAITRESSE_MARGO_DIR . '/inc/cpt-hero.php';
require MAITRESSE_MARGO_DIR . '/inc/cpt-presentation.php';
require MAITRESSE_MARGO_DIR . '/inc/cpt-testimonials.php';
require MAITRESSE_MARGO_DIR . '/inc/cpt-services.php';
require MAITRESSE_MARGO_DIR . '/inc/cpt-contact.php';

/**
 * Inclure les champs personnalisés (ACF)
 */
require MAITRESSE_MARGO_DIR . '/inc/custom-fields.php';

/**
 * Fonction pour récupérer le dernier élément d'un CPT
 */
function maitresse_margo_get_latest_cpt($post_type)
{
    $args = array(
        'post_type'      => $post_type,
        'posts_per_page' => 1,
        'orderby'        => 'date',
        'order'          => 'DESC',
    );

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        $query->the_post();
        $post_id = get_the_ID();
        wp_reset_postdata();
        return $post_id;
    }

    return false;
}

/**
 * Fonction pour récupérer tous les éléments d'un CPT
 */
function maitresse_margo_get_all_cpt($post_type, $limit = -1)
{
    $args = array(
        'post_type'      => $post_type,
        'posts_per_page' => $limit,
        'orderby'        => 'menu_order',
        'order'          => 'ASC',
    );

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        return $query->posts;
    }

    return array();
}

/**
 * Fonction pour afficher un template part
 */
function maitresse_margo_get_template_part($slug, $name = null, $args = array())
{
    if (is_array($args) && !empty($args)) {
        extract($args);
    }

    if ($name) {
        get_template_part('template-parts/' . $slug, $name);
    } else {
        get_template_part('template-parts/' . $slug);
    }
}
