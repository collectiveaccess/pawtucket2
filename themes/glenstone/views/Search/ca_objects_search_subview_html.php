<?php
/* ----------------------------------------------------------------------
 * themes/default/views/Search/ca_objects_search_subview_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013-2014 Whirl-i-Gig
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
 
	$qr_results 		= $this->getVar('result');
	$va_block_info 		= $this->getVar('blockInfo');
	$vs_block 			= $this->getVar('block');
	$vn_start		 	= (int)$this->getVar('start');			// offset to seek to before outputting results
	$vn_hits_per_block 	= (int)$this->getVar('itemsPerPage');
	$vb_has_more 		= (bool)$this->getVar('hasMore');
	$vs_search 			= (string)$this->getVar('search');
	$vn_init_with_start	= (int)$this->getVar('initializeWithStart');
	$va_access_values 	= caGetUserAccessValues($this->request);

	if ($qr_results->numHits() > 0) {
		if (!$this->request->isAjax()) {
?>
			<small class="pull-right sort">
				sort by {{{sortByList}}} <?php print caNavLink($this->request, _t('Full results &gt;'), 'fullResult', '', 'Search', '{{{block}}}', array('search' => $vs_search, 'source' => 'multisearch')); ?> 
			</small>
			<H3><?php print $va_block_info['displayName']." (".$qr_results->numHits().")"; ?></H3>
			<div class='blockResults'><div id="{{{block}}}scrollButtonPrevious" class="scrollButtonPrevious"><i class="fa fa-angle-left"></i></div><div id="{{{block}}}scrollButtonNext" class="scrollButtonNext"><i class="fa fa-angle-right"></i></div>
				<div id='{{{block}}}Results' class='scrollBlock'>
					<div class='blockResultsScroller'>
<?php
		}
		$vn_count = 0;
		while($qr_results->nextHit()) {
?>
			<div class='{{{block}}}Result'>
<?php 			
				if ($qr_results->get('ca_objects.type_id') == 28 || $qr_results->get('ca_objects.type_id') == 30) {	
					$vs_style = "style='font-style:italic;'";
				}
				if ($qr_results->get('ca_objects.type_id') == 30) {
					if ($qr_results->get('ca_object_representations.media.library', array('checkAccess' => $va_access_values))) {
						print caNavLink($this->request, "<div class='resultImg'>".$qr_results->get('ca_object_representations.media.library', array('checkAccess' => $va_access_values))."</div>", '', '', 'Detail', 'library/'.$qr_results->get('ca_objects.object_id'));
					} else {
						print caNavLink($this->request, "<div class='resultImg noimage'><i class='glyphicon glyphicon-book'></i></div>", '', '', 'Detail', 'library/'.$qr_results->get('ca_objects.object_id'));
					}
				} elseif ($qr_results->get('ca_objects.type_id') == 25) {
					print caNavLink($this->request, "<div class='resultImg'><i class='glyphicon glyphicon-volume-up'></i>".$qr_results->get('ca_object_representations.media.widepreview', array('checkAccess' => $va_access_values))."</div>", '', '', 'Detail', 'archives/'.$qr_results->get('ca_objects.object_id'));
				} elseif ($qr_results->get('ca_objects.type_id') == 26) {
					if ($qr_results->get('ca_object_representations.media.widepreview', array('checkAccess' => $va_access_values))) {
						print caNavLink($this->request, "<div class='resultImg'><i class='glyphicon glyphicon-film'></i>".$qr_results->get('ca_object_representations.media.widepreview', array('checkAccess' => $va_access_values))."</div>", '', '', 'Detail', 'archives/'.$qr_results->get('ca_objects.object_id'));
					} else {
						print caNavLink($this->request, "<div class='resultImg noimage'><i class='glyphicon glyphicon-film'></i></div>", '', '', 'Detail', 'archives/'.$qr_results->get('ca_objects.object_id'));
					}
				} else {
					print caNavLink($this->request, "<div class='resultImg'>".$qr_results->get('ca_object_representations.media.widepreview', array('checkAccess' => $va_access_values))."</div>", '', '', 'Detail', $vs_block.'/'.$qr_results->get('ca_objects.object_id'));				
				}
				if ($qr_results->get('ca_objects.type_id') == 30) {  
					$va_strlen = 120;
				} else {
					$va_strlen = 100;
				}
				if ($qr_results->get('ca_objects.type_id') == 28) {
					print "<p class='artist'>".$qr_results->get('ca_entities.preferred_labels', array('restrictToRelationshipTypes' => 'artist'))."</p>";
				}				
				if (strlen($qr_results->get('ca_objects.preferred_labels.name', array('returnAsLink' => true))) > $va_strlen) {
					print "<p><span $vs_style>".substr($qr_results->get('ca_objects.preferred_labels.name', array('returnAsLink' => true)), 0, $va_strlen-3)."... </span>".$qr_results->get('ca_objects.creation_date')."</p>";  
				} else {
					print "<p><span $vs_style>".$qr_results->get('ca_objects.preferred_labels.name', array('returnAsLink' => true))."</span>";
					if ($qr_results->get('ca_objects.creation_date')) {
						print $qr_results->get('ca_objects.creation_date', array('returnAsLink' => true, 'delimiter' => ', ', 'template' => ', ^creation_date'));
					}
					print "</p>";
				}

				if ($qr_results->get('ca_objects.type_id') == 30) {
					if ($qr_results->get('ca_entities.preferred_labels', array('restrictToRelationshipTypes' => 'author', 'delimiter' => '; '))) {
						$va_authors = $qr_results->get('ca_entities.preferred_labels', array('restrictToRelationshipTypes' => 'author', 'delimiter' => '; '));
					} else {
						$va_authors = "";
					}
					print "<p class='artist'>".(strlen($va_authors) > 40 ? substr($va_authors, 0, 37)."..." : $va_authors)."</p>";
					print "<p class='artist dark'>".$qr_results->get('ca_entities.preferred_labels', array('restrictToRelationshipTypes' => 'publisher', 'delimiter' => '; '))."</p>";
				}				
				if ($qr_results->get('ca_objects.dc_date.dc_dates_value')) {
					print $qr_results->get('ca_objects.dc_date', array('returnAsLink' => true, 'template' => '<p>^dc_dates_value</p>')); 
				}
				if ($qr_results->get('is_deaccessioned') && ($qr_results->get('deaccession_date', array('getDirectDate' => true)) <= caDateToHistoricTimestamp(_t('now')))) {
					// If currently deaccessioned then display deaccession message
					print "<div class='searchDeaccessioned'>"._t('Deaccessioned %1', $qr_results->get('deaccession_date'))."</div>\n";
					#if ($vs_deaccession_notes = $qr_results->get('deaccession_notes')) { TooltipManager::add(".inspectorDeaccessioned", $vs_deaccession_notes); }
				}				

?>			
			</div><!-- end blockResult -->
<?php
			$vn_count++;
			if ((!$vn_init_with_start && ($vn_count == $vn_hits_per_block)) || ($vn_init_with_start && ($vn_count >= $vn_init_with_start))) {break;} 
		}
?>
<?php	
		if (!$this->request->isAjax()) {
?>
					</div><!-- end blockResultsScroller -->
				</div>
			</div><!-- end blockResults -->
			<script type="text/javascript">
				jQuery(document).ready(function() {
					jQuery('#{{{block}}}Results').hscroll({
						name: '{{{block}}}',
						itemCount: <?php print $qr_results->numHits(); ?>,
						preloadCount: <?php print $vn_count; ?>,
						itemWidth: jQuery('.{{{block}}}Result').outerWidth(true),
						itemsPerLoad: <?php print $vn_hits_per_block; ?>,
						itemLoadURL: '<?php print caNavUrl($this->request, '*', '*', '*', array('block' => $vs_block, 'search'=> $vs_search)); ?>',
						itemContainerSelector: '.blockResultsScroller',
						sortParameter: '{{{block}}}Sort',
						sortControlSelector: '#{{{block}}}_sort',
						scrollPreviousControlSelector: '#{{{block}}}scrollButtonPrevious',
						scrollNextControlSelector: '#{{{block}}}scrollButtonNext',
						scrollControlDisabledOpacity: 0,
						scrollControlEnabledOpacity: .5,						
						cacheKey: '{{{cacheKey}}}'
					});
				});
			</script>
<?php
		}
	}
?>