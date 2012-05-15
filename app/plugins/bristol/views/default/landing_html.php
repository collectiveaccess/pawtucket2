<?php
/* ----------------------------------------------------------------------
 * app/plugins/bristol/landing_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2011 Whirl-i-Gig
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
	$va_set_descriptions			= $this->getVar('set_descriptions');
	$va_set_date					= $this->getVar('set_date');
	$va_set_creator					= $this->getVar('set_creator');	
?>
<div id="bristolLanding">
	
	
		<h1><?php print  (sizeof($va_set_list) == 1) ? _t("1 set is available") : _t("%1 sets are available", sizeof($va_set_list)); ?></h1>
<?php
	foreach($va_set_list as $vn_set_id => $va_set_info){

		print "<div class='setTitle'>".caNavLink($this->request, (strlen($va_set_info["name"]) > 80 ? substr($va_set_info["name"], 0, 80)."..." : $va_set_info["name"]), '', 'bristol', 'Show', 'displaySet', array('set_id' => $vn_set_id));
		print "<span class='setCount'> (".$va_set_info[item_count]." items)</span>";
?>
		<a href='#' id='<?php print $vn_set_id?>showSet' class='showSet' onclick='$("#<?php print $vn_set_id?>setInfo").slideDown(250); $("#<?php print $vn_set_id?>showSet").hide(); $("#<?php print $vn_set_id?>hideSet").show(); return false;'><img src="<?php print $this->request->getThemeUrlPath()?>/graphics/open_arrow.png" width="10" height="10" border="0"></a> 
		<a href='#' id='<?php print $vn_set_id?>hideSet' class='showSet' style="display:none;" onclick='$("#<?php print $vn_set_id?>setInfo").slideUp(250); $("#<?php print $vn_set_id?>hideSet").hide(); $("#<?php print $vn_set_id?>showSet").show(); return false;'><img src="<?php print $this->request->getThemeUrlPath()?>/graphics/close_arrow.png" width="10" height="10" border="0"></a>
		</div><!-- end setTitle -->
<?php
		$va_item = $va_first_items_from_sets[$vn_set_id][array_shift(array_keys($va_first_items_from_sets[$vn_set_id]))];
		print "<div id='".$vn_set_id."setInfo' class='setInfo' style='display:none;'>";
		print caNavLink($this->request, "<div class='setImage'>".$va_item["representation_tag"]."</div>", '', 'bristol', 'Show', 'displaySet', array('set_id' => $vn_set_id))."<!-- end setImage -->";
		if($va_set_creators = $va_set_creator[$vn_set_id][0]){
			print "<div><b>Creator: </b>".$va_set_creators."</div>";
		}		
		if($va_set_dates = $va_set_date[$vn_set_id][0]){
			print "<div><b>Creation Date: </b>".$va_set_dates."</div>";
		}
		$vs_set_text = "";
		if(isset($va_set_descriptions[$vn_set_id]) && $va_set_descriptions[$vn_set_id]){
			$vs_set_text = "<b>Description: </b>".$va_set_descriptions[$vn_set_id][0]; // is array because fields could (but usually don't) repeat - just grab the first desc
			if(strlen(utf8_decode($vs_set_text)) > 353){
				$vs_set_text = substr($vs_set_text, 0, 353)."...";
			}
		}
		print "<div>".$vs_set_text."</div>";
		
		print "<div style='clear:left; height:1px;'><!-- empty --></div><!-- end clear -->";
		print "<div class='setMoreLink'>".caNavLink($this->request, _t('View Set').'  &rsaquo;', '', 'bristol', 'Show', 'displaySet', array('set_id' => $vn_set_id))."</div></div><!-- end setInfo -->";
	}
?>

</div><!-- end bristolLanding -->
	