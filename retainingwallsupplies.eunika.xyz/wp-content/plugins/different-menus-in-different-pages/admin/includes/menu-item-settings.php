<?php
namespace DifferentMenuItemSettings;

class DifferentMenuItemSettings {
    /**
     * DifferentMenuItemSettings constructor.
     * Hook methods to appropriate WordPress actions and filters when the class is instantiated.
     *
     * @since    2.3.0
     * @access   public
     */
    
    public function __construct() {

        // Hook methods to appropriate WordPress actions and filters when the class is instantiated.
        add_action('admin_enqueue_scripts', array($this, 'enqueue_scripts'));
        add_action('wp_nav_menu_item_custom_fields', array($this, 'add_menu_item_fields'), 2, 4);
        add_action('wp_update_nav_menu_item', array($this, 'save_menu_item_fields'), 10, 3);

        add_filter('wp_get_nav_menu_items', [$this, 'hide_menu_items_for_logged_in_users'], 10, 3);

        add_action('admin_menu', [$this, 'custom_nav_menu_metabox']);


        add_filter('walker_nav_menu_start_el', [$this, 'add_icon_to_menu_item'], 10, 4);

    }

    /**
     * Enqueue necessary scripts for the admin page.
     *
     * @since    2.3.0
     * @access   public
     * @param    string    $hook    The current admin page.
     */

    public function enqueue_scripts($hook) {
        if ($hook === 'nav-menus.php') {
            wp_enqueue_script('different-menu', plugin_dir_url(__DIR__) . 'js/menu-item-settings.js', array('jquery'), '1.0.0', true);
            wp_enqueue_style( 'menu_page', plugin_dir_url( __FILE__ ) . 'css/menu-page.css', array(), '4.3.1', 'all' );

        }
    }

