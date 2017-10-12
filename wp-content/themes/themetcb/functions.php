<?php
/**
 * Twenty Seventeen functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 */
add_action( 'template_redirect', function() {
	require "xml_rewrite.php";
} );

function custom_rewrite_rule() {
	add_rewrite_rule('^article/([^/]*)/([^/]*)/([^/]*)?','index.php?name=$matches[3]','top');
	add_rewrite_rule('^article/([^/]*)/([^/]*)?','index.php?name=$matches[2]','top');
	add_rewrite_rule('^article/([^/]*)?','region/$matches[1]','top');
	add_rewrite_rule('^category/([^/]*)/page/([^/]*)?','/category/$matches[1]/page/$matches[2]','top');
	add_rewrite_rule('^category/([^/]*)/([^/,page]*)?','index.php?name=$matches[2]','top');
}
add_action('init', 'custom_rewrite_rule', 10, 0);


function admin_expert_validation( $hook ) {
	if ('post.php' === $hook or 'post-new.php' === $hook)
		wp_enqueue_script( 'expert_validation', get_theme_file_uri( '/assets/js/expert_validation.js' ) );
	return;
}
add_action('admin_enqueue_scripts', 'admin_expert_validation');

function pre($array, $debugIndex = 0) {
	global $wpdb;
	if(!$array) $array = $wpdb->last_query;
	$debug = debug_backtrace();
	$result = '<div id="debug-section" style="display: flex; flex-direction: column; position: fixed; z-index: 999999; top: 0; left: 0; width: 100%;"><div style="text-align: center; background-color: rgba(0, 71, 171, 0.75); padding: 5px; font-size: 16px; color: white;">Debug call at: <font color=silver>'.$debug[$debugIndex]['file'].'</font>: <font color=\'red\'>'.$debug[$debugIndex]['line'].'</font><i class="fa fa-times" id="close-debug" aria-hidden="true" style="float: right;"></i></div>';
	$result .= '<pre style="opacity: 0.95; font-family: Calibri, Candara, Segoe, \'Segoe UI\', Optima, Arial, sans-serif; font-size: 13px; font-style: normal; font-variant: normal; font-weight: 400; line-height: 18.5714px; color: black;">'.print_r($array, 1).'</pre></div>';
	$result .='<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>';
	$result .='<script>
        jQuery(document).ready(function(){
           jQuery("#close-debug").on("click", function(){
               jQuery("#debug-section").hide(500);
           });
        });
                   </script>';
	echo $result;
}

function cf_search_join( $join ) {
	global $wpdb;

	if ( is_search() ) {
		if(!$join){
			$join .=' LEFT JOIN '.$wpdb->postmeta. ' ON '. $wpdb->posts . '.ID = ' . $wpdb->postmeta . '.post_id ';
			if(IsSet($_GET['f'])){
				foreach ($_GET['f'] as $k => $v){
					$join .=' INNER JOIN wp_term_relationships AS t'.$k.' ON '. $wpdb->posts . '.ID = t'.$k.'.object_id AND t'.$k.'.term_taxonomy_id = '.$k;
				}
			}
		}
	}

	return $join;
}
add_filter('posts_join_request', 'cf_search_join' );

/**
 * Modify the search query with posts_where
 *
 * http://codex.wordpress.org/Plugin_API/Filter_Reference/posts_where
 */
function cf_search_where( $where ) {
	global $wpdb;

	if ( is_search() ) {
		$where = preg_replace(
			"/\(\s*".$wpdb->posts.".post_title\s+LIKE\s*(\'[^\']+\')\s*\)/",
			"(".$wpdb->posts.".post_title LIKE $1) OR (".$wpdb->postmeta.".meta_value LIKE $1)", $where );
//        pre($where);
	}

	return $where;
}
add_filter( 'posts_where', 'cf_search_where' );


//add_filter( 'posts_groupby', 'my_posts_groupby' );
//function my_posts_groupby($groupby) {
//    global $wpdb;
//    if ( is_search() ) {
//        $groupby = "{$wpdb->posts}.ID";
//    }
//    return $groupby;
//}

add_filter( 'posts_orderby', 'filter_function_orderby_11', 10, 2 );
function filter_function_orderby_11( $orderby ){
	if(is_search()){
		if(IsSet($_GET['sort_by']) && $_GET['sort_by'] && $_GET['sort_by'] == 'ASC'){
			$orderby = 'wp_posts.post_date ASC';
		}
	}
	return $orderby;
}

/**
 * Prevent duplicates
 *
 * http://codex.wordpress.org/Plugin_API/Filter_Reference/posts_distinct
 */
function cf_search_distinct( $where ) {
	global $wpdb;

	if ( is_search() ) {
		return "DISTINCT";
	}

	return $where;
}
add_filter( 'posts_distinct', 'cf_search_distinct' );

