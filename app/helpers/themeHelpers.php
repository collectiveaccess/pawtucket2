<?php
/** ---------------------------------------------------------------------
 * app/helpers/themeHelpers.php : utility functions for setting database-stored configuration values
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2009-2014 Whirl-i-Gig
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
 * @package CollectiveAccess
 * @subpackage utils
 * @license http://www.gnu.org/copyleft/gpl.html GNU Public License version 3
 * 
 * ----------------------------------------------------------------------
 */

	/**
	*
	*/
   
   	# ---------------------------------------
	/**
	 * Generate HTML <img> tag for graphic in current theme; if graphic is not available the graphic in the default theme will be returned.
	 *
	 * @param RequestHTTP $po_request
	 * @param string $ps_file_path
	 * @param array $pa_attributes
	 * @param array $pa_options
	 * @return string 
	 */
	function caGetThemeGraphic($po_request, $ps_file_path, $pa_attributes=null, $pa_options=null) {
		$vs_base_url_path = $po_request->getThemeUrlPath();
		$vs_base_path = $po_request->getThemeDirectoryPath();
		$vs_file_path = '/assets/pawtucket/graphics/'.$ps_file_path;
		
		if (!file_exists($vs_base_path.$vs_file_path)) {
			$vs_base_url_path = $po_request->getDefaultThemeUrlPath();
		}
		
		$vs_html = caHTMLImage($vs_base_url_path.$vs_file_path, $pa_attributes, $pa_options);
		
		return $vs_html;
	}
	# ---------------------------------------
	/**
	 * Generate URL tag for graphic in current theme; if graphic is not available the graphic in the default theme will be returned.
	 *
	 * @param RequestHTTP $po_request
	 * @param string $ps_file_path
	 * @param array $pa_options
	 * @return string 
	 */
	function caGetThemeGraphicURL($po_request, $ps_file_path, $pa_options=null) {
		$vs_base_path = $po_request->getThemeUrlPath();
		$vs_file_path = '/assets/pawtucket/graphics/'.$ps_file_path;

		if (!file_exists($po_request->getThemeDirectoryPath().$vs_file_path)) {
			$vs_base_path = $po_request->getDefaultThemeUrlPath();
		}
		return $vs_base_path.$vs_file_path;
	}
	# ---------------------------------------
	/**
	 * Set CSS classes to add the "pageArea" page content <div>, overwriting any previous setting. 
	 * Use to set classes specific to each page type and context.
	 *
	 * @param RequestHTTP $po_request
	 * @param mixed $pa_page_classes A class (string) or list of classes (array) to set
	 * @return bool Always returns true
	 */
	$g_theme_page_css_classes = array();
	function caSetPageCSSClasses($pa_page_classes) {
		global $g_theme_page_css_classes;
		if (!is_array($pa_page_classes) && $pa_page_classes) { $pa_page_classes = array($pa_page_classes); }
		if (!is_array($pa_page_classes)) { $pa_page_classes = array(); }
		
		$g_theme_page_css_classes = $pa_page_classes;
		
		return true;
	}
	# ---------------------------------------
	/**
	 * Adds CSS classes to the "pageArea" page content <div>. Use to set classes specific to each
	 * page type and context.
	 *
	 * @param RequestHTTP $po_request
	 * @param mixed $pa_page_classes A class (string) or list of classes (array) to add
	 * @return bool Returns true if classes were added, false if class list is empty
	 */
	function caAddPageCSSClasses($pa_page_classes) {
		global $g_theme_page_css_classes;
		if (!is_array($pa_page_classes) && $pa_page_classes) { $pa_page_classes = array($pa_page_classes); }
		
		if(!is_array($va_classes = $g_theme_page_css_classes)) {
			return false;
		}
		
		$g_theme_page_css_classes = array_unique(array_merge($pa_page_classes, $va_classes));
		
		return true;
	}
	# ---------------------------------------
	/**
	 * Get CSS class attribute ready for including in a <div> tag. Used to add classes to the "pageArea" page content <div>
	 *
	 * @param RequestHTTP $po_request
	 * @return string The "class" attribute with set classes or an empty string if no classes are set
	 */
	function caGetPageCSSClasses() {
		global $g_theme_page_css_classes;
		return (is_array($g_theme_page_css_classes) && sizeof($g_theme_page_css_classes)) ? "class='".join(' ', $g_theme_page_css_classes)."'" : '';
	}
	# ---------------------------------------
	/**
	 * Converts, and by default prints, a root-relative static view path to a DefaultController URL to load the appropriate view
	 * Eg. $ps_path of "/About/this/site" becomes "/index.php/About/this/site"
	 *
	 * @param string $ps_path
	 * @param array $pa_options Options include:
	 *		dontPrint = Don't print URL to output. Default is false.
	 *		request = The current request object (RequestHTTP). Default is to use globally set request object.
	 *
	 * @return string the URL
	 */
	function caStaticPageUrl($ps_path, $pa_options=null) {
		global $g_request;
		
		if (!($po_request = caGetOption('request', $pa_options, null))) { $po_request = $g_request; }
		$vs_url = $po_request->getBaseUrlPath().'/'.$po_request->getScriptName().$ps_path;
		
		if (!caGetOption('dontPrint', $pa_options, false)) {
			print $vs_url;
		}
		return $vs_url;
	}
	# ---------------------------------------
	/**
	 * Get theme-specific detail configuration
	 *
	 * @return Configuration 
	 */
	function caGetDetailConfig() {
		return Configuration::load(__CA_THEME_DIR__.'/conf/detail.conf');
	}
	# ---------------------------------------
	/**
	 * Get theme-specific gallery section configuration
	 *
	 * @return Configuration 
	 */
	function caGetGalleryConfig() {
		return Configuration::load(__CA_THEME_DIR__.'/conf/gallery.conf');
	}
	# ---------------------------------------
	/**
	 * Get theme-specific contact configuration
	 *
	 * @return Configuration 
	 */
	function caGetContactConfig() {
		return Configuration::load(__CA_THEME_DIR__.'/conf/contact.conf');
	}
	# ---------------------------------------
	/**
	 * Get theme-specific front page configuration
	 *
	 * @return Configuration 
	 */
	function caGetFrontConfig() {
		return Configuration::load(__CA_THEME_DIR__.'/conf/front.conf');
	}
	# ---------------------------------------
	/**
	 * Get theme-specific icon configuration
	 *
	 * @return Configuration 
	 */
	function caGetIconsConfig() {
		if(file_exists(__CA_THEME_DIR__.'/conf/front.conf')){
			return Configuration::load(__CA_THEME_DIR__.'/conf/icons.conf');
		}else{
			return Configuration::load(__CA_THEMES_DIR__.'/default/conf/icons.conf');
		}
	}
	# ---------------------------------------
	/**
	 * Get theme-specific sets/lightbox configuration
	 *
	 * @return Configuration 
	 */
	function caGetSetsConfig() {
		return Configuration::load(__CA_THEME_DIR__.'/conf/sets.conf');
	}
	# ---------------------------------------
	/**
	 * Returns associative array, keyed by primary key value with values being
	 * the preferred label of the row from a suitable locale, ready for display 
	 * 
	 * @param array $pa_ids indexed array of primary key values to fetch labels for
	 * @param array $pa_options
	 * @return array List of media
	 */
	function caGetPrimaryRepresentationsForIDs($pa_ids, $pa_options=null) {
		if (!is_array($pa_ids) && (is_numeric($pa_ids)) && ($pa_ids > 0)) { $pa_ids = array($pa_ids); }
		if (!is_array($pa_ids) || !sizeof($pa_ids)) { return array(); }
		
		$pa_access_values = caGetOption("checkAccess", $pa_options, array());
		$pa_versions = caGetOption("versions", $pa_options, array(), array('castTo' => 'array'));
		$ps_table = caGetOption("table", $pa_options, 'ca_objects');
		$pa_return = caGetOption("return", $pa_options, array(), array('castTo' => 'array'));
		
		$vs_access_where = '';
		if (isset($pa_access_values) && is_array($pa_access_values) && sizeof($pa_access_values)) {
			$vs_access_where = ' AND orep.access IN ('.join(',', $pa_access_values).')';
		}
		$o_db = new Db();
		$o_dm = Datamodel::load();
		
		if (!($vs_linking_table = RepresentableBaseModel::getRepresentationRelationshipTableName($ps_table))) { return null; }
		$vs_pk = $o_dm->getTablePrimaryKeyName($ps_table);
	
		$qr_res = $o_db->query("
			SELECT oxor.{$vs_pk}, orep.media, orep.representation_id
			FROM ca_object_representations orep
			INNER JOIN {$vs_linking_table} AS oxor ON oxor.representation_id = orep.representation_id
			WHERE
				(oxor.{$vs_pk} IN (".join(',', $pa_ids).")) AND oxor.is_primary = 1 AND orep.deleted = 0 {$vs_access_where}
		");
	
		$vb_return_tags = (sizeof($pa_return) == 0) || in_array('tags', $pa_return);
		$vb_return_info = (sizeof($pa_return) == 0) || in_array('info', $pa_return);
		$vb_return_urls = (sizeof($pa_return) == 0) || in_array('urls', $pa_return);
		
		$va_media = array();
		while($qr_res->nextRow()) {
			$va_media_tags = array();
			if ($pa_versions && is_array($pa_versions) && sizeof($pa_versions)) { $va_versions = $pa_versions; } else { $va_versions = $qr_res->getMediaVersions('media'); }
			
			$vb_media_set = false;
			foreach($va_versions as $vs_version) {
				if (!$vb_media_set && $qr_res->getMediaPath('ca_object_representations.media', $vs_version)) { $vb_media_set = true; }
				
				if ($vb_return_tags) {
					if (sizeof($va_versions) == 1) {
						$va_media_tags['tags'] = $qr_res->getMediaTag('ca_object_representations.media', $vs_version);
					} else {
						$va_media_tags['tags'][$vs_version] = $qr_res->getMediaTag('ca_object_representations.media', $vs_version);
					}
				}
				if ($vb_return_info) {
					if (sizeof($va_versions) == 1) {
						$va_media_tags['info'] = $qr_res->getMediaInfo('ca_object_representations.media', $vs_version);
					} else {
						$va_media_tags['info'][$vs_version] = $qr_res->getMediaInfo('ca_object_representations.media', $vs_version);
					}
				}
				if ($vb_return_urls) {
					if (sizeof($va_versions) == 1) {
						$va_media_tags['urls'] = $qr_res->getMediaUrl('ca_object_representations.media', $vs_version);
					} else {
						$va_media_tags['urls'][$vs_version] = $qr_res->getMediaUrl('ca_object_representations.media', $vs_version);
					}
				}
			}
			
			$va_media_tags['representation_id'] = $qr_res->get('ca_object_representations.representation_id');
			
			if (!$vb_media_set)  { continue; }
			
			if (sizeof($pa_return) == 1) {
				$va_media_tags = $va_media_tags[$pa_return[0]];
			}
			$va_media[$qr_res->get($vs_pk)] = $va_media_tags;
		}
	
		// Return empty array when there's no media
		if(!sizeof($va_media)) { return array(); }
	
		// Preserve order of input ids
		$va_media_sorted = array();
		foreach($pa_ids as $vn_id) {
			if(!isset($va_media[$vn_id]) || !$va_media[$vn_id]) { continue; }
			$va_media_sorted[$vn_id] = $va_media[$vn_id];
		} 
		
		return $va_media_sorted;
	}
	# ---------------------------------------
	/**
	 * Returns associative array, keyed by primary key value with values being
	 * the preferred label of the row from a suitable locale, ready for display 
	 * 
	 * @param array $pa_ids indexed array of primary key values to fetch labels for
	 * @param array $pa_options
	 * @return array List of media
	 */
	function caGetPrimaryRepresentationTagsForIDs($pa_ids, $pa_options=null) {
		$pa_options['return'] = array('tags');
		
		return caGetPrimaryRepresentationsForIDs($pa_ids, $pa_options);
	}
	# ---------------------------------------
	/**
	 * Returns associative array, keyed by primary key value with values being
	 * the preferred label of the row from a suitable locale, ready for display 
	 * 
	 * @param array $pa_ids indexed array of primary key values to fetch labels for
	 * @param array $pa_options
	 * @return array List of media
	 */
	function caGetPrimaryRepresentationInfoForIDs($pa_ids, $pa_options=null) {
		$pa_options['return'] = array('info');
		
		return caGetPrimaryRepresentationsForIDs($pa_ids, $pa_options);
	}
	# ---------------------------------------
	/**
	 * Returns associative array, keyed by primary key value with values being
	 * the preferred label of the row from a suitable locale, ready for display 
	 * 
	 * @param array $pa_ids indexed array of primary key values to fetch labels for
	 * @param array $pa_options
	 * @return array List of media
	 */
	function caGetPrimaryRepresentationUrlsForIDs($pa_ids, $pa_options=null) {
		$pa_options['return'] = array('urls');
		
		return caGetPrimaryRepresentationsForIDs($pa_ids, $pa_options);
	}
	# ---------------------------------------
	/**
	 * Returns the primary representation for display on the object detail page
	 * uses settings from media_display.conf
	 * options
	 *		primaryOnly - true/false, show only the primary rep, default false
	 *		dontShowPlaceholder - true/false, default false
	 *		currentRepClass = set to class name added to thumbnail reps link tag for current rep (default = active)	
	 *
	 *
	 * NOTE: references classes in caObjectRepresentationThumbnails to select current thumbnail
	 */
	function caObjectDetailMedia($po_request, $pn_object_id, $t_representation, $t_object, $pa_options=null) {
		if(!is_array($pa_options)){ $pa_options = array(); }
		if(!$pa_options["currentRepClass"]){
			$pa_options["currentRepClass"] = "active";
		}
		$va_access_values = caGetUserAccessValues($po_request);
		if($t_representation){
			$vn_current_rep_id = $t_representation->get("representation_id");
		}
		if($pa_options["primaryOnly"]){
			if($vn_current_rep_id){
				$va_rep_ids = array($vn_current_rep_id);
			}else{
				if($vn_primary_rep_id = $t_object->getPrimaryRepresentationID(array("checkAccess" => $va_access_values))){
					$va_rep_ids = array($vn_primary_rep_id);
				}
			}
		}else{
			# --- are there multiple reps?
			$va_rep_ids = $t_object->getRepresentationIDs(array("checkAccess" => $va_access_values));
			if(sizeof($va_rep_ids)){
				$vn_primary_id = array_search("1", $va_rep_ids);
				if($vn_primary){
					unset($va_rep_ids[$vn_primary_id]);
					$va_rep_ids = array_merge(array($vn_primary_id), array_keys($va_rep_ids));
				}else{
					$va_rep_ids = array_keys($va_rep_ids);
				}
			}
		}
		$va_rep_tags = array();
		if(sizeof($va_rep_ids)){
			$vs_output = "";
			$qr_reps = caMakeSearchResult('ca_object_representations', $va_rep_ids);
			
			$va_rep_tags = $qr_reps->getRepresentationViewerHTMLBundles($po_request, array('display' => 'detail', 'object_id' => $pn_object_id, 'containerID' => 'cont'));
			
			$qr_reps->seek(0);
			while($qr_reps->nextHit()) {
				$vn_rep_id = $qr_reps->get('representation_id');
				$vs_tool_bar = caRepToolbar($po_request, $qr_reps, $pn_object_id);
				$va_rep_tags[$vn_rep_id] = "<div class='repViewerContCont'><div id='cont{$vn_rep_id}' class='repViewerCont'>".$va_rep_tags[$vn_rep_id].$vs_tool_bar."</div></div>";
			}
			
			if(sizeof($va_rep_ids) > 1){
				$vs_output .= '<div class="jcarousel-wrapper"><div class="jcarousel" id="repViewerCarousel"><ul>';
			}
			
			$vn_count = 0;
			$va_slide_rep_ids = array();
			foreach($va_rep_tags as $vn_rep_id => $vs_rep_tag){
				if(sizeof($va_rep_ids) > 1){
					$vs_output .= "<li id='slide".$vn_rep_id."' class='".$vn_rep_id."'>";
				}
				if ($vn_count == 0) { $vs_output .= $vs_rep_tag; }	// only load first one initially
				if(sizeof($va_rep_ids) > 1){
					$vs_output .= "</li>";
				}
				$va_slide_rep_ids[] = $vn_rep_id;
				$vn_count++;
			}
			if(sizeof($va_rep_ids) > 1){
				$vs_output .= "</ul></div><!-- end jcarousel -->
								<!-- Prev/next controls -->
								<div id='detailRepNav'><a href='#' id='detailRepNavPrev' title='"._t("Previous")."'><span class='glyphicon glyphicon-arrow-left'></span></a> <a href='#' id='detailRepNavNext' title='"._t("Next")."'><span class='glyphicon glyphicon-arrow-right'></span></a><div style='clear:both;'></div></div><!-- end detailRepNav -->
							</div><!-- end jcarousel-wrapper -->
					<script type='text/javascript'>
						jQuery(document).ready(function() {
							var caSlideRepresentationIDs = ".json_encode($va_slide_rep_ids).";
							/* width of li */
							$('.jcarousel li').width($('.jcarousel').width());
							$( window ).resize(function() { $('.jcarousel li').width($('.jcarousel').width()); });
							
							/* Carousel initialization */
							$('.jcarousel').jcarousel({
								animation: {
									duration: 0 // make changing image immediately
								},
								wrap: 'circular'
							});
					
							// make fadeIn effect
							$('.jcarousel').on('jcarousel:animate', function (event, carousel) {
								$(carousel._element.context).find('li').hide().fadeIn(500);
							}).on('jcarousel:animateend', function(event, carousel) {
								var current_rep_id = parseInt($('.jcarousel').jcarousel('first').attr('id').replace('slide', ''));
								var i = caSlideRepresentationIDs.indexOf(current_rep_id);
									
								if (!jQuery('#slide' + caSlideRepresentationIDs[i]).html()) {
									// load media via ajax
									jQuery('#slide' + caSlideRepresentationIDs[i]).html('<div style=\'margin-top: 120px; text-align: center; width: 100%;\'>Loading...</div>');
									
									jQuery('#slide' + caSlideRepresentationIDs[i]).load('".caNavUrl($po_request, '*', '*', 'GetRepresentationInfo', array('object_id' => $pn_object_id, 'representation_id' => ''))."' + caSlideRepresentationIDs[i] + '/include_tool_bar/1/display_type/detail/containerID/slide' + caSlideRepresentationIDs[i]);
								}
							});

							/* Prev control initialization */
							$('#detailRepNavPrev')
								.on('jcarouselcontrol:active', function() { $(this).removeClass('inactive'); })
								.on('jcarouselcontrol:inactive', function() { $(this).addClass('inactive'); })
								.jcarouselControl({ 
									target: '-=1',
									method: function() {
											$('.jcarousel').jcarousel('scroll', '-=1', true, function() {
												var id = $('.jcarousel').jcarousel('target').attr('class');
												$('#detailRepresentationThumbnails .".$pa_options["currentRepClass"]."').removeClass('".$pa_options["currentRepClass"]."');
												$('#detailRepresentationThumbnails #detailRepresentationThumbnail' + id).addClass('".$pa_options["currentRepClass"]."');
												$('#detailRepresentationThumbnails #detailRepresentationThumbnail' + id + ' a').addClass('".$pa_options["currentRepClass"]."');
											});
										}
								});
					
							/* Next control initialization */
							$('#detailRepNavNext')
								.on('jcarouselcontrol:active', function() { $(this).removeClass('inactive'); })
								.on('jcarouselcontrol:inactive', function() { $(this).addClass('inactive'); })
								.jcarouselControl({
									target: '+=1',
									method: function() {
											$('.jcarousel').jcarousel('scroll', '+=1', true, function() {
												var id = $('.jcarousel').jcarousel('target').attr('class');
												$('#detailRepresentationThumbnails .".$pa_options["currentRepClass"]."').removeClass('".$pa_options["currentRepClass"]."');
												$('#detailRepresentationThumbnails #detailRepresentationThumbnail' + id).addClass('".$pa_options["currentRepClass"]."');
												$('#detailRepresentationThumbnails #detailRepresentationThumbnail' + id + ' a').addClass('".$pa_options["currentRepClass"]."');
											});
										}
								});";
							if($vn_current_rep_id){	
								$vs_output .= "$('.jcarousel').jcarousel('scroll', $('#slide".$vn_current_rep_id."'));";
							}
				$vs_output .= "
						});
					</script>";
			}
			return $vs_output;

		}else{
			if(!$pa_options["dontShowPlaceholder"]){
				if(!$po_request->config->get("disable_my_collections")){
					$o_set_config = caGetSetsConfig();
					$vs_lightbox_icon = $o_set_config->get("add_to_lightbox_icon");
					if(!$vs_lightbox_icon){
						$vs_lightbox_icon = "<i class='fa fa-suitcase'></i>";
					}
					$va_lightbox_display_name = caGetSetDisplayName($o_set_config);
					$vs_lightbox_display_name = $va_lightbox_display_name["singular"];
					$vs_lightbox_display_name_plural = $va_lightbox_display_name["plural"];
					$vs_tool_bar = "<div id='detailMediaToolbar'>";
					if ($po_request->isLoggedIn()) {
						$vs_tool_bar .= " <a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($po_request, '', 'Sets', 'addItemForm', array("object_id" => $pn_object_id))."\"); return false;' title='"._t("Add item to %1", $vs_lightbox_display_name)."'>".$vs_lightbox_icon."</a>\n";
					}else{
						$vs_tool_bar .= " <a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($po_request, '', 'LoginReg', 'LoginForm')."\"); return false;' title='"._t("Login to add item to %1", $vs_lightbox_display_name)."'>".$vs_lightbox_icon."</a>\n";
					}
					$vs_tool_bar .= "</div><!-- end detailMediaToolbar -->\n";
				}
				$vs_placeholder = getPlaceholder($t_object->getTypeCode(), "placeholder_large_media_icon");
				return "<div class='detailMediaPlaceholder'>".$vs_placeholder."</div>".$vs_tool_bar;
			}
		}
	}
	# ---------------------------------------
	/*
	 * toolbar for representation - used on detail pages and in gallery
	 * t_representation = representation object
	 * object_id = rep's object_id
	 *
	 */
	function caRepToolbar($po_request, $t_representation, $pn_object_id){
		$o_set_config = caGetSetsConfig();
		$vs_lightbox_icon = $o_set_config->get("add_to_lightbox_icon");
		if(!$vs_lightbox_icon){
			$vs_lightbox_icon = "<i class='fa fa-suitcase'></i>";
		}
		$va_lightbox_display_name = caGetSetDisplayName($o_set_config);
		$vs_lightbox_display_name = $va_lightbox_display_name["singular"];
		$vs_lightbox_display_name_plural = $va_lightbox_display_name["plural"];
		$va_rep_display_info = caGetMediaDisplayInfo('detail', $t_representation->getMediaInfo('media', 'INPUT', 'MIMETYPE'));
		$va_rep_display_info['poster_frame_url'] = $t_representation->getMediaUrl('media', $va_rep_display_info['poster_frame_version']);
		
		$vs_tool_bar = "<div class='detailMediaToolbar'>";
		if(!$va_rep_display_info["no_overlay"]){
			$vs_tool_bar .= "<a href='#' class='zoomButton' onclick='caMediaPanel.showPanel(\"".caNavUrl($po_request, '', 'Detail', 'GetRepresentationInfo', array('object_id' => $pn_object_id, 'representation_id' => $t_representation->getPrimaryKey(), 'overlay' => 1))."\"); return false;' title='"._t("Zoom")."'><span class='glyphicon glyphicon-zoom-in'></span></a>\n";
		}
		if(!$po_request->config->get("disable_my_collections")){
			if ($po_request->isLoggedIn()) {
				$vs_tool_bar .= " <a href='#' class='setsButton' onclick='caMediaPanel.showPanel(\"".caNavUrl($po_request, '', 'Sets', 'addItemForm', array("object_id" => $pn_object_id))."\"); return false;' title='"._t("Add item to %1", $vs_lightbox_display_name)."'>".$vs_lightbox_icon."</a>\n";
			}else{
				$vs_tool_bar .= " <a href='#' class='setsButton' onclick='caMediaPanel.showPanel(\"".caNavUrl($po_request, '', 'LoginReg', 'LoginForm')."\"); return false;' title='"._t("Login to add item to %1", $vs_lightbox_display_name)."'>".$vs_lightbox_icon."</a>\n";
			}
		}
		if(caObjectsDisplayDownloadLink($po_request)){
			# -- get version to download configured in media_display.conf
			$va_download_display_info = caGetMediaDisplayInfo('download', $t_representation->getMediaInfo('media', 'INPUT', 'MIMETYPE'));
			$vs_download_version = $va_download_display_info['display_version'];
			$vs_tool_bar .= caNavLink($po_request, " <span class='glyphicon glyphicon-download-alt'></span>", 'dlButton', 'Detail', 'DownloadRepresentation', '', array('representation_id' => $t_representation->getPrimaryKey(), "object_id" => $pn_object_id, "download" => 1, "version" => $vs_download_version), array("title" => _t("Download")));
		}
		$vs_tool_bar .= "</div><!-- end detailMediaToolbar -->\n";
		return $vs_tool_bar;
	}
	# ---------------------------------------
	/*
	 * thumbnails for multiple representations
	 * pn_rep_id = current representation
	 * t_object = current ca_objects object
	 * options
	 *		version = media version for thumbnail (default = icon)
	 *		linkTo = viewer, detail, carousel (default = carousel)carousel slides the media rep carousel on the default object detail page to the selected rep
	 *		returnAs = list, bsCols, array	(default = list)
	 *		bsColClasses = pass the classes to assign to bs col (default = col-sm-4 col-md-3 col-lg-3)
	 *		dontShowCurrentRep = true, false (default = false)
	 *		currentRepClass = set to class name added to li and a tag for current rep (default = active)
	 *
	 */
	function caObjectRepresentationThumbnails($po_request, $pn_rep_id, $t_object, $pa_options){
		if(!$t_object || !$t_object->get("object_id")){
			return false;
		}
		if(!is_array($pa_options)){
			$pa_options = array();
		}
		# --- set defaults
		if(!$pa_options["version"]){
			$pa_options["version"] = "icon";
		}
		if(!$pa_options["linkTo"]){
			$pa_options["linkTo"] = "carousel";
		}
		if(!$pa_options["returnAs"]){
			$pa_options["returnAs"] = "list";
		}
		if(!$pa_options["bsColClasses"]){
			$pa_options["bsColClasses"] = "col-sm-4 col-md-3 col-lg-3";
		}
		if(!$pa_options["currentRepClass"]){
			$pa_options["currentRepClass"] = "active";
		}
		# --- get reps as thumbnails
		$va_reps = $t_object->getRepresentations(array($pa_options["version"]), null, array("checkAccess" => caGetUserAccessValues($po_request)));
		if(sizeof($va_reps) < 2){
			return;
		}
		$va_links = array();
		$vn_primary_id = "";
		foreach($va_reps as $vn_rep_id => $va_rep){
			$vs_class = "";
			if($va_rep["is_primary"]){
				$vn_primary_id = $vn_rep_id;
			}
			if($vn_rep_id == $pn_rep_id){
				if($pa_options["dontShowCurrentRep"]){
					continue;
				}
				$vs_class = $pa_options["currentRepClass"];
			}
			$vs_thumb = $va_rep["tags"][$pa_options["version"]];
			switch($pa_options["linkTo"]){
				case "viewer":
					$va_links[$vn_rep_id] = "<a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($po_request, '', 'Detail', 'GetRepresentationInfo', array('object_id' => $t_object->get("object_id"), 'representation_id' => $vn_rep_id, 'overlay' => 1))."\"); return false;' ".(($vs_class) ? "class='".$vs_class."'" : "").">".$vs_thumb."</a>\n";
				# -------------------------------
				case "carousel":
					$va_links[$vn_rep_id] = "<a href='#' onclick='$(\".".$pa_options["currentRepClass"]."\").removeClass(\"".$pa_options["currentRepClass"]."\"); $(this).parent().addClass(\"".$pa_options["currentRepClass"]."\"); $(this).addClass(\"".$pa_options["currentRepClass"]."\"); $(\".jcarousel\").jcarousel(\"scroll\", $(\"#slide".$vn_rep_id."\"), false); return false;' ".(($vs_class) ? "class='".$vs_class."'" : "").">".$vs_thumb."</a>\n";
				break;
				# -------------------------------
				default:
				case "detail":
					$va_links[$vn_rep_id] = caDetailLink($po_request, $vs_thumb, $vs_class, 'ca_objects', $t_object->get("object_id"), array("representation_id" => $vn_rep_id));
				break;
				# -------------------------------
			}
		}
		# --- make sure the primary rep shows up first
		$va_primary_link = array($vn_primary_id => $va_links[$vn_primary_id]);
		unset($va_links[$vn_primary_id]);
		$va_links = $va_primary_link + $va_links;
		# --- formatting
		$vs_formatted_thumbs = "";
		switch($pa_options["returnAs"]){
			case "list":
				$vs_formatted_thumbs = "<ul id='detailRepresentationThumbnails'>";
				foreach($va_links as $vn_rep_id => $vs_link){
					$vs_formatted_thumbs .= "<li id='detailRepresentationThumbnail".$vn_rep_id."'".(($vn_rep_id == $pn_rep_id) ? " class='".$pa_options["currentRepClass"]."'" : "").">".$vs_link."</li>\n";
				}
				$vs_formatted_thumbs .= "</ul>";
				return $vs_formatted_thumbs;
			break;
			# ---------------------------------
			case "bsCols":
				$vs_formatted_thumbs = "<div class='container'><div class='row' id='detailRepresentationThumbnails'>";
				foreach($va_links as $vn_rep_id => $vs_link){
					$vs_formatted_thumbs .= "<div id='detailRepresentationThumbnail".$vn_rep_id."' class='".$pa_options["bsColClasses"].(($vn_rep_id == $pn_rep_id) ? " ".$pa_options["currentRepClass"] : "")."'>".$vs_link."</div>\n";
				}
				$vs_formatted_thumbs .= "</div></div>\n";
				return $vs_formatted_thumbs;
			break;
			# ---------------------------------
			case "array":
				return $va_links;
			break;
			# ---------------------------------
		}
	}
	# ---------------------------------------
	/*
	 * list of comments and 
	 * comment form for all detail pages
	 *
	 */
	function caDetailItemComments($po_request, $pn_item_id, $t_item, $va_comments, $va_tags){
		$vs_tmp = "";
		if(is_array($va_comments) && (sizeof($va_comments) > 0)){
			foreach($va_comments as $va_comment){
				$vs_tmp .= "<blockquote>";
				if($va_comment["media1"]){
					$vs_tmp .= '<div class="pull-right" id="commentMedia'.$va_comment["comment_id"].'">';
					$vs_tmp .= $va_comment["media1"]["tiny"]["TAG"];						
					$vs_tmp .= "</div><!-- end pullright commentMedia -->\n";
					TooltipManager::add(
						"#commentMedia".$va_comment["comment_id"], $va_comment["media1"]["large_preview"]["TAG"]
					);
				}
				if($va_comment["comment"]){
					$vs_tmp .= $va_comment["comment"];
				}				
				$vs_tmp .= "<small>".$va_comment["author"].", ".$va_comment["date"]."</small></blockquote>";
			}
		}
		if(is_array($va_tags) && sizeof($va_tags) > 0){
			$va_tag_links = array();
			foreach($va_tags as $vs_tag){
				$va_tag_links[] = caNavLink($po_request, $vs_tag, '', '', 'MultiSearch', 'Index', array('search' => $vs_tag));
			}
			$vs_tmp .= "<h2>"._t("Tags")."</h2>\n
				<div id='tags'>".implode($va_tag_links, ", ")."</div>";
		}		
		if($po_request->isLoggedIn()){
			$vs_tmp .= "<button type='button' class='btn btn-default' onclick='caMediaPanel.showPanel(\"".caNavUrl($po_request, '', 'Detail', 'CommentForm', array("tablename" => $t_item->tableName(), "item_id" => $t_item->getPrimaryKey()))."\"); return false;' >"._t("Add your tags and comment")."</button>";
		}else{
			$vs_tmp .= "<button type='button' class='btn btn-default' onclick='caMediaPanel.showPanel(\"".caNavUrl($po_request, '', 'LoginReg', 'LoginForm', array())."\"); return false;' >"._t("Login/register to comment on this object")."</button>";
		}
		return $vs_tmp;
	}
	# ---------------------------------------
	/*
	 * Returns the info for each set
	 * 
	 * options: "write_access" = false
	 *
	 */
	function caLightboxSetListItem($po_request, $t_set, $va_check_access = array(), $pa_options = array()) {
		if(!$t_set->get("set_id")){
			return false;
		}
		$vb_write_access = false;
		if($pa_options["write_access"]){
			$vb_write_access = true;
		}
		$va_set_items = caExtractValuesByUserLocale($t_set->getItems(array("user_id" => $po_request->user->get("user_id"), "thumbnailVersions" => array("iconlarge", "icon"), "checkAccess" => $va_check_access, "limit" => 5)));
		$vs_set_display = "";
		$vs_set_display .= "<div class='lbSetContainer'><div class='lbSet ".(($vb_write_access) ? "" : "readSet" )."'><div class='lbSetContent'>\n";
		if(!$vb_write_access){
			$vs_set_display .= "<div class='pull-right caption'>Read Only</div>";
		}
		$vs_set_display .= "<H5>".caNavLink($po_request, $t_set->getLabelForDisplay(), "", "", "Sets", "setDetail", array("set_id" => $t_set->get("set_id")))."</H5>";
		$va_lightbox_display_name = caGetSetDisplayName();
		$vs_lightbox_display_name = $va_lightbox_display_name["singular"];
		$vs_lightbox_display_name_plural = $va_lightbox_display_name["plural"];
		if(sizeof($va_set_items)){
			$vs_primary_image_block = "";
			$vs_secondary_image_block = "";
			$vn_i = 1;
			$t_list_items = new ca_list_items();
			foreach($va_set_items as $va_set_item){
				$t_list_items->load($va_set_item["type_id"]);
				$vs_placeholder = getPlaceholder($t_list_items->get("idno"), "placeholder_media_icon");
				if($vn_i == 1){
					# --- is the iconlarge version available?
					$vs_large_icon = "icon";
					if($va_set_item["representation_url_iconlarge"]){
						$vs_large_icon = "iconlarge";
					}
					if($va_set_item["representation_tag_".$vs_large_icon]){
						$vs_primary_image_block .= "<div class='col-sm-6'><div class='lbSetImg'>".caNavLink($po_request, $va_set_item["representation_tag_".$vs_large_icon], "", "", "Sets", "setDetail", array("set_id" => $t_set->get("set_id")))."</div><!-- end lbSetImg --></div>\n";
					}else{
						$vs_primary_image_block .= "<div class='col-sm-6'><div class='lbSetImg'>".caNavLink($po_request, "<div class='lbSetImgPlaceholder'>".$vs_placeholder."</div><!-- end lbSetImgPlaceholder -->", "", "", "Sets", "setDetail", array("set_id" => $t_set->get("set_id")))."</div><!-- end lbSetImg --></div>\n";
					}
				}else{
					if($va_set_item["representation_tag_icon"]){
						$vs_secondary_image_block .= "<div class='col-xs-3 col-sm-6 lbSetThumbCols'><div class='lbSetThumb'>".caNavLink($po_request, $va_set_item["representation_tag_icon"], "", "", "Sets", "setDetail", array("set_id" => $t_set->get("set_id")))."</div><!-- end lbSetThumb --></div>\n";
					}else{
						$vs_secondary_image_block .= "<div class='col-xs-3 col-sm-6 lbSetThumbCols'>".caNavLink($po_request, "<div class='lbSetThumbPlaceholder'>".caGetThemeGraphic($po_request,'spacer.png').$vs_placeholder."</div><!-- end lbSetThumbPlaceholder -->", "", "", "Sets", "setDetail", array("set_id" => $t_set->get("set_id")))."</div>\n";
					}
				}
				$vn_i++;
			}
			while($vn_i < 6){
				$vs_secondary_image_block .= "<div class='col-xs-3 col-sm-6 lbSetThumbCols'>".caNavLink($po_request, "<div class='lbSetThumbPlaceholder'>".caGetThemeGraphic($po_request,'spacer.png')."</div><!-- end lbSetThumbPlaceholder -->", "", "", "Sets", "setDetail", array("set_id" => $t_set->get("set_id")))."</div>";
				$vn_i++;
			}
		}else{
			$vs_primary_image_block .= "<div class='col-sm-6'><div class='lbSetImg'><div class='lbSetImgPlaceholder'>"._t("this %1 contains no items", $vs_lightbox_display_name)."</div><!-- end lbSetImgPlaceholder --></div><!-- end lbSetImg --></div>\n";
			$i = 1;
			while($vn_i < 4){
				$vs_secondary_image_block .= "<div class='col-xs-3 col-sm-6 lbSetThumbCols'><div class='lbSetThumbPlaceholder'>".caGetThemeGraphic($po_request,'spacer.png')."</div><!-- end lbSetThumbPlaceholder --></div>";
				$vn_i++;
			}
		}
		$vs_set_display .= "<div class='row'>".$vs_primary_image_block."<div class='col-sm-6'><div id='comment".$t_set->get("set_id")."' class='lbSetComment'><!-- load comments here --></div>\n<div class='lbSetThumbRowContainer'><div class='row lbSetThumbRow' id='lbSetThumbRow".$t_set->get("set_id")."'>".$vs_secondary_image_block."</div><!-- end row --></div><!-- end lbSetThumbRowContainer --></div><!-- end col --></div><!-- end row -->";
		$vs_set_display .= "</div><!-- end lbSetContent -->\n";
		$vs_set_display .= "<div class='lbSetExpandedInfo' id='lbExpandedInfo".$t_set->get("set_id")."'>\n<hr><div>created by: ".trim($t_set->get("ca_users.fname")." ".$t_set->get("ca_users.lname"))."</div>\n";
		$vs_set_display .= "<div>Num items: ".$t_set->getItemCount(array("user_id" => $po_request->user->get("user_id"), "checkAccess" => $va_check_access))."</div>\n";
		if($vb_write_access){
			$vs_set_display .= "<div class='pull-right'>".caNavLink($po_request, '<span class="glyphicon glyphicon-trash"></span>', '', '', 'Sets', 'DeleteSet', array('set_id' => $t_set->get("set_id")), array("title" => _t("Delete")))."</div>\n";
		}
		$vs_set_display .= "<div><a href='#' onclick='jQuery(\"#comment".$t_set->get("set_id")."\").load(\"".caNavUrl($po_request, '', 'Sets', 'AjaxListComments', array('item_id' => $t_set->get("set_id"), 'tablename' => 'ca_sets', 'set_id' => $t_set->get("set_id")))."\", function(){jQuery(\"#lbSetThumbRow".$t_set->get("set_id")."\").hide(); jQuery(\"#comment".$t_set->get("set_id")."\").show();}); return false;' title='"._t("Comments")."'><span class='glyphicon glyphicon-comment'></span> <small>".$t_set->getNumComments()."</small></a>";
		if($vb_write_access){
			$vs_set_display .= "&nbsp;&nbsp;&nbsp;<a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($po_request, '', 'Sets', 'setForm', array("set_id" => $t_set->get("set_id")))."\"); return false;' title='"._t("Edit Name/Description")."'><span class='glyphicon glyphicon-edit'></span></a>";
		}	
		$vs_set_display .= "</div>\n";
		$vs_set_display .= "</div><!-- end lbSetExpandedInfo --></div><!-- end lbSet --></div><!-- end lbSetContainer -->\n";
		return $vs_set_display;
	}
	# ---------------------------------------
	/*
	 * Returns placeholder No lightboxes box
	 * 
	 *
	 */
	function caLightboxSetListItemPlaceholder($po_request) {
		$va_lightbox_display_name = caGetSetDisplayName();
		$vs_lightbox_display_name = $va_lightbox_display_name["singular"];
		$vs_lightbox_display_name_plural = $va_lightbox_display_name["plural"];
		$vs_set_display = "";
		$vs_set_display .= "<div class='lbSet'><div class='lbSetContent'>\n
								<H5>"._t("Create your first %1", $vs_lightbox_display_name)."</H5>
								<div class='row'><div class='col-sm-6'><div class='lbSetImgPlaceholder'><br/><br/></div><!-- end lbSetImgPlaceholder --></div><div class='col-sm-6'>
									<div class='row lbSetThumbRow'>
										<div class='col-xs-3 col-sm-6 lbSetThumbCols'><div class='lbSetThumbPlaceholder'>".caGetThemeGraphic($po_request,'spacer.png').$vs_placeholder."</div><!-- end lbSetThumbPlaceholder --></div>
										<div class='col-xs-3 col-sm-6 lbSetThumbCols'><div class='lbSetThumbPlaceholder'>".caGetThemeGraphic($po_request,'spacer.png').$vs_placeholder."</div><!-- end lbSetThumbPlaceholder --></div>
										<div class='col-xs-3 col-sm-6 lbSetThumbCols'><div class='lbSetThumbPlaceholder'>".caGetThemeGraphic($po_request,'spacer.png').$vs_placeholder."</div><!-- end lbSetThumbPlaceholder --></div>
										<div class='col-xs-3 col-sm-6 lbSetThumbCols'><div class='lbSetThumbPlaceholder'>".caGetThemeGraphic($po_request,'spacer.png').$vs_placeholder."</div><!-- end lbSetThumbPlaceholder --></div>
									</div><!-- end row --></div><!-- end col -->
								</div><!-- end row -->
							</div><!-- end lbSetContent -->\n</div><!-- end lbSet -->\n";
		return $vs_set_display;
	}
	# ---------------------------------------
	/**
	 * Returns the info for each set item
	 * 
	 * q_result -> object search loaded with object record for this set_id
	 * options: "write_access" = false, view = list, thumbnail, caption = caption to override the configured setting, representation = rep tag to use
	 * 
	 */
	function caLightboxSetDetailItem($po_request, $q_result, $t_set_item, $pa_options = array()) {
		if(!$t_set_item->get("item_id")){
			return false;
		}
		$vb_write_access = false;
		if($pa_options["write_access"]){
			$vb_write_access = true;
		}
		$vs_view = $pa_options["view"];
		if(!in_array($vs_view, array("thumbnails", "list"))){
			$vs_view = "thumbnails";
		}
		$va_access_values = caGetUserAccessValues($po_request);
		$t_list_items = new ca_list_items($q_result->get("ca_objects.type_id"));
		$vs_placeholder = getPlaceholder($t_list_items->get("idno"), "placeholder_media_icon");
		$vs_caption = "";
		if($pa_options["caption"]){
			$vs_caption = $pa_options["caption"];
		}else{
			$o_config = caGetSetsConfig();
			$vs_caption_template = $o_config->get("caption_template");
			if($vs_caption_template){
				$vs_caption = $q_result->getWithTemplate($vs_caption_template);
			}else{
				$vs_caption = $q_result->get("ca_objects.preferred_labels.name");
			}
		}
		$vs_set_item_display = "";
		$vs_set_item_display .= "<div class='lbItem'><div class='lbItemContent'>\n";
		if($pa_options["representation"]){
			$vs_set_item_display .= caDetailLink($po_request, "<div class='lbItemImg'>".$pa_options["representation"]."</div>", '', 'ca_objects', $q_result->get("object_id"));
		}else{
			$vs_media_version = "medium";
			if($vs_view == "list"){
				$vs_media_version = "icon";
			}
			if($vs_tag = $q_result->getMediaTag('ca_object_representations.media', $vs_media_version, array("checkAccess" => $va_access_values))){
				$vs_set_item_display .= caDetailLink($po_request, "<div class='lbItemImg'>".$vs_tag."</div>", '', 'ca_objects', $q_result->get("object_id"));
			}else{
				$vs_set_item_display .= caDetailLink($po_request, "<div class='lbItemImg lbSetImgPlaceholder'>".$vs_placeholder."</div>", '', 'ca_objects', $q_result->get("object_id"));
			}
		}
		$vs_set_item_display .= "<div id='comment".$t_set_item->get("item_id")."' class='lbSetItemComment'><!-- load comments here --></div>\n";
		$vs_set_item_display .= "<div class='caption'>".$vs_caption."</div>\n";
		$vs_set_item_display .= "</div><!-- end lbItemContent -->\n";
		$vs_set_item_display .= "<div class='lbExpandedInfo' id='lbExpandedInfo".$t_set_item->get("item_id")."'>\n<hr>\n";
		if($vb_write_access){
			$vs_set_item_display .= "<div class='pull-right'><a href='#' class='lbItemDeleteButton' id='lbItemDelete".$t_set_item->get("item_id")."' title='"._t("Remove")."'><span class='glyphicon glyphicon-trash'></span></a></div>\n";
		}
		$vs_set_item_display .= "<div>".caDetailLink($po_request, "<span class='glyphicon glyphicon-file'></span>", '', 'ca_objects', $q_result->get("object_id"), "", array("title" => _t("View Item Detail")))."\n";
		$vn_rep_id = "";
		if($vn_rep_id = $q_result->get('ca_object_representations.representation_id')){
			$vs_set_item_display .= "&nbsp;<a href='#' title='"._t("Enlarge Image")."' onclick='caMediaPanel.showPanel(\"".caNavUrl($po_request, '', 'Detail', 'GetRepresentationInfo', array('object_id' => $q_result->get("object_id"), 'representation_id' => $vn_rep_id, 'overlay' => 1))."\"); return false;' ><span class='glyphicon glyphicon-zoom-in'></span></a>\n";
		}
		$vs_set_item_display .= "&nbsp;&nbsp;<a href='#' title='"._t("Comments")."' onclick='jQuery(\"#comment".$t_set_item->get("item_id")."\").load(\"".caNavUrl($po_request, '', 'Sets', 'AjaxListComments', array('item_id' => $t_set_item->get("item_id"), 'tablename' => 'ca_set_items', 'set_id' => $t_set_item->get("set_id")))."\", function(){jQuery(\"#comment".$t_set_item->get("item_id")."\").show();}); return false;'><span class='glyphicon glyphicon-comment'></span> <small>".$t_set_item->getNumComments()."</small></a></div>\n";
		$vs_set_item_display .= "</div><!-- end lbExpandedInfo --></div><!-- end lbItem -->\n";
		return $vs_set_item_display;
	}
	# ---------------------------------------
	/**
	 * Returns the info for each set item
	 * 
	 * options: "write_access" = false
	 * 
	 */
	function caLightboxSetDetailItemOld($po_request, $va_set_item = array(), $pa_options = array()) {
		$t_set_item = new ca_set_items($va_set_item["item_id"]);
		if(!$t_set_item->get("item_id")){
			return false;
		}
		$vb_write_access = false;
		if($pa_options["write_access"]){
			$vb_write_access = true;
		}
		
		$t_list_items = new ca_list_items($va_set_item["type_id"]);
		$vs_placeholder = getPlaceholder($t_list_items->get("idno"), "placeholder_media_icon");
		$vs_caption = "";
		$o_config = caGetSetsConfig();
		$vs_caption_template = $o_config->get("caption_template");
		if($vs_caption_template){
			$t_object = new ca_objects($va_set_item["row_id"]);
			$vs_caption = $t_object->getWithTemplate($vs_caption_template);
		}else{
			$vs_caption = $va_set_item["set_item_label"];
		}
		$vs_set_item_display = "";
		$vs_set_item_display .= "<div class='lbItem'><div class='lbItemContent'>\n";
		#$vs_set_item_display .= "<div class='lbItem' onmouseover='jQuery(\"#lbExpandedInfo".$t_set_item->get("item_id")."\").show();'  onmouseout='jQuery(\"#lbExpandedInfo".$t_set_item->get("item_id")."\").hide();'><div class='lbItemContent'>\n";
		if($va_set_item["representation_tag_medium"]){
			$vs_set_item_display .= caDetailLink($po_request, "<div class='lbItemImg'>".$va_set_item["representation_tag_medium"]."</div>", '', 'ca_objects', $va_set_item["row_id"]);
		}else{
			$vs_set_item_display .= caDetailLink($po_request, "<div class='lbItemImg lbSetImgPlaceholder'>".$vs_placeholder."</div>", '', 'ca_objects', $va_set_item["row_id"]);
		}
		$vs_set_item_display .= "<div id='comment".$t_set_item->get("item_id")."' class='lbSetItemComment'><!-- load comments here --></div>\n";
		$vs_set_item_display .= "<div class='caption'>".$vs_caption."</div>\n";
		$vs_set_item_display .= "</div><!-- end lbItemContent -->\n";
		$vs_set_item_display .= "<div class='lbExpandedInfo' id='lbExpandedInfo".$t_set_item->get("item_id")."'>\n<hr>\n";
		if($vb_write_access){
			$vs_set_item_display .= "<div class='pull-right'><a href='#' class='lbItemDeleteButton' id='lbItemDelete".$t_set_item->get("item_id")."' title='"._t("Remove")."'><span class='glyphicon glyphicon-trash'></span></a></div>\n";
		}
		$vs_set_item_display .= "<div>".caDetailLink($po_request, "<span class='glyphicon glyphicon-file'></span>", '', 'ca_objects', $va_set_item["row_id"], "", array("title" => _t("View Item Detail")))."\n";
		if($va_set_item["representation_id"]){
			$vs_set_item_display .= "&nbsp;<a href='#' title='"._t("Enlarge Image")."' onclick='caMediaPanel.showPanel(\"".caNavUrl($po_request, '', 'Detail', 'GetRepresentationInfo', array('object_id' => $t_set_item->get("row_id"), 'representation_id' => $va_set_item["representation_id"], 'overlay' => 1))."\"); return false;' ><span class='glyphicon glyphicon-zoom-in'></span></a>\n";
		}
		$vs_set_item_display .= "&nbsp;&nbsp;<a href='#' title='"._t("Comments")."' onclick='jQuery(\"#comment".$t_set_item->get("item_id")."\").load(\"".caNavUrl($po_request, '', 'Sets', 'AjaxListComments', array('item_id' => $t_set_item->get("item_id"), 'tablename' => 'ca_set_items', 'set_id' => $t_set_item->get("set_id")))."\", function(){jQuery(\"#comment".$t_set_item->get("item_id")."\").show();}); return false;'><span class='glyphicon glyphicon-comment'></span> <small>".$t_set_item->getNumComments()."</small></a></div>\n";
		$vs_set_item_display .= "</div><!-- end lbExpandedInfo --></div><!-- end lbItem -->\n";
		return $vs_set_item_display;
	}
	# ---------------------------------------
	/**
	 * 
	 * 
	 */
	$g_theme_detail_for_type_cache = array();
	function caGetDetailForType($pm_table, $pm_type=null, $pa_options=null) {
		global $g_theme_detail_for_type_cache;
		$vs_current_action = ($po_request = caGetOption('request', $pa_options, null)) ? $po_request->getAction() : null;
		if (isset($g_theme_detail_for_type_cache[$pm_table.'/'.$pm_type])) { return $g_theme_detail_for_type_cache[$pm_table.'/'.$pm_type.'/'.$vs_current_action]; }
		$o_config = caGetDetailConfig();
		$o_dm = Datamodel::load();
		
		$vs_preferred_detail = caGetOption('preferredDetail', $pa_options, null);
		
		if (!($vs_table = $o_dm->getTableName($pm_table))) { return null; }
		
		if ($pm_type) {
			$t_instance = $o_dm->getInstanceByTableName($vs_table, true);
			$vs_type = is_numeric($pm_type) ? $t_instance->getTypeCode($pm_type) : $pm_type;
		} else {
			$vs_type = null;
		}	
		
		$va_detail_types = $o_config->getAssoc('detailTypes');
	
		$vs_detail_type = null;
		foreach($va_detail_types as $vs_code => $va_info) {
			if ($va_info['table'] == $vs_table) {
				$va_detail_aliases = caGetOption('aliases', $va_info, array(), array('castTo' => 'array'));
				
				if (is_null($pm_type) || !is_array($va_info['restrictToTypes']) || (sizeof($va_info['restrictToTypes']) == 0) || in_array($vs_type, $va_info['restrictToTypes'])) {
					// If the code matches the current url action use that in preference to anything else
					
					// does it have an alias?
					if ($vs_preferred_detail && ($vs_code == $vs_preferred_detail)) { return $vs_preferred_detail; }
					if ($vs_preferred_detail && in_array($vs_preferred_detail, $va_detail_aliases)) { return $vs_preferred_detail; }
					if ($vs_current_action && ($vs_code == $vs_current_action)) { return $vs_code; }
					if ($vs_current_action && in_array($vs_current_action, $va_detail_aliases)) { return $vs_current_action; }
					
					$vs_detail_type = $g_theme_detail_for_type_cache[$pm_table.'/'.$pm_type.'/'.$vs_current_action] = $g_theme_detail_for_type_cache[$vs_table.'/'.$vs_type.'/'.$vs_current_action] = $vs_code;
				}
			}
		}
		
		if (!$vs_detail_type) $g_theme_detail_for_type_cache[$pm_table.'/'.$pm_type] = $g_theme_detail_for_type_cache[$vs_table.'/'.$vs_type.'/'.$vs_current_action] = null;
		return $vs_detail_type;
	}
	# ---------------------------------------
	/**
	 * 
	 * 
	 */
	function caGetDisplayImagesForAuthorityItems($pm_table, $pa_ids, $pa_options=null) {
		$o_dm = Datamodel::load();
		if (!($t_instance = $o_dm->getInstanceByTableName($pm_table, true))) { return null; }
		
		if (method_exists($t_instance, "getPrimaryMediaForIDs")) {
			// Use directly related media if defined
			$va_media = $t_instance->getPrimaryMediaForIDs($pa_ids, array($vs_version = caGetOption('version', $pa_options, 'icon')), $pa_options);
			$va_media_by_id = array();
			foreach($va_media as $vn_id => $va_media_info) {
				if(!is_array($va_media_info)) { continue; }
				$va_media_by_id[$vn_id] = $va_media_info['tags'][$vs_version];
			}
			if(sizeof($va_media_by_id)){			
				return $va_media_by_id;
			}
		}
		
		if(!is_array($pa_options)){
			$pa_options = array();
		}
		$pa_access_values = caGetOption("checkAccess", $pa_options, array());
		$vs_access_wheres = '';
		if($pa_options['checkAccess']){
			$vs_access_wheres = " AND ca_objects.access IN (".join(",", $pa_access_values).") AND ca_object_representations.access IN (".join(",", $pa_access_values).")";
		}
		$va_path = array_keys($o_dm->getPath($vs_table = $t_instance->tableName(), "ca_objects"));
		$vs_pk = $t_instance->primaryKey();
		
		$va_params = array();
		
		$vs_linking_table = $va_path[1];
		
		
		$vs_rel_type_where = '';
		if (is_array($va_rel_types = caGetOption('relationshipTypes', $pa_options, null)) && sizeof($va_rel_types)) {
			$va_rel_types = caMakeRelationshipTypeIDList($vs_linking_table, $va_rel_types);
			if (is_array($va_rel_types) && sizeof($va_rel_types)) {
				$vs_rel_type_where = " AND ({$vs_linking_table}.type_id IN (?))";
				$va_params[] = $va_rel_types;
			}
		}
		
		if(is_array($pa_ids) && sizeof($pa_ids)) {
			$vs_id_sql = "AND {$vs_table}.{$vs_pk} IN (?)";
			$va_params[] = $pa_ids;
		}
		
		$vs_sql = "SELECT ca_object_representations.media, {$vs_table}.{$vs_pk}
			FROM {$vs_table}
			INNER JOIN {$vs_linking_table} ON {$vs_linking_table}.{$vs_pk} = {$vs_table}.{$vs_pk}
			INNER JOIN ca_objects ON ca_objects.object_id = {$vs_linking_table}.object_id
			INNER JOIN ca_objects_x_object_representations ON ca_objects_x_object_representations.object_id = ca_objects.object_id
			INNER JOIN ca_object_representations ON ca_object_representations.representation_id = ca_objects_x_object_representations.representation_id
			WHERE
				ca_objects_x_object_representations.is_primary = 1 {$vs_rel_type_where} {$vs_id_sql}
			GROUP BY {$vs_table}.{$vs_pk}
		";
		
		$o_db = $t_instance->getDb();
		
		$qr_res = $o_db->query($vs_sql, $va_params);
		$va_res = array();
		while($qr_res->nextRow()) {
			$va_res[$qr_res->get($vs_pk)] = $qr_res->getMediaTag("media", caGetOption('version', $pa_options, 'icon'));
		}
		return $va_res;
	}
	# ---------------------------------------
	/**
	 * class -> class name of <ul>
	 * 
	 */
	function caGetGallerySetsAsList($po_request, $vs_class, $pa_options=null){
		$o_config = caGetGalleryConfig();
		$va_access_values = caGetUserAccessValues($po_request);
 		$t_list = new ca_lists();
 		$vn_gallery_set_type_id = $t_list->getItemIDFromList('set_types', $o_config->get('gallery_set_type')); 			
 		$vs_set_list = "";
		if($vn_gallery_set_type_id){
			$t_set = new ca_sets();
			$va_sets = caExtractValuesByUserLocale($t_set->getSets(array('table' => 'ca_objects', 'checkAccess' => $va_access_values, 'setType' => $vn_gallery_set_type_id)));
			
			$vn_limit = caGetOption('limit', $pa_options, 100);
			if(sizeof($va_sets)){
				$vs_set_list = "<ul".(($vs_class) ? " class='".$vs_class."'" : "").">\n";
				
				$vn_c = 0;
				foreach($va_sets as $vn_set_id => $va_set){
					$vs_set_list .= "<li>".caNavLink($po_request, $va_set["name"], "", "", "Gallery", $vn_set_id)."</li>\n";
					$vn_c++;
					
					if ($vn_c >= $vn_limit) { break; }
				}
				$vs_set_list .= "</ul>\n";
			}
		}
		return $vs_set_list;
	}
	# ---------------------------------------
	function getPlaceholder($vs_type_code, $vs_placeholder_type = "placeholder_media_icon"){
		$o_config = caGetIconsConfig();
		$va_placeholders_by_type = $o_config->getAssoc("placeholders");
		$vs_placeholder = $o_config->get($vs_placeholder_type);
		if(is_array($va_placeholders_by_type[$vs_type_code])){
			$vs_placeholder = $va_placeholders_by_type[$vs_type_code][$vs_placeholder_type];
		}
		if(!$vs_placeholder){
			if($vs_placeholder_type == "placeholder_media_icon"){
				$vs_placeholder = "<i class='fa fa-picture-o fa-2x'></i>";
			}else{
				$vs_placeholder = "<i class='fa fa-picture-o fa-5x'></i>";
			}
		}
		return $vs_placeholder;
	}
	# ---------------------------------------
	function caGetSetDisplayName($o_set_config = null){
		if(!$o_set_config){
			$o_set_config = caGetSetsConfig();
		}
		$vs_set_display_name = $o_set_config->get("set_display_name");
		if(!$vs_set_display_name){
			$vs_set_display_name = _t("lightbox");
		}
		$vs_set_display_name_plural = $o_set_config->get("set_display_name_plural");
		if(!$vs_set_display_name_plural){
			$vs_set_display_name_plural = _t("lightboxes");
		}
		$vs_set_section_heading = $o_set_config->get("set_section_heading");
		if(!$vs_set_section_heading){
			$vs_set_section_heading = _t("lightboxes");
		}
		return array("singular" => $vs_set_display_name, "plural" => $vs_set_display_name_plural, "section_heading" => $vs_set_section_heading);
	}
	# ---------------------------------------
