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
	$va_access_values = $this->getVar("access_values");
	
?>
<HTML>
	<HEAD>
		<link rel="stylesheet" href="http://booklyn.org/wp/wp-content/themes/baa-theme/css/pdf_fonts.css" type="text/css" media="screen">
		<style type="text/css">
			<!--			
			div, p, table { font-size: 11px; font-family: Helvetica, sans-serif; color: #000;}
			span {font-family: 'DIN-Black-TT';}
			.footer {font-family: 'DIN-Black-TT'; font-size: 11px;}
			.unit { padding:0px 0px 10px 0px;}
			.sub { font-weight:bold; font-size: 13px; font-family: 'DIN-Black-TT'; margin:0px 0px 10px 0px; color: #90BCC4;}
			H2 { font-weight:bold; font-size: 11px; font-family: 'DIN-Black-TT'; }
			.media { float:right; padding:0px 0px 10px 10px; width:400px; }
			.pageHeader { margin: 0px auto 20px auto; padding: 0px 5px 0px 5px; width: 100%; font-family: Helvetica, sans-serif; text-align:center;}
			.pageHeader img{ vertical-align:middle;  }
			.notes { font-style:italic; color:#828282; margin-top:20px; width:100%; clear:both}
			div.subHeader{ width:100%; text-align:center; font-size: 13px; margin:0px auto 20px auto; clear:both; font-family: 'DIN-Black-TT'; color: #90BCC4;}
			-->
		</style>
	</HEAD>
	<BODY>
		
<?php
		if(file_exists($this->request->getThemeDirectoryPath().'/graphics/booklyn_logo_pdf.jpg')){
			print '<div class="pageHeader"><img src="'.$this->request->getThemeDirectoryPath().'/graphics/booklyn_logo_pdf.jpg" width="197" height="72"/></div>';
		}
?>		
		<div class='subHeader'>
<?php		
			if($va_artist = $t_item->get('ca_entities.preferred_labels', array('restrictToRelationshipTypes' => array('artist'), 'delimiter' => ', ', 'checkAccess' => $va_access_values, 'sort' => 'surname'))){
?>				
				<?php print $va_artist."<br/>"?>
<?php			
			}
			
			print $t_item->getLabelForDisplay();
			if($va_date = $t_item->get('ca_objects.pub_date.pubDatesValue')) {
				print ", ".$va_date;
			}
			
			
			
		print "</div><!-- end subHeader -->";		
		if($t_rep = $t_item->getPrimaryRepresentationInstance(array('return_with_access' => $va_access_values))){
			$va_rep_display_info = caGetMediaDisplayInfo("summary", $t_rep->getMediaInfo('media', 'INPUT', 'MIMETYPE'));
			if (!($vs_version = $va_rep_display_info['display_version'])) { $vs_version = "large"; }
?>
			<div class="media"><img src="<?php print $t_rep->getMediaPath("media", $vs_version); ?>"></div>
<?php
		}

		if($va_publisher = $t_item->get('ca_entities.preferred_labels', array('restrictToRelationshipTypes' => array('publisher'), 'delimiter' => ', ', 'checkAccess' => $va_access_values, 'sort' => 'surname'))){
			print "<div class='line'><span>"._t("Publisher").":</span> ".$va_publisher."</div><!-- end unit -->";
		}
		if($va_origin = $t_item->get('ca_objects.originLocation', array('template' => '^locationCity<ifdef code="locationCity,locationState">, </ifdef>^locationState ^locationCountry'))){
			print "<div class='unit'><span>"._t("Origin").": </span> ".$va_origin."</div><!-- end unit -->";
		}
		if($va_medium = $t_item->get('ca_objects.medium', array('delimiter' => ', ', 'convertCodesToDisplayText' => true))){
			print "<div class='line'><span>"._t("Medium").": </span> ".$va_medium."</div><!-- end unit -->";
		}
		if(($va_binding = $t_item->get('ca_objects.bindingType', array('delimiter' => ', ', 'convertCodesToDisplayText' => true))) && ($t_item->get('ca_objects.bindingType') != 233)){
			print "<div class='line'><span>"._t("Binding").": </span> ".$va_binding."</div><!-- end unit -->";
		}
		if($va_height = $t_item->get('ca_objects.overall_dimensions', array('template' => '^foot_length <ifdef code="foot_length">W </ifdef> <ifdef code="foot_length,spine_length">x</ifdef> ^spine_length<ifdef code="spine_length"> H</ifdef> <ifdef code="spine_length,depth">x</ifdef> ^depth<ifdef code="depth"> D</ifdef>'))){
			print "<div class='line'><span>"._t("Dimensions").": </span> ".$va_height."</div><!-- end unit -->";
		}	
		if($va_pages = $t_item->get('ca_objects.pages', array('delimiter' => ', '))){
			print "<div class='line'><span>"._t("Pages").": </span> ".$va_pages."</div><!-- end unit -->";
		}
		if($va_edition = $t_item->get('ca_objects.editionSize')){
			print "<div class='line'><span>"._t("Edition Size").": </span> ".$va_edition."</div><!-- end unit -->";
		}											
		# --- parent hierarchy info
		if($t_item->get('parent_id')){
			print "<div class='unit'>"._t("Part Of").": ".$t_item->get("ca_objects.parent.preferred_labels.name")."</div>";
		}
		# --- attributes
		$va_attributes = $this->request->config->get('ca_objects_detail_display_attributes');
		if(is_array($va_attributes) && (sizeof($va_attributes) > 0)){
			foreach($va_attributes as $vs_attribute_code){
				if($vs_value = $t_item->get("ca_objects.{$vs_attribute_code}")){
					print "<div class='unit'>".$t_item->getDisplayLabel("ca_objects.{$vs_attribute_code}").": {$vs_value}</div><!-- end unit -->";
				}
			}
		}
		# --- description
		if($this->request->config->get('ca_objects_description_attribute')){
			if($vs_description_text = $t_item->get("ca_objects.".$this->request->config->get('ca_objects_description_attribute'))){
				print "<div class='unit'><span>".$t_item->getDisplayLabel("ca_objects.".$this->request->config->get('ca_objects_description_attribute')).": </span>{$vs_description_text}</div><!-- end unit -->";				
			}
		}
		# --- child hierarchy info
		$va_children = $t_item->get("ca_objects.children.preferred_labels", array('returnAsArray' => 1, 'checkAccess' => $va_access_values));
		if(sizeof($va_children) > 0){
			print "<div class='unit'><h2>"._t("Part%1", ((sizeof($va_children) > 1) ? "s" : ""))."</h2> ";
			foreach($va_children as $va_child){
				print "<div>".$va_child['name']."</div>";
			}
			print "</div><!-- end unit -->";
		}
		# --- entities
		
		if ($va_entities = $t_item->get("ca_entities", array('restrictToRelationshipTypes' => array('contributor'), 'checkAccess' => $va_access_values, 'sort' => 'surname', 'delimiter' => ', '))) {
			print "<div class='unit'>"._t('Other Contributors').": ".$va_entities."</div>";
		}
		print "<table style='float:left; width:40%; margin-right:10px;'>";
		# --- collectors

		if ($va_institutions = $t_item->get("ca_entities", array('checkAccess' => $va_access_values, 'restrictToRelationshipTypes' => array('institutional'), 'sort' => 'surname', 'template' => '<tr><td>^preferred_labels</td></tr>'))) {
			print "<tr><td><span>Institutional Collectors:</span></td></tr>".$va_institutions;
		}
		print "</table";
		print "<table style='width:40%; float:left'>";		
		# --- exhibitions
		$va_exhibitions = array();
		if ($va_exhibition_array = $t_item->get("ca_occurrences", array("returnAsArray" => true, 'checkAccess' => $va_access_values, 'sort' => 'name'))) {
			
			print "<tr><td><span>"._t('Exhibitions').":</span></td></tr>";
			foreach($va_exhibition_array as $key => $exhibition_array) {
				print "<tr><td>".$exhibition_array['label']."</td></tr>";
			}
			
			
		}
		print "</table>";
		#print "</div><!-- end spacer -->";
		#print "<div class='notes'><b>Downloaded:</b> ".caGetLocalizedDate(null, array('dateFormat' => 'delimited'))."</unit>";
?>	
	<div class='footer' style='width:100%; text-align:center; clear:both; '>Booklyn Artists Alliance - 37 Greenpoint Avenue, Suite E4G / Box 23 Brooklyn, NY 11222<br/>
		718-383-9621 - Booklyn.org - mweber@booklyn.org
	</div>
	
	</BODY>
</HTML>