function random_string($str_length, $str_characters)
{
	$str_characters = array (0,1,2,3,4,5,6,7,8,9,'a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z','A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
	if (!is_int($str_length) || $str_length < 0) {
		return false;
	}
	$characters_length = count($str_characters) - 1;
	$string = '';
	for ($i = $str_length; $i > 0; $i--) {
		$string .= $str_characters[mt_rand(0, $characters_length)];
	}

	return $string;
}


/* Update Image Caption*/
function updateImageCaption(){
	global $wpdb;
	$post = array(
		'ID'=> $_POST['post_id'],
		'post_excerpt' => $_POST['caption']
	);
	$result = wp_update_post( $post );
	if($result==0){
		return false;
	} else {
		return true;
	}
}
add_action('wp_ajax_updateImageCaption', 'updateImageCaption');
add_action('wp_ajax_updateImageCaption', 'updateImageCaption');

function updateAboutUsSection(){
	global $wpdb;
	$img_url = $_POST['image'];
	$post_id = $_POST['post_id'];
	$post = array(
		'ID'=> $_POST['post_id'],
		'post_excerpt' => $_POST['caption'],
		'post_content' => $_POST['content']
	);
	$result = wp_update_post( $post );
	if($result==0){
		return false;
	} else {
		$wpdb->query("UPDATE wp_posts SET guid = '".$img_url."' WHERE ID = '".$post_id."';");
		return true;
	}
}
add_action('wp_ajax_updateAboutUsSection', 'updateAboutUsSection');
add_action('wp_ajax_updateAboutUsSection', 'updateAboutUsSection');


if( is_admin() && ! class_exists('Term_Meta_Image') ){
	// init
	//add_action('current_screen', 'Term_Meta_Image_init');
	add_action('admin_init', 'Term_Meta_Image_init');
	function Term_Meta_Image_init(){
		$GLOBALS['Term_Meta_Image'] = new Term_Meta_Image();
	}
	/* Картинки в таксономиях */
	class Term_Meta_Image {

		// для каких таксономий включить код. По умолчанию для всех публичных
		static $taxes = array(); // пример: array('category', 'post_tag');

		// название мета ключа
		static $meta_key = '_thumbnail_id';

		// URL пустой картинки
		static $add_img_url = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGQAAABkAQMAAABKLAcXAAAABlBMVEUAAAC7u7s37rVJAAAAAXRSTlMAQObYZgAAACJJREFUOMtjGAV0BvL/G0YMr/4/CDwY0rzBFJ704o0CWgMAvyaRh+c6m54AAAAASUVORK5CYII=';

		public function __construct(){
			if( isset($GLOBALS['Term_Meta_Image']) ) return $GLOBALS['Term_Meta_Image']; // once

			$taxes = self::$taxes ? self::$taxes : get_taxonomies( array( 'public'=>true ), 'names' );

			foreach( $taxes as $taxname ){
				add_action("{$taxname}_add_form_fields",   array( & $this, 'add_term_image' ),     10, 2 );
				add_action("{$taxname}_edit_form_fields",  array( & $this, 'update_term_image' ),  10, 2 );
				add_action("created_{$taxname}",           array( & $this, 'save_term_image' ),    10, 2 );
				add_action("edited_{$taxname}",            array( & $this, 'updated_term_image' ), 10, 2 );

				add_filter("manage_edit-{$taxname}_columns",  array( & $this, 'add_image_column' ) );
				add_filter("manage_{$taxname}_custom_column", array( & $this, 'fill_image_column' ), 10, 3 );
			}
		}

		## поля при создании термина
		public function add_term_image( $taxonomy ){
			wp_enqueue_media(); // подключим стили медиа, если их нет

			add_action('admin_print_footer_scripts', array( & $this, 'add_script' ), 99 );
			$this->css();
			?>
            <div class="form-field term-group">
                <label><?php _e('Image', 'default'); ?></label>
                <div class="term__image__wrapper">
                    <a class="termeta_img_button" href="#">
                        <img src="<?php echo self::$add_img_url ?>" alt="">
                    </a>
                    <input type="button" class="button button-secondary termeta_img_remove" value="<?php _e( 'Remove', 'default' ); ?>" />
                </div>

                <input type="hidden" id="term_imgid" name="term_imgid" value="">
            </div>
			<?php
		}

		## поля при редактировании термина
		// Fucntion to detect witch post connected to author in about us page / @mpegi
		public function aboutUSImage($slug){
			global $wpdb;
			$posts = $wpdb->get_results( $wpdb->prepare("SELECT * FROM $wpdb->posts WHERE post_name LIKE '$slug'"));
			if (!($posts === false)) {
				foreach ($posts as $p => $r) {
					$post = get_post($r);
				}
				return $post;
			} else {
				return false;
			}
		}

		public function updateAboutUsImageUrl($post_id,$img_url){
			global $wpdb;
			$wpdb->query("UPDATE wp_posts SET guid = '".$img_url."' WHERE ID = '".$post_id."';");
		}
		public function createAboutUsdata($content,$title,$execrpt,$slug,$img_url){
			$post = array(
				'post_content' => $content,
				'post_title' => $title,
				'post_excerpt' => $execrpt,
				'post_status' => 'inherit',
				'comment_status' => 'open',
				'ping_status' => 'closed',
				'post_name' => $slug,
				'guid' => $img_url,
				'post_type' => 'attachment',
				'post_mime_type' => 'image/jpeg',
				'comment_count' => 0,
				'filter' => 'raw'
			);
			wp_insert_post($post);
		}

		public function update_term_image( $term, $taxonomy ){
			wp_enqueue_media(); // подключим стили медиа, если их нет
			add_action('admin_print_footer_scripts', array( & $this, 'add_script' ), 99 );
			$image_id = get_term_meta( $term->term_id, self::$meta_key, true );
			$image_url = $image_id ? wp_get_attachment_image_url( $image_id, 'thumbnail' ) : self::$add_img_url;
			$check = get_term_meta( $term->term_id, 'metatax_about_us', true );
			$conf = $this->aboutUSImage($term->slug);
			$img_url = $image_id ? wp_get_attachment_image_url( $image_id, 'full' ) : self::$add_img_url;
			$image = get_post($image_id);
			$image_caption = $image->post_excerpt;
			$this->css();
			if($check=='on') {
				if ($conf != false) {
					$this->updateAboutUsImageUrl($conf->ID, $img_url);
					$connected = $this->aboutUSImage($term->slug);
					?>
                    <tr class="form-field term-group-wrap">
                        <th scope="row"><?php _e('On Page "About US" content', 'default'); ?></th>
                        <td>
                            <div class="term__image__wrapper">

								<?php echo '<img src="' . $connected->guid . '" alt="" class="termeta_img_button_about">'; ?>
                                <fieldset style="border: 1px solid grey; padding: 10px; margin-left: 20px">
                                    <legend style="padding: 0 10px;">Content and Title for About US page content
                                    </legend>
                                    <textarea id="newaboutdescription"
                                              style="width: 70%; height: 207px; margin: 0 0 0 10px;"><?= $connected->post_content ?></textarea>
                                    <textarea id="newabouttitle"
                                              style="width: 25%; height: 207px; margin: 0 0 0 10px;"><?= $connected->post_excerpt ?></textarea>
                                </fieldset>
                                <input type="button" class="button"
                                       value="<?php _e('Update About Us Information', 'default'); ?>"
                                       style="margin: 20px 0 20px 0; background-color: #0085ba; border-color: #0073aa #006799 #006799; color: white"
                                       id="saveaboutUsSection"/>
                                <div id="resultOfSaveAbout"
                                     style="margin-top: 10px; color: green; display: none; text-align: center;"></div>
                            </div>

                        </td>
                    </tr>
				<?php } else {
					$this->createAboutUsdata($term->description, $term->name, $image_caption, $term->slug, $img_url);
					$this->updateAboutUsImageUrl($conf->ID, $img_url);
					$connected = $this->aboutUSImage($term->slug); ?>
                    <tr class="form-field term-group-wrap">
                        <th scope="row"><?php _e('On Page "About US" content', 'default'); ?></th>
                        <td>
                            <div class="term__image__wrapper">

								<?php echo '<img src="' . $connected->guid . '" alt="" class="termeta_img_button_about">'; ?>
                                <fieldset style="border: 1px solid grey; padding: 10px; margin-left: 20px">
                                    <legend style="padding: 0 10px;">Content and Title for About US page content
                                    </legend>
                                    <textarea id="newaboutdescription"
                                              style="width: 70%; height: 207px; margin: 0 0 0 10px;"><?= $connected->post_content ?></textarea>
                                    <textarea id="newabouttitle"
                                              style="width: 25%; height: 207px; margin: 0 0 0 10px;"><?= $connected->post_excerpt ?></textarea>
                                </fieldset>
                                <input type="button" class="button"
                                       value="<?php _e('Update About Us Information', 'default'); ?>"
                                       style="margin: 20px 0 20px 0; background-color: #0085ba; border-color: #0073aa #006799 #006799; color: white"
                                       id="saveaboutUsSection"/>
                                <div id="resultOfSaveAbout"
                                     style="margin-top: 10px; color: green; display: none; text-align: center;"></div>
                            </div>

                        </td>
                    </tr>
				<?php }
			} ?>
            <tr class="form-field term-group-wrap">
                <th scope="row"><?php _e( 'Image', 'default' ); ?></th>
                <td>
                    <div class="term__image__wrapper">
                        <a class="termeta_img_button" href="#">
							<?php echo '<img src="'. $image_url .'" alt="">'; ?>
                        </a>
                        <input type="button" class="button button-secondary termeta_img_remove" value="<?php _e( 'Remove', 'default' ); ?>" />
                    </div>

                    <input type="hidden" id="term_imgid" name="term_imgid" value="<?php echo $image_id; ?>">
                </td>
            </tr>
            <tr class="form-field term-group-wrap">
                <th scope="row"><?php _e( 'Caption of Image/Job Title', 'default' ); ?></th>
                <td>
                    <div class="term__image_caption">
                        <div>
                            <input type="text-area" id="newcaption" value="<?=$image_caption?>" style="width:87%;"/>
                            <input type="button" class="button" value="<?php _e( 'Save/Update', 'default' ); ?>" style="background-color: #0085ba; border-color: #0073aa #006799 #006799; color: white" id="saveImageCaption"/>
                            <div id="resultOfSave" style="margin-top: 10px; color: green; display: none; text-align: center;"></div>
                        </div>
                    </div>
                </td>
            </tr>
            <script type="text/javascript">
                jQuery( document ).ready(function() {
                    jQuery('#saveImageCaption').on('click',function () {
                        var caption = jQuery('#newcaption').val();
                        jQuery.ajax({
                            type: "POST",
                            url: "<?php echo admin_url('admin-ajax.php'); ?>",
                            data: {
                                action: 'updateImageCaption',
                                "post_id": <?=$image_id?>,
                                "caption": caption
                            },
                            success: function (data) {
                                jQuery('#resultOfSave').show(500).html('SAVED');
                                jQuery('#resultOfSave').hide(2000);
                            }
                        });
                    });
					<?php if($check=='on') { ?>
                    jQuery('#saveaboutUsSection').on('click',function () {
                        var description = jQuery('#newaboutdescription').val();
                        var title = jQuery('#newabouttitle').val();
                        var url = '<?=$img_url?>';

                        jQuery.ajax({
                            type: "POST",
                            url: "<?php echo admin_url('admin-ajax.php'); ?>",
                            data: {
                                action: 'updateAboutUsSection',
                                "post_id": <?=$connected->ID?>,
                                "caption": title,
                                "content": description,
                                "image": url,
                            },
                            success: function (data) {
                                jQuery('#resultOfSaveAbout').show(500).html('SAVED');
                                jQuery('#resultOfSaveAbout').hide(2000);
                                jQuery('.termeta_img_button_about').attr('src','<?=$img_url?>').hide().show();
                            }
                        });
                    });
					<?php } ?>

                });
            </script>
			<?php
		}

		public function css(){
			?><style>
                .termeta_img_button{ display:inline-block; margin-right:1em; }
                .termeta_img_button img{ display:block; float:left; margin:0; padding:0; min-width:100px; max-width:150px; height:auto; background:rgba(0,0,0,.07); }
                .termeta_img_button:hover img{ opacity:.8; }
                .termeta_img_button:after{ content:''; display:table; clear:both; }
                .termeta_img_button_about{ display:block; float:left; margin: 10px 15px 0 0; padding:0; min-width:100px; max-width:180px; height:auto; background:rgba(0,0,0,.07); }
            </style><?php
		}

		## Add script
		public function add_script(){
			// выходим если не на нужной странице таксономии
			//$cs = get_current_screen();
			//if( ! in_array($cs->base, array('edit-tags','term')) || ! in_array($cs->taxonomy, (array) $this->for_taxes) )
			//  return;

			$title = __('Featured Image', 'default');
			$button_txt = __('Set featured image', 'default');
			?>
            <script>
                jQuery(document).ready(function($){
                    var frame,
                        $imgwrap = $('.term__image__wrapper'),
                        $imgid   = $('#term_imgid');

                    // добавление
                    $('.termeta_img_button').click( function(ev){
                        ev.preventDefault();

                        if( frame ){ frame.open(); return; }

                        // задаем media frame
                        frame = wp.media.frames.questImgAdd = wp.media({
                            states: [
                                new wp.media.controller.Library({
                                    title:    '<?php echo $title ?>',
                                    library:   wp.media.query({ type: 'image' }),
                                    multiple: false,
                                    //date:   false
                                })
                            ],
                            button: {
                                text: '<?php echo $button_txt ?>', // Set the text of the button.
                            }
                        });

                        // выбор
                        frame.on('select', function(){
                            var selected = frame.state().get('selection').first().toJSON();
                            if( selected ){
                                $imgid.val( selected.id );
                                $imgwrap.find('img').attr('src', selected.sizes.thumbnail.url );
                            }
                        } );

                        // открываем
                        frame.on('open', function(){
                            if( $imgid.val() ) frame.state().get('selection').add( wp.media.attachment( $imgid.val() ) );
                        });

                        frame.open();
                    });

                    // удаление
                    $('.termeta_img_remove').click(function(){
                        $imgid.val('');
                        $imgwrap.find('img').attr('src','<?php echo self::$add_img_url ?>');
                    });
                });
            </script>

			<?php
		}

		## Добавляет колонку картинки в таблицу терминов
		public function add_image_column( $columns ){
			// подправим ширину колонки через css
			add_action('admin_notices', function(){
				echo '<style>.column-image{ width:50px; text-align:center; }</style>';
			});

			$num = 1; // после какой по счету колонки вставлять

			$new_columns = array( 'image'=>'' ); // колонка без названия...

			return array_slice( $columns, 0, $num ) + $new_columns + array_slice( $columns, $num );
		}

		public function fill_image_column( $string, $column_name, $term_id ){
			// если есть картинка
			if( $image_id = get_term_meta( $term_id, self::$meta_key, 1 ) )
				$string = '<img src="'. wp_get_attachment_image_url( $image_id, 'thumbnail' ) .'" width="50" height="50" alt="" style="border-radius:4px;" />';

			return $string;
		}

		## Save the form field
		public function save_term_image( $term_id, $tt_id ){
			if( ! empty($_POST['term_imgid']) && $image = (int) $_POST['term_imgid'] )
				add_term_meta( $term_id, self::$meta_key, $image, true );

		}

		## Update the form field value
		public function updated_term_image( $term_id, $tt_id ){
			if( empty($_POST['term_imgid']) ) return;

			if( $image = (int) $_POST['term_imgid'] )
				update_term_meta( $term_id, self::$meta_key, $image );
			else
				delete_term_meta( $term_id, self::$meta_key );
		}
	}
}

if ( is_admin() && isset($_GET['activated'] ) && $pagenow == "themes.php" ) { // вешаем запрос создания таблицы на активацию темы
	global $wpdb; // глобальный класс $wpdb необходим при работе с базой данных в WordPress
	$collate = '';

	if($wpdb->has_cap('collation')) {
		if(!empty($wpdb->charset)) $collate = "DEFAULT CHARACTER SET $wpdb->charset";
		if(!empty($wpdb->collate)) $collate .= " COLLATE $wpdb->collate";
	}

	// дальше идет сам SQL запрос
	$wpdb->query("CREATE TABLE IF NOT EXISTS ". $wpdb->prefix . "termmeta (
		`meta_id` bigint(20) NOT NULL AUTO_INCREMENT,
		`term_id` bigint(20) NOT NULL,
		`meta_key` varchar(255) NOT NULL,
		`meta_value` longtext DEFAULT '' NOT NULL,
		PRIMARY KEY id (`meta_id`)) $collate;"
	);
}

/* Термины в таксономиях */
class trueTaxonomyMetaBox {
	/*
	 * Функция-конструктор, в ней мы активируем хуки
	 */
	function __construct( $options ) {
		$this->options = $options;
		$this->prefix = $this->options['id'] .'_'; // префикс настроек
		foreach ( $this->options['taxonomy'] as $taxonomy ) { // для каждой таксономии, которая указана в параметрах
			add_action($taxonomy . '_edit_form_fields', array(&$this, 'fill'), 10, 2 ); // хук добавления полей
		}
		add_action('edit_term', array(&$this, 'save'), 10,1); // хук сохранения значений полей
	}
	/*
	 * Функция, создающая поля, я описал в ней текстовые поля (input type=text и textarea), чекбокс и выпадающий список
	 */
	function fill( $term, $taxonomy ){

		foreach ( $this->options['args'] as $param ) { // для каждого описанного параметра...

			?><tr class="form-field"><?php
			// определяем значение произвольного поля таксономии
			if(!$value = get_metadata('term', $term->term_id, $this->prefix .$param['id'], true)) $value = $param['std'];
			switch ( $param['type'] ) {
				// input[type="text"]
				case 'text':{ ?>
                    <th scope="row"><label for="<?php echo $this->prefix .$param['id'] ?>"><?php echo $param['title'] ?></label></th>
                    <td>
                        <input name="<?php echo $this->prefix .$param['id'] ?>" type="<?php echo $param['type'] ?>" id="<?php echo $this->prefix .$param['id'] ?>" value="<?php echo $value ?>" class="regular-text" />
						<?php if(isset( $param['desc'] ) ) echo '<p class="description">' . $param['desc'] . '</p>'  ?>
                    </td>
					<?php
					break;
				}
				// textarea
				case 'textarea':{ ?>
                    <th scope="row"><label for="<?php echo $this->prefix .$param['id'] ?>"><?php echo $param['title'] ?></label></th>
                    <td>
                        <textarea name="<?php echo $this->prefix .$param['id'] ?>" type="<?php echo $param['type'] ?>" id="<?php echo $this->prefix .$param['id'] ?>" value="<?php echo $value ?>" class="large-text" /><?php echo $value ?></textarea>
						<?php if(isset( $param['desc'] ) ) echo '<p class="description">' . $param['desc'] . '</p>'  ?>
                    </td>
					<?php
					break;
				}
				// input[type="checkbox"]
				case 'checkbox':{ ?>
                    <th scope="row"><label for="<?php echo $this->prefix .$param['id'] ?>"><?php echo $param['title'] ?></label></th>
                    <td>
                        <label for="<?php echo $this->prefix .$param['id'] ?>"><input name="<?php echo $this->prefix .$param['id'] ?>" type="<?php echo $param['type'] ?>" id="<?php echo $this->prefix .$param['id'] ?>"<?php echo ($value=='on') ? ' checked="checked"' : '' ?> />
							<?php if(isset( $param['desc'] ) ) echo $param['desc']  ?></label>
                    </td>
					<?php
					break;
				}
				// select
				case 'select':{ ?>
                    <th scope="row"><label for="<?php echo $this->prefix .$param['id'] ?>"><?php echo $param['title'] ?></label></th>
                    <td>
                        <label for="<?php echo $this->prefix .$param['id'] ?>">
                            <select name="<?php echo $this->prefix .$param['id'] ?>" id="<?php echo $this->prefix .$param['id'] ?>"><option>...</option><?php
								foreach($param['args'] as $val=>$name){
									?><option value="<?php echo $val ?>"<?php echo ( $value == $val ) ? ' selected="selected"' : '' ?>><?php echo $name ?></option><?php
								}
								?></select></label>
						<?php if(isset( $param['desc'] ) ) echo '<p class="description">' . $param['desc'] . '</p>'  ?>
                    </td>
					<?php
					break;
				}
			}
			?></tr><?php

		}

	}
	/*
	 * Функция сохранения значений полей
	 */
	function save( $term_id ){
		foreach ( $this->options['args'] as $param ) {
			if ( isset( $_POST[ $this->prefix . $param['id'] ] ) && trim( $_POST[ $this->prefix . $param['id'] ] ) ) {
				update_metadata('term', $term_id, $this->prefix . $param['id'], trim($_POST[ $this->prefix . $param['id'] ], '') );
			} else {
				delete_metadata('term', $term_id, $this->prefix . $param['id'], '', false);
			}
		}
	}
}


