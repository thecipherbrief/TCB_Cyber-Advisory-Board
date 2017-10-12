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
$my_sidebar = getMySideBar('wpcf-show_podcasts','wpcf-sort_podcasts',array(),($myEvent ? $myEvent : array()));
?>

<div class="site-content-contain post_content">
	<div class="post_article content-inner inner column center">

	<?php if ( have_posts() ) : ?>
        <div class="view-header ">
            <div style='display: none' class="breadcrumb"><a href="/podcasts/">Podcasts</a></div>
			<?php
                echo '<h1 class="not_padding_top">Latest '.$wp_query->queried_object->name.' podcasts</h1>';
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


                if (function_exists(custom_pagination)) {
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
        </main><!-- #main -->

	<?php //get_sidebar(); ?>
	</div>
    <?php echo ($my_sidebar ? $my_sidebar : '');?>
</div>

<?php get_footer();
