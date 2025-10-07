<?php

namespace DMIDP;

class ajaxRequests{

    /**
     * ajaxRequests constructor.
     */


    public function __construct()
    {
        $this->require_ajax_files();
        $this->initAjaxClasses();
    }


    function require_ajax_files(){
        require 'AjaxRequests/duplicate-menus.php';
        require 'AjaxRequests/BackupDifferentMenusData.php';
        require 'AjaxRequests/save-different-menu-conditions.php';
        require 'AjaxRequests/RemoveDifferentMenu.php';
        require 'AjaxRequests/RemoveAllDifferentMenus.php';
        /*

        require 'AjaxRequests/RestoreDifferentMenusSettingsData.php';
        require 'AjaxRequests/SearchPages.php';
        require 'AjaxRequests/SearchPostTypes.php';
        require 'AjaxRequests/SearchTaxonomy.php';
        require 'AjaxRequests/NoticeHasClicked.php';*/
    }

    function initAjaxClasses(){
        new AjaxRequests\DuplicateMenus($this);
        new AjaxRequests\BackupDifferentMenusData($this);
        new AjaxRequests\SaveDifferentMenuConditions($this);
        new AjaxRequests\RemoveDifferentMenu($this);
        new AjaxRequests\RemoveAllDifferentMenus($this);
        /*

        new AjaxRequests\RestoreDifferentMenusSettingsData($this);
        new AjaxRequests\SearchPages($this);
        new AjaxRequests\SearchPostTypes($this);
        new AjaxRequests\SearchTaxonomy($this);
        new AjaxRequests\NoticeHasClicked($this);*/
    }

    public function nonceCheck()
    {
        $nonce = isset($_POST['nonce']) ? sanitize_key($_POST['nonce']) : "";

        if (!empty($nonce)) {
            if (!wp_verify_nonce($nonce, "recorp_different_menu")) {
                echo wp_json_encode(array('success' => false, 'status' => 'nonce_verify_error', 'response' => ''));

                die();
            }
        }
    }



}

new ajaxRequests();