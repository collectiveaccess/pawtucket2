<?php
/** ---------------------------------------------------------------------
 * themes/default/views/Compare/manifest_json.php :
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2016 Whirl-i-Gig
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
 * @package CollectiveAccess
 * @subpackage Media
 * @license http://www.gnu.org/copyleft/gpl.html GNU Public License version 3
 *
 * ----------------------------------------------------------------------
 */
 
 	$pn_id		 			= $this->getVar('id');
 	$t_subject 				= $this->getVar('t_subject');
 	$vs_table				= $t_subject->tableName();
 	
 	$va_representations 	= $this->getVar('representations');
 	
 	$va_compare_config = $this->request->config->get('compare_images');
 	if (!is_array($va_compare_config = $va_compare_config[$vs_table])) { $va_compare_config = []; }
?>
{
  "@context": "http://iiif.io/api/presentation/2/context.json", 
  "@id": "object_<?php print $pn_id ?>_manifest", 
  "@type": "sc:Manifest", 
  "attribution": "", 
  "description": "", 
  "label": <?php print json_encode($vs_label = $t_subject->getWithTemplate(caGetOption('title_template', $va_compare_config, "^{$vs_table}.preferred_labels"))); ?>, 
  "license": "", 
  "logo": "", 
  "sequences": [
    {
      "@id": "object_<?php print $pn_id; ?>", 
      "@type": "sc:Sequence", 
      "canvases": [
<?php
	$va_canvases = [];
	foreach($va_representations as $vn_representation_id => $va_representation_info) {
		$vn_width = $va_representation_info['info']['original']['WIDTH'];
		$vn_height = $va_representation_info['info']['original']['HEIGHT'];
		
		$va_canvases[] = "			{
			  \"@id\": \"representation_{$vn_representation_id}_canvas\", 
			  \"@type\": \"sc:Canvas\", 
			  \"height\": {$vn_width}, 
			  \"images\": [
				{
				  \"@type\": \"oa:Annotation\", 
				  \"motivation\": \"sc:painting\", 
				  \"on\": \"representation_{$vn_representation_id}_canvas\", 
				  \"resource\": {
					\"@id\": \"representation_{$vn_representation_id}_res\", 
					\"@type\": \"dctypes:Image\", 
					\"format\": \"image/jpg\", 
					\"height\": {$vn_height}, 
					\"service\": {
					  \"@context\": \"http://library.stanford.edu/iiif/image-api/1.1/context.json\", 
					  \"@id\": \"/service.php/IIIF/representation:{$vn_representation_id}\", 
					  \"profile\": \"http://library.stanford.edu/iiif/image-api/1.1/compliance.html#level2\"
					}, 
					\"width\": {$vn_width}
				  }
				}
			  ], 
			  \"label\": ".json_encode($vs_label).", 
			  \"width\": {$vn_height}
			}";
	}
	print join(",", $va_canvases);
?>
    ]
   }
  ], 
  "viewingHint": "paged"
}