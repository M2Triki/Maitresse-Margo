<?php

/**
 * Template part pour afficher la section Témoignages
 *
 * @package MaitresseMargo
 */

// Récupérer tous les témoignages
$testimonials = maitresse_margo_get_all_cpt('testimonial');

if (empty($testimonials)) {
    return;
}
?>

<section class="testimonials-section section">
    <div class="container">
        <h2 class="section-title"><?php esc_html_e('Témoignages', 'maitresse-margo'); ?></h2>

        <div class="testimonials-slider">
            <?php foreach ($testimonials as $testimonial) :
                $testimonial_id = $testimonial->ID;
                $content = $testimonial->post_content;
                $author = get_post_meta($testimonial_id, '_testimonial_author', true);
                $position = get_post_meta($testimonial_id, '_testimonial_position', true);
                $avatar = get_post_meta($testimonial_id, '_testimonial_avatar', true);
            ?>
                <div class="testimonial-item">
                    <div class="testimonial-content">
                        <?php echo wp_kses_post($content); ?>
                    </div>

                    <div class="testimonial-author-info">
                        <?php if ($avatar) : ?>
                            <div class="testimonial-avatar">
                                <img src="<?php echo esc_url($avatar); ?>" alt="<?php echo esc_attr($author); ?>">
                            </div>
                        <?php endif; ?>

                        <div class="testimonial-author-details">
                            <?php if ($author) : ?>
                                <div class="testimonial-author"><?php echo esc_html($author); ?></div>
                            <?php endif; ?>

                            <?php if ($position) : ?>
                                <div class="testimonial-position"><?php echo esc_html($position); ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>