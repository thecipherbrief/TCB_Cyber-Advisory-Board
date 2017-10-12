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
$description = term_description();
?>
<div class="site-content-contain post_content">
	<div class="post_article content-inner inner column center width100">
	<?php if ( have_posts() ) : ?>
		<div class="view-header no_uppercase">
			<?php
                echo '<h1>'.single_tag_title('',false).'</h1>';
				echo ($description ? '<div class="taxonomy-description">'.$description.'</div>' : '');
			?>
		</div><!-- .page-header -->
	<?php endif; ?>

	<main id="main" class="site-main" role="main">
        <?php
        if ( have_posts() ) : ?>
            <?php
            /* Start the Loop */
            while ( have_posts() ) : the_post();
                get_template_part( 'template-parts/post/content', 'category');
            endwhile;
            if (function_exists('custom_pagination')) {
                custom_pagination($wp_query->max_num_pages,"",$paged);
            } else {
                the_posts_pagination( array(
                    'prev_text' => thecipherbrief_get_svg( array( 'icon' => 'arrow-left' ) ) . '<span class="screen-reader-text">' . __( 'Previous page', 'thecipherbrief' ) . '</span>',
                    'next_text' => '<span class="screen-reader-text">' . __( 'Next page', 'thecipherbrief' ) . '</span>',
                    'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'thecipherbrief' ) . ' </span>',
                ) );
            }

        else :

            get_template_part( 'template-parts/post/content', 'none' );

        endif; ?>
	</main>
    </div>
</div>

<?php get_footer();
