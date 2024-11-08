<?php
/** ---------------------------------------------------------------------
 * app/lib/Media/MediaViewers/ThreeD.php :
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2024 Whirl-i-Gig
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

require_once(__CA_LIB_DIR__.'/Media/IMediaViewer.php');
require_once(__CA_LIB_DIR__.'/Media/BaseMediaViewer.php');

class ThreeD extends BaseMediaViewer implements IMediaViewer {
	# -------------------------------------------------------
	/**
	 *
	 */
	public static function getViewerHTML(\RequestHTTP $request, ?array $options=null) {
		$o_view = self::getView($request, $options);
		return $o_view->render('threed.php');
	}
	# -------------------------------------------------------
	/**
	 *
	 */
	public static function getViewerOverlayHTML(\RequestHTTP $request, ?array $options=null) {
		$o_view = self::getView($request, $options);
		return $o_view->render('threed_overlay.php');
	}
	# -------------------------------------------------------
	/**
	 *
	 */
	public static function viewerOptions() : ?array {
		return ['display_version', 'zoom', 'width', 'height', 'no_overlay'];
	}
	# -------------------------------------------------------
}