<?php

namespace TabItems\Templates;

class TabItem{
    
    public $name = "Templates";
    public $singularName = "Template";
    public $lowerCaseTabName = 'template';
    public $buttonId = 'template';
    public $tabClassName = "";
    public $priority = 30;

    public function tabData(){
        $output = "";
        $templates = wp_get_theme()->get_page_templates();

        if (!empty($templates)) {
            foreach ($templates as $key => $value) {
                $output .= '<label><input type="checkbox" name="'.$this->lowerCaseTabName.'[' . $key . ']" />' . $value . ' ('. $key .')' . '</label>';
            }
        }
        
        return $output;
    }
}
