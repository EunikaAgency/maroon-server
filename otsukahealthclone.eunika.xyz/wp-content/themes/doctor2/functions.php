<?php

/*
 * AIT WordPress Theme
 *
 * Copyright (c) 2013, Affinity Information Technology, s.r.o. (http://ait-themes.com)
 */

// === Usefull debugging constants ===================================

// if(!defined('AIT_DISABLE_CACHE')) define('AIT_DISABLE_CACHE', true);


// === Loads AIT WordPress Framework ================================
require_once get_template_directory() . '/ait-theme/@framework/load.php';


// === Mandatory WordPress Standard functionality ===================

if(!isset($content_width)) $content_width = 1200;


// === Custom filters, actions for framework overrides ==============


// === Run the theme ===============================================

$themeConfiguration = include aitPath('config', '/@theme-configuration.php');

AitTheme::run($themeConfiguration);


// === Custom settings ==============================================

if ( aitIsPluginActive( "woocommerce" ) ) {
	
	add_filter('loop_shop_columns', function() { return 3; });

	// Display 6 products per page
	add_filter('loop_shop_per_page', function($cols){ return 6; }, 20);

	// Add image sizes for woocommerce 3.3+
	add_theme_support( 'woocommerce', array(
	    'thumbnail_image_width'         => 500,
	    'gallery_thumbnail_image_width' => 180,
	    'single_image_width'            => 750,
	) );

	// Change number of related products on product page
	// Set your own value for 'posts_per_page'
	add_filter( 'woocommerce_output_related_products_args', 'ait_related_products_args' );
	function ait_related_products_args( $args ) {
		$args['posts_per_page'] = 3; // 3 related products
		$args['columns'] = 3; // arranged in 3 columns
		return $args;
	}

	// Disable woocommerce default styles
	if ( version_compare( WOOCOMMERCE_VERSION, "2.1" ) >= 0 ) {
		add_filter( 'woocommerce_enqueue_styles', '__return_false' );
	} else {
		define( 'WOOCOMMERCE_USE_CSS', false );
	}
}

//wp_enqueue_style('segoe-ui-symbol-font', '//db.onlinewebfonts.com/c/150ed9b2a009a71d2d819b5561167302?family=Segoe+UI+Symbol');

