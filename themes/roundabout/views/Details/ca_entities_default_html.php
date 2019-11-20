<?php
	$t_item = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");	
?>
<div class="row pt-1 pb-1">
	<div class='col-xs-12 navTop'><!--- only shown at small screen size -->
		{{{previousLink}}}{{{resultsLink}}}{{{nextLink}}}
	</div><!-- end detailTop -->
	<div class='navLeftRight col-xs-1 col-sm-1 col-md-1 col-lg-1 pt-2'>
		<div class="detailNavBgLeft">
			{{{previousLink}}}<br>{{{resultsLink}}}
		</div><!-- end detailNavBgLeft -->
	</div><!-- end col -->
	<div class='col-md-10 col-lg-10 pt-4 pb-5 entity-image'>
					<H1 class= "text-center">{{{^ca_entities.preferred_labels.displayname}}}</H1>
				{{{<ifcount code="ca_objects_x_ca_object_representations" ><div class='unit'><unit relativeTo="ca_objects" delimiter=" " start="0" length="1">^ca_object_representations.media.large</unit></div></ifcount>}}}
<!-- <?php
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
?> -->
					
		</div><!-- end col -->
		<div class='navLeftRight col-xs-1 col-sm-1 col-md-1 col-lg-1 pt-2'>
		<div class="detailNavBgRight">
			{{{nextLink}}}
		</div><!-- end detailNavBgLeft -->
	</div><!-- end col -->
</div><!-- end row -->
			<div class="row">
				<div class='col-sm-12'>
					{{{<ifdef code="ca_entities.biography" delimiter="<br>"><H6>^ca_entities.preferred_labels.displayname Biography</H6>^ca_entities.biography%makeFirstUpper<br/></ifdef>}}}
				</div>
				<div class='col-sm-12 pt-2'>
					{{{<ifcount code="ca_occurrences" restrictToTypes="productions" min="1" max="1"><H6 class="pt-2">Stage Production</H6></ifcount>}}}
					{{{<ifcount code="ca_occurrences" restrictToTypes="productions" min="2"><H6 class="pt-2">Stage Productions</H6></ifcount>}}}
				</div>
				{{{<unit relativeTo="ca_entities_x_occurrences" restrictToTypes="productions" delimiter="<br/>"><div class='col-sm-6 col-md-4 bright'>^ca_relationship_types.preferred_labels.typename%makeFirstUpper for <unit relativeTo="ca_occurrences" delimiter="<br/>"><l>^ca_occurrences.preferred_labels.name</l></unit></unit></div>}}}
				<div class='col-sm-12 pt-2'>
					{{{<ifcount code="ca_collections" min="1" max="1"><H6>In Collection:</H6></ifcount>}}}
					{{{<ifcount code="ca_collections" min="2"><H6>In Collections</H6></ifcount>}}}
					{{{<unit relativeTo="ca_entities_x_collections" delimiter="<br/>"><div class='col-sm-4'><unit relativeTo="ca_collections"><l>^ca_collections.preferred_labels.name</l> (^relationship_typename)</unit></unit></div>}}}
				</div>
			</div><!-- end row -->
			
{{{<ifcount code="ca_objects" min="1">
		<div class="row pt-2">
		<div class="col-sm-12"><h2 class="text-center pt-2 pb-2">Related Items</h2></div>
			<div class="card-columns">
				<unit relativeTo="ca_objects" delimiter=" " start="0"><div class='card'><l>^ca_object_representations.media.large</l><div class="title text-center"><l>^ca_objects.preferred_labels.name</l></div></unit></div>
			</div>
			</ifcount>}}}
		</div><!-- end container -->
	</div><!-- end col -->

<script type='text/javascript'>
	jQuery(document).ready(function() {
		$('.trimText').readmore({
		  speed: 75,
		  maxHeight: 120
		});
	});
</script>