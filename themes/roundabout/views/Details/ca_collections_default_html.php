 <?php
/* ----------------------------------------------------------------------
 * themes/default/views/Details/ca_collections_default_html.php : 
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013-2019 Whirl-i-Gig
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

	$t_item =	 			$this->getVar("item");
	$va_comments = 			$this->getVar("comments");
	$va_tags = 				$this->getVar("tags_array");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");
	$vn_pdf_enabled = 		$this->getVar("pdfEnabled");
	$vn_inquire_enabled = 	$this->getVar("inquireEnabled");
	$vn_id =				$t_item->get('ca_collections.collection_id');
	$va_access_values = 	caGetUserAccessValues();
	$vn_representation_id = $this->getVar("representation_id");
?>
<div class="row borderBottom">
	<div class='col-xs-12 navTop'><!--- only shown at small screen size -->
		{{{previousLink}}}{{{resultsLink}}}{{{nextLink}}}
	</div><!-- end detailTop -->
	<div class='navLeftRight col-xs-1 col-sm-1 col-md-1 col-lg-1 pt-2'>
		<div class="detailNavBgLeft">
			{{{previousLink}}}<br>{{{resultsLink}}}
		</div><!-- end detailNavBgLeft -->
	</div><!-- end col -->
	<div class='col-sm-10 col-md-10 col-lg-10 pt-4 pb-2'>
		<H1 class= "text-center">{{{^ca_collections.preferred_labels.name ^ca_collections.type_id}}}</H1>		
	</div>
	<div class='navLeftRight col-xs-1 col-sm-1 col-md-1 col-lg-1 pt-2'>
		<div class="detailNavBgRight">
			{{{nextLink}}}
		</div><!-- end detailNavBgLeft -->
	</div><!-- end col -->
</div><!-- end row -->
<div class="row">
	<div class="col-sm-12 text-right">
<?php
				# Comment and Share Tools
				if ($vn_comments_enabled || $vn_pdf_enabled || $vn_inquire_enabled) {
						
					print '<div id="detailTools" class="mt-2 mb-3">';
					if ($vn_comments_enabled) {
?>				
						<div class="detailTool"><a href='#' onclick='jQuery("#detailComments").slideToggle(); return false;'><ion-icon name="chatboxes"></ion-icon> <span>Comments and Tags (<?php print sizeof($va_comments) + sizeof($va_tags); ?>)</span></a></div><!-- end detailTool -->
						<div id='detailComments'><?php print $this->getVar("itemComments");?></div><!-- end itemComments -->
<?php				
					}
					if ($vn_pdf_enabled) {
						print "<div class='detailTool'>".caDetailLink("<ion-icon name='document'></ion-icon> <span>Download as PDF</span>", "", "ca_collections",  $vn_id, array('view' => 'pdf', 'export_format' => '_pdf_ca_objects_summary'))."</div>";
					}
					if ($vn_inquire_enabled) {
						print "<div class='detailTool'>".caNavLink("<ion-icon name='ios-mail'></ion-icon> <span>Inquire</span>", "", "", "Contact", "form", array("table" => "ca_collections", "id" => $vn_id))."</div>";
					}
					print '</div><!-- end detailTools -->';
				}				

?>
	</div>
</div>

<div class="row">
	<div class="col-lg-3"><h3>Identifier</h3>{{{^ca_collections.idno}}}</h3></div>
	{{{<ifdef code="ca_collections.inclusive_dates"><div class="col-lg-3"><h3 class="pt-2">Inclusive Dates</h3>^ca_collections.inclusive_dates</div>}}}
	{{{<ifdef code="ca_collections.extent"><div class="col-lg-3"><h3 class="pt-2">Extent</h3><unit relativeTo="ca_collections.extent" delimiter=", ">^ca_collections.extent.extent_collection ^ca_collections.extent.type_collection</unit></div>}}}
	<div class="col-lg-3 bright">{{{<ifcount code="ca_occurrences" restrictToTypes="productions" min="1"><h3 class="pt-2">Production</h3><unit relativeTo="ca_occurrences" restrictToTypes="productions" delimiter=", "><l>^ca_occurrences.preferred_labels.name</l></unit></h3></ifcount>}}}</div>
	<div class="col-lg-12"><hr></div>
</div>
<div class="row">
	{{{<ifdef code="ca_collections.abstract">
		<div class="col-lg-12">
		<h3>Abstract</h3>
			<div class="readMore">
				<div class="collapse" id="collapseSummary">^ca_collections.abstract</div>
				<a class="collapsed" data-toggle="collapse" href="#collapseSummary" aria-expanded="false" aria-controls="collapseSummary"></a>
			</div>
	 	</div>
	 	</div>
	</ifdef>}}}
</div>
<div class="row">
	{{{<ifdef code="ca_collections.bio_note">
		<div class="col-lg-12">
			<h3 class="pt-2">Biographical Note</h3>
			^ca_collections.bio_note
	 	</div>
	</ifdef>}}}
</div>
<div class="row">
	{{{<ifdef code="ca_collections.scope_note">
		<div class="col-lg-12">
			<h3 class="pt-2">Scope and Contents</h3>
			<div class="readMore">
				<div class="collapse" id="collapseSummary">^ca_collections.scope_note</div>
				<a class="collapsed" data-toggle="collapse" href="#collapseSummary" aria-expanded="false" aria-controls="collapseSummary"></a>
			</div>
	 	</div>
	</ifdef>}}}
</div>
<div class="row">
	{{{<ifdef code="ca_collections.Access_restrictions">
	<div class="col-lg-6"><h3 class="pt-3">Access Restrictions</h3>
		^ca_collections.access_restrictions
	</div>
	</ifdef>}}}
	{{{<ifdef code="ca_collections.Preferred_citation">
	<div class="col-lg-6"><h3 class="pt-3">Preferred Citation</h3>
		^ca_collections.preferred_citation
	</div>
	</ifdef>}}}
	{{{<ifdef code="ca_collections.lcsh_terms" delimiter=", ">
	<div class="col-lg-12"><h3 class="pt-3">Library of Congress Subject Headings</h3>
		<l>^ca_collections.lcsh_terms</l>
	</div>
	</ifdef>}}}
</div>

<?php		
	
	$va_related_item_ids = $t_item->get("ca_objects.object_id", array("restrictToTypes" => array("item_select"), "returnAsArray" => true, "checkAccess" => $va_access_values));
	if(sizeof($va_related_item_ids)){
		# --- tags
		$o_db = new Db();
		$q_tags = $o_db->query("SELECT ixt.tag_id, count(ixt.tag_id) as tagCount, t.tag from ca_items_x_tags ixt INNER JOIN ca_item_tags as t on t.tag_id = ixt.tag_id WHERE ixt.table_num = 57 AND ixt.row_id IN (".join(", ", $va_related_item_ids).") GROUP BY ixt.tag_id ORDER BY tagCount DESC limit 20");
			if($q_tags->numRows()){
?>
			<div class="row mt-5">
				<div class="col-sm-12 mt-5">
					<H1>Tags</H1>
				</div>
			</div>
			<div class="row bg-1 pt-4 mb-5 detailTags">
<?php
				while($q_tags->nextRow()){
?>
					<div class="col-sm-6 col-md-3 pb-4">
						<?php print caNavLink("<div class='bg-2 text-center py-2 uppercase'>".$q_tags->get("tag")."</div>", "", "", "MultiSearch", "Index", array("search" => "ca_item_tags.tag:'".$q_tags->get("tag")."' AND ca_collections.collection_id:".$vn_id)); ?>
					</div>
<?php
				}

?>
			</div>
<?php
			}
	
		# --- related_items
	
			shuffle($va_related_item_ids);
			$q_objects = caMakeSearchResult("ca_objects", array_slice($va_related_item_ids,0,20));
?>
		<div class="row mt-5">
			<div class="col-lg-12 mt-2 mb-2">
				<H2>Related Items</H2>
			</div>
		</div>
		<div class="row mb-5 detailRelated">
<?php
			$i = 0;
			while($q_objects->nextHit()){
				if($q_objects->get("ca_object_representations.media.large")){
					print "<div class='col-sm-6 col-md-4 col-lg-4 col-xl-2 pb-4 mb-4'>";
					print $q_objects->getWithTemplate("<div class='color-block-bg'><l>^ca_object_representations.media.large</l></div>");
					print "</div>";
					$i++;
				}
				if($i == 12){
					break;
				}
			}
?>
		</div>

<?php		
	}
?>

	</div>
</div>