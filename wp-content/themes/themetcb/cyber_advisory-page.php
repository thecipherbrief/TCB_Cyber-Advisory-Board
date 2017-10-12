<?php
/*
    Template Name: Cyber Advisory Template
    @mpegi
*/
    get_header();
    the_custom_above_banner();
	$paged = $wp->query_vars['paged'] ? $wp->query_vars['paged'] : 1;
	$paged = IsSet($_GET['page']) ? (int)$_GET['page'] : $paged;
	$OnPage = 9999;
	$leftIndex  = ($paged - 1) * $OnPage;
	$rightIndex = $paged * $OnPage - 1;
	global $wp;
	$current_url = home_url().'/'.$wp->query_vars['pagename'].'/page/'.($paged+1);
    $my_sidebar = getMySideBar('wpcf-show_cyber_advisory','wpcf-sort_cyber_advisory');
?>
<div class="site-content-contain post_content">
    <div class="cyber_advistory" <?=(!$my_sidebar ? 'style="width: 100%;"' : '')?>>
        <div id="content-header" class="content-header">
            <h1><?=$post->post_title?></h1>
            <p><?=$post->post_content?></p>
        </div>
		<hr>
		<div class="boxcontainer">
<?php
$args = array(
    'taxonomy' =>  'experts',
    'hide_empty' =>  false,
    'hierarchical' =>  false,
    'parent' =>  0,
    'orderby' =>  'expert_order',
    'order' => 'ASC',
    'paged' => $paged,
    'posts_per_page' => $OnPage,
    'meta_query' => array(
            'relation' => 'AND',
            'is_on' => array(
                'key' => 'metatax_cyber_advisory',
                'value' => 'on',
                'compare' => '='
            ),
           'expert_order' => array(
                    'key' => 'metatax_cyber_order',
                    'type'    => 'NUMERIC',
                    'compare' => 'EXISTS',
            )
    ),
);
$terms = get_terms( $args );
$total_terms = count($terms);
$pages = ceil($total_terms / $OnPage);
$pos = 0;
	foreach ($terms as $expert){
		if($leftIndex <= $pos && $rightIndex >= $pos){
     ?>
			<div class="row views-row pad">
                <?php
                $excerpt = '';
                $tmp = $wpdb->get_results("SELECT * FROM wp_termmeta WHERE term_id=".(int)$expert->term_id." AND meta_key='_thumbnail_id'");
                if($tmp[0]){
                    $tmp = $wpdb->get_results("SELECT guid,post_excerpt FROM wp_posts WHERE ID=".(int)$tmp[0]->meta_value);
                    $excerpt = $tmp[0] -> post_excerpt;
                    if($tmp[0] && IsSet($tmp[0]->guid) && $tmp[0]->guid) {
                        echo ' <a href="'.$expert->taxonomy.'/'.$expert->slug.'"><div class="row_img'.($pos%2 != 0 ? ' pull-right' : '').' centered-img-background">
				<img src="'.$tmp[0]->guid.'" / class="safariFix"></div><img src="'.$tmp[0]->guid.'" / class="hidden-desktop"></a>';
                    }
                }
                ?>
				<div class="row_con<?=($pos%2 != 0 ? ' left-align' : ' right-align')?>">
                    <div class="<?=($pos%2 != 0 ? 'text-right' : 'text-left')?>">
                        <a href="<?=$expert->taxonomy?>/<?=$expert->slug?>" class="cyber-head"><?=$expert->name?></a>
					<div class="cyber-advisory-label"><?=$excerpt?></div>
                    </div>
					<span class="border_bottom_dobby" <?=($pos%2 != 0 ? 'style="background: linear-gradient(to left, #c94f61 0%, #c6717c 24%, #c4717b 67%, #ffdddd 100%)' : '')?>"></span>
					<div class="views-field-description">
                        <p class="dec_cyber">
                <?php
              echo  $content = strip_tags($expert->description, '<i><p><a><b><strong>');
               // echo $bio = strlen($content)>498 ? get_the_truncated_content(498, $content) : $content;
                ?></p>
                    </div>
				</div>
			</div>
<?php
		}
		++$pos;
	}
?>
		</div>
		<div class="loader"></div>
        <?php
        if($paged < $pages){
        ?>
		<nav class="paginationAjax">
			<a href="<?=$current_url?>" class="next page-numbers">Load more</a>
		</nav>
            <?php } ?>
    </div>
    <?php if($my_sidebar) echo $my_sidebar; ?>
</div>
<?php
    get_footer();
