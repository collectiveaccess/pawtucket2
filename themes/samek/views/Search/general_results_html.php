<?php
/* ----------------------------------------------------------------------
 * views/Search/general_results_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2024 Whirl-i-Gig
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
$results = $this->getVar('results');
$result_count = $results['_info_']['totalCount'] ?? 0;

if ($result_count > 0) {
?>
	<h1><?= _t("Search results for %1", caUcFirstUTF8Safe($this->getVar('searchForDisplay'))); ?></h1>
<?php
	// 
	// Print out block content (results for each type of search)
	//
	foreach($this->getVar('blockNames') as $block) {
?>
		<div id="<?= $block; ?>Block" class='resultBlock'>
			<?= $results[$block]['html']; ?>
		</div>
<?php
	} 
} else {
	print "<H1>"._t("Your search for %1 returned no results", caUcFirstUTF8Safe($this->getVar('search')))."</H1>";
}
