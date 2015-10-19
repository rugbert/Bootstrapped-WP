<?php
/**
 * $fields = array(
 *    'tabs'=>array(
 *        'tab-name'=>array(
 *            'label'=>'Tab Name',
 *            'fields'=>array(
 *                'color'=>array(
 *                    'name'=>'field-name',
 *                    'label'=>'Field Name',
 *                    'type'=>'field-type',
 *                    'args'=>'{string or array}',
 *                    'toggle_field'=>null,
 *                    'toggled_field'=>array('field_name'=>'option'),
 *                    'preview'=>null,
 *                 ),
 *             ),
 *         ),
 *     ),
 * );
 */

$footer_settings = array(
    'tabs' => array(
        'settings'=>array(
            'label'=>'Settings',
            'fields'=>array(
                'footer_height_toggle'=>select_field(array(
                        'name'=>'footer_height_toggle',
                        'label'=>'',
                        'args'=>array('yes','no'),
                        'toggle_field'=>array(
                            'yes'=>array('footer_height'),
                        )
                    )
                ),
                    'footer_height'=>text_field(array(
                            'name'=>'footer_height',
                            'label'=>'',
                            'args'=>array('suffix','px'),
                             'toggled_field'=>array('footer_height_toggle','yes')
                        )
                    ),
                'confine_section'=>select_field(array(
                        'name'=>'confine_section',
                        'label'=>'Confine Section',
                        'args'=>array('yes','no')
                    )
                ),
                'hide'=>select_field(array(
                        'name'=>'hide',
                        'label'=>'Hide',
                        'args'=>array('none','frontpage','inside','all')
                    )
                ),
            )
        ),
    )
);