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
	<div class='col-xs-12 navLeftRight'>
		<small>{{{previousLink}}}{{{resultsLink}}}{{{nextLink}}}</small>
	</div>
	<div class='col-xs-12'>
		<div class="container">
			<div class="row">
				<div class='col-md-12 col-lg-12'>
					<H4>{{{^ca_entities.preferred_labels.displayname}}}</H4>
					<H6>{{{^ca_entities.type_id}}}{{{<ifdef code="ca_entities.idno">, ^ca_entities.idno</ifdef>}}}</H6>
				</div><!-- end col -->
			</div><!-- end row -->
			<div class="row">			
				<div class='col-md-6 col-lg-6'>
					{{{<ifdef code="ca_entities.entity_date"><H6>Date</H6>^ca_entities.entity_date<br/></ifdef>}}}
					{{{<ifdef code="ca_entities.active_dates"><H6>Active Date</H6>^ca_entities.active_dates<br/></ifdef>}}}
					{{{<ifdef code="ca_entities.entity_roles"><H6>Roles</H6>^ca_entities.entity_roles%delimiter=,_<br/></ifdef>}}}
					{{{<ifdef code="ca_entities.other_roles"><H6><ifdef code="ca_entities.entity_roles">Other </ifdef>Roles</H6>^ca_entities.other_roles%delimiter=,_<br/></ifdef>}}}
					{{{<ifdef code="ca_entities.entity_note"><H6>Notes</H6>^ca_entities.entity_note<br/></ifdef>}}}
<?php
				print '<div id="detailTools">';
				# Comment and Share Tools
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
					print '<div class="detailTool"><span class="glyphicon glyphicon-upload"></span>'.caNavLink($this->request, _t("Contribute content"), "", "", "Contribute", "objects", array("ref_table" => "ca_entities", "ref_row_id" => $t_item->get("entity_id"))).'</div><!-- end detailTool -->';
					#print "<div class='detailTool'><span class='glyphicon glyphicon-upload'></span><a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'Contribute', 'objects', array("ref_table" => "ca_entities", "ref_row_id" => $t_item->get("entity_id")))."\"); return false;' >"._t("Contribute content")."</a></div><!-- end detailTool -->";
				}else{
					print "<div class='detailTool'><span class='glyphicon glyphicon-upload'></span><a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'LoginReg', 'LoginForm')."\"); return false;' >"._t("Login to contribute content")."</a></div><!-- end detailTool -->";
				}
				print '</div><!-- end detailTools -->';
?>
					
				</div><!-- end col -->
				<div class='col-md-6 col-lg-6'>
					{{{<ifcount code="ca_collections" min="1" max="1"><H6>Related Collection</H6></ifcount>}}}
					{{{<ifcount code="ca_collections" min="2"><H6>Related Collections</H6></ifcount>}}}
					{{{<unit relativeTo="ca_collections" delimiter="<br/>"><l>^ca_collections.preferred_labels.name</l></unit>}}}
					
					{{{<ifcount code="ca_entities.related" min="1" max="1"><H6>Related Person</H6></ifcount>}}}
					{{{<ifcount code="ca_entities.related" min="2"><H6>Related People</H6></ifcount>}}}
					{{{<unit relativeTo="ca_entities.related" delimiter="<br/>"><l>^ca_entities.related.preferred_labels.displayname</l></unit>}}}
					
					{{{<ifcount code="ca_occurrences" restrictToTypes="event" min="1" max="1"><H6>Related Event</H6></ifcount>}}}
					{{{<ifcount code="ca_occurrences" restrictToTypes="event" min="2"><H6>Related Events</H6></ifcount>}}}
					{{{<unit relativeTo="ca_occurrences" delimiter="<br/>"><l>^ca_occurrences.preferred_labels.name</l></unit>}}}
					
					{{{<ifcount code="ca_occurrences" restrictToTypes="exhibition" min="1" max="1"><H6>Related Exhibition</H6></ifcount>}}}
					{{{<ifcount code="ca_occurrences" restrictToTypes="exhibition" min="2"><H6>Related Exhibitions</H6></ifcount>}}}
					{{{<unit relativeTo="ca_occurrences" delimiter="<br/>"><l>^ca_occurrences.preferred_labels.name</l></unit>}}}
					
					{{{<ifcount code="ca_places" min="1" max="1"><H6>Related Place</H6></ifcount>}}}
					{{{<ifcount code="ca_places" min="2"><H6>Related Places</H6></ifcount>}}}
					{{{<unit relativeTo="ca_places" delimiter="<br/>"><l>^ca_places.preferred_labels.name</l></unit>}}}				
				</div><!-- end col -->
			</div><!-- end row -->
{{{<ifcount code="ca_objects" min="1">
			<div class="row">
				<hr style='margin-top:30px;'>
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
</div><!-- end row -->
<script type='text/javascript'>
	jQuery(document).ready(function() {
		$('.trimText').readmore({
		  speed: 75,
		  maxHeight: 130
		});
	});
</script>