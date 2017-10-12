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
get_header();
the_custom_above_banner();
$my_sidebar = getMySideBar('wpcf-show_podcasts','wpcf-sort_podcasts'); ?>
    <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    <script>(adsbygoogle = window.adsbygoogle || []).push({google_ad_client: "ca-pub-7418758779618043",enable_page_level_ads: true});</script>

    <div class="site-content-contain post_content">
        <div class="post_article content-inner inner column center" <?php if(!$my_sidebar){ ?> style="width: 100%!important;" <?php } ?>>
            <?php if ( have_posts() ) : ?>
                <div class="view-header">
                    <?php
                    echo '<h1>Latest '.post_type_archive_title('',false).'</h1>';
                    the_archive_description( '<div class="taxonomy-description">', '</div>' );
                    ?>
                </div>
            <?php endif; ?>
                <main id="main" class="site-main" role="main">
                    <?php
                    if ( have_posts() ) : ?>
                        <?php
                        while ( have_posts() ) : the_post();
                            $format = get_post_format();
                            $format = !$format ? $post->post_type : $format;
                            get_template_part( 'template-parts/post/content', $format );
                        endwhile;
                        if (function_exists('custom_pagination')) {
                            custom_pagination($custom_query->max_num_pages,"",$paged);
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
     <?php if($my_sidebar){ echo $my_sidebar; }?>

    </div>

<?php get_footer();
