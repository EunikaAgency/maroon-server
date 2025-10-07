<?php

namespace TabItems\UserRoles;

class TabItem{
    
    public $name = "User Role";
    public $singularName = "User Role";
    public $lowerCaseTabName = 'roles';
    public $buttonId = 'roles';
    public $tabClassName = "";
    public $priority = 80;

    public function tabData(){
        $output = "";
        $output .= '<div id="tab-items" class="tab-items-user_roles clearfix">';
        foreach( $GLOBALS['wp_roles']->roles as $key => $role ) {
            $output .= '<label><input type="checkbox" name="'.$this->lowerCaseTabName.'['. $key .']"  />' . $role['name'] . '</label>';
        }
        $output .= '</div>'; // tab-userroles

        return $output;
    }
}

