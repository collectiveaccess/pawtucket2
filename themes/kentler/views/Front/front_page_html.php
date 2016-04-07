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
 	$o_config = $this->getVar("config");
	$va_access_values = $this->getVar("access_values");
	if ($this->request->session->getVar('visited') != 'has_visited') {		
?>	
		<div id="homePanel">
			<div class="titleLine1">Kentler</div>
			<TABLE BORDER=0 CELLPADDING=0 CELLSPACING=0 align="center">  
				<TR>		
					<TD COLSPAN=3> <IMG SRC="<?php print caGetThemeGraphicURL($this->request, 'logoDrawing/logo_01.gif'); ?>" WIDTH=157 HEIGHT=29 name="Image2"></TD>
				</TR>
				<TR>		
					<TD ROWSPAN=2> <IMG SRC="<?php print caGetThemeGraphicURL($this->request, 'logoDrawing/logo_02.gif'); ?>" WIDTH=27 HEIGHT=188></TD>	
					<TD> <IMG SRC="<?php print caGetThemeGraphicURL($this->request, 'logoDrawing/logo_03.gif'); ?>" WIDTH=118 HEIGHT=92 border="0" name="Image3"></TD>		
					<TD ROWSPAN=2> <IMG SRC="<?php print caGetThemeGraphicURL($this->request, 'logoDrawing/logo_04.gif'); ?>" WIDTH=12 HEIGHT=188></TD>
				</TR>
				<TR>		
					<TD> <IMG SRC="<?php print caGetThemeGraphicURL($this->request, 'logoDrawing/logo_05.gif'); ?>" WIDTH=118 HEIGHT=96></TD>
				</TR>
			</TABLE>
			<div class='titleLine2'>International</div>
			<div class='titleLine3'>Drawing Space</div>			
		</div>	<!--end homePanel-->
		<script type="text/javascript">
			jQuery(document).ready(function() {
				setTimeout(function() {
					$('#homePanel').slideUp('slow');
				}, 3000); // <-- time in milliseconds
			});
		</script>

<?php
	}
	# --- check if there is a current exhibition
	$o_ent_search = caGetSearchInstance("ca_entities");
	$qr_featured_artist = $o_ent_search->search("ca_entities.entity_category:\"flatfile artist\"", array("checkAccess" => $va_access_values));
	$vn_featured_artist_id = null;
	$va_featured_artist_info = array();
	$va_featured_artist_ids = array();
	if($qr_featured_artist->numHits()){
		while($qr_featured_artist->nextHit()){
			$va_featured_artist_info[$qr_featured_artist->get("entity_id")] = array("name" => $qr_featured_artist->get("ca_entities.preferred_labels.displayname"), "id" => $qr_featured_artist->get("entity_id"));
			$va_featured_artist_ids[] = $qr_featured_artist->get("entity_id");
		}
		$va_featured_artist_images = caGetDisplayImagesForAuthorityItems('ca_entities', $va_featured_artist_ids, array('version' => 'iconlarge', 'relationshipTypes' => array('artist'), 'checkAccess' => $va_access_values));
	}
	if(is_array($va_featured_artist_images) && sizeof($va_featured_artist_images)){
		$vn_featured_artist_id = array_rand($va_featured_artist_images);
	}
?>

<?php
	print $this->render("Front/featured_set_slideshow_html.php");
?>

<div class="container">
	
	<div class="row" style="margin-top:20px;">
		<div class="col-sm-3">
			<div class='contentBox'>
<?php
			if($vn_featured_artist_id){
				print $va_featured_artist_images[$vn_featured_artist_id];
?>
				<div class='contentCaptionOver'>
					<?php print caDetailLink($this->request, '<div class="openSansBold">KENTLER FLATFILES ARTIST</div><div class="openSansReg">'.$va_featured_artist_info[$vn_featured_artist_id]["name"].'</div>', '', 'ca_entities', $vn_featured_artist_id); ?>
				</div>
<?php
			}else{
				print caGetThemeGraphic($this->request, 'artist.jpg');
?>
				<div class='contentCaptionOver'>
					<?php print caNavLink($this->request, '<div class="openSansBold">EXPLORE THE FLATFILES</div>', '', '', 'Listing', 'flatfileArtists'); ?>
				</div>
<?php
			}
