<?php
/** ---------------------------------------------------------------------
 * app/lib/core/Plugins/Media/MSWord.php :
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2008-2011 Whirl-i-Gig
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
 * Plugin for processing Microsoft Word documents
 */
 
include_once(__CA_LIB_DIR__."/core/Plugins/WLPlug.php");
include_once(__CA_LIB_DIR__."/core/Plugins/IWLPlugMedia.php");
include_once(__CA_LIB_DIR__."/core/Configuration.php");
include_once(__CA_LIB_DIR__."/core/Media.php");
include_once(__CA_APP_DIR__."/helpers/mediaPluginHelpers.php");

class WLPlugMediaMSWord Extends WLPlug Implements IWLPlugMedia {
	var $errors = array();
	
	var $filepath;
	var $handle;
	var $ohandle;
	var $properties;
	
	var $opo_config;
	var $opo_external_app_config;
	var $ops_abiword_path;
	
	var $info = array(
		"IMPORT" => array(
			"application/msword" 					=> "doc"
		),
		
		"EXPORT" => array(
			"application/msword" 					=> "doc",
			"application/pdf"						=> "pdf",
			"text/html"								=> "html",
			"text/plain"							=> "txt",
			"image/jpeg"							=> "jpg",
			"image/png"								=> "png"
		),
		
		"TRANSFORMATIONS" => array(
			"SCALE" 			=> array("width", "height", "mode", "antialiasing"),
			"ANNOTATE"	=> array("text", "font", "size", "color", "position", "inset"),	// dummy
			"WATERMARK"	=> array("image", "width", "height", "position", "opacity"),	// dummy
			"SET" 				=> array("property", "value")
		),
		
		"PROPERTIES" => array(
			"mimetype" 			=> 'W',
			"typename"			=> 'W',
			"filesize" 			=> 'R',
			"quality"			=> 'W',
			"width"				=> 'W',
			"height"			=> 'W',
			"version_width" 	=> 'R', // width version icon should be output at (set by transform())
			"version_height" 	=> 'R',	// height version icon should be output at (set by transform())
			
			'version'			=> 'W'	// required of all plug-ins
		),
		
		"NAME" => "MSWord",
		
		"MULTIPAGE_CONVERSION" => true, // if true, means plug-in support methods to transform and return all pages of a multipage document file (ex. a PDF)
		"NO_CONVERSION" => false
	);
	
	var $typenames = array(
		"application/pdf" 				=> "PDF",
		"application/msword" 			=> "Microsoft Word",
		"text/html" 					=> "HTML",
		"text/plain" 					=> "Plain text",
		"image/jpeg"					=> "JPEG",
		"image/png"						=> "PNG"
	);
	
	var $magick_names = array(
		"application/pdf" 				=> "PDF",
		"application/msword" 			=> "DOC",
		"text/html" 					=> "HTML",
		"text/plain" 					=> "TXT"
	);
	
