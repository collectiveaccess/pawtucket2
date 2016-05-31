<?php
	$t_object = $this->getVar("item");
	$va_comments = $this->getVar("comments");
?>
<div class="row">



	<div class='col-xs-12 col-sm-10 col-md-10 col-lg-10'>
		<div class="container"><div class="row">
			<div class='col-sm-6 col-md-6 col-lg-5 col-lg-offset-1'>
				{{{representationViewer}}}
				
				<?php print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_object, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-sm-3 col-md-3 col-xs-4")); ?>

			</div><!-- end col -->
			
			<div class='col-sm-6 col-md-6 col-lg-5'>
				<H6><?php print $t_object->get('ca_occurrences.preferred_labels'); ?></H6>
				<H4>{{{ca_objects.preferred_labels.name}}}</H4>
				<HR>			
<?php
				if ($va_idno = $t_object->get('ca_objects.idno', array('delimiter' => '<br/>'))) {
					print "<div class='unit'><span class='detailLabel'>ID</span><span class='detailInfo'>".$va_idno."</span></div>";
				}
				if ($va_dates = $t_object->get('ca_objects.date_as_text', array('delimiter' => '<br/>'))) {
					print "<div class='unit'><span class='detailLabel'>Date</span>";
					print "<span class='detailInfo'>".$va_dates."</span></div>";			
				} else if ($va_dates = $t_object->get('ca_objects.dates.dates_value', array('delimiter' => '<br/>'))) {
					print "<div class='unit'><span class='detailLabel'>Date</span>";
					print "<span class='detailInfo'>".$va_dates."</span></div>";			
				}
				if ($va_storage = $t_object->get('ca_objects.location.location_description', array('delimiter' => ' > '))) {
					print "<div class='unit'><span class='detailLabel'>Location</span><span class='detailInfo'>".$va_storage."</span></div>";
				}
				if ($va_type = $t_object->get('ca_objects.series', array('delimiter' => ' > ', 'convertCodesToDisplayText' => true))) {
					print "<div class='unit'><span class='detailLabel'>Classification</span><span class='detailInfo'>".$va_type."</span></div>";
				} else {
					print "<div class='unit'><span class='detailLabel'>Classification</span><span class='detailInfo'>".$t_object->get('ca_objects.type_id', array('convertCodesToDisplayText' => true))."</span></div>";
				}
				if ($va_materials = $t_object->get('ca_objects.materials', array('delimiter' => ' > ', 'convertCodesToDisplayText' => true))) {
					print "<div class='unit'><span class='detailLabel'>Materials</span><span class='detailInfo'>".$va_materials."</span></div>";
				}
				if ($va_dims = $t_object->get('ca_objects.dimensions', array('delimiter' => ' &times; ', 'convertCodesToDisplayText' => true))) {
					print "<div class='unit'><span class='detailLabel'>Measurements</span><span class='detailInfo'>".$va_dims."</span></div>";
				}	
				if ($va_exhibition = $t_object->get('ca_occurrences.preferred_labels', array('returnAsLink' => true, 'delimiter' => '<br/>'))) {
					print "<div class='unit'><h6>Related Exhibitions</h6>".$va_exhibition."</div>";
				}
				if ($va_collection = $t_object->get('ca_collections.hierarchy.preferred_labels', array('returnAsLink' => true, 'delimiter' => ' <br/><i class="fa fa-reply collection"></i> '))) {
					print "<div class='unit'><h6>Location in Collection</h6>".$va_collection."</div>";
				}
				if ($va_dept = $t_object->get('ca_entities.preferred_labels', array('returnAsLink' => true, 'delimiter' => '<br/>', 'restrictToTypes' => array('department')))) {
					print "<div class='unit'><h6>Related Departments</h6>".$va_dept."</div>";
				}																																
				if ($va_entities = $t_object->get('ca_entities', array('returnAsLink' => true, 'delimiter' => '<br/>', 'template' => '^ca_entities.preferred_labels'))) {
					print "<div class='unit'><h6>Related Entities</h6>".$va_entities."</div>";
				}					
				
?>
				
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