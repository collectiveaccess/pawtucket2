<?php
	$t_object = $this->getVar("item");
	$vn_object_id = $t_object->get('ca_objects.object_id');
	$va_comments = $this->getVar("comments");
	$pn_rep_id = $this->getVar("representation_id");
?>
<div class="row">
	<div class='col-xs-1 col-sm-1 col-md-1 col-lg-1'>
		<div class="detailNavBgLeft">
			{{{previousLink}}}{{{resultsLink}}}
		</div><!-- end detailNavBgLeft -->
	</div><!-- end col -->
	<div class='col-xs-10 col-sm-10 col-md-10 col-lg-10'>
	
	</div>
	<div class='col-xs-1 col-sm-1 col-md-1 col-lg-1'>
		<div class="detailNavBgRight">
			{{{nextLink}}}
		</div><!-- end detailNavBgLeft -->
	</div><!-- end col -->
</div>
<div class="row">
	<div class="container">
			<div class="artworkTitle">
				<H4>{{{<unit relativeTo="ca_entities" delimiter="<br/>" restrictToRelationshipTypes="artist|creator"><l>^ca_entities.preferred_labels.name</l></unit>}}}</H4>
				<H5><i>{{{ca_objects.preferred_labels.name}}}</i>, {{{ca_objects.creation_date}}}</H5> 
			</div>
			<div class='col-sm-6 col-md-6 col-lg-6'>
			
				{{{representationViewer}}}
<?php
		print "<div class='repIcons'>".caObjectRepresentationThumbnails($this->request, $pn_rep_id, $t_object, array('dontShowCurrentRep' => false))."</div>";
?>	
			
			</div><!-- end col -->
			<div class='col-sm-6 col-md-6 col-lg-6'>
			
				<div class='tabdiv'>
					<div class='toggle'><a href='#' onclick="$('.infoBlock').hide(); $('#artworkInfo').fadeIn(100);">Tombstone</a></div>
					<div class='toggle'><a href='#' onclick="$('.infoBlock').hide(); $('#factSheet').fadeIn(100);">Fact Sheet</a></div>
					<div class='toggle'><a href='#' onclick="$('.infoBlock').hide(); $('#Location').fadeIn(100);">Location</a></div> 
					<div class='toggle'><a href='#' onclick="$('.infoBlock').hide(); $('#Financial').fadeIn(100);">Financials</a></div>
					<div class='toggle'><a href='#' onclick="$('.infoBlock').hide(); $('#Condition').fadeIn(100);">Condition</a></div>
					<div class='toggle'><a href='#' onclick="$('.infoBlock').hide(); $('#Description').fadeIn(100);">Description</a></div>
				</div>
				
					<hr>
				
				<div id="artworkInfo" class="infoBlock">
					{{{<div class='unit'><unit relativeTo="ca_entities" delimiter="<br/>" restrictToRelationshipTypes="artist|creator"><l>^ca_entities.preferred_labels.name</l></unit></div>}}}
					<div class='unit'><i>{{{ca_objects.preferred_labels.name}}}</i>, &nbsp;{{{ca_objects.creation_date}}}</div>
					{{{<ifdef code="ca_objects.medium"><div class='unit'>^ca_objects.medium</div></ifdef>}}}
					{{{<ifcount min="1" code="ca_objects.dimensions.display_dimensions"><div class='unit'><unit delimiter="<br/>">^ca_objects.dimensions.display_dimensions ^ca_objects.dimensions.Type</unit></div></ifcount>}}}
					{{{<ifdef code="ca_objects.edition.edition_number"><div class='unit'>Edition <ifdef code="ca_objects.edition.edition_number">^ca_objects.edition.edition_number / ^ca_objects.edition.edition_total </ifdef><ifdef code="ca_objects.edition.ap_number"><br/>^ca_objects.edition.ap_number / ^ca_objects.edition.other_info  AP</ifdef></div></ifdef>}}}
<?php
					if ($t_object->get('ca_objects.signed.signed_yn') == "No") {
						print "Signed, ".$t_object->get('ca_objects.signed.signature_details');
					}
?>					
					
					{{{<ifcount min="1" code="ca_objects.idno"><div class="unit">^ca_objects.idno</div></ifcount>}}}				
				</div>
				
				<div id="factSheet" class="infoBlock">	
					{{{<ifdef code="ca_objects.artwork_provenance"><div class='unit wide'><span class='metaHeader'>Provenance</span><span>^ca_objects.artwork_provenance</span></div></ifdef>}}}
