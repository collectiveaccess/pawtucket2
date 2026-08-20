<?php
/** ---------------------------------------------------------------------
 * themes/default/Transcribe/story_html.php :
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
 * @package CollectiveAccess
 * @subpackage theme/default
 * @license http://www.gnu.org/copyleft/gpl.html GNU Public License version 3
 *
 * ----------------------------------------------------------------------
 */

$t_resource = $this->getVar('resource');


$previous_id = $this->getVar('previousID');
$next_id = $this->getVar('nextID');

$access_values = caGetUserAccessValues($this->request);
?>
<div class="transcription educationalResources container textContent">
	<div class="row">
		<div class="col-sm-1">
			<div class="setsBack">
				<?php print $previous_id ? caNavLink($this->request, '<i class="fa fa-angle-left" aria-label="back"></i><div class="small">Previous</div>', '', '*', 'EducationalResources', 'Resource', ['id' => $previous_id]) : ''; ?>
				<?php print ResultContext::getResultsLinkForLastFind($this->request, 'ca_occurrences', '<i class="fa fa-angle-double-left" aria-label="back"></i><div class="small">Back</div>'); ?>
			</div>
		</div>
		<div class="col-sm-10">
			<p>	
				<h1><?php print caDetailLink($this->request, $t_resource->get('ca_occurrences.preferred_labels.name'), '' ,$t_resource->tableName(), $t_resource->getPrimaryKey()); ?></h1>
				<h6><?php print $t_resource->get("ca_entities", array("restrictToTypes" => ["member_institution"], 'delimiter' => ', ', "returnAsLink" => true, "checkAccess" => $access_values));?></h6>
				<?php print $t_resource->get('ca_occurrences.description', ['doRefSubstitution' => true]); ?>
			</p>
			<div style="clear:both; margin-top:10px;">

				<div class="row">
					<div class="col-sm-10">
						<?= $t_resource->get('ca_occurrences.story_text', ['doRefSubstitution' => true]); ?>
					</div>
					<div class="col-sm-2"></div>
				</div>

<?php
	$related_objects = $t_resource->getRelatedItems('ca_objects', ['returnAs' => 'searchResult']);
	if($related_objects) {
?>
				<div class="row">
					<div class="col-md-12">
						<h2><?= _t('Related collection objects on NovaMuse'); ?></h2>
<?php
	while($related_objects->nextHit()) {
		$id = $related_objects->get('ca_objects.object_id');
		$title = caDetailLink($this->request, $related_objects->get('ca_objects.preferred_labels.name'), '', 'ca_objects', $id);
		$idno = $related_objects->get('ca_objects.idno');
		$img = caDetailLink($this->request, $related_objects->get('ca_object_representations.media.small'), '', 'ca_objects', $id);
		
		if ($source = $related_objects->get('ca_entities.preferred_labels.displayname', ['restrictToTypes' => 'member_institution'])) {
			$source = "From: {$source}";
		}
		print "<div class='bResultItemCol col-xs-2 col-sm-2 col-md-3'>
				<div class='bResultItem' onmouseover='jQuery(\"#bResultItemExpandedInfo{$id}\").show();'  onmouseout='jQuery(\"#bResultItemExpandedInfo{$id}\").hide();'>
					<div class='bSetsSelectMultiple'><input type='checkbox' name='object_ids' value='{$id}'></div>
					<div class='bResultItemContent'><div class='text-center bResultItemImg'>{$img}</div>
						<div class='bResultItemText'>
							{$title} ({$idno})
						</div><!-- end bResultItemText -->
					</div><!-- end bResultItemContent -->
					<div class='bResultItemExpandedInfo' id='bResultItemExpandedInfo{$id}'>
						<hr>
						{$source}
					</div><!-- bResultItemExpandedInfo -->
				</div><!-- end bResultItem -->
			</div><!-- end col -->";
	}
?>			
					
					</div>
				</div>
<?php
	}
?>
			</div>
		</div>	
	<div class="col-sm-1">
		<div class="setsBack">
			<?php print $next_id ? caNavLink($this->request, '<i class="fa fa-angle-right" aria-label="back"></i><div class="small">Next</div>', '', '*', 'EducationalResources', 'Resource', ['id' => $next_id]) : ''; ?>
		</div>
	</div>
	</div>
</div>