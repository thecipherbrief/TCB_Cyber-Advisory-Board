<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */
/*
    Template Name: Page Stat
*/
    get_header();
    the_custom_above_banner();
?>
<div class="region region-content-top"></div>
<div class="site-content-contain post_content">
	<div class="post_article content-inner column">
		<div id="content-header" class="content-header">
			<h1 class="title"><?php the_title(); ?></h1>
		</div>
		<div id="content-area" class="content-area">
			<div class="region region-content">
				<div id="block-system-main" class="block block-system block-even block-first block-last clearfix">
					<div class="content clearfix">
						<div id="node-1480" class="node node-page node-odd">
							<div class="content private">
								<?php the_content(); ?>
							</div>
						</div>
					</div>
				</div>  
			</div>
		</div>
	</div>
</div>
<?php
    get_footer();