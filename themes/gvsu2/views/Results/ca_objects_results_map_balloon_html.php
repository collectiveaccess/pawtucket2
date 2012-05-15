<?php
/* ----------------------------------------------------------------------
 * themes/default/views/Results/ca_objects_results_map_balloon_html.php :
 * 		full search results
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2010 Whirl-i-Gig
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
$qr_data = $this->getVar('data');		// this is a search result row
?>
<div id="mapBalloon">
<?php
	if($qr_data->getMediaTag('ca_object_representations.media', 'thumbnail')){
		print caNavLink($this->request, $qr_data->getMediaTag('ca_object_representations.media', 'thumbnail'), '', 'Detail', 'Object', 'Show', array('object_id' => $qr_data->get("ca_objects.object_id")));
	}
?>
	<div id="mapBalloonText">
	<?php print caNavLink($this->request, '<b>'.$qr_data->get("ca_objects.idno").'</b>: '.$qr_data->get("ca_objects.preferred_labels"), '', 'Detail', 'Object', 'Show', array('object_id' => $qr_data->get("ca_objects.object_id"))); ?>
	</div><!-- end mapBalloonText -->
</div><!-- end mapBallon -->