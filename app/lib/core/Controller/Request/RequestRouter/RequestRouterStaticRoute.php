<?php
/* ----------------------------------------------------------------------
 * app/phpweblib2/RequestRouter/RequestRouterStaticRoute.php : static route
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2007 Whirl-i-Gig
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
 

 	class RequestRouterStaticRoute extends RequestRouterRoute {
 		# -------------------------------------------------------
 		var $opa_route_info;
 		# -------------------------------------------------------
 		public function __construct($pa_route_info=null) {
 			if ($pa_route_info) { $this->setRouteInfo($pa_route_info); }	
 		}
 		# -------------------------------------------------------
 		public function setRouteInfo($pa_route_info) {
 			$this->opa_route_info = $pa_route_info;
 		}
 		# -------------------------------------------------------
 	}
 ?>