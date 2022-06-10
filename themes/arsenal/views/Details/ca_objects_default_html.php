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
 
	$t_object = 			$this->getVar("item");
	$va_comments = 			$this->getVar("comments");
	$va_tags = 				$this->getVar("tags_array");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");
	$vn_pdf_enabled = 		$this->getVar("pdfEnabled");
	$vn_id =				$t_object->get('ca_objects.object_id');
	$va_access_values = caGetUserAccessValues($this->request);
	
	// get film work
	$vn_occurrence_id = $t_object->get('ca_occurrences.occurrence_id',array('restrictToTypes' => 'work', 'limit' => 1));

	$t_work = new ca_occurrences($vn_occurrence_id);
	if($vn_occurrence_id){
		$va_related_objects = $t_work->get("ca_objects.related",array("checkAccess" => $va_access_values, "returnWithStructure" => true, "restrictToTypes" => "film_print"));
		if(is_array($va_related_objects) && sizeof($va_related_objects)){
			foreach($va_related_objects as $vn_id => $va_info){
				if($vn_id == $t_object->get("ca_objects.object_id")){
					unset($va_related_objects[$vn_id]);
				}
			}
		}
	}
	$t_locale =					new ca_locales();

	global $g_ui_locale;
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
			<div class='col-sm-12'>
				<H1>{{{<unit relativeTo="ca_collections" delimiter="<br/>"><l>^ca_collections.preferred_labels.name</l></unit><ifcount min="1" code="ca_collections"> ➔ </ifcount>}}}{{{ca_objects.preferred_labels.name}}}</H1>
				<H2>{{{^ca_objects.type_id}}}</H2>
				<HR>
			</div>
		</div>
		<div class="row">
			<div class='col-sm-6 col-md-6'>
				{{{representationViewer}}}
				
				
				<div id="detailAnnotations"></div>
				
				<?php print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_object, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-sm-3 col-md-3 col-xs-4", "primaryOnly" => $this->getVar('representationViewerPrimaryOnly') ? 1 : 0)); ?>
				
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
						print "<div class='detailTool'><span class='glyphicon glyphicon-file' aria-label='"._t("Download")."'></span>".caDetailLink($this->request, "Download as PDF", "faDownload", "ca_objects",  $vn_id, array('view' => 'pdf', 'export_format' => '_pdf_ca_objects_summary'))."</div>";
					}
					print '</div><!-- end detailTools -->';
				}				

?>

			</div><!-- end col -->
			
			<div class='col-sm-6 col-md-6'>
				








