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
    Template Name: Page Exclusives
*/

$post = get_post();
$paged = $wp_query -> query['paged'] ? $wp_query -> query['paged'] : 1;
$paged = IsSet($_GET['page']) ? (int)$_GET['page'] : $paged;
$count_per_page = get_option( 'posts_per_page' );
get_header();
the_custom_above_banner();
?>
    <div class="site-content-contain post_content">
        <div class="post_article content-inner inner column center border_bottom">
            <div class="view-header">
                <h1><?php echo $post->post_title; ?></h1>
            </div>
<?php
$wp_query = new WP_Query(array(
    'cache_results' => false,
    'paged' => $paged,
    'post_type' => 'post',
    "orderby" => "date",
    'meta_query' => array(
        'relation' => 'AND',
        array(
            'key' => 'wpcf-exclusive',
            'value' => '1',
            'compare' => '='
        ),
    ),
    "order" => 'DESC'
));
//pre($wp_query);
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
        <h4><a href="<?=get_correct_url($post->ID)?>"><?php echo $region -> name ?></a></h4>
    <?php endforeach; ?>
<?php endif;?>
<?php if($post_categories):?>
    <?php foreach($post_categories as $categories): ?>
        <h4><a href="<?=get_correct_url($post->ID)?>"><?php echo $categories -> name ?></a></h4>
    <?php endforeach; ?>
<?php endif;?>
                </div>
            </div>
            <a href="<?=get_correct_url($post->ID)?>">
                <div class="brief-contain">
                    <div class="img-crop">
                        <?php
                            $image = '';
                            ob_start();
                                the_post_thumbnail( 'thecipherbrief-featured-image' );
                            $image = ob_get_clean();
                            if($image){
                                echo $image;
                            } else {
                                $author = wp_get_post_terms($post->ID, 'experts');
                                $primary = new WPSEO_Primary_Term('experts', $post->ID);
                                foreach ($author as $key=>$id){
                                    if($id->term_id==$primary->get_primary_term()) {
                                        unset($author[$key]);
                                        array_unshift($author, $id);
                                    }
                                }
                                if(IsSet($author[0]->name)):
                                    $img = '';
                                    $temp = $wpdb->get_results("SELECT * FROM wp_termmeta WHERE term_id=".(int)$author[0]->term_id." AND meta_key='_thumbnail_id'");
                                    if($temp[0]){
                                        $temp = $wpdb->get_results("SELECT guid,post_excerpt FROM wp_posts WHERE ID=".(int)$temp[0]->meta_value);
                                        if($temp[0] && IsSet($temp[0]->guid) && $temp[0]->guid) {
                                            echo '<img src="'.$temp[0]->guid.'" alt="'.$author[0]->name.'">';
                                        }
                                    }
                                endif;
                            }
                        ?>

                    </div>
                    <div class="brief-content">
                        <div class="timestamp-mobile"><?php echo $posttime ?></div>
                        <h2><?php echo $post->post_title ?></h2>
                        <?php $author = wp_get_post_terms($post->ID, 'authors');?>
                        <?php if($author[0]):?>
                        <h3>by <?php echo $author[0]->name?></h3>
                        <?php endif; ?>
                        <p><?php the_truncated_post(200) ?></p>
                    </div>
                </div>
            </a>
        </div>
<?php
    }
    if (function_exists(custom_pagination)) {
        custom_pagination($custom_query->max_num_pages,"",$paged);
    }
}
?>
        </div>
        <div id="sidebar-second" class="column sidebar second">
            <div id="sidebar-second-inner" class="inner">
                <div class="region region-sidebar-second">
                        <?php
                        $sidebar = false;
                        if(!empty($myEvent)) {
                            ob_start();
                            foreach ($myEvent as $banner) {
                                if (IsSet($banner['title']) && $banner['title']) {
                                    echo'<div class="sponsor-ad-box">';
                                    echo'<h2>The Georgetown Salon Series is proud to present</h2>';
                                    echo'<div class="sponsor-event-cta">';
                                    echo'<h3>'.$banner['wpcf-speaker-title'].'<br>'.$banner['wpcf-speaker-name'].'</h3>';
                                    echo(IsSet($banner['wpcf-client-logo']) && $banner['wpcf-client-logo'] ? '<img src="'.$banner['wpcf-client-logo'].'" class="clientLogo"/>' : '');
                                    echo'<p>'.$banner['title'].'<br><br><b>'.$banner['wpcf-event-date'].'</b><br><br></p>';
                                    echo(IsSet($banner['content']) ? '<p>'.$banner['content'].'</p>' : '');
                                    echo(IsSet($banner['wpcf-cient-link-url']) ? '<br><a target="_blank" href="'.$banner['wpcf-cient-link-url'].'">For more information click here</a>' : '');
                                    echo'<p></p>';
                                    echo(IsSet($banner['wpcf-event-image']) && $banner['wpcf-event-image'] ? '<img src="'.$banner['wpcf-event-image'].'" class="eventImage"/>' : '');
                                    echo'</div>';
                                    echo'</div>';
                                    $sidebar = true;
                                }
                            }
                            $my_sidebar = ob_get_clean();
                        }
                        if($sidebar):
                            ?>
                            <div class="sponsor-ad-container">
                                <?php echo $my_sidebar ?>
                                <div class="sponsor-promo-cta">
                                    <a href="/become-sponsor">BECOME A SPONSOR</a>
                                </div>
                            </div>
                        <?php endif ?>
                        <?php
                        $sidebar = false;
                        if(!empty($adver)) {
                            ob_start();
                            foreach ($adver as $banner) {
                                if (IsSet($banner['wpcf-sidebar']) && $banner['wpcf-sidebar']) {
                                    echo'<div class="views-row">';
                                    echo'<div class="views-field">';
                                    echo'<div class="field-content">';
                                    echo(IsSet($banner['wpcf-url']) ? '<a target="_blank" href="'.$banner['wpcf-url'].'">' : '');
                                    echo(IsSet($banner['photo']) ? '<img src="'.$banner['photo'].'"/>' : '');
                                    echo(IsSet($banner['wpcf-url']) ? '</a>' : '');
                                    echo'</div>';
                                    echo'</div>';
                                    echo'</div>';
                                    $sidebar = true;
                                }
                            }
                            $my_sidebar = ob_get_clean();
                        }
                        if($sidebar):
                        ?>
                        <div id="block-views-advertisement_sidebar-block" class="block block-views advertisement block-even clearfix">
                            <div class="content clearfix">
                                <div class="view view-advertisement-sidebar view-id-advertisement_sidebar">
                                    <div class="view-content">
                                        <?php echo $my_sidebar ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endif ?>
                    <div id="block-block-11" class="block block-block global-newsletter-sidebar block-odd block-last clearfix">
                        <div class="content clearfix">


                            <div class="promo-header">
                                <h2>The Cipher Daily Brief</h2>
                            </div>
                            <div class="promo-content">
                                <p> Get a daily rundown of the top security stories delivered to your inbox Monday through Friday with exclusive briefs and columns on what matters most to you and your organization.</p>
                            </div>
                            <div class="promo-content">
                                <div class="simple-signup">
                                    <h6>SIGN UP FOR  The Newsletter</h6>
                                    <a class="light-blue-button" href="https://www.thecipherbrief.com/subscribe">Sign up</a>
                                </div>
                            </div>
                        </div>
                    </div>  </div>
            </div>
        </div>
    </div>
<?php
get_footer();
