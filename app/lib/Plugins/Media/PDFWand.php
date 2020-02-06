<?php
/** ---------------------------------------------------------------------
 * app/lib/Plugins/Media/PDFWand.php :
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2006-2020 Whirl-i-Gig
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
 * @subpackage Media
 * @license http://www.gnu.org/copyleft/gpl.html GNU Public License version 3
 *
 * ----------------------------------------------------------------------
 */
 
 /**
  *
  */

/**
 * Plugin for processing PDF documents
 */

include_once(__CA_LIB_DIR__."/Plugins/Media/BaseMediaPlugin.php");
include_once(__CA_LIB_DIR__."/Plugins/IWLPlugMedia.php");
include_once(__CA_LIB_DIR__."/Configuration.php");
include_once(__CA_LIB_DIR__."/Media.php");
include_once(__CA_APP_DIR__."/helpers/mediaPluginHelpers.php");

class WLPlugMediaPDFWand Extends BaseMediaPlugin implements IWLPlugMedia {
	var $errors = array();
	
	var $filepath;
	var $handle;
	var $ohandle;
	var $properties;
	
	var $opo_config;
	var $opo_external_app_config;
	var $opo_search_config;
	var $ops_ghostscript_path;
	var $ops_pdftotext_path;
	var $ops_pdfminer_path;
	
	var $ops_imagemagick_path;
	var $ops_graphicsmagick_path;
	
	var $info = array(
		"IMPORT" => array(
			"application/pdf" 					=> "pdf"
		),
		
		"EXPORT" => array(
			"application/pdf" 					=> "pdf",
			"image/jpeg"						=> "jpg",
			"image/png"							=> "png",
			"image/gif"							=> "gif",
			"image/tiff"						=> "tiff",
			"application/postscript"			=> "ps"
		),
		
		"TRANSFORMATIONS" => array(
			"SCALE" 			=> array("width", "height", "mode", "antialiasing"),
			"ANNOTATE"	=> array("text", "font", "size", "color", "position", "inset"),	// dummy
			"WATERMARK"	=> array("image", "width", "height", "position", "opacity"),	// dummy
			"SET" 				=> array("property", "value")
		),
		
		"PROPERTIES" => array(
			"width" 			=> 'W', # in pixels
			"height" 			=> 'W', # in pixels
			"version_width" 	=> 'R', // width version icon should be output at (set by transform())
			"version_height" 	=> 'R',	// height version icon should be output at (set by transform())
			"mimetype" 			=> 'W',
			"quality"			=> 'W',
			"pages"				=> 'R',
			"page"				=> 'W', # page to output as JPEG or TIFF
			"resolution"		=> 'W', # resolution of graphic in pixels per inch
			"filesize" 			=> 'R',
			"antialiasing"		=> 'W', # amount of antialiasing to apply to final output; 0 means none, 1 means lots; a good value is 0.5
			"crop"				=> 'W', # if set to geometry value (eg. 72x72) image will be cropped to those dimensions; set by transform() to support fill_box SCALE mode 
			"crop_from"			=> 'W', # location to calculate crop area from
			"crop_center_x"		=> 'W',
			"crop_center_y"		=> 'W',
			"scaling_correction"=> 'W',	# percent scaling required to correct sizing of image output by Ghostscript (Ghostscript does not do fractional resolutions)
			"target_width"		=> 'W',
			"target_height"		=> 'W',
			
			"colors"			=> 'W', # number of colors in output PNG-format image; default is 256
			
			'version'			=> 'W'	// required of all plug-ins
		),
		
		"NAME" => "PDF",
		
		"MULTIPAGE_CONVERSION" => true, // if true, means plug-in support methods to transform and return all pages of a multipage document file (ex. a PDF)
		"NO_CONVERSION" => false
	);
	
	var $typenames = array(
		"application/pdf" 					=> "PDF",
		"image/jpeg"						=> "JPEG",
		"image/tiff"						=> "TIFF",
		"image/png"							=> "PNG",
		"image/gif"							=> "GIF",
		"application/postscript"			=> "Postscript"
	);
	
	var $magick_names = array(
		"image/jpeg" 		=> "JPEG",
		"image/gif" 		=> "GIF",
		"image/tiff" 		=> "TIFF",
		"image/png" 		=> "PNG",
		"image/x-bmp" 		=> "BMP",
		"image/x-psd" 		=> "PSD",
		"application/pdf"	=> "PDF",
		"application/postscript" => "Postscript"
	);
	
	#
	# Alternative extensions for supported types
	#
	var $alternative_extensions = [];
	
