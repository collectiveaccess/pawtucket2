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
	#if ($this->request->session->getVar('visited') != 'has_visited') {		
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
				}, 4000); // <-- time in milliseconds
			});
		</script>

<?php
	#}
?>

<?php
	print $this->render("Front/featured_set_slideshow_html.php");
?>

<div class="container">
	
	<div class="row" style="margin-top:20px;">
		<div class="col-sm-3">
			<div class='contentBox'>
				<?php print caGetThemeGraphic($this->request, 'artist.jpg');?>
				<div class='contentCaptionOver turqBg'>
					<div class="openSansBold">FROM THE FLATFILES</div>
					<div class="openSansReg">Jane Smith</div>
				</div>
			</div>
		</div><!--end col-sm-3-->
		<div class="col-sm-3">
			<div class='contentBox'>
				<?php print caGetThemeGraphic($this->request, 'exhibition.jpg');?>
				<div class='contentCaptionOver yellowBg'>
					<div class="openSansBold">ON VIEW</div>
					<div class="openSansReg">
						ORLANDO RICHARDS<br/>In Bold Colors
					</div>
				</div>
			</div>		
		</div> <!--end col-sm-3-->	
		<div class="col-sm-3">
			<div class='contentBox'>
				<?php print caGetThemeGraphic($this->request, 'donate.jpg');?>
				<div class='contentCaptionOver redBg'>
					<div class="openSansBold">SUPPORT</div>
					<div class="openSansReg">
						Volunteer or Donate!
					</div>
				</div>
			</div>		
		</div> <!--end col-sm-3-->
		<div class="col-sm-3">
			<div class='contentBox'>
				<?php print caGetThemeGraphic($this->request, 'events.jpg');?>
				<div class='contentCaptionOver greenBg'>
					<div class="openSansBold">OUTREACH</div>
					<div class="openSansReg">
						K.I.D.S Art Education Program
					</div>
				</div>
			</div>		
		</div> <!--end col-sm-3-->					
	</div><!-- end row -->
</div> <!--end container-->


<!--<div class="container">
	
	<div class="row" style="margin-top:50px;">
		<div class="col-sm-3">
			<div class='contentBox'>
				<div class='contentBanner turqText'>Featured Artist</div>
				<?php print caGetThemeGraphic($this->request, 'artist.jpg');?>
				<div class='contentCaption'>Jane Smith</div>
			</div>
		</div>
		<div class="col-sm-3">
			<div class='contentBox'>
				<div class='contentBanner yellowText'>Current Exhibition</div>
				<?php print caGetThemeGraphic($this->request, 'exhibition.jpg');?>
				<div class='contentCaption'>Annual Benefit Exhibition</div>
			</div>		
		</div>
		<div class="col-sm-3">
			<div class='contentBox'>
				<div class='contentBanner pinkText'>Support</div>
				<?php print caGetThemeGraphic($this->request, 'donate.jpg');?>
				<div class='contentCaption'>Volunteer or Donate!</div>
			</div>		
		</div>
		<div class="col-sm-3">
			<div class='contentBox'>
				<div class='contentBanner greenText'>Events</div>
				<?php print caGetThemeGraphic($this->request, 'events.jpg');?>
				<div class='contentCaption'>Upcoming: Artist Talk</div>
			</div>		
		</div>				
	</div>
</div> -->