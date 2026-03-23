<?php
/**
 * Image Text Block template.
 *
 * Fields:
 *  wpst_itb_image          – image (returns ID, optional)
 *  wpst_itb_image_size     – '1/2' | '1/3'
 *  wpst_itb_image_position – 'left' | 'right'
 *  wpst_itb_heading        – text (optional)
 *  wpst_itb_heading_level  – 'h2' | 'h3' | 'h4'
 *  wpst_itb_text_size      – 'normal' | 'lead' (only when no heading)
 *  wpst_itb_content        – textarea
 *  wpst_itb_link           – link (url, title, target)
 *  wpst_itb_link_position  – 'left' | 'right'
 *
 * @author Henrik Pettersson
 * @package WPST ACF Blocks
 */

$image_id       = get_field( 'wpst_itb_image' );
$image_size     = get_field( 'wpst_itb_image_size' ) ?: '1/2';
$image_position = get_field( 'wpst_itb_image_position' ) ?: 'left';
$heading        = get_field( 'wpst_itb_heading' );
$heading_level  = get_field( 'wpst_itb_heading_level' ) ?: 'h2';
$text_size      = get_field( 'wpst_itb_text_size' ) ?: 'normal';
$content        = get_field( 'wpst_itb_content' );
$link           = get_field( 'wpst_itb_link' );
$link_position  = get_field( 'wpst_itb_link_position' ) ?: 'left';

// Placeholder when block has no content yet.
if ( empty( $image_id ) ) : ?>
	<div class="acf-block-placeholder">
		<div class="acf-block-placeholder__inner">
			<span class="dashicons dashicons-columns"></span>
			<p><?php echo esc_html__( 'Bild & text — välj en bild i högerpanelen.', 'wpst-acf-blocks' ); ?></p>
		</div>
	</div>
	<?php return;
endif;

if ( '1/3' === $image_size ) {
	$columns = 'right' === $image_position ? '2fr 1fr' : '1fr 2fr';
} else {
	$columns = '1fr 1fr';
}
$image_order = 'right' === $image_position ? 2 : 1;
$text_order  = 'right' === $image_position ? 1 : 2;

// Lead only applies when there is no heading.
$is_lead    = empty( $heading ) && 'lead' === $text_size;

$block_id   = ! empty( $block['anchor'] ) ? esc_attr( $block['anchor'] ) : 'image-text-block-' . esc_attr( $block['id'] );
$heading_id = $block_id . '-heading';

$class_name = 'image-text-block' . ( $is_lead ? ' image-text-block--lead' : '' );
if ( ! empty( $block['className'] ) ) {
	$class_name .= ' ' . esc_attr( $block['className'] );
}

$aria_attr = $heading
	? 'aria-labelledby="' . esc_attr( $heading_id ) . '"'
	: 'aria-label="' . esc_attr__( 'Bild och text', 'wpst-acf-blocks' ) . '"';
?>
<section
	id="<?php echo esc_attr( $block_id ); ?>"
	class="<?php echo esc_attr( $class_name ); ?>"
	style="--itb-columns: <?php echo esc_attr( $columns ); ?>; --itb-image-order: <?php echo esc_attr( $image_order ); ?>; --itb-text-order: <?php echo esc_attr( $text_order ); ?>"
	<?php echo $aria_attr; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
>
	<?php if ( $image_id ) : ?>
		<div class="image-text-block__image" aria-hidden="true">
			<?php echo wp_get_attachment_image( $image_id, 'large', false, array( 'class' => 'image-text-block__img' ) ); ?>
		</div>
	<?php endif; ?>

	<div class="image-text-block__content">
		<?php if ( ! empty( $heading ) ) : ?>
			<<?php echo esc_attr( $heading_level ); ?> id="<?php echo esc_attr( $heading_id ); ?>" class="image-text-block__heading">
				<?php echo esc_html( $heading ); ?>
			</<?php echo esc_attr( $heading_level ); ?>>
		<?php endif; ?>

		<?php if ( ! empty( $content ) ) : ?>
			<div class="image-text-block__text">
				<?php echo wp_kses_post( $content ); ?>
			</div>
		<?php endif; ?>

		<?php if ( ! empty( $link ) ) : ?>
			<div class="image-text-block__link-wrap image-text-block__link-wrap--<?php echo esc_attr( $link_position ); ?>">
				<a
					href="<?php echo esc_url( $link['url'] ); ?>"
					class="image-text-block__link"
					<?php if ( $link['target'] ) : ?>target="<?php echo esc_attr( $link['target'] ); ?>" rel="noopener noreferrer"<?php endif; ?>
				>
					<?php echo esc_html( $link['title'] ?: $link['url'] ); ?>
				</a>
			</div>
		<?php endif; ?>
	</div>
</section>
