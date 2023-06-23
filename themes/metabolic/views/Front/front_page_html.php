<?php
/** ----------------------------------------------------------------------
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
 * @subpackage Core
 * @license http://www.gnu.org/copyleft/gpl.html GNU Public License version 3
 *
 * ----------------------------------------------------------------------
 */
	$va_access_values = caGetUserAccessValues();
	$o_front_config = caGetFrontConfig();
	
?>
	<div class="row">
		<div class="col-sm-12">
			<div id="frontSlider"></div>
		</div><!--end col -->	
	</div><!-- end row -->

	<div class="row">
		<div class="col-sm-12">
			<form class="hpSearch form-inline" action="<?php print caNavUrl('', 'MultiSearch', 'Index'); ?>">
				<div class="text-center mx-auto">
					<span class="">Search the Archive</span>
					<input type="text" class="form-control " id="hpSearchInput" placeholder="" name="search" autocomplete="off" placeholder="Search" aria-label="Search" />
					<button class="btn" type="submit">GO</button>
				</div>
			</form>
		</div>
	</div>

<?php
# --- hide tags from home page
if($showTags){
?>
	<div class="row">
		<div class="col-sm-12">
			<H1>Tags</H1>
		</div>
	</div>
<?php
	#$o_browse = caGetBrowseInstance("ca_objects");
	#$va_tag_facet = $o_browse->getFacet("tag_facet", array('checkAccess' => $this->opa_access_values, 'request' => $this->request));
	
	$o_db = new Db();
	#$q_tags = $o_db->query("SELECT t.tag from ca_item_tags t INNER JOIN ca_items_x_tags AS it ON t.tag_id = it.tag_id ORDER BY count(it.tag_id)");
	$q_tags = $o_db->query("SELECT ixt.tag_id, count(ixt.tag_id) as tagCount, t.tag from ca_items_x_tags ixt INNER JOIN ca_item_tags as t on t.tag_id = ixt.tag_id GROUP BY ixt.tag_id ORDER BY tagCount DESC limit 20");
	if($q_tags->numRows()){
?>
	<div class="row bg-1 pt-4 mb-5 hpTags">
<?php
		while($q_tags->nextRow()){
?>
			<div class="col-sm-6 col-md-3 pb-4">
				<?php print caNavLink("<div class='bg-2 text-center py-2 uppercase'>".$q_tags->get("tag")."</div>", "", "", "MultiSearch", "Index", array("search" => "ca_item_tags.tag:'".$q_tags->get("tag")."'")); ?>
			</div>
<?php
		}

?>
	</div>
<?php
	}
}
	$o_gallery_config = caGetGalleryConfig();
	if(!$vs_section_name = $o_gallery_config->get('gallery_section_name')){
		$vs_section_name = _t("Featured Galleries");
	}
	$t_list = new ca_lists();
	$vn_gallery_set_type_id = $t_list->getItemIDFromList('set_types', $o_gallery_config->get('gallery_set_type'));
	if($vn_gallery_set_type_id){
		$t_set = new ca_sets();
		$va_un_sorted_sets = caExtractValuesByUserLocale($t_set->getSets(array('checkAccess' => $va_access_values, 'setType' => $vn_gallery_set_type_id)));
		if(is_array($va_un_sorted_sets) && sizeof($va_un_sorted_sets)){
			shuffle($va_un_sorted_sets);
			$va_sets = array();
			foreach($va_un_sorted_sets as $va_set){
				if($va_set["set_code"] != $o_front_config->get("front_page_set_code")){
					$va_sets[$va_set["set_id"]] = $va_set;
				}
			}
			$va_sets = array_slice($va_sets,0,8,true);
			$va_set_first_items = $t_set->getPrimaryItemsFromSets(array_keys($va_sets), array("version" => "widepreview", "checkAccess" => $va_access_values));
		}
	}	
	if(is_array($va_sets) && sizeof($va_sets)){		
?>
	<div class="row mt-5">
		<div class="col-md-6 mt-5">
			<H1><?php print $vs_section_name; ?></H1>
		</div>
		<div class="col-md-6 mt-5 text-right">
<?php
			print caNavLink(_t("View All"), "btn btn-sm btn-primary", "", "Gallery", "Index");
?>
		</div>
	</div>
	<div class="row mb-5">
		<div class="col-lg-12">
			<div class="row">
<?php
		foreach($va_sets as $vn_set_id => $va_set){
			$va_first_item = "";
			if($va_set_first_items[$vn_set_id]){
				$va_first_item = array_shift($va_set_first_items[$vn_set_id]);
			}
			if(!is_array($va_first_item) || !isset($va_first_item['representation_tag'])) { continue; }
			
			print "<div class='col-sm-6 col-md-3 pb-4 mb-4'>";
			print caNavLink($va_first_item["representation_tag"], "", "", "Gallery", $vn_set_id);
			print "<div class='pt-2'>".$va_set["name"]."</div><div>".$va_set["item_count"]." ".(($va_set["item_count"] == 1) ? _t("item") : _t("items"))."</div>";
			print "</div>";
		}
?>
			</div>
		</div>
	</div>
<?php
	}
?>

<script type="text/javascript">	
	pawtucketUIApps['FrontPage'] = {
		'selector': '#frontSlider',
		'data': {
			'images': <?php print ca_sets::setContentsAsJSON($o_front_config->get("front_page_set_code"), ['checkAccess' => $va_access_values, 'template' => ($vs_tmp = $o_front_config->get("front_page_set_item_caption_template")) ? $vs_tmp : '<l>^ca_objects.preferred_labels.name (^ca_objects.idno)</l>']); ?>,
		}
	};
</script>