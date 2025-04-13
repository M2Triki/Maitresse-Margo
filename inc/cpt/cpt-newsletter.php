<?php

/**
 * CPT Newsletter
 *
 * @package MaitresseMargo
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Enregistrer le CPT Newsletter
 */
function maitresse_margo_register_newsletter_cpt()
{
    $labels = array(
        'name'                  => _x('Newsletters', 'Post type general name', 'maitresse-margo'),
        'singular_name'         => _x('Newsletter', 'Post type singular name', 'maitresse-margo'),
        'menu_name'             => _x('Newsletter', 'Admin Menu text', 'maitresse-margo'),
        'name_admin_bar'        => _x('Newsletter', 'Add New on Toolbar', 'maitresse-margo'),
        'add_new'               => __('Ajouter', 'maitresse-margo'),
        'add_new_item'          => __('Ajouter une newsletter', 'maitresse-margo'),
        'new_item'              => __('Nouvelle newsletter', 'maitresse-margo'),
        'edit_item'             => __('Modifier la newsletter', 'maitresse-margo'),
        'view_item'             => __('Voir la newsletter', 'maitresse-margo'),
        'all_items'             => __('Toutes les newsletters', 'maitresse-margo'),
        'search_items'          => __('Rechercher des newsletters', 'maitresse-margo'),
        'not_found'             => __('Aucune newsletter trouvée.', 'maitresse-margo'),
        'not_found_in_trash'    => __('Aucune newsletter trouvée dans la corbeille.', 'maitresse-margo'),
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
        'menu_icon'          => 'dashicons-email',
        'supports'           => array('title'),
        'show_in_rest'       => true,
    );

    register_post_type('newsletter', $args);
}
add_action('init', 'maitresse_margo_register_newsletter_cpt');

/**
 * Ajouter les champs personnalisés pour le CPT Newsletter
 */
function maitresse_margo_newsletter_meta_boxes()
{
    add_meta_box(
        'newsletter_details',
        __('Détails de la newsletter', 'maitresse-margo'),
        'maitresse_margo_newsletter_meta_box_callback',
        'newsletter',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'maitresse_margo_newsletter_meta_boxes');

/**
 * Callback pour afficher les champs personnalisés
 */
function maitresse_margo_newsletter_meta_box_callback($post)
{
    wp_nonce_field('maitresse_margo_newsletter_save_meta_box_data', 'maitresse_margo_newsletter_meta_box_nonce');

    $description = get_post_meta($post->ID, '_newsletter_description', true);
    $button_text = get_post_meta($post->ID, '_newsletter_button_text', true);
    $form_action = get_post_meta($post->ID, '_newsletter_form_action', true);
?>
    <p>
        <label for="newsletter_description"><?php esc_html_e('Description:', 'maitresse-margo'); ?></label><br>
        <textarea id="newsletter_description" name="newsletter_description" rows="4" style="width: 100%;"><?php echo esc_textarea($description); ?></textarea>
    </p>
    <p>
        <label for="newsletter_button_text"><?php esc_html_e('Texte du bouton:', 'maitresse-margo'); ?></label><br>
        <input type="text" id="newsletter_button_text" name="newsletter_button_text" value="<?php echo esc_attr($button_text); ?>" style="width: 100%;" placeholder="Ex: Je m'abonne">
    </p>
    <p>
        <label for="newsletter_form_action"><?php esc_html_e('URL d\'action du formulaire:', 'maitresse-margo'); ?></label><br>
        <input type="text" id="newsletter_form_action" name="newsletter_form_action" value="<?php echo esc_url($form_action); ?>" style="width: 100%;" placeholder="Ex: https://example.com/subscribe">
        <span class="description"><?php esc_html_e('Laissez vide pour utiliser #', 'maitresse-margo'); ?></span>
    </p>
<?php
}

/**
 * Sauvegarder les données des champs personnalisés
 */
function maitresse_margo_newsletter_save_meta_box_data($post_id)
{
    if (!isset($_POST['maitresse_margo_newsletter_meta_box_nonce'])) {
        return;
    }

    if (!wp_verify_nonce($_POST['maitresse_margo_newsletter_meta_box_nonce'], 'maitresse_margo_newsletter_save_meta_box_data')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    if (isset($_POST['newsletter_description'])) {
        update_post_meta($post_id, '_newsletter_description', sanitize_textarea_field($_POST['newsletter_description']));
    }

    if (isset($_POST['newsletter_button_text'])) {
        update_post_meta($post_id, '_newsletter_button_text', sanitize_text_field($_POST['newsletter_button_text']));
    }

    if (isset($_POST['newsletter_form_action'])) {
        update_post_meta($post_id, '_newsletter_form_action', esc_url_raw($_POST['newsletter_form_action']));
    }
}
add_action('save_post', 'maitresse_margo_newsletter_save_meta_box_data');
