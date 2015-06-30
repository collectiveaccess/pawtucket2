<?php
	$t_object = $this->getVar("item");
	$va_comments = $this->getVar("comments");
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
			<div class='col-sm-6 col-md-6 col-lg-5 col-lg-offset-1'>
				{{{representationViewer}}}
				
				<?php print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_object, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-sm-3 col-md-3 col-xs-4")); ?>

			</div><!-- end col -->
			
			<div class='col-sm-6 col-md-6 col-lg-5'>
				<H4>{{{<unit relativeTo="ca_collections" delimiter="<br/>"><l>^ca_collections.preferred_labels.name</l></unit><ifcount min="1" code="ca_collections"> ➔ </ifcount>}}}{{{ca_objects.preferred_labels.name}}}</H4>
				<H6>{{{<unit>^ca_objects.type_id</unit>}}}</H6>
<?php
				if($t_object->get('type_id', array('convertCodesToDisplayText' => true)) != 'reel'){
					if($t_object->get('parent_id')){
						$vn_parent_id = $t_object->get('ca_objects.parent_id');
						print "<h5>"._t("Part of %1", "<span class='metaData'> ".caNavLink($this->request, $t_object->get("ca_objects.parent.preferred_labels.name"), '', '', 'Detail', 'objects/'.$vn_parent_id)."</span>")."</h5>";
					}
				}
?>
				<HR>
				{{{<ifdef code="ca_objects.idno"><H6>Identifer:</H6><span class='metaData'>^ca_objects.idno</span><br/></ifdef>}}}				
				{{{<ifcount min="1" code="ca_objects.reel_date.reel_date_value"><div class='unit'><H6>Date:</H6><unit delimiter='<br/>'>^ca_objects.reel_date.reel_date_value <ifdef code='ca_objects.reel_date.reel_date_types'>(^ca_objects.reel_date.reel_date_types)</ifdef></unit></div></ifcount>}}}
				{{{<ifcount min="1" code="ca_objects.ring_date.ring_dates_value"><div class='unit'><H6>Date:</H6><unit delimiter='<br/>'>^ca_objects.ring_date.ring_dates_value <ifdef code='ca_objects.ring_date.ring_date_types'>(^ca_objects.ring_date.ring_date_types)</ifdef></unit></div></ifcount>}}}
		
				{{{<ifdef code="ca_objects.duration"><H6>Duration:</H6>^ca_objects.duration<br/></ifdef>}}}
				{{{<ifdef code="ca_objects.music_category"><div class='unit'><h6>Category</h6><span class='metaFloat'>^ca_objects.music_category</span></div></ifdef>}}}
				{{{<ifdef code="ca_objects.spoken_word_category"><div class='unit'><h6>Category</h6><span class='metaFloat'>^ca_objects.spoken_word_category</span></div></ifdef>}}}
				{{{<ifdef code="ca_objects.religious_category"><div class='unit'><h6>Category</h6><span class='metaFloat'>^ca_objects.religious_category</span></div></ifdef>}}}	
				{{{<ifdef code="ca_objects.language"><div class='unit'><h6>Language</h6><unit><span class='metaFloat'>^ca_objects.language</span></unit></div></ifdef>}}}


				{{{<ifdef code="ca_objects.topic"><div class='unit'><h6>Topic</h6><span class='metaFloat'>^ca_objects.topic</span></div></ifdef>}}}
				{{{<ifdef code="ca_objects.description"><h6>Description</h6>^ca_objects.description<br/></ifdef>}}}
		
				{{{<ifdef code="ca_objects.courtesy"><div class='unit'><h6>Courtesy<h6><span class='metaFloat'>^ca_objects.courtesy</span></div></ifdef>}}}

				{{{<ifdef code="ca_objects.rights.rightsText"><div class='unit'><h6>Rights</h6><span class='metaFloat'>^ca_objects.rights.rightsText</span></div></ifdef>}}}	
			
<?php
				if($vs_entities = $t_object->get("ca_entities", array('delimiter' => '<br/>', 'template' => '^preferred_labels (^relationship_typename)', "returnAsLink" => true))){
					print "<div class='unit'><H6>"._t('Related Entities')."</H6> <span class='metaData'>{$vs_entities}</span></div><!-- end unit -->";
				}
 
				if($t_object->get('type_id') == 21){
					$va_children = $t_object->getHierarchyChildren(null, array('idsOnly' => true));
					print "<div class='unit rings'><h6><b>"._t("Rings")."</b></h6>";
					foreach ($va_children as $va_child_key => $va_child_id) {
						$t_ring = new ca_objects($va_child_id);
						print caNavLink($this->request, $t_ring->get("ca_objects.preferred_labels.name"), '', '', 'Detail', 'objects/'.$va_child_id)."<br/>";
					} 
					print "</div>";
				}
?>					

			</div><!-- end col -->
		</div><!-- end row --></div><!-- end container -->
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