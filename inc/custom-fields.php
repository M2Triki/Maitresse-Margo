<?php

/**
 * Custom Fields
 *
 * @package MaitresseMargo
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Fonction pour enregistrer les meta boxes pour tous les CPT
 * Cette approche utilise uniquement les fonctions natives de WordPress
 */
function maitresse_margo_register_meta_boxes()
{
    // Les meta boxes sont déjà définies dans les fichiers CPT individuels
    // Ce fichier sert principalement de documentation et de point d'extension

    // Si vous souhaitez ajouter des meta boxes supplémentaires, vous pouvez le faire ici
}
add_action('add_meta_boxes', 'maitresse_margo_register_meta_boxes');

/**
 * Fonction pour récupérer la valeur d'un champ personnalisé
 * Alternative à get_field() qui utilise uniquement get_post_meta()
 */
if (!function_exists('maitresse_margo_get_custom_field')) {
    function maitresse_margo_get_custom_field($field_name, $post_id = null)
    {
        if (!$post_id) {
            $post_id = get_the_ID();
        }

        return get_post_meta($post_id, '_' . $field_name, true);
    }
}

/**
 * Fonction pour mettre à jour la valeur d'un champ personnalisé
 * Alternative à update_field() qui utilise uniquement update_post_meta()
 */
if (!function_exists('maitresse_margo_update_custom_field')) {
    function maitresse_margo_update_custom_field($field_name, $value, $post_id = null)
    {
        if (!$post_id) {
            $post_id = get_the_ID();
        }

        return update_post_meta($post_id, '_' . $field_name, $value);
    }
}
