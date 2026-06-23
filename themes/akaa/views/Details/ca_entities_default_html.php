<?php
	$t_item = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");	
	$va_access_values = caGetUserAccessValues($this->request);
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
					<H1>{{{^ca_entities.preferred_labels.displayname <ifdef code="ca_entities.life_time">(b. ^ca_entities.life_time)</ifdef>}}}</H1>
                    <H2>{{{^ca_entities.preferred_labels.displayname%locale=kor_KO&noLocaleFallback=1}}}</H2>
					<HR/>
				</div><!-- end col -->
			</div><!-- end row -->
			<div class="row">
				<div class='col-sm-6'>
					{{{representationViewer}}}
				</div>			
				<div class='col-sm-6'>
<?php
					if ($va_birth = $t_item->get('ca_entities.birth_place')) {
						$va_birth = preg_replace('/\[.*\]+/', '', $va_birth);
						print "<div class='unit'><label>Place of Birth</label>".$va_birth."</div>";
					}
					if ($va_death = $t_item->get('ca_entities.place_death')) {
						$va_death = preg_replace('/\[.*\]+/', '', $va_death);
						print "<div class='unit'><label>Place of Death</label>".$va_death."</div>";
					}
					if ($va_heritage = $t_item->get('ca_entities.cultural_hert')) {
						print "<div class='unit'><label>Cultural Heritage</label>".$va_heritage."</div>";
					}
?>
	  		  		<!-- 
{{{<ifdef code="ca_entities.immigration_date"><div class="unit"><label>Year of Immigration / Move to U.S</label>
						<unit relativeTo="ca_entities.immigration_date" delimiter="<br/>">^ca_entities.immigration_date</unit>
					</div></ifdef>}}}
 -->   
<?php
					if ($va_bio = $t_item->get('ca_entities.biography')) {
						print "<div class='unit'><label>Biography</label>".$va_bio."</div>";
					}
					if ($va_statement = $t_item->get('ca_entities.artist_statement')) {
						print "<div class='unit'><label>Artist Statement</label>".$va_statement."</div>";
					}
?>
					{{{<ifdef code="ca_entities.external_link.url_entry"><div class="unit"><label>Official Website</label>
						<unit relativeTo="ca_entities.external_link" delimiter="<br/>">
							<a href="^ca_entities.external_link.url_entry" target="_blank"><ifdef code="ca_entities.external_link.url_source">^ca_entities.external_link.url_source</ifdef><ifnotdef code="ca_entities.external_link.url_source">^ca_entities.external_link.url_entry</ifnotdef> <span class='glyphicon glyphicon glyphicon-new-window' aria-hidden='true'></span></a>
						</unit>
					</div></ifdef>}}}
<?php
					if ($va_credit = $t_item->get('ca_entities.credit_line')) {
						print "<div class='unit'><label>Image Credit Line</label>".$va_credit."</div>";
					}
?>

<?php
					if ($va_interviews = $t_item->get('ca_objects.object_id', array('restrictToTypes' => 'interview', 'checkAccess' => $va_access_values))) {
						$t_interview = new ca_objects($va_interviews);
						print "<div class='unit'><label>".caDetailLink($this->request, 'Artist Interview', '', 'ca_objects', $va_interviews)."</label></div>";
						print caDetailLink($this->request, $t_interview->get('ca_object_representations.media.widepreview'), '', 'ca_objects', $va_interviews)."<br/><br/>";
					}
#					if ($va_interview = $t_item->get('ca_entities.interview')) {
#						print "<div class='unit'><label>Interview Excerpt</label>".$va_interview."</div>";
#					}										
?>					
				</div><!-- end col -->

			</div><!-- end row -->
{{{<ifcount code="ca_objects" min="1" restrictToTypes="image">
			<br/><br/><br/>
			<div class="row">
				<div class="col-sm-12">
					<H2>Featured Artworks</H2><HR/>
				</div>
			</div>
			<div class="row">
				<div id="browseResultsContainer">
					<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>
				</div><!-- end browseResultsContainer -->
			</div><!-- end row -->
			<script type="text/javascript">
				jQuery(document).ready(function() {
					jQuery("#browseResultsContainer").load("<?php print caNavUrl($this->request, '', 'Browse', 'artworks', array('facet' => 'entity_facet', 'id' => '^ca_entities.entity_id'), array('dontURLEncodeParameters' => true)); ?>", function() {
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
{{{<ifcount code="ca_objects" min="1" restrictToTypes="publication">
			<br/><br/><br/>
			<div class="row">
				<div class="col-sm-12">
					<H2>Publications</H2><HR/>
				</div>
			</div>
			<div class="row">
				<div id="browseResultsContainer2">
					<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>
				</div><!-- end browseResultsContainer -->
			</div><!-- end row -->
			<script type="text/javascript">
				jQuery(document).ready(function() {
					jQuery("#browseResultsContainer2").load("<?php print caNavUrl($this->request, '', 'Browse', 'publications', array('facet' => 'entity_facet', 'id' => '^ca_entities.entity_id'), array('dontURLEncodeParameters' => true)); ?>", function() {
						jQuery('#browseResultsContainer2').jscroll({
							autoTrigger: true,
							loadingHtml: '<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>',
							padding: 20,
							nextSelector: 'a.jscroll-next'
						});
					});
					
					
				});
			</script>
</ifcount>}}}
{{{<ifcount code="ca_objects" min="1" restrictToTypes="physical_object">
			<br/><br/><br/>
			<div class="row">
				<div class="col-sm-12">
					<H2>AKAA Collection</H2><HR/>
				</div>
			</div>
			<div class="row">
				<div id="browseResultsContainer3">
					<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>
				</div><!-- end browseResultsContainer -->
			</div><!-- end row -->
			<script type="text/javascript">
				jQuery(document).ready(function() {
					jQuery("#browseResultsContainer3").load("<?php print caNavUrl($this->request, '', 'Browse', 'akaa_collection', array('facet' => 'entity_facet', 'id' => '^ca_entities.entity_id'), array('dontURLEncodeParameters' => true)); ?>", function() {
						jQuery('#browseResultsContainer3').jscroll({
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
