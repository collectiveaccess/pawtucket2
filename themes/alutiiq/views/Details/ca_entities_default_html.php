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
	<div class='navLeftRight col-xs-1 col-sm-1 col-md-1 col-lg-2'>
		<div class="detailNavBgLeft">
			{{{previousLink}}}{{{resultsLink}}}
		</div><!-- end detailNavBgLeft -->
	</div><!-- end col -->
	<div class='col-xs-12 col-sm-10 col-md-10 col-lg-8'>
		<div class="container">
			<div class="row">
				<div class='col-md-12 col-lg-12 text-center'>
					<H1 class="uk-h1">{{{^ca_entities.preferred_labels.displayname}}}</H1>
					{{{<ifdef code="ca_entities.description">
						<div class='unit'>^ca_entities.description</div>
					</ifdef>}}}
					<hr/>
					{{{<ifdef code="ca_entities.website|ca_entities.online_collection"><div class="link"><ifdef code="ca_entities.website"><a href="^ca_entities.website" target="_blank">^ca_entities.website <i class="fa fa-external-link" aria-hidden="true"></i></a></ifdef><ifdef code="ca_entities.website,ca_entities.online_collection"><br/></ifdef><ifdef code="ca_entities.online_collection"><a href="^ca_entities.online_collection" target="_blank">Online Collection <i class="fa fa-external-link" aria-hidden="true"></i></a></ifdef></div></ifdef>}}}
					<HR/>
				</div><!-- end col -->
			</div><!-- end row -->
			<div class="row">			
				<div class='col-sm-6 col-md-6 col-lg-6'>
					{{{<ifdef code="ca_entities.address">
						<div class='unit'>
							<ifdef code="ca_entities.address.address1">^ca_entities.address.address1<br/></ifdef>
							<ifdef code="ca_entities.address.address2">^ca_entities.address.address2<br/></ifdef>
							<ifdef code="ca_entities.address.city">^ca_entities.address.city, </ifdef><ifdef code="ca_entities.address.stateprovince">^ca_entities.address.stateprovince </ifdef><ifdef code="ca_entities.address.postalcode">^ca_entities.address.postalcode</ifdef><ifdef code="ca_entities.address.postalcode|ca_entities.address.stateprovince|ca_entities.address.city"><br/></ifdef>
							<ifdef code="ca_entities.address.country">^ca_entities.address.country</ifdef>
						</div></ifdef>}}}
					{{{<ifdef code="ca_entities.telephone_work">
						<div class='unit'><label>Telephone</label>^ca_entities.telephone_work</div>
					</ifdef>}}}
					{{{<ifdef code="ca_entities.email">
						<div class='unit'><label>E-mail</label><a href="mailto:^ca_entities.email">^ca_entities.email</a></div>
					</ifdef>}}}
					
					{{{<ifcount code="ca_collections" min="1">
						<ifcount code="ca_collections" min="1" max="1"><label>Collection</label></ifcount>
						<ifcount code="ca_collections" min="2"><label>collections</label></ifcount>
						<span class="trimText"><unit relativeTo="ca_collections" delimiter="<br/>">^ca_collections.preferred_labels.name</unit></span>
					</ifcount>}}}					
<?php
				# Comment and Share Tools
				if ($vn_comments_enabled | $vn_share_enabled) {
						
					print '<div id="detailTools">';
					if ($vn_comments_enabled) {
?>				
						<div class="detailTool"><a href='#' onclick='jQuery("#detailComments").slideToggle(); return false;'><span class="glyphicon glyphicon-comment" aria-label="<?php print _t("Comments and tags"); ?>"></span>Comments (<?php print sizeof($va_comments); ?>)</a></div><!-- end detailTool -->
						<div id='detailComments'><?php print $this->getVar("itemComments");?></div><!-- end itemComments -->
<?php				
					}
					if ($vn_share_enabled) {
						print '<div class="detailTool"><span class="glyphicon glyphicon-share-alt" aria-label="'._t("Share").'"></span>'.$this->getVar("shareLink").'</div><!-- end detailTool -->';
					}
					print '</div><!-- end detailTools -->';
				}				
?>
					
				</div><!-- end col -->
<?php
				if($vs_map = trim($this->getVar("map"))){	
?>
				<div class="col-sm-6">
					<?php print $vs_map; ?>
				</div>
<?php
				}
?>
			</div><!-- end row -->
			
{{{<unit relativeTo="ca_collections" length="1"><ifcount code="ca_objects" min="1">
			<div class="row">
				<div class="col-sm-12">
					<HR/><H2>Object<ifcount code="ca_objects" min="2">s</ifcount></H2>
				</div>
			</div>
			<div class="row">
				<div id="browseResultsContainer">
					<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>
				</div><!-- end browseResultsContainer -->
			</div><!-- end row -->
			<script type="text/javascript">
				jQuery(document).ready(function() {
					jQuery("#browseResultsContainer").load("<?php print caNavUrl($this->request, '', 'Browse', 'amutatObjects', array('facet' => 'institution_facet', 'id' => '^ca_entities.entity_id'), array('dontURLEncodeParameters' => true)); ?>", function() {
						jQuery('#browseResultsContainer').jscroll({
							autoTrigger: true,
							loadingHtml: '<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>',
							padding: 20,
							nextSelector: 'a.jscroll-next'
						});
					});
					
					
				});
			</script>
</ifcount></unit>}}}
		</div><!-- end container -->
	</div><!-- end col -->
	<div class='navLeftRight col-xs-1 col-sm-1 col-md-1 col-lg-2'>
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