$options = array(
	array(
		'id'	=>	'metatax', // айдишник играет роль префикса названий полей
		'taxonomy'	=>	array('authors'), // укажите таксономии, для которых нужно добавить ниже перечисленные поля
		'args'	=>	array(
			array(
				'id'			=>	'order', // атрибуты name и id без префикса, например с префиксом будет meta1_field_1
				'title'			=>	'Order', // лейбл поля
				'type'			=>	'text', // тип, в данном случае обычное текстовое поле
				'desc'			=>	'Specify sort order', // описание
				'std'			=>	'1' // значение поля по умолчанию
			),
			array(
				'id'			=>	'about_us',
				'title'			=>	'About us',
				'type'			=>	'checkbox', // чекбокс
				'desc'			=>	'Display on page about us',
				'std'			=>	''
			)
		)
	),
	array(
		'id'	=>	'metatax', // айдишник играет роль префикса названий полей
		'taxonomy'	=>	array('experts'), // укажите таксономии, для которых нужно добавить ниже перечисленные поля
		'args'	=>	array(
			array(
				'id'			=>	'order', // атрибуты name и id без префикса, например с префиксом будет meta1_field_1
				'title'			=>	'Order', // лейбл поля
				'type'			=>	'text', // тип, в данном случае обычное текстовое поле
				'desc'			=>	'Specify sort order', // описание
				'std'			=>	'1' // значение поля по умолчанию
			),
			array(
				'id'			=>	'our_network',
				'title'			=>	'Our network',
				'type'			=>	'checkbox', // чекбокс
				'desc'			=>	'Display on page our network',
				'std'			=>	''
			),
			array(
				'id'			=>	'network_spotlight',
				'title'			=>	'Our Netwok Spotlight',
				'type'			=>	'checkbox', // чекбокс
				'desc'			=>	'Display on homepage our Network Spotlight',
				'std'			=>	''
			),
            array(
                'id'			=>	'cyber_advisory',
                'title'			=>	'Cyber Advisory',
                'type'			=>	'checkbox', // чекбокс
                'desc'			=>	'Display on Cyber Advisory Page ?',
                'std'			=>	''
            ),
            array(
                'id'			=>	'cyber_order', // атрибуты name и id без префикса, например с префиксом будет meta1_field_1
                'title'			=>	'Cyber Advisory Order', // лейбл поля
                'type'			=>	'text', // тип, в данном случае обычное текстовое поле
                'desc'			=>	'Specify sort order of current expert for Cyber Advisory Page', // описание
                'std'			=>	'1' // значение поля по умолчанию
            )
		)
	)
);

foreach ($options as $option) {
	$truetaxmetabox = new trueTaxonomyMetaBox($option);
}

/**
 * Twenty Seventeen only works in WordPress 4.7 or later.
 */
