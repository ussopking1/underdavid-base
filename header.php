<?php
/**
 * The header for our theme
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package Understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$container = get_theme_mod( 'understrap_container_type' );
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?> <?php understrap_body_attributes(); ?>>
<?php do_action( 'wp_body_open' ); ?>
<div class="site" id="page">
<!-- banner -->
<?php
  if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar('banner') )
?>
	<!-- ******************* The Navbar Area ******************* -->
	
	
	
	<div id="wrapper-navbar" itemscope itemtype="http://schema.org/WebSite">
		<a class="skip-link sr-only sr-only-focusable" href="#content"><?php esc_html_e( 'Skip to content', 'understrap' ); ?></a>
		<nav class="navbar navbar-expand-md navbar-dark bg-primary">
			<div class="container">
				<div class="col-md-5">
<!-- 				PRIMARY MENU (Collapsable) -->
				<?php wp_nav_menu(
	array(
		'theme_location'  => 'primary',
		'container_class' => 'collapse navbar-collapse',
		'container_id'    => 'navbarNavDropdown',
		'menu_class'      => 'navbar-nav mx-auto',
		'fallback_cb'     => '',
		'menu_id'         => 'main-menu',
		'depth'           => 3,
		'walker'          => new Understrap_WP_Bootstrap_Navwalker(),
	)
); ?>
<!-- 				PRIMARY MENU (Collapsable) -->
				
<!-- 				PRIMARY MENU (Non Collapsable) -->
<!-- 				<?php wp_nav_menu(
	array(
		'theme_location'  => 'primary',
		'container_class' => 'container',
		'container_id'    => 'horizontalMenu',
		'menu_class'      => 'navbar-nav mx-auto',
		'fallback_cb'     => '',
		'menu_id'         => 'main-menu',
		'depth'           => 2,
		'walker'          => new Understrap_WP_Bootstrap_Navwalker(),
	)
); ?> -->
<!-- 				PRIMARY MENU (Non Collapsable) -->
				</div>
			
		
			
		
			
			<div class="col-md-2">
				<!-- Your site title as branding in the menu -->
				<?php if ( ! has_custom_logo() ) { ?>
				<?php if ( is_front_page() && is_home() ) : ?>
				<h1 class="navbar-brand mb-0">
					<a rel="home" href="<?php echo esc_url( home_url( '/' ) ); ?>" 
					   title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" 
					   itemprop="url">
																						
<!-- 						NORMAL AUTOMATIC SITE TITLE -->
						
						<?php bloginfo( 'name' ); ?>
						
<!-- 						NORMAL AUTOMATIC SITE TITLE END -->
						
<!-- 						CUSTOM STYLE FOR SPECIFIC WORDS SITE TITLE -->
						
<!-- 						<span class="titles"><span class="title1">tees valley </span><span class="title2">arts</span></span> -->
						
<!-- 						CUSTOM STYLE FOR SPECIFIC WORDS SITE TITLE END -->
						
					</a></h1>
				<?php else : ?>
				<a class="navbar-brand" rel="home" 
				   href="<?php echo esc_url( home_url( '/' ) ); ?>" 
				   title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" 
				   itemprop="url">
																											
<!-- 						NORMAL AUTOMATIC SITE TITLE -->
						
						<?php bloginfo( 'name' ); ?>
						
<!-- 						NORMAL AUTOMATIC SITE TITLE END -->
						
<!-- 						CUSTOM STYLE FOR SPECIFIC WORDS SITE TITLE -->
						
<!-- 						<span class="titles"><span class="title1">tees valley </span><span class="title2">arts</span></span> -->
						
<!-- 						CUSTOM STYLE FOR SPECIFIC WORDS SITE TITLE END -->
						
				</a>
				<?php endif; ?>
				<?php } 
				else {
					the_custom_logo();
				} ?>
				<!-- end custom logo -->
			</div>
			
<!-- 			SOCIAL MEDIA ICONS HERE -->

				<div class="col-md-5">
					<ul class="socialiconz">
<!-- 						DEFAULT SEARCH (REQUIRES GOOGLE SEARCH KEY TO BE ADDED INT FUNCTIONS) -->
						<li class="ssi-search">
							<a href='/search_gcse'>
								<i class="fas fa-search">
								</i>
							</a>
						</li>
<!-- 						DEFAULT SEARCH END -->
						
<!-- 						BLANK PLACEHOLDERS -->
						<!--FACEBOOK-->
						<li class="ssi-facebook">
							<a href='https://fb.com/'>
								<i class="fab fa-facebook">
								</i>
							</a>
						</li>
						<!--FACEBOOK END-->
						<!--INSTAGRAM-->
						<li class="ssi-instagram">
							<a href='https://instagram.com/'>
								<i class="fab fa-instagram">
								</i>
							</a>
						</li>
						<!--INSTAGRAM END-->
						<!--TWITTER-->
						<li class="ssi-twitter">
							<a href='https://twitter.com/'>
								<i class="fab fa-twitter">
								</i>
							</a>
						</li>
						<!--TWITTER END-->
						<!--YOUTUBE-->
						<li class="ssi-youtube">
							<a href='https://www.youtube.com/'>
								<i class="fab fa-youtube">
								</i>
							</a>
						</li>
						<!--YOUTUBE END-->
						<!--LINKEDIN-->
						<li class="ssi-linkedin">
							<a href='https://www.linkedin.com/'>
								<i class="fab fa-linkedin">
								</i>
							</a>
						</li>
						<!--LINKEDIN END-->
						<!--PINTEREST-->
						<li class="ssi-pinterest">
							<a href='https://www.pinterest.co.uk/'>
								<i class="fab fa-pinterest">
								</i>
							</a>
						</li>
						<!--PINTEREST END-->
<!-- 						BLANK PLACEHOLDERS END -->
					</ul>
				</div>
			
<!-- 			SOCIAL MEDIA ICONS END -->
			
</div>
		</nav><!-- .site-navigation -->
			
	</div><!-- #wrapper-navbar end -->
	
	
	
	
<!-- 	NAVBAR TOGGLER -->
	<nav class="navbar2 navbar-expand-md navbar-dark bg-primary">
		<div class="d-flex justify-content-center flex-grow-1">
			
<!-- 			FROM NEW UNDERSTRAP -->
			
			<button class="navbar-toggler"
					type="button"
					data-bs-toggle="collapse"
					data-bs-target="#navbarNavDropdown"
					aria-controls="navbarNavDropdown"
					aria-expanded="false"
					aria-label="<?php esc_attr_e( 'Toggle navigation', 'understrap' ); ?>">
			<span class="navbar-toggler-icon"></span>
			</button>
		</div>
	</nav>
<!-- 	NAVBAR TOGGLER -->
	

	