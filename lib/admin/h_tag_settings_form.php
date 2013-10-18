<?php

/*
	H tag settings
	h tag > a settings
*/

	settings_fields('kjd_'.$section.'_htag_settings' );
	$options = get_option('kjd_'.$section.'_htag_settings'); 

	$htags = array('H1','H1a','H1ahover', 'H2','H2a','H2ahover', 'H3','H3a','H3ahover','H4','H4a','H4ahover');

	$backgroundStyles = array('none','tabs','squared','pills');
	$decorationStyles = array('none','overline','underline','line-through','text-shadow');
	$borderStyles = array('none','solid','dotted','dashed','double','groove','ridge','inset','outset');

	foreach($htags as $element){  
		
		$value = $options['kjd_'.$section.'_'.$element];
					
		if($section =="navbar" && ($element == 'H1' || $element == 'H2' || $element == 'H3' || $element == 'H4')){
			continue;
		}
	?>
	<div class="options-wrapper float-options"> 
		<h2><?php echo ucwords(str_replace('_','none',$element)); ?> Settings</h2>
		<!-- font and link colors -->
		<div class="color-option option" style="position: relative;">

			<label>Color</label>

			<input class="minicolors" name="kjd_<?php echo $section;?>_text_settings[kjd_<?php echo $section;?>_<?php echo $element;?>][color]" 
				value="<?php echo $value['color'] ? $value['color'] : ''; ?>"/>
			<a class="clearColor">Clear</a>
		</div>


	<div class='full-option'>
			<div class="option">
				<label>Decoration</label>
				<select class="decorationList" name="kjd_<?php echo $section;?>_text_settings[kjd_<?php echo $section;?>_<?php echo $element;?>][decoration]">
					<?php foreach($decorationStyles as $decoration){ ?>
						<option value="<?php echo $decoration;?>" <?php selected( $value['decoration'], $decoration, true) ?>><?php echo $decoration ?></option>
					<?php } ?>
				</select>
			</div>


			<div class="shadowColor option" style="<?php echo $value['decoration'] == 'text-shadow'? 'display:block;' : 'display:none;' ;?>">
				<label>Text-shadow Color</label>

				<input class="minicolors" name="kjd_<?php echo $section;?>_text_settings[kjd_<?php echo $section;?>_<?php echo $element;?>][textShadowColor]" 
					value="<?php echo $value['textShadowColor'] ? $value['textShadowColor'] : ''; ?>"/>
				<a class="clearColor">Clear</a>
			</div>
	</div>
	<div class='full-option'>
		<div class="option">
			<label>Background Style</label>
			<select name="kjd_<?php echo $section;?>_text_settings[kjd_<?php echo $section;?>_<?php echo $element;?>][bg_style]">
				<?php foreach($backgroundStyles as $style){ ?>
					<option value="<?php echo $style;?>" <?php selected( $value['bg_style'], $style, true) ?>><?php echo ucwords(str_replace("_"," ",$style));?>
					</option>
				<?php } ?>
			</select>
		</div>


		<div class="color_option option" style="position: relative;">
			<label><?php echo $elementName;?> BG Color</label>

			<input class="minicolors" 
			name="kjd_<?php echo $section;?>_text_settings[kjd_<?php echo $section;?>_<?php echo $element;?>][bg_color]" 
				value="<?php echo $value['bg_color'] ? $value['bg_color'] : 'none'; ?>" />
				<a class="clearColor">Clear</a>
		</div>
	</div>
	<div class='full-option'>
			<div class="option">
				<label>Border style</label>
				<select name="kjd_<?php echo $section;?>_text_settings[kjd_<?php echo $section;?>_<?php echo $element;?>][border_style]">
					<?php foreach($borderStyles as $style){?>
						<option value="<?php echo $style;?>"<?php selected( $value['border_style'], $style, true) ?>><?php echo $style;?></option>
					<?php }?>
				</select>
			</div>

			<div class="color_option option" style="position: relative;">

				<label>Border color</label>
				<input type="minicolors" class="minicolors" data-default="none" name="kjd_<?php echo $section;?>_text_settings[kjd_<?php echo $section;?>_<?php echo $element;?>][border_color]"
				value="<?php echo $value['border_color'] ? $value['border_color'] : '' ;?>"
				 />		
				<a class="clearColor">Clear</a>
			</div> 			
	</div>
		<?php

		
?>
</div> 

<?php
		} //end foreach loop through font and link colors 