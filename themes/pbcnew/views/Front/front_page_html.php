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
		#Featured Artists
		$va_featured_ids = array();
		if($vs_set_code = $this->request->config->get("featured_artist_set_code")){
			$t_set = new ca_sets();
			$t_set->load(array('set_code' => $vs_set_code));
			# Enforce access control on set
			if((sizeof($va_access_values) == 0) || (sizeof($va_access_values) && in_array($t_set->get("access"), $va_access_values))){
				$featured_set_id = $t_set->get("set_id");
				$va_featured_ids = array_keys(is_array($va_tmp = $t_set->getItemRowIDs(array('checkAccess' => $va_access_values, 'shuffle' => 0))) ? $va_tmp : array());
				$qr_res = caMakeSearchResult('ca_entities', $va_featured_ids);
			}
		}
		#Featured Works
		$va_featured_work_ids = array();
		if($vs_set_code_work = $this->request->config->get("featured_works_set_code")){
			$t_work = new ca_sets();
			$t_work->load(array('set_code' => $vs_set_code_work));
			# Enforce access control on set
			if((sizeof($va_access_values) == 0) || (sizeof($va_access_values) && in_array($t_work->get("access"), $va_access_values))){
				$featured_set_id = $t_work->get("set_id");
				$va_featured_work_ids = array_keys(is_array($va_tmp = $t_work->getItemRowIDs(array('checkAccess' => $va_access_values, 'shuffle' => 0))) ? $va_tmp : array());
				$qr_works = caMakeSearchResult('ca_objects', $va_featured_work_ids);
			}
		}		
?>
<div class="container">
	<div class="row">
		<div class="col-sm-4 ">
			<div class="homesection left">
				<h1>Browse Our Archive</h1>
				<hr>
				PUT BROWSE FACETS HERE<br/>
				Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis vulputate, orci quis vehicula eleifend, metus elit laoreet elit.

				<h2>Music</h2>	
				<h2>Spoken Word</h2>
				<h2>Religious</h2>
				<h2>People</h2>
				<p><?php print caNavLink($this->request, "View All", '', '', 'Listing', 'people');?></p>
			
			</div>
		</div><!--end col-sm-4-->
		<div class="col-sm-8">
			<div class="homesection right">
				<div class='container'>
					<div class='row'>
						<div class="col-sm-6 homegraphic">
<?php
							print caGetThemeGraphic($this->request, 'jinnah.jpg');
?>	
						</div>
						<div class="col-sm-6">
							<H1>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis vulputate, orci quis vehicula eleifend, metus elit laoreet elit.</H1>

<?php
							#print $this->render("Front/gallery_set_links_html.php");
?>
						</div> <!--end col-sm-6-->	
					</div>	<!--end row-->
					<div class='row'>
						<div class="col-sm-6">
							<div class='featuredArtists'>
								<h1>Featured Artists</h1>
								<hr>
								<ul>
<?php
									if ($qr_works->nextHit()) {
										while($qr_res->nextHit()){
												print caNavLink($this->request, "<li><div class='media'>".$qr_res->get('ca_entities.portrait.icon')."</div>", '', '', 'Detail', 'entities/'.$qr_res->get('ca_entities.entity_id'));
												print "<div class='title'>".caNavLink($this->request, $qr_res->get('ca_entities.preferred_labels'), '', '', 'Detail', 'entities/'.$qr_res->get('ca_entities.entity_id'))."</div>";
												print "</li>";

										}
									}
?>
								</ul>								
							</div>
						</div>
						<div class="col-sm-6">
							<div class='featuredWorks'>
								<h1>Featured Works</h1>
								<hr>
								<ul>
<?php
									if ($qr_works->nextHit()) {
										while($qr_works->nextHit()){
												print caNavLink($this->request, "<li><div class='media'>".$qr_works->get('ca_object_representations.media.icon')."</div>", '', '', 'Detail', 'objects/'.$qr_works->get('ca_objects.object_id'));
												print "<div class='title'>".caNavLink($this->request, $qr_works->get('ca_objects.preferred_labels'), '', '', 'Detail', 'objects/'.$qr_works->get('ca_objects.object_id'))."</div>";
												print "</li>";

										}
									}
?>
								</ul>								
							</div>
						</div> <!--end col-sm-6-->	
					</div>	<!--end row-->					
				</div>	<!--end container-->
				
				
				
			</div><!--end homesection-->
		</div><!--end col-sm-8-->
	
	</div><!-- end row -->
</div> <!--end container-->