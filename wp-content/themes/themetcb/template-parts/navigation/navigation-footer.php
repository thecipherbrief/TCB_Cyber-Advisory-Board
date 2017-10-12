<?php
/**
 * Displays Footer navigation
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

?>
<nav id="footer-menu" role="navigation" aria-label="<?php _e( 'Footer Menu', 'thecipherbrief' ); ?>">
    <span class="about"><?php echo get_bloginfo();?> © 2015</span>
	<?php wp_nav_menu( array(
		'theme_location' => 'footer-menu',
		'menu_id'        => 'footer-menu',
	) ); ?>
</nav><!-- #site-navigation -->
