<?php
/**
 * Text Block template.
 *
 * Fields:
 *  wpst_tb_heading        – text (optional)
 *  wpst_tb_heading_level  – 'h2' | 'h3' | 'h4'
 *  wpst_tb_text_size      – 'normal' | 'lead'  (only when no heading)
 *  wpst_tb_content        – textarea
 *  wpst_tb_link           – link (url, title, target)
 *  wpst_tb_link_position  – 'left' | 'right'
 *  wpst_bg_color          – 'none' | 'light' | 'dark' | 'primary'
 *
 * @author Henrik Pettersson
 * @package WPST ACF Blocks
 */

$heading       = get_field( 'wpst_tb_heading' );
$heading_level = get_field( 'wpst_tb_heading_level' ) ?: 'h2';
$text_size     = get_field( 'wpst_tb_text_size' ) ?: 'normal';
$content       = get_field( 'wpst_tb_content' );
$link          = get_field( 'wpst_tb_link' );
$link_position = get_field( 'wpst_tb_link_position' ) ?: 'left';
$bg_color      = get_field( 'wpst_bg_color' ) ?: 'none';

// Placeholder when block has no content yet.
if ( empty( $heading ) && empty( $content ) && empty( $link ) ) : ?>
	<div class="acf-block-placeholder">
		<div class="acf-block-placeholder__inner">
			<span class="dashicons dashicons-editor-paragraph"></span>
			<p><?php echo esc_html__( 'Textblock — fyll i fälten i högerpanelen.', 'wpst-acf-blocks' ); ?></p>
		</div>
	</div>
	<?php return;
endif;

$block_id   = ! empty( $block['anchor'] ) ? esc_attr( $block['anchor'] ) : 'text-block-' . esc_attr( $block['id'] );
$heading_id = $block_id . '-heading';

$class_name = 'wpst-block text-block';
if ( 'none' !== $bg_color ) {
	$class_name .= ' has-bg has-bg--' . $bg_color;
}
if ( ! empty( $block['className'] ) ) {
	$class_name .= ' ' . esc_attr( $block['className'] );
}

$aria_attr = $heading
	? 'aria-labelledby="' . esc_attr( $heading_id ) . '"'
	: 'aria-label="' . esc_attr__( 'Textblock', 'wpst-acf-blocks' ) . '"';
?>
<section
	id="<?php echo esc_attr( $block_id ); ?>"
	class="<?php echo esc_attr( $class_name ); ?>"
	<?php echo $aria_attr; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
>
	<div class="text-block__content<?php echo ( empty( $heading ) && 'lead' === $text_size ) ? ' has-large-font-size' : ''; ?>">
		<?php if ( ! empty( $heading ) ) : ?>
			<<?php echo esc_attr( $heading_level ); ?> id="<?php echo esc_attr( $heading_id ); ?>">
				<?php echo esc_html( $heading ); ?>
			</<?php echo esc_attr( $heading_level ); ?>>
		<?php endif; ?>

		<?php if ( ! empty( $content ) ) : ?>
			<?php echo wp_kses_post( $content ); ?>
		<?php endif; ?>
	</div>

	<?php if ( ! empty( $link ) ) : ?>
		<div class="wpst-block__link-wrap wpst-block__link-wrap--<?php echo esc_attr( $link_position ); ?>">
			<a
				href="<?php echo esc_url( $link['url'] ); ?>"
				class="text-block__link"
				<?php if ( $link['target'] ) : ?>target="<?php echo esc_attr( $link['target'] ); ?>" rel="noopener noreferrer"<?php endif; ?>
			>
				<?php echo esc_html( $link['title'] ?: $link['url'] ); ?>
			</a>
		</div>
	<?php endif; ?>
</section>
