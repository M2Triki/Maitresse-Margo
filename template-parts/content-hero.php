<?php

/**
 * Template part pour afficher la section Hero
 *
 * @package MaitresseMargo
 */

// Récupérer le dernier élément Hero
$hero_id = maitresse_margo_get_latest_cpt('hero');

// Titre et sous-titre par défaut
$title = 'Bienvenue sur Maitresse Margo';
$subtitle = 'Un espace pensé pour les étudiants MEEF, les candidats au CRPE et les jeunes profs des écoles. Inspi, ressources & bonne humeur au programme !';

// Si un élément Hero existe, récupérer ses données
if ($hero_id) {
    $title = get_the_title($hero_id);
    $subtitle_meta = get_post_meta($hero_id, '_hero_subtitle', true);
    if (!empty($subtitle_meta)) {
        $subtitle = $subtitle_meta;
    }
}
?>

<section class="hero-section">
    <div class="container">
        <h1 class="hero-title"><?php echo esc_html($title); ?></h1>
        <p class="hero-description"><?php echo esc_html($subtitle); ?></p>
    </div>
</section>