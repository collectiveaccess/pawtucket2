<?php
	$t_item = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");	
?>
<div class="row">
	<div class='col-xs-12 navTop'><!--- only shown at small screen size -->
		{{{previousLink}}}{{{resultsLink}}}{{{nextLink}}}
	</div><!-- end detailTop -->
	<div class='navLeftRight col-xs-1 col-sm-1 col-md-1 col-lg-1'>
		<div class="detailNavBgLeft">
			{{{previousLink}}}{{{resultsLink}}}
		</div><!-- end detailNavBgLeft -->
	</div><!-- end col -->
	<div class='col-xs-12 col-sm-10 col-md-10 col-lg-10'>
		<div class="container">
			<div class="row">
				<div class='col-md-12 col-lg-12'>
					<H1>{{{^ca_entities.preferred_labels.displayname}}}</H1>
				</div><!-- end col -->
			</div><!-- end row -->
			<div class="row">			
				<div class='col-sm-12'>
					{{{<ifdef code="ca_entities.nonpreferred_labels.displayname"><div class='unit'><label>Alternate Names</label>^ca_entities.nonpreferred_labels.displayname%delimiter=<br/> </div></ifdef>}}}
					{{{<ifdef code="ca_entities.counties"><div class='unit'><label><ifcount code="ca_entities.counties" min="1" max="1">County</ifcount><ifcount code="ca_entities.counties" min="2">Counties</ifcount></label>^ca_entities.counties%delimiter=,_</div></ifdef>}}}
					{{{<if rule="^ca_entities.type_id !~ /Individual/">
						<ifdef code="ca_entities.website"><div class='unit'><label>Website<ifcount code="ca_entities.website" min="2">s</ifcount></label><unit relativeTo="ca_entities.website" delimiter="<br/>"><a href="^ca_entities.website" target="_blank">^ca_entities.website</a></unit></div></ifdef>
						<ifdef code="ca_entities.address.address1|ca_entities.address.address2|ca_entities.address.city|ca_entities.address.stateprovince|ca_entities.address.postalcode|ca_entities.address.country">
							<div class='unit'><label>Address<ifcount code="ca_entities.address" min="2">es</ifcount></label>
								<unit relativeTo="ca_entities.address" delimiter="<br/><br/>">
									<ifdef code="ca_entities.address.address1">^ca_entities.address.address1 <br/></ifdef>
									<ifdef code="ca_entities.address.address2">^ca_entities.address.address2 <br/></ifdef>
									<ifdef code="ca_entities.address.city">^ca_entities.address.city, </ifdef><ifdef code="ca_entities.address.state">^ca_entities.address.state </ifdef><ifdef code="ca_entities.address.postalcode">^ca_entities.address.postalcode</ifdef><ifdef code="ca_entities.address.country"> ^ca_entities.address.country</ifdef>
								</unit>
							</div>
						</ifdef>
					</if>}}}
				</div><!-- end col -->
			</div><!-- end row -->
			
{{{<ifcount code="ca_objects" min="1">
			<div class="row">
				<div id="browseResultsContainer">
					<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>
				</div><!-- end browseResultsContainer -->
			</div><!-- end row -->
			<script type="text/javascript">
				jQuery(document).ready(function() {
					jQuery("#browseResultsContainer").load("<?php print caNavUrl($this->request, '', 'Search', 'objects', array('search' => 'entity_id:^ca_entities.entity_id'), array('dontURLEncodeParameters' => true)); ?>", function() {
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