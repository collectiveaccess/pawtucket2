<?php
/* ----------------------------------------------------------------------
 * themes/default/views/bundles/ca_objects_default_html.php :
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013-2018 Whirl-i-Gig
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
$t_object = $this->getVar("item");
$va_comments = $this->getVar("comments");
$va_tags = $this->getVar("tags_array");
$vn_comments_enabled = $this->getVar("commentsEnabled");
$vn_share_enabled = $this->getVar("shareEnabled");
$vn_pdf_enabled = $this->getVar("pdfEnabled");
$vn_id = $t_object->get('ca_objects.object_id');
$va_tgm = $t_object->get("ca_objects.tgm_terms", array('returnAsArray' => 1, 'returnAllLocales' => false));
$va_lcsh = $t_object->get("ca_objects.lcsh_terms", array('returnAsArray' => 1, 'returnAllLocales' => false));
$va_skill = $t_object->get("ca_objects.skills", array('returnAsArray' => 1, 'returnAllLocales' => false));
# [TG 4/2021] Below uses helper function found in app/helpers/listHelpers.php
$va_skill_cats = caGetListItems('skill_categories', ['index' => 'id', 'value' => 'name_plural']);
# [TG used to get full rights information stored in the list item record]
$vo_rights = new ca_list_items($t_object->get("ca_objects.rights.copyright_logo"));
$vo_rights_idno = $vo_rights->get('idno');
#	$vo_rights = $vo_rights_list->getItemFromList('rights_logos', 'public_domain'); #$t_object->get("ca_objects.rights.copyright_logo")); #caGetListItems('rights_logos', ['index' => 'id', 'value' => 'item_value']);
?>
<div class="row">
	<div class='col-xs-12 navTop'><!--- only shown at small screen size -->
		{{{previousLink}}}{{{resultsLink}}}{{{nextLink}}}
	</div><!-- end detailTop -->
	<div class='navLeftRight col-xs-1 col-sm-1 col-md-1 col-lg-1'>
		<div class="detailNavBgLeft">
			{{{previousLink}}}{{{resultsLink}}}
		</div><!-- end detailNavBgLeft -->
	</div><!-- end col -->
	<div class='col-xs-12 col-sm-10 col-md-10 col-lg-10'>
			
				<H4>{{{^ca_objects.preferred_labels.name}}}</H4>
				<H6>{{{<unit>^ca_objects.type_id</unit>}}}</H6>
				<HR/>
		<div class="container">
			<div class="row">
				<div class='col-sm-12 col-md-12 col-lg-12'>	
				{{{representationViewer}}}
				<div id="detailAnnotations"></div>
				
			</div><!-- end col sm-6...-->
				<div class='col-sm-6 col-md-6 col-lg-5'><!-- Metadata container -->
					{{{<ifdef code="ca_objects.description">
						<div class='unit'><h6>Description</h6>
							<span class="trimText">^ca_objects.description</span>
						</div>
					</ifdef>}}}
	        {{{<ifdef code="ca_objects.pp_identifies_pw"><H6>Identifies as poet or writer?:</H6> ^ca_objects.pp_identifies_pw<br/></ifdef>}}}
					{{{<ifdef code="ca_objects.pp_inspiration"><H6>Inspiration:</H6> ^ca_objects.pp_inspiration<br/></ifdef>}}}
					{{{<ifdef code="ca_objects.pp_zip"><H6>Zip code:</H6> ^ca_objects.pp_zip<br/></ifdef>}}}
					 {{{<ifdef code="ca_objects.date"><H6>Dates:</H6>^ca_objects.date.date_value (^ca_objects.date.date_type)<br/></ifdef>}}}
					<?php
						# created by TG [01/2021] so clicking on TGM subject heading will return other objects with same TGM subject
						if(sizeof($va_tgm) > 0){
							print "<div class='unit'><h6>"._t("Subject Heading").((sizeof($va_tgm) > 1) ? "s" : "")." (TGM)</h6>";
							foreach($va_tgm as $va_tgm_info){
								$tgm_term=explode(" [",$va_tgm_info);
								print "<div>".caNavLink($this->request, $tgm_term[0], '', '', 'Search', 'Objects', array('search' => 'ca_objects.tgm_terms:"'.$tgm_term['0'].'"'))."</div>";
							}
							print "</div><!-- end unit -->";
						}
					?>
					
					<?php
						# created by TG [04/2021] so clicking on LoC subject heading will return other objects with same LoC subject
						if(sizeof($va_lcsh) > 0){
								print "<div class='unit'><h6>"._t("Subject Heading").((sizeof($va_lcsh) > 1) ? "s" : "")." (LCSH)</h6>";
								foreach($va_lcsh as $va_lcsh_info){
									$lcsh_term=explode(" [",$va_lcsh_info);
									print "<div>".caNavLink($this->request, $lcsh_term[0], '', '', 'Search', 'Objects', array('search' => 'ca_objects.lcsh_terms:"'.$lcsh_term['0'].'"'))."</div>";
								}
								print "</div><!-- end unit -->";
							}
					?>
					{{{<ifdef code="ca_objects.serial_name"><H6>Publication Title:</H6>^ca_objects.serial_name<br/></ifdef>}}}
					{{{<ifdef code="ca_objects.language"><H6>Language:</H6>^ca_objects.language<br/></ifdef>}}}
					{{{<ifdef code="ca_objects.idno"><H6>File Identifier:</H6>^ca_objects.idno<br/></ifdef>}}}
					{{{<ifdef code="ca_objects.source"><H6>Source:</H6>^ca_objects.source<br/></ifdef>}}}
					{{{<ifdef code="ca_objects.rights.copyright_logo"><H6>Rights:</H6></ifdef>}}}
					<?php
						# created by TG [05/2021] to display rights logo
						if ($vo_rights_idno){
							print "<div class='detailCC'><a href='".$vo_rights->get('item_value')."'>".caGetThemeGraphic($this->request, $vo_rights_idno.".png", array("alt" => $vo_rights->get('preferred_labels')))."</a></div>";
						}
					?>
					<hr></hr>
					{{{<ifcount min="1" code="ca_collections"><H6>Part of digital collection:</H6></ifcount>}}}
	      	{{{<unit relativeTo="ca_collections" delimiter="<br/>"><l>^ca_collections.preferred_labels.name</l></unit>}}}

					{{{<ifcount code="ca_entities" min="1" max="1"><H6>Related entity</H6></ifcount>}}}
					{{{<ifcount code="ca_entities" min="2"><H6>Related entities</H6></ifcount>}}}
					{{{<unit relativeTo="ca_entities" delimiter="<br/>"><l>^ca_entities.preferred_labels</l> (^relationship_typename)</unit>}}}

					{{{<ifcount code="ca_objects.related" min="1" max="1"><H6>Related item</H6></ifcount>}}}
					{{{<ifcount code="ca_objects.related" min="2"><H6>Related items</H6></ifcount>}}}
					{{{<unit relativeTo="ca_objects.related" delimiter="<br/>"><l>^ca_objects.preferred_labels</l> (^ca_objects.type_id)</unit>}}}

					{{{<ifcount code="ca_places" min="1" max="1"><H6>Related place</H6></ifcount>}}}
					{{{<ifcount code="ca_places" min="2"><H6>Related places</H6></ifcount>}}}
					{{{<unit relativeTo="ca_places" delimiter="<br/>"><l>^ca_places.preferred_labels</l> (^relationship_typename)</unit>}}}

					{{{<ifcount code="ca_list_items" min="1" max="1"><H6>Local subject</H6></ifcount>}}}
					{{{<ifcount code="ca_list_items" min="2"><H6>Local subjects</H6></ifcount>}}}
					{{{<unit relativeTo="ca_list_items" delimiter="<br/>"><l>^ca_list_items.preferred_labels.name_plural</l> (^relationship_typename)</unit>}}}
					<hr></hr>
					{{{<ifcount code="ca_objects.address_info" min="1"> <H6>Related address information</H6>Street address: ^ca_objects.address_info.address</ifcount>}}}
					{{{map}}}
				</div> <!-- End Metadata container -->
			</div><!-- end row -->
		</div><!-- end container -->
	</div><!-- end col -->
	<div class='navLeftRight col-xs-1 col-sm-1 col-md-1 col-lg-1'>
		<div class="detailNavBgRight">
			{{{nextLink}}}
		</div><!-- end detailNavBgLeft -->
	</div><!-- end col -->
</div><!-- end row -->

<script type='text/javascript'>
	jQuery(document).ready(function() {
		$('.trimText').readmore({
		  speed: 75,
		  maxHeight: 120
		});
	});
</script>