<?php

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
			
			$va_entity_ids = $t_work->get('ca_entities.entity_id', array('returnAsArray' => true));
			$t_entity = new ca_entities();
			if(is_array($va_entity_ids) && sizeof($va_entity_ids)){
				$vn_i = 0;
				print "<div class='unit'>";
				print "<label>".($g_ui_locale=="en_US" ? "Director" : "Regie")."</label>";
				foreach($va_entity_ids as $vn_entity_id) {
					if ($t_entity->load($vn_entity_id)) {           // doesn't hurt to make sure the entity actually loaded... but it should never fail
						if ($vs_director_name = $t_entity->get('ca_entities.preferred_labels.displayname')) {
							print caNavLink($this->request,$vs_director_name,'','','Browse','objects',array("facet" => "entity_facet", "id" => $vn_entity_id));
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
			});

			$("#biohide<?php print $vn_entity_id; ?>").click(function(event){
				$("#biocontent<?php print $vn_entity_id; ?>").hide();
				$("#biohide<?php print $vn_entity_id; ?>").hide();
				$("#bioshow<?php print $vn_entity_id; ?>").show();
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

			$va_tags = $t_work->get("ca_list_items", array("returnWithStructure" => true));
			if(sizeof($va_tags)){
				print "<div class='unit'><label>".($g_ui_locale == "de_DE" ? "Schlagworte" : "Tags")."</label>";
				$va_print_tags = array();
				foreach($va_tags as $vn_id => $va_term_info){
					if($va_term_info["idno"]=="exp"){
						$va_print_tags[] = caNavLink($this->request, $va_term_info["label"], '', '', 'Search', 'objects', array('search' => $va_term_info["label"]));
					} else {
						$va_print_tags[] = $va_term_info["label"];
					}
					
				}
				print join(", ",$va_print_tags);
				print "</div>";
			}

?>
			</div><!-- end col -->
		</div><!-- end row -->
		<div class="row">
			<div class='col-sm-12 col-md-12'><HR/></div>
		</div>
		<div class="row">
<?php
			if(strlen($t_work->get('ca_occurrences.description'))>0){
				print "<div class='col-sm-6'><div class='unit'><label>".$t_work->getAttributeLabel('description')."</label><span class='trimText'>".$t_work->get('ca_occurrences.description')."</span></div><!-- end unit --></div>";
				print "<div class='col-sm-6'>";
			}else{
				print "<div class='col-sm-12 col-md-12'>";
			}
			
			# --- output related objects as links
			if (is_array($va_related_objects) && sizeof($va_related_objects)) {
				$t_rel = new ca_objects();
				print "<div class='unit'><label>".($g_ui_locale == "de_DE" ? "Weitere Kopien" : "More Prints")."</label>";
				foreach($va_related_objects as $vn_id => $va_object_info){
					$t_rel->load($va_object_info["object_id"]);

					$va_display_parts = array();

					$va_display_parts[] = $va_object_info["label"];

					if($vs_format = $t_rel->get("ca_objects.format", array("convertCodesToDisplayText" => true))){
						$va_display_parts[] = $vs_format;
					}

					if($vs_version = $t_rel->get("ca_objects.version", array("convertCodesToDisplayText" => true))){
						$va_display_parts[] = $vs_version;
					}					

					if(strlen(trim($t_object->get('ca_objects.lang_sub', array("convertCodesToDisplayText" => true, 'delimiter' => ', '))))>0){
						$va_display_parts[] = ($g_ui_locale == "de_DE" ? "UT" : "ST").": ".$t_object->get('ca_objects.lang_sub', array("convertCodesToDisplayText" => true, 'delimiter' => ', '));
					}

					$vs_rel_label = join(', ',$va_display_parts);

					if($this->request->config->get("dont_enforce_access_settings")) {
						$vs_rel_label .= " (".$va_object_info["idno"].")";
					}

					print caDetailLink($this->request, $vs_rel_label, '', 'ca_objects', $t_rel->getPrimaryKey());
					print "<br />";
				}
				print "</div>";
			}
?>
			</div><!-- end col either 6 or 12 based on if there is a synopsis or not -->
		</div><!-- end row -->
		<div class="row">
			<div class="col-sm-12">
				<h3><?php print ($g_ui_locale == "de_DE" ? "Technische Angaben" : "Technical Attributes"); ?></h2>
				<div class="detailBox">
					<div class="row">
						<div class="col-sm-6">
<?php
							//if($vs_idno = $t_object->get('ca_objects.oa3_id')){
							//	print "<div class='unit'><b>".($g_ui_locale == "de_DE" ? "Kopiennummer" : "Print ID")."</b>: ".$vs_idno."</div><!-- end unit -->";
							//}
							if(strlen(trim($t_object->get('ca_objects.format', array("convertCodesToDisplayText" => true, 'delimiter' => ', '))))>0){
								print "<div class='unit'><b>".$t_object->getAttributeLabel('format')."</b>: ".$t_object->get('ca_objects.format',array("convertCodesToDisplayText" => true))."</div><!-- end unit -->";
							}
							if(strlen(trim($t_object->get('ca_objects.to_rent', array("convertCodesToDisplayText" => true, 'delimiter' => ', '))))>0){
								print "<div class='unit'><b>".$t_object->getAttributeLabel('to_rent')."</b>: ".$t_object->get('ca_objects.to_rent',array("convertCodesToDisplayText" => true))."</div><!-- end unit -->";
							}
							if(strlen(trim($t_object->get('ca_objects.version', array("convertCodesToDisplayText" => true, 'delimiter' => ', '))))>0){
								print "<div class='unit'><b>".$t_object->getAttributeLabel('version')."</b>: ".$t_object->get('ca_objects.version',array("convertCodesToDisplayText" => true))."</div><!-- end unit -->";
							}
							if(strlen(trim($t_object->get('ca_objects.lang_syn', array("convertCodesToDisplayText" => true, 'delimiter' => ', '))))>0){
								print "<div class='unit'><b>".$t_object->getAttributeLabel('lang_syn')."</b>: ".$t_object->get('ca_objects.lang_syn', array("convertCodesToDisplayText" => true, 'delimiter' => ', '))."</div><!-- end unit -->";
							}
							if(strlen(trim($t_object->get('ca_objects.lang_sub', array("convertCodesToDisplayText" => true, 'delimiter' => ', '))))>0){
								print "<div class='unit'><b>".$t_object->getAttributeLabel('lang_sub')."</b>: ".$t_object->get('ca_objects.lang_sub', array("convertCodesToDisplayText" => true, 'delimiter' => ', '))."</div><!-- end unit -->";
							}
							if(strlen(trim($t_object->get('ca_objects.lang_intertit', array("convertCodesToDisplayText" => true, 'delimiter' => ', '))))>0){
								print "<div class='unit'><b>".$t_object->getAttributeLabel('lang_intertit')."</b>: ".$t_object->get('ca_objects.lang_intertit', array("convertCodesToDisplayText" => true, 'delimiter' => ', '))."</div><!-- end unit -->";
							}
							if(strlen(trim($t_object->get('ca_objects.lang_txtlist', array("convertCodesToDisplayText" => true, 'delimiter' => ', '))))>0){
								print "<div class='unit'><b>".$t_object->getAttributeLabel('lang_txtlist')."</b>: ".$t_object->get('ca_objects.lang_txtlist', array("convertCodesToDisplayText" => true, 'delimiter' => ', '))."</div><!-- end unit -->";
							}
							if(strlen(trim($t_object->get('ca_objects.resolution_list', array("convertCodesToDisplayText" => true, 'delimiter' => ', '))))>0){
								print "<div class='unit'><b>".$t_object->getAttributeLabel('resolution_list')."</b>: ".$t_object->get('ca_objects.resolution_list', array("convertCodesToDisplayText" => true, 'delimiter' => ', '))."</div><!-- end unit -->";
							}
							if(strlen(trim($t_object->get('ca_objects.size', array("convertCodesToDisplayText" => true, 'delimiter' => ', '))))>0){
								print "<div class='unit'><b>".$t_object->getAttributeLabel('size')."</b>: ".$t_object->get('ca_objects.size', array("convertCodesToDisplayText" => true, 'delimiter' => ', '))."</div><!-- end unit -->";
							}
							if(strlen(trim($t_object->get('ca_objects.container_list', array("convertCodesToDisplayText" => true, 'delimiter' => ', '))))>0){
								print "<div class='unit'><b>".$t_object->getAttributeLabel('container_list')."</b>: ".$t_object->get('ca_objects.container_list', array("convertCodesToDisplayText" => true, 'delimiter' => ', '))."</div><!-- end unit -->";
							}
							if(strlen(trim($t_object->get('ca_objects.codec_list', array("convertCodesToDisplayText" => true, 'delimiter' => ', '))))>0){
								print "<div class='unit'><b>".$t_object->getAttributeLabel('codec_list')."</b>: ".$t_object->get('ca_objects.codec_list', array("convertCodesToDisplayText" => true, 'delimiter' => ', '))."</div><!-- end unit -->";
							}
?>
						</div>
						<div class="col-sm-6">
<?php
							if(strlen(trim($t_object->get('ca_objects.lang_voiceover ', array("convertCodesToDisplayText" => true, 'delimiter' => ', '))))>0){
								print "<div class='unit'><b>".$t_object->getAttributeLabel('lang_voiceover')."</b>: ".$t_object->get('ca_objects.lang_voiceover', array("convertCodesToDisplayText" => true, 'delimiter' => ', '))."</div><!-- end unit -->";
							}
							if(strlen(trim($t_object->get('ca_objects.lang_magnet ', array("convertCodesToDisplayText" => true, 'delimiter' => ', '))))>0){
								print "<div class='unit'><b>".$t_object->getAttributeLabel('lang_magnet')."</b>: ".$t_object->get('ca_objects.lang_magnet', array("convertCodesToDisplayText" => true, 'delimiter' => ', '))."</div><!-- end unit -->";
							}
							if(strlen($t_object->get('ca_objects.duration'))>0){
								print "<div class='unit'><b>".$t_object->getAttributeLabel('duration')."</b>: ".$t_object->get('ca_objects.duration')."</div><!-- end unit -->";
							}
							if(strlen(trim($t_object->get('ca_objects.color', array("convertCodesToDisplayText" => true, 'delimiter' => ', '))))>0){
								print "<div class='unit'><b>".$t_object->getAttributeLabel('color')."</b>: ".$t_object->get('ca_objects.color', array("convertCodesToDisplayText" => true))."</div><!-- end unit -->";
							}
							if(strlen(trim($t_object->get('ca_objects.sound', array("convertCodesToDisplayText" => true, 'delimiter' => ', '))))>0){
								print "<div class='unit'><b>".$t_object->getAttributeLabel('sound')."</b>: ".$t_object->get('ca_objects.sound', array("convertCodesToDisplayText" => true, 'delimiter' => ', '))."</div><!-- end unit -->";
							}
							if(strlen(trim($t_object->get('ca_objects.ratio', array("convertCodesToDisplayText" => true, 'delimiter' => ', '))))>0){
								print "<div class='unit'><b>".$t_object->getAttributeLabel('ratio')."</b>: ".$t_object->get('ca_objects.ratio', array("convertCodesToDisplayText" => true))."</div><!-- end unit -->";
							}				
							if(strlen(trim($t_object->get('ca_objects.projection_format', array("convertCodesToDisplayText" => true, 'delimiter' => ', '))))>0){
								print "<div class='unit'><b>".$t_object->getAttributeLabel('projection_format')."</b>: ".$t_object->get('ca_objects.projection_format',array("convertCodesToDisplayText" => true))."</div><!-- end unit -->";
							}
							if(strlen($t_object->get('ca_objects.fps_list'))>0){
								print "<div class='unit'><b>".$t_object->getAttributeLabel('fps_list')."</b>: ".$t_object->get('ca_objects.fps_list',array("convertCodesToDisplayText" => true))."</div><!-- end unit -->";
							}
							if(strlen($t_object->get('ca_objects.length'))>0){
								print "<div class='unit'><b>".$t_object->getAttributeLabel('length')."</b>: ".$t_object->get('ca_objects.length')."</div><!-- end unit -->";
							}	
							if(strlen($t_object->get('ca_objects.weight'))>0){
								print "<div class='unit'><b>".$t_object->getAttributeLabel('weight')."</b>: ".$t_object->get('ca_objects.weight')."</div><!-- end unit -->";
							}	
							if(strlen($t_object->get('ca_objects.reels'))>0){
								print "<div class='unit'><b>".$t_object->getAttributeLabel('reels')."</b>: ".$t_object->get('ca_objects.reels')."</div><!-- end unit -->";
							}	
							if(strlen($t_object->get('ca_objects.gossip'))>0){
								print "<div class='unit'><b>".$t_object->getAttributeLabel('gossip')."</b>: ".$t_object->get('ca_objects.gossip')."</div><!-- end unit -->";
							}				
?>
						</div>
					</div>
				</div><!-- end detailBox -->
<?php
			if($this->request->isLoggedIn() && $this->request->hasRole("frontendRestricted")){
?>
				<h3><?php print ($g_ui_locale == "de_DE" ? "Interne Angaben" : "Hidden Attributes"); ?></h2>
				<div class="detailBox">
					<div class="row">
						<div class="col-sm-6">
<?php
							$va_show_internal_fields = array(
								'object_type', 'notes', 'condition', 'condition_opt', 'condition_date', 'condition_comm', 'condition_color', 
								'source', 'source_date', 'oa3create_date', 'oa3change_date', 'rights', 'textlist',
								// neu
								'file_folder_name', 'bytes', 'number_of_files', 'image_frame', 'cpl', 'cpl_content_title_text',
								'original_format_notes', 'original_format_sound', 'original_fps', 'original_source', 'creator',
								'creation_date', 'processing_system', 'edited_by', 'processing_step', 'final', 'media'
							);
							$va_output = array();

							// Spezialfälle mit speziellen Labels
							$va_output[] = "<div class='unit'><b>"."OA3 ID"."</b>: ".$t_object->get('ca_objects.idno')."</div><!-- end unit -->";
							$va_output[] = "<div class='unit'><b>".($g_ui_locale == "de_DE" ? "Zugriffsrechte" : "Access")."</b>: ".$t_object->get('ca_objects.access',array('convertCodesToDisplayText' => true))."</div><!-- end unit -->";
							$va_output[] = "<div class='unit'><b>".($g_ui_locale == "de_DE" ? "Status" : "Status")."</b>: ".$t_object->get('ca_objects.status',array('convertCodesToDisplayText' => true))."</div><!-- end unit -->";

							foreach($va_show_internal_fields as $vs_bundle){
								if(strlen($t_object->get("ca_objects.{$vs_bundle}"))>0) {
									$va_output[] = "<div class='unit'><b>".$t_object->getAttributeLabel($vs_bundle)."</b>: ".$t_object->get("ca_objects.{$vs_bundle}",array('convertCodesToDisplayText' => true))."</div><!-- end unit -->";
								}
							}

							$vn_i = 1;
							foreach($va_output as $vs_output) {
								print $vs_output."\n";

								if($vn_i >= (floor(sizeof($va_output) / 2))) {
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
		  maxHeight: 200
		});
	});
</script>