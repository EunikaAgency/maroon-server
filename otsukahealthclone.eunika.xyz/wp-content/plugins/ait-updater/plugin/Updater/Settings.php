<?php

namespace Ait\Updater;

use Ait\Updater\Screens\SimpleSettings;
use Ait\Updater\Screens\BrandedSettings;



class Settings
{
	protected static $pageSlug = 'ait-updtr-settings';
	protected $updater;
	protected $options;
	protected static $instance;



	public static function run($updater)
	{
		self::instance()->setUpdater($updater);
		add_action('network_admin_menu', array(self::instance(), 'addToAdminMenu'), 12);
		if (!is_multisite()) {
			add_action('admin_menu', array(self::instance(), 'addToAdminMenu'), 12);
		}
		add_action('wp_ajax_aitUpdater:saveSettings', array(self::instance(), 'ajaxSave'));
		add_action('wp_ajax_aitUpdater:fixDirname', array(self::instance(), 'ajaxFixDirname'));
	}



	protected function key()
	{
		return '_ait_updater_options';
	}



	protected function defaults()
	{
		return array(
			'api_key'         => '',
			'do_backup'       => true,
		);
	}



	protected function all()
	{
		if($this->options === null){
			$o = get_site_option($this->key(), $this->defaults());
			$this->options = wp_parse_args($o, $this->defaults());
		}

		return $this->options;
	}



	protected function get($key)
	{
		$options = $this->all();

		if(isset($options[$key])){
			return $options[$key];
		}

		return null;
	}



	public function validate($input)
	{
		$errors = array();

		if(Detector::isThereAnyAitClubThemes() or Detector::isThereAnyAitPluginsExceptPrepackedAndFree()){
			if(empty($input['api_key'])){
				$errors['api_key'][] = 'empty';
			}
		}

		return $errors;
	}



	protected function sanitize($options)
	{
		$only = function($array, $keys){
			return array_intersect_key($array, array_flip((array) $keys));
		};

		$opts = $only($options, array_keys($this->defaults()));

		array_walk($opts, function(&$item){
			$item = trim($item);
		});

		return $opts;
	}



	protected function update($rawData)
	{
		$options = $this->sanitize($rawData);
		update_site_option($this->key(), $options);
		delete_site_transient('check_ait_subscription');
	}



	protected function getValidationErrorMessages()
	{
		$msgs = array(
			'empty' => __('You have to enter value to %s', 'ait-updater'),
		);

		return array(
			'api_key'  => array(
				'empty' => sprintf($msgs['empty'], __('API Key', 'ait-updater')),
			),
		);
	}



	public function ajaxSave()
	{
		$result = $this->validate($_POST);
		if(!empty($result)){
			wp_send_json_error($result);
		}else{
			$this->update($_POST);
			wp_send_json_success(array(
				'type' => 'success',
				'msg' => __('Settings saved.', 'ait-updater'),
			));
		}
	}



	public function ajaxFixDirname()
	{
		$result = ThemeDirnameFixer::run();
		wp_send_json_success($result);
	}



	public function addToAdminMenu()
	{
		if(defined('AIT_SKELETON_VERSION')){
			$page = new BrandedSettings($this->updater);
			$pageHookname = add_submenu_page(
				'ait-theme-options',
				sprintf(_x('%s Settings', 'AIT Updater', 'ait-updater'), 'AIT Updater'),
				'AIT Updater',
				apply_filters('ait-updater-menu-permission', 'update_plugins'),
				self::$pageSlug,
				array($page, 'render')
			);

			$page->pageHookname = $pageHookname;
		}else{
			$page = new SimpleSettings($this->updater);
			$pageHookname = add_menu_page(
				sprintf(_x('%s Settings', 'AIT Updater', 'ait-updater'), 'AIT Updater'),
				'AIT Updater',
				apply_filters('ait-updater-menu-permission', 'update_plugins'),
				self::$pageSlug,
				array($page, 'render'),
				'dashicons-admin-generic'
			);
			$page->pageHookname = $pageHookname;
		}
	}



	public function setUpdater($updater)
	{
		$this->updater = $updater;
	}



	public static function instance()
	{
		if(!self::$instance){
			self::$instance = new self;
		}

		return self::$instance;
	}



	public static function __callStatic($name, $args)
	{
		return call_user_func_array(array(self::instance(), $name), $args);
	}
}
