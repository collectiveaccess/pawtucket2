<?php
/** ---------------------------------------------------------------------
 * themes/default/views/Compare/manifest_json.php :
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2016-2018 Whirl-i-Gig
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
 
 	$ps_id		 			= $this->getVar('id');
 	$ps_id_proc             = preg_replace("![^A-Za-z0-9_]+!", "_", $ps_id);
 	$pa_info 				= $this->getVar('info');
 	
 	$va_compare_config      = $this->request->config->get('compare_images');
 	if (!is_array($va_compare_config = $va_compare_config[$pa_info['subject']])) { $va_compare_config = []; }
?>
{
  "@context": "http://iiif.io/api/presentation/2/context.json", 
  "@id": "<?php print $ps_id_proc ?>_manifest", 
  "@type": "sc:Manifest", 
  "attribution": "", 
  "description": "", 
  "label": <?php print json_encode(strip_tags($pa_info['display'])); ?>, 
  "license": "", 
  "logo": "", 
  "sequences": [
    {
      "@id": "<?php print $ps_id_proc; ?>", 
      "@type": "sc:Sequence", 
      "canvases": [
<?php
	$va_canvases = [];
    $vn_width = $vn_height = 500; 
    
    $va_canvases[] = "			{
          \"@id\": \"{$ps_id_proc}_canvas\", 
          \"@type\": \"sc:Canvas\", 
          \"height\": {$vn_height}, 
          \"images\": [
            {
              \"@type\": \"oa:Annotation\", 
              \"motivation\": \"sc:painting\", 
              \"on\": \"{$ps_id_proc}_canvas\", 
              \"resource\": {
                \"@id\": \"{$ps_id_proc}_res\", 
                \"@type\": \"dctypes:Image\", 
                \"format\": \"image/jpg\", 
                \"height\": {$vn_height}, 
                \"service\": {
                  \"@context\": \"http://library.stanford.edu/iiif/image-api/1.1/context.json\", 
                  \"@id\": \"/service.php/IIIF/{$ps_id}\", 
                  \"profile\": \"http://library.stanford.edu/iiif/image-api/1.1/compliance.html#level2\"
                }, 
                \"width\": {$vn_width}
              }
            }
          ], 
          \"label\": ".json_encode($pa_info['display']).", 
          \"width\": {$vn_width}
        }";
        
	print join(",", $va_canvases);
?>
    ]
   }
  ], 
  "viewingHint": "paged"
}