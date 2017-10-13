<?php
/**
 * The front page template file
 *
 */
    get_header();
    the_custom_above_banner();
?>
<div class="holder-container">
  <div class='col' id="recent-news">
    <h1><a href="/category/latest">Our Latest News</a></h1>
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
        <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'thecipherbrief-featured-image' ); ?></a>
        <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
        <p><?php echo wp_trim_words( get_the_content(), 40, '...' );?> </p>
    <?php endwhile; ?>
    <!-- end of the loop -->
    <?php wp_reset_postdata(); ?>

<?php else : ?>
    <p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
<?php endif; ?>
<a href="/category/latest">VIEW MORE</a>
  </div>
  <div <div class='col' id="cab">
    <h1><a href="/category/cab">CAB Stuff</a></h1>
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
        <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'thecipherbrief-featured-image' ); ?></a>
        <h3><a href="<?php the_permalink(); ?>"> <?php the_title(); ?> </a> </h3>
        <p><?php echo wp_trim_words( get_the_content(), 40, '...' );?> </p>
    <?php endwhile; ?>
    <!-- end of the loop -->


    <?php wp_reset_postdata(); ?>

<?php else : ?>
    <p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
<?php endif; ?>
<a href="/category/cab">VIEW MORE</a>
  </div>
  <div <div class='col' id="threat">
    <h1><a href="/category/threat">Threats!</a></h1>
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
        <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'thecipherbrief-featured-image' ); ?></a>
        <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
        <p><?php echo wp_trim_words( get_the_content(), 40, '...' );?> </p>
    <?php endwhile; ?>
    <!-- end of the loop -->


    <?php wp_reset_postdata(); ?>

<?php else : ?>
    <p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
<?php endif; ?>
<a href="/category/threat">VIEW MORE</a>
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
