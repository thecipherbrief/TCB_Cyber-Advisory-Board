<?php
/**
 * The template for displaying archive pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

get_header();
the_custom_above_banner();
$paged = get_query_var( 'paged', 1 );
$paged = (!$paged ? 1 : $paged);
$my_sidebar = getMySideBar('wpcf-show_expert_commentary','wpcf-sort_expert_commentary',array(),($myEvent ? $myEvent : array()));
?>
<div class="site-content-contain post_content">
	<div class="post_expert_ajax content-inner inner column center">

		<div class="view-header">
        <div id="content-header" class="content-header">
            <div class="breadcrumb"><a href="/experts/">The Network</a></div>
        </div>
        <h4>The Network</h4>
        <?php
            $img = '';
            if($wp_query->queried_object_id && $wp_query->queried_object->name){
                echo '<div class="expert-article-headshot block block-views expert-article-headshot block-even clearfix">';
                $temp = $wpdb->get_results("SELECT * FROM wp_termmeta WHERE term_id=".(int)$wp_query->queried_object_id." AND meta_key='_thumbnail_id'");
                if($temp[0]){
                    $temp = $wpdb->get_results("SELECT guid,post_excerpt FROM wp_posts WHERE ID=".(int)$temp[0]->meta_value);
	                
                    if($temp[0] && IsSet($temp[0]->guid) && $temp[0]->guid) {
                        echo '<a>';
                            echo '<img src="'.$temp[0]->guid.'" width="220" height="220" alt="">';
                               echo '<div class="expert-name">';
                                    echo $wp_query->queried_object->name;
                                    echo '</br>';
                                    echo $temp[0] -> post_excerpt;
                                echo '</div>';
                        echo '</a>';
                    }
                }
                echo '</div>';
            }
            the_archive_description( '<div class="block block-system block-even clearfix">', '</div>' );
        ?>
		</div>
        <?php
        $for_wp = array(
            'cache_results'  => false,
            'posts_per_page' => 5,
            'paged'          => $paged,
            'post_type'      => array('column_article','post'),
            'tax_query'      => array(
                array(
                    'taxonomy' => 'experts',
                    'field'    => 'id',
                    'terms'    => $wp_query->queried_object_id
                )
            ),
            "orderby" => "date",
            "order" => 'DESC'
        );
        $wp_query = new WP_Query($for_wp);

        ?>
        <div id="block-views-the_network-block_1" class="block block-views block-odd block-last clearfix">
            <?php  if ( $wp_query->have_posts() ){ ?>
            <div class="moreExpert">
                <h2>More From This Expert</h2>
            </div>
            <main id="main" class="site-main" role="main">
                <?php
                if ($wp_query->have_posts()) : ?>
                    <?php
                    echo '<div class="boxcontainer">';
                    while (have_posts()) : the_post();
                        $format = get_post_format();
                        $format = !$format ? $post->post_type : $format;
                        get_template_part('template-parts/post/content_expert_ajax', $format);

                    endwhile;
                    echo '</div>';
                    echo '<div class="loader"></div>';
                    if (function_exists(customPaginAjax)) {
                        customPaginAjax();
                    } else {
                        the_posts_pagination(array(
                            'prev_text' => thecipherbrief_get_svg(array('icon' => 'arrow-left')) . '<span class="screen-reader-text">' . __('Previous page', 'thecipherbrief') . '</span>',
                            'next_text' => '<span class="screen-reader-text">' . __('Next page', 'thecipherbrief') . '</span>' . thecipherbrief_get_svg(array('icon' => 'arrow-right')),
                            'before_page_number' => '<span class="meta-nav screen-reader-text">' . __('Page', 'thecipherbrief') . ' </span>',
                        ));
                    }
                else :

                    get_template_part('template-parts/post/content', 'none');

                endif; ?>
            </main>
    <?php  } ?>
        </div>
    </div>
    <?php
    echo ($my_sidebar ? $my_sidebar : '');?>
</div>

<?php get_footer();
