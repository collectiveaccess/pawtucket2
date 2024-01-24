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
 
	$t_resource = $this->getVar('resource');
	
	
	$previous_id = $this->getVar('previousID');
	$next_id = $this->getVar('nextID');
	
	$representation_id = $this->getVar('representation_id');
	$representation_ids = $t_resource->get('ca_object_representations.representation_id', ['returnAsArray' => true]);
	
	if(is_array($representation_ids) && sizeof($representation_ids)) {
		if (in_array($representation_id, $representation_ids)) {
			$current_representation_id = $representation_id;
		} else {
			$current_representation_id = $representation_ids[0];
		}
	} else {
		$current_representation_id = null;
	}
	
	
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
			<h1><a href="/About/Teachers"><?= _t('For Teachers'); ?></a> &gt; <a href="/EducationalResources/Index"><?= _t('Educational Resources'); ?></a> &gt; <?= $t_resource->get('ca_occurrences.preferred_labels.name'); ?></H1>
			<p>
				
				<h4><?php print caDetailLink($this->request, $t_resource->get('ca_occurrences.preferred_labels.name')." (".$t_resource->get('ca_occurrences.idno').")", '' ,$t_resource->tableName(), $t_resource->getPrimaryKey()); ?></h4>
				<h6><?php print $t_resource->get("ca_entities", array("restrictToTypes" => ["member_institution"], 'delimiter' => ', ', "returnAsLink" => true, "checkAccess" => $access_values));?></h6>
				<?php print $t_resource->get('ca_occurrences.description'); ?>
			</p>
			<div style="clear:both; margin-top:10px;">

				<div class="row">
					<div class="col-sm-7">
						<?php 
							print array_shift(caRepresentationViewerHTMLBundles($this->request, caMakeSearchResult('ca_object_representations', [$current_representation_id]), $t_resource, ['display' => 'detail', 'context' => 'education']));
						?>
						
						
