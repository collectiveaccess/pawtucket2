<?php
	$t_object = $this->getVar("item");
	$vn_object_id = $t_object->get('ca_objects.object_id');
	$va_comments = $this->getVar("comments");
	$pn_rep_id = $this->getVar("representation_id");
	
	
	$va_export_formats = $this->getVar('export_formats');
	$vs_export_format_select = $this->getVar('export_format_select');
	
?>
<div class="row">
	<div class='col-xs-1 col-sm-1 col-md-1 col-lg-1'>
		<div class="detailNavBgLeft">
			{{{resultsLink}}}<div class='detailPrevLink'>{{{previousLink}}}</div>
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
<?php
if ($this->request->user->hasUserRole("founder") || $this->request->user->hasUserRole("supercurator") || $this->request->user->hasUserRole("collection")) {
	// Export as PDF
	print "<div id='bViewButtons'>";
	print "<div class='reportTools'>";
	print caFormTag($this->request, 'view/pdf', 'caExportForm', ($this->request->getModulePath() ? $this->request->getModulePath().'/' : '').$this->request->getController().'/'.$this->request->getAction().'/'.$this->request->getActionExtra(), 'post', 'multipart/form-data', '_top', array('disableUnsavedChangesWarning' => true));
	print "{$vs_export_format_select}".caFormSubmitLink($this->request, _t('Download'), 'button', 'caExportForm')."</form>\n";
	print "</div>"; 
	print "</div>"; 
}
?>
			<div class="artworkTitle">
				<H4>{{{<unit relativeTo="ca_entities" delimiter="<br/>" restrictToRelationshipTypes="artist|creator"><l>^ca_entities.preferred_labels.name</l></unit>}}}</H4>
				<H5><i>{{{ca_objects.preferred_labels.name}}}</i>, {{{ca_objects.creation_date}}}</H5> 
<?php
				if ($t_object->hasField('is_deaccessioned') && $t_object->get('is_deaccessioned') && ($t_object->get('deaccession_date', array('getDirectDate' => true)) <= caDateToHistoricTimestamp(_t('now')))) {
					// If currently deaccessioned then display deaccession message
					print "<div class='artworkDeaccessioned'>"._t('Deaccessioned %1', $t_object->get('deaccession_date'))."</div>\n";
					#if ($vs_deaccession_notes = $t_object->get('deaccession_notes')) { TooltipManager::add(".inspectorDeaccessioned", $vs_deaccession_notes); }
				}
				if ($t_object->get('confidential') && ($t_object->get('ca_objects.confidential.confidential_until', array('getDirectDate' => true)) >= caDateToHistoricTimestamp(_t('now')))) {
					// If currently deaccessioned then display deaccession message
					print "<div class='artworkDeaccessioned'>Confidential until ".$t_object->get('ca_objects.confidential.confidential_until')."</div>\n";
				}				

?>				
			</div>
			<div class='col-sm-7 col-md-7 col-lg-7 media'>
			
				{{{representationViewer}}}
<?php
		print "<div class='repIcons'>".caObjectRepresentationThumbnails($this->request, $pn_rep_id, $t_object, array('dontShowCurrentRep' => false))."</div>";
?>	
			
			</div><!-- end col -->
			<div class='col-sm-5 col-md-5 col-lg-5'>
			
				<div class='tabdiv'>
					<div class='toggle'><a href='#' onclick="$('.infoBlock').hide(); $('#artworkInfo').fadeIn(100);">Tombstone</a></div>
					<div class='toggle'><a href='#' onclick="$('.infoBlock').hide(); $('#factSheet').fadeIn(100);">Fact Sheet</a></div>
<?php 			if ($this->request->user->hasUserRole("founder") || $this->request->user->hasUserRole("supercurator")){ ?>					
					<div class='toggle'><a href='#' onclick="$('.infoBlock').hide(); $('#Location').fadeIn(100);">Location</a></div> 
<?php 			}  ?>			
<?php 			if ($this->request->user->hasUserRole("founder")){ ?>					
					<div class='toggle'><a href='#' onclick="$('.infoBlock').hide(); $('#Financial').fadeIn(100);">Financials</a></div>
<?php 			}  ?>	
<?php 			if ($this->request->user->hasUserRole("founder") || $this->request->user->hasUserRole("supercurator")){ ?>										
					<div class='toggle'><a href='#' onclick="$('.infoBlock').hide(); $('#Condition').fadeIn(100);">Condition</a></div>
<?php 			}  ?>						
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
					if ($this->request->user->hasUserRole("founder") || $this->request->user->hasUserRole("supercurator") || $this->request->user->hasUserRole("collection")){
						if ($va_idno = $t_object->get('ca_objects.idno')) {
								print "<div class='unit wide'>".$va_idno."</div>";
						}
					}					
?>					
				</div>
				
				<div id="factSheet" class="infoBlock">
