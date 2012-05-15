<?php
/**
 *
 * RequestRouter module.  Copyright 2007 - 2008 Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Implements routing of incoming requests to arbitrary controllers
 * [NOT IMPLEMENTED YET]
 *
 * @author Seth Kaufman <seth@whirl-i-gig.com>
 * @copyright Copyright 2007 - 2008 Whirl-i-Gig (http://www.whirl-i-gig.com)
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
 
 	require_once(__CA_LIB_DIR__."/core/Controller/Request/RequestHTTP.php");
 
 	class RequestRouter {
 		# -------------------------------------------------------
 		private $opo_request;
 		
 		# -------------------------------------------------------
 		public function RequestRouter(&$po_request=null) {
 			
 		}
 		# -------------------------------------------------------
 		public function getRequest() {
 			return $this->opo_request;
 		}
 		# -------------------------------------------------------
 		public function addRoute() {
 		
 		}
 		# -------------------------------------------------------
 		public function run() {
 		
 		}
 		# -------------------------------------------------------
 		public function setControllerDirectories($pa_directories) {
 		
 		}
 		# -------------------------------------------------------
 		public function addControllerDirectories($pa_directories) {
 		
 		}
 		# -------------------------------------------------------
 		public function addControllerDirectory($ps_directory) {
 		
 		}
 		# -------------------------------------------------------
 	}
 ?>