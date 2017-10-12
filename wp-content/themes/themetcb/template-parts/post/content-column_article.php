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
<div class="views-rows">
    <?php
    $post_meta = get_metadata('post',$post->ID);

    if ( is_sticky() && is_home() ) :
        echo thecipherbrief_get_svg( array( 'icon' => 'thumb-tack' ) );
    endif;
    ?>
    <header class="entry-header">
        <?php
        $author = wp_get_post_terms($post->ID, 'authors');
        $title = isset( $post->post_title ) ? $post->post_title : '';
        if ( is_single() ) {
            the_title( '<h1 class="entry-title">', '</h1>' );
        } else {
            the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
        }
        $posttime = timeLink();
            echo '<div class="single-featured-image-header'.($post->post_type ? ' '.$post->post_type : '').'">';

        echo get_the_post_thumbnail($post);
            ?>
            <div class="views-field views-field-field-author">
                <div class="field-content">
                    <span class="date"><?php echo $posttime; ?></span> | <span class="author"><?php echo $author[0]->name;?></span>
                </div>
            </div>
            <?php
            $current_url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
            echo '<div class="image_social">';
//                echo '<a onclick="return loadpopupSocial(this);" rel="external nofollow" class="ss-button-email" href="http://www.sharethis.com/share?url='.urlencode($current_url).'&title='.urlencode($title).'&summary='.urlencode($title).'&img='.$image[0].'&pageInfo=%7B%22hostname%22%3A%22'.$_SERVER['SERVER_NAME'].'%22%2C%22publisher%22%3A%22%22%7D" target="_blank"><span class="at-icon-wrapper" style="background-color: rgb(132, 132, 132); line-height: 32px; height: 32px; width: 32px;"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 32 32" title="Email" alt="Email" class="at-icon at-icon-email" style="width: 32px; height: 32px;"><g><g fill-rule="evenodd"></g><path d="M27 22.757c0 1.24-.988 2.243-2.19 2.243H7.19C5.98 25 5 23.994 5 22.757V13.67c0-.556.39-.773.855-.496l8.78 5.238c.782.467 1.95.467 2.73 0l8.78-5.238c.472-.28.855-.063.855.495v9.087z"></path><path d="M27 9.243C27 8.006 26.02 7 24.81 7H7.19C5.988 7 5 8.004 5 9.243v.465c0 .554.385 1.232.857 1.514l9.61 5.733c.267.16.8.16 1.067 0l9.61-5.733c.473-.283.856-.96.856-1.514v-.465z"></path></g></svg></span></a>';
//                echo '<a onclick="return loadpopupSocial(this,\'linkedin\');" rel="external nofollow" class="ss-button-linkedin" href="http://www.linkedin.com/shareArticle"><span class="at-icon-wrapper" style="background-color: rgb(0, 119, 181); line-height: 32px; height: 32px; width: 32px;"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 32 32" title="LinkedIn" alt="LinkedIn" class="at-icon at-icon-linkedin" style="width: 32px; height: 32px;"><g><path d="M26 25.963h-4.185v-6.55c0-1.56-.027-3.57-2.175-3.57-2.18 0-2.51 1.7-2.51 3.46v6.66h-4.182V12.495h4.012v1.84h.058c.558-1.058 1.924-2.174 3.96-2.174 4.24 0 5.022 2.79 5.022 6.417v7.386zM8.23 10.655a2.426 2.426 0 0 1 0-4.855 2.427 2.427 0 0 1 0 4.855zm-2.098 1.84h4.19v13.468h-4.19V12.495z" fill-rule="evenodd"></path></g></svg></span></a>';
//                echo '<a onclick="return loadpopupSocial(this,\'twitter\');" rel="external nofollow" class="ss-button-twitter" href="http://twitter.com/intent/tweet/" target="_blank"><span class="at-icon-wrapper" style="background-color: rgb(29, 161, 242); line-height: 32px; height: 32px; width: 32px;"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 32 32" title="Twitter" alt="Twitter" class="at-icon at-icon-twitter" style="width: 32px; height: 32px;"><g><path d="M27.996 10.116c-.81.36-1.68.602-2.592.71a4.526 4.526 0 0 0 1.984-2.496 9.037 9.037 0 0 1-2.866 1.095 4.513 4.513 0 0 0-7.69 4.116 12.81 12.81 0 0 1-9.3-4.715 4.49 4.49 0 0 0-.612 2.27 4.51 4.51 0 0 0 2.008 3.755 4.495 4.495 0 0 1-2.044-.564v.057a4.515 4.515 0 0 0 3.62 4.425 4.52 4.52 0 0 1-2.04.077 4.517 4.517 0 0 0 4.217 3.134 9.055 9.055 0 0 1-5.604 1.93A9.18 9.18 0 0 1 6 23.85a12.773 12.773 0 0 0 6.918 2.027c8.3 0 12.84-6.876 12.84-12.84 0-.195-.005-.39-.014-.583a9.172 9.172 0 0 0 2.252-2.336" fill-rule="evenodd"></path></g></svg></span></a>';
//                echo '<a onclick="return loadpopupSocial(this);" rel="external nofollow" class="ss-button-facebook" href="http://www.facebook.com/sharer/sharer.php?u='.urlencode($current_url).'" target="_blank"><span class="at-icon-wrapper" style="background-color: rgb(59, 89, 152); line-height: 32px; height: 32px; width: 32px;"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 32 32" title="Facebook" alt="Facebook" class="at-icon at-icon-facebook" style="width: 32px; height: 32px;"><g><path d="M22 5.16c-.406-.054-1.806-.16-3.43-.16-3.4 0-5.733 1.825-5.733 5.17v2.882H9v3.913h3.837V27h4.604V16.965h3.823l.587-3.913h-4.41v-2.5c0-1.123.347-1.903 2.198-1.903H22V5.16z" fill-rule="evenodd"></path></g></svg></span></a>';
                echo'<div class="addthis_inline_share_toolbox addthis_default_style addthis_32x32_style">' .
                        '<a class="addthis_button_email"></a>' .
                        '<a class="addthis_button_linkedin"></a>' .
                        '<a class="addthis_button_twitter"></a>' .
                        '<a class="addthis_button_facebook"></a>' .