if ( version_compare( $GLOBALS['wp_version'], '4.7-alpha', '<' ) ) {
	require get_template_directory() . '/inc/back-compat.php';
	return;
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function thecipherbrief_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed at WordPress.org. See: https://translate.wordpress.org/projects/wp-themes/thecipherbrief
	 * If you're building a theme based on Twenty Seventeen, use a find and replace
	 * to change 'thecipherbrief' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'thecipherbrief' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	add_image_size( 'thecipherbrief-featured-image', 2000, 1200, true );

	add_image_size( 'thecipherbrief-thumbnail-avatar', 100, 100, true );

	add_image_size( 'feature-thumb', 50, 33, true );
	// Set the default content width.
	$GLOBALS['content_width'] = 525;

	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus( array(
		'top'    => __( 'Top Menu', 'thecipherbrief' ),
		'social' => __( 'Social Links Menu', 'thecipherbrief' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 *
	 * See: https://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside',
		'image',
		'video',
		'quote',
		'link',
		'gallery',
		'audio',
	) );

	// Add theme support for Custom Logo.
	add_theme_support( 'custom-logo', array(
		'width'       => 250,
		'height'      => 250,
		'flex-width'  => true,
	) );

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/*
	 * This theme styles the visual editor to resemble the theme style,
	 * specifically font, colors, and column width.
	  */
	add_editor_style( array( 'assets/css/editor-style.css', thecipherbrief_fonts_url() ) );

	// Define and register starter content to showcase the theme on new sites.
	$starter_content = array(
		'widgets' => array(
			// Place three core-defined widgets in the sidebar area.
			'sidebar-1' => array(
				'text_business_info',
				'search',
				'text_about',
			),

			// Add the core-defined business info widget to the footer 1 area.
			'sidebar-2' => array(
				'text_business_info',
			),

			// Put two core-defined widgets in the footer 2 area.
			'sidebar-3' => array(
				'text_about',
				'search',
			),
		),

		// Specify the core-defined pages to create and add custom thumbnails to some of them.
		'posts' => array(
			'home',
			'about' => array(
				'thumbnail' => '{{image-sandwich}}',
			),
			'contact' => array(
				'thumbnail' => '{{image-espresso}}',
			),
			'blog' => array(
				'thumbnail' => '{{image-coffee}}',
			),
			'homepage-section' => array(
				'thumbnail' => '{{image-espresso}}',
			),
		),

		// Create the custom image attachments used as post thumbnails for pages.
		'attachments' => array(
			'image-espresso' => array(
				'post_title' => _x( 'Espresso', 'Theme starter content', 'thecipherbrief' ),
				'file' => 'assets/images/espresso.jpg', // URL relative to the template directory.
			),
			'image-sandwich' => array(
				'post_title' => _x( 'Sandwich', 'Theme starter content', 'thecipherbrief' ),
				'file' => 'assets/images/sandwich.jpg',
			),
			'image-coffee' => array(
				'post_title' => _x( 'Coffee', 'Theme starter content', 'thecipherbrief' ),
				'file' => 'assets/images/coffee.jpg',
			),
		),

		// Default to a static front page and assign the front and posts pages.
		'options' => array(
			'show_on_front' => 'page',
			'page_on_front' => '{{home}}',
			'page_for_posts' => '{{blog}}',
		),

		// Set the front page section theme mods to the IDs of the core-registered pages.
		'theme_mods' => array(
			'panel_1' => '{{homepage-section}}',
			'panel_2' => '{{about}}',
			'panel_3' => '{{blog}}',
			'panel_4' => '{{contact}}',
		),

		// Set up nav menus for each of the two areas registered in the theme.
		'nav_menus' => array(
			// Assign a menu to the "top" location.
			'top' => array(
				'name' => __( 'Top Menu', 'thecipherbrief' ),
				'items' => array(
					'link_home', // Note that the core "home" page is actually a link in case a static front page is not used.
					'page_about',
					'page_blog',
					'page_contact',
				),
			),

			// Assign a menu to the "social" location.
			'social' => array(
				'name' => __( 'Social Links Menu', 'thecipherbrief' ),
				'items' => array(
					'link_yelp',
					'link_facebook',
					'link_twitter',
					'link_instagram',
					'link_email',
				),
			),
		),
	);

	/**
	 * Filters Twenty Seventeen array of starter content.
	 *
	 * @since Twenty Seventeen 1.1
	 *
	 * @param array $starter_content Array of starter content.
	 */
	$starter_content = apply_filters( 'thecipherbrief_starter_content', $starter_content );

	add_theme_support( 'starter-content', $starter_content );
}
add_action( 'after_setup_theme', 'thecipherbrief_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function thecipherbrief_content_width() {

	$content_width = $GLOBALS['content_width'];

	// Get layout.
	$page_layout = get_theme_mod( 'page_layout' );

	// Check if layout is one column.
	if ( 'one-column' === $page_layout ) {
		if ( thecipherbrief_is_frontpage() ) {
			$content_width = 644;
		} elseif ( is_page() ) {
			$content_width = 740;
		}
	}

	// Check if is single post and there is no sidebar.
	if ( is_single() && ! is_active_sidebar( 'sidebar-1' ) ) {
		$content_width = 740;
	}

	/**
	 * Filter Twenty Seventeen content width of the theme.
	 *
	 * @since Twenty Seventeen 1.0
	 *
	 * @param $content_width integer
	 */
	$GLOBALS['content_width'] = apply_filters( 'thecipherbrief_content_width', $content_width );
}
add_action( 'template_redirect', 'thecipherbrief_content_width', 0 );

/**
 * Register custom fonts.
 */
function thecipherbrief_fonts_url() {
	$fonts_url = '';

	/**
	 * Translators: If there are characters in your language that are not
	 * supported by Libre Franklin, translate this to 'off'. Do not translate
	 * into your own language.
	 */
	$libre_franklin = _x( 'on', 'Libre Franklin font: on or off', 'thecipherbrief' );

	if ( 'off' !== $libre_franklin ) {
		$font_families = array();

		$font_families[] = 'Libre Franklin:300,300i,400,400i,600,600i,800,800i';

		$query_args = array(
			'family' => urlencode( implode( '|', $font_families ) ),
			'subset' => urlencode( 'latin,latin-ext' ),
		);

		$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
	}

	return esc_url_raw( $fonts_url );
}

/**
 * Add preconnect for Google Fonts.
 *
 * @since Twenty Seventeen 1.0
 *
 * @param array  $urls           URLs to print for resource hints.
 * @param string $relation_type  The relation type the URLs are printed.
 * @return array $urls           URLs to print for resource hints.
 */
function thecipherbrief_resource_hints( $urls, $relation_type ) {
	if ( wp_style_is( 'thecipherbrief-fonts', 'queue' ) && 'preconnect' === $relation_type ) {
		$urls[] = array(
			'href' => 'https://fonts.gstatic.com',
			'crossorigin',
		);
	}

	return $urls;
}
add_filter( 'wp_resource_hints', 'thecipherbrief_resource_hints', 10, 2 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function thecipherbrief_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'thecipherbrief' ),
		'id'            => 'sidebar-1',
		'description'   => __( 'Add widgets here to appear in your sidebar.', 'thecipherbrief' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer 1', 'thecipherbrief' ),
		'id'            => 'sidebar-2',
		'description'   => __( 'Add widgets here to appear in your footer.', 'thecipherbrief' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer 2', 'thecipherbrief' ),
		'id'            => 'sidebar-3',
		'description'   => __( 'Add widgets here to appear in your footer.', 'thecipherbrief' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'thecipherbrief_widgets_init' );

/**
 * Replaces "[...]" (appended to automatically generated excerpts) with ... and
 * a 'Continue reading' link.
 *
 * @since Twenty Seventeen 1.0
 *
 * @return string 'Continue reading' link prepended with an ellipsis.
 */
function thecipherbrief_excerpt_more( $link ) {
	if ( is_admin() ) {
		return $link;
	}

	$link = sprintf( '<p class="link-more"><a href="%1$s" class="more-link">%2$s</a></p>',
		esc_url( get_permalink( get_the_ID() ) ),
		/* translators: %s: Name of current post */
		sprintf( __( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'thecipherbrief' ), get_the_title( get_the_ID() ) )
	);
	return ' &hellip; ' . $link;
}
add_filter( 'excerpt_more', 'thecipherbrief_excerpt_more' );

/**
 * Handles JavaScript detection.
 *
 * Adds a `js` class to the root `<html>` element when JavaScript is detected.
 *
 * @since Twenty Seventeen 1.0
 */
function thecipherbrief_javascript_detection() {
	echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";
}
add_action( 'wp_head', 'thecipherbrief_javascript_detection', 0 );

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function thecipherbrief_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">' . "\n", get_bloginfo( 'pingback_url' ) );
	}
}
add_action( 'wp_head', 'thecipherbrief_pingback_header' );

/**
 * Display custom color CSS.
 */
function thecipherbrief_colors_css_wrap() {
	if ( 'custom' !== get_theme_mod( 'colorscheme' ) && ! is_customize_preview() ) {
		return;
	}

	require_once( get_parent_theme_file_path( '/inc/color-patterns.php' ) );
	$hue = absint( get_theme_mod( 'colorscheme_hue', 250 ) );
	?>
    <style type="text/css" id="custom-theme-colors" <?php if ( is_customize_preview() ) { echo 'data-hue="' . $hue . '"'; } ?>>
        <?php echo thecipherbrief_custom_colors_css(); ?>
    </style>
<?php }
add_action( 'wp_head', 'thecipherbrief_colors_css_wrap' );

/**
 * Enqueue scripts and styles.
 */
function thecipherbrief_scripts() {
	// Add custom fonts, used in the main stylesheet.
	wp_enqueue_style( 'thecipherbrief-fonts', thecipherbrief_fonts_url(), array(), null );

	// Theme stylesheet.
	wp_enqueue_style( 'thecipherbrief-style', get_stylesheet_uri() );

	// Load the dark colorscheme.
	if ( 'dark' === get_theme_mod( 'colorscheme', 'light' ) || is_customize_preview() ) {
		wp_enqueue_style( 'thecipherbrief-colors-dark', get_theme_file_uri( '/assets/css/colors-dark.css' ), array( 'thecipherbrief-style' ), '1.0' );
	}

//    wp_enqueue_style( 'thecipherbrief-plugin', get_theme_file_uri( '/assets/css/jquery.mCustomScrollbar.css' ), array( 'thecipherbrief-style' ), '1.0' );

	// Load the Internet Explorer 9 specific stylesheet, to fix display issues in the Customizer.
	if ( is_customize_preview() ) {
		wp_enqueue_style( 'thecipherbrief-ie9', get_theme_file_uri( '/assets/css/ie9.css' ), array( 'thecipherbrief-style' ), '1.0' );
		wp_style_add_data( 'thecipherbrief-ie9', 'conditional', 'IE 9' );
	}

	// Load the Internet Explorer 8 specific stylesheet.
	wp_enqueue_style( 'thecipherbrief-ie8', get_theme_file_uri( '/assets/css/ie8.css' ), array( 'thecipherbrief-style' ), '1.0' );
	wp_style_add_data( 'thecipherbrief-ie8', 'conditional', 'lt IE 9' );

	// Load the html5 shiv.
	wp_enqueue_script( 'html5', get_theme_file_uri( '/assets/js/html5.js' ), array(), '3.7.3' );
	wp_script_add_data( 'html5', 'conditional', 'lt IE 9' );

	wp_enqueue_script( 'thecipherbrief-skip-link-focus-fix', get_theme_file_uri( '/assets/js/skip-link-focus-fix.js' ), array(), '1.0', true );

	$thecipherbrief_l10n = array(
		'quote'          => thecipherbrief_get_svg( array( 'icon' => 'quote-right' ) ),
	);

	wp_enqueue_script( 'magnific-popap', get_theme_file_uri( '/assets/js/jquery.magnific-popup.min.js' ), array( 'jquery' ), '1.0', true );
	wp_enqueue_script( 'slick-js', get_theme_file_uri( '/assets/js/slick.min.js' ), array( 'jquery' ), '1.0', true );

	wp_enqueue_script( 'jquery-scrollto', get_theme_file_uri( '/assets/js/jquery.scrollTo.js' ), array( 'jquery' ), '2.1.2', true );

	wp_enqueue_script( 'mCustomScrollbar', get_theme_file_uri( '/assets/js/jquery.mCustomScrollbar.js' ), array( 'jquery' ), '1.0.0', true );
	wp_enqueue_script( 'thecipherbrief-global', get_theme_file_uri( '/assets/js/global.js' ), array( 'jquery' ), '1.0', true );
	wp_localize_script( 'thecipherbrief-skip-link-focus-fix', 'thecipherbriefScreenReaderText', $thecipherbrief_l10n );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
	wp_register_style( 'awesome-icons', get_template_directory_uri() . '/assets/css/font-awesome.css', array(), '', 'all' );
	wp_enqueue_style( 'awesome-icons' );
}
add_action( 'wp_enqueue_scripts', 'thecipherbrief_scripts' );

/**
 * Add custom image sizes attribute to enhance responsive image functionality
 * for content images.
 *
 * @since Twenty Seventeen 1.0
 *
 * @param string $sizes A source size value for use in a 'sizes' attribute.
 * @param array  $size  Image size. Accepts an array of width and height
 *                      values in pixels (in that order).
 * @return string A source size value for use in a content image 'sizes' attribute.
 */
function thecipherbrief_content_image_sizes_attr( $sizes, $size ) {
	$width = $size[0];

	if ( 740 <= $width ) {
		$sizes = '(max-width: 706px) 89vw, (max-width: 767px) 82vw, 740px';
	}

	if ( is_active_sidebar( 'sidebar-1' ) || is_archive() || is_search() || is_home() || is_page() ) {
		if ( ! ( is_page() && 'one-column' === get_theme_mod( 'page_options' ) ) && 767 <= $width ) {
			$sizes = '(max-width: 767px) 89vw, (max-width: 1000px) 54vw, (max-width: 1071px) 543px, 580px';
		}
	}

	return $sizes;
}
add_filter( 'wp_calculate_image_sizes', 'thecipherbrief_content_image_sizes_attr', 10, 2 );

/**
 * Filter the `sizes` value in the header image markup.
 *
 * @since Twenty Seventeen 1.0
 *
 * @param string $html   The HTML image tag markup being filtered.
 * @param object $header The custom header object returned by 'get_custom_header()'.
 * @param array  $attr   Array of the attributes for the image tag.
 * @return string The filtered header image HTML.
 */
function thecipherbrief_header_image_tag( $html, $header, $attr ) {
	if ( isset( $attr['sizes'] ) ) {
		$html = str_replace( $attr['sizes'], '100vw', $html );
	}
	return $html;
}
add_filter( 'get_header_image_tag', 'thecipherbrief_header_image_tag', 10, 3 );

/**
 * Add custom image sizes attribute to enhance responsive image functionality
 * for post thumbnails.
 *
 * @since Twenty Seventeen 1.0
 *
 * @param array $attr       Attributes for the image markup.
 * @param int   $attachment Image attachment ID.
 * @param array $size       Registered image size or flat array of height and width dimensions.
 * @return string A source size value for use in a post thumbnail 'sizes' attribute.
 */
function thecipherbrief_post_thumbnail_sizes_attr( $attr, $attachment, $size ) {
	if ( is_archive() || is_search() || is_home() ) {
		$attr['sizes'] = '(max-width: 767px) 89vw, (max-width: 1000px) 54vw, (max-width: 1071px) 543px, 580px';
	} else {
		$attr['sizes'] = '100vw';
	}

	return $attr;
}
add_filter( 'wp_get_attachment_image_attributes', 'thecipherbrief_post_thumbnail_sizes_attr', 10, 3 );

/**
 * Use front-page.php when Front page displays is set to a static page.
 *
 * @since Twenty Seventeen 1.0
 *
 * @param string $template front-page.php.
 *
 * @return string The template to be used: blank if is_home() is true (defaults to index.php), else $template.
 */
function thecipherbrief_front_page_template( $template ) {
	return is_home() ? '' : $template;
}
add_filter( 'frontpage_template',  'thecipherbrief_front_page_template' );

/**
 * Implement the Custom Header feature.
 */
require get_parent_theme_file_path( '/inc/custom-header.php' );

/**
 * Custom template tags for this theme.
 */
require get_parent_theme_file_path( '/inc/template-tags.php' );

/**
 * Additional features to allow styling of the templates.
 */
require get_parent_theme_file_path( '/inc/template-functions.php' );

/**
 * Customizer additions.
 */
require get_parent_theme_file_path( '/inc/customizer.php' );

/**
 * SVG icons functions and filters.
 */
require get_parent_theme_file_path( '/inc/icon-functions.php' );

function register_my_menus() {
	register_nav_menus(
		array(
			'footer-menu' => __( 'Footer Menu' ),
		)
	);
}
add_action( 'init', 'register_my_menus' );

if(IsSet($_REQUEST['action']) ) {
	do_action( 'wp_ajax_nopriv_'.$_REQUEST['action'],'wp_ajax_'.$_REQUEST['action']);
	add_action('wp_ajax_'.$_REQUEST['action'], $_REQUEST['action'].'_callback');
	add_action('wp_ajax_nopriv_'.$_REQUEST['action'], $_REQUEST['action'].'_callback');
}

function getPostData($data){
	global $wpdb;
	if(!empty($data)){

		$results = $wpdb->get_results("SELECT
                                          ID,
                                          post_date,
                                          post_date_gmt,
                                          post_content,
                                          post_title,
                                          post_name,
                                          post_type,
                                          guid
                                       FROM wp_posts WHERE ID IN (".implode(',',array_keys($data)).")");
		foreach ($results as $k => $v){
			if(IsSet($data[$v -> ID])){
				$data[$v -> ID] = array(
					'post_date'     => $v -> post_date,
					'post_date_gmt' => $v -> post_date_gmt,
					'post_content'  => $v -> post_content,
					'post_title'    => $v -> post_title,
					'post_name'     => $v -> post_name,
					'post_type'     => $v -> post_type,
					'guid'          => $v -> guid,
				);
			}
		}

		$results = $wpdb->get_results("SELECT
                                          ID,
                                          post_parent,
                                          post_type,
                                          guid
                                       FROM wp_posts WHERE post_parent IN (".implode(',',array_keys($data)).")");
		foreach ($results as $k => $v){
			if(IsSet($data[$v -> post_parent])){
				$data[$v -> post_parent][$v -> post_type] = $v -> guid;
			}
		}

		$results = $wpdb->get_results("SELECT
                                          t1.term_id,
                                          t3.taxonomy,
                                          t1.name,
                                          t2.object_id,
                                          t1.slug
                                       FROM wp_terms AS t1,wp_term_relationships AS t2,wp_term_taxonomy AS t3
                                       WHERE
                                          t2.object_id IN (".implode(',',array_keys($data)).") AND
                                          t2.term_taxonomy_id = t1.term_id AND
                                          t2.term_taxonomy_id = t3.term_id AND
                                          t3.taxonomy = 'authors'
                                       GROUP BY t2.object_id
                                      ");
		foreach($results as $k => $v){
			if(IsSet($data[$v -> object_id])){
				$data[$v -> object_id][$v -> taxonomy] = array(
					'name' => $v -> name,
					'slug' => $v -> slug,
				);
			}
		}
		return $data;
	}
}

function custom_pagination($numpages = '', $pagerange = '', $paged='') {
	global $wp_query, $wp_rewrite;
	if (empty($pagerange)) {
		$pagerange = 4;
	}

	global $paged;
	if (empty($paged)) {
		$paged = 1;
	}
	if ($numpages == '') {
		$numpages = $wp_query->max_num_pages;
		if(!$numpages) {
			$numpages = 1;
		}
	}

	$pagenum_link = html_entity_decode( get_pagenum_link() );
	$url_parts    = explode( '?', $pagenum_link );

	$pagenum_link = trailingslashit( $url_parts[0] ) . '%_%';
	$format  = $wp_rewrite->using_index_permalinks() && ! strpos( $pagenum_link, 'index.php' ) ? 'index.php/' : '';
	$format .= $wp_rewrite->using_permalinks() ? user_trailingslashit( $wp_rewrite->pagination_base . '/%#%', 'paged' ) : '?paged=%#%';

	$pagination_args = array(
		'base'            => $pagenum_link,
		'format'          => $format,
		'total'           => $numpages,
		'current'         => $paged,
		'show_all'        => False,
		'end_size'        => 1,
		'mid_size'        => $pagerange,
		'prev_next'       => True,
		'prev_text'       => __('&lsaquo; previous'),
		'next_text'       => __('next &rsaquo;'),
		'type'            => 'plain',
		'add_args'        => false,
		'add_fragment'    => ''
	);

	$paginate_links = paginate_links($pagination_args);
	$last = get_pagenum_link(1);
	if ($paginate_links) {
		echo "<nav class='custom-pagination'>";
		if($pagination_args['current'] >= 2){
			echo '<a class="next page-numbers" href="'.(IsSet($url_parts[1]) && $url_parts[1] ? $url_parts[0].'?'.$url_parts[1] : $last).'">&laquo; first</a>';
		}
		echo $paginate_links;
		if($pagination_args['current'] != $pagination_args['total']) {
			$url_parts[1] = trim($url_parts[1], '/');
			$url_parts[0] = trim($url_parts[0], '/');
			$last = trim($last, '/');

			echo '<a class="next page-numbers" href="' . (IsSet($url_parts[1]) && $url_parts[1] ? $url_parts[0] . 'page/' . $pagination_args['total'] . '/?' . $url_parts[1] : $last . '/page/' . $pagination_args['total']) . '">last &raquo;</a>';
		}
		echo "</nav>";
	}
}
function customPaginAjax() {
	global $paged, $wp_query;
	if (empty($paged)) {
		$paged = 1;
	}
	$numpages = $wp_query->max_num_pages;
	if(!$numpages) {
		$numpages = 1;
	}

	$pagination_args = array(
		'base'            => get_pagenum_link(1) . '%_%',
		'format'          => '/page/%#%',
		'total'           => $numpages,
		'current'         => $paged,
		'show_all'        => false,
		'end_size'        => 1,
		'mid_size'        => 0,
		'prev_next'       => true,
		'prev_text'       => __(''),
		'next_text'       => __('Load more'),
		'type'            => 'plain',
		'add_args'        => false,
		'add_fragment'    => ''
	);

	$pagination_args['base'] = trim($pagination_args['base'], '/%_%');
	$pagination_args['base'] .= "%_%";

	$paginate_links = paginate_links($pagination_args);

	if ($paginate_links) {
		echo '<nav class="paginationAjax">'.$paginate_links.'</nav>';
	}
}
function the_truncated_post($symbol_amount) {
	$filtered = strip_tags( preg_replace('@<style[^>]*?>.*?</style>@si', '', preg_replace('@<script[^>]*?>.*?</script>@si', '', apply_filters('the_content', get_the_content()))) );
	echo substr($filtered, 0, strrpos(substr($filtered, 0, $symbol_amount), ' ')) . '...';
}
function theTruncatedPost($symbol_amount,$content) {
	$filtered = strip_tags( preg_replace('@<style[^>]*?>.*?</style>@si', '', preg_replace('@<script[^>]*?>.*?</script>@si', '', $content)) );
	echo substr($filtered, 0, strrpos(substr($filtered, 0, $symbol_amount), ' ')) . '...';
}
function get_the_truncated_content($symbol_amount,$content) {
	return substr($content, 0, strrpos(substr($content, 0, $symbol_amount), ' ')) . '...';
}
function timeLink() {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
	}
	$time_string = sprintf( $time_string,
		get_the_date( DATE_W3C ),
		get_the_date(),
		get_the_modified_date( DATE_W3C ),
		get_the_modified_date()
	);
	return $time_string;
}

function is_url_exist($url){
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_NOBODY, true);
	curl_exec($ch);
	$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

	if($code == 200){
		$status = true;
	}else{
		$status = false;
	}
	curl_close($ch);
	return $status;
}

//function wpa_show_permalinks( $post_link, $post ){
//    global $wp_query;
//    pre($wp_query->query['pagename']);
//    get_query_var();
//    if ( is_object( $post ) && $post->post_type == 'podcasts' ){
//        $terms = wp_get_object_terms( $post->ID, 'podcast_categories' );
//        pre($terms);
//        pre($_SERVER);
//        if( $terms ){
//            return str_replace( '%podcast_categories%' , $terms[0]->slug , $post_link );
//        }
//    }
//
//    return $post_link;
//}
//add_filter( 'post_type_link', 'wpa_show_permalinks', 1, 2 );


//function create_post_types() {
//    register_post_type('podcasts', array(
//        'labels' => array(
//            'name' => 'Podcasts',
//            'all_items' => 'All Podcasts'
//        ),
//        'public' => true
//    ));
//}
//add_action('init', 'create_post_types');
//
//function create_taxonomies() {
//    register_taxonomy('podcast_categories', array('podcasts'), array(
//        'labels' => array(
//            'name' => 'Podcast Categories'
//        ),
//        'show_ui' => true,
//        'show_tagcloud' => false,
//        'rewrite' => array('slug' => 'podcasts')
//    ));
//}
//add_action('init', 'create_taxonomies');
//
//function taxonomy_slug_rewrite($wp_rewrite) {
//    $rules = array();
//
//    $taxonomies = get_taxonomies(array('_builtin' => false), 'objects');
//    $post_types = get_post_types(array('public' => true, '_builtin' => false), 'objects');
//
//    foreach ($post_types as $post_type) {
//        foreach ($taxonomies as $taxonomy) {
//            foreach ($taxonomy->object_type as $object_type) {
//                if ($object_type == $post_type->rewrite['slug']) {
//                    $terms = get_categories(array('type' => $object_type, 'taxonomy' => $taxonomy->name, 'hide_empty' => 0));
//                    foreach ($terms as $term) {
//                        $rules[$object_type . '/' . $term->slug . '/?$'] = 'index.php?' . $term->taxonomy . '=' . $term->slug;
//                    }
//                }
//            }
//        }
//    }
//    $wp_rewrite->rules = $rules + $wp_rewrite->rules;
//}
//add_filter('generate_rewrite_rules', 'taxonomy_slug_rewrite');

// add_action('init', 'region_init');
//
// function region_init() {
//     if (!is_taxonomy('region')) {
//         register_taxonomy( 'region', 'post',
//                    array(   'hierarchical' => FALSE, 'label' => __('Region'),
//                         'public' => TRUE, 'show_ui' => TRUE,
//                         'query_var' => 'region',
//                         'rewrite' => true ) );
//     }
// }
//
// add_filter('post_link', 'region_permalink', 10, 3);
// add_filter('post_type_link', 'region_permalink', 10, 3);
//
// function region_permalink($permalink, $post_id, $leavename) {
//     if (strpos($permalink, '%region%') === FALSE) return $permalink;
//
//         // Get post
//         $post = get_post($post_id);
//         if (!$post) return $permalink;
//
//         // Get taxonomy terms
//         $terms = wp_get_object_terms($post->ID, 'region');
//         if (!is_wp_error($terms) && !empty($terms) && is_object($terms[0])) $taxonomy_slug = $terms[0]->slug;
//         else $taxonomy_slug = 'no-region';
//
//     return str_replace('%region%', $taxonomy_slug, $permalink);
// }


function getEvent(){
	$time = time();
	$wp_query = new WP_Query(array(
		'cache_results' => false,
		'post_type' => 'event',
		'meta_query' => array(
			'relation' => 'AND',
			array(
				'key'     => 'wpcf-display-dates-begin',
				'value'   => $time,
				'compare' => '<=',
			),
			array(
				'key' => 'wpcf-display-dates-end',
				'value' => $time,
				'compare' => '>=',
			)
		),
	));

	$data = array();
	if($wp_query->posts){
		foreach ($wp_query->posts as $post){
			$post_meta = get_metadata('post',$post->ID);
			$photos = get_children( array('post_parent' => $post->ID, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => 'ASC', 'orderby' => 'menu_order ID') );
			$data[$post->ID] = array(
				'title'   => $post->post_title,
				'content' => $post->post_content,
			);
			foreach ($post_meta as $key => $val){
				if(strpos($key,'wpcf') !== false){
					if($val[0]){
						$data[$post->ID][$key] = $val[0];
					}
				}
			}
			if(!empty($photos)) {
				foreach ($photos as $photo){
					$data[$post->ID]['photo'] = $photo->guid;
				}
			}
		}
	}
	return $data;
}

$myEvent = getEvent();

function getPostAuthor($author){
	$count = count($author);
	if($count){
		$temp = array();
		if($count > 1){
			foreach ($author as $k => $v){
				if($k+1 != $count){
					$temp[] = $v->name;
				} else {
					return implode(', ',$temp).' and '.$v->name;
				}
			}
		} else {
			return $author[0]->name;
		}
	} else {
		return '';
	}
}

add_filter('nav_menu_css_class' , 'special_nav_class' , 10 , 2);

function special_nav_class ($classes, $item) {
	if (in_array('current-menu-item', $classes) ){
		$classes[] = 'active ';
	}
	return $classes;
}
if(!is_admin()) {
	add_action('pre_get_posts', 'categoryCountPost');
}
function categoryCountPost($query){
	if($query->tax_query->queries[0]['taxonomy'] == 'category' && $query->query_vars['posts_per_page'] > 2){
		$query->set( 'posts_per_page', 50 );
	}

	if(is_search()){
		$query->set( 'posts_per_page', 25 );
	}

	if(IsSet($query->query['tag']) && $query->query['tag']){
		$query->set( 'posts_per_page', 50 );
	}

	if ($query->is_search) {
		$query->set('post_type', array('post', 'column_article', 'dead_drop_article', 'job_listing', 'podcasts', 'video-daily-brief'));
	}
	$temp = explode('/',urldecode($_SERVER['REQUEST_URI']));
	if (IsSet($temp[1]) && $temp[1] == 'region') {
		$query->set( 'posts_per_page', 50 );
	}
}

function getMySideBar($type,$sort, $BlockComm = array(), $myEvent = array()){
	global $wpdb;
	$data = '';
	if(!empty($BlockComm)){
		$data .=
			'<div id="block-views-sidebar_expert_commentary-block" class="block block-views expert-commentary block-odd block-first clearfix">' .
			'<div class="content clearfix">' .
			'<div class="view view-sidebar-expert-commentary view-id-sidebar_expert_commentary">' .
			'<div class="view-header">' .
			'<div class="expert-header">' .
			'<h3>'.(IsSet($BlockComm['postComentar']['wpcf-sub-title'][0]) && $BlockComm['postComentar']['wpcf-sub-title'][0] ? $BlockComm['postComentar']['wpcf-sub-title'][0] : 'Expert Commentary').'</h3></div>' .
			($BlockComm['imageComm'][0] ? '<div class="story-img"><div class="crop-height"><img src="'.$BlockComm['imageComm'][0].'" width="'.$BlockComm['imageComm'][1].'" height="'.$BlockComm['imageComm'][2].'"></div><div class="com-article"><p>Commenting On</p><h3><a href="'.get_correct_url($BlockComm['commPost'][0]->ID).'">'.$BlockComm['real_title'].'</a></h3></div></div>' : '') .
			'</div>' .
			'<div class="view-content">';
		foreach ($BlockComm['wpQuery'] as $commn){
			$author = wp_get_post_terms($commn->ID, 'experts');
            $primary = new WPSEO_Primary_Term('experts', $commn->ID);
            foreach ($author as $key=>$id){
                if($id->term_id==$primary->get_primary_term()) {
                    unset($author[$key]);
                    array_unshift($author, $id);
                }
            }
			if(IsSet($author[0]->name)){
				$img = '';
				$temp = $wpdb->get_results("SELECT * FROM wp_termmeta WHERE term_id=".(int)$author[0]->term_id." AND meta_key='_thumbnail_id'");
				if($temp[0]){
					$temp = $wpdb->get_results("SELECT guid,post_excerpt FROM wp_posts WHERE ID=".(int)$temp[0]->meta_value);
					if($temp[0] && IsSet($temp[0]->guid) && $temp[0]->guid) {
						$img = '<img src="'.$temp[0]->guid.'" width="95" height="95" alt="'.$author[0]->name.'">';
					}
				}
				if($img){
					$link = get_correct_url($commn->ID);
					$data .=
						'<div class="views-row">' .
						'<a href="'.esc_url($link).'"'.($commn->ID == $BlockComm['mainPostId'] ? ' class="active"' : '').'>' .
						'<div class="expert-image">'.$img.'</div>' .
						'<div class="expert-text">' .
						'<div class="article-title">' .
						'<div class="inner">'.$commn->post_title.'</div>'.
						'</div>' .
						'<div class="text">' .
						'<div class="inner">' .
						'<h3>'.$author[0]->name.'</h3>' .
						'<h4>'.$temp[0] -> post_excerpt.'</h4>' .
						'</div>' .
						'</div>' .
						'</div>' .
						'</a>' .
						'</div>';
				}
			}
		}
		$data .=
			'</div>' .
			'</div>' .
			'</div>' .
			'</div>' .
			'</div>';
	}
	if(!empty($myEvent)){
		$time = time();
		ob_start();
		foreach ($myEvent as $banner) {
			if (IsSet($banner['title']) && $banner['title']) {
				?>
                <div class="sponsor-ad-box">
                    <h2>The Georgetown Salon Series is proud to present</h2>
                    <div class="sponsor-event-cta">
                        <h3><?php echo $banner['wpcf-speaker-title'].'<br>'.$banner['wpcf-speaker-name']; ?></h3>
						<?php echo(IsSet($banner['wpcf-client-logo']) && $banner['wpcf-client-logo'] ? '<img src="'.$banner['wpcf-client-logo'].'" class="clientLogo"/>' : '');?>
                        <p><?php echo $banner['title'].'<br><br><b>'.$banner['wpcf-event-date']; ?></b><br><br></p>
						<?php echo(IsSet($banner['content']) ? '<p>'.$banner['content'].'</p>' : '');?>
						<?php echo(IsSet($banner['wpcf-cient-link-url']) ? '<br><a target="_blank" href="'.$banner['wpcf-cient-link-url'].'">For more information click here</a>' : '');?>
                        <p></p>
						<?php echo(IsSet($banner['wpcf-event-image']) && $banner['wpcf-event-image'] ? '<img src="'.$banner['wpcf-event-image'].'" class="eventImage"/>' : '');?>
                    </div>
                </div>
				<?php
			}
		}
		$my_sidebar = ob_get_clean();
		if($my_sidebar){
			$data .=
				'<div class="sponsor-ad-container">' .
				$my_sidebar .
				'<div class="sponsor-promo-cta"><a href="/become-sponsor/">BECOME A SPONSOR</a></div>' .
				'</div>';
		}
	}

	$time = time();
	$wp_query = new WP_Query(array(
		'cache_results' => false,
		'post_type' => 'advertisement',
		'orderby' => 'meta_value',
		'meta_key' => $sort,
		'meta_query' => array(
			'relation' => 'AND',
			array(
				'key'     => 'wpcf-daterange',
				'value'   => $time,
				'compare' => '<=',
			),
			array(
				'key' => 'wpcf-date-range-end',
				'value' => $time,
				'compare' => '>=',
			),
			array(
				'key' => $type,
				'value' => '1',
				'compare' => '=',
			)
		),
		'order' => 'ASC',
	));
	if($wp_query->posts){
		foreach ($wp_query->posts as $post){
			$id = get_queried_object_id();
			$post_meta = get_metadata('post',$post->ID);
			$photos = get_children( array('post_parent' => $post->ID, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => 'ASC', 'orderby' => 'menu_order ID') );
			if(IsSet($post_meta['wpcf-network_spotlight']) && IsSet($post_meta['wpcf-network_spotlight'][0]) && $post_meta['wpcf-network_spotlight'][0]){
				$results = $wpdb->get_results("SELECT COUNT(*) AS cnt FROM wp_termmeta WHERE meta_key = 'metatax_network_spotlight'  ");
				if($results[0]->cnt):
					$cnt = $results[0]->cnt - 1;
					$network = array();
					$results_new = $wpdb->get_results("SELECT term.*, tmeta.*
                                       FROM wp_terms AS term
                                       INNER JOIN wp_termmeta AS tmeta ON term.term_id = tmeta.term_id
                                       WHERE tmeta.meta_key = 'metatax_network_spotlight'
                                       LIMIT ".rand(0, $cnt).",1");
					if($results_new[0]->term_id):
						$network = (array)get_term($results_new[0]->term_id);
						$temp = $wpdb->get_results("SELECT * FROM wp_termmeta WHERE term_id=".(int)$results_new[0]->term_id." AND meta_key='_thumbnail_id'");
						if($temp[0]){
							$temp = $wpdb->get_results("SELECT guid,post_excerpt FROM wp_posts WHERE ID=".(int)$temp[0]->meta_value);
							if($temp[0] && IsSet($temp[0]->guid) && $temp[0]->guid) {
								$network['image'] = '<img src="'.$temp[0]->guid.'" alt="'.$results[0] -> name.'"/>';
								$network['work'] = $temp[0] -> post_excerpt;
							}
						}
						$data.=
							'<div id="block-views-home-newtork_spotlights">'.
							'<div class="view-header"><h2>Network Spotlight</h2></div>' .
							'<div class="view-content">' .
							'<div class="views-row views-row-1 views-row-odd views-row-first views-row-last">' .
							'<div class="views-field views-field-name">' .
							'<span class="field-content">' .
							'<div class="fp">' .
							'<div class="fp-crop">'.(IsSet($network['image']) && $network['image'] ? $network['image'] : '').'</div>' .
							'<div class="fp-expert"><h2>'.(IsSet($network['name']) && $network['name'] ? $network['name'] : '').'</h2></div>' .
							'<div class="fp-content">' .
							'<p></p>' .
							'<p>'.wp_trim_words( $network['description'], 60, ' ...' ).'</p>' .
							'<a href="/expert/'.$network['slug'].'/" class="blue-button">Read More</a>' .
							'</div>' .
							'</div>' .
							'</span>' .
							'</div>' .
							'</div>' .
							'</div>' .
							'</div>';
					endif;
				endif;
			} elseif(IsSet($post_meta['wpcf-past_dead_drops']) && IsSet($post_meta['wpcf-past_dead_drops'][0]) && $post_meta['wpcf-past_dead_drops'][0]){
				$data.=
					'<div id="block-views-dead_drop_articles-block_1" class="block block-views block-even clearfix">' .
					'<div class="content clearfix">' .
					'<h2>Past Dead Drops</h2>' .
					'<div class="view view-dead-drop-articles view-id-dead_drop_articles">' .
					'<div class="view-content">' .
					'<div class="views-row views-row-1 views-row-odd views-row-first views-row-last">' .
					'<div class="views-field views-field-view">' .
					'<span class="field-content">' .
					'<div class="view view-dead-drop-articles view-id-dead_drop_articles">' .
					'<div class="view-content">' .
					'<div class="item-list">' .
					'<ul class="views-summary">' .
					wp_my_get_archives (array(
						'type'     => 'monthly', 'limit' => '',
						'format'    => 'html', 'before' => '',
						'after'     => '', 'show_post_count' => true,
						'post_type' => 'dead_drop_article',
						'echo'      => '',
						'my_type'   => '/dead-drop',
					)) .
					'</ul>' .
					'</div>' .
					'</div>' .
					'</div>' .
					'</span>' .
					'</div>' .
					'</div>' .
					'</div>' .
					'</div>' .
					'</div>' .
					'</div>';
			} elseif(IsSet($post_meta['wpcf-recent_briefs']) && IsSet($post_meta['wpcf-recent_briefs'][0]) && $post_meta['wpcf-recent_briefs'][0]) {
			    $recent = new WP_Query(array(
					'cache_results' => false,
					'posts_per_page' => 5,
					'post_type' => 'post',
					'post__not_in' => array($id),
                    'orderby' => 'date',
                    'order' => 'DESC',
                    'relation' => 'AND',
					'meta_query' => array(
						'relation' => 'AND',
						// Not Article Execrpt
						array(
							'relation' => 'OR',
							array(
								'key' => 'wpcf-articleexcerpt',
								'compare' => 'NOT EXISTS',
								'value' => ''
							),
							array(
								'key' => 'wpcf-articleexcerpt',
								'value' => ''
							)
						),
                        // Not Exclusive
                        array(
                            'relation' => 'OR',
                            array(
                                'key' => 'wpcf-exclusive',
                                'compare' => 'NOT EXISTS',
                                'value' => ''
                            ),
                            array(
                                'key' => 'wpcf-exclusive',
                                'value' => ''
                            )
                        ),
                        // Promoted to Front Page
                        array(
                            'key' => 'wpcf-promoted-to-front-page',
                            'value' => '1',
                            'compare' => '='
                        ),
                        // Have a Futured Image
                        array(
                            'relation' => 'AND',
                            array(
                                'key' => '_thumbnail_id',
                                'compare' => 'EXISTS',
                            ),
                            array(
                                'key' => '_thumbnail_id',
                                'value' => '',
                                'compare' => '!='
                            ),
                        )
					),
                    'date_query' => array(
                        'before' => 'today',
                        'inclusive' => false,
                     )
				));

				if(IsSet($recent->posts)):
					$data.=
						'<div id="block-views-home-next_up" class="block block-views block-odd clearfix">'.
						'<div class="content clearfix">' .
						'<h2>Recent Briefs</h2>' .
						'<div class="view view-home view-id-home view-display-id-next_up">' .
						'<div class="view-content">' .
						'<div class="item-list">' .
						'<ol>';
					foreach ($recent->posts as $commn) {
						$author = wp_get_post_terms($commn->ID, 'authors');
						if (IsSet($author[0]->name)) {
							$data .=
								'<li class="views-row views-row-1 views-row-odd views-row-first">' .
								'<div class="views-field views-field-title">' .
								'<span class="field-content">' .
								'<a href="' .get_correct_url($commn->ID). '">' .
								'<div class="nextup">' .
								'<h3>' . $commn->post_title . '</h3>' .
								'<div class="author-text">' . $author[0]->name . '</div>' .
								'</div>' .
								'</a>' .
								'</span>' .
								'</div>' .
								'</li>';
						}
					}
					$data.=
						'</ol>' .
						'</div>' .
						'</div>' .
						'</div>' .
						'</div>' .
						'</div>';
				endif;
			} else {
				if(IsSet($post->post_content) && $post->post_content){
					$data .= "<div class='row-2 row-last sidebar_row'>{$post->post_content}</div>";
				} else {
					$baner = array();
					if(!empty($photos)) {
						foreach ($photos as $photo){
							$baner['photo'] = $photo->guid;
						}
					}
					if($post_meta['wpcf-url'] || $baner['photo']){
						$data .=
							'<div class="view-id-advertisement_sidebar">' .
							'<div class="field-content">' .
							'<div class="view-content">' .
							(IsSet($post_meta['wpcf-url']) && IsSet($post_meta['wpcf-url'][0]) && $post_meta['wpcf-url'][0] ? '<a target="_blank" href="'.$post_meta['wpcf-url'][0].'">' : '') .
							(IsSet($baner['photo']) ? '<img src="'.$baner['photo'].'"/>' : '') .
							(IsSet($post_meta['wpcf-url']) && IsSet($post_meta['wpcf-url'][0]) && $post_meta['wpcf-url'][0] ? '</a>' : '') .
							'</div>' .
							'</div>' .
							'</div>';
					}
				}
			}
		}
	}
	return ($data ? '<div id="sidebar-second" class="column sidebar second"><div id="sidebar-second-inner" class="inner"><div class="region region-sidebar-second">' . $data . '</div></div></div>' : '');
}

function true_request( $query ){
	global $wpdb;

	$url_zapros = urldecode($_SERVER['REQUEST_URI']);
	$temp = explode('/',$url_zapros);
	if(is_admin()) return $query;
	if($temp[1] == 'article' and $temp[2] == 'international')$temp[1] = "category";
	if( $temp[1] == 'category' and !empty($temp[2]) and !empty($temp[2])) {
		$terms_categories = get_terms(
			array(
				'taxonomy' => 'category',
				'hide_empty' => false,
			)
		);
		foreach ( $terms_categories as $terms_category ) {
			if ( $terms_category->slug == $temp[ 2 ] ) {
				$query['taxonomy']           = 'category';
				$query['category_name']               = $temp[ 2 ];
				$query['paged']              = (int)$temp[4];
				$query['posts_per_page']    = 10;
				unset($query['tag']);
				unset($query['attachment']);
				unset($query['error']);
			}
		}
	}
	if( $temp[1] == 'article' ) {
		if(count($temp)<=3){
			$query['meta_query'] =
				array(
					'relation' => 'AND',
					array(
						'relation' => 'OR',
						array(
							'key' => 'wpcf-articleexcerpt',
							'compare' => 'NOT EXISTS',
							'value' => ''
						),
						array(
							'key' => 'wpcf-articleexcerpt',
							'value' => ''
						)
					),
					array(
						'relation' => 'OR',
						array(
							'key' => 'wpcf-exclusive',
							'compare' => 'NOT EXISTS',
						),
						array(
							'key' => 'wpcf-exclusive',
							'value' => '1',
							'compare' => '!='
						),
					),
				);
		}

		if($temp[2]){
			if($temp[2] != 'page'){
				$terms = get_terms(
					array(
						'taxonomy' => 'region',
						'hide_empty' => false,
					)
				);
				$region = false;
				$category = false;
				if(!$region) {
					foreach ( $terms as $term ) {
						if ( $term->slug == $temp[ 2 ] ) {
							$region = true;
						}
					}
				}
				$terms_categories = get_terms(
					array(
						'taxonomy' => 'category',
						'hide_empty' => false,
					)
				);

				if(!$category) {
					foreach ( $terms_categories as $terms_category ) {
						if ( $terms_category->slug == $temp[ 3 ]) {
							$category = true;
						}
					}

					if($region == true){
						$query['taxonomy'] = 'region';
						$query['term'] = $temp[2];
						//$query['category_name'] = $temp[2];
						$query['posts_per_page']    = 10;
						unset($query['tag']);
						unset($query['attachment']);
						unset($query['error']);
					} else if($category == true){
						if(!empty($temp[3]) and $temp[3] != 'page'){
							$query['name'] = $temp[3];
						}else if (empty($temp[3]) or $temp[3] == null){
							$query['taxonomy'] = 'category';
							$query['term'] = $temp[2];
							unset($query['tag']);
							unset($query['attachment']);
							unset($query['error']);
						}
					}

				} else {
					$temp[2] = array_shift(explode('?', $temp[2]));
					$query['name'] = $temp[2];
					$query['post_type'] = 'post';
				}
				if($temp[2] == 'exclusive'){
					if($temp[4]) {
						$temp[4] = array_shift(explode('?', $temp[4]));
						$query['taxonomy'] = 'region';
						$query['term'] = $temp[3];
						$query['name'] = $temp[4];
						unset($query['post_type']);
						unset($query['tag']);
						unset($query['attachment']);
						unset($query['error']);
					} else {
						$temp[3] = array_shift(explode('?', $temp[3]));
						$query['name'] = $temp[3];
					}
				}
				if($temp[3] == 'page'){
					$query['paged']               = $temp[4];
					unset($query['name']);
				}
			} else {
				unset($query['name']);
				$query['pagename']    = 'article';
				$query['paged']        = $temp[3];
			}
		}
	}

	if( $temp[1] == 'tags' ) {
		if($temp[2] == 'tag'){
			$query['tag'] = $temp[3];
			unset($query['error']);
			if($temp[4] == 'page'){
				$query['paged']               = $temp[5];
			}
		}
	}
	if( $temp[1] == 'column' ) {
		if(!$temp[2]){
			$query['post_type']                  = 'column_article';
			unset($query['name']);
			unset($query['page']);
		} else {
			if($temp[2] == 'page'){
				$query['post_type']              = 'column_article';
				$query['paged']                  = $temp[3];
				unset($query['name']);
			} else {
				if(!$temp[3]){
					$query['taxonomy']           = 'columns';
					$query['term']               = $temp[2];
					unset($query['attachment']);
				} else {
					if($temp[3] == 'page'){
						$query['taxonomy']       = 'columns';
						$query['term']           = $temp[2];
						$query['paged']          = $temp[4];
						unset($query['error']);
					} else {
						$temp[3] = array_shift(explode('?', $temp[3]));
						$query['column_article'] = $temp[3];
						$query['post_type']      = 'column_article';
						$query['name']           = $temp[3];
						unset($query['error']);
					}
				}
			}
		}
	}
	if($temp[3] == 'dead-drop'){
		$query['year']      = $temp[1];
		$query['monthnum']  = $temp[2];
		$query['post_type'] = 'dead_drop_article';
		unset($query['error']);
	} elseif($temp[1] == 'dead-drop' && $temp[2]) {
		$temp[2] = array_shift(explode('?', $temp[2]));
		$query['page']              = '';
		$query['dead_drop_article'] = $temp[2];
		$query['post_type']         = 'dead_drop_article';
		$query['name']              = $temp[2];
	} elseif($temp[1] == 'dead-drop' && !$temp[2]) {
		add_filter( 'wpseo_twitter_title', 'my_gv_wpseo_twitter_title', 10, 1 );
		add_filter( 'wpseo_opengraph_url', 'my_gv_wpseo_opengraph_url', 10, 1 );
		add_filter( 'wpseo_opengraph_title', 'my_gv_wpseo_opengraph_title', 10, 1 );
		add_filter( 'wpseo_opengraph_title', 'my_gv_wpseo_opengraph_title', 10, 1 );
	}

	if($temp[1] == 'podcasts' && $temp[2]){
		unset($query['attachment']);
		$query['taxonomy']       = 'podcast_categories';
		$query['term']           = $temp[2];
		if($temp[3] == 'page'){
			$query['paged']      = $temp[4];
		}
		if($wpdb->get_var("SELECT COUNT(*) FROM $wpdb->terms WHERE slug='$temp[2]'")){
			unset($query['podcasts']);
			unset($query['post_type']);
			unset($query['name']);
		}
		if($temp[2] == 'page'){
			unset($query['taxonomy']);
			unset($query['term']);
		}
	}


	if(($temp[1] == 'expert' && $temp[2])||($temp[1] == 'experts' && $temp[2])){
		$query['taxonomy']       = 'experts';
		$query['term']           = $temp[2];
		unset($query['attachment']);
		unset($query['error']);
		if($temp[3] == 'page'){
			if($temp[4] <= 1){
				$query['paged'] = 1;
			} else {
				$query['paged'] = $temp[4];
				$query['posts_per_page'] = 5;
			}
		}
	}

	/*if($temp[2] === 'international' and is_numeric( (int) $temp[4]) and $temp[3] === 'page'){
		$query['taxonomy']           = 'category';
		$query['category_name']               = 'international';
		$query['paged']              = (int)$temp[4];
		$query['posts_per_page']    = 10;
		unset($query['tag']);
		unset($query['attachment']);
		unset($query['error']);
	}

	if($temp[1] === 'category' and $temp[2] === 'international' and empty($temp[4]) and empty($temp[3])){
		$query['taxonomy']           = 'category';
		$query['category_name']               = 'international';
		$query['paged']              = 1;
		$query['posts_per_page']    = 10;
		unset($query['tag']);
		unset($query['attachment']);
		unset($query['error']);
	}*/

	return $query;
}

add_filter( 'request', 'true_request', 9999, 1 );

remove_action('wpseo_head', array( 'twitter' ), 40);

function wp_my_get_archives( $args = '' ) {
	global $wpdb, $wp_locale;

	$defaults = array(
		'type' => 'monthly', 'limit' => '',
		'format' => 'html', 'before' => '',
		'after' => '', 'show_post_count' => false,
		'echo' => 1, 'order' => 'DESC',
		'post_type' => 'post'
	);

	$r = wp_parse_args( $args, $defaults );

	$post_type_object = get_post_type_object( $r['post_type'] );
	if ( ! is_post_type_viewable( $post_type_object ) ) {
		return;
	}
	$r['post_type'] = $post_type_object->name;

	if ( '' == $r['type'] ) {
		$r['type'] = 'monthly';
	}

	if ( ! empty( $r['limit'] ) ) {
		$r['limit'] = absint( $r['limit'] );
		$r['limit'] = ' LIMIT ' . $r['limit'];
	}

	$order = strtoupper( $r['order'] );
	if ( $order !== 'ASC' ) {
		$order = 'DESC';
	}

	// this is what will separate dates on weekly archive links
	$archive_week_separator = '&#8211;';

	$sql_where = $wpdb->prepare( "WHERE post_type = %s AND post_status = 'publish'", $r['post_type'] );

	/**
	 * Filters the SQL WHERE clause for retrieving archives.
	 *
	 * @since 2.2.0
	 *
	 * @param string $sql_where Portion of SQL query containing the WHERE clause.
	 * @param array  $r         An array of default arguments.
	 */
	$where = apply_filters( 'getarchives_where', $sql_where, $r );

	/**
	 * Filters the SQL JOIN clause for retrieving archives.
	 *
	 * @since 2.2.0
	 *
	 * @param string $sql_join Portion of SQL query containing JOIN clause.
	 * @param array  $r        An array of default arguments.
	 */
	$join = apply_filters( 'getarchives_join', '', $r );

	$output = '';

	$last_changed = wp_cache_get_last_changed( 'posts' );

	$limit = $r['limit'];

	if ( 'monthly' == $r['type'] ) {
		$query = "SELECT YEAR(post_date) AS `year`, MONTH(post_date) AS `month`, count(ID) as posts FROM $wpdb->posts $join $where GROUP BY YEAR(post_date), MONTH(post_date) ORDER BY post_date $order $limit";
		$key = md5( $query );
		$key = "wp_get_archives:$key:$last_changed";
		if ( ! $results = wp_cache_get( $key, 'posts' ) ) {
			$results = $wpdb->get_results( $query );
			wp_cache_set( $key, $results, 'posts' );
		}
		if ( $results ) {
			$after = $r['after'];
			foreach ( (array) $results as $result ) {
				$url = get_month_link( $result->year, $result->month );
				if ( 'post' !== $r['post_type'] ) {
					if(!IsSet($args['my_type'])){
						$url = add_query_arg( 'post_type', $r['post_type'], $url );
					} else {
						$url = $url.$r['my_type'].'/';
					}
				}
				/* translators: 1: month name, 2: 4-digit year */
				$text = sprintf( __( '%1$s %2$d' ), $wp_locale->get_month( $result->month ), $result->year );
				if ( $r['show_post_count'] ) {
					$r['after'] = '&nbsp;(' . $result->posts . ')' . $after;
				}
				$output .= get_archives_link( $url, $text, $r['format'], $r['before'], $r['after'] );
			}
		}
	} elseif ( 'yearly' == $r['type'] ) {
		$query = "SELECT YEAR(post_date) AS `year`, count(ID) as posts FROM $wpdb->posts $join $where GROUP BY YEAR(post_date) ORDER BY post_date $order $limit";
		$key = md5( $query );
		$key = "wp_get_archives:$key:$last_changed";
		if ( ! $results = wp_cache_get( $key, 'posts' ) ) {
			$results = $wpdb->get_results( $query );
			wp_cache_set( $key, $results, 'posts' );
		}
		if ( $results ) {
			$after = $r['after'];
			foreach ( (array) $results as $result) {
				$url = get_year_link( $result->year );
				if ( 'post' !== $r['post_type'] ) {
					$url = add_query_arg( 'post_type', $r['post_type'], $url );
				}
				$text = sprintf( '%d', $result->year );
				if ( $r['show_post_count'] ) {
					$r['after'] = '&nbsp;(' . $result->posts . ')' . $after;
				}
				$output .= get_archives_link( $url, $text, $r['format'], $r['before'], $r['after'] );
			}
		}
	} elseif ( 'daily' == $r['type'] ) {
		$query = "SELECT YEAR(post_date) AS `year`, MONTH(post_date) AS `month`, DAYOFMONTH(post_date) AS `dayofmonth`, count(ID) as posts FROM $wpdb->posts $join $where GROUP BY YEAR(post_date), MONTH(post_date), DAYOFMONTH(post_date) ORDER BY post_date $order $limit";
		$key = md5( $query );
		$key = "wp_get_archives:$key:$last_changed";
		if ( ! $results = wp_cache_get( $key, 'posts' ) ) {
			$results = $wpdb->get_results( $query );
			wp_cache_set( $key, $results, 'posts' );
		}
		if ( $results ) {
			$after = $r['after'];
			foreach ( (array) $results as $result ) {
				$url  = get_day_link( $result->year, $result->month, $result->dayofmonth );
				if ( 'post' !== $r['post_type'] ) {
					$url = add_query_arg( 'post_type', $r['post_type'], $url );
				}
				$date = sprintf( '%1$d-%2$02d-%3$02d 00:00:00', $result->year, $result->month, $result->dayofmonth );
				$text = mysql2date( get_option( 'date_format' ), $date );
				if ( $r['show_post_count'] ) {
					$r['after'] = '&nbsp;(' . $result->posts . ')' . $after;
				}
				$output .= get_archives_link( $url, $text, $r['format'], $r['before'], $r['after'] );
			}
		}
	} elseif ( 'weekly' == $r['type'] ) {
		$week = _wp_mysql_week( '`post_date`' );
		$query = "SELECT DISTINCT $week AS `week`, YEAR( `post_date` ) AS `yr`, DATE_FORMAT( `post_date`, '%Y-%m-%d' ) AS `yyyymmdd`, count( `ID` ) AS `posts` FROM `$wpdb->posts` $join $where GROUP BY $week, YEAR( `post_date` ) ORDER BY `post_date` $order $limit";
		$key = md5( $query );
		$key = "wp_get_archives:$key:$last_changed";
		if ( ! $results = wp_cache_get( $key, 'posts' ) ) {
			$results = $wpdb->get_results( $query );
			wp_cache_set( $key, $results, 'posts' );
		}
		$arc_w_last = '';
		if ( $results ) {
			$after = $r['after'];
			foreach ( (array) $results as $result ) {
				if ( $result->week != $arc_w_last ) {
					$arc_year       = $result->yr;
					$arc_w_last     = $result->week;
					$arc_week       = get_weekstartend( $result->yyyymmdd, get_option( 'start_of_week' ) );
					$arc_week_start = date_i18n( get_option( 'date_format' ), $arc_week['start'] );
					$arc_week_end   = date_i18n( get_option( 'date_format' ), $arc_week['end'] );
					$url            = add_query_arg( array( 'm' => $arc_year, 'w' => $result->week, ), home_url( '/' ) );
					if ( 'post' !== $r['post_type'] ) {
						$url = add_query_arg( 'post_type', $r['post_type'], $url );
					}
					$text           = $arc_week_start . $archive_week_separator . $arc_week_end;
					if ( $r['show_post_count'] ) {
						$r['after'] = '&nbsp;(' . $result->posts . ')' . $after;
					}
					$output .= get_archives_link( $url, $text, $r['format'], $r['before'], $r['after'] );
				}
			}
		}
	} elseif ( ( 'postbypost' == $r['type'] ) || ('alpha' == $r['type'] ) ) {
		$orderby = ( 'alpha' == $r['type'] ) ? 'post_title ASC ' : 'post_date DESC, ID DESC ';
		$query = "SELECT * FROM $wpdb->posts $join $where ORDER BY $orderby $limit";
		$key = md5( $query );
		$key = "wp_get_archives:$key:$last_changed";
		if ( ! $results = wp_cache_get( $key, 'posts' ) ) {
			$results = $wpdb->get_results( $query );
			wp_cache_set( $key, $results, 'posts' );
		}
		if ( $results ) {
			foreach ( (array) $results as $result ) {
				if ( $result->post_date != '0000-00-00 00:00:00' ) {
					$url = get_permalink( $result );
					if ( $result->post_title ) {
						/** This filter is documented in wp-includes/post-template.php */
						$text = strip_tags( apply_filters( 'the_title', $result->post_title, $result->ID ) );
					} else {
						$text = $result->ID;
					}
					$output .= get_archives_link( $url, $text, $r['format'], $r['before'], $r['after'] );
				}
			}
		}
	}
	if ( $r['echo'] ) {
		echo $output;
	} else {
		return $output;
	}
}



function my_gv_wpseo_opengraph_title( $title ) {
	global $wp_query;
	$wp_query = new WP_Query(array(
		'cache_results' => false,
		'paged' => 1,
		'posts_per_page' => 1,
		'post_type' => 'dead_drop_article',
		"orderby" => "date",
		"order" => 'DESC'
	));
	return $wp_query->posts[0]->post_title;
}
function my_gv_wpseo_opengraph_url( $url ) {
	global $wp_query;
	$wp_query = new WP_Query(array(
		'cache_results' => false,
		'paged' => 1,
		'posts_per_page' => 1,
		'post_type' => 'dead_drop_article',
		"orderby" => "date",
		"order" => 'DESC'
	));
	return '/dead-drop/'.$wp_query->posts[0]->post_name.'/';
}
function my_gv_wpseo_twitter_title( $title ) {
	global $wp_query;
	$wp_query = new WP_Query(array(
		'cache_results' => false,
		'paged' => 1,
		'posts_per_page' => 1,
		'post_type' => 'dead_drop_article',
		"orderby" => "date",
		"order" => 'DESC'
	));
	return '/dead-drop/'.$wp_query->posts[0]->post_name.'/';
}

function get_my_the_term_list( $id, $taxonomy, $before = '', $sep = '', $after = '' ) {
	$terms = get_the_terms( $id, $taxonomy );

	if ( is_wp_error( $terms ) )
		return $terms;

	if ( empty( $terms ) )
		return false;

	$links = array();

	foreach ( $terms as $term ) {
		$link = '/tags/tag/'.$term->slug.'/';
		if ( is_wp_error( $link ) ) {
			return $link;
		}
		$links[] = '<a href="' . esc_url( $link ) . '" rel="tag">' . $term->name . '</a>';
	}

	$term_links = apply_filters( "term_links-{$taxonomy}", $links );

	return $before . join( $sep, $term_links ) . $after;
}
/* Redirect rule to podcats_category @mpegi */
add_action( 'init', 'podcasts_redirect' );
function podcasts_redirect()
{
	$request = $_SERVER['REQUEST_URI'];
	if (!preg_match('/wp-admin/',$request)) {
		if (preg_match('/podcast_categories/', $request)) {
			$result = str_replace('podcast_categories', 'podcasts', $request);
			wp_redirect($result);
			exit;
		}
	}
}

error_reporting(0);

/**
 *  Create a new custom yoast seo sitemap
 */

add_filter( 'wpseo_sitemap_index', 'ex_add_sitemap_custom_items' );
add_action( 'init', 'init_wpseo_do_sitemap_actions' );
// Add custom index
function ex_add_sitemap_custom_items(){
	global $wpseo_sitemaps;
	$date = $wpseo_sitemaps->get_last_modified('post');
	$smp ='';
	$smp .= '<sitemap>' . "\n";
	$smp .= '<loc>' . site_url() .'/posts-sitemap.xml</loc>' . "\n";
	$smp .= '<lastmod>' . htmlspecialchars( $date ) . '</lastmod>' . "\n";
	$smp .= '</sitemap>' . "\n";
	$smp .= '<sitemap>' . "\n";
	$smp .= '<loc>' . site_url() .'/column-article-sitemap.xml</loc>' . "\n";
	$smp .= '<lastmod>' . htmlspecialchars( $date ) . '</lastmod>' . "\n";
	$smp .= '</sitemap>' . "\n";
	$smp .= '<sitemap>' . "\n";
	$smp .= '<loc>' . site_url() .'/dead-drop-article-sitemap.xml</loc>' . "\n";
	$smp .= '<lastmod>' . htmlspecialchars( $date ) . '</lastmod>' . "\n";
	$smp .= '</sitemap>' . "\n";
	/*
	 * $smp .= '<sitemap>' . "\n";
	$smp .= '<loc>' . site_url() .'/job-listing-sitemap.xml</loc>' . "\n";
	$smp .= '<lastmod>' . htmlspecialchars( $date ) . '</lastmod>' . "\n";
	$smp .= '</sitemap>' . "\n";
	 */
	return $smp;
}
function init_wpseo_do_sitemap_actions(){
	add_action( "wpseo_do_sitemap_posts", 'ex_generate_origin_combo_sitemap');
	add_action( "wpseo_do_sitemap_column-article", 'ex_generate_origin_column_article');
	add_action( "wpseo_do_sitemap_dead-drop-article", 'ex_generate_origin_dead_drop_article');
	//add_action( "wpseo_do_sitemap_job-listing", 'ex_generate_origin_job_listing');
}
function ex_generate_origin_column_article(){
	$url = array();
	global $wpseo_sitemaps;
	$args = array(
		'post_type'=> 'column_article',
		'posts_per_page' => -1,
		'order'    => 'ASC'
	);

	$the_query = new WP_Query( $args );
	foreach ($the_query->posts as $post) {
		$taxonomy = wp_get_post_terms( $post->ID, 'columns');

		$url[ 'loc' ] = get_home_url( NULL, "/column/" . $taxonomy[0]->slug . "/" . $post->post_name );
		$url[ 'pri' ] = 1;
		$url[ 'mod' ] = $post->post_modified_gmt;
		$url[ 'chf' ] = 'weekly';
		$output .= $wpseo_sitemaps->sitemap_url( $url );

	}

	wp_reset_postdata();
	$sitemap = '<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" ';
	$sitemap .= 'xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd" ';
	$sitemap .= 'xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
	$sitemap .= $output . '</urlset>';
	$wpseo_sitemaps->set_sitemap($sitemap);

}
function ex_generate_origin_dead_drop_article(){
	$url = array();
	global $wpseo_sitemaps;
	$args = array(
		'post_type'=> 'dead_drop_article',
		'posts_per_page' => -1,
		'order'    => 'ASC'
	);

	$the_query = new WP_Query( $args );
	foreach ($the_query->posts as $post) {
		//$taxonomy = wp_get_post_terms( $post->ID, 'columns');

		$url[ 'loc' ] = get_home_url( NULL, "/dead-drop/" . $post->post_name );
		$url[ 'pri' ] = 1;
		$url[ 'mod' ] = $post->post_modified_gmt;
		$url[ 'chf' ] = 'weekly';
		$output .= $wpseo_sitemaps->sitemap_url( $url );

	}

	wp_reset_postdata();
	$sitemap = '<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" ';
	$sitemap .= 'xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd" ';
	$sitemap .= 'xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
	$sitemap .= $output . '</urlset>';
	$wpseo_sitemaps->set_sitemap($sitemap);

}
function ex_generate_origin_job_listing(){
	$url = array();
	global $wpseo_sitemaps;
	$args = array(
		'post_type'=> 'job_listing',
		'posts_per_page' => -1,
		'order'    => 'ASC'
	);

	$the_query = new WP_Query( $args );
	foreach ($the_query->posts as $post) {
		$url[ 'loc' ] = get_home_url( NULL, "/job_listing/" . $post->post_name );
		$url[ 'pri' ] = 1;
		$url[ 'mod' ] = $post->post_modified_gmt;
		$url[ 'chf' ] = 'weekly';
		$output .= $wpseo_sitemaps->sitemap_url( $url );
	}

	wp_reset_postdata();
	$sitemap = '<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" ';
	$sitemap .= 'xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd" ';
	$sitemap .= 'xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
	$sitemap .= $output . '</urlset>';
	$wpseo_sitemaps->set_sitemap($sitemap);
}
function ex_generate_origin_combo_sitemap(){
	global $wpseo_sitemaps;
	$args = array(
		'numberposts' => -1,
	);

	$posts = get_posts( $args );

	foreach($posts as $post) {
		setup_postdata( $post );

		$url_link = '';
		if($post->post_status == 'publish' && $post->post_type == 'post') {
			$ex = '';
			if (get_post_meta($post->ID, 'wpcf-exclusive', true)) $ex = 'exclusive/';
			$region = wp_get_post_terms($post->ID, 'region');
			if ($region[0]->term_id > 0) {
				$url_link = get_home_url( NULL,"/article/{$ex}{$region[0]->slug}/{$post->post_name}");
			} else {
				$columns = wp_get_post_terms($post->ID, 'columns');
				if ($columns[0]->term_id > 0) {
					$url_link = get_home_url( NULL,"/column/{$ex}{$columns[0]->slug}/{$post->post_name}");
				} else {
					$cat_obj = get_the_category($post->ID);
					if($cat_obj[0]->slug=='uncategorized'){
						$url_link = get_home_url( NULL,"/article/{$ex}{$post->post_name}");
					}else {
						$url_link = get_home_url( NULL,"/article/{$ex}{$cat_obj[0]->slug}/{$post->post_name}");
					}
				}
			}
		}

		$url = array();
		$url['loc'] = $url_link;
		$url['pri'] = 1;
		$url['mod'] = $post->post_modified;
		$url['chf'] = 'weekly';
		$output .= $wpseo_sitemaps->sitemap_url( $url );
	}

	wp_reset_postdata();

	$sitemap = '<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" ';
	$sitemap .= 'xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd" ';
	$sitemap .= 'xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
	$sitemap .= $output . '</urlset>';
	$wpseo_sitemaps->set_sitemap($sitemap);
}
function get_correct_url($id)
{
	$post = get_post($id);
	$url = '';
	$ex = '';
	if (get_post_meta($post->ID, 'wpcf-exclusive', true)) $ex = 'exclusive/';
	$region = wp_get_post_terms($post->ID, 'region');
	if ($region[0]->term_id > 0) {
		$url = "/article/{$ex}{$region[0]->slug}/{$post->post_name}";
	} else {
		$columns = wp_get_post_terms($post->ID, 'columns');
		if ($columns[0]->term_id > 0) {
			$url = "/column/{$ex}{$columns[0]->slug}/{$post->post_name}";
		} else {
			$cat_obj = get_the_category($post->ID);
			if($cat_obj[0]->slug=='uncategorized'){
				$url = "/article/{$ex}{$post->post_name}";
			}else {
				$url = "/article/{$ex}{$cat_obj[0]->slug}/{$post->post_name}";
			}
		}
	}
	return esc_url($url);
}


/* Fontsize select in editor */

function wp_editor_fontsize_filter( $buttons ) {
    array_shift( $buttons );
    array_unshift( $buttons, 'fontsizeselect');
    array_unshift( $buttons, 'formatselect');
    return $buttons;
}
add_filter('mce_buttons', 'wp_editor_fontsize_filter');


function the_custom_header_banner(){

    $time = time();
    $adv_query = new WP_Query(array(
        'cache_results' => false,
        'post_type' => 'advertisement',
        'orderby' => 'date',
        'order' => 'DESC',
        'posts_per_page' => 1,
        'meta_query' => array(
            'relation' => 'AND',
            array(
                'key'     => 'wpcf-daterange',
                'value'   => $time,
                'compare' => '<=',
            ),
            array(
                'key' => 'wpcf-date-range-end',
                'value' => $time,
                'compare' => '>=',
            ),
            array(
                'key' => 'wpcf-header',
                'value' => '1',
                'compare' => '=',
            )
        )
    ));
    $result = '';
    if($adv_query->posts){
        foreach ($adv_query->posts as $post) {
            $result.='<div class="adv-header">'.$post->post_content.'</div>';
        }
    }
    echo $result;
}

function the_custom_above_banner(){

    $time = time();
    $adv_query = new WP_Query(array(
        'cache_results' => false,
        'post_type' => 'advertisement',
        'orderby' => 'date',
        'order' => 'DESC',
        'posts_per_page' => 1,
        'meta_query' => array(
            'relation' => 'AND',
            array(
                'key'     => 'wpcf-daterange',
                'value'   => $time,
                'compare' => '<=',
            ),
            array(
                'key' => 'wpcf-date-range-end',
                'value' => $time,
                'compare' => '>=',
            ),
            array(
                'key' => 'wpcf-top-of-page',
                'value' => '1',
                'compare' => '=',
            )
        )
    ));
    $result = '';
    if($adv_query->posts){
        foreach ($adv_query->posts as $post) {
            $result.='<div class="adv-above">'.$post->post_content.'</div>';
        }
    }
    echo $result;
}
function the_custom_footer_banner(){

    $time = time();
    $adv_query = new WP_Query(array(
        'cache_results' => false,
        'post_type' => 'advertisement',
        'orderby' => 'date',
        'order' => 'DESC',
        'posts_per_page' => 1,
        'meta_query' => array(
            'relation' => 'AND',
            array(
                'key'     => 'wpcf-daterange',
                'value'   => $time,
                'compare' => '<=',
            ),
            array(
                'key' => 'wpcf-date-range-end',
                'value' => $time,
                'compare' => '>=',
            ),
            array(
                'key' => 'wpcf-footer',
                'value' => '1',
                'compare' => '=',
            )
        )
    ));
    $result = '';
    if($adv_query->posts){
        foreach ($adv_query->posts as $post) {
            $result.='<div class="adv-footer">'.$post->post_content.'</div>';
        }
    }
    echo $result;
}
