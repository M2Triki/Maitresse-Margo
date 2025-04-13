<?php

/**
 * Helper Functions
 *
 * @package MaitresseMargo
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

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
        // Stockez l'ID avant de réinitialiser
        $post_id = $query->posts[0]->ID;
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
        $posts = $query->posts;
        wp_reset_postdata();
        return $posts;
    }

    return array();
}

/**
 * Fonction pour récupérer la valeur d'un champ personnalisé
 */
function maitresse_margo_get_custom_field($field_name, $post_id = null)
{
    if (!$post_id) {
        $post_id = get_the_ID();
    }

    return get_post_meta($post_id, '_' . $field_name, true);
}

/**
 * Fonction pour mettre à jour la valeur d'un champ personnalisé
 */
function maitresse_margo_update_custom_field($field_name, $value, $post_id = null)
{
    if (!$post_id) {
        $post_id = get_the_ID();
    }

    return update_post_meta($post_id, '_' . $field_name, $value);
}

/**
 * Fonction pour afficher un SVG depuis un fichier
 */
function maitresse_margo_get_svg($filename)
{
    $svg_path = MAITRESSE_MARGO_DIR . '/assets/img/svg/' . $filename . '.svg';

    if (file_exists($svg_path)) {
        return file_get_contents($svg_path);
    }

    return '';
}