<?php					
					if ($this->request->user->hasUserRole("collection")){
						if ($va_provenance = $t_object->get('ca_objects.artwork_provenance')) {
								print "<div class='unit wide'><span class='metaHeader'>Provenance </span><span>".$va_provenance."</span></div>";
						}
					}
					if ($va_exhibition_history = $t_object->get('ca_objects.exhibition_history', array('returnAsArray' => true, 'idsOnly' => true, 'sort' => 'ca_objects.exhibition_history.exhibition_date', 'sortDirection' => 'DESC'))) {
						print "<div class='unit wide'><span class='metaHeader'>Exhibition History</span>";
						foreach ($va_exhibition_history as $ex_key => $va_exhibition) {
							if ($va_exhibition['related_loan']) {
								print "<p>".caNavLink($this->request, $va_exhibition['exhibition_name'], '', '', 'Detail', 'loans/'.$va_exhibition['related_loan'])."</p>";
							} else {
								print "<p>".$va_exhibition['exhibition_name']."</p>";
							}
						}
						print "</div>";
					}

?>										
					{{{<ifdef code="ca_objects.literature"><div class='unit wide'><span class='metaHeader'>Literature </span><span >^ca_objects.literature</span></div></ifdef>}}}
				</div>
				
				<div id="Location" class="infoBlock">
<?php	
				if ($this->request->user->hasUserRole("founder") || $this->request->user->hasUserRole("supercurator")){
			
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
							
							// Rewrite back-end display settings to remove link tags
							// since the referenced details don't exist on the front-end
							foreach($va_bundle_settings as $vs_key => $vm_val) {
								if (preg_match("!displayTemplate$!", $vs_key)) {
									$va_bundle_settings[$vs_key] = str_ireplace("<l>", "", str_ireplace("</l>", "", $vm_val));
								}
							} 
							
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
				} else {
					print "access restricted";
				}
					
?>
					<!--{{{<ifcount min="1" code="ca_objects.legacy_locations.legacy_location"><div class='unit wide'><span class='metaHeader'>Legacy Locations</span><unit delimiter="<br/>">^ca_objects.legacy_locations.legacy_location <ifdef code="ca_objects.legacy_locations.sublocation">- ^ca_objects.legacy_locations.sublocation</ifdef> <ifdef code="ca_objects.legacy_locations.via">(via ^ca_objects.legacy_locations.via)</ifdef><ifdef code="ca_objects.legacy_locations.legacy_location_date"> as of ^ca_objects.legacy_locations.legacy_location_date</ifdef></unit></div></ifcount>}}}-->
				</div>
				
				<div id="Financial" class="infoBlock">
