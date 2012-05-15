<?php
/* ----------------------------------------------------------------------
 * pawtucket2/themes/default/views/ca_objects_detail_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2009 Whirl-i-Gig
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
	$t_object = 					$this->getVar('t_item');
	$vn_object_id = 				$t_object->get('object_id');
	$vs_title = 					$this->getVar('label');
	if($this->request->config->get("dont_enforce_access_settings")){
		$va_access = array();
	} else {
		$va_access = $this->request->config->getList("public_access_settings");
	}

	$va_related_objects =				$t_object->getRelatedItems("ca_objects",array("checkAccess" => $va_access));
	
	$t_rep = 					$this->getVar('t_primary_rep');
	$vs_display_version =				$this->getVar('primary_rep_display_version');
	
	$t_rel_types = 					$this->getVar('t_relationship_types');
	$t_locale =					new ca_locales();

	global $g_ui_locale;
?>	
	<div id="detailBody">
		<div id="pageNav">
<?php
			print ResultContext::getResultsLinkForLastFind($this->request, 'ca_objects', "<img src='".$this->request->getThemeUrlPath()."/graphics/arrow_up_grey.gif' width='11' height='10' border='0'> "._t("BACK"), '');

			if (($this->getVar('next_id')) || ($this->getVar('previous_id'))) {	
				print "&nbsp;&nbsp;&nbsp;";
			}
			if ($this->getVar('previous_id')) {
				print caNavLink($this->request, "<img src='".$this->request->getThemeUrlPath()."/graphics/arrow_grey_left.gif' width='10' height='10' border='0'> "._t("PREVIOUS"), '', 'Detail', 'Object', 'Show', array('object_id' => $this->getVar('previous_id')), array('id' => 'previous'));
			}
			if (($this->getVar('next_id')) && ($this->getVar('previous_id'))) {	
				print "&nbsp;&nbsp;|&nbsp;&nbsp;";
			}
			if ($this->getVar('next_id') > 0) {
				print caNavLink($this->request, _t("NEXT")." <img src='".$this->request->getThemeUrlPath()."/graphics/arrow_grey_right.gif' width='10' height='10' border='0'>", '', 'Detail', 'Object', 'Show', array('object_id' => $this->getVar('next_id')), array('id' => 'next'));
			}
?>
		</div><!-- end nav -->
		
		<div id="leftCol">
		<h1><?php print $vs_title; ?></h1>
		<div id="rightCol">
<?php
		$va_reps = $t_object->getRepresentations(array('medium', 'icon'));
		if ($t_rep && $t_rep->getPrimaryKey()) {
?>
			<div id="objDetailImage">
				<div id="objDetailRepScrollingViewer">
					<div id="objDetailRepScrollingViewerImageContainer"></div>
				</div>
				<div id="objDetailImageNav">
					<div>

<?php
				if (sizeof($va_reps) > 1) {
?>
					<a href="#" onclick="caObjDetailRepScroller.scrollToPreviousImage(); return false;" id="previousImage"><?php print _t("< previous"); ?></a>
					&nbsp;<span id='objDetailRepScrollingViewerCounter'></span>&nbsp;
					<a href="#" onclick="caObjDetailRepScroller.scrollToNextImage(); return false;" id="nextImage"><?php print _t("next >"); ?></a>
<?php
				}
?>
					</div>

					<script type="text/javascript">
<?php
					foreach($va_reps as $va_rep) {
						//print_r($va_rep);
						$va_imgs[] = "{url:'".$va_rep['urls']['medium']."', width: ".$va_rep['info']['medium']['WIDTH'].", height: ".$va_rep['info']['medium']['HEIGHT']."}";
					}
?>
						var caObjDetailRepScroller = caUI.initImageScroller([<?php print join(",", $va_imgs); ?>], 'objDetailRepScrollingViewerImageContainer', {
								containerWidth: 450, containerHeight: 400,
								imageCounterID: 'objDetailRepScrollingViewerCounter',
								scrollingImageClass: 'objDetailRepScrollerImage',
								scrollingImagePrefixID: 'objDetailRep',
								noImageLink: 1
						});
					</script>
				</div><!-- end objDetailImageNav -->
			</div><!-- end objDetailImage -->

<?php
		}
?>

		</div><!-- end rightCol -->
		<div id="objectDetailContent">

			<div class="unit">
<?php
				$va_label_list = $t_object->get('ca_objects.preferred_labels.name', array('returnAllLocales' => true));
				foreach($va_label_list as $va_labels_by_locale) {
					foreach($va_labels_by_locale as $vn_locale_id => $va_label_values) {
						foreach($va_label_values as $vn_num => $vs_label_text) {
							if($vs_label_text != $vs_title) {
								print "<div class='unit'><b>"._t("Title")."</b>: ".$vs_label_text."</div>\n";
							}
						}
					}
				}

				$va_alt_label_list = $t_object->get('ca_objects.nonpreferred_labels.name', array('returnAllLocales' => true));
				$vn_locale_de = $t_locale->loadLocaleByCode('de_DE');
				$vn_locale_en = $t_locale->loadLocaleByCode('en_US');
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
								print "<div class='unit'><b>".$vs_nonpref_label."</b>: ".$vs_label_text."</div>\n";
							}
						}
					}
				}

			if($t_object->get('ca_objects.title_series')){
				print "<div class='unit'><b>".$t_object->getAttributeLabel('title_series')."</b>: ".$t_object->get('ca_objects.title_series');
				if($t_object->get('ca_objects.series')){
					print " (".$t_object->get('ca_objects.series.series_unit',array("convertCodesToDisplayText" => true))." ".$t_object->get('ca_objects.series.series_value').")";
				}
				print "</div><!-- end unit -->";
			}
			
			$va_entity_ids = $t_object->get('ca_entities.entity_id', array('returnAsArray' => true));
			$t_entity = new ca_entities();
				foreach($va_entity_ids as $vn_entity_id) {
					if ($t_entity->load($vn_entity_id)) {           // doesn't hurt to make sure the entity actually loaded... but it should never fail
						print "<div class='unit'>";
						if ($vs_director_name = $t_entity->get('ca_entities.preferred_labels.displayname')) {
							$vs_director_search = str_replace("!","",$vs_director_name);
							$vs_director_search = "entity:".$vs_director_search;

							print "<b>".($g_ui_locale=="en_US" ? "Director" : "Regie").": </b>";
							print caNavLink($this->request,$vs_director_name,'','','Search','Index',array("search" => $vs_director_search));
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
							print "<span id='biocontent$vn_entity_id' style='display:none'><br /><b>"._t("Biography").": </b>".$vs_director_bio."<br /></span>\n";
						}
						print "</div>";
					}
				}
			if($t_object->get('ca_objects.country',array("convertCodesToDisplayText" => true))){
				print "<div class='unit'><b>".$t_object->getAttributeLabel('country')."</b>: ".$t_object->get('ca_objects.country', array("convertCodesToDisplayText" => true, 'delimiter' => ', '))."</div><!-- end unit -->";
			}
			if($t_object->get('ca_objects.production_year')){
				print "<div class='unit'><b>".$t_object->getAttributeLabel('production_year')."</b>: ".$t_object->get('ca_objects.production_year', array('delimiter' => ', '))."</div><!-- end unit -->";
			}
			if($t_object->get('ca_objects.description')){
				print "<div class='unit'><b>".$t_object->getAttributeLabel('description')."</b>: ".$t_object->get('ca_objects.description')."</div><!-- end unit -->";
			}
			if($t_object->get('ca_objects.forum_year')){
				print "<div class='unit'><b>".$t_object->getAttributeLabel('forum_year')."</b>: ".$t_object->get('ca_objects.forum_year', array('delimiter' => ', '))."</div><!-- end unit -->";
			}
			if($t_object->get('ca_objects.forum_pdf')){
				print "<div class='unit'><b>".$t_object->getAttributeLabel('forum_pdf')."</b>: ".$t_object->get('ca_objects.forum_pdf', array('delimiter' => ', '))."</div><!-- end unit -->";
			}

			$va_tags = $t_object->getRelatedItems("ca_list_items");
			if(sizeof($va_tags)){
				print "<div class='unit'><b>".($g_ui_locale == "de_DE" ? "Schlagworte" : "Tags")."</b>: ";
				$va_print_tags = array();
				foreach($va_tags as $vn_id => $va_term_info){
					if($va_term_info["idno"]=="exp"){
						$va_print_tags[] = caNavLink($this->request, $va_term_info["label"], '', '', 'Search', 'Index', array('search' => $va_term_info["label"]));
					} else {
						$va_print_tags[] = $va_term_info["label"];
					}
					
				}
				print join(", ",$va_print_tags);
			}
?>
</div>
<?php
   if ($t_rep) {
       print "<div class='divide' style='width:320px'></div>";
       } else {
       print "<div class='divide' style='width:790px'></div>";
       }
?>
<?php		
			# --- output related objects as links
			if (sizeof($va_related_objects)) {
				$t_rel = new ca_objects();
				print "<div class='unit'><h2>".($g_ui_locale == "de_DE" ? "Weitere Kopien:" : "More Prints:")."</h2>";
				foreach($va_related_objects as $vn_id => $va_object_info){
					$t_rel->load($va_object_info["object_id"]);
					if($vs_format = $t_rel->get("ca_objects.format", array("convertCodesToDisplayText" => true))){
						$vs_rel_label = $va_object_info["label"].", {$vs_format}";
					} else {
						$vs_rel_label = $va_object_info["label"];
					}
					if($this->request->config->get("dont_enforce_access_settings")){
						$vs_rel_label .= " (".$va_object_info["object_id"].")";
					}
					print caNavLink($this->request, $vs_rel_label, '', 'Detail', 'Object', 'Show', array('object_id' => $t_rel->getPrimaryKey()));
					print "<br />";
				}
				print "</div>";
			}
?>
			<!-- AddThis Button BEGIN -->
			<div class="unit" style="margin-bottom:25px"><a class="addthis_button" href="http://www.addthis.com/bookmark.php?v=250&amp;username=xa-4baa59d57fc36521"><img src="http://s7.addthis.com/static/btn/v2/lg-share-en.gif" width="125" height="16" alt="Bookmark and Share" style="border:0;"/></a><script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#username=xa-4baa59d57fc36521"></script></div><!-- end unit -->
			<!-- AddThis Button END -->
		</div><!-- end objectDetailContent-->
		</div><!-- end leftCol-->
		</div><!-- end detailBody -->

<div id="tech" class="techunit">
<h2><?php print ($g_ui_locale == "de_DE" ? "Technische Angaben" : "Technical Attributes"); ?></h2>
<div style="border:1px solid #000; padding:10px; width:770px;">
<div style="float:left; width:350px;">
<?php
			if($vs_idno = $t_object->get('ca_objects.oa3_id')){
				print "<div class='unit'><b>".($g_ui_locale == "de_DE" ? "Kopiennummer" : "Print ID")."</b>: ".$vs_idno."</div><!-- end unit -->";
			}
			if($t_object->get('ca_objects.format')){
				print "<div class='unit'><b>".$t_object->getAttributeLabel('format')."</b>: ".$t_object->get('ca_objects.format',array("convertCodesToDisplayText" => true))."</div><!-- end unit -->";
			}
			if($t_object->get('ca_objects.to_rent')){
				print "<div class='unit'><b>".$t_object->getAttributeLabel('to_rent')."</b>: ".$t_object->get('ca_objects.to_rent',array("convertCodesToDisplayText" => true))."</div><!-- end unit -->";
			}
			if($t_object->get('ca_objects.version')){
				print "<div class='unit'><b>".$t_object->getAttributeLabel('version')."</b>: ".$t_object->get('ca_objects.version',array("convertCodesToDisplayText" => true))."</div><!-- end unit -->";
			}
			if($t_object->get('ca_objects.language')){
				print "<div class='unit'><b>".$t_object->getAttributeLabel('language')."</b>: ".$t_object->get('ca_objects.language', array("convertCodesToDisplayText" => true, 'delimiter' => ', '))."</div><!-- end unit -->";
			}
			if($t_object->get('ca_objects.lang_syn')){
				print "<div class='unit'><b>".$t_object->getAttributeLabel('lang_syn')."</b>: ".$t_object->get('ca_objects.lang_syn', array("convertCodesToDisplayText" => true, 'delimiter' => ', '))."</div><!-- end unit -->";
			}
			if($t_object->get('ca_objects.lang_sub')){
				print "<div class='unit'><b>".$t_object->getAttributeLabel('lang_sub')."</b>: ".$t_object->get('ca_objects.lang_sub', array("convertCodesToDisplayText" => true, 'delimiter' => ', '))."</div><!-- end unit -->";
			}
			if($t_object->get('ca_objects.lang_intertit')){
				print "<div class='unit'><b>".$t_object->getAttributeLabel('lang_intertit')."</b>: ".$t_object->get('ca_objects.lang_intertit', array("convertCodesToDisplayText" => true, 'delimiter' => ', '))."</div><!-- end unit -->";
			}
			if($t_object->get('ca_objects.lang_txtlist')){
				print "<div class='unit'><b>".$t_object->getAttributeLabel('lang_txtlist')."</b>: ".$t_object->get('ca_objects.lang_txtlist', array("convertCodesToDisplayText" => true, 'delimiter' => ', '))."</div><!-- end unit -->";
			}
?>
</div>
<div style="float:right; width:350px;">
<?php
			if($t_object->get('ca_objects.lang_voiceover ')){
				print "<div class='unit'><b>".$t_object->getAttributeLabel('lang_voiceover')."</b>: ".$t_object->get('ca_objects.lang_voiceover', array("convertCodesToDisplayText" => true, 'delimiter' => ', '))."</div><!-- end unit -->";
			}
			if($t_object->get('ca_objects.lang_magnet ')){
				print "<div class='unit'><b>".$t_object->getAttributeLabel('lang_magnet')."</b>: ".$t_object->get('ca_objects.lang_magnet', array("convertCodesToDisplayText" => true, 'delimiter' => ', '))."</div><!-- end unit -->";
			}
			if($t_object->get('ca_objects.duration')){
				print "<div class='unit'><b>".$t_object->getAttributeLabel('duration')."</b>: ".$t_object->get('ca_objects.duration')."</div><!-- end unit -->";
			}
			if($t_object->get('ca_objects.color')){
				print "<div class='unit'><b>".$t_object->getAttributeLabel('color')."</b>: ".$t_object->get('ca_objects.color', array("convertCodesToDisplayText" => true))."</div><!-- end unit -->";
			}
			if($t_object->get('ca_objects.sound')){
				print "<div class='unit'><b>".$t_object->getAttributeLabel('sound')."</b>: ".$t_object->get('ca_objects.sound', array("convertCodesToDisplayText" => true, 'delimiter' => ', '))."</div><!-- end unit -->";
			}
			if($t_object->get('ca_objects.ratio')){
				print "<div class='unit'><b>".$t_object->getAttributeLabel('ratio')."</b>: ".$t_object->get('ca_objects.ratio', array("convertCodesToDisplayText" => true))."</div><!-- end unit -->";
			}				
			if($t_object->get('ca_objects.projection_format')){
				print "<div class='unit'><b>".$t_object->getAttributeLabel('projection_format')."</b>: ".$t_object->get('ca_objects.projection_format',array("convertCodesToDisplayText" => true))."</div><!-- end unit -->";
			}
			if($t_object->get('ca_objects.fps')){
				print "<div class='unit'><b>".$t_object->getAttributeLabel('fps')."</b>: ".$t_object->get('ca_objects.fps')."</div><!-- end unit -->";
			}
			if($t_object->get('ca_objects.length')){
				print "<div class='unit'><b>".$t_object->getAttributeLabel('length')."</b>: ".$t_object->get('ca_objects.length')."</div><!-- end unit -->";
			}	
			if($t_object->get('ca_objects.weight')){
				print "<div class='unit'><b>".$t_object->getAttributeLabel('weight')."</b>: ".$t_object->get('ca_objects.weight')."</div><!-- end unit -->";
			}	
			if($t_object->get('ca_objects.reels')){
				print "<div class='unit'><b>".$t_object->getAttributeLabel('reels')."</b>: ".$t_object->get('ca_objects.reels')."</div><!-- end unit -->";
			}	
			if($t_object->get('ca_objects.gossip')){
				print "<div class='unit'><b>".$t_object->getAttributeLabel('gossip')."</b>: ".$t_object->get('ca_objects.gossip')."</div><!-- end unit -->";
			}				
?>
</div>
<div style="clear:both"><!-- empty --></div>
</div></div><!-- end tech -->
<?php
if($this->request->config->get("dont_enforce_access_settings")){
?>
<br /><br />
<div id="tech" class="techunit">
<h2><?php print ($g_ui_locale == "de_DE" ? "Interne Angaben" : "Hidden Attributes"); ?></h2>
<div style="border:1px solid #000; padding:10px; width:770px;">
<div style="float:left; width:350px;">
<?php
	if($t_object->get('ca_objects.idno')){
		print "<div class='unit'><b>"."OA3 ID"."</b>: ".$t_object->get('ca_objects.idno')."</div><!-- end unit -->";
	}
	if($t_object->get('ca_objects.notes')){
		print "<div class='unit'><b>".$t_object->getAttributeLabel('notes')."</b>: ".$t_object->get('ca_objects.notes')."</div><!-- end unit -->";
	}
	if($t_object->get('ca_objects.condition')){
		print "<div class='unit'><b>".$t_object->getAttributeLabel('condition')."</b>: ".$t_object->get('ca_objects.condition')."</div><!-- end unit -->";
	}
	if($t_object->get('ca_objects.condition_opt')){
		print "<div class='unit'><b>".$t_object->getAttributeLabel('condition_opt')."</b>: ".$t_object->get('ca_objects.condition_opt')."</div><!-- end unit -->";
	}
	if($t_object->get('ca_objects.condition_date')){
		print "<div class='unit'><b>".$t_object->getAttributeLabel('condition_date')."</b>: ".$t_object->get('ca_objects.condition_date')."</div><!-- end unit -->";
	}
	if($t_object->get('ca_objects.condition_comm')){
		print "<div class='unit'><b>".$t_object->getAttributeLabel('condition_comm')."</b>: ".$t_object->get('ca_objects.condition_comm')."</div><!-- end unit -->";
	}
	if($t_object->get('ca_objects.condition_color')){
		print "<div class='unit'><b>".$t_object->getAttributeLabel('condition_color')."</b>: ".$t_object->get('ca_objects.condition_color')."</div><!-- end unit -->";
	}
?>
</div>
<div style="float:right; width:350px;">
<?php
	if(strlen($t_object->get('ca_objects.access'))>0){
		print "<div class='unit'><b>".($g_ui_locale == "de_DE" ? "Zugriffsrechte" : "Access")."</b>: ".$t_object->get('ca_objects.access',array('convertCodesToDisplayText' => true))."</div><!-- end unit -->";
	}
	if($t_object->get('ca_objects.status')){
		print "<div class='unit'><b>".($g_ui_locale == "de_DE" ? "Status" : "Status")."</b>: ".$t_object->get('ca_objects.status',array('convertCodesToDisplayText' => true))."</div><!-- end unit -->";
	}
	if($t_object->get('ca_objects.source')){
		print "<div class='unit'><b>".$t_object->getAttributeLabel('source')."</b>: ".$t_object->get('ca_objects.source')."</div><!-- end unit -->";
	}
	if($t_object->get('ca_objects.source_date')){
		print "<div class='unit'><b>".$t_object->getAttributeLabel('source_date')."</b>: ".$t_object->get('ca_objects.source_date')."</div><!-- end unit -->";
	}
	if($t_object->get('ca_objects.oa3create_date')){
		print "<div class='unit'><b>".$t_object->getAttributeLabel('oa3create_date')."</b>: ".$t_object->get('ca_objects.oa3create_date')."</div><!-- end unit -->";
	}
	if($t_object->get('ca_objects.oa3change_date')){
		print "<div class='unit'><b>".$t_object->getAttributeLabel('oa3change_date')."</b>: ".$t_object->get('ca_objects.oa3change_date')."</div><!-- end unit -->";
	}
	if($t_object->get('ca_objects.rights')){
		print "<div class='unit'><b>".$t_object->getAttributeLabel('rights')."</b>: ".$t_object->get('ca_objects.rights')."</div><!-- end unit -->";
	}
	if($t_object->get('ca_objects.textlist')){
		print "<div class='unit'><b>".$t_object->getAttributeLabel('textlist')."</b>: ".$t_object->get('ca_objects.textlist')."</div><!-- end unit -->";
	}
?>
</div>
<div style="clear:both"><!-- empty --></div>
</div></div><!-- end tech -->
<?php
}
?>