	# ------------------------------------------------
	public function __construct() {
		$this->description = _t('Accepts and processes Microsoft Word 97, 2000 and 2008 format documents');
	}
	# ------------------------------------------------
	# Tell WebLib what kinds of media this plug-in supports
	# for import and export
	public function register() {
		$this->opo_config = Configuration::load();
		$vs_external_app_config_path = $this->opo_config->get('external_applications');
		$this->opo_external_app_config = Configuration::load($vs_external_app_config_path);
		$this->ops_abiword_path = $this->opo_external_app_config->get('abiword_app');
		
		$this->info["INSTANCE"] = $this;
		return $this->info;
	}
	# ------------------------------------------------
	public function checkStatus() {
		$va_status = parent::checkStatus();
		
		if ($this->register()) {
			$va_status['available'] = true;
		}
		
		if (!caMediaPluginAbiwordInstalled($this->ops_abiword_path)) { 
			$va_status['warnings'][] = _t("ABIWord cannot be found: indexing of text in Microsoft Word files will not be performed; you can obtain ABIWord at http://www.abisource.com/");
		}
		
		return $va_status;
	}
	# ------------------------------------------------
	public function divineFileFormat($ps_filepath) {
		if ($ps_filepath == '') {
			return '';
		}
		
		if ($r_fp = fopen($ps_filepath, "r")) {
			$vs_sig = fgets($r_fp, 9);
			if ($this->isWord2008doc($vs_sig) || $this->isWord972000doc($vs_sig, $r_fp)) {
				$this->properties = $this->handle = $this->ohandle = array(
					"mimetype" => 'application/msword',
					"filesize" => filesize($ps_filepath),
					"typename" => "Microsoft Word",
					"content" => ""
				);
				fclose($r_fp);
				return "application/msword";
			}
		}
		fclose($r_fp);
		return '';
	}
	# ----------------------------------------------------------
	private function isWord972000doc($ps_sig, $r_fp) {
		// Testing on the first 8 bytes of the file isn't great... 
		// any Microsoft Compound Document formated
		// file will be accepted by this test.
		if (
			(ord($ps_sig{0}) == 0xD0) &&
			(ord($ps_sig{1}) == 0xCF) &&
			(ord($ps_sig{2}) == 0x11) &&
			(ord($ps_sig{3}) == 0xE0) &&
			(ord($ps_sig{4}) == 0xA1) &&
			(ord($ps_sig{5}) == 0xB1) &&
			(ord($ps_sig{6}) == 0x1A) &&
			(ord($ps_sig{7}) == 0xE1)
		) {
			// Look for Word string in doc... this is hacky but seems to work well
			// If it has both the file sig above and this string it's pretty likely
			// a Word file
			while (!feof($r_fp)) {
				$buffer = fgets($r_fp, 32000);
			if (preg_match("!W.{1}o.{1}r.{1}d.{1}D.{1}o.{1}c.{1}u.{1}m.{1}e.{1}n.{1}t!", $buffer) !== false) {
        			return true;
        		}
   			}
		}
		
		return false;
	}
	# ----------------------------------------------------------
	private function isWord2008doc($ps_sig) {
		// ehh... this'll also consider any PK zip file or text field beginning
		// with "PK" as a Word 2008 file... there has got to be a better way.
		if (
			substr($ps_sig, 0, 2) == 'PK'
		) {
			return true;
		}
		
		return false;
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
				$this->postError(1650, _t("Can't set property %1", $property), "WLPlugMediaMSWord->set()");
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
			# noop
		} else {
			if (!file_exists($ps_filepath)) {
				$this->postError(1650, _t("File %1 does not exist", $ps_filepath), "WLPlugMediaMSWord->read()");
				$this->handle = "";
				$this->filepath = "";
				return false;
			}
			if (!($this->divineFileFormat($ps_filepath))) {
				$this->postError(1650, _t("File %1 is not a Microsoft Word document", $ps_filepath), "WLPlugMediaMSWord->read()");
				$this->handle = "";
				$this->filepath = "";
				return false;
			}
		}
		
		//try to extract text
		if (caMediaPluginAbiwordInstalled($this->ops_abiword_path)) {
			$vs_tmp_filename = tempnam('/tmp', 'CA_MSWORD_TEXT');
			exec($this->ops_abiword_path.' -t txt '.$ps_filepath.' -o '.$vs_tmp_filename);
			$vs_extracted_text = preg_replace('![^\w\d]+!u' , ' ', file_get_contents($vs_tmp_filename));	// ABIWord seems to dump Unicode...
			$this->handle['content'] = $this->ohandle['content'] = $vs_extracted_text;
			@unlink($vs_tmp_filename);
		}
			
