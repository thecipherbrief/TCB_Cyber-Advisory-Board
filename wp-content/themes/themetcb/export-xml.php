<?php

(isset($_GET['mode'])) ? $mode = $_GET['mode'] : die("You must take me mode of access!");
 require_once ABSPATH . 'wp-admin/includes/post.php';

global $wpdb;
echo '$urlp = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);<br />$query = parse_url($_SERVER["REQUEST_URI"], PHP_URL_QUERY);<br />';
$success = 0;
$failed = 0;
$rss =  simplexml_load_file('http://thecipherbriefnew.brickdev.com/xml/migrate-content-xml-article.xml');
foreach ($rss as $key => $value) {
 $post = post_exists($value->Title);
 if($post>0){
   $post = get_post($post);
   $url = '';
   $ex = '';
   if (get_post_meta($post, 'wpcf-exclusive', true)) $ex = 'exclusive/';
   $region = wp_get_post_terms($post, 'region');
   $cat_obj = get_the_category();
   $columns = wp_get_post_terms($post, 'columns');
   $place = (isset($region[0]->slug) and !is_null($region[0]->slug)) ? $region[0]->slug : $cat_obj[0]->slug;
   if ($place == NULL and $columns[0] != NULL)
       $url = "/column/{$ex}{$columns[0]->slug}/{$post->post_name}";
   else
       $url = "/article/{$ex}{$place}/{$post->post_name}";

if($mode == "debug"){
  echo "<font color='green'>Found new redirect with: ";

  echo $value->Path . "\t|\t<b>New redirection to: int ID, string URL</b> ";
  var_dump($post->ID);
  var_dump($url);
  echo "</font>";
  echo "<br />";
}
if($mode == "generate_rewrite"){
  echo "<font color='green'>";
  echo 'if($urlp == "'.$value->Path.'/")wp_redirect( "'.$url.'{$query}", 301 );';
  echo "</font>";
  echo "<br />";
}
$success++;
}else{
    if($mode != "generate_rewrite"){
       echo "<font color='red'>Post Not Found(404): " . $value->Title . "\t|\t Path: " . $value->Path . "</font><br />";
    }
    $failed++;
 }
}
$rss =  simplexml_load_file('http://thecipherbriefnew.brickdev.com/xml/migrate-content-xml-column-article.xml');
foreach ($rss as $key => $value) {
 $post = post_exists($value->Title);
 if($post>0){
   $post = get_post($post);
   $url = '';
   $ex = '';
   if (get_post_meta($post, 'wpcf-exclusive', true)) $ex = 'exclusive/';
   $region = wp_get_post_terms($post, 'region');
   $cat_obj = get_the_category();
   $columns = wp_get_post_terms($post, 'columns');
   $place = (isset($region[0]->slug) and !is_null($region[0]->slug)) ? $region[0]->slug : $cat_obj[0]->slug;
   if ($place == NULL and $columns[0] != NULL)
       $url = "/column/{$ex}{$columns[0]->slug}/{$post->post_name}";
   else
       $url = "/article/{$ex}{$place}/{$post->post_name}";

if($mode == "debug"){
  echo "<font color='green'>Found new redirect with: ";

  echo $value->Path . "\t|\t<b>New redirection to: int ID, string URL</b> ";
  var_dump($post->ID);
  var_dump($url);
  echo "</font>";
  echo "<br />";
}
if($mode == "generate_rewrite"){
  echo "<font color='green'>";
  echo 'if($urlp == "'.$value->Path.'/")wp_redirect( "'.$url.'{$query}", 301 );';
  echo "</font>";
  echo "<br />";
}
$success++;
}else{
    if($mode != "generate_rewrite"){
       echo "<font color='red'>Post Not Found(404): " . $value->Title . "\t|\t Path: " . $value->Path . "</font><br />";
    }
    $failed++;
 }
}
?>
<h2>
<font color='green'>Success: <?=$success;?></font><br />
<font color='red'>Failed: <?=$failed;?></font><br />
</h2>
