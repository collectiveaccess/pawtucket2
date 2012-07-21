<?php
/* ----------------------------------------------------------------------
 * themes/default/views/Results/ca_objects_result_caption_html.php :
 * 		thumbnail search results
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2009-2010 Whirl-i-Gig
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
?>
<div class="thumbnailCaption">
<?php
	$vs_caption = "";
	if($this->getVar('caption_title')){
		//$vs_caption .= "<i>";
		//$vs_caption .= (unicode_strlen($this->getVar('caption_title')) > 50) ? preg_replace('![^A-Za-z0-9]+$!', '', substr(strip_tags($this->getVar('caption_title')), 0, 47)).'...' : $this->getVar('caption_title');
		//$vs_caption .= "</i><br/>";
		$vs_caption .= "ID: ".$this->getVar('caption_idno');
	}
	print caNavLink($this->request, $vs_caption, '', 'Detail', 'Object', 'Show', array('object_id' => $this->getVar("object_id")));
?>
</div>