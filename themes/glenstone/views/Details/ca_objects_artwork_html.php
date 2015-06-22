<?php
	$t_object = $this->getVar("item");
	$vn_object_id = $t_object->get('ca_objects.object_id');
	$va_comments = $this->getVar("comments");
	$pn_rep_id = $this->getVar("representation_id");
	
	
	$va_export_formats = $this->getVar('export_formats');
	$vs_export_format_select = $this->getVar('export_format_select');
	
	$t_set = new ca_sets();
	$va_sets = caExtractValuesByUserLocale($t_set->getSetsForItem("ca_objects", $t_object->get("object_id"), array("user_id" => $this->request->user->get("user_id"))));
	$va_lightbox_crumbs = array();
	foreach($va_sets as $vn_set_id => $va_set){
		$va_lightbox_crumbs[] = caNavLink($this->request, _t("Lightbox"), "", "", "Lightbox", "Index")." &#8594; ".caNavLink($this->request, $va_set["name"], "", "", "Lightbox", "SetDetail", array("set_id" => $vn_set_id))." &#8594; ".$t_object->get("ca_objects.preferred_labels.name");
	}
	$vs_lightbox_crumbs = "";
	if(sizeof($va_lightbox_crumbs)){
		$vs_lightbox_crumbs = join("<br/>", $va_lightbox_crumbs);
	}
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
if ($this->request->user->hasUserRole("founders_new") || $this->request->user->hasUserRole("admin") || $this->request->user->hasUserRole("curatorial_all_new") || $this->request->user->hasUserRole("curatorial_basic_new") || $this->request->user->hasUserRole("archives_new") || $this->request->user->hasUserRole("library_new")) {
	// Export as PDF
	print "<div id='bViewButtons'>";
	print "<div class='reportTools'>";
	print caFormTag($this->request, 'view/pdf', 'caExportForm', ($this->request->getModulePath() ? $this->request->getModulePath().'/' : '').$this->request->getController().'/'.$this->request->getAction().'/'.$this->request->getActionExtra(), 'post', 'multipart/form-data', '_top', array('disableUnsavedChangesWarning' => true));
	print "{$vs_export_format_select}".caFormSubmitLink($this->request, _t('Download'), 'button', 'caExportForm')."</form>\n";
	print "</div>"; 
	print "</div>"; 
}
			if($vs_lightbox_crumbs){
?>
			<div class="detailLightboxCrumb"><?php print $vs_lightbox_crumbs; ?></div>
<?php
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
		#print "<div class='repIcons'>".caObjectRepresentationThumbnails($this->request, $pn_rep_id, $t_object, array('dontShowCurrentRep' => false))."</div>";
		# --- get reps as thumbnails
		$va_reps = $t_object->getRepresentations(array("icon"), null, array("checkAccess" => caGetUserAccessValues($this->request)));
		if(sizeof($va_reps) > 1){		
			$va_links = array();
			$vn_primary_id = "";
			foreach($va_reps as $vn_rep_id => $va_rep){
				$vs_class = "";
				if($va_rep["is_primary"]){
					$vn_primary_id = $vn_rep_id;
				}
				if($vn_rep_id == $pn_rep_id){
					$vs_class = "active";
				}
				$vs_thumb = $va_rep["tags"]["icon"];
				$vs_icon = "";
				if(in_array($va_rep["mimetype"], array("video/mp4", "video/x-flv", "video/mpeg", "audio/x-realaudio", "video/quicktime", "video/x-ms-asf", "video/x-ms-wmv", "application/x-shockwave-flash", "video/x-matroska"))){
					$vs_icon = "<i class='glyphicon glyphicon-film'></i>";
				}
				if(in_array($va_rep["mimetype"], array("audio/mpeg", "audio/x-aiff", "audio/x-wav", "audio/mp4"))){
					$vs_icon = "<i class='glyphicon volume-up'></i>";
				}
				$va_links[$vn_rep_id] = "<a href='#' onclick='$(\".active\").removeClass(\"active\"); $(this).parent().addClass(\"active\"); $(this).addClass(\"active\"); $(\".jcarousel\").jcarousel(\"scroll\", $(\"#slide".$vn_rep_id."\"), false); return false;' ".(($vs_class) ? "class='".$vs_class."'" : "").">".$vs_icon.$vs_thumb."</a>\n";
			}
			# --- make sure the primary rep shows up first
			$va_primary_link = array($vn_primary_id => $va_links[$vn_primary_id]);
			unset($va_links[$vn_primary_id]);
			$va_links = $va_primary_link + $va_links;
			# --- formatting
			$vs_formatted_thumbs = "";
	
			$vs_formatted_thumbs = "<ul id='detailRepresentationThumbnails'>";
			foreach($va_links as $vn_rep_id => $vs_link){
				$vs_formatted_thumbs .= "<li id='detailRepresentationThumbnail".$vn_rep_id."'".(($vn_rep_id == $pn_rep_id) ? " class='active'" : "").">".$vs_link."</li>\n";
			}
			$vs_formatted_thumbs .= "</ul>";
			print "<div class='repIcons'>".$vs_formatted_thumbs."</div>";
		}
?>				
			</div><!-- end col -->
			<div class='col-sm-5 col-md-5 col-lg-5'>
			
				<div class='tabdiv'>
					<div class='toggle'><a href='#' onclick="$('.infoBlock').hide(); $('#artworkInfo').fadeIn(100);">Tombstone</a></div>
					<div class='toggle'><a href='#' onclick="$('.infoBlock').hide(); $('#factSheet').fadeIn(100);">Fact Sheet</a></div>
<?php 			if ($this->request->user->hasUserRole("founders_new") || $this->request->user->hasUserRole("admin") || $this->request->user->hasUserRole("curatorial_all_new") || $this->request->user->hasUserRole("art_location_new")){ ?>					
					<div class='toggle'><a href='#' onclick="$('.infoBlock').hide(); $('#Location').fadeIn(100);">Location</a></div> 
<?php 			}  ?>			
<?php 			if ($this->request->user->hasUserRole("founders_new") || $this->request->user->hasUserRole("admin") || $this->request->user->hasUserRole("curatorial_all_new") || $this->request->user->hasUserRole("art_insurance_loan")){ ?>					
					<div class='toggle'><a href='#' onclick="$('.infoBlock').hide(); $('#Financial').fadeIn(100);">Financials</a></div>
<?php 			}  ?>	
<?php 			if ($this->request->user->hasUserRole("founders_new") || $this->request->user->hasUserRole("admin") || $this->request->user->hasUserRole("curatorial_all_new") || $this->request->user->hasUserRole("art_condition_new") || $this->request->user->hasUserRole("art_conservation_new")){ ?>										
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
<?php
					if ($t_object->get('ca_objects.edition.edition_number')) {
						print "<div class='unit'>Edition ".$t_object->get('ca_objects.edition.edition_number')." / ".$t_object->get('ca_objects.edition.edition_total');
						if ($t_object->get('ca_objects.edition.ap_number')) {
							print "+ ".$t_object->get('ca_objects.edition.ap_number')." AP";
						}
						print "</div>";
					} elseif ($t_object->get('ca_objects.edition.ap_number')) {
						print "<div class='unit'>AP ".(count($t_object->get('ca_objects.edition.ap_total')) >= 2 ? $t_object->get('ca_objects.edition.ap_number') : "")." from an edition of ".$t_object->get('ca_objects.edition.edition_total')." + ".$t_object->get('ca_objects.edition.ap_total')." AP";
						print "</div>";					
					}
					if ($t_object->get('ca_objects.signed.signed_yn') == "No") {
						print "Signed, ".$t_object->get('ca_objects.signed.signature_details');
					}
					if ($this->request->user->hasUserRole("founders_new") || $this->request->user->hasUserRole("admin") || $this->request->user->hasUserRole("curatorial_all_new") || $this->request->user->hasUserRole("curatorial_basic_new") || $this->request->user->hasUserRole("archives_new") || $this->request->user->hasUserRole("library_new")){
						if ($va_idno = $t_object->get('ca_objects.idno')) {
								print "<div class='unit wide'>".$va_idno."</div>";
						}
					}					
?>					
				</div>
				
				<div id="factSheet" class="infoBlock">
<?php					
					if ($this->request->user->hasUserRole("founders_new") || $this->request->user->hasUserRole("admin") || $this->request->user->hasUserRole("curatorial_all_new")){
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
				if ($this->request->user->hasUserRole("founders_new") || $this->request->user->hasUserRole("admin") || $this->request->user->hasUserRole("curatorial_all_new") || $this->request->user->hasUserRole("art_location_new")){
			
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
					if ($this->request->user->hasUserRole("founders_new") || $this->request->user->hasUserRole("admin") || $this->request->user->hasUserRole("curatorial_all_new")){
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
						print "<br/>";						
	
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
								break;
							}
							print"</span></div>";
						}
						print "<br/>";
						if ($va_acquisition = $t_object->get('ca_object_lots.preferred_labels', array('returnAsLink' => true))) {
							print "<div class='unit'><span class='metaTitle'>Acquisition Details: </span><span class='meta'>".$va_acquisition."</span></div>";
						}											
					} elseif ($this->request->user->hasUserRole("art_insurance_loan")) {
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
					} else { 
						print "access restricted";
					}
?>
				</div>
				<div id="Condition" class="infoBlock">
<?php
				if ($this->request->user->hasUserRole("founders_new") || $this->request->user->hasUserRole("admin") || $this->request->user->hasUserRole("curatorial_all_new") || $this->request->user->hasUserRole("art_condition_new") || $this->request->user->hasUserRole("art_conservation_new")){

					$va_condition_array = array();
					if ($va_general_condition = $t_object->get('ca_objects.general_condition', array('returnAsArray' => true, 'rawDate' => 1, 'convertCodesToDisplayText' => true))) {
						foreach ($va_general_condition as $va_gen_key => $va_general) {
							$va_condition_array[$va_general['general_condition_date']['start']][] = $va_general;
						}
					}
					if ($va_detailed_condition = $t_object->get('ca_objects.detailed_condition', array('returnAsArray' => true, 'rawDate' => 1, 'convertCodesToDisplayText' => true, 'showHierarchy' => true))) {
						foreach ($va_detailed_condition as $va_det_key => $va_detailed) {
							$va_condition_array[$va_detailed['detailed_date']['start']][] = $va_detailed;
						}
					}					
#					if ($va_surface_condition = $t_object->get('ca_objects.surface_condition', array('returnAsArray' => true, 'rawDate' => 1, 'convertCodesToDisplayText' => true))) {
#						foreach ($va_surface_condition as $va_sur_key => $va_surface) {
#							$va_condition_array[$va_surface['surface_date']['start']][] = $va_surface;
#						}
#					}					
#					if ($va_frame_condition = $t_object->get('ca_objects.frame_condition', array('returnAsArray' => true, 'rawDate' => 1, 'convertCodesToDisplayText' => true))) {
#						foreach ($va_frame_condition as $va_frame_key => $va_frame) {
#							$va_condition_array[$va_frame['frame_date']['start']][] = $va_frame; 
#						}
#					}
#					if ($va_glazing_condition = $t_object->get('ca_objects.glazing_condition', array('returnAsArray' => true, 'rawDate' => 1, 'convertCodesToDisplayText' => true))) {
#						foreach ($va_glazing_condition as $va_glaze_key => $va_glazing) {
#							$va_condition_array[$va_glazing['glazing_date']['start']][] = $va_glazing; 
#						}
#					}	
#					if ($va_support_condition = $t_object->get('ca_objects.support_condition', array('returnAsArray' => true, 'rawDate' => 1, 'convertCodesToDisplayText' => true))) {
#						foreach ($va_support_condition as $va_sup_key => $va_support) {
#							$va_condition_array[$va_support['support_date']['start']][] = $va_support;
#						}
#					}
#					if ($va_vitrine_condition = $t_object->get('ca_objects.vitrine_condition', array('returnAsArray' => true, 'rawDate' => 1, 'convertCodesToDisplayText' => true))) {
#						foreach ($va_vitrine_condition as $va_vit_key => $va_vitrine) {
#							$va_condition_array[$va_vitrine['vitrine_date']['start']][] = $va_vitrine;
#						}
#					}
#					if ($va_mount_condition = $t_object->get('ca_objects.mount_condition', array('returnAsArray' => true, 'rawDate' => 1, 'convertCodesToDisplayText' => true))) {
#						foreach ($va_mount_condition as $va_mount_key => $va_mount) {
#							$va_condition_array[$va_mount['mount_date']['start']][] = $va_mount; 
#						}
#					}	
#					if ($va_base_condition = $t_object->get('ca_objects.base_condition', array('returnAsArray' => true, 'rawDate' => 1, 'convertCodesToDisplayText' => true))) {
#						foreach ($va_base_condition as $va_base_key => $va_base) {
#							$va_condition_array[$va_base['base_date']['start']][] = $va_base; 
#						}
#					}
#					if ($va_pedestal_condition = $t_object->get('ca_objects.pedestal_condition', array('returnAsArray' => true, 'rawDate' => 1, 'convertCodesToDisplayText' => true))) {
#						foreach ($va_pedestal_condition as $va_pedestal_key => $va_pedestal) {
#							$va_condition_array[$va_pedestal['pedestal_date']['start']][] = $va_pedestal; 
#						}
#					}																																	
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
						print "<b>".caGetLocalizedHistoricDate($va_condition_key, array('timeOmit' => true))."</b><br/>";
							foreach ($va_condition_holder as $va_condition) {																																				
								if (($va_condition['general_condition_value']) || ($va_condition['general_condition_comments'])) {
									print " <u>General Condition:</u> ".($va_condition['general_condition_value'] ? $va_condition['general_condition_value'].". " : "").preg_replace('![\.\,\;\:]+$!', '', $va_condition['general_condition_comments']).($va_condition['general_condition_comments'] ? ", " : "").($va_condition['general_condition_specific'] ? "assessed by ".$va_condition['general_condition_person']." ".$va_condition['general_condition_specific'] : "");
									print "<div class='clearfix'></div>";
								}
								if (($va_condition['detailed_value']) || ($va_condition['detailed_notes'])) {
									print " <u>Detailed Condition:</u> ".($va_condition['detailed_value'] ? $va_condition['detailed_value'][1].": ".$va_condition['detailed_value'][0].". " : "").preg_replace('![\.\,\;\:]+$!', '', $va_condition['detailed_notes']).($va_condition['detailed_notes'] ? ", " : "").($va_condition['detailed_assessor'] ? "assessed by ".$va_condition['detailed_assessor'] : "");
									print "<div class='clearfix'></div>";
								}								
								/*if ($va_condition['frame_value'] || ($va_condition['frame_notes'])) {
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
								*/																															
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
					{{{<ifcount min="1" code="ca_objects.object_dates.object_date"><div class='unit wide'><span class='metaHeader'>Date: </span><span ><unit delimiter="<br/>">^ca_objects.object_dates.object_date <ifdef code="ca_objects.object_dates.date_note">(^ca_objects.object_dates.date_note)</ifdef></unit></span></div></ifcount>}}}
					{{{<ifcount min="1" code="ca_objects.child.preferred_labels"><div class='unit wide'><span class='metaHeader'>Elements </span><span ><unit delimiter="<br/>"><l>^ca_objects.child.preferred_labels</l></unit></span></div></ifcount>}}}
					{{{<ifdef code="ca_objects.element_notes"><div class='unit wide'><span class='metaHeader'>Element Notes: </span><span >^ca_objects.element_notes</span></div></ifdef>}}}
					{{{<ifdef code="ca_objects.category"><div class='unit wide'><span class='metaHeader'>Category: </span><span >^ca_objects.category</span></div></ifdef>}}}
<?php
					if ($t_object->get('ca_objects.signed.signed_yn') == "Yes") {
						print "<div class='unit wide'><span class='metaHeader'>Signed: </span><span>".ucfirst($t_object->get('ca_objects.signed.signature_details'))."</span></div>";
					}
					if ($t_object->get('ca_objects.dated') == "Yes") {
						print "<div class='unit wide'><span class='metaHeader'>Dated: </span><span>Dated</span></div>";
					}	
					if ($va_item_weight = $t_object->get('ca_objects.dimensions.dimensions_weight')) {
						print "<div class='unit wide'><span class='metaHeader'>Weight: </span><span>".$va_item_weight."</span></div>";
					}									
?>
					{{{<ifcount min="1" code="ca_objects.inscription"><div class='unit wide'><span class='metaHeader'>Inscription: </span><span><unit delimiter="<br/>">^ca_objects.inscription.inscription_position1 ^ca_objects.inscription.inscription_position2 ^ca_objects.inscription.inscription_position3 ^ca_objects.inscription.inscription_material - ^ca_objects.inscription.inscription_text</unit></span></div></ifcount>}}}
					{{{<ifcount min="1" code="ca_objects.sticker_label"><div class='unit wide'><span class='metaHeader'>Label Details </span><span><unit delimiter="<br/>">^ca_objects.sticker_label</unit></span></div></ifcount>}}}
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
					{{{<ifcount min="1" code="ca_objects.nonpreferred_labels"><div class='unit wide'><span class='metaHeader'>Other Titles </span><span><unit delimiter="<br/>">^ca_objects.nonpreferred_labels</unit></span></div></ifcount>}}}
					{{{<ifdef code="ca_objects.legacy_description"><div class='unit wide'><span class='metaHeader'>Description (Legacy): </span><span>^ca_objects.legacy_description</span></div></ifdef>}}}
					{{{<ifdef code="ca_objects.legacy_comments"><div class='unit wide'><span class='metaHeader'>Comments (Legacy): </span><span>^ca_objects.legacy_comments</span></div></ifdef>}}}
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
								print "<div class='unit wide'><span class='metaHeader'>Certificate of Authenticity: </span><span>".$va_cert_auth['certificate_auth_yn']." ".$va_cert_auth['certificate_auth_date']." ".$va_cert_auth['certificate_auth_notes']."</div>";
							}
						}
					}
					if ($va_art_agrs = $t_object->get('ca_objects.artist_agreement', array('returnAsArray' => true, 'convertCodesToDisplayText' => true))) {
						foreach ($va_art_agrs as $va_arg_key => $va_art_agr) {
							if (($va_art_agr['artist_agreement_yn'] != "No") && ($va_art_agr['artist_agreement_yn'] != "N/A") && ($va_art_agr['artist_agreement_yn'] != "")) {
								print "<div class='unit wide'><span class='metaHeader'>Artist Agreement: </span><span >".$va_art_agr['artist_agreement_yn']." ".$va_art_agr['artist_agreement_date']." ".$va_art_agr['artist_agreement_notes']."</div>";
							}
						}
					}
					if ($va_non_excl = $t_object->get('ca_objects.non_exclusive', array('returnAsArray' => true, 'convertCodesToDisplayText' => true))) {
						foreach ($va_non_excl as $va_non_key => $va_non_exc) {
							if (($va_non_exc['non_exclusive_yn'] != "No") && ($va_non_exc['non_exclusive_yn'] != "N/A") && ($va_non_exc['non_exclusive_yn'] != "")) {
								print "<div class='unit wide'><span class='metaHeader'>Non-exclusive License: </span><span >".$va_non_exc['non_exclusive_yn']." ".$va_non_exc['non_exclusive_date']." ".$va_non_exc['non_exclusive_notes']."</div>";
							}
						}
					}
					if ($va_transparencys = $t_object->get('ca_objects.transparency', array('returnAsArray' => true, 'convertCodesToDisplayText' => true))) {
						foreach ($va_transparencys as $va_tran_key => $va_transparency) {
							if (($va_transparency['transparency_yn'] != "No") && ($va_transparency['transparency_yn'] != "N/A") && ($va_transparency['transparency_yn'] != "")) {
								print "<div class='unit wide'><span class='metaHeader'>Transparency: </span><span >".$va_transparency['transparency_yn']." ".$va_transparency['transparency_date']." ".$va_transparency['transparency_notes']."</div>";
							}
						}
					}
					if ($va_photo_records = $t_object->get('ca_objects.photo_record', array('returnAsArray' => true, 'convertCodesToDisplayText' => true))) {
						foreach ($va_photo_records as $va_photo_key => $va_photo_record) {
							if (($va_photo_record['photo_record_yn'] != "No") && ($va_photo_record['photo_record_yn'] != "N/A") && ($va_photo_record['photo_record_yn'] != "")) {
								print "<div class='unit wide'><span class='metaHeader'>Photograph Information Record: </span><span >".$va_photo_record['photo_record_yn']." ".$va_photo_record['photo_record_date']." ".$va_photo_record['photo_record_notes']."</div>";
							}
						}
					}																				
?>
					{{{<ifdef code="ca_objects.artwork_website"><div class='unit'><span class='metaTitle'>Website: </span><span class='meta'>^ca_objects.artwork_website</span></div></ifdef>}}}
<?php
					if ($va_notes = $t_object->get('ca_objects.other_notes', array('returnAsArray' => true, 'convertCodesToDisplayText' => true))) {
						foreach ($va_notes as $va_key => $va_note) {
						
							if ($va_note['other_notes_content']) {
								print "<div class='unit wide'><span class='metaHeader'>".$va_note['other_notes_type'].": </span><span >".$va_note['other_notes_content']."</span></unit>";
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
	if ($t_object->get('ca_objects.related', array('checkAccess' => caGetUserAccessValues($this->request), 'restrictToTypes' => array('audio', 'document', 'ephemera', 'image', 'moving_image')))) {
?>	
<div class="row">
	<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
		<div class="container">
<?php	
			if (!$this->request->isAjax()) {
				$va_object_ids = $t_object->get('ca_objects.related.object_id', array('checkAccess' => caGetUserAccessValues($this->request), 'returnAsArray' => true, 'restrictToTypes' => array('audio', 'document', 'ephemera', 'image', 'moving_image')));
			
?>		<hr>
		<H6>Related Archive Items <small><?php if (sizeof($va_object_ids) > 1) { print caNavLink($this->request, 'view all', '', '', 'Search', 'archives', array('search' => 'object_id:'.$t_object->getPrimaryKey())); } ?></small></H6>
		<div class="archivesBlock">
			<div class="blockResults">
				<div id="archivesscrollButtonPrevious" class="scrollButtonPrevious"><i class="fa fa-angle-left"></i></div>
				<div id="archivesscrollButtonNext" class="scrollButtonNext"><i class="fa fa-angle-right"></i></div>
				<div id="archiveResults">
					<div id="blockResultsScroller">				
<?php
				}
			
			if (is_array($va_object_ids) && sizeof($va_object_ids)) {
				$qr_res = caMakeSearchResult('ca_objects', $va_object_ids);
				//foreach ($va_object_ids as $obj_key => $vn_object_id) {
				while($qr_res->nextHit()) {
					//$t_archive = new ca_objects($vn_object_id);
					$vs_icon = "";
					if($qr_res->get("ca_objects.type_id") == 26){
						# --- moving image
						$vs_icon = "<i class='glyphicon glyphicon-film'></i>";	
					}
					if($qr_res->get("ca_objects.type_id") == 25){
						# --- audio
						$vs_icon = "<i class='glyphicon glyphicon-volume-up'></i>";	
					}
					
					print "<div class='archivesResult'>";
					print "<div class='resultImg'>".caNavLink($this->request, $vs_icon.$qr_res->get('ca_object_representations.media.widepreview'), '', '', 'Detail', 'archives/'.$qr_res->get('ca_objects.object_id'))."</div>";
					print "<p>".caNavLink($this->request, $qr_res->get('ca_objects.preferred_labels.name'), '', '', 'Detail', 'archives/'.$qr_res->get('ca_objects.object_id'))."</p>";
					print "<p>".$qr_res->get('ca_objects.dc_date.dc_dates_value')."</p>";
					print "</div><!-- archivesResult -->";
				}
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
			
			if (is_array($va_object_ids) && sizeof($va_object_ids)) {
				$qr_res = caMakeSearchResult('ca_objects', $va_object_ids);
				//foreach ($va_object_ids as $obj_key => $vn_object_id) {
				while($qr_res->nextHit()) {
					//$t_library = new ca_objects($vn_object_id);
					print "<div class='libraryResult'>";
					print "<div class='resultImg'>".caNavLink($this->request, $qr_res->get('ca_object_representations.media.library'), '', '', 'Detail', 'artworks/'.$vn_object_id)."</div>";
					print "<p>".caNavLink($this->request, $qr_res->get('ca_objects.preferred_labels'), '', '', 'Detail', 'artworks/'.$qr_res->get('ca_objects.object_id'))."</p>";				
					print "<p>".caNavLink($this->request, $qr_res->get('ca_entities.preferred_labels.name', array('restrictToRelationshipTypes' => array('author'))), '', '', 'Detail', 'artworks/'.$vn_object_id)."</p>";
					print "<p>".$qr_res->get('ca_entities.preferred_labels.name', array('restrictToRelationshipTypes' => array('publisher')))."</p>";
					print "</div><!-- libraryResult -->";
				}
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
			
			if (is_array($va_object_ids) && sizeof($va_object_ids)) {
				$qr_res = caMakeSearchResult('ca_objects', $va_object_ids);
				//foreach ($va_object_ids as $obj_key => $vn_object_id) {
				while($qr_res->nextHit()) {
					//$t_object = new ca_objects($vn_object_id);
					print "<div class='archivesResult'>";
					print "<div class='resultImg'>".caNavLink($this->request, $qr_res->get('ca_object_representations.media.widepreview'), '', '', 'Detail', 'artworks/'.$vn_object_id)."</div>";
					print "<p>".caNavLink($this->request, $qr_res->get('ca_objects.preferred_labels.name'), '', '', 'Detail', 'artworks/'.$qr_res->get('ca_objects.object_id'))."</p>";
					print "<p class='artist'>".$qr_res->get('ca_entities.preferred_labels', array('restrictToRelationshipTypes' => 'artist'))."</p>";
					print "<p>".$qr_res->get('ca_objects.object_dates')."</p>";
					print "</div><!-- archivesResult -->";
				}
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