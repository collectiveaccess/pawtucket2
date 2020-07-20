<?php
	$t_item = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");	
	$vn_pdf_enabled = 		$this->getVar("pdfEnabled");
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
				<div class='col-small-12 col-md-10'>
					<H2>{{{^ca_entities.Name_Type<ifdef code="ca_entities.Name_KressInstitutionType"> - ^ca_entities.Name_KressInstitutionType</ifdef><ifdef code="ca_entities.idno">: ^ca_entities.idno</ifdef>}}}</H2>
					<H1>{{{^ca_entities.preferred_labels.displayname}}}</H1>
					<div class="row">
						{{{<ifdef code="ca_entities.nonpreferred_labels.displayname|ca_entities.Name_DateExpression|ca_entities.Name_InstitutionStatus|ca_entities.Name_Nationality|ca_entities.Name_BirthDate|ca_entities.Name_DeathDate|ca_entities.Name_InstitutionWeb|ca_entities.Name_Location">
							<div class='col-sm-12 col-md-8'>
								<div class="grayBg">
									<ifdef code="ca_entities.nonpreferred_labels.displayname"><div class="unit"><label data-toggle="popover" title="Alternate Names" data-content="Alternate Names">Alternate Names</label>^ca_entities.nonpreferred_labels.displayname</div></ifdef>
									<ifdef code="ca_entities.Name_DateExpression"><div class="unit"><label data-toggle="popover" title="Date" data-content="Date">Date</label>^ca_entities.Name_DateExpression</div></ifdef>
									<ifdef code="ca_entities.Name_InstitutionStatus"><div class="unit"><label data-toggle="popover" title="Status" data-content="Status">Status</label>^ca_entities.Name_InstitutionStatus</div></ifdef>
									<ifdef code="ca_entities.Name_Nationality"><div class="unit"><label data-toggle="popover" title="Nationality" data-content="Nationality">Nationality</label>^ca_entities.Name_Nationality</div></ifdef>
									<ifdef code="ca_entities.Name_BirthDate"><div class="unit"><label data-toggle="popover" title="Birth Date" data-content="Birth Date">Birth Date</label>^ca_entities.Name_BirthDate</div></ifdef>
									<ifdef code="ca_entities.Name_DeathDate"><div class="unit"><label data-toggle="popover" title="Death Date" data-content="Death Date">Death Date</label>^ca_entities.Name_DeathDate</div></ifdef>
									<ifdef code="ca_entities.Name_InstitutionWeb"><div class="unit"><label data-toggle="popover" title="Web Address" data-content="Web Address">Web Address</label>^ca_entities.Name_InstitutionWeb</div></ifdef>
									<ifdef code="ca_entities.Name_Location"><div class="unit"><label data-toggle="popover" title="Location" data-content="Location">Location</label>^ca_entities.Name_Location</div></ifdef>
								</div>					
							</div>
						</ifdef>}}}
						{{{<ifdef code="ca_entities.Name_ULANURI|ca_entities.Name_VIAFURI|ca_entities.Name_LCCNURI|ca_entities.NAME_wikipediaURL">
							<div class='col-sm-12 col-md-4'>
								<label class="noTopMargin" data-toggle="popover" title="External Links" data-content="External Links">External Links</label>					
								<ifdef code="ca_entities.Name_ULANURI"><a href="^ca_entities.Name_ULANURI" target="_blank"><div class="grayBg paddingTop"><div class="unit">ULAN <i class="fa fa-external-link" aria-hidden="true"></i></div></div></a></ifdef>
								<ifdef code="ca_entities.Name_VIAFURI"><a href="^ca_entities.Name_VIAFURI" target="_blank"><div class="grayBg paddingTop"><div class="unit">VIAF <i class="fa fa-external-link" aria-hidden="true"></i></div></div></a></ifdef>
								<ifdef code="ca_entities.Name_LCCNURI"><a href="^ca_entities.Name_LCCNURI" target="_blank"><div class="grayBg paddingTop"><div class="unit">LCCN <i class="fa fa-external-link" aria-hidden="true"></i></div></div></a></ifdef>
								<ifdef code="ca_entities.NAME_wikipediaURL"><a href="^ca_entities.NAME_wikipediaURL" target="_blank"><div class="grayBg paddingTop"><div class="unit">Wikipedia <i class="fa fa-external-link" aria-hidden="true"></i></div></div></a></ifdef>
							</div>
						</ifdef>}}}
					</div>
				</div><!-- end col -->
				<div class='col-sm-12 col-md-2'>
					<div id="detailTools">
