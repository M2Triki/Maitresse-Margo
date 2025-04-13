<?php

/**
 * CPT About
 *
 * @package MaitresseMargo
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Enregistrer le CPT About
 */
function maitresse_margo_register_about_cpt()
{
    $labels = array(
        'name'                  => _x('À propos', 'Post type general name', 'maitresse-margo'),
        'singular_name'         => _x('À propos', 'Post type singular name', 'maitresse-margo'),
        'menu_name'             => _x('À propos', 'Admin Menu text', 'maitresse-margo'),
        'name_admin_bar'        => _x('À propos', 'Add New on Toolbar', 'maitresse-margo'),
        'add_new'               => __('Ajouter', 'maitresse-margo'),
        'add_new_item'          => __('Ajouter une section À propos', 'maitresse-margo'),
        'new_item'              => __('Nouvelle section À propos', 'maitresse-margo'),
        'edit_item'             => __('Modifier la section À propos', 'maitresse-margo'),
        'view_item'             => __('Voir la section À propos', 'maitresse-margo'),
        'all_items'             => __('Toutes les sections À propos', 'maitresse-margo'),
        'search_items'          => __('Rechercher des sections À propos', 'maitresse-margo'),
        'not_found'             => __('Aucune section À propos trouvée.', 'maitresse-margo'),
        'not_found_in_trash'    => __('Aucune section À propos trouvée dans la corbeille.', 'maitresse-margo'),
        'featured_image'        => __('Image de profil', 'maitresse-margo'),
        'set_featured_image'    => __('Définir l\'image de profil', 'maitresse-margo'),
        'remove_featured_image' => __('Supprimer l\'image de profil', 'maitresse-margo'),
        'use_featured_image'    => __('Utiliser comme image de profil', 'maitresse-margo'),
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
        'menu_position'      => 25,
        'menu_icon'          => 'dashicons-id',
        'supports'           => array('title', 'editor', 'thumbnail'),
        'show_in_rest'       => true,
    );

    register_post_type('about', $args);
}
add_action('init', 'maitresse_margo_register_about_cpt');

/**
 * Ajouter les champs personnalisés pour le CPT About
 */
function maitresse_margo_about_meta_boxes()
{
    add_meta_box(
        'about_details',
        __('Détails supplémentaires', 'maitresse-margo'),
        'maitresse_margo_about_meta_box_callback',
        'about',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'maitresse_margo_about_meta_boxes');

/**
 * Callback pour afficher les champs personnalisés
 */
function maitresse_margo_about_meta_box_callback($post)
{
    wp_nonce_field('maitresse_margo_about_save_meta_box_data', 'maitresse_margo_about_meta_box_nonce');

    $avatar = get_post_meta($post->ID, '_about_avatar', true);
?>
    <p>
        <strong><?php esc_html_e('Image de profil:', 'maitresse-margo'); ?></strong><br>
        <?php esc_html_e('Utilisez l\'image mise en avant pour définir l\'image de profil.', 'maitresse-margo'); ?>
    </p>
    <p>
        <label for="about_avatar"><?php esc_html_e('URL de l\'avatar (optionnel):', 'maitresse-margo'); ?></label><br>
        <input type="text" id="about_avatar" name="about_avatar" value="<?php echo esc_url($avatar); ?>" style="width: 100%;">
        <span class="description"><?php esc_html_e('Si vous préférez utiliser une URL externe pour l\'avatar au lieu de l\'image mise en avant.', 'maitresse-margo'); ?></span>
    </p>
<?php
}

/**
 * Sauvegarder les données des champs personnalisés
 */
function maitresse_margo_about_save_meta_box_data($post_id)
{
    if (!isset($_POST['maitresse_margo_about_meta_box_nonce'])) {
        return;
    }

    if (!wp_verify_nonce($_POST['maitresse_margo_about_meta_box_nonce'], 'maitresse_margo_about_save_meta_box_data')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    if (isset($_POST['about_avatar'])) {
        update_post_meta($post_id, '_about_avatar', esc_url_raw($_POST['about_avatar']));
    }
}
add_action('save_post', 'maitresse_margo_about_save_meta_box_data');