//for google analytics
function insert_analytics_script(){
	if(is_user_logged_in()){
		?>
			<!-- Global site tag (gtag.js) - Google Analytics -->
			<script async src="https://www.googletagmanager.com/gtag/js?id=UA-189141312-1"></script>
			<script>
			  window.dataLayer = window.dataLayer || [];
			  function gtag(){dataLayer.push(arguments);}
			  gtag('js', new Date());

			  gtag('config', 'UA-189141312-1', {'user_id' : '<?php echo get_current_user_id(); ?>'});
			  gtag('event', 'Pageview',
				   {
				     'event_category' : '<?php echo esc_html(get_the_title()); ?>',
				     'event_label' :  '<?php echo "VST-" . get_current_user_id() . "-" . (new DateTime("now", new DateTimeZone("Asia/Singapore")))->format("Ymd-His"); ?>',
				     'event_value' : 1
				   }
			  );
				
				 var pageEnter = new Date().getTime()/1000;
				    //create listener when user leaves the page
				    //and calculate the duration using the pageEnter variable
				    jQuery(window).on('beforeunload', function() {
						var pageLeave = new Date();
						var leaveMonth = ('0' + (pageLeave.getMonth() + 1)).slice(-2);
						var leaveDay = ('0' + (pageLeave.getDate())).slice(-2);
						var leaveHour = ('0' + (pageLeave.getHours())).slice(-2);
						var leaveMins = ('0' + (pageLeave.getMinutes())).slice(-2);
						var leaveSecs = ('0' + (pageLeave.getSeconds())).slice(-2);
						var pageDuration = Math.round((pageLeave.getTime()/1000) - pageEnter);
						gtag('event', 'Analytics',
							{
								'event_category' : '<?php echo esc_html(get_the_title()); ?>',
								'event_label' : 'PVW-' + '<?php echo get_current_user_id() ?>' + '-' + pageLeave.getFullYear() + leaveMonth + leaveDay + '-' + leaveHour + leaveMins + leaveSecs + '-' + pageDuration,
								'event_value' : '1'
							}
						);
						
						 <?php if(get_current_user_id() == '1'){ ?>
				var testdata =  'PVW-' + '<?php echo get_current_user_id() ?>' + '-' + pageLeave.getFullYear() + leaveMonth + leaveDay + '-' + leaveHour + leaveMins + leaveSecs + '-' + pageDuration;
				console.log(testdata);
				<?php } ?>
					});
				
				
				
					//adding pdf on-click analytics function
					jQuery(document).on('click', '.pdf-click-btn', function() {
							var pdfFilePath = jQuery(this).attr('href');
							var pdfFile = pdfFilePath.substring(pdfFilePath.lastIndexOf('/')+1);

							gtag('event', 'Analytics',
								{
									'event_category' : pdfFile,
									 'event_label' : '<?php echo "VST-" . get_current_user_id() . "-" . (new DateTime("now", new DateTimeZone("Asia/Singapore")))->format("Ymd-His"); ?>',
									'event_value' : '1'
								}
							);


						});
								//For homepage carousel-item
					jQuery(document).on('click', '.carousel-container>.carousel-item>.item>.item-text>.item-icons>ul>li>a' ,function() {
						var pdfFilePath = jQuery(this).attr('href');
						var pdfFile = pdfFilePath.substring(pdfFilePath.lastIndexOf('/')+1);
					
						gtag('event', 'Analytics',
							{
								'event_category' : pdfFile,
								 'event_label' : '<?php echo "VST-" . get_current_user_id() . "-" . (new DateTime("now", new DateTimeZone("Asia/Singapore")))->format("Ymd-His"); ?>',
								'event_value' : '1'
							}
						);
					});
												
					
					var timeStarted = -1;
					
					//for regular embedded html5 videos
					function videoStartedPlaying(event){
						var video = event.target;
						if(event.target.tagName.toLowerCase() == "div"){
							video = event.target.getElementsByTagName("video");
							if(video.length > 0){
								timeStarted = new Date().getTime()/1000;
							}
						}
					}
					
					//for regular embedded html5 videos
					function videoStoppedPlaying(event){
						var video = event.target;
						if(event.target.tagName.toLowerCase() == "div"){
							if (timeStarted > 0){
								video = event.target.getElementsByTagName("video");
								if(video.length > 0){
									var videoStopped = new Date();
									var watchMonth = ('0' + (videoStopped.getMonth() + 1)).slice(-2);
									var watchDay = ('0' + (videoStopped.getDate())).slice(-2);
									var watchHour = ('0' + (videoStopped.getHours())).slice(-2);
									var watchMins = ('0' + (videoStopped.getMinutes())).slice(-2);
									var watchSecs = ('0' + (videoStopped.getSeconds())).slice(-2);
									var watchDuration = Math.round((videoStopped.getTime()/1000) - timeStarted);
									timeStarted = -1;
									
									var filepath = video[0].currentSrc;
									var filename = filepath.substring(filepath.lastIndexOf('/')+1);

									gtag('event', 'Analytics',
										{
											'event_category' : filename,
											'event_label' : 'VID-' + '<?php echo get_current_user_id() ?>' + '-' + videoStopped.getFullYear() + watchMonth + watchDay + '-' + watchHour + watchMins + watchSecs + '-' + watchDuration,
											'event_value' : '1'
										}
									);
								}
							}
							
														 <?php if(get_current_user_id() == '1'){ ?>
				var testdata2 =  'VID-' + '<?php echo get_current_user_id() ?>' + '-' + videoStopped.getFullYear() + watchMonth + watchDay + '-' + watchHour + watchMins + watchSecs + '-' + watchDuration;
				console.log(testdata2);
				<?php } ?>
						}
					}
					
					jQuery("*").on("play", videoStartedPlaying);
					//jQuery("*").on("playing", videoStartedPlaying);

					jQuery("*").on("pause", videoStoppedPlaying);
					jQuery("*").on("ended", videoStoppedPlaying);
					
					jQuery(document).ready(function () {
						
						//for vimeo videos inside popup
						jQuery(document).on('custombox:content:open', function() {
							var popupframe = jQuery(".custombox-content").find("iframe");
							if(popupframe.length > 0){
								var vimeoframe = popupframe[0];
								var vimeoplayer = new Vimeo.Player(vimeoframe);
								var vimeotitle = "";
								vimeoplayer.ready().then(function() {
									vimeoplayer.getVideoTitle().then(function(title){
										vimeotitle = title;
									}).catch(function(e){
										console.error(e);
									});
									vimeoplayer.on('play', function(data){
										timeStarted = new Date().getTime()/1000;
									});
									vimeoplayer.on('pause', function(data){
										var videoStopped = new Date();
										var watchMonth = ('0' + (videoStopped.getMonth() + 1)).slice(-2);
										var watchDay = ('0' + (videoStopped.getDate())).slice(-2);
										var watchHour = ('0' + (videoStopped.getHours())).slice(-2);
										var watchMins = ('0' + (videoStopped.getMinutes())).slice(-2);
										var watchSecs = ('0' + (videoStopped.getSeconds())).slice(-2);
										var watchDuration = Math.round((videoStopped.getTime()/1000) - timeStarted);
										timeStarted = -1;
										
										gtag('event', 'Analytics',
											{
												'event_category' : vimeotitle,
												'event_label' : 'VID-' + '<?php echo get_current_user_id() ?>' + '-' + videoStopped.getFullYear() + watchMonth + watchDay + '-' + watchHour + watchMins + watchSecs + '-' + watchDuration,
												'event_value' : '1'
											}
		
											 
										);
										<?php if(get_current_user_id() == '1'){ ?>
				var testdata2 =  'VID-' + '<?php echo get_current_user_id() ?>' + '-' + videoStopped.getFullYear() + watchMonth + watchDay + '-' + watchHour + watchMins + watchSecs + '-' + watchDuration;
				console.log(testdata2);
				<?php } ?>
							
									});
								});
								
							}
						});
						
														 
					});
				
				
			</script>
		<?php
	}
}
add_action('wp_head', 'insert_analytics_script');

//redirect non-admin back to homepage
function redirect_non_admin() {
	$queried_object = get_queried_object();
	$user = wp_get_current_user();
	$admin_pages = array('1256', '1258');
	if($queried_object) {
		$page_id = $queried_object->ID;
		if(in_array($page_id, $admin_pages) && !$user->has_cap('administrator')) {
			wp_safe_redirect("https://otsukahealthclone.eunika.xyz");
		}	
	}
}
add_action('template_redirect', 'redirect_non_admin');

