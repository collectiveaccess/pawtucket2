<?php
	$t_object = $this->getVar("item");
	$va_comments = $this->getVar("comments");
?>
<div class="row">
	<div class='col-xs-12 navTop'><!--- only shown at small screen size -->
		{{{previousLink}}}{{{resultsLink}}}{{{nextLink}}}
	</div><!-- end detailTop -->
	<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
		<div class="container"><div class="row">
			
			<div class='col-sm-8 col-md-8 col-lg-8 content'>
				<div class='objTitle'>{{{ca_objects.preferred_labels.name}}}</div>
<?php				
				if ($object_type = unicode_ucfirst($t_object->get('type_id', array('convertCodesToDisplayText' => true)))) {	
					print "<h1>Type</h1>";
					print"<p>".$object_type."</p>";
				}
				print "<div style='width:500px;clear:left;height:1px;'></div>";


				if ($va_hierarchy = $t_object->get('ca_collections.hierarchy', array('returnAsArray' => true, 'removeFirstItems' => 0))) {	
					$hierarchy_id = $t_object->get('ca_collections.hierarchy.collection_id', array('returnAsArray' => true, 'removeFirstItems' => 0));
					$va_hierarchy_array = array_combine($hierarchy_id[0], $va_hierarchy[0]);
					print "<h1>Collection</h1><ul>";
					foreach ($va_hierarchy_array as $id => $content) {
						print "<li>".caNavLink($this->request, $content, '', '', 'Detail', 'collections/'.$id)."</li>";
					}
					print "</ul>";
				}
		
				
				if ($va_idno = $t_object->get('ca_objects.object_id')) {	
					print "<h1>Identifier</h1>";
					print"<p>CA ".$va_idno."</p>";
				}		
				
				print "<div style='width:500px;clear:left;height:1px;'></div>";
				
				if ($va_dates = $t_object->get('ca_objects.date_as_text', array('delimiter' => '<br/>'))) {
					print "<h1>Dates</h1>";
					print "<p>".$va_dates."</p>";			
				} else if ($va_dates = $t_object->get('ca_objects.dates.dates_value', array('delimiter' => '<br/>'))) {
					print "<h1>Dates</h1>";
					print "<p>".$va_dates."</p>";
				}

				print "<div style='width:500px;clear:left;height:1px;'></div>";				
		
				if ($va_bio = $t_object->get('ca_objects.description_public')) {	
					print "<h1>Description</h1>";
					print"<p>".$va_bio."</p>";
				}
				
				print "<div style='width:500px;clear:left;height:1px;'></div>";


				# --- entities

				$va_entities = $t_object->get("ca_entities", array("returnAsArray" => 1, 'checkAccess' => $va_access_values));
				$va_occurrences = $t_object->get("ca_occurrences", array("returnAsArray" => 1, 'checkAccess' => $va_access_values));
				if ((sizeof($va_entities) > 0 ) | (sizeof($va_occurrences) > 0 )) {	
?>
					<h1><?php print _t("Related"); ?></h1>
					<ul>
<?php
					if (sizeof($va_entities) > 0 ) {
						foreach($va_entities as $vn_entity_id => $va_entity) {
							print "<li>".caNavLink($this->request, $va_entity["label"], '', '', 'Detail', 'occurrences/'.$va_entity["entity_id"])."</li>\n";
						}
					}
					if (sizeof($va_occurrences) > 0 ) {
						foreach($va_occurrences as $vn_occurrence_id => $va_occurrence) {
							print "<li>".caNavLink($this->request, $va_occurrence["label"], '', '', 'Detail', 'occurrences/'.$va_occurrence["occurrence_id"])."</li>\n";
						}
					}
	
?>
					</ul>
		
					<div style='width:500px;clear:left;height:1px;'></div>
<?php		
				}
	if ($t_object->get("ca_objects.location.drawer") | $t_object->get("ca_objects.location.box") | $t_object->get("ca_objects.location.folder") | $t_object->get("ca_objects.location.item")) {
?>		
		<h1><?php print _t("Location"); ?></h1>
<?php

		$va_location = array();
		if ($va_drawer = $t_object->get("ca_objects.location.drawer")) {
			$va_location[] = "Drawer ".$va_drawer;
		}
		if ($va_box = $t_object->get("ca_objects.location.box")) {
			$va_location[] = "Box ".$va_box;
		}
		if ($va_folder = $t_object->get("ca_objects.location.folder")) {
			$va_location[] = "Folder ".$va_folder;
		}		
		if ($va_item = $t_object->get("ca_objects.location.item")) {
			$va_location[] = "Item ".$va_item;
		}

		print "<p>".join($va_location, ', ')."</p>";
	}	
?>

			</div><!-- end col -->
			<div class='col-sm-4 col-md-4 col-lg-4 '>
				{{{representationViewer}}}
				
				<?php print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_object, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-sm-3 col-md-3 col-xs-4")); ?>

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