    /**
     * Add custom fields to menu items in the admin.
     *
     * @since    2.3.0
     * @access   public
     * @param    int       $item_id    The ID of the menu item being edited.
     * @param    object    $item       The menu item object.
     * @param    int       $depth      The depth of the menu item.
     * @param    object    $args       The menu item arguments.
     */
    public function add_menu_item_fields($item_id, $item, $depth, $args) {
        // Retrieve various meta values for the menu item.
        $who_will_see_the_link = get_post_meta($item_id, '_who_will_see_the_link', true);
        $different_menu_user_role = get_post_meta($item_id, '_different_menu_user_role', true);
        $different_menu_user_roles = get_post_meta($item_id, '_different_menu_user_roles', true);
        $user_avatar = get_post_meta($item_id, '_user_avatar', true);
        $user_avatar_border_radius_type = get_post_meta($item_id, '_user_avatar_border_radius_type', true);
        $user_avatar_border_radius_type = !empty($user_avatar_border_radius_type) ? $user_avatar_border_radius_type : 'rounded';

        $user_avatar_border_radius = get_post_meta($item_id, '_user_avatar_border_radius', true);
        $user_avatar_border_radius = !empty($user_avatar_border_radius) ? $user_avatar_border_radius : '4';

        $different_menu_redirect_after = get_post_meta($item_id, '_different_menu_redirect_after', true);
        $different_menu_redirect_after = !empty($different_menu_redirect_after) ? $different_menu_redirect_after : 'default';

        $redirect_after_to_custom_url = get_post_meta($item_id, '_redirect_after_to_custom_url', true);
        $redirect_after_to_custom_url = !empty($redirect_after_to_custom_url) ? $redirect_after_to_custom_url : '';

        $type = $item->type;

        ?>

        <?php if($type == 'register' || $type == 'login' || $type == 'logout'): ?>
        <?php
            $text = "";
            if ($type=='register'){
                $text = 'registration';
            }
            if ($type=='login'){
                $text = 'login';
            }
            if ($type=='logout'){
                $text = 'logout';
            }
        ?>

        <!--Output HTML for different fields based on the menu item type.-->
        <p class="different-menu-item description  description-wide">
            <label for="different-menu-redirect-after-<?php echo esc_attr($item_id); ?>">
                <?php esc_html_e('Redirect after', 'different-menu'); echo ' ' . esc_html($text); ?>

                <br>
                <select name="different-menu-redirect-after[<?php echo esc_attr($item_id); ?>]" id="different-menu-redirect-after-<?php echo esc_attr($item_id); ?>">
                    <option value="default" <?php selected($different_menu_redirect_after, 'default') ?>><?php esc_html_e('Default', 'different-menu'); ?></option>
                    <option value="current" <?php selected($different_menu_redirect_after, 'current') ?>><?php esc_html_e('Current Page', 'different-menu'); ?></option>
                    <option value="home" <?php selected($different_menu_redirect_after, 'home') ?>><?php esc_html_e('Home Page', 'different-menu'); ?></option>
                    <option value="custom" <?php selected($different_menu_redirect_after, 'custom') ?>><?php esc_html_e('Custom Page', 'different-menu'); ?></option>
                </select>
            </label>
        </p>
        <p class="different-menu-item redirect-after-to-custom-url description description-wide" style="display: <?php echo $different_menu_redirect_after == "custom" ? 'block': 'none'; ?>">
            <label for="redirect-after-to-custom-url[<?php echo esc_attr($item_id); ?>]">
                <?php esc_html_e('Custom URL to redirect', 'different-menu'); ?><br>
                <input type="text" placeholder="https://example.com" name="redirect-after-to-custom-url[<?php echo esc_attr($item_id); ?>]" id="redirect-after-to-custom-url[<?php echo esc_attr($item_id); ?>]" value="<?php echo !empty($redirect_after_to_custom_url) ? esc_url($redirect_after_to_custom_url): ''; ?>" class="widefat code">
            </label>
        </p>
        <?php endif; ?>

            <!--Output HTML for the "Insert shortcode" button.-->
        <div class="diffrent-menu-item-shortcode-btn for-logged-in-users" sub-settings-for="logged_in_users" style="display: <?php echo $who_will_see_the_link == "logged_in_users" ? 'block' : 'none'; ?>"><button class="button insert-user-shortcode">Insert shortcode</button></div>
        <p class="different-menu-item avatar-size description description-wide" style="display: <?php echo strpos(get_the_title($item_id), '{avatar}') !== false ? 'block': 'none'; ?>">
            <label for="user-avatar[<?php echo esc_attr($item_id); ?>]">
                <?php esc_html_e('Avatar Size (px)', 'different-menu'); ?><br>
                <input type="number" min="0" step="1" name="user-avatar[<?php echo esc_attr($item_id); ?>]" id="user-avatar[<?php echo esc_attr($item_id); ?>]" value="<?php echo !empty($user_avatar) ? esc_attr($user_avatar) : '24'; ?>" class="widefat  code">
            </label>
        </p>

        <p class="different-menu-item avatar-radius-type description description-wide" style="display: <?php echo strpos(get_the_title($item_id), '{avatar}') !== false ? 'block': 'none'; ?>">
            <label for="user-avatar-border-radius-type[<?php echo esc_attr($item_id); ?>]">
                <input type="radio" name="user-avatar-border-radius-type[<?php echo esc_attr($item_id); ?>]" id="user-avatar-border-radius-type[<?php echo esc_attr($item_id); ?>]" value="rounded" class="widefat  code" <?php checked($user_avatar_border_radius_type, 'rounded'); ?>>
                <?php esc_html_e('Rounded Avatar', 'different-menu'); ?>
            </label>
            <br>
            <label for="user-avatar-border-radius-type2[<?php echo esc_attr($item_id); ?>]">
                <input type="radio" name="user-avatar-border-radius-type[<?php echo esc_attr($item_id); ?>]" id="user-avatar-border-radius-type2[<?php echo esc_attr($item_id); ?>]" value="border-radius" class="widefat  code" <?php checked($user_avatar_border_radius_type, 'border-radius'); ?>>
                <?php esc_html_e('Avatar border radius', 'different-menu'); ?>
            </label>
            <br>
            <!--<span style="color: red;">Pro version only </span> <a href="https://myrecorp.com/different-menu-in-different-pages/?r=menu-item" target="_blank"> Go to pro</a>-->
        </p>

        <!--Output HTML for avatar size and border radius settings.-->
        <p class="different-menu-item avatar-border-radius description description-wide" style="display: <?php echo strpos(get_the_title($item_id), '{avatar}') !== false && $user_avatar_border_radius_type == "border-radius" ? 'block': 'none'; ?>">
            <label for="user-avatar-border-radius[<?php echo esc_attr($item_id); ?>]">
                <?php esc_html_e('Border radius', 'different-menu'); ?><br>
                <input type="number" min="0" step="1" name="user-avatar-border-radius[<?php echo esc_attr($item_id); ?>]" id="user-avatar-border-radius[<?php echo esc_attr($item_id); ?>]" value="<?php echo esc_attr($user_avatar_border_radius); ?>" class="widefat code">
            </label>
        </p>

        <!--Output HTML for who will see the link settings.-->
        <p class="different-menu-item description  description-wide">
            <label for="who-will-see-the-link-<?php echo esc_attr($item_id); ?>">
                <?php esc_html_e('Who will see the link?', 'different-menu'); ?>
                <br>
                <select name="who-will-see-the-link[<?php echo esc_attr($item_id); ?>]" id="who-will-see-the-link-<?php echo esc_attr($item_id); ?>" <?php echo ($type == 'register'||$type == 'login'||$type == 'logout') ? 'disabled': ''; ?>>
                    <option value="everyone" <?php selected($who_will_see_the_link, 'everyone') ?>><?php esc_html_e('Everyone', 'different-menu'); ?></option>
                    <option value="logged_in_users" <?php echo ($type == 'logout') ? 'selected': selected($who_will_see_the_link, 'logged_in_users', false); ?>><?php esc_html_e('Logged in users', 'different-menu'); ?></option>
                    <option value="logged_out_users" <?php echo ($type == 'register'||$type == 'login') ? 'selected':  selected($who_will_see_the_link, 'logged_out_users', false) ?>><?php esc_html_e('Logged out users', 'different-menu'); ?></option>
                </select>
            </label>
        </p>

        <!--Output HTML for user role visibility settings.-->
        <p class="different-menu-item for-logged-in-users description  description-wide" style="display: <?php echo $who_will_see_the_link == "logged_in_users" ? 'block' : 'none'; ?>">
            <label for="user-role-will-see-the-link-<?php echo esc_attr($item_id); ?>">
                <input id="user-role-will-see-the-link-<?php echo esc_attr($item_id); ?>" type="radio" name="diffrent-menu-user-role[<?php echo esc_attr($item_id); ?>]" value="will_see"  <?php checked($different_menu_user_role, 'will_see'); ?>>
                <?php esc_html_e('User role will see the link', 'different-menu'); ?>
            </label>
            <br>
            <label for="user-role-will-not-see-the-link-<?php echo esc_attr($item_id); ?>">
                <input id="user-role-will-not-see-the-link-<?php echo esc_attr($item_id); ?>" type="radio" name="diffrent-menu-user-role[<?php echo esc_attr($item_id); ?>]" value="will_not_see" <?php checked($different_menu_user_role, 'will_not_see'); ?>>
                <?php esc_html_e('User role will not see the link', 'different-menu'); ?>
            </label>
        </p>

        <!--Output HTML for user roles visibility settings.-->
        <p class="different-menu-item user-roles for-logged-in-users description  description-wide" style="display: <?php echo $who_will_see_the_link == "logged_in_users" ? 'block' : 'none'; ?>">
            <?php
            $output = "";
            foreach( $GLOBALS['wp_roles']->roles as $key => $role ) {
                $checked = in_array($role['name'], explode(',', $different_menu_user_roles)) ? 'checked': "";
                $output .= '<label><input type="checkbox" name="diffrent-menu-user-roles['.esc_attr($item_id).']['.esc_attr($role['name']).']" '.$checked.'  />' . esc_html($role['name']) . '</label>';
            }

            echo $output;
            ?>

        </p>

        <!--Output HTML for a popup with available shortcodes.-->
        <div class="popup" id="userPopup">
            <ul class="options-list">
                <li title="<?php esc_attr_e('Click to insert the {avatar} shortcode.'); ?>" shortcode="{avatar}"><?php esc_attr_e('Avatar', 'different-menu'); ?></li>
                <li title="<?php esc_attr_e('Click to insert the {username} shortcode.'); ?>" shortcode="{username}"><?php esc_attr_e('Username', 'different-menu'); ?></li>
                <li title="<?php esc_attr_e('Click to insert the {first_name} shortcode.'); ?>" shortcode="{first_name}"><?php esc_attr_e('First Name', 'different-menu'); ?></li>
                <li title="<?php esc_attr_e('Click to insert the {last_name} shortcode.'); ?>" shortcode="{last_name}"><?php esc_attr_e('Last Name', 'different-menu'); ?></li>
                <li title="<?php esc_attr_e('Click to insert the {display_name} shortcode.'); ?>" shortcode="{display_name}"><?php esc_attr_e('Display Name', 'different-menu'); ?></li>
                <li title="<?php esc_attr_e('Click to insert the {nickname} shortcode.'); ?>" shortcode="{nickname}"><?php esc_attr_e('Nickname', 'different-menu'); ?></li>
                <li title="<?php esc_attr_e('Click to insert the {email} shortcode.'); ?>" shortcode="{email}"><?php esc_attr_e('Email', 'different-menu'); ?></li>
            </ul>
        </div>


        <?php
        wp_nonce_field( 'fmidp_menu_nonce_action', 'fmidp_menu_nonce' );
    }

