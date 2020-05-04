<?php
	require_once(__CA_MODELS_DIR__."/ca_sets.php");
	require_once(__CA_MODELS_DIR__."/ca_lists.php");
	$va_access_values = $this->getVar('access_values');	
?>
<div id="browseListBody" style="margin-bottom:100px;">
	<div id="featuredCollections">
		<div style="clear:both;"></div><br/><br/><div class="subTitle">Highlighted Films</div>
<?php
		# --- list all curatorial sets
		$t_list = new ca_lists();
		$vn_gallery_set_type_id = $t_list->getItemIDFromList('set_types', 'curatorial'); 			
		$t_set = new ca_sets();
		$vn_gallery_set_type_id = 2859;
		$va_sets = caExtractValuesByUserLocale($t_set->getSets(array('checkAccess' => $va_access_values, 'setType' => $vn_gallery_set_type_id)));
		if(is_array($va_sets) && sizeof($va_sets)){
			foreach($va_sets as $vn_set_id => $va_set_info){
				$t_set->load($vn_set_id);
?>
			<div class='featuredCollection'>
<?php
				print caNavLink($this->request, $t_set->get('ca_sets.collection_still.small'), "", "", "About", "FeaturedCollectionsList", array("set_id" => $t_set->get('ca_sets.set_id')));
				print caNavLink($this->request, $t_set->get("ca_sets.preferred_labels.name"), "", "", "About", "FeaturedCollectionsList", array("set_id" => $t_set->get('ca_sets.set_id')))."<br/>\n";
?>
				<div>
<?php
					$vs_desc = $t_set->get("description");
					if(mb_strlen($vs_desc) > 250){
						$vs_desc = mb_substr($vs_desc, 0, 250)."...";
					}
					print $vs_desc;
?>
				</div>
			</div><!-- end featuredCollection -->			
<?php
			}
		}else{
			print "<p>Coming soon...</p>";
		}
?> 			
	</div><!-- end featuredCollections -->
	<div style="clear:both;">&nbsp;</div>
</div><!-- end introText -->

<div style="clear:both; height:1px;"><!-- empty --></div></div><!-- end browseListBody -->