<?php
					if ($this->request->user->hasUserRole("founder")){
						if ($va_source = $t_object->get('ca_entities.preferred_labels', array('restrictToRelationshipTypes' => array('source', 'advisor'), 'returnAsLink' => true))) {
							print "<div class='unit'><span class='metaTitle'>Source: </span><span class='meta'>".$va_source."</span></div>";
						}	
						if ($va_purchase = $t_object->get('ca_objects.purchase_date')) {
							print "<div class='unit'><span class='metaTitle'>Purchase Date: </span><span class='meta'>".$va_purchase."</span></div>";
						}										
						if ($va_cost = $t_object->get('ca_objects.object_cost')) {
							print "<div class='unit'><span class='metaTitle'>Cost: </span><span class='meta'>".$va_cost."</span></div>";
						}
						if ($va_purchased_by = $t_object->get('ca_object_lots.purchased_by', array('convertCodesToDisplayText' => true))) {
							print "<div class='unit'><span class='metaTitle'>Purchased by: </span><span class='meta'>".$va_purchased_by."</span></div>";
						}	
						#if ($va_payment = $t_object->get('ca_objects.payment_details', array('returnAsArray' => true, 'convertCodesToDisplayText' => true))) {
						#	print "<div class='unit'><span class='metaTitle'>Payment Details: </span><span class='meta'>";
						#	foreach ($va_payment as $va_key => $va_payment_details) {
						#		if ($va_payment_details['payment_amount']) {print "<b>Payment Amount:</b> ".$va_payment_details['payment_amount']."<br/>";}
						#		if ($va_payment_details['payment_date']) {print "<b>Payment Date:</b> ".$va_payment_details['payment_date']."<br/>";}
						#		if ($va_payment_details['payment_quarter'] != " ") {print "<b>Payment Quarter:</b> ".$va_payment_details['payment_quarter']."<br/>";}
						#		if ($va_payment_details['payment_installment']) {print "<b>Installment:</b> ".$va_payment_details['payment_installment']."<br/>";}
						#		if ($va_payment_details['payment_notes']) {print "<b>Payment Notes:</b> ".$va_payment_details['payment_notes']."<br/>";}
						#	}
						#	
						#	print "</span></div>";
						#}
						print "<br/>";						
						#if ($va_insurance = $t_object->get('ca_objects.current_insurance', array('template' => '^insurance_value ^insurance_date'))) {
						#	print "<div class='unit'><span class='metaTitle'>Current Insurance <br/>Value: </span><span class='meta'><br/>".$va_insurance."</span></div>";
						#}	
						if ($t_object->get('ca_objects.insurance_valuation.insurance_value_price')) {
							$va_appraisal = $t_object->get('ca_objects.insurance_valuation', array('returnAsArray' => true, 'convertCodesToDisplayText' => true, 'sort' => 'ca_objects.insurance_valuation.insurance_valuation_date')); 
							print "<div class='unit'><span class='metaTitle'>Current Insurance Value: </span><span class='meta'>";
							$va_appraisal_rev = array_reverse($va_appraisal);
							foreach ($va_appraisal_rev as $ar_key => $va_appraisal_r) {
								print "<b>Value: </b>".$va_appraisal_r['insurance_value_price']."<br/>";
								print "<b>Date: </b>".$va_appraisal_r['insurance_valuation_date']."<br/>";
								print "<b>Appraiser: </b>".$va_appraisal_r['insurance_appraiser']."<br/>";
								if ($va_appraisal_r['valuation_notes']) {
									print "<b>Appraisal Notes: </b>".$va_appraisal_r['valuation_notes'];
								}
								print "<hr>";
							}
							print"</span></div>";
						}
						print "<br/>";
						if ($va_acquisition = $t_object->get('ca_object_lots.preferred_labels', array('returnAsLink' => true))) {
							print "<div class='unit'><span class='metaTitle'>Acquisition Details: </span><span class='meta'>".$va_acquisition."</span></div>";
						}						
#						if ($t_object->get('ca_objects.financial_uploads.financial_uploads_media')){
#							$va_financial_images = $t_object->get('ca_objects.financial_uploads', array('returnAsArray' => true, 'ignoreLocale' => true, 'rawDate' => 1, 'version' => 'icon')); 
#							print '<div class="unit "><span class="metaTitle">&nbsp;</span><span class="meta">';

#							$o_db = new Db();
#							$vn_media_element_id = $t_object->_getElementID('financial_uploads_media');
#							foreach ($va_financial_images as $vn_financial_id => $va_financial_image) {
#								if ($va_financial_image['financial_uploads_primary'] == 162) {
#									$qr_res = $o_db->query('SELECT value_id FROM ca_attribute_values WHERE attribute_id = ? AND element_id = ?', array($vn_financial_id, $vn_media_element_id)) ;
#									if ($qr_res->nextRow()) {
#										print "<a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'Detail', 'GetMediaInfo', array('object_id' => $vn_object_id, 'value_id' => $qr_res->get('value_id')))."\"); return false;'>".$va_financial_image['financial_uploads_media']."</a>";
#									}
#								}
#							}
#							print "</span><div class='clearfix'></div></div>";
#						}						
#						if ($va_primary_check = $t_object->get('ca_object_lots.invoice_upload.invoice_upload_primary', array('returnAsArray' => true))){
#							$va_primary = false;
#							foreach($va_primary_check as $va_key => $va_check) {
#								foreach ($va_check as $check) {
#									if ($check == 162) {
#										$va_primary = true;
#									}
#								}
#							}
#							if ($va_primary == true) {
#								$va_lot_images = $t_object->get('ca_object_lots.invoice_upload', array('returnAsArray' => true, 'ignoreLocale' => true, 'rawDate' => 1, 'version' => 'icon', 'convertCodesToDisplayText' => true)); 
#								$va_lot_id = $t_object->get('ca_object_lots.lot_id');
#								$t_lot = new ca_object_lots($va_lot_id);
#								print '<div class="unit "><span class="metaTitle">Invoice:</span><span class="meta">';

#								$o_db = new Db();
#								$vn_media_element_id = $t_lot->_getElementID('invoice_upload_media');
#								foreach ($va_lot_images as $vs_lot_id => $va_lot_imaged) {
#									foreach ($va_lot_imaged as $vn_lot_id => $va_lot_image) {
#										if ($va_lot_image['invoice_upload_primary'] == "Yes") {
#											$qr_res = $o_db->query('SELECT value_id FROM ca_attribute_values WHERE attribute_id = ? AND element_id = ?', array($vn_lot_id, $vn_media_element_id)) ;
#											if ($qr_res->nextRow()) {
#												print "<a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'Detail', 'GetMediaInfo', array('object_id' => $vn_object_id, 'value_id' => $qr_res->get('value_id')))."\"); return false;'>".$va_lot_image['invoice_upload_media']."</a>";
#
#											}
#										}
#									}
#								}
#								print "</span><div class='clearfix'></div></div>";
#
#							}
#						}
#						if ($va_bill_check = $t_object->get('ca_object_lots.bill_upload.bill_upload_primary', array('returnAsArray' => true))){
#							$va_bill_primary = false;
#							foreach($va_bill_check as $va_key => $va_check) {
#								foreach ($va_check as $check) {
#									if ($check == 162) {
#										$va_bill_primary = true;
#									}
#								}
#							}
#							if ($va_bill_primary == true) {
#								$va_bill_images = $t_object->get('ca_object_lots.bill_upload', array('returnAsArray' => true, 'ignoreLocale' => true, 'rawDate' => 1, 'version' => 'icon', 'convertCodesToDisplayText' => true)); 
#								$va_lot_id = $t_object->get('ca_object_lots.lot_id');
#								$t_lot = new ca_object_lots($va_lot_id);
#								print '<div class="unit "><span class="metaTitle">Bill of Sale:</span><span class="meta">';
#								$o_db = new Db();
#								$vn_media_element_id = $t_lot->_getElementID('bill_upload_media');
#								foreach ($va_bill_images as $vs_bill_id => $va_bill_imaged) {
#									foreach ($va_bill_imaged as $vn_bill_id => $va_bill_image) {
#										if ($va_bill_image['bill_upload_primary'] == "Yes") {
#											$qr_res = $o_db->query('SELECT value_id FROM ca_attribute_values WHERE attribute_id = ? AND element_id = ?', array($vn_bill_id, $vn_media_element_id)) ;
#											if ($qr_res->nextRow()) {
#												print "<a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'Detail', 'GetMediaInfo', array('object_id' => $vn_object_id, 'value_id' => $qr_res->get('value_id')))."\"); return false;'>".$va_bill_image['bill_upload_media']."</a>";

#											}
#										}
#									}
#								}
#								print "</span><div class='clearfix'></div></div>";
#							}
#							
#						}	
																			
#						if ($t_object->get('ca_objects.appraisal.appraisal_value')) {
#							$va_appraisal = $t_object->get('ca_objects.appraisal', array('returnAsArray' => true)); 
#							print "<div class='unit'><span class='metaTitle'>Appraisal: </span><span class='meta'>";
#							$va_appraisal_rev = array_reverse($va_appraisal);
#							foreach ($va_appraisal_rev as $ar_key => $va_appraisal_r) {
#								print "<b>Value: </b>".$va_appraisal_r['appraisal_value']."<br/>";
#								print "<b>Date: </b>".$va_appraisal_r['appraisal_date']."<br/>";
#								print "<b>Appraiser: </b>".$va_appraisal_r['appraiser']."<br/>";
#								if ($va_appraisal_r['appraisal_notes']) {
#									print "<b>Appraisal Notes: </b>".$va_appraisal_r['appraisal_notes'];
#								}
#								print "<hr>";
#							}
#							print"</span></div>";
#						}											
#						if ($t_object->get('ca_objects.gift_yn') == "Yes") {
#							print "<div class='unit'><span class='metaTitle'>Gift: </span><span class='meta'>Yes</span></div>";
#						}
#						if ($va_market = $t_object->get('ca_objects.object_retail')) {
#							print "<div class='unit'><span class='metaTitle'>Market Value: </span><span class='meta'>".$va_market."</span></div>";
#						}
						
?>
<?php																		
					} else { 
						print "access restricted";
					}
