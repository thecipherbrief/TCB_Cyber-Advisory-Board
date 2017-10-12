<?php
/**
 * The front page template file
 *
 */
    get_header();
    the_custom_above_banner();
?>
<div style="border: 1px solid #ccc;"></div>
<div id="content-top" id="header_three_block">
    <div class="region region-content-top" style="margin-top: 20px;padding-bottom: 7px;">
        <div class="view view-home view-id-home">
            <div id="block-views-home-block_5">
    <?php
    $expertQuery = new WP_Query(array(
        'cache_results' => false,
        'post_type' => 'expert_commentary',
        "orderby" => "date",
        'posts_per_page' => 1,
        "order" => 'DESC'
    ));
    if(IsSet($expertQuery->posts) && !empty($expertQuery->posts)){
        $expPost = $expertQuery->posts[0];
        $exmeta = get_post_meta($expPost->ID);
        $extemp = array();
        $extemp[] = "'".str_replace("'","''",$exmeta['wpcf-expert-commentary-for'][0])."'";
        foreach ($exmeta['wpcf-article-commentar'] as $value){
            $extemp[] = "'".str_replace("'","''",$value)."'";
        }
        if(!empty($extemp)){
            $expertQuery = new WP_Query(array(
                'cache_results' => false,
                'posts_per_page' => 4,
                'post_title' => $extemp
            ));
            $results = $wpdb->get_results("SELECT ID,post_title,post_name,post_date FROM wp_posts WHERE post_title IN (".implode(',',$extemp).") AND post_type != 'expert_commentary' AND post_status IN('publish','private') GROUP BY post_name ORDER BY FIELD(post_title, ".implode(',',$extemp).")");
            if($results){
                $html = '';
                foreach ($results as $post) {
                    if ($post->post_title == $exmeta['wpcf-expert-commentary-for'][0]) {
                        ?>
                        <div class="view-content">
                            <div class="views-row views-row-1 views-row-odd views-row-first views-row-last">
                                <div class="views-field views-field-field-full-name">
                                    <div class="field-content"></div>
                                </div>
                                <div class="views-field views-field-title">
                                    <span class="field-content">

                                        <a href="<?=get_correct_url($post->ID)?>/">
                                            <div class="main-feature">
                                                <div class="crop-height">
                                                    <?php
                                                    echo get_the_post_thumbnail($post);
                                                    ?>
                                                </div>
                                                 <h4>Analyst Notebook</h4>
                                                <div class="main-feature-text">
                                                    <h2><?php echo $post->post_title; ?></h2>
                                                    <div class="main-feature-date">
                                                        <?php
                                                        $author = wp_get_post_terms($post->ID, 'authors');
                                                        echo getPostAuthor($author);
                                                        ?>
                                                        <span class="hide-break">|</span>
                                                        <span class="break"><?php echo date("F d, Y", strtotime($post->post_date)) ?></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <?php
                        $true = false;
                    } else {
                        $html .= '<div class="analyst__sub_block">';
                        $html .= '<div>';
                        $html .= '<span class="field-content">';
                        $html .= '<a href="' . get_correct_url($post->ID). '/">';
                        $html .= '<div class="feature-article">' . $post->post_title . '</div>';
                        $author = wp_get_post_terms($post->ID, 'experts');
                        $primary = new WPSEO_Primary_Term('experts', $post->ID);
                        foreach ($author as $key=>$id){
                            if($id->term_id==$primary->get_primary_term()) {
                                unset($author[$key]);
                                array_unshift($author, $id);
                            }
                        }
                        if(IsSet($author[0]->name)):
                            $img = '';
                            $temp = $wpdb->get_results("SELECT * FROM wp_termmeta WHERE term_id=".(int)$author[0]->term_id." AND meta_key='_thumbnail_id'");
                            if($temp[0]){
                                $temp = $wpdb->get_results("SELECT guid,post_excerpt FROM wp_posts WHERE ID=".(int)$temp[0]->meta_value);
                                if($temp[0] && IsSet($temp[0]->guid) && $temp[0]->guid) {
                                    $img = '<img src="'.$temp[0]->guid.'" width="95" height="95" alt="'.$author[0]->name.'">';
                                    $html .= '<div class="feature-name">' . $author[0]->name . '</div>';
                                    $html .= '<div class="feature-title">' . $temp[0] -> post_excerpt . '</div>';
                                }
                            }
                        endif;
                        $html .= '</a>';
                        $html .= '</span>';
                        $html .= '</div>';
                        $html .= '</div>';
                    }
                }
                }
            }
        }
        if($html){
?>
            <div class="attachment attachment-after">
                <div class="view view-home view-id-home view-display-id-attachment_2">
                    <div class="view-content">
                                <div id="analyst_block">
                                    <?php echo $html; ?>
                                </div>
                    </div>
                </div>
            </div>
<?php
        }

    $wpQuery = new WP_Query(array(
        'cache_results'  => false,
        'post_type'      => 'top_articles',
        'posts_per_page' => 1,
        'orderby'        => 'date',
        'order'          => 'DESC',
    ));
    $results = array();
    if(IsSet($wpQuery->posts) && IsSet($wpQuery->posts[0]) && !empty($wpQuery->posts[0])){
        $post_meta = get_metadata('post',$wpQuery->posts[0]->ID);
        if(IsSet($post_meta['wpcf-recent-brif']) && !empty($post_meta['wpcf-recent-brif'])){
            $results = $wpdb->get_results("SELECT ID,post_title,post_name,post_date FROM wp_posts WHERE post_title IN ('" .implode("','", str_replace("'","''",$post_meta['wpcf-recent-brif'])) . "') AND post_type != 'expert_commentary' AND post_status IN('publish','private') ORDER BY FIELD(post_title, '" . implode("','", str_replace("'","''",$post_meta['wpcf-recent-brif'])) . "') LIMIT 20");
        }
    }
    ?>
            </div>