    /**
     * Save custom fields for menu items.
     *
     * @since    2.3.0
     * @access   public
     * @param    int       $menu_id         The ID of the menu.
     * @param    int       $menu_item_db_id The ID of the menu item being edited.
     * @param    array     $args            The menu item arguments.
     */

    public function save_menu_item_fields($menu_id, $menu_item_db_id, $args) {
        if ( ! isset( $_POST['fmidp_menu_nonce'] ) || ! wp_verify_nonce( $_POST['fmidp_menu_nonce'], 'fmidp_menu_nonce_action' ) ) {
            return;
        }

        if (isset($_POST['who-will-see-the-link'][$menu_item_db_id])) {
            update_post_meta($menu_item_db_id, '_who_will_see_the_link', sanitize_key($_POST['who-will-see-the-link'][$menu_item_db_id]));
        } else {
            delete_post_meta($menu_item_db_id, '_who_will_see_the_link');
        }

        if (isset($_POST['diffrent-menu-user-role'][$menu_item_db_id]) && isset($_POST['diffrent-menu-user-roles'][$menu_item_db_id])) {
            update_post_meta($menu_item_db_id, '_different_menu_user_role', sanitize_key($_POST['diffrent-menu-user-role'][$menu_item_db_id]));
        } else {
            delete_post_meta($menu_item_db_id, '_different_menu_user_role');
        }

        if (isset($_POST['diffrent-menu-user-roles'][$menu_item_db_id])) {
            update_post_meta($menu_item_db_id, '_different_menu_user_roles', sanitize_text_field(implode(',', array_keys($_POST['diffrent-menu-user-roles'][$menu_item_db_id]))));
        } else {
            delete_post_meta($menu_item_db_id, '_different_menu_user_roles');
        }

        if (isset($_POST['user-avatar'][$menu_item_db_id])) {
            update_post_meta($menu_item_db_id, '_user_avatar', sanitize_key($_POST['user-avatar'][$menu_item_db_id]));
        } else {
            delete_post_meta($menu_item_db_id, '_user_avatar');
        }

        if (isset($_POST['user-avatar-border-radius-type'][$menu_item_db_id])) {
            update_post_meta($menu_item_db_id, '_user_avatar_border_radius_type', sanitize_key($_POST['user-avatar-border-radius-type'][$menu_item_db_id]));
        } else {
            delete_post_meta($menu_item_db_id, '_user_avatar_border_radius_type');
        }

        if (isset($_POST['user-avatar-border-radius'][$menu_item_db_id])) {
            update_post_meta($menu_item_db_id, '_user_avatar_border_radius', sanitize_key($_POST['user-avatar-border-radius'][$menu_item_db_id]));
        } else {
            delete_post_meta($menu_item_db_id, '_user_avatar_border_radius');
        }

        if (isset($_POST['different-menu-redirect-after'][$menu_item_db_id])) {
            update_post_meta($menu_item_db_id, '_different_menu_redirect_after', sanitize_key($_POST['different-menu-redirect-after'][$menu_item_db_id]));
        } else {
            delete_post_meta($menu_item_db_id, '_different_menu_redirect_after');
        }

        if (isset($_POST['redirect-after-to-custom-url'][$menu_item_db_id])) {
            update_post_meta($menu_item_db_id, '_redirect_after_to_custom_url', sanitize_text_field($_POST['redirect-after-to-custom-url'][$menu_item_db_id]));
        } else {
            delete_post_meta($menu_item_db_id, '_redirect_after_to_custom_url');
        }

    }

