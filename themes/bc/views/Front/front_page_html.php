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
 
  	$t_set = new ca_sets();
 	$t_set->load(array('set_code' => 'frontMember'));
 	$va_featured_members = $t_set->getItemRowIDs(array('checkAccess' => $va_access_values, 'shuffle' => $vn_shuffle));
	
  	$t_item_set = new ca_sets();
 	$t_item_set->load(array('set_code' => 'frontItems'));
 	$va_featured_items = $t_item_set->getItemRowIDs(array('checkAccess' => $va_access_values, 'shuffle' => $vn_shuffle));
		
	print $this->render("Front/featured_set_slideshow_html.php");
?>
<div class="container">
	<div class="row blue">
		<div class="col-sm-3"></div>
		<div class="col-sm-6">
			<div class='tagLine'>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis vulputate, orci quis vehicula eleifend, metus elit laoreet elit. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis vulputate, orci quis vehicula eleifend, metus elit laoreet elit.</div>
		</div><!--end col-sm-8-->
		<div class="col-sm-3"></div>
	</div><!-- end row -->
	<div class="row">
		<h1 class='blue' style='text-align:center;margin-bottom:40px;'>Heritage Sites</h1>
		<div class="col-sm-2"><div class='institution'><i class='fa fa-image'></i><div class='institutionName'>Emily Carr House</div></div></div>
		<div class="col-sm-2"><div class='institution'><i class='fa fa-image'></i><div class='institutionName'>Grist Mill</div></div></div>
		<div class="col-sm-2"><div class='institution'><i class='fa fa-image'></i><div class='institutionName'>Craigflower School House</div></div></div>
		<div class="col-sm-2"><div class='institution'><i class='fa fa-image'></i><div class='institutionName'>Craigflower Manor</div></div></div>
		<div class="col-sm-2"><div class='institution'><i class='fa fa-image'></i><div class='institutionName'>Cottonwood House Historic Park</div></div></div>
		<div class="col-sm-2"><div class='institution'><i class='fa fa-image'></i><div class='institutionName'>Kilby Store and Farm</div></div></div>
	</div>
	<div class="row" >
		<div class="col-sm-1"></div>
		<div class="col-sm-2"><div class='institution'><i class='fa fa-image'></i><div class='institutionName'>Historic Yale</div></div></div>
		<div class="col-sm-2"><div class='institution'><i class='fa fa-image'></i><div class='institutionName'>Fort Steele Heritage Town</div></div></div>
		<div class="col-sm-2"><div class='institution'><i class='fa fa-image'></i><div class='institutionName'>Barkerville Historic Town</div></div></div>
		<div class="col-sm-2"><div class='institution'><i class='fa fa-image'></i><div class='institutionName'>Historic Hat Creek Ranch</div></div></div>
		<div class="col-sm-2"><div class='institution'><i class='fa fa-image'></i><div class='institutionName'>Point Ellice House</div></div></div>
		<div class="col-sm-1"></div>
	</div>	

	<div class="row blue" style='margin-top:50px;padding-top:15px;'>
		<div class="col-sm-1"></div>
<?php
		foreach ($va_featured_members as $va_member_id => $va_member) {
			$t_entity = new ca_entities($va_member_id);
			print '<div class="col-sm-5 featuredMember"><h1>Featured Collection</h1>';
			print "<div class='featuredTitle'>".caNavLink($this->request, $t_entity->get('ca_entities.preferred_labels'), '', '', 'Detail', 'entities/'.$va_member_id)."</div>";
			print $t_entity->get('ca_entities.biography');			
			print '</div>';
			print '<div class="col-sm-5 featuredMember" style="padding-top:25px;">'.caGetThemeGraphic($this->request, 'hat.jpg').'</div>';
			break;
		}
?>			
		<div class="col-sm-1"></div>
	</div><!-- end row -->
	<div class="row blue" style="padding-top:25px;padding-bottom:45px;">
		<div class="col-sm-1"></div>
<?php
		foreach ($va_featured_items as $va_item_id => $va_item) {
			$t_object = new ca_objects($va_item_id);
			print '<div class="col-sm-5 featuredMember" style="padding-top:25px;border-top:1px solid #fff;">'.$t_object->get('ca_object_representations.media.medium').'</div>';			
			print '<div class="col-sm-5 featuredMember" style="border-top:1px solid #fff;"><h1>Featured Artifact</h1>';
			print "<div class='featuredTitle'>".caNavLink($this->request, $t_object->get('ca_objects.preferred_labels'), '', '', 'Detail', 'objects/'.$va_item_id)."</div>";
			print $t_object->get('ca_objects.description');			
			print '</div>';
			break;
		}
?>
		<div class="col-sm-1"></div>
	</div><!-- end row -->	
	<div class="row cats">
		<h1 class='blue' style='margin-bottom:-20px;'>Browse Collections</h1>
		<div class="col-sm-2"></div>
		<div class="col-sm-2"><i class="fa fa-building"></i><br/>Architecture</div>
		<div class="col-sm-2"><i class="fa fa-paint-brush"></i><br/>Art</div>
		<div class="col-sm-2"><i class="fa fa-comments"></i><br/>Communications</div>
		<div class="col-sm-2"><i class="fa fa-leaf"></i><br/>Farming</div>
		<div class="col-sm-2"></div>
	</div><!-- end row -->
	<div class="row cats" style="margin-bottom:80px;">
		<div class="col-sm-2"></div>
		<div class="col-sm-2"><i class="fa fa-ship"></i><br/>Fishing</div>
		<div class="col-sm-2"><i class="fa fa-home"></i><br/>Household Life</div>
		<div class="col-sm-2"><i class="fa fa-rocket"></i><br/>Industry</div>
		<div class="col-sm-2"><i class="fa fa-star"></i><br/>Military</div>
		<div class="col-sm-2"></div>
	</div><!-- end row -->	
</div> <!--end container-->