<?php
/**
 *
 * TextHighlighter module.  Copyright 2008 Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Highlights text based upon a query expression. Typically used to highlight text
 * in search results and details
 *
 * @author Seth Kaufman <seth@whirl-i-gig.com>
 * @copyright Copyright 2008 Whirl-i-Gig (http://www.whirl-i-gig.com)
 * @license http://www.gnu.org/copyleft/lesser.html
 * @package CA
 * @subpackage Core
 *
 * Disclaimer:  There are no doubt inefficiencies and bugs in this code; the
 * documentation leaves much to be desired. If you'd like to improve these  
 * libraries please consider helping us develop this software. 
 *
 * phpweblib is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY.
 *
 * This source code are free and modifiable under the terms of 
 * GNU Lesser General Public License. (http://www.gnu.org/copyleft/lesser.html)
 *
 *
 */

	class TextHighlighter {
		# -------------------------------------------------------
		private $opa_terms;
		private $opo_app_config;
		private $opo_search_config;
		# -------------------------------------------------------
		public function __construct($pm_query, $ps_style=null) {
			if ($ps_style == null) {
				$o_app_config = Configuration::load();
				$o_search_config = Configuration::load($o_app_config->get("search_config"));
			
				$ps_style = $o_search_config->get('text_highlight_style');
			}
			if (!is_array($pm_query)) {
				$va_terms = array($pm_query);
			} else {
				$va_terms = $pm_query;
			}
			
			$this->opa_terms = array();
			if (is_array($va_terms) && (sizeof($va_terms) > 0) && is_object($va_terms[0])) {
				// array of Zend_Search_Lucene_Index_Term objects
				foreach($va_terms as $o_term) {
					$vs_text = ''.$o_term->text; 															// forces copy from Zend_Search_Lucene_Index_Term object (object ref won't survive serialization
					if (unicode_strlen($vs_text) < 2) { continue; }											// don't try to highligh really short terms (hilarity often ensues if we do)
					$this->opa_terms['~^('.$vs_text.'[\w]*)~iu'] = "<span class='$ps_style'>$1</span>";		// highlight matches at beginning of text
					$this->opa_terms['~([^A-Za-z0-9]+)('.$vs_text.'[\w]*)~iu'] = "$1<span class='$ps_style'>$2</span>";	// highlight matches within the text
				}
			} else {
				// array of patterns
				$this->opa_terms = $pm_query;
			}
		}
		# -------------------------------------------------------
		public function highlight($ps_text) {
			if (!is_array($this->opa_terms)) { return $ps_text; }
			return preg_replace(array_keys($this->opa_terms), array_values($this->opa_terms), $ps_text);
		}
		# -------------------------------------------------------
		public function getHighlightPatterns() {
			return $this->opa_terms;
		}
		# -------------------------------------------------------
	}
?>