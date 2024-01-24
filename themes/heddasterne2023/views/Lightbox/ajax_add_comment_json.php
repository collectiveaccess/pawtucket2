<?php
/* ----------------------------------------------------------------------
 * themes/default/views/Sets/ajax_add_comment_json.php :
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2015 Whirl-i-Gig
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
 * ----------------------------------------------------------------------
 */
	$va_errors = $this->getVar('errors');
    $vs_message = $this->getVar('message');
    $vs_comment = $this->getVar('comment');
    $vn_comment_count = $this->getVar('comment_count');
    $vs_comment_count_display = $this->getVar('comment_count_display');
    $vn_set_id = $this->getVar('set_id');
	
	if (is_array($va_errors) && sizeof($va_errors)) {
			print json_encode(array('status' => 'error', 'errors' => $va_errors));
	} else {
			print json_encode(array('status' => 'ok', 'message' => $vs_message, 'comment' => $vs_comment, 'set_id' => $vn_set_id, 'count' => $vn_comment_count, 'displayCount' => $vs_comment_count_display));
	}