<?php
$t_item = $this->getVar("item");
$va_comments = $this->getVar("comments");
$vn_comments_enabled = 	$this->getVar("commentsEnabled");
$vn_share_enabled = 	$this->getVar("shareEnabled");	
$va_access_values = 	caGetUserAccessValues($this->request);

if ($va_external_link = $t_item->get('ca_entities.external_link', array('returnWithStructure' => true))) {
	foreach ($va_external_link as $va_key => $va_external_link_t) {
		foreach ($va_external_link_t as $va_key => $va_external_link_info) {
			if ($va_external_link_info['url_entry']) {
				$vs_external_link = $va_external_link_info['url_entry'];
				break;
			}
		}
	}
}

$r_sets = $r_collections = null;
	if($entity_source_id = caGetListItemID('object_sources', $t_item->get('ca_entities.idno'))) {
	
		$r_sets = ca_sets::findAsSearchResult(['created_by_member' => $entity_source_id], ['checkAccess' => $va_access_values, 'sort' => 'ca_sets.preferred_labels.name',]);
		
		$stats = [];
		if (($vn_num_objects = ca_objects::find(['source_id' => $entity_source_id], ['checkAccess' => $va_access_values,'returnAs' => 'count'])) > 1000) {
			$stats[] = "{$vn_num_objects} objects";
		} elseif($vn_num_objects > 0) {
			$stats[] = ($vn_num_objects == 1) ? "{$vn_num_objects} object" : "{$vn_num_objects} objects";
		}
		
		if($coll_entity_source_id = caGetListItemID('collection_sources', $t_item->get('ca_entities.idno'))) {
			if (($vn_num_collections = ca_collections::find(['source_id' => $coll_entity_source_id, 'type_id' => 'collection'], ['checkAccess' => $va_access_values,'returnAs' => 'count'])) > 1000) {
				$stats[] = "{$vn_num_collections} archival collections";
			} elseif($vn_num_collections > 0) {
				$stats[] = ($vn_num_collections == 1) ? "{$vn_num_collections} archival collection" : "{$vn_num_collections} archival collections";
			}
			
			$r_collections = ca_collections::findAsSearchResult(['source_id' => $coll_entity_source_id, 'type_id' => 'collection'], ['checkAccess' => $va_access_values, 'sort' => 'ca_collections.preferred_labels.name']);
		}
		
		$stats_str = sizeof($stats) ? join(" & ", $stats).' on NovaMuse' : '';
	
	$search_browse_bar = '
					<div class="browseSearchBar">'."<span class='resultCountDetailPage resultCount'>{$stats_str}</span>".'<form class="detailSearch" role="search" action="" id="detailSearchForm">
						<div class="formOutline">
							<div class="form-group">
								<button type="submit" class="btn-search"><span class="glyphicon glyphicon-search"></span></button>						
								<input type="text" class="form-control detailSearchInput" placeholder="Search this Collection" name="search">
							</div>	
						</div>
					</form>'.caNavLink($this->request, "Filter this Collection <i class='fa fa-external-link'></i>", 'filterCollection', '', 'Browse', 'objects', array('facet' => 'source_facet', 'id' => $entity_source_id))."</div>";
		
	} else {
		$vs_num_objects = $search_browse_bar  = '';
	}	
			
?>
<div class="row">
	<div class='col-xs-12 navTop'><!--- only shown at small screen size -->
		<?php if($t_item->get('type_id') != 464) { ?>{{{previousLink}}}{{{resultsLink}}}{{{nextLink}}}<?php } ?>
	</div><!-- end detailTop -->
	<div class='navLeftRight col-xs-1 col-sm-1 col-md-1 col-lg-1'>
		<div class="detailNavBgLeft">
			<?php if($t_item->get('type_id') != 464) { ?>{{{previousLink}}}{{{resultsLink}}}<?php } ?>
		</div><!-- end detailNavBgLeft -->
	</div><!-- end col -->
	<div class='col-xs-12 col-sm-10 col-md-10 col-lg-10'>
		<div class="container">
			<div class="row">
				<div class='col-md-12 col-lg-12'>
					<H4><?php print ($vs_external_link) ? "<a href='".$vs_external_link."' target='_blank'>".$t_item->get("ca_entities.preferred_labels.displayname")." <i class='fa fa-external-link'></i></a>" : $t_item->get("ca_entities.preferred_labels.displayname"); ?></H4>
				</div><!-- end col -->
			</div><!-- end row -->
			<div class="row">			
				<div class='col-sm-6 col-md-6 col-lg-6'>
