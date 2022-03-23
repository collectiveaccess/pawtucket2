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
 
	$t_object = 			$this->getVar("item");
	$va_comments = 			$this->getVar("comments");
	$va_tags = 				$this->getVar("tags_array");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");
	$vn_pdf_enabled = 		$this->getVar("pdfEnabled");
	$vn_id =				$t_object->get('ca_objects.object_id');
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
				
				
				<div id="detailAnnotations"></div>
				
				<?php print caObjectRepresentationThumbnails($this->request, $this->getVar("representation_id"), $t_object, array("returnAs" => "bsCols", "linkTo" => "carousel", "bsColClasses" => "smallpadding col-sm-3 col-md-3 col-xs-4", "primaryOnly" => $this->getVar('representationViewerPrimaryOnly') ? 1 : 0)); ?>
<div id="fb-root"></div>
  <script>(function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.0";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));</script>

  <!-- Your share button code -->
  <div class="detailFbShare"><div class="fb-share-button" 
		data-href="<?php print $this->request->config->get("site_host").caDetailUrl($this->request, "ca_objects", $t_object->get("object_id")); ?>" 
		data-layout="button">
	  </div>
  </div>				
<?php
				# Comment and Share Tools
				#if ($vn_comments_enabled | $vn_share_enabled | $vn_pdf_enabled) {
						
					print '<div id="detailTools">';
					print "<div class='detailTool'><span class='glyphicon glyphicon-envelope'></span>".caNavLink($this->request, "Hoge resolutie versie bestellen", "", "", "Contact",  "form", array('table' => 'ca_objects', 'id' => $vn_id))."</div>";
					if ($vn_comments_enabled) {
?>				
						<div class="detailTool"><a href='#' onclick='jQuery("#detailComments").slideToggle(); return false;'><span class="glyphicon glyphicon-comment"></span><?php print _t("Comments and Tags"); ?> (<?php print sizeof($va_comments) + sizeof($va_tags); ?>)</a></div><!-- end detailTool -->
<?php
						if($this->request->isLoggedIn()){
?>
						<div id='detailComments'><?php print $this->getVar("itemComments");?></div><!-- end itemComments -->
<?php					
						}else{
							print "<div id='detailComments'><button type='button' class='btn btn-default' onclick='caMediaPanel.showPanel(\"".caNavUrl($this->request, '', 'LoginReg', 'LoginForm', array())."\"); return false;' >"._t("Login")."/"._t("Register")."</button></div>";

						}				
					}
					if ($vn_share_enabled) {
						print '<div class="detailTool"><span class="glyphicon glyphicon-share-alt"></span>'.$this->getVar("shareLink").'</div><!-- end detailTool -->';
					}
					if ($vn_pdf_enabled) {
						print "<div class='detailTool'><span class='glyphicon glyphicon-file'></span>".caDetailLink($this->request, _t("Download as PDF"), "faDownload", "ca_objects",  $vn_id, array('view' => 'pdf', 'export_format' => '_pdf_ca_objects_summary'))."</div>";
					}
					print '</div><!-- end detailTools -->';
				#}				

?>

			</div><!-- end col -->

			<div class='col-sm-6 col-md-6 col-lg-5'>
				<H4>{{{ca_objects.preferred_labels.name}}}</H4>
<?php
				if($vn_collection_id = $t_object->get("ca_objects.object_collection.collection_id")){
					print "<div class='unit'><H6>Collectie</H6>";
					print caDetailLink($this->request, $t_object->get("ca_objects.object_collection.preferred_labels.name"), '', 'ca_collections', $vn_collection_id);
					print "</div>";
				}
				
?>
				{{{<ifdef code="ca_objects.idno"><div class="unit"><H6>Inventarisnummer</H6>^ca_objects.idno</div></ifdef>}}}
				<HR>
				{{{<ifdef code="ca_objects.content_description">
					<div class='unit'><h6>Beschrijving</h6>
						<span class="trimText">^ca_objects.content_description</span>
					</div>
				</ifdef>}}}
<?php
				if($va_list_items = $t_object->get("ca_list_items", array("returnWithStructure" => true))){
					print '<div class="unit"><H6>Objecttype</H6>';
					$va_tmp = array();
					foreach($va_list_items as $va_list_item){
						$va_tmp[] = caNavLink($this->request, $va_list_item["label"], "", "", "Browse", "objects", array("facet" => "term_facet", "id" => $va_list_item["item_id"]));
					}
					print join(", ", $va_tmp);
					print '</div>';
				}
?>				
				
				{{{<ifdef code="ca_objects.dimensions"><div class="unit"><H6>Afmetingen</H6><unit relativeTo="ca_objects" delimiter="<br/>"><ifdef code="ca_objects.dimensions.dimensions_name">^ca_objects.dimensions.dimensions_name: </ifdef><ifdef code="ca_objects.dimensions.dimensions_height">^ca_objects.dimensions.dimensions_height</ifdef><ifdef code="ca_objects.dimensions.dimensions_width|ca_objects.dimensions.dimensions_depth"> X </ifdef><ifdef code="ca_objects.dimensions.dimensions_width">^ca_objects.dimensions.dimensions_width</ifdef><ifdef code="ca_objects.dimensions.dimensions_depth"> X </ifdef><ifdef code="ca_objects.dimensions.dimensions_depth">^ca_objects.dimensions.dimensions_depth</ifdef><ifdef code="ca_objects.dimensions.dimensions_unit"> ^ca_objects.dimensions.dimensions_unit</ifdef><ifdef code="ca_objects.dimensions.weight"> ^ca_objects.dimensions.weight</ifdef><ifdef code="ca_objects.dimensions.weight,ca_objects.dimensions.weight_unit"> ^ca_objects.dimensions.weight_unit</ifdef></unit></div></ifdef>}}}
				{{{<ifcount code="ca_places" min="1"><div class="unit"><H6>Plaatsen</H6><unit relativeTo="ca_places" delimiter=", ">^ca_places.preferred_labels</unit></div></ifcount>}}}
				
<?php
				if($vs_date = $t_object->getWithTemplate('<ifdef code="ca_objects.production_dating.Style|ca_objects.production_dating.earliest_date|ca_objects.production_dating.production_period"><unit relativeTo="ca_objects" delimiter="<br/>"><ifdef code="ca_objects.production_dating.Style">^ca_objects.production_dating.Style </ifdef><ifdef code="ca_objects.production_dating.earliest_date">^ca_objects.production_dating.earliest_date </ifdef><ifdef code="ca_objects.production_dating.production_period">^ca_objects.production_dating.production_period </ifdef></unit></ifdef>')){
					print '<div class="unit"><H6>Datering</H6>';
					print caNavLink($this->request, $vs_date, "", "", "Search", "objects", array("search" => "'".$vs_date."'"));
					print '</div>';
				}
				if($va_object_keywords = $t_object->get("ca_objects.object_keywords", array("returnWithStructure" => true))){
					$va_object_keywords = array_pop($va_object_keywords);
					$va_tmp = array();
					foreach($va_object_keywords as $va_object_keyword){
						$va_tmp[] = caNavLink($this->request, $va_object_keyword["object_keywords"], "", "", "Browse", "objects", array("facet" => "trefwoorden_facet", "id" => $va_object_keyword["object_keywords"]));
					}
						print '<div class="unit"><H6>Trefwoord</H6>';
						print join(", ", $va_tmp);
						print "</div>";
				}
				if($va_makers = $t_object->get("ca_objects.production_maker.maker", array("returnAsArray" => true, "convertCodesToDisplayText" => true))){
					$va_makers_ids = $t_object->get("ca_objects.production_maker.maker", array("returnAsArray" => true));
					print '<div class="unit"><H6>Vervaardiger</H6>';
					foreach($va_makers as $vn_i => $vs_maker){
						print caNavLink($this->request, $vs_maker, "", "", "Search", "objects", array("search" => "ca_entities.entity_id:".$va_makers_ids[$vn_i]));
					}
					print '</div>';
				}
				#print $t_object->getWithTemplate('<ifdef code="ca_objects.production_maker.maker"><div class="unit"><H6>Vervaardiger</H6><unit relativeTo="ca_objects" delimiter="<br/>"><ifdef code="ca_objects.production_maker.maker">^ca_objects.production_maker.maker</ifdef><ifdef code="ca_objects.production_maker.maker_role">, ^ca_objects.production_maker.maker_role</ifdef><ifdef code="ca_objects.production_maker.maker_sureness">, ^ca_objects.production_maker.maker_sureness</ifdef></unit></div></ifdef>');
				print $t_object->getWithTemplate('<ifdef code="ca_objects.management_acquisition.acquisition_source|ca_objects.management_acquisition.acquisition_method_type|ca_objects.management_acquisition.acquisition_date|ca_objects.management_acquisition.acquisition_note"><div class="unit"><H6>Verwerving</H6><unit relativeTo="ca_objects" delimiter="<br/>"><ifdef code="ca_objects.management_acquisition.acquisition_source">^ca_objects.management_acquisition.acquisition_source</ifdef><ifdef code="ca_objects.management_acquisition.acquisition_method_type">, ^ca_objects.management_acquisition.acquisition_method_type</ifdef><ifdef code="ca_objects.management_acquisition.acquisition_date">, ^ca_objects.management_acquisition.acquisition_date</ifdef><ifdef code="ca_objects.management_acquisition.acquisition_note">, ^ca_objects.management_acquisition.acquisition_note</ifdef></unit></div></ifdef>');
	if($vs_map = $this->getVar("map")){								
		print "<hr></hr><div class='unit'>".$vs_map."</div><br/>";
	}
?>
						
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