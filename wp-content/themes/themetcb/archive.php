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
//echo'<pre>';
//print_r($wp_query);
//echo'</pre>';
$paged = $wp_query -> query['paged'] ? $wp_query -> query['paged'] : 1;
the_custom_above_banner();
?>

<div class="site-content-contain post_content">

    <div class="post_article content-inner inner column center<?php echo ($wp_query->queried_object->taxonomy == 'category' ? ' width100' : '')?>">
        <?php if ( have_posts() ) : ?>
            <div class="view-header<?php echo ($wp_query->queried_object->taxonomy == 'category' ? ' no_uppercase' : '')?>">
                <?php
                    if($wp_query->queried_object->taxonomy == 'category'){
                        echo '<h1>'.$wp_query->queried_object->name.'</h1>';
                    } else {
                        echo '<h1>'.post_type_archive_title( '', false ).'</h1>';
                    }
                    $cat = $wp_query->queried_object->name;
                ?>



                <div class="cab">
                  <h1>CAB Stuff</h1>
                  <?php
              // the query
              $wpb_all_query = new WP_Query(array('post_type'=>'post', 'category_name' => "{$cat}", 'post_status'=>'publish', 'posts_per_page'=>-1)); ?>

              <?php if ( $wpb_all_query->have_posts() ) : ?>

              <ul>

                  <!-- the loop -->
                  <?php while ( $wpb_all_query->have_posts() ) : $wpb_all_query->the_post(); ?>
                      <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
                  <?php endwhile; ?>
                  <!-- end of the loop -->

              </ul>

                  <?php wp_reset_postdata(); ?>

              <?php else : ?>
                  <p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
              <?php endif; ?>

                </div>



                <?php
                    the_archive_description( '<div class="taxonomy-description">', '</div>' );
                ?>
            </div><!-- .page-header -->
        <?php endif; ?>

        <main id="main" class="site-main" role="main">
            <?php
            if ( have_posts() ) : ?>
                <?php
                /* Start the Loop */
                while ( have_posts() ) : the_post();
                    $format = get_post_format();
                    $format = !$format ? $post->post_type : $format;
                    if($wp_query->queried_object->taxonomy == 'category'){
                        $format = $wp_query->queried_object->taxonomy;
                    }


                    get_template_part( 'template-parts/post/content', $format );

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
    <?php
    if($wp_query->queried_object->taxonomy == 'category'){

    } elseif($wp_query->query['post_type'] == 'video-daily-brief') {
        $my_sidebar = getMySideBar('wpcf-show_video_daily','wpcf-sort_video_daily',array(),($myEvent ? $myEvent : array()));
        echo ($my_sidebar ? $my_sidebar : '');
    }
    ?>
</div>

<?php get_footer();