    /**
     * Hide menu items based on user roles.
     *
     * @since    2.3.0
     * @access   public
     * @param    array     $items     The array of menu items.
     * @param    object    $menu      The menu object.
     * @param    array     $args      The menu arguments.
     * @return   array                The filtered array of menu items.
     */
    function hide_menu_items_for_logged_in_users($items, $menu, $args) {
        if (!is_admin()){
            foreach ($items as $key => $item) {
                $who_will_see_the_link = get_post_meta($item->ID, '_who_will_see_the_link', true);
                $different_menu_user_role = get_post_meta($item->ID, '_different_menu_user_role', true);
                $different_menu_user_roles = get_post_meta($item->ID, '_different_menu_user_roles', true);

                if ($item->object == "login" || $item->object == "register" ){
                    $who_will_see_the_link = 'logged_out_users';
                }
                if ($item->object == "logout"){
                    $who_will_see_the_link = 'logged_in_users';
                }

                if (
                    ( ( ($who_will_see_the_link == 'logged_in_users' && is_user_logged_in()) &&
                            ($different_menu_user_role == "will_see" && empty(array_intersect( explode(',', strtolower($different_menu_user_roles)), wp_get_current_user()->roles ))) ||
                            ($different_menu_user_role == "will_not_see" && empty(array_intersect( explode(',', strtolower($different_menu_user_roles)), wp_get_current_user()->roles )) ) ) ||
                        ($who_will_see_the_link == 'logged_in_users' && !is_user_logged_in())
                    ) ||
                    ($who_will_see_the_link == 'logged_out_users' && is_user_logged_in())
                ) {

                    unset($items[$key]);
                }

                $item->title = $this->replace_placeholders($item->title, $item->ID);
                $item->url = $this->setURLs($item);


            }
        }

        return $items;
    }

