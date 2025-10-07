<?php

namespace TabItems\CustomLinks;

class TabItem{
    
    public $name = "Custom Links";
    public $singularName = "Custom Link";
    public $lowerCaseTabName = 'custom_links';
    public $buttonId = 'custom_links';
    public $tabClassName = "";
    public $priority = 20;

    public function tabData(){
        ob_start();
        ?>

        <div class="container">
            <div class="row">
                <div class="col-lg-12" style="padding-left: 0px;">
                    <div>
                        <div class="field_wrapper">
                            <div>
                                <input type="text" name="custom_links[]" value="" placeholder="Enter an URL, page id or post-name" />
                                <a href="javascript:void(0);" class="add_button" title="Add field"><span class="dashicons dashicons-plus-alt2"></span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="nb_dmidp">
            <div>Note:
                <ul>
                    <li>1. You can use exact url, example: <strong>https://yoursite.com/post-name</strong></li>
                    <li>2. You can use page id. Example: <strong>101</strong></li>
                    <li>3. You can use specific post name. Example: <strong>post-name</strong></li>
                    <li>4. To match an url part, you can use <strong>%{keyword}%</strong> example: <strong>%/en%</strong></li>
                </ul>
            </div>
        </div>

        <?php
        $output = ob_get_clean();

        return $output;
    }
}
