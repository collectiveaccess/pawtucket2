<?php
/** ---------------------------------------------------------------------
 * themes/default/Front/front_page_html : Front page of site 
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
 		$access_values = caGetUserAccessValues($this->request);
 
		print $this->render("Front/featured_set_slideshow_html.php");
		
		$o = new ca_objects();
		$qr_recently_added = caMakeSearchResult('ca_objects', $o->getRecentlyAddedItems(3, ['checkAccess' => $access_values, 'hasRepresentations' => true, 'idsOnly' => true]));
        $qr_recently_viewed = caMakeSearchResult('ca_objects', $o->getRecentlyViewedItems(3, ['checkAccess' => $access_values, 'hasRepresentations' => true]));

?>
	<div class="row">
		<div class="col-sm-5">
<?php
		print $this->render("Front/gallery_set_links_html.php");
?>
		</div> <!--end col-sm-4-->	
		<div class="col-sm-7">
		<h2>Recently Added</h2>
		<p><div class="row recent"><?php
		    while($qr_recently_added->nextHit()) {
		        print $qr_recently_added->getWithTemplate('<div class="col-sm-6 col-md-6 col-lg-4 recently"><l>^ca_object_representations.media.small</l> <br/><br/> <l>^ca_objects.preferred_labels.name</l></div>', ['checkAccess' => $access_values]);
		    }
		?></div></p>
		<h2>Recently Viewed</h2>
		<p><div class="row recent"><?php
		    while($qr_recently_viewed->nextHit()) {
		        print $qr_recently_viewed->getWithTemplate('<div class="col-sm-6 col-md-6 col-lg-4 recently"><l>^ca_object_representations.media.small</l> <br/><br/> <l>^ca_objects.preferred_labels.name</l></div>', ['checkAccess' => $access_values]);
		    }
		?></div></p>	
		</div>
	</div><!-- end row -->