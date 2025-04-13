<?php

/**
 * CPT Services
 *
 * @package MaitresseMargo
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Enregistrer le CPT Services
 */
function maitresse_margo_register_services_cpt()
{
    $labels = array(
        'name'                  => _x('Services', 'Post type general name', 'maitresse-margo'),
        'singular_name'         => _x('Service', 'Post type singular name', 'maitresse-margo'),
        'menu_name'             => _x('Services', 'Admin Menu text', 'maitresse-margo'),
        'name_admin_bar'        => _x('Service', 'Add New on Toolbar', 'maitresse-margo'),
        'add_new'               => __('Ajouter', 'maitresse-margo'),
        'add_new_item'          => __('Ajouter un service', 'maitresse-margo'),
        'new_item'              => __('Nouveau service', 'maitresse-margo'),
        'edit_item'             => __('Modifier le service', 'maitresse-margo'),
        'view_item'             => __('Voir le service', 'maitresse-margo'),
        'all_items'             => __('Tous les services', 'maitresse-margo'),
        'search_items'          => __('Rechercher des services', 'maitresse-margo'),
        'not_found'             => __('Aucun service trouvé.', 'maitresse-margo'),
        'not_found_in_trash'    => __('Aucun service trouvé dans la corbeille.', 'maitresse-margo'),
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
        'menu_position'      => 22,
        'menu_icon'          => 'dashicons-clipboard',
        'supports'           => array('title'),
        'show_in_rest'       => true,
    );

    register_post_type('service', $args);
}
add_action('init', 'maitresse_margo_register_services_cpt');

/**
 * Ajouter les champs personnalisés pour le CPT Services
 */
function maitresse_margo_services_meta_boxes()
{
    add_meta_box(
        'service_details',
        __('Détails du service', 'maitresse-margo'),
        'maitresse_margo_services_meta_box_callback',
        'service',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'maitresse_margo_services_meta_boxes');

/**
 * Callback pour afficher les champs personnalisés
 */
function maitresse_margo_services_meta_box_callback($post)
{
    wp_nonce_field('maitresse_margo_services_save_meta_box_data', 'maitresse_margo_services_meta_box_nonce');

    $icon = get_post_meta($post->ID, '_service_icon', true);
    $link_url = get_post_meta($post->ID, '_service_link_url', true);
?>
    <p>
        <label for="service_icon"><?php esc_html_e('Icône SVG:', 'maitresse-margo'); ?></label><br>
        <select id="service_icon" name="service_icon" style="width: 100%;">
            <option value=""><?php esc_html_e('Sélectionner une icône', 'maitresse-margo'); ?></option>
            <option value="graduate" <?php selected($icon, 'graduate'); ?>><?php esc_html_e('Diplôme', 'maitresse-margo'); ?></option>
            <option value="school" <?php selected($icon, 'school'); ?>><?php esc_html_e('École', 'maitresse-margo'); ?></option>
            <option value="book" <?php selected($icon, 'book'); ?>><?php esc_html_e('Livre', 'maitresse-margo'); ?></option>
            <option value="email" <?php selected($icon, 'email'); ?>><?php esc_html_e('Email', 'maitresse-margo'); ?></option>
            <option value="fiches" <?php selected($icon, 'fiches'); ?>><?php esc_html_e('Fiches', 'maitresse-margo'); ?></option>
            <option value="books" <?php selected($icon, 'books'); ?>><?php esc_html_e('Livres', 'maitresse-margo'); ?></option>
        </select>
    </p>
    <p>
        <label for="service_link_url"><?php esc_html_e('URL du lien:', 'maitresse-margo'); ?></label><br>
        <input type="text" id="service_link_url" name="service_link_url" value="<?php echo esc_url($link_url); ?>" style="width: 100%;">
    </p>
<?php
}

/**
 * Sauvegarder les données des champs personnalisés
 */
function maitresse_margo_services_save_meta_box_data($post_id)
{
    if (!isset($_POST['maitresse_margo_services_meta_box_nonce'])) {
        return;
    }

    if (!wp_verify_nonce($_POST['maitresse_margo_services_meta_box_nonce'], 'maitresse_margo_services_save_meta_box_data')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    if (isset($_POST['service_icon'])) {
        update_post_meta($post_id, '_service_icon', sanitize_text_field($_POST['service_icon']));
    }

    if (isset($_POST['service_link_url'])) {
        update_post_meta($post_id, '_service_link_url', esc_url_raw($_POST['service_link_url']));
    }
}
add_action('save_post', 'maitresse_margo_services_save_meta_box_data');
