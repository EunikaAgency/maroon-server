
<?php do_action('before_different_menus_settings_page_start'); ?>

<div id="different-menus-settings-page">
    <!-- <div class="section"> -->
    <div class="container-fluid border-bottom mb-3">
        <div class="row pt-3 pb-3">
            <div class="col-md-12">
                <h4 class="border-bottom pb-1"><span class="dashicons dashicons-image-filter" style="color: #4ab722;position: relative;top: 6px;"></span> <?php esc_html_e('Different menus in different pages', 'different-menu'); ?> <span class="badge badge-secondary">v<?php echo esc_html($this->version); ?></span></h4>
            </div>
        </div>

        <div class="alert alert-danger">
            <?php
            // Translate the string with translator comment for placeholders
            /* translators: %s is a placeholder for 'menu items' */
            $translated_string = esc_html__('To apply visibility settings exclusively to %s, navigate to the menu settings page and adjust the visibility options there. To set advanced condition on menus you may setup here.', 'different-menu');

            // Define the placeholder without HTML tags
            $menu_items_placeholder = __('menu items', 'different-menu');

            // Output the translated string with injected HTML tags
            echo sprintf(esc_html($translated_string), '<b>' . $menu_items_placeholder . '</b>');

            ?>


        </div>


        <?php
		  		$name 		= get_registered_nav_menus();
		  		$menu_items = $menus = wp_get_nav_menus();
		  		$locations 	= get_nav_menu_locations();

		  	    $post_types =  get_post_types( array( 'public' => true ) );
				unset( $post_types['page'] );
				$post_types = array_map( 'get_post_type_object', $post_types );

				$taxonomies = get_taxonomies( array( 'public' => true ) );
				unset( $taxonomies['category'] );
				$taxonomies = array_map( 'get_taxonomy', $taxonomies );
                $posts_per_page = 4;

			?>

            <div class="row">
                <div class="col-md-8 border-right">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col"><?php esc_html_e('Theme Location', 'different-menu'); ?></th>
                                <th scope="col"><?php esc_html_e('Assigned Menu', 'different-menu'); ?></th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            $menu_count = 0;
                            if (!empty($locations)){
					  		foreach ($locations as $location => $value) {
                                if (isset($name[$location])&&!empty($value)) {
					  			$menu_objects = wp_get_nav_menu_object($value);
					  			$term_id = (isset($menu_objects->term_id))?$menu_objects->term_id:"0";
					  			?>
                                <tr>
                                    <td location="<?php echo esc_attr($location); ?>">
                                        <?php echo esc_html($name[$location]); ?>
                                    </td>

                                    <td>
                                        <div class="default_menu clearfix">
                                            <select disabled class="form-control col-sm-6 float-left mr-2 assigned_menu" id="menu_items" style="">
                                                <?php
                                                foreach ($menu_items as $key => $value) {
                                                    ?>
                                                    <option slug="<?php echo esc_attr($value->slug); ?>" value="<?php echo esc_attr($value->term_id); ?>" <?php echo ($term_id == $value->term_id) ? "selected" : ""; ?>>
                                                        <?php echo esc_html($value->name); ?>
                                                    </option>
                                                    <?php
                                                }
                                                ?>

                                            </select>
                                            <span class="default description"><?php esc_html_e('Default', 'different-menu'); ?></span>
                                        </div>

                                        <div class="different_menus_list">
                                            <?php 
	$different_menus = get_option('different_menus_for_different_page');

	$assigned_menu = isset($different_menus[get_stylesheet()][$location])? $different_menus[get_stylesheet()][$location] : array();

if (isset($assigned_menu)) {
    $menu_count++;

        foreach ($assigned_menu as $menu_id => $conditions) {

            $disable_menu = esc_attr($menu_id);
            $menu_id = str_replace("menu_", "", $menu_id);

            ?>
									<div class="menu_items clearfix">
                                        <select class="form-control col-sm-6 float-left mr-2 assigned_menu" id="menu_items" selected_menu="<?php echo esc_attr($menu_id); ?>">
                                            <option><?php esc_html_e('- Select a Menu -', 'different-menu'); ?></option>
                                            <?php foreach ($menu_items as $key => $value) { ?>
                                                <option slug="<?php echo esc_attr($value->slug); ?>" value="<?php echo esc_attr($value->term_id); ?>" <?php echo ($menu_id == $value->term_id) ? "selected" : ""; ?>>
                                                    <?php echo esc_html($value->name); ?>
                                                </option>
                                            <?php } ?>
                                        </select>


                                        <?php

                                                	$conditions = $conditions['name'];

                                                	$single_condition = "";
                                                	foreach ($conditions as $condition) {
                                                		$single_condition .= '[name=\'' . $condition . "'],";
                                                	}

                                                	$single_condition = rtrim($single_condition, ",");
                                                ?>
                                        <a href="#" class="setup button" data-toggle="modal" conditions="<?php echo esc_attr($single_condition); ?>"><i class="dmi dm-cogs" style="padding-right: 3px;position: relative;top: 2px;"></i> <?php esc_html_e('Setup', 'different-menu'); ?></a>

                                        <button type="button" class="close menu-delete float-left" aria-label="Close" data-toggle="tooltip" data-placement="top" title="<?php echo esc_attr('Remove this menu', 'different-menu'); ?>">
												  <span aria-hidden="true">&times;</span>
												</button>
											</div>
                                                <?php } }  ?>


                                        </div>
                                        <div class="content">
                                            <a href="#" class="btn right add_different_menu">
                                                <span class="left title">
										    		<span class="slant-left"></span>
										    		<?php esc_html_e('Add Different Menu', 'different-menu'); ?>
												</span>
                                                <span class="right icon dmi dm-plus-square"></span>
                                            </a>
                                        </div>

                                    </td>
                                </tr>



<?php

                            }
                            }
					  		}//end location foreach
                            

                            if ($menu_count == 0) {
                                echo '<tr><td>You didn\'t created any menu yet! <a href="nav-menus.php" style="color: #007bff;">Create here!</a></td></tr>';
                            }
					  	 ?>
                        </tbody>
                    </table>


            
