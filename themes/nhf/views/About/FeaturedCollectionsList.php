<?php
	require_once(__CA_MODELS_DIR__.'/ca_sets.php');
	require_once(__CA_MODELS_DIR__.'/ca_collections.php');
	require_once(__CA_MODELS_DIR__.'/ca_occurrences.php');
	
 	$pn_set_id = $this->request->getParameter('set_id', pInteger);
 	if(!$pn_set_id){
 		print "set id not defined";
        die;
 	}
 	
	# --- load set
	$t_featured_set = new ca_sets($pn_set_id);		
	$va_access_values = caGetUserAccessValues($this->request);
	
	$o_dm = $this->request->getAppDatamodel();
	$vs_table = $o_dm->getTableName($t_featured_set->get('table_num'));
	$t_instance = $o_dm->getInstanceByTableNum($t_featured_set->get('table_num'));
	
?>
<div id="browseListBody">
	<div id="title"><?php print $t_featured_set->get("ca_sets.preferred_labels.name"); ?></div>
	<div id="introText">
		<?php print $t_featured_set->get("ca_sets.description"); ?>
	
		<br/><br/><br/>	
		<div class="subTitle">Featured <?php print ($vs_table == "ca_collections") ? "Collections" : "Works"; ?></div>
		<div id="featuredCollections">
	
<?php
	$va_items = caExtractValuesByUserLocale($t_featured_set->getItems(array('returnItemAttributes' => array('caption'))));
	if(is_array($va_items) && (sizeof($va_items) > 0)){
		foreach($va_items as $vn_i => $va_set_item_info){
			print "<div class='featuredCollection'>";
			$vn_row_id = $va_set_item_info["row_id"];
			$t_instance->load($vn_row_id);
			if($vs_table == "ca_collections"){
				print caDetailLink($this->request, $t_instance->getAttributesForDisplay("collection_still", null, array('version' => 'thumbnail', 'showMediaInfo' => false)), '', $vs_table, $vn_row_id);
			}
			print caDetailLink($this->request, $t_instance->getLabelForDisplay(), '', $vs_table, $vn_row_id);
			if($vs_table == "ca_collections"){
				$vs_desc = $t_instance->get('ca_collections.collection_summary');
			}else{
				$vs_desc = $t_instance->get('ca_occurrences.pbcoreDescription.description_text');
			}
			if(mb_strlen($vs_desc) > 250){
				$vs_desc = mb_substr($vs_desc, 0, 250)."...";
			}
			print "<div>".$vs_desc."</div>";
			print "</div>";
		}
	}			
?>	
		</div>
	</div><!-- end introText -->
	<div style="clear:both; height:1px;"><!-- empty --></div></div><!-- end browseListBody -->