<?php

namespace bswp\Settings;

use bswp\CSS\Builder;

/**
 * A Section is a page of settings for some
 * section of the website.
 *
 * For instance, we might have a page for the footer section settings,
 * or a page for the login page settings.
 *
 * Sections can be turned on and off
 * Sections can also inherit their settings from another section
 *
 * Basic steps:
 * when a section object is created, we pass in the section name and
 * its field settings.  The fields themselves will have the name of the
 * "SettingsGroup" and "Tab".  These will be used to determine how to set up the
 * structure of the form to display.
 *
 * On construction, the object will read the DB to try and grab the saved values
 * of the fields and set them to the fields in the object.  These are displayed in the forms.
 *
 * Finally, the object should register the settings and sections (WordPress terms)
 * so we can save them in the DB.  This gets tricky because these need to be registered
 * early in the bootstrap process.  think about abstracting that to its own class.
 *
 */


class Section {

    public $name = '';
    public $display_name = '';

    public $settings = array();
    public $settings_file = '';

    public $is_active = false;
    public $inherits_from = array();

    public $current_group = '';
    public $groups = array();
    public $fields = array();
    public $current_tab = '';


    /**
     * sets the section name, this is used to grab all the saved values from
     * the DB, and also register all fields.
     */
    public function __construct($name = null, $fields = array(), $display_name = null){


        if($name){
            // examine('set');
            $this->name = $name;
        }elseif( isset($_GET['section']) ){
            $this->name = $_GET['section'];
        }elseif( !empty($_POST)){

            preg_match( '/(bswp_){1}[a-zA-Z_]+(_settings){1}/', $_POST['option_page'], $m );

            if( !isset($_POST['option_page'])
                || !$m
                || empty($_POST[$m[0]])
            )
                return;
            $this->name = str_replace('bswp_', '',$_POST['option_page']);

        }else{
            $this->name = 'site_settings';
        }


        $this->isSectionSctivated();


        if($display_name)
            $this->display_name = $display_name;
        else
            $this->display_name = ucwords(str_replace('_',' ', $this->name));

        $this->get_settings_file();
        $this->get_saved_values();

        if(isset($_GET['show_saved_values']) && $_GET['show_saved_values'] == 'yes')
            examine($this->saved_values);


        $class = __CLASS__;
        if($GLOBALS[ $class ])
            unset($GLOBALS[ $class ]);

        $GLOBALS[ $class ] = $this;

        $this->get_section_field_settings();
        $this->set_values_to_fields();

        $this->form_meta_settings = $this->saved_values['form_meta_settings'];



        if(isset($_GET['show_object']) && $_GET['show_object'] == 'yes')
            examine($this);


            $this->build_css();
        if( !get_option('bswp_site_settings') || $this->form_meta_settings['build_css'] == 'yes') {
        }

        unset($this->saved_values);

    }


    /**
     * If the use attempts to goto a section page which has not been activated
     * (ie: body_settings) then we redirect them to the site settings page
     */
    public function isSectionSctivated()
    {

        $sections = array('site_settings');
        $options = get_option('bswp_site_settings');
        $options = $options['settings'];
        $options = !empty( $options['sections']) ?  $options['sections'] : array();

        foreach($options as $section=>$toggled){
            if($toggled !== 'yes')
                continue;

            $sections[] = $section.'_settings';
        }
        if( in_array($this->name, $sections) ){
            return;
        }

        $this->redirectToSiteSettings();
    }

    public function redirectToSiteSettings()
    {

        $url = admin_url('admin.php?page=bswp_settings&amp;section=site_settings');
        wp_redirect($url);
        exit;
    }


    /**
     * Build the CSS!
     * We only do this when the settings have been saved
     */
    public function build_css() {
        if(!empty($_POST) )
            return;

        $builder = new Builder();
        $builder->build();
        $builder->saveToFile('dist');

        unset($builder);

    }


    public function delete_preview_css() {
        $builder = new Builder($this->name, null, true);
        $builder->deletePreviewFile('preview');
    }

    // we use a settings file as an index of all settings
    public function get_settings_file(){
        if(is_readable(dirname(__FILE__).'/section--'.$this->name.'.php'))
            $this->settings_file = dirname(__FILE__).'/section--'.$this->name.'.php';
        else
            $this->redirectToSiteSettings();

    }

    // now we grab the field settings
    public function get_section_field_settings(){

        include_once( $this->settings_file );

        foreach( $groups as $key=>$group )
        $this->groups[$key] = $group;
    }


    // get all the saved values for this section from the DB, options table
    public function get_saved_values(){
        $values = $this->saved_values = get_option('bswp_'.$this->name);
        if($values['form_meta_settings']['build_css'] == 'yes'){
            $values['form_meta_settings']['build_css'] = 'no';
            update_option('bswp_'.$this->name, $values, 'no');

        }
    }


    // Start process to take the set values and save them to the fields
    public function set_values_to_fields(){
        foreach( $this->groups as &$group ){
            $group->set_section($this->name);
            $group->loop_tabs();
        }
    }


    // see if the field has a saved value
    public function find_saved_value($group_name = '', $tab_name = '', $field_name = '') {


        if( empty( $this->saved_values[$group_name] ) )
            return false;


        // loop through all the group tabs
        foreach( $this->saved_values[$group_name] as $tab_key=>$tab ){

            if($tab_name !== $tab_key)
                continue;


            $fields = $tab;
            // loop through the fields
            foreach($fields as $field_key => $field_value){
                if($field_name == $field_key){
                    // if($group_name == 'layouts')
                    //     examine($field_name .'=='. $field_key .':'. $field_value);
                        // examine( $group_name . '>' . $tab_name .'>'. $field_name );
                    return $field_value;
                }
            }

        }
    }


    // register this section to save the fields
    public function register_section_settings() {

        add_settings_section(
            'bswp_'.$this->name.'_section',
            null,
            null,
            'bswp_'.$this->name
        );
        register_setting('bswp_'.$this->name, 'bswp_'.$this->name);


    }


}
