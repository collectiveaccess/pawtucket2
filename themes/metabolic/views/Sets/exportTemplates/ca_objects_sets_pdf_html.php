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
	
	$vn_num_items_per_page = 6;
	
?>
<style type="text/css">
<!--
/* commentaire dans un css */
table { border: 1px solid #999999; color: #000000; text-wrap: normal; font-size: 11px; margin:15px;}
table td { border: 1px solid #999999; color: #000000; text-wrap: normal; width: 120px; padding:10px; font-size: 11px; text-align:center;}
.imageTable{ margin:0px; padding:0px; width:120px; height:120px; border:1px solid #FFF;}
.imageTable td{vertical-align:middle; text-align:center; margin:0px; padding:0px; height:120px; width:120px; border:0px; padding:0px 5px 0px 5px;}
.imageCaptionTable{background-color:#EDEDED; border: 1px solid #DEDEDE; margin:10px 0px 0px 0px; width:120px;}
.imageCaptionTable td{ border:0px; padding:5px; margin:0px; text-align:center; color: #000000; text-wrap: normal; font-size: 11px; width:120px;}

.displayHeader { background-color: #EEEEEE; padding: 5px; border: 1px solid #999999; font-size: 12px; }
.pageHeader { background-color: #FFFFFF; margin: 5px 10px 10px 10px; padding: 3px 5px 2px 5px; width: 100%; height: 45px; }
.pageHeader img{ vertical-align:middle; }
.headerText { color: #000; margin: 0px 0px 10px 15px; }
.pagingText { color: #000; margin: 0px 0px 10px 15px; text-align: right; }
-->
</style>

	<page backtop="50px">
	<page_header>
		<div class='pageHeader'>
<?php
			if(file_exists($this->request->getThemeDirectoryPath().'/graphics/metabolic_logo.png')){
				print '<img src="'.$this->request->getThemeDirectoryPath().'/graphics/metabolic_logo.png"/>';
 			}
			print "<span class='headerText'>".caGetLocalizedDate(null, array('dateFormat' => 'delimited'))."</span>";
			print "<span class='headerText'>".(($vn_num_items == 1) ? _t('%1 item', $vn_num_items) : _t('%1 items', $vn_num_items))."</span>";
			print "<span class='headerText'>".mb_substr($vs_title, 0, 15).((mb_strlen($vs_title) > 15) ? '...' : '')."</span>";
			print "<span class='pagingText'>"._t("page [%1]/[%2]", "[page_cu]", "[page_nb]")."</span>";
?>
		</div>
	</page_header>

	<table width="100%" cellpadding="0" cellspacing="0">
<?php
		$i = 1;
		$t_object = new ca_objects();
		foreach($va_items as $va_item){
			$vn_object_id = $va_item['object_id'];
			$t_object->load($vn_object_id);
			$t_rep = $t_object->getPrimaryRepresentationInstance();
			if($i == 1){
				print "<tr>";
			}
			print "<td><table class='imageTable' cellpadding='0' cellspacing='0'><tr><td>";
			print "<img src='".$t_rep->getMediaUrl("media", "medium")."' width='".$va_item["representation_width_thumbnail"]."' height='".$va_item["representation_height_thumbnail"]."' border='0'>";
			print "</td></tr></table>";
			#print "<td><table class='imageTable' cellpadding='0' cellspacing='0'><tr><td>".((file_exists(str_replace($this->request->config->get("site_host"), $this->request->config->get("ca_base_dir"), $va_item["representation_url_thumbnail"]))) ? $va_item["representation_tag_thumbnail"] : "")."</td></tr></table>";
			print "<table class='imageCaptionTable' cellpadding='0' cellspacing='0'><tr><td>".$va_item["idno"]."<br/>".$t_object->get("ca_collections.preferred_labels", array("delimiter" => "; "))."</td></tr></table></td>";
			if($i == 4){
				print "</tr>";
				$i = 0;
			}
			$i++;
		}
		if(($i <= 4) && ($i > 1)){
			while($i <= 4){
				print "<td></td>";
				$i++;
			}
			print "</tr>";
		}
?>

	</table>
	</page>