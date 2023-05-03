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
	$t_locale =					new ca_locales();

	global $g_ui_locale;
 
	$t_object = 			$this->getVar("item");
	$va_comments = 			$this->getVar("comments");
	$va_tags = 				$this->getVar("tags_array");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");
	$vn_pdf_enabled = 		$this->getVar("pdfEnabled");
	$va_access_values = caGetUserAccessValues($this->request);
	$back_to_work = "";
	// get film work
	$vn_occurrence_id = $t_object->get('ca_occurrences.occurrence_id',array('restrictToTypes' => 'work', 'limit' => 1));
	
	// Force media viewing context to "works" so the viewer will pull representations relative to occurrences, not objects
	$this->request->setParameter('context', 'works');
	
	$t_work = new ca_occurrences($vn_occurrence_id);
	if($vn_occurrence_id){
		$va_related_objects = $t_work->get("ca_objects.related",array("checkAccess" => $va_access_values, "returnWithStructure" => true, "restrictToTypes" => array("film_print", "digital_item", "video_item")));
		if(is_array($va_related_objects) && sizeof($va_related_objects)){
			$va_object_ids = array();
			foreach($va_related_objects as $vn_i => $va_info){
				if($va_info["object_id"] == $t_object->get("ca_objects.object_id")){
					unset($va_related_objects[$vn_i]);
				}
				$va_object_ids[] = $va_info["object_id"];
			}
			$o_context = new ResultContext($this->request, 'ca_objects', 'detailrelated');
			#$o_context->setAsLastFind();
			$o_context->setResultList($va_object_ids);
			$o_context->saveContext();
		}
		$config = caGetDetailConfig();
		$detail_types = $config->getAssoc('detailTypes');
		$options = $detail_types['works'];
		$t_representation = $t_work->getPrimaryRepresentationInstance(array("checkAccess" => $va_access_values));
		if(!$t_representation || !is_array($media_display_info = caGetMediaDisplayInfo('detail', $t_representation->getMediaInfo('media', 'original', 'MIMETYPE')))) { $media_display_info = []; }
			
		$vs_rep_viewer = caRepresentationViewer(
					$this->request, 
					$t_work, 
					$t_work,
					array_merge($options, $media_display_info, 
						[
							'display' => 'detail',
							'showAnnotations' => true, 
							'primaryOnly' => caGetOption('representationViewerPrimaryOnly', $options, false), 
							'dontShowPlaceholder' => caGetOption('representationViewerDontShowPlaceholder', $options, false), 
							#'captionTemplate' => caGetOption('representationViewerCaptionTemplate', $options, false),
							'captionTemplate' => "<ifdef code='ca_object_representations.caption|ca_object_representations.copyright'><div class='detailMediaCaption'><div><ifdef code='ca_object_representations.caption'>^ca_object_representations.caption</ifdef> <ifdef code='ca_object_representations.copyright'>^ca_object_representations.copyright</ifdef></div></div></ifdef>",
							'checkAccess' => $va_access_values
						]
					)
				);

		$back_to_work = caDetailLink($this->request, ($g_ui_locale == "de_DE" ? "zum Werk" : "to Film Work"), '', 'ca_occurrences', $vn_occurrence_id);
					
	}
	$vs_type = $t_object->getWithTemplate("^ca_objects.type_id");
	switch($vs_type){
		case "Filmkopie":
			$vs_type = "Kopie";
		break;
		# ---------------
	}		
?>

		<div class="row">
			<div class='col-sm-12'>
				<div class='navTop'><!--- only shown at small screen size -->
					{{{previousLink}}}{{{resultsLink}}}{{{nextLink}}}
				</div><!-- end detailTop -->
				<H1>{{{ca_objects.preferred_labels.name}}}</H1>
				<H2><?php print $vs_type; ?><?php print ($back_to_work) ? " | ".$back_to_work : ""; ?></H2>
				<HR/>
			</div>
		</div>
		<div class="row">
