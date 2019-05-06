<?php
$ps_mode = $this->getVar('mode');
if(!$ps_mode){
	print "<H2 class='text-center' id='initialMessage' style='display:none;'>Please select items to compare from the index above.</H2>";
}
if($ps_mode != "remove"){
	$va_items = array();
	$va_ids = $this->getVar('entity_list');
	if(is_array($va_ids) && sizeof($va_ids)){
		foreach ($va_ids as $vs_color => $vn_id) {
			$t_entity = new ca_entities($vn_id);
			$va_stops = $t_entity->get('ca_tour_stops.stop_id', ['returnAsArray' => true]);
			$qr_stops = caMakeSearchResult('ca_tour_stops', $va_stops, array('sort' => 'ca_tour_stops.tourStopDateSet.tourStopDateIndexingDate'));
			$vn_count = 0;
			$va_stop_list = array();
			$vs_first_date = "";
			$vs_last_date = "";
			while($qr_stops->nextHit()) {
				$va_tmp = array();
				$va_tmp['name'] = $qr_stops->get('ca_tour_stops.preferred_labels');
				$va_raw_dates = array_shift(array_shift($qr_stops->get('ca_tour_stops.tourStopDateSet.tourStopDateIndexingDate', array('rawDate' => 1, 'returnWithStructure' => 1))));
				if ($vn_count == 0) { $vs_first_date = caGetLocalizedHistoricDate($va_raw_dates['tourStopDateIndexingDate']['start'], array('timeOmit' => true));}
				$va_tmp['startDateRaw'] = $va_raw_dates['tourStopDateIndexingDate']['start'];
				$va_tmp['startDate'] = caGetLocalizedHistoricDate($va_raw_dates['tourStopDateIndexingDate']['start'], array('timeOmit' => true));
				$va_tmp['endDate'] = $vs_last_date = caGetLocalizedHistoricDate($va_raw_dates['tourStopDateIndexingDate']['end'], array('timeOmit' => true));
				$va_tmp['displayDate'] = $qr_stops->get('ca_tour_stops.tourStopDateSet.tourStopDateDisplayDate');
				$va_tmp['description'] = $qr_stops->get('ca_tour_stops.tour_stop_description');
				$va_tmp['source'] = $qr_stops->get('ca_list_items.preferred_labels', array('delimiter' => ', '));			
				$vn_count++;
				$va_stop_list[$qr_stops->get('ca_tour_stops.stop_id')] = $va_tmp;
			}
			$va_items[$vn_id] = array(
								"stop_list" => $va_stop_list, 
								"icon" => $t_entity->get('ca_entities.agentMedia', array('version' => 'icon', 'class' => 'img-circle')),
								"name" => $t_entity->get('ca_entities.preferred_labels'),
								"first_date" => $vs_first_date,
								"last_date" => $vs_last_date,
								"color" =>  $vs_color,
								"type"	=> "entity",
								"entity_id"	=> $vn_id
							);
		}
	}
	$va_object_ids = $this->getVar('object_list');
	if(is_array($va_object_ids) && sizeof($va_object_ids)){
		foreach ($va_object_ids as $vs_color => $vn_id) {
			$t_object = new ca_objects($vn_id);
			$va_stops = $t_object->get('ca_tour_stops.stop_id', ['returnAsArray' => true]);
			$qr_stops = caMakeSearchResult('ca_tour_stops', $va_stops, array('sort' => 'ca_tour_stops.tourStopDateSet.tourStopDateIndexingDate'));
			$vn_count = 0;
			$va_stop_list = array();
			$vs_first_date = "";
			$vs_last_date = "";
			while($qr_stops->nextHit()) {
				$va_tmp = array();
				$va_tmp['name'] = $qr_stops->get('ca_tour_stops.preferred_labels');
				$va_raw_dates = array_shift(array_shift($qr_stops->get('ca_tour_stops.tourStopDateSet.tourStopDateIndexingDate', array('rawDate' => 1, 'returnWithStructure' => 1))));
				if ($vn_count == 0) { $vs_first_date = caGetLocalizedHistoricDate($va_raw_dates['tourStopDateIndexingDate']['start'], array('timeOmit' => true));}
				$va_tmp['startDateRaw'] = $va_raw_dates['tourStopDateIndexingDate']['start'];
				$va_tmp['startDate'] = caGetLocalizedHistoricDate($va_raw_dates['tourStopDateIndexingDate']['start'], array('timeOmit' => true));
				$va_tmp['endDate'] = $vs_last_date = caGetLocalizedHistoricDate($va_raw_dates['tourStopDateIndexingDate']['end'], array('timeOmit' => true));
				$va_tmp['displayDate'] = $qr_stops->get('ca_tour_stops.tourStopDateSet.tourStopDateDisplayDate');
				$va_tmp['description'] = $qr_stops->get('ca_tour_stops.tour_stop_description');
				$va_tmp['source'] = $qr_stops->get('ca_list_items.preferred_labels', array('delimiter' => ', '));			
				$vn_count++;
				$va_stop_list[$qr_stops->get('ca_tour_stops.stop_id')] = $va_tmp;
			}
			$va_items[$vn_id] = array(
								"stop_list" => $va_stop_list, 
								"icon" => array_shift($t_object->get('ca_object_representations.media.icon', array('returnAsArray' => true))),
								"name" => $t_object->get('ca_objects.preferred_labels.name'),
								"first_date" => $vs_first_date,
								"last_date" => $vs_last_date,
								"color" =>  $vs_color,
								"type"	=> "object",
								"object_id"	=> $vn_id
							);
		}
	}
	if(is_array($va_items) && sizeof($va_items)){
		foreach($va_items as $vn_id => $va_item){
?>
			<div class="col-xs-3 timelineColumn" id="<?php print $va_item["type"].$vn_id; ?>">
				<div class="people"><?php print $va_item["icon"]; ?>
					<div>
						<h4><?php print $va_item["name"]; ?><i class='glyphicon glyphicon-remove timelineTravelerRemove' data-entity_id='<?php print $va_item["entity_id"]; ?>' data-object_id='<?php print $va_item["object_id"]; ?>'></i></h4>
<?php		
						print "<small>Traveling between ".$va_item["first_date"]." - ".$va_item["last_date"]."</small>";			
?>
					</div>
				</div><!-- end people -->
				<div class='column'>
<?php
				foreach($va_item["stop_list"] as $vn_stop_id => $va_stop){
?>
					<ul class="timeline timeLeft" data-start-date="<?php print $va_stop["startDateRaw"]; ?>" id="<?php print $vn_stop_id; ?>">				
						<li>
						  <div class="timeline-panel" style='border-left: 5px solid #<?php print $va_item["color"];?>'>
							<div class="timeline-heading">
							  <h4 class="timeline-title"><?php print $va_stop['name'];?></h4>
							  <p><a href="#" onClick="alignTimeline(<?php print $va_stop["startDateRaw"]; ?>); return false;"><small class="text-muted"><i class="glyphicon glyphicon-time"></i> <?php print $va_stop['displayDate'];?></small></a></p>
							</div>
							<div class="timeline-body">
								<p><?php print $va_stop['description'];?></p>
								<?php ( $va_stop['source'] ? print "<p class='source'>Source: ".$va_stop['source']."</p>" : ""); ?>
							</div>
						  </div>
						</li>
					</ul>
<?php		
				}
?>
					<div style='clear:both; height:320px;'></div>
				</div><!-- end column -->
			</div><!-- end col -->
			<script type="text/javascript">
				jQuery(document).ready(function() {
					jQuery('#initialMessage').hide();
				});
			</script>
<?php
		}
	}else{
		if (!is_array($va_entity_list = Session::getVar('itinera_entity_list'))) { $va_entity_list = array(); }
 		if (!is_array($va_object_list = Session::getVar('itinera_object_list'))) { $va_object_list = array(); }
 			
		if ((!sizeof($va_entity_list)) && !sizeof($va_object_list)){
 			
			
?>
			<script type="text/javascript">
				jQuery(document).ready(function() {
					jQuery('#initialMessage').show();
				});
			</script>
<?php
		}
	}
		?>
		<script type="text/javascript">
			jQuery(document).ready(function() {
				reSizeScroll();
			
				jQuery(".timelineTravelerRemove").bind("click", function() {
					if(jQuery(this).data('entity_id')){
						var id = jQuery(this).data('entity_id');
						var id_name = 'id';
						
						jQuery("#entity" + id).remove();
					}else{
						var id = jQuery(this).data('object_id');
						var id_name = 'object_id';
						
						jQuery("#object" + id).remove();
					}
					reSizeScroll();
					jQuery.get('<?php print caNavUrl($this->request, '*', '*', 'Get'); ?>/' + id_name + '/' + id +'/m/remove', function(d){ 
						jQuery(d).appendTo("#travelerContentTimelineColumns");
						jQuery.get('<?php print caNavUrl($this->request, '*', '*', 'getTimelineData'); ?>', function(timelineJSONArray){ 
							var objs = JSON.parse(timelineJSONArray);
							renderTimeline(objs.events, objs.start, objs.end, objs.yearSpan);
						});
					});
		
				});
				jQuery(".timelineContainer").scroll(function() {
					if((jQuery("#travelerContentTimelineColumns").outerWidth() - jQuery(".timelineContainer").outerWidth()) > 50){
						if(jQuery(".timelineContainer").scrollLeft() == (jQuery("#travelerContentTimelineColumns").outerWidth() - jQuery(".timelineContainer").outerWidth())){
							jQuery('.moreArrowRight').hide();
						}else{
							jQuery('.moreArrowRight').show();
						}
					}
				});
		
			});
			jQuery.get('<?php print caNavUrl($this->request, '*', '*', 'getTimelineData'); ?>', function(timelineJSONArray){ 
				var objs = JSON.parse(timelineJSONArray);
				renderTimeline(objs.events, objs.start, objs.end, objs.yearSpan);
			});
		
			function reSizeScroll(){
				//resize col container
				var numCols = jQuery('.timelineColumn').length;
				var colWidth = jQuery('.timelineColumn').outerWidth();
				var newWidth = colWidth * numCols;
				if(newWidth < jQuery('.timelineContainer').width()){
					newWidth = jQuery('.timelineContainer').width();
				}
				if((newWidth - jQuery('.timelineContainer').width()) > 50){
					jQuery('.moreArrowRight').show();
				}else{
					jQuery('.moreArrowRight').hide();
				}
				jQuery("#travelerContentTimelineColumns").width((newWidth + 30) + "px");
				if(numCols == 0){
					jQuery('#initialMessage').show();
				}
			}
			function alignTimeline(date){
				jQuery('.timelineColumn .column').each(function() {
					col = $(this);
					var scrolled = false;
					col.children('ul').each(function () {
						if(scrolled == false){
							var event_date = $(this).data('start-date');
							if((date == event_date) || (event_date > date)){
								var position = $(this).position();
								col.scrollTop(col.scrollTop() + position.top - 100);
								//alert("moved");
								scrolled = true;
							}else{
								var position = $(this).position();
								col.scrollTop(col.scrollTop() + position.top - 100);
							}
						}
					});
				});
			}
		</script>
<?php
}
?>