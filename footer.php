<?php

/**
 * Footer template
 *
 * @package MaitresseMargo
 */
?>

</div><!-- #content -->

<footer id="colophon" class="site-footer">
    <div class="container">
        <div class="footer-widgets">
            <div class="footer-widget">
                <h3 class="footer-widget-title">Préparer sa classe</h3>
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'footer',
                    'menu_id'        => 'footer-menu-1',
                    'container'      => false,
                    'depth'          => 1,
                ));
                ?>
            </div>
            <div class="footer-widget">
                <h3 class="footer-widget-title">CRPE</h3>
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'footer',
                    'menu_id'        => 'footer-menu-2',
                    'container'      => false,
                    'depth'          => 1,
                ));
                ?>
            </div>
            <div class="footer-widget">
                <h3 class="footer-widget-title">À propos</h3>
                <p>Maitresse Margo est un site dédié aux étudiants MEEF, aux candidats au CRPE et aux jeunes professeurs des écoles.</p>
                <div class="social-links">
                    <a href="#" target="_blank"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" target="_blank"><i class="fab fa-instagram"></i></a>
                    <a href="#" target="_blank"><i class="fab fa-twitter"></i></a>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <div class="footer-links">
                <a href="<?php echo esc_url(home_url('/mentions-legales')); ?>">Mentions légales</a>
                <a href="<?php echo esc_url(home_url('/politique-de-confidentialite')); ?>">Politique de confidentialité</a>
                <a href="<?php echo esc_url(home_url('/politique-des-cookies')); ?>">Politique des cookies</a>
            </div>
            <p class="copyright">&copy; <?php echo date('Y'); ?> Maitresse Margo. Tous droits réservés.</p>
        </div>
    </div>
</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>

</html>