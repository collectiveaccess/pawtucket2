<?php
/** ---------------------------------------------------------------------
 * themes/newvamuse/Transcribe/collection_html.php :
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
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
 * @package CollectiveAccess
 * @subpackage theme/default
 * @license http://www.gnu.org/copyleft/gpl.html GNU Public License version 3
 *
 * ----------------------------------------------------------------------
 */
 	$t_set = $this->getVar('set');
 	$items = $this->getVar('items');	
 
?>
<div class="container textContent">
	<div class="row">
		<div class="col-sm-10 col-sm-offset-1">
			<h1>Collection: <?php print $t_set->get('ca_sets.preferred_labels.name'); ?></H1>
			<p style='padding-bottom:15px;'>
				<?php print $t_set->get('ca_sets.set_description'); ?>
			</p>
			<div style="clear:both; margin-top:10px;">

			</div>
			<div class="row">
<?php
	foreach($items as $item) {
		$item = array_shift($item);
		print "<div class='col-xs-6 col-sm-4 col-md-3 col-lg-3 lbItem{$item['object_id']}'><div class='lbItemContainer'>";
		print caNavLink($this->request, $item['representation_tag_small']."<br/>".$item['name'], '', '*', 'Transcribe', 'Item', ['id' => $item['object_id']]);
		print "</div></div>\n";
	}
?>
			</div>
		</div>	
	</div>
</div>