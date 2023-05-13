<?php
/* ----------------------------------------------------------------------
 * views/Browse/browse_results_html.php :
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2019 Whirl-i-Gig
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

	$initial_criteria = [];
	if ($search = $this->request->getParameter('search', pString)) {
	    $initial_criteria['_search'] = [$search => $search];
	}
	if(($facet = $this->request->getParameter('facet', pString)) && $facet_id = $this->request->getParameter('id', pInteger)) {
		$initial_criteria[$facet] = [$facet_id => $facet_id];
	}
	$action = $this->request->getAction();
	$browse_info = $this->getVar('browseInfo');
	$export_formats = $this->getVar('export_formats');
?>

<div id="browse"></div>

<script type="text/javascript">
	pawtucketUIApps['PawtucketBrowse'] = {
        'selector': '#browse',
        'data': {
			baseUrl: "<?php print __CA_URL_ROOT__."/index.php/Browse"; ?>",
			baseLightboxUrl: "<?php print __CA_URL_ROOT__."/index.php/Lightbox"; ?>",
			endpoint: "<?php print $action; ?>",
			initialFilters: <?php print json_encode($initial_criteria); ?>,
			view: "<?php print caGetOption('defaultView', $browse_info, 'images'); ?>",
			browseConfig: <?php print json_encode($browse_info); ?>,
			exportFormats: <?php print json_encode($export_formats); ?>,
			lightboxTerminology: <?php print json_encode(caGetLightboxDisplayName()); ?>,
			isLoggedIn: <?php print ($this->request->isLoggedIn()) ? 1 : 0; ?>
        }
    };
</script>
