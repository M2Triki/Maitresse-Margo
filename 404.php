<?php

/**
 * 404 template
 *
 * @package MaitresseMargo
 */

get_header();
?>

<main id="primary" class="site-main">
    <div class="container">
        <section class="error-404 not-found">
            <header class="page-header">
                <h1 class="page-title"><?php esc_html_e('Oups! Cette page est introuvable.', 'maitresse-margo'); ?></h1>
            </header><!-- .page-header -->

            <div class="page-content">
                <p><?php esc_html_e('Il semble que rien n\'a été trouvé à cet endroit. Essayez peut-être une recherche?', 'maitresse-margo'); ?></p>

                <?php get_search_form(); ?>

                <div class="error-suggestions">
                    <h2><?php esc_html_e('Voici quelques liens utiles:', 'maitresse-margo'); ?></h2>
                    <ul>
                        <li><a href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('Accueil', 'maitresse-margo'); ?></a></li>
                        <li><a href="<?php echo esc_url(home_url('/blog')); ?>"><?php esc_html_e('Blog', 'maitresse-margo'); ?></a></li>
                        <li><a href="<?php echo esc_url(home_url('/contact')); ?>"><?php esc_html_e('Contact', 'maitresse-margo'); ?></a></li>
                    </ul>
                </div>
            </div><!-- .page-content -->
        </section><!-- .error-404 -->
    </div>
</main><!-- #primary -->

<?php
get_footer();
