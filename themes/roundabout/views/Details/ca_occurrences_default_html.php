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
	<div class='navLeftRight col-xs-1 col-sm-1 col-md-1 col-lg-1 pt-2'>
		<div class="detailNavBgLeft">
			{{{previousLink}}}<br>{{{resultsLink}}}
		</div><!-- end detailNavBgLeft -->
	</div><!-- end col -->
	<div class='col-sm-10 col-md-10 col-lg-10 pt-4 pb-2'>
		<H1 class= "text-center capitalize">{{{^ca_occurrences.preferred_labels.name ^ca_occurrences.type_id}}}</H1>		
	</div>
	<div class='navLeftRight col-xs-1 col-sm-1 col-md-1 col-lg-1 pt-2'>
		<div class="detailNavBgRight">
			{{{nextLink}}}
		</div><!-- end detailNavBgLeft -->
	</div><!-- end col -->
</div><!-- end row -->
<div class="row">
	<div class="col-sm-12">
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
		<div class='col-md-12 mx-auto pt-3'><div class="col-lg-4 mx-auto">
				{{{<ifcount code="ca_objects_x_ca_object_representations" ><div class='unit'><unit relativeTo="ca_objects" delimiter=" " start="0" length="1">^ca_object_representations.media.large</unit></div></ifcount>}}}

		</div>
		</div>
		<div class='col-md-12'>
					{{{<ifcount code="ca_entities" min="1"><h3 class="pt-3">People</h3>
					<div class="bright"><unit relativeTo="ca_entities" delimiter=", ">^relationship_typename <l>^ca_entities.preferred_labels</l></unit></div></ifcount>}}}
		</div>
			
</div><!-- end col -->

{{{<ifcount code="ca_objects" min="1">
		<div class="row pt-2">
		<div class="col-sm-12"><h2 class="text-center pt-2 pb-2">Related Items</h2></div>
			<div class="card-columns">
				<unit relativeTo="ca_objects" delimiter=" " start="0"><div class='card'><l>^ca_object_representations.media.large</l><div class="text-center"><l>^ca_objects.preferred_labels.name</l></div></unit></div>
			</div>
			</ifcount>}}}

		</div><!-- end container -->
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