<?php
					if ($va_description = $t_item->get('ca_entities.biography')) {
						print "<div class='unit'>".$va_description."</div>";
					}		
			
					if($res = $t_item->get("ca_occurrences", array('delimiter' => ', ', "returnAsLink" => true, "checkAccess" => $va_access_values))) {
						print "<div class='unit'><span class='name'>"._t("Educational resources").": </span>".$res."</div>\n";
					}

	if(false) {		
					if ($va_social_media = $t_item->get('ca_entities.social_media', array('returnWithStructure' => true, 'convertCodesToDisplayText' => true))) {
						print "<div class='unit connect'><div class='name' style='width:100%;'><?= _t('Connect'); ?></div>";
						foreach ($va_social_media as $va_key => $va_social_media_t) { 
							foreach ($va_social_media_t as $va_key => $va_social_media_link) {
								switch ($va_social_media_link['platform']) {
								case "Facebook":
									print "<a href='".$va_social_media_link['social_link']."' target='_blank'><i class='fa fa-facebook-square'></i></a>";
									break;
								case "Twitter":
									print "<a href='".$va_social_media_link['social_link']."' target='_blank'><i class='fa fa-twitter-square'></i></a>";
									break;
								case "Pinterest":
									print "<a href='".$va_social_media_link['social_link']."' target='_blank'><i class='fa fa-pinterest-square'></i></a>";
									break;
								case "Instagram":
									print "<a href='".$va_social_media_link['social_link']."' target='_blank'><i class='fa fa-instagram'></i></a>";
									break;
								case "Youtube":
									print "<a href='".$va_social_media_link['social_link']."' target='_blank'><i class='fa fa-youtube-square'></i></a>";
								break;	
								}
							}				
						}
						print "</div>";
					}
	}
					print "<div class='unit'>".$this->getVar('map')."</div>";
					if($t_item->get("ca_entities.address")){
						print "<div class='unit'><h6><?= _t('Address'); ?></h6>";
						if($t_item->get("ca_entities.address.address1")){
							print $t_item->get("ca_entities.address.address1")."<br/>";
						}
						if($t_item->get("ca_entities.address.address2")){
							print $t_item->get("ca_entities.address.address2")."<br/>";
						}
						$va_address_line3 = array();
						if($t_item->get("ca_entities.address.city")){
							$va_address_line3[] = $t_item->get("ca_entities.address.city");
						}
						if($t_item->get("ca_entities.address.county")){
							$va_address_line3[] = $t_item->get("ca_entities.address.county");
						}
						if($t_item->get("ca_entities.address.stateprovince")){
							$va_address_line3[] = $t_item->get("ca_entities.address.stateprovince");
						}
						if($t_item->get("ca_entities.address.postalcode")){
							$va_address_line3[] = $t_item->get("ca_entities.address.postalcode");
						}
						if($t_item->get("ca_entities.address.country")){
							$va_address_line3[] = $t_item->get("ca_entities.address.country");
						}
						if(sizeof($va_address_line3) > 0){
							print join(", ", $va_address_line3);
						}
						print "</div><!-- end unit -->";
					}
					if ($va_links = $t_item->get('ca_entities.external_link', array('returnWithStructure' => true))) {
						foreach ($va_links as $va_key => $va_links_t) {
							foreach ($va_links_t as $va_key => $va_link) {
								if ($va_link['url_source']) {
									print "<p><a href='".$va_link['url_entry']."' target='_blank'>".$va_link['url_source']."</a></p>";
								} else {
									print "<p><a href='".$va_link['url_source']."' target='_blank'>".$va_link['url_source']."</a></p>";
								}
							}
						}
					}					
								
?>
				
					
				</div><!-- end col -->
				<div class='col-sm-6 col-md-6 col-lg-6'>
