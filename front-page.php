<?php

/**
 * Template Name: Page d'accueil
 * Template Post Type: page
 *
 * @package MaitresseMargo
 */

get_header();
?>

<main id="primary" class="site-main">
    <!-- Section Hero -->
    <section class="hero-section">
        <div class="container">
            <h1 class="hero-title">
                <?php
                // Récupérer le titre depuis le CPT Hero ou utiliser une valeur par défaut
                $hero_id = maitresse_margo_get_latest_cpt('hero');
                if ($hero_id) {
                    echo esc_html(get_the_title($hero_id));
                } else {
                    echo 'Découvrez le site';
                }
                ?>
            </h1>
            <p class="hero-description">
                <?php
                // Récupérer la description depuis le CPT Hero ou utiliser une valeur par défaut
                if ($hero_id) {
                    $subtitle = get_post_meta($hero_id, '_hero_subtitle', true);
                    echo esc_html($subtitle);
                } else {
                    echo 'Bien plus qu\'une simple plateforme éducative, un site qui rayonne de passion, conçu pour éveiller la curiosité, séduire de jeunes enseignants et attirer les candidats au CRPE.';
                }
                ?>
            </p>
        </div>
    </section>

    <!-- Section Présentation -->
    <section class="presentation-section">
        <div class="container">
            <div class="presentation-content">
                <div class="presentation-text">
                    <h2>
                        <?php
                        $presentation_id = maitresse_margo_get_latest_cpt('presentation');
                        if ($presentation_id) {
                            echo esc_html(get_the_title($presentation_id));
                        } else {
                            echo 'Qui est Maitresse Margo ?';
                        }
                        ?>
                    </h2>
                    <div class="presentation-description">
                        <?php
                        if ($presentation_id) {
                            echo wp_kses_post(get_post_field('post_content', $presentation_id));
                        } else {
                            echo '<p>Je suis Margo, professeure des écoles passionnée, passée par les bancs de master MEEF et du CRPE comme vous ! Ce site est né de mon envie de partager mes ressources, mes astuces et un peu de bonne humeur à tous ceux qui se lancent dans cette belle aventure.</p>';
                        }
                        ?>
                    </div>
                    <?php
                    $button_text = $button_url = '';
                    if ($presentation_id) {
                        $button_text = get_post_meta($presentation_id, '_presentation_button_text', true);
                        $button_url = get_post_meta($presentation_id, '_presentation_button_url', true);
                    }
                    if (empty($button_text)) {
                        $button_text = 'En savoir plus';
                    }
                    if (empty($button_url)) {
                        $button_url = '#';
                    }
                    ?>
                    <a href="<?php echo esc_url($button_url); ?>" class="button"><?php echo esc_html($button_text); ?></a>
                </div>

                <div class="presentation-image">
                    <?php
                    if ($presentation_id && has_post_thumbnail($presentation_id)) {
                        echo get_the_post_thumbnail($presentation_id, 'medium', ['alt' => 'Image de présentation', 'class' => 'presentation-thumbnail']);
                    } else {
                        // Image par défaut
                        echo '<img src="' . esc_url(get_template_directory_uri() . '/assets/img/logo.png') . '" alt="Maitresse Margo Logo" class="logo-large">';
                    }
                    ?>
                </div>
            </div>
        </div>
    </section>


    <!-- Section Services -->
    <section class="services-section">
        <div class="container">
            <h2 class="section-title">Bienvenue sur Maitresse Margo</h2>
            <p class="section-description">Un espace pensé pour les étudiants MEEF, les candidats au CRPE et les jeunes profs des écoles. Inspi, ressources & bonne humeur au programme !</p>

            <div class="services-grid">
                <div class="service-item">
                    <div class="service-icon">
                        <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/icon-graduation.png'); ?>" alt="Icône CRPE">
                    </div>
                    <h3 class="service-title">Préparer le CRPE</h3>
                    <a href="#" class="service-link">En savoir plus</a>
                </div>

                <div class="service-item">
                    <div class="service-icon">
                        <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/icon-school.png'); ?>" alt="Icône École">
                    </div>
                    <h3 class="service-title">Préparer sa classe</h3>
                    <a href="#" class="service-link">En savoir plus</a>
                </div>

                <div class="service-item">
                    <div class="service-icon">
                        <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/icon-book.png'); ?>" alt="Icône Boutique">
                    </div>
                    <h3 class="service-title">Boutique pédagogique</h3>
                    <a href="#" class="service-link">En savoir plus</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Section Newsletter -->
    <section class="newsletter-section">
        <div class="container">
            <div class="newsletter-content">
                <div class="newsletter-icon">
                    <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/icon-newsletter.png'); ?>" alt="Icône Newsletter">
                </div>
                <div class="newsletter-text">
                    <h3 class="newsletter-title">Newsletter</h3>
                    <p class="newsletter-description">Des ressources gratuites, des conseils utiles et des surprises pédagogiques chaque mois dans ta boîte mail !</p>
                </div>
                <div class="newsletter-form">
                    <form action="#" method="post" class="newsletter-signup">
                        <input type="text" name="prenom" placeholder="Prénom" required>
                        <button type="submit" class="button">Je m'abonne</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Section À la une -->
    <section class="featured-section">
        <div class="container">
            <h2 class="section-title">À la une</h2>

            <div class="featured-grid">
                <div class="featured-item">
                    <div class="featured-image">
                        <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/icon-document.png'); ?>" alt="Fiches de révision">
                    </div>
                    <h3 class="featured-title">Fiches de révision</h3>
                </div>

                <div class="featured-item">
                    <div class="featured-image">
                        <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/icon-books.png'); ?>" alt="Fiches de révision">
                    </div>
                    <h3 class="featured-title">Fiches de révision</h3>
                </div>
            </div>

            <a href="#" class="button button-full">Accéder aux ressources</a>
        </div>
    </section>

    <!-- Section À propos -->
    <section class="about-section">
        <div class="container">
            <div class="about-content">
                <h2 class="section-title">À propos</h2>
                <div class="about-profile">
                    <div class="about-avatar">
                        <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/avatar.png'); ?>" alt="Maitresse Margo">
                    </div>
                    <div class="about-text">
                        <p>Je suis Margo, professeurs des écoles passionnée passée par les bancs du master MEEF et du CRPE comme vous ! Ce site est né de mon envie de partager mes ressources, mes astuces et un peu de bonne humeur à tous ceux qui se lancent dans cette belle aventure.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php
get_footer();
