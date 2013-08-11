<?php 

$navbarSettings = get_option('kjd_navbar_misc_settings');
$navSettings = $navbarSettings['kjd_navbar_misc'];
$sideNav = $navSettings['side_nav'];
$root=get_stylesheet_directory_uri(); 

	
	
$navbarSettings = $navbarSettings['kjd_navbar_misc'];
$navbarLinkStyle = $navbarSettings['navbar_link_style'];
$form = $navbarSetting['form_type'];

$confineNavbarBackground = $navbarSettings['kjd_navbar_confine_background'];

	if($navbarSettings['hideNav'] != "true"){
		
		$nav_wrapper ='';
		
		switch( $navbarSettings['navbar_style'] ){
			
			case 'full_width':
				$navbar_style .= 'navbar navbar-static-top';
				break ;

			case 'contained':
				$navbar_style .= 'container';
				$nav_wrapper ='<div class="navbar">';
				break ;

			case 'sticky-top':
				$navbar_style .= 'navbar navbar-fixed-top';
				break ;
		
			case 'sticky-bottom':
				$navbar_style .= 'navbar navbar-fixed-bottom';
				break ;
		
			case 'page-top':
				$navbar_style .= 'navbar navbar-static-top';
				break ;
		
		default:
				$navbar_style .= 'navbar navbar-static-top';
				break ;
		}

		$navbar_open = '<div id="navbar" class="'. $navbar_style . '">';
		$navbar_open .= $nav_wrapper;

		$navbar_inner = '';
			$navbar_inner .= '<div class="navbar-inner">';

			if( $navbar_style != 'contained' ){
				$navbar_inner .= '<div class="container">';
			}
			
			if($sideNav == 'true'){
				$navbar_inner .= '<a id="sidr-toggle" class="btn btn-navbar">
				    <span class="icon-bar"></span>
				    <span class="icon-bar"></span>
					<span class="icon-bar"></span>
					</a>';
			}else{
				$navbar_inner .= '<a data-target=".navbar-responsive-collapse" data-toggle="collapse" class="btn btn-navbar">
				    <span class="icon-bar"></span>
				    <span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</a>';
			}
				
					$navbar_inner .='<div class="nav-collapse collapse navbar-responsive-collapse">';
						ob_start();
						menuStyleCallback($navbarLinkStyle);
						$navbar_contents = ob_get_contents();
						ob_end_clean();
					$navbar_inner .= $navbar_contents;
					$navbar_inner .= '</div>';
				
				if( $navbar_style != 'contained' ){
					$navbar_inner .='</div>'; // end container -->
				}

			$navbar_inner .='</div>'; // end navbar-inner-->



		if($navbarSettings['navbar_style'] =="contained"){
			$navbar_close = '</div></div>';
		}else{
			$navbar_close = '</div>';
		} 
	}

echo $navbar_open . $navbar_inner . $navbar_close; 