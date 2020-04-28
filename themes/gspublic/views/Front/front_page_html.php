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
?>
	<div class="row frontBand about">
		<div class="col-sm-8 noPaddingLeft">
<?php
		$vs_directory = __CA_THEME_DIR__."/assets/pawtucket/graphics/home/welcome/";
		$vn_filecount = 0;
		$va_files = glob($vs_directory . "*");
		if ($va_files){
		 $vn_filecount = count($va_files);
		}
?>
			<?php print caGetThemeGraphic($this->request, 'home/welcome/'.rand(1,$vn_filecount).'.jpg'); ?>
		</div>
		<div class="col-sm-4 textRight">
			<H1>Welcome to the<br/>Girl Scouts of the USA Collections</H1>
			<p>
				The collection of the Girl Scouts of the USA documents the history of the world’s largest female-led global organization for girls. 
			</p>
		</div><!--end col-sm-8-->
	
	</div><!-- end row -->
	<div class="row frontBand browse">
		<div class="col-sm-4  textLeft">
			<h1>Discover the Collection</h1>
			<p>Journey through the rich cultural history of Girl Scouts of the USA. Discover where it all began by clicking through to explore the collection.</p>
<?php
			print caNavLink($this->request, 'Explore', 'btn-default', '', 'About', 'browse');
?>			
		</div>	
		<div class="col-sm-8 noPaddingRight">
<?php
		$vs_directory = __CA_THEME_DIR__."/assets/pawtucket/graphics/home/discover/";
		$vn_filecount = 0;
		$va_files = glob($vs_directory . "*");
		if ($va_files){
		 $vn_filecount = count($va_files);
		}
?>
			<?php print caGetThemeGraphic($this->request, 'home/discover/'.rand(1,$vn_filecount).'.jpg'); ?>	
		</div>			
	</div>				
	<div class="row frontBand galleryFront">
		<div class="col-sm-8 noPaddingLeft">
<?php
		$vs_directory = __CA_THEME_DIR__."/assets/pawtucket/graphics/home/gallery/";
		$vn_filecount = 0;
		$va_files = glob($vs_directory . "*");
		if ($va_files){
		 $vn_filecount = count($va_files);
		}
?>
			<?php print caGetThemeGraphic($this->request, 'home/gallery/'.rand(1,$vn_filecount).'.jpg'); ?>		
		</div>	
		<div class="col-sm-4 textRight">
			<h1>Featured Galleries & Interactives</h1>
			<p>Explore iconic Girl Scout moments. Take a virtual walk through the interactive galleries.</p>
<?php
			print caNavLink($this->request, 'galleries', 'btn-default', '', 'Gallery', 'Index');
			print "&nbsp;&nbsp;&nbsp;".caNavLink($this->request, 'Interactives', 'btn-default', '', 'Interactive', 'Index');
?>		
		</div>	
	</div>	
	<div class="row frontBand collections">
		<div class="col-sm-4 textLeft">
			<h1>Research Collections</h1>
			<p>For over 100 years Girl Scouts have been at the forefront of empowering others and striving to make a difference. Delve deeper into Girl Scout history through the Research Collections.</p>
<?php
			print caNavLink($this->request, 'More', 'btn-default', '', 'Collections', 'Index');
?>			
		</div>		
		<div class="col-sm-8 noPaddingRight">
<?php
		$vs_directory = __CA_THEME_DIR__."/assets/pawtucket/graphics/home/research/";
		$vn_filecount = 0;
		$va_files = glob($vs_directory . "*");
		if ($va_files){
		 $vn_filecount = count($va_files);
		}
?>
			<?php print caGetThemeGraphic($this->request, 'home/research/'.rand(1,$vn_filecount).'.jpg'); ?>
		</div>	
	</div>
			
