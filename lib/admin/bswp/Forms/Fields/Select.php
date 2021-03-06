<?php

namespace bswp\Forms\Fields;


class Select extends Field{

    /**
     * Select field
     * 'args' field is in array - used to populate the options
     * if an 'args' a non-associative array then each value is used for both the value and label
     * otherwise the key is the value and the value is the label. huh?
     * @return [type]       [description]
     */
    public function field_output() {

        $output = '';
        $classes = $this->class . ' ' . $this->type;
        $classes .= $this->toggle_fields ? ' js--toggle-field' : '';


        // all the data attrs
        if($this->preview == 'toggle-class'){
            $data_preview_deps = $this->preview_args ? 'data-toggle_class="'.$this->preview_args.'"' : '' ;
        }else{
            $data_preview_deps = $this->preview_dependancies ? 'data-preview_deps="'.$this->preview_dependancies.'"' : '' ;
        }
        $data_preview = $this->preview ? 'data-preview="'.$this->preview.'"' : '';
        $data_field_name = $this->toggle_fields ? 'data-field_name="'.$this->name.'"' : '';

        // list of the fields which are toggled by this one
        $data_target_fields = $this->data_target_fields
        ? 'data-target_fields="'.$this->data_target_fields.'"' : '';

        $value = isset($this->value) ? $this->value : '';

        // the id and field name
        $id = $this->group_name.'-'.$this->tab_name.'-'.$this->name;
        $field_name = 'bswp_'.$this->section_name.
            '['.$this->group_name.']['.$this->tab_name.']['.$this->name.']';

        // the label
        $output .= '<label>'.$this->label.'</label>';


        // the select
        $output .= '<select class="'.$classes.'" id="'.$id.'" name="'.$field_name.'"
            '.$data_field_name.'
            '.$data_preview.'
            '.$data_preview_deps.'
            '.$data_target_fields.'>';

        // loop through the args to set the select options
        foreach ($this->args as $key=>$option):

            $option_test = $option;
            if(is_string($key))
                $option_text = $key;

            $name = strtolower(str_replace(' ','_',$option));
            $data_targets = '';

            // the option markup
            $output .= '<option '.$data_targets.' value="'.$option.'" '.selected( $option, $this->value, false).'>';
                $output .= str_replace('_',' ',$option);
            $output .= '</option>';

        endforeach;
        $output .= '</select>';

        return $output;

    }

    public function preview_dependancies() {

        examine($this->preview_dependancies);
    }

}
