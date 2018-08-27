<?php
	$t_item = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");	
	
	$vs_link = array_shift($t_item->get('ca_entities.external_link.url_entry', ['returnAsArray' => true]));
	$vs_type = $t_item->get('ca_entities.type_id', array('convertCodesToDisplayText' => true));
	$vs_detail_facet = "";
	if(strtolower($vs_type) == "institution"){
		$vs_detail_facet = "institution_facet";
	}else{
		$vs_detail_facet = "entity_facet";
	}
?>
<div class="container">
<div class="row">
<?php
if ($vs_type == "Member Institution") {
	$va_images = $t_item->getRepresentations(array('large'));	
	if($va_images){
?>   
		<div class="jcarousel-wrapper">
			<!-- Carousel -->
			<div class="jcarousel">
				<ul>
<?php
					foreach($va_images as $va_key => $va_image){
							print "<li><div class='frontSlide'>";
							print $va_image['tags']['large'];
							print "</div></li>";
							$vb_item_output = true;	
					}
?>
				</ul>
			</div><!-- end jcarousel -->
<?php
			if($vb_item_output){
?>
			<!-- Prev/next controls -->
			<a href="#" class="jcarousel-control-prev"><i class="fa fa-angle-left"></i></a>
			<a href="#" class="jcarousel-control-next"><i class="fa fa-angle-right"></i></a>
		
			<!-- Pagination -->

<?php
			}
?>
		</div><!-- end jcarousel-wrapper -->
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
<?php
	}
}	
?>		
	
	<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
		<div class="container">
			<div class="row">
<?php
				if ($vs_type == "Member Institution") {
					print "<div class='col-sm-2 col-md-2 col-lg-2'></div>";
				}
?>						
				<div class='col-sm-5 col-md-5 col-lg-5'>
					<h2>{{{ca_entities.preferred_labels}}}</h2>
				</div><!-- end col -->
			</div><!-- end row -->
			<div class="row">
				
<?php
					if ($vs_type == "Member Institution") {
						print "<div class='col-sm-2 col-md-2 col-lg-2 leftBar'>";
						
						if ($vs_inst_image = $t_item->get('ca_entities.inst_images.medium.tag')) {
							print "<div class='instLogo'><a href='".$vs_link."' target='_blank'>".$vs_inst_image."</a></div>";
						}
						print "<div style='text-align:center;padding-top:15px;'><a href='".$vs_link."' target='_blank'>More Information</a></div>";
						
						if ($va_social_links = $t_item->get('ca_entities.social_links', array('returnWithStructure' => true, 'convertCodesToDisplayText' => true))) {
							print "<div class='socialLinks'>";
							foreach ($va_social_links as $va_key => $va_social_link_t) {
								foreach ($va_social_link_t as $va_key => $va_social_link) {
									if ($va_social_link['social_platform'] == "Facebook") {
										print "<a href='".$va_social_link['social_link']."'><i class='fa fa-facebook-square'></i></a>";
									} elseif ($va_social_link['social_platform'] == "Twitter") {
										print "<a href='".$va_social_link['social_link']."'><i class='fa fa-twitter-square'></i></a>";
									} elseif ($va_social_link['social_platform'] == "Instagram") {
										print "<a href='".$va_social_link['social_link']."'><i class='fa fa-instagram-square'></i></a>";
									} elseif ($va_social_link['social_platform'] == "Pinterest") {
										print "<a href='".$va_social_link['social_link']."'><i class='fa fa-pinterest-square'></i></a>";
									}
								}
							}
							print "</div>";
						}
						
						print "</div><!-- end col -->";
					}

?>																
				<div class='col-sm-5 col-md-5 col-lg-5'>
<?php
					if ($vs_description = $t_item->get('ca_entities.biography')) {
						print "<div >".$vs_description."</div>";
					}
					if ($vs_source = $t_item->get('ca_entities.biography_source')) {
						print "<div >Biography source: ".$vs_source."</div>";
					}													
?>					
				</div><!-- end col -->
				<div class='col-sm-5 col-md-5 col-lg-5'>
<?php
					#print $this->getVar('representationViewer');
?>				
					{{{map}}}	
					