<?php
			# --- do not show object media.  Show primary rep from the occurrence
			$vs_work_media = $t_work->get("ca_object_representations.media.large", array("checkAccess" => $va_access_values));
			$vs_work_media_caption = $t_work->getWithTemplate("<div class='small text-center'><ifdef code='ca_object_representations.caption'>^ca_object_representations.caption</ifdef> <ifdef code='ca_object_representations.copyright'>^ca_object_representations.copyright</ifdef></div>");
			if($vs_rep_viewer){
?>
			<div class='col-sm-6 col-md-6 fullWidthImg'>
				<?php print $vs_rep_viewer; ?>
				
<?php
				# Comment and Share Tools
				if ($vn_comments_enabled | $vn_share_enabled | $vn_pdf_enabled) {
						
					print '<div id="detailTools">';
					if ($vn_comments_enabled) {
?>				
						<div class="detailTool"><a href='#' onclick='jQuery("#detailComments").slideToggle(); return false;'><span class="glyphicon glyphicon-comment" aria-label="<?php print _t("Comments and tags"); ?>"></span>Comments and Tags (<?php print sizeof($va_comments) + sizeof($va_tags); ?>)</a></div><!-- end detailTool -->
						<div id='detailComments'><?php print $this->getVar("itemComments");?></div><!-- end itemComments -->
<?php				
					}
					if ($vn_share_enabled) {
						print '<div class="detailTool"><span class="glyphicon glyphicon-share-alt" aria-label="'._t("Share").'"></span>'.$this->getVar("shareLink").'</div><!-- end detailTool -->';
					}
					if ($vn_pdf_enabled) {
						print "<div class='detailTool'><span class='glyphicon glyphicon-file' aria-label='"._t("Download")."'></span>".caDetailLink($this->request, "Download as PDF", "faDownload", "ca_objects",  $t_object->get('ca_objects.object_id'), array('view' => 'pdf', 'export_format' => '_pdf_ca_objects_summary'))."</div>";
					}
					print '</div><!-- end detailTools -->';
				}				

?>

			</div><!-- end col -->
			
			<div class='col-sm-6 col-md-6'>
<?php
			}else{
?>
			<div class='col-sm-12'>
<?php
			}
?>				



				<!--<h3><?php print ($g_ui_locale == "de_DE" ? "Technische Angaben" : "Technical Attributes"); ?></h3>-->
				
					<div class="row">
						<div class="col-sm-6">
<?php
							$va_show_public_fields = array(
								'format', 'to_rent', 'version', 'lang_syn', 'lang_sub', 'lang_intertit', 'lang_txtlist','duration', 'resolution_list', 'size', 'container_list', 'codec_list', 'lang_voiceover', 'lang_magnet', 'subtitle_type', 'audiodescription_lang', 'closed_caption_lang', 'color', 'sound', 'sound_mix', 'optical_sound_type', 'ratio', 'projection_format', 'fps_list', 'length', 'weight', 'reels', 'gossip', 'material_type', 'installation_format'
							);
							$va_output = array();
							
							foreach($va_show_public_fields as $vs_bundle){
								if(strlen($v = trim($t_object->get("ca_objects.{$vs_bundle}",array('convertCodesToDisplayText' => true, 'delimiter' => ', '))))>0) {
									$va_output[] = "<div class='unit'><b>".$t_object->getAttributeLabel($vs_bundle)."</b>: {$v}</div><!-- end unit -->";

								}
							}

							$vn_i = 1;
							foreach($va_output as $vs_output) {
								print $vs_output."\n";

								if($vn_i == (ceil(sizeof($va_output) / 2))) {
									print '</div><div class="col-sm-6">';
								}
								$vn_i++;
							}
							
							
?>
						</div>
					</div>
			</div><!-- end col -->
		</div>
		<div class="row">
			<div class="col-sm-12">
