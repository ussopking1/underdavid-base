<?php
/**
 * Understrap Child Theme functions and definitions
 *
 * @package UnderstrapChild
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;



/**
 * Removes the parent themes stylesheet and scripts from inc/enqueue.php
 */
function understrap_remove_scripts() {
	wp_dequeue_style( 'understrap-styles' );
	wp_deregister_style( 'understrap-styles' );

	wp_dequeue_script( 'understrap-scripts' );
	wp_deregister_script( 'understrap-scripts' );
}
add_action( 'wp_enqueue_scripts', 'understrap_remove_scripts', 20 );



/**
 * Enqueue our stylesheet and javascript file
 */
function theme_enqueue_styles() {

	// Get the theme data.
	$the_theme = wp_get_theme();

	$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
	// Grab asset urls.
	$theme_styles  = "/css/child-theme{$suffix}.css";
	$theme_scripts = "/js/child-theme{$suffix}.js";

	wp_enqueue_style( 'child-understrap-styles', get_stylesheet_directory_uri() . $theme_styles, array(), $the_theme->get( 'Version' ) );
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'child-understrap-scripts', get_stylesheet_directory_uri() . $theme_scripts, array(), $the_theme->get( 'Version' ), true );
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );



/**
 * Load the child theme's text domain
 */
function add_child_theme_textdomain() {
	load_child_theme_textdomain( 'understrap-child', get_stylesheet_directory() . '/languages' );
}
add_action( 'after_setup_theme', 'add_child_theme_textdomain' );



/**
 * Overrides the theme_mod to default to Bootstrap 5
 *
 * This function uses the `theme_mod_{$name}` hook and
 * can be duplicated to override other theme settings.
 *
 * @param string $current_mod The current value of the theme_mod.
 * @return string
 */
function understrap_default_bootstrap_version( $current_mod ) {
	return 'bootstrap5';
}
add_filter( 'theme_mod_understrap_bootstrap_version', 'understrap_default_bootstrap_version', 20 );



/**
 * Loads javascript for showing customizer warning dialog.
 */
function understrap_child_customize_controls_js() {
	wp_enqueue_script(
		'understrap_child_customizer',
		get_stylesheet_directory_uri() . '/js/customizer-controls.js',
		array( 'customize-preview' ),
		'20130508',
		true
	);
}
add_action( 'customize_controls_enqueue_scripts', 'understrap_child_customize_controls_js' );















/**
 * Changes "site-info" to our boilerplate copyright (David Stockdale).
 * Also adds Log In and Log Out links.
 * (Original "site-info" code can be found in "understrap/inc/hooks.php")
 * 
 * Comment out "add_action" to enable default site info override!
 */
add_action( 'init', 'remove_parent_functions', 15 );

function remove_parent_functions() {
    remove_action( 'understrap_site_info', 'understrap_add_site_info' );
    add_action( 'understrap_site_info', 'understrap_add_site_child_info' );
}

function understrap_add_site_child_info() {
	if(is_user_logged_in()) 
	{
?>
<div class="wrap"><p>Site commissioned from RCVDA &nbsp; ⁄ &nbsp; Developed by <a rel="nofollow" href=<?php echo 'https://davidstockdalescrapcode.co.uk/' ?>>David Stockdale</a> &nbsp; ⁄ &nbsp; Copyright ©&nbsp;<?php echo date("Y"); ?> &nbsp; ⁄ &nbsp; <a rel="nofollow" href=<?php echo get_site_url().'/wp-login.php?action=logout&amp;_wpnonce=5969d1c9bc' ?>>Log out</a></p></div>
<?php
	} 
	else 
	{
?>
<div class="wrap"><p>Site commissioned from RCVDA &nbsp; ⁄ &nbsp; Developed by <a rel="nofollow" href=<?php echo 'https://davidstockdalescrapcode.co.uk/' ?>>David Stockdale</a> &nbsp; ⁄ &nbsp; Copyright ©&nbsp;<?php echo date("Y"); ?> &nbsp; ⁄ &nbsp; <a rel="nofollow" href=<?php echo get_site_url().'/wp-login.php' ?>>Log in</a></p></div>
<?php
	}
}




