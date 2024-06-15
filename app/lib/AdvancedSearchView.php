<?php
/** ---------------------------------------------------------------------
 * app/lib/AdvancedSearchView.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2024 Whirl-i-Gig
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
 * @subpackage Core
 * @license http://www.gnu.org/copyleft/gpl.html GNU Public License version 3
 *
 * ----------------------------------------------------------------------
 */
require_once(__CA_LIB_DIR__."/View.php");
 
class AdvancedSearchView extends View {
	# -------------------------------------------------------
	/**
	 *
	 */
	private $template_list;
	
	/**
	 *
	 */
	private $info;
	
	/**
	 *
	 */
	private $subject;
	
	/**
	 *
	 */
	private $search_config;
	
	/**
	 *
	 */
	private $form_elements;
	
	
	# -------------------------------------------------------
	/**
	 *
	 */
	public function __construct(RequestHTTP $request, ?array $path=null, ?string $character_encoding='UTF8', ?array $options=null) {
		$this->search_config = caGetSearchConfig();
		$this->template_list = $this->search_config->getAssoc('advanceSearchFormElementTemplates');
		
		parent::__construct($request, $path, $character_encoding, $options);
		
		$this->form_elements = [];
	}
	# -------------------------------------------------------
	/**
	 *
	 */
	public function formElement(string $bundle, ?array $options=null) {
		$this->info = $this->getVar('searchInfo');
		$this->subject = Datamodel::getInstance($this->info['table'] ?? null, true);
		$base_classes = $this->search_config->getList('advancedSearchBaseClasses');
		
		if(!strlen($template = caGetOption('template', $options, null))) {
			if($template_name = caGetOption('templateName', $options, null)) {
				$template = $this->template_list[$template_name] ?? '???';
			} else {
				$template = $this->template_list['__default__'] ?? '???';
			}
		}
		
		$classes = [];
		if(is_array($base_classes) && sizeof($base_classes)) { $classes = array_merge($base_classes, $classes); }
		if($class = caGetOption('class', $options, null)) { $classes[] = $class; }
		
		//<input type='text' class='form-control' id='{{{formId}}}' aria-describedby='{{{descId}}}'>
		$element_id = 'adv-'.preg_replace('![^A-Za-z0-9_]+!', '_', $bundle);
		$desc_id = 'advdesc-'.preg_replace('![^A-Za-z0-9_]+!', '_', $bundle);
		$element = $this->subject->htmlFormElementForSearch(
			$this->request, 
			$bundle, 
			array_merge([
				'class' => join(' ', $classes),
				'id' => $element_id,
				'attributes' => ['aria-describedby' => $desc_id]
			], $options)
		);	
		
		$label = caGetOption('label', $options, $this->subject->getDisplayLabel($bundle));
		$description = caGetOption('description', $options, $this->subject->getDisplayDescription($bundle));
		
		$template = str_replace("^ELEMENTID", $element_id, $template);	
		$template = str_replace("^DESCRIPTIONID", $desc_id, $template);
		$template = str_replace("^ELEMENT", $element, $template);
		$template = str_replace("^LABEL", $label, $template);
		$template = str_replace("^DESCRIPTION", $description, $template);
		
		$this->form_elements[$bundle] = 1;
		
		return $template;
	}
	# -------------------------------------------------------
	/**
	 *
	 */
	public function formBundle(string $formbundle, ?array $options=null) : ?string {
		$this->subject = Datamodel::getInstance($this->info['table'] ?? null, true);
		
		if(!is_array($bundle_defs = $this->info['fieldBundles'][$formbundle] ?? null)) {
			return null;
		}
		
		$opts = [];
		foreach($bundle_defs as $k => $bi) {
			if(!($bundle = $bi['bundle'] ?? null)) { continue; }
			if(!strlen($label = $bi['label'] ?? null)) { continue; }
			$opts[$bundle] = $label;
		}
		$select = caHTMLSelect('bundle', array_flip($opts), ['aria-label' => 'select', 'class' => caGetOption('selectClass', $options, null)]);
		
		$ret = [
			'id' => caGetOption('id', $options, 'bundle'),
			'select' => $select,
			'options' => $opts,
		];
		
		// Get form elements for each option
		$classes = [];
		$inputs = [];
		foreach($opts as $b => $l) {
			//$inputs[$b] = '<input type="text" name="'.$b.'" class="form-control s7terms" placeholder="'._t('Enter %1', $l).'">';
			
			$this->form_elements[$b] = 1;
			$element_id = 'adv-'.preg_replace('![^A-Za-z0-9_]+!', '_', $b);
			$elements = $this->subject->htmlFormElementForSearch(
				$this->request, 
				$b, 
				array_merge([
					'class' => join(' ', $classes),
					'id' => $element_id,
					'elementsOnly' => true
					//'attributes' => ['aria-describedby' => $desc_id]
				], $options)
			);	
			if(is_array($elements['elements'] ?? null)) {
				$elements = $elements['elements'];
				$elements = array_shift($elements);
				$inputs[$b] = join('', $elements);
			} else {
				$inputs[$b] = $elements;
			}
		}
		$ret['inputs'] = $inputs;
	//print_r($ret);
		
		$js =  "<script>
	if(!pawtucketUIApps['advancedSearchFieldBundle']) { pawtucketUIApps['advancedSearchFieldBundle'] = {}; }
	if(!pawtucketUIApps['advancedSearchFieldBundle']['bundles']) { pawtucketUIApps['advancedSearchFieldBundle']['bundles'] = {}; }
	pawtucketUIApps['advancedSearchFieldBundle']['bundles']['{$formbundle}'] = ".json_encode($ret, true)."</script>";
		
		return $js;
	}
	# -------------------------------------------------------
	/**
	 *
	 */
	public function formTag(?array $attributes, ?array $options=null) {
		$attr = array_merge([
			'action' => caNavUrl($this->request, '*', '*', $this->request->getActionExtra()),
			'enctype' => 'multipart/form-data',
			'target' => '_top',
			'method' => 'post'
		], $attributes);
		$attr_str = _caHTMLMakeAttributeString($attr);
		return "<form {$attr_str}>";
	}
	# -------------------------------------------------------
	/**
	 *
	 */
	public function formHiddenElements(?array $options=null) {
		$elements = [
			caHTMLHiddenInput('_advanced', ['value' => 1]),
			caHTMLHiddenInput('_formElements', ['value' => join('|', array_keys($this->form_elements))]),
		];
		return join("\n", $elements);
	}
	# -------------------------------------------------------
	/**
	 *
	 */
	public function render($filename, $dont_do_var_replacement=false, $options=null) {
		$this->setVar('formElementList', array_keys($this->form_elements));
		return parent::render($filename, $dont_do_var_replacement, $options);
	}
	# -------------------------------------------------------
}