<?php 

    $theme_builders = get_option('elementor_pro_theme_builder_conditions');

    if (is_plugin_active( 'elementor/elementor.php')&&!empty($theme_builders)) {

?>
<table class="table elementor_dm">

    <thead>
        <tr>
            <th>
                <h2 class="elementor-dm-section">Elementor Section</h2>

                 <div class="premium">This option is available for premium version only <span class="go_pro2"><a href="https://myrecorp.com/product/different-menus-in-different-pages/?clk=elementor_sec&a=pro">Buy Now</a></span></div>
            </th>
        </tr>
        <tr>
            <th scope="col">Theme Location</th>
            <th scope="col">Assigned Menu</th>
        </tr>
    </thead>
    <tbody>

    <?php
        $theme_builders = array_reverse($theme_builders);

        foreach ($theme_builders as $key => $builder) {
            $key_name = $key;
            $page_id = key($builder);

            $data = get_post_meta($page_id, '_elementor_data', true);

            if (!empty($data)) {
                if (strpos($data, '"menu":"')!==false||strpos($data, '"nav_menu":"')!==false) {

                    if (strpos($data, '"menu":"')!==false) {
                        preg_match("/(?<=\"menu\"\:\").*?(?=\")/", $data, $match);
                        $term = get_term_by( 'slug', $match[0], 'nav_menu' );
                        $match = $term->term_id;
                    }
                    elseif(strpos($data, '"nav_menu":"')!==false){
                        preg_match("/(?<=\"nav_menu\"\:\").*?(?=\")/", $data, $match);
                        $match = $match[0];
                    }
                $e_menu_id = $match;

                ?>

        <tr>

            <td location="elementor-<?php echo esc_attr($key_name); ?>">
                Elementor <?php echo esc_html($key_name); ?>
            </td>

            <td>
              <div class="default_menu clearfix">
                  <select class="form-control col-sm-6 float-left mr-2 assigned_menu" id="menu_items" style="">
                      <?php
                      foreach ($menu_items as $key => $value) {
                          ?>
                          <option slug="<?php echo esc_attr($value->slug); ?>" value="<?php echo esc_attr($value->term_id); ?>" <?php echo ($e_menu_id == $value->term_id) ? "selected" : ""; ?>>
                              <?php echo esc_html($value->name); ?>
                          </option>
                          <?php
                      }
                      ?>
                  </select>

                  <span class="default description">Default</span>
              </div>
        <div class="different_menus_list">
        <?php 
            $different_menus = get_option('different_menus_for_different_page');
            $elementor_location = 'elementor-' . $key_name;
            $assigned_menu = isset($different_menus[get_stylesheet()][$elementor_location])? $different_menus[get_stylesheet()][$elementor_location] : array();

        if (isset($assigned_menu)) {

                foreach ($assigned_menu as $menu_id => $conditions) { 

                    $disable_menu = $menu_id;
                    $menu_id = str_replace("menu_", "", $menu_id);
                ?>                          
        <div class="menu_items clearfix">
            <select class="form-control col-sm-6 float-left mr-2 assigned_menu" id="menu_items" selected_menu="<?php echo esc_attr($menu_id); ?>">
                <option><?php esc_html_e('- Select a Menu -', 'different-menu'); ?></option>
                <option value="0" <?php echo ($menu_id == "0") ? "selected" : ""; ?>>Disable</option>
                <?php foreach ($menu_items as $key => $value) { ?>
                    <option slug="<?php echo esc_attr($value->slug); ?>" value="<?php echo esc_attr($value->term_id); ?>" <?php echo ($menu_id == $value->term_id) ? "selected" : ""; ?>>
                        <?php echo esc_html($value->name); ?>
                    </option>
                <?php } ?>
            </select>


            <?php

                        $conditions = $conditions['name'];

                        $single_condition = "";
                        foreach ($conditions as $condition) {
                            $single_condition .= '[name=\'' . $condition . "'],";
                        }

                        $single_condition = rtrim($single_condition, ",");
                    ?>
            <a href="#" class="setup button" data-toggle="modal" conditions="<?php echo esc_attr($single_condition); ?>"><i class="dmi dm-cogs"></i> Setup</a>

            <button type="button" class="close menu-delete float-left" aria-label="Close" data-toggle="tooltip" data-placement="top" title="<?php echo esc_attr('Remove this menu', 'different-menu'); ?>">
                      <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                    <?php } }  ?>
            </div>

              <div class="content">
                 <a href="#" class="btn right add_different_menu">
                 <span class="left title">
                 <span class="slant-left"></span>
                 Add Different Menu                                             </span>
                 <span class="right icon"><i class="dmi dm-plus-square"></i></span>
                 </a>
              </div>

           </td>
        </tr>                    <?php
                }
            }
        }
        ?>


    </tbody>
</table>
<?php
    }
 ?>

                    <div class="all_menu_options" style="display: none;">

                        <div class="new_different_menu menu_items clearfix">
                            <select class="form-control col-sm-6 float-left mr-2 assigned_menu" id="menu_items" style="">
                                <option value=""><?php esc_html_e('- Select a Menu -', 'different-menu'); ?></option>
                                <?php 
				      		foreach ($menu_items as $key => $value) {
		  				?>
                                <option slug="<?php echo esc_attr($value->slug); ?>" value="<?php echo esc_attr($value->term_id); ?>">
                                    <?php echo esc_html($value->name); ?>
                                </option>

                                <?php
			  				}
				      	?>
                            </select>

                            <a href="#" class="setup button" data-toggle="modal"><i class="dmi dm-cogs" style="padding-right: 3px;position: relative;top: 2px;"></i><?php esc_html_e('Setup', 'different-menu'); ?></a>
                            <button type="button" class="close tmp-remove-menu float-left" aria-label="Close" data-toggle="tooltip" data-placement="top" title="" data-original-title="Remove this menu">
                            <span aria-hidden="true">×</span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 support">
                    <div class="created py-2 mt-1 border-bottom"> <?php esc_html_e('Created by', 'different-menu'); ?> <a href="https://myrecorp.com/?clk=wp"><img src="<?php echo esc_url( plugins_url( 'images/recorp-logo.png', __FILE__ ) ); ?>" alt="ReCorp" width="100"></a></div>

                    <div class="documentation my-2">
                      <a href="https://myrecorp.com/different-menus/documentation/?clk=wp"><?php esc_html_e('Documentation', 'different-menu'); ?></a>
                  </div>
                    <div class="documentation my-2">
                          <a href="https://myrecorp.com/contact-us/"><?php esc_html_e('Support', 'different-menu'); ?></a>
                    </div> 

                    <div class="pro mt-3">
                        <span class="go_pro"><a href="https://myrecorp.com/product/different-menus-in-different-pages/?clk=wp&a=pro"><?php esc_html_e('Go to pro', 'different-menu'); ?></a></span>

                        <!--
                          <br>

                        <span style="position: relative; top: 30px;font-weight: bold;"> We are offering 20% discount for you for very limited time! </span> -->
                    </div> 

                    <div class="right_side_notice mt-4">
                        <?php do_action('dmidp_right_side_notice'); ?>
                    </div>

                    <div class="plugin_rating mt-4">
                        <p id="rate-left" class="alignleft">
                        If you like <strong>this plugin</strong> please leave us a <a href="https://wordpress.org/support/plugin/different-menus-in-different-pages/reviews?rate=5#new-post" target="_blank" class="wc-rating-link" aria-label="five star" data-rated="Thanks :)">★★★★★</a> rating. <br>A huge thanks in advance!  </p>
                        
                    </div>
