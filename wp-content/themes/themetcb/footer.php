<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

?>

		</div><!-- #content -->

		<footer id="colophon" class="site-footer" role="contentinfo">
            <?php get_template_part( 'template-parts/footer/site', 'info' );?>
			<div class="wrap-footer">
				<?php
				if ( has_nav_menu( 'footer-menu' ) ) : ?>
                    <?php get_template_part( 'template-parts/navigation/navigation', 'footer' ); ?>
				<?php endif; ?>
			</div><!-- .wrap-footer -->
		</footer><!-- #colophon -->
	</div><!-- .site-content-contain -->
</div>
<script type="text/javascript" src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
<script type='text/javascript' src='https://cdn.jsdelivr.net/jquery.slick/1.6.0/slick.min.js'></script>

<script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
    ga('create', 'UA-62844917-1', 'auto');
    ga('send', 'pageview');
</script>
<?php wp_footer(); ?>

</body>
</html>
