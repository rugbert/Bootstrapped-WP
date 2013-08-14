<?php 
// gets options function
if(is_admin()){
	include(dirname(dirname(__FILE__)).'/admin/init.php' ); 	
	include(dirname(dirname(__FILE__)).'/styles/styles.php');
}

 require_once('kjd_bootstrap_menus.php');
 require_once('kjdGallery.php');
 require_once('kjdShortcodes.php');
 require_once('kjdWidgets.php');
 require_once('kjd_adminbar_menu.php');

 require_once('layout_functions.php');



/* ----------------------- kjd add js and css --------------------- */
function kjd_add_assets(){

	// set variables
	$navbarSettings = get_option('kjd_navbar_misc_settings');
	$navbarSettings = $navbarSettings['kjd_navbar_misc'];
	$sideNav = $navbarSettings['side_nav'];
	$generalSettings = get_option('kjd_theme_settings');
	$responsive = $generalSettings['kjd_responsive_design'];

	//set tempplate root
	$root=get_bloginfo('template_directory'); 
	$root = $root.'/lib';

	wp_enqueue_script("jquery", $root."/scripts/jquery.js", false, "1.0", false);  
	wp_enqueue_script("bootstrap", $root."/scripts/bootstrap.min.js", false, "1.0", true);  

	if($sideNav =='true'){
		wp_enqueue_script("sidr", $root."/scripts/sidr.min.js", false, "1.0", true);  
		wp_enqueue_style("sidr", $root."/styles/sidr.css");
	}

	
	wp_enqueue_script("script", $root."/scripts/application.js", false, "1.0", true);  

	wp_enqueue_style("bootstrap", $root."/styles/bootstrap/bootstrap.min.css");

	if($responsive == 'true'){
		wp_enqueue_style("bootstrap-responsive", $root."/styles/bootstrap/bootstrap-responsive.min.css");
	}

	wp_enqueue_style("wpstyles", $root."/styles/wpstyles.css");	
	wp_enqueue_style("scaffolding", $root."/styles/common.css");	
	wp_enqueue_style("custom", $root."/styles/custom.css");

	// Add slider scripts if on front page
	if( is_front_page() ){
		 include( 'add_slider_scripts.php');
	}

}
add_action( 'wp_enqueue_scripts', 'kjd_add_assets' );


/* ------------------------- Update Style sheet after settigns are saved ------------------------------------ */
// function kjd_update_stylesheet( $oldvalue, $_newvalue ){
// 	echo 'updated!';
// 	die();
// }
// add_action('update_option_kjd_body_background_settings','kjd_update_stylesheet',10, 2);

// function kjd_export_theme_settings(){
// 	//gets all rows with the stuff
// 	$myrows = $wpdb->get_results( "SELECT * FROM `wp_options` WHERE option_name LIKE 'kjd_%';" );
// 	foreach($myrows as $k => $v){
// 		// echo $v->option_name.' =>'.$v->option_value;
// 	}

// }

/* ------------------------- select form for admin pages ------------------------ */
function kjd_nav_select(){
	$nav_markup = '';
	$nav_markup .= '<select class="kjd-admin-page-title">';
	foreach( array(
		'General Settings'=>'admin.php?page=kjd_theme_settings',
		'Header Settings'=>'admin.php?page=kjd_header_settings',
		'Navbar Settings'=>'admin.php?page=kjd_navbar_settings',
		'Navbar Dropdown Settings'=>'admin.php?page=kjd_dropdown-menu_settings',
		'Image Carousel Settings'=>'admin.php?page=kjd_cycler_settings',
		'Page Title Settings'=>'admin.php?page=kjd_pageTitle_settings',
		'Body Settings'=>'admin.php?page=kjd_body_settings',
		'Footer Settings'=>'admin.php?page=kjd_footer_settings',
		'Login Page Settings'=>'admin.php?page=kjd_login_settings',
		'Special Backgrounds'=>'admin.php?page=kjd_misc_background_settings',
		'Page Layouts'=>'admin.php?page=kjd_page_layout_settings' 
			) as $page => $path )
	{
		$nav_markup .= '<option value="'.$path.'">' . $page . '</option>';

	}
	$nav_markup .= '</select>';

	return $nav_markup;
}

/* ------------------------ site preview iframe ----------------------------*/
function kjd_site_preview(){
	$site_preview ='';

	$site_preview .='<iframe src="'.get_site_url().'" width="1000" height="600"></iframe>';

	return $site_preview;
}


///////////////////////////
// featured image settings
///////////////////////////