<?php
					if ($vs_type == "Member Institution") { print "<hr>"; }
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
								if ($va_address['state']) {
									$vs_address.= $va_address['state'];
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
					if ($vs_email = $t_item->get('ca_entities.email')) {
						print "<div class='unit'><span class='data'>Email</span><span class='meta'><a href='mailto:".$vs_email."'>".$vs_email."</a></span></div>";
					}	 
					if ($vs_telephone = $t_item->get('ca_entities.telephone')) { 
						print "<div class='unit'><span class='data'>Telephone</span><span class='meta'>".$vs_telephone."</span></div>";
					}									
					if ($vs_life_dates = $t_item->get('ca_entities.life_dates')) {
						print "<div class='unit'><span class='data'>Life Dates</span><span class='meta'>".$vs_life_dates."</span></div>";
					}
					if ($vs_nationality = $t_item->get('ca_entities.nationality')) {
						print "<div class='unit'><span class='data'>Nationality</span><span class='meta'>".$vs_nationality."</span></div>";
					}					
					if ($vs_brand = $t_item->get('ca_entities.brand', array('convertCodesToDisplayText' => true))) {
						print "<div class='unit'><span class='data'>Brand Names</span><span class='meta'>".$vs_brand."</span></div>";
					}
					if ($vs_founded = $t_item->get('ca_entities.entity_founded')) {
						print "<div class='unit'><span class='data'>Date Founded</span><span class='meta'>".$vs_founded."</span></div>";
					}
					if ($vs_inc = $t_item->get('ca_entities.entity_incorporated')) {
						print "<div class='unit'><span class='data'>Date incorporated</span><span class='meta'>".$vs_inc."</span></div>";
					}					
					if ($vs_liq = $t_item->get('ca_entities.entity_liquidated')) {
						print "<div class='unit'><span class='data'>Date of liquidation</span><span class='meta'>".$vs_liq."</span></div>";
					}
					if ($vs_ent = $t_item->getWithTemplate('<unit relativeTo="ca_entities.related"><l>^ca_entities.preferred_labels</l> (^relationship_typename)</unit>')) {
						print "<div class='unit'><span class='data'>Related Entities</span><span class='meta'>".$vs_ent."</span></div>";
					}	
					if ($vs_occ = $t_item->getWithTemplate('<unit relativeTo="ca_occurrences"><l>^ca_occurrences.preferred_labels</l> (^relationship_typename)</unit>')) {
						print "<div class='unit'><span class='data'>Related Events</span><span class='meta'>".$vs_occ."</span></div>";
					}
					if ($vs_type != "Member Institution") {
						if ($va_external_links = $t_item->get('ca_entities.external_link', array('returnWithStructure' => true))) {
							print "<div class='unit'><span class='data'>Related Links</span><span class='meta'>";
							foreach ($va_external_links as $va_key => $va_external_link_t) {
								foreach ($va_external_link_t as $va_key => $va_external_link) {
									if ($va_external_link['url_source']) {
										print "<a href='".$va_external_link['url_entry']."' target='_blank'>".$va_external_link['url_source']."</a><br/>";
									} else {
										print "<a href='".$va_external_link['url_entry']."' target='_blank'>".$va_external_link['url_entry']."</a><br/>";
									}
								}
							}
							print "</span></div>";
						}
					}									
					
?>													
				</div>

			</div><!-- end row -->
<?php
		if ($vs_type == "Member Institution") {
?>			
			<div class='row cats'>
				<div class='col-sm-1'></div>
				<div class='col-sm-1'><span class='category' data-toggle="popover" data-trigger="hover" data-content="Architecture"><?php print caNavLink($this->request, caGetThemeGraphic($this->request, 'architecture.png'), '', '', 'Browse', 'objects', array('facet' => 'topic_facet', 'id' => 542)); ?></span></div>
				<div class='col-sm-1'><span class='category' data-toggle="popover" data-trigger="hover" data-content="Art"><?php print caNavLink($this->request, caGetThemeGraphic($this->request, 'art.png'), '', '', 'Browse', 'objects/facet/topic_facet/id/543'); ?></span></div>
				<div class='col-sm-1'><span class='category' data-toggle="popover" data-trigger="hover" data-content="Communications and Technology"><?php print caNavLink($this->request, caGetThemeGraphic($this->request, 'communication.png'), '', '', 'Browse', 'objects/facet/topic_facet/id/544'); ?></span></div>
				<div class='col-sm-1'><span class='category' data-toggle="popover" data-trigger="hover" data-content="Agriculture and Fishing"><?php print caNavLink($this->request, caGetThemeGraphic($this->request, 'agriculture.png'), '', '', 'Browse', 'objects/facet/topic_facet/id/545'); ?></span></div>
				<div class='col-sm-1'><span class='category' data-toggle="popover" data-trigger="hover" data-content="Clothing and Accessories"><?php print caNavLink($this->request, caGetThemeGraphic($this->request, 'clothing.png'), '', '', 'Browse', 'objects/facet/topic_facet/id/546'); ?></span></div>
				<div class='col-sm-1'><span class='category' data-toggle="popover" data-trigger="hover" data-content="Household Life"><?php print caNavLink($this->request, caGetThemeGraphic($this->request, 'household.png'), '', '', 'Browse', 'objects/facet/topic_facet/id/547'); ?></span></div>
				<div class='col-sm-1'><span class='category' data-toggle="popover" data-trigger="hover" data-content="Industry and Manufacturing"><?php print caNavLink($this->request, caGetThemeGraphic($this->request, 'industry.png'), '', '', 'Browse', 'objects/facet/topic_facet/id/548'); ?></span></div>
				<div class='col-sm-1'><span class='category' data-toggle="popover" data-trigger="hover" data-content="Military"><?php print caNavLink($this->request, caGetThemeGraphic($this->request, 'military.png'), '', '', 'Browse', 'objects/facet/topic_facet/id/549'); ?></span></div>
				<div class='col-sm-1'><span class='category' data-toggle="popover" data-trigger="hover" data-content="Recreation"><?php print caNavLink($this->request, caGetThemeGraphic($this->request, 'recreation.png'), '', '', 'Browse', 'objects/facet/topic_facet/id/550'); ?></span></div>
				<div class='col-sm-1'><span class='category' data-toggle="popover" data-trigger="hover" data-content="Transportation"><?php print caNavLink($this->request, caGetThemeGraphic($this->request, 'transportation.png'), '', '', 'Browse', 'objects/facet/topic_facet/id/551'); ?></span></div>
				<div class='col-sm-1'></div>
			</div>
			<script>
				jQuery(document).ready(function() {
					$('.category').popover(); 
				});
	
			</script>
<?php
		}
?>			
{{{<ifcount code="ca_objects" min="2">
			<div class='row'><div class='col-sm-12'><div class='browseSearchBar'>
<?php
			$vn_num_objects = sizeof($t_item->get("ca_objects", array("returnAsArray" => true)));
			print 	"<div class='resultCount'>".($vn_num_objects > 1 ? $vn_num_objects." Results" : $vn_num_objects." Result")."</div>"; 

		print 		'<form class="detailSearch" role="search" action="" id="detailSearchForm">
						<div class="formOutline">
							<div class="form-group">
								<button type="submit" class="btn-search"><span class="glyphicon glyphicon-search"></span></button>						
								<input type="text" class="form-control" placeholder="Search this Collection" name="search" id="detailSearchInput">
							</div>	
						</div>
					</form>';
		print caNavLink($this->request, "Filter Collection <i class='fa fa-external-link'></i>", 'filterCollection', '', 'Browse', 'objects', array('facet' => $vs_detail_facet, 'id' => $t_item->get('ca_entities.entity_id')));
					
		print "</div></div></div>";
?>
				<script type="text/javascript">
					$('#detailSearchForm').on('submit', function (e) {
						e.preventDefault();
						searchTerm = jQuery("#detailSearchInput").val();
						if(searchTerm){
							searchTerm = encodeURIComponent(" AND " + searchTerm);
						}
						jQuery("#browseResultsContainer").load("<?php print caNavUrl($this->request, '', 'Search', 'objects', null, array('dontURLEncodeParameters' => true)); ?>/search/entity_id:<?php print $t_item->get('ca_entities.entity_id'); ?>" + searchTerm, function() {
							jQuery('#browseResultsContainer').removeData('jscroll').jscroll.destroy();
							jQuery('#browseResultsContainer').jscroll({
								autoTrigger: true,
								loadingHtml: '<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>',
								padding: 20,
								nextSelector: 'a.jscroll-next'
							});
						});
					});
				</script>

			<div class="row">
				<div id="browseResultsContainer">
					<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>
				</div><!-- end browseResultsContainer -->
			</div><!-- end row -->
			<script type="text/javascript">
				jQuery(document).ready(function() {
					jQuery("#browseResultsContainer").load("<?php print caNavUrl($this->request, '', 'Search', 'objects', array('search' => 'entity_id:'.$t_item->get('ca_entities.entity_id')), array('dontURLEncodeParameters' => true)); ?>", function() {
						jQuery('#browseResultsContainer').jscroll({
							autoTrigger: true,
							loadingHtml: '<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>',
							padding: 20,
							nextSelector: 'a.jscroll-next'
						});
					});
					
					
				});
			</script>
</ifcount>}}}
		</div><!-- end container -->
	</div><!-- end col -->
</div><!-- end row -->
</div><!-- end container -->