<?php
					if ($va_exhibition_history = $t_object->get('ca_objects.exhibition_history', array('returnAsArray' => true, 'idsOnly' => true))) {
						print "<div class='unit wide'><span class='metaHeader'>Exhibition History</span>";
						foreach ($va_exhibition_history as $ex_key => $va_exhibition) {
							if ($va_exhibition['related_loan']) {
								print caNavLink($this->request, $va_exhibition['exhibition_name'], '', '', 'Detail', 'loans/'.$va_exhibition['related_loan'])."<br/><br/>";
							} else {
								print "<span>".$va_exhibition['exhibition_name']."</span><br/><br/>";
							}
						}
						print "</div>";
					}

?>										
					{{{<ifdef code="ca_objects.literature"><div class='unit wide'><span class='metaHeader'>Literature </span><span >^ca_objects.literature</span></div></ifdef>}}}
				</div>
				
				<div id="Location" class="infoBlock">
<?php				
					if ($t_object->hasField('is_deaccessioned') && $t_object->get('is_deaccessioned')) {
						// If currently deaccessioned then display deaccession message
						print "<br/><div class='inspectorDeaccessioned'>"._t('Deaccessioned %1', $t_object->get('deaccession_date'))."</div>\n";
					} else {
						$t_ui = ca_editor_uis::loadDefaultUI('ca_objects', $this->request);
						if (($t_ui && method_exists($t_object, "getObjectHistory")) && (is_array($va_placements = $t_ui->getPlacementsForBundle('ca_objects_history')) && (sizeof($va_placements) > 0))) {
							//
							// Output current "location" of object in life cycle. Configuration is taken from a ca_objects_history bundle configured for the current editor
							//
							$va_placement = array_shift($va_placements);
							$va_bundle_settings = $va_placement['settings'];
							if (is_array($va_history = $t_object->getObjectHistory($va_bundle_settings, array('displayLabelOnly' => false, 'limit' => 1, 'currentOnly' => true))) && (sizeof($va_history) > 0)) {
								$va_current_location = array_shift(array_shift($va_history));
								if ($va_current_location['display']) { print "<div class='inspectorCurrentLocation'><strong>"._t('Current').'</strong><br/>'.$va_current_location['display']."</div>"; }
							}
						} elseif (method_exists($t_object, "getLastLocationForDisplay")) {
							// If no ca_objects_history bundle is configured then display the last storage location
							if ($vs_current_location = $t_object->getLastLocationForDisplay("<ifdef code='ca_storage_locations.parent.preferred_labels'>^ca_storage_locations.parent.preferred_labels ➜ </ifdef>^ca_storage_locations.preferred_labels.name")) {
								print "<br/><div class='inspectorCurrentLocation'>"._t('Location: %1', $vs_current_location)."</div>\n";
								$vs_full_location_hierarchy = $t_object->getLastLocationForDisplay("^ca_storage_locations.hierarchy.preferred_labels.name%delimiter=_➜_");
								if ($vs_full_location_hierarchy !== $vs_current_location) { TooltipManager::add(".inspectorCurrentLocation", $vs_full_location_hierarchy); }
							}
						}
					}
?>
					<!--{{{<ifcount min="1" code="ca_objects.legacy_locations.legacy_location"><div class='unit wide'><span class='metaHeader'>Legacy Locations</span><unit delimiter="<br/>">^ca_objects.legacy_locations.legacy_location <ifdef code="ca_objects.legacy_locations.sublocation">- ^ca_objects.legacy_locations.sublocation</ifdef> <ifdef code="ca_objects.legacy_locations.via">(via ^ca_objects.legacy_locations.via)</ifdef><ifdef code="ca_objects.legacy_locations.legacy_location_date"> as of ^ca_objects.legacy_locations.legacy_location_date</ifdef></unit></div></ifcount>}}}-->
				</div>
				
				<div id="Financial" class="infoBlock">
