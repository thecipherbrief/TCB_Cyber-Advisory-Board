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
    Template Name: Page Briefs
*/
$post = get_post();
$paged = $wp_query -> query['paged'] ? $wp_query -> query['paged'] : 1;
$paged = IsSet($_GET['page']) ? (int)$_GET['page'] : $paged;
$count_per_page = get_option( 'posts_per_page' );
$my_sidebar = getMySideBar('wpcf-show_article_page_catalog','wpcf-sort_article_page_catalog',array(),($myEvent ? $myEvent : array()));
get_header();
the_custom_above_banner();
?>
    <div class="site-content-contain post_content">
        <div class="post_article content-inner inner column center border_bottom">
            <div class="view-header">
                <h1> <?php echo $post->post_title; ?></h1>
            </div>
<?php
$wp_query = new WP_Query(array(
    'cache_results' => false,
    'paged' => $paged,
    'post_type' => 'post',
    'meta_query' => array(
        'relation' => 'AND',
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
        array(
            'relation' => 'OR',
            array(
                'key' => 'wpcf-exclusive',
                'compare' => 'NOT EXISTS',
            ),
            array(
                'key' => 'wpcf-exclusive',
                'value' => '1',
                'compare' => '!='
            ),
        ),
    ),
    'orderby' => 'date',
    'order' => 'DESC',
));
if ( $wp_query->have_posts() ) {
    while (have_posts()) {
        the_post();
        $post_region = wp_get_post_terms($post->ID, 'region');
        $post_categories = wp_get_post_terms($post->ID, 'category');
        $posttime = timeLink();
?>
        <div class="views-row">
            <div class="brief-info">
                <div class="timestamp"><?php echo $posttime ?></div>
                <div class="brief-region">
<?php if($post_region):?>
    <?php foreach($post_region as $region): ?>
        <h4><a href="article/<?php echo $region -> slug ?>/"><?php echo $region -> name ?></a></h4>
    <?php endforeach; ?>
<?php endif;?>
<?php if($post_categories):?>
    <?php foreach($post_categories as $categories): ?>
        <h4><a href="/<?php echo $categories->taxonomy ?>/<?php echo $categories -> slug ?>/"><?php echo $categories -> name ?></a></h4>
    <?php endforeach; ?>
<?php endif;?>
                </div>
            </div>
            <a href="<?=get_correct_url($post->ID)?>">
                <div class="brief-contain">
                    <div class="brief-crop">
                        <?php
                            $image = '';
                            ob_start();
                                the_post_thumbnail( 'thecipherbrief-featured-image' );
                            $image = ob_get_clean();
                            if($image){
                                echo $image;
                            }
                        ?>

                    </div>
                    <div class="brief-content">
                        <div class="timestamp-mobile"><?php echo $posttime ?></div>
                        <h2><?php echo $post->post_title ?></h2>
                        <?php $author = wp_get_post_terms($post->ID, 'authors');?>
                        <?php if($author[0]):?>
                        <h3>by <?php echo getPostAuthor($author) ?></h3>
                        <?php endif; ?>
                        <p><?php the_truncated_post(200) ?></p>
                    </div>
                </div>
            </a>
        </div>
<?php
    }
    if (function_exists(custom_pagination)) {
        custom_pagination($wp_query->max_num_pages,"",$paged);
    }
}
?>
        </div>
        <?php echo ($my_sidebar ? $my_sidebar : '');?>
    </div>
<?php
get_footer();
