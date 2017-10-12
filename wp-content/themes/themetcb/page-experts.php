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
    Template Name: Expert page
*/
    $post = get_post();
    get_header();
    the_custom_above_banner();
?>
<div class="site-content-contain">
    <div id="content" class="site-content post_content">
        <div class="experts">
            <h1 class="entry-title"><?php echo $post->post_title; ?></h1>

<?php
    echo $content = apply_filters( 'the_content', $post -> post_content);
    $results = $wpdb->get_results("SELECT
                                            t4.*,t6.slug
                                   FROM wp_term_taxonomy AS t1
                                   INNER JOIN wp_termmeta AS t2 ON t2.term_id = t1.term_id AND t2.meta_key = 'metatax_our_network' AND t2.meta_value = 'on'
                                   INNER JOIN wp_termmeta AS t3 ON t3.term_id = t1.term_id AND t3.meta_key = '_thumbnail_id'
                                   INNER JOIN wp_posts AS t4 ON t4.ID = t3.meta_value
                                   INNER JOIN wp_termmeta AS t5 ON t5.term_id = t1.term_id AND t5.meta_key = 'metatax_order'
                                   INNER JOIN wp_terms AS t6 ON t6.term_id = t3.term_id
                                   WHERE t1.taxonomy = 'experts'
                                   ORDER BY  CAST(t5.meta_value AS SIGNED)");
    if(!empty($results)){
?>
    </div>
        <hr>
        <div class="staff">
            <div class="view-content">
<?php
                foreach ($results as $k => $v){
                    echo '<div class="views-row-expert">';
                            echo '<div class="expert-headshot" style="background-image: url('.$v -> guid.');"></div>';
                        echo '<div class="expert-head">';
                            echo '<div class="expert-name-display">';
                                echo $v -> post_title;
                                echo '<div class="titles">'.$v -> post_excerpt.'</div>';
                            echo '</div>';
                        echo '</div>';
                    echo'
                        <a href="/expert/'.$v->slug.'/">
                            <div class="text hover-url">
                                <span class="arrow-link"><i class="fa fa-arrow-right"></i> Read Full Bio</span>
                            </div>
                        </a>
                    ';
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
