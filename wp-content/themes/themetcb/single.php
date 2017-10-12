
<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

$array = array(
    'post' => array(
        'wpcf-show_article_page',
        'wpcf-sort_article_page',
    ),
    'article' => array(
        'wpcf-show_article_page',
        'wpcf-sort_article_page',
    ),
    'column_article' => array(
        'wpcf-show_column_article',
        'wpcf-sort_column_article',
    ),
    'dead_drop_article' => array(
        'wpcf-show_dead_drop_article',
        'wpcf-sort_dead_drop_article',
    ),
);

$what = (!$wp_query->query['post_type'] ?  'article' : $wp_query->query['post_type']);
get_header();
    $post_meta = get_metadata('post',$post->ID);
    $mainPostId = $post->ID;
    $title = isset( $post->post_title ) ? $post->post_title : '';
    $expert = false;
    $article_exerpt = false;
    $imageComm = '';
    $my_search = $wpdb->get_results("SELECT * FROM wp_postmeta WHERE meta_value='".str_replace("'","''",$post->post_title)."' AND meta_key='wpcf-expert-commentary-for'");
if(IsSet($post_meta['wpcf-articleexcerpt']) && IsSet($post_meta['wpcf-articleexcerpt'][0]) && $post_meta['wpcf-articleexcerpt'][0]) {
        $title = $post_meta['wpcf-articleexcerpt'][0];
        $expert_comm_post = $wpdb->get_results("SELECT * FROM wp_posts WHERE post_title='" . str_replace("'", "''", $title) . "' AND post_type = 'expert_commentary' LIMIT 1");
        if($expert_comm_post[0]->ID>0) {
            $expert = true;
            $real_post_name = get_post_meta($expert_comm_post[0]->ID, 'wpcf-expert-commentary-for', true);
            if ($real_post_name != '') {
                $commPost = $wpdb->get_results("SELECT * FROM wp_posts WHERE post_title='" . str_replace("'", "''", $real_post_name) . "' AND post_type = 'post' LIMIT 1");
                if (IsSet($commPost[0]) && IsSet($commPost[0]->ID)) {
                    $temp = wp_get_attachment_image_src(get_post_meta($commPost[0]->ID, '_thumbnail_id', true), 'post_thumbnail', false);
                    if (!empty($temp)) {
                        $imageComm = $temp;
                        $article_exerpt = true;
                    }
                }
            }
        }
    }
    $postComentar = array();

    if($expert == true) {
        $results = $wpdb->get_results("SELECT * FROM wp_postmeta WHERE meta_value='" . str_replace("'", "''", $real_post_name) . "' AND meta_key='wpcf-expert-commentary-for'");
    }
        if($expert == false && $my_search){
            $results = $wpdb->get_results("SELECT * FROM wp_postmeta WHERE meta_value='".str_replace("'","''",$title)."' AND meta_key='wpcf-expert-commentary-for'");
        }
    if(IsSet($results[0]) && $results[0]){
        $postComentar = get_metadata('post',$results[0]->post_id);
    }
    if($postComentar){
        $wpQuery = $wpdb->get_results("SELECT * FROM wp_posts WHERE post_title IN ('".implode("','",str_replace("'","''",$postComentar['wpcf-article-commentar']))."')  ORDER BY FIELD(post_title, '".implode("','",str_replace("'","''",$postComentar['wpcf-article-commentar']))."')");
    }

    $photos = get_children( array('post_parent' => $post->ID, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => 'ASC', 'orderby' => 'menu_order ID') );
    $galleryimages = array();
    if ($photos) {
        foreach ($photos as $photo) {
            $galleryimages[] = wp_get_attachment_url($photo->ID);
        }
    }
the_custom_above_banner();
    $my_sidebar = getMySideBar($array[$what][0],$array[$what][1],($wpQuery ?
        array(
            'postComentar' => $postComentar,
            'imageComm'    => $imageComm,
            'commPost'     => $commPost,
            'title'        => $title,
            'real_title'   => $real_post_name,
            'wpQuery'      => $wpQuery,
            'mainPostId'   => $mainPostId,
        )
        : array()
    ),($myEvent ? $myEvent : array())
    );
?>
<div class="site-content-contain post_content post-margin-minus">
    <div class="post_article content-inner inner column center">
        <div class="wrap">
            <div id="primary" class="content-area">
                <main id="main" class="site-main" role="main">
                    <?php
                        while ( have_posts() ) :
                            the_post();
                            $format = get_post_format();
                            $format = !$format ? $post->post_type : $format;
                            get_template_part( 'template-parts/post/content', $format );
                        endwhile;
                    ?>

                </main>
            </div>
        </div>
    </div>
    <div id="sidebar-second" class="column sidebar second">
        <div id="sidebar-second-inner" class="inner">
            <div class="region region-sidebar-second">
    <?php


    $key = 'wpcf-key-points-id';
    $meta_keypoints_tmp = get_post_meta( $post_id_key, $key, $single);
    $meta_ids = explode(',', $meta_keypoints_tmp);
    $args= array(
        'cache_results' => false,
        'post__in' => $meta_ids,
        'ignore_sticky_posts' => true,
        'orderby' => 'post__in'
    );
    $query_keypoints = new WP_Query($args);
    if($query_keypoints->posts) {
        $data_keypoints = '<div id="block-views-home-next_up" class="block block-views block-odd clearfix">
				<div class="content clearfix">
					<h2>Key Points</h2>
					<div class="view view-home view-id-home view-display-id-next_up">
						<div class="view-content">
							<div class="item-list">
								<ol style="list-style-type: none; margin: 0.5em 0 0.5em 0!important;">';
        foreach ($query_keypoints->posts as $post) {
            $post_metadata = get_metadata('post', $post->ID);
            if(IsSet($post->post_title) && $post->post_title){
                $data_keypoints .= '
                <li style=" padding: 0; padding-left: 0.4em; border-left: 0.3em solid gray; margin-top: 0.2em;
">
                    <div>
											<span class="field-content">
												<a href="'.esc_url( get_permalink($post) ).'">
													<div class="nextup">
														<h3>'.$post->post_title.'</h3>
													</div>
												</a>
											</span>
                    </div>
                </li>
             '; }
        }
        $data_keypoints .= '</ol>
							</div>
						</div>
					</div>
				</div>
			</div>';
        echo $data_keypoints;
    }

    echo ($my_sidebar ? $my_sidebar : '');

    ?>

            </div></div></div>
</div>
<?php get_footer();