<?php
			if(strlen($t_object->get('ca_objects.funded_by'))>0){
				print "<div class='unit'><i>".$t_object->get('ca_objects.funded_by', array('delimiter' => ', '))."</i></div><!-- end unit -->";
			}
?>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
<?php
			if(is_array($va_related_objects) && sizeof($va_related_objects)){
				$t_rel = new ca_objects();
				print "<HR/><div class='unit'><label>".($g_ui_locale == "de_DE" ? "Weitere Kopien" : "More Prints")."</label>";
				foreach($va_related_objects as $vn_id => $va_object_info){
					$t_rel->load($va_object_info["object_id"]);

					$va_display_parts = array();

					if($vs_format = $t_rel->get("ca_objects.format", array("convertCodesToDisplayText" => true))){
						$va_display_parts[] = $vs_format;
					}

					if($vs_version = $t_rel->get("ca_objects.version", array("convertCodesToDisplayText" => true))){
						$va_display_parts[] = $vs_version;
					}					

					if(strlen(trim($t_rel->get('ca_objects.lang_sub', array("convertCodesToDisplayText" => true, 'delimiter' => ', '))))>0){
						$va_display_parts[] = ($g_ui_locale == "de_DE" ? "UT" : "ST").": ".$t_rel->get('ca_objects.lang_sub', array("convertCodesToDisplayText" => true, 'delimiter' => ', '));
					}

					$vs_rel_label = join(', ',$va_display_parts);

					if($this->request->isLoggedIn()){
						$vs_rel_label .= " (".$va_object_info["idno"].")";
					}

					print caDetailLink($this->request, "&rarr; ".$vs_rel_label, '', 'ca_objects', $t_rel->getPrimaryKey());
					print "<br />";
				}
				print "</div>";
			}
?>
				<HR/>
			</div>
		</div>			
		<div class="row">
