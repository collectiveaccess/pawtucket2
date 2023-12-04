<?php
/* ----------------------------------------------------------------------
 * default/views/mailTemplates/image_licensing_html.tpl
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2009-2010 Whirl-i-Gig
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
 
$va_object_information = $this->getVar("object_information");
$vs_site_host = $this->request->config->get("site_host");
	
print "<p>"._t("You have been sent an Image Licensing / Reproduction Request from %1, %2.", $this->request->config->get("app_display_name"), $this->request->config->get("site_host"))."</p>";
$va_fields = $this->getVar("licensing_form_elements");
foreach($va_fields as $vs_element => $va_options){
	if(!in_array($vs_element, array("itemTitle", "itemId")) && $this->request->getParameter($vs_element, pString)){
		print "<p><b>".$va_options["label"].":</b> ".$this->request->getParameter($vs_element, pString)."</p>";
	}
}

	if(is_array($va_object_information) && sizeof($va_object_information)){
?>
		<H2>Items</H2><hr/>
<?php
		foreach($va_object_information as $vn_object_id => $va_item_info){
			print "<p><b>Item:</b>";
			$vs_url = $vs_site_host.caNavUrl($this->request, "Detail", "objects", $vn_object_id);
			print "<a href='".$vs_url."'>".$va_item_info["idno"].": ".$va_item_info["title"]."</a>";
			print "<br/><b>URL</b>: <a href='".$vs_url."'>".$vs_url."</a>";
			foreach($va_item_info["fields"] as $va_field){
				print '<br/><b>'.$va_field['label'].'</b>: '.$va_field['value']; 
			}
			print "</p>";
		}
	}
?>