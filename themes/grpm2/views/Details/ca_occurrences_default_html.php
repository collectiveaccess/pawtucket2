<?php
	$t_item = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");	
	$vs_page_url = $this->request->config->get("site_host").caNavUrl($this->request, '', 'Detail', 'occurrences/'.$t_item->get("occurrence_id"));
	
	MetaTagManager::addMetaProperty("og:image", caGetThemeGraphicUrl($this->request, 'GRPM_blue_sq.png'));

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
					<H4>{{{^ca_occurrences.preferred_labels.name}}}</H4>
					<!-- share buttons -->
					<br/><div class="shareBar">
						<div class="shareButton"> 
							<!-- Your share button code -->
							<div class="fb-share-button" 
							data-href="<?php print $vs_page_url; ?>" 
							data-layout="button" 
							data-size="large" 
							data-mobile-iframe="true">
							</div>
						</div>
						<div class="shareButton">
							<a class="twitter-share-button"
							  href="https://twitter.com/share"
							  data-size="large"
							  data-text="<?php print $t_item->get("ca_occurrences.preferred_labels.name"); ?>"
							  data-url="<?php print $vs_page_url; ?>"
							  data-hashtags=""
							  data-via="GRMuseum"
							  data-related="">
							Tweet
							</a>
						</div>
						<div class="shareButton">
							<a href="https://www.pinterest.com/pin/create/button/" data-pin-do="buttonBookmark" data-pin-tall="true"></a>
						</div>
						<div class="shareButton">
	<?php
							print '<div class="btn-default"><span class="glyphicon glyphicon-envelope"></span> '.$this->getVar("shareLink").'</div>';
	?>
						</div>
						<div style="clear:left;"></div>
					</div>
					<H6>{{{^ca_occurrences.type_id}}}{{{<ifdef code="ca_occurrences.idno">, ^ca_occurrences.idno</ifdef>}}}</H6>
				</div><!-- end col -->
			</div><!-- end row -->
			<div class="row">			
				<div class='col-sm-6 col-md-6 col-lg-6'>
					{{{<ifdef code="ca_occurrences.description"><H6>Description</H6><span class="trimText">^ca_occurrences.description</span><br/></ifdef>}}}
					{{{<ifcount code="ca_objects" min="1" max="1"><div class='unit'><unit relativeTo="ca_objects" delimiter=" "><l>^ca_object_representations.media.large</l><div class='caption'>Related Object: <l>^ca_objects.preferred_labels.name</l></div></unit></div></ifcount>}}}
				</div><!-- end col -->
				<div class='col-md-6 col-lg-6'>
					{{{<ifcount code="ca_collections" min="1" max="1"><H6>Related collection</H6></ifcount>}}}
					{{{<ifcount code="ca_collections" min="2"><H6>Related collections</H6></ifcount>}}}
					{{{<unit relativeTo="ca_collections" delimiter="<br/>"><l>^ca_collections.preferred_labels.name</l></unit>}}}
					
					{{{<ifcount code="ca_entities" min="1" max="1"><H6>Related person</H6></ifcount>}}}
					{{{<ifcount code="ca_entities" min="2"><H6>Related people</H6></ifcount>}}}
					{{{<unit relativeTo="ca_entities" delimiter="<br/>"><l>^ca_entities.preferred_labels.displayname</l></unit>}}}
					
					{{{<ifcount code="ca_occurrences.related" min="1" max="1"><H6>Related occurrence</H6></ifcount>}}}
					{{{<ifcount code="ca_occurrences.related" min="2"><H6>Related occurrences</H6></ifcount>}}}
					{{{<unit relativeTo="ca_occurrences.related" delimiter="<br/>"><l>^ca_occurrences.preferred_labels.name</l></unit>}}}
					
					{{{<ifcount code="ca_places" min="1" max="1"><H6>Related place</H6></ifcount>}}}
					{{{<ifcount code="ca_places" min="2"><H6>Related places</H6></ifcount>}}}
					{{{<unit relativeTo="ca_places" delimiter="<br/>"><l>^ca_places.preferred_labels.name</l></unit>}}}					
				</div><!-- end col -->
			</div><!-- end row -->
{{{<ifcount code="ca_objects" min="2">
			<div class="row">
				<div id="browseResultsContainer">
					<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>
				</div><!-- end browseResultsContainer -->
			</div><!-- end row -->
			<script type="text/javascript">
				jQuery(document).ready(function() {
					jQuery("#browseResultsContainer").load("<?php print caNavUrl($this->request, '', 'Search', 'objects', array('search' => 'occurrence_id:^ca_occurrences.occurrence_id', 'view' => 'thumbnails'), array('dontURLEncodeParameters' => true)); ?>", function() {
						jQuery('#browseResultsContainer').jscroll({
							autoTrigger: true,
							loadingHtml: '<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>',
							padding: 20,
							nextSelector: 'a.jscroll-next'
						});
					});
					
					
				});
			</script>
</ifcount>}}}		</div><!-- end container -->
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