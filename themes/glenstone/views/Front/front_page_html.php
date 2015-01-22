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
	#$va_item_ids = $this->getVar('featured_set_item_ids');
	$o_result_context = $this->getVar('result_context');
	
	require_once(__CA_MODELS_DIR__."/ca_sets.php");
	$va_access_values = caGetUserAccessValues($this->request);

	if($vs_set_code = $this->request->config->get("featured_art_set")){
		$t_set = new ca_sets();
		$t_set->load(array('set_code' => $vs_set_code));
		# Enforce access control on set
		if((sizeof($va_access_values) == 0) || (sizeof($va_access_values) && in_array($t_set->get("access"), $va_access_values))){
			$va_item_ids = array_keys(is_array($va_tmp = $t_set->getItemRowIDs(array('checkAccess' => $va_access_values, 'shuffle' => 0))) ? $va_tmp : array());
			$va_art_items = $t_set->getItemIDs();
			if ($va_art_items) {
				foreach($va_art_items as $va_art_item => $va_art) {$va_art_set_item = $va_art_item; break;}
			}
			$t_art_item = new ca_set_items($va_art_set_item);
			$va_artwork_caption = $t_art_item->get('ca_set_items.caption');
		}
		if(is_array($va_item_ids) && sizeof($va_item_ids)){
			$t_object = new ca_objects();
			$va_item_media = $t_object->getPrimaryMediaForIDs($va_item_ids, array("small"), array('checkAccess' => caGetUserAccessValues($this->request)));
		}
	}
	if($vs_library_set_code = $this->request->config->get("featured_library_set")){
		$t_library_set = new ca_sets();
		$t_library_set->load(array('set_code' => $vs_library_set_code));
		# Enforce access control on set
		if((sizeof($va_access_values) == 0) || (sizeof($va_access_values) && in_array($t_library_set->get("access"), $va_access_values))){
			$va_library_item_ids = array_keys(is_array($va_tmp = $t_library_set->getItemRowIDs(array('checkAccess' => $va_access_values, 'shuffle' => 0))) ? $va_tmp : array());
			$va_library_items = $t_library_set->getItemIDs();
			foreach($va_library_items as $va_library_item => $va_library) {$va_library_set_item = $va_library_item; break;}
			$t_library_item = new ca_set_items($va_library_set_item);
			$va_library_caption = $t_library_item->get('ca_set_items.caption');
		}
		if(is_array($va_library_item_ids) && sizeof($va_library_item_ids)){
			$t_object = new ca_objects();
			$va_library_media = $t_object->getPrimaryMediaForIDs($va_library_item_ids, array("small"), array('checkAccess' => caGetUserAccessValues($this->request)));
		}
	}	
	if($vs_archive_set_code = $this->request->config->get("featured_archive_set")){
		$t_archive_set = new ca_sets();
		$t_archive_set->load(array('set_code' => $vs_archive_set_code));
		# Enforce access control on set
		if((sizeof($va_access_values) == 0) || (sizeof($va_access_values) && in_array($t_archive_set->get("access"), $va_access_values))){
			$va_archive_item_ids = array_keys(is_array($va_tmp = $t_archive_set->getItemRowIDs(array('checkAccess' => $va_access_values, 'shuffle' => 0))) ? $va_tmp : array());
			$va_archive_items = $t_archive_set->getItemIDs();
			foreach($va_archive_items as $va_archive_item => $va_archive) {$va_archive_set_item = $va_archive_item; break;}
			$t_archive_item = new ca_set_items($va_archive_set_item);
			$va_archive_caption = $t_archive_item->get('ca_set_items.caption');
		}
		if(is_array($va_archive_item_ids) && sizeof($va_archive_item_ids)){
			$t_object = new ca_objects();
			$va_archive_media = $t_object->getPrimaryMediaForIDs($va_archive_item_ids, array("small"), array('checkAccess' => caGetUserAccessValues($this->request)));
		}
	}	
	

	
	if ($this->request->config->get('pawtucket_requires_login')&&!($this->request->isLoggedIn())) {
	
		print "<div id='homepageLogin'>";
		print $this->render('LoginReg/form_login_html.php');
		print "</div>";			
	
	} else {
?>
<div class='row featuredItems'>
	<div class="col-sm-4">
		<div class='item first' >
<?php 
		
			print "<h1>Collection</h1>";
		if (sizeof($va_item_media)) {	
			$va_item_media = array_values($va_item_media);
			print "<div class='image'>".caNavLink($this->request, $va_item_media[0]['tags']['small'], '', '', 'Detail', 'artworks/'.$va_item_ids[0])."</div>"; 
			print "<div class='caption'>".caNavLink($this->request, $va_artwork_caption, '', '', 'Detail', 'artworks/'.$va_item_ids[0])."</div>";
		}
?>
		</div>
	</div>
	<div class="col-sm-4">
		<div class='item'>
<?php 
		print "<h1>Library</h1>";
		if (sizeof($va_library_media)) {
			$va_library_media = array_values($va_library_media);
			print "<div class='image'>".caNavLink($this->request, $va_library_media[0]['tags']['small'], '', '', 'Detail', 'library/'.$va_library_item_ids[0])."</div>";
			print "<div class='caption'>".caNavLink($this->request, $va_library_caption, '', '', 'Detail', 'library/'.$va_library_item_ids[0])."</div>"; 
		} else {
			print "<div class='image'></div>";
		}
?>
		</div>
	</div>	
	<div class="col-sm-4">
		<div class='item'>
<?php 
		print "<h1>Archives</h1>";
		if (sizeof($va_archive_media)) {
			$va_archive_media = array_values($va_archive_media);
			print "<div class='image'>".caNavLink($this->request, $va_archive_media[0]['tags']['small'], '', '', 'Detail', 'archives/'.$va_archive_item_ids[0])."</div>";
			print "<div class='caption'>".caNavLink($this->request, $va_archive_caption, '', '', 'Detail', 'archives/'.$va_archive_item_ids[0])."</div>"; 
		} else {
			print "<div class='image'></div>";
		}
?>
		</div>
	</div>
</div>	

	<hr>

<div class="container">
	<div class="row">
		<div class="col-sm-8">
			<H1>Welcome to Glenstone.  To begin, enter a term into the search bar.</H1>
		</div><!--end col-sm-8-->

<?php

#	$va_recent_searches = $o_result_context->getSearchHistory(); 
	
	if (is_array($va_recent_searches) && sizeof($va_recent_searches)) {
?>	
		<div class="col-sm-4">
			<h1>Recent Searches</h1>
			<ul class='recentSearch'> 
<?php
			$v_i = 0;
			foreach($va_recent_searches as $vs_search => $va_search_info) {
				print "<li>".caNavLink($this->request, $vs_search, '', '', 'MultiSearch', 'Index', array('search' => $vs_search))."</li>";
				$v_i++;
				if ($v_i == 10) {
					break;
				}
			}
?>
			</ul>
			
		</div> <!--end col-sm-4-->	
<?php
	}
?>
	</div><!-- end row -->
</div> <!--end container-->

<?php	
	}
?>