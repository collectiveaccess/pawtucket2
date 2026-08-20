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
				<div class='col-sm-6 col-md-6 col-lg-6'>
					<!-- <H1>{{{^ca_entities.preferred_labels.displayname}}}</H1>
					<H2>{{{^ca_entities.type_id}}}</H2> -->
					{{{representationViewer}}}
				</div><!-- end col -->

				<div class='col-sm-6 col-md-6 col-lg-6'>
					<H1>{{{^ca_entities.preferred_labels.displayname}}}</H1>
					<H2>{{{^ca_entities.type_id}}}</H2>

					{{{<ifdef code="ca_entities.biography">
						<div class="flabel">About</div>^ca_entities.biography<br/>
					</ifdef>}}}

					{{{<ifdef code="ca_entities.lifespan">
						<div class="flabel">Life Span</div>^ca_entities.lifespan<br/>
					</ifdef>}}}

					{{{<ifdef code="ca_entities.description"><div class='unit'><div class="flabel">Biography</div>^ca_entities.description</div></ifdef>}}}
					
					{{{<ifcount code="ca_entities.collections" min="1" max="1"><div class="flabel">Related collection</div></ifcount>}}}
					{{{<ifcount code="ca_entities.collections" min="2"><div class="flabel">Related collections</div></ifcount>}}}
					{{{<unit relativeTo="ca_entities.collections" delimiter="<br/>"><unit relativeTo="ca_collections"><l>^ca_collections.preferred_labels.name</l></unit></unit>}}}

					{{{<ifcount code="ca_entities.related" min="1" max="1"><div class="flabel">Related person</div></ifcount>}}}
					{{{<ifcount code="ca_entities.related" min="2"><div class="flabel">Related people</div></ifcount>}}}
					{{{<unit relativeTo="ca_entities.related" delimiter="<br/>"><l>^ca_entities.preferred_labels.displayname</l></unit>}}}
					
					{{{<ifcount code="ca_entities.places" min="1" max="1"><div class="flabel">Related place</div></ifcount>}}}
					{{{<ifcount code="ca_entities.places" min="2"><div class="flabel">Related places</div></ifcount>}}}
					{{{<unit relativeTo="ca_entities.places" delimiter="<br/>"><unit relativeTo="ca_places" delimiter="<br/>"><l>^ca_places.preferred_labels.name</l></unit></unit>}}}

				</div><!-- end col -->
			</div><!-- end row -->

			<div class="row">			
				<div class='col-sm-6 col-md-6 col-lg-6'>
					</br>
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
				
			</div><!-- end row -->
			
			{{{<ifcount code="ca_objects" min="1">
				</BR>
				<HR>
				</BR>
				<H1>Related Objects</H1>
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