<?php
					if ($this->request->user->hasUserRole("collection")){
						if ($va_source = $t_object->get('ca_entities.preferred_labels', array('restrictToRelationshipTypes' => array('source', 'advisor'), 'returnAsLink' => true))) {
							print "<div class='unit'><span class='metaTitle'>Source: </span><span class='meta'>".$va_source."</span></div>";
						}	
						if ($va_purchase = $t_object->get('ca_objects.purchase_date')) {
							print "<div class='unit'><span class='metaTitle'>Purchase Date: </span><span class='meta'>".$va_purchase."</span></div>";
						}										
						if ($va_cost = $t_object->get('ca_objects.object_cost')) {
							print "<div class='unit'><span class='metaTitle'>Cost: </span><span class='meta'>".$va_cost."</span></div>";
						}
						if ($va_insurance = $t_object->get('ca_objects.current_insurance', array('template' => '^insurance_value ^insurance_date'))) {
							print "<div class='unit'><span class='metaTitle'>Current Insurance Value: </span><span class='meta'>".$va_insurance."</span></div>";
						}						
						if ($t_object->get('ca_objects.gift_yn') == "Yes") {
							print "<div class='unit'><span class='metaTitle'>Gift: </span><span class='meta'>Yes</span></div>";
						}
						if ($va_market = $t_object->get('ca_objects.object_retail')) {
							print "<div class='unit'><span class='metaTitle'>Market Value: </span><span class='meta'>".$va_market."</span></div>";
						}
						if ($t_object->get('ca_objects.payment_details.payment_amount')) {
							$va_payment = $t_object->get('ca_objects.payment_details', array('delimiter' => '<hr>', 'template' => '<b>Payment Amount: </b>^payment_amount <br/><b>Payment Date:</b> ^payment_date <br/><b>Payment Quarter:</b> ^payment_quarter <br/><b>Installment:</b> ^installment<br/><b>Notes:</b> ^payment_notes'));
							print "<div class='unit'><span class='metaTitle'>Payment Details: </span><span class='meta'>".$va_payment."</span></div>";
						}						
						#if ($t_object->get('ca_objects.appraisal.appraisal_value')) {
						#	$va_appraisal = $t_object->get('ca_objects.appraisal', array('delimiter' => '<hr>', 'template' => '<b>Value: </b>^appraisal_value <br/><b>Date:</b> ^appraisal_date <br/><b>Appraiser:</b> ^appraiser  <ifdef code="appraisal_notes"><br/><b>Notes: </b>^appraisal_notes</ifdef>')); 
						#	print "<div class='unit'><span class='metaTitle'>Appraisal: </span><span class='meta'>".$va_appraisal."</span></div>";
						#}
						if ($t_object->get('ca_objects.appraisal.appraisal_value')) {
							$va_appraisal = $t_object->get('ca_objects.appraisal', array('returnAsArray' => true)); 
							print "<div class='unit'><span class='metaTitle'>Appraisal: </span><span class='meta'>";
							$va_appraisal_rev = array_reverse($va_appraisal);
							foreach ($va_appraisal_rev as $ar_key => $va_appraisal_r) {
								print "<b>Value: </b>".$va_appraisal_r['appraisal_value']."<br/>";
								print "<b>Date: </b>".$va_appraisal_r['appraisal_date']."<br/>";
								print "<b>Appraiser: </b>".$va_appraisal_r['appraiser']."<br/>";
								if ($va_appraisal_r['appraisal_notes']) {
									print "<b>Appraisal Notes: </b>".$va_appraisal_r['appraisal_notes'];
								}
								print "<hr>";
							}
							print"</span></div>";
						}						

						if ($va_object_lots = $t_object->get('ca_object_lots.preferred_labels', array('returnAsLink' => true))) {
							print "<div class='unit'><span class='metaTitle'>Related Accession</span><span class='meta'>".$va_object_lots."</span></div>";
						}
						
?>
<?php																		
					} else { 
						print "access restricted";
					}
?>
				</div>
				<div id="Condition" class="infoBlock">
<?php
					$va_condition_array = array();
					if ($va_general_condition = $t_object->get('ca_objects.general_condition', array('returnAsArray' => true, 'rawDate' => 1))) {
						foreach ($va_general_condition as $va_gen_key => $va_general) {
							$va_condition_array[$va_general['general_condition_date']['start']] = $va_general;
						}
					}
