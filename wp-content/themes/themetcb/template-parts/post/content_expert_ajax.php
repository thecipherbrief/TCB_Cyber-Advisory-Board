<?php
    $posttime = timeLink();
    $urlLink = '';
    if($post->post_type){
        $columns = wp_get_post_terms($post->ID, 'columns');
        foreach($columns as $column):
            $urlLink = '/column/'.$column -> slug.'/';
        endforeach;
    }
?>
<div class="views-row">
    <a href="<?php echo ($post->post_type == 'column_article' ? $urlLink.'/' : '')?><?php echo $post->post_name; ?>/">
        <div class="title"><?php echo $post->post_title ?></div>
        <?php echo $posttime ?>
        <div class="content"><?php the_truncated_post(200) ?></div>
    </a>
</div>
