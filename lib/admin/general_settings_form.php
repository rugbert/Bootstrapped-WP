<?php

function kjd_theme_settings_display(){  
screen_icon('themes'); ?> 

<h2>Theme Settings</h2>

<?php

	if( isset( $_GET[ 'tab' ] ) ) {  
	 $active_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : 'home'; 
	}else{
	 $active_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : 'home'; 
	}
?> 

<h2 class="nav-tab-wrapper">  
	<a href="?page=kjd_theme_settings&tab=home" class="nav-tab"<?php echo $active_tab == 'home' ? 'id="active"' : 'none'; ?>>Home</a>  	
	<a href="?page=kjd_theme_settings&tab=settings" class="nav-tab"<?php echo $active_tab == 'settings' ? 'id="active"' : 'none'; ?>>General Settings </a>  	
	<a href="?page=kjd_theme_settings&tab=components" class="nav-tab"<?php echo $active_tab == 'components' ? 'id="active"' : 'none'; ?>>Components</a>
</h2>

    <?php settings_errors(); ?>  
	  
		<?php 
			if( $active_tab == 'home' ) { 
				kjd_theme_home_callback();
			}else{
				echo '<form method="post" action="options.php"> ';
				if( $active_tab == 'settings' ) { 
					kjd_theme_settings_callback();
				}elseif( $active_tab == 'components' ) { 
					kjd_theme_components_callback();
				}

				submit_button(); 
				wp_enqueue_media();
				echo '</form>';
			}
		?>  
	

<?php
}
function kjd_theme_home_callback(){
	include('functions/kjd_export_settings.php'); 
?>
	<div class="optionsWrapper">
		<h3>What do you want to style?</h3>
		<div class="option">
			<ul class="unstyled">


			</ul>
		</div>
	</div>




	<div class="optionsWrapper">
		<h3>Export your settings</h3>
		<div class="option">
			<?php kjd_get_settings(); ?>
			<!-- <a class='export-xml' href='#' >Export database as XML</a> -->
		</div>
	</div>


	<div class="optionsWrapper">
		<h3>Import a style file.</h3>
		<div class="option">
			<label for="file">Filename:</label>
			<input type="file" name="file" id="file">
			<!-- <a class='export-xml' href='#' >Export database as XML</a> -->
		</div>
	</div>

<?php
}
////////////////////
// theme settings
////////////////////
function kjd_theme_settings_callback(){

	settings_fields( 'kjd_theme_settings' ); 
	$options = get_option('kjd_theme_settings');
?>
<!-- upload logo -->


	<div class="optionsWrapper">
		<h3>Logo</h3>
		<div class="option">

			<label>Upload your site logo</label>

			<input type="text" class="media_input" name="kjd_theme_settings[kjd_site_logo]" value="<?php echo $options['kjd_site_logo'] ? $options['kjd_site_logo'] : ' '; ?>" />  
		  	<input type="button" class="button upload_image" value="Upload image" />  

			<div class="image_preview">  
			<?php if( !empty($options['kjd_site_logo']) ){
		      echo '<img src="'.esc_url( $options['kjd_site_logo'] ).'" /> ';
			} ?>
		  </div> 
		</div>

		<div class="option">
			<label>Toggle site title</label>

			<select name="kjd_theme_settings[kjd_logo_toggle]">
				<option value="logo" <?php selected( $options['kjd_logo_toggle'], "logo", true) ?>>Logo</option>
				<option value="text" <?php selected( $options['kjd_logo_toggle'], "text", true) ?>>Custom</option>
				<option value="title" <?php selected( $options['kjd_logo_toggle'], "title", true) ?>>Site Title</option>
			</select>

		</div>

	<div class="option">
		<label>Custom Header</label>
		<?php 

		wp_editor( $options['kjd_custom_header'], 'kjd_theme_settings[kjd_custom_header]', array( 'textarea_rows' =>1 ) 
		);?>
	</div>

	<div class="option">

		<label>Upload favicon</label>
		<input type="text" class="media_input" name="kjd_theme_settings[kjd_favicon]" value="<?php echo $options['kjd_favicon'] ? $options['kjd_favicon'] : ' '; ?>" />  
	  <input type="button" class="button upload_image" value="Upload image" />  

		<div class="image_preview" style="min-height: 100px; clear:both;">  
	      <img style="max-width:100%;" src="<?php echo esc_url( $options['kjd_favicon'] ); ?>" />  
	  </div> 
	</div>


	<div class="option">
		<label>Google Analytics</label>
		<textarea class="long_textarea" name="kjd_theme_settings[kjd_google_analytics]"><?php echo $options['kjd_google_analytics']? $options['kjd_google_analytics']: '' ;?></textarea>
	</div>




<!-- confine page to 960px -->
	<div class="option">
		<label>Use Responsive design</label>

		<select class="toggleDisplaySwitch" name="kjd_theme_settings[kjd_responsive_design]">
			<option value="true" <?php selected( $options['kjd_responsive_design'], "true", true) ?>>Yes</option>
			<option value="false" <?php selected( $options['kjd_responsive_design'], "false", true) ?>>No</option>
		</select>

	</div>

	<div class="toggleDisplay">
		<div id="confineOption" class="option">
			<label>Confine ALL backgrounds 960px wide</label>

			<select name="kjd_theme_settings[kjd_confine_page]">
				<option value="true" <?php selected( $options['kjd_confine_page'], "true", true) ?>>Yes</option>
				<option value="false" <?php selected( $options['kjd_confine_page'], "false", true) ?>>No</option>
			</select>

		</div>

		<div id="boxShadow" class="option">
			<label>Add Shadow to page wrapper?</label>

			<select name="kjd_theme_settings[kjd_box_shadow]">
				<option value="true" <?php selected( $options['kjd_box_shadow'], "true", true) ?>>Yes</option>
				<option value="false" <?php selected( $options['kjd_box_shadow'], "false", true) ?>>No</option>
			</select>

		</div>	
	</div>	

</div>	

	<div class="option">
		<label>404 Page Content</label>
			<?php wp_editor( $options['kjd_404_page'], 'kjd_theme_settings[kjd_404_page]' );?>
	</div>

<?php
}