<?php
					if ($va_member_image = $t_item->get('ca_entities.mem_inst_image', array('version' => 'large', 'limit' => 1))) {
						print "<div class='unit'>".$va_member_image."</div>"; 
					}
					if ($va_manu_image = $t_item->get('ca_entities.manufacturers_media', array('version' => 'medium'))) {
						if (trim($va_manu_image) != ";") {
							print "<div class='unit image'>".$va_manu_image."</div>"; 
						}
					}					
					if ($vs_business_type = $t_item->get('ca_entities.business_category', array('convertCodesToDisplayText' => true, 'delimiter' => ', '))) {
						print "<div class='unit'><span class='name'>"._t("Business Category").": </span><span class='data'>".$vs_business_type."</span></div>";
					}
					if ($vs_add = $t_item->get('ca_entities.add_info')) {
						print "<div class='unit'><span class='name'>"._t("Additional Information").": </span><span class='data'>".$vs_add."</span></div>";
					}					
					if ($vs_brands = $t_item->get('ca_entities.entity_brands')) {
						print "<div class='unit'><span class='name'>"._t("Brands").": </span><span class='data'>".$vs_brands."</span></div>";
					}						
					if ($vs_products = $t_item->get('ca_entities.products')) {
						print "<div class='unit'><span class='name'>"._t("Products").": </span><span class='data'>".$vs_products."</span></div>";
					}	
					if ($vs_manu_date = $t_item->getWithTemplate('<ifcount min="1" code="ca_entities.manufacturer_date.dates_value"><unit delimiter=" "><div class="unit"><ifdef code="ca_entities.manufacturer_date.dates_value"><span class="name">^ca_entities.manufacturer_date.dates_type: </span><span class="data"> ^ca_entities.manufacturer_date.dates_value</span></div></ifdef></unit>')) {
						print $vs_manu_date;
					}
					if ($vs_remarks = $t_item->get('ca_entities.remarks')) {
						print "<div class='unit'><span class='name'>"._t("Remarks").": </span><span class='data'>".$vs_remarks."</span></div>";
					}	
					if ($vs_remarks_source = $t_item->get('ca_entities.remarks_source')) {
						print "<div class='unit'><span class='name'>"._t("Remarks Source").": </span><span class='data'>".$vs_remarks_source."</span></div>";
					}																		
?>				
					

					<div class="sharethis-inline-share-buttons"></div>					
				
				</div><!-- end col -->
			</div><!-- end row -->
			
		<div class='row'><div class='col-sm-12'>
			<div class='row'>
				<div class='col-sm-12'>
					<?= $search_browse_bar; ?>
				</div>
			</div>
			<div class='row'>
				<div class='col-sm-12'>
						
					<div id="browseResultsContainerObjects">
					
					</div><!-- end browseResultsContainerObjects -->
				</div>
			</div><!-- end row -->
			<script type="text/javascript">
				jQuery(document).ready(function() {
					jQuery("#browseResultsContainerObjects").load("<?= caNavUrl($this->request, '', 'Search', 'objects', array('sort' => 'Recently+added', 'search' => 'ca_objects.source_id:'.$t_item->get('ca_entities.idno')), array('dontURLEncodeParameters' => true)); ?>", function() {
						jQuery('#browseResultsContainerObjects').jscroll({
							autoTrigger: true,
							loadingHtml: "<?= caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>",
							padding: 20,
							nextSelector: 'a.jscroll-next'
						});
					});	
					
					$('#detailSearchForm').on('submit', function (e) {
						e.preventDefault();
						
						jQuery('#browseResultsContainerCollections').html(<?= json_encode(caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...'))); ?>);
						
						jQuery(window).scrollTo('#browseResultsContainerCollections', {duration: 500});
						
						searchTerm = jQuery(this).find("input.detailSearchInput").val();
						if(searchTerm){
							searchTerm = encodeURIComponent(" AND " + searchTerm);
						}
						jQuery("#browseResultsContainerObjects").load("<?= caNavUrl($this->request, '', 'Search', 'objects', null, array('dontURLEncodeParameters' => true)); ?>/search/ca_objects.source_id:<?= $t_item->get('ca_entities.idno'); ?>" + searchTerm, function() {
							jQuery('#browseResultsContainerObjects').jscroll.destroy();
							jQuery('#browseResultsContainerObjects').jscroll({
								autoTrigger: true,
								loadingHtml: <?= json_encode(caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...'))); ?>,
								padding: 20,
								nextSelector: 'a.jscroll-next'
							});
						});
						jQuery("#browseResultsContainerCollections").load("<?= caNavUrl($this->request, '', 'EntityDetail', 'collectionsSearch', null, array('dontURLEncodeParameters' => true)); ?>/all/1/search/ca_collections.source_id:<?= $t_item->get('ca_entities.idno'); ?>" + searchTerm, function() {
							// noop
						});
					});
				});
			</script>
		</div><!-- end container -->
	</div><!-- end col -->
	<div class='navLeftRight col-xs-1 col-sm-1 col-md-1 col-lg-1'>
		<div class="detailNavBgRight">
			{{{nextLink}}}
		</div><!-- end detailNavBgLeft -->
	</div><!-- end col -->
</div><!-- end row -->
<script type='text/javascript'>
	jQuery(document).ready(function() {
		$('.trimText').readmore({
		  speed: 75,
		  maxHeight: 120
		});
	});
</script>