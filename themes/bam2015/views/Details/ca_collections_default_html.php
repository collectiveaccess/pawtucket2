<?php
	$t_item = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$vn_id = $t_item->get('ca_collections.collection_id');
	$va_access_values = caGetUserAccessValues($this->request);
?>
<div class="row">
	<div class='col-xs-12 navTop'><!--- only shown at small screen size -->
		{{{previousLink}}}{{{resultsLink}}}{{{nextLink}}}
	</div><!-- end detailTop -->
	<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
		<div class="container">
			<div class="row">
				<div class='col-xs-1 col-sm-1 col-md-1 col-lg-1'>
					<div class="detailNavBgLeft">
						{{{previousLink}}}{{{resultsLink}}}
					</div><!-- end detailNavBgLeft -->
				</div><!-- end col -->			
				<div class='col-sm-10 col-md-10 col-lg-10'>
					<div class="detailHead">
<?php
					print "<div class='leader'>".$t_item->get('ca_collections.type_id', array('convertCodesToDisplayText' => true))."</div>";
					print "<h2>".$t_item->get('ca_collections.preferred_labels')."</h2>";
					
?>
					</div><!-- end detailHead -->
				</div><!-- end col -->
				<div class='col-xs-1 col-sm-1 col-md-1 col-lg-1'>
					<div class="detailNavBgRight">
						{{{nextLink}}}
					</div><!-- end detailNavBgLeft -->
				</div><!-- end col -->
			</div><!-- end row -->
			<div class="row">		
				<div class='col-md-12 col-md-12 col-lg-12'>
					<hr class="divide">	
<?php

					print caNavLink($this->request, 'Download Finding Aid', 'faDownload', 'Detail', 'collections', $vn_id.'/view/pdf/export_format/_pdf_ca_collections_summary');

					if ($vs_historical = $t_item->get('ca_collections.biogHist')) {
						print "<div class='unit'><span class='label'>Historical Note: </span>".$vs_historical."</div>";
					}
					if ($vs_scope = $t_item->get('ca_collections.scopeContent')) {
						print "<div class='unit'><span class='label'>Scope and Content Note: </span>".$vs_scope."</div>";
					}
					if ($va_events = $t_item->get('ca_occurrences.preferred_labels', array('returnAsLink' => true, 'restrictToTypes' => array('special_event', 'production'), 'delimiter' => ', '))) {
						print "<div class='unit'><span class='label'>Related Productions & Events: </span>".$va_events."</div>";
					}
					if ($va_collection_children = $t_item->get('ca_collections.children.collection_id', array('returnAsArray' => true, 'checkAccess' => $va_access_values))) {
						print "<div class='unit trimText'><span class='label collection'>Collection Contents </span>";
						foreach ($va_collection_children as $col_key => $vn_collection_id) {
							$t_collection_series = new ca_collections($vn_collection_id);
							if ($vn_series_link = $t_collection_series->get('ca_collections.preferred_labels', array('returnAsLink' => true, 'checkAccess' => $va_access_values))) {
								if ($t_collection_series->get('ca_collections.children.preferred_labels', array('returnAsLink' => true, 'checkAccess' => $va_access_values))) {
									print "<p style='margin-left:0px;'><a href='#' onclick='$(\"#series".$vn_collection_id."\").toggle(300);return false;'><span class='icon-arrow-down'></span> </a>".$vn_series_link."</p>";							
								} else {
									print "<p style='margin-left:0px;'>".$vn_series_link."</p>";							
								}
							}
							print "<div class='seriesWrapper' id='series".$vn_collection_id."' style='display:none;'>";
							if ($va_series_children = $t_collection_series->get('ca_collections.children.collection_id', array('returnWithStructure' => true, 'checkAccess' => $va_access_values))){		
								print "<div class='boxWrapper'>";
								foreach ($va_series_children as $ser_key => $vn_series_id) {
									$t_collection_box = new ca_collections($vn_series_id);
									print "<p style='margin-left:40px;'>".$t_collection_box->get('ca_collections.preferred_labels', array('returnAsLink' => true, 'checkAccess' => $va_access_values))."</p>";
								}
								if ($va_box_children = $t_collection_box->get('ca_collections.children.collection_id', array('returnWithStructure' => true, 'checkAccess' => $va_access_values))) {
									print "<div class='folderWrapper'>";
									foreach ($va_box_children as $box_key => $vn_box_id) {
										$t_collection_folder = new ca_collections($vn_box_id);
										print "<p style='margin-left:80px;'>".$t_collection_folder->get('ca_collections.preferred_labels', array('returnAsLink' => true, 'checkAccess' => $va_access_values))."</p>";
									}
									print "</div>";
								}
								print "</div>";
							}
							print "</div><!-- end series wrapper-->";
						}
						print "</div><!-- end unit -->";
					}										
?>				
					<!--<div id="detailTools">
						<div class="detailTool"><a href='#' onclick='jQuery("#detailComments").slideToggle(); return false;'><span class="glyphicon glyphicon-comment"></span>Comments (<?php print sizeof($va_comments); ?>)</a></div>
						<div id='detailComments'>{{{itemComments}}}</div>
						<div class="detailTool"><span class="glyphicon glyphicon-share-alt"></span>{{{shareLink}}}</div>
					</div>-->
					
				</div><!-- end col -->

			</div><!-- end row -->
{{{<ifcount code="ca_objects" min="2">
			<hr class="divide" style="margin-bottom:0px;"/>
			<div class="row">
				<div class="col-sm-12 col-md-12 col-lg-12">
					<div id="browseResultsContainer">
						<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>
					</div><!-- end browseResultsContainer -->
				</div><!-- end col -->
			</div><!-- end row -->
			<script type="text/javascript">
				jQuery(document).ready(function() {
					jQuery("#browseResultsContainer").load("<?php print caNavUrl($this->request, '', 'Search', 'objects', array('detailNav' => '1', 'search' => 'collection_id:^ca_collections.collection_id'), array('dontURLEncodeParameters' => true)); ?>", function() {
						jQuery('#browseResultsContainer').jscroll({
							autoTrigger: true,
							loadingHtml: '<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>',
							padding: 20,
							nextSelector: 'a.jscroll-next'
						});
					});
					
					
				});
			</script>
			<script type='text/javascript'>
				jQuery(document).ready(function() {
					$('.trimText').readmore({
					  speed: 75,
					  maxHeight: 135
					});		
				});
			</script>			
</ifcount>}}}
		</div><!-- end container -->
	</div><!-- end col -->
</div><!-- end row -->
