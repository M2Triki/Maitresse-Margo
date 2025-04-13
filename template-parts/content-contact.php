<?php

/**
 * Template part pour afficher la section Contact
 *
 * @package MaitresseMargo
 */

// Récupérer le dernier élément Contact
$contact_id = maitresse_margo_get_latest_cpt('contact');

if (!$contact_id) {
    return;
}

// Récupérer les données avec get_post_meta uniquement
$title = get_the_title($contact_id);
$email = get_post_meta($contact_id, '_contact_email', true);
$phone = get_post_meta($contact_id, '_contact_phone', true);
$address = get_post_meta($contact_id, '_contact_address', true);
$map_embed = get_post_meta($contact_id, '_contact_map_embed', true);
$form_shortcode = get_post_meta($contact_id, '_contact_form_shortcode', true);
?>

<section class="contact-section section">
    <div class="container">
        <h2 class="section-title"><?php echo esc_html($title); ?></h2>

        <div class="contact-content">
            <div class="row">
                <div class="col-md-6">
                    <div class="contact-info">
                        <?php if ($email) : ?>
                            <div class="contact-item">
                                <div class="contact-icon">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <div class="contact-text">
                                    <a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if ($phone) : ?>
                            <div class="contact-item">
                                <div class="contact-icon">
                                    <i class="fas fa-phone"></i>
                                </div>
                                <div class="contact-text">
                                    <a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', $phone)); ?>"><?php echo esc_html($phone); ?></a>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if ($address) : ?>
                            <div class="contact-item">
                                <div class="contact-icon">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <div class="contact-text">
                                    <?php echo nl2br(esc_html($address)); ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>

                    <?php if ($map_embed) : ?>
                        <div class="contact-map">
                            <?php echo $map_embed; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="col-md-6">
                    <div class="contact-form">
                        <?php if ($form_shortcode) : ?>
                            <?php echo do_shortcode($form_shortcode); ?>
                        <?php else : ?>
                            <p><?php esc_html_e('Veuillez ajouter un shortcode de formulaire de contact dans les paramètres.', 'maitresse-margo'); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>