<?php
    if(IsSet($results) && !empty($results)):
?>
            <div id="block-views-home-global_news">
                <div class="view-display-id-global_news">
                    <div class="view-header">

                        <a href="/exclusive" style="text-decoration: none"><h2>Cipher Exclusive</h2></a>
                    </div>
                    <div class="view-content">
                        <div class="item-list">
                            <ul>
    <?php
        foreach($results as $post):
    ?>
                                <li class="views-row">
                                    <div class="views-field views-field-field-headshot">
                                        <div class="field-content">
                                            <div class="ec-img">
                                                <?php
                                                $thumb = get_the_post_thumbnail($post->ID);
                                                if($thumb){
                                                    echo $thumb;
                                                }
                                                 else {
                                                    $author = wp_get_post_terms($post->ID, 'experts');
                                                     $primary = new WPSEO_Primary_Term('experts', $post->ID);
                                                     foreach ($author as $key=>$id){
                                                         if($id->term_id==$primary->get_primary_term()) {
                                                             unset($author[$key]);
                                                             array_unshift($author, $id);
                                                         }
                                                     }
                                                    if(IsSet($author[0]->name)):
                                                        $img = '';
                                                        $temp = $wpdb->get_results("SELECT * FROM wp_termmeta WHERE term_id=".(int)$author[0]->term_id." AND meta_key='_thumbnail_id'");
                                                        if($temp[0]){
                                                            $temp = $wpdb->get_results("SELECT guid,post_excerpt FROM wp_posts WHERE ID=".(int)$temp[0]->meta_value);
                                                            if($temp[0] && IsSet($temp[0]->guid) && $temp[0]->guid) {
                                                                echo '<img src="'.$temp[0]->guid.'" alt="'.$author[0]->name.'">';
                                                            }
                                                        }
                                                    endif;
                                                }
                                                ?>
                                            </div>
                                            <div class="global-news">

                                                <h3><a href="<?=get_correct_url($post->ID)?>"><?php echo $post->post_title ?></a></h3>
                                                <?php
                                                $author = wp_get_post_terms($post->ID, 'authors');
                                                echo '<p>'.getPostAuthor($author).'</p>';
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </li>
    <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

<?php
    endif;
    $for_wp = array(
        'cache_results' => false,
        'paged' => 1,
        'posts_per_page' => 7,
        'post_type' => 'column_article',
        'orderby' => 'date',
        'order' => 'DESC'
    );
    $wp_query = new WP_Query($for_wp);
    $columns = array();
    if ( $wp_query->have_posts() ) {
        while (have_posts()) {
            the_post();
            $author = wp_get_post_terms($post->ID, 'experts');
            $column = wp_get_post_terms($post->ID, 'columns');
            $columns[$post->ID] = array();
            if(!empty($column) && IsSet($column[0])){
                $columns[$post->ID]['column'] = $column[0]->name;
                $columns[$post->ID]['column_url'] = '/column/'.$column[0]->slug.'/';
                $columns[$post->ID]['url'] = '/column/'.$column[0]->slug.'/'.$post->post_name.'/';
                $columns[$post->ID]['post_content'] = $post->post_content;
            }
            $primary = new WPSEO_Primary_Term('experts', $post->ID);
            foreach ($author as $key=>$id){
                if($id->term_id==$primary->get_primary_term()) {
                    unset($author[$key]);
                    array_unshift($author, $id);
                }
            }
            $count = 0;
            foreach ($author as $k => $v) {
                $temp = $wpdb->get_results("SELECT * FROM wp_termmeta WHERE term_id=" . (int)$v->term_id . " AND meta_key='_thumbnail_id'");
                    if ($temp[0]) {
                        $count =+1;
                        $temp = $wpdb->get_results("SELECT guid,post_excerpt FROM wp_posts WHERE ID=" . (int)$temp[0]->meta_value);
                        if ($temp[0] && IsSet($temp[0]->guid) && $temp[0]->guid) {
                            $columns[$post->ID]['image'] = '<img src="' . $temp[0]->guid . '" alt="' . $v->name . '"/>';
                            $columns[$post->ID]['expert'] = $v->name;
                            $columns[$post->ID]['work'] = $temp[0]->post_excerpt;
                            $columns[$post->ID]['title'] = $post->post_title;
                        }
                    }
                if($count==1) break;
            }
        }
    }

    $key = key($columns);
    if(IsSet($columns[$key])):
        $is_excerpt = get_post_meta( $key, 'wpcf-columnexcerpt', true );
