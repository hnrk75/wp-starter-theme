<?php
/**
 * The sidebar containing the main widget area
 *
 * @author Henrik Pettersson <henrik.pettersson@knowit.se>
 * @package StarterWP
 */

if ( ! is_active_sidebar( 'sidebar-1' ) ) { ?>
		</div>
	</div>
<?php } ?>

<aside id="secondary" class="widget-area" role="complementary">
	<?php dynamic_sidebar( 'sidebar-1' ); ?>
</aside>
