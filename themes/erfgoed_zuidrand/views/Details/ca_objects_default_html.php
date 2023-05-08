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
	$va_config_options = 	$this->getVar("config_options");
	$va_access_values = caGetUserAccessValues($this->request);

	
	
	MetaTagManager::addMetaProperty("og:url", $this->request->config->get("site_host").caNavUrl($this->request, "*", "*", "*"));
	MetaTagManager::addMetaProperty("og:title", $t_object->get("ca_objects.preferred_labels.name"));
	MetaTagManager::addMetaProperty("og:type", "website");
	if($vs_tmp = $t_object->getWithTemplate("^ca_objects.content_description")){
		MetaTagManager::addMetaProperty("og:description", htmlentities(strip_tags($vs_tmp)));
	}
	if($vs_rep = $t_object->get("ca_object_representations.media.page.url", array("checkAccess" => $va_access_values))){
		MetaTagManager::addMetaProperty("og:image", $vs_rep);
		MetaTagManager::addMetaProperty("og:image:width", $t_object->get("ca_object_representations.media.page.width"));
		MetaTagManager::addMetaProperty("og:image:height", $t_object->get("ca_object_representations.media.page.height"));
	}


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
				
				<?= $this->getVar('representationViewerThumbnailBar'); ?>
<?php
	$allow_social_cookies = (bool)CookieOptionsManager::allow("social");
	if($allow_social_cookies){
?>

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
	}
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
				<H1>{{{^ca_objects.preferred_labels.name}}}</H1>
				{{{<ifcount code="ca_collections" min="1"><div class='unit'><label>Collectie</label><unit relativeTo="ca_collections"><l>^ca_collections.preferred_labels.name</l></unit></div></ifcount>}}}
				{{{<ifdef code="ca_objects.idno"><div class="unit"><label>Inventarisnummer</label>^ca_objects.idno</div></ifdef>}}}
				<HR>
				{{{<ifdef code="ca_objects.content_description">
					<div class='unit'><label>Beschrijving</label>
						<span class="trimText"><unit relativeTo="ca_objects.content_description" delimiter="<br/><br/>">^ca_objects.content_description</unit></span>
					</div>
				</ifdef>}}}				
				{{{<ifdef code="ca_objects.object_type_AAT"><div class="unit"><label>Objectnaam</label><unit relativeTo="ca_objects.object_type_AAT" delimiter=", ">^ca_objects.object_type_AAT</unit></div></ifdef>}}}
				{{{<ifdef code="ca_objects.dimensions"><div class="unit"><label>Afmetingen</label><unit relativeTo="ca_objects" delimiter="<br/>"><ifdef code="ca_objects.dimensions.dimensions_name">^ca_objects.dimensions.dimensions_name: </ifdef><ifdef code="ca_objects.dimensions.dimensions_height">^ca_objects.dimensions.dimensions_height</ifdef><ifdef code="ca_objects.dimensions.dimensions_width|ca_objects.dimensions.dimensions_depth"> X </ifdef><ifdef code="ca_objects.dimensions.dimensions_width">^ca_objects.dimensions.dimensions_width</ifdef><ifdef code="ca_objects.dimensions.dimensions_depth"> X </ifdef><ifdef code="ca_objects.dimensions.dimensions_depth">^ca_objects.dimensions.dimensions_depth</ifdef><ifdef code="ca_objects.dimensions.dimensions_unit"> ^ca_objects.dimensions.dimensions_unit</ifdef><ifdef code="ca_objects.dimensions.weight"> ^ca_objects.dimensions.weight</ifdef><ifdef code="ca_objects.dimensions.weight,ca_objects.dimensions.weight_unit"> ^ca_objects.dimensions.weight_unit</ifdef></unit></div></ifdef>}}}
				{{{<ifcount code="ca_places" min="1"><div class="unit"><label>Plaatsen</label><unit relativeTo="ca_places" delimiter="<br/>">
					<unit relativeTo="ca_places.parent">
						<ifdef code="^ca_places.parent_id">
							<unit relativeTo="ca_places.parent"><if rule="^ca_places.type_id !~ /land/"><?php print caNavLink($this->request, "^ca_places.preferred_labels", "", "", "Browse", "objects/facet/place_facet/id/^ca_places.place_id"); ?> > </if></unit>
							<?php print caNavLink($this->request, "^ca_places.preferred_labels", "", "", "Browse", "objects/facet/place_facet/id/^ca_places.place_id"); ?> > 
						</ifdef>
					</unit>
					<if rule="^ca_places.type_id !~ /straat/"><?php print caNavLink($this->request, "^ca_places.preferred_labels", "", "", "Browse", "objects/facet/place_facet/id/^ca_places.place_id"); ?></if>
					<if rule="^ca_places.type_id =~ /straat/"><unit relativeTo="ca_places">^ca_places.preferred_labels</unit></if>
				
				</unit></div></ifcount>}}}
				
				
