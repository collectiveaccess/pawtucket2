<?php
/** ---------------------------------------------------------------------
 * themes/default/Front/front_page_html : Front page of site 
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
 * @subpackage Core
 * @license http://www.gnu.org/copyleft/gpl.html GNU Public License version 3
 *
 * ----------------------------------------------------------------------
 */
#	print $this->render("Front/featured_set_slideshow_html.php");
	
	$va_featured_ids = array();
	if($vs_set_code = $this->request->config->get("front_page_set_code")){
		$t_set = new ca_sets();
		$t_set->load(array('set_code' => $vs_set_code));
		# Enforce access control on set
		if((sizeof($va_access_values) == 0) || (sizeof($va_access_values) && in_array($t_set->get("access"), $va_access_values))){
			$vs_set_id = $t_set->get("set_id");
			$va_featured_ids = array_keys(is_array($va_tmp = $t_set->getItemRowIDs(array('checkAccess' => $va_access_values, 'shuffle' => 1))) ? $va_tmp : array());
			$featured_set_items_as_search_result = caMakeSearchResult('ca_occurrences', $va_featured_ids);
		}
	}	
?>

	<div class="row">
			<div class="col-md-10">
				<h2>Search digital collections</h2>
			</div>
			<div class="col-md-10">
				<p>The digital archive contains a selection (though not all) of all the materials on exhibitions held at the School of Visual Arts, documented at the SVA Archives. You can also browse our digital archive by <a href='#'>object</a> types, related <a href='#'>people</a>, academic <a href='#'>departments</a>, and exhibition <a href='#'>locations.</a> More information about the SVA Archives can be found <a href='#'>here</a>.</p>
			</div>
	</div>
	<div class="row">
		<div class="col-sm-10">
		
				<form class="main-search" role="search" action="<?php print caNavUrl($this->request, '', 'MultiSearch', 'Index'); ?>">
					<div class="formOutline">
						<div class="form-group">
							<input type="text" class="form-control" placeholder="Search" name="search">
							<button type="submit" class="btn-search"><span class="glyphicon glyphicon-search"></span></button>
						</div>
					</div>
				</form>		
		</div>
	</div>

		
