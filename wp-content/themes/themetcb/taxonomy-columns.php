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

$my_sidebar = getMySideBar('wpcf-show_column_article','wpcf-sort_column_article',array(),($myEvent ? $myEvent : array()));
get_header();
//pre($wp_query);
the_custom_above_banner();
?>

<div class="site-content-contain post_content">
	<div class="post_article content-inner inner column center">
	<?php if ( have_posts() ) : ?>
        <div class="view-header taxonomy">
            <div class="breadcrumb" style='display: none;'><a href="/column_article/">Columns</a></div>
        <?php
        $archive_desc = get_the_archive_description();
        if( $archive_desc ){
            if($wp_query->query['taxonomy']){
                echo '<h1 class="no_border-bottom">LATEST '.$wp_query->queried_object->name.' COLUMNS</h1>';
            } else {
                the_archive_title( '<h1 class="no_border-bottom">', '</h1>' );
            }
        } else {
            if($wp_query->query['taxonomy']){
                echo '<h1>LATEST '.$wp_query->queried_object->name.' COLUMNS</h1>';
            } else {
                the_archive_title( '<h1>', '</h1>' );
            }
        }
            the_archive_description( '<div class="taxonomy-description">', '</div>' );
        ?>
        </div><!-- .page-header -->
    <?php endif; ?>
	<main id="main" class="site-main" role="main">
		<?php
		if ( have_posts() ) : ?>
			<?php
			while ( have_posts() ) :
                the_post();
	            $format = 'column_article';
				get_template_part( 'template-parts/post/contents', $format );

			endwhile;

            if (function_exists(custom_pagination)) {
                custom_pagination($wp_query->max_num_pages,"",$paged);
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
