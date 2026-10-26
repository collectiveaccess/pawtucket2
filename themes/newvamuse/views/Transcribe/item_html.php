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
$representation_id = $t_rep->getPrimaryKey();

$transcription = $this->getVar('transcription'); 

$previous_id = $this->getVar('previousID');
$next_id = $this->getVar('nextID');

$access_values = caGetUserAccessValues($this->request);

$set = $this->getVar('set');
?>
<div class="transcription container textContent">
	<div class="row">
		<div class="col-sm-1">
			<div class="setsBack">
				<?php print $previous_id ? caNavLink($this->request, '<i class="fa fa-angle-left" aria-label="back"></i><div class="small">'._t('Previous').'</div>', '', '*', 'Transcribe', 'Item', ['id' => $previous_id]) : ''; ?>
				<?php print $set['set_id'] ? caNavLink($this->request, '<i class="fa fa-angle-double-left" aria-label="back"></i><div class="small">'._t('Back').'</div>', '', '*', 'Transcribe', 'Collection/'.$set['set_id']) : ''; ?>
			</div>
		</div>
		<div class="col-sm-10">
			<h1><a href="/Transcribe/Index"><?= _t('Transcribe'); ?></a> &gt; <?php print is_array($set) ? caNavLink($this->request, $set['name'], '', '*', 'Transcribe', 'Collection/'.$set['set_id'])." &gt; " : ""; ?><?php print $t_item->get('ca_objects.preferred_labels.name'); ?></H1>
			<p >
				
				<h4><?php print caDetailLink($this->request, $t_item->get('ca_objects.preferred_labels.name')." (".$t_item->get('ca_objects.idno').")", '' ,$t_item->tableName(), $t_item->getPrimaryKey()); ?></h4>
				<h6><?php print $t_item->get("ca_entities", array("restrictToRelationshipTypes" => array("repository"), "returnAsLink" => true, "checkAccess" => $access_values));?></h6>
				<?php print $t_item->get('ca_objects.description'); ?>
			</p>
			<div style="clear:both; margin-top:10px;">

				<div class="row">
					<div class="col-sm-7">
						<?php 
							print array_shift(caRepresentationViewerHTMLBundles($this->request, caMakeSearchResult('ca_object_representations', [$representation_id]), $t_item, ['display' => 'transcribe']));
						?>
						
						
<?php
	if (is_array($reps = $t_item->getRepresentations(['versions' => 'icon'], null, ['checkAccess' => $access_values])) && ($reps = array_filter($reps, function($v) { return $v['is_transcribable']; })) &&  (sizeof($reps) > 1)) {
?>
		<div class='otherRepresentations'>
			<div class="unit">
				<span class="name"><?= _t('Additional pages'); ?>:</span>
				<span class="data">
					<br/>
<?php
		foreach($reps as $rep) {
			if($rep['representation_id'] == $representation_id) {
				print "<a href='#' class='otherRepresentation selected'>{$rep['tags']['icon']}</a>";
			} else {
				print caNavLink($this->request, $rep['tags']['icon'], 'otherRepresentation', '*', '*', 'item', ['id' => $t_item->getPrimaryKey(), 'representation_id' => $rep['representation_id']]);
			}
		}
?>
				</span>
			</div>
		</div>
<?php
	}
?>
					</div>
					<div class="col-sm-5">
						<?php print caFormTag($this->request, 'SaveTranscription', 'transcript', null, 'post', 'multipart/form-data', '_top', ['disableUnsavedChangesWarning' => true]); ?>
							<div class="unit">
								<span class="name"><?= _t('Transcription'); ?>: </span>

<?php
	if($transcription->isComplete()) {
?>
	<div class='completedText'> 
		<?php print $transcription->get('transcription'); ?>
		
		<div class='saveControls'> 
			<button class='btn btn-lg btn-danger'><?= _t('Edit this transcription'); ?></button>
		</div>
		
		<?php print caHTMLHiddenInput('id', ['value' => $t_item->getPrimaryKey()]); ?>
		<?php print caHTMLHiddenInput('representation_id', ['value' => $representation_id]); ?>
		<?php print caHTMLHiddenInput('edit', ['value' => '1']); ?>
		<?php print caHTMLHiddenInput('transcription_id', ['value' => $transcription->getPrimaryKey()]); ?>
	</div>
<?php
	} else {
?>
							<?php print caHTMLTextInput('transcription', ['value' => $transcription->get('transcription'), 'id' => 'transcription'], ['width' => '525px', 'height' => '400px']); ?>
					
							<?php print caHTMLHiddenInput('id', ['value' => $t_item->getPrimaryKey()]); ?>
							<?php print caHTMLHiddenInput('representation_id', ['value' => $representation_id]); ?>
<?php
	if ($start_date = $transcription->get('ca_representation_transcriptions.created_on')) {
		print "<div class='startTime'>("._t('Started %1', $start_date).")</div>";
	}
?>
							<div class='saveControls'> 
								<button class='btn btn-lg btn-danger'><?= _t('Save transcription'); ?></button>
								<?php print caHTMLCheckboxInput('complete', ['value' => 1]); ?> Completed?
							</div>
<?php
	}
?>
							</div>
						</form>
<?php
	if($transcription->isComplete()) {
?>
		<div class='completedMessage'>
			<?= _t('Transcription was completed on %1', $transcription->get('completed_on')); ?>
		</div>
<?php
	} else {
?>
						<div>
							<ul>
								<li><?= _t('If you cannot read a word, enter [illegible]. If you are making an educated guess, enter the word in square brackets with a question mark, ie [shipyard?]'); ?></li>
								<li><?= _t('Save your work often'); ?></li>
								<li><?= _t('Some records may include spelling mistakes and/or abbreviations. Please do not correct spelling or expand abbreviations, but simply transcribe the record as it appears. If a word has been misspelled, put (sic) afterwards so it is clear this is not a transcription error. If words have been crossed out, they should not be included in the transcription.'); ?></li>
								<li><?= _t('Focus on the text rather than formatting. No need for adding line or paragraph breaks or noting that words are underlined, bolded, etc.; the goal is to make the text searchable and easy to read.'); ?></li>
								<li><?= _t('When you finish a transcription, check the completed box. For multi-page documents, you will need to do this for each page.'); ?></li>
								<li><?= _t('View <a href="/TranscriptionTips/Index" target="_new">Transcription Tips</a>'); ?></li>
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
			<?php print $next_id ? caNavLink($this->request, '<i class="fa fa-angle-right" aria-label="back"></i><div class="small">'._t('Next').'</div>', '', '*', 'Transcribe', 'Item', ['id' => $next_id]) : ''; ?>
		</div>
	</div>
	</div>
</div>

<script type='text/javascript'>jQuery(document).ready(function() {
		var ckEditor = CKEDITOR.replace( 'transcription',
		{
			toolbar : <?php print json_encode([['Bold', 'Italic', 'Underline', 'Strike', '-', 'Subscript',' Superscript', '-', 'Table', 'NumberedList', 'BulletedList', 'Outdent', 'Indent', '-', 'SpecialChar', '-', 'Maximize']]); ?>,
			width: '525px',
			height: '400px',
			toolbarLocation: 'top',
			enterMode: CKEDITOR.ENTER_BR
		});
		
		ckEditor.on('instanceReady', function(){ 
			 ckEditor.document.on( 'keydown', function(e) {if (caUI && caUI.utils) { caUI.utils.showUnsavedChangesWarning(true); } });
		});
});									
</script>