?>
            <div id="block-views-the_network-column_section">
                <div class="view view-the-network view-id-the_network view-display-id-column_section">
                    <div class="view-header">
                        <h2><a href="<?php echo $columns[$key]['column_url'];?>"><?php echo $columns[$key]['column'];?></a></h2>
                    </div>
                    <div class="view-content">
                        <div class="views-row views-row-1 views-row-odd views-row-first views-row-last">
                            <div class="views-field views-field-title">
                                <span class="field-content">
                                    <a href="<?php echo $columns[$key]['url'];?>">
                                        <div class="fp">
                                            <div class="fp-crop"><?php echo $columns[$key]['image'];?></div>
                                            <div class="fp-expert">
                                                <h2><?php echo $columns[$key]['expert'];?></h2>
                                                <h5><?php echo $columns[$key]['work'];?></h5>
                                            </div>
                                            <div class="fp-content">
                                                <h3><?php echo $columns[$key]['title'];?></h3>
                                                <p></p>
                                                <p><?=( $is_excerpt ? wp_trim_words( $is_excerpt, 30, ' ...' ) : wp_trim_words( $columns[$key]['post_content'], 30, ' ...' ) )?></p>
                                                <p></p>
                                            </div>
                                            <div class="blue-button">Read More</div>
                                        </div>
                                    </a>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
<?php   unset($columns[$key]);
        endif;?>
        </div>
    </div>
</div>


<div class="my_div_content">
    <div id="content-inner" class="inner column center">
        <div id="content-header" class="content-header"></div>
        <div id="content-area" class="content-area">
            <div class="region region-content" >
                <div id="block-views-cipher_take-block" class="block block-views block-even block-first clearfix">
                    <div class="content clearfix">
<?php
    $paged =IsSet($_GET['page']) ? (int)$_GET['page'] : 1;
    $wp_query = new WP_Query(array(
        'cache_results' => false,
        'paged' => $paged,
        'posts_per_page' => 4,
        'tags' => 'CAB',
        'orderby' => 'date',
        'order' => 'ASC'
    ));
    if(IsSet($wp_query->posts)):
        foreach($wp_query->posts as $post) {
          $metapost = get_post_meta($post->ID);
        }
        // $post = $wp_query->posts[0];
        // for($i=1;$i<=$wp_query->max_num_pages;$i++){
        //     echo'<li class="pager-item'.($paged == $i ? ' pager-current' : '').'"><a title="Go to page '.$i.'" href="/?page='.$i.'">'.$i.'</a></li>';
        // }
        // foreach($wp_query->posts as $post) {
            // $authors   = wp_get_post_terms($post->ID, 'authors');
            // $metapost = get_post_meta($post->ID);
            // $tauthor = array();
            // foreach ($authors as $author){
            //     $tauthor[] = $author->name;
            // }
        // $metapost = get_post_meta($post->ID);
?>

                        <div class="view view-cipher-take view-id-cipher_take view-display-id-block view-dom-id-3ee9bc67a2ea87d9045f8fbad9597859">
                            <div class="view-header">
                                <h2>OUR LATEST REPORTING</h2>
                            </div>
                            <div class="view-content">
                                <div id="mCSB_1" class="mCustomScrollBox mCS-inset mCSB_vertical mCSB_inside" style="max-height: 485px;" tabindex="0">
                                    <div id="mCSB_1_container" class="mCSB_container" style="position: relative; left: 0px; padding: 0 25px;" dir="ltr">
                                        <div>
                                            <h3><?php echo($metapost['wpcf-labelforarticletitle'][0] ? 'Headline: ' : '').$post->post_title?></h3>
                                            <p><?php echo $post->post_content ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="item-list">
                                <ul class="pager">
                            <?php
                            // if($wp_query->max_num_pages > 5) { $wp_query->max_num_pages = 5 ; }
                            // if($wp_query->max_num_pages > 1):
                            //     for($i=1;$i<=$wp_query->max_num_pages;$i++){
                            //         echo'<li class="pager-item'.($paged == $i ? ' pager-current' : '').'"><a title="Go to page '.$i.'" href="/?page='.$i.'">'.$i.'</a></li>';
                            //     }
                            // else:
                            //     echo'<li class="pager-item pager-current">1</li>';
                            // endif;
                            ?>
                                </ul>
                            </div> -->
                        </div>
                    </div>
                </div>
