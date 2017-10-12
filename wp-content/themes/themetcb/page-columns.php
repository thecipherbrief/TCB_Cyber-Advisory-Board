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
    Template Name: Page Columns
*/

$post = get_post();
$paged = $wp_query -> query['paged'] ? $wp_query -> query['paged'] : 1;
$paged = IsSet($_GET['page']) ? (int)$_GET['page'] : $paged;
$my_sidebar = getMySideBar('wpcf-show_column_article','wpcf-sort_column_article',array(),($myEvent ? $myEvent : array()));
get_header();
the_custom_above_banner();
?>
    <div class="site-content-contain post_content">
        <div class="post_article content-inner inner column center">
            <div class="view-header">
                <h1><?php echo $post->post_title; ?></h1>
            </div>
<?php
$terms_id = array();
$results = $wpdb->get_results("SELECT * FROM wp_term_taxonomy WHERE taxonomy='columns'");
if(!empty($results)){
    foreach ($results as $k => $v){
        $terms_id[] = $v -> term_id;
    }
}

if(!empty($terms_id)) {
    $for_wp = array(
        'cache_results' => false,
        'paged' => $paged,
        'post_type' => 'column_article',
        "orderby" => "date",
        "order" => 'DESC'
    );
    $wp_query = new WP_Query($for_wp);
    if ($wp_query->have_posts()) {
        while (have_posts()) {
            the_post();
            $posttime = timeLink();
            ?>
            <?php
                $author = wp_get_post_terms($post->ID, 'authors');
                $img = '';
                if($author[0]){
                    $temp = $wpdb->get_results("SELECT * FROM wp_termmeta WHERE term_id=".(int)$author[0]->term_id." AND meta_key='_thumbnail_id'");
                    if($temp[0]){
                        $temp = $wpdb->get_results("SELECT guid FROM wp_posts WHERE ID=".(int)$temp[0]->meta_value);
                        if($temp[0] && IsSet($temp[0]->guid) && $temp[0]->guid){
                            $img = $temp[0]->guid;
                        }
                    }
                }
            ?>
            <div class="views-row">
                <div class="brief-info">
                    <div class="timestamp"><?php echo $posttime ?></div>
                </div>
                <a href="<?php echo esc_url(get_permalink()) ?>">
                    <div class="brief-contain">
                        <div class="img-crop">
                            <?php
                            if ($img){
                                echo '<img src="'.$img.'"/>';
                            }
                            ?>

                        </div>
                        <div class="brief-content">
                            <div class="timestamp-mobile"><?php echo $posttime ?></div>
                            <h2><?php echo $post->post_title ?></h2>
                            <?php if ($author[0]): ?>
                                <h3>by <?php echo $author[0]->name ?></h3>
                            <?php endif; ?>
                            <p><?php the_truncated_post(200) ?></p>
                        </div>
                    </div>
                </a>
            </div>
            <?php
        }
        if (function_exists('custom_pagination')) {
            custom_pagination($custom_query->max_num_pages, "", $paged);
        }
    }
    ?>
    </div>
    <?php echo ($my_sidebar ? $my_sidebar : '');?>
<?php
    }
?>
    </div>
</div>
    <?php
get_footer();