	/**
	 * Per-request caching of information extracted from read PDFs
	 */
	static $s_pdf_info_cache = [];
	
	# ------------------------------------------------
	public function __construct() {
		$this->description = _t('Provides PDF conversion services using ImageMagick or the Zend_PDF library. Will use Ghostscript to generate image-previews of PDF files.');
	}
	# ------------------------------------------------
	/**
	 * What sort media does this plug-in support for import and export
	*/ 
	public function register() {
		$this->opo_config = Configuration::load();
		
		$this->opo_search_config = Configuration::load(__CA_CONF_DIR__.'/search.conf');
		$this->opo_external_app_config = Configuration::load(__CA_CONF_DIR__.'/external_applications.conf');
		
		$this->ops_ghostscript_path = $this->opo_external_app_config->get('ghostscript_app');
		$this->ops_pdftotext_path = $this->opo_external_app_config->get('pdftotext_app');
		$this->ops_pdfminer_path = $this->opo_external_app_config->get('pdfminer_app');
		$this->ops_imagemagick_path = $this->opo_external_app_config->get('imagemagick_path');
		$this->ops_graphicsmagick_path = $this->opo_external_app_config->get('graphicsmagick_app');

		
		$this->info["INSTANCE"] = $this;
		return $this->info;
	}
	# ------------------------------------------------
	public function checkStatus() {
		$va_status = parent::checkStatus();
		
		if ($this->register()) {
			$va_status['available'] = true;
		} 
		
		if (!caMediaPluginGhostscriptInstalled($this->ops_ghostscript_path)) { 
			$va_status['warnings'][] = _t("Ghostscript cannot be found: image previews will not be created");
		}
		if (!caMediaPluginPdftotextInstalled($this->ops_pdftotext_path)) { 
			$va_status['warnings'][] = _t("PDFToText cannot be found: indexing of text in PDF files will not be performed; you can obtain PDFToText at http://www.foolabs.com/xpdf/download.html");
		}
		if (!caPDFMinerInstalled($this->ops_pdfminer_path)) { 
			$va_status['warnings'][] = _t("PDFMiner cannot be found: indexing of text locations in PDF files will not be performed; you can obtain PDFMiner at http://www.unixuser.org/~euske/python/pdfminer/index.html");
		}
		
		return $va_status;
	}
	# ------------------------------------------------
	public function divineFileFormat($ps_filepath) {
		if ($ps_filepath == '') {
			return '';
		}
		
		if ((isset(WLPlugMediaPDFWand::$s_pdf_info_cache[$ps_filepath]) && ($va_info = WLPlugMediaPDFWand::$s_pdf_info_cache[$ps_filepath])) || (WLPlugMediaPDFWand::$s_pdf_info_cache[$ps_filepath] = $va_info = caGetPDFInfo($ps_filepath))) {
			if(!WLPlugMediaPDFWand::$s_pdf_info_cache[$ps_filepath]) { return ''; }
			$vn_width = $va_info['width'];
			$vn_height = $va_info['height'];
			$vn_res = 72;
			$vn_pages = $va_info['pages'];
		} else {
			return '';
		} 
		$vs_mimetype = "application/pdf";
		
		
		if (sizeof(WLPlugMediaPDFWand::$s_pdf_info_cache) > 100) { WLPlugMediaPDFWand::$s_pdf_info_cache = array_slice(WLPlugMediaPDFWand::$s_pdf_info_cache, 50); }
		
		
		if (($vs_mimetype) && $this->info["IMPORT"][$vs_mimetype]) {
			$this->handle = $this->ohandle = array(
				"filepath" => 		$ps_filepath,
				"width" => 			$vn_width,
				"height" => 		$vn_height,
				"mimetype" => 		$vs_mimetype,
				"resolution" => 	$vn_res, 	
				"pages"	=>			$vn_pages,
				"page" => 			1,
				"quality" => 		75,
				"filesize" =>		filesize($ps_filepath),
				"content" =>		'',
				"content_by_location" => array()
			);
			
			$this->properties = array(
				"width" => $this->handle["width"],
				"height" => $this->handle["height"],
				"mimetype" => $vs_mimetype,
				"quality" => 75,
				"pages" => $this->handle["pages"],
				"page" => 1,
				"resolution" => 72,
				"filesize" => $this->handle["filesize"],
				"typename" => "PDF"
			);
			return $vs_mimetype;
		} else {
			return '';
		}
	}
	# ----------------------------------------------------------
	public function get($property) {
		if ($this->handle) {
			if ($this->info["PROPERTIES"][$property]) {
				return $this->properties[$property];
			} else {
				//print "Invalid property";
				return '';
			}
		} else {
			return '';
		}
	}
	# ----------------------------------------------------------
	public function set($property, $value) {
		if ($this->handle) {
			if ($this->info["PROPERTIES"][$property]) {
				switch($property) {
					case 'quality':
						if (($value < 1) || ($value > 100)) {
							$this->postError(1650, _t("Quality property must be between 1 and 100"), "WLPlugPDFWand->set()");
							return '';
						}
						$this->properties["quality"] = $value;
						break;
					case 'antialiasing':
						if (($value < 0) || ($value > 100)) {
							$this->postError(1650, _t("Antialiasing property must be between 0 and 100"), "WLPlugPDFWand->set()");
							return '';
						}
						$this->properties["antialiasing"] = $value;
						break;
					default:
						if ($this->info["PROPERTIES"][$property] == 'W') {
							$this->properties[$property] = $value;
						} else {
							# read only
							return '';
						}
						break;
				}
			} else {
				# invalid property
				$this->postError(1650, _t("Can't set property %1", $property), "WLPlugPDFWand->set()");
				return '';
			}
		} else {
			return '';
		}
		return true;
	}
	# ------------------------------------------------
	/**
	 * Returns text content for indexing, or empty string if plugin doesn't support text extraction
	 *
	 * @return String Extracted text
	 */
	public function getExtractedText() {
		return isset($this->handle['content']) ? $this->handle['content'] : '';
	}
	# ------------------------------------------------
	/**
	 * Returns array of locations of text within document, or null if plugin doesn't support text location extraction
	 *
	 * @return Array Extracted text locations
	 */
	public function getExtractedTextLocations() {
		return isset($this->handle['content_by_location']) ? $this->handle['content_by_location'] : '';
	}
	# ------------------------------------------------
	/**
	 * Returns array of extracted metadata, key'ed by metadata type or empty array if plugin doesn't support metadata extraction
	 *
	 * @return Array Extracted metadata
	 */
	public function getExtractedMetadata() {
		return array();
	}
	# ------------------------------------------------
	public function read ($ps_filepath) {
		if (is_array($this->handle) && ($this->handle["filepath"] == $ps_filepath)) {
			// noop
		} else {
			if (!file_exists($ps_filepath)) {
				$this->postError(1650, _t("File %1 does not exist", $ps_filepath), "WLPlugPDFWand->read()");
				$this->handle = "";
				$this->filepath = "";
				return false;
			}
			if (!($this->divineFileFormat($ps_filepath))) {
				$this->postError(1650, _t("File %1 is not a PDF", $ps_filepath), "WLPlugPDFWand->read()");
				$this->handle = "";
				$this->filepath = "";
				return false;
			}
		}
		
		$this->filepath = $ps_filepath;
		
		
		// Try to extract positions of text using PDFMiner (http://www.unixuser.org/~euske/python/pdfminer/index.html)
		if (caPDFMinerInstalled($this->ops_pdfminer_path)) {
			
			// Try to extract text
			$vs_tmp_filename = tempnam('/tmp', 'CA_PDF_TEXT');
			exec($this->ops_pdfminer_path.' -t text '.caEscapeShellArg($ps_filepath).' > '.caEscapeShellArg($vs_tmp_filename).(caIsPOSIX() ? " 2> /dev/null" : ""));
			$vs_extracted_text = file_get_contents($vs_tmp_filename);
			$this->handle['content'] = $this->ohandle['content'] = $vs_extracted_text;
			@unlink($vs_tmp_filename);
	
			$vs_tmp_filename = tempnam('/tmp', 'CA_PDF_TEXT_LOCATIONS');
			exec($this->ops_pdfminer_path.' -A -t xml '.caEscapeShellArg($ps_filepath).' > '.caEscapeShellArg($vs_tmp_filename).(caIsPOSIX() ? " 2> /dev/null" : ""));
			
			$xml = new XMLReader();
			if ($xml->open($vs_tmp_filename)) {
			
			// Structure of locations array is [<word>][] = array(page, x1, y1, x2, y2, size)
			$va_locations = array();
			$vn_current_page = null;
			$vs_text_line_content = '';
			$vs_page_content = '';
			$va_text_line_locs = array();
			$vb_in_text_element = false;
			$va_current_text_loc = null;
			
			$vs_indexing_regex = $this->opo_search_config->get('indexing_tokenizer_regex');
			while (@$xml->read()) {
					switch ($xml->name) {
						case 'page':		// new page
							if ($xml->nodeType == XMLReader::END_ELEMENT) { 
								//$va_locations['__pages__'][$vn_current_page] = $vs_page_content;
								$vs_page_content = '';
								break(2); 
							}
							$vs_text_line_content = '';
							$vn_current_page = (int)$xml->getAttribute('id');
							break;
						case 'textline':
							if ($xml->nodeType == XMLReader::END_ELEMENT) { 
								// end of line
							
								$vn_start = $vn_end = null;
								$vs_acc = '';
								for($vn_i=0; $vn_i < mb_strlen($vs_text_line_content); $vn_i++) {
									if (preg_match("![{$vs_indexing_regex}]!u", mb_substr($vs_text_line_content, $vn_i, 1))) {
										// word boundary
										if ($vs_acc) {
											$vs_acc = mb_strtolower($vs_acc);
											$va_start = $va_text_line_locs[$vn_start];
											$va_end = $va_text_line_locs[$vn_end];
											$va_locations[$vs_acc][] = array(
												'p' => $vn_current_page,
												'x1' => $va_start['x1'], 'y1' => $va_start['y1'],
												'x2' => $va_end['x2'], 'y2' => $va_end['y2']
												//'size' => $va_start['size']
											);
										}
										$vn_start = $vn_end = null;
										$vs_acc = '';
									} else {
										if(is_null($vn_start)) { $vn_start = $vn_i; }
										$vn_end = $vn_i;
										$vs_acc .= ($vs_c = mb_substr($vs_text_line_content, $vn_i, 1));
									}
								}
							} else {
								// new line of text
								$vs_page_content .= $vs_text_line_content;
								$vs_text_line_content = '';
								$va_text_line_locs = array();
							}
							break;
						case 'textbox':
							if ($xml->nodeType == XMLReader::END_ELEMENT) {
								$vs_page_content .= "\n";
							}
							break;
						case 'text':
							if ($vb_in_text_element = ($xml->nodeType == XMLReader::ELEMENT)) {
								$va_tmp = explode(",", (string)$xml->getAttribute('bbox'));
								$va_current_text_loc = array(
									'x1' => $va_tmp[0],
									'y1' => $va_tmp[1],
									'x2' => $va_tmp[2],
									'y2' => $va_tmp[3]
									//'font' => $xml->getAttribute('font'),
									//'size' => $xml->getAttribute('size')
								);	
							} else {
								$va_current_text_loc = null;
							}
							break;
						case '#text':		// bit of text to record (usually a single character)
							if ($vb_in_text_element) {
								$va_current_text_loc['chars'] = mb_strlen((string)$xml->value);
								$va_text_line_locs[mb_strlen($vs_text_line_content)] = $va_current_text_loc;
								$vs_text_line_content .= (string)$xml->value;
							}
							break;
					}
				}
			}
			
			$this->handle['content_by_location'] = $this->ohandle['content_by_location'] = $va_locations;
			@unlink($vs_tmp_filename);	
		} else {			
			// Try to extract text
			if (caMediaPluginPdftotextInstalled($this->ops_pdftotext_path)) {
				$vs_tmp_filename = tempnam('/tmp', 'CA_PDF_TEXT');
				exec($this->ops_pdftotext_path.' -q -enc UTF-8 '.caEscapeShellArg($ps_filepath).' '.caEscapeShellArg($vs_tmp_filename).(caIsPOSIX() ? " 2> /dev/null" : ""));
				$vs_extracted_text = file_get_contents($vs_tmp_filename);
				$this->handle['content'] = $this->ohandle['content'] = $vs_extracted_text;
				@unlink($vs_tmp_filename);
			}
		}
			
		return true;	
	}
	# ----------------------------------------------------------
	public function transform($ps_operation, $pa_parameters) {
		if (!$this->handle) { return false; }
		
		if (!($this->info["TRANSFORMATIONS"][$ps_operation])) {
			# invalid transformation
			$this->postError(1655, _t("Invalid transformation %1", $ps_operation), "WLPlugPDFWand->transform()");
			return false;
		}
		
		# get parameters for this operation
		$sparams = $this->info["TRANSFORMATIONS"][$ps_operation];
		
		$this->properties["version_width"] = $w = $pa_parameters["width"];
		$this->properties["version_height"] = $h = $pa_parameters["height"];
		$cw = $this->get("width");
		$ch = $this->get("height");
		switch($ps_operation) {
			# -----------------------
			case "SET":
				while(list($k, $v) = each($pa_parameters)) {
					$this->set($k, $v);
				}
				break;
			# -----------------------
			case "SCALE":
				$vn_width_ratio = $w/$cw;
				$vn_height_ratio = $h/$ch;
				$vn_orig_resolution = $this->get("resolution");
				switch($pa_parameters["mode"]) {
					# ----------------
					case "width":
						$vn_resolution = ceil($vn_orig_resolution * $vn_width_ratio);
						$vn_scaling_correction = $w/ceil($vn_resolution * ($cw/$vn_orig_resolution));
						break;
					# ----------------
					case "height":
						$vn_resolution = ceil($vn_orig_resolution * $vn_height_ratio);
						$vn_scaling_correction = $h/ceil($vn_resolution * ($ch/$vn_orig_resolution));
						break;
					# ----------------
					case "fill_box":
						$crop_from = $pa_parameters["crop_from"];
						if (!in_array($crop_from, array('center', 'north_east', 'north_west', 'south_east', 'south_west', 'random'))) {
							$crop_from = '';
						}
						
						if ($vn_width_ratio < $vn_height_ratio) {
							$vn_resolution = ceil($vn_orig_resolution * $vn_width_ratio);
							$vn_scaling_correction = $w/ceil($vn_resolution * ($cw/$vn_orig_resolution));
						} else {
							$vn_resolution = ceil($vn_orig_resolution * $vn_height_ratio);
							$vn_scaling_correction = $h/ceil($vn_resolution * ($ch/$vn_orig_resolution));
						}
						$this->set("crop",$w."x".$h);
						$this->set("crop_from",$crop_from);
						$this->set("crop_center_x", caGetOption('_centerX', $pa_parameters, 0.5));
						$this->set("crop_center_y", caGetOption('_centerY', $pa_parameters, 0.5));
						break;
					# ----------------
					case "bounding_box":
					default:
						if ($vn_width_ratio > $vn_height_ratio) {
							$vn_resolution = ceil($vn_orig_resolution * $vn_height_ratio);
							$vn_scaling_correction = $h/ceil($vn_resolution * ($ch/$vn_orig_resolution));
						} else {
							$vn_resolution = ceil($vn_orig_resolution * $vn_width_ratio);
							$vn_scaling_correction = $w/ceil($vn_resolution * ($cw/$vn_orig_resolution));
						}
						break;
					# ----------------
				}
				
				$this->properties["scaling_correction"] = $vn_scaling_correction;
				
				$this->properties["resolution"] = $vn_resolution;
				$this->properties["width"] = ceil($vn_resolution * ($cw/$vn_orig_resolution));
				$this->properties["height"] = ceil($vn_resolution * ($ch/$vn_orig_resolution));
				$this->properties["target_width"] = $w;
				$this->properties["target_height"] = $h;
				$this->properties["antialiasing"] = ($pa_parameters["antialiasing"]) ? 1 : 0;
				break;
			# -----------------------
		}
		return true;
	}
	# ----------------------------------------------------------
	/**
	 * @param array $pa_options Options include:
	 *		dontUseDefaultIcons = If set to true, write will fail rather than use default icons when preview can't be generated. Default is false – to use default icons.
	 *		writeAllPages = 
	 *		start = 
	 *		numPages = 
	 */
	public function write($ps_filepath, $ps_mimetype, $pa_options=null) {
		if (!$this->handle) { return false; }
		
		$pb_write_all_pages = caGetOption('writeAllPages', $pa_options, false);
		$pb_dont_allow_default_icons = caGetOption('dontUseDefaultIcons', $pa_options, false);
		$pb_antialiasing = caGetOption('antialiasing', $pa_options, false);
		
		# is mimetype valid?
		if (!($vs_ext = $this->info["EXPORT"][$ps_mimetype])) {
			$this->postError(1610, _t("Can't convert file to %1", $ps_mimetype), "WLPlugPDFWand->write()");
			return false;
		} 
		
		$va_files = [];
		
		# write the file
		if ($ps_mimetype == "application/pdf") {
			if ( !copy($this->filepath, $ps_filepath.".pdf") ) {
				$this->postError(1610, _t("Couldn't write file to '%1'", $ps_filepath), "WLPlugPDFWand->write()");
				return false;
			}
		} else {
			if (caMediaPluginGhostscriptInstalled($this->ops_ghostscript_path)) {
				$vn_scaling_correction = (float)$this->get("scaling_correction");
				if ($vn_scaling_correction == 1) { $vn_scaling_correction = 0; }
				$vs_res = "72x72";
				if (ceil($this->get("resolution")) > 0) {
					$vn_res= $this->get("resolution");
					if ($vn_scaling_correction) { $vn_res *= 2; }
					$vs_res = ceil($vn_res)."x".ceil($vn_res);
				}
				$vn_quality = ceil($this->get("quality"));
				if ($vn_quality > 100) { $vn_quality = 100; }
				if ($vn_quality < 1) { $vn_quality = 50; }
				
				$vn_start_page = $vn_end_page = ceil($this->get("page"));
				if ($pb_write_all_pages) {
					$vn_start_page = caGetOption('start', $pa_options, $vn_start_page);
					$vn_end_page = caGetOption('numPages', $pa_options, $vn_start_page);
					$ps_filepath .= '%05d';
				}
				if ($vn_start_page < 1) { $vn_start_page = 1; }
				if ($vn_end_page > $this->get('pages')) { $vn_end_page = (int)$this->get('pages'); }
				if ($vn_end_page < 1) { $vn_end_page = $vn_start_page; }
				
				$vs_antialiasing = ($this->get("antialiasing") || $pb_antialiasing) ?  "-dTextAlphaBits=4 -dGraphicsAlphaBits=4" : "";
				
				$vb_processed_preview = false;
				switch($ps_mimetype) {
					case 'image/jpeg':
						exec($this->ops_ghostscript_path." -dNumRenderingThreads=6 -dNOPAUSE -dBATCH -sDEVICE=".($vn_scaling_correction ? "tiff24nc" : "jpeg")." {$vs_antialiasing} -dJPEGQ=".$vn_quality." -dFirstPage=".$vn_start_page." -dLastPage=".$vn_end_page." -dMaxPatternBitmap=1000000 -dBandBufferSpace=500000000 -sBandListStorage=memory -dBufferSpace=1000000000 -dBandHeight=100 -sOutputFile=".caEscapeShellArg($ps_filepath.".".$vs_ext)." -r".$vs_res." -c \"30000000 setvmthreshold\" -f ".caEscapeShellArg($this->handle["filepath"]).(caIsPOSIX() ? " 2> /dev/null" : ""), $va_output, $vn_return);
						if ($vn_return == 0) { $vb_processed_preview = true; }
						break;
					case 'image/png':
						exec($this->ops_ghostscript_path." -dNumRenderingThreads=6 -dNOPAUSE -dBATCH -sDEVICE=pngalpha {$vs_antialiasing} -dFirstPage=".$vn_start_page." -dLastPage=".$vn_end_page." -dMaxPatternBitmap=1000000 -dBandBufferSpace=500000000 -sBandListStorage=memory -dBufferSpace=1000000000 -dBandHeight=100 -sOutputFile=".caEscapeShellArg($ps_filepath.".".$vs_ext)." -r".$vs_res." -c \"30000000 setvmthreshold\" -f ".caEscapeShellArg($this->handle["filepath"]).(caIsPOSIX() ? " 2> /dev/null" : ""), $va_output, $vn_return);
						if ($vn_return == 0) { $vb_processed_preview = true; }
						break;
					case 'image/tiff':
					case 'image/gif':
						exec($this->ops_ghostscript_path." -dNumRenderingThreads=6 -dNOPAUSE -dBATCH -sDEVICE=tiff24nc {$vs_antialiasing} -dFirstPage=".$vn_start_page." -dLastPage=".$vn_end_page." -dMaxPatternBitmap=1000000 -dBandBufferSpace=500000000 -sBandListStorage=memory -dBufferSpace=1000000000 -dBandHeight=100 -sOutputFile=".caEscapeShellArg($ps_filepath.".".$vs_ext)." -r".$vs_res." -c \"30000000 setvmthreshold\" -f ".caEscapeShellArg($this->handle["filepath"]).(caIsPOSIX() ? " 2> /dev/null" : ""), $va_output, $vn_return);
						if ($vn_return == 0) { $vb_processed_preview = true; }
						break;
					default:
						//die("Unsupported output type in PDF plug-in: $ps_mimetype [this shouldn't happen]");
						break;
				}
				if ($pb_write_all_pages) {
					for($i=$vn_start_page; $i <= $vn_end_page; $i++) {
						$va_files[$i] = str_replace("%05d",  sprintf("%05d", $i), $ps_filepath).".{$vs_ext}";
					}
				} else {
					$va_files[] = "{$ps_filepath}.{$vs_ext}";
				}		
		

				if ($vb_processed_preview) {
					foreach($va_files as $vn_page => $vs_file) {
						$vb_use_default_icon = true;
						if ($vs_crop = $this->get("crop")) {
							$o_media = new Media();
							list($vn_w, $vn_h) = explode("x", $vs_crop);
							
							if (($vn_w > 0) && ($vn_h > 0)) {
								$o_media->read($vs_file);
								if (!$o_media->numErrors()) {
									$o_media->transform('SCALE', array('mode' => 'fill_box', 'antialiasing' => 0.5, 'width' => $vn_w, 'height' => $vn_h, 'crop_from' => $this->get('crop_from'), '_centerX' => $this->get('crop_center_x'), '_centerY' => $this->get('crop_center_y')));
									$o_media->write(preg_replace("!\.[A-Za-z0-9]+$!", '', $vs_file), $ps_mimetype, array());
									if (!$o_media->numErrors()) {
										$this->properties["width"] = $vn_w;
										$this->properties["height"] = $vn_h;
										$vb_use_default_icon = false;
									}
								}
							}
						} else {
							if ($vn_scaling_correction) {
								$o_media = new Media(true);
								$o_media->read($vs_file);
								if (!$o_media->numErrors()) {
										
									$vn_w = ($o_media->get('width') * $vn_scaling_correction);
									$vn_h = ($o_media->get('height') * $vn_scaling_correction);
								
									if (($vn_w > $vn_h) || ($this->get("target_height") == 0)) {
										$vn_r = $this->get("target_width")/$vn_w;
										$vn_w = $this->get("target_width");
										$vn_h *= $vn_r;
									} else {
										$vn_r = $this->get("target_height")/$vn_h;
										$vn_h = $this->get("target_height");
										$vn_w *= $vn_r;
									}
								
									$vn_w = ceil($vn_w);
									$vn_h = ceil($vn_h);
									$this->properties["width"] = $vn_w;
									$this->properties["height"] = $vn_h;
									
									$o_media->transform('SCALE', array('mode' => 'bounding_box', 'antialiasing' => 0.5, 'width' => $vn_w, 'height' => $vn_h));
									$o_media->transform('UNSHARPEN_MASK', array('sigma' => 0.5, 'radius' => 1, 'threshold' => 1.0, 'amount' => 0.1));
									$o_media->set('quality',$vn_quality);
								
									$o_media->write(preg_replace("!\.[A-Za-z0-9]+$!", '', $vs_file), $ps_mimetype, array());
									if (!$o_media->numErrors()) {
										$vb_use_default_icon = false;
									}
								}
							} else {
								$vb_use_default_icon = false;
							}
						}
						
						if (!$pb_write_all_pages && $vb_use_default_icon) {
							return $pb_dont_allow_default_icons ? null : __CA_MEDIA_DOCUMENT_DEFAULT_ICON__;
						} elseif($pb_write_all_pages && $vb_use_default_icon) {
							$va_files[$vn_page] = __CA_MEDIA_DOCUMENT_DEFAULT_ICON__;
						}
					}
				}
			}
		}
		if (!$pb_write_all_pages) {	
			$this->properties["mimetype"] = $ps_mimetype;
			$this->properties["filesize"] = filesize($ps_filepath.".".$vs_ext);
			$this->properties["typename"] = $this->typenames[$ps_mimetype];
		}
		return $pb_write_all_pages ? $va_files : array_shift($va_files);
	}
	# ------------------------------------------------
	/** 
	 * Options:
	 *		width
	 *		height
	 *		numberOfPages
	 *		pageInterval
	 *		startAtPage
	 *		outputDirectory
	 *		force = ignore setting of "document_preview_generate_pages" app.conf directive and generate previews no matter what
	 */
	# This method must be implemented for plug-ins that can output preview frames for videos or pages for documents
	public function &writePreviews($ps_filepath, $pa_options) {
		if (!(bool)$this->opo_config->get("document_preview_generate_pages") && (!isset($pa_options['force']) || !$pa_options['force'])) { return false; }
		if (!isset($pa_options['outputDirectory']) || !$pa_options['outputDirectory'] || !file_exists($pa_options['outputDirectory'])) {
			if (!($vs_tmp_dir = $this->opo_config->get("taskqueue_tmp_directory"))) {
				// no dir
				return false;
			}
		} else {
			$vs_tmp_dir = $pa_options['outputDirectory'];
		}
		
		if (($vn_max_number_of_pages = $pa_options['numberOfPages']) < 1) {
			$vn_max_number_of_pages = 5000;
		}
		
		if (!($vn_start_at = (int)$pa_options['startAtPage'])) {
			$vn_start_at = 1;
		}
		if ($vn_start_at < 1) { 
			$vn_start_at = 1;
		}
		
		$vn_tot_pages = $this->get('pages');
		
		if ($vn_start_at > $vn_tot_pages) { $vn_start_at = 1; }
		
		$vs_output_file_prefix = tempnam($vs_tmp_dir, 'caDocumentPreview');
		
		$vn_old_res = $this->get('resolution');
		$vn_old_quality = $this->get('quality');
		
		if (($vn_res = (int)$this->opo_config->get("document_preview_resolution")) < 72) { $vn_res = 72; }
		$this->set('resolution', $vn_res);
		
		if (($vn_quality = (int)$this->opo_config->get("document_preview_quality")) > 100) { $vn_quality = 75; }
		$this->set('quality', $vn_quality);
		
		$va_files = $this->write($vs_output_file_prefix, 'image/jpeg', ['writeAllPages' => caGetOption('writeAllPages', $pa_options, false), 'dontUseDefaultIcons' => true, 'antialiasing' => true, 'start' => $vn_start_at, 'numPages' => (($vn_tot_pages > $vn_max_number_of_pages) > $vn_max_number_of_pages) ? $vn_max_number_of_pages : $vn_tot_pages]);

		$this->set("page", 1);
		$this->set('resolution', $vn_old_res);
		$this->set('quality', $vn_old_quality);
		
		
		if (!sizeof($va_files)) {
			$this->postError(1610, _t("Couldn't not write document preview frames to tmp directory (%1)", $vs_tmp_dir), "WLPlugPDFWand->write()");
		}
		@unlink($vs_output_file_prefix);
		return $va_files;
	}
	# ------------------------------------------------
	public function getOutputFormats() {
		return $this->info["EXPORT"];
	}
	# ------------------------------------------------
	public function getTransformations() {
		return $this->info["TRANSFORMATIONS"];
	}
	# ------------------------------------------------
	public function getProperties() {
		return $this->info["PROPERTIES"];
	}
	# ------------------------------------------------
	public function mimetype2extension($ps_mimetype) {
		return $this->info["EXPORT"][$ps_mimetype];
	}
	# ------------------------------------------------
	public function mimetype2typename($ps_mimetype) {
		return $this->typenames[$ps_mimetype];
	}
	# ------------------------------------------------
	public function extension2mimetype($ps_extension) {
		reset($this->info["EXPORT"]);
		while(list($k, $v) = each($this->info["EXPORT"])) {
			if ($v === $ps_extension) {
				return $k;
			}
		}
		return '';
	}
	# ------------------------------------------------
	public function reset() {
		return $this->init();
	}
	# ------------------------------------------------
	public function init() {
		$this->errors = array();
		$this->handle = $this->ohandle;
		$this->properties = array(
			"width" => $this->ohandle["width"],
			"height" => $this->ohandle["height"],
			"mimetype" => $this->ohandle["mimetype"],
			"quality" => 75,
			"pages" => $this->ohandle["pages"],
			"page" => 1,
			"resolution" => 72,
			"filesize" => $this->ohandle["filesize"],
			"typename" => "PDF"
		);
	}
	# ------------------------------------------------
	public function htmlTag($ps_url, $pa_properties, $pa_options=null, $pa_volume_info=null) {
		if (!is_array($pa_options)) { $pa_options = array(); }
		
		foreach(array(
			'name', 'url', 'viewer_width', 'viewer_height', 'idname',
			'viewer_base_url', 'width', 'height',
			'vspace', 'hspace', 'alt', 'title', 'usemap', 'align', 'border', 'class', 'style',
			'embed'
		) as $vs_k) {
			if (!isset($pa_options[$vs_k])) { $pa_options[$vs_k] = null; }
		}
		
		$vn_viewer_width = intval($pa_options['viewer_width']);
		if ($vn_viewer_width < 100) { $vn_viewer_width = 400; }
		$vn_viewer_height = intval($pa_options['viewer_height']);
		if ($vn_viewer_height < 100) { $vn_viewer_height = 400; }
		
		if (!($vs_id = isset($pa_options['id']) ? $pa_options['id'] : $pa_options['name'])) {
			$vs_id = '_pdf';
		}
		
		if(preg_match("/\.pdf\$/", $ps_url)) {
			if ($vs_poster_frame_url =	$pa_options["poster_frame_url"]) {
				$vs_poster_frame = "<img src='{$vs_poster_frame_url}'/ alt='"._t("Click to download document")." title='"._t("Click to download document")."''>";
			} else {
				$vs_poster_frame = _t("View PDF document");
			}
			
			return $vs_buf;
		} else {
			if (!is_array($pa_options)) { $pa_options = array(); }
			if (!is_array($pa_properties)) { $pa_properties = array(); }
			return caHTMLImage($ps_url, array_merge($pa_options, $pa_properties));
		}
	}
	# ------------------------------------------------
	#
	# ------------------------------------------------
	public function cleanup() {
		return;
	}
	# ------------------------------------------------
}
?>