<?php
			if(strlen($t_work->get('ca_occurrences.description'))>0){
				print "<div class='col-sm-6'>";
				print "<div class='unit'><label>".$t_work->getAttributeLabel('description')."</label>".$t_work->get('ca_occurrences.description')."</div><!-- end unit -->";
				print "</div>";
				print "<div class='col-sm-6'>";
			}else{
				print "<div class='col-sm-12'>";
			}
			


				$vs_work = $t_object->getWithTemplate("<ifcount code='ca_occurrences' min='1'><unit relativeTo='ca_occurrences'><l>^ca_occurrences.preferred_labels.name</l></unit></ifcount>");
				print "<div class='unit'><label>"._t("Work")."</label>".$vs_work."</div>";
				$va_alt_label_list = $t_object->get('ca_occurrences.nonpreferred_labels.name', array('returnAllLocales' => true, 'returnWithStructure' => true));
				$vn_locale_de = $t_locale->loadLocaleByCode('de_DE');
				$vn_locale_en = $t_locale->loadLocaleByCode('en_US');
				if(is_array($va_alt_label_list) && sizeof($va_alt_label_list)){
					$va_alt_label_list = array_pop($va_alt_label_list);
					foreach($va_alt_label_list as $va_labels_by_locale) {
						foreach($va_labels_by_locale as $vn_locale_id => $va_label_values) {
							switch($vn_locale_id){
								case $vn_locale_de:
									$vs_nonpref_label = ($g_ui_locale == "de_DE" ? "Deutscher Titel": "German title");
									break;
								case $vn_locale_en:
									$vs_nonpref_label = ($g_ui_locale == "de_DE" ? "Englischer Titel": "English title");
									break;
								default:
									$vs_nonpref_label = ($g_ui_locale == "de_DE" ? "Alternativtitel": "Alternative title");
									break;

							}
							foreach($va_label_values as $vn_num => $vs_label_text) {
								if($vs_label_text != $vs_title) {
									print "<div class='unit'><label>".$vs_nonpref_label."</label>".$vs_label_text."</div>\n";
								}
							}
						}
					}
				}

			if(strlen($t_work->get('ca_occurrences.title_series'))>0){
				print "<div class='unit'><label>".$t_work->getAttributeLabel('title_series')."</label>".$t_work->get('ca_occurrences.title_series');
				if($t_work->get('ca_occurrences.series')){
					print " (".$t_work->get('ca_occurrences.series.series_unit',array("convertCodesToDisplayText" => true))." ".$t_work->get('ca_occurrences.series.series_value').")";
				}
				print "</div><!-- end unit -->";
			}
			
			$va_entity_ids = $t_work->get('ca_entities.entity_id', array('restrictToRelationshipTypes' => ['director'], 'returnAsArray' => true));
			$t_entity = new ca_entities();
			if(is_array($va_entity_ids) && sizeof($va_entity_ids)){
				$vn_i = 0;
				print "<div class='unit'>";
				print "<label>".($g_ui_locale=="en_US" ? "Director" : "Regie")."</label>";
				foreach($va_entity_ids as $vn_entity_id) {
					if ($t_entity->load($vn_entity_id)) {           // doesn't hurt to make sure the entity actually loaded... but it should never fail
						if ($vs_director_name = $t_entity->get('ca_entities.preferred_labels.displayname')) {
							print caNavLink($this->request,$vs_director_name,'','','Browse','works',array("facet" => "entity_facet", "id" => $vn_entity_id));
							print "\n";
						}
						if ($vs_director_bio = $t_entity->get('ca_entities.director_bio')) {
							if($g_ui_locale=="en_US"){
								print "&nbsp;&nbsp;&nbsp;<a id='bioshow$vn_entity_id' href='#'>&rarr; show biography</a>";
								print "&nbsp;&nbsp;&nbsp;<a id='biohide$vn_entity_id' style='display:none' href='#'>&larr; hide biography</a>";
							} else {
								print "&nbsp;&nbsp;&nbsp;<a id='bioshow$vn_entity_id' href='#'>&rarr; Biografie anzeigen</a>";
								print "&nbsp;&nbsp;&nbsp;<a id='biohide$vn_entity_id' style='display:none' href='#'>&larr; Biografie schließen</a>";
							}
							print "<br />";

	?>
	<script type="text/javascript">
		$(document).ready(function(event){
			$("#biohide<?php print $vn_entity_id; ?>").hide();
			$("#biocontent<?php print $vn_entity_id; ?>").hide();

			$("#bioshow<?php print $vn_entity_id; ?>").click(function(event){
				$("#biocontent<?php print $vn_entity_id; ?>").show();
				$("#bioshow<?php print $vn_entity_id; ?>").hide();
				$("#biohide<?php print $vn_entity_id; ?>").show();
				return false;
			});

			$("#biohide<?php print $vn_entity_id; ?>").click(function(event){
				$("#biocontent<?php print $vn_entity_id; ?>").hide();
				$("#biohide<?php print $vn_entity_id; ?>").hide();
				$("#bioshow<?php print $vn_entity_id; ?>").show();
				return false;
			});
		});
	</script>
	<?php
							print "<span id='biocontent$vn_entity_id' style='display:none'><br /><label>".($g_ui_locale=="en_US" ? "Biography" : "Biografie")."</label>".$vs_director_bio."<br /></span>\n";
						}
						$vn_i++;
						if($vn_i < sizeof($va_entity_ids)){
							print "<br/>";
						}	
					}
				}
				print "</div>";
			}
			if($t_work->get('ca_occurrences.country',array("convertCodesToDisplayText" => true))){
				print "<div class='unit'><label>".$t_work->getAttributeLabel('country')."</label>".$t_work->get('ca_occurrences.country', array("convertCodesToDisplayText" => true, 'delimiter' => ', '))."</div><!-- end unit -->";
			}
			if(strlen($t_work->get('ca_occurrences.production_year'))>0){
				print "<div class='unit'><label>".$t_work->getAttributeLabel('production_year')."</label>".$t_work->get('ca_occurrences.production_year', array('delimiter' => ', '))."</div><!-- end unit -->";
			}
			if(strlen(trim($t_work->get('ca_occurrences.language', array("convertCodesToDisplayText" => true, 'delimiter' => ', '))))>0){
				print "<div class='unit'><label>".$t_work->getAttributeLabel('language')."</label>".$t_work->get('ca_occurrences.language', array("convertCodesToDisplayText" => true, 'delimiter' => ', '))."</div><!-- end unit -->";
			}
			if(strlen($t_work->get('ca_occurrences.forum_year'))>0){
				print "<div class='unit'><label>".$t_work->getAttributeLabel('forum_year')."</label>".$t_work->get('ca_occurrences.forum_year', array('delimiter' => ', '))."</div><!-- end unit -->";
			}
			if(strlen($t_work->get('ca_occurrences.forum_pdf'))>0){
				print "<div class='unit'><label>".$t_work->getAttributeLabel('forum_pdf')."</label>".$t_work->get('ca_occurrences.forum_pdf', array('delimiter' => ', '))."</div><!-- end unit -->";
			}
			
			// TODO: need final text and formatting for link
			if($url = $t_work->get('ca_occurrences.film_page_url')) {
				print "<div class='unit'><label>".($g_ui_locale == "de_DE" ? "Forum" : "Forum")."</label><div class='trimText'><a href='{$url}' target='_blank'>".($g_ui_locale == "de_DE" ? "For more information on the film visit the Forum page" : "Mehr Informationen zum Film auf der Webseite des Forums")."</a></div></div>"; 
			}	

			$va_tags = $t_work->get("ca_list_items", array("returnWithStructure" => true));
			if(is_array($va_tags) && sizeof($va_tags)){
				print "<div class='unit'><label>".($g_ui_locale == "de_DE" ? "Schlagworte" : "Tags")."</label>";
				$va_print_tags = array();
				foreach($va_tags as $vn_id => $va_term_info){
					if($va_term_info["idno"]=="exp"){
						$va_print_tags[] = caNavLink($this->request, $va_term_info["label"], '', '', 'Search', 'works', array('search' => $va_term_info["label"]));
					} else {
						$va_print_tags[] = $va_term_info["label"];
					}
					
				}
				print join(", ",$va_print_tags);
				print "</div>";
			}
			
			if($this->request->isLoggedIn() && $t_work->get('ca_occurrences.work_notes')){
				print "<div class='unit'><label>".$t_work->getAttributeLabel('work_notes')."</label>".$t_work->get('ca_occurrences.work_notes', array('delimiter' => '<br/>'))."</div><!-- end unit -->";
			}
			if($t_work->get("ca_occurrences.credit_editable.credit_entity")){
				print "<div class='unit'><label>".($g_ui_locale == "de_DE" ? "Credits" : "Credits")."</label><div class='trimText'>";
				print $t_work->getWithTemplate("<unit relativeTo='ca_occurrences.credit_editable' delimiter='<br/>'>^ca_occurrences.credit_editable.credit_role: ^ca_occurrences.credit_editable.credit_entity</unit>");
				print "</div></div>";
			}
			
			

