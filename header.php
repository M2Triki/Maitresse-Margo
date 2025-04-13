<?php

/**
 * Header template
 *
 * @package MaitresseMargo
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>

    <div id="page" class="site">
        <header id="masthead" class="site-header">
            <div class="container">
                <div class="header-inner">
                    <div class="site-branding">
                        <?php if (has_custom_logo()) : the_custom_logo();
                        else : ?>
                            <a href="<?php echo esc_url(home_url('/')); ?>" class="site-logo">
                                <img src="<?php echo esc_url(MAITRESSE_MARGO_URI . '/assets/img/logo.png'); ?>" alt="<?php bloginfo('name'); ?>">
                            </a>
                        <?php endif; ?>
                    </div>

                    <!-- Menu burger -->
                    <button class="menu-toggle" aria-label="Ouvrir le menu">
                        <span class="burger-line"></span>
                        <span class="burger-line"></span>
                        <span class="burger-line"></span>
                    </button>

                    <nav id="site-navigation" class="main-navigation">
                        <?php
                        wp_nav_menu(array(
                            'theme_location' => 'primary',
                            'menu_id'        => 'primary-menu',
                            'container'      => false,
                        ));
                        ?>
                    </nav>
                </div>
            </div>
        </header>


        <div id="content" class="site-content">