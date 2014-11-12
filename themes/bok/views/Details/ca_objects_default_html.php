<?php
	$t_object = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$vs_rep_viewer = $this->getVar("representationViewer");
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
		<div class="container"><div class="row">
<?php
		if($vs_rep_viewer){
?>
			<div class='col-sm-6'>
				<?php print $vs_rep_viewer; ?>
				
				<?php print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_object, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-sm-3 col-md-3 col-xs-4")); ?>
				<div id="detailTools">
					<div class="detailTool"><a href='#' onclick='jQuery("#detailComments").slideToggle(); return false;'><span class="glyphicon glyphicon-comment"></span>Comments (<?php print sizeof($va_comments); ?>)</a></div><!-- end detailTool -->
					<div id='detailComments'><?php print $this->getVar("itemComments"); ?></div><!-- end itemComments -->
					<div class="detailTool"><span class="glyphicon glyphicon-share-alt"></span><?php print $this->getVar("shareLink"); ?></div><!-- end detailTool -->
				</div><!-- end detailTools -->
			</div><!-- end col -->
			
			<div class='col-sm-6'>
<?php
		}else{
?>
			<div class='col-sm-12'>
<?php
		}
?>
				<H4>{{{ca_objects.preferred_labels.name}}}</H4>
				<H6>{{{<unit>^ca_objects.type_id</unit>}}}</H6>
<?php
				if($t_object->get("ca_objects.external_link")){
					$va_external_links = $t_object->get("ca_objects.external_link", array("returnAsArray" => true));
					print "<H6>Link to Resource:</H6>";
					$i = 0;
					foreach($va_external_links as $va_external_link){
						$vs_link_text = "";
						if($va_external_link["url_source"]){
							$vs_link_text = $va_external_link["url_source"];
						}else{
							$vs_link_text = (mb_strlen($va_external_link["url_entry"]) > 50) ? mb_substr($va_external_link["url_entry"], 0, 50)."..." : $va_external_link["url_entry"];
						}
						print "<a href='".$va_external_link["url_entry"]."' target='_blank'>".$vs_link_text."</a>";
						$i++;
						if($i < sizeof($va_external_links)){
							print "<br/>";
						}
					}
					
				}
?>

				<HR></HR>			
				{{{<ifdef code="ca_objects.description">
					<span class="trimText">^ca_objects.description</span><HR></HR>
				</ifdef>}}}

				
				{{{<ifcount code="ca_objects.regions" min="1"><H6>Applicable region(s):</H6><unit delimiter=", ">^ca_objects.regions</unit></ifcount>}}}
				{{{<ifcount code="ca_objects.language" min="1"><H6>Language(s):</H6><unit delimiter=", ">^ca_objects.language</unit></ifcount>}}}
				{{{<ifdef code="ca_objects.source_reference"><H6>Source/Reference:</H6>^ca_objects.source_reference</ifdef>}}}
				

				
				
				{{{<ifdef code="ca_objects.dateSet.setDisplayValue"><H6>Date:</H6>^ca_objects.dateSet.setDisplayValue<br/></ifdev>}}}
				
				<HR></HR>
					
				{{{<ifcount code="ca_occurrences" min="1" max="1"><H6>Related competence</H6></ifcount>}}}
				{{{<ifcount code="ca_occurrences" min="2"><H6>Related competences</H6></ifcount>}}}
				{{{<unit relativeTo="ca_occurrences" delimiter="<br/>"><strong>^ca_occurrences.idno</strong> ^ca_occurrences.preferred_labels.name</unit>}}}
				
				{{{<ifcount code="ca_objects.related" min="1" max="1"><H6>Related resource</H6></ifcount>}}}
				{{{<ifcount code="ca_objects.related" min="2"><H6>Related resources</H6></ifcount>}}}
				{{{<unit relativeTo="ca_objects" delimiter="<br/>"><l>^ca_objects.related.preferred_labels.name</l></unit>}}}
				
				{{{<ifcount code="ca_entities" restrictToRelationshipTypes="curated" min="1"><H6>Curated by</H6>
					<unit relativeTo="ca_entities" delimiter=", " restrictToRelationshipTypes="curated"><l>^ca_entities.preferred_labels</l></unit>
				</ifcount>}}}
				{{{<ifcount code="ca_entities" restrictToRelationshipTypes="contribute" min="1"><H6>Contributed by</H6>
					<unit relativeTo="ca_entities" delimiter=", " restrictToRelationshipTypes="contribute"><l>^ca_entities.preferred_labels</l></unit>
				</ifcount>}}}
<?php
				if(!$vs_rep_viewer){
?>
					<HR></HR>
					<div id="detailTools">
						<div class="detailTool"><a href='#' onclick='jQuery("#detailComments").slideToggle(); return false;'><span class="glyphicon glyphicon-comment"></span>Comments (<?php print sizeof($va_comments); ?>)</a></div><!-- end detailTool -->
						<div id='detailComments'><?php print $this->getVar("itemComments"); ?></div><!-- end itemComments -->
						<div class="detailTool"><span class="glyphicon glyphicon-share-alt"></span><?php print $this->getVar("shareLink"); ?></div><!-- end detailTool -->
					</div><!-- end detailTools -->

<?php
				}
?>
			</div><!-- end col -->
		</div><!-- end row --></div><!-- end container -->
		<br/><br/><br/>
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