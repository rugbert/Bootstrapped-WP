<?php

namespace bswp\Settings;

use bswp\Forms\Fields\Divider;
use bswp\Forms\Fields\Label;


if($component_options['activate_breadcrumbs'] == 'yes'){
    $breadcrumbs = new SettingsGroup('breadcrumbs');
    $breadcrumbs->add_tab('background_colors', $background_colors);

    $breadcrumbs->add_tab('borders', array_merge(
            $top,
            array( 'divider1'=>new Divider()),
            $right,
            array( 'divider2'=>new Divider()),
            $bottom,
            array( 'divider3'=>new Divider()),
            $left,
            array( 'divider4'=>new Divider()),
            array( 'label1'=>new Label(array('name'=>'border_radius'))),
            $radii_fields
        )
    );


    $breadcrumbs->add_tab('text', array_merge(
            $regular_text,
            array( 'divider1'=>new Divider()),
            $link,
            array( 'divider2'=>new Divider()),
            $visited_link,
            array( 'divider3'=>new Divider()),
            $hovered_link,
            array( 'divider4'=>new Divider()),
            $active_link
        )
    );

}