?>
				</div>
				<div id="Condition" class="infoBlock">
<?php
				if ($this->request->user->hasUserRole("founder") || $this->request->user->hasUserRole("supercurator")){

					$va_condition_array = array();
					if ($va_general_condition = $t_object->get('ca_objects.general_condition', array('returnAsArray' => true, 'rawDate' => 1, 'convertCodesToDisplayText' => true))) {
						foreach ($va_general_condition as $va_gen_key => $va_general) {
							$va_condition_array[$va_general['general_condition_date']['start']][] = $va_general;
						}
					}
					if ($va_surface_condition = $t_object->get('ca_objects.surface_condition', array('returnAsArray' => true, 'rawDate' => 1, 'convertCodesToDisplayText' => true))) {
						foreach ($va_surface_condition as $va_sur_key => $va_surface) {
							$va_condition_array[$va_surface['surface_date']['start']][] = $va_surface;
						}
					}					
					if ($va_frame_condition = $t_object->get('ca_objects.frame_condition', array('returnAsArray' => true, 'rawDate' => 1, 'convertCodesToDisplayText' => true))) {
						foreach ($va_frame_condition as $va_frame_key => $va_frame) {
							$va_condition_array[$va_frame['frame_date']['start']][] = $va_frame; 
						}
					}
					if ($va_glazing_condition = $t_object->get('ca_objects.glazing_condition', array('returnAsArray' => true, 'rawDate' => 1, 'convertCodesToDisplayText' => true))) {
						foreach ($va_glazing_condition as $va_glaze_key => $va_glazing) {
							$va_condition_array[$va_glazing['glazing_date']['start']][] = $va_glazing; 
						}
					}	
					if ($va_support_condition = $t_object->get('ca_objects.support_condition', array('returnAsArray' => true, 'rawDate' => 1, 'convertCodesToDisplayText' => true))) {
						foreach ($va_support_condition as $va_sup_key => $va_support) {
							$va_condition_array[$va_support['support_date']['start']][] = $va_support;
						}
					}
					if ($va_vitrine_condition = $t_object->get('ca_objects.vitrine_condition', array('returnAsArray' => true, 'rawDate' => 1, 'convertCodesToDisplayText' => true))) {
						foreach ($va_vitrine_condition as $va_vit_key => $va_vitrine) {
							$va_condition_array[$va_vitrine['vitrine_date']['start']][] = $va_vitrine;
						}
					}
					if ($va_mount_condition = $t_object->get('ca_objects.mount_condition', array('returnAsArray' => true, 'rawDate' => 1, 'convertCodesToDisplayText' => true))) {
						foreach ($va_mount_condition as $va_mount_key => $va_mount) {
							$va_condition_array[$va_mount['mount_date']['start']][] = $va_mount; 
						}
					}	
					if ($va_base_condition = $t_object->get('ca_objects.base_condition', array('returnAsArray' => true, 'rawDate' => 1, 'convertCodesToDisplayText' => true))) {
						foreach ($va_base_condition as $va_base_key => $va_base) {
							$va_condition_array[$va_base['base_date']['start']][] = $va_base; 
						}
					}
					if ($va_pedestal_condition = $t_object->get('ca_objects.pedestal_condition', array('returnAsArray' => true, 'rawDate' => 1, 'convertCodesToDisplayText' => true))) {
						foreach ($va_pedestal_condition as $va_pedestal_key => $va_pedestal) {
							$va_condition_array[$va_pedestal['pedestal_date']['start']][] = $va_pedestal; 
						}
					}																																	
					if ($t_object->get('ca_objects.condition_images.condition_images_media')){
						$va_condition_images = $t_object->get('ca_objects.condition_images', array('returnAsArray' => true, 'ignoreLocale' => true, 'rawDate' => 1, 'version' => 'icon')); 

						$o_db = new Db();
						$vn_media_element_id = $t_object->_getElementID('condition_images_media');
						foreach ($va_condition_images as $vn_condition_id => $va_condition_image) {
							if ($va_condition_image['condition_images_primary'] == 162) {
								$qr_res = $o_db->query('SELECT value_id FROM ca_attribute_values WHERE attribute_id = ? AND element_id = ?', array($vn_condition_id, $vn_media_element_id)) ;
								if ($qr_res->nextRow()) {
									#print "<a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'Detail', 'GetMediaInfo', array('object_id' => $vn_object_id, 'value_id' => $qr_res->get('value_id')))."\"); return false;'>".$va_condition_image['condition_images_media']."</a>";
									$va_condition_image['value_id'] = $qr_res->get('value_id');
									$va_condition_array[$va_condition_image['condition_images_date']['start']][] = $va_condition_image;
								}
							}
						}
					}	
					if ($t_object->get('ca_objects.legacy_conservation_materials.legacy_conservation_media')){
						$va_conservation_images = $t_object->get('ca_objects.legacy_conservation_materials', array('returnAsArray' => true, 'ignoreLocale' => true, 'rawDate' => 1, 'version' => 'icon')); 
						
						$o_db = new Db();
						$vn_media_element_id = $t_object->_getElementID('legacy_conservation_media');
						foreach ($va_conservation_images as $vn_conservation_id => $va_conservation_image) {
							if ($va_conservation_image['legacy_conservation_primary'] == 162) {
								$qr_res = $o_db->query('SELECT value_id FROM ca_attribute_values WHERE attribute_id = ? AND element_id = ?', array($vn_conservation_id, $vn_media_element_id)) ;
								if ($qr_res->nextRow()) {
									#print "<a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'Detail', 'GetMediaInfo', array('object_id' => $vn_object_id, 'value_id' => $qr_res->get('value_id')))."\"); return false;'>".$va_conservation_image['legacy_conservation_media']."</a>";
									$va_conservation_image['legacy_value_id'] = $qr_res->get('value_id');
									$va_condition_array[$va_conservation_image['legacy_conservation_date']['start']][] = $va_conservation_image;
								}
							}
						}
					}	
					if ($t_object->get('ca_objects.conservation_reports.conservation_reports_media')){
						$va_outside_images = $t_object->get('ca_objects.conservation_reports', array('returnAsArray' => true, 'ignoreLocale' => true, 'rawDate' => 1, 'version' => 'icon')); 
						
						$o_db = new Db();
						$vn_media_element_id = $t_object->_getElementID('conservation_reports_media');
						foreach ($va_outside_images as $vn_outside_id => $va_outside_image) {
							if ($va_outside_image['conservation_reports_primary'] == 162) {
								$qr_res = $o_db->query('SELECT value_id FROM ca_attribute_values WHERE attribute_id = ? AND element_id = ?', array($vn_outside_id, $vn_media_element_id)) ;
								if ($qr_res->nextRow()) {
									#print "<a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'Detail', 'GetMediaInfo', array('object_id' => $vn_object_id, 'value_id' => $qr_res->get('value_id')))."\"); return false;'>".$va_conservation_image['legacy_conservation_media']."</a>";
									$va_outside_image['outside_value_id'] = $qr_res->get('value_id');
									$va_condition_array[$va_outside_image['conservation_reports_date']['start']][] = $va_outside_image;
								}
							}
						}
					}					
									

					krsort($va_condition_array);
					
					print "<div class='unit wide'><span class='metaHeader'>Condition </span><span>";	
					foreach ($va_condition_array as $va_condition_key => $va_condition_holder) {
						if ($va_condition_key != ""){
						$vn_i = 0;
						print "<div class='clearfix'></div>";
						print "<b>".caGetLocalizedHistoricDate($va_condition_key)."</b><br/>";
							foreach ($va_condition_holder as $va_condition) {
								/*
								if ($va_condition['general_condition_date']['start']) {
									print "<b>".caGetLocalizedHistoricDateRange($va_condition['general_condition_date']['start'], $va_condition['general_condition_date']['end'])."</b>";
								}
								if ($va_condition['surface_date']['start']) {
									print "<b>".caGetLocalizedHistoricDateRange($va_condition['surface_date']['start'], $va_condition['surface_date']['end'])."</b>";
								}
								if ($va_condition['frame_date']['start']) {
									print "<b>".caGetLocalizedHistoricDateRange($va_condition['frame_date']['start'], $va_condition['frame_date']['end'])."</b>";
								}
								if ($va_condition['glazing_date']['start']) {
									print "<b>".caGetLocalizedHistoricDateRange($va_condition['glazing_date']['start'], $va_condition['glazing_date']['end'])."</b>";
								}
								if ($va_condition['support_date']['start']) {
									print "<b>".caGetLocalizedHistoricDateRange($va_condition['support_date']['start'], $va_condition['support_date']['end'])."</b>";
								}	
								if ($va_condition['vitrine_date']['start']) {
									print "<b>".caGetLocalizedHistoricDateRange($va_condition['vitrine_date']['start'], $va_condition['vitrine_date']['end'])."</b>";
								}
								if ($va_condition['mount_date']['start']) {
									print "<b>".caGetLocalizedHistoricDateRange($va_condition['mount_date']['start'], $va_condition['mount_date']['end'])."</b>";
								}
								if ($va_condition['base_date']['start']) {
									print "<b>".caGetLocalizedHistoricDateRange($va_condition['base_date']['start'], $va_condition['base_date']['end'])."</b>";
								}
								*/																																				
								if (($va_condition['general_condition_value']) || ($va_condition['general_condition_comments'])) {
									print " <u>General Condition:</u> ".($va_condition['general_condition_value'] ? $va_condition['general_condition_value'].". " : "").preg_replace('![\.\,\;\:]+$!', '', $va_condition['general_condition_comments']).($va_condition['general_condition_comments'] ? ", " : "").($va_condition['general_condition_specific'] ? "assessed by ".$va_condition['general_condition_person']." ".$va_condition['general_condition_specific'] : "");
									print "<div class='clearfix'></div>";
								}
								if ($va_condition['frame_value'] || ($va_condition['frame_notes'])) {
									print " <u>Frame:</u> ".$va_condition['frame_value']." - ".$va_condition['frame_notes'].", assessed by ".$va_condition['frame_assessor'];
									print "<div class='clearfix'></div>";
								}
								if ($va_condition['glazing_value'] || ($va_condition['glazing_notes'])) {
									print " <u>Glazing:</u> ".$va_condition['glazing_value']." - ".$va_condition['glazing_notes'].", assessed by ".$va_condition['glazing_assessor'];
									print "<div class='clearfix'></div>";
								}												
								if ($va_condition['support_value'] || ($va_condition['support_notes'])) {
									print " <u>Support:</u> ".$va_condition['support_value']." - ".$va_condition['support_notes'].", assessed by ".$va_condition['support_assessor'];
									print "<div class='clearfix'></div>";
								}
								if ($va_condition['vitrine_value'] || ($va_condition['vitrine_notes'])) {
									print " <u>Vitrine:</u> ".$va_condition['vitrine_value']." - ".$va_condition['vitrine_notes'].", assessed by ".$va_condition['vitrine_assessor'];
									print "<div class='clearfix'></div>";
								}
								if ($va_condition['mount_value'] || ($va_condition['mount_notes'])) {
									print " <u>Mount:</u> ".$va_condition['mount_value']." - ".$va_condition['mount_notes'].", assessed by ".$va_condition['mount_assessor'];
									print "<div class='clearfix'></div>";
								}
								if (($va_condition['surface_value']) || ($va_condition['surface_notes'])) {
									print " <u>Surface:</u> ".$va_condition['surface_value']." - ".$va_condition['surface_notes'].", assessed by ".$va_condition['surface_assessor'];
									print "<div class='clearfix'></div>";
								}
								if (($va_condition['base_value']) || ($va_condition['base_notes'])) {
									print " <u>Base:</u> ".$va_condition['base_value']." - ".$va_condition['base_notes'].", assessed by ".$va_condition['base_assessor'];
									print "<div class='clearfix'></div>";
								}
								if (($va_condition['pedestal_value']) || ($va_condition['pedestal_notes'])) {
									print " <u>Pedestal:</u> ".$va_condition['pedestal_value']." - ".$va_condition['pedestal_notes'].", assessed by ".$va_condition['pedestal_assessor'];
									print "<div class='clearfix'></div>";
								}																																
								if ($va_condition['condition_images_date']['start']) {
									#print "<b>".caGetLocalizedHistoricDateRange($va_condition['condition_images_date']['start'], $va_condition['condition_images_date']['end'])."</b>: <br/>";
									print "<a href='#' class='conditionImage' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'Detail', 'GetMediaInfo/ca_objects', array('object_id' => $vn_object_id, 'value_id' =>  $va_condition['value_id']))."\"); return false;'>".$va_condition['condition_images_media']."</a>";
									#print "<div class='clearfix'></div>";
									$vn_i++;
									if ($vn_i == 3) {
										print "<div class='clearfix'></div>";
										$vn_i = 0;
									}
								}
								if ($va_condition['legacy_conservation_date']['start']) {
									#print "<b>".caGetLocalizedHistoricDateRange($va_condition['legacy_conservation_date']['start'], $va_condition['legacy_conservation_date']['end'])."</b>: <br/>";
									print "<a href='#' class='conditionImage' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'Detail', 'GetMediaInfo/ca_objects', array('object_id' => $vn_object_id, 'value_id' =>  $va_condition['legacy_value_id']))."\"); return false;'>".$va_condition['legacy_conservation_media']."</a>";
									#print "<div class='clearfix'></div>";
									$vn_i++;
									if ($vn_i == 3) {
										print "<div class='clearfix'></div>";
										$vn_i = 0;
									}									
								}
								if ($va_condition['conservation_reports_date']['start']) {
									#print "<b>".caGetLocalizedHistoricDateRange($va_condition['legacy_conservation_date']['start'], $va_condition['legacy_conservation_date']['end'])."</b>: <br/>";
									print "<a href='#' class='conditionImage' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'Detail', 'GetMediaInfo/ca_objects', array('object_id' => $vn_object_id, 'value_id' =>  $va_condition['outside_value_id']))."\"); return false;'>".$va_condition['conservation_reports_media']."</a>";
									#print "<div class='clearfix'></div>";
									$vn_i++;
									if ($vn_i == 3) {
										print "<div class='clearfix'></div>";
										$vn_i = 0;
									}									
								}									
											
								#print "<br/>";
							}
						}
					}	
					print "</span>";
					print "</div>";
				} else {
					print "access restricted";
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
					if ($va_item_weight = $t_object->get('ca_objects.dimensions.dimensions_weight')) {
						print "<div class='unit'><span class='metaTitle'>Weight: </span>".$va_item_weight."</div>";
					}									
?>
					{{{<ifcount min="1" code="ca_objects.inscription"><div class='unit'><span class='metaTitle'>Inscription: </span><span class='meta'><unit delimiter="<br/>">^ca_objects.inscription.inscription_position1 ^ca_objects.inscription.inscription_position2 ^ca_objects.inscription.inscription_position3 ^ca_objects.inscription.inscription_material - ^ca_objects.inscription.inscription_text</unit></span></div></ifcount>}}}
					{{{<ifcount min="1" code="ca_objects.sticker_label"><div class='unit'><span class='metaTitle'>Label Details </span><span class='meta'><unit delimiter="<br/>">^ca_objects.sticker_label</unit></span></div></ifcount>}}}
<?php
					if ($t_object->get('ca_objects.inscription_uploads.inscription_uploads_media')){
						$va_inscription_images = $t_object->get('ca_objects.inscription_uploads', array('returnAsArray' => true, 'ignoreLocale' => true, 'version' => 'icon')); 
						print '<div class="unit wide"><span class="metaHeader">Inscription Uploads</span><span>';
						
						$o_db = new Db();
						$vn_media_element_id = $t_object->_getElementID('inscription_uploads_media');
						foreach ($va_inscription_images as $vn_inscription_id => $va_inscription_image) {
							if ($va_inscription_image['inscription_uploads_primary'] == 162) {
								$qr_res = $o_db->query('SELECT value_id FROM ca_attribute_values WHERE attribute_id = ? AND element_id = ?', array($vn_inscription_id, $vn_media_element_id)) ;
								if ($qr_res->nextRow()) {
									print "<a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'Detail', 'GetMediaInfo/ca_objects', array('object_id' => $vn_object_id, 'value_id' => $qr_res->get('value_id')))."\"); return false;'>".$va_inscription_image['inscription_uploads_media']."</a>";
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
							if (($va_cert_auth['certificate_auth_yn'] != "No") && ($va_cert_auth['certificate_auth_yn'] != "N/A") && ($va_cert_auth['certificate_auth_yn'] != "")) {
								print "<div class='unit'><span class='metaTitle'>Certificate of Authenticity: </span><span class='meta'>".$va_cert_auth['certificate_auth_yn']." ".$va_cert_auth['certificate_auth_date']." ".$va_cert_auth['certificate_auth_notes']."</div>";
							}
						}
					}
					if ($va_art_agrs = $t_object->get('ca_objects.artist_agreement', array('returnAsArray' => true, 'convertCodesToDisplayText' => true))) {
						foreach ($va_art_agrs as $va_arg_key => $va_art_agr) {
							if (($va_art_agr['artist_agreement_yn'] != "No") && ($va_art_agr['artist_agreement_yn'] != "N/A") && ($va_art_agr['artist_agreement_yn'] != "")) {
								print "<div class='unit'><span class='metaTitle'>Artist Agreement: </span><span class='meta'>".$va_art_agr['artist_agreement_yn']." ".$va_art_agr['artist_agreement_date']." ".$va_art_agr['artist_agreement_notes']."</div>";
							}
						}
					}
					if ($va_non_excl = $t_object->get('ca_objects.non_exclusive', array('returnAsArray' => true, 'convertCodesToDisplayText' => true))) {
						foreach ($va_non_excl as $va_non_key => $va_non_exc) {
							if (($va_non_exc['non_exclusive_yn'] != "No") && ($va_non_exc['non_exclusive_yn'] != "N/A") && ($va_non_exc['non_exclusive_yn'] != "")) {
								print "<div class='unit'><span class='metaTitle'>Non-exclusive License: </span><span class='meta'>".$va_non_exc['non_exclusive_yn']." ".$va_non_exc['non_exclusive_date']." ".$va_non_exc['non_exclusive_notes']."</div>";
							}
						}
					}
					if ($va_transparencys = $t_object->get('ca_objects.transparency', array('returnAsArray' => true, 'convertCodesToDisplayText' => true))) {
						foreach ($va_transparencys as $va_tran_key => $va_transparency) {
							if (($va_transparency['transparency_yn'] != "No") && ($va_transparency['transparency_yn'] != "N/A") && ($va_transparency['transparency_yn'] != "")) {
								print "<div class='unit'><span class='metaTitle'>Transparency: </span><span class='meta'>".$va_transparency['transparency_yn']." ".$va_transparency['transparency_date']." ".$va_transparency['transparency_notes']."</div>";
							}
						}
					}
					if ($va_photo_records = $t_object->get('ca_objects.photo_record', array('returnAsArray' => true, 'convertCodesToDisplayText' => true))) {
						foreach ($va_photo_records as $va_photo_key => $va_photo_record) {
							if (($va_photo_record['photo_record_yn'] != "No") && ($va_photo_record['photo_record_yn'] != "N/A") && ($va_photo_record['photo_record_yn'] != "")) {
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
						if ($va_artwork_docs = $t_object->get('ca_objects.artwork_documents.artwork_documents_primary', array('returnAsArray' => true))){

						$va_doc_primary = false;
							foreach($va_artwork_docs as $va_key => $va_docs) {
								if ($va_docs == 162) {
									$va_doc_primary = true;
								}
							}
							if ($va_doc_primary == true) {
								$va_artwork_docs = $t_object->get('ca_objects.artwork_documents', array('returnAsArray' => true, 'ignoreLocale' => true, 'convertCodesToDisplayText' => true)); 
								print '<div class="unit wide"><span class="metaHeader">Artwork Documents</span><span>';
						
								$o_db = new Db();
								$vn_media_element_id = $t_object->_getElementID('artwork_documents_media');
								foreach ($va_artwork_docs as $vn_doc_id => $va_artwork_doc) {
									if ($va_artwork_doc['artwork_documents_primary'] == "Yes") {
										$qr_res = $o_db->query('SELECT value_id FROM ca_attribute_values WHERE attribute_id = ? AND element_id = ?', array($vn_doc_id, $vn_media_element_id)) ;
										if ($qr_res->nextRow()) {
											print "<a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'Detail', 'GetMediaInfo/ca_objects', array('object_id' => $vn_object_id, 'value_id' => $qr_res->get('value_id')))."\"); return false;'>".$va_artwork_doc['artwork_documents_media']."</a>";
										}
									}
								}
								print "</span><div class='clearfix'></div></div>";
							}
						}
					}
					
?>
				</div>				
			
			</div><!-- end col -->
		</div><!-- end row -->
	</div><!-- end container -->
<?php
	#$va_archives = $t_object->get('ca_objects.related', array('checkAccess' => caGetUserAccessValues($this->request), 'restrictToTypes' => array('audio', 'documents', 'ephemera', 'image', 'moving_image')));
	if (sizeof($va_archives) > 0) {
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
			$va_object_ids = $t_object->get('ca_objects.related.object_id', array('checkAccess' => caGetUserAccessValues($this->request), 'returnAsArray' => true, 'restrictToTypes' => array('audio', 'documents', 'ephemera', 'image', 'moving_image')));
			foreach ($va_object_ids as $obj_key => $va_object_id) {
				$t_archive = new ca_objects($va_object_id);
				print "<div class='archivesResult'>";
				print "<div class='resultImg'>".caNavLink($this->request, $t_archive->get('ca_object_representations.media.widepreview'), '', '', 'Detail', 'artworks/'.$va_object_id)."</div>";
				print "<p>".caNavLink($this->request, $t_archive->get('ca_objects.preferred_labels.name'), '', '', 'Detail', 'artworks/'.$va_object_id)."</p>";
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
	
	if ($t_object->get('ca_objects.related', array('checkAccess' => caGetUserAccessValues($this->request), 'restrictToTypes' => array('book')))) {
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
			$va_object_ids = $t_object->get('ca_objects.related.object_id', array('checkAccess' => caGetUserAccessValues($this->request), 'returnAsArray' => true, 'restrictToTypes' => array('book')));
			foreach ($va_object_ids as $obj_key => $va_object_id) {
				$t_library = new ca_objects($va_object_id);
				print "<div class='libraryResult'>";
				print "<div class='resultImg'>".caNavLink($this->request, $t_library->get('ca_object_representations.media.library'), '', '', 'Detail', 'artworks/'.$va_object_id)."</div>";
				print "<p>".caNavLink($this->request, $t_library->get('ca_objects.preferred_labels'), '', '', 'Detail', 'artworks/'.$va_object_id)."</p>";				
				print "<p>".caNavLink($this->request, $t_library->get('ca_entities.preferred_labels.name', array('restrictToRelationshipTypes' => array('author'))), '', '', 'Detail', 'artworks/'.$va_object_id)."</p>";
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
	
	if ($t_object->get('ca_objects.related', array('checkAccess' => caGetUserAccessValues($this->request), 'restrictToTypes' => array('artwork')))) {
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
			$va_object_ids = $t_object->get('ca_objects.related.object_id', array('checkAccess' => caGetUserAccessValues($this->request), 'returnAsArray' => true, 'restrictToTypes' => array('artwork')));
			foreach ($va_object_ids as $obj_key => $va_object_id) {
				$t_object = new ca_objects($va_object_id);
				print "<div class='archivesResult'>";
				print "<div class='resultImg'>".caNavLink($this->request, $t_object->get('ca_object_representations.media.widepreview'), '', '', 'Detail', 'artworks/'.$va_object_id)."</div>";
				print "<p>".caNavLink($this->request, $t_object->get('ca_objects.preferred_labels.name'), '', '', 'Detail', 'artworks/'.$va_object_id)."</p>";
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