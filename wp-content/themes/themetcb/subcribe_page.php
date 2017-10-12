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
    Template Name: Subcribe page
*/
    get_header();
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
						<div id="node-1480" class="node node-page node-odd">
							<div class="content sponsors_content">
								<?php the_content(); ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div id="sidebar-second" class="column sidebar second">
	<div id="sidebar-second-inner" class="inner">
		<div class="region region-sidebar-second">
	<!-- Here must be  sidebar -->
            <?php
$data = '';
$time = time();
$wp_query = new WP_Query(array(
    'cache_results' => false,
    'post_type' => 'advertisement',
    'orderby' => 'meta_value',
    'meta_query' => array(
        'relation' => 'AND',
        array(
            'key'     => 'wpcf-daterange',
            'value'   => $time,
            'compare' => '<=',
        ),
        array(
            'key' => 'wpcf-date-range-end',
            'value' => $time,
            'compare' => '>=',
        ),
        array(
            'key' => 'wpcf-show-on-subscribe-page',
            'value' => 1,
            'compare' => '=',
        )
    ),
    'order' => 'ASC',
));
 //   pre($wp_query);
if($wp_query->posts) {
    foreach ($wp_query->posts as $post) {
        $post_meta = get_metadata('post', $post->ID);
        if(IsSet($post->post_content) && $post->post_content){
            $data .= $post->post_content;
        }
    }

}

            echo $data;
            ?>
		</div>
	</div>
</div>

<?php
    get_footer();