<?php
	# --- distributions
	
	$va_access_values = caGetUserAccessValues($this->request);
	$t_item = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");
	$vn_pdf_enabled = 		$this->getVar("pdfEnabled");
	
	# --- back button for related acquisitions-ca_movements, ca_objects, entities
	$o_context = new ResultContext($this->request, 'ca_movements', 'detailrelated', 'distributions');
	$o_context->setResultList($t_item->get("ca_movements.movement_id", array("returnAsArray" => true, "checkAccess" => $va_access_values)));
	$o_context->setAsLastFind();
	$o_context->saveContext();
	
	$o_context = new ResultContext($this->request, 'ca_entities', 'detailrelated', 'distributions');
	$o_context->setResultList($t_item->get("ca_entities.entity_id", array("returnAsArray" => true, "checkAccess" => $va_access_values)));
	$o_context->setAsLastFind();
	$o_context->saveContext();
	
	# --- object done when browse loaded with ajax
	#$o_context = new ResultContext($this->request, 'ca_objects', 'detailrelated', 'distributions');
	#$o_context->setResultList($t_item->get("ca_objects.object_id", array("returnAsArray" => true, "checkAccess" => $va_access_values)));
	#$o_context->setAsLastFind();
	#$o_context->saveContext();
	
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
				<div class='col-sm-12 col-md-10'>
					<div class="row">
						<div class='col-md-12 col-lg-12'>
							<H1>{{{^ca_loans.preferred_labels.name}}}</H1>
						</div><!-- end col -->
					</div><!-- end row -->
					<div class="grayBg">
						{{{<ifdef code="ca_loans.idno" min="1"><div class="unit"><label data-toggle="popover" title="Identifier" data-content="Identifier">Identifier</label>^ca_loans.idno</div></ifdef>}}}
						{{{<ifcount code="ca_entities" min="1"><div class="unit"><label data-toggle="popover" title="Institution" data-content="Institution">Institution</label><unit relativeTo="ca_entities" delimiter="<br/>"><l>^ca_entities.preferred_labels.displayname</l></unit></div></ifcount>}}}
						<div class="row">							
							{{{<ifdef code="ca_loans.Distribution_OfferDate|ca_loans.Distribution_OfferDocSource"><div class='col-sm-6'>
								<ifdef code="ca_loans.Distribution_OfferDate"><div class="unit"><label data-toggle="popover" title="Offer Date" data-content="Offer Date">Offer Date</label>^ca_loans.Distribution_OfferDate</div></ifdef>
								<ifdef code="ca_loans.Distribution_OfferDocSource"><div class="unit"><label data-toggle="popover" title="Offer Documentation" data-content="Offer Documentation">Offer Documentation</label>^ca_loans.Distribution_OfferDocSource</div></ifdef>
							</div><!-- end col --></ifdef>}}}
							<div class='col-sm-6'>
								{{{<ifdef code="ca_loans.Distribution_AcceptDate"><div class="unit"><label data-toggle="popover" title="Acceptance Date" data-content="Acceptance Date">Acceptance Date</label>^ca_loans.Distribution_AcceptDate</div></ifdef>}}}
								{{{<ifdef code="ca_loans.Distribution_AcceptDocSource"><div class="unit"><label data-toggle="popover" title="Acceptance Documentation" data-content="Acceptance Documentation">Acceptance Documentation</label>^ca_loans.Distribution_AcceptDocSource</div></ifdef>}}}
								{{{<ifdef code="ca_loans.Distribution_Note">
									<div class='unit'><label data-toggle="popover" title="Note" data-content="Note">Note</label>
										<span class="trimText">^ca_loans.Distribution_Note</span>
									</div>
								</ifdef>}}}	
				
							</div><!-- end col -->
						</div><!-- end row -->
					</div>
				</div>
				<div class='col-sm-12 col-md-2'>
					<div id="detailTools">
<?php
						if($vs_download_link = $t_item->get("ca_movements.media.media_media.original.url")){
							print "<div class='detailTool'><span class='glyphicon glyphicon-download' aria-label='"._t("Download Media")."'></span><a href='".$vs_download_link."'>Download Media</a></div>";
						}
						if ($vn_pdf_enabled) {
							print "<div class='detailTool'><span class='glyphicon glyphicon-file' aria-label='"._t("Summary")."'></span>".caDetailLink($this->request, "PDF Summary", "", "ca_loans",  $t_item->get("ca_loans.loan_id"), array('view' => 'pdf', 'export_format' => '_pdf_ca_loans_summary'))."</div>";
						}
						print "<div class='detailTool'><span class='glyphicon glyphicon-link' aria-label='"._t("Permalink")."'></span> <a href='#' onClick='$(\"#permalink\").toggle(); return false;'>Permalink</a><br/><textarea name='permalink' id='permalink' class='form-control input-sm' style='display:none;'>".$this->request->config->get("site_host").caDetailUrl($this->request, 'ca_loans', $t_item->get("ca_loans.loan_id"))."</textarea></div>";					
?>
					</div>				
				</div>
			</div>

{{{<ifcount code="ca_objects" min="1">
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
					jQuery("#browseResultsDetailContainer").load("<?php print caNavUrl($this->request, '', 'Browse', 'objects', array('facet' => 'loan_facet', 'id' => '^ca_loans.loan_id', 'showFilterPanel' => 1, 'dontSetFind' => 1, 'detailType' => 'distributions'), array('dontURLEncodeParameters' => true)); ?>", function() {
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