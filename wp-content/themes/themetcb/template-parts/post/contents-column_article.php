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

<div class="views-row column_article_row">
    <?php
    $posttime = timeLink();
    $author = wp_get_post_terms($post->ID, 'experts');
    $primary = new WPSEO_Primary_Term('experts', $post->ID);
    foreach ($author as $key=>$id){
        if($id->term_id==$primary->get_primary_term()) {
            unset($author[$key]);
            array_unshift($author, $id);
        }
    }
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
    <div class="brief-info">
        <div class="timestamp"><?php echo $posttime ?></div>
        <?php
        $columns = wp_get_post_terms($post->ID, 'columns');
        $urlLink = '';
        ?>
        <div class="brief-region">
        <?php if($columns):?>
            <?php foreach($columns as $column): ?>
                <?php
                $urlLink = '/column/'.$column -> slug.'/';
                if($column->term_id != $wp_query->queried_object->term_id):
                ?>
                <h4><a href="<?php echo $urlLink; ?>"><?php echo $column -> name ?></a></h4>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php endif;?>
        </div>
    </div>
<!--    <a href="--><?php //echo esc_url( get_permalink() ) ?><!--">-->
    <a href="<?php echo $urlLink.$post->post_name; ?>/">
        <div class="brief-contain">
            <div class="img-crop">
                <?php
                if($img){
                    echo '<img src="'.$img.'"/>';
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
