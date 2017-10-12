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
    Template Name: Static page
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
		<?php
        $key = 'wpcf-sidebar_adv_item';
        $post_id = get_the_ID();
        $meta_adv_value_tmp = get_post_meta( $post_id, $key, $single );
        $meta_adv_value = explode(',', $meta_adv_value_tmp);
        $data_adv = '';
        $time = time();
        $args= array(
             'post_type' => 'advertisement',
             'post__in' => $meta_adv_value,
             'ignore_sticky_posts' => true,
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
                        )
             ),
             'orderby' => 'post__in'
        );
        $query_ads = new WP_Query($args);

       if($query_ads->posts) {
            foreach ($query_ads->posts as $post) {
                $post_metadata = get_metadata('post', $post->ID);
                if(IsSet($post->post_content) && $post->post_content){
                    $data_adv .= $post->post_content;
                }
            }
        }

        echo $data_adv;

		$wp_query = new WP_Query(array(
            'cache_results' => false,
            'posts_per_page' => 5,
            'post_type' => 'post',
            'post__not_in' => array($id),
            'orderby' => 'date',
            'order' => 'DESC',
            'relation' => 'AND',
            'meta_query' => array(
                'relation' => 'AND',
                // Not Article Execrpt
                array(
                    'relation' => 'OR',
                    array(
                        'key' => 'wpcf-articleexcerpt',
                        'compare' => 'NOT EXISTS',
                        'value' => ''
                    ),
                    array(
                        'key' => 'wpcf-articleexcerpt',
                        'value' => ''
                    )
                ),
                // Not Exclusive
                array(
                    'relation' => 'OR',
                    array(
                        'key' => 'wpcf-exclusive',
                        'compare' => 'NOT EXISTS',
                        'value' => ''
                    ),
                    array(
                        'key' => 'wpcf-exclusive',
                        'value' => ''
                    )
                ),
                // Promoted to Front Page
                array(
                    'key' => 'wpcf-promoted-to-front-page',
                    'value' => '1',
                    'compare' => '='
                ),
                // Have a Futured Image
                array(
                    'relation' => 'AND',
                    array(
                        'key' => '_thumbnail_id',
                        'compare' => 'EXISTS',
                    ),
                    array(
                        'key' => '_thumbnail_id',
                        'value' => '',
                        'compare' => '!='
                    ),
                )
            ),
            'date_query' => array(
                'before' => 'today',
                'inclusive' => false,
            )
        ));
		if(IsSet($wp_query->posts)):
			?>
			<div id="block-views-home-next_up" class="block block-views block-odd clearfix">
				<div class="content clearfix">
					<h2>Recent Briefs</h2>
					<div class="view view-home view-id-home view-display-id-next_up">
						<div class="view-content">
							<div class="item-list">
								<ol>
									<?php
									foreach ($wp_query->posts as $commn):
										$author = wp_get_post_terms($commn->ID, 'authors');
										if(IsSet($author[0]->name)):
											?>
											<li class="views-row views-row-1 views-row-odd views-row-first">
												<div class="views-field views-field-title">
											<span class="field-content">
												<a href="<?php echo esc_url( get_permalink($commn) ) ?>">
													<div class="nextup">
														<h3><?php echo $commn->post_title?></h3>
														<div class="author-text"><?php echo $author[0]->name ?></div>
													</div>
												</a>
											</span>
												</div>
											</li>
											<?php
										endif;
									endforeach
									?>
								</ol>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php
		endif;
		?>
		</div>
	</div>
</div>

<?php
    get_footer();
