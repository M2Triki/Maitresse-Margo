<?php

/**
 * CPT Contact
 *
 * @package MaitresseMargo
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Enregistrer le CPT Contact
 */
function maitresse_margo_register_contact_cpt()
{
    $labels = array(
        'name'                  => _x('Contacts', 'Post type general name', 'maitresse-margo'),
        'singular_name'         => _x('Contact', 'Post type singular name', 'maitresse-margo'),
        'menu_name'             => _x('Contact', 'Admin Menu text', 'maitresse-margo'),
        'name_admin_bar'        => _x('Contact', 'Add New on Toolbar', 'maitresse-margo'),
        'add_new'               => __('Ajouter', 'maitresse-margo'),
        'add_new_item'          => __('Ajouter un contact', 'maitresse-margo'),
        'new_item'              => __('Nouveau contact', 'maitresse-margo'),
        'edit_item'             => __('Modifier le contact', 'maitresse-margo'),
        'view_item'             => __('Voir le contact', 'maitresse-margo'),
        'all_items'             => __('Tous les contacts', 'maitresse-margo'),
        'search_items'          => __('Rechercher des contacts', 'maitresse-margo'),
        'not_found'             => __('Aucun contact trouvé.', 'maitresse-margo'),
        'not_found_in_trash'    => __('Aucun contact trouvé dans la corbeille.', 'maitresse-margo'),
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
        'menu_position'      => 24,
        'menu_icon'          => 'dashicons-email',
        'supports'           => array('title'),
    );

    register_post_type('contact', $args);
}
add_action('init', 'maitresse_margo_register_contact_cpt');

/**
 * Ajouter les champs personnalisés pour le CPT Contact
 */
function maitresse_margo_contact_meta_boxes()
{
    add_meta_box(
        'contact_details',
        __('Détails du contact', 'maitresse-margo'),
        'maitresse_margo_contact_meta_box_callback',
        'contact',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'maitresse_margo_contact_meta_boxes');

/**
 * Callback pour afficher les champs personnalisés
 */
function maitresse_margo_contact_meta_box_callback($post)
{
    wp_nonce_field('maitresse_margo_contact_save_meta_box_data', 'maitresse_margo_contact_meta_box_nonce');

    $email = get_post_meta($post->ID, '_contact_email', true);
    $phone = get_post_meta($post->ID, '_contact_phone', true);
    $address = get_post_meta($post->ID, '_contact_address', true);
    $map_embed = get_post_meta($post->ID, '_contact_map_embed', true);
    $form_shortcode = get_post_meta($post->ID, '_contact_form_shortcode', true);
?>
    <p>
        <label for="contact_email"><?php esc_html_e('Email:', 'maitresse-margo'); ?></label><br>
        <input type="email" id="contact_email" name="contact_email" value="<?php echo esc_attr($email); ?>" style="width: 100%;">
    </p>
    <p>
        <label for="contact_phone"><?php esc_html_e('Téléphone:', 'maitresse-margo'); ?></label><br>
        <input type="text" id="contact_phone" name="contact_phone" value="<?php echo esc_attr($phone); ?>" style="width: 100%;">
    </p>
    <p>
        <label for="contact_address"><?php esc_html_e('Adresse:', 'maitresse-margo'); ?></label><br>
        <textarea id="contact_address" name="contact_address" style="width: 100%;" rows="3"><?php echo esc_textarea($address); ?></textarea>
    </p>
    <p>
        <label for="contact_map_embed"><?php esc_html_e('Code d\'intégration Google Maps:', 'maitresse-margo'); ?></label><br>
        <textarea id="contact_map_embed" name="contact_map_embed" style="width: 100%;" rows="5"><?php echo esc_textarea($map_embed); ?></textarea>
        <small><?php esc_html_e('Collez ici le code iframe de Google Maps.', 'maitresse-margo'); ?></small>
    </p>
    <p>
        <label for="contact_form_shortcode"><?php esc_html_e('Shortcode du formulaire de contact:', 'maitresse-margo'); ?></label><br>
        <input type="text" id="contact_form_shortcode" name="contact_form_shortcode" value="<?php echo esc_attr($form_shortcode); ?>" style="width: 100%;" placeholder="[contact-form-7 id=&quot;123&quot; title=&quot;Formulaire de contact&quot;]">
        <small><?php esc_html_e('Exemple: [contact-form-7 id="123" title="Formulaire de contact"]', 'maitresse-margo'); ?></small>
    </p>
<?php
}

/**
 * Sauvegarder les données des champs personnalisés
 */
function maitresse_margo_contact_save_meta_box_data($post_id)
{
    if (!isset($_POST['maitresse_margo_contact_meta_box_nonce'])) {
        return;
    }

    if (!wp_verify_nonce($_POST['maitresse_margo_contact_meta_box_nonce'], 'maitresse_margo_contact_save_meta_box_data')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    if (isset($_POST['contact_email'])) {
        update_post_meta($post_id, '_contact_email', sanitize_email($_POST['contact_email']));
    }

    if (isset($_POST['contact_phone'])) {
        update_post_meta($post_id, '_contact_phone', sanitize_text_field($_POST['contact_phone']));
    }

    if (isset($_POST['contact_address'])) {
        update_post_meta($post_id, '_contact_address', sanitize_textarea_field($_POST['contact_address']));
    }

    if (isset($_POST['contact_map_embed'])) {
        update_post_meta($post_id, '_contact_map_embed', $_POST['contact_map_embed']);
    }

    if (isset($_POST['contact_form_shortcode'])) {
        update_post_meta($post_id, '_contact_form_shortcode', sanitize_text_field($_POST['contact_form_shortcode']));
    }
}
add_action('save_post', 'maitresse_margo_contact_save_meta_box_data');
