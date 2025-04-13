<?php

/**
 * CPT Hero
 *
 * @package MaitresseMargo
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Enregistrer le CPT Hero
 */
function maitresse_margo_register_hero_cpt()
{
    $labels = array(
        'name'                  => _x('Sections Hero', 'Post type general name', 'maitresse-margo'),
        'singular_name'         => _x('Section Hero', 'Post type singular name', 'maitresse-margo'),
        'menu_name'             => _x('Hero', 'Admin Menu text', 'maitresse-margo'),
        'name_admin_bar'        => _x('Hero', 'Add New on Toolbar', 'maitresse-margo'),
        'add_new'               => __('Ajouter', 'maitresse-margo'),
        'add_new_item'          => __('Ajouter une section Hero', 'maitresse-margo'),
        'new_item'              => __('Nouvelle section Hero', 'maitresse-margo'),
        'edit_item'             => __('Modifier la section Hero', 'maitresse-margo'),
        'view_item'             => __('Voir la section Hero', 'maitresse-margo'),
        'all_items'             => __('Toutes les sections Hero', 'maitresse-margo'),
        'search_items'          => __('Rechercher des sections Hero', 'maitresse-margo'),
        'not_found'             => __('Aucune section Hero trouvée.', 'maitresse-margo'),
        'not_found_in_trash'    => __('Aucune section Hero trouvée dans la corbeille.', 'maitresse-margo'),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => false,
        'publicly_queryable' => false,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => false,
        'capability_type'    => 'post',
        'has_archive'        => false,
        'hierarchical'       => false,
        'menu_position'      => 20,
        'menu_icon'          => 'dashicons-format-image',
        'supports'           => array('title'),
        'show_in_rest'       => true,
    );

    register_post_type('hero', $args);
}
add_action('init', 'maitresse_margo_register_hero_cpt');

/**
 * Ajouter les champs personnalisés pour le CPT Hero
 */
function maitresse_margo_hero_meta_boxes()
{
    add_meta_box(
        'hero_details',
        __('Détails de la section Hero', 'maitresse-margo'),
        'maitresse_margo_hero_meta_box_callback',
        'hero',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'maitresse_margo_hero_meta_boxes');

/**
 * Callback pour afficher les champs personnalisés
 */
function maitresse_margo_hero_meta_box_callback($post)
{
    wp_nonce_field('maitresse_margo_hero_save_meta_box_data', 'maitresse_margo_hero_meta_box_nonce');

    $subtitle = get_post_meta($post->ID, '_hero_subtitle', true);
?>
    <p>
        <label for="hero_subtitle"><?php esc_html_e('Sous-titre / Description:', 'maitresse-margo'); ?></label><br>
        <textarea id="hero_subtitle" name="hero_subtitle" rows="4" style="width: 100%;"><?php echo esc_textarea($subtitle); ?></textarea>
        <span class="description"><?php esc_html_e('Ce texte apparaîtra sous le titre principal.', 'maitresse-margo'); ?></span>
    </p>
<?php
}

/**
 * Sauvegarder les données des champs personnalisés
 */
function maitresse_margo_hero_save_meta_box_data($post_id)
{
    if (!isset($_POST['maitresse_margo_hero_meta_box_nonce'])) {
        return;
    }

    if (!wp_verify_nonce($_POST['maitresse_margo_hero_meta_box_nonce'], 'maitresse_margo_hero_save_meta_box_data')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    if (isset($_POST['hero_subtitle'])) {
        update_post_meta($post_id, '_hero_subtitle', sanitize_textarea_field($_POST['hero_subtitle']));
    }
}
add_action('save_post', 'maitresse_margo_hero_save_meta_box_data');
