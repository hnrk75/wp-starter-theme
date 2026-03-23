<?php
/**
 * Text Block template.
 *
 * @author Henrik Pettersson
 * @package WPST ACF Blocks
 */

$heading = get_field( 'text_block_heading' );
$content = get_field( 'text_block_content' );

$class_name = 'text-block';
if ( ! empty( $block['className'] ) ) {
	$class_name .= ' ' . esc_attr( $block['className'] );
}
?>
<section class="<?php echo esc_attr( $class_name ); ?>">
	<?php if ( ! empty( $heading ) ) : ?>
		<h2 class="text-block__heading"><?php echo esc_html( $heading ); ?></h2>
	<?php endif; ?>

	<?php if ( ! empty( $content ) ) : ?>
		<div class="text-block__content"><?php echo wp_kses_post( $content ); ?></div>
	<?php endif; ?>
</section>
