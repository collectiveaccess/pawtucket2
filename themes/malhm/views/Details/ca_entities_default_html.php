<?php	
	AssetLoadManager::register("panel");
	AssetLoadManager::register("mediaViewer");
	AssetLoadManager::register("carousel");
	AssetLoadManager::register("readmore");
	
	$t_item = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");	
	$va_access_values = caGetUserAccessValues($this->request);
	
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
		
		$stats_str = sizeof($stats) ? join(" & ", $stats).' on MNCollections' : '';
	
	$search_browse_bar_top = '
					<div class="browseSearchBar">'."<span class='resultCountDetailPage resultCount'>{$stats_str}</span>".'<form class="detailSearch" role="search" action="" id="detailSearchFormTop">
						<div class="formOutline">
							<div class="form-group">
								<button type="submit" class="btn-search"><span class="glyphicon glyphicon-search"></span></button>						
								<input type="text" class="form-control detailSearchInput" placeholder="Search this Collection" name="search">
							</div>	
						</div>
					</form>'.caNavLink($this->request, "Filter this Collection <i class='fa fa-external-link'></i>", 'filterCollection', '', 'Browse', 'objects', array('facet' => 'source_facet', 'id' => $entity_source_id))."</div>";
					
	$search_browse_bar_bottom = '
					<div class="browseSearchBar">'."<span class='resultCountDetailPage resultCount'>{$stats_str}</span>".'<form class="detailSearch" role="search" action="" id="detailSearchFormBottom">
						<div class="formOutline">
							<div class="form-group">
								<button type="submit" class="btn-search"><span class="glyphicon glyphicon-search"></span></button>						
								<input type="text" class="form-control detailSearchInput" placeholder="Search this Collection" name="search">
							</div>	
						</div>
					</form>'.caNavLink($this->request, "Filter this Collection <i class='fa fa-external-link'></i>", 'filterCollection', '', 'Browse', 'objects', array('facet' => 'source_facet', 'id' => $entity_source_id))."</div>";
		
	} else {
		$vs_num_objects = $search_browse_bar_top = $search_browse_bar_bottom  = '';
	}	
	
?>
<div class='containerWrapper'>
<div class="row">
	<div class='navLeftRight col-xs-12 col-sm-12 col-md-12 col-lg-12'>
		<div class="detailNavBgLeft">
			{{{previousLink}}}{{{resultsLink}}}{{{nextLink}}}
		</div><!-- end detailNavBgLeft -->
	</div><!-- end col -->
</div><!-- end row -->	
<div class="row">
	<div class='col-xs-12 '>
		<div class="container">
			<div class="row">
				<div class='col-md-12 col-lg-12'>
					<H4>{{{^ca_entities.preferred_labels.displayname}}}</H4>
					<?= $search_browse_bar_top; ?>
				</div><!-- end col -->
			</div><!-- end row -->
			<div class="row">			
				<div class='col-sm-6 col-md-6 col-lg-6'>
<?php
					if ($vs_bio = $t_item->get('ca_entities.biography')) {
						print "<div class='unit' style='margin-top:20px'>".$vs_bio."</div>";
					}
					if ($va_website = $t_item->get('ca_entities.website', array('returnAsArray' => true))) {
						foreach ($va_website as $va_key => $va_website_link) {
							print "<div class='unit'><a href='".$va_website_link."' target='_blank'>".$va_website_link."</a></div>";
						}
					}
?>
					<hr/>
<?php
					if ($va_addresses = $t_item->get('ca_entities.address', array('returnWithStructure' => true))) {
						$vs_address = "";
						foreach ($va_addresses as $va_key => $va_addresses_t) {
							foreach ($va_addresses_t as $va_key => $va_address) {
								if ($va_address['address1']) {
									$vs_address.= $va_address['address1']."<br/>";
								}
								if ($va_address['address2']) {
									$vs_address.= $va_address['address2']."<br/>";
								}
								if ($va_address['city']) {
									$vs_address.= $va_address['city'].", ";
								}
								if ($va_address['stateprovince']) {
									$vs_address.= $va_address['stateprovince'];
								}
								if ($va_address['postalcode']) {
									$vs_address.= " ".$va_address['postalcode'];
								}
								if ($va_address['country']) {
									$vs_address.= "<br/>".$va_address['country'];
								}																																
							}
						}
						if ($vs_address != "") {
							print "<div class='unit'>".$vs_address."</div>";
						}
					}
					if ($vs_phones = $t_item->get('ca_entities.telephone_work', array('delimiter' => '<br/>'))) {
						print "<div class='unit'>".$vs_phones."</div>";
					}
					if ($va_email = $t_item->get('ca_entities.email', array('returnAsArray' => true))) {
						print "<div class='unit'>";
						foreach ($va_email as $va_key => $va_email_address) {
							print "<a href='mailto:".$va_email_address."'>".$va_email_address."</a><br/>";
						}
						print "</div>";
					}					
