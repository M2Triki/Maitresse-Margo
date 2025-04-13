<?php

/**
 * Maitresse Margo Theme Functions
 *
 * @package MaitresseMargo
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Définir les constantes du thème
define('MAITRESSE_MARGO_VERSION', '1.0.0');
define('MAITRESSE_MARGO_DIR', get_template_directory());
define('MAITRESSE_MARGO_URI', get_template_directory_uri());

/**
 * Configuration du thème
 */
function maitresse_margo_setup()
{
    // Ajouter la prise en charge des fonctionnalités WordPress
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));
    add_theme_support('customize-selective-refresh-widgets');
    add_theme_support('custom-logo', array(
        'height'      => 250,
        'width'       => 250,
        'flex-width'  => true,
        'flex-height' => true,
    ));

    // Enregistrer les menus de navigation
    register_nav_menus(array(
        'primary' => esc_html__('Menu Principal', 'maitresse-margo'),
        'footer'  => esc_html__('Menu Footer', 'maitresse-margo'),
    ));
}
add_action('after_setup_theme', 'maitresse_margo_setup');

/**
 * Enregistrer les scripts et styles
 */
function maitresse_margo_scripts()
{
    // Styles
    wp_enqueue_style('maitresse-margo-style', get_stylesheet_uri(), array(), MAITRESSE_MARGO_VERSION);

    // Vérifier si les fichiers CSS existent avant de les inclure
    if (file_exists(MAITRESSE_MARGO_DIR . '/assets/css/style.css')) {
        wp_enqueue_style('maitresse-margo-main', MAITRESSE_MARGO_URI . '/assets/css/style.css', array(), MAITRESSE_MARGO_VERSION);
    }

    if (file_exists(MAITRESSE_MARGO_DIR . '/assets/css/responsive.css')) {
        wp_enqueue_style('maitresse-margo-responsive', MAITRESSE_MARGO_URI . '/assets/css/responsive.css', array(), MAITRESSE_MARGO_VERSION);
    }

    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css', array(), '5.15.3');

    // Scripts
    if (file_exists(MAITRESSE_MARGO_DIR . '/assets/js/main.js')) {
        wp_enqueue_script('maitresse-margo-main', MAITRESSE_MARGO_URI . '/assets/js/main.js', array('jquery'), MAITRESSE_MARGO_VERSION, true);
    }

    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'maitresse_margo_scripts');

/**
 * Inclure les fichiers des Custom Post Types
 */
// Inclure le fichier helpers.php s'il existe
$helpers_file = MAITRESSE_MARGO_DIR . '/inc/helpers.php';
if (file_exists($helpers_file)) {
    require $helpers_file;
}

// Créer le dossier inc/cpt s'il n'existe pas
$cpt_dir = MAITRESSE_MARGO_DIR . '/inc/cpt';
if (!file_exists($cpt_dir)) {
    wp_mkdir_p($cpt_dir);
}

// Liste des fichiers CPT à inclure
$cpt_files = array(
    'cpt-hero.php',
    'cpt-presentation.php',
    'cpt-services.php',
    'cpt-newsletter.php',
    'cpt-featured.php',
    'cpt-about.php'
);

// Inclure chaque fichier CPT s'il existe
foreach ($cpt_files as $cpt_file) {
    $file_path = $cpt_dir . '/' . $cpt_file;
    if (file_exists($file_path)) {
        require $file_path;
    }
}
