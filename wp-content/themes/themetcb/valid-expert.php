<?php
/*
 * Template Name: Validate Experts
 */

require_once(ABSPATH . 'wp-config.php');
$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
if ($mysqli->connect_errno) {
    echo "No connection with MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
$mysqli->set_charset("utf8");

if ( !defined('ABSPATH') )
    define('ABSPATH', dirname(__FILE__) . '/');

(isset($_POST['case'])&&($_POST['case'])=='article') ? checkTopArticle($_POST['value'], $mysqli) : $is_article = false;
(isset($_POST['case'])&&($_POST['case'])=='commentary') ? checkTopArticle($_POST['value'], $mysqli) : $is_commentary = false;
(isset($_POST['case'])&&($_POST['case'])=='tacrticle') ? checkTopArticle($_POST['value'], $mysqli) : $is_tarticle = false;
(isset($_POST['case'])&&($_POST['case'])=='article-excerpt') ? checkExpertArticle($_POST['value'], $mysqli) : $is_article_excerpt = false;


function escapeJavaScriptText($string)
{
    return str_replace("\n", '\n', str_replace('"', '\"', addcslashes(str_replace("\r", '', (string)$string), "\0..\37'\\")));
}

function checkExpertArticle($expert_com, $mysqli){
    $expert_com = htmlentities($expert_com,ENT_QUOTES);
    $res = $mysqli->query("SELECT * FROM `wp_posts` WHERE `post_title`  LIKE '" . $expert_com . "%' AND (`wp_posts`.`post_status` = 'publish' OR `wp_posts`.`post_status` = 'future') AND `wp_posts`.`post_type` = 'expert_commentary' ORDER BY `wp_posts`.`post_date` DESC LIMIT 20");
    while ($row = mysqli_fetch_assoc($res) ):
        $str = htmlspecialchars(json_encode($row['post_title']), ENT_QUOTES, 'UTF-8');
        $type = 'IS NOT Expert Commentary';
        if($row['post_type']=='expert_commentary') $type = 'Expert Commentary';
        ?>
        <a href='javascript:set_art(<?=$str?>)'><?=$row['post_title'];?></a> (Post ID: <?=$row['ID'];?> <?=$type?>)</br>
    <?php endwhile;
}

function checkTopArticle($recentbrief, $mysqli){
    $recentbrief = htmlentities($recentbrief,ENT_QUOTES);
    $res = $mysqli->query("SELECT * FROM `wp_posts` WHERE `post_title`  LIKE '" . $recentbrief . "%' AND (`wp_posts`.`post_status` = 'publish' OR `wp_posts`.`post_status` = 'future')  AND `wp_posts`.`post_type` != 'expert_commentary' ORDER BY `wp_posts`.`post_date` DESC LIMIT 20");
    while ($row = mysqli_fetch_assoc($res) ):
        $str = htmlspecialchars(json_encode($row['post_title']), ENT_QUOTES, 'UTF-8');
        $type = '';
        if($row['post_type']=='column_article') $type = 'Column Article';
        if($row['post_type']=='post') $type = 'Post';
        if($row['post_type']=='reporter_articles') $type = 'Reporter Article';
        if($row['post_type']=='cipher_take') $type = 'Cipher Take';
        if($row['post_type']=='dead_drop_article') $type = 'Dead Drop Article';
        ?>
        <a href='javascript:set_art(<?=$str?>)'><?=$row['post_title'];?></a> (Post ID: <?=$row['ID'];?> <?=$type?>)</br>
    <?php endwhile;
}