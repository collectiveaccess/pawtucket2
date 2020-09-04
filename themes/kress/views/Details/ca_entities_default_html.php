<?php
	$va_access_values = caGetUserAccessValues($this->request);
	$t_item = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");	
	$vn_pdf_enabled = 		$this->getVar("pdfEnabled");


	# --- back button for related acquisitions-ca_movements, distributions-ca_loans, archival items - ca_occurrences, ca_objects
	$o_context = new ResultContext($this->request, 'ca_movements', 'detailrelated', 'entities');
	$o_context->setResultList($t_item->get("ca_movements.movement_id", array("returnAsArray" => true, "checkAccess" => $va_access_values)));
	$o_context->setAsLastFind();
	$o_context->saveContext();
	
	$o_context = new ResultContext($this->request, 'ca_loans', 'detailrelated', 'entities');
	$o_context->setResultList($t_item->get("ca_loans.loan_id", array("returnAsArray" => true, "checkAccess" => $va_access_values)));
	$o_context->setAsLastFind();
	$o_context->saveContext();
	
	$o_context = new ResultContext($this->request, 'ca_occurrences', 'detailrelated', 'entities');
	$o_context->setResultList($t_item->get("ca_occurrences.occurrence_id", array("returnAsArray" => true, "checkAccess" => $va_access_values)));
	$o_context->setAsLastFind();
	$o_context->saveContext();
	
	# --- object done when browse loaded with ajax
	#$o_context = new ResultContext($this->request, 'ca_objects', 'detailrelated', 'entities');
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
				<div class='col-small-12 col-md-10'>
					<H1>{{{^ca_entities.preferred_labels.displayname}}}</H1>
					<div class="row">
						{{{<ifdef code="ca_entities.nonpreferred_labels.displayname|ca_entities.Name_DateExpression|ca_entities.Name_InstitutionStatus|ca_entities.Name_Nationality|ca_entities.Name_BirthDateFilter|ca_entities.Name_DeathDateFilter|ca_entities.Name_InstitutionWeb|ca_entities.Name_Location">
							<div class='col-sm-12 col-md-8'>
								<div class="grayBg">
									<ifdef code="ca_entities.idno"><div class="unit"><label data-toggle="popover" title="Identifier" data-content="Unique system-generated record identifier">Identifier</label>^ca_entities.idno</div></ifdef>
								<?php
									if($vn_list_item_id = $t_item->get("ca_entities.Name_KressInstitutionType")){
										$t_list_item = new ca_list_items($vn_list_item_id);
										print '<div class="unit"><label>Institution Type</label>'.$t_list_item->get("ca_list_item_labels.name_singular").'</div>';
									}
								?>
									
									<ifdef code="ca_entities.nonpreferred_labels.displayname"><div class="unit"><label>Alternate Names</label>^ca_entities.nonpreferred_labels.displayname</div></ifdef>
									<ifdef code="ca_entities.Name_InstitutionStatus"><div class="unit"><label>Status</label>^ca_entities.Name_InstitutionStatus</div></ifdef>
									<ifdef code="ca_entities.Name_Nationality"><div class="unit"><label>Nationality</label>^ca_entities.Name_Nationality</div></ifdef>
									<ifdef code="ca_entities.Name_BirthDateFilter"><div class="unit"><label>Birth Date</label>^ca_entities.Name_BirthDateFilter</div></ifdef>
									<ifdef code="ca_entities.Name_DeathDateFilter"><div class="unit"><label>Death Date</label>^ca_entities.Name_DeathDateFilter</div></ifdef>
									<ifdef code="ca_entities.Name_InstitutionWeb"><div class="unit"><label>Web Address</label><a href="^ca_entities.Name_InstitutionWeb" target="_blank">^ca_entities.Name_InstitutionWeb</a> <i class="fa fa-external-link" aria-hidden="true"></i></div></ifdef>
									<ifdef code="ca_entities.Name_Location"><div class="unit"><label>Location</label>^ca_entities.Name_Location</div></ifdef>
								</div>					
							</div>
						</ifdef>}}}
						{{{<ifdef code="ca_entities.Name_ULANURI|ca_entities.Name_VIAFURI|ca_entities.Name_LCCNURI|ca_entities.NAME_wikipediaURL">
							<div class='col-sm-12 col-md-4'>
								<label class="noTopMargin">External Links</label>					
								<ifdef code="ca_entities.Name_ULANURI"><a href="^ca_entities.Name_ULANURI" target="_blank"><div class="grayBg paddingTop"><div class="unit" data-toggle="popover" title="ULAN" data-content="Union List of Artist Names record">ULAN <i class="fa fa-external-link" aria-hidden="true"></i></div></div></a></ifdef>
								<?php
									if($vs_Name_VIAFURI = $t_item->get("ca_entities.Name_VIAFURI")){
										$va_Name_VIAFURI = explode(";", $vs_Name_VIAFURI);
										foreach($va_Name_VIAFURI as $vs_Name_VIAFURI_part){
											$vs_Name_VIAFURI_part = trim($vs_Name_VIAFURI_part);
											print '<a href="'.$vs_Name_VIAFURI_part	.'" target="_blank"><div class="grayBg paddingTop"><div class="unit" data-toggle="popover" title="VIAF" data-content="Virtual International Authority File record">VIAF <i class="fa fa-external-link" aria-hidden="true"></i></div></div></a>';
										}
									}
								?>
								<ifdef code="ca_entities.Name_LCCNURI"><a href="^ca_entities.Name_LCCNURI" target="_blank"><div class="grayBg paddingTop"><div class="unit" data-toggle="popover" title="LCCN" data-content="Library of Congress Name Authority File record">LCCN <i class="fa fa-external-link" aria-hidden="true"></i></div></div></a></ifdef>
								<ifdef code="ca_entities.NAME_wikipediaURL"><a href="^ca_entities.NAME_wikipediaURL" target="_blank"><div class="grayBg paddingTop"><div class="unit" data-toggle="popover" title="Wikipedia" data-content="Wikipedia article">Wikipedia <i class="fa fa-external-link" aria-hidden="true"></i></div></div></a></ifdef>
							</div>
						</ifdef>}}}
					</div>
				</div><!-- end col -->
				<div class='col-sm-12 col-md-2'>
					<div id="detailTools">
