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
global $post_meta;
global $post_id_key;
global $article_exerpt;
?>

<div class="views-row">
    <header class="entry-header">
        <?php
        if( $article_exerpt == true){
            echo '<strong class="expert-com">Expert Commentary</strong>';
        }
        $title = isset( $post->post_title ) ? $post->post_title : '';
        if ( is_single() ) {
            the_title( '<h1 class="entry-title">', '</h1>' );
            the_content('<p>', '</p>');
        } else {
            the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
        }
        if ( 'post' === get_post_type() ) :
            echo '<div class="entry-meta">';
                $posttime = timeLink();
                echo'<span class="posted-on">' . $posttime. '</span>';
                $author = wp_get_post_terms($post->ID, 'authors');
                if($author):
                    echo'<span class="byline">' .
                            '<span class="author vcard"> | '.getPostAuthor($author).'</span>' .
                        '</span>';
                endif;
            echo '</div><!-- .entry-meta -->';
        endif;
        // If a regular post or page, and not the front page, show the featured image.
        echo '<div class="single-featured-image-header'.($post->post_type ? ' '.$post->post_type : '').'">';
           echo get_the_post_thumbnail($post);
            $current_url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
            echo '<div class="image_social">';
                echo'<div class="addthis_inline_share_toolbox addthis_default_style addthis_32x32_style">' .
                        '<a class="addthis_button_email"></a>' .
                        '<a class="addthis_button_linkedin"></a>' .
                        '<a class="addthis_button_twitter"></a>' .
                        '<a class="addthis_button_facebook"></a>' .
                    '</div>';
                if(IsSet($post_meta['wpcf-photocreditcaption']) && IsSet($post_meta['wpcf-photocreditcaption'][0]) && $post_meta['wpcf-photocreditcaption'][0]) {
                    echo '<span style="margin-left: 190px; margin-top: -10px; position: absolute;">'.$post_meta['wpcf-photocreditcaption'][0].'</span>';
                }
            echo '</div>';
        echo '</div><!-- .single-featured-image-header -->';
        ?>
    </header><!-- .entry-header -->
    <div class="block block-block newsletter-top-cta block-even clearfix">
        <div class="content clearfix">
            <div class="promo-left">
                <h2>The Newsletter</h2>
                <p>Get exclusive analysis delivered to your inbox daily.</p>
            </div>
            <div class="promo-right">
                <a class="light-blue-button" href="/subscribe/">subscribe now</a>
            </div>
        </div>
    </div>
    <?php if ( '' !== get_the_post_thumbnail() && ! is_single() ) : ?>
        <div class="post-thumbnail">
            <a href="<?php the_permalink(); ?>">
                <?php the_post_thumbnail( 'thecipherbrief-featured-image' ); ?>
            </a>
        </div><!-- .post-thumbnail -->
    <?php endif; ?>

    <div class="entry-content">

        <?php
        $post_id_key = $post->ID;
        $check_img = get_the_post_thumbnail($post->ID);
        if((IsSet($post_meta['wpcf-articleexcerpt']) && IsSet($post_meta['wpcf-articleexcerpt'][0]) && $post_meta['wpcf-articleexcerpt'][0])||((IsSet($post_meta['wpcf-exclusive']) && IsSet($post_meta['wpcf-exclusive'][0]) && $post_meta['wpcf-exclusive'][0])&&('' == get_the_post_thumbnail()))){
            $author = wp_get_post_terms($post->ID, 'experts');
            $primary = new WPSEO_Primary_Term('experts', $post->ID);
            foreach ($author as $key=>$id){
                if($id->term_id==$primary->get_primary_term()) {
                    unset($author[$key]);
                    array_unshift($author, $id);
                }
            }
            if($author[0]){
                echo '<div class="block block-views expert-article-headshot block-even clearfix">';
                foreach ($author as $k => $v) {
                    $temp = $wpdb->get_results("SELECT * FROM wp_termmeta WHERE term_id=".(int)$v->term_id." AND meta_key='_thumbnail_id'");
                    if($temp[0]){
                        $temp = $wpdb->get_results("SELECT guid,post_excerpt FROM wp_posts WHERE ID=".(int)$temp[0]->meta_value);
                        if($temp[0] && IsSet($temp[0]->guid) && $temp[0]->guid) {
                            echo '<a href="/'.$v->taxonomy.'/'.$v->slug.'/">';
                                echo '<img src="'.$temp[0]->guid.'" width="220" height="220" alt="">';
                                echo '<div class="expert-name">';
                                    echo $v -> name;
                                    echo '</br>';
                                    echo $temp[0] -> post_excerpt;
                                echo '</div>';
                            echo '</a>';
                        } else {
                            echo "NOT FOUND !!!";
                        }
                    }
                }
                echo '</div>';
            }
        }

        /* translators: %s: Name of current post */
        the_content( sprintf(
            __( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'thecipherbrief' ),
            get_the_title()
        ) );

        wp_link_pages( array(
            'before'      => '<div class="page-links">' . __( 'Pages:', 'thecipherbrief' ),
            'after'       => '</div>',
            'link_before' => '<span class="page-number">',
            'link_after'  => '</span>',
        ) );
        ?>
    </div><!-- .entry-content -->

    <?php if ( is_single() ) : ?>
    <?php
        $separate_meta = __( ' ', 'thecipherbrief' );

        $relID = array();
        $terms = get_the_terms( $post->ID, 'post_tag');
        if(!empty($terms)){
            foreach($terms as $term){
                $relID[$term -> term_id] = $term -> term_id;
            }
        }
        $terms = get_the_terms( $post->ID, 'topic_areas');
        if(!empty($terms)){
            foreach($terms as $term){
                $relID[$term -> term_id] = $term -> term_id;
            }
        }
        $tags_list = get_my_the_term_list( $id, 'post_tag', '', '', '');
        if ( $tags_list || get_edit_post_link() ) {
            echo '<footer class="entry-footer">';
            if ( 'post' === get_post_type() ) {
                if ( $tags_list ) {
                    if ( $tags_list ) {
                        echo '<span class="tags-links">' . $tags_list . '</span>';
                    }
                }
            }
            thecipherbrief_edit_link();
            echo '</footer>';
        }

    if((IsSet($post_meta['wpcf-articleexcerpt']) && IsSet($post_meta['wpcf-articleexcerpt'][0]) && $post_meta['wpcf-articleexcerpt'][0])||((IsSet($post_meta['wpcf-exclusive']) && IsSet($post_meta['wpcf-exclusive'][0]) && $post_meta['wpcf-exclusive'][0])&&('' == get_the_post_thumbnail()))) {
        if ($author[0]) {
                ?>
                <div class="footerAuthor">
                    <div class="view-content">
                        <h3>The Author is <a
                                    href="/<?=$author[0]->taxonomy?>/<?=$author[0]->slug?>"><?=$author[0]->name?></a>
                        </h3>
                    </div>
                    <div class="views-field-description">
                        <?php if(strlen($author[0]->description)>498){ ?>
                            <span class="field-content"><?=get_the_truncated_content(498,$author[0]->description)?> </span>
                        <a style="text-decoration: underline" href="/<?=$author[0]->taxonomy?>/<?=$author[0]->slug?>">Read More</a>
                        <?php } else { ?>
                            <span class="field-content"><?=$author[0]->description?></span>
                        <?php } ?>
                    </div>
                    <?php if($author[1]){?>
                        <div class="view-content">
                            <h3>The Coauthor is <a
                                        href="/<?=$author[1]->taxonomy?>/<?=$author[1]->slug?>"><?=$author[1]->name?></a>
                            </h3>
                        </div>
                        <div class="views-field-description">
                            <?php if(strlen($author[1]->description)>498){ ?>
                                <span class="field-content"><?=get_the_truncated_content(498,$author[1]->description)?> </span>
                                <a style="text-decoration: underline" href="/<?=$author[1]->taxonomy?>/<?=$author[1]->slug?>">Read More</a>
                            <?php } else { ?>
                                <span class="field-content"><?=$author[1]->description?></span>
                            <?php } ?>
                        </div>
                    <?php }?>
                    <div class="views-field-nothing">
                    <span class="field-content learn-more-about">
                        <p>Learn more about The Cipher's Network <a href="/experts/" >here</a></p>
                    </span>
                    </div>
                </div>
                <?php

            ?>

            <?php
        }
    }
        $tags_exist = wp_get_post_tags($post->ID);
    ?>
    <?php endif; ?>

    <?php
    // @mpegi related articles
    if(($tags_exist)&&!empty($tags_exist)||($terms&&!empty($terms))) {
        $tags = wp_get_post_tags($post->ID);
        $main_count = count($tags);
        $count = 0;
        for ($i = 1; $i <= $main_count; $i++) {
            if ($tags) {
                $main_tag = $tags[$i-1]->term_id;
                $args = array(
                    'tag__in' => array($main_tag),
                    'post__not_in' => array($post->ID),
                    'posts_per_page' => -1,
                    'caller_get_posts' => 1,
                    'orderby' => 'DESC',
                    'order' => 'date',
                    'meta_query' => array(
                        'relation' => 'AND',
                        array(
                            'relation' => 'OR',
                            array(
                                'key' => 'wpcf-articleexcerpt',
                                'compare' => 'NOT EXISTS',
                                'value' => ''
                            ),
                            array(
                                'key' => 'wpcf-articleexcerpt',
                                'value' => ''
                            )
                        ),
                        array(
                            'relation' => 'AND',
                            array(
                                'key' => '_thumbnail_id',
                                'compare' => 'EXISTS',
                            ),
                            array(
                                'key' => '_thumbnail_id',
                                'value' => '',
                                'compare' => '!='
                            ),
                        ),
                    ),
                );
                $my_query = new WP_Query($args);
                if ($my_query->have_posts()) {
                    while ($my_query->have_posts()) : $my_query->the_post();
                        $tags_post = wp_get_post_tags($post->ID);
                        $post_tag = $tags_post[0]->term_id;
                        if ($post_tag == $main_tag) {
                            $count = $count + 1;
                            if($count==1){
                            echo '<div id="block-views-home-block_2" class="block block-views block-odd clearfix">
    <div class="content clearfix">
        <h2>Related Articles</h2>
        <div class="view view-home view-id-home view-display-id-block_2">
              <div class="view-content">
                  <table class="views-view-grid cols-3">
                    <tbody>
                        <tr class="row-1 row-first row-last">'; }
                            ?>
                            <td class="col-1 col-first">
                                <div class="views-field views-field-views-conditional">
                                <span class="field-content">
                                    <a href="<?=get_correct_url($post->ID)?>">
                                        <div class="summary">
                                            <div class="img-feed">
                                                <?php
                                                the_post_thumbnail();
                                                ?>
                                                  </div>
                                            <h3><?php echo $post->post_title ?></h3>
                                            <?php
                                            $author = wp_get_post_terms($post->ID, 'authors');
                                            ?>
                                            <h4><?php echo getPostAuthor($author) ?></h4>
                                        </div>
                                    </a>
                                </span>
                                </div>
                            </td>
                            <?php
                            if ($count == 3) {
                                break;
                            }
                        }
                    endwhile;
                }
                wp_reset_query();
            }
            if ($count == 3) {
                break;
            }
        }
    }
    if (($i == $main_count) && ($count < 3)) {
        $args = array(
            'cache_results'  => false,
            'post_type'      => 'post',
            'orderby'        => 'DESC',
            'posts_per_page' => -1,
            'post__not_in'   => array($post->ID),
            'tax_query'      => array(
                'relation'   => 'OR',
                array(
                    'taxonomy' => 'post_tag',
                    'terms'   => $relID,
                    'field'   => 'id',
                    'operator' => 'IN'
                ),
                array(
                    'taxonomy' => 'topic_areas',
                    'terms'   => $relID,
                    'field'   => 'id',
                    'operator' => 'IN'
                )
            ),
            'meta_query' => array(
                'relation' => 'AND',
                array(
                    'relation' => 'OR',
                    array(
                        'key' => 'wpcf-articleexcerpt',
                        'compare' => 'NOT EXISTS',
                        'value' => ''
                    ),
                    array(
                        'key' => 'wpcf-articleexcerpt',
                        'value' => ''
                    )
                ),
                array(
                    'relation' => 'AND',
                    array(
                        'key' => '_thumbnail_id',
                        'compare' => 'EXISTS',
                    ),
                    array(
                        'key' => '_thumbnail_id',
                        'value' => '',
                        'compare' => '!='
                    ),
                ),
            )
        );
        $topic_query = new WP_Query($args);
        if ($topic_query->have_posts()) {
            if($count<=0){
                echo '<div id="block-views-home-block_2" class="block block-views block-odd clearfix">
    <div class="content clearfix">
        <h2>Related Articles</h2>
        <div class="view view-home view-id-home view-display-id-block_2">
              <div class="view-content">
                  <table class="views-view-grid cols-3">
                    <tbody>
                        <tr class="row-1 row-first row-last">'; }
            while ($topic_query->have_posts()) : $topic_query->the_post();
                ?>
                <td class="col-1 col-first">
                    <div class="views-field views-field-views-conditional">
                                <span class="field-content">
                                    <a href="<?=get_correct_url($post->ID)?>">
                                        <div class="summary">
                                            <div class="img-feed">
                                                <?php
                                                the_post_thumbnail();
                                                ?>
                                                  </div>
                                            <h3><?php echo $post->post_title ?></h3>
                                            <?php
                                            $author = wp_get_post_terms($post->ID, 'authors');
                                            ?>
                                            <h4><?php echo getPostAuthor($author) ?></h4>
                                        </div>
                                    </a>
                                </span>
                    </div>
                </td>
                <?php
                $count = $count + 1;
                if ($count == 3) {
                    break;
                }
            endwhile;
        }
        wp_reset_query();
    }
    if ($count>0) { ?>
    </tr>
    </tbody>
    </table>
</div>
    </div>
    </div>
    </div>
<?php
}
    //end
    ?>
</div><!-- #post-## -->
