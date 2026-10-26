<?php
	$t_item = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");
	$vn_pdf_enabled = 		$this->getVar("pdfEnabled");
	
	# --- get collections configuration
	$o_collections_config = caGetCollectionsConfig();
	$vb_show_hierarchy_viewer = true;
	if(!$t_item->get("ca_collections.children.collection_id", array('checkAccess' => $va_access_values))){
		$vb_show_hierarchy_viewer = false;	
	}
	# --- get the collection hierarchy parent to use for exportin finding aid
	$vn_top_level_collection_id = array_shift($t_item->get('ca_collections.hierarchy.collection_id', array("returnWithStructure" => true)));
	$vs_collection_number = "";
	if($vn_top_level_collection_id != $t_item->get("ca_collections.collection_id")){
		$t_top_level_collection = new ca_collections($vn_top_level_collection_id);
		$vs_collection_number = $t_top_level_collection->get("ca_collections.repository.repository_country");
	}else{
		$vs_collection_number = $t_item->get("ca_collections.repository.repository_country");
	}
	$va_access_values = caGetUserAccessValues($this->request);
	
	$o_browse = caGetBrowseInstance("ca_objects");
	$o_browse->addCriteria("collection_facet", $t_item->get("ca_collections.collection_id"));
	$o_browse->execute(array('checkAccess' => $va_access_values));
	$vb_show_objects_link = false;
	if($o_browse->numResults()){
		$vb_show_objects_link = true;
	}
	$vb_show_collections_link = false;
	if($t_item->get("ca_collections.children.collection_id", array("checkAccess" => $va_access_values))){
		$vb_show_collections_link = true;
	}
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
		<div class="container">
			<div class="row">
				<div class='col-sm-12 col-md-6 col-lg-6'>
					<div class="unit"><H1>{{{^ca_collections.preferred_labels.name}}}</H1></div>
				</div>
				<div class='col-sm-12 col-md-6 col-lg-6'>
<?php					
					print "<div class='exportCollection'>";
					if($vs_ead = $t_item->get("ca_collections.ead_file.url")){
						print "<a href='$vs_ead' target='_blank' class='btn btn-default'><span class='glyphicon glyphicon-download'></span> EAD Finding Aid</a>";
					}
					if ($vn_pdf_enabled) {
						print caDetailLink($this->request, "<span class='glyphicon glyphicon-download'></span> PDF Finding Aid", "btn btn-default", "ca_collections",  $vn_top_level_collection_id, array('view' => 'pdf', 'export_format' => '_pdf_ca_collections_summary'));
					}
					print "</div>";
					print "<div class='inquireButtonCollection'>".caNavLink($this->request, "<span class='glyphicon glyphicon-envelope'></span> Inquire", "btn btn-default", "", "Contact", "Form", array("table" => "ca_collections", "id" => $t_item->get("ca_collections.collection_id")))."</div>";					
?>
				</div>
			</div>
			<div class="row">
				<div class='col-md-12 col-lg-12'>
					
<?php
					if($vs_collection_number){
						print '<div class="unit"><label class="inline">Collection Number: </label>'.$vs_collection_number.'</div>';
					}
?>
					{{{<ifdef code="ca_collections.parent_id"><label>Part of: <unit relativeTo="ca_collections.hierarchy" delimiter=" &gt; "><l>^ca_collections.preferred_labels.name</l></unit></label></ifdef>}}}
					
				</div><!-- end col -->
			</div><!-- end row -->
<?php
			$vs_sponsor_image = $t_item->get("ca_collections.sponsor_img.small");
			$vs_sponsor = $t_item->get("ca_collections.fa_sponsor");
			