<?php
				if($vs_date = $t_object->getWithTemplate('<ifdef code="ca_objects.production_dating.Style|ca_objects.production_dating.earliest_date|ca_objects.production_dating.production_period"><unit relativeTo="ca_objects" delimiter="<br/>"><ifdef code="ca_objects.production_dating.Style">^ca_objects.production_dating.Style </ifdef><ifdef code="ca_objects.production_dating.earliest_date">^ca_objects.production_dating.earliest_date </ifdef><ifdef code="ca_objects.production_dating.production_period">^ca_objects.production_dating.production_period </ifdef></unit></ifdef>')){
					print '<div class="unit"><label>Datering</label>';
					print caNavLink($this->request, $vs_date, "", "", "Search", "objects", array("search" => "'".$vs_date."'"));
					print '</div>';
				}
				if($va_object_keywords = $t_object->get("ca_objects.object_keywords", array("returnWithStructure" => true))){
					$va_object_keywords = array_pop($va_object_keywords);
					$va_tmp = array();
					foreach($va_object_keywords as $va_object_keyword){
						$va_tmp[] = caNavLink($this->request, $va_object_keyword["object_keywords"], "", "", "Search", "objects", array("search" => $va_object_keyword["object_keywords"]));
					}
						print '<div class="unit"><label>Trefwoord</label>';
						print join(", ", $va_tmp);
						print "</div>";
				}
				if($va_makers = $t_object->get("ca_objects.production_maker.maker", array("returnAsArray" => true, "convertCodesToDisplayText" => true, "checkAccess" => $va_access_values))){
					$va_makers_ids = $t_object->get("ca_objects.production_maker.maker", array("returnAsArray" => true, "checkAccess" => $va_access_values));
					if(sizeof($va_makers_ids)){
						$va_tmp = array();
						foreach($va_makers as $vn_i => $vs_maker){
							if($vs_maker){
								$va_tmp[] = caNavLink($this->request, $vs_maker, "", "", "Search", "objects", array("search" => "ca_entities.entity_id:".$va_makers_ids[$vn_i]));
							}
						}
						if(sizeof($va_tmp)){
							print '<div class="unit"><label>Vervaardiger</label>';
							print join(", ", $va_tmp);
							print '</div>';
						}
					}
				}
				print $t_object->getWithTemplate('<ifdef code="ca_objects.management_acquisition.acquisition_source|ca_objects.management_acquisition.acquisition_method_type|ca_objects.management_acquisition.acquisition_date|ca_objects.management_acquisition.acquisition_note"><div class="unit"><label>Verwerving</label>
														<unit relativeTo="ca_objects" delimiter="<br/>">
															<ifdef code="ca_objects.management_acquisition.acquisition_source">^ca_objects.management_acquisition.acquisition_source</ifdef>
															<ifdef code="ca_objects.management_acquisition.acquisition_method_type"><ifdef code="ca_objects.management_acquisition.acquisition_source">, </ifdef>^ca_objects.management_acquisition.acquisition_method_type</ifdef>
															<ifdef code="ca_objects.management_acquisition.acquisition_date"><ifdef code="ca_objects.management_acquisition.acquisition_source|ca_objects.management_acquisition.acquisition_method_type">, </ifdef>^ca_objects.management_acquisition.acquisition_date</ifdef>
															<ifdef code="ca_objects.management_acquisition.acquisition_note"><ifdef code="ca_objects.management_acquisition.acquisition_source|ca_objects.management_acquisition.acquisition_method_type|ca_objects.management_acquisition.acquisition_date">, </ifdef>^ca_objects.management_acquisition.acquisition_note</ifdef></unit></div></ifdef>');
	if($vs_map = $this->getVar("map")){								
		print "<hr></hr><div class='unit'>".$vs_map."</div><br/>";
	}
?>
				{{{<ifcount code="ca_objects.related" min="1">
					<div class="unit">
						<label>Related Objects</label>
						<unit relativeTo="ca_objects.related" delimiter="<br/>">
							<div class="row"><div class="col-sm-3"><l>^ca_object_representations.media.small</l></div><div class="col-sm-9"><l>^ca_objects.preferred_labels.name</l></div></div>
						</unit>
					</div>
				</ifcount>}}}
									
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
		  maxHeight: 120,
		  moreLink: '<a href="#">Lees meer</a>',
          lessLink: '<a href="#">Lees Minder</a>'
		});
	});
</script>