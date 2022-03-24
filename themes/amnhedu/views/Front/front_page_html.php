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
    require_once(__CA_LIB_DIR__."/Browse/BrowseEngine.php");
 		
		$o = new ca_objects();
		$qr_recently_added = caMakeSearchResult('ca_objects', $o->getRecentlyAddedItems(2, ['checkAccess' => caGetUserAccessValues($this->request), 'hasRepresentations' => true, 'idsOnly' => true]));
        $qr_recently_viewed = caMakeSearchResult('ca_objects', $o->getRecentlyViewedItems(2, ['checkAccess' => caGetUserAccessValues($this->request), 'hasRepresentations' => true]));
						
        $browse = new BrowseEngine('ca_objects');
        
        $specimen_categories = $browse->getFacet('specimen_category_facet');
        $cultural_history = $browse->getFacet('artifact_category_facet');
?>
<div class="container">
	<div class="row">
		<div class="col-sm-4">
		<div class="front-browse">
			<H2>Natural History</H2><br/><br/>
			<ul>
<?php
    foreach($specimen_categories as $sc) {
        print "<li>".caNavLink($this->request, $sc['label'], '', '', 'Browse', 'objects', ['facet' => 'specimen_category_facet', 'id' => $sc['id']])."</li>\n";
    }
?>
			</ul>
		</div>	
		</div><!--end col-sm-8-->
		<div class="col-sm-4">
		<div class="front-browse">
			<h2>Cultural History</h2><br/><br/>
			<ul>
<?php
    foreach($cultural_history as $ch) {
        print "<li>".caNavLink($this->request, $ch['label'], '', '', 'Browse', 'objects', ['facet' => 'artifact_category_facet', 'id' => $ch['id']])."</li>\n";
    }
?>
            </ul>
		</div>
		</div>
		<div class="col-sm-4">
			<h2>About</h2>
			{{{homepage}}}
		</div>
	</div><!-- end row -->
	<div class="row">
		<div class="col-sm-12">
		<br/>
		<hr>
			<h2>Exhibits</h2>
		</div>
		<div class="col-sm-4">
<?php
#$setitem = ca_sets::getFirstItemFromSet('temp_exhibit', ['version' => 'small']);
	print "<div class='front-exhibit'>".caNavLink($this->request, $setitem["representation_tag"], '', '', 'Gallery', $setitem["set_id"])."<h3>".$setitem["set_name"]."</h3>"."</div><br/>";

?>		
		</div>

		<div class="col-sm-4">
<?php
#$setitem = ca_sets::getFirstItemFromSet('perm_exhibit', ['version' => 'small']);
	print "<div class='front-exhibit'>".caNavLink($this->request, $setitem["representation_tag"], '', '', 'Gallery', $setitem["set_id"])."<h3>".$setitem["set_name"]."</h3>"."</div><br/>";

?>	
		</div> 
		<div class="col-sm-4">
<?php
#$setitem = ca_sets::getFirstItemFromSet('upcoming_exhibit', ['version' => 'small']);
	print "<div class='front-exhibit'>".caNavLink($this->request, $setitem["representation_tag"], '', '', 'Gallery', $setitem["set_id"])."<h3>".$setitem["set_name"]."</h3>"."</div><br/>";

?>	
		</div> 

	</div><!-- end row -->
	<div class="row">
		<div class="col-sm-12">
		<hr>
			<h2>Items</h2>
		</div>
		<div class="col-sm-4">
			<h3>Recently Viewed</h3>
<?php
		    while($qr_recently_viewed->nextHit()) {
		        print $qr_recently_viewed->getWithTemplate('<div class="col-sm-5"><div class="recently"<l>^ca_object_representations.media.icon</l> <br/><br/> <l>^ca_objects.preferred_labels.name</l></div><br/></div>');
		    }
?>
		</div> 
		<div class="col-sm-4">
			<h3>Recently Added</h3>
<?php
		    while($qr_recently_added->nextHit()) {
		        print $qr_recently_added->getWithTemplate('<div class="col-sm-5"><div class="recently"><l>^ca_object_representations.media.icon</l> <br/><br/> <l>^ca_objects.preferred_labels.name</l></div><br/></div>');
		    }
?>
		</div> 
	</div>
	<br/><br/>
</div>
