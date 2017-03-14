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
		print $this->render("Front/featured_set_slideshow_html.php");
		$this->config = caGetFrontConfig();
		$vs_featured_museum = $this->config->get("museum_set_code");
		$vs_featured_archives = $this->config->get("archives_set_code");
		$vs_featured_library = $this->config->get("library_set_code");
		$vs_featured_testimony = $this->config->get("testimony_set_code");
?>
<div class="container">
	<div class="row">
		<div class="col-sm-12">
			<h1>Welcome to VHEC</h1>
			<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis vulputate, orci quis vehicula eleifend, metus elit laoreet elit.  Quisque lacus quam, auctor sit amet volutpat dictum, scelerisque sit amet neque. Vivamus non massa finibus, ultrices nunc vel, scelerisque dui. Aliquam commodo, quam eget fringilla finibus, enim diam sodales ligula, sollicitudin faucibus ligula lorem vitae arcu. Sed efficitur nisi sit amet lobortis malesuada. Ut quis imperdiet elit. Mauris blandit suscipit leo, non tristique est ultrices eu. Aliquam commodo, quam eget fringilla finibus, enim diam sodales ligula, sollicitudin faucibus ligula lorem vitae arcu. Sed efficitur nisi sit amet lobortis malesuada. Ut quis imperdiet elit. Mauris blandit suscipit leo, non tristique est ultrices eu. Aliquam commodo, quam eget fringilla finibus, enim diam sodales ligula, sollicitudin faucibus ligula lorem vitae arcu. Sed efficitur nisi sit amet lobortis malesuada. Ut quis imperdiet elit. Mauris blandit suscipit leo, non tristique est ultrices eu.</p>
		</div><!--end col-sm-12-->
	</div><!-- end col-->
	<div class='row'>	
		<div class="col-sm-3 homeTile">
<?php			
				if ($vs_featured_museum) {
					$t_museum = new ca_sets();
					$t_museum->load(array('set_code' => $vs_featured_museum));
					$va_object_ids = $t_museum->getItemRowIDs(array('checkAccess' => $va_access_values));
					if (sizeof($va_object_ids) > 0) {
						foreach ($va_object_ids as $vn_object_id => $what_is) {
							$t_museum_object = new ca_objects($vn_object_id);
							print "<div class='featuredHome'>";
							print caNavLink($this->request, $t_museum_object->get('ca_object_representations.media.megawidepreview'), '', '', 'Museum', 'Index');
							print caNavLink($this->request, "<div class='caption'>Museum</div>", '', '', 'Museum', 'Index');
							print "</div>";
							if (strlen($t_museum_object->get('ca_objects.description')) > 200) {
								$vs_museum_description = substr($t_museum_object->get('ca_objects.description'), 0, 197)."...";
							} else {
								$vs_museum_description = $t_museum_object->get('ca_objects.description');
							}
							#print "<p><span class='strongCaption'>".caNavLink($this->request, $t_museum_object->get('ca_objects.preferred_labels'), '', '', 'Detail', 'objects/'.$vn_object_id)." </span>".$vs_museum_description."</p>";
							break;
						}
					}	
				}
?>
		</div>
		<div class='col-sm-3 homeTile'>
<?php		
				if ($vs_featured_archives) {
					$t_archives = new ca_sets();
					$t_archives->load(array('set_code' => $vs_featured_archives));
					$va_object_ids = $t_archives->getItemRowIDs(array('checkAccess' => $va_access_values));
					if (sizeof($va_object_ids) > 0) {
						foreach ($va_object_ids as $vn_object_id => $what_is) {
							$t_archives_object = new ca_objects($vn_object_id);
							print "<div class='featuredHome'>";
							print caNavLink($this->request, $t_archives_object->get('ca_object_representations.media.megawidepreview'), '', '', 'Archives', 'Index');
							print caNavLink($this->request, "<div class='caption'>Archives</div>", '', '', 'Archives', 'Index');
							print "</div>";
							if (strlen($t_archives_object->get('ca_objects.description')) > 200) {
								$vs_archives_description = substr($t_archives_object->get('ca_objects.description'), 0, 197)."...";
							} else {
								$vs_archives_description = $t_archives_object->get('ca_objects.description');
							}
							#print "<p><span class='strongCaption'>".caNavLink($this->request, $t_archives_object->get('ca_objects.preferred_labels'), '', '', 'Detail', 'objects/'.$vn_object_id)." </span>".$vs_archives_description."</p>";
							break;
						}
					}	
				}
?>				
		</div>
		<div class='col-sm-3 homeTile'>
<?php		
				if ($vs_featured_library) {
					$t_library = new ca_sets();
					$t_library->load(array('set_code' => $vs_featured_library));
					$va_object_ids = $t_library->getItemRowIDs(array('checkAccess' => $va_access_values));
					if (sizeof($va_object_ids) > 0) {
						foreach ($va_object_ids as $vn_object_id => $what_is) {
							$t_library_object = new ca_objects($vn_object_id);
							print "<div class='featuredHome'>";
							print caNavLink($this->request, $t_library_object->get('ca_object_representations.media.megawidepreview'), '', '', 'Library', 'Index');
							print caNavLink($this->request, "<div class='caption'>Library</div>", '', '', 'Library', 'Index');
							print "</div>";
							if (strlen($t_library_object->get('ca_objects.description')) > 200) {
								$vs_library_description = substr($t_library_object->get('ca_objects.description'), 0, 197)."...";
							} else {
								$vs_library_description = $t_library_object->get('ca_objects.description');
							}
							#print "<p><span class='strongCaption'>".caNavLink($this->request, $t_library_object->get('ca_objects.preferred_labels'), '', '', 'Detail', 'objects/'.$vn_object_id)." </span>".$vs_library_description."</p>";
							break;
						}	
					}
				}
?>
		</div>
		<div class='col-sm-3 homeTile'>
<?php		
				if ($vs_featured_testimony) {
					$t_testimony = new ca_sets();
					$t_testimony->load(array('set_code' => $vs_featured_testimony));
					$va_object_ids = $t_testimony->getItemRowIDs(array('checkAccess' => $va_access_values));
					if (sizeof($va_object_ids) > 0) {
						foreach ($va_object_ids as $vn_object_id => $what_is) {
							$t_testimony_object = new ca_objects($vn_object_id);
							print "<div class='featuredHome'>";
							print caNavLink($this->request, $t_testimony_object->get('ca_object_representations.media.megawidepreview'), '', '', 'Testimony', 'Index');
							print caNavLink($this->request, "<div class='caption'>Testimony</div>", '', '', 'Testimony', 'Index');
							print "</div>";
							if (strlen($t_testimony_object->get('ca_objects.description')) > 200) {
								$vs_testimony_description = substr($t_testimony_object->get('ca_objects.description'), 0, 197)."...";
							} else {
								$vs_testimony_description = $t_testimony_object->get('ca_objects.description');
							}
							#print "<p><span class='strongCaption'>".caNavLink($this->request, $t_testimony_object->get('ca_objects.preferred_labels'), '', '', 'Detail', 'objects/'.$vn_object_id)." </span>".$vs_testimony_description."</p>";
							break;
						}	
					}
				}
?>
		</div>				
	</div>
</div> <!--end container-->