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
 *  wpst_bg_color           – 'none' | 'light' | 'dark' | 'primary'
 *
 * @package WPST ACF Blocks
 */

$image_id       = get_field( 'wpst_itb_image' );
$image_size     = get_field( 'wpst_itb_image_size' );
$image_size     = $image_size ? $image_size : '1/2';
$image_position = get_field( 'wpst_itb_image_position' );
$image_position = $image_position ? $image_position : 'left';
$heading        = get_field( 'wpst_itb_heading' );
$heading_level  = get_field( 'wpst_itb_heading_level' );
$heading_level  = $heading_level ? $heading_level : 'h2';
$text_size      = get_field( 'wpst_itb_text_size' );
$text_size      = $text_size ? $text_size : 'normal';
$content        = get_field( 'wpst_itb_content' );
$block_link     = get_field( 'wpst_itb_link' );
$link_position  = get_field( 'wpst_itb_link_position' );
$link_position  = $link_position ? $link_position : 'left';
$bg_color    = get_field( 'wpst_bg_color' );
$bg_color    = $bg_color ? $bg_color : 'none';
$block_align = ! empty( $block['align'] ) ? $block['align'] : '';

// Placeholder when block has no content yet.
if ( empty( $image_id ) ) : ?>
	<div class="acf-block-placeholder">
		<div class="acf-block-placeholder__inner">
			<span class="dashicons dashicons-columns"></span>
			<p><?php echo esc_html__( 'Bild & text — välj en bild i högerpanelen.', 'wpst-acf-blocks' ); ?></p>
		</div>
	</div>
	<?php
	return;
endif;

if ( '1/3' === $image_size ) {
	$columns = 'right' === $image_position ? '2fr 1fr' : '1fr 2fr';
} else {
	$columns = '1fr 1fr';
}
$image_order = 'right' === $image_position ? 2 : 1;
$text_order  = 'right' === $image_position ? 1 : 2;

$block_id   = ! empty( $block['anchor'] ) ? esc_attr( $block['anchor'] ) : 'image-text-block-' . esc_attr( $block['id'] );
$heading_id = $block_id . '-heading';

$class_name = 'wpst-block image-text-block';
if ( 'none' !== $bg_color ) {
	$class_name .= ' has-bg has-bg--' . $bg_color;
}
if ( $block_align ) {
	$class_name .= ' align' . $block_align;
}
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
	<?php echo $aria_attr; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
>
	<div
		class="wpst-block__inner"
		style="--itb-columns: <?php echo esc_attr( $columns ); ?>; --itb-image-order: <?php echo esc_attr( $image_order ); ?>; --itb-text-order: <?php echo esc_attr( $text_order ); ?>"
	>
		<?php if ( $image_id ) : ?>
			<div class="image-text-block__image" aria-hidden="true">
				<?php echo wp_get_attachment_image( $image_id, 'wpst-4-3', false, array( 'class' => 'image-text-block__img' ) ); ?>
			</div>
		<?php endif; ?>

		<div class="image-text-block__content<?php echo ( empty( $heading ) && 'lead' === $text_size ) ? ' has-large-font-size' : ''; ?>">
			<?php if ( ! empty( $heading ) ) : ?>
				<<?php echo esc_attr( $heading_level ); ?> id="<?php echo esc_attr( $heading_id ); ?>">
					<?php echo esc_html( $heading ); ?>
				</<?php echo esc_attr( $heading_level ); ?>>
			<?php endif; ?>

			<?php if ( ! empty( $content ) ) : ?>
				<?php echo wp_kses_post( $content ); ?>
			<?php endif; ?>

			<?php if ( ! empty( $block_link ) ) : ?>
				<?php
				$link_url    = $block_link['url'];
				$link_title  = $block_link['title'] ? $block_link['title'] : $link_url;
				$link_target = ! empty( $block_link['target'] ) ? $block_link['target'] : '';
				$link_host   = wp_parse_url( $link_url, PHP_URL_HOST );
				$home_host   = wp_parse_url( home_url(), PHP_URL_HOST );
				$is_external = ! empty( $link_host ) && $link_host !== $home_host;
				$icon_name   = $is_external ? 'icon-extern-link' : 'icon-intern-link';
				$icon_html   = function_exists( 'wpst_icon' ) ? wpst_icon( $icon_name, array( 'echo' => false ) ) : '';
				?>
				<div class="wpst-block__link-wrap wpst-block__link-wrap--<?php echo esc_attr( $link_position ); ?>">
					<a
						href="<?php echo esc_url( $link_url ); ?>"
						class="image-text-block__link link-icon"
						<?php if ( $link_target ) : ?>target="<?php echo esc_attr( $link_target ); ?>" rel="noopener noreferrer"<?php endif; ?>
					><?php echo esc_html( $link_title ); ?><?php echo $icon_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- sanitised via wp_kses ?></a>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>
