<?php
/* ----------------------------------------------------------------------
 * app/views/objects/object_representation_page_binary.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2012-2014 Whirl-i-Gig
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

	$pn_object_id 			= $this->getVar('object_id');
	$pn_representation_id 	= $this->getVar('representation_id');
	$va_pages 				= $this->getVar('pages');
	$va_sections 			= $this->getVar('sections');
	$vs_content_mode 		= $this->getVar('content_mode');
	$vs_title 				= $this->getVar('title');
	$vs_download_version 	= $this->getVar('download_version');
	$vb_is_searchable 		= (bool)$this->getVar('is_searchable');
	
	header("Content-type: application/json");
	print json_encode(array(
		'title' => $vs_title,
		'description' => '',
		'id' => 'documentData',
		'pages' => sizeof($va_pages),
		'annotations' => array(),
		'sections' => $va_sections,
		'resources' => array(
			'page' => array(
				'image' => '',
				'object_id' => $pn_object_id, 'representation_id' => $pn_representation_id
			),
			'pageList' => $va_pages,
			'downloadUrl' => in_array($vs_content_mode, array('multiple_representations', 'hierarchy_of_representations')) ? caNavUrl($this->request, '', 'Detail', 'DownloadMedia', array('object_id' => $pn_object_id, 'representation_id' => $pn_representation_id, 'download' => 1, 'version' => $vs_download_version)): caNavUrl($this->request, '', 'Detail', 'DownloadRepresentation', array('object_id' => $pn_object_id, 'representation_id' => $pn_representation_id, 'download' => 1, 'version' => $vs_download_version)),
			'search' => $vb_is_searchable ? caNavUrl($this->request,  '*', '*', 'SearchWithinMedia', array('object_id' => $pn_object_id, 'representation_id' => $pn_representation_id))."/q/{query}" : null
		)
	));
?>