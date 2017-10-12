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

<div class="views-row">
    <?php
    $post_categories = wp_get_post_categories( $post->ID );
    $posttime = timeLink();
    ?>
    <div class="brief-info">
        <div class="timestamp"><?php echo $posttime ?></div>
        <div class="brief-region">
            <?php if($post_categories):?>
                <?php foreach($post_categories as $k => $v): ?>
                    <?php $category = get_the_category($v) ?>
                    <h4><a href="/<?php echo $category[0] -> taxonomy ?>/<?php echo $category[0] -> slug ?>/"><?php echo $category[0] -> name ?></a></h4>
                <?php endforeach; ?>
            <?php endif;?>
        </div>
    </div>
    <a href="<?php echo esc_url( get_permalink() ) ?>">
        <div class="brief-contain">
            <div class="brief-crop">
                <?php
                if(the_post_thumbnail( 'thecipherbrief-featured-image' ) == false)
                    echo "<img src='http://dummyimage.com/800x600/4d494d/686a82.gif&text=placeholder+image' />";
                else
                    the_post_thumbnail( 'thecipherbrief-featured-image' );
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
