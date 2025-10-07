<?php if (!defined('ABSPATH')) exit; ?>

<div class="wrap">
  <h1>Floating Google Reviews - Settings</h1>
  <form method="post" action="options.php">
    <?php
      settings_fields('fgr_settings_group');
      do_settings_sections('fgr-settings');
      submit_button();
    ?>
  </form>
</div>
