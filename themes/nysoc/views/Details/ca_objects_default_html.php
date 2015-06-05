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
		<div class="row">
			
			<div class='col-sm-6 col-md-6 col-lg-6'>
<?php
				if ($va_parent_label = $t_object->get('ca_objects.parent.preferred_labels')) {
					$va_title_parts = explode(':', $t_object->get('ca_objects.parent.preferred_labels'));
					print "<h4>".caNavLink($this->request, $va_title_parts[0], '', '', 'Detail', 'objects/'.$t_object->get('ca_objects.parent.object_id'))." ".$t_object->get('ca_objects.preferred_labels')."</h4>";
					print "<p class='longTitle'>";
					foreach (array_slice($va_title_parts, 1) as $va_key => $va_title_part) {
						print $va_title_part;
					}
					print "</p>";					
				} else {
					$va_title_parts = explode(':', $t_object->get('ca_objects.preferred_labels'));
					print "<h4>".$va_title_parts[0]."</h4>";
					print "<p class='longTitle'>";
					foreach (array_slice($va_title_parts, 1) as $va_key => $va_title_part) {
						print $va_title_part;
					}
					print "</p>";
				}
?>			
				<H6>{{{<unit>^ca_objects.type_id</unit>}}}</H6>
				<HR>
<?php
				if ($va_authors = $t_object->get('ca_entities.preferred_labels', array('restrictToRelationshipTypes' => array('author'), 'delimiter' => ', ', 'returnAsLink' => true))) {
					print "<div class='unit'>Author: ".$va_authors."</div>";
				}
				if ($vs_date = $t_object->get('ca_objects.publication_date')) {
					print "<div class='unit'>Publication Date: ".$vs_date."</div>";
				}
				if ($vs_place = $t_object->get('ca_objects.publication_place.publication_place_text')) {
					print "<div class='unit'>Publication Place: ".$vs_place."</div>";
				}	
				if ($vs_children = $t_object->get('ca_objects.children.preferred_labels', array('returnAsLink' => true, 'delimiter' => ', ', 'sort' => 'ca_objects.preferred_labels'))) {
					print "<div class='unit'>Available Volumes: ".$vs_children."</div>";
				}
				if ($vs_subjects_1850 = $t_object->get('ca_objects.subjects_1850', array('delimiter' => ', '))) {
					print "<div class='unit'>1850 Subjects: ".$vs_subjects_1850."</div>";
				}
				if ($vs_subjects_1838 = $t_object->get('ca_objects.subjects_1838', array('delimiter' => ', '))) {
					print "<div class='unit'>1838 Subjects: ".$vs_subjects_1850."</div>";
				}
				if ($vs_subjects_1813 = $t_object->get('ca_objects.subjects_1813', array('delimiter' => ', '))) {
					print "<div class='unit'>1813 Subjects: ".$vs_subjects_1813."</div>";
				}	
				if ($vs_subjects_lcsh = $t_object->get('ca_objects.LCSH', array('delimiter' => ', '))) {
					print "<div class='unit'>LCSH Subjects: ".$vs_subjects_lcsh."</div>";
				}																			
?>				
											
				{{{<ifdef code="ca_objects.dateSet.setDisplayValue"><H6>Date:</H6>^ca_objects.dateSet.setDisplayValue<br/></ifdev>}}}
				
			</div><!-- end col -->
			<div class='col-sm-6 col-md-6 col-lg-6'>
				{{{representationViewer}}}
				<?php print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_object, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-sm-3 col-md-3 col-xs-4")); ?>
				{{{map}}}
				<div id="detailTools">
					<div class="detailTool"><a href='#' onclick='jQuery("#detailComments").slideToggle(); return false;'><span class="glyphicon glyphicon-comment"></span>Comments (<?php print sizeof($va_comments); ?>)</a></div><!-- end detailTool -->
					<div id='detailComments'>{{{itemComments}}}</div><!-- end itemComments -->
					<div class="detailTool"><span class="glyphicon glyphicon-share-alt"></span>{{{shareLink}}}</div><!-- end detailTool -->
				</div><!-- end detailTools -->			
			</div><!-- end col -->			
		</div><!-- end row -->
		<div class="row">
			<div class='col-sm-12 col-md-12 col-lg-12'>
				<div class='visualize'><a href='#' onclick="$('#visualizePane').slideDown();document.querySelector('.ct-chart').__chartist__.update();return false;"><i class='fa fa-gears'></i> Visualize</a></div>	
			</div><!-- end col -->			
		</div><!-- end row -->		
