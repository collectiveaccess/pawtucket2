<?php
/** ---------------------------------------------------------------------
 * themes/default/Lightbox/set_list_html.php :
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2015-2024 Whirl-i-Gig
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
$t_set 								= new ca_sets();
$write_sets 						= $this->getVar("write_sets");
$read_sets 							= $this->getVar("read_sets");
$set_ids 							= $this->getVar("set_ids");
$access_values 						= $this->getVar("access_values");
$lightbox_displayname_singular 		= $this->getVar("lightbox_displayname_singular");
$lightbox_displayname_plural 		= $this->getVar("lightbox_displayname_plural");
$o_lightbox_config 					= $this->getVar("set_config");
$current_sort 						= $this->getVar('sort');
$current_sort_dir 					= $this->getVar('direction');

$qr_sets = $this->getVar('qr_sets');

?>
<h1>
	<?= ucfirst($lightbox_displayname_plural); ?>
</h1>
<div id="browseResultsContainer">
	<div class="row">
<?php
	if(!$qr_sets) {
?>
		<div class='col-md-12 col-lg-12 d-flex'>
			<?= _t('No lightboxes available'); ?>
		</div>	
<?php
	} else {
		while($qr_sets->nextHit()) {
			$table = $qr_sets->get('table_num');
			$caption = $qr_sets->get('ca_sets.preferred_labels.name');
?>
			<div class='col-md-6 col-lg-4 d-flex'>
				<div id='row{$vn_id}' class='card flex-grow-1 width-100 rounded-0 shadow border-0 mb-4'>
				  <?= caGetLightboxPreviewImage($qr_sets->getPrimaryKey(), $qr_sets, ['checkAccess' => $access_values]); ?>
				  	<div class='card-body'>
						<?= $caption; ?>
					</div>
					<div class='card-footer text-end bg-transparent'>
						<?= $detail_link; ?>
					</div>
				 </div>	
			</div><!-- end col -->
<?php
		}
	}
?>
	</div>
</div>
