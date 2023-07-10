<?php
/* ----------------------------------------------------------------------
 * views/Browse/browse_results_html.php :
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2019-2020 Whirl-i-Gig
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
	$export_formats = $this->getVar('export_formats');
	$config = $this->getVar('config');
	
	if(!($set_id = $this->request->getParameter('set_id', pInteger))) { $set_id = null; }
?>

<div id="lightbox"></div>

<script type="text/javascript">
	pawtucketUIApps['Lightbox'] = {
        'selector': '#lightbox',
		'key': '<?= $this->getVar('key'); ?>', 
        'data': {
			baseUrl: "<?= __CA_URL_ROOT__."/service.php"; ?>",
			siteBaseUrl: "<?= __CA_URL_ROOT__."/index.php"; ?>/Lightbox",
			
            <?= $set_id ? "showLastLightboxOnLoad: {$set_id}," : ""; ?>
			view: "thumbnails",
			browseConfig: <?= json_encode($config->get("lightboxBrowse")); ?>,
			exportFormats: <?= json_encode($export_formats); ?>,
			lightboxTerminology: <?= json_encode(caGetLightboxDisplayName()); ?>
        }
    };
</script>