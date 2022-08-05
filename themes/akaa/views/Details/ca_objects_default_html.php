<?php
/* ----------------------------------------------------------------------
 * themes/default/views/bundles/ca_objects_default_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013-2015 Whirl-i-Gig
 *
 * For more information visit http://www.CollectiveAccess.org
 *
 * This program is free software; you may redistribute it and/or modify it under
 * the terms of the provided license as published by Whirl-i-Gig
 *
 * CollectiveAccess is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTIES whatsoever, including any implied warranty of 
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  
 *
 * This source code is free and modifiable under the terms of 
 * GNU General Public License. (http://www.gnu.org/copyleft/gpl.html). See
 * the "license.txt" file for details, or visit the CollectiveAccess web site at
 * http://www.CollectiveAccess.org
 *
 * ----------------------------------------------------------------------
 */
 
	$t_object = 			$this->getVar("item");
	$va_comments = 			$this->getVar("comments");
	$va_tags = 				$this->getVar("tags_array");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");

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
				
				
				<div id="detailAnnotations"></div><!-- end detailAnnotations -->
				
				<?php print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_object, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-sm-3 col-md-3 col-xs-4")); ?>
				

			</div><!-- end col -->
			
			<div class='col-sm-6 col-md-6 col-lg-5'>
				<H1>{{{<i>^ca_objects.preferred_labels.name</i>}}}</H1>
				<HR>
				{{{<ifdef code="ca_objects.nonpreferred_labels.name"><div class='unit'><unit relativeTo="ca_objects.nonpreferred_labels" delimiter="<br/>"><i>^ca_objects.nonpreferred_labels.name</i></unit></div></ifdef>}}}
<?php
				if ($va_artist = $t_object->get('ca_entities.preferred_labels', array('restrictToRelationshipTypes' => array('creator'), 'delimiter' => ', ', 'returnAsLink' => true))) {
					print "<div class='unit'><label>Artist</label>".$va_artist."</div>";
				}
				$va_years = $t_object->get("ca_objects.date.dates_value", array("returnAsArray" => true));
				$vs_date_note = $t_object->get("ca_objects.date_notes");
				if((is_array($va_years) && sizeof($va_years)) || $vs_date_note){
					print "<div class='unit'><label>Year".((sizeof($va_years) > 1) ? "s" : "")."</label>";
					if(is_array($va_years) && sizeof($va_years)){
						$va_tmp = array();
						foreach($va_years as $vs_year){
							$va_tmp[] = caNavLink($this->request, $vs_year, '', '', 'Browse', 'artworks', array("facet" => "year_facet", "id" => $vs_year));
						}
						print join(", ", $va_tmp);
						if($vs_date_note){
							print ", ";
						}
					}
					if($vs_date_note){
						print $vs_date_note;
					}
					print "</div>";
				}
				$va_mediums = $t_object->get("ca_objects.medium", array("returnAsArray" => true));
				if(is_array($va_mediums) && sizeof($va_mediums)){
					$t_list_item = new ca_list_items();
					print "<div class='unit'><label>Type".((sizeof($va_mediums) > 1) ? "s" : "")."</label>";
					$va_tmp = array();
					foreach($va_mediums as $vn_medium_id){
						$t_list_item->load($vn_medium_id);
						$va_tmp[] = caNavLink($this->request, $t_list_item->get("ca_list_item_labels.name_singular"), '', '', 'Browse', 'artworks', array("facet" => "medium_facet", "id" => $vn_medium_id));
					}
					print join(", ", $va_tmp);
					print "</div>";
				}
				#if ($va_dimensions = $t_object->get('ca_objects.dimensions', array('returnWithStructure' => true))) {
				#	$va_dims = array();
				#	foreach ($va_dimensions as $va_key => $va_dimension_t) {
				#		foreach ($va_dimension_t as $va_key => $va_dimension) {
				#			if ($va_dimension['dimensions_length']) {
				#				$va_dims[] = $va_dimension['dimensions_length']." L";
				#			}
				#			if ($va_dimension['dimensions_width']) {
				#				$va_dims[] = $va_dimension['dimensions_width']." W";
				#			}
				#			if ($va_dimension['dimensions_height']) {
				#				$va_dims[] = $va_dimension['dimensions_height']." H";
				#			}
				#			if ($va_dimension['dimensions_thickness']) {
				#				$va_dims[] = $va_dimension['dimensions_thickness']." D";
				#			}															
				#		}
				#	}
				#	if (sizeof($va_dims) > 0) {
				#		print "<div class='unit'><h6>Dimensions</h6>".join(' x ', $va_dims)."</div>";
				#	}
				#}
				if ($va_description = $t_object->get('ca_objects.description', array('delimiter' => '<br/>'))) {
					print "<div class='unit'><label>Medium</label>".$va_description."</div>";
				}
				if ($vs_dimensions = $t_object->get('ca_objects.dimensions.measurement_notes', array('delimiter' => '<br/>'))) {
					print "<div class='unit'><label>Dimensions</label>".$vs_dimensions."</div>";
				}

?>
			</div><!-- end col -->
		</div><!-- end row -->
{{{<ifcount code="ca_entities" restrictToRelationshipTypes="creator" min="1"><unit relativeTo="ca_entities" restrictToRelationshipTypes="creator">
			<br/><br/><br/>
			<div class="row">
				<div class="col-sm-12">
					<H2>Related Artworks</H2><HR/>
				</div>
			</div>
			<div class="row">
				<div id="browseResultsContainer">
					<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>
				</div><!-- end browseResultsContainer -->
			</div><!-- end row -->
			<script type="text/javascript">
				jQuery(document).ready(function() {
					jQuery("#browseResultsContainer").load("<?php print caNavUrl($this->request, '', 'Browse', 'artworks', array('facet' => 'entity_facet', 'id' => '^ca_entities.entity_id'), array('dontURLEncodeParameters' => true)); ?>", function() {
						jQuery('#browseResultsContainer').jscroll({
							autoTrigger: true,
							loadingHtml: '<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>',
							padding: 20,
							nextSelector: 'a.jscroll-next'
						});
					});
					
					
				});
			</script>
</unit></ifcount>}}}		

<?php
					$va_medium = $t_object->get('ca_objects.medium', array('returnAsArray' => 1));
					if(is_array($va_medium) && sizeof($va_medium)) {
						$vn_medium = $va_medium[0];

?>					
						{{{<br/><br/><br/>
							<div class="row">
								<div class="col-sm-12">
									<H2>Similar Artists</H2><HR/>
								</div>
							</div>
							<div class="row">
								<div id="browseResultsContainerEntities">
									<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>
								</div><!-- end browseResultsContainer -->
							</div><!-- end row -->
							<script type="text/javascript">
								jQuery(document).ready(function() {
									jQuery("#browseResultsContainerEntities").load("<?php print caNavUrl($this->request, '', 'Browse', 'artists', array('facet' => 'medium_facet', 'id' => $vn_medium), array('dontURLEncodeParameters' => true)); ?>", function() {
										jQuery('#browseResultsContainerEntities').jscroll({
											autoTrigger: true,
											loadingHtml: '<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>',
											padding: 20,
											nextSelector: 'a.jscroll-next'
										});
									});
					
					
								});
							</script>}}}
<?php
					}
?>

</div><!-- end container -->
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