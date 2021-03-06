<?php

// forms
$forms = $values['forms'];
$form = $forms['background_colors'];
$field = $forms['field_colors'];
$field_active = $forms['field_active_colors'];
$field_buttons = $forms['button_colors'];
$form_misc = $forms['misc'];
?>

// Forms
// -------------------------
$inputBackground:               $white;
$inputBorder:                   $grayLighterDark;
$inputBorderRadius:             $baseBorderRadius;
$inputDisabledBackground:       $grayLighter;
$formActionsBackground:         $offWhite;
$inputHeight:                   $baseLineHeight + 10px; // base line-height + 8px vertical padding + 2px top/bottom border
$placeholderText:         $grayLight;
$formRemovePadding: <?php echo _tern($form_misc['remove_padding'], 'no'); ?>;

$formTextColor: <?php echo $form['text_color'] ? $form['text_color'] : '$grayDark';  ?>;
<?php

    _component_background_colors_sass_vars('form', $form);
    _component_outer_border_sass_vars('form', $form);
    _component_border_radius_sass_vars('form', $form);

?>

$fieldTextColor: <?php echo $field['text_color'] ? $field['text_color'] : '$grayDark';  ?>;
<?php

    _component_background_colors_sass_vars('field', $field);
    _component_outer_border_sass_vars('field', $field);
    _component_border_radius_sass_vars('field', $field);

?>


$fieldActiveTextColor: <?php echo $field_active['text_color'] ? $field_active['text_color'] : '$grayDark';  ?>;
<?php

    _component_background_colors_sass_vars('fieldActive', $field_active);
    _component_outer_border_sass_vars('fieldActive', $field_active);
    _component_border_radius_sass_vars('fieldActive', $field_active);

?>
