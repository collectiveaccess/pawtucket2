<?php
/* ----------------------------------------------------------------------
 * themes/default/views/bundles/ca_placess_default_html.php : 
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


<div class="container detail-container">

	<div class="row border-bottom mb-3">
		<div class="col">
			<H1>{{{<l>^ca_places.preferred_labels.name</l>}}}</H1>
		</div>
	</div>

	<div class="row mb-3">
		<div class="col-1 mb-2">
			{{{previousLink}}} {{{resultsLink}}}
		</div>

		<div class="col-10">
			<?php
				if ($vn_share_enabled | $vn_pdf_enabled) {	
			?>
				<div class='row'>
			<?php
					if ($vn_share_enabled) {
						print '<div class="col-auto"><span class="" aria-label="'._t("Share").'"><i class="bi bi-share me-1"></i></span>'.$this->getVar("shareLink")."</div>";
					}
					if ($vn_pdf_enabled) {
						print "<div class='col-auto'><span class='' aria-label='"._t("Download")."'><i class='bi bi-download me-1'></i></span>".caDetailLink($this->request, "Download as PDF", "", "ca_objects",  $vn_id, array('view' => 'pdf', 'export_format' => '_pdf_ca_objects_summary'))."</div>";
					}
			?>
				</div>
			<?php
				}				
			?>

			<!-- {{{representationViewer}}} -->
			{{{<ifcount code="ca_objects" min="1">
				<div class='unit'>
					<unit relativeTo="ca_objects" delimiter=" " length="1">
						<l>^ca_object_representations.media.large</l>
						<div class='caption'>Related Object: <l>^ca_objects.preferred_labels.name</l></div>
					</unit>
				</div>
			</ifcount>}}}
		</div>

		<div class="col-1">
			{{{nextLink}}}
		</div>
	</div>

	<div class="row row-cols-sm-1 row-cols-md-2 mt-5 justify-content-center">

		<div class="col-sm-5 col-md-5">						
			{{{<div class="unit">
				<h6><?= _t('Type Id'); ?></h6>
				^ca_places.type_id
			</div>}}}

			{{{<ifdef code="ca_places.idno">
				<div class="unit">
					<h6><?= _t('Identifier'); ?></h6>
					^ca_places.idno
				</div>
			</ifdef>}}}
			
			{{{<ifdef code="ca_places.description">
				<div class='unit'>
					<h6><?= _t('About'); ?></h6>
					<span class="trimText">^ca_places.description</span>
				</div>
			</ifdef>}}}
		</div>

		<div class="col-sm-5 col-md-5">
			{{{<ifcount code="ca_entities" min="1"><div class="unit">
				<ifcount code="ca_entities" min="1" max="1"><h6><?= _t('Related person'); ?></h6></ifcount>
				<ifcount code="ca_entities" min="2"><h6><?= _t('Related people'); ?></h6></ifcount>
				<unit relativeTo="ca_entities" delimiter="<br/>"><l>^ca_entities.preferred_labels</l> (^relationship_typename)</unit>
			</div></ifcount>}}}
			
			{{{<ifcount code="ca_occurrences" min="1"><div class="unit">
				<ifcount code="ca_occurrences" min="1" max="1"><h6><?= _t('Related occurrence'); ?></h6></ifcount>
				<ifcount code="ca_occurrences" min="2"><h6><?= _t('Related occurrences'); ?></h6></ifcount>
				<unit relativeTo="ca_occurrences" delimiter="<br/>"><l>^ca_occurrences.preferred_labels</l> (^relationship_typename)</unit>
			</div></ifcount>}}}
			
			{{{<ifcount code="ca_places.related" min="1"><div class="unit">
				<ifcount code="ca_places.related" min="1" max="1"><h6><?= _t('Related place'); ?></h6></ifcount>
				<ifcount code="ca_places.related" min="2"><h6><?= _t('Related places'); ?></h6></ifcount>
				<unit relativeTo="ca_places.related" delimiter="<br/>"><l>^ca_places.preferred_labels</l> (^relationship_typename)</unit>
			</div></ifcount>}}}
			
			{{{<ifcount code="ca_collections" min="1"><div class="unit">
				<ifcount code="ca_collections" min="1" max="1"><h6><?= _t('Related Collection'); ?></h6></ifcount>
				<ifcount code="ca_collections" min="2"><h6><?= _t('Related Collections'); ?></h6></ifcount>
				<unit relativeTo="ca_collections" delimiter="<br/>"><l>^ca_collections.preferred_labels</l> (^relationship_typename)</unit>
			</div></ifcount>}}}
		</div>
	</div>
	{{{<ifcount code="ca_objects" min="2">
		<div class="row">
			<div id="browseResultsContainer">
				<?php print caBusyIndicatorIcon($this->request).' '.addslashes(_t('Loading...')); ?>
			</div><!-- end browseResultsContainer -->
		</div><!-- end row -->
		<script type="text/javascript">
			jQuery(document).ready(function() {
				jQuery("#browseResultsContainer").load("<?php print caNavUrl($this->request, '', 'Search', 'objects', array('search' => 'place_id:^ca_places.place_id'), array('dontURLEncodeParameters' => true)); ?>", function() {
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

</div>

<script type='text/javascript'>
	jQuery(document).ready(function() {
		$('.trimText').readmore({
		  speed: 75,
		  maxHeight: 120
		});
	});
</script>

</div>
