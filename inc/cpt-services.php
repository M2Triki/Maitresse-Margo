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
        'menu_position'      => 23,
        'menu_icon'          => 'dashicons-clipboard',
        'supports'           => array('title', 'editor'),
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
    $link_text = get_post_meta($post->ID, '_service_link_text', true);
    $link_url = get_post_meta($post->ID, '_service_link_url', true);
?>
    <p>
        <label for="service_icon"><?php esc_html_e('Icône (classe Font Awesome):', 'maitresse-margo'); ?></label><br>
        <input type="text" id="service_icon" name="service_icon" value="<?php echo esc_attr($icon); ?>" style="width: 100%;" placeholder="fas fa-graduation-cap">
        <small><?php esc_html_e('Exemple: fas fa-graduation-cap, fas fa-book, fas fa-chalkboard-teacher', 'maitresse-margo'); ?></small>
    </p>
    <p>
        <label for="service_link_text"><?php esc_html_e('Texte du lien:', 'maitresse-margo'); ?></label><br>
        <input type="text" id="service_link_text" name="service_link_text" value="<?php echo esc_attr($link_text); ?>" style="width: 100%;">
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

    if (isset($_POST['service_link_text'])) {
        update_post_meta($post_id, '_service_link_text', sanitize_text_field($_POST['service_link_text']));
    }

    if (isset($_POST['service_link_url'])) {
        update_post_meta($post_id, '_service_link_url', esc_url_raw($_POST['service_link_url']));
    }
}
add_action('save_post', 'maitresse_margo_services_save_meta_box_data');
