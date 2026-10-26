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
 	$set_id = $t_set->getPrimaryKey();
 	
	$previous_id = $this->getVar('previousID');
	$next_id = $this->getVar('nextID');
	
	$transcription_status = $this->getVar('transcriptionStatus');
?>
<div class="transcription container textContent">
	<div class="row">
		<div class="col-sm-1">
			<div class="setsBack">
				<?php print $previous_id ? caNavLink($this->request, '<i class="fa fa-angle-left" aria-label="back"></i><div class="small">'._t('Previous').'</div>', '', '*', 'Transcribe', 'Collection/'.$previous_id) : ''; ?>
				<?php print caNavLink($this->request, '<i class="fa fa-angle-double-left" aria-label="back"></i><div class="small">'._t('Back').'</div>', '', '*', 'Transcribe', 'Collections'); ?>
			</div>
		</div>
		<div class="col-sm-10">
			
			<h1><a href="/Transcribe/Index"><?= _t('Transcribe'); ?></a> &gt; <?= _t('Collection'); ?>: <?php print $t_set->get('ca_sets.preferred_labels.name'); ?></H1>
			<p style='padding-bottom:15px;'>
				<?php print $t_set->get('ca_sets.set_description'); ?>
			</p>
			<div class="row">
<?php
	
			foreach($items as $item) {
				$status_info = caGetTranscriptionStatusInfo($transcription_status, 'items', $item['object_id']);
?>
				<div class='col-sm-3 collectionTile'>
					<div class='collectionImageCrop hovereffect'>
						<?php print caNavLink($this->request, $item['representation_tag_medium']."<div class='overlay'><h2>{$item['name']}</h2></div>", '', '*', 'Transcribe', 'Item', ['id' => $item['object_id']]); ?>
					</div>
					
					<?php print caNavLink($this->request, $status_info['status'], "btn btn-sm btn-{$status_info['color']}", '*', 'Transcribe', 'Item', ['id' => $item['object_id']]); ?>
				</div>
<?php
	}
?>
			</div>
		</div>
		<div class="col-sm-1">
			<div class="setsBack">
				<?php print $next_id ? caNavLink($this->request, '<i class="fa fa-angle-right" aria-label="back"></i><div class="small">Next</div>', '', '*', 'Transcribe', 'Collection/'.$next_id) : ''; ?>
			</div>
		</div>	
	</div>
</div>