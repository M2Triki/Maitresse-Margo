<?php

/**
 * Template part pour afficher la section Services
 *
 * @package MaitresseMargo
 */

// Récupérer tous les services
$services = maitresse_margo_get_all_cpt('service');

// Services par défaut si aucun n'est défini
$default_services = array(
    array(
        'title' => 'Préparer le CRPE',
        'icon' => 'graduate',
        'link' => '#'
    ),
    array(
        'title' => 'Préparer sa classe',
        'icon' => 'school',
        'link' => '#'
    ),
    array(
        'title' => 'Boutique pédagogique',
        'icon' => 'book',
        'link' => '#'
    )
);

// Utiliser les services définis ou les services par défaut
if (empty($services)) {
    $services_to_display = $default_services;
} else {
    $services_to_display = array();
    foreach ($services as $service) {
        $services_to_display[] = array(
            'title' => $service->post_title,
            'icon' => get_post_meta($service->ID, '_service_icon', true),
            'link' => get_post_meta($service->ID, '_service_link_url', true)
        );
    }
}
?>

<section class="services-section">
    <div class="container">
        <div class="services-grid">
            <?php foreach ($services_to_display as $service) :
                $icon = !empty($service['icon']) ? $service['icon'] : 'graduate';
                $link = !empty($service['link']) ? $service['link'] : '#';
            ?>
                <div class="service-item">
                    <div class="service-icon icon-primary">
                        <?php echo maitresse_margo_get_svg($icon); ?>
                    </div>
                    <h3 class="service-title"><?php echo esc_html($service['title']); ?></h3>
                    <!-- <a href="<?php echo esc_url($link); ?>" class="service-link">En savoir plus</a> -->
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>