//redirect user if they already answered the survey form
function redirect_from_survey() {
	$queried_object = get_queried_object();
	if($queried_object) {
		if($queried_object->ID == 971){
			if(isset($_GET["webinar-ID"])){
				//get form id from db
				global $wpdb;
				$form_details = $wpdb->get_row($wpdb->prepare("SELECT * from wp_webinar_list where id=%d", $_GET["webinar-ID"]), ARRAY_A);
				
				//check if current time is within webinar timeframe
				$curr_time = current_time('H:i');
				if($form_details["start_time"] >= $curr_time  && $curr_time <= $form_details["end_time"]){
					
					wp_safe_redirect("https://otsukahealthclone.eunika.xyzwebinar-survey-landing-page/");
					
				} else {
					//get current user's id
					$user_id = get_current_user_id();

					//get all submissions from form
					$submissions  = Ninja_Forms()->form($form_details["form_id"])->get_subs();

					//check if user already answered form
					foreach($submissions as $sub){
						if($sub->get_field_value("user_id") == $user_id){
							wp_safe_redirect("https://otsukahealthclone.eunika.xyzwebinar-survey-landing-page/");
						}
					}
				}
			} else {
				wp_safe_redirect("https://otsukahealthclone.eunika.xyz");
			}
		}
	}
}
add_action('template_redirect', 'redirect_from_survey');

//hide menu items from non-admin
function hide_menu_items($items, $menu, $args) {
	$menu_item = 1256;
	$user = wp_get_current_user();
	if(!$user->has_cap('administrator')){
		foreach($items as $key => $item){
			if($item->object_id == $menu_item) unset($items[$key]);
		}
	}
	
	return $items;
}
add_filter( 'wp_get_nav_menu_items', 'hide_menu_items', null, 3 );

//get current user's first name
function get_first_name() {
	return um_user('first_name');
}
add_shortcode('first_name', 'get_first_name');

function get_um_info($atts) {
	return um_user($atts["field"]);
}
add_shortcode('get_um_info', 'get_um_info');

function get_webinar_title() {
	$title = "";
	if(isset($_GET["webinar-ID"])){
		global $wpdb;
		$id = $_GET["webinar-ID"];
		$title = $wpdb->get_var($wpdb->prepare("SELECT title from wp_webinar_list where id=%d", $id));
	}
	
	return $title;
}
add_shortcode('show_webinar_title', 'get_webinar_title');

function get_participant_name() {
	global $current_user;
	wp_get_current_user();
	
	return $current_user->display_name;
}
add_shortcode('participant_name', 'get_participant_name');

function add_new_webinar_detail () {
	
	$webinar_id = "";
	$title = $_POST["webinar-title"];
	$date = $_POST["webinar-date"];
	$start_time = $_POST["start-time"];
	$end_time = $_POST["end-time"];
	$form_id = $_POST["form-id"];
	$insert_success = false;
	$update_success = false;
	
	$table_name = "wp_webinar_list";
	global $wpdb;
	
	if($_POST["webinar-id"] != ""){
		$webinar_id = $_POST["webinar-id"];
		$update_success = $wpdb->update($table_name, array('title' => $title, 'webinar_date' => $date, 'start_time' => $start_time, 'end_time' => $end_time, "form_id" => $form_id), array('id' => $webinar_id));
	} else {
		$insert_success = $wpdb->insert($table_name, array('title' => $title, 'webinar_date' => $date, 'start_time' => $start_time, 'end_time' => $end_time, "form_id" => $form_id));
	}
	wp_safe_redirect("https://otsukahealthclone.eunika.xyzwebinar-survey-list/");
}
add_action('admin_post_add_webinar_detail', 'add_new_webinar_detail');
add_action('admin_post_nopriv_add_webinar_detail', 'add_new_webinar_detail');

