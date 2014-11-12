<?php
	$t_item = $this->getVar("item");
	$va_comments = $this->getVar("comments");
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
				<div class='col-md-12 col-lg-12'>
					<H4>{{{^ca_entities.preferred_labels.displayname}}}</H4>
					<H6>{{{^ca_entities.type_id}}}</H6>
					{{{<ifdef code="ca_entities.biography"><HR></HR><p>^ca_entities.biography</p></ifdef>}}}
					<HR></HR>
				</div><!-- end col -->
			</div><!-- end row -->
			<div class="row">			
				<div class='col-md-6 col-lg-6'>
					{{{<ifcount code="ca_entities.regions" min="1"><H6>Applicable region(s):</H6><unit delimiter=", ">^ca_entities.regions</unit></ifcount>}}}
					{{{<ifcount code="ca_entities.language" min="1"><H6>Language(s):</H6><unit delimiter=", ">^ca_entities.language</unit></ifcount>}}}
<?php
				if($t_item->get("ca_entities.external_link")){
					$va_external_links = $t_item->get("ca_entities.external_link", array("returnAsArray" => true));
					print "<H6>Links:</H6>";
					$i = 0;
					foreach($va_external_links as $va_external_link){
						$vs_link_text = "";
						if($va_external_link["url_source"]){
							$vs_link_text = $va_external_link["url_source"];
						}else{
							$vs_link_text = (mb_strlen($va_external_link["url_entry"]) > 50) ? mb_substr($va_external_link["url_entry"], 0, 50)."..." : $va_external_link["url_entry"];
						}
						print "<a href='".$va_external_link["url_entry"]."' target='_blank'>".$vs_link_text."</a>";
						$i++;
						if($i < sizeof($va_external_links)){
							print "<br/>";
						}
					}
					
				}
?>	
					<div id="detailTools">
						<div class="detailTool"><a href='#' onclick='jQuery("#detailComments").slideToggle(); return false;'><span class="glyphicon glyphicon-comment"></span>Comments (<?php print sizeof($va_comments); ?>)</a></div><!-- end detailTool -->
						<div id='detailComments'>{{{itemComments}}}</div><!-- end itemComments -->
						<div class="detailTool"><span class="glyphicon glyphicon-share-alt"></span>{{{shareLink}}}</div><!-- end detailTool -->
					</div><!-- end detailTools -->
				</div><!-- end col -->
				<div class='col-md-6 col-lg-6'>
					{{{<ifcount code="ca_entities.related" restrictToTypes="org" min="1" max="1"><H6>Related organization</H6></ifcount>}}}
					{{{<ifcount code="ca_entities.related" restrictToTypes="org" min="2"><H6>Related organizations</H6></ifcount>}}}
					{{{<unit relativeTo="ca_entities.related" restrictToTypes="org" delimiter="<br/>"><l>^ca_entities.preferred_labels.displayname</l></unit>}}}
					
					{{{<ifcount code="ca_entities.related" restrictToTypes="ind" min="1" max="1"><H6>Related person</H6></ifcount>}}}
					{{{<ifcount code="ca_entities.related" restrictToTypes="ind" min="2"><H6>Related people</H6></ifcount>}}}
					{{{<unit relativeTo="ca_entities.related" restrictToTypes="ind" delimiter="<br/>"><l>^ca_entities.preferred_labels.displayname</l></unit>}}}
					
					{{{<ifcount code="ca_occurrences" min="1" max="1"><H6>Related competence</H6></ifcount>}}}
					{{{<ifcount code="ca_occurrences" min="2"><H6>Related competences</H6></ifcount>}}}
					{{{<unit relativeTo="ca_occurrences" delimiter="<br/>"><strong>^ca_occurrences.idno</strong> ^ca_occurrences.preferred_labels.name</unit>}}}
							
				</div><!-- end col -->
			</div><!-- end row -->
{{{<ifcount code="ca_objects" min="1">
			<div class="row">
				<div class="col-sm-12">
					<br/><H3 style="margin-bottom:0px;">Contributed and Curated Resources</H3>
				</div>
			</div>
			<div class="row">
				<div id="browseResultsContainer">
					<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>
				</div><!-- end browseResultsContainer -->
			</div><!-- end row -->
			<script type="text/javascript">
				jQuery(document).ready(function() {
					jQuery("#browseResultsContainer").load("<?php print caNavUrl($this->request, '', 'Search', 'resources', array('search' => 'entity_id:^ca_entities.entity_id'), array('dontURLEncodeParameters' => true)); ?>", function() {
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
			<br/><br/>
		</div><!-- end container -->
	</div><!-- end col -->
	<div class='navLeftRight col-xs-1 col-sm-1 col-md-1 col-lg-1'>
		<div class="detailNavBgRight">
			{{{nextLink}}}
		</div><!-- end detailNavBgLeft -->
	</div><!-- end col -->
</div><!-- end row -->