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
    Template Name: Sponsor Ship
*/
    get_header();
    the_custom_above_banner();
?>
<div class="site-content-contain post_content">
	<div class="post_article content-inner inner column center">
		<div id="content-header" class="content-header">
			<h1 class="title"><?php the_title(); ?></h1>
		</div>
		<div id="content-area" class="content-area">
			<div class="region region-content">
				<div id="block-system-main" class="block block-system block-even block-first block-last clearfix">
					<div class="content clearfix">
                        <div class="content sponsors_content">
                            <?php the_content(); ?>
                        </div>
					</div>
				</div>  
			</div>
		</div>
	</div>
</div>
<?php
    $postMeta = get_post_meta($post->ID);
    if(IsSet($postMeta['_thumbnail_id']) && IsSet($postMeta['_thumbnail_id'][0]) && $postMeta['_thumbnail_id'][0]):
        $image = get_post($postMeta['_thumbnail_id'][0]);
        $imageMeta = get_post_meta($postMeta['_thumbnail_id'][0]);
?>
<div id="sidebar-second" class="column sidebar second">
	<div id="sidebar-second-inner" class="inner">
		<div class="region region-sidebar-second">
			<div id="block-block-16" class="block block-block block-odd block-first block-last clearfix">
				<div class="content clearfix sponsors">
					<center>
						<h1><?php echo $image->post_title ?></h1>
						<div>
							<img src="<?php echo $image->guid ?>"<?php echo (IsSet($imageMeta['_wp_attachment_image_alt']) && IsSet($imageMeta['_wp_attachment_image_alt'][0]) && $imageMeta['_wp_attachment_image_alt'][0] ? ' alt="'.$imageMeta['_wp_attachment_image_alt'][0].'"' : '')?>/>
						</div>
					</center>    
				</div>
			</div>  
		</div>
	</div>
</div>
<?php endif ?>
<?php
    get_footer();