<?php
	$t_object = $this->getVar("item");
	$va_access_values = $this->getVar("access_values");
	$va_related_objects = $t_object->get("ca_objects.related.object_id", array("returnAsArray" => true, "checkAccess" => $va_access_values, "restrictToTypes" => array("archival", "library", "work", "resource", "file", "survivor")));
	if(is_array($va_related_objects) && sizeof($va_related_objects)){
		$qr_res = caMakeSearchResult("ca_objects", $va_related_objects, array('checkAccess' => $this->opa_access_values));
		if($qr_res->numHits()){
			$t_list_item = new ca_list_items();
			$o_icons_conf = caGetIconsConfig();
			$va_object_type_specific_icons = $o_icons_conf->getAssoc("placeholders");
			if(!($vs_default_placeholder = $o_icons_conf->get("placeholder_media_icon"))){
				$vs_default_placeholder = "<i class='fa fa-picture-o fa-4x'></i>";
			}
			$vs_default_placeholder_tag = "<div class='bResultItemImgPlaceholder'>".$vs_default_placeholder."</div>";
			
?>
			<div class="relatedBlock">
				<h3>Records</H3>
				<div class="row" id="browseResultsContainer">
<?php
			while($qr_res->nextHit()){
				if(!($vs_thumbnail = $qr_res->get('ca_object_representations.media.medium', array("checkAccess" => $va_access_values)))){
					$t_list_item->load($qr_res->get("resource_type"));
					$vs_typecode = $t_list_item->get("idno");
					if($vs_type_placeholder = caGetPlaceholder($vs_typecode, "placeholder_media_icon")){
						$vs_thumbnail = "<div class='bResultItemImgPlaceholder'>".$vs_type_placeholder."</div>";
					}else{
						$vs_thumbnail = $vs_default_placeholder_tag;
					}
				}
				$vs_rep_detail_link 	= caDetailLink($this->request, $vs_thumbnail, '', 'ca_objects', $qr_res->get("ca_objects.object_id"));
?>
				<div class="bResultItemCol col-xs-12 col-sm-6 col-md-3">
					<div class="bResultItem">
						<div class="bResultItemContent"><div class="text-center bResultItemImg"><?php print $vs_rep_detail_link; ?></div>
							<div class="bResultItemText">
								<small><?php print caDetailLink($this->request, $qr_res->get("ca_objects.preferred_labels"), '', 'ca_objects', $qr_res->get("ca_objects.object_id")); ?></small>
							</div><!-- end bResultItemText -->
						</div><!-- end bResultItemContent -->
					</div><!-- end bResultItem -->
				</div>
<?php
			}
?>
				</div>
			</div>
<?php
		}
	}
?>