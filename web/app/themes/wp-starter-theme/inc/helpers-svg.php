<?php
/**
 * SVG icon helper
 *
 * Laddar inline SVG från assets/svg/.
 * Användning: wpst_icon( 'arrow-right' );
 *             wpst_icon( 'arrow-right', [ 'class' => 'icon icon--sm', 'title' => 'Gå vidare' ] );
 *
 * @author Henrik Pettersson
 * @package WP Starter Theme
 */

if ( ! function_exists( 'wpst_icon' ) ) {
	/**
	 * Returnerar en inline SVG från assets/svg/.
	 *
	 * @param string $name   Filnamn utan .svg-ändelse.
	 * @param array  $args {
	 *     Valfria argument.
	 *     @type string $class  CSS-klass på <svg>-elementet.
	 *     @type string $title  Tillgänglig titel (lägger till <title> + aria-label).
	 *     @type bool   $echo   Om true (standard) echas SVG:n, annars returneras den.
	 * }
	 * @return string|void
	 */
	function wpst_icon( string $name, array $args = array() ): string {
		$args = wp_parse_args(
			$args,
			array(
				'class' => 'icon',
				'title' => '',
				'echo'  => true,
			)
		);

		// Sanera filnamnet — tillåt bara a-z, 0-9, bindestreck och understreck.
		$safe_name = preg_replace( '/[^a-z0-9\-_]/', '', strtolower( $name ) );
		$path      = get_theme_file_path( 'assets/svg/' . $safe_name . '.svg' );

		if ( ! file_exists( $path ) ) {
			if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
				// phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_trigger_error
				trigger_error( esc_html( "wpst_icon: ikonen '{$safe_name}.svg' hittades inte." ), E_USER_NOTICE );
			}
			return '';
		}

		$svg = file_get_contents( $path ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents

		if ( false === $svg || '' === trim( $svg ) ) {
			return '';
		}

		// Lägg till/ersätt class-attributet på <svg>-taggen.
		$class = esc_attr( $args['class'] );
		if ( preg_match( '/<svg[^>]+class=["\']/', $svg ) ) {
			$svg = preg_replace( '/(<svg[^>]+class=["\'])([^"\']*)["\']/', '$1' . $class . '"', $svg );
		} else {
			$svg = preg_replace( '/<svg/', '<svg class="' . $class . '"', $svg );
		}

		// Tillgänglighet: lägg till <title> och aria-label om $title är satt.
		if ( ! empty( $args['title'] ) ) {
			$title     = esc_html( $args['title'] );
			$title_tag = '<title>' . $title . '</title>';
			$svg       = preg_replace( '/(<svg[^>]*>)/', '$1' . $title_tag, $svg );
			$svg       = preg_replace( '/<svg/', '<svg aria-label="' . esc_attr( $args['title'] ) . '" role="img"', $svg );
		} else {
			// Dekorativ ikon — dölj från skärmläsare.
			$svg = preg_replace( '/<svg/', '<svg aria-hidden="true" focusable="false"', $svg );
		}

		$output = wp_kses(
			$svg,
			array(
				'svg'     => array(
					'class'       => true,
					'aria-hidden' => true,
					'aria-label'  => true,
					'focusable'   => true,
					'role'        => true,
					'xmlns'       => true,
					'width'       => true,
					'height'      => true,
					'viewbox'     => true,
					'fill'        => true,
					'stroke'      => true,
				),
				'title'   => array(),
				'path'    => array(
					'd'               => true,
					'fill'            => true,
					'fill-rule'       => true,
					'stroke'          => true,
					'stroke-width'    => true,
					'stroke-linecap'  => true,
					'stroke-linejoin' => true,
					'clip-rule'       => true,
				),
				'circle'  => array(
					'cx' => true,
					'cy' => true,
					'r' => true,
					'fill' => true,
					'stroke' => true,
					'stroke-width' => true,
				),
				'rect'    => array(
					'x' => true,
					'y' => true,
					'width' => true,
					'height' => true,
					'rx' => true,
					'fill' => true,
				),
				'line'    => array(
					'x1' => true,
					'y1' => true,
					'x2' => true,
					'y2' => true,
					'stroke' => true,
					'stroke-width' => true,
					'stroke-linecap' => true,
				),
				'polyline' => array(
					'points' => true,
					'fill' => true,
					'stroke' => true,
					'stroke-width' => true,
					'stroke-linecap' => true,
					'stroke-linejoin' => true,
				),
				'polygon' => array(
					'points' => true,
					'fill' => true,
					'stroke' => true,
				),
				'g'       => array(
					'fill' => true,
					'stroke' => true,
					'transform' => true,
				),
				'defs'    => array(),
				'use'     => array(
					'href' => true,
					'xlink:href' => true,
				),
			)
		);

		if ( $args['echo'] ) {
			echo $output; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- saniterad via wp_kses
			return '';
		}

		return $output;
	}
}
