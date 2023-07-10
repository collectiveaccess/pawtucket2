<?php
/** ---------------------------------------------------------------------
 * themes/default/Listings/listing_html : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2014 Whirl-i-Gig
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
 
 	$va_lists = 			$this->getVar('lists');
 	$va_type_info = 		$this->getVar('typeInfo');
 	$va_listing_info = 		$this->getVar('listingInfo');
 	$vs_current_sort = 		$this->getVar('sort');
?>

<div id='listingResults'>
<?php
	if(is_array($va_sorts = $this->getVar('sortBy')) && sizeof($va_sorts) > 1) {
?>
	<H1>	
		<div class="btn-group">
			<i class="fa fa-gear bGear" data-toggle="dropdown"></i>
			<ul class="dropdown-menu" role="menu">
<?php
				foreach($va_sorts as $vs_sort => $vs_sort_flds) {
					if ($vs_current_sort === $vs_sort) {
						print "<li><a href='#'><em>{$vs_sort}</em></a></li>\n";
					} else {
						print "<li>".caNavLink($this->request, $vs_sort, '', '*', '*', '*', array('sort' => $vs_sort, 'facet' => $this->getVar('facet'), 'id' => $this->getVar('facet_id')))."</li>\n";
					}
				}			
?>
			</ul>
		</div><!-- end btn-group -->
	</H1>
<?php
	}
 	print $this->render($va_listing_info['view']);
?>
</div>