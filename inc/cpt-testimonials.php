<?php

/**
 * CPT Testimonials
 *
 * @package MaitresseMargo
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Enregistrer le CPT Testimonials
 */
function maitresse_margo_register_testimonials_cpt()
{
    $labels = array(
        'name'                  => _x('Témoignages', 'Post type general name', 'maitresse-margo'),
        'singular_name'         => _x('Témoignage', 'Post type singular name', 'maitresse-margo'),
        'menu_name'             => _x('Témoignages', 'Admin Menu text', 'maitresse-margo'),
        'name_admin_bar'        => _x('Témoignage', 'Add New on Toolbar', 'maitresse-margo'),
        'add_new'               => __('Ajouter', 'maitresse-margo'),
        'add_new_item'          => __('Ajouter un témoignage', 'maitresse-margo'),
        'new_item'              => __('Nouveau témoignage', 'maitresse-margo'),
        'edit_item'             => __('Modifier le témoignage', 'maitresse-margo'),
        'view_item'             => __('Voir le témoignage', 'maitresse-margo'),
        'all_items'             => __('Tous les témoignages', 'maitresse-margo'),
        'search_items'          => __('Rechercher des témoignages', 'maitresse-margo'),
        'not_found'             => __('Aucun témoignage trouvé.', 'maitresse-margo'),
        'not_found_in_trash'    => __('Aucun témoignage trouvé dans la corbeille.', 'maitresse-margo'),
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
        'menu_icon'          => 'dashicons-format-quote',
        'supports'           => array('title', 'editor'),
    );

    register_post_type('testimonial', $args);
}
add_action('init', 'maitresse_margo_register_testimonials_cpt');

/**
 * Ajouter les champs personnalisés pour le CPT Testimonials
 */
function maitresse_margo_testimonials_meta_boxes()
{
    add_meta_box(
        'testimonial_details',
        __('Détails du témoignage', 'maitresse-margo'),
        'maitresse_margo_testimonials_meta_box_callback',
        'testimonial',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'maitresse_margo_testimonials_meta_boxes');

/**
 * Callback pour afficher les champs personnalisés
 */
function maitresse_margo_testimonials_meta_box_callback($post)
{
    wp_nonce_field('maitresse_margo_testimonials_save_meta_box_data', 'maitresse_margo_testimonials_meta_box_nonce');

    $author = get_post_meta($post->ID, '_testimonial_author', true);
    $position = get_post_meta($post->ID, '_testimonial_position', true);
    $avatar = get_post_meta($post->ID, '_testimonial_avatar', true);
?>
    <p>
        <label for="testimonial_author"><?php esc_html_e('Auteur:', 'maitresse-margo'); ?></label><br>
        <input type="text" id="testimonial_author" name="testimonial_author" value="<?php echo esc_attr($author); ?>" style="width: 100%;">
    </p>
    <p>
        <label for="testimonial_position"><?php esc_html_e('Poste/Position:', 'maitresse-margo'); ?></label><br>
        <input type="text" id="testimonial_position" name="testimonial_position" value="<?php echo esc_attr($position); ?>" style="width: 100%;">
    </p>
    <p>
        <label for="testimonial_avatar"><?php esc_html_e('Avatar:', 'maitresse-margo'); ?></label><br>
        <input type="text" id="testimonial_avatar" name="testimonial_avatar" value="<?php echo esc_url($avatar); ?>" style="width: 80%;">
        <button type="button" class="button" id="testimonial_avatar_button"><?php esc_html_e('Sélectionner une image', 'maitresse-margo'); ?></button>
    <div id="testimonial_avatar_preview" style="margin-top: 10px;">
        <?php if ($avatar) : ?>
            <img src="<?php echo esc_url($avatar); ?>" style="max-width: 100px; height: auto; border-radius: 50%;">
        <?php endif; ?>
    </div>
    </p>
    <script>
        jQuery(document).ready(function($) {
            $('#testimonial_avatar_button').click(function(e) {
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
                    $('#testimonial_avatar').val(attachment.url);
                    $('#testimonial_avatar_preview').html('<img src="' + attachment.url + '" style="max-width: 100px; height: auto; border-radius: 50%;">');
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
function maitresse_margo_testimonials_save_meta_box_data($post_id)
{
    if (!isset($_POST['maitresse_margo_testimonials_meta_box_nonce'])) {
        return;
    }

    if (!wp_verify_nonce($_POST['maitresse_margo_testimonials_meta_box_nonce'], 'maitresse_margo_testimonials_save_meta_box_data')) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    if (isset($_POST['testimonial_author'])) {
        update_post_meta($post_id, '_testimonial_author', sanitize_text_field($_POST['testimonial_author']));
    }

    if (isset($_POST['testimonial_position'])) {
        update_post_meta($post_id, '_testimonial_position', sanitize_text_field($_POST['testimonial_position']));
    }

    if (isset($_POST['testimonial_avatar'])) {
        update_post_meta($post_id, '_testimonial_avatar', esc_url_raw($_POST['testimonial_avatar']));
    }
}
add_action('save_post', 'maitresse_margo_testimonials_save_meta_box_data');