?>				
					{{{<ifcount min="1" code="ca_objects.general_condition"><div class="unit wide"><span class='metaHeader'>General Condition </span><span><unit delimiter="<br/>" sort="ca_objects.general_condition.general_condition_date" sortDirection="DESC"><b>^ca_objects.general_condition.general_condition_value <ifdef code="ca_objects.general_condition.general_condition_value">: </ifdef>^ca_objects.general_condition.general_condition_date</b>  Assessed by: ^ca_objects.general_condition.general_condition_person - ^ca_objects.general_condition.general_condition_specific</unit></span></div></ifcount>}}}																				
					{{{<ifcount min="1" code="ca_objects.frame_condition.frame_notes"><div class="unit wide"><span class='metaHeader'>Frame Condition </span><span><unit delimiter="<br/>" sort="ca_objects.frame_condition.frame_date" sortDirection="DESC"><b>^ca_objects.frame_condition.frame_date</b> ^ca_objects.frame_condition.frame_value - ^ca_objects.frame_condition.frame_notes</unit></span></div></ifcount>}}}																
					{{{<ifcount min="1" code="ca_objects.glazing_condition.glazing_date|ca_objects.glazing_condition.glazing_notes"><div class="unit wide"><span class='metaHeader'>Glazing Condition </span><span><unit delimiter="<br/>" sort="ca_objects.glazing_condition.glazing_date" sortDirection="DESC"><b>^ca_objects.glazing_condition.glazing_date</b> ^ca_objects.glazing_condition.glazing_value - ^ca_objects.glazing_condition.glazing_notes</unit></span></div></ifcount>}}}												
					{{{<ifcount min="1" code="ca_objects.support_condition.support_notes"><div class="unit wide"><span class='metaHeader'>Support Condition </span><span><unit delimiter="<br/>" sort="ca_objects.support_condition.support_date" sortDirection="DESC"><b>^ca_objects.support_condition.support_date</b> ^ca_objects.support_condition.support_value - ^ca_objects.support_condition.support_notes</unit></span></div></ifcount>}}}								
					{{{<ifcount min="1" code="ca_objects.vitrine_condition.vitrine_notes"><div class="unit wide"><span class='metaHeader'>Vitrine Condition </span><span><unit delimiter="<br/>" sort="ca_objects.vitrine_condition.vitrine_date" sortDirection="DESC"><b>^ca_objects.vitrine_condition.vitrine_date</b> ^ca_objects.vitrine_condition.vitrine_value - ^ca_objects.vitrine_condition.vitrine_notes</unit></span></div></ifcount>}}}				
					{{{<ifcount min="1" code="ca_objects.mount_condition.mount_notes"><div class="unit wide"><span class='metaHeader'>Mount Condition </span><span><unit delimiter="<br/>" sort="ca_objects.mount_condition.mount_date" sortDirection="DESC"><b>^ca_objects.mount_condition.mount_date</b> ^ca_objects.mount_condition.mount_value - ^ca_objects.mount_condition.mount_notes</unit></span></div></ifcount>}}}				
					{{{<ifcount min="1" code="ca_objects.surface_condition.surface_notes"><div class="unit wide"><span class='metaHeader'>Surface Condition </span><span><unit delimiter="<br/>" sort="ca_objects.surface_condition.surface_date" sortDirection="DESC"><b>^ca_objects.surface_condition.surface_date</b> ^ca_objects.surface_condition.surface_value - ^ca_objects.surface_condition.surface_notes</unit></span></div></ifcount>}}}
					{{{<ifcount min="1" code="ca_objects.base_condition.base_notes"><div class="unit wide"><span class='metaHeader'>Base Condition </span><span><unit delimiter="<br/>" sort="ca_objects.base_condition.base_date" sortDirection="DESC"><b>^ca_objects.base_condition.base_date</b> ^ca_objects.base_condition.base_value - ^ca_objects.base_condition.base_notes</unit></span></div></ifcount>}}}
<?php
#					if ($va_surface_condition = $t_object->get('ca_objects.surface_condition', array('delimiter' => '<br/>', 'template' => '<u>^ca_objects.surface_condition.surface_date</u> ^ca_objects.surface_condition.surface_value - ^ca_objects.surface_condition.surface_notes'))) {
#						print "<div class='unit wide'><span class='metaHeader'>Surface Condition </span><span>";
#						print $va_surface_condition;
#						print "</span></div>";
#					}

					if ($t_object->get('ca_objects.condition_images.condition_images_media')){
						$va_condition_images = $t_object->get('ca_objects.condition_images', array('returnAsArray' => true, 'ignoreLocale' => true)); 
						print '<div class="unit wide"><span class="metaHeader">Condition Images</span><span>';
						
						$o_db = new Db();
						$vn_media_element_id = $t_object->_getElementID('condition_images_media');
						foreach ($va_condition_images as $vn_condition_id => $va_condition_image) {
							if ($va_condition_image['condition_images_primary'] == 162) {
								$qr_res = $o_db->query('SELECT value_id FROM ca_attribute_values WHERE attribute_id = ? AND element_id = ?', array($vn_condition_id, $vn_media_element_id)) ;
								if ($qr_res->nextRow()) {
									print "<a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'Detail', 'GetMediaInfo', array('object_id' => $vn_object_id, 'value_id' => $qr_res->get('value_id')))."\"); return false;'>".$va_condition_image['condition_images_media']."</a>";
								}
							}
						}
						print "</span><div class='clearfix'></div></div>";
					}
					
					if ($t_object->get('ca_objects.legacy_conservation_materials.legacy_conservation_media')){
						$va_conservation_images = $t_object->get('ca_objects.legacy_conservation_materials', array('returnAsArray' => true, 'ignoreLocale' => true)); 
						print '<div class="unit wide"><span class="metaHeader">Legacy Conservation Images</span><span>';
						
						$o_db = new Db();
						$vn_media_element_id = $t_object->_getElementID('legacy_conservation_media');
						foreach ($va_conservation_images as $vn_conservation_id => $va_conservation_image) {
							if ($va_conservation_image['legacy_conservation_primary'] == 162) {
								$qr_res = $o_db->query('SELECT value_id FROM ca_attribute_values WHERE attribute_id = ? AND element_id = ?', array($vn_conservation_id, $vn_media_element_id)) ;
								if ($qr_res->nextRow()) {
									print "<a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'Detail', 'GetMediaInfo', array('object_id' => $vn_object_id, 'value_id' => $qr_res->get('value_id')))."\"); return false;'>".$va_conservation_image['legacy_conservation_media']."</a>";
								}
							}
						}
						print "</span><div class='clearfix'></div></div>";
					}					
