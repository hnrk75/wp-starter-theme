<?php
/**
 * Block Template for My Custom Block.
 *
 * @author Henrik Pettersson
 * @package WP Starter Theme
 */

$block_id = ! empty( $block['anchor'] ) ? esc_attr( $block['anchor'] ) : 'my-custom-' . esc_attr( $block['id'] );

$class_name = 'my-custom-block';
if ( ! empty( $block['className'] ) ) {
	$class_name .= ' ' . esc_attr( $block['className'] );
}
if ( ! empty( $block['align'] ) ) {
	$class_name .= ' align' . esc_attr( $block['align'] );
}

$heading = get_field( 'my_custom_block_heading' );
$content = get_field( 'my_custom_block_content' );
$image   = get_field( 'my_custom_block_image' );

$aria_label = $heading ? wp_strip_all_tags( $heading, true ) : __( 'Anpassat innehållsblock', 'wp-starter-theme' );

?>

<div class="container">
	<section 
	id="<?php echo esc_attr( $block_id ); ?>" 
	class="<?php echo esc_attr( $class_name ); ?>" 
	role="region" 
	aria-label="<?php echo esc_attr( $aria_label ); ?>">
		
		<?php if ( $heading ) : ?>
			<h2><?php echo esc_html( $heading ); ?></h2>
		<?php endif; ?>

		<?php if ( $image ) : ?>
			<img 
				src="<?php echo esc_url( $image['url'] ); ?>" 
				alt="<?php echo isset( $image['alt'] ) && $image['alt'] !== '' ? esc_attr( $image['alt'] ) : ''; ?>" 
				class="img-fluid"
			>
		<?php endif; ?>

		<?php if ( $content ) : ?>
			<p><?php echo wp_kses_post( $content ); ?></p>
		<?php endif; ?>

	</section>
</div>