<?php endif; ?>
<!-- end of Our Latest Reporting -->


                <div id="block-views-home-reporter_links" class="block block-views block-odd clearfix">
                    <div class="content clearfix">
<?php
/* FLASH TRAFFIC */
    $wp_query = new WP_Query(array(
        'cache_results' => false,
        'paged' => 1,
        'posts_per_page' => 10,
        'post_type' => 'reporter_articles',
        "orderby" => "date",
        "order" => 'DESC'
    ));
if(!empty($wp_query) && !empty($wp_query->posts)):
?>
                        <div class="view view-home view-id-home view-display-id-reporter_links">
                            <div class="view-header">
                                <h2>Flash Traffic</h2>
                                <p>The Best Global Security Reporting and Opinion</p>
                            </div>
                            <div class="view-content">
                                <div id="mCSB_2" class="mCustomScrollBox mCS-inset mCSB_vertical mCSB_inside" tabindex="0">
                                    <div id="mCSB_2_container" class="mCSB_container" style="position: relative; top: 0px; left: 0px; padding: 0 5px;" dir="ltr">
                            <?php
                            foreach($wp_query->posts as $post) {
                                $authors   = wp_get_post_terms($post->ID, 'authors');
                                $metapost = get_post_meta($post->ID);
                                $tauthor = array();
                                foreach ($authors as $author){
                                    $tauthor[] = $author->name;
                                }
                                $author = '';
                                $count = count($tauthor);
                                if($count > 1){
                                    if($count > 2){
                                        $end = end($tauthor);
                                        unset($tauthor[$count-1]);
                                        $author = implode(', ',$tauthor).' and '.$end;
                                    } else {
                                        $author = implode(' and ',$tauthor);
                                    }
                                } else {
                                    $author = $tauthor[0];
                                }
                                unset($tauthor);
                            ?>
                                        <div class="views-row views-row-1 views-row-odd views-row-first">
                                            <div class="views-field views-field-title">
                                            <span class="field-content">
                                                <div class="reporter-link">
                                                    <a href="<?php echo $metapost['wpcf-articlelink'][0] ?>" target="_blank">
                                                        <h3><?php echo $post->post_title ?></h3>
                                                        <h4><?php echo $author;?></h4>
                                                    </a>
                                                </div>
                                            </span>
                                            </div>
                                        </div>
                                        <?php
                           }
                            ?>
                                    </div>
                                    <div id="mCSB_2_scrollbar_vertical" class="mCSB_scrollTools mCSB_2_scrollbar mCS-inset mCSB_scrollTools_vertical" style="display: block;">
                                        <div class="mCSB_draggerContainer">
                                            <div id="mCSB_2_dragger_vertical" class="mCSB_dragger" style="position: absolute; min-height: 30px; display: block; height: 318px; max-height: 485px; top: 0px;" oncontextmenu="return false;">
                                                <div class="mCSB_dragger_bar" style="line-height: 30px;"></div>
                                            </div>
                                            <div class="mCSB_draggerRail"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
<?php
    endif;
?>
                    </div>
                </div>
<?php
$args= array(
    'ignore_sticky_posts' => true,
    'cache_results' => false,
    'post_type' => array('podcasts','video-daily-brief'),
    'posts_per_page' => 10,
    'meta_key' => 'wpcf-promote-to-homepage-slider',
    'meta_value' => '1',
    'meta_compare' => '=',
    'orderby' => 'date',
    'order' => 'DESC'
);
$podQuery = new WP_Query($args);
if ( $podQuery->have_posts() ) {
        ?>
        <div id="block-views-podcast_views-block"
             class="block block-views c-podcasts__block--front block-even clearfix">
            <div class="content clearfix">
              <a style='color: white;' href="https://www.thecipherbrief.com/podcasts"><h2>Podcasts and Videos</h2></a>
                <section class="regular slider">
                    <?php
                    foreach ($podQuery->posts as $post){
                        $title = isset( $post->post_title ) ? $post->post_title : '';
                        ?>
                        <div class="regular_slid">
                            <a href="<?php echo esc_url( get_permalink() ) ?>">
                                <aside>
                        <?php
                            $image = wp_get_attachment_image_src(get_post_thumbnail_id( $post ), 'post_thumbnail');
                            if(IsSet($image) && IsSet($image[0])){
                                echo '<img src="'.$image[0].'" width="200" height="200"/>';
                            }
                        ?>
                                    <i class="fa fa-play"></i>
                                </aside>
                                <div class="slid_desc">
                                    <h3><?php echo $title;?></h3>
                                    <p><?php theTruncatedPost(100,$post->post_content) ?></p>
                                </div>
                            </a>
                        </div>
                        <?php
                    }
                    ?>
                </section>
            </div>
        </div>
        <?php
}