function display_webinar_details() {
	ob_start();
	
	$webinar_id = null;
	$webinar_title = "";
	$webinar_date = "2021-01-31";
	$webinar_start = "18:00";
	$webinar_end = "20:00";
	$form_id = "";
	$button_text = "Add New Webinar";
	
	if(isset($_GET["webinar-ID"])){
		global $wpdb;
		$webinar_id = $_GET["webinar-ID"];
		//retrieve details for current webinar ID
		$current_webinar = $wpdb->get_row($wpdb->prepare("SELECT * from wp_webinar_list where id=%d", $webinar_id));
		$webinar_title = $current_webinar->title;
		$webinar_date = $current_webinar->webinar_date;
		$webinar_start = $current_webinar->start_time;
		$webinar_end = $current_webinar->end_time;
		$form_id = $current_webinar->form_id;
		$button_text = "Update Webinar";
	}
	?>
	<form name="webinar-details" method="POST" onsubmit="return validate_webinar_form()" action="/wp-admin/admin-post.php" autocomplete="off">
		<input type="hidden" name="action" value="add_webinar_detail"/>
		<input type="hidden" id="webinar-id" name="webinar-id" value ="<?php echo $webinar_id; ?>"/>
		<table class="webinar-details">
			<tr>
				<td class="label-column">
					<label for="webinar-title">Title: </label>
				</td>
				<td>
					<input type="text" id="webinar-title" name="webinar-title" value="<?php echo $webinar_title; ?>"/>
				</td>
			</tr>
			<tr>
				<td class="label-column">
					<label for="webinar-date">Date: </label>
				</td>
				<td>
					<input type="date" id="webinar-date" name="webinar-date" value="<?php echo $webinar_date; ?>"/>
				</td>
			</tr>
			<tr>
				<td class="label-column">
					<label for="start-time">Start Time: </label>
				</td>
				<td>
					<input type="time" id="start-time" name="start-time" value="<?php echo $webinar_start; ?>"/>
				</td>
			</tr>
			<tr>
				<td class="label-column">
					<label for="end-time">End Time: </label>
				</td>
				<td>
					<input type="time" id="end-time" name="end-time" value="<?php echo $webinar_end; ?>"/>
				</td>
			</tr>
			<tr>
				<td class="label-column">
					<label for="form-id">Form ID: </label>
				</td>
				<td>
					<input type="text" id="form-id" name="form-id" value="<?php echo $form_id; ?>"/>
				</td>
			</tr>
			<tr>
				<td></td>
				<td><input type="submit" class="submit_button" value="<?php echo $button_text; ?>"</td>
			</tr>
		</table>
	</form>

	<script type="text/javascript">

		function validate_webinar_form() {
			var title = document.forms["webinar-details"]["webinar-title"].value;
			if(title == "" || title == null) {
				alert("Webinar Title can't be empty");
				return false;
			}

			var start_time = document.forms["webinar-details"]["start-time"].value;
			var end_time = document.forms["webinar-details"]["end-time"].value;

			if(start_time > end_time) {
				alert("Start Time should be earlier than End Time");
				return false;
			}
		}

	</script>
	<?php
	
	return ob_get_clean();
}
add_shortcode("show_webinar_details", "display_webinar_details");

function display_webinar_survey_list() {
	ob_start();
	global $wpdb;
	$webinars = $wpdb->get_results("SELECT * FROM wp_webinar_list ORDER BY webinar_date DESC limit 30");
	?>

	<table class="webinar_survey_list">
		<tr>
			<td colspan="7"><button class="blue_button"><a href="/input-webinar-details/">Add New</a></button></td>
		</tr>
		<tr class="wsl_header">
			<td class="wsl_title">Webinar Title</td>
			<td class="wsl_date">Date</td>
			<td class="wsl_start">Start Time</td>
			<td class="wsl_end">End Time</td>
			<td class="wsl_link">Survey Link</td>
			<td class="wsl_responses"></td>
			<td class="wsl_summary"></td>
		</tr>
		<?php 
		foreach($webinars as $webinar){
			$id = $webinar->id;
			$title = $webinar->title;
			$webinar_date = $webinar->webinar_date;
			$start_time = $webinar->start_time;
			$end_time = $webinar->end_time;			
			$survey_link = "https://otsukahealthclone.eunika.xyzwebinar-survey-form/?webinar-ID=" . $id;
			$summary_link = "/webinar-survey-summary/?formid=" . $webinar->form_id;
			$edit_link = "/input-webinar-details/?webinar-ID=" . $id;
		?>
		<tr>
			<td class="wsl_title"><span><?php echo $title; ?></span></td>
			<td class="wsl_date"><span><?php echo $webinar_date; ?></span></td>
			<td class="wsl_start"><span><?php echo $start_time; ?></span></td>
			<td class="wsl_end"><span><?php echo $end_time; ?></span></td>
			<td class="wsl_link"><input id="survey_link_<?php echo $id; ?>" type="text" class="survey_link" value="<?php echo $survey_link;?>" readonly/><input type="button" class="copy_button" onclick="copy_to_clipboard('<?php echo $id; ?>')" value="COPY"/></td>
			<td class="wsl_responses"><a style="text-decoration: underline;" href="<?php echo $edit_link ?>">EDIT</a></td>
			<td class="wsl_summary"><button class="view_summary_btn"><a href="<?php echo $summary_link ?>">VIEW SUMMARY</a></button></td>
		</tr>
		<?php
		}
		?>
    </table>

    <script type="text/javascript">
      function copy_to_clipboard($id){
		  var textbox_id = "survey_link_" + $id;
		  var textbox_selected = document.getElementById(textbox_id);
		  textbox_selected.select();
		  textbox_selected.setSelectionRange(0, 99999);
		  document.execCommand("copy");
	  }
    </script>
	<?php
	return ob_get_clean();
}
add_shortcode('show_webinar_survey_list', 'display_webinar_survey_list');

