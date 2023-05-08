<?php
/* ----------------------------------------------------------------------
 * themes/default/views/Gallery/set_detail_timeline_html.php :
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
 * ----------------------------------------------------------------------
 */
 	
	AssetLoadManager::register('timeline');
	$t_set = $this->getVar("set");
?>
	<div id="lbTimelineContainer">
		<div id="timeline-embed"></div>
	</div>
	
	<div style="clear:both;"><!-- empty --></div>
	
    <script type="text/javascript">
		jQuery(document).ready(function() {
			createStoryJS({
				type:       'timeline',
				width:      '100%',
				height:     '100%',
				source:     '<?php print caNavUrl($this->request, '', '*', 'getSetInfoAsJSON', array('mode' => 'timeline', 'set_id' => $t_set->get("set_id"))); ?>',
				embed_id:   'timeline-embed'
			});
		});
	</script>