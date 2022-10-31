<?php
/** ---------------------------------------------------------------------
 * ExportFormatXML.php : defines XML export format
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013 Whirl-i-Gig
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
 * @subpackage Export
 * @license http://www.gnu.org/copyleft/gpl.html GNU Public License version 3
 *
 * ----------------------------------------------------------------------
 */

require_once(__CA_LIB_DIR__.'/Export/BaseExportFormat.php');
require_once(__CA_MODELS_DIR__.'/ca_data_exporters.php');
require_once(__CA_MODELS_DIR__.'/ca_data_exporter_items.php');

class ExportXML extends BaseExportFormat {
	# ------------------------------------------------------
	private $opo_dom;
	# ------------------------------------------------------
	public function __construct(){
		$this->ops_name = 'XML';
		$this->ops_element_description = _t('Values prefixed with @ reference XML attributes. All other values define XML elements. The usual restrictions and naming conventions for XML elements and attributes apply.');

		$this->opo_dom = new DOMDocument('1.0','utf-8'); // are those settings?
		$this->opo_dom->formatOutput = true;
		$this->opo_dom->preserveWhiteSpace = false;

		parent::__construct();
	}
	# ------------------------------------------------------
	public function getFileExtension($pa_settings) {
		return 'xml';
	}
	# ------------------------------------------------------
	public function getContentType($pa_settings) {
		return 'text/xml';
	}
	# ------------------------------------------------------
	public function processExport($pa_data,$pa_options=array()){
		$pb_single_record = caGetOption('singleRecord', $pa_options);
		//$pb_rdf_mode = caGetOption('rdfMode', $pa_options);
		$pb_strip_cdata = (bool) caGetOption('stripCDATA', $pa_options['settings'], false);

		//caDebug($pa_data,"Data to build XML from");
		
		$this->log("XML export formatter: Now processing export tree ...");

		// XML exports should usually have only one top-level element (i.e. one root).
		if(sizeof($pa_data)!=1){ return false; }

		$this->processItem(array_pop($pa_data),$this->opo_dom, ['stripCDATA' => $pb_strip_cdata]);

		$this->log(_t("XML export formatter: Done processing export tree ..."));

		// when dealing with a record set export, we don't want <?xml tags in front of each record
		// that way we can simply dump a sequence of records in a file and have well-formed XML as result
		$vs_return = ($pb_single_record ? $this->opo_dom->saveXML() : $this->opo_dom->saveXML($this->opo_dom->firstChild));

		if($pb_strip_cdata) {
			$vs_return = str_replace('<![CDATA[', '', $vs_return);
			$vs_return = str_replace(']]>','',$vs_return);
		}

		return $vs_return;
	}
	# ------------------------------------------------------
	private function processItem($pa_item, $po_parent, $pa_options=null){
		if(!($po_parent instanceof DOMNode)) return false;

		//caDebug($pa_item,"Data passed to XML item processor");

		$vs_element = $pa_item['element'];
		$vs_text = (isset($pa_item['text']) ? $pa_item['text'] : null);

		$this->log(_t("XML export formatter: Processing element or attribute '%1' with text '%2' and parent element '%3' ...", $vs_element, $vs_text, $po_parent->nodeName));

		$vs_first = substr($vs_element,0,1);

		if($vs_first == "@"){ // attribute
			// attributes are only valid for DOMElement, not for DOMDocument
			if(!($po_parent instanceof DOMElement)) return false;

			$vs_rest = substr($vs_element,1);
			$po_parent->setAttribute($vs_rest, $vs_text);
			$vo_new_element = $po_parent; // attributes shouldn't have children, but still ...
		} else { // element
			$vs_escaped_text = caEscapeForXML($vs_text);

			if(strlen($vs_text)>0){

				if($vs_escaped_text != $vs_text) { // sth was escaped by caEscapeForXML -> wrap in CDATA
					if(caGetOption('stripCDATA', $pa_options, false)) {
						$vo_new_element = $this->opo_dom->createElement($vs_element, $vs_escaped_text);
					} else {
						$vo_new_element = $this->opo_dom->createElement($vs_element);
						$vo_new_element->appendChild(new DOMCdataSection($vs_text));
					}
				}  else { // add text as-is using DOMDocument
					$vo_new_element = $this->opo_dom->createElement($vs_element,$vs_text);
				}
				
			} else {
				$vo_new_element = $this->opo_dom->createElement($vs_element);
			}
			$po_parent->appendChild($vo_new_element);
		}

		if(is_array($pa_item['children'])){
			foreach($pa_item['children'] as $va_child){
				if(!empty($va_child)){
					$this->processItem($va_child,$vo_new_element, $pa_options);
				}
			}
		}
	}
	# ------------------------------------------------------
	public function getMappingErrors($t_mapping){
		$va_errors = array();

		$va_top = $t_mapping->getTopLevelItems(array('dontIncludeVariables' => true));
		if(sizeof($va_top)!==1){
			$va_errors[] = _t("XML documents must have exactly one root element. Found %1.", sizeof($va_top));
		}

		foreach($va_top as $va_item){
			$va_errors = array_merge($va_errors,$this->getMappingErrorsForItem($va_item));
		}

		return $va_errors;
	}
	# ------------------------------------------------------
	private function getMappingErrorsForItem($pa_item){
		$va_errors = array();
		$t_item = new ca_data_exporter_items($pa_item['item_id']);


		// check if element is attribute and if so, if it's valid and if it has a non-attribute parent it belongs to
		$vs_element = $t_item->get('element');
		$vs_first = substr($vs_element,0,1);
		if($vs_first == "@"){
			$vs_attribute_name = substr($vs_element,1);
			if(!preg_match("/^[_:A-Za-z][-._:A-Za-z0-9]*$/",$vs_attribute_name)){
				$va_errors[] = _t("Invalid XML attribute name '%1'",$vs_attribute_name);
			}

			$t_parent = new ca_data_exporter_items($t_item->get('parent_id'));
			$vs_parent_first = substr($t_parent->get('element'),0,1);
			if($vs_parent_first == "@" || !$t_parent->get('element')){
				$va_errors[] = _t("XML attribute '%1' doesn't have a valid parent element",$vs_attribute_name);	
			}
		} else { // plain old XML element -> check for naming convention
			if(!preg_match("/^[_:A-Za-z][-._:A-Za-z0-9]*$/",$vs_element)){
				$va_errors[] = _t("Invalid XML element name '%1'",$vs_element);
			}			
		}

		foreach($t_item->getHierarchyChildren() as $va_child){
			$va_errors = array_merge($va_errors,$this->getMappingErrorsForItem($va_child));
		}

		return $va_errors;
	}
	# ------------------------------------------------------
}

BaseExportFormat::$s_format_settings['XML'] = array(
	'stripCDATA' => array(
		'formatType' => FT_NUMBER,
		'displayType' => DT_CHECKBOXES,
		'default' => 0,
		'width' => 1, 'height' => 1,
		'label' => _t("Strip CDATA"),
		'description' => _t("By default the exporter wraps field content that contains invalid XML in CDATA sections to make sure the XML is valid regardless of the field content. If this option is set, the exporter explicitly strips the CDATA tags before returning the XML text. Use only if you know what you're doing!")
	),
);
