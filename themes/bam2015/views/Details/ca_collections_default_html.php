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
					print "<div class='clearfix'></div>";					
					if ($vs_historical = $t_item->get('ca_collections.biogHist')) {
						print "<div class='unit'><span class='label'>Historical Note: </span>".$vs_historical."</div>";
					}
					if ($vs_scope = $t_item->get('ca_collections.scopeContent')) {
						print "<div class='unit'><span class='label'>Scope and Content Note: </span>".$vs_scope."</div>";
					}
					if ($va_extent = $t_item->getWithTemplate('<unit delimiter=", ">^ca_collections.extent.extent_value ^ca_collections.extent.extent_units</unit>')) {
						print "<div class='unit'><span class='label'>Extent: </span>".$va_extent."</div>";
					}					
					if ($va_events = $t_item->get('ca_occurrences.preferred_labels', array('returnAsLink' => true, 'restrictToTypes' => array('special_event', 'production'), 'delimiter' => ', '))) {
						print "<div class='unit'><span class='label'>Related Productions & Events: </span>".$va_events."</div>";
					}
?>
					<div class="collection-form"  >
						<div class="formOutline">
							<div class="form-group">
								<input type="text" id="searchfield" class="form-control" placeholder="Search within this collection" >
							</div>
							<button id="collectionSubmit" class="btn-search"><span class="icon-magnifier"></span></button>
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
									var s = escape("(ca_collections.hier_collection_id:<?php print $vn_id; ?>) AND " + searchstring.val());
									jQuery("#collectionSearch").load("<?php print caNavUrl($this->request, '', 'Search', 'collections', array('detailNav' => '0', 'openResultsInOverlay' => '0'), array('dontURLEncodeParameters' => false)); ?>", { search: s })
								});
							});
							$("#searchfield").keypress(function(e) {
								if(e.which == 13) {
								var searchstring = $('#searchfield');
								searchstring.focus();
									$("#collectionSearch").slideDown("200", function () {
										$('#collectionSearch').html("<?php print caGetThemeGraphic($this->request, 'indicator.gif');?> Loading");
										var s = escape("(ca_collections.hier_collection_id:<?php print $vn_id; ?>) AND " + searchstring.val());
										jQuery("#collectionSearch").load("<?php print caNavUrl($this->request, '', 'Search', 'collections', array('detailNav' => '0', 'openResultsInOverlay' => '0'), array('dontURLEncodeParameters' => false)); ?>", { search: s })
									});
								}
							});
							return false;
						});
					</script>
					<div class='clearfix'></div>					
					
<?php					
					if ($va_collection_children = $t_item->get('ca_collections.children.collection_id', array('returnAsArray' => true, 'checkAccess' => $va_access_values))) {
						print "<div class='unit row' style='margin-bottom:0px;'><div class='col-sm-12 col-md-12 col-lg-12'><hr class='divide' style='margin-bottom:0px; margin-top:3px;'></hr></div><div class='col-sm-4 col-md-4 col-lg-4'><div class='findingAidContainer'><div class='label collection'>Collection Contents </div>";
						foreach ($va_collection_children as $col_key => $vn_collection_id) {
							$t_collection_series = new ca_collections($vn_collection_id);
							$vs_collection_label = $t_collection_series->get('ca_collections.preferred_labels');
							if (($t_collection_series->get('ca_collections.type_id', array('convertCodesToDisplayText' => true))) == "Box") {
								$vs_icon = "<i class='fa fa-archive'></i>&nbsp;";
							} else {
								$vs_icon = null;
							}
							print "<div style='margin-left:0px;margin-top:5px;'><a href='#' class='openCollection openCollection".$vn_collection_id."'>".$vs_icon.$vs_collection_label."</a></div>";	
?>													
						<script>
							$(document).ready(function(){
								$('.openCollection<?php print $vn_collection_id;?>').click(function(){
									$('#collectionLoad').html("<?php print caGetThemeGraphic($this->request, 'indicator.gif');?> Loading");
									$('#collectionLoad').load("<?php print caNavUrl($this->request, '', 'About', 'collectionsubview', array('collection_id' => $vn_collection_id)); ?>");
									$('.openCollection').removeClass('active');
									$('.openCollection<?php print $vn_collection_id;?>').addClass('active');
									return false;
								}); 
							})
						</script>						
<?php								
						}
						print "</div><!-- end findingAidContainer --></div><!-- end col -->";
						print "<div id='collectionLoad' class='col-sm-8 col-md-8 col-lg-8'><i class='fa fa-arrow-left'></i> Click a Collection container to the left to see its contents.</div>";
						print "</div><div class='row'><div class='col-sm-12 col-md-12 col-lg-12'><hr class='divide' style='margin-top:0px;'></hr></div></div>";
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
{{{<ifcount code="ca_objects" min="1">
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
					jQuery("#browseResultsContainer").load("<?php print caNavUrl($this->request, '', 'Search', 'objects', array('detailNav' => '1', 'openResultsInOverlay' => '1', 'search' => 'collection_id:^ca_collections.collection_id'), array('dontURLEncodeParameters' => true)); ?>", function() {
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
