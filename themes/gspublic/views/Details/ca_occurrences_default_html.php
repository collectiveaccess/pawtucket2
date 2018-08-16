<?php
	$t_item = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");
	$va_access_values = 	$this->getVar("access_values");	
?>
<div class="row">
	<div class='col-xs-12 navTop'><!--- only shown at small screen size -->
		{{{previousLink}}}{{{resultsLink}}}{{{nextLink}}}
	</div><!-- end detailTop -->
	<div class='col-xs-12 navLeftRight'>
		<small>{{{previousLink}}}{{{resultsLink}}}{{{nextLink}}}</small>
	</div>
	<div class='col-xs-12'>
		<div class="container">
			<div class="row">
				<div class='col-md-12 col-lg-12'>
					<H4>{{{^ca_occurrences.preferred_labels.name}}}</H4>
					<H6>{{{^ca_occurrences.type_id}}}</H6>
				</div><!-- end col -->
			</div><!-- end row -->
			<div class="row">			
				<div class='col-sm-6 col-md-6 col-lg-6'>

<?php
				if ($vs_description = $t_item->get('ca_occurrences.description')) {
					print "<div class='unit'><h6>Description</h6>".$vs_description."</div>";
				}				
				# Comment and Share Tools
				print '<div id="detailTools">';
				if ($vn_comments_enabled | $vn_share_enabled) {
						
					if ($vn_comments_enabled) {
?>				
						<div class="detailTool"><a href='#' onclick='jQuery("#detailComments").slideToggle(); return false;'><span class="glyphicon glyphicon-comment"></span>Comments (<?php print sizeof($va_comments); ?>)</a></div><!-- end detailTool -->
						<div id='detailComments'><?php print $this->getVar("itemComments");?></div><!-- end itemComments -->
<?php				
					}
					if ($vn_share_enabled) {
						print '<div class="detailTool"><span class="glyphicon glyphicon-share-alt"></span>'.$this->getVar("shareLink").'</div><!-- end detailTool -->';
					}
				}	
				if($this->request->isLoggedIn()){
					print '<div class="detailTool"><span class="glyphicon glyphicon-upload"></span>'.caNavLink($this->request, _t("Contribute content"), "", "", "Contribute", "objects", array("ref_table" => "ca_occurrences", "ref_row_id" => $t_item->get("occurrence_id"))).'</div><!-- end detailTool -->';
					#print "<div class='detailTool'><span class='glyphicon glyphicon-upload'></span><a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'Contribute', 'objects', array("ref_table" => "ca_occurrences", "ref_row_id" => $t_item->get("occurrence_id")))."\"); return false;' >"._t("Contribute content")."</a></div><!-- end detailTool -->";
				}else{
					print "<div class='detailTool'><span class='glyphicon glyphicon-upload'></span><a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'LoginReg', 'LoginForm')."\"); return false;' >"._t("Login to contribute content")."</a></div><!-- end detailTool -->";
				}
				print '</div><!-- end detailTools -->';					
							
?>
					
				</div><!-- end col -->
				<div class='col-md-6 col-lg-6'>
<?php
					if ($vs_dates = $t_item->get('ca_occurrences.event_dates', array('delimiter' => ', '))) {
						print "<div class='unit'><h6>Date</h6>".$vs_dates."</div>";
					}
?>
					{{{<ifcount code="ca_collections" min="1" max="1"><H6>Related collection</H6></ifcount>}}}
					{{{<ifcount code="ca_collections" min="2"><H6>Related collections</H6></ifcount>}}}
					{{{<unit relativeTo="ca_collections" delimiter="<br/>"><l>^ca_collections.preferred_labels.name</l></unit>}}}
					
					{{{<ifcount code="ca_entities" min="1" max="1"><H6>Related person</H6></ifcount>}}}
					{{{<ifcount code="ca_entities" min="2"><H6>Related people</H6></ifcount>}}}
					{{{<unit relativeTo="ca_entities" delimiter="<br/>"><l>^ca_entities.preferred_labels.displayname</l></unit>}}}
					
					{{{<ifcount code="ca_occurrences.related" restrictToTypes="event" min="1" max="1"><H6>Related event</H6></ifcount>}}}
					{{{<ifcount code="ca_occurrences.related" restrictToTypes="event" min="2"><H6>Related events</H6></ifcount>}}}
					{{{<unit relativeTo="ca_occurrences.related" delimiter="<br/>"><l>^ca_occurrences.related.preferred_labels.name</l></unit>}}}
					
					{{{<ifcount code="ca_occurrences.related" restrictToTypes="exhibition" min="1" max="1"><H6>Related exhibition</H6></ifcount>}}}
					{{{<ifcount code="ca_occurrences.related" restrictToTypes="exhibition" min="2"><H6>Related exhibitions</H6></ifcount>}}}
					{{{<unit relativeTo="ca_occurrences.related" delimiter="<br/>"><l>^ca_occurrences.related.preferred_labels.name</l></unit>}}}
					
					{{{<ifcount code="ca_places" min="1" max="1"><H6>Related place</H6></ifcount>}}}
					{{{<ifcount code="ca_places" min="2"><H6>Related places</H6></ifcount>}}}
					{{{<unit relativeTo="ca_places" delimiter="<br/>"><l>^ca_places.preferred_labels.name</l></unit>}}}				
				</div><!-- end col -->
			</div><!-- end row -->		
{{{<ifcount code="ca_objects" min="1">
			<hr style='margin-top:30px;'>
			<div class="row">
				<div class="col-sm-12">
					<h4>Related Items</h4>
				</div>
			</div>	
			<div class="row">
				<div id="browseResultsContainer">
					<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>
				</div><!-- end browseResultsContainer -->
			</div><!-- end row -->
			<script type="text/javascript">
				jQuery(document).ready(function() {
					jQuery("#browseResultsContainer").load("<?php print caNavUrl($this->request, '', 'Search', 'objects', array('search' => 'occurrence_id:^ca_occurrences.occurrence_id'), array('dontURLEncodeParameters' => true)); ?>", function() {
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
</div><!-- end row -->
<script type='text/javascript'>
	jQuery(document).ready(function() {
		$('.trimText').readmore({
		  speed: 75,
		  maxHeight: 120
		});
	});
</script>