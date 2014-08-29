<?php
	$t_object = $this->getVar("item");
	$va_comments = $this->getVar("comments");
?>
<div class="row">
	<div class='col-xs-1 col-sm-1 col-md-1 col-lg-1'>
		<div class="detailNavBgLeft">
			{{{previousLink}}}{{{resultsLink}}}
		</div><!-- end detailNavBgLeft -->
	</div><!-- end col -->
	<div class='col-xs-10 col-sm-10 col-md-10 col-lg-10'>
		<div class="container"><div class="row">
<?php
			$va_media_class = str_replace(' ', '', strtolower($t_object->get('ca_objects.type_id', array('convertCodesToDisplayText' => true))));
?>				
			<div class='col-sm-6 col-md-6 col-lg-6 <?php print $va_media_class; ?>'>
		
				{{{representationViewer}}}
				<div id="detailTools">
					<div class="detailTool"><a href='#' onclick='jQuery("#detailComments").slideToggle(); return false;'><span class="glyphicon glyphicon-comment"></span>Comments (<?php print sizeof($va_comments); ?>)</a></div><!-- end detailTool -->
					<div id='detailComments'>{{{itemComments}}}</div><!-- end itemComments -->
					<div class="detailTool"><span class="glyphicon glyphicon-share-alt"></span>{{{shareLink}}}</div><!-- end detailTool -->
				</div><!-- end detailTools -->
			</div><!-- end col -->
			<div class='col-sm-6 col-md-6 col-lg-6'>
				<H4>{{{<ifdef code="ca_objects.preferred_labels"><H6>Title:</H6>^ca_objects.preferred_labels<br/></ifdef>}}}</H4>
				<H6>{{{<unit>^ca_objects.type_id</unit>}}}</H6>
				<HR>
							
				{{{<ifdef code="ca_objects.idno"><H6>Identifer:</H6>^ca_objects.idno<br/></ifdef>}}}				
	
				
<?php
			if($t_object->get('parent_id')){
				$vn_parent_id = $t_object->get('ca_objects.parent_id');
				print "<div class='unit'>"._t("Part Of Reel").": ".caNavLink($this->request, $t_object->get("ca_objects.parent.preferred_labels.name"), '', '', 'Detail', 'objects/'.$vn_parent_id)."</div>";
			}
			if($t_object->get('type_id') != 23){
				$va_children = $t_object->getHierarchyChildren(null, array('idsOnly' => true));
				print "<div class='unit rings'><h6>"._t("Rings").":</h6>";
				foreach ($va_children as $va_child_key => $va_child_id) {
					$t_object = new ca_objects($va_child_id);
					print caNavLink($this->request, $t_object->get("ca_objects.preferred_labels.name"), '', '', 'Detail', 'objects/'.$va_child_id)."<br/>";
				} 
				print "</div>";
			}
?>				
				
				{{{<ifdef code="ca_objects.description"><H6>Description:</H6>^ca_objects.description<br/></ifdef>}}}

				{{{<ifcount min="1" code="ca_objects.reel_date.reel_date_value"><H6>Date:</H6><unit delimiter='<br/>'>^ca_objects.reel_date.reel_date_value <ifdef code='ca_objects.reel_date.reel_date_types'>(^ca_objects.reel_date.reel_date_types)</ifdef></unit></ifcount>}}}
				{{{<ifdef code="ca_objects.music_category"><H6>Category:</H6>^ca_objects.music_category<br/></ifdef>}}}
				{{{<ifdef code="ca_objects.spoken_word_category"><H6>Category:</H6>^ca_objects.spoken_word_category<br/></ifdef>}}}
				{{{<ifdef code="ca_objects.religious_category"><H6>Category:</H6>^ca_objects.religious_category<br/></ifdef>}}}
				
				{{{<ifdef code="ca_objects.language"><H6>Language:</H6>^ca_objects.language<br/></ifdef>}}}
				{{{<ifdef code="ca_objects.duration"><H6>Duration:</H6>^ca_objects.duration<br/></ifdef>}}}
				

				{{{<ifcount min="1" code="ca_objects.ring_date.ring_dates_value"><H6>Date:</H6><unit delimiter='<br/>'>^ca_objects.ring_date.ring_dates_value <ifdef code='ca_objects.ring_date.ring_date_types'>(^ca_objects.ring_date.ring_date_types)</ifdef></unit></ifcount>}}}

				{{{<ifdef code="ca_objects.topic"><H6>Topic:</H6>^ca_objects.topic<br/></ifdef>}}}
				
				{{{<ifdef code="ca_objects.courtesy"><H6>Courtesy:</H6>^ca_objects.courtesy<br/></ifdef>}}}

				{{{<ifdef code="ca_objects.rights.rightsText"><H6>Rights:</H6>^ca_objects.rights.rightsText<br/></ifdef>}}}
							
<?php
			if($vs_entities = $t_object->get("ca_entities", array('delimiter' => '<br/>', 'template' => '^preferred_labels (^relationship_typename)', "returnAsLink" => true))){
				print "<div class='unit'><H6><b>"._t('Related Entities').":</b></H6> {$vs_entities}</div><!-- end unit -->";
				}
?>			
			</div><!-- end col -->
		</div><!-- end row --></div><!-- end container -->
	</div><!-- end col -->
	<div class='col-xs-1 col-sm-1 col-md-1 col-lg-1'>
		<div class="detailNavBgRight">
			{{{nextLink}}}
		</div><!-- end detailNavBgLeft -->
	</div><!-- end col -->
</div><!-- end row -->



<script type='text/javascript'>
	jQuery(document).ready(function() {
		$('.trimText').readmore({
		  speed: 75,
		  maxHeight: 65
		});
	});
</script>