    /**
     * Set the URLs for different menu item types.
     *
     * @since    2.3.0
     * @access   public
     * @param    object    $item    The menu item object.
     * @return   string             The modified URL for the menu item.
     */
    public function setURLs($item)
    {
        $type = $item->object;

        $url = $item->url;
        $redirect_url = $this->getRedirectURL($item->ID);

        switch ($type) {
            case "logout":
                $url = wp_logout_url($redirect_url);
                break;
            case "login":
                $url = wp_login_url($redirect_url);
                break;
            case "register":
                $url = wp_registration_url($redirect_url);
                break;
        }

        return $url;
    }

    public function getRedirectURL($id)
    {
        $different_menu_redirect_after = get_post_meta($id, '_different_menu_redirect_after', true);
        $redirect_after = !empty($different_menu_redirect_after) ? $different_menu_redirect_after : 'default';

        switch ($redirect_after){
            case "current":
                global $wp;
                $url = esc_url(add_query_arg( $wp->query_vars, home_url( $wp->request ) ));
                break;
            case "home":
                $url = home_url();
                break;
            case "custom":
                $redirect_after_to_custom_url = get_post_meta($id, '_redirect_after_to_custom_url', true);
                $url = esc_url($redirect_after_to_custom_url);
                break;
            case "default":
                $url = "";
        }
        return $url;
    }


