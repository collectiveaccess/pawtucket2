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
		<div class="col-sm-10 col-sm-offset-1">
			<h1><a href="/Transcribe/Index">Transcribe</a> &gt; All Collections</H1>
			<p>
				Transcribe gives you the opportunity to make our collections more accessible. The transcriptions you create will become 
				searchable data, facilitating learning and research around the world. Whether you choose to transcribe one page, 
				one hundred pages, or just browse our collections, you’re helping us share the stories that matter. 
			</p>
			<p>
				Please read our <a href="/TranscriptionTips/Index">transcription tips</a> page for suggestions on how to get started.
			</p>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-10 col-sm-offset-1">
			<div class="row">
<?php
						while($qr_sets->nextHit()) {
							$set_id = $qr_sets->get('ca_sets.set_id');
							if(!isset($set_media[$set_id])) { continue; }
							$item = array_shift($set_media[$set_id]);
?>
			<div class="col-sm-3 collectionTile">
				<div class="collectionImageCrop hovereffect"><?php print caNavLink($this->request, $item['representation_tag'], '', '', 'Transcribe', "Collection/{$set_id}"); ?>
				<div class="overlay"><h2><?php print caNavLink($this->request, $qr_sets->get('ca_sets.preferred_labels.name'), '', '', 'Transcribe', "Collection/{$set_id}"); ?></h2></div>
				</div>
			</div>
<?php
						}
?>
			</div>
		</div>
	</div>
</div>