?>
			</div>
		</div><!--end col-sm-3-->
<?php
		$t_features_set = new ca_sets();
		$t_features_set->load(array("set_code" => $o_config->get("front_page_set_code_box_2")));
		if($t_features_set->get("ca_sets.preferred_labels.name")){
?>
		<div class="col-sm-3">
			<div class='contentBox'>
				<?php print $t_features_set->get("ca_sets.set_image", array("version" => "original"));?>
				<div class='contentCaptionOver'>
					<a href="<?php print ($t_features_set->get("ca_sets.set_link")) ? $t_features_set->get("ca_sets.set_link") : "#"; ?>">
						<div class="openSansBold"><?php print $t_features_set->get("ca_sets.preferred_labels.name"); ?></div>
<?php
						if($t_features_set->get("ca_sets.description")){
?>
						<div class="openSansReg">
							<?php print $t_features_set->get("ca_sets.description"); ?>
						</div>
<?php
						}
?>
					</a>
				</div>
			</div>		
		</div> <!--end col-sm-3-->
<?php
		}else{
?>
		<div class="col-sm-3">
			<div class='contentBox'>
				<?php print caGetThemeGraphic($this->request, 'events.jpg');?>
				<div class='contentCaptionOver'>
					<a href="#">
						<div class="openSansBold">OUTREACH</div>
						<div class="openSansReg">
							K.I.D.S Art Education Program
						</div>
					</a>
				</div>
			</div>		
		</div> <!--end col-sm-3-->
<?php
	}
		$t_features_set->load(array("set_code" => $o_config->get("front_page_set_code_box_3")));
		if($t_features_set->get("ca_sets.preferred_labels.name")){
?>	
		<div class="col-sm-3">
			<div class='contentBox'>
				<?php print $t_features_set->get("ca_sets.set_image", array("version" => "original"));?>
				<div class='contentCaptionOver'>
					<a href="<?php print ($t_features_set->get("ca_sets.set_link")) ? $t_features_set->get("ca_sets.set_link") : "#"; ?>">
						<div class="openSansBold"><?php print $t_features_set->get("ca_sets.preferred_labels.name"); ?></div>
<?php
						if($t_features_set->get("ca_sets.description")){
?>
						<div class="openSansReg">
							<?php print $t_features_set->get("ca_sets.description"); ?>
						</div>
<?php
						}
?>
					</a>
				</div>
			</div>		
		</div> <!--end col-sm-3-->
<?php		
		}else{
?>	
		<div class="col-sm-3">
			<div class='contentBox'>
				<?php print caGetThemeGraphic($this->request, 'exhibition.jpg');?>
				<div class='contentCaptionOver'>
					<div class="openSansBold">VISIT</div>
					<div class="openSansReg">
						Come to Red Hook!
					</div>
				</div>
			</div>		
		</div> <!--end col-sm-3-->
<?php
		}
		$t_features_set->load(array("set_code" => $o_config->get("front_page_set_code_box_4")));
		if($t_features_set->get("ca_sets.preferred_labels.name")){
?>	
		<div class="col-sm-3">
			<div class='contentBox'>
				<?php print $t_features_set->get("ca_sets.set_image", array("version" => "original"));?>
				<div class='contentCaptionOver'>
					<a href="<?php print ($t_features_set->get("ca_sets.set_link")) ? $t_features_set->get("ca_sets.set_link") : "#"; ?>">
						<div class="openSansBold"><?php print $t_features_set->get("ca_sets.preferred_labels.name"); ?></div>
<?php
						if($t_features_set->get("ca_sets.description")){
?>
						<div class="openSansReg">
							<?php print $t_features_set->get("ca_sets.description"); ?>
						</div>
<?php
						}
?>
					</a>
				</div>
			</div>		
		</div> <!--end col-sm-3-->
<?php		
		}else{
?>
		<div class="col-sm-3">
			<div class='contentBox'>
				<?php print caGetThemeGraphic($this->request, 'donate.jpg');?>
				<div class='contentCaptionOver'>
					<div class="openSansBold">SUPPORT</div>
					<div class="openSansReg">
						Volunteer or Donate!
					</div>
				</div>
			</div>		
		</div> <!--end col-sm-3-->	
<?php
		}
?>				
	</div><!-- end row -->
</div> <!--end container-->