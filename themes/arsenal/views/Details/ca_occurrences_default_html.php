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
 
$t_item = $this->getVar("item");
	$va_comments = 			$this->getVar("comments");
	$va_tags = 				$this->getVar("tags_array");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");
	$vn_pdf_enabled = 		$this->getVar("pdfEnabled");
	$va_access_values = caGetUserAccessValues($this->request);

	
	$va_related_objects = $t_item->get("ca_objects.related",array("checkAccess" => $va_access_values, "returnWithStructure" => true, "restrictToTypes" => array("film_print", "digital_item", "video_item")));
	if(is_array($va_related_objects) && sizeof($va_related_objects)){
		$va_object_ids = array();
		foreach($va_related_objects as $vn_i => $va_info){
			$va_object_ids[] = $va_info["object_id"];
		}
		$o_context = new ResultContext($this->request, 'ca_objects', 'detailrelated');
		$o_context->setAsLastFind();
		$o_context->setResultList($va_object_ids);
		$o_context->saveContext();
	}	
	
	$vs_representationViewer = trim($this->getVar("representationViewer"));

	$t_locale =					new ca_locales();

	global $g_ui_locale;
	
	$vs_type = $t_item->getWithTemplate("^ca_occurrences.type_id");
	switch($vs_type){
		case "Filmwerk":
			$vs_type = "Werk";
		break;
		# ---------------
	}
?>

		<div class="row">
			<div class='col-sm-12'>
				<div class='navTop'><!--- only shown at small screen size -->
					{{{previousLink}}}{{{resultsLink}}}{{{nextLink}}}
				</div><!-- end detailTop -->
				<H1>{{{ca_occurrences.preferred_labels.name}}}</H1>
				<H2><?php print $vs_type; ?></H2>
				<HR>
			</div>
		</div>
		<div class="row">
