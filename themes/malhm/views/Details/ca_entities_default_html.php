<?php
	$t_item = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");	
	$va_access_values = caGetUserAccessValues($this->request);
	
	$entity_source_id = caGetListItemID('object_sources', $t_item->get('ca_entities.idno'));
	
	
	if (($vn_num_objects = ca_objects::find(['source_id' => $entity_source_id], ['checkAccess' => $va_access_values,'returnAs' => 'count'])) > 1000) {
		$vs_num_objects = "1000+ results";
	} else {
		$vs_num_objects = ($vn_num_objects == 1) ? "{$vn_num_objects} result" : "{$vn_num_objects} results";
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
			<div class='row'>
				<div class='col-sm-12'>
					<div class='browseSearchBar'>
						<span class="browseSearchBarHeading">Related Objects</span>
<?php
			
			print 	"<span class='resultCountDetailPage resultCount'>({$vs_num_objects})</span>"; 

		print 		'<form class="detailSearch" role="search" action="" id="detailSearchForm">
						<div class="formOutline">
							<div class="form-group">
								<button type="submit" class="btn-search"><span class="glyphicon glyphicon-search"></span></button>						
								<input type="text" class="form-control" placeholder="Search this Collection" name="search" id="detailSearchInput">
							</div>	
						</div>
					</form>';
		print caNavLink($this->request, "Filter this Collection <i class='fa fa-external-link'></i>", 'filterCollection', '', 'Browse', 'objects', array('facet' => 'source_facet', 'id' => $entity_source_id));
					
		print "</div></div></div>";
?>			
				<div id="browseResultsContainer">
					<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>
				</div><!-- end browseResultsContainer -->
			</div></div><!-- end row -->
			<script type="text/javascript">
				jQuery(document).ready(function() {
					jQuery("#browseResultsContainer").load("<?php print caNavUrl($this->request, '', 'Search', 'objects', array('search' => 'ca_objects.source_id:'.$t_item->get('ca_entities.idno')), array('dontURLEncodeParameters' => true)); ?>", function() {
						jQuery('#browseResultsContainer').jscroll({
							autoTrigger: true,
							loadingHtml: "<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>",
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
		$('#detailSearchForm').on('submit', function (e) {
			e.preventDefault();
			searchTerm = jQuery("#detailSearchInput").val();
			if(searchTerm){
				searchTerm = encodeURIComponent(" AND " + searchTerm);
			}
			jQuery("#browseResultsContainer").load("<?php print caNavUrl($this->request, '', 'Search', 'objects', null, array('dontURLEncodeParameters' => true)); ?>/search/ca_objects.source_id:<?php print $t_item->get('ca_entities.idno'); ?>" + searchTerm, function() {
				jQuery('#browseResultsContainer').jscroll.destroy();
				jQuery('#browseResultsContainer').jscroll({
					autoTrigger: true,
					loadingHtml: "<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>",
					padding: 20,
					nextSelector: 'a.jscroll-next'
				});
			});
		});
	});
</script>