<?php

		#checkout code
		$va_obj_ids = $t_object->get('ca_objects_x_entities.relation_id', array('returnAsArray' => true));
		
		if ($va_children_ids = $t_object->get('ca_objects.children.object_id', array('returnAsArray' => true))) {	
			foreach ($va_children_ids as $va_id => $va_children_id) {
				$t_child = new ca_objects($va_children_id);
				$va_child_rel_ids = $t_child->get('ca_objects_x_entities.relation_id', array('returnAsArray' => true));
				foreach ($va_child_rel_ids as $vn_id => $va_children_rel_id) {
					$va_obj_ids[] = $va_children_rel_id;
				}
			}
		}			
		$qr_rels = caMakeSearchResult('ca_objects_x_entities', $va_obj_ids, array('sort' => 'ca_objects_x_entities.date_out'));
		
		// set all of the page object_ids
		$va_page_ids = array();
		while($qr_rels->nextHit()) {
			$va_page_ids[] = $qr_rels->get("ca_objects_x_entities.see_original_link", array('idsOnly' => 1));
		}
		$qr_pages = caMakeSearchResult('ca_objects', $va_page_ids);
		
		$va_parents = array();
		while($qr_pages->nextHit()) {
			$va_parents[$qr_pages->get('ca_objects.object_id')] = $qr_pages->get('ca_objects.parent.preferred_labels.name');
		}

		$qr_rels->seek(0);	// reset the result to the beginning so we can run through it again
		$vn_i = 0;
		$vs_buf = "";
		$va_readers = array();
		$va_full_set_readers = array();
		$va_occupations = array();
		
		while($qr_rels->nextHit()) {
			if ($qr_rels->get('ca_objects_x_entities.type_id') != 100) {
				continue;
			}
			$vs_buf.= "<div class='row ledgerRow'>";
				$vs_buf.= "<div class='col-xs-1 col-sm-1 col-md-1 col-lg-1'>";
				if (substr($qr_rels->get("ca_objects.preferred_labels"), 0, 6) == "Volume") {
					$vs_buf.= $qr_rels->get("ca_objects.preferred_labels", array('returnAsLink' => true));
				}
				$vs_buf.= "</div>";
								
				$vs_buf.= "<div class='col-xs-2 col-sm-2 col-md-2 col-lg-2' id='entity".$vn_i."'>";
				$vs_buf.= $qr_rels->get("ca_entities.preferred_labels.displayname", array('returnAsLink' => true));
				$vs_buf.= "</div>";
				
				$vs_entity_info = "";
				if ($qr_rels->getWithTemplate("^ca_entities.life_dates")) {
					$vs_entity_info = $qr_rels->getWithTemplate("^ca_entities.life_dates")."<br/>";
				}
				if ($qr_rels->get("ca_entities.country_origin")) {
					$vs_entity_info.= $qr_rels->get("ca_entities.country_origin")."<br/>";
				}
				if ($qr_rels->getWithTemplate("^ca_entities.industry_occupations")) {
					$vs_entity_info.= $qr_rels->getWithTemplate("^ca_entities.industry_occupations", array('delimiter' => ', '))."<br/>";
				}
				if ($qr_rels->get("ca_entities.industry_occupations")) {
					$va_occupation_count = $qr_rels->get("ca_entities.industry_occupations", array('returnAsArray' => true, 'convertCodesToDisplayText' => true));
					foreach ($va_occupation_count as $va_occupation_key => $va_occupations_type) {
						foreach ($va_occupations_type as $va_occupation_key => $va_occupation) {
							$va_occupations["$va_occupation"][] = $qr_rels->get("ca_entities.entity_id");
						}
					}
				}
									
				TooltipManager::add('#entity'.$vn_i, "<div class='tooltipImage'>".$qr_rels->getWithTemplate('<unit relativeTo="ca_entities">^ca_object_representations.media.preview</unit>')."</div><b>".$qr_rels->get("ca_entities.preferred_labels.displayname")."</b><br/>".$vs_entity_info.$qr_rels->getWithTemplate("^ca_entities.biography.biography_text")); 

				$vs_buf.= "<div class='col-xs-2 col-sm-2 col-md-2 col-lg-2'>";
				$vs_buf.= $qr_rels->get("ca_objects_x_entities.date_out");
				$vs_buf.= "</div>";	
				
				$vs_buf.= "<div class='col-xs-2 col-sm-2 col-md-2 col-lg-2'>";
				$vs_buf.= $qr_rels->get("ca_objects_x_entities.date_in");
				$vs_buf.= "</div>";

				$vs_buf.= "<div class='col-xs-2 col-sm-2 col-md-2 col-lg-2'>";
				$vs_buf.= $qr_rels->get("ca_objects_x_entities.representative");
				$vs_buf.= "</div>";
										
				$vs_buf.= "<div class='col-xs-1 col-sm-1 col-md-1 col-lg-1'>";
				$vs_buf.= $qr_rels->get("ca_objects_x_entities.fine");
				$vs_buf.= "</div>";
				
				$vs_buf.= "<div class='col-xs-2 col-sm-2 col-md-2 col-lg-2'>";
				$vs_buf.= $va_parents[$qr_rels->get("ca_objects_x_entities.see_original_link", array('idsOnly' => true))]." ".$qr_rels->get("ca_objects_x_entities.see_original_link", array('returnAsLink' => true));
				$vs_buf.= "</div>";													
			$vs_buf.= "</div>";
			
			# Reader Count
				$vn_entity_id = $qr_rels->get("ca_entities.entity_id");
				$va_readers[$vn_entity_id] = $qr_rels->get("ca_entities.preferred_labels.displayname");
				
				$t_entity = new ca_entities($vn_entity_id);
				$va_reading_list = $t_entity->get('ca_objects.object_id', array('returnAsArray' => true, 'restrictToRelationshipTypes' => array('reader')));
				$va_volume_list = $t_object->get('ca_objects.children.object_id', array('returnAsArray' => true));
				foreach ($va_volume_list as $va_volume_key => $va_volume_list_id) {
					$vn_read_volume = false;
					foreach ($va_reading_list as $va_reading_key => $va_reading_id) {
						if ($va_reading_id == $va_volume_list_id) {
							$vn_read_volume = true;
						}
					}
				}
				if ($vn_read_volume == true) {
					$va_full_set_readers[$vn_entity_id] = $qr_rels->get("ca_entities.preferred_labels.displayname");
				}

			
			$vn_i++;
		}
		$vn_all_professions = 0;
		foreach ($va_occupations as $va_occupation_name => $va_occupation_count) {
			$vn_all_professions = $vn_all_professions+sizeof($va_occupation_count);
		}
		$va_js_stuff = array();
		$va_labels = array();
		$va_class_count = 1;
		foreach ($va_occupations as $va_occupation_name => $va_occupation_count) {
			$vn_fraction = round((sizeof($va_occupation_count) / $vn_all_professions)*100);
			$va_labels[$va_class_count] = "'$va_occupation_name'";
			$va_js_stuff[$va_class_count] = "{data: ".$vn_fraction.", className: 'color".$va_class_count."'}";
			$va_class_count++;
		}
