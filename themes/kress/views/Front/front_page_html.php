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
	
	$va_access_values = $this->getVar("access_values");
	AssetLoadManager::register('timeline');
 	
?>
<div class="parallax">
	<div class="container">
		<div class="row">
			<div class="col-xs-12 col-sm-6 col-sm-offset-3">
				
				<div class="heroSearch">
					Welcome to the<br/>
					<H1>Kress Collection<br/>Digital Archive</H1>
					<form role="search" action="<?php print caNavUrl($this->request, '', 'MultiSearch', 'Index'); ?>">
						<div class="formOutline">
							<div class="form-group">
								<input type="text" class="form-control" id="heroSearchInput" placeholder="Search" name="search" autocomplete="off" />
							</div>
							<button type="submit" class="btn-search" id="heroSearchButton"><span class="glyphicon glyphicon-search"></span></button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="container hpIntro">
	<div class="row">
		<div class="col-sm-12 col-md-6 col-md-offset-3">
			<p class="callout">The <br/><b>Kress Collection Digital Archive</b><br/>{{{home_intro_text}}}</p>

			<p>Enter keywords into the search box above or browse <?php print caNavLink($this->request, "Art Objects", "", "", "Browse", "objects"); ?>, <?php print caNavLink($this->request, "Archival Materials", "", "", "Browse", "archival"); ?>, Events (<?php print caNavLink($this->request, "Acquisitions", "", "", "Browse", "Acquisitions"); ?> and <?php print caNavLink($this->request, "Distributions", "", "", "Browse", "distributions"); ?>), and <?php print caNavLink($this->request, "People and Organizations", "", "", "Browse", "entities"); ?> below.</p>

		</div>
	</div>
</div>
<div class="container">
	<div class="row hpExplore">
		<div class="col-sm-10 col-sm-offset-1 text-center"> 
			<div class="row">
				<div class="col-sm-6 exploreTile">
	<?php
					print caNavLink($this->request, caGetThemeGraphic($this->request, 'art_sq.jpg'), "", "", "Browse", "objects");
					print caNavLink($this->request, "Art Objects", "hpExploreTitle", "", "Browse", "objects");
					
	?>				
				</div>
				<div class="col-sm-6">
					<div class="row">
						<div class="col-sm-6 exploreTile">
	<?php
							print caNavLink($this->request, caGetThemeGraphic($this->request, 'archival.jpg'), "", "", "Browse", "archival");
							print caNavLink($this->request, "Archival Materials", "hpExploreTitle", "", "Browse", "archival");							
	?>
						</div>
						<div class="col-sm-6 exploreTile">
	<?php
							print caNavLink($this->request, caGetThemeGraphic($this->request, 'people.jpg'), "", "", "Browse", "entities");
							print caNavLink($this->request, "People & Organizations", "hpExploreTitle", "", "Browse", "entities");
	?>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6 exploreTile">
	<?php
							print caNavLink($this->request, caGetThemeGraphic($this->request, 'acquisitions.jpg'), "", "", "Browse", "acquisitions");
							print caNavLink($this->request, "Acquisitions", "hpExploreTitle", "", "Browse", "acquisitions");
														
	?>
			
						</div>
						<div class="col-sm-6 exploreTile">
	<?php
							print caNavLink($this->request, caGetThemeGraphic($this->request, 'distributions.jpg'), "", "", "Browse", "distributions");
							print caNavLink($this->request,"Distributions", "hpExploreTitle", "", "Browse", "distributions");
							
	?>
			
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
</div>
	<div class="row hpTimeline">
		<div class="col-sm-12">
			<H3>History</H3>
			<div id="frontTimelineContainer">
				<div id="timeline-embed"></div>
			</div>
	
			<script type="text/javascript">
				jQuery(document).ready(function() {
					createStoryJS({
						type:       'timeline',
						width:      '100%',
						height:     '400px',
						source:     '<?php print caNavUrl($this->request, '', 'Front', 'timelinejson'); ?>',
						embed_id:   'timeline-embed',
						initial_zoom: '1'
					});
				});
			</script>
		</div>
	</div>
