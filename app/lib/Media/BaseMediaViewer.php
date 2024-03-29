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
		
		return $o_view;
	}
	# -------------------------------------------------------
	/**
	 *
	 */
	public static function searchViewerData($request, $identifier, $data=null, $options=null) {
		throw new ApplicationException(_t('Media search is not available'));
	}
	# -------------------------------------------------------
	/**
	 *
	 */
	public static function autocomplete($request, $identifier, $data=null, $options=null) {
		throw new ApplicationException(_t('Media search autocomplete is not available'));
	}
	# -------------------------------------------------------
}
