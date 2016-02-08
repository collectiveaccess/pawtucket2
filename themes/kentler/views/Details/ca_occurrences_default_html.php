<?php
	$t_item = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$va_access_values = caGetUserAccessValues($this->request);
	$t_lists = new ca_lists();
	$vn_promo_type_id = $t_lists->getItemIDFromList("object_representation_types", "press_promo");
 ?>
<div class="row">
	<div class='col-xs-12 navTop'><!--- only shown at small screen size -->
		{{{previousLink}}}{{{resultsLink}}}{{{nextLink}}}
	</div><!-- end detailTop -->
	<div class='col-xs-12 col-sm-12'>
			<div class="row">
				<div class='col-sm-10'>
					<H1><span class="ltgrayText">{{{^ca_occurrences.type_id}}}</span><br/>{{{^ca_occurrences.preferred_labels.name}}}</H1>
					{{{<ifdef code="ca_occurrences.subtitle"><H5>^ca_occurrences.subtitle</H5></ifdef>}}}
				</div><!-- end col -->
				<div class='navLeftRight col-sm-2'>
					<div class="detailNavBgRight">
						{{{resultsLink}}}{{{previousLink}}}{{{nextLink}}}
					</div><!-- end detailNavBgLeft -->
				</div><!-- end col -->
			</div><!-- end row -->
			<div class="row">			
				<div class='col-md-6 col-lg-6'>
					{{{<ifdef code="ca_occurrences.exhibition_dates"><H6>Date</H6>^ca_occurrences.exhibition_dates<br/></ifdef>}}}
					{{{<ifdef code="ca_occurrences.opening_date"><H6>Opening Reception</H6>^ca_occurrences.opening_date<br/></ifdef>}}}
					
					{{{<ifcount code="ca_entities" restrictToRelationshipTypes="curator" min="1"><H6>Curated By</H6></ifcount>}}}
					{{{<unit relativeTo="ca_entities" restrictToRelationshipTypes="curator" delimiter=", ">^ca_entities.preferred_labels.displayname</unit>}}}
					
					{{{<ifcount code="ca_entities" restrictToRelationshipTypes="essayist" min="1"><H6>Essay By</H6></ifcount>}}}
					{{{<unit relativeTo="ca_entities" restrictToRelationshipTypes="essayist" delimiter=", ">^ca_entities.preferred_labels.displayname</unit>}}}
					
				</div><!-- end col -->
				<div class='col-md-6 col-lg-6'>
					{{{<ifcount code="ca_entities" restrictToRelationshipTypes="artist" min="1" max="1"><H6>Artist</H6></ifcount>}}}
					{{{<ifcount code="ca_entities" restrictToRelationshipTypes="artist" min="2"><H6>Artists</H6></ifcount>}}}
					{{{<unit relativeTo="ca_entities" restrictToRelationshipTypes="artist" delimiter=", ">^ca_entities.preferred_labels.displayname</unit>}}}
					
					{{{<ifcount code="ca_occurrences.related" restrictToTypes="exhibition" min="1" max="1"><H6>Related exhibition</H6></ifcount>}}}
					{{{<ifcount code="ca_occurrences.related" restrictToTypes="exhibition" min="2"><H6>Related exhibitions</H6></ifcount>}}}
					{{{<unit relativeTo="ca_occurrences.related" restrictToTypes="exhibition" delimiter="<br/>"><l>^ca_occurrences.preferred_labels.name</l></unit>}}}
					
					{{{<ifcount code="ca_occurrences.related" restrictToTypes="event" min="1" max="1"><H6>Related event</H6></ifcount>}}}
					{{{<ifcount code="ca_occurrences.related" restrictToTypes="event" min="2"><H6>Related events</H6></ifcount>}}}
					{{{<unit relativeTo="ca_occurrences.related" restrictToTypes="event" delimiter="<br/>"><l>^ca_occurrences.preferred_labels.name</l></unit>}}}
				</div><!-- end col -->
			</div><!-- end row -->
			<div class="row">
				<div class='col-md-12 col-lg-12'>
					<br/><HR/><br/>
				</div>
			</div>
			<div class="row">			
				<div class='col-sm-5'>
<?php
					$va_reps = $t_item->getRepresentations(array("large"), null, array("checkAccess" => $va_access_values));
					$va_art_installations = array();
					$va_promos = array();
					foreach($va_reps as $va_rep){
						$va_tmp = array("image" => $va_rep["tags"]["large"], "label" => $va_rep["label"], "image_link" => "<a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'Detail', 'GetRepresentationInfo', array('object_id' => $t_item->getPrimaryKey(), 'representation_id' => $va_rep["representation_id"], 'overlay' => 1))."\"); return false;' >".$va_rep["tags"]["large"]."</a>");
						
						if($va_rep["type_id"] == $vn_promo_type_id){
							$va_promos[] = $va_tmp;
							}else{
							$va_art_installations[] = $va_tmp;
						}
					}
					if(sizeof($va_art_installations)){
						print "<H6>"._t("%1 Images", $t_item->get("type_id", array("convertCodesToDisplayText" => true)))."</H6><br/>";
						foreach($va_art_installations as $va_art_installation){
							print "<p class='fullWidthImg'>".$va_art_installation["image_link"];
							if($va_art_installation["label"]){
								print "<br/><small>".$va_art_installation["label"]."</small>";
							}
							print "</p><br/>";
						}
						print "<br/><br/>";
					}
					if(sizeof($va_promos)){
						print "<H6>"._t("Press and Promotion")."</H6><br/>";
						foreach($va_promos as $va_promo){
							print "<p class='fullWidthImg'>".$va_promo["image_link"];
							if($va_promo["label"]){
								print "<br/><small>".$va_promo["label"]."</small>";
							}
							print "</p><br/>";
						}
					}
?>				
				</div>
				<div class='col-sm-1'>
				
				</div>
				<div class='col-sm-6 largerText'>
					{{{<ifdef code="ca_occurrences.description"><H6>About the ^ca_occurrences.type_id</H6><br/>^ca_occurrences.description</ifdef>}}}
				</div>
			</div>
	</div><!-- end col -->
</div><!-- end row -->