?>
			<div class="row">
				<div class='col-sm-<?php print ($vs_sponsor_image || $vs_sponsor) ? "9" : "12"; ?>'>
					{{{<ifdef code="ca_collections.abstract"><div class="unit"><label>Abstract</label><div class="trimText">^ca_collections.abstract%delimiter=,_</div></div></ifdef>}}}
					
					{{{<ifdef code="ca_collections.adminbiohist"><div class="unit"><label>Administrative/Biographical History</label><div class="trimText">^ca_collections.adminbiohist%delimiter=,_</div></div></ifdef>}}}
				
					
					{{{<ifdef code="ca_collections.scopecontent"><div class="unit"><label>Scope and Content</label><div class="trimText">^ca_collections.scopecontent%delimiter=,_</div></div></ifdef>}}}
					{{{<ifdef code="ca_collections.general_notes"><div class="unit"><label>Notes</label><div class="trimText">^ca_collections.general_notes%delimiter=,_></div></div></ifdef>}}}
				
					{{{<ifdef code="ca_collections.unitdate.dacs_date_text"><div class="unit"><label>Date</label><unit relativeTo="ca_collections.unitdate" delimiter="<br/>"><ifdef code="ca_collections.unitdate.dacs_dates_labels">^ca_collections.unitdate.dacs_dates_labels: </ifdef>^ca_collections.unitdate.dacs_date_text <ifdef code="ca_collections.unitdate.dacs_dates_types">^ca_collections.unitdate.dacs_dates_types</ifdef></unit></div></ifdef>}}}
				
					{{{<ifdef code="ca_collections.extentDACS.extent_number|ca_collections.extentDACS.portion_label|ca_collections.extentDACS.extent_type|ca_collections.extentDACS.container_summary|ca_collections.extentDACS.physical_details">
						<div class="unit"><label>Extent</label>
							<unit relativeTo="ca_collections.extentDACS">
								<ifdef code="ca_collections.extentDACS.extent_number">^ca_collections.extentDACS.extent_number </ifdef>
								<ifdef code="ca_collections.extentDACS.extent_type">^ca_collections.extentDACS.extent_type</ifdef>
								<ifdef code="ca_collections.extentDACS.container_summary"><br/>^ca_collections.extentDACS.container_summary</ifdef>
								<ifdef code="ca_collections.extentDACS.physical_details"><br/>^ca_collections.extentDACS.physical_details</ifdef>
							</unit>
						</div>
					</ifdef>}}}
					{{{<ifdef code="ca_collections.material_type"><div class="unit"><label>Material Format</label>^ca_collections.material_type%delimiter=,_</div></ifdef>}}}
					
				</div>
<?php
			if ($vs_sponsor_image || $vs_sponsor) {	
?>
				<div class='col-sm-3'>
<?php
					if($vs_sponsor_image){
						print "<br/><div class='unit sponsorImage'>".$vs_sponsor_image."</div>";
					}
					if($vs_sponsor){
						print "<div class='unit sponsorNote'>".$vs_sponsor."</div>";
					}
?>
				</div><!-- end col -->
<?php				
			}									
?>				
			</div>
			<div class="row">
				<div class="col-sm-12">
