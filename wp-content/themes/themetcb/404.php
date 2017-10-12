<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

get_header(); ?>

<div class="site-content-contain post_content">
	<div class="post_article content-inner inner column center">

			<section class="error-404 not-found">
				<header class="page-header">
					<h1 class="page-title"><?php _e( 'Oops! That page can&rsquo;t be found.', 'thecipherbrief' ); ?></h1>
				</header><!-- .page-header -->
				<div class="page-content">
					<p><?php _e( 'It looks like nothing was found at this location. Maybe try a search?', 'thecipherbrief' ); ?></p>

					<?php get_search_form(); ?>

				</div><!-- .page-content -->
			</section><!-- .error-404 -->
	</div><!-- #primary -->
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

<?php get_footer();
