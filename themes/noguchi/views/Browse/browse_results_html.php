<?php
/* ----------------------------------------------------------------------
 * views/Browse/browse_results_html.php :
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2014 Whirl-i-Gig
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

	// TODO: move this out of view
	$action = preg_replace("![^A-Za-z0-9_]+!", "", $this->request->getAction());
	$params = $this->request->getParameters();

	$initial_criteria = null;
	if(isset($params['facet'])) {
		$initial_criteria[$params['facet']] = [$params['id'] => ($params['facet'] === 'collection_facet') ? $collection_title : ""];
	}
	switch(strToLower($action)){
		case "bibliography":
			$desc = $this->getVar('bibliographyIntro');
		break;
		# --------------------------------
		case "archive":
			// Get info for collection
			$collection_title = $desc = null;
			require_once(__CA_MODELS_DIR__."/ca_collections.php");
			if ($this->request->getParameter('facet', pString) === 'collection_facet') {
				$t_collection = new ca_collections($id = $this->request->getParameter('id', pInteger));
				if ($t_collection->isLoaded() && ($t_collection->get('access') > 0)) {
					$collection_title = $t_collection->get('ca_collections.preferred_labels.name');
					$desc = $t_collection->get('ca_collections.scopecontent');
				}
			}
		break;
		# --------------------------------
	}
?>

<div id="browse"></div>
<script type="text/javascript">
	pawtucketUIApps['Noguchi<?php print ucfirst(strToLower($action)); ?>Browse'] = {
        'selector': '#browse',
        'data': {
            title: <?php print json_encode($collection_title); ?>,
			description: <?php print json_encode($desc); ?>,
			baseUrl: "<?php print __CA_URL_ROOT__."/index.php/Browse"; ?>",
			endpoint: "<?php print $action; ?>",
			initialFilters: <?php print json_encode($initial_criteria); ?>
        }
    };
</script>
