<?php
/* ----------------------------------------------------------------------
 * themes/default/views/bundles/ca_objects_default_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013-2015 Whirl-i-Gig
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
 
	$t_object = 			$this->getVar("item");
	$va_comments = 			$this->getVar("comments");
	$va_tags = 				$this->getVar("tags_array");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");
	$va_access_values = caGetUserAccessValues($this->request);

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
			<div class='col-sm-6 col-md-6 col-lg-5 col-lg-offset-1'>
				{{{representationViewer}}}
				
				
				<div id="detailAnnotations"></div><!-- end detailAnnotations -->
				
				<?php print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_object, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-sm-3 col-md-3 col-xs-4")); ?>
				

			</div><!-- end col -->
			
			<div class='col-sm-6 col-md-6 col-lg-5'>
				<H1>{{{<i>^ca_objects.preferred_labels.name</i>}}}</H1>
				<HR>
				{{{<ifdef code="ca_objects.author"><div class='unit'><label>Author/Editor</label>^ca_objects.author</div></ifdef>}}}
				{{{<ifdef code="ca_objects.publisher"><div class='unit'><label>Publisher</label>^ca_objects.publisher</div></ifdef>}}}
				{{{<ifdef code="ca_objects.pub_year"><div class='unit'><label>Year</label>^ca_objects.pub_year%delimiter=,_</div></ifdef>}}}
				{{{<ifdef code="ca_objects.pub_cat"><div class='unit'><label>Type</label>^ca_objects.pub_cat</div></ifdef>}}}
<?php
				$tmp_rel_artist = $t_object->getWithTemplate("<ifcount code='ca_entities' restrictToRelationshipTypes='subject' min='1'><unit relativeTo='ca_entities'= delimiter=', '> <l>^ca_entities.preferred_labels.displayname</l></unit></ifcount>", array("checkAccess" => $va_access_values));
				$tmp_artist = $t_object->getWithTemplate("<ifdef code='ca_objects.pub_subjects'>^ca_objects.pub_subjects</ifdef>");

				if($tmp_rel_artist || $tmp_artist){
					print '<div class="unit"><label>Subject</label>'.$tmp_rel_artist.(($tmp_rel_artist && $tmp_artist) ? ", " : "").$tmp_artist.'</div>';
				}
?>				
				{{{<ifdef code="ca_objects.pub_location"><div class='unit'><label>Location</label>^ca_objects.pub_location</div></ifdef>}}}	
				{{{<ifdef code="ca_objects.pub_cat"><div class='unit'><label>ISBN</label>^ca_objects.isbn</div></ifdef>}}}	
				{{{<ifdef code="ca_objects.language"><div class='unit'><label>Language</label>^ca_objects.language%delimiter=,_</div></ifdef>}}}				

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