<?php
	
	if (is_array($reps = $t_resource->getRepresentations(['versions' => 'icon'], null, ['checkAccess' => $access_values])) &&  (sizeof($reps) > 1)) {
?>
		<div class='otherRepresentations'>
			<div class="unit">
				<span class="name"><?= _t('Files'); ?>:</span>
				<span class="data">
					<br/>
<?php
		foreach($reps as $rep) {
			if($rep['representation_id'] == $representation_id) {
				print "<a href='#' class='otherRepresentation selected'>{$rep['tags']['icon']}</a>";
			} else {
				print caNavLink($this->request, $rep['tags']['icon'], 'otherRepresentation', '*', '*', '*', ['id' => $t_resource->getPrimaryKey(), 'representation_id' => $rep['representation_id']]);
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
<?php
	$grade_levels = $t_resource->get('ca_occurrences.grade_level', ['convertCodesToDisplayText' => true, 'returnAsArray' => true]);
	$grade_level_ids = $t_resource->get('ca_occurrences.grade_level', ['returnAsArray' => true]);
	if (is_array($grade_levels) && sizeof($grade_levels)) {
?>
						<div class='unit'><span class='name'><?= _t('Grade level'); ?></span><span class='data'>
							<?php 
								$links = [];
								foreach($grade_levels as $i => $g) { 
									$links[] = caNavLink($this->request, $g, "", "", "*", "Browse/facet/grade_level_facet/id/".$grade_level_ids[$i]);
								} 
								
								if(sizeof($links) > 0) {
									print join(', ', $links);
								}
							?>
						</span></div>
<?php
	}
		
	if(is_array($regions = $t_resource->get('ca_occurrences.mem_inst_region', ['convertCodesToDisplayText' => true, 'returnAsArray' => true])) && sizeof($regions)) {
		$region_ids = $t_resource->get('ca_occurrences.mem_inst_region', ['returnAsArray' => true]);
?>
						<div class='unit'><span class='name'><?= _t('Region'); ?></span><span class='data'>
							<?php 
								$links = [];
								foreach($regions as $i => $c) { 
									$links[] = caNavLink($this->request, $c, "", "", "*", "Browse/facet/region_facet/id/".$region_ids[$i]);
								} 
								
								if(sizeof($links) > 0) {
									print join(', ', $links);
								}
							?>
						</span></div>
<?php
	}
	
	if(is_array($counties = $t_resource->get('ca_occurrences.counties', ['convertCodesToDisplayText' => true, 'returnAsArray' => true])) && sizeof($counties)) {
		$county_ids = $t_resource->get('ca_occurrences.counties', ['returnAsArray' => true]);
?>
						<div class='unit'><span class='name'><?= _t('County'); ?></span><span class='data'>
							<?php 
								$links = [];
								foreach($counties as $i => $c) { 
									$links[] = caNavLink($this->request, $c, "", "", "*", "Browse/facet/county_facet/id/".$county_ids[$i]);
								} 
								
								if(sizeof($links) > 0) {
									print join(', ', $links);
								}
							?>
						</span></div>
<?php
	}
	
	if(is_array($activity_types = $t_resource->get('ca_occurrences.activity_type', ['convertCodesToDisplayText' => true, 'returnAsArray' => true])) && sizeof($activity_types)) {
		$activity_type_ids = $t_resource->get('ca_occurrences.activity_type', ['returnAsArray' => true]);
?>
						<div class='unit'><span class='name'><?= _t('Activity'); ?></span><span class='data'>
							<?php 
								$links = [];
								foreach($activity_types as $i => $c) { 
									$links[] = caNavLink($this->request, $c, "", "", "*", "Browse/facet/activity_type_facet/id/".$activity_type_ids[$i]);
								} 
								
								if(sizeof($links) > 0) {
									print join(', ', $links);
								}
							?>
						</span></div>
<?php
	}
	
	if(is_array($cultures = $t_resource->get('ca_occurrences.culture', ['convertCodesToDisplayText' => true, 'returnAsArray' => true])) && sizeof($cultures)) {
		$culture_ids = $t_resource->get('ca_occurrences.culture', ['returnAsArray' => true]);
?>
						<div class='unit'><span class='name'><?= _t('Culture'); ?></span><span class='data'>
							<?php 
								$links = [];
								foreach($cultures as $i => $c) { 
									$links[] = caNavLink($this->request, $c, "", "", "*", "Browse/facet/culture_facet/id/".$culture_ids[$i]);
								} 
								
								if(sizeof($links) > 0) {
									print join(', ', $links);
								}
							?>
						</span></div>
<?php
	}
	
	if(is_array($subjects = $t_resource->get('ca_occurrences.subjects', ['convertCodesToDisplayText' => true, 'returnAsArray' => true])) && sizeof($subjects)) {
		$subject_ids = $t_resource->get('ca_occurrences.subjects', ['returnAsArray' => true]);
?>
						<div class='unit'><span class='name'><?= _t('Subjects'); ?></span><span class='data'>
							<?php 
								$links = [];
								foreach($subjects as $i => $c) { 
									$links[] = caNavLink($this->request, $c, "", "", "*", "Browse/facet/subjects_facet/id/".$subject_ids[$i]);
								} 
								
								if(sizeof($links) > 0) {
									print join(', ', $links);
								}
							?>
						</span></div>
<?php
	}
	
	if($date_added = $t_resource->get('ca_occurrences.date_added')) {
?>
		<div class='unit'><span class='name'><?= _t('Date added'); ?></span><span class='data'> <?= $date_added; ?></div>
<?php
	}
?>

						<h2><?= _t('Download'); ?></h2>
						
						<ul class="educationalResourcesDownloadList">
<?php
	if (is_array($reps = $t_resource->getRepresentations(['icon', 'original'])) && (($n = sizeof($reps)) > 0)) {
		$tfs = 0;
		foreach($reps as $r) {
			$fs = $r['info']['original']['PROPERTIES']['filesize'];
			$tfs += $fs;
			$filesize = caHumanFilesize($fs);
			$file_label = ($n > 1) ? strtolower($r['label']) : '';
			if ($fetched_from = caGetOption('fetched_from', $r, null)) {
				$fetched_from = preg_replace("!/export[A-Za-z\?=]+$!", "", $fetched_from);
				
?>
				<li><?= _t('<a href="%1">Open</a> %2 in GoogleDrive (%3)', $fetched_from, $file_label, $filesize); ?></li>
<?php
			} 
?>
			<?= "<li>".caNavLink($this->request, _t('Download'), '', '*', '*', 'Download', ['id' => $t_resource->getPrimaryKey(), 'representation_id' => $r['representation_id']])." {$file_label} from NovaMuse ({$filesize})</li>\n"; ?>
<?php
			
		}
		
		if ($n > 1) {
			$filesize = caHumanFilesize($tfs);
?>
			<?= "<li>".caNavLink($this->request, ($n > 1) ? _t('Download all files') : 'Download', '', '*', '*', 'Download', ['id' => $t_resource->getPrimaryKey()])." from NovaMuse ({$filesize})</li>\n"; ?>
<?php
		}
	}
?>
						</ul>
					</div>
				</div>
<?php
	$related_objects = $t_resource->getRelatedItems('ca_objects', ['returnAs' => 'searchResult']);
	if($related_objects) {
?>
				<div class="row">
					<div class="col-md-12">
						<h2><?= _t('Related collection objects'); ?></h2>
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