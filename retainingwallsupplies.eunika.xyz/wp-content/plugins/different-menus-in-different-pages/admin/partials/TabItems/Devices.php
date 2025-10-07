<?php

namespace TabItems\Devices;

class TabItem{
    
    public $name = "Devices";
    public $singularName = "Device";
    public $lowerCaseTabName = 'device';
    public $buttonId = 'device';
    public $tabClassName = "";
    protected $checkBoxName = 'version';
    public $priority = 90;

    public function tabData(){
        
        ob_start();
        ?>
        <div class="premium">This option is available for premium version only <span class="go_pro2"><a href="https://myrecorp.com/product/different-menus-in-different-pages/?clk=device-tab&a=pro">Buy Now</a></span></div>

        <div class="labels" style="filter: blur(0.5px);-webkit-filter: blur(0.5px);pointer-events: none;">
            <label class=""><input type="checkbox" name="<?php echo esc_attr($this->checkBoxName); ?>[android]" /> <?php esc_html_e('Android', 'different-menu'); ?> <span class="question-circle" data-toggle="tooltip" title="<?php esc_attr_e('Check this if you want to show the menu on all android device.', 'different-menu'); ?>"></span></label>

            <label class=""><input type="checkbox" name="<?php echo esc_attr($this->checkBoxName); ?>[ios]" /> <?php esc_html_e('iPhone', 'different-menu'); ?> <span class="question-circle" data-toggle="tooltip" title="<?php esc_attr_e('Check this if you want to show the menu on all iPhone devices.', 'different-menu'); ?>"></span></label>

            <label class=""><input type="checkbox" name="<?php echo esc_attr($this->checkBoxName); ?>[mobile]" /> <?php esc_html_e('Mobile', 'different-menu'); ?> <span class="question-circle" data-toggle="tooltip" title="<?php esc_attr_e('Check this if you want to show the menu on all mobile devices.', 'different-menu'); ?>"></span></label>

            <label class=""><input type="checkbox" name="<?php echo esc_attr($this->checkBoxName); ?>[tablet]" /> <?php esc_html_e('Tablet', 'different-menu'); ?> <span class="question-circle" data-toggle="tooltip" title="<?php esc_attr_e('Check this if you want to show the menu on all tablet devices.', 'different-menu'); ?>"></span></label>
        </div>

        <?php
        $output = ob_get_clean();

        return $output;
    }
}

                