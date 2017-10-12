<?php
/**
 * The template for displaying archive pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */
global $wp_query;
$paged = $wp_query -> query['paged'] ? $wp_query -> query['paged'] : 1;
$paged = IsSet($_GET['page']) ? (int)$_GET['page'] : $paged;
$temp = explode('/',urldecode($_SERVER['REQUEST_URI']));
$my_sidebar = '';
if($temp[1] != 'region') {
    $my_sidebar = getMySideBar('wpcf-show_article_page_catalog','wpcf-sort_article_page_catalog',array(),($myEvent ? $myEvent : array()));
}
get_header();

the_custom_above_banner();
?>
    <div class="site-content-contain post_content">
        <div class="post_article content-inner inner column <?php echo ($temp[1] == 'region' ? 'center width100' : 'center')?>">

            <?php if ( have_posts() ) : ?>
                <div class="view-header<?php echo ($temp[1] == 'region' ? ' no_uppercase text_left' : '')?>">
                <?php
                    if($temp[1] == 'region'){
                        echo '<h1>'.$wp_query->queried_object->name.'</h1>';
                    } else {
                        echo '<h1>LATEST '.$wp_query->queried_object->name.' BRIEFS</h1>';
                    }
                    if ( is_author() ) {
                        $description = get_the_author_meta( 'description' );
                    } else {
                        $description = term_description();
                    }
                    echo($description ? '<div class="taxonomy-description">'.$description.'</div>' : '');
                ?>
                </div><!-- .page-header -->
            <?php endif; ?>

            <main id="main" class="site-main" role="main">
                <?php
                if ( have_posts() ) : ?>
                    <?php
                    while ( have_posts() ) :
                        the_post();
                                if ($temp[1] != 'region'):
                                    $post_region = wp_get_post_terms($post->ID, 'region');
                                    $post_categories = wp_get_post_terms($post->ID, 'category');
                                    $posttime = timeLink();
                                    ?>
                                    <div class="views-row">
                                        <div class="brief-info">
                                            <div class="timestamp"><?php echo $posttime ?></div>
                                            <div class="brief-region">
                                                <?php if ($post_region): ?>
                                                    <?php foreach ($post_region as $region): ?>
                                                        <h4>
                                                            <a href="/article/<?php echo $region->slug ?>/"><?php echo $region->name ?></a>
                                                        </h4>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                                <?php if ($post_categories): ?>
                                                    <?php foreach ($post_categories as $categories): ?>
                                                        <h4>
                                                            <a href="/<?php echo $categories->taxonomy ?>/<?php echo $categories->slug ?>/"><?php echo $categories->name ?></a>
                                                        </h4>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </div>
                                        </div>

                                        <a href="<?php echo get_correct_url($post->ID); ?>/">
                                            <div class="brief-contain">
                                                <div class="brief-crop">
                                                    <?php
                                                    $image = '';
                                                    ob_start();
                                                    the_post_thumbnail('thecipherbrief-featured-image');
                                                    $image = ob_get_clean();
                                                    if ($image) {
                                                        echo $image;
                                                    }
                                                    ?>

                                                </div>
                                                <div class="brief-content">
                                                    <div class="timestamp-mobile"><?php echo $posttime ?></div>
                                                    <h2><?php echo $post->post_title ?></h2>
                                                    <?php $author = wp_get_post_terms($post->ID, 'authors'); ?>
                                                    <?php if ($author[0]): ?>
                                                        <h3>by <?php echo $author[0]->name ?></h3>
                                                    <?php endif; ?>
                                                    <p><?php the_truncated_post(200) ?></p>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <?php
                                else:
                                    get_template_part('template-parts/post/content', 'category');
                                endif;
                    endwhile;
	                $category = get_term_by('slug', $temp[2], 'region' );
	                //var_dump($categories);
                    if (function_exists('custom_pagination')) {
                        custom_pagination(round($category->count/10), 4,$paged);
                    } else {
                        the_posts_pagination( array(
                            'prev_text' => thecipherbrief_get_svg( array( 'icon' => 'arrow-left' ) ) . '<span class="screen-reader-text">' . __( 'Previous page', 'thecipherbrief' ) . '</span>',
                            'next_text' => '<span class="screen-reader-text">' . __( 'Next page', 'thecipherbrief' ) . '</span>' . thecipherbrief_get_svg( array( 'icon' => 'arrow-right' ) ),
                            'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'thecipherbrief' ) . ' </span>',
                        ) );
                    }
                else :
                    get_template_part( 'template-parts/post/content', 'none' );
                endif; ?>
            </main>
        </div>
        <?php echo ($my_sidebar ? $my_sidebar : '');?>
    </div>

<?php get_footer();
