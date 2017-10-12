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
    Template Name: Page Job list
*/
    get_header();
    the_custom_above_banner();
    $wp_query = new WP_Query(array(
        'cache_results' => false,
        'post_type' => 'job_listing',
        'posts_per_page' => -1,
        "orderby" => "date",
        "order" => 'DESC'
    ));
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
                                <?php
                                $boolean = false;
                                if(!empty($wp_query->posts)){
                                    foreach ($wp_query->posts as $post){
                                        if($boolean){
                                            echo '<hr />';
                                        }
                                        echo '<div class="views-field views-field-title">';
                                            echo '<h3>'.$post->post_title.'</h3>';
                                        echo '</div>';
                                        $content = apply_filters( 'the_content', $post->post_content);
                                        echo str_replace( ']]>', ']]&gt;', $content );
                                        $boolean = true;
                                    }
                                }
                                ?>
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