<?php
						if ($vn_pdf_enabled) {
							print "<div class='detailTool'><span class='glyphicon glyphicon-file' aria-label='"._t("Summary")."'></span>".caDetailLink($this->request, "PDF Summary", "", "ca_entities",  $t_item->get("ca_entities.entity_id"), array('view' => 'pdf', 'export_format' => '_pdf_ca_entities_summary'))."</div>";
						}
						print "<div class='detailTool'><span class='glyphicon glyphicon-link' aria-label='"._t("Record Link")."'></span><a href='#' onClick='$(\"#permalink\").toggle(); return false;' title='Copy link to share or save record'>Record Link</a><br/><textarea name='permalink' id='permalink' class='form-control input-sm' style='display:none;'>".$this->request->config->get("site_host").caDetailUrl($this->request, 'ca_entities', $t_item->get("ca_entities.entity_id"))."</textarea></div>";					
?>
					</div>				
				</div>
			</div>
			
					
				{{{<ifcount code="ca_movements" min="1">
					<div class="row">
						<div class='col-sm-12'>
							<HR/><label>^ca_movements._count Acquisition<ifcount code="ca_movements" min="2">s</ifcount></label>
						</div>
					</div>
					<div class="row">
						<unit relativeTo="ca_movements" delimiter=" " length="12" sort="ca_movements.Acquisition_DateFilter">
							<div class='col-sm-6 col-md-3'>
								<l><div class="grayBg paddingTop">
								<div class="unit">
									^ca_movements.preferred_labels
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
							<HR/><label>^ca_loans._count Distribution<ifcount code="ca_loans" min="2">s</ifcount></label>
						</div>
					</div>
					<div class="row">
						<unit relativeTo="ca_loans" delimiter=" " length="12" sort="ca_loans.Distribution_DateYearFilter"><div class='col-sm-6 col-md-3'><l><div class="grayBg paddingTop"><div class="unit">^ca_loans.preferred_labels</div></div></l></div></unit>
					</div>
					<if rule="^ca_loans._count > 12">
						<div class="row">
							<div class="col-sm-12 text-center"><?php print caNavLink($this->request, "View All", "btn btn-default", "", "Browse", "distributions", array("facet" => "institution_entity_facet", "id" => $t_item->get("ca_entities.entity_id"))); ?></div>
						</div>
					</if>
				</ifcount>}}}
				
		{{{<if rule="^ca_entities.Name_Type !~ /Institution/"><ifcount code="ca_occurrences" min="1" restrictToTypes="documentation">
			<hr/><label>^ca_occurrences._count Archival Item<ifcount code="ca_occurrences" min="2">s</ifcount></label>						
			<div class="row">
				<unit relativeTo="ca_occurrences" restrictToTypes="documentation" length="9" delimiter=" " sort="ca_occurrences.Doc_DateFilter">
					<div class="col-sm-4">
						<l><div class="grayBg paddingTop">
							<div class="unit">
								<div class="row">
									<div class="col-xs-4">
										^ca_occurrences.media.media_media.iconlarge
									</div>
									<div class="col-xs-8">
										^ca_occurrences.preferred_labels
									</div>
								</div>
							</div>
						</div></l>
					</div>
				</unit>
			</div>			
			<if rule="^ca_occurrences._count > 9" restrictToTypes="documentation">
				<div class="row">
					<div class="col-sm-12 text-center"><?php print caNavLink($this->request, "View All", "btn btn-default", "", "Browse", "archival", array("facet" => "entity_facet", "id" => $t_item->get("ca_entities.entity_id"))); ?></div>
				</div>
			</if>
		</ifcount></if>}}}
			
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
					jQuery("#browseResultsDetailContainer").load("<?php print caNavUrl($this->request, '', 'Browse', 'objects', array('facet' => 'entity_facet', 'id' => '^ca_entities.entity_id', 'showFilterPanel' => 1, 'dontSetFind' => 1, 'detailType' => 'entities'), array('dontURLEncodeParameters' => true)); ?>", function() {
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
			placement: "auto top",
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
		
		$("#permalink").click(function(){
			$("#permalink").select();
			document.execCommand('copy');
		});

	});
</script>