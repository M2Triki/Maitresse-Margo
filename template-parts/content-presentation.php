<?php

/**
 * Template part pour afficher la section Présentation
 *
 * @package MaitresseMargo
 */

// Récupérer le dernier élément Présentation
$presentation_id = maitresse_margo_get_latest_cpt('presentation');

// Valeurs par défaut
$title = 'Qui est Maitresse Margo ?';
$content = '<p>Je suis Margo, professeure des écoles passionnée, passée par les bancs de master MEEF et du CRPE comme vous ! Ce site est né de mon envie de partager mes ressources, mes astuces et un peu de bonne humeur à tous ceux qui se lancent dans cette belle aventure.</p>';
$button_text = 'En savoir plus';
$button_url = '#';
$image = get_template_directory_uri() . '/assets/img/logo.png';

// Si un élément Présentation existe, récupérer ses données
if ($presentation_id) {
    $title = get_the_title($presentation_id);
    $post_content = get_post_field('post_content', $presentation_id);
    if (!empty($post_content)) {
        $content = $post_content;
    }

    $meta_button_text = get_post_meta($presentation_id, '_presentation_button_text', true);
    if (!empty($meta_button_text)) {
        $button_text = $meta_button_text;
    }

    $meta_button_url = get_post_meta($presentation_id, '_presentation_button_url', true);
    if (!empty($meta_button_url)) {
        $button_url = $meta_button_url;
    }

    if (has_post_thumbnail($presentation_id)) {
        $image = get_the_post_thumbnail_url($presentation_id, 'medium');
    }
}
?>

<section class="presentation-section">
    <div class="container">
        <div class="presentation-content">
            <div class="presentation-text">
                <h2><?php echo esc_html($title); ?></h2>
                <div class="presentation-description">
                    <?php echo wp_kses_post($content); ?>
                </div>
                <a href="<?php echo esc_url($button_url); ?>" class="button"><?php echo esc_html($button_text); ?></a>
            </div>
            <div class="presentation-image">
                <img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr($title); ?>" class="presentation-thumbnail">
            </div>
        </div>
    </div>
</section>