function display_webinar_survey_summary() {
	ob_start();
	?>
    <table class="webinar_survey_summary">
	<tr>
		<td colspan="2" class="label_table">SURVEY SUMMARY</td>
	</tr>
    <?php
	$summary_text = "";
	if(isset($_GET["formid"])){
		/** Display Webinar Survey Summary **/
		
		//Get all user responses for the survey
		$responses = Ninja_Forms()->form($_GET["formid"])->get_subs();

		if(count($responses) > 0) {
			//if survey has one or more response
			$summary_array = array();
			$summary_array[] = ["label" => "Number of Responses", "value" => count($responses)];

			//get all fields of current survey
			$all_questions = Ninja_Forms()->form($_GET["formid"])->get_fields();
			$questions_to_summarize = ["listselect", "listcheckbox", "listradio"];
			foreach($all_questions as $question){
				if(in_array($question->get_setting("type"), $questions_to_summarize)){
					//put all choicces for current question into an array
					$question_choices = array();
					foreach($question->get_setting("options") as $option){
						$question_choices[$option["value"]] = ["label" => $option["label"], "count" => 0];
					}

					//loop through all submissions and update count for each choice
					foreach($responses as $response) {
						//loop through all selected choices
						if($question->get_setting("type") == "listcheckbox"){
							$keys = $response->get_field_value($question->get_setting("key"));
							foreach($keys as $checked_item){
								$question_choices[$checked_item]["count"] += 1;
							}
							/*uasort($question_choices, function($item1, $item2) { 
									return $item2["count"] <=> $item1["count"];
								});*/
						}
						else {
							$question_choices[$response->get_field_value($question->get_setting("key"))]["count"] += 1;
						}
					}

					//generate summary text
					$question_summary = "";
					foreach($question_choices as $choice){
						$question_summary .= $choice["label"] . " : " . $choice["count"] . "<br/>";
					}
					$summary_array[] = ["label" => $question->get_setting("label"), "value" => $question_summary];
				}
				else {
					/*
					$fields_to_summarize = ["home_address", "gender", "doctor_specialty"];
					if(in_array($question->get_setting("key"), $fields_to_summarize)){
						$choices_array = array();
						foreach($responses as $response){
							$choice = $response->get_field_value($question->get_setting("key"));
							if(array_key_exists($choice, $choices_array)){
								$choices_array[$choice]["count"] += 1;
							} else {
								$choices_array[$choice] = ["label" => $choice,"count" => 1];
							}
						}
						
						$field_summary = "";
						foreach($choices_array as $x){
							$field_summary .= $x["label"] . " : " . $x["count"];
						}
						$summary_array[] = ["label" => $question->get_setting("label"), "value" => $field_summary];
						
					} elseif($question->get_setting("type") != "submit"){
						
						$summary_array[] = ["label" => $question->get_setting("label"), "value" => "Summary Not Applicable"];
					}
					*/
				}
			}

			foreach($summary_array as $summary){
				?>
		        <tr>
					<td class="label_column"><?php echo $summary["label"]; ?></td>
					<td class="value_column"><?php echo $summary["value"]; ?></td>
		        </tr>
		        <?php
			}

		} else {
			//if survey has no responses
			?>
		    <tr>
				<td style="text-align: center;"><h4>This survey doesn't have any submissions.</h4></td>
		    </tr>
			<?php
		}		
	}
	?>
    </table>
    <?php
	return ob_get_clean();
}
add_shortcode('show_webinar_survey_summary', 'display_webinar_survey_summary');

function display_survey_form() {
	if(isset($_GET["webinar-ID"])){
		global $wpdb;
		$form_id = $wpdb->get_var($wpdb->prepare("SELECT form_id from wp_webinar_list where id = %d", $_GET["webinar-ID"]));
		
		return do_shortcode('[ninja_form id="' . $form_id .'"]');
	}
	
	return "";
}
add_shortcode('show_survey_form', 'display_survey_form');

function display_public_survey() {
	if(isset($_GET["form-id"])){
		return do_shortcode('[ninja_form id="' . $_GET["form-id"] . '"]');
	}
	
	return "";
}
add_shortcode('public_survey_form', 'display_public_survey');

function display_temp_login_form(){
	ob_start();
	?>
    <form name="temp-login-details" method="POST" onsubmit="return validate_temp_login_form()" action="/wp-admin/admin-post.php" autocomplete="off">
		<input type="hidden" name="action" value="temp_login"/>
		<table class="temp-login-table">
			<tr>
				<td class="temp-login-label">
					<label for="first-name">First Name: </label>
				</td>
				<td>
					<input type="text" id="first-name" name="first-name"/>
				</td>
			</tr>
			<tr>
				<td class="temp-login-label">
					<label for="middle-name">Middle Name: </label>
				</td>
				<td>
					<input type="text" id="middle-name" name="middle-name"/>
				</td>
			</tr>
			<tr>
				<td class="temp-login-label">
					<label for="last-name">Last Name: </label>
				</td>
				<td>
					<input type="text" id="last-name" name="last-name"/>
				</td>
			</tr>
			<tr>
				<td class="temp-login-label">
					<label for="primary-care-doctor">Primary Care Doctor: </label>
				</td>
				<td>
					<input type="text" id="primary-care-doctor" name="primary-care-doctor"/>
				</td>
			</tr>
			<tr>
				<td class="temp-login-label">
					<label for="doctor-specialty">Specialty of Primary Care Doctor: </label>
				</td>
				<td>
					<input type="text" id="doctor-specialty" name="doctor-specialty"/>
				</td>
			</tr>
			<tr>
				<td></td>
				<td>
					<input type="submit" class="temp-login-btn" value="Login"/>
				</td>
			</tr>
		</table>
	</form>

	<script type="text/javascript">
		function validate_temp_login_form() {
			var firstname = document.forms["temp-login-details"]["first-name"].value;
			var middlename = document.forms["temp-login-details"]["middle-name"].value;
			var lastname = document.forms["temp-login-details"]["last-name"].value;
			var doctor = document.forms["temp-login-details"]["primary-care-doctor"].value;
			var specialty = document.forms["temp-login-details"]["doctor-specialty"].value;
			if(firstname == "" || firstname == null || 
			   middlename == "" || middlename == null ||
			   lastname == "" || lastname == null ||
			   doctor == "" || doctor == null ||
			   specialty == "" || specialty == null) {
				alert("All fields are required");
				return false;
			}
		}
	</script>
	<?php
	
	return ob_get_clean();
}
add_shortcode("show_temp_login", "display_temp_login_form");

