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
    Template Name: Page About Us
*/
    $post = get_post();
    get_header();
    the_custom_above_banner();
?>
<div class="region region-content-top"></div>
<div class="site-content-contain">
    <div id="content" class="site-content post_content about_page">
      <span style="line-height: 25px;margin-top: 20px;display: block;">
        <h1 class="entry-title"><?php echo $post->post_title; ?></h1>
<?php
    echo $content = apply_filters( 'the_content', $post -> post_content);
    $results = $wpdb->get_results("SELECT
                                          t4.*
                                       FROM wp_term_taxonomy AS t1
                                       INNER JOIN wp_termmeta AS t2 ON t2.term_id = t1.term_id AND t2.meta_key = 'metatax_about_us' AND t2.meta_value = 'on'
                                       INNER JOIN wp_terms AS t3 ON t3.term_id = t1.term_id
                                       INNER JOIN wp_posts AS t4 ON t4.post_name = t3.slug
                                       INNER JOIN wp_termmeta AS t5 ON t5.term_id = t1.term_id AND t5.meta_key = 'metatax_order'
                                       WHERE t1.taxonomy = 'authors'
                                       ORDER BY  CAST(t5.meta_value AS SIGNED)
                                      ");
  // pre($results);
    if(!empty($results)){
?>
        </span>
        <hr>
        <div class="staff">
            <h2>The Staff</h2>
            <div class="view-content">
<?php
                foreach ($results as $k => $v){
                    echo '<div class="staff-row">';
                        echo '<div class="field-content staff-head">';
                            echo '<img src="'.$v -> guid.'" alt="'.$v -> post_title.'">';
                        echo '</div>';
                        echo '<div class="staff-rollover" ontouchstart="">';
                            echo '<div class="text">';
                                echo '<h3>'.$v -> post_title.'</h3>';
                                echo '<div class="titles">'.$v -> post_excerpt.'</div>';
                                echo '<p>'.$v -> post_content.'</p>';
                            echo '</div>';
                        echo '</div>';
                    echo '</div>';
                }
?>
            </div>
        </div>
<?php
    }
?>
    </div>
</div>
<?php
    get_footer();