?>				
				</div>
				<div id="Description" class="infoBlock">
					{{{<ifcount min="1" code="ca_objects.object_dates.object_date"><div class='unit'><span class='metaTitle'>Date: </span><span class='meta'><unit delimiter="<br/>">^ca_objects.object_dates.object_date <ifdef code="ca_objects.object_dates.date_note">(^ca_objects.object_dates.date_note)</ifdef></unit></span></div></ifcount>}}}
					{{{<ifcount min="1" code="ca_objects.child.preferred_labels"><div class='unit wide'><span class='metaHeader'>Elements </span><span ><unit delimiter="<br/>"><l>^ca_objects.child.preferred_labels</l></unit></span></div></ifcount>}}}
					{{{<ifdef code="ca_objects.element_notes"><div class='unit'><span class='metaTitle'>Element Notes: </span><span class='meta'>^ca_objects.element_notes</span></div></ifdef>}}}
					{{{<ifdef code="ca_objects.category"><div class='unit'><span class='metaTitle'>Category: </span><span class='meta'>^ca_objects.category</span></div></ifdef>}}}
<?php
					if ($t_object->get('ca_objects.signed.signed_yn') == "Yes") {
						print "<div class='unit'><span class='metaTitle'>Signed: </span>".ucfirst($t_object->get('ca_objects.signed.signature_details'))."</div>";
					}
					if ($t_object->get('ca_objects.dated') == "Yes") {
						print "<div class='unit'><span class='metaTitle'>Dated: </span>Dated</div>";
					}					
?>
					{{{<ifcount min="1" code="ca_objects.inscription"><div class='unit'><span class='metaTitle'>Inscription: </span><span class='meta'><unit delimiter="<br/>">^ca_objects.inscription.inscription_position1 ^ca_objects.inscription.inscription_position2 ^ca_objects.inscription.inscription_position3 ^ca_objects.inscription.inscription_material - ^ca_objects.inscription.inscription_text</unit></span></div></ifcount>}}}
					{{{<ifcount min="1" code="ca_objects.sticker_label"><div class='unit'><span class='metaTitle'>Label Details </span><span class='meta'><unit delimiter="<br/>">^ca_objects.sticker_label</unit></span></div></ifcount>}}}
<?php
					if ($t_object->get('ca_objects.inscription_uploads.inscription_uploads_media')){
						$va_inscription_images = $t_object->get('ca_objects.inscription_uploads', array('returnAsArray' => true, 'ignoreLocale' => true)); 
						print '<div class="unit wide"><span class="metaHeader">Inscription Uploads</span><span>';
						
						$o_db = new Db();
						$vn_media_element_id = $t_object->_getElementID('inscription_uploads_media');
						foreach ($va_inscription_images as $vn_inscription_id => $va_inscription_image) {
							if ($va_inscription_image['inscription_uploads_primary'] == 162) {
								$qr_res = $o_db->query('SELECT value_id FROM ca_attribute_values WHERE attribute_id = ? AND element_id = ?', array($vn_inscription_id, $vn_media_element_id)) ;
								if ($qr_res->nextRow()) {
									print "<a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'Detail', 'GetMediaInfo', array('object_id' => $vn_object_id, 'value_id' => $qr_res->get('value_id')))."\"); return false;'>".$va_inscription_image['inscription_uploads_media']."</a>";
								}
							}
						}
						print "</span><div class='clearfix'></div></div>";
					}
