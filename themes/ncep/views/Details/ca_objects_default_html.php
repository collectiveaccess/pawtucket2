<?php
	$t_object = $this->getVar("item");
	$va_comments = $this->getVar("comments");
?>
<div class="row">
	<div class='col-xs-12 navTop'><!--- only shown at small screen size -->
		{{{previousLink}}}{{{resultsLink}}}{{{nextLink}}}
	</div><!-- end navTop -->
	<div class='col-xs-12'>
		<div class="detailBox detailBoxTop">
			<div class="detailNav pull-right">
				{{{previousLink}}}{{{resultsLink}}}{{{nextLink}}}
			</div><!-- end detailNav -->
			<H1>{{{^ca_objects.preferred_labels.name}}}</H1>
					
			<div class="row">
				{{{<if rule="(length(^ca_objects.abstract) > 0) or (length(^ca_objects.related%restrictToRelationshipTypes=translation) > 0)">
				<div class='col-xs-12 col-sm-6'>
					<ifdef code="ca_objects.abstract"><p>^ca_objects.abstract</p></ifdef>
					<ifcount code="ca_objects.related" min="1" restrictToRelationshipTypes="translation">
						<p><b>View this module in other languages:</b><br/>
						<unit relativeTo="ca_objects.related" delimiter="<br/>" restrictToRelationshipTypes="translation"><l>^ca_objects.preferred_labels.name</l> (^ca_objects.language)</unit>
						</p>
					</ifcount>
				</div>
				</if>}}}
				<div class='col-xs-12 col-sm-6'>
					{{{<ifcount code="ca_objects.related" min="1" restrictToRelationshipTypes="related"><p><b>See Also:</b><br/>
						<unit relativeTo="ca_objects.related" delimiter="<br/>" restrictToRelationshipTypes="related"><l>^ca_objects.preferred_labels.name</l></unit>
					</p></ifcount>}}}
<?php
					if($va_themes = $t_object->get("ca_objects.themes", array("returnWithStructure" => true))){
						if(is_array($va_themes) && sizeof($va_themes)){
							$t_list_items = new ca_list_items();
							$va_themes = array_pop($va_themes);
							print "<p><b>Theme".((sizeof($va_themes) > 1) ? "s" : "")."</b>: ";
							$va_theme_links = array();
							foreach($va_themes as $vn_key => $va_theme){
								$t_list_items->load($va_theme["themes"]);
								$va_theme_links[] = caNavLink($this->request, $t_list_items->get("ca_list_items.preferred_labels.name_singular"), "", "", "Browse", "objects", array("facet" => "theme", "id" => $va_theme["themes"]));					
							}
							print join(", ", $va_theme_links);
							print "</p>";
						}
					}
					$va_component_ids = $t_object->get("ca_objects.children.object_id", array("returnWithStructure" => true, "checkAccess" => caGetUserAccessValues($this->request)));
?>
					{{{<ifdef code="ca_objects.language"><p><b>Language:</b> ^ca_objects.language</p></ifdef>}}}
					<p><b>Components:</b> <?php print sizeof($va_component_ids); ?></p>
				</div>
			</div>
		</div><!-- end detailBox -->
		<div class="row">
			<div class='col-xs-2'>
			
			</div><!-- end col-2 -->
			<div class='col-xs-10'>
				<div class="detailBox">
<?php
					$va_learn = $t_object->get("ca_objects.children", array("returnWithStructure" => true, "checkAccess" => caGetUserAccessValues($this->request)));
					print_r($va_learn);