if (function_exists('add_theme_support')) {  
    add_theme_support('post-thumbnails');  

	$options = get_option('kjd_component_settings');
	$image = $options['featured_image'];
    add_image_size( 'featured-image', $image['width'], $image['height'] ); 
}  


//gets featured image meta info
function kjd_the_post_thumbnail_description($args) {
  $thumbnail_id    = get_post_thumbnail_id($args->ID);
  $thumbnail_image = get_posts(array('p' => $thumbnail_id, 'post_type' => 'attachment'));

  if ($thumbnail_image && isset($thumbnail_image[0])) {
    echo '<span>'.$thumbnail_image[0]->post_content.'</span>';
  }
}


// add excerpts to pages
function kjd_add_excerpts_to_pages() {
     add_post_type_support( 'page', 'excerpt' );
}

add_action( 'init', 'kjd_add_excerpts_to_pages' );


//////////////////
// get images
//////////////////

// old image grabber
function kjd_get_post_images($postID, $size = NULL) {

$attachments = get_children( array( 
	'post_parent' => $postID, 
	'post_type' => 'attachment', 
	'post_mime_type' => 'image', 
	'orderby' => 'menu_order', 
	'order' => 'ASC', 
	'numberposts' => 999 ) 
); 
	$images = array();
/* $images is now a object that contains all images (related to post id 1) and their information ordered like the gallery interface. */
    $attributes = array();
	if ( $attachments){
	    //looping through the images
	    foreach ( $attachments as $attachment => $att ) {

	    	$url = wp_get_attachment_image_src($attachment, 'thumbnail');
			$attributes['thumbnail']= $url[0];
			$url = wp_get_attachment_image_src($attachment, 'medium');
			$attributes['medium'] = $url[0];
			$url = wp_get_attachment_image_src($attachment, 'large');
			$attributes['large'] = $url[0];
			$url = wp_get_attachment_image_src($attachment, 'full');
			$attributes['full'] = $url[0];
			
			$attributes['image_id'] = $att->ID;
			$attributes['title'] = $att->post_title;
			$attributes['description'] = $att->post_content;
			$attributes['caption'] = $att->post_excerpt;
			$attributes['alt'] = $att->_wp_attachment_image_alt;
			array_push($images, $attributes);
	    }
	}	
	return $images;

}


/* -------------------device views ----------------------- */

function kjd_deviceViewSettings($deviceView){
		if(isset($deviceView) && $deviceView !="all"){
			echo $deviceView;
		}
}

////////////////////////
// login screen styling


function kjd_login_css() {
	require_once(dirname(dirname(__FILE__)).'/styles/login.php');
}
add_action('login_head', 'kjd_login_css');



/* ------------------------------------- get page template layout settings ************************* */
function kjd_get_layout_settings($template = NULL) {






			//	if the page is a post type

			$layoutOptions = get_option('kjd_post_layout_settings');
			$layoutSettings = $layoutOptions['kjd_post_layouts'];
			
			if( is_single() ){
			
				$template = 'single';

			}elseif( is_attachment() ){

				$template = 'attachment';

			}elseif( is_404() ){
			
				$template = '404';
			
			}elseif( is_category() ){
			
				$template = 'category';

			}elseif( is_archive() ){
			
				$template = 'archive';
			
			}elseif( is_tag() ){

				$template = 'tag';

			}elseif( is_author() ){

				$template = 'author';

			}elseif( is_date() ){

				$template = 'date';

			}elseif( is_search() ){

				$template = 'search';

			}elseif( is_front_page() ){

				$template = 'front_page';

			}elseif( is_page() ){

				// if current page is page template
				if( is_page_template() ){

					$options = get_option('kjd_page_layout_settings');
					$layoutSettings = $options['kjd_page_layouts'];

					
						if ( is_page_template('pageTemplate1.php') ){

							$template = 'template_1';
						
						}elseif( is_page_template('pageTemplate2.php') ){

							$template = 'template_2';
						
						}elseif( is_page_template('pageTemplate3.php') ){

							$template = 'template_3';
						
						}elseif( is_page_template('pageTemplate4.php') ){

							$template = 'template_4';
						
						}elseif( is_page_template('pageTemplate5.php') ){

							$template = 'template_5';
						
						}elseif( is_page_template('pageTemplate6.php') ){

							$template = 'template_6';
						
						}else{
							
							$template = 'page';							
						}
		

				// if current page is a page but not a template
				}else{

					$template = 'page';
				
				}

			//fallback - if not a post template OR a page
			}else{

				$template = 'default';
			}
			

	$layoutSettings = $layoutSettings[$template]['toggled'] == 'true' ? $layoutSettings[$template] : $layoutSettings['default'] ;


	return $layoutSettings;
}



