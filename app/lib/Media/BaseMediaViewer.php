<?php
/** ---------------------------------------------------------------------
 * app/lib/Media/BaseMediaViewer.php :
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2016-2024 Whirl-i-Gig
 *
 * For more information visit http://www.CollectiveAccess.org
 *
 * This program is free software; you may redistribute it and/or modify it under
 * the terms of the provided license as published by Whirl-i-Gig
 *
 * CollectiveAccess is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTIES whatsoever, including any implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * This source code is free and modifiable under the terms of
 * GNU General Public License. (http://www.gnu.org/copyleft/gpl.html). See
 * the "license.txt" file for details, or visit the CollectiveAccess web site at
 * http://www.CollectiveAccess.org
 *
 * @package CollectiveAccess
 * @subpackage Media
 * @license http://www.gnu.org/copyleft/gpl.html GNU Public License version 3
 *
 * ----------------------------------------------------------------------
 */
namespace CA\MediaViewers;

class BaseMediaViewer {
	# -------------------------------------------------------
	/**
	 *
	 */
	static public function checkStatus() {
		return true;
	}
	# -------------------------------------------------------
	/**
	 *
	 */
	static public function getView($request, ?array $options=null) {
		$o_view = new \View($request, $request->getViewsDirectoryPath()."/mediaViewers");
		
		foreach(['displayClass', 'id'] as $opt) {
			$o_view->setVar($opt, caGetOption($opt, $options, null));
		}
		$class = get_called_class();
		$opt_list = $class::viewerOptions();
		$filtered_opts = [];
		foreach($opt_list as $opt) {
			switch($opt) {
				case 'width':
				case 'height':
					if(!is_array($dim = caParseFormElementDimension($options[$opt] ?? null))) { break; }
					if($dim['type'] === 'percentage') {
						$filtered_opts[$opt] = $dim['dimension'].'%';
					} else {
						$filtered_opts[$opt] = $dim['dimension'].'px';
					}
					break;
				default:
					$filtered_opts[$opt] = $options[$opt] ?? null;
					break;
			}
		}
		$o_view->setVar('options', $filtered_opts);
		
		return $o_view;
	}
	# -------------------------------------------------------
	/**
	 *
	 */
	public static function viewerOptions() : ?array {
		return ['display_version', 'width', 'height', 'no_overlay'];
	}
	# -------------------------------------------------------
}
