<?php
/* ----------------------------------------------------------------------
 * themes/default/views/Search/ca_collections_search_subview_html.php : 
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
	$va_options 		= $va_block_info["options"];
	$vs_block 			= $this->getVar('block');
	$vn_start		 	= (int)$this->getVar('start');			// offset to seek to before outputting results
	$vn_hits_per_block 	= (int)$this->getVar('itemsPerPage');
	$vb_has_more 		= (bool)$this->getVar('hasMore');
	$vs_search 			= (string)$this->getVar('search');
	$vn_init_with_start	= (int)$this->getVar('initializeWithStart');
	$va_access_values = caGetUserAccessValues($this->request);
	$o_browse_config = caGetBrowseConfig();
	$va_browse_types = array_keys($o_browse_config->get("browseTypes"));
	$o_config = caGetSearchConfig();
	$o_icons_conf = caGetIconsConfig();
	if(!($vs_default_placeholder = $o_icons_conf->get("placeholder_media_icon"))){
		$vs_default_placeholder = "<i class='fa fa-picture-o fa-2x'></i>";
	}
	$vs_default_placeholder_tag = "<div class='multisearchImgPlaceholder'>".$vs_default_placeholder."</div>";

	if ($qr_results->numHits() > 0) {
		if (!$this->request->isAjax()) {
?>
			<small class="pull-right sortValues">
<?php
				if(in_array($vs_block, $va_browse_types)){
?>
				<span class='multisearchFullResults'><?php print caNavLink($this->request, '<span class="glyphicon glyphicon-list" aria-label="list"></span> '._t('Full results'), '', '', 'Search', '{{{block}}}', array('search' => str_replace("/", "", $vs_search))); ?></span> | 
<?php
				}
?>
				<span class='multisearchSort'><?php print _t("sort by:"); ?> {{{sortByControl}}}</span>
				{{{sortDirectionControl}}}
			</small>
<?php
			if(in_array($vs_block, $va_browse_types)){
?>
				<?php print '<H2>'.caNavLink($this->request, $va_block_info['displayName'].' ('.$qr_results->numHits().')', '', '', 'Search', '{{{block}}}', array('search' => $vs_search)).'</H2>'; ?>
<?php
			}else{
?>
				<H2><?php print $va_block_info['displayName']." (".$qr_results->numHits().")"; ?></H2>
<?php
			}
?>
			<div class='blockResults'>
				<div id="{{{block}}}scrollButtonPrevious" class="scrollButtonPrevious"><i class="fa fa-angle-left"></i></div><div id="{{{block}}}scrollButtonNext" class="scrollButtonNext"><i class="fa fa-angle-right"></i></div>
				<div id='{{{block}}}Results' class='multiSearchResults'>
					<div class='blockResultsScroller'>
<?php
		}
		
		$va_collection_ids = array();
		while($qr_results->nextHit()) {
			$va_collection_ids[] = $qr_results->get('ca_collections.collection_id');
		}
		$qr_results->seek($vn_start);
		
		#$va_images = caGetDisplayImagesForAuthorityItems('ca_collections', $va_collection_ids, array('version' => 'widepreview', 'relationshipTypes' => caGetOption('selectMediaUsingRelationshipTypes', $va_options, null), 'objectTypes' => caGetOption('selectMediaUsingTypes', $va_options, null), 'checkAccess' => $va_access_values));
		
		$coll = Datamodel::getInstance('ca_collections', true);	
		
		$vn_count = 0;
		while($qr_results->nextHit()) {
?>
			<div class='{{{block}}}Result multisearchResult'>
<?php
			$vs_image = $qr_results->getWithTemplate("<unit relativeTo='ca_collections' length='1'>^ca_object_representations.media.widepreview</unit>", $va_access_values);
			if (!$vs_image) {
				$collection_ids = array_merge([$qr_results->getPrimaryKey()], $qr_results->get("ca_collections.children.collection_id", array("checkAccess" => $va_access_values, "returnAsArray" => true, "sort" => "ca_collection_labels.name")));
			
				foreach($collection_ids as $collection_id) {
					$refs = $coll->getAuthorityElementReferences(['row_id' => $collection_id]);
					if(isset($refs['57']) && sizeof($refs['57'])) { // 57 = ca_objects
						$qr_objects = caMakeSearchResult('ca_objects', array_keys($refs['57']), array("checkAccess" => $va_access_values, "sort" => 'ca_objects.idno'));
						while($qr_objects->nextHit()) {
							if(in_array($qr_objects->get("ca_objects.access"), $va_access_values)){
								if($vs_image = $qr_objects->get('ca_object_representations.media.widepreview')) {
									break(2);
								}
							}
						}
					}
				}
			}
			print $vs_image;
?>
				<br/><?php print $qr_results->get('ca_collections.preferred_labels.name', array('returnAsLink' => true)); ?>
			</div>
<?php
			$vn_count++;
			if ((!$vn_init_with_start && ($vn_count == $vn_hits_per_block)) || ($vn_init_with_start && ($vn_count >= $vn_init_with_start))) {break;} 
		}
		if (!$this->request->isAjax()) {
?>
					</div><!-- end blockResultsScroller -->
				</div>
			</div><!-- end blockResults -->
		
			<div class='allLink'><?php print caNavLink($this->request, 'all '.$va_block_info['displayName'].' results', '', '', 'Search', '{{{block}}}', array('search' => $vs_search));?></div>
			
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
						
						sortDirection: '{{{sortDirection}}}',
						sortDirectionParameter: '{{{block}}}SortDirection',
						sortDirectionSelector: '#{{{block}}}_sort_direction',
						
						scrollPreviousControlSelector: '#{{{block}}}scrollButtonPrevious',
						scrollNextControlSelector: '#{{{block}}}scrollButtonNext',
						cacheKey: '{{{cacheKey}}}'
					});
				});
			</script>
<?php
		}else{
			# --- need to change sort direction to catch default setting for direction when sort order has changed
			if($this->getVar("sortDirection") == "desc"){
?>
				<script type="text/javascript">
					jQuery('#<?php print $vs_block; ?>_sort_direction').find('span').removeClass('glyphicon-sort-by-alphabet').addClass('glyphicon-sort-by-alphabet-alt');
				</script>
<?php
			}else{
?>
				<script type="text/javascript">
					jQuery('#<?php print $vs_block; ?>_sort_direction').find('span').removeClass('glyphicon-sort-by-alphabet-alt').addClass('glyphicon-sort-by-alphabet');
				</script>
<?php
			}
		}
	}
?>