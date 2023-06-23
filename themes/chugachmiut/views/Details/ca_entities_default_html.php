<?php
/* ----------------------------------------------------------------------
 * themes/default/views/bundles/ca_entities_default_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013-2022 Whirl-i-Gig
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
 
	$t_item = $this->getVar("item");
	$va_comments = $this->getVar("comments");
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
		<div class="container">
			<div class="row">
				<div class='col-md-12 col-lg-12'>
					<H1>{{{^ca_entities.preferred_labels.displayname}}}</H1>
					<H2>{{{^ca_entities.type_id}}}{{{<ifdef code="ca_entities.idno">, ^ca_entities.idno</ifdef>}}}</H2>
					<hr/>
				</div><!-- end col -->
			</div><!-- end row -->
			<div class="row">			
<?php
			if($vs_rep = trim($this->getVar("representationViewer"))){
				print "<div class='col-md-6 col-lg-6'>".$vs_rep."</div>\n";
				print "<div class='col-md-6 col-lg-6'>";
			}else{
				print "<div class='col-md-6 col-md-offset-3'>";
			}
?>
				{{{<ifdef code="ca_entities.quote"><div class="unit entityQuote">&ldquo;^ca_entities.quote&rdquo;</div></ifdef>}}}
				</div>
			</div>
			<div class="row">
				<div class='col-sm-12'>
				{{{<ifdef code="ca_entities.bio_history_container.bio_history"><div class="unit"><label>Biography</label>^ca_entities.bio_history_container.bio_history</div></ifdef>}}}

				{{{<ifdef code="ca_entities.nonpreferred_labels"><div class="unit"><label>Alternate Names</label><unit relativeTo="ca_entities.nonpreferred_labels" delimiter="<br/>">^ca_entities.nonpreferred_labels.displayname</unit></div></ifdef>}}}

				{{{<ifdef code="ca_entities.vital_date_ind_container.vital_date_ind">
					<div class="unit">
						<label>Vital Dates</label>
						<unit relativeTo="ca_entities.vital_date_ind_container" delimiter="<br/>">
							^ca_entities.vital_date_ind_container.vital_date_ind<ifdef code="ca_entities.vital_date_ind_container.vital_date_ind_type">, ^ca_entities.vital_date_ind_container.vital_date_ind_type</ifdef><ifdef code="ca_entities.vital_date_ind_container.vital_date_ind_loc">, ^ca_entities.vital_date_ind_container.vital_date_ind_loc</ifdef>
						</unit>
					</div>
				</ifdef>}}}
				{{{<if rule="^ca_entities.deceased_container.deceased =~ /Yes/"><div class="unit"><label>Deceased</label></div></ifdef>}}}

				{{{<ifcount code="ca_entities" min="1" restrictToTypes="organization"><div class="unit"><label>Related Organizations</label>
							<unit relativeTo="ca_entities" delimiter="<br/>" restrictToTypes="organization"><l>^ca_entities.preferred_labels</l> (^relationship_typename)</unit>
						</div></ifcount>}}}
				{{{<ifcount code="ca_entities" min="1" restrictToTypes="individual"><div class="unit"><label>Related People</label>
							<unit relativeTo="ca_entities" delimiter="<br/>" restrictToTypes="individual"><l>^ca_entities.preferred_labels</l> (^relationship_typename)</unit>
						</div></ifcount>}}}
				{{{<ifcount code="ca_places" min="1" restrictToTypes="community"><div class="unit"><label>Related Communities</label>
								<unit relativeTo="ca_places" delimiter="<br/>" restrictToTypes="community"><l>^ca_places.preferred_labels</l> (^relationship_typename)</unit>
							</div></ifcount>}}}
				{{{<ifcount code="ca_places" min="1" excludeTypes="community"><div class="unit"><label>Related Places</label>
								<unit relativeTo="ca_places" delimiter="<br/>" excludeTypes="community"><l>^ca_places.preferred_labels</l> (^relationship_typename)</unit>
							</div></ifcount>}}}
						
<?php
				# Comment and Share Tools
				if ($vn_comments_enabled | $vn_share_enabled) {
						
					print '<div id="detailTools">';
					if ($vn_comments_enabled) {
?>				
						<div class="detailTool"><a href='#' onclick='jQuery("#detailComments").slideToggle(); return false;'><span class="glyphicon glyphicon-comment" aria-label="<?php print _t("Comments and tags"); ?>"></span>Comments (<?php print sizeof($va_comments); ?>)</a></div><!-- end detailTool -->
						<div id='detailComments'><?php print $this->getVar("itemComments");?></div><!-- end itemComments -->
<?php				
					}
					if ($vn_share_enabled) {
						print '<div class="detailTool"><span class="glyphicon glyphicon-share-alt" aria-label="'._t("Share").'"></span>'.$this->getVar("shareLink").'</div><!-- end detailTool -->';
					}
					print '</div><!-- end detailTools -->';
				}				
?>
					
				</div><!-- end col -->
			</div><!-- end row -->
			
{{{<ifcount code="ca_objects" min="1">
			<div class="row">
				<div class="col-sm-12">
					<H3>Heritage Items</H3>
				</div>
			</div>
			<div class="row">
				<div id="browseResultsContainer">
					<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>
				</div><!-- end browseResultsContainer -->
			</div><!-- end row -->
			<script type="text/javascript">
				jQuery(document).ready(function() {
					jQuery("#browseResultsContainer").load("<?php print caNavUrl($this->request, '', 'Search', 'objects', array('search' => 'entity_id:^ca_entities.entity_id', 'sort' => 'Media', 'direction' => 'desc'), array('dontURLEncodeParameters' => true)); ?>", function() {
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
		  maxHeight: 120
		});
	});
</script>