<?php
			if($vb_show_objects_link || $vb_show_collections_link){
?>
				<div class='collectionBrowseItems'>
<?php
				if($vb_show_objects_link){
					print caNavLink($this->request, "<span class='glyphicon glyphicon-search' aria-label='Search'></span> Browse Archival Items", "btn btn-default", "", "browse", "objects", array("facet" => "collection_facet", "id" => $t_item->get("ca_collections.collection_id")));					
				}
				if($vb_show_collections_link){
					print "&nbsp;&nbsp;&nbsp;".caNavLink($this->request, "<span class='glyphicon glyphicon-search' aria-label='Search'></span> Search folder titles", "btn btn-default", "", "browse", "collections", array("facet" => "collection", "id" => $t_item->get("ca_collections.collection_id"))); 
											
				}
?>
				</div>
<?php			
			}
			# --- are there sub records?
			if($vb_show_hierarchy_viewer){
				
				
				if($searchWithin){	
?>
						<div class="collection-form">
							<div class="formOutline" style="position:relative;">
								<div class="form-group">
									<input type="text" id="searchfield" class="form-control" placeholder="Search within this collection" >
								</div>
								<button id="collectionSubmit" type="submit" class="btn-search"><span class="glyphicon glyphicon-search" aria-label="<?php print _t("Submit"); ?>"></span></button>
							</div>
						</div>
					
						<div id='collectionSearch'></div>
					
						<script type="text/javascript">
							jQuery(document).ready(function() {
								jQuery("#collectionSubmit").click(function() {
									var searchstring = $('#searchfield');
									searchstring.focus();
									$("#collectionSearch").slideDown("200", function () {
										$('#collectionSearch').html("<?php print caGetThemeGraphic($this->request, 'indicator.gif');?> Loading");
										var s = escape("ca_collections.collection_id:<?php print $t_item->get("ca_collections.collection_id"); ?> AND " + searchstring.val());
										jQuery("#collectionSearch").load("<?php print caNavUrl($this->request, '', 'Search', 'objects', null, array('dontURLEncodeParameters' => false)); ?>", { search: s }, function() {
											jQuery("#collectionSearch").jscroll({
												autoTrigger: true,
												loadingHtml: "<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>",
												padding: 20,
												nextSelector: "a.jscroll-next"
											});
										});
									});
								});
								$("#searchfield").keypress(function(e) {
									if(e.which == 13) {
									var searchstring = $('#searchfield');
									searchstring.focus();
										$("#collectionSearch").slideDown("200", function () {
											$('#collectionSearch').html("<?php print caGetThemeGraphic($this->request, 'indicator.gif');?> Loading");
											var s = escape("ca_collections.collection_id:<?php print $t_item->get("ca_collections.collection_id"); ?> AND " + searchstring.val());
											jQuery("#collectionSearch").load("<?php print caNavUrl($this->request, '', 'Search', 'objects', null, array('dontURLEncodeParameters' => false)); ?>", { search: s }, function() {
												jQuery("#collectionSearch").jscroll({
													autoTrigger: true,
													loadingHtml: "<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>",
													padding: 20,
													nextSelector: "a.jscroll-next"
												});
											});
										});
									}
								});
								return false;
							});
						</script>
<?php
				}
?>
						<div class='clearfix'></div>					
					<div id="collectionHierarchy"><?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?></div>
					<script>
						$(document).ready(function(){
							$('#collectionHierarchy').load("<?php print caNavUrl($this->request, '', 'Collections', 'collectionHierarchy', array('collection_id' => $t_item->get('collection_id'))); ?>"); 
						})
					</script>
<?php
			}								
?>	
				</div>
			</div>
			<div class="row">
				<div class='col-sm-12'>
					{{{<ifdef code="ca_collections.langmaterial"><div class="unit"><label>Languages and Scripts of Collection Materials</label>^ca_collections.langmaterial%delimiter=,_</div></ifdef>}}}
					{{{<ifdef code="ca_collections.accessrestrict"><div class="unit"><label>Restrictions</label>^ca_collections.accessrestrict%delimiter=,_</div></ifdef>}}}
					
					{{{<ifdef code="ca_collections.physaccessrestrict"><div class="unit"><label>Physical Access</label>^ca_collections.physaccessrestrict%delimiter=,_</div></ifdef>}}}

					{{{<ifdef code="ca_collections.preferCite"><div class="unit"><label>Preferred Citation</label>^ca_collections.preferCite%delimiter=,_</div></ifdef>}}}
					
					{{{<ifcount code="ca_storage_locations" min="1"><div class="unit"><label>Location</label>
						<unit relativeTo="ca_storage_locations" delimiter="<br/>">^ca_storage_locations.hierarchy.preferred_labels%delimiter=_➔_</unit>
					</div></ifcount>}}}
					
