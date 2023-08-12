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
		<div class="container my-3">

			<div class="row mb-3">
				<div class='col-md-12 col-lg-12'>
					<H2>{{{^ca_entities.preferred_labels}}}</H2>
				</div><!-- end col -->
			</div><!-- end row -->

			<div class="row">			
				{{{<ifcount code="ca_objects" min="1" max="1">
					<div class='col-sm-6 col-md-6 col-lg-6'>
						<div class='unit'>
							<unit relativeTo="ca_objects" delimiter=" ">
								<l>^ca_object_representations.media.medium</l>
							</unit>
						</div>
					</div><!-- end col -->
				</ifcount>}}}

				<div class='col-sm-6 col-md-6 col-lg-6'>
					{{{<ifdef code="ca_entities.biography">
						<label><strong>Biography</strong></label>
						<div class='unit'>^ca_entities.biography</div>
						<br/>
					</ifdef>}}}

					{{{<ifcount code="ca_collections" min="1">
						<label><strong>Related collections</strong></label>
						<div class='unit'>
							<unit relativeTo="ca_collections" delimiter="<br/>">
								<l>^ca_collections.preferred_labels.name</l> (^relationship_typename)
							</unit>
						</div>
					</ifcount>}}}
				</div><!-- end col -->
			</div><!-- end row -->
			
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