$wp_query = new WP_Query(array(
    'cache_results' => false,
    'posts_per_page' => 2,
    'post_type' => 'post',
    'orderby' => 'date',
    'order' => 'DESC',
    'relation' => 'AND',
    'meta_query' => array(
        'relation' => 'AND',
        array(
            'key' => 'wpcf-promoted-to-front-page',
            'value' => '1',
            'compare' => '='
        ),
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
        )
    ),
    'date_query' => array(
        'before' => 'today',
        'inclusive' => false,
    ),
    'tax_query' => array(
        array(
            'taxonomy' => 'category',
            'field'    => 'slug',
            'terms'    => 'tech',
            'operator' => 'NOT IN'
        )
    )
));
        ?>
        <?php if(IsSet($wp_query->posts) && !empty($wp_query->posts)):?>
                <div id="block-system-main" class="block block-system block-odd clearfix">
                    <div class="content clearfix">
                        <div class="view view-home view-id-home view-display-id-feature_articles">
                            <div class="view-header">
                                <div class="head-titles"><a class='inherit-header' href="https://www.thecipherbrief.com/article">Cipher Brief Features</a></div>
                            </div>
                            <div class="view-content">
                                <table class="views-view-grid cols-2">
                                    <tbody>
                                        <tr class="row-1 row-first row-last">
                                          <?php foreach($wp_query->posts as $post):?>
                                            <td class="col-1 col-first">
                                                <div class="views-field views-field-title">
                                                    <span class="field-content">
                                                        <a href="<?=get_correct_url($post->ID)?>">
                                                            <div class="summary">
                                                                <div class="img-feed">
                                                                    <?php

                                                                    $metapost = get_post_meta($post->ID);
                                                                    if(IsSet($metapost['_thumbnail_id'])) {
                                                                        $image = wp_get_attachment_image_src($metapost['_thumbnail_id'][0], 'post_thumbnail');
                                                                        if (IsSet($image) && IsSet($image[0])) {
                                                                            echo '<img typeof="foaf:Image" src="'.$image[0].'"/>';
                                                                        }
                                                                    }

                                                                    $author = wp_get_post_terms($post->ID, 'authors');
                                                                    ?>
                                                                </div>
                                                                <h3><?php echo $post->post_title?></h3>
                                                                <h4><?php echo date("F d, Y", strtotime($post->post_date)) ?> | <?php echo getPostAuthor($author) ?></h4>
                                                                <p><?php echo wp_trim_words( $post -> post_content, 30, ' ...' ) ?></p>
                                                            </div>
                                                        </a>
                                                    </span>
                                                </div>
                                            </td>
                                        <?php endforeach ?>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="view-footer">
                                <div class="center-button">
                                    <a class="light-button" href="/article/">Get More Briefs</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
<?php endif; ?>
<?php if(!empty($columns)):?>
<?php $boolean = false;?>
<?php $tempColumns = array_chunk($columns, 3); ?>
                <div id="block-views-home-network_insights_selection" class="block block-views block-odd clearfix">
                    <div class="content clearfix">
                        <div class="view view-home view-id-home view-display-id-network_insights_selection">
                            <div class="view-header">
                                <div class="head-titles"><a class='inherit-header' href="https://www.thecipherbrief.com/column">Recent Columns</a></div>
                            </div>
                            <div class="view-content">
                                <table class="views-view-grid cols-3">
                                    <tbody>
                                    <?php $increment = 0; foreach($tempColumns as $k => $v): ?>
                                        <tr class="row-1 row-first">
                                            <?php foreach($v as $k1 => $v1): ?>
                                                <?php $increment++; ?>
                                                <td class="col-1 col-first">
                                                    <div class="views-field views-field-title<?php echo ($boolean ? ' top_line' : '');?>">
                                                    <span class="field-content">
                                                        <a href="<?php echo $v1['url'];?>">
                                                            <div class="network-recent network-recent_numm_<?php echo $increment; ?>">
                                                                <div class="network-headshot">
                                                                    <?php echo $v1['image'];?>
                                                                </div>
                                                                <div class="network-name"><?php echo $v1['expert'];?></div>
                                                                <div class="title"><?php echo $v1['title'];?></div>
                                                            </div>
                                                        </a>
                                                    </span>
                                                </div>
                                            </td>
        <?php endforeach; ?>
                                    </tr>