<?php
					# --- entity name should be the loc name when Entity Source is LCNAF - LcshNames - /\[[^)]+\]/
					print preg_replace('/\[[^)]+\]/', '', $t_item->getWithTemplate('<ifcount code="ca_entities" min="1" restrictToTypes="ind"><div class="unit"><ifcount code="ca_entities" min="1" max="1" restrictToTypes="ind"><label>Related person</label></ifcount><ifcount code="ca_entities" min="2" restrictToTypes="ind"><label>Related people</label></ifcount><unit relativeTo="ca_entities" restrictToTypes="ind" delimiter="<br/>"><if rule="^ca_entities.entity_source =~ /LCNAF/">^ca_entities.LcshNames<ifnotdef code="ca_entities.LcshNames">^ca_entities.preferred_labels</ifnofdef></if><if rule="^ca_entities.entity_source !~ /LCNAF/">^ca_entities.preferred_labels</if> (^relationship_typename)</unit></div></ifcount>'));
					print preg_replace('/\[[^)]+\]/', '', $t_item->getWithTemplate('<ifcount code="ca_entities" min="1" restrictToTypes="org"><div class="unit"><ifcount code="ca_entities" min="1" max="1" restrictToTypes="org"><label>Related organization</label></ifcount><ifcount code="ca_entities" min="2" restrictToTypes="org"><label>Related organizations</label></ifcount><unit relativeTo="ca_entities" restrictToTypes="org" delimiter="<br/>"><if rule="^ca_entities.entity_source =~ /LCNAF/">^ca_entities.LcshNames<ifnotdef code="ca_entities.LcshNames">^ca_entities.preferred_labels</ifnofdef></if><if rule="^ca_entities.entity_source !~ /LCNAF/">^ca_entities.preferred_labels</if> (^relationship_typename)</unit></div></ifcount>'));
					print preg_replace('/\[[^)]+\]/', '', $t_item->getWithTemplate('<ifcount code="ca_entities" min="1" restrictToTypes="fam"><div class="unit"><ifcount code="ca_entities" min="1" max="1" restrictToTypes="fam"><label>Related family</label></ifcount><ifcount code="ca_entities" min="2" restrictToTypes="fam"><label>Related families</label></ifcount><unit relativeTo="ca_entities" restrictToTypes="fam" delimiter="<br/>"><if rule="^ca_entities.entity_source =~ /LCNAF/">^ca_entities.LcshNames<ifnotdef code="ca_entities.LcshNames">^ca_entities.preferred_labels</ifnofdef></if><if rule="^ca_entities.entity_source !~ /LCNAF/">^ca_entities.preferred_labels</if> (^relationship_typename)</unit></div></ifcount>'));
					
					
					$va_LcshNames = $t_item->get("ca_collections.LcshNames", array("returnAsArray" => true));
					$va_LcshNames_processed = array();
					if(is_array($va_LcshNames) && sizeof($va_LcshNames)){
						foreach($va_LcshNames as $vs_LcshNames){
							if($vs_LcshNames && (strpos($vs_LcshNames, " [") !== false)){
								$va_LcshNames_processed[] = mb_substr($vs_LcshNames, 0, strpos($vs_LcshNames, " ["));
							}else{
								$va_LcshNames_processed[] = $vs_LcshNames;
							}
						}
						$vs_LcshNames = join("<br/>", $va_LcshNames_processed);
					}
					if($vs_LcshNames){
						print "<div class='unit'><label>Library of Congress Names</label>".$vs_LcshNames."</div>";	
					}

					$va_LcshSubjects = $t_item->get("ca_collections.LcshSubjects", array("returnAsArray" => true));
					$va_LcshSubjects_processed = array();
					if(is_array($va_LcshSubjects) && sizeof($va_LcshSubjects)){
						foreach($va_LcshSubjects as $vs_LcshSubjects){
							if($vs_LcshSubjects && (strpos($vs_LcshSubjects, " [") !== false)){
								$va_LcshSubjects_processed[] = mb_substr($vs_LcshSubjects, 0, strpos($vs_LcshSubjects, " ["));
							}else{
								$va_LcshSubjects_processed[] = $vs_LcshSubjects;
							}
						}
						$vs_LcshSubjects = join("<br/>", $va_LcshSubjects_processed);
					}
					if($vs_LcshSubjects){
						print "<div class='unit'><label>Subjects</label>".$vs_LcshSubjects."</div>";	
					}

					$va_LcshGenre = $t_item->get("ca_collections.LcshGenre", array("returnAsArray" => true));
					$va_LcshGenre_processed = array();
					if(is_array($va_LcshGenre) && sizeof($va_LcshGenre)){
						foreach($va_LcshGenre as $vs_LcshGenre){
							if($vs_LcshGenre && (strpos($vs_LcshGenre, " [") !== false)){
								$va_LcshGenre_processed[] = mb_substr($vs_LcshGenre, 0, strpos($vs_LcshGenre, " ["));
							}else{
								$va_LcshGenre_processed[] = $vs_LcshGenre;
							}
						}
						$vs_LcshGenre = join("<br/>", $va_LcshGenre_processed);
					}
					$va_aat = $t_item->get("ca_collections.aat", array("returnAsArray" => true));
					$va_aat_processed = array();
					if(is_array($va_aat) && sizeof($va_aat)){
						foreach($va_aat as $vs_aat){
							if($vs_aat && (strpos($vs_aat, " [") !== false)){
								$va_aat_processed[] = mb_substr($vs_aat, 0, strpos($vs_aat, " ["));
							}else{
								$va_aat_processed[] = $vs_aat;
							}
						}
						$vs_aat = join("<br/>", $va_aat_processed);
					}
					if($vs_LcshGenre || $vs_aat){
						print "<div class='unit'><label>Genres</label>";
						if($vs_LcshGenre){
							print $vs_LcshGenre;
						}
						if($vs_LcshGenre && $vs_aat){
							print "<br/>";
						}
						if($vs_aat){
							print $vs_aat;
						}
						print "</div>";	
					}
