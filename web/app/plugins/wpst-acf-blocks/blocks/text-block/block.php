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
 * @package WPST ACF Blocks
 */

$heading       = get_field( 'wpst_tb_heading' );
$heading_level = get_field( 'wpst_tb_heading_level' );
$heading_level = $heading_level ? $heading_level : 'h2';
$text_size     = get_field( 'wpst_tb_text_size' );
$text_size     = $text_size ? $text_size : 'normal';
$content       = get_field( 'wpst_tb_content' );
$block_link    = get_field( 'wpst_tb_link' );
$link_position = get_field( 'wpst_tb_link_position' );
$link_position = $link_position ? $link_position : 'left';
$bg_color    = get_field( 'wpst_bg_color' );
$bg_color    = $bg_color ? $bg_color : 'none';
$block_align = ! empty( $block['align'] ) ? $block['align'] : '';

// Placeholder when block has no content yet.
if ( empty( $heading ) && empty( $content ) && empty( $block_link ) ) : ?>
	<div class="acf-block-placeholder">
		<div class="acf-block-placeholder__inner">
			<span class="dashicons dashicons-editor-paragraph"></span>
			<p><?php echo esc_html__( 'Textblock — fyll i fälten i högerpanelen.', 'wpst-acf-blocks' ); ?></p>
		</div>
	</div>
	<?php
	return;
endif;

$block_id   = ! empty( $block['anchor'] ) ? esc_attr( $block['anchor'] ) : 'text-block-' . esc_attr( $block['id'] );
$heading_id = $block_id . '-heading';

$class_name = 'wpst-block text-block';
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
	: 'aria-label="' . esc_attr__( 'Textblock', 'wpst-acf-blocks' ) . '"';
?>
<section
	id="<?php echo esc_attr( $block_id ); ?>"
	class="<?php echo esc_attr( $class_name ); ?>"
	<?php echo $aria_attr; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
>
	<div class="wpst-block__inner">
		<div class="text-block__content<?php echo ( empty( $heading ) && 'lead' === $text_size ) ? ' has-large-font-size' : ''; ?>">
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
						class="text-block__link link-icon"
						<?php if ( $link_target ) : ?>target="<?php echo esc_attr( $link_target ); ?>" rel="noopener noreferrer"<?php endif; ?>
					><?php echo esc_html( $link_title ); ?><?php echo $icon_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- sanitised via wp_kses ?></a>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>