    /**
     * Replace placeholders in menu item titles with user information.
     *
     * @since    2.3.0
     * @access   public
     * @param    string    $title    The menu item title.
     * @param    int       $id       The ID of the menu item being edited.
     * @return   string              The modified menu item title.
     */
    function replace_placeholders($title, $id)
    {
        if (!is_user_logged_in()){
            return $title;
        }

        $user = wp_get_current_user();
        $avatar_size = get_post_meta($id, '_user_avatar', true);
        $avatar_size = !empty($avatar_size) ? $avatar_size: '24';


        $user_avatar_border_radius_type = get_post_meta($id, '_user_avatar_border_radius_type', true);
        $user_avatar_border_radius_type = !empty($user_avatar_border_radius_type) ? $user_avatar_border_radius_type : 'rounded';

        $user_avatar_border_radius = get_post_meta($id, '_user_avatar_border_radius', true);
        $user_avatar_border_radius = !empty($user_avatar_border_radius) ? $user_avatar_border_radius : '4';

        $border_radius = ($user_avatar_border_radius_type == "rounded") ? '50%': $user_avatar_border_radius.'px';

        if (strpos($title, '{avatar}') !== false) {
            $avatar_url = '<img class="different-menu-avatar" src="' . get_avatar_url($user->ID) . '" width="'.$avatar_size.'" height="'.$avatar_size.'" style="vertical-align: middle; border-radius: '.$border_radius.'">';
            $title = str_replace('{avatar}', $avatar_url, $title);
        }

        if (strpos($title, '{first_name}') !== false) {
            $title = str_replace('{first_name}', $user->first_name, $title);
        }

        if (strpos($title, '{last_name}') !== false) {
            $title = str_replace('{last_name}', $user->last_name, $title);
        }

        if (strpos($title, '{display_name}') !== false) {
            $title = str_replace('{display_name}', $user->display_name, $title);
        }

        if (strpos($title, '{nickname}') !== false) {
            $title = str_replace('{nickname}', $user->nickname, $title);
        }

        if (strpos($title, '{email}') !== false) {
            $title = str_replace('{email}', $user->user_email, $title);
        }

        if (strpos($title, '{username}') !== false) {
            $title = str_replace('{username}', $user->user_login, $title);
        }

        return $title;
    }

    /**
     * Add a custom meta box to the nav-menus.php page.
     *
     * @since    2.3.0
     * @access   public
     */
    function custom_nav_menu_metabox() {
        add_meta_box(
            'different_menu_nav_menu_metabox', // Unique ID for the metabox
            'User Related Menu Items',       // Title of the metabox
            [$this, 'user_related_custom_nav_menu_metabox'], // Callback function to display content
            'nav-menus',             // Admin page where the metabox should be displayed
            'side',                  // Context (side, normal, advanced)
            'low'                   // Priority (high, core, default, low)
        );
    }

