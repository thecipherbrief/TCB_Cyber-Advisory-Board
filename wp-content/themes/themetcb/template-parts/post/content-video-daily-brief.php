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
<?php
$post_meta = get_metadata('post',$post->ID);
$category = $categories = get_the_terms( $post->ID, 'podcast_categories' );
$metapost = get_post_meta($post->ID);
$title = isset( $post->post_title ) ? $post->post_title : '';
$posttime = timeLink();
$video = '';
if(IsSet($metapost['wpcf-videobrif']) && IsSet($metapost['wpcf-videobrif'][0]) && $metapost['wpcf-videobrif'][0]){
    $video = ' href="'.$metapost['wpcf-videobrif'][0].'" class="popup-video views-row"';
} else {
    $video = ' class="views-row"';
}
?>
<div style="margin-bottom: 50px;"<?php echo $video ?>>
    <div class="brief-info podcast-info">
        <span class="posted-on timestamp"><?php echo $posttime ?></span>
<?php
            if(IsSet($metapost['_thumbnail_id']) && IsSet($metapost['_thumbnail_id'][0]) && $metapost['_thumbnail_id'][0]){
                $image = wp_get_attachment_image_src($metapost['_thumbnail_id'][0], 'post_thumbnail');
                echo '<img src="'.$image[0].'"/>';
            }
?>
    </div>
    <div class="brief-contain">
        <div class="column-content podcast-content">
            <h2 class="entry-title"><?php echo $title ?></h2>
            <div class="paragraf"><?php echo $post->post_content ?></div>
        </div>
    </div>
</div>
