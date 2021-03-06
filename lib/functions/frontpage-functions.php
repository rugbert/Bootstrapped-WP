<?php

function get_frontpage_settings(){


    $site_options = get_option('bswp_site_settings');
    $layout_settings = $site_options['layouts'];
    $sidebars = $layout_settings['sidebars'];

    $sidebar = json_decode($sidebars['frontpage_widgets']);
    $sidebar_pos = $sidebar->position;
    $sidebar_vis = $sidebar->visibility;


    $components = $layout_settings['frontpage']['frontpage_layout_sortable'];
    $components = json_decode($components);
    $main_width = ($sidebar_pos == 'left' || $sidebar_pos == 'right') ? 'span9' : 'span12';

    return array(
        'components' => $components,
        'sidebar_vis' => $sidebar_vis,
        'sidebar_pos' => $sidebar_pos,
        'main_width' => $main_width,
    );
}
/* --------------------------------------------------------------------
			Widget Areas
 -------------------------------------------------------------------- */
function frontpage_widgets_1_callback($visibility){

	echo '<div class="row '.$visibility.' frontpage-component">';
		dynamic_sidebar('frontpage_widgets_1');
	echo '</div>';
}

function frontpage_widgets_2_callback($visibility){
	echo '<div class="row '.$visibility.' frontpage-component">';
		dynamic_sidebar('frontpage_widgets_2');
	echo '</div>';
}

function frontpage_widgets_3_callback($visibility){
	echo '<div class="row '.$visibility.' frontpage-component">';
		dynamic_sidebar('frontpage_widgets_3');
	echo '</div>';
}

/* --------------------------------------------------------------------
			Default Content
 -------------------------------------------------------------------- */
function frontpage_content($visibility){



    $front_page = new Content();

	echo '<div class="'.$visibility.' frontpage-component">';

	if (have_posts()){

		if($pagination_top == 'true'){
			echo new Pagination();
		}


		echo '<div class="content-list">';

		while(have_posts()){

			the_post();
			echo $front_page->kjd_the_content_wrapper();
		}

		echo '</div>';
	}
	echo new Pagination();

	echo '</div>';
}


/* -----------------------------------------------------------------
		Choose layout
------------------------------------------------------------------- */
function kjd_front_page_layout( $components ){

    ob_start();
	foreach($components as $position => $component)
	{

        $name = $component->name;
        $visibility = $component->visibility;
        $visibility = $visibility == 'all' ? '' : str_replace('_','-',$visibility);
        
		switch( $name ):
			case 'frontpage_widgets_1':
				frontpage_widgets_1_callback($visibility);
				break;
			case 'frontpage_widgets_2':
				frontpage_widgets_2_callback($visibility);
				break;
			case 'frontpage_widgets_3':
				frontpage_widgets_3_callback($visibility);
				break;
			case 'page_content':
				frontpage_content($visibility);
				break;
            default:
                frontpage_content($visibility);
                break;
		endswitch;

	}
    $contents = ob_get_contents();
    ob_end_clean();

    return $contents;
}



function default_frontpage() {
    ob_start();
    ?>

    <div class="jumbotron">
        <h1>Please set up your front page!</h1>
        <p>And this ugly message goes away</p>
            <p>
            <a href="<?php echo admin_url('admin.php?page=bswp_settings'); ?>"
            class="btn btn-warning btn-large">
                Go to your dashboard
            </a>
        </p>
    </div>

    <?php
    $contents = ob_get_contents();
    ob_end_clean();

    return $contents;
}
