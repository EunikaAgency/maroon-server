
<!-- Modal -->
<div class="modal" id="removeMenu"  data-easein="flipXIn" tabindex="4" role="dialog" aria-labelledby="backupAndRestoreTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle"><?php esc_html_e('Are you sure?', 'different-menu'); ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        
        <h6><?php esc_html_e('You want to delete the menu?', 'different-menu'); ?></h6>
        <h6><?php esc_html_e('You may backup those settings first!', 'different-menu'); ?></h6>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php esc_html_e('Close', 'different-menu'); ?></button>
        <button type="button" class="btn btn-danger remove_diff_menu"><?php esc_html_e('Delete', 'different-menu'); ?></button>
      </div>
    </div>
  </div>
</div>

