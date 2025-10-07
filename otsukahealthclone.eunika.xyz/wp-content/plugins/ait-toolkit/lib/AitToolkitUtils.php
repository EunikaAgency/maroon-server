<?php

/*
 * AIT Toolkit WordPress Plugin
 *
 * Copyright (c) 2013, Affinity Information Technology, s.r.o. (http://ait-themes.com)
 */




class AitToolkitUtils
{

	public static function loadRawConfig($file)
	{

		if(!file_exists($file)){
			trigger_error("Config file '{$file}' does not exist.");
			return array();
		}

		if(self::endsWith('.php', $file)){

			$config = include $file;
			return $config;

		}else{
			if(!class_exists('NNeon', false)){
				require_once dirname(__FILE__) . '/NNeon.php';
			}

			$content = @file_get_contents($file);

			if($content === false){
				trigger_error("Config file '{$filename}' is unreadable.", E_USER_WARNING);
				return array();
			}

			$config = (array) NNeon::decode($content);

			return $config;
		}
	}



	public static function isAjax()
	{
		return (defined('DOING_AJAX') and DOING_AJAX === true);
	}



	/**
	 * Checks if given url is absolute url
	 * @param  string  $url Absolute URL to http resource
	 * @return boolean
	 */
	public static function isAbsUrl($url)
	{
		$url = trim($url);
		return (self::startsWith('http', $url) or self::startsWith('//', $url));
	}



	/**
	 * Checks if given url points to external resource.
	 * @param  string  $url Absolute URL to http resource
	 * @return boolean
	 */
	public static function isExtUrl($url)
	{
		$url = trim($url);
		$parts = parse_url($url);
		return ((self::startsWith('http', $url) or self::startsWith('//', $url)) and !(isset($parts['host']) and self::contains(site_url(), $parts['host'])));
	}



	/**
	 * Starts the $haystack string with the prefix $needle?
	 * @param  string
	 * @param  string
	 * @return bool
	 */
	public static function startsWith($needle, $haystack)
	{
		return strncmp($haystack, $needle, strlen($needle)) === 0;
	}



	/**
	 * Does $haystack contain $needle?
	 * @param  string
	 * @param  string
	 * @return bool
	 */
	public static function contains($haystack, $needle)
	{
		return strpos($haystack, $needle) !== FALSE;
	}



	/**
	 * Ends the $haystack string with the suffix $needle?
	 * @param  string
	 * @param  string
	 * @return bool
	 */
	public static function endsWith($needle, $haystack)
	{
		return strlen($needle) === 0 || substr($haystack, -strlen($needle)) === $needle;
	}



	/**
	 * Creates classname from id, e.g. parallax-portfolio -> AitParallaxPortfolioElement
	 * @param  string $id     Id in with dashes
	 * @param  string $suffix Classname suffix, e.g. 'Element', 'OptionType'
	 * @param  string $prefix Classname prefix, default 'Ait'
	 * @return string         Full classname
	 */
	public static function id2class($id,  $suffix, $prefix = 'Ait')
	{
		return $prefix . ucfirst(self::dash2camel($id)) . ucfirst($suffix);
	}



	/**
	 * Reverse operation of id2classname method
	 * @param  string $classname Classname suffix, e.g. 'Element', 'OptionType'
	 * @param  string $suffix Classname suffix, e.g. 'Element', 'OptionType'
	 * @param  string $prefix Classname prefix, default 'Ait'
	 * @return string         Id with dashes
	 */
	public static function class2id($classname, $suffix, $prefix = 'Ait')
	{
		return self::camel2dash(substr($classname, strlen($prefix), -strlen($suffix)));
	}



	/**
	 * dash-separated -> camelCase.
	 * @param  string
	 * @return string
	 */
	public static function dash2camel($s)
	{
		$s = strtolower($s);
		$s = preg_replace('#([.-])(?=[a-z])#', '$1 ', $s);
		$s = ucwords($s);
		$s = strtolower($s[0]) . substr($s, 1);
		$s = str_replace('- ', '', $s);
		return $s;
	}



	/**
	 * camelCaseAction name -> dash-separated.
	 * @param  string
	 * @return string
	 */
	public static function camel2dash($s)
	{
		$s = preg_replace('#(.)(?=[A-Z])#', '$1-', $s);
		$s = strtolower($s);
		$s = rawurlencode($s);
		return $s;
	}



 	/**
	 * dash-sepeated -> ClassName
	 * @param  string $s
	 * @return string
	 */
	public static function dash2class($s)
	{
		return ucfirst(self::dash2camel($s));
	}



	/**
	 * underscore_sepeated -> ClassName
	 * @param  string $s
	 * @return string
	 */
	public static function _2class($s)
	{
		$s = strtolower($s);
		$s = preg_replace('#([._])(?=[a-z])#', '$1 ', $s);
		$s = ucwords($s);
		$s = strtolower($s[0]) . substr($s, 1);
		$s = str_replace('_ ', '', $s);
		return ucfirst($s);
	}
}