?>
					{{{<ifdef code="ca_objects.children" restrictToTypes="Synthesis">
						<unit relativeTo="ca_objects.children" delimiter="<br/>" restrictToTypes="Synthesis">^ca_objects.preferred_labels.name ^ca_objects.type_id</unit>
					</ifdef>}}}
				</div><!-- end detailBox -->
			</div><!-- end col-10 -->
		</div><!-- end row -->
		<div class="container"><div class="row">
			<div class='col-sm-6 col-md-6 col-lg-5 col-lg-offset-1'>
				{{{representationViewer}}}
				
				<?php print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_object, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-sm-3 col-md-3 col-xs-4")); ?>
				<div id="detailTools">
					<div class="detailTool"><a href='#' onclick='jQuery("#detailComments").slideToggle(); return false;'><span class="glyphicon glyphicon-comment"></span>Comments (<?php print sizeof($va_comments); ?>)</a></div><!-- end detailTool -->
					<div id='detailComments'>{{{itemComments}}}</div><!-- end itemComments -->
					<div class="detailTool"><span class="glyphicon glyphicon-share-alt"></span>{{{shareLink}}}</div><!-- end detailTool -->
				</div><!-- end detailTools -->
			</div><!-- end col -->
			
			<div class='col-sm-6 col-md-6 col-lg-5'>
				<H4>{{{<unit relativeTo="ca_collections" delimiter="<br/>"><l>^ca_collections.preferred_labels.name</l></unit><ifcount min="1" code="ca_collections"> ➔ </ifcount>}}}{{{ca_objects.preferred_labels.name}}}</H4>
				<H6>{{{<unit>^ca_objects.type_id</unit>}}}</H6>
				<HR>
				
				{{{<ifdef code="ca_objects.measurementSet.measurements">^ca_objects.measurementSet.measurements (^ca_objects.measurementSet.measurementsType)</ifdef><ifdef code="ca_objects.measurementSet.measurements,ca_objects.measurementSet.measurements"> x </ifdef><ifdef code="ca_objects.measurementSet.measurements2">^ca_objects.measurementSet.measurements2 (^ca_objects.measurementSet.measurementsType2)</ifdef>}}}
				
				
				{{{<ifdef code="ca_objects.idno"><H6>Identifer:</H6>^ca_objects.idno<br/></ifdef>}}}
				{{{<ifdef code="ca_objects.containerID"><H6>Box/series:</H6>^ca_objects.containerID<br/></ifdef>}}}				
				
				{{{<ifdef code="ca_objects.description">
					<span class="trimText">^ca_objects.description</span>
				</ifdef>}}}
				
				
				{{{<ifdef code="ca_objects.dateSet.setDisplayValue"><H6>Date:</H6>^ca_objects.dateSet.setDisplayValue<br/></ifdev>}}}
				
				<hr></hr>
					<div class="row">
						<div class="col-sm-6">		
							{{{<ifcount code="ca_entities" min="1" max="1"><H6>Related person</H6></ifcount>}}}
							{{{<ifcount code="ca_entities" min="2"><H6>Related people</H6></ifcount>}}}
							{{{<unit relativeTo="ca_entities" delimiter="<br/>"><l>^ca_entities.preferred_labels.displayname</l></unit>}}}
							
							
							{{{<ifcount code="ca_places" min="1" max="1"><H6>Related place</H6></ifcount>}}}
							{{{<ifcount code="ca_places" min="2"><H6>Related places</H6></ifcount>}}}
							{{{<unit relativeTo="ca_places" delimiter="<br/>"><l>^ca_places.preferred_labels.name</l></unit>}}}
							
							{{{<ifcount code="ca_list_items" min="1" max="1"><H6>Related Term</H6></ifcount>}}}
							{{{<ifcount code="ca_list_items" min="2"><H6>Related Terms</H6></ifcount>}}}
							{{{<unit relativeTo="ca_list_items" delimiter="<br/>">^ca_list_items.preferred_labels.name_plural</unit>}}}
							
							{{{<ifcount code="ca_objects.LcshNames" min="1"><H6>LC Terms</H6></ifcount>}}}
							{{{<unit delimiter="<br/>"><l>^ca_objects.LcshNames</l></unit>}}}
						</div><!-- end col -->				
						<div class="col-sm-6 colBorderLeft">
							{{{map}}}
						</div>
					</div><!-- end row -->
			</div><!-- end col -->
		</div><!-- end row --></div><!-- end container -->
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