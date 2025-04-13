<?php

/**
 * Template part pour afficher la section Hero
 *
 * @package MaitresseMargo
 */

// Récupérer le dernier élément Hero
$hero_id = maitresse_margo_get_latest_cpt('hero');

if (!$hero_id) {
    return;
}

// Récupérer les données avec get_post_meta uniquement
$title = get_the_title($hero_id);
$subtitle = get_post_meta($hero_id, '_hero_subtitle', true);
$button_text = get_post_meta($hero_id, '_hero_button_text', true);
$button_url = get_post_meta($hero_id, '_hero_button_url', true);
$background_image = get_post_meta($hero_id, '_hero_background_image', true);

// Style pour l'image de fond
$style = '';
if ($background_image) {
    $style = 'style="background-image: url(' . esc_url($background_image) . '); background-size: cover; background-position: center;"';
}
?>

<section class="hero-section" <?php echo $style; ?>>
    <div class="container">
        <h1 class="hero-title"><?php echo esc_html($title); ?></h1>

        <?php if ($subtitle) : ?>
            <p class="hero-description"><?php echo esc_html($subtitle); ?></p>
        <?php endif; ?>

        <?php if ($button_text && $button_url) : ?>
            <a href="<?php echo esc_url($button_url); ?>" class="button"><?php echo esc_html($button_text); ?></a>
        <?php endif; ?>
    </div>
</section>