<?php
/** ---------------------------------------------------------------------
 * app/helpers/printHelpers.php :
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2014-2019 Whirl-i-Gig
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
	require_once(__CA_LIB_DIR__."/Print/PDFRenderer.php");
	require_once(__CA_LIB_DIR__."/Print/Barcode.php");
	require_once(__CA_LIB_DIR__."/Print/phpqrcode/qrlib.php");

	global $g_print_measurement_cache;
	$g_print_measurement_cache = array();

	# ---------------------------------------
	/**
	 *
	 *
	 * @return string
	 */
	function caGetPrintTemplateDirectoryPath($ps_type) {
		$va_paths = [];
		switch($ps_type) {
			case 'results':
				if (is_dir(__CA_THEME_DIR__.'/printTemplates/results')) { $va_paths[] = __CA_THEME_DIR__.'/printTemplates/results'; }
				$va_paths[] = __CA_APP_DIR__.'/printTemplates/results';
				break;
			case 'summary':
				if (is_dir(__CA_THEME_DIR__.'/printTemplates/summary')) { $va_paths[] = __CA_THEME_DIR__.'/printTemplates/summary'; }
				$va_paths[] = __CA_APP_DIR__.'/printTemplates/summary';
				break;
			case 'labels':
				if (is_dir(__CA_THEME_DIR__.'/printTemplates/labels')) { $va_paths[] = __CA_THEME_DIR__.'/printTemplates/labels'; } 
				$va_paths[] = __CA_APP_DIR__.'/printTemplates/labels';
				break;
			case 'bundles':
				if(is_dir(__CA_THEME_DIR__.'/printTemplates/bundles')) { $va_paths[] = __CA_THEME_DIR__.'/printTemplates/bundles'; }
				$va_paths[] = __CA_APP_DIR__.'/printTemplates/bundles';
				break;
			case 'sets':
				if(is_dir(__CA_THEME_DIR__.'/printTemplates/sets')) { $va_paths[] = __CA_THEME_DIR__.'/printTemplates/sets'; }
				$va_paths[] = __CA_APP_DIR__.'/printTemplates/sets';
				break;
		}
		return (sizeof($va_paths) > 0) ? $va_paths : null;
	}
	# ---------------------------------------
	/**
	 *
	 * @param string $ps_type
	 * @param array $pa_options Options include:
	 *		table =
	 *		type =
	 * 		elementCode =
	 *      showOnlyIn = 
	 *      restrictToTypes = 
	 *
	 * @return array
	 */
	function caGetAvailablePrintTemplates($ps_type, $pa_options=null) {
		if (!is_array($va_template_paths = caGetPrintTemplateDirectoryPath($ps_type))) { $va_template_paths = []; }
		
		$restrict_to_types = [];
		if ($vs_tablename = caGetOption('table', $pa_options, null)) {
            if(($restrict_to_types = caGetOption('restrictToTypes', $pa_options, false)) && !is_array($restrict_to_types)) {
                $restrict_to_types = [$restrict_to_types];
            }
            $restrict_to_types = caMakeTypeList($vs_tablename, $restrict_to_types);
		}
		$vs_type = caGetOption('type', $pa_options, 'page');
		$vs_element_code = caGetOption('elementCode', $pa_options, null);
		$vb_for_html_select = caGetOption('forHTMLSelect', $pa_options, false);    
        if (!is_array($va_show_only_in = caGetOption('showOnlyIn', $pa_options, null))) {
            $va_show_only_in = array_map(function($v) { return trim($v); }, explode(',', $va_show_only_in));
        }
		

		$vs_cache_key = caMakeCacheKeyFromOptions($pa_options, $ps_type);
		
		$va_templates = array();
		$vb_needs_caching = false;
		
		$va_cached_list = (ExternalCache::contains($vs_cache_key, 'PrintTemplates')) ? ExternalCache::fetch($vs_cache_key, 'PrintTemplates') : [];
			
		foreach($va_template_paths as $vs_template_path) {
			foreach(array("{$vs_template_path}", "{$vs_template_path}/local") as $vs_path) {
				if(!file_exists($vs_path)) { continue; }
		
				if (is_array($va_cached_list)) {
					$f = array_map("filemtime", glob("{$vs_template_path}/*.{php,css}", GLOB_BRACE));
					sort($f);
					$vn_template_rev = file_exists($vs_template_path) ? array_pop($f) : 0;
					
					$f = array_map("filemtime", glob("{$vs_template_path}/local/*.{php,css}", GLOB_BRACE));
					sort($f);
					$vn_local_rev = file_exists("{$vs_template_path}/local") ? array_pop($f) : 0;
					
					if(
						(ExternalCache::fetch("{$vs_cache_key}_mtime", 'PrintTemplates') >= $vn_template_rev) &&
						(ExternalCache::fetch("{$vs_cache_key}_local_mtime", 'PrintTemplates') >= $vn_local_rev)
					){
						$va_templates = array_merge($va_templates, $va_cached_list);
						continue;
					}
				}

				if (is_resource($r_dir = opendir($vs_path))) {
					while (($vs_template = readdir($r_dir)) !== false) {
						if (in_array($vs_template, array(".", ".."))) { continue; }
						$vs_template_tag = pathinfo($vs_template, PATHINFO_FILENAME);
						if (is_array($va_template_info = caGetPrintTemplateDetails($ps_type, $vs_template_tag))) {
							if (caGetOption('type', $va_template_info, null) !== $vs_type)  { continue; }
							
							if (!is_array($template_restrict_to_types = caGetOption('restrictToTypes', $va_template_info, null))) { $template_restrict_to_types = []; }
							$c = (array_intersect($restrict_to_types, $template_restrict_to_types));
							
							if (
							    sizeof($restrict_to_types) && sizeof($template_restrict_to_types) && 
							    (is_array($c) && !sizeof($c)))
							{ 
							    continue; 
							}
							$va_template_show_only_in = array_filter(array_map(function($v) { return trim($v); }, explode(",", caGetOption('showOnlyIn', $va_template_info, null))), function($v) { return (bool)strlen($v);});
							if(is_array($va_show_only_in) && (sizeof($va_show_only_in) > 0) && is_array($va_template_show_only_in) && (sizeof($va_template_show_only_in) > 0) && !sizeof(array_intersect($va_template_show_only_in, $va_show_only_in))) { continue; }
                            
							if ($vs_element_code && (caGetOption('elementCode', $va_template_info, null) !== $vs_element_code)) { continue; }

							if ($vs_tablename && (!in_array($vs_tablename, $va_template_info['tables'])) && (!in_array('*', $va_template_info['tables']))) {
								continue;
							}
							if ($vs_tablename && (!in_array($vs_tablename, $va_template_info['tables'])) && (!in_array('*', $va_template_info['tables']))) {
								continue;
							}

							if (!is_dir($vs_path.'/'.$vs_template) && preg_match("/^[A-Za-z_]+[A-Za-z0-9_]*$/", $vs_template_tag)) {
								if ($vb_for_html_select && !isset($va_templates[$va_template_info['name']])) {
									$va_templates[$va_template_info['name']] = '_pdf_'.$vs_template_tag;
								} elseif (!isset($va_templates[$vs_template_tag])) {
									$va_templates[$vs_template_tag] = array(
										'name' => $va_template_info['name'],
										'code' => '_'.$va_template_info['fileFormat'].'_'.$vs_template_tag,
										'type' => $va_template_info['fileFormat'],
										'generic' => $va_template_info['generic'] ? 1 : 0
									);
								}
								
								$vb_needs_caching = true;
							}
						}
					}
				}
				
				if(sizeof($va_templates) == 0) { $vb_needs_caching = true; }

				asort($va_templates);
			}
		}
		
		if ($vb_needs_caching) {	
			ExternalCache::save($vs_cache_key, $va_templates, 'PrintTemplates');
			ExternalCache::save("{$vs_cache_key}_mtime", $vn_template_rev, 'PrintTemplates');
			ExternalCache::save("{$vs_cache_key}_local_mtime", $vn_local_rev, 'PrintTemplates');
		}
		return $va_templates;
	}
	# ------------------------------------------------------------------
	/**
	 * @param $ps_type
	 * @param $ps_template
	 * @param null $pa_options
	 * @return array|bool|false|mixed
	 */
	function caGetPrintTemplateDetails($ps_type, $ps_template, $pa_options=null) {
		if (!is_array($va_template_paths = caGetPrintTemplateDirectoryPath($ps_type))) { return null; }
		
		$va_info = [];
		foreach($va_template_paths as $vs_template_path) {
			if (file_exists("{$vs_template_path}/local/{$ps_template}.php")) {
				$vs_template_path = "{$vs_template_path}/local/{$ps_template}.php";
			} elseif(file_exists("{$vs_template_path}/{$ps_template}.php")) {
				$vs_template_path = "{$vs_template_path}/{$ps_template}.php";
			} else {
				continue;
			}

			$vs_cache_key = caMakeCacheKeyFromOptions($pa_options, $ps_type.'/'.$vs_template_path);
			if (ExternalCache::contains($vs_cache_key, 'PrintTemplateDetails')) {
				$va_list = ExternalCache::fetch($vs_cache_key, 'PrintTemplateDetails');
				$vn_template_rev = file_exists($vs_template_path) ? array_shift(array_map("filemtime", glob("{$vs_template_path}/*.{php,css}", GLOB_BRACE))) : 0;
				if(ExternalCache::fetch("{$vs_cache_key}_mtime", 'PrintTemplateDetails') >= filemtime($vs_template_path)) {
					return $va_list;
				}
			}

			$vs_template = file_get_contents($vs_template_path);

			$va_info = [];
			foreach(array(
				"@name", "@type", "@pageSize", "@pageOrientation", "@tables", "@restrictToTypes",
				"@marginLeft", "@marginRight", "@marginTop", "@marginBottom",
				"@horizontalGutter", "@verticalGutter", "@labelWidth", "@labelHeight",
				"@elementCode", "@showOnlyIn", "@filename", "@fileFormat", "@generic"
			) as $vs_tag) {
				if (preg_match("!{$vs_tag}([^\n\n]+)!", $vs_template, $va_matches)) {
					$va_info[str_replace("@", "", $vs_tag)] = trim($va_matches[1]);
				} else {
					$va_info[str_replace("@", "", $vs_tag)] = null;
				}
			}
			if (!$va_info['fileFormat']) { $va_info['fileFormat'] = 'pdf'; }    // pdf is assumed for templates without a specific file format
			$va_info['tables'] = preg_split("![,;]{1}!", trim($va_info['tables']));
			
			if (trim($va_info['restrictToTypes'])) {
			    $va_info['restrictToTypes'] = preg_split("![,;]{1}!", trim($va_info['restrictToTypes']));
			}
			$va_info['path'] = $vs_template_path;

			ExternalCache::save($vs_cache_key, $va_info, 'PrintTemplateDetails');
			ExternalCache::save("{$vs_cache_key}_mtime", filemtime($vs_template_path), 'PrintTemplateDetails');
			
			return $va_info;
		}
		return null;
	}
	# ------------------------------------------------------------------
	/**
	 * Converts string quantity with units ($ps_value parameter) to a numeric quantity in
	 * points. Units are limited to inches, centimeters, millimeters, pixels and points as
	 * this function is primarily used to switch between units used when generating PDFs.
	 *
	 * @param $ps_value string The value to convert. Valid units are in, cm, mm, px and p. If units are invalid or omitted points are assumed.
	 * @param $pa_options array Options include:
	 *		dpi = dots-per-inch factor to use when converting physical units (in, cm, etc.) to points [Default is 72dpi]
	 *		ppi = synonym for dpi option
	 * @return int Converted measurement in points.
	 */
	function caConvertMeasurementToPoints($ps_value, $pa_options=null) {
		global $g_print_measurement_cache;

		if (isset($g_print_measurement_cache[$ps_value])) { return $g_print_measurement_cache[$ps_value]; }

		if (!preg_match("/^([\d\.]+)[ ]*([A-Za-z]*)$/", $ps_value, $va_matches)) {
			return $g_print_measurement_cache[$ps_value] = $ps_value;
		}
		
		$vn_dpi = caGetOption('dpi', $pa_options, caGetOption('ppi', $pa_options, 72));

		switch(strtolower($va_matches[2])) {
			case 'in':
				$ps_value_in_points = $va_matches[1] * $vn_dpi;
				break;
			case 'cm':
				$ps_value_in_points = $va_matches[1] * ($vn_dpi/2.54);
				break;
			case 'mm':
				$ps_value_in_points = $va_matches[1] * ($vn_dpi/24.4);
				break;
			case '':
			case 'px':
			case 'p':
				$ps_value_in_points = $va_matches[1];
				break;
			default:
				$ps_value_in_points = $ps_value;
				break;
		}

		return $g_print_measurement_cache[$ps_value] = $ps_value_in_points;
	}
	# ------------------------------------------------------------------
	/**
	 * Converts string quantity with units ($ps_value parameter) to a numeric quantity in
	 * the units specified by the $ps_units parameter. Units are limited to inches, centimeters, millimeters, pixels and points as
	 * this function is primarily used to switch between units used when generating PDFs.
	 *
	 * @param $ps_value string The value to convert. Valid units are in, cm, mm, px and p. If units are invalid or omitted points are assumed.
	 * @param $ps_units string A valid measurement unit: in, cm, mm, px, p (inches, centimeters, millimeters, pixels, points) respectively.
	 *
	 * @return int Converted measurement. If the output units are omitted or otherwise not valid, pixels are assumed.
	 */
	function caConvertMeasurement($ps_value, $ps_units) {
		$vn_in_points = caConvertMeasurementToPoints($ps_value);
		
		if (!preg_match("/^([\d\.]+)[ ]*([A-Za-z]*)$/", $ps_value, $va_matches)) {
			return $vn_in_points;
		}
		
		switch(strtolower($ps_units)) {
			case 'in':
				return $vn_in_points/72;
				break;
			case 'cm':
				return $vn_in_points/28.346;
				break;
			case 'mm':
				return $vn_in_points/2.8346;
				break;
			default:
			case 'px':
			case 'p':
				return $vn_in_points;
				break;
		}
	}
	# ------------------------------------------------------------------
	/**
	 * Converts string quantity with units ($ps_value parameter) to a numeric quantity in
	 * the units specified by the $ps_units parameter. Units are limited to inches, centimeters, millimeters, pixels and points as
	 * this function is primarily used to switch between units used when generating PDFs.
	 *
	 * @param $ps_value string The value to convert. Valid units are in, cm, mm, px and p. If units are invalid or omitted points are assumed.
	 * @param $ps_units string A valid measurement unit: in, cm, mm, px, p (inches, centimeters, millimeters, pixels, points) respectively.
	 *
	 * @return int Converted measurement. If the output units are omitted or otherwise not valid, pixels are assumed.
	 */
	function caParseMeasurement($ps_value, $pa_options=null) {
		if (!preg_match("/^([\d\.]+)[ ]*([A-Za-z]*)$/", $ps_value, $va_matches)) {
			return null;
		}

		switch(strtolower($va_matches[2])) {
			case 'in':
			case 'cm':
			case 'mm':
			case 'px':
			case 'p':
				return array('value' => $va_matches[1], 'units' => $va_matches[2]);
				break;
			default:
				return null;
				break;
		}

	}
	# ------------------------------------------------------------------
	/**
	 *
	 */
	function caGenerateBarcode($ps_value, $pa_options=null) {
		$ps_barcode_type = caGetOption('type', $pa_options, 'code128', array('forceLowercase' => true));
		$pn_barcode_height = caConvertMeasurementToPoints(caGetOption('height', $pa_options, '9px'));

		$vs_tmp = null;
		switch($ps_barcode_type) {
			case 'qr':
			case 'qrcode':
				$vs_tmp = tempnam(caGetTempDirPath(), 'caQRCode');
				$vs_tmp2 = tempnam(caGetTempDirPath(), 'caQRCodeResize');

				if (!defined('QR_LOG_DIR')) { define('QR_LOG_DIR', false); }

				if (($pn_barcode_height < 1) || ($pn_barcode_height > 8)) {
					$pn_barcode_height = 1;
				}
				QRcode::png($ps_value, "{$vs_tmp}.png", QR_ECLEVEL_H, $pn_barcode_height);
				return $vs_tmp;
				break;
			case 'code128':
			case 'code39':
			case 'ean13':
			case 'int25':
			case 'postnet':
			case 'upca':
				$o_barcode = new Barcode();
				$vs_tmp = tempnam(caGetTempDirPath(), 'caBarCode');
				if(!($va_dimensions = $o_barcode->draw($ps_value, "{$vs_tmp}.png", $ps_barcode_type, 'png', $pn_barcode_height))) { return null; }
				return $vs_tmp;
				break;
			default:
				// invalid barcode
				break;
		}

		return null;
	}
	# -------------------------------------------------------
	/**
	 *
	 */
	function caParseBarcodeViewTag($ps_tag, $po_view, $po_result, $pa_options=null) {
		$vs_tmp = null;
		if (substr($ps_tag, 0, 7) == 'barcode') {
			$o_barcode = new Barcode();

			// got a barcode
			$va_bits = explode(":", $ps_tag);
			array_shift($va_bits); // remove "barcode" identifier
			$vs_type = array_shift($va_bits);
			if (is_numeric($va_bits[0])) {
				$vn_size = (int)array_shift($va_bits);
				$vs_template = join(":", $va_bits);
			} else {
				$vn_size = 16;
				$vs_template = join(":", $va_bits);
			}

			$vs_tmp = caGenerateBarcode($po_result->getWithTemplate($vs_template, $pa_options), array('type' => $vs_type, 'height' => $vn_size));

			$po_view->setVar($ps_tag, "<img src='{$vs_tmp}.png'/>");
		}
		return $vs_tmp;
	}
	# ------------------------------------------------------------------
	/**
	 *
	 */
	function caDoPrintViewTagSubstitution($po_view, $po_result, $ps_template_path, $pa_options=null) {
		return caDoTemplateTagSubstitution($po_view, $po_result, $ps_template_path, ['render' => false, 'barcodes' => true, 'clearVars' => true]);
	}
	# ---------------------------------------
	/** 
	 *
	 */
	function caPrintLabels($po_view, $po_result, $ps_title) {
		try {
			$po_view->setVar('title', $ps_title);
			
			// render labels
			$vn_width = 				caConvertMeasurement(caGetOption('labelWidth', $va_template_info, null), 'mm');
			$vn_height = 				caConvertMeasurement(caGetOption('labelHeight', $va_template_info, null), 'mm');
			
			$vn_top_margin = 			caConvertMeasurement(caGetOption('marginTop', $va_template_info, null), 'mm');
			$vn_bottom_margin = 		caConvertMeasurement(caGetOption('marginBottom', $va_template_info, null), 'mm');
			$vn_left_margin = 			caConvertMeasurement(caGetOption('marginLeft', $va_template_info, null), 'mm');
			$vn_right_margin = 			caConvertMeasurement(caGetOption('marginRight', $va_template_info, null), 'mm');
			
			$vn_horizontal_gutter = 	caConvertMeasurement(caGetOption('horizontalGutter', $va_template_info, null), 'mm');
			$vn_vertical_gutter = 		caConvertMeasurement(caGetOption('verticalGutter', $va_template_info, null), 'mm');
			
			$va_page_size =				PDFRenderer::getPageSize(caGetOption('pageSize', $va_template_info, 'letter'), 'mm', caGetOption('pageOrientation', $va_template_info, 'portrait'));
			$vn_page_width = $va_page_size['width']; $vn_page_height = $va_page_size['height'];
			
			$vn_label_count = 0;
			$vn_left = $vn_left_margin;
			
			$vn_top = $vn_top_margin;
			
			$vs_content = $this->render("pdfStart.php");
			
			
			$va_defined_vars = array_keys($po_view->getAllVars());		// get list defined vars (we don't want to copy over them)
			$va_tag_list = $this->getTagListForView($va_template_info['path']);				// get list of tags in view
			
			$va_barcode_files_to_delete = [];
			
			$vn_page_count = 0;
			while($po_result->nextHit()) {
				$va_barcode_files_to_delete = array_merge($va_barcode_files_to_delete, caDoPrintViewTagSubstitution($po_view, $po_result, $va_template_info['path'], array('checkAccess' => $this->opa_access_values)));
				
				$vs_content .= "<div style=\"{$vs_border} position: absolute; width: {$vn_width}mm; height: {$vn_height}mm; left: {$vn_left}mm; top: {$vn_top}mm; overflow: hidden; padding: 0; margin: 0;\">";
				$vs_content .= $this->render($va_template_info['path']);
				$vs_content .= "</div>\n";
				
				$vn_label_count++;
				
				$vn_left += $vn_vertical_gutter + $vn_width;
				
				if (($vn_left + $vn_width) > $vn_page_width) {
					$vn_left = $vn_left_margin;
					$vn_top += $vn_horizontal_gutter + $vn_height;
				}
				if (($vn_top + $vn_height) > (($vn_page_count + 1) * $vn_page_height)) {
					
					// next page
					if ($vn_label_count < $po_result->numHits()) { $vs_content .= "<div class=\"pageBreak\">&nbsp;</div>\n"; }
					$vn_left = $vn_left_margin;
						
					switch($vs_renderer) {
						case 'wkhtmltopdf':
							// WebKit based renderers (wkhtmltopdf) want things numbered relative to the top of the document (Eg. the upper left hand corner of the first page is 0,0, the second page is 0,792, Etc.)
							$vn_page_count++;
							$vn_top = ($vn_page_count * $vn_page_height) + $vn_top_margin;
							break;
						case 'domPDF':
						default:
							// domPDF wants things positioned in a per-page coordinate space (Eg. the upper left hand corner of each page is 0,0)
							$vn_top = $vn_top_margin;								
							break;
					}
				}
			}
			
			$vs_content .= $this->render("pdfEnd.php");
			
			
			
			caExportAsPDF($po_view, $vs_template_identifier, caGetOption('filename', $va_template_info, 'labels.pdf'), []);

			$vb_printed_properly = true;
			
			foreach($va_barcode_files_to_delete as $vs_tmp) { @unlink($vs_tmp); @unlink("{$vs_tmp}.png");}
			
		} catch (Exception $e) {
			foreach($va_barcode_files_to_delete as $vs_tmp) { @unlink($vs_tmp); @unlink("{$vs_tmp}.png");}
			
			$vb_printed_properly = false;
			$this->postError(3100, _t("Could not generate PDF"),"BaseFindController->PrintSummary()");
		}
	}
	# ---------------------------------------
	/** 
	 *
	 */
	function caGetPrintFormatsListAsHTMLForRelatedBundles($ps_id_prefix, $po_request, $pt_primary, $pt_related, $pt_relation, $pa_initial_values) {
		$va_formats = caGetAvailablePrintTemplates('results', ['table' => $pt_related->tableName(), 'type' => null, 'showOnlyIn' => 'editor_relationship_bundle']);
		if(!is_array($va_formats)) { $va_formats = []; }
		$vs_pk = $pt_related->primaryKey();
		
		$va_ids = [];
		
		foreach($pa_initial_values as $vn_relation_id => $va_info) {
			$va_ids[$vn_relation_id] = $va_info[$vs_pk];
		}
		
		$va_options = [];
		if (sizeof($va_formats) > 0) {
            foreach($va_formats as $vn_ => $va_form_info) {
                $va_options[$va_form_info['name']] = $va_form_info['code'];
            }
        }
        
		if (sizeof($va_options) == 0) { return ''; }
		
		// Get current display list
		require_once(__CA_MODELS_DIR__."/ca_bundle_displays.php");
		$t_display = new ca_bundle_displays();
        foreach(caExtractValuesByUserLocale($t_display->getBundleDisplays(['table' => $pt_related->tableName()])) as $va_display_info) {
            if (is_array($va_display_info['settings']['show_only_in']) && sizeof($va_display_info['settings']['show_only_in']) && !in_array('editor_relationship_bundle', $va_display_info['settings']['show_only_in'])) { continue; }        
            $va_options[$va_display_info['name']] = '_pdf__display_'.$va_display_info['display_id'];
        }
		
		uksort($va_options, 'strnatcasecmp');
		
		$vs_buf = "<div class='editorBundlePrintControl'>"._t("Export as")." ";
		$vs_buf .= caHTMLSelect('export_format', $va_options, array('id' => "{$ps_id_prefix}_reportList", 'class' => 'dontTriggerUnsavedChangeWarning'), array('value' => null, 'width' => '150px'))."\n";
		
		$vs_buf .= caJSButton($po_request, __CA_NAV_ICON_GO__, '', "{$ps_id_prefix}_report", ['onclick' => "caGetExport{$ps_id_prefix}(); return false;"], ['size' => '15px']);
		
		$vs_url = caNavUrl($po_request, 'find', 'RelatedList', 'Export', ['relatedRelTable' => $pt_relation->tableName(), 'primaryTable' => $pt_primary->tableName(), 'primaryID' => $pt_primary->getPrimaryKey(), 'download' => 1, 'relatedTable' => $pt_related->tableName()]);
		$vs_buf .= "</div>";
		$vs_buf .= "
			<script type='text/javascript'>
				function caGetExport{$ps_id_prefix}() {
					var s = jQuery('#{$ps_id_prefix}_reportList').val();
					var f = jQuery('<form id=\"caTempExportForm\" action=\"{$vs_url}/export_format/' + s + '\" method=\"post\" style=\"display:none;\"><textarea name=\"ids\">".json_encode($va_ids)."</textarea></form>');
					jQuery('body #caTempExportForm').replaceWith(f).hide();
					f.submit();
				}
			</script>
		";
		return $vs_buf;
	}
	# ---------------------------------------
	/**
	 *
	 */
	function caGetPrintFormatsListAsHTMLForSetItemBundles($ps_id_prefix, $po_request, $pt_set, $pa_row_ids) {
	    require_once(__CA_MODELS_DIR__."/ca_bundle_displays.php");
	
		$vs_set_table = Datamodel::getTableName($pt_set->get("table_num"));
		$va_formats = caGetAvailablePrintTemplates('sets', ['showOnlyIn' => 'set_item_bundle', 'table' => $vs_set_table, 'type' => null]);
		
		if(!is_array($va_formats) || (sizeof($va_formats) == 0)) { return ''; }
		$vs_pk = $pt_set->primaryKey();
		
		$va_options = [];
		foreach($va_formats as $vn_ => $va_form_info) {
			$va_options[$va_form_info['name']] = $va_form_info['code'];
		}
		if (sizeof($va_options) == 0) { return ''; }
		
		$t_display = new ca_bundle_displays();
		if(is_array($va_displays = caExtractValuesByUserLocale($t_display->getBundleDisplays(['user_id' => $po_request->getUserID(), 'table' => $vs_set_table])))) {
		    foreach($va_displays as $vn_display_id => $va_display_info) {
		        if (is_array($va_display_info['settings']['show_only_in']) && sizeof($va_display_info['settings']['show_only_in']) && !in_array('set_item_bundle', $va_display_info['settings']['show_only_in'])) { continue; }
		        $va_options[$va_display_info['name']] = '_display_'.$va_display_info['display_id'];
		    }
		}
		
		
		uksort($va_options, 'strnatcasecmp');
		
		$vs_buf = "<div class='editorBundlePrintControl'>"._t("Export as")." ";
		$vs_buf .= caHTMLSelect('export_format', $va_options, array('id' => "{$ps_id_prefix}_reportList", 'class' => 'dontTriggerUnsavedChangeWarning'), array('value' => null, 'width' => '150px'))."\n";
		
		$vs_buf .= caJSButton($po_request, __CA_NAV_ICON_GO__, '', "{$ps_id_prefix}_report", ['onclick' => "caGetExport{$ps_id_prefix}(); return false;"], ['size' => '15px']);
		
		$vs_url = caNavUrl($po_request, 'manage', 'sets', 'setEditor/exportSetItems', ['set_id' => $pt_set->get("set_id"), 'download' => 1]);
		$vs_buf .= "</div>";
		$vs_buf .= "
			<script type='text/javascript'>
				function caGetExport{$ps_id_prefix}() {
					var s = jQuery('#{$ps_id_prefix}_reportList').val();
					var f = jQuery('<form id=\"caTempExportForm\" action=\"{$vs_url}/export_format/' + s + '\" method=\"post\" style=\"display:none;\"></form>');
					jQuery('body #caTempExportForm').replaceWith(f).hide();
					f.submit();
				}
			</script>
		";
		return $vs_buf;
	}
	# ---------------------------------------
	/**
	 * Return HTML/Javascript for "print summmary" controls on item editor summary screen
	 *
	 * @param View $po_view The view into which the control will be rendered
	 * 
	 * @return string
	 */
	function caEditorPrintSummaryControls($po_view) {
	    $t_display = $po_view->getVar('t_display');
	    $t_item = $po_view->getVar('t_subject');
	    $request = $po_view->request;
	    
	    $vn_item_id = $t_item->getPrimaryKey();
	    
        $vs_buf = $po_view->render($request->getViewsDirectoryPath(true).'/bundles/summary_download_options_html.php');
    
        if ($vs_display_select_html = $t_display->getBundleDisplaysAsHTMLSelect('display_id', array('onchange' => 'jQuery("#caSummaryDisplaySelectorForm").submit();',  'class' => 'searchFormSelector'), array('table' => $t_item->tableNum(), 'value' => $t_display->getPrimaryKey(), 'access' => __CA_BUNDLE_DISPLAY_READ_ACCESS__, 'user_id' => $request->getUserID(), 'restrictToTypes' => array($t_item->getTypeID()), 'context' => 'editor_summary'))) {

            $vs_buf .= "<div id='printButton'>
                <a href='#' onclick='return caShowSummaryDownloadOptionsPanel();'>".caNavIcon(__CA_NAV_ICON_PDF__, 2)."</a>
                    <script type='text/javascript'>
                            function caShowSummaryDownloadOptionsPanel() {
                                caSummaryDownloadOptionsPanel.showPanel();
                                return false;
                            }
                    </script>
 </div>\n";
            $vs_buf .= caFormTag($request, 'Summary', 'caSummaryDisplaySelectorForm', null, 'post', 'multipart/form-data', '_top', ['noCSRFToken' => true, 'disableUnsavedChangesWarning' => true]).
            "<div class='searchFormSelector' style='float:right;'>". _t('Display').": {$vs_display_select_html}</div>
            <input type='hidden' name='".$t_item->primaryKey()."' value='{$vn_item_id}'/>
            </form>\n";
	}
	
        return $vs_buf;
	}
	# ---------------------------------------
