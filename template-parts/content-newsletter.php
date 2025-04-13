<?php

/**
 * Template part pour afficher la section Newsletter
 *
 * @package MaitresseMargo
 */

// Récupérer le dernier élément Newsletter
$newsletter_id = maitresse_margo_get_latest_cpt('newsletter');

// Valeurs par défaut
$title = 'Newsletter';
$description = 'Des ressources gratuites, des conseils utiles et des surprises pédagogiques chaque mois dans ta boîte mail !';
$button_text = 'Je m\'abonne';
$form_action = '#';

// Si un élément Newsletter existe, récupérer ses données
if ($newsletter_id) {
    $title = get_the_title($newsletter_id);
    $meta_description = get_post_meta($newsletter_id, '_newsletter_description', true);
    if (!empty($meta_description)) {
        $description = $meta_description;
    }

    $meta_button_text = get_post_meta($newsletter_id, '_newsletter_button_text', true);
    if (!empty($meta_button_text)) {
        $button_text = $meta_button_text;
    }

    $meta_form_action = get_post_meta($newsletter_id, '_newsletter_form_action', true);
    if (!empty($meta_form_action)) {
        $form_action = $meta_form_action;
    }
}
?>

<section class="newsletter-section">
    <div class="container">
        <div class="newsletter-content">
            <div class="service-icon icon-primary">
                <?php echo maitresse_margo_get_svg('email'); ?>
            </div>
            <div class="newsletter-text">
                <h3 class="newsletter-title"><?php echo esc_html($title); ?></h3>
                <p class="newsletter-description"><?php echo esc_html($description); ?></p>
            </div>
            <div class="newsletter-form">
                <form action="<?php echo esc_url($form_action); ?>" method="post" class="newsletter-signup">
                    <input type="text" name="prenom" placeholder="Prénom" required>
                    <button type="submit" class="button"><?php echo esc_html($button_text); ?></button>
                </form>
            </div>
        </div>
    </div>
</section>