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
# --- get the narrative threads to link to browses
	$t_list = new ca_lists();
	$va_narrative_threads = $t_list->getItemsForList("narrative_thread", array("extractValuesByUserLocale" => true));
#print_r($va_narrative_threads);	
?>
	<div class="row frontSearchRow">
		<div class="col-sm-12 frontSearchCol">
				<form role="search" class="form-inline" action="<?php print caNavUrl($this->request, '', 'MultiSearch', 'Index'); ?>">
					<div class="formOutline">
						<div class="form-group form-group-lg">
							<input class="form-control" placeholder="Search the collection" name="search" type="text">
						</div>
						<button type="submit" class="btn-search"><span class="glyphicon glyphicon-search"></span></button>
					</div>
				</form>

		</div>
	</div>
	<div class="row">
		<div class="col-sm-12 col-md-8 col-md-offset-2">
			<br/>
			<br/>
			<br/>
			<H1>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis vulputate, orci quis vehicula eleifend, metus elit laoreet elit.</H1>
			<br/>
			<br/>
			<br/>
		</div>
	</div>
	<div class="row blackBg">
		<div class="col-sm-5 col-md-3 col-md-offset-1">
			<br/><br/><br/><br/><br/>
			<H2>Duis vulputate, orci quis vehicula eleifend</H2>
			<H3>Metus elit laoreet elit</H3>
			<br/>
			<p>
				Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis vulputate, orci quis vehicula eleifend, metus elit laoreet elit. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis vulputate, orci quis vehicula eleifend, metus elit laoreet elit.
			</p>
			<p class="text-center">
				<br/><a href="#" class="btn-default outline">MORE</a>
			</p>
		</div>
		<div class="col-md-7  col-md-offset-1 bleed">
			<?php print caGetThemeGraphic($this->request, 'hptest3.jpg'); ?>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12 col-lg-10 col-lg-offset-1">
			<br/>
			<br/>
			<br/>
			<br/>
			<br/>
			<br/><H2>Explore by Narrative Thread</H2>
			<div class="row">
<?php
			if(is_array($va_narrative_threads) && sizeof($va_narrative_threads)){
				foreach($va_narrative_threads as $vn_item_id => $va_narrative_thread){
					#$va_narrative_thread = array_pop($va_narrative_thread);
					print "<div class='col-sm-3'>".caNavLink($this->request, "<div class='frontIconButton'><span>".$va_narrative_thread["name_singular"]."</span></div>", "", "", "Browse", "objects", array("facet" => "narrative_threads_facet", "id" => $vn_item_id))."</div>";
				}
			}
?>
			</div>
			<br/>
			<br/>
			<br/>
			<br/>
			<br/>
			<br/>
		</div>
	</div>
	<div class="row blackTan">
		<div class="col-md-12 col-lg-10 col-lg-offset-1">
			<br/>
			<br/>
			<br/>
			<H1>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis vulputate, orci quis vehicula eleifend, metus elit laoreet elit.</H1>
			<br/>
			<br/>
			<br/>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12 col-lg-10 col-lg-offset-1">
			<br/>
			<br/>
			<br/>
			<H2>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis vulputate, orci quis vehicula eleifend, metus elit laoreet elit.</H2>
			<br/>
			<br/>
			<br/>
		</div>
	</div>


<?php
		#print $this->render("Front/featured_set_slideshow_html.php");
?>

<script type='text/javascript'>
	jQuery(document).ready(function() {
		$('.notificationMessage').delay(1000).fadeOut('slow');
	});
</script>