/**
 * Removes the site title from embedded content (David Stockdale).
 */
add_filter('embed_site_title_html','__return_false');
/**
 * Adds the author's names to embedded content (David Stockdale).
 */
add_action( 'embed_content', 'embed_author' );
/**
 * Adds the author div to the embed iframe (David Stockdale).
 */
function embed_author() {
	$output .= '<div class="wp-embed-author">By:';
	$coauthors = get_coauthors();
	$loopcheck = 0;
	foreach( $coauthors as $coauthor ):
	/**
	 * Checking if it's the first line to decide if it should be seperated with a comma.
	 */
	if($loopcheck == 0) {
		$loopcheck++;
	} 
	else 
	{
		$output .= ',';
	}
	$output .= ' ';
	$authorArchiveLink = get_author_posts_url($coauthor->ID, $coauthor->user_nicename);
	if ( isset( $coauthor->type ) && 'guest-author' === $coauthor->type ) 
	{
		// we have a guest author
		$output .=  "<a href=$authorArchiveLink> $coauthor->display_name</a>";
	} 
	else 
	{
		$output .=  "<a href=$authorArchiveLink> $coauthor->user_firstname $coauthor->user_lastname</a>";
	}
	endforeach;
	$output .= '.';
	$output .= '</div>';
    echo $output;
}

/**
 * Customises the style/colours of embedded posts (David Stockdale).
 */
add_action( 'embed_head', 'embed_styles' );
/**
 * Embed the plugin's custom styles (David Stockdale).
 */
function embed_styles() {
    echo <<<CSS
<style>
	.wp-embed {
		font-family: "Open Sans", sans-serif;
		background-color:inherit;
		border: none;
		
		box-shadow:none;
	}
	.wp-embed-heading a {
		font-family: "Open Sans", sans-serif;
		color: inherit;
// 		font-size: 1.8rem;
	}
	.wp-embed-author {
		margin-top: 0.5em;
	}
	.wp-embed-author a {
// 		color: #a6191a;
		color: rgb(217, 104, 101);
	}
	.wp-embed-author a:hover {
// 		color: #454545;
		color: darkgray;
 	}
 	.wp-embed-featured-image {
 		width: 150px!important;
		height: 150px!important;
 	}
	.wp-embed-featured-image > a > img {
 		width: 150px!important;
		object-fit: cover;
		height: 150px!important;
 	}
	.wp-embed-excerpt > p {
		word-break:break-word!important;
	}
</style>
CSS;
}

/**
 * Removes the "read more" link auto added to excerpts in UnderStrap (David Stockdale).
 */
add_filter( 'wp_trim_excerpt', 'understrap_all_excerpts_get_more_link' );
function understrap_all_excerpts_get_more_link( $post_excerpt ) {
	return $post_excerpt . '';
}


















/**
 * Shortcode for getting coauthors (David Stockdale).
 * [post_authors_posts_links]
 */
add_shortcode( 'post_authors_posts_links', 'post_authors_posts_links_shortcode' );
function post_authors_posts_links_shortcode(  ) {
	return coauthors_posts_links();
}

/**
 * Registers the "authors" widget area (David Stockdale).
 */
