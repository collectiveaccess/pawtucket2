<?php
/** ---------------------------------------------------------------------
 * themes/default/Transcribe/set_detail_item_html.php :
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2015 Whirl-i-Gig
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
 
	$t_item = $this->getVar('item');
	$t_rep = $this->getVar('representation');
	$t_transcription = $this->getVar('transcription'); //new ca_representation_transcriptions(); //::find(['representation_id' => $rep_id]);;
	
	$previous_id = $this->getVar('previousID');
	$next_id = $this->getVar('nextID');
	
	// TODO: move to controller
	$t_set = new ca_sets();
	$sets = $t_set->getSetsForItem($t_item->tableName(), $t_item->getPrimaryKey(), ['restrictToTypes' => 'transcription_collection']);
	$set_id = is_array($sets) ? array_shift(array_keys($sets)) : null;
	$set = is_array($sets) ? array_shift(caExtractValuesByUserLocale($sets)) : '';
	
	$va_access_values = caGetUserAccessValues($this->request);
?>
<div class="container textContent">
	<div class="row">
		<div class="col-sm-1">
			<div class="setsBack">
				<?php print $previous_id ? caNavLink($this->request, '<i class="fa fa-angle-left" aria-label="back"></i><div class="small">Previous</div>', '', '*', 'Transcribe', 'Item', ['id' => $previous_id]) : ''; ?>
				<?php print $set_id ? caNavLink($this->request, '<i class="fa fa-angle-double-left" aria-label="back"></i><div class="small">Back</div>', '', '*', 'Transcribe', 'Collection/'.$set_id) : ''; ?>
			</div>
		</div>
		<div class="col-sm-10">
			<h1><a href="/Transcribe/Index">Transcribe</a> &gt; <?php print is_array($set) ? caNavLink($this->request, $set['name'], '', '*', 'Transcribe', 'Collection/'.$set['set_id'])." &gt; " : ""; ?><?php print $t_item->get('ca_objects.preferred_labels.name'); ?></H1>
			<p >
				
				<h4><?php print caDetailLink($this->request, $t_item->get('ca_objects.preferred_labels.name')." (".$t_item->get('ca_objects.idno').")", '' ,$t_item->tableName(), $t_item->getPrimaryKey()); ?></h4>
				<h6><?php print $t_item->get("ca_entities", array("restrictToRelationshipTypes" => array("repository"), "returnAsLink" => true, "checkAccess" => $va_access_values));?></h6>
				<?php print $t_item->get('ca_objects.description'); ?>
			</p>
			<div style="clear:both; margin-top:10px;">

				<div class="row">
					<div class="col-sm-7">
						<?php 
							//print $t_rep->get('ca_object_representations.media.large'); 
							print array_shift(caRepresentationViewerHTMLBundles($this->request, caMakeSearchResult('ca_object_representations', [$t_rep->getPrimaryKey()]), $t_item, ['display' => 'transcribe']));
						?>
						
						<br/>
<?php
	if (is_array($reps = $t_item->getRepresentations(['versions' => 'icon'])) && (sizeof($reps) > 1)) {
		foreach($reps as $rep) {
			print caNavLink($this->request, $rep['tags']['icon'], '', '*', '*', 'item', ['id' => $t_item->getPrimaryKey(), 'representation_id' => $rep['representation_id']]);
		}
	}
?>
					</div>
					<div class="col-sm-5">
						<?php print caFormTag($this->request, 'SaveTranscription', 'transcript', null, 'post', 'multipart/form-data', '_top', ['disableUnsavedChangesWarning' => true]); ?>
							<div>
								Transcription 
<?php
	if ($start_date = $t_transcription->get('ca_representation_transcriptions.created_on')) {
		print " (Started {$start_date})";
	}
?>
							</div>

<?php
	if($t_transcription->isComplete()) {
?>
	 <?php print $t_transcription->get('transcription'); ?>
<?php
	} else {
?>
							<?php print caHTMLTextInput('transcription', ['value' => $t_transcription->get('transcription')], ['width' => '600px', 'height' => '400px']); ?>
					
							<?php print caHTMLHiddenInput('id', ['value' => $t_item->getPrimaryKey()]); ?>
							<?php print caHTMLHiddenInput('representation_id', ['value' => $t_rep->getPrimaryKey()]); ?>
							
							<button class='btn btn-lg btn-danger'>Save transcription</button>
							<?php print caHTMLCheckboxInput('complete', ['value' => 1]); ?> Complete?
<?php
	}
?>
						</form>
<?php
	if($t_transcription->isComplete()) {
?>
		This transcription was completed on <?php print $t_transcription->get('created_on'); ?>
<?php
	} else {
?>
						<div>
							<ul>
								<li>Remember to save often</li>
								<li>Copy the text as is, including misspellings and abbreviation</li>
								<li>No need to account for formatting - the goal is to provide text for searching and readability</li>
								<li>If you can't make out a word, enter "[illegible]"; if uncertain, indicate with square brackets, for example: "[town?]"</li>
								<li>Check completed when you finish the page</li>
								<li>View more <a href="/TranscriptionTips/Index" target="_new">transcription tips</a></li>
							</ul>
						</div>
<?php
	}
?>
					</div>
				</div>
			</div>
		</div>	
	<div class="col-sm-1">
		<div class="setsBack">
			<?php print $next_id ? caNavLink($this->request, '<i class="fa fa-angle-right" aria-label="back"></i><div class="small">Next</div>', '', '*', 'Transcribe', 'Item', ['id' => $next_id]) : ''; ?>
		</div>
	</div>
	</div>
</div>