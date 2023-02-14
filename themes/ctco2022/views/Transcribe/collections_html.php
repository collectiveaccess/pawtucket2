<?php
/** ---------------------------------------------------------------------
 * themes/newvamuse/Transcribe/collections_html.php :
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
 
 	$qr_sets = $this->getVar('sets');
 	$set_media = $this->getVar('set_media');
?>
<div class="transcription container textContent">
	<div class="row">
		<div class="col-sm-12 col-md-8 col-md-offset-2">
			<h1><?php print caNavLink($this->request, 'Transcribe', '', '', 'Transcribe', "Index"); ?> &gt; All Collections</H1>
			<div class="transcribeIntro">{{{transcribe_collections_list_intro}}}</div>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12 col-md-8 col-md-offset-2">
			<div class="row">
<?php
						while($qr_sets->nextHit()) {
							$set_id = $qr_sets->get('ca_sets.set_id');
							if(!isset($set_media[$set_id])) { continue; }
							$item = array_shift($set_media[$set_id]);
?>
			<div class="col-sm-3">
				<div class="collectionTile">
					<div class="collectionImageCrop hovereffect"><?php print caNavLink($this->request, $item['representation_tag'].'<div class="overlay">'.$qr_sets->get('ca_sets.preferred_labels.name').'</div>', '', '', 'Transcribe', "Collection/{$set_id}"); ?></div>
				</div>
			</div>
<?php
						}
?>
			</div>
		</div>
	</div>
</div>