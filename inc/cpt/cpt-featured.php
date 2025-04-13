<?php

/**
 * CPT Featured
 *
 * @package MaitresseMargo
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Enregistrer le CPT Featured
 */
function maitresse_margo_register_featured_cpt()
{
    $labels = array(
        'name'                  => _x('Éléments à la une', 'Post type general name', 'maitresse-margo'),
        'singular_name'         => _x('Élément à la une', 'Post type singular name', 'maitresse-margo'),
        'menu_name'             => _x('À la une', 'Admin Menu text', 'maitresse-margo'),
        'name_admin_bar'        => _x('À la une', 'Add New on Toolbar', 'maitresse-margo'),
        'add_new'               => __('Ajouter', 'maitresse-margo'),
        'add_new_item'          => __('Ajouter un élément', 'maitresse-margo'),
        'new_item'              => __('Nouvel élément', 'maitresse-margo'),
        'edit_item'             => __('Modifier l\'élément', 'maitresse-margo'),
        'view_item'             => __('Voir l\'élément', 'maitresse-margo'),
        'all_items'             => __('Tous les éléments', 'maitresse-margo'),
        'search_items'          => __('Rechercher des éléments', 'maitresse-margo'),
        'not_found'             => __('Aucun élément trouvé.', 'maitresse-margo'),
        'not_found_in_trash'    => __('Aucun élément trouvé dans la corbeille.', 'maitresse-margo'),
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
        'menu_icon'          => 'dashicons-star-filled',
        'supports'           => array('title'),
        'show_in_rest'       => true,
    );

    register_post_type('featured', $args);

    // Enregistrer également un CPT pour les paramètres de la section
    $section_labels = array(
        'name'                  => _x('Paramètres À la une', 'Post type general name', 'maitresse-margo'),
        'singular_name'         => _x('Paramètre À la une', 'Post type singular name', 'maitresse-margo'),
        'menu_name'             => _x('Paramètres À la une', 'Admin Menu text', 'maitresse-margo'),
        'name_admin_bar'        => _x('Paramètres À la une', 'Add New on Toolbar', 'maitresse-margo'),
        'add_new'               => __('Ajouter', 'maitresse-margo'),
        'add_new_item'          => __('Ajouter des paramètres', 'maitresse-margo'),
        'new_item'              => __('Nouveaux paramètres', 'maitresse-margo'),
        'edit_item'             => __('Modifier les paramètres', 'maitresse-margo'),
        'view_item'             => __('Voir les paramètres', 'maitresse-margo'),
        'all_items'             => __('Tous les paramètres', 'maitresse-margo'),
        'search_items'          => __('Rechercher des paramètres', 'maitresse-margo'),
        'not_found'             => __('Aucun paramètre trouvé.', 'maitresse-margo'),
        'not_found_in_trash'    => __('Aucun paramètre trouvé dans la corbeille.', 'maitresse-margo'),
    );

    $section_args = array(
        'labels'             => $section_labels,
        'public'             => false,
        'publicly_queryable' => false,
        'show_ui'            => true,
        'show_in_menu'       => 'edit.php?post_type=featured',
        'query_var'          => false,
        'capability_type'    => 'post',
        'has_archive'        => false,
        'hierarchical'       => false,
        'menu_position'      => null,
        'supports'           => array('title'),
        'show_in_rest'       => true,
    );

    register_post_type('featured_section', $section_args);
}
add_action('init', 'maitresse_margo_register_featured_cpt');

/**
 * Ajouter les champs personnalisés pour le CPT Featured
 */