?>
					{{{<ifcount min="1" code="ca_objects.nonpreferred_labels"><div class='unit'><span class='metaTitle'>Other Titles </span><span class='meta'><unit delimiter="<br/>">^ca_objects.nonpreferred_labels</unit></span></div></ifcount>}}}
					{{{<ifdef code="ca_objects.legacy_description"><div class='unit'><span class='metaTitle'>Description (Legacy): </span><span class='meta'>^ca_objects.legacy_description</span></div></ifdef>}}}
					{{{<ifdef code="ca_objects.legacy_comments"><div class='unit'><span class='metaTitle'>Comments (Legacy): </span><span class='meta'>^ca_objects.legacy_comments</span></div></ifdef>}}}
<?php
#					if ($va_certificate = $t_object->get('ca_objects.certificate_auth', array('returnAsArray' => true))) {
#						foreach ($va_certificate as $cert_key => $va_cert){
#							if ($va_cert['certificate_auth_yn'] == "Yes") {
#								print "<div class='unit'><span class='metaTitle'>Certificate of Authenticity: </span><span class='unit'>";
#								if ($va_cert['certificate_auth_date']){
#									print $va_cert['certificate_auth_date'].", ";
#								}	
#								print $va_cert['certificate_auth_notes']."</span></div>";
#							}
#						}
#					}

					if ($va_cert_auths = $t_object->get('ca_objects.certificate_auth', array('returnAsArray' => true, 'convertCodesToDisplayText' => true))) {
						foreach ($va_cert_auths as $va_cert_key => $va_cert_auth) {
							if (($va_cert_auth['certificate_auth_yn'] != "No") && ($va_cert_auth['certificate_auth_yn'] != "N/A")) {
								print "<div class='unit'><span class='metaTitle'>Certificate of Authenticity: </span><span class='meta'>".$va_cert_auth['certificate_auth_yn']." ".$va_cert_auth['certificate_auth_date']." ".$va_cert_auth['certificate_auth_notes']."</div>";
							}
						}
					}
					if ($va_art_agrs = $t_object->get('ca_objects.artist_agreement', array('returnAsArray' => true, 'convertCodesToDisplayText' => true))) {
						foreach ($va_art_agrs as $va_arg_key => $va_art_agr) {
							if (($va_art_agr['artist_agreement_yn'] != "No") && ($va_art_agr['artist_agreement_yn'] != "N/A")) {
								print "<div class='unit'><span class='metaTitle'>Artist Agreement: </span><span class='meta'>".$va_art_agr['artist_agreement_yn']." ".$va_art_agr['artist_agreement_date']." ".$va_art_agr['artist_agreement_notes']."</div>";
							}
						}
					}
					if ($va_non_excl = $t_object->get('ca_objects.non_exclusive', array('returnAsArray' => true, 'convertCodesToDisplayText' => true))) {
						foreach ($va_non_excl as $va_non_key => $va_non_exc) {
							if (($va_non_exc['non_exclusive_yn'] != "No") && ($va_non_exc['non_exclusive_yn'] != "N/A")) {
								print "<div class='unit'><span class='metaTitle'>Non-exclusive License: </span><span class='meta'>".$va_non_exc['non_exclusive_yn']." ".$va_non_exc['non_exclusive_date']." ".$va_non_exc['non_exclusive_notes']."</div>";
							}
						}
					}
					if ($va_transparencys = $t_object->get('ca_objects.transparency', array('returnAsArray' => true, 'convertCodesToDisplayText' => true))) {
						foreach ($va_transparencys as $va_tran_key => $va_transparency) {
							if (($va_transparency['transparency_yn'] != "No") && ($va_transparency['transparency_yn'] != "N/A")) {
								print "<div class='unit'><span class='metaTitle'>Transparency: </span><span class='meta'>".$va_transparency['transparency_yn']." ".$va_transparency['transparency_date']." ".$va_transparency['transparency_notes']."</div>";
							}
						}
					}
					if ($va_photo_records = $t_object->get('ca_objects.photo_record', array('returnAsArray' => true, 'convertCodesToDisplayText' => true))) {
						foreach ($va_photo_records as $va_photo_key => $va_photo_record) {
							if (($va_photo_record['photo_record_yn'] != "No") && ($va_photo_record['photo_record_yn'] != "N/A")) {
								print "<div class='unit'><span class='metaTitle'>Photograph Information Record: </span><span class='meta'>".$va_photo_record['photo_record_yn']." ".$va_photo_record['photo_record_date']." ".$va_photo_record['photo_record_notes']."</div>";
							}
						}
					}																				
