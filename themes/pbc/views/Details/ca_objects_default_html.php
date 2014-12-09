<?php
	$t_object = $this->getVar("item");
	$va_comments = $this->getVar("comments");
?>
<div class="row" style="margin-top:-1px;z-index:20000;position:relative;">
	<div class='col-xs-1 col-sm-1 col-md-1 col-lg-1'>
		<div class="detailNavBgLeft">
			{{{previousLink}}}{{{resultsLink}}}
		</div><!-- end detailNavBgLeft -->
	</div><!-- end col -->
	<div class='col-xs-10 col-sm-10 col-md-10 col-lg-10'>
	</div>
	<div class='col-xs-1 col-sm-1 col-md-1 col-lg-1'>
		<div class="detailNavBgRight">
			{{{nextLink}}}
		</div><!-- end detailNavBgLeft -->
	</div><!-- end col -->
</div><!-- end row -->	
<div class="row" style='background-color:#cad9eb;'>	
		
<?php
	$va_media_class = str_replace(' ', '', strtolower($t_object->get('ca_objects.type_id', array('convertCodesToDisplayText' => true))));
	if($t_object->get('type_id') != 23){
?>				
	<div class='col-sm-5 col-md-5 col-lg-5 upper left <?php print $va_media_class; ?>' style='background-color:#d1e0f3;'>
<?php
	} else {
?>	
	<div class='col-sm-7 col-md-7 col-lg-7 upper left <?php print $va_media_class; ?>' style='background-color:#d1e0f3;'>
<?php	
	}
?>		
		<H1>{{{<ifdef code="ca_objects.preferred_labels">^ca_objects.preferred_labels</ifdef>}}}</H1>
		{{{representationViewer}}}

	</div><!-- end col -->
<?php
	if($t_object->get('type_id') != 23){
?>	
	<div class='col-sm-7 col-md-7 col-lg-7 upper right' style='background-color:#cad9eb;'>
<?php
	} else { 
?>
	<div class='col-sm-5 col-md-5 col-lg-5 upper right' style='background-color:#cad9eb;'>
<?php	
	}	
?>		
		<br/>
		{{{<div class='unit'><unit>^ca_objects.type_id</unit></div>}}}<br/>
		
		{{{<ifcount min="1" code="ca_objects.reel_date.reel_date_value"><div class='unit'><unit delimiter='<br/>'>^ca_objects.reel_date.reel_date_value <ifdef code='ca_objects.reel_date.reel_date_types'>(^ca_objects.reel_date.reel_date_types)</ifdef></unit></div></ifcount>}}}
		{{{<ifcount min="1" code="ca_objects.ring_date.ring_dates_value"><div class='unit'><unit delimiter='<br/>'>^ca_objects.ring_date.ring_dates_value <ifdef code='ca_objects.ring_date.ring_date_types'>(^ca_objects.ring_date.ring_date_types)</ifdef></unit></div></ifcount>}}}
		
		{{{<ifdef code="ca_objects.duration"><br/>Duration:<br/>^ca_objects.duration<br/></ifdef>}}}
<?php
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
</div><!-- end row -->
<div class="row">	
	<div class='col-sm-7 col-md-7 col-lg-7'>
		<div class='col-sm-6 col-md-6 col-lg-6'>
			<div class='unitSection'>
				{{{<ifdef code="ca_objects.idno"><H6>Identifer:</H6><span class='metaData'>^ca_objects.idno</span><br/></ifdef>}}}				
<?php
			if($t_object->get('type_id', array('convertCodesToDisplayText' => true)) != 'reel'){
				if($t_object->get('parent_id')){
					$vn_parent_id = $t_object->get('ca_objects.parent_id');
					print "<h6>"._t("Part Of Reel").":</h6><span class='metaData'> ".caNavLink($this->request, $t_object->get("ca_objects.parent.preferred_labels.name"), '', '', 'Detail', 'objects/'.$vn_parent_id)."</span><br/>";
				}
			}
?>
			</div>
		</div>		
	
		<div class='col-sm-6 col-md-6 col-lg-6 section'>
			<div class='unitSection'>
				{{{<ifdef code="ca_objects.music_category"><div class='unit'><span class='metaTitle'>Category</span><span class='metaFloat'>^ca_objects.music_category</span></div></ifdef>}}}
				{{{<ifdef code="ca_objects.spoken_word_category"><div class='unit'><span class='metaTitle'>Category</span><span class='metaFloat'>^ca_objects.spoken_word_category</span></div></ifdef>}}}
				{{{<ifdef code="ca_objects.religious_category"><div class='unit'><span class='metaTitle'>Category</span><span class='metaFloat'>^ca_objects.religious_category</span></div></ifdef>}}}	
				{{{<ifdef code="ca_objects.language"><div class='unit'><span class='metaTitle'>Language</span><span class='metaFloat'>^ca_objects.language</span></div></ifdef>}}}


				{{{<ifdef code="ca_objects.topic"><div class='unit'><span class='metaTitle'>Topic</span><span class='metaFloat'>^ca_objects.topic</span></div></ifdef>}}}
		
				{{{<ifdef code="ca_objects.courtesy"><div class='unit'><span class='metaTitle'>Courtesy</span><span class='metaFloat'>^ca_objects.courtesy</span></div></ifdef>}}}

				{{{<ifdef code="ca_objects.rights.rightsText"><div class='unit'><span class='metaTitle'>Rights</span><span class='metaFloat'>^ca_objects.rights.rightsText</span></div></ifdef>}}}	
			
			</div>
		</div>
	</div>
	
	<div class='col-sm-5 col-md-5 col-lg-5 section'>	
		<div class='unitSection'>		
<?php
		if($vs_entities = $t_object->get("ca_entities", array('delimiter' => '<br/>', 'template' => '^preferred_labels (^relationship_typename)', "returnAsLink" => true))){
			print "<div class='unit'><H6>"._t('Related Entities')."</H6> <span class='metaData'>{$vs_entities}</span></div><!-- end unit -->";
		}
?>	
		</div>					
	</div><!-- end col -->
</div><!-- end row -->
<div class='row'>
	<div class='col-sm-12 col-md-12 col-lg-12 topborder'>
		<div class='col-sm-7 col-md-7 col-lg-7'>
			<div class='unitSection'>
				{{{<ifdef code="ca_objects.description"><H7>Description</H7>^ca_objects.description<br/></ifdef>}}}
			</div>
		</div><!-- end col -->
		<div class='col-sm-5 col-md-5 col-lg-5'>
			<div class='unitSection'>

			</div>
		</div><!-- end col -->	
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