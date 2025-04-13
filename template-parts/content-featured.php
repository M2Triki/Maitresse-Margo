<?php

/**
 * Template part pour afficher la section À la une
 *
 * @package MaitresseMargo
 */

// Récupérer les éléments À la une
$featured_items = maitresse_margo_get_all_cpt('featured');

// Éléments par défaut si aucun n'est défini
$default_featured = array(
    array(
        'title' => 'Fiches de révision',
        'icon' => 'fiches',
        'link' => '#'
    ),
    array(
        'title' => 'Fiches de révision',
        'icon' => 'books',
        'link' => '#'
    )
);

// Utiliser les éléments définis ou les éléments par défaut
if (empty($featured_items)) {
    $items_to_display = $default_featured;
} else {
    $items_to_display = array();
    foreach ($featured_items as $item) {
        $items_to_display[] = array(
            'title' => $item->post_title,
            'icon' => get_post_meta($item->ID, '_featured_icon', true),
            'link' => get_post_meta($item->ID, '_featured_link_url', true)
        );
    }
}

// Récupérer les paramètres de la section
$section_id = maitresse_margo_get_latest_cpt('featured_section');
$section_title = 'À la une';
$button_text = 'Accéder aux ressources';
$button_url = '/ressources';

if ($section_id) {
    $section_title = get_the_title($section_id);
    $meta_button_text = get_post_meta($section_id, '_featured_section_button_text', true);
    if (!empty($meta_button_text)) {
        $button_text = $meta_button_text;
    }

    $meta_button_url = get_post_meta($section_id, '_featured_section_button_url', true);
    if (!empty($meta_button_url)) {
        $button_url = $meta_button_url;
    }
}
?>

<section class="featured-section">
    <div class="container">
        <h2 class="section-title"><?php echo esc_html($section_title); ?></h2>

        <div class="featured-grid">
            <?php foreach ($items_to_display as $item) :
                $icon = !empty($item['icon']) ? $item['icon'] : 'fiches';
                $link = !empty($item['link']) ? $item['link'] : '#';
            ?>
                <div class="featured-item">
                    <div class="icon-primary">
                        <?php echo maitresse_margo_get_svg($icon); ?>
                    </div>
                    <h3 class="featured-title"><?php echo esc_html($item['title']); ?></h3>
                </div>
            <?php endforeach; ?>
        </div>

        <a href="<?php echo esc_url($button_url); ?>" class="button button-full"><?php echo esc_html($button_text); ?></a>
    </div>
</section>