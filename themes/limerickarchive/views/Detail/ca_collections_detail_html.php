<?php
/* ----------------------------------------------------------------------
 * pawtucket2/themes/default/views/ca_entities_detail_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2010 Whirl-i-Gig
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
	$t_collection 			= $this->getVar('t_item');
	$vn_collection_id 		= $t_collection->getPrimaryKey();
	
	$vs_title 					= $this->getVar('label');
	
	$va_access_values	= $this->getVar('access_values');
	JavascriptLoadManager::register('tabUI');
	JavascriptLoadManager::register('formUI');
	$qr_hits = $this->getVar('browse_results');
	$va_items = array();
	$va_item_classifications = array();
	if($qr_hits->numHits()){
		while($qr_hits->nextHit()){
			$va_items[$qr_hits->get("ca_objects.showcase_classification")][] = array("object_id" => $qr_hits->get("ca_objects.object_id"), "label" => join($qr_hits->getDisplayLabels(), "; "), "image" => $qr_hits->getMediaTag('ca_object_representations.media', 'widepreview', array('checkAccess' => $va_access_values)));
		}
		$va_item_classifications = array_keys($va_items);
	}
	
	# -- get the top level showcase classifications to display as tabs containing items with that showcase classification
	$o_lists = new ca_lists();
	$vn_root_node = $o_lists->getRootItemIDForList("archival_showcase_classification");
	$va_classification_for_tabs = caExtractValuesByUserLocale($o_lists->getChildItemsForList("archival_showcase_classification", $vn_root_node, array('directChildrenOnly' => true)));

?>	
	<div id="collectionDetail"><div style="float:left;">
			<div class="maincolimage" style="margin-top:16px;">
			<?php print $t_collection->get("showcase_banner", array("version" => "original", "showMediaInfo" => false)); ?>
			</div><!-- end mailcolImage -->
			<div class="maincol">
				
				<h1><?php print $vs_title; ?></h1>
		

			<div id="tabs" style="margin-top:20px;">
				<ul>
					<li class="tabIntro" style="height:34px; "><a href="#fragment-intro"><span style="float:left;">Introduction</span></a></li>
<?php
					if(sizeof($va_items) && is_array($va_classification_for_tabs) && (sizeof($va_classification_for_tabs) > 0)){
						foreach($va_classification_for_tabs as $vn_item_id => $va_item_info){
							# --- make sure there are items with this classification or sub classification
							$va_subclassification_ids = array_keys(caExtractValuesByUserLocale($o_lists->getChildItemsForList("archival_showcase_classification", $vn_item_id, array('directChildrenOnly' => true))));
							if(!in_array($vn_item_id, $va_item_classifications) && !sizeof(array_intersect($va_item_classifications, $va_subclassification_ids))){
								continue;
							}
							print '<li class="tab" style="height:34px;"><a href="#fragment-'.$vn_item_id.'"><span style="float:left;">'.$va_item_info['name_plural'].'</span></a></li>';
						}
					}
					reset($va_classification_for_tabs);
?>
					<li class="tab" style="height:34px; "><a href="#fragment-search"><span style="float:left;">Search</span></a></li>
				</ul>
				<div id="fragment-intro">
					<div class="contentstyle">			
<?php
					print $t_collection->get("description");
?>
					</div><!-- end contentstyle -->
					<div style="clear:both; height:1px;"><!-- empty --></div>
				</div><!-- end fragment-intro -->
				<div id="fragment-search">
					<div class="contentstyle">
						<div class="tabsearch" >
							<?php print "<h2>"._t("Search the Collection")."</h2>";?>
								<form action="#" method="get" id="collectionSearchForm">
									<fieldset style="border:0px">
										<p><label for="keyword">by keyword</label><input type="text" name="search" size="20" value="<?php print ($vs_search) ? $vs_search : ''; ?>"  autocomplete="off" /><input type="hidden" name="searchtype" value="keyword" /><input class="button" type="image" src="<?php print $this->request->getThemeUrlPath()?>/graphics/city/search-button.png" alt="search" /></p>
									</fieldset>
									<input type="hidden" name="collectionSearch" value="1">
								</form>
						</div><!-- end tabsearch -->
						<div id="resultBox"></div>
					</div><!-- end contentstyle -->
					<div style="clear:both; height:1px;"><!-- empty --></div>
					<script type="text/javascript">
						$(document).ready(function() {
							jQuery("#collectionSearchForm").submit(function() {
								jQuery("#resultBox").load("<?php print caNavUrl($this->request, '', 'Search', 'Index'); ?>", jQuery("#collectionSearchForm").serializeArray());
								return false;
							});
							
						});
					</script>
				</div><!-- end fragment-search -->
<?php
					if(sizeof($va_items) && is_array($va_classification_for_tabs) && (sizeof($va_classification_for_tabs) > 0)){
						foreach($va_classification_for_tabs as $vn_item_id => $va_item_info){
							$va_subclassification_for_tabs = caExtractValuesByUserLocale($o_lists->getChildItemsForList("archival_showcase_classification", $vn_item_id, array('directChildrenOnly' => true)));
							$va_subclassification_ids = array_keys($va_subclassification_for_tabs);
							if(!in_array($vn_item_id, $va_item_classifications) && !sizeof(array_intersect($va_item_classifications, $va_subclassification_ids))){
								continue;
							}
?>
						<div id="fragment-<?php print $vn_item_id; ?>">
							<div class="contentstyle">
<?php
								# --- items for top level classification
								if($va_items[$vn_item_id]){
									foreach($va_items[$vn_item_id] as $va_items_for_classification){
									
?>
									<div class="showcaseItem"><div class="showcaseItemContainer"><?php print caNavLink($this->request, $va_items_for_classification['image'], '', 'Detail', 'Object', 'Show', array('object_id' => $va_items_for_classification['object_id'])).caNavLink($this->request, $va_items_for_classification['label'], '', 'Detail', 'Object', 'Show', array('object_id' => $va_items_for_classification['object_id']));?></div></div>
<?php
									}
								}else{
									# --- items for child classifications
									$vs_subGroupItems = "";
									print "<div class='subItemCategoriesListHeading'>Show ".$va_item_info['name_plural']." About:</div><div class='subItemCategoriesList'>";
									foreach($va_subclassification_for_tabs as $vn_sub_item_id => $va_sub_item_info){
										if($va_items[$vn_sub_item_id]){
											print "<span class='itemSubCategory' id='category".$vn_sub_item_id."'><a href='#' onclick='$(\".itemSubCategory\").removeClass(\"itemSubCategoryHighlight\"); $(\"#category".$vn_sub_item_id."\").addClass(\"itemSubCategoryHighlight\"); $(\".itemGroup\").hide(); $(\"#group".$vn_sub_item_id."\").toggle(); return false;'>".$va_sub_item_info['name_plural']."</a></span>";
											$vs_subGroupItems .= "<div class='itemGroup' id='group".$vn_sub_item_id."'>";
											foreach($va_items[$vn_sub_item_id] as $va_items_for_sub_classification){
												$vs_subGroupItems .= '<div class="showcaseItem"><div class="showcaseItemContainer">'.caNavLink($this->request, $va_items_for_sub_classification['image'], '', 'Detail', 'Object', 'Show', array('object_id' => $va_items_for_sub_classification['object_id'])).caNavLink($this->request, $va_items_for_sub_classification['label'], '', 'Detail', 'Object', 'Show', array('object_id' => $va_items_for_sub_classification['object_id'])).'</div></div>';
											}
											$vs_subGroupItems .= "</div>";
										}
									}
									print "</div><!-- end subItemCategoriesList -->".$vs_subGroupItems;
								}
?>
							</div><!-- end contentstyle -->
							<div style="clear:both; height:1px;"><!-- empty --></div>
						</div><!-- end fragment -->
<?php
						}
					}
?>
				
			</div><!-- end tabs -->
		</div><!-- end maincol -->
		</div><!-- end leftCol -->
	</div><!-- end detailBody -->
	</div><!-- end collectionDetail -->
<script type="text/javascript">
  	$(document).ready(function() {
    	$("#tabs").tabs({
    		cookie: {
    			expires: 30
    		}
    	});
  	});
</script>