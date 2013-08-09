<!DOCTYPE html>
<html <?php language_attributes(); ?> style="margin-top:0 !important;">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width" />
	<title>
	<?php
	global $page, $paged;

	wp_title( '|', true, 'right' );

	// Add the blog name.
	bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		echo " | $site_description";

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		echo ' | ' . sprintf( __( 'Page %s', 'page' ), max( $paged, $page ) );

	?>
	</title>
<?php

	$themeSettings = get_option('kjd_theme_settings');
	$logo = $themeSettings['kjd_site_logo'];	
	$confinePage = $themeSettings['kjd_confine_page'];
	$responsiveDesign = $themeSettings['kjd_responsive_design'];

	$headerSettings = get_option('kjd_header_misc_settings');
	$headerSettings = $headerSettings['kjd_header_misc'];
	$confineHeaderBackground = $headerSettings['kjd_header_confine_background'];

	$options = get_option('kjd_navbar_misc_settings');
	$navbarSettings = $options['kjd_navbar_misc'];
	$alignNavWithLogo = $navbarSettings['kjd_navbar_pull_up'];
	$sideNav = $navbarSettings['side_nav'];

	$useMast = $headerSettings['use_mast'];
	$useLogo = $headerSettings['use_logo'];

	$options = get_option('kjd_mastArea_background_settings');
	$options = $options['kjd_mastArea_background_misc'];
	$confineMast = $options['confine_mast'];

	$contentAreaSettings = get_option('kjd_contentArea_background_settings');
	$confinecontentArea = $contentAreaSettings['kjd_contentArea_background']['confine_contentArea'];

	if(is_front_page() ) { 

		$hideHeader = $headerSettings['hide_header'];

		$footerSettings = get_option('kjd_footer_misc_settings');
		$footerSettings = $footerSettings['kjd_footer_misc'];
		$hideFooter = $themeOptions['hide_footer'];

		if($hideHeader == 'frontpage' || $hideHeader =='all' ){
			$output = '<style>';
				$output .= '#header{display:none;}';
			$output .=  "</style>";
		}
		echo $output;

		if($hideFooter == 'frontpage' ||$hideFooter == 'frontpage'){
			$output = "<style>";
				$output .= "#pageWrapper{margin:0 auto !important;}";
				$output .= "#footer,#push{display:none;}";
			$output .=  "</style>";
		}
			
		echo $output;

	}



 if ( is_user_logged_in() ) { 
 	echo '<style>body{padding-top:28px !important;}</style>';
  }

	$navbar .= dirname(__FILE__).'/lib/partials/navbar_scaffolding.php';

  	wp_head();
?>
</head>

<body>
	<?php if($sideNav =='true'): ?>
		<div id="sidr">
			<?php wp_nav_menu(array('theme_location' => 'sidr-menu' ) ); ?>
		</div>	
	<?php endif; ?>

<div id="pageWrapper">
	<div id="mastArea" class="<?php echo $confineMast == 'true' ? 'container' : '' ;?>">
		<?php
			if( $navbarSettings['navbar_style'] =='page-top' && $alignNavWithLogo !='true'){
				include($navbar); 	
			}
		?>

			<div id="header" class="<?php echo $confineHeaderBackground =='true' ? 'container confined' : '' ;?>">
				<div class="container">
					<div class="row">
					<?php if($headerSettings['header_contents'] == 'widgets'){ 

						dynamic_sidebar('header_widgets');
					
					}else{ ?>

						<a id="logoWrapper" href="<?php bloginfo('url'); ?>">
							<img src="<?php echo $logo; ?>" alt=""/>
						</a>
						<?php 
						if( $alignNavWithLogo =='true'){ 
							include($navbar); 	
						}
						?>

					<?php } ?>

					</div> <!-- end row -->
				</div><!-- end header container -->

			</div> <!-- end header area -->

	<?php
		if( $navbarSettings['navbar_style'] !='page-top' && $alignNavWithLogo !='true'){
			include($navbar); 	
		}
	?>
	</div> <!-- end mast -->
