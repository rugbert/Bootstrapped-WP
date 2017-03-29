<?php

namespace bswp\Forms\Fields;


/**
 * bswp\Forms\Fields\Select Object
 * (
 *    [name] => underscored_name_should_match_class_name_variable_in_parent_array
 *    [label] => 'Just A Label'
 *    [field_name] => 'section[group_name][tab][field_name]' - auto generated
 *    [args] => Array
 *        (
 *            [0] => value
 *            [1] => value 2
 *        )

 *    [toggle_fields] => Array
 *        (
 *        	[value (from select option)] => 'comma,delimated,string,of,fields'
 *        	[value (from select option)] => 'comma,delimated,string,of,fields'
 *        )

 *    [toggled_by] => Array
 *        (
 *        	[field-name] => 'comma,delimated,string,of,values,from,select'
 *        )

 *    [preview] => auto,ajax,custom,form_save_warning
 *    [preview_args] => 'the function which is called by the wp_ajax func'
 *    [preview_dependancies] => 'comma,delimated,string,of,fields'
 *    [class] => 'basically the class type, ie: Select'
 *    [wrapper_class] =>
 *    [value] => 'string value'
 *    [output] => 'generated by the class'
 *    [preview_callback] => 'what js function to call after successful ajax'
 *    [id] => '--section-group-tab-the_field_name'
 *    )
 */


class Field {

    public $name;
    public $label;
    public $field_name;
    public $args;
    public $toggle_fields;
    public $toggled_by;
    public $data_target_fields;

    public $preview;
    public $preview_args;
    public $preview_callback;
    public $preview_dependancies;

    public $class;
    public $wrapper_class;

    public $value = '';

    public $output = '';

    public function __construct( $settings = array() ){
        extract($settings);
        $name = isset($name) ? $name : 'field';

        $this->name = $name;
        $this->label = isset($label) ? ucfirst($label) : ucfirst(str_replace(array('-','_'), ' ', $name ) );
        $this->args = isset($args) ? $args : array();

        $this->toggle_fields = isset($toggle_fields) ? $toggle_fields : array();
        $this->toggled_by = isset($toggled_by) ? $toggled_by : array();

        $this->preview = isset($preview) ? $preview : 'auto';
        $this->preview_callback = isset($preview_callback) ? $preview_callback : '';
        $this->preview_args = isset($preview_args) ? $preview_args : '';
        $this->preview_dependancies = isset($preview_dependancies) ? $preview_dependancies : '';

        $this->class = isset($class) ? $class : '';
        $this->wrapper_class = isset($wrapper_class) ? $wrapper_class : '';
        $this->default = isset($default) ? $default : null;

    }


    public function __toString() {
        return $this->output;
    }


    public function get_the_field() {
        $this->generate_output();
        return $this->output;
    }



    public function the_field() {
        echo $this->output;
    }

    // this is gross but im hungover
    public function find_value($target) {

        $section = $GLOBALS['bswp\Settings\Section'];

        // loop through the settings group
        foreach( $section->groups as $group ){
            $tabs = $group->tabs;

            // loop through the tabs
            if( empty($tabs) )
                continue;

            foreach( $tabs as $tab ){
                $fields = $tab;
                // loop through the fields
                if(!is_array($fields))
                    continue;

                // when we find the matching field, return the value
                foreach($fields as $name=>$field){
                    if($target == $field->name)
                        return $field->value;
                }
            }
        }

        return false;
    }


    // get alpha from RGBA
    public function get_alpha($rgba){
        $find = array('rgba','(',')');
        $rgba = str_replace($find,'',$rgba);

        $parts = explode(', ', $rgba);
        $last = $parts[(sizeof($parts)-1)];

        $alpha = $last;
        return $alpha;
    }


    /**
     * Identifies which field to use based on the 'type' key
     */
    public function generate_output(){

        $output = '';

        $data_toggled_by = '';
        $data_toggle_name = '';


        if(!empty($this->toggled_by) ){
            $toggles = $this->toggle_fields_markup($this->toggled_by);
            extract($toggles);
        }

        $id = $this->group_name.'-'.$this->tab_name.'-'.$this->name;
        $output .= '<div id="wrapper--'.$id.'"
            class="field '.$this->type.' '.$data_toggled_by.' '.$this->wrapper_class.
            '" '.$data_toggle_name.' '.$data_toggled_by_name.'>';
            $output .= $this->field_output();
        $output .= '</div>';


        $this->output = $output;
    }



    // sets the class to indicate we are toggling this field via JS
    public function get_toggled_by($toggled_bys){

        $output = 'hide js--toggled-field ';

        return $output;
    }


    // produces the name of the toggled by fields as data attrs
    public function get_toggled_by_names($toggled_bys){


        $output = '';
            foreach ($toggled_bys as $field=>$value){

                $output .= 'data-toggled_by_'.$field.'="'.$value.'"';
            }
        $output = rtrim($output, ', ');

        return $output;
    }



    // initiates the various toggle functions
    public function toggle_fields_markup($toggled_by){

        $data_toggled_by = !empty($toggled_by) ? $this->get_toggled_by($toggled_by) : '' ;
        $data_toggle_name = !empty($toggled_by) ? 'data-toggle_name="'.$this->name.'"' : '';
        $data_toggled_by_name = !empty($toggled_by) ? $this->get_toggled_by_names($toggled_by) : '' ;

        $data = array(
            'data_toggled_by' => $data_toggled_by,
            'data_toggle_name' => $data_toggle_name,
            'data_toggled_by_name' => $data_toggled_by_name
        );



        return $data;
    }


    public function clean_string($string) {
        $string = str_replace('_',' ', $string);
        $string = ucwords($string);
        return $string;
    }
}
