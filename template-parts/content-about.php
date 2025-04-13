<?php

/**
 * Template part pour afficher la section À propos
 *
 * @package MaitresseMargo
 */

// Récupérer le dernier élément À propos
$about_id = maitresse_margo_get_latest_cpt('about');

// Valeurs par défaut
$title = 'À propos';
$content = '<p>Je suis Margo, professeure des écoles passionnée passée par les bancs du master MEEF et du CRPE comme vous ! Ce site est né de mon envie de partager mes ressources, mes astuces et un peu de bonne humeur à tous ceux qui se lancent dans cette belle aventure.</p>';
$avatar = get_template_directory_uri() . '/assets/img/avatar.png';

// Si un élément À propos existe, récupérer ses données
if ($about_id) {
    $title = get_the_title($about_id);
    $post_content = get_post_field('post_content', $about_id);
    if (!empty($post_content)) {
        $content = $post_content;
    }

    $meta_avatar = get_post_meta($about_id, '_about_avatar', true);
    if (!empty($meta_avatar)) {
        $avatar = $meta_avatar;
    } elseif (has_post_thumbnail($about_id)) {
        $avatar = get_the_post_thumbnail_url($about_id, 'thumbnail');
    }
}
?>

<section class="about-section" id="a-propos">
    <div class="container">
        <div class="about-content">
            <h2 class="section-title"><?php echo esc_html($title); ?></h2>
            <div class="about-profile">
                <div class="about-avatar">
                    <img src="<?php echo esc_url($avatar); ?>" alt="<?php echo esc_attr($title); ?>">
                </div>
                <div class="about-text">
                    <?php echo wp_kses_post($content); ?>
                </div>
            </div>
        </div>
    </div>
</section>