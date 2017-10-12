<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

get_header();

$search_query = get_search_query();
$pagenum_link = html_entity_decode( get_pagenum_link() );
$url_parts    = explode( '?', $pagenum_link );
$linkOrder = $url_parts[0].($paged ? 'page/'.$paged.'/'.($search_query ? '?s='.$search_query : '?s=') : ($search_query ? '?s='.$search_query : '?s='));
$linkFaset = $url_parts[0].($search_query ? '?s='.$search_query : '?s=');
$my_sidebar = getMySideBar('wpcf-show_search_page','wpcf-sort_search_page',array(),($myEvent ? $myEvent : array()));
$querry = str_replace(' SQL_CALC_FOUND_ROWS DISTINCT','',$wp_query->request);
$querry = substr($querry, 0, strpos($querry, "ORDER BY")).'GROUP BY wp_posts.ID';
$only_experts = (isset($_REQUEST['experts']) and $_REQUEST['experts'] !== NULL) ? true : false;
$results = $wpdb->get_results("SELECT wp_term_relationships.term_taxonomy_id,COUNT(wp_term_relationships.term_taxonomy_id) AS cnt
    FROM (".$querry.") AS t1
    INNER JOIN wp_term_relationships ON t1.ID = wp_term_relationships.object_id AND wp_term_relationships.term_taxonomy_id IN(510,511,512)
    GROUP BY wp_term_relationships.term_taxonomy_id");

$array = array(
    512 => 'International',
    510 => 'Perspectives & Culture',
    511 => 'Tech/Cyber',
);
$el_experts =  wp_count_terms( 'experts',array(
    'description__like'  => $search_query,
    'name__like'  => $search_query,
    'hide_empty'  => true
) ); ?>

<div id="content-top" class="clearfix">
    <div class="region region-content-top">
        <div class="block block-views block-even block-last clearfix">
            <div class="content clearfix">
                <form action="" method="get" id="views-exposed-form-search-page" accept-charset="UTF-8">
                    <div>
                        <div class="views-exposed-form">
                            <div class="views-exposed-widgets clearfix">
                                <div id="edit-search-api-views-fulltext-wrapper" class="views-exposed-widget views-widget-filter-search_api_views_fulltext">
                                    <label for="edit-search-api-views-fulltext">Search</label>
                                    <div class="views-widget">
                                        <div class="form-item form-type-textfield form-item-search-api-views-fulltext">
                                            <input id="edit-search-api-views-fulltext" name="s" value="<?php echo $search_query; ?>" size="30" maxlength="128" class="form-text" type="text">
                                        </div>
                                    </div>
                                </div>
                                <div class="views-exposed-widget views-widget-sort-by">
                                    <div class="form-item form-type-select form-item-sort-by">
                                        <label for="edit-sort-by">Sort by </label>
                                        <div class="bef-select-as-links jquery-once-1-processed">
                                            <div class="form-item">
                                                <div id="edit-sort-by-search-api-relevance" class="form-item form-type-bef-link form-item-edit-sort-by-search-api-relevance">
                                                    <a href="<?php echo $linkOrder ?>">Relevance</a>
                                                </div>
                                                <div id="edit-sort-by-created" class="form-item form-type-bef-link form-item-edit-sort-by-created">
                                                    <a href="<?php echo $linkOrder ?>&sort_by=DESC">Newest</a>
                                                </div>
                                                <div id="edit-sort-by-created-1" class="form-item form-type-bef-link form-item-edit-sort-by-created-1">
                                                    <a href="<?php echo $linkOrder ?>&sort_by=ASC">Oldest</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="views-exposed-widget views-submit-button">
                                    <input id="edit-submit-search" name="" value="Go" class="form-submit" type="submit">
                                </div>
                                <div class="views-exposed-widget views-reset-button">
                                    <input id="edit-reset" name="op" value="Reset" class="form-submit" type="submit">
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>




<div class="site-content-contain post_content">
	<div class="post_article content-inner inner column center">
        <div class="wrap">
            <div id="primary" class="content-area siteSearch">
                <?php if($results):?>
                <div class="faset-sidebar-first">
                    <h2>Section</h2>
                    <ul id="facetapi-link">
                    <?php
                    if($only_experts == false){
                    foreach ($results as $key => $val): ?>
                        <?php
                        $temp = $_GET['f'];
                        if(IsSet($temp[$val->term_taxonomy_id])){
                            unset($temp[$val->term_taxonomy_id]);
                        }
                        $addLink = '';
                        if($temp){
                            foreach ($temp as $k => $v):
                                $addLink.='&f['.$k.']';
                            endforeach;
                        }
                        ?>
                        <li<?php (IsSet($_GET['f'][$val->term_taxonomy_id]) ? ' class="active"' : '') ?>>
                            <a href="<?php echo $linkFaset.(IsSet($_GET['sort_by']) ? '&sort_by='.$_GET['sort_by'] : '').(IsSet($_GET['f'][$val->term_taxonomy_id]) ? '' : '&f['.$val->term_taxonomy_id.']=1').$addLink ?>" rel="nofollow">
                                <?php echo (IsSet($_GET['f'][$val->term_taxonomy_id]) ? '(-) ' : '') ?>
                                <?php

                                echo $array[$val->term_taxonomy_id]?>
                                <?php
                                if($array[$val->term_taxonomy_id] != NULL){
                                    echo (IsSet($_GET['f'][$val->term_taxonomy_id]) ? '' : ' ('.$val->cnt.')');
                                }
                                 ?>
                            </a>

                        </li>
                    <?php endforeach;
                    if(!isset($_REQUEST['f']) and $el_experts > 0){
                        echo "<li><a href='{$linkFaset}&experts=true'>Expert ($el_experts)</a></li>";
                    }
                    } else {
                        echo "<li><a href='{$linkFaset}'>(-) Experts ($el_experts)</a></li>";
                    }
                    ?>
                    </ul>
                </div>
                <?php endif; ?>
                <main id="main" class="site-main<?php echo ($results ? ' centerSearch' : '')?>" role="main">
                <?php
                $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

                if(1 == $paged and !isset($_REQUEST['f'])) {
                    $experts =  get_terms( array(
                        'description__like'  => $search_query,
                        'name__like'  => $search_query,
                        'orderby'     => 'name',
                        'hide_empty'  => true,
                        'number'      => 4,
                        'taxonomy'    => 'experts'
                    ) );
                    if(!empty($experts)){
                        foreach ($experts as $author){
                            //pre($author);
                            echo '<div class="views-row">';
                            echo"<h3 class=\"field-content\"><a href='/experts/{$author->slug}'>{$author->name}</a></h3>";
                            echo "<div class='lock block-system block-even clearfix'><p>" . get_the_truncated_content(200,$author->description) . "</p></div></div>";
                        }
                    }
                }

                if ( have_posts() and $only_experts == false) :
                    while ( have_posts() ) :

                        the_post();
                        $post_id = get_the_ID();
?>
                        <div class="views-row">
                            <h3 class="field-content">
                                <a href="<?=get_correct_url($post->ID)?>"><?php echo $post->post_title ?></a>
                            </h3>
                            <p><?php the_truncated_post(200) ?></p>
                        </div>
<?php
                    endwhile;
                    echo '</main>';
                    if (function_exists(custom_pagination)) {
                        custom_pagination($custom_query->max_num_pages,"",$paged);
                    } else {
                        the_posts_pagination(array(
                            'prev_text' => thecipherbrief_get_svg(array('icon' => 'arrow-left')) . '<span class="screen-reader-text">' . __('Previous page', 'thecipherbrief') . '</span>',
                            'next_text' => '<span class="screen-reader-text">' . __('Next page', 'thecipherbrief') . '</span>' . thecipherbrief_get_svg(array('icon' => 'arrow-right')),
                            'before_page_number' => '<span class="meta-nav screen-reader-text">' . __('Page', 'thecipherbrief') . ' </span>',
                        ));
                    }

                else : ?>
                        <?php
                        if($only_experts == false or $el_experts < 1){
                            _e( '<p>Sorry, but nothing matched your search terms. Please try again with some different keywords.</p>', 'thecipherbrief' );
                        get_search_form();
                        }
                endif;
                ?>
            </div>
        </div>
    </div>
    <?php echo ($my_sidebar ? $my_sidebar : '');?>
</div>

<?php get_footer();
