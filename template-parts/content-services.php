<?php

/**
 * Template part pour afficher la section Services
 *
 * @package MaitresseMargo
 */

// Récupérer tous les services
$services = maitresse_margo_get_all_cpt('service');

if (empty($services)) {
    return;
}
?>

<section class="services-section section">
    <div class="container">
        <h2 class="section-title"><?php esc_html_e('Nos Services', 'maitresse-margo'); ?></h2>

        <div class="services-grid">
            <?php foreach ($services as $service) :
                $service_id = $service->ID;
                $title = $service->post_title;
                $content = $service->post_content;
                $icon = get_post_meta($service_id, '_service_icon', true);
                $link_text = get_post_meta($service_id, '_service_link_text', true);
                $link_url = get_post_meta($service_id, '_service_link_url', true);
            ?>
                <div class="service-item">
                    <?php if ($icon) : ?>
                        <div class="service-icon">
                            <i class="<?php echo esc_attr($icon); ?>"></i>
                        </div>
                    <?php endif; ?>

                    <h3 class="service-title"><?php echo esc_html($title); ?></h3>

                    <div class="service-content">
                        <?php echo wp_kses_post($content); ?>
                    </div>

                    <?php if ($link_text && $link_url) : ?>
                        <a href="<?php echo esc_url($link_url); ?>" class="service-link"><?php echo esc_html($link_text); ?></a>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>