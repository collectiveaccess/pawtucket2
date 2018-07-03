<?php
	$t_item = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");	
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
			<h4>Related Objects</h4>			
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
	});
</script>