<?php

/**
 * Template part pour afficher la section Présentation
 *
 * @package MaitresseMargo
 */

// Récupérer le dernier élément Presentation
$presentation_id = maitresse_margo_get_latest_cpt('presentation');

if (!$presentation_id) {
    return;
}

// Récupérer les données avec get_post_meta uniquement
$title = get_the_title($presentation_id);
$content = get_post_field('post_content', $presentation_id);
$image = get_post_meta($presentation_id, '_presentation_image', true);
$button_text = get_post_meta($presentation_id, '_presentation_button_text', true);
$button_url = get_post_meta($presentation_id, '_presentation_button_url', true);
?>

<section class="presentation-section section">
    <div class="container">
        <h2 class="section-title"><?php echo esc_html($title); ?></h2>

        <div class="presentation-content">
            <div class="row">
                <div class="col-md-6">
                    <div class="presentation-text">
                        <?php echo wp_kses_post($content); ?>

                        <?php if ($button_text && $button_url) : ?>
                            <a href="<?php echo esc_url($button_url); ?>" class="button"><?php echo esc_html($button_text); ?></a>
                        <?php endif; ?>
                    </div>
                </div>

                <?php if ($image) : ?>
                    <div class="col-md-6">
                        <div class="presentation-image">
                            <img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr($title); ?>">
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>