function kjd_theme_components_callback(){

	settings_fields( 'kjd_component_settings' ); 
	$options = get_option('kjd_component_settings');
	// echo $options['featured_image']['width'] ? $options['featured_image']['width'] : 300 ;
	// echo $options['featured_image']['height'] ? $options['featured_image']['height'] : 300 ;

?>
<div class="options_wrapper">

	<div class="option">
		<label>Style widgets?</label>
		<select name="kjd_component_settings[style_widgets]">
			<option value="false" <?php selected( $options['style_widgets'], 'false', true ) ?>>No</option>
			<option value="true" <?php selected( $options['style_widgets'], 'true', true) ?>>Yes</option>
		</select>
	</div>	

	<div class="option">
		<label>Style image cycler section?</label>
		<select name="kjd_component_settings[style_image_cycler_section]">
			<option value="false" <?php selected( $options['style_image_cycler_section'], 'false', true ) ?>>No</option>
			<option value="true" <?php selected( $options['style_image_cycler_section'], 'true', true) ?>>Yes</option>
		</select>
	</div>		

	<div class="option">
		<label>Featured Image Size</label>
		
		<div class="margin-label"><span>Height</span>
		<input name="kjd_component_settings[featured_image][height]" 
			value="<?php echo $options['featured_image']['height'] ? $options['featured_image']['height'] : ''; ?>"
			style="width:40px;"/>px.
		</div>

		<div class="margin-label"><span>Width</span>
		<input name="kjd_component_settings[featured_image][width]" 
			value="<?php echo $options['featured_image']['width'] ? $options['featured_image']['width'] : ''; ?>"
			style="width:40px;"/>px.
		</div>

		<div class="margin-label"><span>Hard Crop?</span>
			<select name="kjd_component_settings[featured_image][crop]">
				<option value="false" <?php selected( $options['featured_image']['crop'], 'false', true ) ?>>No</option>
				<option value="true" <?php selected( $options['featured_image']['crop'], 'true', true) ?>>Yes</option>
			</select>
		</div>
	</div>

	<div class="option">
		<label>Allow Commenting?</label>
		<select name="kjd_component_settings[allow_comments]">
			<option value="false" <?php selected( $options['allow_comments'], 'false', true ) ?>>No</option>
			<option value="true" <?php selected( $options['allow_comments'], 'true', true) ?>>Yes</option>
		</select>
	</div>	

</div>

<?php
}

function kjd_theme_widget_areas_callback(){
	settings_fields( 'kjd_widget_areas_settings' ); 
	$options = get_option('kjd_widget_areas_settings');


	// print_r($options); die();

	$widget_areas = array('front_page','page','single','404','category','archive','tag','author','date','search','attachment');
?>
<div class="options_wrapper">
	<h3>Choose Widget Areas</h3>

	<div class="option">
		<ul class="checkbox-list">
		<?php foreach($widget_areas as $area){ ?>
			<li>
				<label>
					<span><?php echo ucwords($area); ?></span>
					<input type="checkbox" name="kjd_widget_areas_settings[widget_areas][<?php echo $area;?>]" value="true" 
					<?php 
					if( isset($options['widget_areas'][$area]) ){
						checked( $options['widget_areas'][$area], 'true', true ); 
					} 
					?>
					 />
				</label>
			</li>
		<?php } ?>
		</ul
	</div>
</div>

<?php
}