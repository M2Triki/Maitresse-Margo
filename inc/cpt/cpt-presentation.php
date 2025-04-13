<?php

/**
 * CPT Presentation
 *
 * @package MaitresseMargo
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Enregistrer le CPT Presentation
 */
function maitresse_margo_register_presentation_cpt()
{
    $labels = array(
        'name'                  => _x('Présentations', 'Post type general name', 'maitresse-margo'),
        'singular_name'         => _x('Présentation', 'Post type singular name', 'maitresse-margo'),
        'menu_name'             => _x('Présentation', 'Admin Menu text', 'maitresse-margo'),
        'name_admin_bar'        => _x('Présentation', 'Add New on Toolbar', 'maitresse-margo'),
        'add_new'               => __('Ajouter', 'maitresse-margo'),
        'add_new_item'          => __('Ajouter une présentation', 'maitresse-margo'),
        'new_item'              => __('Nouvelle présentation', 'maitresse-margo'),
        'edit_item'             => __('Modifier la présentation', 'maitresse-margo'),
        'view_item'             => __('Voir la présentation', 'maitresse-margo'),
        'all_items'             => __('Toutes les présentations', 'maitresse-margo'),
        'search_items'          => __('Rechercher des présentations', 'maitresse-margo'),
        'not_found'             => __('Aucune présentation trouvée.', 'maitresse-margo'),
        'not_found_in_trash'    => __('Aucune présentation trouvée dans la corbeille.', 'maitresse-margo'),
        'featured_image'        => __('Image de la présentation', 'maitresse-margo'),
        'set_featured_image'    => __('Définir l\'image', 'maitresse-margo'),
        'remove_featured_image' => __('Supprimer l\'image', 'maitresse-margo'),
        'use_featured_image'    => __('Utiliser comme image', 'maitresse-margo'),
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
        'menu_position'      => 21,
        'menu_icon'          => 'dashicons-id-alt',
        'supports'           => array('title', 'editor', 'thumbnail'),
        'show_in_rest'       => true,
    );

    register_post_type('presentation', $args);
}
add_action('init', 'maitresse_margo_register_presentation_cpt');

/**
 * Ajouter les champs personnalisés pour le CPT Presentation
 */
function maitresse_margo_presentation_meta_boxes()
{
    add_meta_box(
        'presentation_details',
        __('Détails de la présentation', 'maitresse-margo'),
        'maitresse_margo_presentation_meta_box_callback',
        'presentation',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'maitresse_margo_presentation_meta_boxes');

/**
 * Callback pour afficher les champs personnalisés
 */
function maitresse_margo_presentation_meta_box_callback($post)
{
    wp_nonce_field('maitresse_margo_presentation_save_meta_box_data', 'maitresse_margo_presentation_meta_box_nonce');

    $button_text = get_post_meta($post->ID, '_presentation_button_text', true);
    $button_url = get_post_meta($post->ID, '_presentation_button_url', true);
?>
    <p>
        <label for="presentation_button_text"><?php esc_html_e('Texte du bouton:', 'maitresse-margo'); ?></label><br>
        <input type="text" id="presentation_button_text" name="presentation_button_text" value="<?php echo esc_attr($button_text); ?>" style="width: 100%;" placeholder="Ex: En savoir plus">
    </p>
    <p>
        <label for="presentation_button_url"><?php esc_html_e('URL du bouton:', 'maitresse-margo'); ?></label><br>
        <input type="text" id="presentation_button_url" name="presentation_button_url" value="<?php echo esc_url($button_url); ?>" style="width: 100%;" placeholder="Ex: https://example.com/a-propos">
    </p>
    <p>
        <strong><?php esc_html_e('Image principale:', 'maitresse-margo'); ?></strong><br>
        <?php esc_html_e('Utilisez l\'image mise en avant pour définir l\'image de la section présentation.', 'maitresse-margo'); ?>
    </p>
<?php
}

/**
 * Sauvegarder les données des champs personnalisés
 */
function maitresse_margo_presentation_save_meta_box_data($post_id)
{
    if (!isset($_POST['maitresse_margo_presentation_meta_box_nonce'])) {
        return;
    }

    if (!wp_verify_nonce($_POST['maitresse_margo_presentation_meta_box_nonce'], 'maitresse_margo_presentation_save_meta_box_data')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    if (isset($_POST['presentation_button_text'])) {
        update_post_meta($post_id, '_presentation_button_text', sanitize_text_field($_POST['presentation_button_text']));
    }

    if (isset($_POST['presentation_button_url'])) {
        update_post_meta($post_id, '_presentation_button_url', esc_url_raw($_POST['presentation_button_url']));
    }
}
add_action('save_post', 'maitresse_margo_presentation_save_meta_box_data');
