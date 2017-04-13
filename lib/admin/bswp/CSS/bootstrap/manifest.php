<?php
foreach($this->section as $section):

    $section_name = $this->getSectionName($section );

    ob_start();
    if ( $section == 'site_settings' ):
?>
    // Settings
    ///////////////////////

    // Core variables and mixins
    @import 'settings/constants';
    @import 'settings/variables'; // Modify this for custom colors, font-sizes, etc
    @import 'settings/mixins';

    // CSS Reset
    @import 'settings/reset';
    // Utility classes
    @import 'settings/utilities'; // Has to be last to override when necessary

    // the body background
    @import './body';


    // these are not repeatable in other sections
    @import 'settings/grid';
    @import 'settings/layouts';
    @import 'components/section';

    @import 'components/navs';


    // @import 'components/tabbables';

    @import 'components/brand';
    @import 'settings/responsive-utilities'; // RESPONSIVE CLASSES
    @import 'settings/responsive-1200px-min'; // Large desktops
    @import 'settings/responsive-768px-979px'; // Tablets to regular desktops
    @import 'settings/responsive-767px-max'; // Phones to portrait tablets and narrow desktops
    @import 'components/component-animations';
    @import 'components/sprites';
    @import 'components/modals';

    @import 'components/frontpage';
    <?php
        endif;
    ?>


    // Components
    ///////////////////////////
    <?php
    echo $section_name . ' {';
    ?>

        // Grid system and page structure
        @import 'components/scaffolding';
        @import 'components/links';
        // Base CSS
        @import 'components/type';
        @import 'components/blockquotes';
        @import 'components/code';
        @import 'components/forms';
        @import 'components/tables';

        // Components: common
        @import 'components/wells';
        @import 'components/close';

        // Components: Buttons & Alerts
        @import 'components/buttons';
        @import 'components/button-groups';
        @import 'components/alerts'; // Note: alerts share common CSS with buttons and thus have styles in buttons

        @import 'components/breadcrumbs';
        @import 'components/pagination';
        @import 'components/pager';

        // Components: Popovers
        @import 'components/tooltip';
        @import 'components/popovers';

        // images
        @import 'components/images';
        // @import 'components/thumbnails';
        @import 'components/thumbnails';


        // Components: Misc
        @import 'components/media';
        @import 'components/labels-badges';
        @import 'components/progress-bars';
        @import 'components/accordion';
        @import 'components/tabbables';
        @import 'components/carousel';
        @import 'components/hero-unit';
        @import 'components/sidebar';
        @import 'components/content-column';

        @import 'components/header';

        @import 'components/navbar';
        @import 'components/dropdowns';
        @import 'components/navbar_dropdown';
        @import 'components/navbar-toggle';
        @import 'components/navbar-responsive';

    <?php
        echo '}';


        $contents = ob_get_contents();
        ob_end_clean();

    $this->bootstrap_manifest = $contents;

    // examine($contents);
endforeach;
