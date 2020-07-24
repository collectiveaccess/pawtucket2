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
 	
	$t_set = $this->getVar("set");
?>
	<div class="row">
		<div class="col-sm-12">
			<H1><?php print $this->getVar("section_name"); ?>: <?php print $this->getVar("label")."</H1>"; ?>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">

			<!-- The StoryMap container can go anywhere on the page. Be sure to
				specify a width and height.  The width can be absolute (in pixels) or
				relative (in percentage), but the height must be an absolute value.
				Of course, you can specify width and height with CSS instead -->
			<div id="mapdiv" style="width: 100%; height: 600px;"></div>
		</div>
	</div>
	<div style="clear:both;"><!-- empty --></div>

<!-- Your script tags should be placed before the closing body tag. -->
<link rel="stylesheet" href="https://cdn.knightlab.com/libs/storymapjs/latest/css/storymap.css">
<script type="text/javascript" src="https://cdn.knightlab.com/libs/storymapjs/latest/js/storymap-min.js"></script>

<script>
// storymap_data can be an URL or a Javascript object
//var storymap_data = '//media.knightlab.com/StoryMapJS/demo/demo.json';
var storymap_data = '<?php print $this->request->config->get("site_host").caNavUrl($this->request, '', '*', 'getSetInfoAsJSON', array('mode' => 'storymap', 'set_id' => $t_set->get("set_id"))); ?>';

// certain settings must be passed within a separate options object
var storymap_options = {};

var storymap = new VCO.StoryMap('mapdiv', storymap_data, storymap_options);
window.onresize = function(event) {
    storymap.updateDisplay(); // this isn't automatic
}
</script>