?>
					{{{<ifdef code="ca_objects.artwork_website"><div class='unit'><span class='metaTitle'>Website: </span><span class='meta'>^ca_objects.artwork_website</span></div></ifdef>}}}
<?php
					if ($va_notes = $t_object->get('ca_objects.other_notes', array('returnAsArray' => true, 'convertCodesToDisplayText' => true))) {
						foreach ($va_notes as $va_key => $va_note) {
							if ($va_note['other_notes_content']) {
								print "<div class='unit'><span class='metaTitle'>".$va_note['other_notes_type'].": </span><span class='meta'>".$va_note['other_notes_content']."</span></unit>";
							}
						}
					}

					if ($t_object->get('ca_objects.artwork_documents.artwork_documents_media')){
						$va_artwork_docs = $t_object->get('ca_objects.artwork_documents', array('returnAsArray' => true, 'ignoreLocale' => true, 'convertCodesToDisplayText' => true)); 
						print '<div class="unit wide"><span class="metaHeader">Artwork Documents</span><span>';
						
						$o_db = new Db();
						$vn_media_element_id = $t_object->_getElementID('artwork_documents_media');
						foreach ($va_artwork_docs as $vn_doc_id => $va_artwork_doc) {
							if ($va_artwork_doc['artwork_documents_primary'] == "Yes") {
								$qr_res = $o_db->query('SELECT value_id FROM ca_attribute_values WHERE attribute_id = ? AND element_id = ?', array($vn_doc_id, $vn_media_element_id)) ;
								if ($qr_res->nextRow()) {
									print "<a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'Detail', 'GetMediaInfo', array('object_id' => $vn_object_id, 'value_id' => $qr_res->get('value_id')))."\"); return false;'>".$va_artwork_doc['artwork_documents_media']."</a>";
								}
							}
						}
						print "</span><div class='clearfix'></div></div>";
					}
					
?>
				</div>				
			
			</div><!-- end col -->
		</div><!-- end row -->
	</div><!-- end container -->
