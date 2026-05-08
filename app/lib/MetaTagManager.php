<?php
/* ----------------------------------------------------------------------
 * MetaTagManager.php : class to control loading of metatags in page headers
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2010-2025 Whirl-i-Gig
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
class MetaTagManager {
	# --------------------------------------------------------------------------------
	private static $opa_tags;
	private static $ops_window_title = '';
	# --------------------------------------------------------------------------------
	/**
	 * Initialize 
	 *
	 * @return void
	 */
	static function init() {
		MetaTagManager::$opa_tags = array('meta' => array(), 'link' => array());
	}
	# --------------------------------------------------------------------------------
	/**
	 * Add <meta> tag to response
	 *
	 * @param $tag_name (string) - name attribute of <meta> tag
	 * @param $content (string or array) - content of <meta> tag, if $content is an array, it will output multiple meta tags of the same name
	 * @return (bool) - Returns true if tooltip was successfully added, false if not
	 */
	static function addMeta($tag_name, $content) {			
		if (!is_array(MetaTagManager::$opa_tags)) { MetaTagManager::init(); }
		if (!$tag_name) { return false; }
		
		MetaTagManager::$opa_tags['meta'][$tag_name] = $content;
		
		return true;
	}
	# --------------------------------------------------------------------------------
	/**
	 * Add <meta> tag to response with property
	 *
	 * @param $tag_property (string) - name attribute of <meta> tag
	 * @param $content (string) - content of <meta> tag
	 * @return (bool) - Returns true if was successfully added, false if not
	 */
	static function addMetaProperty($tag_property, $content) {			
		if (!is_array(MetaTagManager::$opa_tags)) { MetaTagManager::init(); }
		if (!$tag_property) { return false; }
		
		MetaTagManager::$opa_tags['meta_property'][$tag_property] = $content;
		
		return true;
	}
	# --------------------------------------------------------------------------------
	/**
	 * Add <link> tag to response.
	 *
	 * @param $rel (string) - rel attribute of <link> tag
	 * @param $href (string) - href attribute of <link> tag
	 * @param $type (string) - type attribute of <link> tag [optional]
	 * @return (bool) - Always return true
	 */
	static function addLink($rel, $href, $type=null) {			
		if (!is_array(MetaTagManager::$opa_tags)) { MetaTagManager::init(); }
		if (!$rel) { return false; }
		
		MetaTagManager::$opa_tags['link'][] = array(
			'href' => $href,
			'rel' => $rel,
			'type' => $type
		);
		
		return true;
	}
	# --------------------------------------------------------------------------------
	/**
	 * Add <script> tag to response.
	 *
	 * @param $src (string) - href attribute of <script> tag
	 * @param $type (string) - type attribute of <link> tag [optional]
	 * @return (bool) - Always return true
	 */
	static function addScript($src, $type=null,$options=null) {
		if (!is_array(MetaTagManager::$opa_tags)) { MetaTagManager::init(); }

		MetaTagManager::$opa_tags['script'][] = array(
			'src' => $src,
			'type' => $type
		);

		return true;
	}
	# --------------------------------------------------------------------------------
	/**
	 * Clears all currently set tags
	 *
	 * @return void
	 */
	static function clearAll() {
		MetaTagManager::init();
	}
	# --------------------------------------------------------------------------------
	/**
	 * Returns <meta> and <link> tags
	 *
	 * @return (string) - HTML <meta> and <link> tags
	 */
	static function getHTML() {
		$vs_buf = '';
		if (!is_array(MetaTagManager::$opa_tags)) { MetaTagManager::init(); }
		
		if(is_array(MetaTagManager::$opa_tags)) {
			if (is_array(MetaTagManager::$opa_tags['meta'] ?? null) && sizeof(MetaTagManager::$opa_tags['meta'])) {	
				foreach(MetaTagManager::$opa_tags['meta'] as $tag_name => $contents) {
					if(is_array($contents)){
						foreach($contents as $content){
							$vs_buf .= "<meta name='".htmlspecialchars($tag_name, ENT_QUOTES)."' content='".htmlspecialchars($content, ENT_QUOTES)."'/>\n";
					}
					}
					else{
						$vs_buf .= "<meta name='".htmlspecialchars($tag_name, ENT_QUOTES)."' content='".htmlspecialchars($contents, ENT_QUOTES)."'/>\n";
					}
					
				}
			}
			if (is_array(MetaTagManager::$opa_tags['meta_property'] ?? null) && sizeof(MetaTagManager::$opa_tags['meta_property'])) {	
				foreach(MetaTagManager::$opa_tags['meta_property'] as $tag_property => $content) {
					$vs_buf .= "<meta property='".htmlspecialchars($tag_property, ENT_QUOTES)."' content='".htmlspecialchars($content, ENT_QUOTES)."'/>\n";
				}
			}
			if (is_array(MetaTagManager::$opa_tags['link'] ?? null) && sizeof(MetaTagManager::$opa_tags['link'])) {	
				foreach(MetaTagManager::$opa_tags['link'] as $vn_i => $link) {
					$vs_buf .= "<link rel='".htmlspecialchars($link['rel'], ENT_QUOTES)."' href='".htmlspecialchars($link['href'], ENT_QUOTES)."' ".($link['type'] ? " type='".$link['type']."'" : "")."/>\n";
				}
			}
			if (is_array(MetaTagManager::$opa_tags['script'] ?? null) && sizeof(MetaTagManager::$opa_tags['script'])) {
				foreach(MetaTagManager::$opa_tags['script'] as $vn_i => $link) {
					$vs_buf .= "<script src='".htmlspecialchars($link['src'], ENT_QUOTES)."' ".($link['type'] ? " type='".$link['type']."'" : "")."></script>\n";
				}
			}
		}
		return $vs_buf;
	}
	# --------------------------------------------------------------------------------
	/**
	 * Set window title
	 *
	 * @param string $title The window title
	 * @return bool Always returns true
	 */
	static function setWindowTitle(string $title) : bool {
		MetaTagManager::$ops_window_title = $title;
		
		return true;
	}
	# --------------------------------------------------------------------------------
	/**
	 * Get window title
	 *
	 * @return string
	 */
	static function getWindowTitle() : ?string {
		return MetaTagManager::$ops_window_title ? MetaTagManager::$ops_window_title : Configuration::load()->get('app_display_name');
	}
	# --------------------------------------------------------------------------------
	/**
	 * Set text highlight
	 *
	 * @param array $highlight_text List of strings to highlight
	 * @param array $options Options include:
	 *		persist = Persist highlight text in session. [Default is true]
	 *		removeWildcards = Strip asterisks from highlight text. [Default is true]
	 * @return bool Always returns true
	 */
	static function setHighlightText(?array $highlight_text, ?array $options=null) : bool {
		global $g_highlight_text;
		if(is_array($highlight_text) && caGetOption('removeWildcards', $options, true)) {
			$highlight_text = array_map(function($v) { 
				return str_replace('*', '', $v);
			}, $highlight_text);
		}
		$g_highlight_text = $highlight_text;
		
		if(caGetOption('persist', $options, true)) {
			Session::setVar('text_highlight', $highlight_text);
		}
		return true;
	}
	# --------------------------------------------------------------------------------
	/**
	 * Get list of text to highlight
	 *
	 * @return array
	 */
	static function getHighlightText() : ?array {
		global $g_highlight_text;
		if(!is_null($g_highlight_text)) { return $g_highlight_text; }
		return $g_highlight_text = Session::getVar('text_highlight');
	}
	# --------------------------------------------------------------------------------
}
