<?php
	$va_access_values = $this->getVar("access_values");
	$vn_timeline_set_id = $this->getVar("timeline_set_id");
	$qr_schools = $this->getVar("schools_results");
?>
	<div class="row tanBg exploreRow exploreSchoolsRow">
		<div class="col-sm-12">
			<H1>Explore BC Schools</H1>
			<p>
				Records and stories of Indian Residential Schools in British Columbia reveal a great deal about our history of BC and our histories of Canada. These collections provide a window into a way of knowing how the schools shaped the lives of Survivors, their families and communities. Here you can see the operation of these schools as a nation-wide system as well as very individual and distinct functions of community life in BC. Each school has a distinct set of histories and meaning to these communities. Survivor stories, documents, images, records and objects on the schools provide us a way of knowing stories so integral to the shape of our histories as Canadians and as Indigenous peoples.
			</p>
			<div class="text-center">
<?php
			print caNavLink($this->request, "Browse All Schools", "btn-default btn-lg", "", "Browse", "schools");
?>			
			</div>

		</div>
	</div>
	<div class='row'>
		<div class="col-lg-10 col-lg-offset-1 col-md-12 schoolBottom">
			<div class='row noPadding'>
				<div class="col-sm-12 schoolTabContainer noPadding">
					<div id="exploreSchoolMapContainer" class="schoolTab">
<?php
						print $this->getVar("map");
?>
					</div>
					<div id="exploreSchoolTimelineContainer" class="schoolTab">
						<div id="timeline-embed"></div>
					</div>
					<div id="exploreSchoolListContainer" class="schoolTab">
						<div class='row'>
<?php
						if($qr_schools->numHits()){
							$va_ids = array();
							while($qr_schools->nextHit()){
								# --- only show bc schools - idno = 37
								#$va_place_hier = array_pop($qr_schools->get("ca_places.hierarchy.idno", array("returnWithStructure" => true)));
								#if(is_array($va_place_hier) && in_array(37, $va_place_hier)){
									print "<div class='col-xs-6 col-sm-3 col-md-2'>";
									$vs_image = $qr_schools->getWithTemplate("<unit relativeTo='ca_objects' length='1' restrictToRelationshipTypes='featured'>^ca_object_representations.media.iconlarge</unit>", array("checkAccess" => $va_access_values, "limit" => 1));
									if(!$vs_image){
										$vs_image = $qr_schools->get('ca_object_representations.media.iconlarge', array("checkAccess" => $va_access_values));
									}
									if(!$vs_image){
										$vs_image = caGetThemeGraphic($this->request, 'spacer.png');
									}
									if($vs_image){
										print "<div>".caDetailLink($this->request, $vs_image, '', 'ca_entities', $qr_schools->get("entity_id"))."</div>";
									}
									print "<div class='schoolLink'>".caDetailLink($this->request, $qr_schools->get('ca_entities.preferred_labels'), '', 'ca_entities', $qr_schools->get("entity_id"))."</div>";
									print "</div>";
									$va_ids[] = $qr_schools->get("entity_id");
								#}
							}
							# --- do entity context here since we're filtering out non-bc schools
							$o_entity_context = new ResultContext($this->request, 'ca_entities', 'exploreSchools');
							$o_entity_context->setAsLastFind();
							$o_entity_context->setResultList($va_ids);
							$o_entity_context->saveContext();
 			
						}
?>						
						</div>
					</div>
					<script type="text/javascript">
						jQuery(document).ready(function() {
							createStoryJS({
								type:       'timeline',
								width:      '100%',
								height:     '100%',
								source:     '<?php print caNavUrl($this->request, '', 'Gallery', 'getSetInfoAsJSON', array('mode' => 'timeline', 'set_id' => $vn_timeline_set_id)); ?>',
								embed_id:   'timeline-embed'
							});
						});
					</script>
				</div><!-- end col -->
			</div><!-- end row -->
			<div class='row noPadding'>
				<div class="col-md-4 col-sm-12 noPadding">
					<a href="#" class="selected schoolTabButton" id="exploreSchoolListButton" onClick="toggleTag('exploreSchoolList'); return false;"><div class="grayBg text-center">
						<i class="fa fa-align-left" aria-hidden="true"></i> B.C. Schools
					</div></a>
				</div><!-- end col -->
				<div class="col-md-4 col-sm-12 noPadding">
					<a href="#" class="schoolTabButton" id="exploreSchoolTimelineButton" onClick="toggleTag('exploreSchoolTimeline'); return false;"><div class="grayBg text-center">
						<i class="fa fa-clock-o" aria-hidden="true"></i> Timeline
					</div></a>
				</div><!-- end col -->
				<div class="col-md-4 col-sm-12 noPadding">
					<a href="#" class="schoolTabButton" id="exploreSchoolMapButton" onClick="toggleTag('exploreSchoolMap'); return false;"><div class="grayBg text-center">
						<i class="fa fa-map" aria-hidden="true"></i> Map
					</div></a>
				</div><!-- end col -->
			</div><!-- end row -->
		</div><!-- end col -->
	</div><!-- end row -->
<script type="text/javascript">
	function toggleTag(ID){
		$('.schoolTab').css('z-index', '1');
		$('#' + ID + 'Container').css('z-index', '10');
		$('.schoolTabButton').removeClass('selected');
		$('#' + ID + 'Button').addClass('selected');
	}
</script>