<?php $boolean = true; ?>
<?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>

                            <div class="view-footer">
                                <div class="center-button"><a class="light-button" href="/column">VIEW OUR COLUMNS</a></div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
                <div id="block-views-home-cyber_reports" class="block block-views block-even clearfix">
                    <div class="content clearfix">
<?php
    $wp_query = new WP_Query(array(
        'cache_results' => false,
        'paged' => 1,
        'posts_per_page' => 2,
        'post_type' => 'post',
        'orderby' => 'date',
        'relation' => 'AND',
        'meta_query' => array(
            'relation' => 'AND',
            array(
                'key' => 'wpcf-promoted-to-front-page',
                'value' => '1',
                'compare' => '='
            ),
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
        )
        ),
        'date_query' => array(
            'before' => 'today',
            'inclusive' => false,
        ),
        'tax_query' => array(
            array(
                'taxonomy' => 'category',
                'field'    => 'slug',
                'terms'    => 'tech'
            )
        ),
        'order' => 'DESC'
    ));
?>
                        <?php if(IsSet($wp_query->posts) && !empty($wp_query->posts)):?>
                            <div id="block-system-main" class="block block-system block-odd clearfix">
                                <div class="content clearfix">
                                    <div class="view view-home view-id-home view-display-id-feature_articles">
                                        <div class="view-header">
                                            <div class="head-titles"><a class='inherit-header' href="https://www.thecipherbrief.com/article/tech">Recent Tech/Cyber Briefs</a></div>
                                        </div>
                                        <div class="view-content">
                                            <table class="views-view-grid cols-2">
                                                <tbody>
                                                <tr class="row-1 row-first row-last">
                                                    <?php $i = 1;?>
                                                    <?php foreach($wp_query->posts as $post):?>
                                                        <?php if($i++>2) break;?>

                                                        <td class="col-1 col-first">
                                                            <div class="views-field views-field-title">
                                                                <span class="field-content">
                                                                    <a href="<?=get_correct_url($post->ID)?>">
                                                                        <div class="summary">
                                                                            <div class="img-feed">
                                                                                <?php
                                                                                $metapost = get_post_meta($post->ID);
                                                                                if(IsSet($metapost['_thumbnail_id'])) {
                                                                                    $image = wp_get_attachment_image_src($metapost['_thumbnail_id'][0], 'post_thumbnail');
                                                                                    if (IsSet($image) && IsSet($image[0])) {
                                                                                        echo '<img typeof="foaf:Image" src="'.$image[0].'"/>';
                                                                                    }
                                                                                }
                                                                                $author = wp_get_post_terms($post->ID, 'authors');
                                                                                ?>
                                                                            </div>
                                                                            <h3><?php echo $post->post_title?></h3>
                                                                            <h4><?php echo date("F d, Y", strtotime($post->post_date)) ?> | <?php echo getPostAuthor($author) ?></h4>
                                                                            <p><?php echo wp_trim_words( $post -> post_content, 30, ' ...' ) ?></p>
                                                                        </div>
                                                                    </a>
                                                                </span>
                                                            </div>
                                                        </td>
                                                    <?php endforeach ?>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div id="block-views-landing_page-region_buckets" class="block block-views block-odd block-last clearfix">
                    <div class="content clearfix">
                        <div class="view view-landing-page view-id-landing_page view-display-id-region_buckets view-dom-id-c37147da37b8eef3100b87f2339c3eb7">
                            <div class="view-content">
                                <table class="views-view-grid cols-3">
                                    <tbody>
                                    <tr class="row-1 row-first">
                                        <td class="col-1 col-first">
                                        <?php
                                            $regQuery = new WP_Query(array(
                                                'cache_results' => false,
                                                'posts_per_page' => 3,
                                                'post_type' => 'post',
                                                "orderby" => 'date ID',
                                                "order" => 'DESC',
                                                'tax_query' => array(
                                                    array(
                                                        'taxonomy' => 'region',
                                                        'field'    => 'id',
                                                        'terms'    => 3168
                                                    )
                                                )
                                            ));
                                        ?>
                                            <h2 class="field-content"><a class-'inherit-header' href="https://www.thecipherbrief.com/article/africa">Africa</a></h2>
                                            <div class="view view-landing-page-blocks">
                                                <div class="view-content">
                                                <?php
                                                if(IsSet($regQuery->posts) && !empty($regQuery->posts)):
                                                    foreach ($regQuery->posts as $post):
                                                        $author = wp_get_post_terms($post->ID, 'authors');
	                                                    ?>
                                                    <div class="views-row">
                                                        <h3 class="field-content">
                                                            <a href="<?=get_correct_url($post->ID)?>">
                                                                <div class="region-bucket">
                                                                    <div class="region-content">
                                                                        <h3><?php echo $post->post_title ?></h3>
                                                                        <?php if($author[0]):?>
                                                                        <h4><?php echo $author[0]->name ?></h4>
                                                                        <?php endif;?>
                                                                    </div>
                                                                </div>
                                                            </a>
                                                        </h3>
                                                    </div>
                                                <?php
                                                    endforeach;
                                                endif;
                                                ?>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="col-2">
                                            <?php
                                            $regQuery = new WP_Query(array(
                                                'cache_results' => false,
                                                'posts_per_page' => 3,
                                                'post_type' => 'post',
                                                "orderby" => 'date ID',
                                                "order" => 'DESC',
                                                'tax_query' => array(
                                                    array(
                                                        'taxonomy' => 'region',
                                                        'field'    => 'id',
                                                        'terms'    => 3170
                                                    )
                                                )
                                            ));
                                            ?>
                                            <h2 class="field-content"><a class-'inherit-header' href="https://www.thecipherbrief.com/article/asia">Asia</a></h2>
                                            <div class="view view-landing-page-blocks">
                                                <div class="view-content">
                                                    <?php
                                                    if(IsSet($regQuery->posts) && !empty($regQuery->posts)):
                                                        foreach ($regQuery->posts as $post):
                                                            $author = wp_get_post_terms($post->ID, 'authors');
	                                                        ?>
                                                            <div class="views-row">
                                                                <h3 class="field-content">
                                                                    <a href="<?=get_correct_url($post->ID)?>">
                                                                        <div class="region-bucket">
                                                                            <div class="region-content">
                                                                                <h3><?php echo $post->post_title ?></h3>
                                                                                <?php if($author[0]):?>
                                                                                    <h4><?php echo $author[0]->name ?></h4>
                                                                                <?php endif;?>
                                                                            </div>
                                                                        </div>
                                                                    </a>
                                                                </h3>
                                                            </div>
                                                            <?php
                                                        endforeach;
                                                    endif;
                                                    ?>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="col-3 col-last">
                                            <?php
                                            $regQuery = new WP_Query(array(
                                                'cache_results' => false,
                                                'posts_per_page' => 3,
                                                'post_type' => 'post',
                                                "orderby" => 'date ID',
                                                "order" => 'DESC',
                                                'tax_query' => array(
                                                    array(
                                                        'taxonomy' => 'region',
                                                        'field'    => 'id',
                                                        'terms'    => 3173
                                                    )
                                                )
                                            ));
                                            ?>
                                            <h2 class="field-content"><a class-'inherit-header' href="https://www.thecipherbrief.com/article/europe">Europe</a></h2>
                                            <div class="view view-landing-page-blocks">
                                                <div class="view-content">
                                                    <?php
                                                    if(IsSet($regQuery->posts) && !empty($regQuery->posts)):
                                                        foreach ($regQuery->posts as $post):
                                                            $author = wp_get_post_terms($post->ID, 'authors');
	                                                       ?>
                                                            <div class="views-row">
                                                                <h3 class="field-content">
                                                                    <a href="<?=get_correct_url($post->ID)?>">
                                                                        <div class="region-bucket">
                                                                            <div class="region-content">
                                                                                <h3><?php echo $post->post_title ?></h3>
                                                                                <?php if($author[0]):?>
                                                                                    <h4><?php echo $author[0]->name ?></h4>
                                                                                <?php endif;?>
                                                                            </div>
                                                                        </div>
                                                                    </a>
                                                                </h3>
                                                            </div>
                                                            <?php
                                                        endforeach;
                                                    endif;
                                                    ?>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="row-2 row-last">
                                        <td class="col-1 col-first">
                                            <?php
                                            $regQuery = new WP_Query(array(
                                                'cache_results' => false,
                                                'posts_per_page' => 3,
                                                'post_type' => 'post',
                                                "orderby" => 'date ID',
                                                "order" => 'DESC',
                                                'tax_query' => array(
                                                    array(
                                                        'taxonomy' => 'region',
                                                        'field'    => 'id',
                                                        'terms'    => 3172
                                                    )
                                                )
                                            ));
                                            ?>
                                            <h2 class="field-content"><a class-'inherit-header' href="https://www.thecipherbrief.com/article/latin-america">Latin America</a></h2>
                                            <div class="view view-landing-page-blocks">
                                                <div class="view-content">
                                                    <?php
                                                    if(IsSet($regQuery->posts) && !empty($regQuery->posts)):
                                                        foreach ($regQuery->posts as $post):
                                                            $author = wp_get_post_terms($post->ID, 'authors');
	                                                        ?>
                                                            <div class="views-row">
                                                                <h3 class="field-content">
                                                                    <a href="<?=get_correct_url($post->ID)?>">
                                                                        <div class="region-bucket">
                                                                            <div class="region-content">
                                                                                <h3><?php echo $post->post_title ?></h3>
                                                                                <?php if($author[0]):?>
                                                                                    <h4><?php echo $author[0]->name ?></h4>
                                                                                <?php endif;?>
                                                                            </div>
                                                                        </div>
                                                                    </a>
                                                                </h3>
                                                            </div>
                                                            <?php
                                                        endforeach;
                                                    endif;
                                                    ?>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="col-2">
                                            <?php
                                            $regQuery = new WP_Query(array(
                                                'cache_results' => false,
                                                'posts_per_page' => 3,
                                                'post_type' => 'post',
                                                "orderby" => 'date ID',
                                                "order" => 'DESC',
                                                'tax_query' => array(
                                                    array(
                                                        'taxonomy' => 'region',
                                                        'field'    => 'id',
                                                        'terms'    => 3169
                                                    )
                                                )
                                            ));
                                            ?>
                                            <h2 class="field-content"><a class-'inherit-header' href="https://www.thecipherbrief.com/article/middle-east">Middle East</a></h2>
                                            <div class="view view-landing-page-blocks">
                                                <div class="view-content">
                                                    <?php
                                                    if(IsSet($regQuery->posts) && !empty($regQuery->posts)):
                                                        foreach ($regQuery->posts as $post):
                                                            $author = wp_get_post_terms($post->ID, 'authors');
                                                          ?>
                                                            <div class="views-row">
                                                                <h3 class="field-content">
                                                                    <a href="<?=get_correct_url($post->ID)?>">
                                                                        <div class="region-bucket">
                                                                            <div class="region-content">
                                                                                <h3><?php echo $post->post_title ?></h3>
                                                                                <?php if($author[0]):?>
                                                                                    <h4><?php echo $author[0]->name ?></h4>
                                                                                <?php endif;?>
                                                                            </div>
                                                                        </div>
                                                                    </a>
                                                                </h3>
                                                            </div>
                                                            <?php
                                                        endforeach;
                                                    endif;
                                                    ?>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="col-3 col-last">
                                            <?php
                                            $regQuery = new WP_Query(array(
                                                'cache_results' => false,
                                                'posts_per_page' => 3,
                                                'post_type' => 'post',
                                                "orderby" => 'date ID',
                                                "order" => 'DESC',
                                                'tax_query' => array(
                                                    array(
                                                        'taxonomy' => 'region',
                                                        'field'    => 'id',
                                                        'terms'    => 3171
                                                    )
                                                )
                                            ));
                                            ?>
                                            <h2 class="field-content"><a class-'inherit-header' href="https://www.thecipherbrief.com/article/north-america">North America</a></h2>
                                            <div class="view view-landing-page-blocks">
                                                <div class="view-content">
                                                    <?php
                                                    if(IsSet($regQuery->posts) && !empty($regQuery->posts)):
                                                        foreach ($regQuery->posts as $post):
                                                            $author = wp_get_post_terms($post->ID, 'authors');
                                                            ?>
                                                            <div class="views-row">
                                                                <h3 class="field-content">
                                                                    <a href="<?=get_correct_url($post->ID)?>">
                                                                        <div class="region-bucket">
                                                                            <div class="region-content">
                                                                                <h3><?php echo $post->post_title ?></h3>
                                                                                <?php if($author[0]):?>
                                                                                    <h4><?php echo $author[0]->name ?></h4>
                                                                                <?php endif;?>
                                                                            </div>
                                                                        </div>
                                                                    </a>
                                                                </h3>
                                                            </div>
                                                            <?php
                                                        endforeach;
                                                    endif;
                                                    ?>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$my_sidebar = getMySideBar('wpcf-show_main_page','wpcf-sort_main_page', array(),($myEvent ? $myEvent : array()));
echo ($my_sidebar ? $my_sidebar : '');
?>
</div>
    <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    <script>(adsbygoogle = window.adsbygoogle || []).push({google_ad_client: "ca-pub-7418758779618043",enable_page_level_ads: true});</script>
    <script>
	if(document.getElementById('content-top').offsetWidth > 1125)
    	jQuery("#block-views-home-global_news").css("height", "calc("+ document.getElementById('content-top').offsetHeight + "px - 30px)");
    else
    	jQuery("#block-views-home-global_news").css("height", "auto");
</script>
<?php
    get_footer();
