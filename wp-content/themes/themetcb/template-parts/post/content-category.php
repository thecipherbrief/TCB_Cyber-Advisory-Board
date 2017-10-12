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


<div class="views-row-cat">
  <?php
    $post_categories = wp_get_post_categories( $post->ID );
    $posttime = timeLink();
  ?>

  <div class="views-field-title">
    <h3 class="field-content">
        <a href="<?=get_correct_url($post->ID)?>"><?php echo $post->post_title ?></a>
    </h3>
    </div>
    <div class="views-field">
        <span class="field-content"><?php echo $posttime ?></span>
    </div>
    <div class="views-field-body">
        <span class="field-content"><p><?php echo wp_trim_words( $post -> post_content, 50, ' ...' ) ?></p></span>
    </div>
</div>
