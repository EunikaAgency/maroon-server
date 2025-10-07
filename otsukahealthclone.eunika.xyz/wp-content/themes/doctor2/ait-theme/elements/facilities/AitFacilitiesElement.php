<?php

/*
 * AIT WordPress Theme Framework
 *
 * Copyright (c) 2014, Affinity Information Technology, s.r.o. (http://ait-themes.com)
 */

/**
 * Facilities Element
 */
class AitFacilitiesElement extends AitElement
{
	public function isColor($hex)
	{
		$result = false;

		if(strpos($hex, "#") == 0 && strlen($hex) == 7){
			$result = true;
		}

		return $result;
	}



	public function getContentPreviewOptions()
	{
		$columns = $this->option('itemColumns');
		$rows    = $this->option('itemRows');

		return array(
			'layout' => 'list',
			'columns' => !empty($columns) ? $columns : 3,
			'carousel' => false,
			'rows' => !empty($rows) ? $rows : 1
		);
	}
}
