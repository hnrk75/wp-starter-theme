<?php
/**
 * Searchform
 *
 * @author Henrik Pettersson <henrik.pettersson@knowit.se>
 * @package StarterWP
 */

?>

<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<div class="input-group">
		<input type="text" class="search-field form-control" placeholder="<?php echo esc_attr_x( 'Search', 'placeholder' ) ?>" value="<?php echo esc_attr( get_search_query() ); ?>" name="s" aria-describedby="search-form">
		<span class="input-group-append">
			<button type="submit" class="btn btn-secondary" id="search-form">
				<?php echo esc_html_x( 'Search', 'submit button' ); ?>
			</button>
		</span>
	</div>
</form>

