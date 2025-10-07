<!-- BEGIN: Row Box -->
<div class="wpui-row wpui-row-box">
	<div class="wpui-col-md-3">
		<p><span class="wpui-settings-title">Tracking Code</span></p>
	</div>
	<div class="wpui-col-md-9">
		<div class="form-group">
			<input type="text" name="aios-seotools[ga-tracking-code]" id="aios-seotools[ga-tracking-code]" value="<?=$google_analytics_code?>" placeholder="UA-XXXXXXXX-YY">
		</div>
	</div>
</div>
<!-- END: Row Box -->

<!-- BEGIN: Row Box -->
<div class="wpui-row wpui-row-box">
	<div class="wpui-col-md-3">
		<p><span class="wpui-settings-title">Tracking Code for IDXB</span></p>
	</div>
	<div class="wpui-col-md-9">
		<div class="form-group">
			<input type="text" name="aios-seotools[ga-tracking-code-idxb]" id="aios-seotools[ga-tracking-code-idxb]" value="<?=$google_analytics_code_idxb?>" placeholder="UA-XXXXXXXX-YY">
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
			<input type="text" name="aios-seotools[ga-account-used]" id="aios-seotools[ga-account-used]" value="<?=$ga_account_used?>" placeholder="ai-console-1@august99.com">
			<p class="mb-0">List the email address associated with the Google Analytics account. If no email is provided, please specify as Client Account, and any accompanying reference link.</p>
		</div>
	</div>
</div>
<!-- END: Row Box -->

<!-- BEGIN: Row Box -->
<div class="wpui-row wpui-row-box">
	<div class="wpui-col-md-3">
		<p>
			<span class="wpui-settings-title">Additional event tracking</span>
			Usage: Add additional event tracking for video play, outbond links, and common user interactions.
		</p>
	</div>
	<div class="wpui-col-md-9">
		<div class="form-group">
			<textarea name="aios-seotools[ga-additional-code]" id="aios-seotools[ga-additional-code]" style="height: 150px;"><?=$google_analytics_additional_code?></textarea>
		</div>
	</div>
</div>
<!-- END: Row Box -->

<!-- BEGIN: Row Box -->
<div class="wpui-row wpui-row-box">
	<div class="wpui-col-md-3">
		<p>
			<span class="wpui-settings-title">Mutliple Tracking</span>
		</p>
	</div>
	<div class="wpui-col-md-9">
		<div class="form-group">
			<div class="form-checkbox-group form-toggle-switch">
				<div class="form-checkbox">
					<label><input type="checkbox" name="aios-seotools[multiple-tracking]" value="1" <?=$ga_multiple_tracking == '1' ? 'checked=checked' : '' ?>> Enable</label>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- END: Row Box -->

<!-- BEGIN: Row Box -->
<div class="wpui-row wpui-row-box">
	<div class="wpui-col-md-3">
		<p>
			<span class="wpui-settings-title">Mutliple Tracking Code</span>
			Note: <strong>"Tracking Code"</strong> and <strong>Additional event tracking</strong> will not be added.
		</p>
	</div>
	<div class="wpui-col-md-9">
		<div class="form-group">
			<p>Usually only the 2nd and any subsequent trackers would be named.</p>
			<textarea name="aios-seotools[multiple-tracking-code]" id="aios-seotools[multiple-tracking-code]" style="height: 150px;" placeholder="ga('create', 'UA-XXXXXXXX-1', 'auto');
ga('create', 'UA-XXXXXXXX-1', 'auto', 'TRACKERNAME');
ga('send', 'pageview');
ga('TRACKERNAME.send', 'pageview');"><?=stripslashes_deep($ga_multiple_tracking_code)?></textarea>
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
