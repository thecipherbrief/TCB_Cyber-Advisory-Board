<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */
?>
<div class="views-row" style="margin-bottom: 50px;">
    <?php

    $post_meta = get_metadata('post',$post->ID);
    $category = $categories = get_the_terms( $post->ID, 'podcast_categories' );
    ?>
        <?php
        $title = isset( $post->post_title ) ? $post->post_title : '';
        echo '<div class="brief-info podcast-info">';
            $posttime = timeLink();
            echo'<span class="posted-on timestamp">' . $posttime. '</span>';
            if(!empty($category)):
                foreach ($category as $k => $v){
                    if($v->term_id != $wp_query->queried_object->term_id) {
                        echo'<div class="brief-region" style="margin-top:-10px;margin-bottom:5px;"><h4><a href="/'.$v->taxonomy.'/'.$v->slug.'/" class="byline">'.$v->name.'</a></h4></div>';
                    }
                }
            endif;
        $metapost = get_post_meta($post->ID);
        if(IsSet($metapost['wpcf-image']) && IsSet($metapost['wpcf-image'][0])){
            echo '<img src="'.$metapost['wpcf-image'][0].'"/>';
        }
        echo '</div><!-- .podcast-info -->';
        echo '<div class="brief-contain">';
        echo '<div class="column-content podcast-content">';
        echo '<h2 class="entry-title">'.$title.'</h2>';
        if(IsSet($metapost['wpcf-podcastembedcode']) && IsSet($metapost['wpcf-podcastembedcode'][0])){
            echo $metapost['wpcf-podcastembedcode'][0];
        }
        echo '<div class="paragraf">';
            echo $post->post_content;
        echo '</div>';
        echo '</div>';
        echo '</div>';
/*
        echo '<div class="single-featured-image-header'.($post->post_type ? ' '.$post->post_type : '').'">';
            $post_thumbnail_id = get_post_thumbnail_id( $post );
            if ( $post_thumbnail_id ) {
                $image = wp_get_attachment_image_src($post_thumbnail_id, 'post_thumbnail');
                if(IsSet($image[0]) && $image[0] && is_url_exist($image[0])){
                    echo '<img src="'.$image[0].'"/>';
                }
            }
            echo '</div>';
        echo '</div><!-- .single-featured-image-header -->';
*/
        ?>
</div><!-- #post-## -->
