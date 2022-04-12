<?php
/** ---------------------------------------------------------------------
 * themes/default/Front/gallery_slideshow_html : Front page of site 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013 Whirl-i-Gig
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
 * @subpackage Core
 * @license http://www.gnu.org/copyleft/gpl.html GNU Public License version 3
 *
 * ----------------------------------------------------------------------
 */
	require_once(__CA_MODELS_DIR__."/ca_collections.php");
	$va_access_values = $this->getVar("access_values");
	

	$qr_collections = ca_collections::find(array('parent_id' => NULL, 'preferred_labels' => ['is_preferred' => 1]), array('returnAs' => 'searchResult', 'checkAccess' => $va_access_values, 'sort' => 'ca_collections.preferred_labels.name'));
			
	if($qr_collections->numHits()){
?>
<div class="row"><div class="col-sm-12 col-md-10 col-md-offset-1 col-lg-8 col-lg-offset-2 frontFeaturedCollections">
	<h2>Ik ben op zoek naar ...<br/><hr/></h2>
<?php
		$c = 0;
		$i = 0;
		while($qr_collections->nextHit()){
			$c++;
			if($c == 7){
				break;
			}
			if($i == 0){
				print "<div class='row'>";
			}
			print "<div class='col-sm-4 col-md-4 frontFeaturedCollectionsItem'>".$qr_collections->getWithTemplate("<div class='frontFeaturedCollectionsImg'><l>^ca_object_representations.media.widepreview</l></div>").$qr_collections->getWithTemplate("<l>^ca_collections.preferred_labels.name</l>")."</div>";
			$i++;
			if($i == 3){
				print "</div>";
				$i = 0;
			}
		}
		if($i > 0){
			print "</div>";
		}
?>
</div></div>
<?php
	}
?>