//                        '<a class="addthis_button_email"><img src="/wp-content/themes/thecipherbrief/assets/images/button_email.svg" width="32" height="32" border="0" alt="Email"/></a>' .
//                        '<a class="addthis_button_linkedin"><img src="/wp-content/themes/thecipherbrief/assets/images/button_linkedIn.svg" width="32" height="32" border="0" alt="LinkedIn"/></a>' .
//                        '<a class="addthis_button_twitter"><img src="/wp-content/themes/thecipherbrief/assets/images/button_twitter.svg" width="32" height="32" border="0" alt="Twitter"/></a>' .
//                        '<a class="addthis_button_facebook"><img src="/wp-content/themes/thecipherbrief/assets/images/button_facebook.svg" width="32" height="32" border="0" alt="Facebook"/></a>' .
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

    <div class="entry-content columms">
        <?php
        $img = '';
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
                        echo '<a href="/expert/'.$v->slug.'/">';
                            echo '<img src="'.$temp[0]->guid.'" width="220" height="220" alt="">';
                                echo '<div class="expert-name">';
                                    echo $v -> name;
                                    echo '</br>';
                                    echo $temp[0] -> post_excerpt;
                                echo '</div>';
                        echo '</a>';
                    }
                }
            }
            echo '</div>';
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
        $tags_list = get_the_tag_list( '', $separate_meta );
        if ( $tags_list || get_edit_post_link() ) {
            echo '<footer class="entry-footer">';
            if ( 'column_article' === get_post_type() ) {
                if ( $tags_list ) {
                    if ( $tags_list ) {
                        echo '<span class="tags-links">' . $tags_list . '</span>';
                    }
                }
            }
            thecipherbrief_edit_link();
            echo '</footer>';
        }

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
