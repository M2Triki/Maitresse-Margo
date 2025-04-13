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
        <div class="footer-content">
            <!-- Logo -->
            <div class="footer-logo">
                <a href="<?php echo esc_url(home_url('/')); ?>">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/logo.jpg" alt="Maitresse Margo">
                </a>
            </div>

            <!-- Menu -->
            <nav class="footer-menu">
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'footer',
                    'menu_class'     => 'footer-links',
                    'container'      => false,
                    'depth'          => 1,
                ));
                ?>
            </nav>

            <!-- Réseaux sociaux
            <div class="footer-social">
                <a href="#" target="_blank"><i class="fab fa-facebook-f"></i></a>
                <a href="#" target="_blank"><i class="fab fa-instagram"></i></a>
                <a href="#" target="_blank"><i class="fab fa-twitter"></i></a>
            </div> -->
        </div>

        <div class="footer-bottom">
            <p class="copyright">© 2025 Maitresse Margo — Tous droits réservés.</p>
        </div>
    </div>
</footer>

</div><!-- #page -->

<?php wp_footer(); ?>
</body>

</html>