		return true;	
	}
	# ----------------------------------------------------------
	public function transform($operation, $parameters) {
		if (!$this->handle) { return false; }
		
		if (!($this->info["TRANSFORMATIONS"][$operation])) {
			# invalid transformation
			$this->postError(1655, _t("Invalid transformation %1", $operation), "WLPlugMediaMSWord->transform()");
			return false;
		}
		
		# get parameters for this operation
		$sparams = $this->info["TRANSFORMATIONS"][$operation];
		
		
		switch($operation) {
			# -----------------------
			case "SET":
				while(list($k, $v) = each($parameters)) {
					$this->set($k, $v);
				}
				break;
			# -----------------------
			case 'SCALE':
				if (!$parameters["width"]) { $parameters["width"] = $parameters["height"]; }
				if (!$parameters["height"]) { $parameters["height"] = $parameters["width"]; }
				
				$this->properties["width"] = $this->properties["version_width"] = $parameters["width"];
				$this->properties["height"] = $this->properties["version_height"] = $parameters["height"];
				break;
			# -----------------------
		}
		return true;
	}
	# ----------------------------------------------------------
	public function write($ps_filepath, $ps_mimetype) {
		if (!$this->handle) { return false; }
		
		# is mimetype valid?
		if (!($vs_ext = $this->info["EXPORT"][$ps_mimetype])) {
			$this->postError(1610, _t("Can't convert file to %1", $ps_mimetype), "WLPlugMediaMSWord->write()");
			return false;
		} 
		
		# write the file
		if ($ps_mimetype == "application/msword") {
			if ( !copy($this->filepath, $ps_filepath.".doc") ) {
				$this->postError(1610, _t("Couldn't write file to '%1'", $ps_filepath), "WLPlugMediaMSWord->write()");
				return false;
			}
		} else {
			
			# use default media icons
			if (file_exists($this->opo_config->get("default_media_icons"))) {
				$o_icon_info = Configuration::load($this->opo_config->get("default_media_icons"));
				if ($va_icon_info = $o_icon_info->getAssoc('application/msword')) {
					$vs_icon_path = $o_icon_info->get("icon_folder_path");
					if (!copy($vs_icon_path."/".trim($va_icon_info[$this->get("version")]),$ps_filepath.'.'.$vs_ext)) {
						$this->postError(1610, _t("Can't copy icon file from %1 to %2", $vs_icon_path."/".trim($va_icon_info[$this->get("version")]), $ps_filepath.'.'.$vs_ext), "WLPlugMediaMSWord->write()");
						return false;
					}
				} else {
					$this->postError(1610, _t("No icon available for this media type (system misconfiguration)"), "WLPlugMediaMSWord->write()");
					return false;
				}
			} else {
				$this->postError(1610, _t("No icons available (system misconfiguration)"), "WLPlugMediaMSWord->write()");
				return false;
			}
		}
		
		
		$this->properties["mimetype"] = $ps_mimetype;
		$this->properties["filesize"] = filesize($ps_filepath.".".$vs_ext);
		//$this->properties["typename"] = $this->typenames[$ps_mimetype];
		
		return $ps_filepath.".".$vs_ext;
	}
	# ------------------------------------------------
	/** 
	 *
	 */
	# This method must be implemented for plug-ins that can output preview frames for videos or pages for documents
	public function &writePreviews($ps_filepath, $pa_options) {
		return null;
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
	public function mimetype2extension($mimetype) {
		return $this->info["EXPORT"][$mimetype];
	}
	# ------------------------------------------------
	public function mimetype2typename($mimetype) {
		return $this->typenames[$mimetype];
	}
	# ------------------------------------------------
	public function extension2mimetype($extension) {
		reset($this->info["EXPORT"]);
		while(list($k, $v) = each($this->info["EXPORT"])) {
			if ($v === $extension) {
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
			"mimetype" => $this->ohandle["mimetype"],
			"filesize" => $this->ohandle["filesize"],
			"typename" => $this->ohandle["typename"]
		);
	}
	# ------------------------------------------------
	public function htmlTag($ps_url, $pa_properties, $pa_options=null, $pa_volume_info=null) {
		if (!is_array($pa_options)) { $pa_options = array(); }
		
		foreach(array(
			'name', 'url', 'viewer_width', 'viewer_height', 'idname',
			'viewer_base_url', 'width', 'height',
			'vspace', 'hspace', 'alt', 'title', 'usemap', 'align', 'border', 'class', 'style'
		) as $vs_k) {
			if (!isset($pa_options[$vs_k])) { $pa_options[$vs_k] = null; }
		}
		
		$vn_viewer_width = intval($pa_options['viewer_width']);
		if ($vn_viewer_width < 100) { $vn_viewer_width = 400; }
		$vn_viewer_height = intval($pa_options['viewer_height']);
		if ($vn_viewer_height < 100) { $vn_viewer_height = 400; }
		
		if (!($vs_id = isset($pa_options['id']) ? $pa_options['id'] : $pa_options['name'])) {
			$vs_id = '_msword';
		}
			
		if(preg_match("/\.doc\$/", $ps_url)) {
			return "<a href='$ps_url' target='_pdf'>"._t('Click to view Microsoft Word document')."</a>";
		} else {
			if(preg_match("/\.pdf\$/", $ps_url)) {
				if ($vs_poster_frame_url =	$pa_options["poster_frame_url"]) {
					$vs_poster_frame = "<img src='{$vs_poster_frame_url}'/ alt='"._t("Click to download document")."' title='"._t("Click to download document")."'>";
				} else {
					$vs_poster_frame = _t("View PDF document");
				}
				
				$vs_buf = "<script type='text/javascript'>jQuery(document).ready(function() {
	new PDFObject({
		url: '{$ps_url}',
		id: '{$vs_id}',
		width: '{$vn_viewer_width}px',
		height: '{$vn_viewer_height}px',
	}).embed('{$vs_id}_div');
});</script>
	<div id='{$vs_id}_div'><a href='$ps_url' target='_pdf'>".$vs_poster_frame."</a></div>
";
				return $vs_buf;
			} else {
				if (!is_array($pa_options)) { $pa_options = array(); }
				if (!is_array($pa_properties)) { $pa_properties = array(); }
				return caHTMLImage($ps_url, array_merge($pa_options, $pa_properties));
			}
		}
	}
	# ------------------------------------------------
	public function cleanup() {
		return;
	}
	# ------------------------------------------------
}
?>