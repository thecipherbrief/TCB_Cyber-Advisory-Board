<?php
/**
 * The front page template file
 *
 */
    get_header();
    the_custom_above_banner();
?>
<div class="holder-container">
  <div class="recent-news">
    <h1>Our Latest News</h1>
    <?php
// the query
$wpb_all_query = new WP_Query(array(
  'post_type' =>'post',
  'category_name' => 'latest',
  'post_status' =>'publish',
  'posts_per_page' => 4,
  'orderby' => 'date',
  'order' => 'DESC'
  ));
?>

<?php if ( $wpb_all_query->have_posts() ) : ?>
    <!-- the loop -->
    <?php while ( $wpb_all_query->have_posts() ) : $wpb_all_query->the_post(); ?>
        <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
        <p><?php echo wp_trim_words( get_the_content(), 40, '...' );?> </p>
    <?php endwhile; ?>
    <!-- end of the loop -->
    <?php wp_reset_postdata(); ?>

<?php else : ?>
    <p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
<?php endif; ?>

  </div>
  <div class="cab">
    <h1>CAB Stuff</h1>
    <?php $wpb_all_query = new WP_Query(array(
  'post_type' =>'post',
  'category_name' => 'cab',
  'post_status' =>'publish',
  'posts_per_page' => 4,
  'orderby' => 'date',
  'order' => 'DESC'
  ));
  ?>
<?php if ( $wpb_all_query->have_posts() ) : ?>



    <!-- the loop -->
    <?php while ( $wpb_all_query->have_posts() ) : $wpb_all_query->the_post(); ?>
        <h1><a href="<?php the_permalink(); ?>"> <?php the_title(); ?> </a> </h1>
        <p><?php echo wp_trim_words( get_the_content(), 40, '...' );?> </p>
    <?php endwhile; ?>
    <!-- end of the loop -->


    <?php wp_reset_postdata(); ?>

<?php else : ?>
    <p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
<?php endif; ?>

  </div>
  <div class="threat">
    <h1>Threats!</h1>
    <?php
// the query
$wpb_all_query = new WP_Query(array(
  'post_type'=>'post',
  'category_name' => 'threat',
  'post_status'=>'publish',
  'posts_per_page'=>4));
  ?>

<?php if ( $wpb_all_query->have_posts() ) : ?>



    <!-- the loop -->
    <?php while ( $wpb_all_query->have_posts() ) : $wpb_all_query->the_post(); ?>
        <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
        <p><?php echo wp_trim_words( get_the_content(), 40, '...' );?> </p>
    <?php endwhile; ?>
    <!-- end of the loop -->


    <?php wp_reset_postdata(); ?>

<?php else : ?>
    <p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
<?php endif; ?>

  </div>

</div>
    <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    <script>(adsbygoogle = window.adsbygoogle || []).push({google_ad_client: "ca-pub-7418758779618043",enable_page_level_ads: true});</script>
    <script>
	if(document.getElementById('content-top').offsetWidth > 1125)
    	jQuery("#block-views-home-global_news").css("height", "calc("+ document.getElementById('content-top').offsetHeight + "px - 30px)");
    else
    	jQuery("#block-views-home-global_news").css("height", "auto");
</script>
<?php
    get_footer();