<?php
	if ($t_object->get('ca_objects.related', array('restrictToTypes' => array('audio', 'documents', 'ephemera', 'image', 'moving_image')))) {
?>	
<div class="row">
	<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
		<div class="container">
<?php	
			if (!$this->request->isAjax()) {
?>		<hr>
		<H6>Related Archive Items</H6>
		<div class="archivesBlock">
			<div class="blockResults">
				<div id="archivesscrollButtonPrevious" class="scrollButtonPrevious"><i class="fa fa-angle-left"></i></div>
				<div id="archivesscrollButtonNext" class="scrollButtonNext"><i class="fa fa-angle-right"></i></div>
				<div id="archiveResults">
					<div id="blockResultsScroller">				
<?php
				}
			$va_object_ids = $t_object->get('ca_objects.related.object_id', array('returnAsArray' => true, 'restrictToTypes' => array('audio', 'documents', 'ephemera', 'image', 'moving_image')));
			foreach ($va_object_ids as $obj_key => $va_object_id) {
				$t_archive = new ca_objects($va_object_id);
				print "<div class='archivesResult'>";
				print "<div class='resultImg'>".caNavLink($this->request, $t_archive->get('ca_object_representations.media.widepreview'), '', '', 'Detail', 'objects/'.$va_object_id)."</div>";
				print "<p>".caNavLink($this->request, $t_archive->get('ca_objects.preferred_labels.name'), '', '', 'Detail', 'objects/'.$va_object_id)."</p>";
				print "<p>".$t_archive->get('ca_objects.dc_date.dc_dates_value')."</p>";
				print "</div><!-- archivesResult -->";
			}
			if (!$this->request->isAjax()) {		
?>	
					</div> <!-- blockResultsScroller -->
				</div> <!-- archivesResults -->
			</div> <!-- blockResults -->
		</div> <!-- archivesBlock -->
<?php
			}	
?>	
		</div><!-- end container -->	
	</div><!-- end col -->
</div>	<!-- end row -->
<?php
	}
	
	if ($t_object->get('ca_objects.related', array('restrictToTypes' => array('book')))) {
?>	
<div class="row">
	<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
		<div class="container">
<?php	
			if (!$this->request->isAjax()) {
?>		<hr>
		<H6>Related Library Items</H6>
		<div class="libraryBlock">
			<div class="blockResults">
				<div id="archivesscrollButtonPrevious" class="scrollButtonPrevious"><i class="fa fa-angle-left"></i></div>
				<div id="archivesscrollButtonNext" class="scrollButtonNext"><i class="fa fa-angle-right"></i></div>
				<div id="archiveResults">
					<div id="blockResultsScroller">				
<?php
				}
			$va_object_ids = $t_object->get('ca_objects.related.object_id', array('returnAsArray' => true, 'restrictToTypes' => array('book')));
			foreach ($va_object_ids as $obj_key => $va_object_id) {
				$t_library = new ca_objects($va_object_id);
				print "<div class='libraryResult'>";
				print "<div class='resultImg'>".caNavLink($this->request, $t_library->get('ca_object_representations.media.library'), '', '', 'Detail', 'objects/'.$va_object_id)."</div>";
				print "<p>".caNavLink($this->request, $t_library->get('ca_objects.preferred_labels'), '', '', 'Detail', 'objects/'.$va_object_id)."</p>";				
				print "<p>".caNavLink($this->request, $t_library->get('ca_entities.preferred_labels.name', array('restrictToRelationshipTypes' => array('author'))), '', '', 'Detail', 'objects/'.$va_object_id)."</p>";
				print "<p>".$t_library->get('ca_entities.preferred_labels.name', array('restrictToRelationshipTypes' => array('publisher')))."</p>";
				print "</div><!-- libraryResult -->";
			}
			if (!$this->request->isAjax()) {		
?>	
					</div> <!-- blockResultsScroller -->
				</div> <!-- libraryResults -->
			</div> <!-- blockResults -->
		</div> <!-- libraryBlock -->
<?php
			}	
?>	
		</div><!-- end container -->	
	</div><!-- end col -->
</div>	<!-- end row -->
<?php
	}	
	
	if ($t_object->get('ca_objects.related', array('restrictToTypes' => array('artwork')))) {
?>	
<div class="row">
	<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
		<div class="container">
<?php	
			if (!$this->request->isAjax()) {
?>		<hr>
		<H6>Related Artworks</H6>
		<div class="archivesBlock">
			<div class="blockResults">
				<div id="archivesscrollButtonPrevious" class="scrollButtonPrevious"><i class="fa fa-angle-left"></i></div>
				<div id="archivesscrollButtonNext" class="scrollButtonNext"><i class="fa fa-angle-right"></i></div>
				<div id="archiveResults">
					<div id="blockResultsScroller">				
<?php
				}
			$va_object_ids = $t_object->get('ca_objects.related.object_id', array('returnAsArray' => true, 'restrictToTypes' => array('artwork')));
			foreach ($va_object_ids as $obj_key => $va_object_id) {
				$t_object = new ca_objects($va_object_id);
				print "<div class='archivesResult'>";
				print "<div class='resultImg'>".caNavLink($this->request, $t_object->get('ca_object_representations.media.widepreview'), '', '', 'Detail', 'objects/'.$va_object_id)."</div>";
				print "<p>".caNavLink($this->request, $t_object->get('ca_objects.preferred_labels.name'), '', '', 'Detail', 'objects/'.$va_object_id)."</p>";
				print "<p class='artist'>".$t_object->get('ca_entities.preferred_labels', array('restrictToRelationshipTypes' => 'artist'))."</p>";
				print "<p>".$t_object->get('ca_objects.object_dates')."</p>";
				print "</div><!-- archivesResult -->";
			}
			if (!$this->request->isAjax()) {		
?>	
					</div> <!-- blockResultsScroller -->
				</div> <!-- archivesResults -->
			</div> <!-- blockResults -->
		</div> <!-- archivesBlock -->
<?php
			}	
?>	
		</div><!-- end container -->	
	</div><!-- end col -->
</div>	<!-- end row -->
<?php
	}	
?>

<script type="text/javascript">
	jQuery(document).ready(function() {
		jQuery('.archivesResults').hscroll({
			name: 'archives',
			itemWidth: jQuery('.archivesResult').outerWidth(true),
			itemsPerLoad: 10,
			itemContainerSelector: '.blockResultsScroller',
			sortParameter: 'archivesSort',
			sortControlSelector: '#archives_sort',
			scrollPreviousControlSelector: '#archivesscrollButtonPrevious',
			scrollNextControlSelector: '#archivesscrollButtonNext',
			scrollControlDisabledOpacity: 0,
			cacheKey: '{{{cacheKey}}}'
		});
	});
</script>

<script type='text/javascript'>
	jQuery(document).ready(function() {
		$('.trimText').readmore({
		  speed: 75,
		  maxHeight: 65
		});
	});
</script>