<?php
	$t_item = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");	
	$vn_pdf_enabled = 		$this->getVar("pdfEnabled");
	AssetLoadManager::register('mirador');

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
				<div class='col-sm-12 col-md-5'>
<?php
					// 
					// Uses new ".value_id" suffix to get value_ids for all repeats of ca_occurrences.media.media_media.value_id
					//
					if(is_array($media_value_ids = $t_item->get("ca_occurrences.media.media_media.value_id", ["returnAsArray" => true]))) {
						foreach($media_value_ids as $value_id) {
							print caGetMediaViewerHTML($this->request, "attribute:".$value_id, $t_item, array("inline" => true, "display" => "detail", "context" => "archival"));
						}
					}
					
					//
					// This is updated to use the new "includeValueIDs" option and works now as well
					//
					// $va_media = $t_item->get("ca_occurrences.media.media_media", ["returnWithStructure" => true, 'includeValueIDs' => true]);
// 					if(is_array($va_media) && sizeof($va_media)){
// 						$va_media = array_pop($va_media);
// 						foreach($va_media as $vn_attribute_id => $va_media){
// 							print caGetMediaViewerHTML($this->request, "attribute:".$va_media['media_media_value_id'], $t_item, array("inline" => true, "display" => "detail", "context" => "acquisitions"));
// 						}
// 					}
?>

				</div><!-- end col -->
				<div class='col-sm-12 col-md-5'>
					<H2>{{{^ca_occurrences.Doc_type<ifdef code="ca_occurrences.idno">: ^ca_occurrences.idno</ifdef>}}}</H2>
					<H1>{{{^ca_occurrences.preferred_labels.name}}}</H1>
					<div class="grayBg">
						{{{<ifcount code="ca_entities" min="1"><div class="unit"><label data-toggle="popover" title="Creator" data-content="Creator">Creator<ifcount code="ca_entities" min="2">s</ifcount></label><unit relativeTo="ca_entities" delimiter=", "><l>^ca_entities.preferred_labels.displayname</l></div></unit></ifcount>}}}
						{{{<ifdef code="ca_occurrences.Doc_Date"><div class="unit"><label data-toggle="popover" title="Date" data-content="Date description">Date</label>^ca_occurrences.Doc_Date</div></ifdef>}}}
						{{{<ifdef code="ca_occurrences.Doc_Source"><div class="unit"><label data-toggle="popover" title="Citation" data-content="Citation">Citation</label>^ca_occurrences.Doc_Source</div></ifdef>}}}
					</div>
					{{{<ifdef code="ca_occurrences.Doc_Note"><div class="unit"><label data-toggle="popover" title="Note" data-content="Note">Note</label><span class="trimText">^ca_occurrences.Doc_Note</span></div></ifdef>}}}
					{{{<ifdef code="ca_occurrences.Doc_Photographer"><div class="unit"><label>Photographer</label>^ca_occurrences.Doc_Photographer</div></ifdef>}}}
					{{{<ifcount code="ca_objects.related" min="1" max="3">
							<br/>
							<ifcount code="ca_objects.related" min="1" max="1">
								<label data-toggle="popover" title="Related Art Object" data-content="Related Art Object">Related Art Object</label>
							</ifcount>
							<ifcount code="ca_objects.related" min="2">
								<label data-toggle="popover" title="Related Art Objects" data-content="Related Art Objects">Related Art Objects</label>
							</ifcount>
							<unit relativeTo="ca_objects.related" delimiter=" ">
									<l><div class="grayBg paddingTop">
										<div class="unit">
											<div class="row">
												<ifdef code="ca_object_representations.media.small">
													<div class="col-xs-4">
														^ca_object_representations.media.small
													</div>
													<div class="col-xs-8">
														^ca_objects.preferred_labels.name
													</div>
												</ifdef>
												<ifnotdef code="ca_object_representations.media.small">
													<div class="col-xs-12">
														^ca_objects.preferred_labels.name
													</div>
												</ifnotdef>
											</div>
										</div>
									</div></l>
							</unit>
					</ifcount>}}}					
				</div><!-- end col -->
				<div class='col-sm-12 col-md-2'>
					<div id="detailTools">
	<?php
						if($vs_download_link = $t_item->get("ca_occurrences.media.media_media.original.url")){
							print "<div class='detailTool'><span class='glyphicon glyphicon-download' aria-label='"._t("Download Media")."'></span><a href='".$vs_download_link."'>Download Media</a></div>";
						}
						if ($vn_pdf_enabled) {
							print "<div class='detailTool'><span class='glyphicon glyphicon-file' aria-label='"._t("Summary")."'></span>".caDetailLink($this->request, "PDF Summary", "", "ca_occurrences",  $t_item->get("ca_occurrences.occurrence_id"), array('view' => 'pdf', 'export_format' => '_pdf_summary'))."</div>";
						}
						print "<div class='detailTool'><span class='glyphicon glyphicon-link' aria-label='"._t("Permalink")."'></span> <a href='#' onClick='$(\"#permalink\").toggle(); return false;'>Permalink</a><br/><textarea name='permalink' id='permalink' class='form-control input-sm' style='display:none;'>".$this->request->config->get("site_host").caNavUrl($this->request, '', 'Detail', 'archival/'.$t_item->get("occurrence_id"))."</textarea></div>";					

	?>
					</div>
				</div>
			</div><!-- end row -->
{{{<ifcount code="ca_objects" min="4">
			<div class="row">
				<div class="col-sm-12"><HR/>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<div id="browseResultsDetailContainer" class="results">
						<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>
					</div><!-- end browseResultsContainer -->
				</div>
			</div><!-- end row -->
			<script type="text/javascript">
				jQuery(document).ready(function() {
					jQuery("#browseResultsDetailContainer").load("<?php print caNavUrl($this->request, '', 'Browse', 'objects', array('facet' => 'archival_facet', 'id' => '^ca_occurrences.occurrence_id', 'showFilterPanel' => 1), array('dontURLEncodeParameters' => true)); ?>", function() {
						//jQuery('#browseResultsContainer').jscroll({
						//	autoTrigger: true,
						//	loadingHtml: '<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>',
						//	padding: 20,
						//	nextSelector: 'a.jscroll-next'
						//});
					});
					
					
				});
			</script>
</ifcount>}}}		</div><!-- end container -->
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
		var options = {
			placement: function () {
				if ($(window).width() > 992) {
					return "left";
				}else{
					return "auto top";
				}

			},
			trigger: "hover",
			html: "true"
		};

		$('[data-toggle="popover"]').each(function() {
			if($(this).attr('data-content')){
				$(this).popover(options).click(function(e) {
					$(this).popover('toggle');
				});
			}
		});
	});

</script>