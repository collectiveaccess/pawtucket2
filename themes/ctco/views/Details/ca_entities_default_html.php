<?php
	$t_item = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");	
?>
<div class="container"><div class="row">
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
					<H4>{{{^ca_entities.preferred_labels.displayname}}}</H4>
<?php
					if ($vs_nat = $t_item->get('ca_entities.nationalityCreator', array('delimiter' => '<br/>'))) {
						print "<div class='unit'><h6>Nationality</h6>".$vs_nat."</div>";
					}
					if ($vs_birth = $t_item->get('ca_entities.birthplace', array('delimiter' => '<br/>'))) {
						print "<div class='unit'><h6>Birthplace</h6>".$vs_birth."</div>";
					}
					if ($vs_life = $t_item->get('ca_entities.life_dates', array('delimiter' => '<br/>'))) {
						print "<div class='unit'><h6>Life Dates</h6>".$vs_life."</div>";
					}
					if ($vs_titles = $t_item->get('ca_entities.titles', array('delimiter' => '<br/>'))) {
						print "<div class='unit'><h6>Titles</h6>".$vs_titles."</div>";
					}
					if ($vs_occupation = $t_item->get('ca_entities.occupation', array('delimiter' => '<br/>'))) {
						print "<div class='unit'><h6>Occupation</h6>".$vs_occupation."</div>";
					}
					if ($vs_education = $t_item->get('ca_entities.education', array('delimiter' => '<br/>'))) {
						print "<div class='unit'><h6>Education</h6>".$vs_education."</div>";
					}
					if ($vs_published = $t_item->get('ca_entities.published', array('delimiter' => '<br/>'))) {
						print "<div class='unit'><h6>Published</h6>".$vs_published."</div>";
					}
					if ($vs_gender = $t_item->get('ca_entities.genderCreator', array('convertCodesToDisplayText' => true))) {
						print "<div class='unit'><h6>Gender</h6>".$vs_gender."</div>";
					}
					if ($vs_bio = $t_item->get('ca_entities.biography')) {
						print "<div class='unit'><h6>Biography</h6>".$vs_bio."</div>";
					}																						
?>				
					{{{<ifcount code="ca_collections" min="1" max="1"><H6>Related collection</H6></ifcount>}}}
					{{{<ifcount code="ca_collections" min="2"><H6>Related collections</H6></ifcount>}}}
					{{{<unit relativeTo="ca_collections" delimiter="<br/>"><l>^ca_collections.preferred_labels.name</l></unit>}}}
					
					{{{<ifcount code="ca_entities.related" min="1" max="1"><H6>Related person</H6></ifcount>}}}
					{{{<ifcount code="ca_entities.related" min="2"><H6>Related people</H6></ifcount>}}}
					{{{<unit relativeTo="ca_entities" delimiter="<br/>"><l>^ca_entities.related.preferred_labels.displayname</l></unit>}}}
					
					{{{<ifcount code="ca_occurrences" min="1" max="1"><H6>Related occurrence</H6></ifcount>}}}
					{{{<ifcount code="ca_occurrences" min="2"><H6>Related occurrences</H6></ifcount>}}}
					{{{<unit relativeTo="ca_occurrences" delimiter="<br/>"><l>^ca_occurrences.preferred_labels.name</l></unit>}}}
					
					{{{<ifcount code="ca_places" min="1" max="1"><H6>Related place</H6></ifcount>}}}
					{{{<ifcount code="ca_places" min="2"><H6>Related places</H6></ifcount>}}}
					{{{<unit relativeTo="ca_places" delimiter="<br/>"><l>^ca_places.preferred_labels.name</l></unit>}}}				
				</div><!-- end col -->
				<div class='col-sm-6 col-md-6 col-lg-6'>
					{{{<ifcount code="ca_objects" min="1" max="1"><unit relativeTo="ca_objects" delimiter=" "><div class='singleImage'><l>^ca_object_representations.media.small</l><br/><l>^ca_objects.preferred_labels.name</l><br/></unit></div></ifcount>}}}
<?php			
				# Comment and Share Tools
				if ($vn_comments_enabled | $vn_share_enabled) {
						
					print '<div id="detailTools">';
					if ($vn_comments_enabled) {
?>				
						<div class="detailTool"><a href='#' onclick='jQuery("#detailComments").slideToggle(); return false;'><span class="glyphicon glyphicon-comment"></span>Comments (<?php print sizeof($va_comments); ?>)</a></div><!-- end detailTool -->
						<div id='detailComments'><?php print $this->getVar("itemComments");?></div><!-- end itemComments -->
<?php				
					}
					if ($vn_share_enabled) {
						print '<div class="detailTool"><span class="glyphicon glyphicon-share-alt"></span>'.$this->getVar("shareLink").'</div><!-- end detailTool -->';
					}
					print '</div><!-- end detailTools -->';
				}				
?>
					
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
</div><!-- end row --></div><!-- end row -->