?>
			</div><!-- end col -->
		</div><!-- end row -->

<?php
			if($this->request->isLoggedIn()){
?>
				<h3><?php print ($g_ui_locale == "de_DE" ? "Interne Angaben" : "Hidden Attributes"); ?></h2>
				<div class="detailBox">
					<div class="row">
						<div class="col-sm-6">
<?php
							$va_show_internal_fields = array(
								'object_type', 'print_id', 'notes', 'condition', 'condition_opt', 'condition_date', 'condition_comm', 'condition_color', 
								'source', 'source_date', 'oa3create_date', 'oa3change_date', 'rights', 'textlist',
								// neu
								'file_folder_name', 'bytes', 'number_of_files', 'image_frame', 'cpl', 'cpl_content_title_text',
								'original_format_notes', 'original_format_sound', 'original_fps', 'original_source', 'creator',
								'creation_date', 'processing_system', 'edited_by', 'processing_step', 'final', 'media',
								'storage_location', 'vinegar', 'shrinking', 'film_base_type', 'print_id_old', 'colorspace'
							);
							$va_output = array();

							// Spezialfälle mit speziellen Labels
							$va_output[] = "<div class='unit'><b>"."OA3 ID"."</b>: ".$t_object->get('ca_objects.idno')."</div><!-- end unit -->";
							$va_output[] = "<div class='unit'><b>".($g_ui_locale == "de_DE" ? "Zugriffsrechte" : "Access")."</b>: ".$t_object->get('ca_objects.access',array('convertCodesToDisplayText' => true))."</div><!-- end unit -->";
							$va_output[] = "<div class='unit'><b>".($g_ui_locale == "de_DE" ? "Status" : "Status")."</b>: ".$t_object->get('ca_objects.status',array('convertCodesToDisplayText' => true))."</div><!-- end unit -->";

							foreach($va_show_internal_fields as $vs_bundle){
								if(strlen($t_object->get("ca_objects.{$vs_bundle}"))>0) {
									switch($vs_bundle){
										case "storage_location":
											$vs_tmp = "<div class='unit'><b>".$t_object->getAttributeLabel($vs_bundle)."</b>: ";
											$vs_tmp .= $t_object->getWithTemplate("<unit relativeTo='ca_objects.storage_locations' delimiter='<br/>'><ifdef code='ca_objects.storage_location.storage_location_number'>^ca_objects.storage_location.storage_location_number</ifdef><ifdef code='ca_objects.storage_location.storage_location_comment'><ifdef code='ca_objects.storage_location.storage_location_number'>, </ifdef>^ca_objects.storage_location.storage_location_comment</ifdef></unit>");
											$vs_tmp .= "</div><!-- end unit -->";
											$va_output[] = $vs_tmp;
										break;
										# ------------------------------
										case "vinegar":
											$vs_tmp = "<div class='unit'><b>".$t_object->getAttributeLabel($vs_bundle)."</b>: ";
											$vs_tmp .= $t_object->getWithTemplate("<unit relativeTo='ca_objects.vinegar' delimiter='<br/>'><ifdef code='ca_objects.vinegar.vinegar_check_date'>^ca_objects.vinegar.vinegar_check_date</ifdef><ifdef code='ca_objects.vinegar.vinegar_value'><ifdef code='ca_objects.vinegar.vinegar_check_date'>, </ifdef>^ca_objects.vinegar.vinegar_value</ifdef><ifdef code='ca_objects.vinegar.vinegar_report'><br/>^ca_objects.vinegar.vinegar_report</ifdef></unit>");
											$vs_tmp .= "</div><!-- end unit -->";
											$va_output[] = $vs_tmp;
										break;
										# ------------------------------
										default:
											$va_output[] = "<div class='unit'><b>".$t_object->getAttributeLabel($vs_bundle)."</b>: ".$t_object->get("ca_objects.{$vs_bundle}",array('convertCodesToDisplayText' => true, 'delimiter' => ", "))."</div><!-- end unit -->";
										break;
										# ------------------------------
									}
								}
							}

							$vn_i = 1;
							foreach($va_output as $vs_output) {
								print $vs_output."\n";

								if($vn_i == (ceil(sizeof($va_output) / 2))) {
									print '</div><div class="col-sm-6">';
								}
								$vn_i++;
							}
?>
						</div>
					</div>
				</div>			
<?php
			}
?>

	</div><!-- end col -->
</div><!-- end row -->

<script type='text/javascript'>
	jQuery(document).ready(function() {
		$('.trimText').readmore({
		  speed: 75,
		  maxHeight: 200
		});
	});
</script>
