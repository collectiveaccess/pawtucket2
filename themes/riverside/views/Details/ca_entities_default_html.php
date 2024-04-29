<?php
	$t_item = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");	
	$vs_representation_viewer = trim($this->getVar("representationViewer"));
	$va_access_values = caGetUserAccessValues($this->request);
	$vs_image = "";
	if(!$vs_representation_viewer){
		$vs_image = $t_item->getWithTemplate("<unit relativeTo='ca_objects' restrictToRelationshipTypes='Depicted' length='1'>^ca_object_representations.media.large</unit>", array("checkAccess" => $va_access_values));
	}
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
<?php
				print "<div class='inquireButton'>".caNavLink($this->request, "<span class='glyphicon glyphicon-envelope'></span> Inquire", "btn btn-default btn-small", "", "Contact", "Form", array("table" => "ca_entities", "id" => $t_item->get("entity_id")))."</div>";
?>
					<H1>{{{^ca_entities.preferred_labels.displayname}}}</H1>
					<H2>{{{^ca_entities.type_id}}}</H2>
				</div><!-- end col -->
			</div><!-- end row -->
			<div class="row">			
<?php
				if($vs_image || $vs_representation_viewer){
?>
					<div class='col-sm-4 entityImage'>
<?php
					print $vs_image.$vs_representation_viewer;
?>
					</div>
					<div class='col-sm-8'>
<?php
				}else{
?>
					<div class='col-sm-12'>
<?php
				}
?>
					{{{<ifdef code="ca_entities.church_role"><div class='unit'><label>Church Role</label>^ca_entities.church_role%delimiter=,_</div></ifdef>}}}
					{{{<ifdef code="ca_entities.lifespan"><div class='unit'><label>Lifetime</label>^ca_entities.lifespan</div></ifdef>}}}
					{{{<ifdef code="ca_entities.dates_active"><div class='unit'><label>Active Dates</label>^ca_entities.dates_active%delimiter=,_</div></ifdef>}}}
					{{{<ifdef code="ca_entities.position"><div class='unit'><label>Position</label>^ca_entities.position%delimiter=,_</div></ifdef>}}}
					{{{<ifdef code="ca_entities.biography.biography_text"><div class='unit'><label>Biography</label>^ca_entities.biography.biography_text%convertLineBreaks=1<ifdef code="ca_entities.biography.biography_source"><br/><br/>^ca_entities.biography.biography_source</ifdef></div></ifdef>}}}
					
					{{{<ifcount code="ca_occurrences" restrictToTypes="event" min="1"><div class="unit"><label>Related Event<ifcount code="ca_occurrences" min="2" restrictToTypes="event">s</ifcount></label><unit relativeTo="ca_occurrences" delimiter="<br/>" restrictToTypes="event"><l>^ca_occurrences.preferred_labels.name</l></unit></div></ifcount>}}}
					{{{<ifcount code="ca_entities.related" min="1"><div class="unit"><label>Related <ifcount code="ca_entities.related" min="1">Person/Organization</ifcount><ifcount code="ca_entities.related" min="2">People & Organizations</ifcount></label><unit relativeTo="ca_entities.related" delimiter="<br/>"><l>^ca_entities.preferred_labels.displayname</l></unit></div></ifcount>}}}
					{{{<ifcount code="ca_collections" min="1"><div class="unit"><label>Related Collection<ifcount code="ca_collections" min="2">s</ifcount></label><unit relativeTo="ca_collections" delimiter="<br/>"><l>^ca_collections.preferred_labels.name</l></unit></div></ifcount>}}}
					
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
