<?php
/**
 * The sidebar containing the main widget area
 *
 * @author Henrik Pettersson
 * @package Knowit Starter Theme
 */

if ( ! is_active_sidebar( 'sidebar-1' ) ) : ?>
	</div>
	</div>
	<?php
	return;
endif;
?>

<aside id="secondary" class="widget-area" role="complementary" aria-label="<?php echo esc_attr__( 'Sidopanel', 'knowit-starter-theme' ); ?>">
	<?php dynamic_sidebar( 'sidebar-1' ); ?>
</aside>
