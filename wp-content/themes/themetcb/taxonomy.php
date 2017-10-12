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
?>
    <div class="site-content-contain post_content">
        <div class="post_article content-inner inner column center">
            <?php if ( have_posts() ) : ?>
                <div class="view-header">
                    <?php
                  $archive_desc = get_the_archive_description();
                  if( $archive_desc ){
                    if($wp_query->query['taxonomy']){
                        echo '<h1 class="no_border-bottom">123LATEST '.$wp_query->query['term'].' BRIEFS</h1>';
                    } else {
                        the_archive_title( '123<h1 class="no_border-bottom">', '</h1>' );
                    }
                  }
                  else {
                    if($wp_query->query['taxonomy']){
                        echo '123<h1>LATEST '.$wp_query->query['term'].' BRIEFS</h1>';
                    } else {
                        the_archive_title( '123<h1>', '</h1>' );
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
                        while ( have_posts() ) : the_post();
                            get_template_part( 'template-parts/post/content', 'tag' );
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
        </div><!-- .wrap -->

        <div id="sidebar-second" class="column sidebar second">
            <div id="sidebar-second-inner" class="inner">
                <div class="region region-sidebar-second">
                    <?php
                    $sidebar = false;
                    if(!empty($myEvent)) {
                        ob_start();
                        foreach ($myEvent as $banner) {
                            if (IsSet($banner['title']) && $banner['title']) {
                                echo'<div class="sponsor-ad-box">';
                                echo'<h2>The Georgetown Salon Series is proud to present</h2>';
                                echo'<div class="sponsor-event-cta">';
                                echo'<h3>'.$banner['wpcf-speaker-title'].'<br>'.$banner['wpcf-speaker-name'].'</h3>';
                                echo(IsSet($banner['wpcf-client-logo']) && $banner['wpcf-client-logo'] ? '<img src="'.$banner['wpcf-client-logo'].'" class="clientLogo"/>' : '');
                                echo'<p>'.$banner['title'].'<br><br><b>'.$banner['wpcf-event-date'].'</b><br><br></p>';
                                echo(IsSet($banner['content']) ? '<p>'.$banner['content'].'</p>' : '');
                                echo(IsSet($banner['wpcf-cient-link-url']) ? '<br><a target="_blank" href="'.$banner['wpcf-cient-link-url'].'">For more information click here</a>' : '');
                                echo'<p></p>';
                                echo(IsSet($banner['wpcf-event-image']) && $banner['wpcf-event-image'] ? '<img src="'.$banner['wpcf-event-image'].'" class="eventImage"/>' : '');
                                echo'</div>';
                                echo'</div>';
                                $sidebar = true;
                            }
                        }
                        $my_sidebar = ob_get_clean();
                    }
                    if($sidebar):
                        ?>
                        <div class="sponsor-ad-container">
                            <?php echo $my_sidebar ?>
                            <div class="sponsor-promo-cta">
                                <a href="/become-sponsor">BECOME A SPONSOR</a>
                            </div>
                        </div>
                    <?php endif ?>
                    <?php
                    $sidebar = false;
                    if(!empty($adver)) {
                        ob_start();
                        foreach ($adver as $banner) {
                            if (IsSet($banner['wpcf-sidebar']) && $banner['wpcf-sidebar']) {
                                echo'<div class="views-row">';
                                echo'<div class="views-field">';
                                echo'<div class="field-content">';
                                echo(IsSet($banner['wpcf-url']) ? '<a target="_blank" href="'.$banner['wpcf-url'].'">' : '');
                                echo(IsSet($banner['photo']) ? '<img src="'.$banner['photo'].'"/>' : '');
                                echo(IsSet($banner['wpcf-url']) ? '</a>' : '');
                                echo'</div>';
                                echo'</div>';
                                echo'</div>';
                                $sidebar = true;
                            }
                        }
                        $my_sidebar = ob_get_clean();
                    }
                    if($sidebar):
                    ?>
                    <div id="block-views-advertisement_sidebar-block" class="block block-views advertisement block-even clearfix">
                        <div class="content clearfix">
                            <div class="view view-advertisement-sidebar view-id-advertisement_sidebar">
                                <div class="view-content">
                                    <?php echo $my_sidebar ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif ?>
                    <div id="block-block-11" class="block block-block global-newsletter-sidebar block-odd block-last clearfix">
                        <div class="content clearfix">
                            <div class="promo-header">
                                <h2>The Cipher Daily Brief</h2>
                            </div>
                            <div class="promo-content">
                                <p> Get a daily rundown of the top security stories delivered to your inbox Monday through Friday with exclusive briefs and columns on what matters most to you and your organization.</p>
                            </div>
                            <div class="promo-content">
                                <div class="simple-signup">
                                    <h6>SIGN UP FOR  The Newsletter</h6>
                                    <a class="light-blue-button" href="https://www.thecipherbrief.com/subscribe">Sign up</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php get_footer();