<!-- 
                    <div class="pro mt-5" style="position: relative; top: 15px;">
                          <span class="go_pro"><a href="https://myrecorp.com/product/different-menus-in-different-pages-trial/?clk=wp&r=free" style="background-color: #ff6e00;">Download Trial Version</a></span>
                            <br>

                          <span style="position: relative; top: 30px;font-weight: bold;"> No credit card needed! </span>
                    </div>  -->



                 </div>
            </div>
    </div>
    <!-- </div> -->
</div>
<?php 
    
    do_action('after_different_menus_settings_page_end');
  
 ?>
<div class="checked_items" style="display:none"></div>

<?php



	?>

	<button class="btn btn-danger" type="reset" data-toggle="modal" data-target="#resetDifferentMenusConditions"><?php esc_html_e('Reset', 'different-menu'); ?></button>

    <!--  data-toggle="tooltip" data-title="<?php esc_html_e('This option is available for premium version only', 'different-menu'); ?>" -->

<span class="d-inline-block">
	<button type="button" class="btn btn-success backup-restore" data-toggle="modal" data-target="#backupAndRestore">

  <?php esc_html_e('Backup or Restore', 'different-menu'); ?>
</button>
</span>

<a href="nav-menus.php" class="btn go-to-menu-settings float-right mr-3"><?php esc_html_e('Menu Settings Page', 'different-menu'); ?></a>

<a href="" class="btn btn-success float-right text-white mr-3" data-toggle="modal" data-target="#duplicate_menu"><?php esc_html_e('Duplicate Menus', 'different-menu'); ?></a>


    <input type="hidden" class="setup_active_menu">
    <input type="hidden" class="change_selected_menu">