function temp_login(){
	
	$username = "temp_user_";
	$duplicate_username = true;
	while($duplicate_username){
		$random_string = "";
		$characters = "0123456789abcdefghijklmnopqrstuvwxyz";
		$length = strlen($characters);
		for($i = 0; $i < 16; $i++){
			$random_string .= $characters[rand(0, $length-1)];
		}
		$user = get_user_by('login', $username . $random_string);
		$duplicate_username = is_wp_error($user);
		if(!$duplicate_username) {
			$username .= $random_string;
		}
	}
	
	$firstname = $_POST["first-name"];
	$middlename = $_POST["middle-name"];
	$lastname = $_POST["last-name"];
	$doctor = $_POST["primary-care-doctor"];
	$specialty = $_POST["doctor-specialty"];
	
	//create new user
	$user = wp_insert_user(array(
		'user_login' => $username,
		'user_pass' => 'password',
		'user_email' => $username . '@gmail.com',
		'first_name' => $firstname,
		'last_name' => $lastname,
		'display_name' => $firstname . ' ' . $middlename . ' ' . $lastname,
		'primary_care_doctor' => $doctor,
		'doctor_specialty' => $specialty,
		'role' => 'um_tempuser'
	));
	
	/**
	if(!is_wp_error($user)){
		//if user is successfully created, initiate login process
		wp_clear_auth_cookie();
		wp_set_current_user ( $user->ID );
		wp_set_auth_cookie  ( $user->ID );
		update_user_caches($user);
	}
	*/
	
	//redirect user to livewebinar page if login is successful
	$new_user = get_user_by('login', $username);
	if(!is_wp_error($new_user)){
		wp_clear_auth_cookie();
		wp_set_current_user($new_user->ID);
		wp_set_auth_cookie($new_user->ID);
		update_user_caches($new_user);
		do_action('wp_login', $new_user->user_login, $new_user);
		$redirect_to =  "/live-webinar/?a=388-383-022";
		wp_safe_redirect( $redirect_to );
	} else {
		echo "<script>alert('". $new_user->get_error_message() ."');</script>";
	}
	
}
//add_action('admin_post_temp_login', 'temp_login');
add_action('admin_post_nopriv_temp_login', 'temp_login');

function display_zoom_register_btn($atts){
	$meetingid = $atts['meetingid'];
		$roomtype = $atts['roomtype'];
		$viewtype = $atts['viewtype'];
		$label = $atts['label'];
	
	if($viewtype != "direct" && $viewtype != "embed") { 
		$viewtype = "direct"; 
	}
	
	ob_start();
	?>
	<form name="zoomregistration" method="POST" action="/wp-admin/admin-post.php" autocomplete="off">
		<input type="hidden" name="action" value="zoom_registration"/>
		<input type="hidden" name="meetingid" value="<?php echo $meetingid; ?>"/>
		<input type="hidden" name="roomtype" value="<?php echo $roomtype; ?>"/>
		<input type="hidden" name="viewtype" value="<?php echo $viewtype; ?>"/>
		<input type="submit" class="zoom_register_btn" value="<?php echo strtoupper($label) ?>"/>
	</form>
	<?php
	return ob_get_clean();
}
add_shortcode("display_zoom_register", "display_zoom_register_btn");

function display_zoom_embed($atts){
	if(isset($_GET['tk'])){
		$title = $atts['title'];
		$meetingid = $atts['meetingid'];
		$passcode = $atts['passcode'];
		$height = $atts['height'];
		$tk = $_GET['tk'];
		
		return do_shortcode('[zoom_join_via_browser ' .
							'meeting_id="' . $meetingid . '" ' .
							'passcode="' . $passcode . '" ' .
							'title="' . $title . '" ' .
							'tk="' . $tk . '" ' .
							'height="' . $height . '" ' .
							'login_required="no" help="yes" disable_countdown="yes" webinar="no"' .
							']');
	} else {
		wp_safe_redirect("/");
	}
}
add_shortcode('zoom_embed', 'display_zoom_embed');