add_action( 'widgets_init', 'authors_widgets_init' );
function authors_widgets_init() {
	register_sidebar( array(
		'id'            => 'authors',
		'name'          => __( 'Authors', 'understrap' ),
		'description'   => __( 'Widgets in this area will be shown after posts and pages for the purpose of listing the co-authors and date of publishing.', 'understrap' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
}

/**
 * Creates [post_date] shortcode (David Stockdale).
 */
add_shortcode( 'post_date', 'shortcode_post_published_date' );
function shortcode_post_published_date(){
	return get_the_date();
}

/**
 * Disables lazy loading (Done to fix embedded posts not loading consistantly) (David Stockdale).
 */ 
add_filter( 'wp_lazy_loading_enabled', '__return_false' );

/**
 * Makes shortcodes function in text widgets (David Stockdale).
 */
add_filter( 'widget_text', 'shortcode_unautop');
add_filter( 'widget_text', 'do_shortcode');

/*
 * Adding support for excerpts on pages (David Stockdale)
 */
add_post_type_support( 'page', 'excerpt' );

/**
 * Adds custom Image Block Style "Squared (Small)" (David Stockdale).
 */
add_action('init', function() {
	$height_and_width = '9.5em';
	$inline_css = '.is-style-square-small img {
	object-fit: cover!important;
	width: '. $height_and_width . '!important; 
	height: ' . $height_and_width . ';!important}';
	register_block_style('core/image', [
		'name' => 'square-small',
		'label' => __('Squared (Small)', 'txtdomain'),
		'inline_style' => $inline_css
	]);
});

/**
 * Adds custom Image Block Style "Squared (Medium)" (David Stockdale).
 */
add_action('init', function() {
	$height_and_width = '15em';
	$inline_css = '.is-style-square-medium img {
	object-fit: cover!important;
	width: '. $height_and_width . '!important; 
	height: ' . $height_and_width . '!important;}';
	register_block_style('core/image', [
		'name' => 'square-medium',
		'label' => __('Squared (Medium)', 'txtdomain'),
		'inline_style' => $inline_css
	]);
});

/**
 * Adds custom Image Block Style "Squared (Large)" (David Stockdale).
 */
add_action('init', function() {
	$height_and_width = '35em';
	$inline_css = '.is-style-square-large img {
	object-fit: cover!important;
	width: '. $height_and_width . '!important; 
	height: ' . $height_and_width . ';!important}';
	register_block_style('core/image', [
		'name' => 'square-large',
		'label' => __('Squared (Large)', 'txtdomain'),
		'inline_style' => $inline_css
	]);
});

/**
 * Adds custom Image Block Style "Squared (Max)" (David Stockdale).
 */
add_action('init', function() {
	$height_and_width = '80em';
	$inline_css = '.is-style-square-maximum img {
	object-fit: cover!important;
	width: '. $height_and_width . '!important; 
	height: ' . $height_and_width . ';!important}';
	register_block_style('core/image', [
		'name' => 'square-maximum',
		'label' => __('Squared (Max)', 'txtdomain'),
		'inline_style' => $inline_css
	]);
});

/**
 * Adds custom Image Block Style "Circle (Small)" (David Stockdale).
 */
add_action('init', function() {
	$height_and_width = '9.5em';
	$inline_css = '.is-style-circle-small img {
	object-fit: cover!important;
	width: '. $height_and_width . '!important; 
	height: ' . $height_and_width . '!important;
	border-radius: 50%!important;
	-moz-border-radius: 50%!important;
	-webkit-border-radius: 50%!important;
	-o-border-radius: 50%!important;
}';
	register_block_style('core/image', [
		'name' => 'circle-small',
		'label' => __('Circled (Small)', 'txtdomain'),
		'inline_style' => $inline_css
	]);
});

/**
 * Adds custom Image Block Style "Circle (Medium)" (David Stockdale).
 */
add_action('init', function() {
	$height_and_width = '15em';
	$inline_css = '.is-style-circle-medium img {
	object-fit: cover!important;
	width: '. $height_and_width . '!important; 
	height: ' . $height_and_width . '!important;
	border-radius: 50%!important;
	-moz-border-radius: 50%!important;
	-webkit-border-radius: 50%!important;
	-o-border-radius: 50%!important;
}';
	register_block_style('core/image', [
		'name' => 'circle-medium',
		'label' => __('Circled (Medium)', 'txtdomain'),
		'inline_style' => $inline_css
	]);
});

/**
 * Adds custom Image Block Style "Circle (Large)" (David Stockdale).
 */
add_action('init', function() {
	$height_and_width = '35em';
	$inline_css = '.is-style-circle-large img {
	object-fit: cover!important;
	width: '. $height_and_width . '!important; 
	height: ' . $height_and_width . '!important;
	border-radius: 50%!important;
	-moz-border-radius: 50%!important;
	-webkit-border-radius: 50%!important;
	-o-border-radius: 50%!important;
}';
	register_block_style('core/image', [
		'name' => 'circle-large',
		'label' => __('Circled (Large)', 'txtdomain'),
		'inline_style' => $inline_css
	]);
});

