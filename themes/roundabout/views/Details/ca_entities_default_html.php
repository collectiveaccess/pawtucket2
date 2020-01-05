<?php
	$t_item = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");	
?>
<div class="row borderBottom pt-1 pb-1">
	<div class='col-xs-12 navTop'><!--- only shown at small screen size -->
		{{{previousLink}}}{{{resultsLink}}}{{{nextLink}}}
	</div><!-- end detailTop -->
	<div class='navLeftRight col-xs-1 col-sm-1 col-md-1 col-lg-1 pt-2'>
		<div class="detailNavBgLeft">
			{{{previousLink}}}<br>{{{resultsLink}}}
		</div><!-- end detailNavBgLeft -->
	</div><!-- end col -->
	<div class='col-md-10 col-lg-10 pt-2 pb-2'>
			<H1 class= "text-center">{{{^ca_entities.preferred_labels.displayname}}}</H1>
	</div>
	<div class='navLeftRight col-xs-1 col-sm-1 col-md-1 col-lg-1 pt-2'>
		<div class="detailNavBgRight">
			{{{nextLink}}}
		</div><!-- end detailNavBgLeft -->
	</div>
</div>
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
	</div>					
	{{{<ifcount code="ca_objects" min="1">
	<div class='col-md-6 mx-auto pt-3'>
			<div class="col-lg-10 mx-auto">
				<div class='unit'><unit relativeTo="ca_objects" delimiter=" " start="0" length="1">^ca_object_representations.media.large</unit></div>
			</div><!-- end col -->		
	</div><!-- end col -->
	</ifcount>}}}
	<div class='col-md-6 inner-columns'>
		{{{<h2 class="capitalize pt-3">^ca_entities.type_id ^ca_entities.idno</h2>}}}
		{{{<ifdef code="ca_entities.biography" delimiter="<br>"><H3>Biography</H3>^ca_entities.biography%makeFirstUpper<br/></ifdef>}}}

		{{{<ifcount code="ca_occurrences" restrictToTypes="productions" min="1" max="1"><H3 class="pt-3">Stage Production</H3></ifcount>}}}
		{{{<ifcount code="ca_occurrences" restrictToTypes="productions" min="2"><H3 class="pt-3">Stage Productions</H3></ifcount>}}}	
	    {{{<unit relativeTo="ca_entities_x_occurrences" restrictToTypes="productions" delimiter=" "><div class='pb-1 bright'>^ca_relationship_types.preferred_labels.typename%makeFirstUpper for <unit relativeTo="ca_occurrences" delimiter="<br/>"><l>^ca_occurrences.preferred_labels.name</l></unit></unit></div>}}}
		
		{{{<ifcount code="ca_collections" min="1" max="1"><H3 class="pt-3">In Collection</H3></ifcount>}}}
		{{{<ifcount code="ca_collections" min="2"><H3 class="pt-3">In Collections</H3></ifcount>}}}
		{{{<unit relativeTo="ca_entities_x_collections" delimiter="<br/>"><div class='col-sm-6 p-0 bright'><unit relativeTo="ca_collections"><l>^ca_collections.preferred_labels.name</l></unit></unit></div>}}}
	</div>
</div><!-- end row -->
			
{{{<ifcount code="ca_objects" min="1">
	<div class="row pt-2">
		<div class="col-sm-12 borderBottom">
			<h2 class="text-center pt-2 pb-2">Related Items</h2>
		</div>
		<div class="card-columns pt-3">
			<unit relativeTo="ca_objects" delimiter=" " start="0">
				<div class='card'><l>^ca_object_representations.media.large</l>
					<div class="title text-center pt-2"><l>^ca_objects.preferred_labels.name</l>
					</div>
				</div>
			</unit>
		</div>
	</div>
</ifcount>}}}