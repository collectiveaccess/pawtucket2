<?php
/* ----------------------------------------------------------------------
 * default/views/mailTemplates/contact.tpl
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2009-2014 Whirl-i-Gig
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

print _t("You have been sent an Image Licensing / Reproduction Request from %1, %2.", $this->request->config->get("app_display_name"), $this->request->config->get("site_host"))."\n\n";
$va_fields = $this->getVar("licensing_form_elements");
foreach($va_fields as $vs_element => $va_options){
	if(!in_array($vs_element, array("itemTitle", "itemId")) && $this->request->getParameter($vs_element, pString)){
		print $va_options["label"].": ".$this->request->getParameter($vs_element, pString)."\n\n";
	}
}


$va_object_information = $this->getVar("object_information");
$vs_site_host = $this->request->config->get("site_host");
	
print _t("You have been sent an Image Licensing / Reproduction Request from \"%1\", %2.", $this->request->config->get("app_display_name"), $this->request->config->get("site_host"))."\n\n";
$va_fields = $this->getVar("licensing_form_elements");
foreach($va_fields as $vs_element => $va_options){
	if($this->request->getParameter($vs_element, pString)){
		print $va_options["label"].": ".$this->request->getParameter($vs_element, pString)."\n\n";
	}
}

	if(is_array($va_object_information) && sizeof($va_object_information)){
?>
		Items\n\n
<?php
		foreach($va_object_information as $vn_object_id => $va_item_info){
			print "Item:";
			$vs_url = $vs_site_host.caNavUrl($this->request, "Detail", "objects", $vn_object_id);
			print $va_item_info["idno"].": ".$va_item_info["title"];
			print "\n\nURL: ".$vs_url;
			foreach($va_item_info["fields"] as $va_field){
				print '\n\n'.$va_field['label'].': '.$va_field['value']; 
			}
		}
	}
?>