function maitresse_margo_featured_meta_boxes()
{
    add_meta_box(
        'featured_details',
        __('Détails de l\'élément à la une', 'maitresse-margo'),
        'maitresse_margo_featured_meta_box_callback',
        'featured',
        'normal',
        'high'
    );

    add_meta_box(
        'featured_section_details',
        __('Détails de la section À la une', 'maitresse-margo'),
        'maitresse_margo_featured_section_meta_box_callback',
        'featured_section',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'maitresse_margo_featured_meta_boxes');

/**
 * Callback pour afficher les champs personnalisés des éléments
 */
function maitresse_margo_featured_meta_box_callback($post)
{
    wp_nonce_field('maitresse_margo_featured_save_meta_box_data', 'maitresse_margo_featured_meta_box_nonce');

    $icon = get_post_meta($post->ID, '_featured_icon', true);
    $link_url = get_post_meta($post->ID, '_featured_link_url', true);
?>
    <p>
        <label for="featured_icon"><?php esc_html_e('Icône SVG:', 'maitresse-margo'); ?></label><br>
        <select id="featured_icon" name="featured_icon" style="width: 100%;">
            <option value=""><?php esc_html_e('Sélectionner une icône', 'maitresse-margo'); ?></option>
            <option value="fiches" <?php selected($icon, 'fiches'); ?>><?php esc_html_e('Fiches', 'maitresse-margo'); ?></option>
            <option value="books" <?php selected($icon, 'books'); ?>><?php esc_html_e('Livres', 'maitresse-margo'); ?></option>
            <option value="graduate" <?php selected($icon, 'graduate'); ?>><?php esc_html_e('Diplôme', 'maitresse-margo'); ?></option>
            <option value="school" <?php selected($icon, 'school'); ?>><?php esc_html_e('École', 'maitresse-margo'); ?></option>
            <option value="book" <?php selected($icon, 'book'); ?>><?php esc_html_e('Livre', 'maitresse-margo'); ?></option>
        </select>
    </p>
    <p>
        <label for="featured_link_url"><?php esc_html_e('URL du lien:', 'maitresse-margo'); ?></label><br>
        <input type="text" id="featured_link_url" name="featured_link_url" value="<?php echo esc_url($link_url); ?>" style="width: 100%;">
    </p>
<?php
}

/**
 * Callback pour afficher les champs personnalisés de la section
 */
function maitresse_margo_featured_section_meta_box_callback($post)
{
    wp_nonce_field('maitresse_margo_featured_section_save_meta_box_data', 'maitresse_margo_featured_section_meta_box_nonce');

    $button_text = get_post_meta($post->ID, '_featured_section_button_text', true);
    $button_url = get_post_meta($post->ID, '_featured_section_button_url', true);
?>
    <p>
        <label for="featured_section_button_text"><?php esc_html_e('Texte du bouton:', 'maitresse-margo'); ?></label><br>
        <input type="text" id="featured_section_button_text" name="featured_section_button_text" value="<?php echo esc_attr($button_text); ?>" style="width: 100%;" placeholder="Ex: Accéder aux ressources">
    </p>
    <p>
        <label for="featured_section_button_url"><?php esc_html_e('URL du bouton:', 'maitresse-margo'); ?></label><br>
        <input type="text" id="featured_section_button_url" name="featured_section_button_url" value="<?php echo esc_url($button_url); ?>" style="width: 100%;" placeholder="Ex: https://example.com/ressources">
    </p>
<?php
}

/**
 * Sauvegarder les données des champs personnalisés des éléments
 */
function maitresse_margo_featured_save_meta_box_data($post_id)
{
    if (!isset($_POST['maitresse_margo_featured_meta_box_nonce'])) {
        return;
    }

    if (!wp_verify_nonce($_POST['maitresse_margo_featured_meta_box_nonce'], 'maitresse_margo_featured_save_meta_box_data')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    if (isset($_POST['featured_icon'])) {
        update_post_meta($post_id, '_featured_icon', sanitize_text_field($_POST['featured_icon']));
    }

    if (isset($_POST['featured_link_url'])) {
        update_post_meta($post_id, '_featured_link_url', esc_url_raw($_POST['featured_link_url']));
    }
}
add_action('save_post_featured', 'maitresse_margo_featured_save_meta_box_data');

/**
 * Sauvegarder les données des champs personnalisés de la section
 */
function maitresse_margo_featured_section_save_meta_box_data($post_id)
{
    if (!isset($_POST['maitresse_margo_featured_section_meta_box_nonce'])) {
        return;
    }

    if (!wp_verify_nonce($_POST['maitresse_margo_featured_section_meta_box_nonce'], 'maitresse_margo_featured_section_save_meta_box_data')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    if (isset($_POST['featured_section_button_text'])) {
        update_post_meta($post_id, '_featured_section_button_text', sanitize_text_field($_POST['featured_section_button_text']));
    }

    if (isset($_POST['featured_section_button_url'])) {
        update_post_meta($post_id, '_featured_section_button_url', esc_url_raw($_POST['featured_section_button_url']));
    }
}
add_action('save_post_featured_section', 'maitresse_margo_featured_section_save_meta_box_data');
