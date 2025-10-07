<?php

/*
 * AIT Shortcodes WordPress Plugin
 *
 * Copyright (c) 2013, Affinity Information Technology, s.r.o. (http://ait-themes.com)
 */



class AitShortcodesUtils
{


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
	 * dash-separated -> camelCase.
	 * @param  string
	 * @return string
	 */
	public static function dash2class($s)
	{
		$s = strtolower($s);
		$s = preg_replace('#([.-])(?=[a-z])#', '$1 ', $s);
		$s = ucwords($s);
		$s = strtolower($s[0]) . substr($s, 1);
		$s = str_replace('- ', '', $s);
		return ucfirst($s);
	}
}