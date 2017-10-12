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
    Template Name: Page Dead Drop
*/
$my_sidebar = getMySideBar('wpcf-show_dead_drop','wpcf-show_dead_drop');
get_header();
the_custom_above_banner();

$for_wp = array(
    'cache_results' => false,
    'paged' => 1,
    'posts_per_page' => 1,
    'post_type' => 'dead_drop_article',
    "orderby" => "date",
    "order" => 'DESC'
);
$wp_query = new WP_Query($for_wp);
if ( $wp_query->have_posts() ) {
    while (have_posts()) {
        the_post();
        ?>
        <div class="region region-content-top"></div>
        <div class="site-content-contain post_content">
            <div class="post_article content-inner inner column center">
                <?php
                $thumb_id = get_post_thumbnail_id();
                $thumb_url = wp_get_attachment_image_src($thumb_id, 'thumbnail-size', true);
                ?>
                <div class="dead_media" style="background-image: url(<?php echo $thumb_url[0]; ?>); background-position: 0px 0px; background-repeat: no-repeat; width: 100%; height: 500px;">
                    <div class="view-dead-drop">
                        <div>
                            <h1><?php the_title(); ?></h1>
                            <h4>Noun.</h4>
                            <ol>
                                <li>A location to secretly pass information without a face-to-face meeting.</li>
                            </ol>
                            <hr>
                            <p>Each week we hope to give our readers tidbits of gossip from the world of national security and intelligence. The Dead Drop is a source of fun or intriguing news you can't get anywhere else.</p>
                            <p>Got a tip for us? Email us at <a href="mailto:thedeaddrop@thecipherbrief.com">thedeaddrop@thecipherbrief.com</a> and share the scoop. We promise to protect our sources and methods.</p>
                            <hr>
                            <p>Below is our recent intelligence collection:</p>
                        </div>
                    </div>
                </div>
                <?php
                $current_url = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
                echo'<div class="image_social">';
//                    echo'<a onclick="return loadpopupSocial(this);" rel="external nofollow" class="ss-button-facebook" href="http://www.facebook.com/sharer/sharer.php?u=' . urlencode($current_url) . '" target="_blank"><span class="at-icon-wrapper" style="background-color: rgb(59, 89, 152); line-height: 32px; height: 32px; width: 32px;"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 32 32" title="Facebook" alt="Facebook" class="at-icon at-icon-facebook" style="width: 32px; height: 32px;"><g><path d="M22 5.16c-.406-.054-1.806-.16-3.43-.16-3.4 0-5.733 1.825-5.733 5.17v2.882H9v3.913h3.837V27h4.604V16.965h3.823l.587-3.913h-4.41v-2.5c0-1.123.347-1.903 2.198-1.903H22V5.16z" fill-rule="evenodd"></path></g></svg></span></a>';
//                    echo'<a onclick="return loadpopupSocial(this);" rel="external nofollow" class="ss-button-twitter" href="http://twitter.com/intent/tweet/?text=' . $title . '&url=' . urlencode($current_url) . '&via=' . (IsSet($author[0]) ? $author[0]->name : '') . '" target="_blank"><span class="at-icon-wrapper" style="background-color: rgb(29, 161, 242); line-height: 32px; height: 32px; width: 32px;"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 32 32" title="Twitter" alt="Twitter" class="at-icon at-icon-twitter" style="width: 32px; height: 32px;"><g><path d="M27.996 10.116c-.81.36-1.68.602-2.592.71a4.526 4.526 0 0 0 1.984-2.496 9.037 9.037 0 0 1-2.866 1.095 4.513 4.513 0 0 0-7.69 4.116 12.81 12.81 0 0 1-9.3-4.715 4.49 4.49 0 0 0-.612 2.27 4.51 4.51 0 0 0 2.008 3.755 4.495 4.495 0 0 1-2.044-.564v.057a4.515 4.515 0 0 0 3.62 4.425 4.52 4.52 0 0 1-2.04.077 4.517 4.517 0 0 0 4.217 3.134 9.055 9.055 0 0 1-5.604 1.93A9.18 9.18 0 0 1 6 23.85a12.773 12.773 0 0 0 6.918 2.027c8.3 0 12.84-6.876 12.84-12.84 0-.195-.005-.39-.014-.583a9.172 9.172 0 0 0 2.252-2.336" fill-rule="evenodd"></path></g></svg></span></a>';
//                    echo'<a onclick="return loadpopupSocial(this);" rel="external nofollow" class="ss-button-linkedin" href="http://www.linkedin.com/shareArticle?mini=true&url=' . urlencode($current_url) . '&title=' . $title . '" target="_blank"><span class="at-icon-wrapper" style="background-color: rgb(0, 119, 181); line-height: 32px; height: 32px; width: 32px;"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 32 32" title="LinkedIn" alt="LinkedIn" class="at-icon at-icon-linkedin" style="width: 32px; height: 32px;"><g><path d="M26 25.963h-4.185v-6.55c0-1.56-.027-3.57-2.175-3.57-2.18 0-2.51 1.7-2.51 3.46v6.66h-4.182V12.495h4.012v1.84h.058c.558-1.058 1.924-2.174 3.96-2.174 4.24 0 5.022 2.79 5.022 6.417v7.386zM8.23 10.655a2.426 2.426 0 0 1 0-4.855 2.427 2.427 0 0 1 0 4.855zm-2.098 1.84h4.19v13.468h-4.19V12.495z" fill-rule="evenodd"></path></g></svg></span></a>';
//                    echo'<a onclick="return loadpopupSocial(this);" rel="external nofollow" class="ss-button-email" href="https://www.addthis.com/bookmark.php?v=300" target="_blank"><span class="at-icon-wrapper" style="background-color: rgb(132, 132, 132); line-height: 32px; height: 32px; width: 32px;"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 32 32" title="Email" alt="Email" class="at-icon at-icon-email" style="width: 32px; height: 32px;"><g><g fill-rule="evenodd"></g><path d="M27 22.757c0 1.24-.988 2.243-2.19 2.243H7.19C5.98 25 5 23.994 5 22.757V13.67c0-.556.39-.773.855-.496l8.78 5.238c.782.467 1.95.467 2.73 0l8.78-5.238c.472-.28.855-.063.855.495v9.087z"></path><path d="M27 9.243C27 8.006 26.02 7 24.81 7H7.19C5.988 7 5 8.004 5 9.243v.465c0 .554.385 1.232.857 1.514l9.61 5.733c.267.16.8.16 1.067 0l9.61-5.733c.473-.283.856-.96.856-1.514v-.465z"></path></g></svg></span></a>';
                    echo'<div class="addthis_inline_share_toolbox addthis_default_style addthis_32x32_style">' .
                        '<a class="addthis_button_email"></a>' .
                        '<a class="addthis_button_linkedin"></a>' .
                        '<a class="addthis_button_twitter" addthis:url="'.get_site_url().'/dead-drop/'.$post->post_name.'/"></a>' .
                        '<a class="addthis_button_facebook" addthis:url="'.get_site_url().'/dead-drop/'.$post->post_name.'/"></a>' .
                    '</div>';
                echo'</div>';
                ?>
                <div id="content-area" class="content-area">
                    <div class="region region-content">
                        <div id="block-system-main"
                             class="block block-system block-even block-first block-last clearfix">
                            <div class="content clearfix">
                                <div id="node-1480" class="node node-page node-odd">
                                    <div class="content dead_content">
                                        <?php the_content(); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php echo ($my_sidebar ? $my_sidebar : ''); ?>
        </div>
        <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
        <script>(adsbygoogle = window.adsbygoogle || []).push({google_ad_client: "ca-pub-7418758779618043",enable_page_level_ads: true});</script>
	
	    <?php
    }
}
get_footer();