?>
	<div class='row' id='visualizePane' style='display:none;'>
		<hr></hr>
		<div class='col-sm-3 col-md-3 col-lg-3'>
			
			<h1>Circulation</h1>
<?php
			print "<div class='time'>Average checkout time<br/><span class='count'>0 weeks</span></div>";
			print "<div class='checkouts'>Total checkouts<br/><span class='count'>".$qr_rels->numHits()."</span></div>";
			print "<div class='readers'><div>Total readers</div>";
			if ($t_object->get('ca_objects.children.object_id')) {
				print "<div class='partial'>partial set<br/><span class='count'>".sizeof($va_readers)."</span></div>";
				print "<div class='full'>full set<br/><span class='count'>".sizeof($va_full_set_readers)."</span></div>";
			} else {
				print "<div class='partial'><span class='count'>".sizeof($va_readers)."</span></div>";
			}
			print "</div>";
?>	
			<!-- Chartist -->
		</div><!-- end col-->
		<div class='col-sm-6 col-md-6 col-lg-6' >
			<h1>Readers</h1>
			<div class="ct-chart ct-square"></div>
				<script>
					var data = {
					  labels: [<?php print join(', ', $va_labels); ?>],
					  series: [
					  <?php print join(', ', $va_js_stuff); ?>
					  ]
					};

					var options = {
					  labelInterpolationFnc: function(value) {
						return value[0]
					  }
					};

					var responsiveOptions = [
					  ['screen and (min-width: 640px)', {
						chartPadding: 50,
						labelOffset: 70,
						labelDirection: 'explode',
						labelInterpolationFnc: function(value) {
						  return value;
						}
					  }],
					  ['screen and (min-width: 1024px)', {
						labelOffset: 90,
						chartPadding: 50
					  }]
					];

					new Chartist.Pie('.ct-chart', data, options, responsiveOptions);

				</script>	
		</div><!-- end col-->
		<div class='col-sm-3 col-md-3 col-lg-3'>					
				<div class='closeBut'><a href='#' onclick="$('#visualizePane').slideUp(); return false;">close</a></div>
		</div><!-- end col-->
	</div><!-- end row -->
	<div class='container'>
		<div class='row titleBar' >
		<hr></hr>
			<div class='col-xs-1 col-sm-1 col-md-1 col-lg-1'>Volume</div>
			<div class='col-xs-2 col-sm-2 col-md-2 col-lg-2'>Borrower Name</div>
			<div class='col-xs-2 col-sm-2 col-md-2 col-lg-2'>Date Out</div>
			<div class='col-xs-2 col-sm-2 col-md-2 col-lg-2'>Date In</div>
			<div class='col-xs-2 col-sm-2 col-md-2 col-lg-2'>Representative</div>
			<div class='col-xs-1 col-sm-1 col-md-1 col-lg-1'>Fine</div>
			<div class='col-xs-2 col-sm-2 col-md-2 col-lg-2'>Ledger</div>

		</div><!-- end row -->
<?php			
		print $vs_buf;

?>		
	</div><!-- end col --></div><!-- end container -->

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