/* --------------------------- read more link --------------------------*/
function kjd_excerpt_more_link($more) {
       global $post;
	return '<a class="moretag" href="'. get_permalink($post->ID) . '"> Read More</a>';
}
add_filter('excerpt_more', 'kjd_excerpt_more_link');

/* -------------------------------- pagination  ------------------------------- */
function kjd_get_posts_pagination(){
	
	$pagination_markup ='';

	global $wp_query;  
	  
	$total_pages = $wp_query->max_num_pages;  
	  
	if ($total_pages > 1){  
	  
	  $current_page = max(1, get_query_var('paged'));  
	  $pagination_markup .= '<div class="row">';

		  $pagination_markup .= '<div class="pagination">';
		  $pagination_markup .=  paginate_links(array(  
		      'base' => get_pagenum_link(1) . '%_%',  
		      'format' => 'page/%#%',  
		      'current' => $current_page,  
		      'total' => $total_pages,  
		      'type' => 'list',
		      'prev_text' => 'Prev',  
		      'next_text' => 'Next'  
		    ));  
		  $pagination_markup .= '</div>';
	  $pagination_markup .= '</div>';  
	    
	}  
	return $pagination_markup;
}



/* ----------------------------------- single image nav links for gallery images ------------------------------------ */
function kjd_gallery_image_links(){

	global $post;

	$navigation_markup = '<div class="image-pagination">';
	$parent_id = $post->post_parent;
	
	if (strpos(get_post($parent_id)->post_content,'[gallery') == false){
		$navigation_markup .= 'no gallery';
	}else{

		$images = kjd_get_post_images($parent_id);
		foreach($images as $k=>$image)
		{
			
			// print_r($image);
			// echo "<br />";
			if($image['image_id'] == $post->ID){
				// $next_url = '<a href="'.get_attachment_link( $id ).'"><img src="'.$url[0].'" /></a>';
				$prev =  $images[$k-1]['image_id'];
				if(isset($prev)){
					$navigation_markup .= '<a class="image-nav prev" href="'.get_attachment_link($prev).'">Previous Image</a>';
				}

				$next =  $images[$k+1]['image_id'];
				if(isset($next)){
					$navigation_markup .= '<a class="image-nav next" href="'.get_attachment_link($next).'">Next Image</a>';
				}
			}
		}
	}

	$navigation_markup .= '</div>';
	return $navigation_markup;
}

/* ------------------------ the 404 ------------------------ */

function kjd_the_404(){

	$page404 = get_option('kjd_theme_settings');
	$page404 = do_shortcode($page404['kjd_404_page']);
	return $page404;
}
 
function kjd_get_featured_image($position = null, $wrapper = 'div'){
	
	if($position == 'left_of_post'){
	
		$wrapper = 'span';
	
		$wrapper_class = 'pull-left';
	
	}elseif($position == 'right_of_post'){
	
		$wrapper = 'span';
	
		$wrapper_class = 'pull-right';
	
	}else{

		$wrapper = 'div';
	
	}

	$featured_image_markup = '';

	if ( has_post_thumbnail() ) {
		$featured_image_markup .= '<'.$wrapper.' class="media-object '.$wrapper_class.'">';
		$featured_image_markup .= get_the_post_thumbnail(null, 'featured-image', array(
			'alt'	=> trim(strip_tags( $attachment->post_excerpt )),
			'title'	=> trim(strip_tags( $attachment->post_title )),
			)
		);
		$featured_image_markup .= '</'.$wrapper.'>';
	} 


	return $featured_image_markup;
}

/* ------------------------- Navbar functions -------------------------------*/
function menuStyleCallback($navbarLinkStyle){
	
	$menu_class = 'nav';
	
	switch($navbarLinkStyle){
		case 'none':

			$menu_class .= ' nav-noBG';
			break;
		case 'dividers':

			$menu_class .= ' nav-dividers';
			break;
		case 'pills':

			$menu_class .= ' nav-pills';
			break;
		case 'tabs':

			$menu_class .= ' nav-tabs';
			break;
		case 'tabs-below':

			$menu_class .= ' nav-tabs tabs-below';	
			break;
	}

	wp_nav_menu(array('theme_location' => 'primary-menu', 'menu_class' =>$menu_class,'container'=> '','walker'=> new dropDown() ) );

}