?>
					
					{{{<ifcount code="ca_places" min="1"><div class="unit"><ifcount code="ca_places" min="1" max="1"><label>Related place</label></ifcount><ifcount code="ca_places" min="2"><label>Related places</label></ifcount><unit relativeTo="ca_places" delimiter="<br/>"><unit relativeTo="ca_places.hierarchy" delimiter=" &gt; "><l>^ca_places.preferred_labels</l></unit></unit></div></ifcount>}}}
					
<?php
					if($vs_map = $this->getVar("map")){
						print "<div class='unit'>".$vs_map."</div>";
					}
?>					
					{{{<ifdef code="ca_collections.relation"><div class="unit"><label>Related Collections</label>^ca_collections.relation%delimiter=,_</div></ifdef>}}}

					
					
<?php
				# Comment and Share Tools
				if ($vn_comments_enabled | $vn_share_enabled) {
						
					print '<div id="detailTools">';
					if ($vn_comments_enabled) {
?>				
						<div class="detailTool"><a href='#' onclick='jQuery("#detailComments").slideToggle(); return false;'><span class="glyphicon glyphicon-comment"></span>Comments (<?php print sizeof($va_comments); ?>)</a></div><!-- end detailTool -->
						<div id='detailComments'><?php print $this->getVar("itemComments");?></div><!-- end itemComments -->
<?php				
					}
					if ($vn_share_enabled) {
						print '<div class="detailTool"><span class="glyphicon glyphicon-share-alt"></span>'.$this->getVar("shareLink").'</div><!-- end detailTool -->';
					}
					print '</div><!-- end detailTools -->';
				}				
?>

				</div>
				
			</div>
{{{<ifcount code="ca_objects" min="1">
			<div class="row">
				<div id="browseResultsContainer">
					<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>
				</div><!-- end browseResultsContainer -->
			</div><!-- end row -->
			<script type="text/javascript">
				jQuery(document).ready(function() {
					jQuery("#browseResultsContainer").load("<?php print caNavUrl($this->request, '', 'Search', 'objects', array('search' => 'collection_id:^ca_collections.collection_id'), array('dontURLEncodeParameters' => true)); ?>", function() {
						jQuery('#browseResultsContainer').jscroll({
							autoTrigger: true,
							loadingHtml: '<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>',
							padding: 20,
							nextSelector: 'a.jscroll-next'
						});
					});
					
					
				});
			</script>
</ifcount>}}}
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
		  maxHeight: 200
		});
	});
</script>
