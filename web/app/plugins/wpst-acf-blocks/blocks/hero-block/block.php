<?php
/**
 * Hero Block template.
 *
 * Fields:
 *  wpst_hero_bg_type    – 'color' | 'image' | 'video'
 *  wpst_hero_bg_color   – 'dark' | 'primary' | ... (när bg_type = color)
 *  wpst_hero_bg_image   – image ID (när bg_type = image)
 *  wpst_hero_bg_video   – MP4-URL (när bg_type = video)
 *  wpst_hero_heading    – text, renderas som h1
 *  wpst_hero_ingress    – textarea
 *
 * Alltid full bredd (alignfull). Inget alignment-val för redaktören.
 *
 * @author Henrik Pettersson
 * @package WPST ACF Blocks
 */

$bg_type = get_field( 'wpst_hero_bg_type' );
$bg_type = $bg_type ? $bg_type : 'color';
$heading = get_field( 'wpst_hero_heading' );
$ingress = get_field( 'wpst_hero_ingress' );

// Placeholder when block has no content yet.
if ( empty( $heading ) && empty( $ingress ) ) : ?>
	<div class="acf-block-placeholder">
		<div class="acf-block-placeholder__inner">
			<span class="dashicons dashicons-format-image"></span>
			<p><?php echo esc_html__( 'Hero — fyll i rubrik och välj bakgrund i högerpanelen.', 'wpst-acf-blocks' ); ?></p>
		</div>
	</div>
	<?php
	return;
endif;

$block_id = ! empty( $block['anchor'] ) ? esc_attr( $block['anchor'] ) : 'hero-block-' . esc_attr( $block['id'] );

$class_name = 'wpst-block hero-block alignfull';

if ( 'color' === $bg_type ) {
	$bg_color = get_field( 'wpst_hero_bg_color' );
	$bg_color = $bg_color ? $bg_color : 'dark';
	$class_name .= ' has-bg--' . $bg_color;
} else {
	$class_name .= ' hero-block--has-media';
}

if ( ! empty( $block['className'] ) ) {
	$class_name .= ' ' . esc_attr( $block['className'] );
}
?>
<section
	id="<?php echo esc_attr( $block_id ); ?>"
	class="<?php echo esc_attr( $class_name ); ?>"
	<?php if ( $heading ) : ?>
		aria-labelledby="<?php echo esc_attr( $block_id ); ?>-heading"
	<?php else : ?>
		aria-label="<?php echo esc_attr__( 'Hero', 'wpst-acf-blocks' ); ?>"
	<?php endif; ?>
>
	<?php if ( 'image' === $bg_type ) : ?>
		<?php $image_id = get_field( 'wpst_hero_bg_image' ); ?>
		<?php if ( $image_id ) : ?>
			<div class="hero-block__bg" aria-hidden="true">
				<?php echo wp_get_attachment_image( $image_id, 'full', false, array( 'class' => 'hero-block__bg-img' ) ); ?>
			</div>
		<?php endif; ?>
	<?php endif; ?>

	<?php if ( 'video' === $bg_type ) : ?>
		<?php $video_url = get_field( 'wpst_hero_bg_video' ); ?>
		<?php if ( $video_url ) : ?>
			<div class="hero-block__bg" aria-hidden="true">
				<video class="hero-block__bg-video" autoplay muted loop playsinline>
					<source src="<?php echo esc_url( $video_url ); ?>" type="video/mp4">
				</video>
			</div>
		<?php endif; ?>
	<?php endif; ?>

	<div class="wpst-block__inner">
		<div class="hero-block__content">
			<?php if ( $heading ) : ?>
				<h1 id="<?php echo esc_attr( $block_id ); ?>-heading" class="hero-block__heading">
					<?php echo esc_html( $heading ); ?>
				</h1>
			<?php endif; ?>

			<?php if ( $ingress ) : ?>
				<p class="hero-block__ingress">
					<?php echo esc_html( $ingress ); ?>
				</p>
			<?php endif; ?>
		</div>
	</div>
</section>
