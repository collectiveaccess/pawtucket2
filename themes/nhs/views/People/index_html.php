<?php
	$qr_people = $this->getVar("set_items_as_search_result");
	$va_access_values = $this->getVar("access_values");
	$va_entity_facets = $this->getVar("entity_facets");
	$va_event_facets = $this->getVar("event_facets");
?>
	<div class="row"><div class="col-sm-12">
		<H1>People</H1>
	</div></div>
<div class="container">
	<div class="row">
		<div class="col-sm-12">
			<div class="row bgDarkBlue featuredCallOut">
				<div class="col-sm-12 col-md-6 featuredHeaderImage">
					<?php print caGetThemeGraphic($this->request, 'people.jpeg', array("alt" => "People image")); ?>
				</div>
				<div class="col-sm-12 col-md-6 text-center">
					<div class="featuredIntro"><div class='featuredIntroTitle'>{{{people_intro_title}}}</div>{{{people_intro}}}</div>
					<div class="featuredSearch"><form role="search" action="<?php print caNavUrl($this->request, '', 'Search', 'entities'); ?>">
						<div class="formOutline">
							<div class="form-group">
								<input type="text" class="form-control" id="peopleSearchInput" placeholder="<?php print _t("Search All People & Organizations"); ?>" name="search" autocomplete="off" aria-label="<?php print _t("Search"); ?>" />
							</div>
							<button type="submit" class="btn-search" id="featuredSearchButton"><span class="glyphicon glyphicon-search" aria-label="<?php print _t("Submit Search"); ?>"></span></button>
						</div>
					</form></div>
				</div>
			</div>
		
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12 col-lg-10 col-lg-offset-1">		
			<div class="featuredList">
				<div class='col-sm-12 col-md-6 col-md-offset-3'>
<?php
				print caNavLink($this->request, "Browse All People & Organizations <i class='fa fa-arrow-right'></i>", "btn btn-landing", "", "Browse", "entities");
?>
				</div>
						
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-8 col-sm-offset-2 col-md-12 col-md-offset-0 col-lg-10 col-lg-offset-1">		
			<hr/><H2>Featured Stories</H2>
<?php
			if($vs_tmp = $this->getVar("people_stories")){
				print "<p>".$vs_tmp."</p>";
			}
?>			
			<div class="featuredList">	
	<?php	
					$vb_show_view_all_stories_link = false;
					$vn_c = 0;
					$vn_i = 0;
					if($qr_people && $qr_people->numHits()) {
						while($qr_people->nextHit()) {
							if ( $vn_i == 0) { print "<div class='row'>"; } 
							$vs_tmp = "<div class='col-sm-12 col-md-4'>";
							$vs_tmp .= "<div class='featuredTile'>";
							$vs_image = "";
							if ($vs_image = $qr_people->getWithTemplate("<unit relativeTo='ca_objects' limit='1'>^ca_object_representations.media.iconlarge</unit>", array("checkAccess" => $va_access_values))) {
								$vs_tmp .= "<div class='featuredImage'>".$vs_image."</div>";
							}
							$vs_tmp .= "<div class='title'>".$qr_people->get("ca_entities.preferred_labels.displayname")."</div>";	
							$vs_tmp .= "</div>";
							print caNavLink($this->request, $vs_tmp, "", "", "People", "Story", array("story" => $qr_people->get("ca_entities.entity_id")));

							print "</div><!-- end col-4 -->";
							$vn_i++;
							if ($vn_i == 3) {
								print "</div><!-- end row -->\n";
								$vn_i = 0;
							}
							$vn_c++;
							if($vn_c == 9){
								$vb_show_view_all_stories_link = true;
								break;
							}
						}
						if ($vn_i > 0) {
							print "</div><!-- end row -->\n";
						}
					} else {
						print _t('No featured people available');
					}
	?>		
			</div>
		</div>
	</div>
<?php
	if($vb_show_view_all_stories_link){
?>
	<div class="row">
		<div class="col-sm-12 col-lg-10 col-lg-offset-1">		
			<div class="featuredList">
				<div class='col-sm-12 col-md-6 col-md-offset-3'>
<?php
				print caNavLink($this->request, "View All Stories <i class='fa fa-arrow-right'></i>", "btn btn-landing", "", "People", "stories");
?>
				</div>
						
			</div>
		</div>
	</div>
<?php
	}
?>
	<div class="row">
		<div class="col-sm-12 col-lg-10 col-lg-offset-1 peopleFacets">	
<?php	
	if(is_array($va_entity_facets) && sizeof($va_entity_facets)){
		print "<hr/><H3>Explore People By</H3>";			
		if($vs_tmp = $this->getVar("people_explore_people")){
			print "<p>".$vs_tmp."</p>";
		}			
		foreach($va_entity_facets as $vs_facet_name => $va_facet_info) {
			
			if (!is_array($va_facet_info['content']) || !sizeof($va_facet_info['content'])) { continue; }
			print "<div class='facetName'>".$va_facet_info['label_singular']."</div>";
			$vn_facet_size = sizeof($va_facet_info['content']);
			$vn_i = 0;
			foreach($va_facet_info['content'] as $va_item) {
				if ( $vn_i == 0) { print "<div class='row'>"; } 
				print "<div class='col-sm-4'>".caNavLink($this->request, $va_item['label'], 'btn btn-default', '', 'Browse','entities', array('facet' => $vs_facet_name, 'id' => $va_item['id']))."</div>";
				$vn_i++;
				if ($vn_i == 3) {
					print "</div><!-- end row -->\n";
					$vn_i = 0;
				}
			}
			if ($vn_i > 0) {
				print "</div><!-- end row -->\n";
			}
						
		}
	}
?>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12 col-lg-10 col-lg-offset-1 peopleFacets">	
<?php	
	if(is_array($va_event_facets) && sizeof($va_event_facets)){
		print "<hr/><H3>Explore Events By</H3>";
		if($vs_tmp = $this->getVar("people_explore_events")){
			print "<p>".$vs_tmp."</p>";
		}			
		foreach($va_event_facets as $vs_facet_name => $va_facet_info) {
			
			if (!is_array($va_facet_info['content']) || !sizeof($va_facet_info['content'])) { continue; }
			print "<div class='facetName'>".$va_facet_info['label_singular']."</div>";
			$vn_facet_size = sizeof($va_facet_info['content']);
			$vn_i = 0;
			foreach($va_facet_info['content'] as $va_item) {
				if ( $vn_i == 0) { print "<div class='row'>"; } 
				print "<div class='col-sm-4'>".caNavLink($this->request, $va_item['label'], 'btn btn-default', '', 'Browse','events', array('facet' => $vs_facet_name, 'id' => $va_item['id']))."</div>";
				$vn_i++;
				if ($vn_i == 3) {
					print "</div><!-- end row -->\n";
					$vn_i = 0;
				}
			}
			if ($vn_i > 0) {
				print "</div><!-- end row -->\n";
			}
						
		}
	}
?>
		</div>
	</div>

	<div class="row">
		<div class="col-sm-12 col-lg-10 col-lg-offset-1">		
			<div class="featuredList">
				<div class='col-sm-12 col-md-6 col-md-offset-3'>
<?php
				print caNavLink($this->request, "Browse All Events <i class='fa fa-arrow-right'></i>", "btn btn-landing", "", "Browse", "events");
?>
				</div>
						
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12 col-lg-10 col-lg-offset-1"><hr/><p class="text-center">{{{people_page_credit}}}</p><br/></div>
	</div>
</div>