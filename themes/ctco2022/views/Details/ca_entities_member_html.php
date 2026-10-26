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
	
	$vn_source_id = getSourceIdForEntity($this->request, $t_item->get("ca_entities.entity_id"));
	$vn_collection_source_id = getCollectionSourceIdForEntity($this->request, $t_item->get("ca_entities.entity_id"));
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
					<H1>{{{^ca_entities.preferred_labels}}}</H1>
					<!-- <H2>{{{^ca_entities.type_id}}}{{{<ifdef code="ca_entities.idno">, ^ca_entities.idno</ifdef>}}}</H2> -->
				</div><!-- end col -->
			</div><!-- end row -->

			<div class="row">			
				<div class='col-sm-6 col-md-6 col-lg-6'>
					{{{<ifdef code="ca_entities.life_dates"><div class='unit'><label>Life Dates</label>^ca_entities.life_dates</div></ifdef>}}}
					{{{<ifdef code="ca_entities.biography"><div class='unit'>^ca_entities.biography%convertLineBreaks=1</div></ifdef>}}}

					{{{<ifdef code="ca_entities.address">
						<div class="unit"><label>Address</label>
						<unit relativeTo="ca_entities.address" delimiter="<br/>">
							<ifdef code="ca_entities.address.address1">^ca_entities.address.address1 <br/></ifdef> 
							<ifdef code="ca_entities.address.address2">^ca_entities.address.address2 <br/></ifdef>
							<ifdef code="ca_entities.address.city|ca_entities.address.stateprovince|ca_entities.address.postalcode|ca_entities.address.country">^ca_entities.address.city<ifdef code="ca_entities.address.city,ca_entities.address.stateprovince">, </ifdef>^ca_entities.address.stateprovince ^ca_entities.address.postalcode ^ca_entities.address.country</ifdef>
						</unit></div>
					</ifdef>}}}

					{{{<ifdef code="ca_entities.email">
						<!-- <label>Email</label> -->
						<div class="unit">
						<unit relativeTo="ca_entities.email" delimiter="<br/>">
							<a href="mailto:^ca_entities.email">^ca_entities.email</a>
						</unit></div>
					</ifdef>}}}	
					
					{{{<ifdef code="ca_entities.website">
						<!-- <label>Website</label> -->
						<div class="unit"><unit relativeTo="ca_entities.website" delimiter="<br/>">
							<a href="^website" target="_blank">^website</a>
						</unit></div>
					</ifdef>}}}	


				</div><!-- end col -->

				<div class='col-sm-6 col-md-6 col-lg-6'>
					{{{representationViewer}}}
				</div><!-- end col -->
			</div><!-- end row -->

			<br/>
<?php
	if($vn_source_id){
?>
		<div class="row">
			<div class="col-sm-6"><H2>Objects</H2></div>
			<div class="col-sm-6 detailBrowseAll">
<?php
			print caNavLink($this->request, "Browse all Objects <span class='glyphicon glyphicon-new-window'></span>", "btn btn-default", "", "Browse", "objects", array("facet" => "source_facet", "id" => $vn_source_id)); 
?>

	</br></br>

<?php
			if($vn_collection_source_id){
				print " ".caNavLink($this->request, "View Archives <span class='glyphicon glyphicon-new-window'></span>", "btn btn-default", "", "Collections", "Collections", array("source_id" => $vn_collection_source_id));
			}
?>
		</div>
		</div>
		<div class="row">
				<div id="browseResultsContainer">
					<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>
				</div><!-- end browseResultsContainer -->
			</div><!-- end row -->
			<script type="text/javascript">
				jQuery(document).ready(function() {
					jQuery("#browseResultsContainer").load("<?php print caNavUrl($this->request, '', 'Search', 'objects', array('search' => 'ca_objects.source_id:'.$vn_source_id, 'view' => 'images'), array('dontURLEncodeParameters' => true)); ?>", function() {
						jQuery('#browseResultsContainer').jscroll({
							autoTrigger: true,
							loadingHtml: '<?php print addslashes(caBusyIndicatorIcon($this->request).' '._t('Loading...')); ?>',
							padding: 20,
							nextSelector: 'a.jscroll-next'
						});
					});
					
					
				});
		</script>
<?php
	}else{
?>			
{{{<ifcount code="ca_objects" min="1">
			<div class="row">
				<div class="col-sm-12"><label>Objects</label></div>
			</div>
			<div class="row">
				<div id="browseResultsContainer">
					<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>
				</div><!-- end browseResultsContainer -->
			</div><!-- end row -->
			<script type="text/javascript">
				jQuery(document).ready(function() {
					jQuery("#browseResultsContainer").load("<?php print caNavUrl($this->request, '', 'Search', 'objects', array('search' => 'entity_id:^ca_entities.entity_id', 'view' => 'images'), array('dontURLEncodeParameters' => true)); ?>", function() {
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
