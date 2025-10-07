
<!-- Modal -->
<div class="modal" id="backupAndRestore" tabindex="3" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle"><?php esc_html_e('Backup or Restore', 'different-menu'); ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <button type="button" class="btn btn-success btn-backup_settings"><?php esc_html_e('Backup settings', 'different-menu'); ?></button>
        <span class="description"><?php esc_html_e('Click here to backup settings data.', 'different-menu'); ?></span>

        <br>
        <br>
        

        <input type="file" id="restore_settings" accept=".csv">
        <br>
        <span class="description"><?php esc_html_e('Select a backup file to restore settings.', 'different-menu'); ?></span>

        <div class="restore_settings_data_as_txt hidden">
            
        </div>
        
      </div>

        <div class="alert alert-danger">
            <span><?php esc_html_e('"Restore" option is available for premium version only', 'different-menu'); ?></span>
        </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php esc_html_e('Close', 'different-menu'); ?></button>
            <button type="button" class="btn btn-primary" data-toggle="tooltip" disabled=""><?php esc_html_e('Restore', 'different-menu'); ?></button>
      </div>
    </div>
  </div>
</div>

