<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js no-svg">
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="http://gmpg.org/xfn/11">
	<base href="<?php echo get_site_url(); ?>/">
    <meta name="twitter:image" content="https://www.thecipherbrief.com/wp-content/uploads/2017/09/resizedCipherWhite.jpg" />
    <?php wp_head(); ?>
    <meta name="twitter:site" content="@thecipherbrief" />
    <meta name="twitter:image:width" content="1024" />
    <meta name="twitter:image:height" content="512" />
    <script type='text/javascript'>
        (function (d, t) {
            var bh = d.createElement(t), s = d.getElementsByTagName(t)[0];
            bh.type = 'text/javascript';
            bh.src = 'https://www.bugherd.com/sidebarv2.js?apikey=bvhptmiygo1wn7sqe6v3qw';
            s.parentNode.insertBefore(bh, s);
        })(document, 'script');
    </script>
</head>
<body <?php body_class(); ?>>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'thecipherbrief' ); ?></a>
	<header id="masthead" class="site-header menu_fixed" role="banner">
	<div class="header_baner">
		<div class="col-mdws-1"><img class="sumome-icon" src="//sumo.com/client/images/apps/408190b5-e369-48af-8e31-afb7380ecd66/transparent-crown-dark.png"></div>
		<div class="col-mdws-2 baner_content_center">
				<p>SIGN UP FOR THE DAILY NEWSLETTER FOR MORE EXPERT ANALYSIS  & COMMENTARY</p>
				<span class="header_baner_btn">
					<a href="/subscribe" class="sumome-smartbar-button">SIGN UP</a>
				</span>
		</div>
		<div class="col-mdws-3">
			<div class="baner_close"></div>
		</div>
	</div>
		<?php get_template_part( 'template-parts/header/header', 'image' ); ?>

		<?php if ( has_nav_menu( 'top' ) ) : ?>
			<div class="navigation-top">
				<div class="wrap">
					<?php get_template_part( 'template-parts/navigation/navigation', 'top' ); ?>
				</div><!-- .wrap -->
			</div><!-- .navigation-top -->
		<?php endif; ?>

	</header><!-- #masthead -->
	<div class="site-content-contain">
		<div id="content" class="site-content">
