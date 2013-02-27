<?php
/* ----------------------------------------------------------------------
 * /views/Detail/downloadTemplates/ca_objects_pdf_html.php 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2012 Whirl-i-Gig
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
	$t_item = $this->getVar("t_item");
	$t_collection = $this->getVar("t_item");
	$va_access_values = $this->getVar("access_values");
	$o_purifier = new HTMLPurifier();
	
?>
<HTML>
	<HEAD>
		<style type="text/css">
			<!--			
			div, p, table, span { font-size: 12px; color: #686868; font-family: "HelveticaNeueBlackCondensed", "HelveticaNeue-Black-Condensed", "Helvetica Neue Black Condensed", "HelveticaNeueBlack", "HelveticaNeue-Black", "Helvetica Neue Black", "HelveticaNeue", "Helvetica Neue", 'TeXGyreHerosCnBold', "Arial Narrow", "Arial", sans-serif;}
			.footer {font-size: 11px;}
			.unit { padding:0px 0px 10px 0px;}
			.unitTitle {font-weight:bold; color:#303030;}
			.sub { font-weight:bold; font-size: 13px; margin:0px 0px 10px 0px; color: #90BCC4;}
			H1 {font-size:18px; color: #303030; font-family: "HelveticaNeueBlackCondensed", "HelveticaNeue-Black-Condensed", "Helvetica Neue Black Condensed", "HelveticaNeueBlack", "HelveticaNeue-Black", "Helvetica Neue Black", "HelveticaNeue", "Helvetica Neue", 'TeXGyreHerosCnBold', "Arial Narrow", "Arial", sans-serif;
				text-transform: uppercase;}
			H2 { font-weight:bold; font-size: 14px; }
			.media { float:right; padding:0px 0px 10px 10px; width:400px; }
			.pageHeader { margin: 0px auto 20px auto; padding: 0px 5px 0px 5px; width: 100%; text-align:center;}
			.pageHeader img{ vertical-align:middle;  }
			.notes { font-style:italic; color:#828282; text-align:right; width:100%; clear:both}
			div.header {color:#333;}
			.footer li {float: left; color: #5c5c5c; font-size: 11px; line-height: 16px;  text-align:left; list-style-type:none; font-family: arial, helvetica, sans-serif;}
			li, ul {padding:0px, margin:0px;text-align:left;}
			li.first {width:300px;}
			li.second {width:220px;}
			li.third {width:290px;}
			-->
		</style>
	</HEAD>
	<BODY>

		<script type="text/php">

        if ( isset($pdf) ) {
            // Open the object: all drawing commands will
			// go to the object instead of the current page
			$footer = $pdf->open_object();
			
			$w = $pdf->get_width();
			$h = $pdf->get_height();
			
			// Draw a line along the bottom
			$y = $h - 24;
			$pdf->line(16, $y, $w - 16, $y, array(.5,.5,.5), 1);

			// Add text
			$font = Font_Metrics::get_font("helvetica", "bold");
			$text = html_entity_decode("Roundabout Theatre Company Archivist  |  (212) 719-9393  |  archives@roundabouttheatre.org", ENT_QUOTES, 'UTF-8');
			$pdf->text(20, $y+5, $text, $font, 7, array(.5,.5,.5));
			
			// Close the object (stop capture)
			$pdf->close_object();
			
			// Add the object to every page. You can
			// also specify "odd" or "even"
			$pdf->add_object($footer, "all");
         
         	$pdf->page_text($w - 60, $y+5, "{PAGE_NUM} of {PAGE_COUNT}", $font, 7, array(.5,.5,.5));
        }
        </script>
<?php	
		print "<div class='notes'><b>Downloaded:</b> ".caGetLocalizedDate(null, array('dateFormat' => 'delimited'))."</div>";

		if(file_exists($this->request->getThemeDirectoryPath().'/graphics/rtc_print.jpg')){
			print '<div class="pageHeader"><img src="'.$this->request->getThemeDirectoryPath().'/graphics/rtc_print.jpg" width="324" height="93"/></div>';
		}

?>		
		<h1><?php print "Finding Aid: ".$o_purifier->purify($t_collection->get('ca_collections.preferred_labels.name')); ?></h1>

		<div id="leftCol">	
<?php
			print "<div class='header'><h2>"._t('Collection Overview')."</h2></div>";
			if($vs_title){
				print "<div class='unit'><span class='unitTitle'>"._t("Collection Title")."</span>: ".$o_purifier->purify($vs_title)."</div><!-- end unit -->";
			}			
			# --- identifier
			if($t_collection->get('idno')){
				print "<div class='unit'><span class='unitTitle'>"._t("Identifier")."</span>: ".$o_purifier->purify($t_collection->get('idno'))."</div><!-- end unit -->";
			}
			# --- dates
			if($va_dates = $t_collection->get('ca_collections.inclusive_dates')){
				print "<div class='unit'><span class='unitTitle'>"._t("Inclusive Dates")."</span>: ".$o_purifier->purify($va_dates)."</div><!-- end unit -->";
			}
			# --- extent
			if($t_collection->get('ca_collections.extent.extent_collection')){
				$va_extent = $t_collection->get('ca_collections.extent', array('convertCodesToDisplayText' => true, 'template' => '^extent_collection ^type_collection'));
				print "<div class='unit'><span class='unitTitle'>"._t("Extent")."</span>: ".$o_purifier->purify($va_extent)."</div><!-- end unit -->";
			}
			# --- extent
			if($t_collection->get('ca_collections.extent_folder.folder_extent')){
				$va_extent = $t_collection->get('ca_collections.extent_folder', array('convertCodesToDisplayText' => true, 'template' => '^folder_extent ^type_folder'));
				print "<div class='unit'><span class='unitTitle'>"._t("Extent")."</span>: ".$o_purifier->purify($va_extent)."</div><!-- end unit -->";
			}			
			# --- scope
			if($va_scope = $t_collection->get('ca_collections.scope_note')){
				print "<div class='header'><h2>"._t("Scope and Content")."</h2></div><div class='unit'>".$o_purifier->purify($va_scope)."</div><!-- end unit -->";

			}
			if ($t_collection->get('ca_collections.Access_restrictions') | $t_collection->get('ca_collections.material_boxes') | $t_collection->get("ca_list_items")) {
				print "<div class='header'><h2>"._t('Administrative Information')."</h2></div>";
			}
			# --- access restrictions
			if($va_access = $t_collection->get('ca_collections.Access_restrictions')){
				print "<div class='unit'><span class='unitTitle'>"._t("Access Restrictions")."</span>: ".$o_purifier->purify($va_access)."</div><!-- end unit -->";
			}	
			# --- materials
			if($va_materials = $t_collection->get('ca_collections.material_boxes', array('convertCodesToDisplayText' => true, 'delimiter' => ', '))){
				print "<div class='unit'><span class='unitTitle'>"._t("Types of Materials")."</span>: ".$o_purifier->purify($va_materials)."</div><!-- end unit -->";
			}
			# --- vocabulary terms
			if($va_terms = $t_collection->get("ca_list_items.preferred_labels", array('delimiter' => ', '))) {
				print "<div class='unit'><span class='unitTitle'>"._t("Subjects").": </span>";
				print $o_purifier->purify($va_terms);
				print "</div><!-- end unit -->";
			}
			if ($va_lcsh = $t_collection->get('ca_collections.lcsh_terms', array('delimiter' => '<br/>'))) {
				print "<div class='unit'><span class='unitTitle'>"._t("Library of Congress Subject Headings")." </span><br/>";
				print $o_purifier->purify($va_lcsh);
				print "</div>";
			}
			# --- occurrences
			$va_occurrences = $t_collection->get("ca_occurrences", array("returnAsArray" => 1, 'checkAccess' => $va_access_values));
			$va_sorted_occurrences = array();
			if(sizeof($va_occurrences) > 0){
				$t_occ = new ca_occurrences();
				$va_item_types = $t_occ->getTypeList();
				foreach($va_occurrences as $va_occurrence) {
					$t_occ->load($va_occurrence['occurrence_id']);
					$va_sorted_occurrences[$va_occurrence['item_type_id']][$va_occurrence['occurrence_id']] = $va_occurrence;
				}
				
				foreach($va_sorted_occurrences as $vn_occurrence_type_id => $va_occurrence_list) {
?>
						<div class="unit"><span class='unitTitle'><?php print _t("Related")." ".$va_item_types[$vn_occurrence_type_id]['name_singular'].((sizeof($va_occurrence_list) > 1) ? "s" : ""); ?></span>
<?php
					foreach($va_occurrence_list as $vn_rel_occurrence_id => $va_info) {
						print "<div>".$o_purifier->purify($va_info["label"])." (".$o_purifier->purify($va_info['relationship_typename']).")</div>";				
					}
					print "</div><!-- end unit -->";
				}
			}						
			if ($va_parent = $t_collection->get('ca_collections.parent.preferred_labels')){
				$va_parent_id = $t_collection->get('ca_collections.parent_id');
				print "<div class='header'><h2>"._t("Parent Collection")."</h2></div><div class='unit'>".$o_purifier->purify($va_parent)."</div><!-- end unit -->";				
			}					
			# --- attributes
			$va_attributes = $this->request->config->get('ca_collections_detail_display_attributes');
			if(is_array($va_attributes) && (sizeof($va_attributes) > 0)){
				foreach($va_attributes as $vs_attribute_code){
					if($vs_value = $t_collection->get("ca_collections.{$vs_attribute_code}")){
						print "<div class='unit'><b>".$o_purifier->purify($t_collection->getDisplayLabel("ca_collections.{$vs_attribute_code}")).":</b> ".$o_purifier->purify($vs_value)."</div><!-- end unit -->";
					}
				}
			}
			# --- description
			if($this->request->config->get('ca_collections_description_attribute')){
				if($vs_description_text = $t_collection->get("ca_collections.".$this->request->config->get('ca_collections_description_attribute'))){
					print "<div class='unit'><div id='description'><b>".$t_collection->getDisplayLabel("ca_collections.".$this->request->config->get('ca_collections_description_attribute')).":</b> {$vs_description_text}</div></div><!-- end unit -->";				
?>
					<script type="text/javascript">
						jQuery(document).ready(function() {
							jQuery('#description').expander({
								slicePoint: 300,
								expandText: '<?php print _t('[more]'); ?>',
								userCollapse: false
							});
						});
					</script>
<?php
				}
			}
			


			if ($va_contents = $t_collection->get('ca_collections.children.preferred_labels.name', array('delimiter' => '<br/>', "sort" => "preferred_labels.name"))) {
				print "<div class='header'><h2>".unicode_ucfirst($t_collection->getTypeName())." "._t('Contents')."</h2></div>";
				print "<div class='unit'>".$o_purifier->purify($va_contents)."</div>";
			}
			# --- collections
			$va_collections = $t_collection->get("ca_collections", array("returnAsArray" => 1, 'checkAccess' => $va_access_values, "sort" => "preferred_labels.name"));
			if(sizeof($va_collections) > 0){
				print "<div class='header'><h2>"._t("Related Collection").((sizeof($va_collections) > 1) ? "s" : "")."</h2></div><div class='unit'>";

				foreach($va_collections as $va_collection_info){

					print "<div class='col'>".$o_purifier->purify($va_collection_info['label']);
					print "</div>";
					#$va_collection_id = $va_collection_info['collection_id'];
					#$t_collection = new ca_collections($va_collection_id);
					#print "<div class='subCol'>".$t_collection->get('ca_collections.children.preferred_labels.name', array('delimiter' => '<br/>', 'returnAsLink' => true, "sort" => "preferred_labels.name"))."</div>";
					#print "<div style='height:15px;width:100%;'></div>";
				}
				print "</div><!-- end unit -->";
			}
		
?>	
	

	</BODY>
</HTML>