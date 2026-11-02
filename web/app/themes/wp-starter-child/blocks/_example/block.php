<?php
/**
 * Example block. Fields: heading, text.
 *
 * @package WP Starter Child
 *
 * @var array $block      Block settings and attributes.
 * @var bool  $is_preview True in the editor.
 */

$heading = get_field( 'heading' );
$text    = get_field( 'text' );

if ( ! $heading && ! $text ) {
	if ( $is_preview ) {
		echo '<p>' . esc_html__( 'Fill in the fields in the sidebar.', 'wp-starter-child' ) . '</p>';
	}
	return;
}

$attributes = array( 'class' => 'example-block' );
if ( ! empty( $block['anchor'] ) ) {
	$attributes['id'] = $block['anchor'];
}
?>
<section <?php echo get_block_wrapper_attributes( $attributes ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped by WordPress. ?>>
	<?php if ( $heading ) : ?>
		<h2 class="example-block__heading"><?php echo esc_html( $heading ); ?></h2>
	<?php endif; ?>

	<?php echo wp_kses_post( (string) $text ); ?>
</section>