<?php
		if($vs_representationViewer){
?>
			<div class='col-sm-6 col-md-6'>
				<?php print $vs_representationViewer; ?>
				<?php print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_item, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-sm-3 col-md-2 col-xs-4", "primaryOnly" => $this->getVar('representationViewerPrimaryOnly') ? 1 : 0)); ?>

			</div><!-- end col -->
			
			<div class='col-sm-6 col-md-6'>
<?php
		}else{
?>
			<div class='col-sm-12'>
<?php
		}

				$va_alt_label_list = $t_item->get('ca_occurrences.nonpreferred_labels.name', array('returnAllLocales' => true, 'returnWithStructure' => true));
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

			if(strlen($t_item->get('ca_occurrences.title_series'))>0){
				print "<div class='unit'><label>".$t_item->getAttributeLabel('title_series')."</label>".$t_item->get('ca_occurrences.title_series');
				if($t_item->get('ca_occurrences.series')){
					print " (".$t_item->get('ca_occurrences.series.series_unit',array("convertCodesToDisplayText" => true))." ".$t_item->get('ca_occurrences.series.series_value').")";
				}
				print "</div><!-- end unit -->";
			}
			
			$va_entity_ids = $t_item->get('ca_entities.entity_id', array('returnAsArray' => true, 'restrictToRelationshipTypes' => array("director")));
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
			
			
			// other credits
			if(is_array($credits = $t_item->getRelatedItems('ca_entities', ['excludeRelationshipTypes' => ['director']]))) {
				$by_credit = [];
				foreach($credits as $credit) {
					$by_credit[$credit['relationship_typename']][] = caNavLink($this->request,$credit['label'],'','','Browse','works',array("facet" => "entity_facet", "id" => $credit['entity_id']));
				}
				foreach($by_credit as $credit => $links) {
?><div class='unit'>
	<label><?= ucfirst($credit); ?></label>
	<?= join("<br/>\n", $links); ?>
</div><?php
				}
			}
			
			
			if($t_item->get('ca_occurrences.country',array("convertCodesToDisplayText" => true))){
				print "<div class='unit'><label>".$t_item->getAttributeLabel('country')."</label>".$t_item->get('ca_occurrences.country', array("convertCodesToDisplayText" => true, 'delimiter' => ', '))."</div><!-- end unit -->";
			}
			if(strlen($t_item->get('ca_occurrences.production_year'))>0){
				print "<div class='unit'><label>".$t_item->getAttributeLabel('production_year')."</label>".$t_item->get('ca_occurrences.production_year', array('delimiter' => ', '))."</div><!-- end unit -->";
			}
			if(strlen(trim($t_item->get('ca_occurrences.language', array("convertCodesToDisplayText" => true, 'delimiter' => ', '))))>0){
				print "<div class='unit'><label>".$t_item->getAttributeLabel('language')."</label>".$t_item->get('ca_occurrences.language', array("convertCodesToDisplayText" => true, 'delimiter' => ', '))."</div><!-- end unit -->";
			}
			if(strlen($t_item->get('ca_occurrences.forum_year'))>0){
				print "<div class='unit'><label>".$t_item->getAttributeLabel('forum_year')."</label>".$t_item->get('ca_occurrences.forum_year', array('delimiter' => ', '))."</div><!-- end unit -->";
			}
			if(strlen($murl = $t_item->get('ca_occurrences.forum_catalogue_pdf.original.url'))>0){
				print "<div class='unit'><label>".$t_item->getAttributeLabel('forum_catalogue_pdf')."</label><a href='{$murl}' target='_new'>"._t('PDF')."</a></div><!-- end unit -->";  
			}
			
			// TODO: need final text and formatting for link
			if($url = $t_item->get('ca_occurrences.film_page_url')) {
				print "<div class='unit'><label>".($g_ui_locale == "de_DE" ? "Forum" : "Forum")."</label><div class='trimText'><a href='{$url}' target='_blank'>".($g_ui_locale == "de_DE" ? "Mehr Informationen zum Film auf der Webseite des Forums" : "For more information on the film visit the Forum page")."</a></div></div>";
			}	
			
			if(strlen($t_item->get('ca_occurrences.world_premiere'))>0){
				print "<div class='unit'><label>".$t_item->getAttributeLabel('world_premiere')."</label>".$t_item->get('ca_occurrences.world_premiere', array('delimiter' => ', '))."</div><!-- end unit -->";
			}

			$va_tags = $t_item->get("ca_list_items", array("returnWithStructure" => true));
			if(is_array($va_tag) && sizeof($va_tags)){
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
			if($this->request->isLoggedIn() && $t_item->get('ca_occurrences.work_notes')){
				print "<div class='unit'><label>".$t_item->getAttributeLabel('work_notes')."</label>".$t_item->get('ca_occurrences.work_notes', array('delimiter' => '<br/>'))."</div><!-- end unit -->";
			}
			if($t_item->get("ca_occurrences.credit_editable.credit_entity")){
				print "<div class='unit'><label>".($g_ui_locale == "de_DE" ? "Credits" : "Credits")."</label><div class='trimText'>";
				print $t_item->getWithTemplate("<unit relativeTo='ca_occurrences.credit_editable' delimiter='<br/>'>^ca_occurrences.credit_editable.credit_role: ^ca_occurrences.credit_editable.credit_entity</unit>");
				print "</div></div>";
			}
?>
			</div><!-- end col -->
		</div><!-- end row -->
		<div class="row">
			<div class='col-sm-12 col-md-12'><HR/></div>
		</div>
		<div class="row">
			
<?php
			if(strlen($t_item->get('ca_occurrences.description'))>0){
				print "<div class='col-sm-6'>";
				print "<div class='unit'><label>".$t_item->getAttributeLabel('description')."</label><div class='trimText'>".$t_item->get('ca_occurrences.description')."</div></div><!-- end unit -->";
				print "</div>";
			}
			if((bool)CookieOptionsManager::allow("video")){
				if($t_item->get('ca_occurrences.trailermedia') || $t_item->get('ca_occurrences.trailer.trailer_url')){
?>
					<div class='col-sm-6 text-center'>
						{{{<ifdef code="ca_occurrences.trailermedia"><div class="unit"><unit relativeTo="ca_occurrences.trailermedia" delimiter="<br/><br/>">^ca_occurrences.trailermedia%embed=1</unit></div></ifdef>}}}
						{{{<ifdef code="ca_occurrences.trailer.trailer_url"><div class="unit text-left"><unit relativeTo="ca_occurrences.trailer" delimiter="<br/>"><a href="^ca_occurrences.trailer.trailer_url" target="_blank">&rarr; ^ca_occurrences.trailer.trailer_description<ifnotdef code="ca_occurrences.trailer.trailer_description">Trailer</ifnotdef></a></unit></unit></ifdef>}}}
					</div>
<?php
				}
			}else{
				if($t_item->get('ca_occurrences.trailer.trailer_url')){
?>
					<div class='col-sm-6 text-center'>
						{{{<ifdef code="ca_occurrences.trailer.trailer_url"><div class="unit text-left"><unit relativeTo="ca_occurrences.trailer" delimiter="<br/>"><a href="^ca_occurrences.trailer.trailer_url" target="_blank">&rarr; ^ca_occurrences.trailer.trailer_description<ifnotdef code="ca_occurrences.trailer.trailer_description">Trailer</ifnotdef></a></unit></unit></ifdef>}}}
					</div>
<?php
				}
			}		
?>
		</div><!-- end row -->
		<div class="row">
			<div class='col-sm-12'>
<?php
			# --- output related objects as links
			if (is_array($va_related_objects) && sizeof($va_related_objects)) {
				$t_rel = new ca_objects();
				print "<div class='unit'><label>".($g_ui_locale == "de_DE" ? "Kopien" : "Copies")."</label>";
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
						$vs_rel_label .= " (".(($print_id = $t_rel->get('ca_objects.print_id')) ? $print_id : $va_object_info["idno"]).")";
					}

					print caDetailLink($this->request, "&rarr; ".$vs_rel_label, '', 'ca_objects', $t_rel->getPrimaryKey());
					print "<br />";
				}
				print "</div>";
			}
?>	
			</div>
		</div>

<script type='text/javascript'>
	jQuery(document).ready(function() {
		$('.trimText').readmore({
		  speed: 75,
		  maxHeight: 400
		});
	});
</script>