function zoom_registration(){
	$current_user = wp_get_current_user();
	$meetingid = $_POST["meetingid"];
	$viewtype = $_POST["viewtype"];
	$roomtype = $_POST["roomtype"];
	
	$api_endpoint = "";
		if($roomtype == "webinar"){
			$api_endpoint = "https://api.zoom.us/v2/webinars/";
		} else {
			$api_endpoint = "https://api.zoom.us/v2/meetings/";
		}

	
	//get list of registrants from Zoom API
	$data = array('headers' => array(
		'Content-Type' => 'application/json',
		'Authorization' => 'Bearer ' . generate_jwt() ));
	$response = wp_remote_get('https://api.zoom.us/v2/meetings/'. $meetingid . '/registrants', $data);
	
	if(is_wp_error($response)){
			wp_safe_redirect("/");
			return false;
		}
	
	$body = wp_remote_retrieve_body($response);
	$zoomdata = json_decode($body);
	
	$join_url = "";
	$already_registered = false;
	
	if(!empty($zoomdata)){
			//search registrants list for current user's email
			foreach($zoomdata->registrants as $x){
				if($x->email == $current_user->user_email){
					$join_url = $x->join_url;
					$already_registered = true;
					break;
				}
			}
	}
	
	//if user's email is not found, register the current user
	if(!$already_registered){
		$email = $current_user->user_email;
		//if($email == "administrator@otsuka.com.ph"){
		//	$email = "rsobremisana@aaisi.com.ph";
		//}
		
		/*$home_address = array("title" => "Home Address", 
							  "value" => $current_user->home_address);*/
		//$primary_care_doctor = array("title" => "Primary Care Doctor",Edited 4-27-2022
		$primary_care_doctor = array("title" => "Primary Care Doctor Name",							 
									 "value" => $current_user->primary_care_doctor);
		//$doctor_specialty = array("title" => "Specialty of Primary Care Doctor",Edited 4-27-2022
		$doctor_specialty = array("title" => "Primary Care Doctor Specialty", 
								  "value" => $current_user->doctor_specialty);
		
		$userdetails = array("email" => $email, 
							 "first_name" => $current_user->first_name,
							 "last_name" => $current_user->last_name,
							  "custom_questions" => array($primary_care_doctor, $doctor_specialty)
							);
		
		$data = array('headers' => array(
						'Content-Type' => 'application/json',
						'Authorization' => 'Bearer ' . generate_jwt()),
					  'body' => json_encode($userdetails)
					 );
		$response = wp_remote_post('https://api.zoom.us/v2/meetings/'. $meetingid . '/registrants', $data);
		$response_code = wp_remote_retrieve_response_code($response);
		$response_message = wp_remote_retrieve_response_message($response);
		if($response_code != "201"){
			wp_safe_redirect("/zoom-registration-test/?code=" . $response_code . "&msg=" .  urlencode($response_message));
		}
		$response = wp_remote_post($api_endpoint . $meetingid . '/registrants', $data);
			$response_code = wp_remote_retrieve_response_code($response);
			$response_message = wp_remote_retrieve_response_message($response);
			if($response_code != "201"){
				wp_safe_redirect("/?code=" . $response_code . "&msg=" .  urlencode($response_message));
			}
			$response_body = wp_remote_retrieve_body($response);
			$user_registration = json_decode($response_body);	
			$join_url = $user_registration->join_url;
	}
	
	$url_array = parse_url($join_url);
	parse_str($url_array['query'], $parameters);
	$tk = $parameters['tk'];
	$embed_url ="/zoom-webinar/?tk=" . $tk;
	
	$url_array = parse_url($join_url);
		parse_str($url_array['query'], $parameters);
		$tk = $parameters['tk'];
		$embed_url ="/zoom-embed/?tk=" . $tk;

		if($viewtype == "direct"){
			wp_redirect($join_url);
			exit;
		} else {
			wp_safe_redirect($embed_url);
		}
}
add_action('admin_post_zoom_registration', 'zoom_registration');

function generate_jwt(){
		$apikey = '5Z_k6XcOQjaDD0wBrl8eqw';
		$apisecret = 'vdZ9wpdYagRqmBrFCGSy8hBF5v5FcPQEisRe';
		$currenttime = time();
		$expiry = $currenttime + 60;

		$header_json = json_encode(['alg' => 'HS256']);
		$header_base64url = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header_json));

		$payload_json = json_encode(['aud' => null, 'iss' => $apikey, 'exp' => $expiry, 'iat' => $currenttime]);
		$payload_base64url = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($payload_json));

		$signature_hash = hash_hmac('sha256', $header_base64url . "." . $payload_base64url, $apisecret, true);
		$signature_base64url = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature_hash));

		$jwt = $header_base64url . "." . $payload_base64url . "." . $signature_base64url;
		return $jwt;
	}

function redirect_logged_in_user(){
	$page = get_queried_object();
	if($page->ID == 2542 && is_user_logged_in()){
		wp_safe_redirect("/live-webinar/?a=388-383-022");
	}
}
add_action('template_redirect', 'redirect_logged_in_user');

function php_execute($html){
	if(strpos($html,"<"."?php")!==false){ ob_start(); eval("?".">".$html);
										 $html=ob_get_contents();
										 ob_end_clean();
										}
	return $html;
}
add_filter('widget_text','php_execute',100);

// function that get root directory
function root_url() { 

	// Things that you want to do. 
	$url = site_url();

	// Output needs to be return
	return $url;
} 
// register shortcode
add_shortcode('site_url_shortcode', 'root_url'); 

// function that get user fullname
function get_user_fullname() { 

	// Things that you want to do. 
	global $current_user;
	get_currentuserinfo();

	$fullname = "<input type='hidden' id='webinar_user_name' value='". $current_user->last_name .", ". $current_user->first_name ."'><input type='hidden' id='webinar_user_email' value='". $current_user->home_address ."|" .$current_user->primary_care_doctor ."|" .$current_user->doctor_specialty ."'>";
	// Output needs to be return
	return $fullname;
} 
// register shortcode
add_shortcode('user_fullname', 'get_user_fullname'); 

function get_login_pdf($atts){
	$current_user = wp_get_current_user();
	//if ($current_user->user_email)
	//{
		$link = "<a href='" .$atts['link'] ."' target='_blank' rel='noopener noreferrer'>";
	//} else {
	//	$link = "<a href='/login'>";
	//}
	return $link;
}
// register shortcode
add_shortcode('login_pdf', 'get_login_pdf'); 

