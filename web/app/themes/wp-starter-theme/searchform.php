<?php
/**
 * Searchform
 *
 * @author Henrik Pettersson <kontakt@hnrkagency.se>
 * @package StarterWP
 */

?>

<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php esc_attr_e( 'Sökformulär', 'starterwp-textdomain' ); ?>">
	<div class="input-group">
		<input type="text" class="search-field form-control" placeholder="<?php echo esc_attr_x( 'Sök', 'placeholder', 'starterwp-textdomain' ); ?>" value="<?php echo esc_attr( get_search_query() ); ?>" name="s" id="search-field" aria-describedby="search-form-description" aria-label="<?php esc_attr_e( 'Skriv din sökfråga', 'starterwp-textdomain' ); ?>">
		<span class="input-group-append">
			<button type="submit" class="btn btn-secondary" id="search-form" aria-label="<?php esc_attr_e( 'Utför sökning', 'starterwp-textdomain' ); ?>">
				<?php echo esc_html_x( 'Sök', 'submit button', 'starterwp-textdomain' ); ?>
			</button>
		</span>
	</div>
	<p id="search-form-description" class="screen-reader-text"><?php esc_html_e( 'Skriv ett ord eller en fras för att söka på webbplatsen.', 'starterwp-textdomain' ); ?></p>
</form>
