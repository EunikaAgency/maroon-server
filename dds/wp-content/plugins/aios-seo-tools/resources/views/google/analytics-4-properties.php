<!-- BEGIN: Row Box -->
<div class="wpui-row wpui-row-box">
	<div class="wpui-col-md-3">
		<p><span class="wpui-settings-title">Google Analaytics 4 Properties ID</span></p>
	</div>
	<div class="wpui-col-md-9">
		<div class="form-group">
			<input type="text" name="aios-seotools[properties-id]" id="aios-seotools[properties-id]" value="<?=$google_properties_tag_manager_id?>" placeholder="G-XXXXXXXXXX">
		</div>
	</div>
</div>
<!-- END: Row Box -->

<!-- BEGIN: Row Box -->
<div class="wpui-row wpui-row-box">
  <div class="wpui-col-md-3">
    <p><span class="wpui-settings-title">Google Analaytics 4 Properties for IDXB</span></p>
  </div>
  <div class="wpui-col-md-9">
    <div class="form-group">
      <input type="text" name="aios-seotools[properties-id-idxb]" id="aios-seotools[properties-id-idxb]" value="<?=$google_properties_tag_manager_id_idxb?>" placeholder="G-XXXXXXXXXX">
    </div>
  </div>
</div>
<!-- END: Row Box -->

<!-- BEGIN: Row Box -->
<div class="wpui-row wpui-row-box">
	<div class="wpui-col-md-3">
		<p><span class="wpui-settings-title">Account Used</span><em>Reference</em></p>
	</div>
	<div class="wpui-col-md-9">
		<div class="form-group">
			<input type="text" name="aios-seotools[properties-account-used]" id="aios-seotools[properties-account-used]" value="<?=$properties_account_used?>" placeholder="ai-console-1@august99.com">
			<p class="mb-0">List the email address associated with the Google Adwords account. If no email is provided, please specify as Client Account, and any accompanying reference link.</p>
		</div>
	</div>
</div>
<!-- END: Row Box -->

<!-- BEGIN: Row Box -->
<div class="wpui-row wpui-row-box">
	<div class="wpui-col-md-3">
		<p><span class="wpui-settings-title">Additional Script for Tracking Event Conversion</span></p>
	</div>
	<div class="wpui-col-md-9">
		<div class="form-group">
			<textarea name="aios-seotools[properties-additional-code]" id="aios-seotools[properties-additional-code]" style="height: 250px;"><?=$google_properties_additional_code?></textarea>
		</div>
	</div>
</div>
<!-- END: Row Box -->

<div class="wpui-row wpui-row-submit">
	<div class="wpui-col-md-12">
		<div class="form-group">
			<input type="submit" class="save-option-ajax wpui-secondary-button text-uppercase" value="Save Changes">
		</div>
	</div>
</div>
