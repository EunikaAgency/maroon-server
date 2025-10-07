<?php $menus = wp_get_nav_menus(); ?>
<!-- Modal -->
<div class="modal" id="duplicate_menu"  data-easein="flipXIn" tabindex="2" role="dialog" aria-labelledby="resetDifferentMenusConditionsTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle"><?php esc_html_e('Duplicate a Menu', 'different-menu'); ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        
        <div class="select-a-menu">
             <div class="default_menu clearfix">

                <label for="menus">Select a menu</label>
                <select class="form-control col-sm-6 float-left mr-2 selected_menu" id="menus" style="">
                    <?php 
foreach ($menus as $key => $value) {
?>
    <option slug="<?php echo esc_attr($value->slug); ?>" value="<?php echo esc_attr($value->slug); ?>">
        <?php echo esc_html($value->name); ?>
    </option>

    <?php
}
?>
                </select>

                <div id="new_menu_name">

                    <input type="text" id="new_menu" class="form-control col-sm-6 float-left mt-3 new_menu_name" name="new_menu_name" placeholder="<?php echo esc_html__('Enter new menu name', 'different-menu'); ?>">
                    <label for="new_menu" class="mt-3 ml-2"><?php esc_html_e('Enter a name', 'different-menu'); ?></label>

                </div>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php esc_html_e('Close', 'different-menu'); ?></button>
        <button type="button" class="btn btn-success duplicate"><?php esc_html_e('Duplicate', 'different-menu'); ?></button>
      </div>
    </div>
  </div>
</div>
