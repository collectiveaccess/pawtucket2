<?php
/* ----------------------------------------------------------------------
 * app/views/objects/object_download_media_binary.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2012-2016 Whirl-i-Gig
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
	$vs_file_path = $this->getVar('archive_path');
	
	if(!headers_sent()) {
		header("Content-type: application/octet-stream");
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate, private, post-check=0, pre-check=0");
		header("Pragma: no-cache");
	
		header("Content-Disposition: attachment; filename=".$this->getVar('archive_name'));
	}
	
	set_time_limit(0);
	$o_fp = @fopen($vs_file_path,"rb");
	while(is_resource($o_fp) && !feof($o_fp)) {
		print(@fread($o_fp, 1024*8));
		ob_flush();
		flush();
	}
?>