?>			
					<hr/>
					{{{map}}}		
				</div><!-- end col -->
				<div class='col-sm-6 col-md-6 col-lg-6'>
					{{{representationViewer}}}				
				</div><!-- end col -->
			</div><!-- end row -->
			

			<div class="row"><div class='col-sm-12'>

			<hr>
<?php
			if($r_sets && $r_sets->numHits()){
				print '<div class="row"><h3>Featured Galleries</h3>';
				print '
					<div class="jcarousel-wrapper col-sm-12">
						<div class="jcarousel">
							<ul>';
				
						while($r_sets->nextHit()){
							if ($r_sets->get('ca_sets.hide', array('convertCodesToDisplayText' => true)) != "No") {					
								$vn_set_id = $r_sets->get("set_id");
								$t_set = new ca_sets($vn_set_id);
								$va_set_items = caExtractValuesByUserLocale($t_set->getItems(array("thumbnailVersions" => array("iconlarge", "icon"), "checkAccess" => $va_access_values, "limit" => 3)));
								
								if (sizeof($va_set_items) == 1 ) { $vs_one_image = "oneItem";} else { $vs_one_image = "";}
								if (sizeof($va_set_items) > 0 ) {
									print "<li ><div class='setTile ".$vs_one_image."'>";
									$vs_item = 0;
									foreach ($va_set_items as $va_key => $va_set_item) {
										if ($vs_item == 0) {
											print "<div class='setImage'>".caNavLink($this->request, $va_set_item['representation_tag_iconlarge'], '', '', 'Gallery', $vn_set_id)."</div>";
										} else {
											print "<div class='imgPreview'>".$va_set_item['representation_tag_iconlarge']."</div>";
										}
										$vs_item++;
									}
									$item_count = $t_set->getItemCount();
									print "<div class='name' style='clear: both;'>".caNavLink($this->request, $t_set->get('ca_sets.preferred_labels.name'), '', '', 'Gallery', $vn_set_id)." <small>(".$item_count." items)</small></div>";
									
									print "</div></li>";
								}
							}
						}
					print "</ul></div><!-- end jcarousel -->";
		
					print '<a href="#" class="jcarousel-control-prev"><i class="fa fa-angle-left"></i></a>';
					print '<a href="#" class="jcarousel-control-next"><i class="fa fa-angle-right"></i></a>';
?>			
					<!-- Pagination -->
					<p class="jcarousel-pagination">
					<!-- Pagination items will be generated in here -->
					</p>					
				</div>	<!-- end jc wrapper -->
				<script type='text/javascript'>
					jQuery(document).ready(function() {
						/*
						Carousel initialization
						*/
						$('.jcarousel')
							.jcarousel({
								// Options go here
								wrap:'circular'
							});

						/*
						 Prev control initialization
						 */
						$('.jcarousel-control-prev')
							.on('jcarouselcontrol:active', function() {
								$(this).removeClass('inactive');
							})
							.on('jcarouselcontrol:inactive', function() {
								$(this).addClass('inactive');
							})
							.jcarouselControl({
								// Options go here
								target: '-=1'
							});

						/*
						 Next control initialization
						 */
						$('.jcarousel-control-next')
							.on('jcarouselcontrol:active', function() {
								$(this).removeClass('inactive');
							})
							.on('jcarouselcontrol:inactive', function() {
								$(this).addClass('inactive');
							})
							.jcarouselControl({
								// Options go here
								target: '+=1'
							});
						/*
						 Pagination initialization
						 */
						$('.jcarousel-pagination')
							.on('jcarouselpagination:active', 'a', function() {
								$(this).addClass('active');
							})
							.on('jcarouselpagination:inactive', 'a', function() {
								$(this).removeClass('active');
							})
							.jcarouselPagination({
								// Options go here
							});	
					});
				</script>
		</div><!-- end row -->			
<?php
	}
?>
	
			<div class='row'>
				<div class='col-sm-12'>
					<?= $search_browse_bar_bottom; ?>
				</div>
			</div>
			
			
			<div class='row'>
				<div class='col-sm-12'>
				<div class="archivalCollections" id="browseResultsContainerCollections"></div>		

				</div>
			</div>
			<div class='row'>
				<div class='col-sm-12'>
						
				<h3>Collection Objects</h3>
				<div id="browseResultsContainerObjects">
				
				</div><!-- end browseResultsContainerObjects -->
			</div></div><!-- end row -->
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
				});
			</script>
		</div><!-- end container -->
	</div><!-- end col -->
</div><!-- end row -->
</div>
<script type='text/javascript'>
	jQuery(document).ready(function() {
		$('.trimText').readmore({
		  speed: 75,
		  maxHeight: 120
		});
		
		jQuery("#browseResultsContainerCollections").load("<?= caNavUrl($this->request, '', 'EntityDetail', 'collectionsSearch', null, array('dontURLEncodeParameters' => true)); ?>/search/ca_collections.source_id:<?= $t_item->get('ca_entities.idno'); ?>", function() {
			// noop
		});
			
		$('#detailSearchFormTop, #detailSearchFormBottom').on('submit', function (e) {
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
