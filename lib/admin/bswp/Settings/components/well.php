<?php

namespace bswp\Settings;

use bswp\Forms\Fields\Divider;
use bswp\Forms\Fields\Label;

if($component_options['activate_well'] == 'yes'){

    $well = new SettingsGroup('well');
    $well->add_tab('background_colors', $background_colors);

    $well->add_tab('text', array_merge(
            $regular_text,
            array( 'divider1'=>new Divider()),
            $link,
            array( 'divider3'=>new Divider()),
            $hovered_link,
            array( 'divider4'=>new Divider()),
            $active_link
        )
    );

    $well->add_tab('borders', array_merge(
            $component_borders,
            array( 'divider1'=>new Divider()),
            array( 'label1'=>new Label(array('name'=>'border_radius'))),
            $radii_fields
        )
    );
}
