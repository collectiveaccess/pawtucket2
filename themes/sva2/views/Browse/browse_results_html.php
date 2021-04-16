<?php
/* ----------------------------------------------------------------------
 * views/Browse/browse_results_html.php :
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2021 Whirl-i-Gig
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
?>

<div class="container-fluid faceted-browse-container">
    <div id="facetedBrowse"></div>
</div>

<script type="text/javascript">
	pawtucketUIApps['FacetedBrowse'] = {
        'selector': '#facetedBrowse',
        'data': {
			baseUrl: "<?php print __CA_URL_ROOT__."/index.php/Browse"; ?>",
			serviceUrl: "http://sva.whirl-i-gig.com:8085/service.php/Browse",
			view: "<?php print caGetOption('defaultView', $browse_info, 'images'); ?>"
        }
    };
</script>
