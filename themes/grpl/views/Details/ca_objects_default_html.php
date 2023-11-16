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
		<div class="container">
			<div class="row">
				<div class='col-sm-6 col-md-6 col-lg-5 col-lg-offset-1'>
				{{{representationViewer}}}
				<div id="detailAnnotations"></div>
				<?php print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_object, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-sm-3 col-md-3 col-xs-4", "primaryOnly" => $this->getVar('representationViewerPrimaryOnly') ? 1 : 0)); ?>
				<?php
				# Comment and Share Tools [Note: if{} below does not currently check if download link is available (b/c it always is)
				if ($vn_comments_enabled | $vn_share_enabled | $vn_pdf_enabled) {
					print '<div id="detailTools">';
					if ($vn_comments_enabled) {
				?>
				<div class="detailTool"><a href='#' onclick='jQuery("#detailComments").slideToggle(); return false;'><span class="glyphicon glyphicon-comment"></span>Comments and Tags (<?php print sizeof($va_comments) + sizeof($va_tags); ?>)</a></div><!-- end detailTool -->
						<div id='detailComments'><?php print $this->getVar("itemComments");?></div><!-- end itemComments -->
				<?php
					}
					if ($vn_share_enabled) {
						print '<div class="detailTool"><span class="glyphicon glyphicon-share-alt"></span>'.$this->getVar("shareLink").'</div><!-- end detailTool -->';
					}
					# TG addition: add download media link to page
					print "<div class='detailTool'><span class='glyphicon glyphicon-download-alt'></span>".caNavLink($this->request, 'Download File', '', 'Detail', 'DownloadRepresentation', '', array('context' => 'objects', 'representation_id' => $this->getVar("representation_id"), "object_id" => $vn_id, "download" => 1, "version" => "original"))."</div>";
					# End TG addition
					if ($vn_pdf_enabled) {
						print "<div class='detailTool'><span class='glyphicon glyphicon-file'></span>".caDetailLink($this->request, "create item summary PDF", "faDownload", "ca_objects",  $vn_id, array('view' => 'pdf', 'export_format' => '_pdf_ca_objects_summary'))."</div>";
					}
					print '</div><!-- end detailTools -->';
				}
						?>
			</div><!-- end col sm-6...-->
				<div class='col-sm-6 col-md-6 col-lg-5'><!-- Metadata container -->
					<H4>{{{^ca_objects.preferred_labels.name}}}</H4>
					<H6>{{{<unit>^ca_objects.type_id</unit>}}}</H6>
					<HR>
					{{{<ifdef code="ca_objects.description">
						<div class='unit'><h6>Description</h6>
							<span class="trimText">^ca_objects.description</span>
						</div>
					</ifdef>}}}
	        {{{<ifdef code="ca_objects.pp_identifies_pw"><H6>Identifies as poet or writer?:</H6> ^ca_objects.pp_identifies_pw<br/></ifdef>}}}
					{{{<ifdef code="ca_objects.pp_inspiration"><H6>Inspiration:</H6> ^ca_objects.pp_inspiration<br/></ifdef>}}}
					{{{<ifdef code="ca_objects.pp_zip"><H6>Zip code:</H6> ^ca_objects.pp_zip<br/></ifdef>}}}
					 {{{<ifdef code="ca_objects.date"><H6>Dates:</H6>^ca_objects.date.date_value (^ca_objects.date.date_type)<br/></ifdef>}}}
					<!-- Original TGM code that was replaced below
					{{{<ifcount code="ca_objects.tgm_terms" min="1" max="1"><H6>TGM Subject Heading:</H6></ifcount>}}}
					{{{<ifcount code="ca_objects.tgm_terms" min="2"><H6>TGM Subject Headings:</H6></ifcount>}}}
					{{{<unit relativeTo="ca_objects.tgm_terms" delimiter="<br/>"><a href="https://^ca_objects.tgm_terms.id%start=6" target="_blank">^ca_objects.tgm_terms.text</a></unit>}}} -->
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
					<!-- The original LoC code that was replaced below
					{{{<ifcount code="ca_objects.loc_terms" min="1" max="1"><H6>LoC Subject Heading:</H6></ifcount>}}}
	        {{{<ifcount code="ca_objects.loc_terms" min="2"><H6>LoC Subject Headings:</H6></ifcount>}}}
	        {{{<unit relativeTo="ca_objects.loc_terms" delimiter="<br/>"><a href="https://^ca_objects.loc_terms.id%start=6" target="_blank">^ca_objects.loc_terms.text</a></unit>}}}
	 -->
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
					<!-- CENSUS CARD DATA -->
					{{{<if rule="^ca_objects.type_id =~ /Registration card/">
						<hr></hr>
						<H6>Registration Card Data</H6>
							<ifdef code="ca_objects.address_info.address"><b>Address: </b>^ca_objects.address_info.address<br/></ifdef>
							<ifdef code="ca_objects.telno"><b>Telephone Number: </b>^ca_objects.telno<br/></ifdef>
							<!-- Demographics -->
							<ifdef code="ca_objects.demographics">
								<div class="unit">
									<b>Demographics</b><br/>
									<div class="row" style="padding-left: 30px">
										<ifdef code="ca_objects.demographics.age">Age: ^ca_objects.demographics.age<br/></ifdef>
										<ifdef code="ca_objects.demographics.marriage">Marriage status: ^ca_objects.demographics.marriage<br/></ifdef>
										<ifdef code="ca_objects.demographics.color_or_race">Color or race: ^ca_objects.demographics.color_or_race<br/></ifdef>
										<ifdef code="ca_objects.demographics.birth_country">Birth country: ^ca_objects.demographics.birth_country<br/></ifdef>
										<ifdef code="ca_objects.demographics.dependents">Dependents: ^ca_objects.demographics.dependents<br/></ifdef>
									</div>
								</div>
							</ifdef>
							<!-- Citizenship -->
							<ifdef code="ca_objects.citizenship">
								<div class="unit">
									<b>Citizenship</b><br/>
									<div class ="row" style="padding-left: 30px">
										<ifdef code="ca_objects.citizenship.by_birth">By birth: ^ca_objects.citizenship.by_birth<br/></ifdef>
										<ifdef code="ca_objects.citizenship.by_nationalization">By naturalization: ^ca_objects.citizenship.by_nationalization<br/></ifdef>
									</div>
								</div>
							</ifdef>
							<!-- Service -->
							<ifdef code="ca_objects.service">
								<div class="unit">
									<b>Service</b><br/>
									<div class="row" style="padding-left: 30px">
										<ifdef code="ca_objects.service.s_offered">Serice offered: ^ca_objects.service.s_offered<br/></ifdef>
										<ifdef code="ca_objects.service.time_pledged">Time pledged: ^ca_objects.service.time_pledged<br/></ifdef>
										<ifdef code="ca_objects.service.training">Line of training requested: ^ca_objects.service.training<br/></ifdef>
										<ifdef code="ca_objects.service.tuition">Tuition: ^ca_objects.service.tuition<br/></ifdef>
										<ifdef code="ca_objects.service.serve_anywhere">Serve anywhere: ^ca_objects.service.serve_anywhere<br/></ifdef>
										<ifdef code="ca_objects.service.serve_home">Serve in hometown: ^ca_objects.service.serve_home<br/></ifdef>
										<ifdef code="ca_objects.service.serve_US">Serve in US: ^ca_objects.service.serve_US<br/></ifdef>
										<ifdef code="ca_objects.service.s_start">Start: ^ca_objects.service.s_start<br/></ifdef>
										<ifdef code="ca_objects.service.es_offered">Emergency Service: ^ca_objects.service.es_offered<br/></ifdef>
									</div>
								</div>
							</ifdef>
							<!-- Employment -->
							<ifdef code="ca_objects.employment">
								<div class="unit">
									<b>Employment</b><br/>
									<div class="row" style="padding-left: 30px">
										<ifdef code="ca_objects.employment.occupation">Present occupation: ^ca_objects.employment.occupation<br/></ifdef>
										<ifdef code="ca_objects.employment.employer">Employer: ^ca_objects.employment.employer<br/></ifdef>
										<ifdef code="ca_objects.employment.where_employed">Where employed: ^ca_objects.employment.where_employed<br/></ifdef>
									</div>
								</div>
							</ifdef>
							<!-- Reverences -->
							<ifdef code="ca_objects.references">
								<div class="unit">
									<b>References</b>: ^ca_objects.references<br/>
								</div>
							</ifdef>
							<!-- Education -->
							<ifdef code="ca_objects.education">
								<div class="unit">
									<b>Education</b><br/>
									<div class="row" style="padding-left: 30px">
										<ifdef code="ca_objects.education.grammar">Grammar school: ^ca_objects.education.grammar<br/></ifdef>
										<ifdef code="ca_objects.education.high_private">High or private school: ^ca_objects.education.high_private<br/></ifdef>
										<ifdef code="ca_objects.education.college">College: ^ca_objects.education.college<br/></ifdef>
										<ifdef code="ca_objects.education.special_training">Special training: ^ca_objects.education.special_training<br/></ifdef>
									</div>
								</div>
							</ifdef>
							<!-- Reg Info -->
							<ifdef code="ca_objects.registration_info">
								<div class="unit">
									<b>Registration Information</b><br/>
									<div class="row" style="padding-left: 30px">
										<ifdef code="ca_objects.registration_info.reg_source">Source: ^ca_objects.registration_info.reg_source<br/></ifdef>
										<ifdef code="ca_objects.registration_info.reg_ward">Ward: ^ca_objects.registration_info.reg_ward<br/></ifdef>
										<ifdef code="ca_objects.registration_info.reg_precinct">Precinct: ^ca_objects.registration_info.reg_precinct<br/></ifdef>
										<ifdef code="ca_objects.registration_info.reg_date">Date: ^ca_objects.registration_info.reg_date<br/></ifdef>
										<ifdef code="ca_objects.registration_info.reg_place">Place: ^ca_objects.registration_info.reg_place<br/></ifdef>
										<ifdef code="ca_objects.registration_info.reg_fee">Fee: ^ca_objects.registration_info.reg_fee<br/></ifdef>
										<ifdef code="ca_objects.registration_info.reg_contrib">Contribution: ^ca_objects.registration_info.reg_contrib<br/></ifdef>
										<ifdef code="ca_objects.registration_info.reg_corresp">Correspondence: ^ca_objects.registration_info.reg_corresp<br/></ifdef>
										<ifdef code="ca_objects.registration_info.reg_before">Has registered before: ^ca_objects.registration_info.reg_before<br/></ifdef>
										<ifdef code="ca_objects.registration_info.reg_remarks">Remarks: ^ca_objects.registration_info.reg_remarks<br/></ifdef>
										<ifdef code="ca_objects.registration_info.reg_name">Registrar's name: ^ca_objects.registration_info.reg_name<br/></ifdef>
										<ifdef code="ca_objects.registration_info.reg_address">Registrar's address: ^ca_objects.registration_info.reg_address<br/></ifdef>
									</div>
								</div>
							</ifdef>
							<!-- Physical Eval. Info -->
							<ifdef code="ca_objects.physical_eval">
								<div class="unit">
									<b>Physical Evaluation</b><br/>
									<div class="row" style="padding-left: 30px">
										<ifdef code="ca_objects.physical_eval.phy_health">Health: ^ca_objects.physical_eval.phy_health<br/></ifdef>
										<ifdef code="ca_objects.physical_eval.phy_defects">Physical defects: ^ca_objects.physical_eval.phy_defects<br/></ifdef>
										<ifdef code="ca_objects.physical_eval.phy_voice">Voice: ^ca_objects.physical_eval.phy_voice<br/></ifdef>
										<ifdef code="ca_objects.physical_eval.phy_sight">Sight: ^ca_objects.physical_eval.phy_sight<br/></ifdef>
										<ifdef code="ca_objects.physical_eval.phy_hearing">Hearing: ^ca_objects.physical_eval.phy_hearing<br/></ifdef>
									</div>
								</div>
							</ifdef>
							<!-- Assignment Info -->
							<ifdef code="ca_objects.assignment">
								<div class="unit">
									<b>Assignment</b><br/>
									<div class="row" style="padding-left: 30px">
										<ifdef code="ca_objects.assignment.assign_date">Date: ^ca_objects.assignment.assign_date<br/></ifdef>
										<ifdef code="ca_objects.assignment.assign_sent">Sent to: ^ca_objects.assignment.assign_sent<br/></ifdef>
									</div>
								</div>
							</ifdef>
						}}}
						<?php
							#  Skills - created by TG [04/2021] to return properly formatted skills
							if(sizeof($va_skill) > 0){
								#create array to track if skill category has been used for this record
								$sk_used = [];
								# create skill header
								print "<div class='unit'><b>"._t("Skill").((sizeof($va_skill) > 1) ? "s" : "")."</b>";
								# create initial div tag for skill info
								$skill_block = '<div class="row" style="padding-left: 30px">';
								# loop array of person's skills
								foreach($va_skill as $va_skill_info) {
									# split each skill (a ;-delimited set) with [0]=skill text and [1]=skill category
									$sp_skill=explode(";",$va_skill_info);
									# if skill category as already been used for this person...
									if (in_array($sp_skill[1], $sk_used)){
										# add to the end with a comma
										$skill_block .= ", ".$sp_skill[0];
									}
									# otherwise if this is the first skill category of the bunch...
									elseif (empty($sk_used)){
										# add to text w/out <br> b/c it's at the top
										$skill_block .= $va_skill_cats[$sp_skill[1]].": ".$sp_skill[0];
										# add skill category number to used array
										array_push($sk_used, $sp_skill[1]);
									}
									else{
										#in all other cases, add <br> to create new line & add skill cat # to used array
										$skill_block .= "<br>".$va_skill_cats[$sp_skill[1]].": ".$sp_skill[0];
										array_push($sk_used, $sp_skill[1]);
									}
								}
								# print skill block + final div tags
								print $skill_block."</div></div><!-- end unit -->";
							}
						?>
					{{{</if>}}}
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
