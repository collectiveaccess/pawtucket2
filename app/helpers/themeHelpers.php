<?php
/** ---------------------------------------------------------------------
 * app/helpers/configurationHelpers.php : utility functions for setting database-stored configuration values
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
	 */
	function caObjectDetailMediaOld($o_request, $pn_object_id, $t_representation, $t_object, $pa_options=null) {
		$va_access_values = caGetUserAccessValues($o_request);
		if ($t_representation && (!sizeof($va_access_values) || in_array($t_representation->get('access'), $va_access_values))) { 		// check rep access
			$va_rep_display_info = caGetMediaDisplayInfo('detail', $t_representation->getMediaInfo('media', 'INPUT', 'MIMETYPE'));
			$va_rep_display_info['poster_frame_url'] = $t_representation->getMediaUrl('media', $va_rep_display_info['poster_frame_version']);
		
			$va_opts = array('display' => 'detail', 'object_id' => $pn_object_id, 'containerID' => 'cont');
			$vs_tool_bar = "<div id='detailMediaToolbar'>";
			if(!$va_rep_display_info["no_overlay"]){
				$vs_tool_bar .= "<a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($o_request, '', 'Detail', 'GetRepresentationInfo', array('object_id' => $pn_object_id, 'representation_id' => $t_representation->getPrimaryKey(), 'overlay' => 1))."\"); return false;' title='"._t("Zoom")."'><span class='glyphicon glyphicon-zoom-in'></span></a>\n";
			}
			if(!$o_request->config->get("disable_my_collections")){
				if ($o_request->isLoggedIn()) {
					$vs_tool_bar .= " <a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($o_request, '', 'Sets', 'addItemForm', array("object_id" => $pn_object_id))."\"); return false;' title='"._t("Add item to lightbox")."'><span class='glyphicon glyphicon-folder-open'></span></a>\n";
				}else{
					$vs_tool_bar .= " <a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($o_request, '', 'LoginReg', 'LoginForm')."\"); return false;' title='"._t("Login to add item to lightbox")."'><span class='glyphicon glyphicon-folder-open'></span></a>\n";
				}
			}
			if(caObjectsDisplayDownloadLink($o_request)){
				# -- get version to download configured in media_display.conf
				$va_download_display_info = caGetMediaDisplayInfo('download', $t_representation->getMediaInfo('media', 'INPUT', 'MIMETYPE'));
				$vs_download_version = $va_download_display_info['display_version'];
				$vs_tool_bar .= caNavLink($o_request, " <span class='glyphicon glyphicon-download-alt'></span>", '', 'Detail', 'DownloadRepresentation', '', array('representation_id' => $t_representation->getPrimaryKey(), "object_id" => $pn_object_id, "download" => 1, "version" => $vs_download_version), array("title" => _t("Download")));
			}
			$vs_tool_bar .= "</div><!-- end detailMediaToolbar -->\n";
			return "<div id='cont' class='repViewerCont'>".$t_representation->getRepresentationViewerHTMLBundle($o_request, $va_opts)."</div>".$vs_tool_bar;
			
		}else{
			if(!$o_request->config->get("disable_my_collections")){
				$vs_tool_bar = "<div id='detailMediaToolbar'>";
				if ($o_request->isLoggedIn()) {
					$vs_tool_bar .= " <a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($o_request, '', 'Sets', 'addItemForm', array("object_id" => $pn_object_id))."\"); return false;' title='"._t("Add item to lightbox")."'><span class='glyphicon glyphicon-folder-open'></span></a>\n";
				}else{
					$vs_tool_bar .= " <a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($o_request, '', 'LoginReg', 'LoginForm')."\"); return false;' title='"._t("Login to add item to lightbox")."'><span class='glyphicon glyphicon-folder-open'></span></a>\n";
				}
				$vs_tool_bar .= "</div><!-- end detailMediaToolbar -->\n";
			}
			$o_config = caGetDetailConfig();
			if(!($vs_placeholder = $o_config->get("placeholder_large_media_icon"))){
				$vs_placeholder = "<i class='fa fa-picture-o fa-5x'></i>";
			}
			return "<div class='detailMediaPlaceholder'>".$vs_placeholder."</div>".$vs_tool_bar;
		}
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
	function caObjectDetailMedia($o_request, $pn_object_id, $t_representation, $t_object, $pa_options=null) {
		if(!is_array($pa_options)){
			$pa_options = array();
		}
		if(!$va_options["currentRepClass"]){
			$va_options["currentRepClass"] = "active";
		}
		$va_access_values = caGetUserAccessValues($o_request);
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
			$vn_primary_id = array_search("1", $va_rep_ids);
			unset($va_rep_ids[$vn_primary_id]);
			$va_rep_ids = array_merge(array($vn_primary_id), array_keys($va_rep_ids));
		}
		$o_set_config = caGetSetsConfig();
		$vs_lightbox_icon = $o_set_config->get("add_to_lightbox_icon");
		if(!$vs_lightbox_icon){
			$vs_lightbox_icon = "<i class='fa fa-suitcase'></i>";
		}
		$va_rep_tags = array();
		if(sizeof($va_rep_ids)){
			$vs_output = "";
			foreach($va_rep_ids as $vn_rep_id){
				$t_representation->load($vn_rep_id);
				$va_rep_display_info = caGetMediaDisplayInfo('detail', $t_representation->getMediaInfo('media', 'INPUT', 'MIMETYPE'));
				$va_rep_display_info['poster_frame_url'] = $t_representation->getMediaUrl('media', $va_rep_display_info['poster_frame_version']);
				
				$va_opts = array('display' => 'detail', 'object_id' => $pn_object_id, 'containerID' => 'cont'.$vn_rep_id);
				$vs_tool_bar = "<div class='detailMediaToolbar'>";
				if(!$va_rep_display_info["no_overlay"]){
					$vs_tool_bar .= "<a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($o_request, '', 'Detail', 'GetRepresentationInfo', array('object_id' => $pn_object_id, 'representation_id' => $t_representation->getPrimaryKey(), 'overlay' => 1))."\"); return false;' title='"._t("Zoom")."'><span class='glyphicon glyphicon-zoom-in'></span></a>\n";
				}
				if(!$o_request->config->get("disable_my_collections")){
					if ($o_request->isLoggedIn()) {
						$vs_tool_bar .= " <a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($o_request, '', 'Sets', 'addItemForm', array("object_id" => $pn_object_id))."\"); return false;' title='"._t("Add item to lightbox")."'>".$vs_lightbox_icon."</a>\n";
					}else{
						$vs_tool_bar .= " <a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($o_request, '', 'LoginReg', 'LoginForm')."\"); return false;' title='"._t("Login to add item to lightbox")."'>".$vs_lightbox_icon."</a>\n";
					}
				}
				if(caObjectsDisplayDownloadLink($o_request)){
					# -- get version to download configured in media_display.conf
					$va_download_display_info = caGetMediaDisplayInfo('download', $t_representation->getMediaInfo('media', 'INPUT', 'MIMETYPE'));
					$vs_download_version = $va_download_display_info['display_version'];
					$vs_tool_bar .= caNavLink($o_request, " <span class='glyphicon glyphicon-download-alt'></span>", '', 'Detail', 'DownloadRepresentation', '', array('representation_id' => $t_representation->getPrimaryKey(), "object_id" => $pn_object_id, "download" => 1, "version" => $vs_download_version), array("title" => _t("Download")));
				}
				$vs_tool_bar .= "</div><!-- end detailMediaToolbar -->\n";
				$va_rep_tags[$vn_rep_id] = "<div class='repViewerContCont'><div id='cont".$vn_rep_id."' class='repViewerCont'>".$t_representation->getRepresentationViewerHTMLBundle($o_request, $va_opts).$vs_tool_bar."</div></div>";			
			}
			if(sizeof($va_rep_ids) > 1){
				$vs_output .= '<div class="jcarousel-wrapper"><div class="jcarousel" id="repViewerCarousel"><ul>';
			}
			foreach($va_rep_tags as $vn_rep_id => $vs_rep_tag){
				if(sizeof($va_rep_ids) > 1){
					$vs_output .= "<li id='slide".$vn_rep_id."' class='".$vn_rep_id."'>";
				}
				$vs_output .= $vs_rep_tag;
				if(sizeof($va_rep_ids) > 1){
					$vs_output .= "</li>";
				}
			}
			if(sizeof($va_rep_ids) > 1){
				$vs_output .= "</ul></div><!-- end jcarousel -->
								<!-- Prev/next controls -->
								<div id='detailRepNav'><a href='#' id='detailRepNavPrev' title='"._t("Previous")."'><span class='glyphicon glyphicon-arrow-left'></span></a> <a href='#' id='detailRepNavNext' title='"._t("Next")."'><span class='glyphicon glyphicon-arrow-right'></span></a></div>
							</div><!-- end jcarousel-wrapper -->
					<script type='text/javascript'>
						jQuery(document).ready(function() {
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
								$(carousel._element.context).find('li').hide().fadeIn(1000);
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
												$('#detailRepresentationThumbnails .".$va_options["currentRepClass"]."').removeClass('".$va_options["currentRepClass"]."');
												$('#detailRepresentationThumbnails #detailRepresentationThumbnail' + id).addClass('".$va_options["currentRepClass"]."');
												$('#detailRepresentationThumbnails #detailRepresentationThumbnail' + id + ' a').addClass('".$va_options["currentRepClass"]."');
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
												$('#detailRepresentationThumbnails .".$va_options["currentRepClass"]."').removeClass('".$va_options["currentRepClass"]."');
												$('#detailRepresentationThumbnails #detailRepresentationThumbnail' + id).addClass('".$va_options["currentRepClass"]."');
												$('#detailRepresentationThumbnails #detailRepresentationThumbnail' + id + ' a').addClass('".$va_options["currentRepClass"]."');
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
				if(!$o_request->config->get("disable_my_collections")){
					$vs_tool_bar = "<div id='detailMediaToolbar'>";
					if ($o_request->isLoggedIn()) {
						$vs_tool_bar .= " <a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($o_request, '', 'Sets', 'addItemForm', array("object_id" => $pn_object_id))."\"); return false;' title='"._t("Add item to lightbox")."'>".$vs_lightbox_icon."</a>\n";
					}else{
						$vs_tool_bar .= " <a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($o_request, '', 'LoginReg', 'LoginForm')."\"); return false;' title='"._t("Login to add item to lightbox")."'>".$vs_lightbox_icon."</a>\n";
					}
					$vs_tool_bar .= "</div><!-- end detailMediaToolbar -->\n";
				}
				$o_config = caGetDetailConfig();
				if(!($vs_placeholder = $o_config->get("placeholder_large_media_icon"))){
					$vs_placeholder = "<i class='fa fa-picture-o fa-5x'></i>";
				}
				return "<div class='detailMediaPlaceholder'>".$vs_placeholder."</div>".$vs_tool_bar;
			}
		}
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
	function caObjectRepresentationThumbnails($o_request, $pn_rep_id, $t_object, $va_options){
		if(!$t_object || !$t_object->get("object_id")){
			return false;
		}
		if(!is_array($va_options)){
			$va_options = array();
		}
		# --- set defaults
		if(!$va_options["version"]){
			$va_options["version"] = "icon";
		}
		if(!$va_options["linkTo"]){
			$va_options["linkTo"] = "carousel";
		}
		if(!$va_options["returnAs"]){
			$va_options["returnAs"] = "list";
		}
		if(!$va_options["bsColClasses"]){
			$va_options["bsColClasses"] = "col-sm-4 col-md-3 col-lg-3";
		}
		if(!$va_options["currentRepClass"]){
			$va_options["currentRepClass"] = "active";
		}
		# --- get reps as thumbnails
		$va_reps = $t_object->getRepresentations(array($va_options["version"]), null, array("checkAccess" => caGetUserAccessValues($o_request)));
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
				if($va_options["dontShowCurrentRep"]){
					continue;
				}
				$vs_class = $va_options["currentRepClass"];
			}
			$vs_thumb = $va_rep["tags"][$va_options["version"]];
			switch($va_options["linkTo"]){
				case "viewer":
					$va_links[$vn_rep_id] = "<a href='#' onclick='caMediaPanel.showPanel(\"".caNavUrl($o_request, '', 'Detail', 'GetRepresentationInfo', array('object_id' => $t_object->get("object_id"), 'representation_id' => $vn_rep_id, 'overlay' => 1))."\"); return false;' ".(($vs_class) ? "class='".$vs_class."'" : "").">".$vs_thumb."</a>\n";
				# -------------------------------
				case "carousel":
					$va_links[$vn_rep_id] = "<a href='#' onclick='$(\".".$va_options["currentRepClass"]."\").removeClass(\"".$va_options["currentRepClass"]."\"); $(this).parent().addClass(\"".$va_options["currentRepClass"]."\"); $(this).addClass(\"".$va_options["currentRepClass"]."\"); $(\".jcarousel\").jcarousel(\"scroll\", $(\"#slide".$vn_rep_id."\"), false); return false;' ".(($vs_class) ? "class='".$vs_class."'" : "").">".$vs_thumb."</a>\n";
				break;
				# -------------------------------
				default:
				case "detail":
					$va_links[$vn_rep_id] = caDetailLink($o_request, $vs_thumb, $vs_class, 'ca_objects', $t_object->get("object_id"), array("representation_id" => $vn_rep_id));
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
		switch($va_options["returnAs"]){
			case "list":
				$vs_formatted_thumbs = "<ul id='detailRepresentationThumbnails'>";
				foreach($va_links as $vn_rep_id => $vs_link){
					$vs_formatted_thumbs .= "<li id='detailRepresentationThumbnail".$vn_rep_id."'".(($vn_rep_id == $pn_rep_id) ? " class='".$va_options["currentRepClass"]."'" : "").">".$vs_link."</li>\n";
				}
				$vs_formatted_thumbs .= "</ul>";
				return $vs_formatted_thumbs;
			break;
			# ---------------------------------
			case "bsCols":
				$vs_formatted_thumbs = "<div class='row' id='detailRepresentationThumbnails'>";
				foreach($va_links as $vn_rep_id => $vs_link){
					$vs_formatted_thumbs .= "<div id='detailRepresentationThumbnail".$vn_rep_id."' class='".$va_options["bsColClasses"].(($vn_rep_id == $pn_rep_id) ? " ".$va_options["currentRepClass"] : "")."'>".$vs_link."</div>\n";
				}
				$vs_formatted_thumbs .= "</div>\n";
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
	function caDetailItemComments($o_request, $pn_item_id, $t_item, $va_comments, $va_tags){
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
				$va_tag_links[] = caNavLink($o_request, $vs_tag, '', '', 'MultiSearch', 'Index', array('search' => $vs_tag));
			}
			$vs_tmp .= "<h2>"._t("Tags")."</h2>\n
				<div id='tags'>".implode($va_tag_links, ", ")."</div>";
		}		
		if($o_request->isLoggedIn()){
			$vs_tmp .= "<button type='button' class='btn btn-default' onclick='caMediaPanel.showPanel(\"".caNavUrl($o_request, '', 'Detail', 'CommentForm', array("tablename" => $t_item->tableName(), "item_id" => $t_item->getPrimaryKey()))."\"); return false;' >"._t("Add your tags and comment")."</button>";
		}else{
			$vs_tmp .= "<button type='button' class='btn btn-default' onclick='caMediaPanel.showPanel(\"".caNavUrl($o_request, '', 'LoginReg', 'LoginForm', array())."\"); return false;' >"._t("Login/register to comment on this object")."</button>";
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
	function caLightboxSetListItem($o_request, $t_set, $va_check_access = array(), $va_options = array()) {
		if(!$t_set->get("set_id")){
			return false;
		}
		$vb_write_access = false;
		if($va_options["write_access"]){
			$vb_write_access = true;
		}
		$o_config = caGetSetsConfig();
		if(!($vs_placeholder = $o_config->get("placeholder_media_icon"))){
			$vs_placeholder = "<i class='fa fa-picture-o fa-2x'></i>";
		}
		$va_set_items = caExtractValuesByUserLocale($t_set->getItems(array("user_id" => $o_request->user->get("user_id"), "thumbnailVersions" => array("medium", "icon"), "checkAccess" => $va_check_access, "limit" => 5)));
		$vs_set_display = "";
		$vs_set_display .= "<div class='lbSet' onmouseover='jQuery(\"#lbExpandedInfo".$t_set->get("set_id")."\").show();'  onmouseout='jQuery(\"#lbExpandedInfo".$t_set->get("set_id")."\").hide();'><div class='lbSetContent'>\n";
		$vs_set_display .= "<H5>".caNavLink($o_request, $t_set->getLabelForDisplay(), "", "", "Sets", "setDetail", array("set_id" => $t_set->get("set_id")))."</H5>";
		if(sizeof($va_set_items)){
			$vs_primary_image_block = "";
			$vs_secondary_image_block = "";
			$vn_i = 1;
			foreach($va_set_items as $va_set_item){
				if($vn_i == 1){
					if($va_set_item["representation_tag_medium"]){
						$vs_primary_image_block .= "<div class='col-sm-6'><div class='lbSetImg'>".caNavLink($o_request, $va_set_item["representation_tag_medium"], "", "", "Sets", "setDetail", array("set_id" => $t_set->get("set_id")))."</div><!-- end lbSetImg --></div>\n";
					}else{
						$vs_primary_image_block .= "<div class='col-sm-6'><div class='lbSetImg'>".caNavLink($o_request, "<div class='lbSetImgPlaceholder'>".$vs_placeholder."</div><!-- end lbSetImgPlaceholder -->", "", "", "Sets", "setDetail", array("set_id" => $t_set->get("set_id")))."</div><!-- end lbSetImg --></div>\n";
					}
				}else{
					if($va_set_item["representation_tag_icon"]){
						$vs_secondary_image_block .= "<div class='col-xs-3 col-sm-6 lbSetThumbCols' ".(($vn_i == 4) ? "style='clear:left;'" : "")."><div class='lbSetThumb'>".caNavLink($o_request, $va_set_item["representation_tag_icon"], "", "", "Sets", "setDetail", array("set_id" => $t_set->get("set_id")))."</div><!-- end lbSetThumb --></div>\n";
					}else{
						$vs_secondary_image_block .= "<div class='col-xs-3 col-sm-6 lbSetThumbCols' ".(($vn_i == 4) ? "style='clear:left;'" : "").">".caNavLink($o_request, "<div class='lbSetThumbPlaceholder'>".$vs_placeholder."</div><!-- end lbSetThumbPlaceholder -->", "", "", "Sets", "setDetail", array("set_id" => $t_set->get("set_id")))."</div>\n";
					}
				}
				$vn_i++;
			}
			while($vn_i < 6){
				$vs_secondary_image_block .= "<div class='col-xs-3 col-sm-6 lbSetThumbCols'>".caNavLink($o_request, "<div class='lbSetThumbPlaceholder'></div><!-- end lbSetThumbPlaceholder -->", "", "", "Sets", "setDetail", array("set_id" => $t_set->get("set_id")))."</div>";
				$vn_i++;
			}
		}else{
			$vs_primary_image_block = "<div class='col-sm-6'><div class='lbSetImgPlaceholder'>"._t("Search/browse to add<br/>items to this lightbox")."</div><!-- end lbSetImgPlaceholder --></div>";
			$vs_secondary_image_block = "<div class='col-xs-3 col-sm-6 lbSetThumbCols'><div class='lbSetThumbPlaceholder'></div><!-- end lbSetThumbPlaceholder --></div><div class='col-xs-3 col-sm-6 lbSetThumbCols'><div class='lbSetThumbPlaceholder'></div><!-- end lbSetThumbPlaceholder --></div><div class='col-xs-3 col-sm-6 lbSetThumbCols'><div class='lbSetThumbPlaceholder'></div><!-- end lbSetThumbPlaceholder --></div><div class='col-xs-3 col-sm-6 lbSetThumbCols'><div class='lbSetThumbPlaceholder'></div><!-- end lbSetThumbPlaceholder --></div>";
		}
		$vs_set_display .= "<div class='row'>".$vs_primary_image_block."<div class='col-sm-6'><div id='comment".$t_set->get("set_id")."' class='lbSetComment'><!-- load comments here --></div>\n<div class='row lbSetThumbRow' id='lbSetThumbRow".$t_set->get("set_id")."'>".$vs_secondary_image_block."</div><!-- end row --></div><!-- end col --></div><!-- end row -->";
		$vs_set_display .= "</div><!-- end lbSetContent -->\n";
		$vs_set_display .= "<div class='lbSetExpandedInfo' id='lbExpandedInfo".$t_set->get("set_id")."'>\n<hr><div>created by: ".trim($t_set->get("ca_users.fname")." ".$t_set->get("ca_users.lname"))."</div>\n";
		$vs_set_display .= "<div>Num items: ".$t_set->getItemCount(array("user_id" => $o_request->user->get("user_id"), "checkAccess" => $va_check_access))."</div>\n";
		if($vb_write_access){
			$vs_set_display .= "<div class='pull-right'>".caNavLink($o_request, '<span class="glyphicon glyphicon-remove"></span>', '', '', 'Sets', 'DeleteSet', array('set_id' => $t_set->get("set_id")), array("title" => _t("Delete")))."</div>\n";
		}
		$vs_set_display .= "<div><a href='#' onclick='jQuery(\"#comment".$t_set->get("set_id")."\").load(\"".caNavUrl($o_request, '', 'Sets', 'AjaxListComments', array('item_id' => $t_set->get("set_id"), 'tablename' => 'ca_sets', 'set_id' => $t_set->get("set_id")))."\", function(){jQuery(\"#lbSetThumbRow".$t_set->get("set_id")."\").hide(); jQuery(\"#comment".$t_set->get("set_id")."\").show();}); return false;' title='"._t("Comments")."'><span class='glyphicon glyphicon-comment'></span> <small>".$t_set->getNumComments()."</small></a></div>\n";
		$vs_set_display .= "</div><!-- end lbSetExpandedInfo --></div><!-- end lbSet -->\n";
		return $vs_set_display;
	}
	# ---------------------------------------
	/**
	 * Returns the info for each set item
	 * 
	 * options: "write_access" = false
	 * 
	 */
	function caLightboxSetDetailItem($o_request, $va_set_item = array(), $va_options = array()) {
		$t_set_item = new ca_set_items($va_set_item["item_id"]);
		if(!$t_set_item->get("item_id")){
			return false;
		}
		$vb_write_access = false;
		if($va_options["write_access"]){
			$vb_write_access = true;
		}
		$o_config = caGetSetsConfig();
		if(!($vs_placeholder = $o_config->get("placeholder_media_icon"))){
			$vs_placeholder = "<i class='fa fa-picture-o fa-2x'></i>";
		}
		$vs_caption = "";
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
			$vs_set_item_display .= caDetailLink($o_request, "<div class='lbItemImg'>".$va_set_item["representation_tag_medium"]."</div>", '', 'ca_objects', $va_set_item["row_id"]);
		}else{
			$vs_set_item_display .= caDetailLink($o_request, "<div class='lbItemImg lbSetImgPlaceholder'>".$vs_placeholder."</div>", '', 'ca_objects', $va_set_item["row_id"]);
		}
		$vs_set_item_display .= "<div id='comment".$t_set_item->get("item_id")."' class='lbSetItemComment'><!-- load comments here --></div>\n";
		$vs_set_item_display .= "<div>".$vs_caption."</div>\n";
		$vs_set_item_display .= "</div><!-- end lbItemContent -->\n";
		$vs_set_item_display .= "<div class='lbExpandedInfo' id='lbExpandedInfo".$t_set_item->get("item_id")."'>\n<hr>\n";
		if($vb_write_access){
			$vs_set_item_display .= "<div class='pull-right'><a href='#' class='lbItemDeleteButton' id='lbItemDelete".$t_set_item->get("item_id")."' title='"._t("Remove")."'><span class='glyphicon glyphicon-remove'></span></a></div>\n";
		}
		$vs_set_item_display .= "<div>".caDetailLink($o_request, "<span class='glyphicon glyphicon-file'></span>", '', 'ca_objects', $va_set_item["row_id"], "", array("title" => _t("View Item Detail")))."\n";
		if($va_set_item["representation_id"]){
			$vs_set_item_display .= "&nbsp;<a href='#' title='"._t("Enlarge Image")."' onclick='caMediaPanel.showPanel(\"".caNavUrl($o_request, '', 'Detail', 'GetRepresentationInfo', array('object_id' => $t_set_item->get("row_id"), 'representation_id' => $va_set_item["representation_id"], 'overlay' => 1))."\"); return false;' ><span class='glyphicon glyphicon-zoom-in'></span></a>\n";
		}
		$vs_set_item_display .= "&nbsp;&nbsp;<a href='#' title='"._t("Comments")."' onclick='jQuery(\"#comment".$t_set_item->get("item_id")."\").load(\"".caNavUrl($o_request, '', 'Sets', 'AjaxListComments', array('item_id' => $t_set_item->get("item_id"), 'tablename' => 'ca_set_items', 'set_id' => $t_set_item->get("set_id")))."\", function(){jQuery(\"#comment".$t_set_item->get("item_id")."\").show();}); return false;'><span class='glyphicon glyphicon-comment'></span> <small>".$t_set_item->getNumComments()."</small></a></div>\n";
		$vs_set_item_display .= "</div><!-- end lbExpandedInfo --></div><!-- end lbItem -->\n";
		return $vs_set_item_display;
	}
	# ---------------------------------------
	/**
	 * 
	 * 
	 */
	$g_theme_detail_for_type_cache = array();
	function caGetDetailForType($pm_table, $pm_type=null) {
		global $g_theme_detail_for_type_cache;
		if (isset($g_theme_detail_for_type_cache[$pm_table.'/'.$pm_type])) { return $g_theme_detail_for_type_cache[$pm_table.'/'.$pm_type]; }
		$o_config = caGetDetailConfig();
		$o_dm = Datamodel::load();
		
		if (!($vs_table = $o_dm->getTableName($pm_table))) { return null; }
		
		if ($pm_type) {
			$t_instance = $o_dm->getInstanceByTableName($vs_table, true);
			$vs_type = is_numeric($pm_type) ? $t_instance->getTypeCode($pm_type) : $pm_type;
		} else {
			$vs_type = null;
		}	
		
		$va_detail_types = $o_config->getAssoc('detailTypes');
	
		foreach($va_detail_types as $vs_code => $va_info) {
			if ($va_info['table'] == $vs_table) {
				if (is_null($pm_type) || !is_array($va_info['restrictToTypes']) || (sizeof($va_info['restrictToTypes']) == 0) || in_array($vs_type, $va_info['restrictToTypes'])) {
					return $g_theme_detail_for_type_cache[$pm_table.'/'.$pm_type] = $g_theme_detail_for_type_cache[$vs_table.'/'.$vs_type] = $vs_code;
				}
			}
		}
		
		return $g_theme_detail_for_type_cache[$pm_table.'/'.$pm_type] = $g_theme_detail_for_type_cache[$vs_table.'/'.$vs_type] = null;
	}
	# ---------------------------------------
	/**
	 * 
	 * 
	 */
	function caGetDisplayImagesForAuthorityItems($pm_table, $pa_ids, $pa_options=null) {
		$o_dm = Datamodel::load();
		if (!($t_instance = $o_dm->getInstanceByTableName($pm_table, true))) { return null; }
		
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
		
		$vs_sql = "SELECT ca_object_representations.media, {$vs_table}.{$vs_pk}
			FROM {$vs_table}
			INNER JOIN {$vs_linking_table} ON {$vs_linking_table}.{$vs_pk} = {$vs_table}.{$vs_pk}
			INNER JOIN ca_objects ON ca_objects.object_id = {$vs_linking_table}.object_id
			INNER JOIN ca_objects_x_object_representations ON ca_objects_x_object_representations.object_id = ca_objects.object_id
			INNER JOIN ca_object_representations ON ca_object_representations.representation_id = ca_objects_x_object_representations.representation_id
			WHERE
				ca_objects_x_object_representations.is_primary = 1 {$vs_rel_type_where} {$vs_access_wheres}
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
	function caGetGallerySetsAsList($o_request, $vs_class){
		$o_config = caGetGalleryConfig();
		$va_access_values = caGetUserAccessValues($o_request);
 		$t_list = new ca_lists();
 		$vn_gallery_set_type_id = $t_list->getItemIDFromList('set_types', $o_config->get('gallery_set_type')); 			
 		$vs_set_list = "";
		if($vn_gallery_set_type_id){
			$t_set = new ca_sets();
			$va_sets = caExtractValuesByUserLocale($t_set->getSets(array('table' => 'ca_objects', 'checkAccess' => $va_access_values, 'setType' => $vn_gallery_set_type_id)));
			if(sizeof($va_sets)){
				$vs_set_list = "<ul".(($vs_class) ? " class='".$vs_class."'" : "").">\n";
				foreach($va_sets as $vn_set_id => $va_set){
					$vs_set_list .= "<li>".caNavLink($o_request, $va_set["name"], "", "", "Gallery", $vn_set_id)."</li>\n";
				}
				$vs_set_list .= "</ul>\n";
			}
		}
		return $vs_set_list;
	}
	# ---------------------------------------
?>