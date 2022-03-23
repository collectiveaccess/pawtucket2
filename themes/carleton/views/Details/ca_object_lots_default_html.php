<?php
/* ----------------------------------------------------------------------
 * themes/default/views/bundles/ca_objects_default_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013-2018 Whirl-i-Gig
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
 
	$t_object_lot = 			$this->getVar("item");
	$va_comments = 			$this->getVar("comments");
	$va_tags = 				$this->getVar("tags_array");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");
	$vn_pdf_enabled = 		$this->getVar("pdfEnabled");
	$vn_id =				$t_object_lot->get('ca_object_lots.lot_id');
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
		<div class="container"><div class="row">
			<div class='col-sm-12 col-md-12 col-lg-10 col-lg-offset-1'>
				
				<H1>{{{^ca_object_lots.preferred_labels.name}}}</H1>
				<HR>
				
				{{{<ifdef code="ca_object_lots.idno_stub"><label>Identifier:</label>^ca_object_lots.idno_stub<br/></ifdef>}}}				
				
				{{{<ifdef code="ca_object_lots.inclusive_dates">
					<div class='unit'><label>Inclusive Dates</label>^ca_object_lots.inclusive_dates%delimiter=,_
					</div>
				</ifdef>}}}
				{{{<ifdef code="ca_object_lots.material">
					<div class='unit'><label>Material</label>^ca_object_lots.materials%delimiter=,_
					</div>
				</ifdef>}}}
				{{{<ifdef code="ca_object_lots.description">
					<div class='unit'><label>Physical Description</label>
						<span class="trimText">^ca_object_lots.description</span>
					</div>
				</ifdef>}}}
				{{{<ifdef code="ca_object_lots.notes">
					<div class='unit'><label>Notes</label>
						<span class="trimText">^ca_object_lots.notes</span>
					</div>
				</ifdef>}}}
				{{{<ifcount code="ca_entities" min="1" max="1"><label>Related person</label></ifcount>}}}
				{{{<ifcount code="ca_entities" min="2"><label>Related people</label></ifcount>}}}
				{{{<unit relativeTo="ca_object_lots_x_entities" delimiter="<br/>"><unit relativeTo="ca_entities"><l>^ca_entities.preferred_labels</l></unit> (^relationship_typename)</unit>}}}
				
				
						
			</div><!-- end col -->
		</div><!-- end row --></div><!-- end container -->
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