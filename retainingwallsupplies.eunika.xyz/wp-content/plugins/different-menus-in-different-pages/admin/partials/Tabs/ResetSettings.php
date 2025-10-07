
<!-- Modal -->
<div class="modal" id="resetDifferentMenusConditions"  data-easein="flipXIn" tabindex="2" role="dialog" aria-labelledby="resetDifferentMenusConditionsTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle"><?php esc_html_e('Are you sure ?', 'different-menu'); ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h6><?php esc_html_e('You want to reset those settings?', 'different-menu'); ?></h6>
        <h6><?php esc_html_e('You may backup those settings first!', 'different-menu'); ?></h6>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php esc_html_e('Close', 'different-menu'); ?></button>
        <button type="button" class="btn btn-danger remove_diff_menus"><?php esc_html_e('Reset', 'different-menu'); ?></button>
      </div>
    </div>
  </div>
</div>
