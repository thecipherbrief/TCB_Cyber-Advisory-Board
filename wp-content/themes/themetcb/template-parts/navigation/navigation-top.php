<?php
/**
 * Displays top navigation
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

?>
<div class="menu-toggle" id="openm" onclick="menuToggle()" aria-controls="top-menu" aria-expanded="false" value="klic me">
    <svg width="15" class="icon icon-bars" aria-hidden="true" role="img"> <use href="#icon-bars" xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#icon-bars"></use> </svg>
    <?php 
    _e( 'Menu', 'thecipherbrief' ); 
    ?>
</div>
<script>
var statm = true;
    function menuToggle(){
        if(statm){
            jQuery("#openm").html('<svg width="15"class="icon icon-close" aria-hidden="true" role="img"> <use href="#icon-close" xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#icon-close"></use> </svg>Menu');
        }else{
            jQuery("#openm").html('<svg width="15" class="icon icon-bars" aria-hidden="true" role="img"> <use href="#icon-bars" xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#icon-bars"></use> </svg>Menu');
        }
        statm = !statm;
    }
</script>
<div class="search-block">
	<?php get_search_form();?>
</div>
<nav id="site-navigation" class="main-navigation" role="navigation" aria-label="<?php _e( 'Top Menu', 'thecipherbrief' ); ?>">
	<?php wp_nav_menu( array(
		'theme_location' => 'top',
		'menu_id'        => 'top-menu',
	) ); ?>
</nav><!-- #site-navigation -->
<div id="block-menu-menu-social-media-menu" class="soc_seti">
    <ul>
        <li><a href="https://twitter.com/thecipherbrief" class="twitter-link" target="_blank"><i class="fa fa-twitter"></i><span>Twitter</span></a></li>
        <li><a href="https://www.linkedin.com/company/thecipherbrief" class="linkedin-link" target="_blank"><i class="fa fa-linkedin"></i><span>Linkedin</span></a></li>
        <li><a href="http://www.facebook.com/thecipherbrief" class="facebook-link" target="_blank"><i class="fa fa-facebook"></i><span>Facebook</span></a></li>
        <li><a href="https://www.instagram.com/thecipherbrief/" class="instagram-link" target="_blank"><i class="fa fa-instagram"></i><span>Instagram</span></a></li>
    </ul>
</div>

<div id="block-superfish-1" class="menu_hide_responsive">
    <div class="content clearfix">
        <?php wp_nav_menu( array(
            'theme_location' => 'top',
            'menu_id'        => 'top-menu',
        ) ); ?>
    </div>
</div>
