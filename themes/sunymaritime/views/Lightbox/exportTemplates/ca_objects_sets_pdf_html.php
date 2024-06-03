<?php
/* ----------------------------------------------------------------------
 * /views/Sets/exportTemplates/ca_objects_sets_pdf_html.php 
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
	$t_set = $this->getVar("t_set");
	$va_items = $this->getVar("items");
	$vs_title = $t_set->getLabelForDisplay();
	$vn_num_items = (int)sizeof($va_items);
	$vn_num_cols = 4;
?>
<HTML>
	<HEAD>
		<style type="text/css">
			<!--
			table { border: 1px solid #828282; color: #000000; text-wrap: normal; font-size: 11px; margin:15px; font-family: Helvetica, sans-serif;}
			table td { border: 1px solid #828282; color: #000000; text-wrap: normal; width: 135px; height: 120px; padding: 5px; font-size: 11px; font-family: Helvetica, sans-serif;}
			tr.odd   { background-color: #f2f2f2; }
			.pageHeader { background-color: #FFFFFF; margin: 0px 10px 20px 10px; padding: 0px 5px 20px 5px; width: 100%; height: 45px; font-family: Helvetica, sans-serif; }
			.pageHeader img{ vertical-align:middle;  }
			.headerText { text-align:right; color: #000; margin: -50px 0px 10px 20px; font-family: Helvetica, sans-serif; font-size: 11px; }
			-->
		</style>
	</HEAD>
	<BODY>
		<div class='pageHeader'>
<?php
			if(file_exists($this->request->getThemeDirectoryPath().'/assets/pawtucket/graphics/ca_nav_logo300.png')){
				print '<img src="'.$this->request->getThemeDirectoryPath().'/assets/pawtucket/graphics/ca_nav_logo300.png"/>';
 			}
 			print "<div class='headerText'>".caGetLocalizedDate(null, array('dateFormat' => 'delimited'))."<br/>".mb_substr($vs_title, 0, 30).((mb_strlen($vs_title) > 30) ? '...' : '').", ".(($vn_num_items == 1) ? _t('%1 item', $vn_num_items) : _t('%1 items', $vn_num_items))."</div>";
?>
		</div>

	<table width="100%" cellpadding="0" cellspacing="0">
<?php
		$i = 0;
		foreach($va_items as $va_item){
			$vn_object_id = $va_item['object_id'];
			if($i == 0){
				print "<tr>";
			}
			print "<td align='center'>";
			print ((file_exists(str_replace($this->request->config->get("site_host"), $this->request->config->get("ca_base_dir"), $va_item["representation_url_thumbnail"]))) ? $va_item["representation_tag_thumbnail"] : "");
			print "<br/>".$va_item["idno"]."<br/>";
			print $va_item["name"];
			print "</td>";
			$i++;	
			if($i == $vn_num_cols){
				print "</tr>";
				$i = 0;
			}
		}
		if($i < $vn_num_cols){
			while($i< $vn_num_cols){
				print "<td></td>";
				$i++;
			}
			print "</tr>";
		}
?>

	</table>
	</BODY>
</HTML>