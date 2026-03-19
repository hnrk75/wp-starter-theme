<?php
/**
 * Block Template for Hero Block.
 *
 * @author Henrik Pettersson
 * @package WP Starter Theme
 */

$block_id = ! empty( $block['anchor'] ) ? esc_attr( $block['anchor'] ) : 'hero-block-' . esc_attr( $block['id'] );

$class_name = 'hero-block';
if ( ! empty( $block['className'] ) ) {
	$class_name .= ' ' . esc_attr( $block['className'] );
}
if ( ! empty( $block['align'] ) ) {
	$class_name .= ' align' . esc_attr( $block['align'] );
}

$image   = get_field( 'acf_block_hero_background_image' );
$heading = get_field( 'acf_block_hero_heading' );

$raw_label  = $heading ? wp_strip_all_tags( $heading, true ) : __( 'Hero block', 'wp-starter-theme' );
$aria_label = $raw_label;

$background_style = '';
if ( ! empty( $image ) && ! empty( $image['url'] ) ) {
	$background_style = 'background-image: url(' . esc_url( $image['url'] ) . ');';
}
?>
<section
	id="<?php echo esc_attr( $block_id ); ?>"
	class="<?php echo esc_attr( $class_name ); ?>"
	role="region"
	aria-label="<?php echo esc_attr( $aria_label ); ?>"
	<?php echo $background_style ? 'style="' . esc_attr( $background_style ) . '"' : ''; ?>
>
	<?php if ( ! empty( $heading ) ) : ?>
		<h1 class="hero-block-heading display-1"><?php echo esc_html( $heading ); ?></h1>
	<?php endif; ?>
</section>
