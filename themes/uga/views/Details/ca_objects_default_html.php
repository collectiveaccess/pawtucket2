<?php
/* ----------------------------------------------------------------------
 * themes/default/views/bundles/ca_objects_default_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013-2023 Whirl-i-Gig
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
 
	$t_object = 			$this->getVar("item");
	$va_comments = 			$this->getVar("comments");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");
	$va_access_values = caGetUserAccessValues($this->request);
	$vs_representation_viewer = trim($this->getVar("representationViewer"));
	
	
	#$t_representation = new ca_object_representations($t_object->get("ca_object_representations.representation_id"));
	#print_r($t_representation->getMediaInfo("media"));
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
		<div class="container"><div class="row">
			<div class='col-sm-6 col-md-6 col-lg-6'>
<?php
				if($vs_representation_viewer){
					print $vs_representation_viewer;
?>			
					<div>Copy <a class='timecodeLink' id='timecodeLink' href='#' data-code=''>link to current in-point</a></div>
					<div id="detailAnnotations"></div>
<?php
					print "<div class='row'><div class='col-md-12 col-lg-8 col-lg-offset-2'>".$this->getVar('representationViewerThumbnailBar')."</div></div>";
				}else{
					# --- media placeholder
					if($t_object->get("instantiationMediaType")){
						$t_list_item = new ca_list_items();
						$t_list_item->load($t_object->get("instantiationMediaType"));
						$vs_typecode = $t_list_item->get("idno");
						$vs_type_placeholder = caGetPlaceholder($vs_typecode, "placeholder_large_media_icon");
						$vs_thumbnail = "<div class='bResultItemImgPlaceholder'>".$vs_type_placeholder."</div>";
					}
					if(!$vs_type_placeholder){
						$vs_type_placeholder = "<i class='fa fa-picture-o fa-5x'></i>";
					}
					print "<div class='detailImgPlaceholder'>".$vs_type_placeholder."</div>";				
				}
				# Comment and Share Tools
				if ($vn_comments_enabled | $vn_share_enabled) {
						
					print '<div id="detailTools">';
					if ($vn_comments_enabled) {
?>				
						<div class="detailTool"><a href='#' onclick='jQuery("#detailComments").slideToggle(); return false;'><span class="glyphicon glyphicon-comment"></span>Comments (<?php print sizeof($va_comments); ?>)</a></div><!-- end detailTool -->
						<div id='detailComments'><?php print $this->getVar("itemComments");?></div><!-- end itemComments -->
<?php				
					}
					if ($vn_share_enabled) {
						print '<div class="detailTool"><span class="glyphicon glyphicon-share-alt"></span>'.$this->getVar("shareLink").'</div><!-- end detailTool -->';
					}
					print '</div><!-- end detailTools -->';
				}				
?>
			</div><!-- end col -->
			
			<div class='col-sm-6 col-md-6 col-lg-6'>
				<H1>{{{ca_objects.preferred_labels.name}}}</H1>
				<HR>
				{{{<ifdef code="ca_objects.measurementSet.measurements">^ca_objects.measurementSet.measurements (^ca_objects.measurementSet.measurementsType)</ifdef><ifdef code="ca_objects.measurementSet.measurements,ca_objects.measurementSet.measurements"> x </ifdef><ifdef code="ca_objects.measurementSet.measurements2">^ca_objects.measurementSet.measurements2 (^ca_objects.measurementSet.measurementsType2)</ifdef>}}}
				
				
				{{{<ifdef code="ca_objects.idno"><div class="unit"><label>Identifer:</label>^ca_objects.idno</div></ifdef>}}}
				{{{<ifcount code="ca_collections" min="1"><div class="unit"><unit relativeTo="ca_collections" delimiter="<br/>"><label>Collection Name:</label><l>^ca_collections.preferred_labels.name</l></unit></div></ifcount>}}}
				
				{{{<ifdef code="ca_objects.containerID"><label>Box/series:</label>^ca_objects.containerID%delimiter=,_</div></ifdef>}}}				
				
				{{{<ifdef code="ca_objects.instantiationMediaType"><div class="unit"><label>Media Type:</label>^ca_objects.instantiationMediaType</div></ifdef>}}}
                {{{<ifdef code="ca_objects.instantiationPhysical"><div class="unit"><label>Physical Format:</label>^ca_objects.instantiationPhysical</div></ifdef>}}}
                {{{<ifdef code="ca_objects.instantiationDate.instantiationDateText"><div class="unit"><label>Date:</label><unit relativeTo="ca_objects.instantiationDate.instantiationDateText" delimiter="; "><ifdef code="ca_objects.instantiationDate.instantiationDateType">^ca_objects.instantiationDate.instantiationDateType: </ifdef>^ca_objects.instantiationDate.instantiationDateText</unit></div></ifdef>}}}
                                {{{<ifdef code="ca_objects.instantiationTimeStart"><div class="unit"><label>Time Start:</label>^ca_objects.instantiationTimeStart%delimiter=,_</div></ifdef>}}}
                                {{{<ifdef code="ca_objects.instantiationColors"><div class="unit"><label>Colors:</label>^ca_objects.instantiationColors%delimiter=,_</div></ifdef>}}}
				{{{<ifdef code="ca_objects.instantiationAnnotation"><div class="unit"><label>Annotation</label> ^ca_objects.instantiationAnnotation%delimiter=,_</div></ifdef>}}}
				{{{<ifdef code="ca_objects.description">
					<div class="unit"><span class="trimText">^ca_objects.description</span></div>
				</ifdef>}}}
				
				
				{{{<ifdef code="ca_objects.dateSet.setDisplayValue"><div class="unit"><label>Date:</label>^ca_objects.dateSet.setDisplayValue%delimiter=,_</div></ifdev>}}}
<?php
				$va_work_ids = $t_object->get("ca_occurrences.occurrence_id", array("checkAccess" => $va_access_values, "returnAsArray" => true));
				if(is_array($va_work_ids) && sizeof($va_work_ids)){
					print "<div class='unit'><H2>Content</H2>";
					foreach($va_work_ids as $vn_work_id){
						$t_work = new ca_occurrences($vn_work_id);
						print "<div class='unit'>";
						print $t_work->get("ca_occurrences.preferred_labels");
						if($vs_tmp = trim($t_work->get("ca_occurrences.pbcoreDescription.pbcoreDescriptionText"))){
							print "<br/>".$vs_tmp;
						}
						$va_names = array();
						$va_tmp = $t_work->get("ca_occurrences.locname", array("returnAsArray" => true));
						if(is_array($va_tmp)){
							foreach($va_tmp as $vs_tmp){
								$vs_processed = $vs_tmp;
								if($vs_tmp && (strpos($vs_tmp, " [") !== false)){
									$vs_processed = mb_substr($vs_tmp, 0, strpos($vs_tmp, " ["));
								}
								$va_names[$vs_processed] = caNavLink($this->request, $vs_processed, "", "", "Search", "objects", array("search" => $vs_processed));						
							}
						}
						$va_tmp = $t_work->get("ca_entities.preferred_labels.displayname", array("returnAsArray" => true, "checkAccess" => $va_access_values));
						if(is_array($va_tmp)){
							foreach($va_tmp as $vs_tmp){
								$va_names[$vs_tmp] = caNavLink($this->request, $vs_tmp, "", "", "Search", "objects", array("search" => $vs_tmp));
							}
						}
						if(is_array($va_names) && sizeof($va_names)){
							ksort($va_names);
							print "<div class='unit'><label>Names</label><span class='trimText'>".join(", ", $va_names)."</span></div>";
						}
						$va_tmp = $t_work->get("ca_occurrences.pbcoreSpatialCoverage", array("returnAsArray" => true));
						$va_places = array();
						if(is_array($va_tmp)){
							foreach($va_tmp as $vs_tmp){
								$vs_processed = $vs_tmp;
								if($vs_tmp && (strpos($vs_tmp, " [") !== false)){
									$vs_processed = mb_substr($vs_tmp, 0, strpos($vs_tmp, " ["));
								}
								$va_places[$vs_processed] = caNavLink($this->request, $vs_processed, "", "", "Search", "objects", array("search" => $vs_processed));						

						
						
						
								print "<div class='unit'><label>Locations</label><span class='trimText'>".join(", ", $va_places)."</span></div>";
							}
						}						
						$va_subjects = array();
						$va_tmp = $t_work->get("ca_occurrences.pbcoreSubjectContainer.pbcoreSubjectNEW", array("returnAsArray" => true));
						if(is_array($va_tmp)){
							foreach($va_tmp as $vs_tmp){
								$vs_processed = $vs_tmp;
								if($vs_tmp && (strpos($vs_tmp, " [") !== false)){
									$vs_processed = mb_substr($vs_tmp, 0, strpos($vs_tmp, " ["));
								}
								$va_subjects[$vs_processed] = caNavLink($this->request, $vs_processed, "", "", "Search", "objects", array("search" => $vs_processed));
							}
						}
						$va_tmp = $t_work->get("ca_occurrences.pbcoreSubject", array("returnAsArray" => true));
						if(is_array($va_tmp)){
							foreach($va_tmp as $vs_tmp){
								if($vs_tmp){
									$va_subjects[$vs_tmp] = caNavLink($this->request, $vs_tmp, "", "", "Search", "objects", array("search" => $vs_tmp));
								}
							}
						}
						if(is_array($va_subjects) && sizeof($va_subjects)){
							ksort($va_subjects);
							print "<div class='unit'><label>Topics</label><span class='trimText'>".join(", ", $va_subjects)."</span></div>";
						}
								
								
					if($robjects = $t_object->getRelatedItems('ca_objects', ['returnAs' => 'searchResult', 'checkAccess' => $va_access_values])) {
						print "<div class='unit'><H2>Related items</H2>";	
						
						$robject_list = [];
						while($robjects->nextHit()) {
							$robject_list[] = "<div class='unit'>".$robjects->getWithTemplate('<l>^ca_objects.preferred_labels</l> (^ca_objects.idno)')."</div>";
						}
						print join("", $robject_list);
					}
						
#Names [section header]: LC Name Authorities, Non-LOCNA Names, [both of these listed together in alphabetical order with no distinction between the types]
#locname
#ca_entities

#Locations [section header]: Work Spatial Coverage
#pbcoreSpatialCoverage

#Topics
#Library of Congress Subject Headings, Subject Headings
#pbcoreSubjectContainer.pbcoreSubjectNEW, pbcoreSubject
						print "</div>";
					}
					print "</div>";
				}
?>				
				
				<br/><br/>
				
				<button id="aeon_submit">Request Item</button>
				
				<form id="aeon_request" name="EADRequest" action="https://uga.aeon.atlas-sys.com/logon/" method="post">
  <input type="hidden" name="AeonForm"     value="EADRequest"/>
  <input type="hidden" name="RequestType"  value="Loan"/>
  <input type="hidden" name="Location"     value="Brown Media Archives"/>
  <input type="hidden" name="DocumentType" value="media"/>
  <input type="hidden" name="Site"         value="Brown Media Archives"/>
<input type="checkbox" name="Request" value="1" checked style="display:none"/><input type="hidden" name="ItemTitle_1" value="{{{ca_objects.preferred_labels.name}}}"/><input type="hidden" name="ItemSubtitle_1" value="{{{ca_objects.idno}}}"/><input type="hidden" name="ReferenceNumber_1" value="{{{ca_collections.preferred_labels.name}}}"/><input type="hidden" name="ItemNumber_1" value="{{{ca_objects.locationContainer.instantiationLocation}}}"/>
{{{<ifdef code="ca_objects.instantiationPhysical"><input type="hidden" name ="ItemInfo2_1" value="^ca_objects.instantiationPhysical"/></ifdef>}}}<input type="hidden" name="SubLocation_1" value="https://ca.libs.uga.edu/index.php/editor/objects/ObjectEditor/Summary/object_id/{{{ca_objects.object_id}}}"/>
</form>
				<script src="<?php print $this->request->getThemeUrlPath(); ?>/assets/aeon/aeonRequestsDialog.min.js"></script>
				<script src="<?php print $this->request->getThemeUrlPath(); ?>/assets/jqote2/jquery.jqote2.min.js"></script>
				<style>
					.ui-dialog { z-index: 10000 !important ;}
					.requestDesc .label, .scheduled_date .label {
						font-size: 100%;
						color: black;
					}
					
				</style>
				 <script>
  var settings = {
              title:'Confirm your viewing request',
              url: 'https://uga.aeon.atlas-sys.com/logon/',
              submitButtonSelector:'#aeon_submit',
              itemFields: [
                {
                  name: 'ItemTitle',
                  label: 'Object title'
                },
                {
                  name: 'ReferenceNumber',
                  label: 'Collection'
                },
								{
									name: 'ItemSubtitle',
									label: 'Identifier'
								},
               {
                 name: 'ItemNumber',
                 label: 'Barcode'
               },
	       {
                 name: 'SubLocation'
	       }
{{{<ifdef code="ca_objects.instantiationPhysical">
               ,{
                 name: 'ItemInfo2',
                 label: 'Physical format' 
               } </ifdef>}}}
              ],
              globalFields: [
                { name: 'Location' },
                { name: 'DocumentType' },
                { name: 'Site' }
              ],
              'scheduledDateLabel':'Select a date from the calendar (below) to visit UGA Special Collections to view the material.',
              'userReviewLabel': 'Keep this request saved in your account for later review. IT WILL NOT BE SENT TO LIBRARIES STAFF FOR FULFILLMENT.',
              'footer': '<i>* Requested items will be grouped by container in the Aeon system.</i>',
              'cleanValues':  function(s){return s.replace(/(^\s*)|(\s*$)/g, "").replace(/(\n|\t)/g, '');},
              'compressRequests':true,
              'stripUnchecked':true,
              'selectAllButtonsPosition': 'none'

            };
						
						$('#aeon_submit').aeonRequestsDialog(settings);
				 </script>

				
					<div class="row">
						<div class="col-sm-12">		
							{{{<ifcount code="ca_entities" min="1"><div class="unit"><ifcount code="ca_entities" min="1" max="1"><label>Related person</label></ifcount><ifcount code="ca_entities" min="2"><label>Related people</label></ifcount><unit relativeTo="ca_entities" delimiter="<br/>"><l>^ca_entities.preferred_labels.displayname</l></unit></div></ifcount>}}}
							
							
							{{{<ifcount code="ca_places" min="1" max="1"><div class="unit"><label>Related place<ifcount code="ca_places" min="2">s</ifcount></label><unit relativeTo="ca_places" delimiter="<br/>"><l>^ca_places.preferred_labels.name</l></unit></div></ifcount>}}}
							
							{{{<ifcount code="ca_list_items" min="1" max="1"><div class="unit"><label>Related Term<ifcount code="ca_list_items" min="2">s</ifcount></label><unit relativeTo="ca_list_items" delimiter="<br/>">^ca_list_items.preferred_labels.name_plural</unit></div></ifcount>}}}
							
							
							{{{<ifcount code="ca_objects.LcshNames" min="1"><div class="unit"><label>LC Terms</label><unit delimiter="<br/>">^ca_objects.LcshNames</unit></div></ifcount>}}}
						</div><!-- end col -->
					</div><!-- end row -->
			</div><!-- end col -->
		</div><!-- end row --></div><!-- end container -->
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
		
		let players = caUI.mediaPlayerManager.getPlayerNames();
		caUI.mediaPlayerManager.onTimeUpdate(players[0], function(e) {
			let ct = e.detail.plyr.currentTime;
			let urlStub = <?= json_encode(caNavUrl($this->request, '*', '*', '*', [], ['absolute' => true])."/start/"); ?>;
			jQuery('#timecodeLink').data('code', urlStub + ct);
		});
		jQuery('.timecodeLink').on('click', function(e) {
			let code = jQuery(this).data('code');
			if(!code) { code = jQuery(this).text(); }
			caUI.utils.copyToClipboard(code, <?= json_encode(_t('Copied link to clipboard')); ?>, { header: <?= json_encode(_t('Notice')); ?>, life: 1000, openDuration: 'fast', closeDuration: 'fast' });
			e.preventDefault();
		});
	});
</script>
