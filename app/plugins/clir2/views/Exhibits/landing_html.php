<?php
/* ----------------------------------------------------------------------
 * app/plugins/simpleGallery/landing_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2010 Whirl-i-Gig
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
 
	$va_set_list 								= $this->getVar('sets');
	$va_first_items_from_sets 		= $this->getVar('first_items_from_sets');
	$va_set_descriptions					= $this->getVar('set_descriptions');
?>
<?php print $this->render('Engage/subNav.php'); ?>
<h1>
<?php
	if($this->request->getController() == "Exhibits"){
		print _t("Exhibits");
	}else{
		print _t("Your Sets");
	}
?></H1>
<div id="galleryLanding">
	<div class="textContent">
<?php
	if($this->request->getController() == "Exhibits"){
		print $this->render('Exhibits/intro_text_html.php');
	}else{
		print $this->render('Exhibits/your_sets_intro_text_html.php');
	}
?>
	</div>
<?php
	$t_occurrence = new ca_occurrences();
	foreach($va_set_list as $vn_set_id => $va_set_info){
		$va_item = $va_first_items_from_sets[$vn_set_id][array_shift(array_keys($va_first_items_from_sets[$vn_set_id]))];
		$t_occurrence->load($va_item['row_id']);
		$va_preview_stills = array();
		$vs_preview_still = "";
		$va_medium_stills = array();
		$vs_medium_still = "";
		$va_preview_stills = $t_occurrence->get('ca_occurrences.ic_stills.ic_stills_media', array('version' => "widepreview", "showMediaInfo" => false, "returnAsArray" => true));
		if(sizeof($va_preview_stills) > 0){
			$vs_preview_still = array_shift($va_preview_stills);
		}
		$va_medium_stills = $t_occurrence->get('ca_occurrences.ic_stills.ic_stills_media', array('version' => "medium", "showMediaInfo" => false, "returnAsArray" => true));
		if(sizeof($va_medium_stills) > 0){
			$vs_medium_still = array_shift($va_medium_stills);
		}
		print "<div class='setInfo'>";
		$va_item = $va_first_items_from_sets[$vn_set_id][array_shift(array_keys($va_first_items_from_sets[$vn_set_id]))];
		print "<div class='setImage'>".caNavLink($this->request, $vs_preview_still, '', 'clir2', $this->request->getController(), 'displaySet', array('set_id' => $vn_set_id))."</div><!-- end setImage -->";
		print "<div class='setTitle'>".caNavLink($this->request, (strlen($va_set_info["name"]) > 60 ? substr($va_set_info["name"], 0, 60)."..." : $va_set_info["name"]), '', 'clir2', $this->request->getController(), 'displaySet', array('set_id' => $vn_set_id))."</div>";
		$vs_set_text = "";
		if(isset($va_set_descriptions[$vn_set_id]) && $va_set_descriptions[$vn_set_id]){
			$vs_set_text = $va_set_descriptions[$vn_set_id][0]; // is array because fields could (but usually don't) repeat - just grab the first desc
			if(strlen(utf8_decode($vs_set_text)) > 150){
				$vs_set_text = substr($vs_set_text, 0, 147)."...";
			}
			print "<div class='setText'>".$vs_set_text."</div>";	
		}
		print "<div class='setMoreLink'>".caNavLink($this->request, _t('More'), '', 'clir2', $this->request->getController(), 'displaySet', array('set_id' => $vn_set_id))." &rsaquo;</div>";
		print "<div style='clear:left; height:1px;'><!-- empty --></div><!-- end clear --></div><!-- end setInfo -->";
	}
?>
</div>
