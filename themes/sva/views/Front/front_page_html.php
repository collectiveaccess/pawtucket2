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
		#print $this->render("Front/featured_set_slideshow_html.php");

 	include_once(__CA_LIB_DIR__."/ca/Search/CollectionSearch.php");
	include_once(__CA_MODELS_DIR__."/ca_lists.php");
	include_once(__CA_MODELS_DIR__."/ca_collections.php");
 
	$t_object = new ca_objects();
	

	
 ?>
	<div id="content" class="darchive search">

			<h1>Search</h1>
				<p></p>
				<div id="search"><form class="svasearch" role="search" action="<?php print caNavUrl($this->request, '', 'MultiSearch', 'Index'); ?>">
					<div class="">
						<div class="">
							<input type="text" class="svaform" placeholder="" name="search">
						</div>
						<button type="submit" class="btn-search"><!--<span class="glyphicon glyphicon-search"></span>--></button>
					</div>
				</form></div>
				
			<div class="asearch"><?php print caNavLink($this->request, 'Advanced Search', '', '', 'Search/advanced', 'objects');?></a></div>
			<br>
			
			

<?php
			$t_list = new ca_lists();
			$vn_collection_type_id = $t_list->getItemIDFromList("collection_types", "collection");

			$o_collection_search = new CollectionSearch();
			$qr_collections = $o_collection_search->search("ca_collections.type_id:{$vn_collection_type_id}", array('sort' => 'ca_collection_labels.name', 'sort_direction' => 'asc'));
			
			if (sizeof($qr_collections) > 0) {
?>
				<h1>Design Collections</h1>
				<ul class="galleries">
<?php			
				while($qr_collections->nextHit()) {
					$va_collection_id = $qr_collections->get('ca_collections.collection_id');
					print "<li class='mgda collection'>".caNavLink($this->request, $qr_collections->get('ca_collections.preferred_labels'), '', '', 'Detail', 'collections/'.$va_collection_id)."</li>";
				}
				print "</ul>";
			}
?>
					
			
			<h1>SVA Archives</h1>
			<ul class="galleries">
				<!-- search links for all: publications, courses, events, exhibitions -->
				<li class="svaa collection">
<?php
				print caNavLink($this->request, _t('Publications'), '', '', 'Detail', 'collections/341');
?>				
				</li>
<!--				<li class="svaa collection">
<?php
				print caNavLink($this->request, _t('Courses'), '', '', 'Search', 'Index', array('search' => 'ca_occurrences.type_id:97'));
?>	
				</li> -->
				<li class="svaa collection">
<?php
				print caNavLink($this->request, _t('Events'), '', '', 'Search', 'occurrences/facet/type_facet/id/96');
?>					
				</li>	
				<li class="svaa collection">
<?php
				print caNavLink($this->request, _t('Exhibitions'), '', '', 'Search', 'occurrences/facet/type_facet/id/95');
?>					
				</li>						
			</ul>	
			
		</div> <!-- end content include footer -->