function get_login_video($atts){
	$current_user = wp_get_current_user();
	//if ($current_user->user_email)
	//{
		return do_shortcode('[popup_anything id="' .$atts['id'] .'"]');
	//} else {
	//	$link = "<a class='paoc-popup popupaoc-button' href='/login'>Watch Now!</a>";
	//}
	return $link;
}
// register shortcode
add_shortcode('login_video', 'get_login_video'); 

function get_login_webinar($atts){
	$current_user = wp_get_current_user();
	$today = new DateTime("now", new DateTimeZone('Asia/Singapore'));
	$currentDate = $today->format('Ymd');
	$start = new DateTime($atts['start_date']);
	$startDate = $start->format('Ymd');
	
	if ($current_user->user_email)
	{
		$link = "<form action='".$atts['link']."' target='_blank'>"; 
	} else {
		if ( (int)$currentDate >= (int)$startDate ){
			$link = "<form action='".$atts['link']."' target='_blank'>"; 
		}else{
			$link = "<form action='/login'>"; 
		}
	}
	$ret = $link."<button class='ait-sc-button aligncenter buticon-left simple' style='background-color: #3994e7;border-color: #3994e7;padding: 10px'><span class='container'><span class='wrap'><span class='text' style='text-align: center;padding:1px;'><span class='title' style='color: #ffffff;font-size:1.75em;padding:2px 4px;'> !CLICK HERE TO JOIN </span></span></span></span></button></form>";
	return $ret;
}
// register shortcode
add_shortcode('login_webinar', 'get_login_webinar'); 


//Function to get hospital, profession and start date
function live_webinar_info($atts){
	global $current_user;
	get_currentuserinfo();

	$profession = "<input type='hidden' id='registration-homeaddress' value='". $current_user->home_address ."'>";
	$hospital = "<input type='hidden' id='registration-specialty' value='". $current_user->doctor_specialty ."'>";
	$startDate = tribe_get_start_date( $atts['eventid'], false, 'YmdHi');
	$endDate = tribe_get_end_date( $atts['eventid'], false, 'YmdHi');

	$today = new DateTime("now", new DateTimeZone('Asia/Singapore') );
	$currentDate2 = $today->format('YmdHi');
	$currentDate = $today->add(new DateInterval('PT1H'))->format('YmdHi');

	$status = "";
	if ( (int)$currentDate >= (int)$startDate ){
		$status = '1';
	} else {
		$status = '0';
	}

	$status2 = "";
	if ( (int)$currentDate2 >= (int)$endDate ){
		$status2 = '1';
	} else {
		$status2 = '0';
	}

	$webinarStatus = "<input type='hidden' id='registration-webinar-status".$atts['eventid']."' value='". $status ."'>";
	$checkEmail = check_rtec_email_db($atts['eventid'], $current_user->user_email);

	$registration = "<div id='btn-registration".$atts['eventid']."' class= '". ((($checkEmail == '0' AND $status2 == '0') OR $status2 == '1') ? '' : 'hide-registered-label') ."'>" . do_shortcode('[rtec-registration-form event='.$atts['eventid'].']') ."</div>";
	$registeredLabel = "<h3 id='registration-status".$atts['eventid']."' class='".(($checkEmail == '1' AND $status == '0' AND $status2 == '0') ? '' : 'hide-registered-label')."' style='margin-left: 3%;margin-right: 3%;'><strong style='color:#6dc1d8;'>YOU ARE ALREADY REGISTERED<br/>PLEASE COME BACK TO THIS WEBSITE ON THE SCHEDULED WEBINAR DATE AND TIME</strong></h3>";
	$joinNowButton = "<a id='ait-sc-button-1".$atts['eventid']."' class='ait-sc-button aligncenter buticon-left simple ".(($checkEmail == '1' AND $status == '1' AND $status2 == '0') ? '' : 'hide-registered-label')."' style='width: 180px; background-color: #3994e7; border-color: #3994e7;' href='/live-webinar/?a=".$atts['eventroom']."'> <span class='container'><span class='wrap'><span class='text' style='text-align: center;'><span class='title' style='color: #ffffff;'> JOIN NOW </span></span></span></span></a>";


	return $profession .$hospital .$webinarStatus .$registration .$registeredLabel .$joinNowButton;
}
add_shortcode('live_webinar_addtional_info', 'live_webinar_info');


//Get User Avatar
function get_user_avatar(){
	global $current_user;
	get_currentuserinfo();

	$avatar = "<input type='hidden' id='webinar-user-avatar' value='". um_get_user_avatar_url( $user_id = '', $size = '96' ) ."'>";
	return $avatar;
}
add_shortcode('user_avatar', 'get_user_avatar'); 


function check_rtec_email_db($eventid, $email){
	if ( class_exists( 'RTEC_db' ) ) {
		$args = array('fields' => array( 'email' ),
					  'where' => array(
						  array( 'event_id', $eventid, '=', 'int' )
					  ),
					  'order_by' => 'registration_date'
					 );

		$rtec = RTEC();
		$entries = $rtec->db_frontend->retrieve_entries( $args );

		if ( isset( $entries[0] ) ) {
			foreach ( $entries as $entry ) {
				if ( $email == maybe_unserialize($entry['email'])){
					return 1;	
				}
			}
			return 0;
		} else {
			return 0;
		}
	}
}