/**
 * Adds custom Image Block Style "Circle (Max)" (David Stockdale).
 */
add_action('init', function() {
	$height_and_width = '80em';
	$inline_css = '.is-style-circle-maximum img {
	object-fit: cover!important;
	width: '. $height_and_width . '!important; 
	height: ' . $height_and_width . '!important;
	border-radius: 50%!important;
	-moz-border-radius: 50%!important;
	-webkit-border-radius: 50%!important;
	-o-border-radius: 50%!important;
}';
	register_block_style('core/image', [
		'name' => 'circle-maximum',
		'label' => __('Circled (Max)', 'txtdomain'),
		'inline_style' => $inline_css
	]);
});

/**
 * Adds Tags to Pages.
 */
function tags_support_all() {
	register_taxonomy_for_object_type('post_tag', 'page');
}

/**
 * Ensure all tags are included in queries.
 */
function tags_support_query($wp_query) {
	if ($wp_query->get('tag')) $wp_query->set('post_type', 'any');
}

/**
 * Tag hooks.
 */
add_action('init', 'tags_support_all');
add_action('pre_get_posts', 'tags_support_query');

/**
 * Adds Font Awsome (https://slickmedia.co.uk/blog/add-fontawesome-5-to-wordpress/)
 * By David Stockdale
 */
add_action( 'wp_enqueue_scripts', 'wpb_load_fa' );
function wpb_load_fa() {
	wp_register_script( 'FontAwesome', 'https://use.fontawesome.com/releases/v5.14.0/js/all.js', null, null, true );
	wp_enqueue_script('FontAwesome');
}

/**
 * Adds Google Search shortcode.
 * [wp_google_search]
 * to get search key goto: https://cse.google.com/cse/all
 */
add_shortcode( 'wp_google_search', 'search_attempt' );
function search_attempt(){
?>
<div class="thing">
	<div class="uk-container uk-container-center">
		<script async src="https://cse.google.com/cse.js?cx=INSERT YOUR GOOGLE SEARCH KEY HERE"></script>
		<div class="gcse-search"></div>
	</div>
</div>
<?php
}

/**
 * Adds additional menu locations.
 */
add_action( 'init', 'register_childtheme_menus' );
function register_childtheme_menus() {
	register_nav_menu('secondary', __( 'Secondary Menu', 'child-theme-textdomain' ));
}














/**
 * Registers the "banner" widget area (David Stockdale).
 */