    /**
     * Add a custom meta box to the nav-menus.php page.
     *
     * @since    2.3.0
     * @access   public
     */
    function user_related_custom_nav_menu_metabox() {
        global $nav_menu_selected_id;

        $my_items = array();

        $link_data = [
            [
                'title' => 'Login',
                'object' => 'login',
            ],
            [
                'title' => 'Register',
                'object' => 'register',
            ],
            [
                'title' => 'Logout',
                'object' => 'logout',
            ],
        ];

        foreach ($link_data as $index => $data) {
            $my_items[] = (object) array(
                'ID' => $index + 1,
                'db_id' => 0,
                'menu_item_parent' => 0,
                'object_id' => $index + 1,
                'post_parent' => 0,
                'type' => $data['object'],
                'object' => $data['object'],
                'type_label' => 'Different Menu in Different Pages Plugin',
                'title' => $data['title'],
                'url' => '',
                'target' => '',
                'attr_title' => '',
                'description' => '',
                'classes' => array(),
                'xfn' => '',
            );
        }

        $db_fields = false;
        // If your links will be hieararchical, adjust the $db_fields array bellow
        if ( false ) {
            $db_fields = array( 'parent' => 'parent', 'id' => 'post_parent' );
        }
        $walker = new \Walker_Nav_Menu_Checklist( $db_fields );

        $removed_args = array(
            'action',
            'customlink-tab',
            'edit-menu-item',
            'menu-item',
            'page-tab',
            '_wpnonce',
        ); ?>
        <div id="different-menu-custom-metabox">
        <div id="tabs-panel-my-plugin-all" class="tabs-panel tabs-panel-active">
            <?php $is_user_ragistration_disabled = get_option( 'users_can_register') != '1'; ?>

            <?php if ( $is_user_ragistration_disabled ) : ?>
                <div style="font-size: 14px; color: #555; background-color: #f2dede; padding: 10px;margin-top: -15px;">
                    <span class="dashicons dashicons-info" style="color: #3498db;"></span>
                    <?php
                    // Translators: %1$s and %2$s represent placeholders for URLs.
                    echo sprintf( esc_html__( 'Registration currently disabled on your site. You may enable it from %1$sgeneral settings%2$s.', 'different-menu' ), '<a href="' . esc_url( admin_url( 'options-general.php' ) ) . '" style="color: #e74c3c;">', '</a>' );
                    ?>

                </div>
            <?php endif; ?>


            <ul id="different-menu-user-meta-box" class="categorychecklist form-no-clear <?php echo $is_user_ragistration_disabled ? 'registration_disabled': ''; ?>" >
                <?php echo walk_nav_menu_tree( array_map( 'wp_setup_nav_menu_item', $my_items ), 0, (object) array( 'walker' => $walker ) ); ?>
            </ul>

            <p class="button-controls">
			<span class="list-controls">
				<a href="<?php
                echo esc_url(add_query_arg(
                    array(
                        'my-plugin-all' => 'all',
                        'selectall' => 1,
                    ),
                    remove_query_arg( $removed_args )
                ));
                ?>#my-menu-test-metabox" class="select-all"><?php esc_html_e( 'Select All' ); ?></a>

			</span>
                <span class="add-to-menu">
				<input type="submit"<?php wp_nav_menu_disabled_check( $nav_menu_selected_id ); ?> class="button-secondary submit-add-to-menu right" value="<?php esc_attr_e( 'Add to Menu' ); ?>" name="submit-different-menu-user-menu-items" id="submit-different-menu-custom-metabox" />
				<span class="spinner"></span>
			</span>
            </p>
        </div>
        <?php
        ?>

        <?php
    }

    /**
     * Add a custom icon to menu items.
     *
     * @since    2.3.0
     * @access   public
     * @param    string    $item_output    The menu item's HTML output.
     * @param    object    $item           The menu item object.
     * @param    int       $depth          The depth of the menu item.
     * @param    array     $args           The menu item arguments.
     * @return   string                    The modified menu item's HTML output.
     */
    function add_icon_to_menu_item($item_output, $item, $depth, $args) {
        // Check if we're on the nav-menus.php page
        if (is_admin()) {
            // Add your icon HTML here
            $icon_html = '<span class="custom-menu-icon">🌟</span>'; // You can replace this with your actual icon HTML

            // Append the icon HTML to the menu item title
            $item_output = preg_replace('/(<span class="menu-item-title">.*?<\/span>)/', '$1' . $icon_html, $item_output);
        }

        return $item_output;
    }

}

new DifferentMenuItemSettings();
