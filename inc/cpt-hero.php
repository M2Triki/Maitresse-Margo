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
    $button_text = get_post_meta($post->ID, '_hero_button_text', true);
    $button_url = get_post_meta($post->ID, '_hero_button_url', true);
    $background_image = get_post_meta($post->ID, '_hero_background_image', true);
?>
    <p>
        <label for="hero_subtitle"><?php esc_html_e('Sous-titre:', 'maitresse-margo'); ?></label><br>
        <input type="text" id="hero_subtitle" name="hero_subtitle" value="<?php echo esc_attr($subtitle); ?>" style="width: 100%;">
    </p>
    <p>
        <label for="hero_button_text"><?php esc_html_e('Texte du bouton:', 'maitresse-margo'); ?></label><br>
        <input type="text" id="hero_button_text" name="hero_button_text" value="<?php echo esc_attr($button_text); ?>" style="width: 100%;">
    </p>
    <p>
        <label for="hero_button_url"><?php esc_html_e('URL du bouton:', 'maitresse-margo'); ?></label><br>
        <input type="text" id="hero_button_url" name="hero_button_url" value="<?php echo esc_url($button_url); ?>" style="width: 100%;">
    </p>
    <p>
        <label for="hero_background_image"><?php esc_html_e('Image de fond:', 'maitresse-margo'); ?></label><br>
        <input type="text" id="hero_background_image" name="hero_background_image" value="<?php echo esc_url($background_image); ?>" style="width: 80%;">
        <button type="button" class="button" id="hero_background_image_button"><?php esc_html_e('Sélectionner une image', 'maitresse-margo'); ?></button>
    <div id="hero_background_image_preview" style="margin-top: 10px;">
        <?php if ($background_image) : ?>
            <img src="<?php echo esc_url($background_image); ?>" style="max-width: 300px; height: auto;">
        <?php endif; ?>
    </div>
    </p>
    <script>
        jQuery(document).ready(function($) {
            $('#hero_background_image_button').click(function(e) {
                e.preventDefault();

                var image_frame;

                if (image_frame) {
                    image_frame.open();
                    return;
                }

                image_frame = wp.media({
                    title: '<?php esc_html_e('Sélectionner une image', 'maitresse-margo'); ?>',
                    multiple: false,
                    library: {
                        type: 'image',
                    }
                });

                image_frame.on('select', function() {
                    var attachment = image_frame.state().get('selection').first().toJSON();
                    $('#hero_background_image').val(attachment.url);
                    $('#hero_background_image_preview').html('<img src="' + attachment.url + '" style="max-width: 300px; height: auto;">');
                });

                image_frame.open();
            });
        });
    </script>
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
        update_post_meta($post_id, '_hero_subtitle', sanitize_text_field($_POST['hero_subtitle']));
    }

    if (isset($_POST['hero_button_text'])) {
        update_post_meta($post_id, '_hero_button_text', sanitize_text_field($_POST['hero_button_text']));
    }

    if (isset($_POST['hero_button_url'])) {
        update_post_meta($post_id, '_hero_button_url', esc_url_raw($_POST['hero_button_url']));
    }

    if (isset($_POST['hero_background_image'])) {
        update_post_meta($post_id, '_hero_background_image', esc_url_raw($_POST['hero_background_image']));
    }
}
add_action('save_post', 'maitresse_margo_hero_save_meta_box_data');