add_action( 'widgets_init', 'banner_widgets_init' );
function banner_widgets_init() {
	register_sidebar( array(
		'id'            => 'banner',
		'name'          => __( 'Banner', 'understrap' ),
		'description'   => __( 'Widgets in this area will be shown on the cookies and consents banner that pops up when you first view the site.', 'understrap' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
}



/**
 * Filter inserts Polly Toggle Shortcode before content.
 */
add_filter( 'the_content', 'updated_page_content' );
function updated_page_content( $content )
{
	//Add pages that shouldn't have polly toggle to this array
	if ( is_page( array( 'search_gcse' ) ) ) {
		return $content;
	} else {
		return '<div class="polly"><p>[showhide type=”polly” more_text=Text-To-Speech less_text=Hide][/showhide]</p></div>' . $content;
	}
}










add_shortcode( 'david_pager', 'david_pager_shortcode' );

/**
 * Gets all recent pages with a specific parent page.
 * If there is only 1 page it will be given the header "Current".
 * If there is 2 pages ther will be given the headers "Current" and "Past".
 * If there is 3 pages ther will be given the headers "Future", "Current" and "Past".
 * 
 * Parent: [david_pager parent=580]
 * Default orientation is horizontal!
 * Vertical: [david_pager parent=580 vertical=true]
 * (Programme = 580)
 * 
 * To disable "Future" header add "future=false" like this:
 * [david_pager parent=580 future=false]
 * To disable "Current" header add "current=false" like this:
 * [david_pager parent=580 current=false]
 * To disable "Past" header add "past=false" like this:
 * [david_pager past=580 current=false]
 */
function david_pager_shortcode($atts) {
	if (!(isset($atts['vertical']->a)) && !empty($atts['vertical'])) {
		if($atts['vertical'] == "true") {
			$vertical = true;
		}
	} else {
		$vertical = false;
	}
	if($vertical) {
		$parent = $atts['parent'];
		//Get recent Programme child pages
		$mypages = get_pages( 
			array( 
				'number' => 10, //Number of pages to show
				'child_of' => $parent, //Parent page ID (Programme = 580)
				'sort_column' => 'post_date', //Sort by date posted
				'sort_order' => 'desc' //Decending order
			) 
		);

		$ressy = '<div class="row" 
		style="
			overflow-y: scroll;
			height: 270px;
			flex-direction: row;
			flex-flow: column;
			margin-right: 0px;
			margin-left: 0px;
			">
			<div class="thing">';

		$pagesleft =  count($mypages);

		if($pagesleft == 0) {
			$ressy .= '</div></div>';
			return $ressy;
		}

		$headed = false;
		
		if (!(isset($atts['current']->a)) && !empty($atts['current'])) {
				if($atts['current'] == "false") {
					$cheaded = true;
				} else {
					$cheaded = false;
				}
			} else {
				$cheaded = false;
			}
		
		//If only 1 page
		if($pagesleft == 1 && !$cheaded) {
			$ressy .= '<h2>Current</h2>';
			$headed = true;
			$cheaded = true;
		}
		
		if (!(isset($atts['future']->a)) && !empty($atts['future'])) {
			if($atts['future'] == "false") {
				$fheaded = true;
			} else {
				$cheaded = false;
			}
		} else {
			$fheaded = false;
		}
		
		if (!(isset($atts['past']->a)) && !empty($atts['past'])) {
				if($atts['past'] == "false") {
					$pheaded = true;
				} else {
					$pheaded = false;
				}
			} else {
				$pheaded = false;
			}
		
		$thinged = true;

		foreach( $mypages as $page ) {  
			if(!$thinged) {
				$ressy .= '<div class="thing">';
			}
			
			$thinged = false;
			
			if(!$headed) {
				//If 3 or more pages
				if($pagesleft >= 3 && !$fheaded) {
					$ressy .= '<h2>Future</h2>';
					$fheaded = true;
				} else if($pagesleft >= 2 && !$cheaded) {
					//If 2 or more pages
					$ressy .= '<h2>Current</h2>';
					$cheaded = true;
				} else if($pagesleft >= 1 && !$pheaded) {
					$ressy .= '<h2>Past</h2>';
					$pheaded = true;
					$headed = true;
				}
				$pagesleft -= 1;
			}

			//Get the excerpt
			$excerpt = $page->post_excerpt;
			$excerpt = apply_filters( 'the_excerpt', $excerpt );

				$ressy .= '<div class="lil-posts"">
				<h3>
					<a href="' .  get_page_link( $page->ID ) . '">
						' .  $page->post_title . '
					</a>
				</h3>
				<div class="d-flex flex-row"> 
					' .  get_the_post_thumbnail( $page->ID, 'thumbnail' ) . '
					<div class="excerpt flex-grow-1">
						' .  $excerpt . '
					</div>
				</div>
				</div>';

			$ressy .= '</div>';
		}   
		$ressy .= '</div>';
		return $ressy;
	} else {
		$parent = $atts['parent'];
		//Get recent Programme child pages
		$mypages = get_pages( 
			array( 
				'number' => 10, //Number of pages to show
				'child_of' => $parent, //Parent page ID (Programme = 580)
				'sort_column' => 'post_date', //Sort by date posted
				'sort_order' => 'desc' //Decending order
			) 
		);

		$ressy = '<div class="row" 
		style="
			overflow-x: scroll;
			height: 270px;
			flex-direction: column;
			flex-flow: row;
			margin-right: 0px;
			margin-left: 0px;
			">
			';
		
		

		$pagesleft =  count($mypages);

		if($pagesleft == 0) {
			$ressy .= '</div></div>';
			return $ressy;
		}

		$headed = false;
		
		if (!(isset($atts['current']->a)) && !empty($atts['current'])) {
				if($atts['current'] == "false") {
					$cheaded = true;
				} else {
					$cheaded = false;
				}
			} else {
				$cheaded = false;
			}
		
		//If only 1 page
		if($pagesleft == 1 && !$cheaded) {
			$ressy .= '<h2>Current</h2>';
			$headed = true;
			$cheaded = true;
		}
		
		if (!(isset($atts['future']->a)) && !empty($atts['future'])) {
			if($atts['future'] == "false") {
				$fheaded = true;
			} else {
				$cheaded = false;
			}
		} else {
			$fheaded = false;
		}
		
		if (!(isset($atts['past']->a)) && !empty($atts['past'])) {
				if($atts['past'] == "false") {
					$pheaded = true;
				} else {
					$pheaded = false;
				}
			} else {
				$pheaded = false;
			}
		
		$thinged = true;
		
		if($fheaded && $cheaded && $pheaded) {
					$ressy .= '<div class="thing" style="margin-top: 38px;">';
				} else {
					$ressy .= '<div class="thing">';
				}
		
		foreach( $mypages as $page ) {  
			if(!$thinged) {
				if($fheaded && $cheaded && $pheaded || ($pagesleft <= 2 && ($cheaded && $pheaded))) {
					$ressy .= '<div class="thing" style="margin-top: 38px;">';
				} else {
					$ressy .= '<div class="thing">';
				}
			}
			$thinged = false;

			if(!$headed) {
				//If 3 or more pages
				if($pagesleft >= 3 && !$fheaded) {
					$ressy .= '<h2>Future</h2>';
					$fheaded = true;
				} else if($pagesleft >= 2 && !$cheaded) {
					//If 2 or more pages
					$ressy .= '<h2>Current</h2>';
					$cheaded = true;
				} else if($pagesleft >= 1 && !$pheaded) {
					$ressy .= '<h2>Past</h2>';
					$pheaded = true;
					$headed = true;
				}
				$pagesleft -= 1;
			}

			//Get the excerpt
			$excerpt = $page->post_excerpt;
			$excerpt = apply_filters( 'the_excerpt', $excerpt );

				$ressy .= '<div class="lil-posts" style="width:430px;">
				<h3>
					<a href="' .  get_page_link( $page->ID ) . '">
						' .  $page->post_title . '
					</a>
				</h3>
				<div class="d-flex flex-row"> 
					' .  get_the_post_thumbnail( $page->ID, 'thumbnail' ) . '
					<div class="excerpt flex-grow-1">
						' .  $excerpt . '
					</div>
				</div>
				</div>';

			$ressy .= '</div>';
		}   
		$ressy .= '</div>';
		return $ressy;
	}
}







/**
 * Adds shortcode (David Stockdale).
 */
add_shortcode('david_streamer', 'david_streamer_shortcode');
/**
 * Creates a hidden twitch stream (David Stockdale).
 * ----------Shortcode Use Examples---------- 
 * Channel: [david_streamer channel="tru3ta1ent"]
 * Channel + Chat : [david_streamer channel="tru3ta1ent" chat="true"]
 */
function david_streamer_shortcode($atts) {
	$header= $atts['header'];
	
	/**
	 * Header level (optional) defaults to 2.
	 */
	if (!(isset($atts['channel']->a)) && !empty($atts['channel'])) {
		$channel = $atts['channel'];
		
		
		if (!(isset($atts['chat']->a)) && !empty($atts['chat'])) {
		$chat = $atts['chat'];
			$result = '<div class="hiddentwitch" style="height: fit-content;
    width: -webkit-fill-available;
    display: inline-block;">
		<html>
		<head>
		  <style>
			.hide { display:none; }

			/* Optional: The following css just makes sure the twitch video stays responsive */
			#twitch {
			  position: relative;
			  padding-bottom: 56.25%; /* 16:9 */
			  padding-top: 25px;
			  height: 0;
			}
			#twitch object, #twitch iframe {
			  display: inline-block;
			  width:70%;
			  max-height: 500px;
			}
			</style>
		</head>

		<body>

		  <script src= "https://player.twitch.tv/js/embed/v1.js"></script>

		  <div id="twitch" class="hide">
		  
		  <div class="hiddenchat" style=" display: inline-block;     height: 100%;
    width: 29%;
	float: right;
">
		  <iframe id="chat_embed" src="https://www.twitch.tv/embed/tru3ta1ent/chat?parent=redcarpalace.org.uk" style="position: unset; 
		  width: 100%;
    min-height: 500px;">
</iframe>
</div>

		  </div>

		  <script type="text/javascript">
			var options = {
			  channel: "'. $channel .'",
			  width: 500,
			  height: 620,
			};
			var player = new Twitch.Player("twitch", options);

			player.addEventListener(Twitch.Player.READY, initiate)

			function initiate() {
			  player.addEventListener(Twitch.Player.ONLINE, handleOnline);
			  player.addEventListener(Twitch.Player.OFFLINE, handleOffline);
			  player.removeEventListener(Twitch.Player.READY, initiate);
			}

			function handleOnline() {
			  document.getElementById("twitch").classList.remove("hide");
			  player.removeEventListener(Twitch.Player.ONLINE, handleOnline);
			  player.addEventListener(Twitch.Player.OFFLINE, handleOffline);
			  player.setMuted(false);
			}

			function handleOffline() {
			  document.getElementById("twitch").classList.add("hide");
			  player.removeEventListener(Twitch.Player.OFFLINE, handleOffline);
			  player.addEventListener(Twitch.Player.ONLINE, handleOnline);
			  player.setMuted(true);
			}
		  </script>

		</body>
		</html>
		</div>';
			
		} else {
			$result = '<div class="hiddentwitch">
		<html>
		<head>
		  <style>
			.hide { display:none; }

			/* Optional: The following css just makes sure the twitch video stays responsive */
			#twitch {
			  position: relative;
			  padding-bottom: 56.25%; /* 16:9 */
			  padding-top: 25px;
			  height: 0;
			}
			#twitch object, #twitch iframe {
			  position: absolute;
			  top: 0;
			  left: 0;
			  width: 100%;
			  height: 100%;
			}
			</style>
		</head>

		<body>

		  <script src= "https://player.twitch.tv/js/embed/v1.js"></script>

		  <div id="twitch" class="hide">
		  </div>

		  <script type="text/javascript">
			var options = {
			  channel: "'. $channel .'",
			  width: 500,
			  height: 620,
			};
			var player = new Twitch.Player("twitch", options);

			player.addEventListener(Twitch.Player.READY, initiate)

			function initiate() {
			  player.addEventListener(Twitch.Player.ONLINE, handleOnline);
			  player.addEventListener(Twitch.Player.OFFLINE, handleOffline);
			  player.removeEventListener(Twitch.Player.READY, initiate);
			}

			function handleOnline() {
			  document.getElementById("twitch").classList.remove("hide");
			  player.removeEventListener(Twitch.Player.ONLINE, handleOnline);
			  player.addEventListener(Twitch.Player.OFFLINE, handleOffline);
			  player.setMuted(false);
			}

			function handleOffline() {
			  document.getElementById("twitch").classList.add("hide");
			  player.removeEventListener(Twitch.Player.OFFLINE, handleOffline);
			  player.addEventListener(Twitch.Player.ONLINE, handleOnline);
			  player.setMuted(true);
			}
		  </script>

		</body>
		</html>
		</div>';
		}
		
		

	} else {
		$result ='';
	}

	 return $result;
}


/**
 * Prevents any image with the class "attatchment" from loading.
 * (Fixes Jetpack Lazy Loading leaving embedded post images forever unloaded).
 */
add_filter( 'jetpack_lazy_images_blocked_classes', 'mysite_customize_lazy_images' );
function mysite_customize_lazy_images( $blocked_classes ) {
    $blocked_classes[] = 'embeddy';
    return $blocked_classes;
}