<?php
						if ($vn_pdf_enabled) {
							print "<div class='detailTool'><span class='glyphicon glyphicon-file' aria-label='"._t("Summary")."'></span>".caDetailLink($this->request, "PDF Summary", "", "ca_entities",  $t_item->get("ca_entities.entity_id"), array('view' => 'pdf', 'export_format' => '_pdf_summary'))."</div>";
						}
						print "<div class='detailTool'><span class='glyphicon glyphicon-link' aria-label='"._t("Permalink")."'></span> <a href='#' onClick='$(\"#permalink\").toggle(); return false;'>Permalink</a><br/><textarea name='permalink' id='permalink' class='form-control input-sm' style='display:none;'>".$this->request->config->get("site_host").caDetailUrl($this->request, 'ca_entities', $t_item->get("ca_entities.entity_id"))."</textarea></div>";					
?>
					</div>				
				</div>
			</div>
			
					
				{{{<ifcount code="ca_movements" min="1">
					<div class="row">
						<div class='col-sm-12'>
							<HR/><label data-toggle="popover" title="Acquisitions" data-content="Acquisitions">^ca_movements._count Acquisition<ifcount code="ca_movements" min="2">s</ifcount></label>
						</div>
					</div>
					<div class="row">
						<unit relativeTo="ca_movements" delimiter=" " length="12">
							<div class='col-sm-6 col-md-3'>
								<l><div class="grayBg paddingTop">
								<div class="unit">
									^ca_movements.idno ^ca_movements.preferred_labels
								</div>
							</div></l></div>
						</unit>
					</div>
					<if rule="^ca_movements._count > 12">
						<div class="row">
							<div class="col-sm-12 text-center"><?php print caNavLink($this->request, "View All", "btn btn-default", "", "Browse", "acquisitions", array("facet" => "entity_facet", "id" => $t_item->get("ca_entities.entity_id"))); ?></div>
						</div>
					</if>
				</ifcount>}}}
				{{{<ifcount code="ca_loans" min="1">
					<div class="row">
						<div class='col-sm-12'>
							<HR/><label data-toggle="popover" title="Distributions" data-content="Distributions">^ca_loans._count Distribution<ifcount code="ca_loans" min="2">s</ifcount></label>
						</div>
					</div>
					<div class="row">
						<unit relativeTo="ca_loans" delimiter=" " length="12"><div class='col-sm-6 col-md-3'><l><div class="grayBg paddingTop"><div class="unit">^ca_loans.idno ^ca_loans.preferred_labels</div></div></l></div></unit>
					</div>
					<if rule="^ca_loans._count > 12">
						<div class="row">
							<div class="col-sm-12 text-center"><?php print caNavLink($this->request, "View All", "btn btn-default", "", "Browse", "distributions", array("facet" => "institution_entity_facet", "id" => $t_item->get("ca_entities.entity_id"))); ?></div>
						</div>
					</if>
				</ifcount>}}}
				
		{{{<ifcount code="ca_occurrences" min="1">
			<hr/><label data-toggle="popover" title="Archival Materials" data-content="Archival Materials">^ca_occurrences._count Archival Material<ifcount code="ca_occurrences" min="2">s</ifcount></label>						
			<div class="row">
				<unit relativeTo="ca_occurrences" length="9" delimiter=" ">
					<div class="col-sm-4">
						<l><div class="grayBg paddingTop">
							<div class="unit">
								<div class="row">
									<div class="col-xs-4">
										^ca_occurrences.media.media_media.iconlarge
									</div>
									<div class="col-xs-8">
										^ca_occurrences.idno ^ca_occurrences.preferred_labels
									</div>
								</div>
							</div>
						</div></l>
					</div>
				</unit>
			</div>			
			<if rule="^ca_occurrences._count > 9">
				<div class="row">
					<div class="col-sm-12 text-center"><?php print caNavLink($this->request, "View All", "btn btn-default", "", "Browse", "archival", array("facet" => "entity_facet", "id" => $t_item->get("ca_entities.entity_id"))); ?></div>
				</div>
			</if>
		</ifcount>}}}
			
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
					jQuery("#browseResultsDetailContainer").load("<?php print caNavUrl($this->request, '', 'Browse', 'objects', array('facet' => 'entity_facet', 'id' => '^ca_entities.entity_id', 'showFilterPanel' => 1), array('dontURLEncodeParameters' => true)); ?>", function() {
						//jQuery('#browseResultsContainer').jscroll({
						//	autoTrigger: true,
						//	loadingHtml: '<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>',
						//	padding: 20,
						//	nextSelector: 'a.jscroll-next'
						//});
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