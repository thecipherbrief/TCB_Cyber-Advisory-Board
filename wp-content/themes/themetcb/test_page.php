<?php

    get_header();
	$paged = $wp->query_vars['paged'] ? $wp->query_vars['paged'] : 1;
	$paged = IsSet($_GET['page']) ? (int)$_GET['page'] : $paged;
	$wpExperts = get_categories('orderby=name&taxonomy=experts');
	$postPerPage = 20;
	$leftIndex  = ($paged - 1) * $postPerPage;
	$rightIndex = $paged * $postPerPage - 1;
	global $wp;
	$current_url = home_url().'/'.$wp->query_vars['pagename'].'/page/'.($paged+1);
?>
<div class="site-content-contain post_content">
    <div class="cyber_advistory">
        <div id="content-header" class="content-header">
            <h1 class="title"><?php echo $post->post_title; ?></h1>
            <div><?php echo $post->post_content ?></div>
        </div>
		<hr>
		<div class="boxcontainer">
<?php
	$i = 0;
	foreach ($wpExperts as $expert){
		if($leftIndex <= $i && $rightIndex >= $i){
?>
			<div class="row views-row">
				<div class="row_img<?php echo ($i%2 == 0 ? ' pull-right' : '')?>">
					<?php
						$postExcerpt = '';
						$temp = $wpdb->get_results("SELECT * FROM wp_termmeta WHERE term_id=".(int)$expert->term_id." AND meta_key='_thumbnail_id'");
						if($temp[0]){
							$temp = $wpdb->get_results("SELECT guid,post_excerpt FROM wp_posts WHERE ID=".(int)$temp[0]->meta_value);
							$postExcerpt = $temp[0] -> post_excerpt;
							if($temp[0] && IsSet($temp[0]->guid) && $temp[0]->guid) {
								echo '<img src="'.$temp[0]->guid.'" alt="'.$expert->name.'"/>';
							}
						}
					?>
				</div>
				<div class="row_con<?php echo ($i%2 == 0 ? ' left-align' : '')?>">
					<h2><?php echo $expert->name ?></h2>
					<label><?php echo $postExcerpt ?></label>
					<span class="border_bottom_dobby"></span>
					<?php
						$content = apply_filters( 'the_content', $expert->description );
						$content = str_replace( ']]>', ']]&gt;', $content );
					?>
					<div><?php echo $content ?></div>
				</div>
			</div>
<?php
		}
		++$i;
	}
?>
		</div>
		<div class="loader"></div>
		<nav class="paginationAjax">
			<a href="<?php echo $current_url ?>" class="next page-numbers">Load more</a>
		</nav>
    </div>
</div>

<?php
    get_footer();