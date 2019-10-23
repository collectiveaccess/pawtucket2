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

	$action = preg_replace("![^A-Za-z0-9_]+!", "", $this->request->getAction());
	
	$initial_criteria = [];
	if($search = $this->request->getParameter('search', pString)) {
	    $initial_criteria['_search'] = [$search => $search];
	}
	if($this->request->getParameter('facet', pString) == 'collection_facet') {
	    $collection_facet_id = $this->request->getParameter('id', pInteger);
	    $t_coll = new ca_collections($collection_facet_id);
	    if($t_coll->isLoaded() && ($t_coll->get('access') == 1)) {
	        $initial_criteria['collection_facet'] = [$collection_facet_id => $t_coll->get('ca_collections.preferred_labels.name')];
	    }
	}
	if($this->request->getParameter('facet', pString) == 'has_media_facet') {
	    $has_media_value = $this->request->getParameter('id', pInteger);
	    $initial_criteria['has_media_facet'] = [$has_media_value => 'Has media'];
	}
?>

<div id="browse"></div>
<script type="text/javascript">
	pawtucketUIApps['Noguchi<?php print ucfirst(strToLower($action)); ?>Browse'] = {
        'selector': '#browse',
        'data': {
			baseUrl: "<?php print __CA_URL_ROOT__."/index.php/Browse"; ?>",
			endpoint: "<?php print $action; ?>",
			initialFilters: <?php print json_encode($initial_criteria); ?>,
			view: "thumbnails"
        }
    };
</script>
