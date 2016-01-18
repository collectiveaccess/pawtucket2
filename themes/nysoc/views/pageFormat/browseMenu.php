<?php
/* ----------------------------------------------------------------------
 * views/pageFormat/browseMenu.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2014-2015 Whirl-i-Gig
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
 * ----------------------------------------------------------------------
 */
 
	$va_browse_types = caGetBrowseTypes(array('forMenuBar' => true));
	$o_config = caGetBrowseConfig();
	
	$vb_dont_preload_browse_menu = (bool)$o_config->get('dontPreloadBrowseMenu');
	
	if(sizeof($va_browse_types)){
		switch($o_config->get("browseMenuFormat")){
			# ------------------------------------------------
			case "list":
				if(sizeof($va_browse_types) > 1){
?>
				<li class="item dropdown<?php print ($this->request->getController() == "Browse") ? ' active' : ''; ?>" style="position:relative;" id="menuId-3"><a href="#" class="dropdown-toggle mainhead top" data-toggle="dropdown"><?php print _t("Search & Browse"); ?></a>
					<ul class="dropdown-menu">
<?php
						foreach($va_browse_types as $vs_browse_name => $va_browse_type){
							print "<li>".caNavLink($this->request, caUcFirstUTF8Safe($va_browse_type['displayName']), '', '', 'Browse', $vs_browse_name, '')."</li>";
						}
?>
					</ul>	
				</li>
<?php				
				}else{
?>
					<li <?php print ($this->request->getController() == "Browse") ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Browse"), "", "", "Browse", key($va_browse_types)); ?></li>
<?php
				}
			break;
			# ------------------------------------------------
			default:
				$vs_first_browse = null;
?>
				 <li id="menuId-3" class="item dropdown yamm-fw<?php print ($this->request->getController() == "Browse") ? ' active' : ''; ?>"> <!-- add class yamm-fw for full width-->
					<a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php print _t("Browse"); ?></a>
					<ul class="dropdown-menu" id="browse-menu">
						<li class="browseNavFacet">			
							<div class="browseMenuContent container">
<?php
						if(sizeof($va_browse_types) > 1){
							# --- only show browse targets if there are more than one
?>	
								<div class="mainfacet">
										<ul class="nav nav-pills">			
<?php
											foreach($va_browse_types as $vs_browse_name => $va_browse_type){
												print "<li><div class='browseHeadernav caps".((!$vb_dont_preload_browse_menu && !$vs_first_browse) ? " active" : "")."'><a href='#' onclick='jQuery(\"#browseMenuTypeFacet\").load(\"".caNavUrl($this->request, '*', 'Browse', 'getBrowseNavBarByTarget', array('target' => $vs_browse_name))."\"); jQuery(\".browseHeadernav\").removeClass(\"active\"); jQuery(this).parent().addClass(\"active\"); return false;'>".caUcFirstUTF8Safe($va_browse_type['displayName'])."</a></div></li>";
												if(!$vs_first_browse){
													$vs_first_browse = $vs_browse_name;
												}
											}
?>
										</ul>
								</div><!--end main facet-->
<?php
						} else {
							$vs_first_browse = key($va_browse_types);
							$va_first_browse = array_pop($va_browse_types);
						}
?>
								<div id="browseMenuTypeFacet" > </div>
							</div><!-- end browseMenuContent container -->		
						</li><!-- end browseNavFacet -->
					</ul> <!--end dropdown-browse-menu -->	
				 </li><!-- end dropdown -->
<?php
	if (!$vb_dont_preload_browse_menu) {
?>
					<script type="text/javascript">
						jQuery('.dropdown-toggle').dropdown()
						jQuery(document).ready(function() {		
							jQuery("#browseMenuTypeFacet").load("<?php print caNavUrl($this->request, '*', 'Browse', 'getBrowseNavBarByTarget', array('target' => $vs_first_browse)); ?>");
						});
					</script>
<?php
	}
			break;
			# ------------------------------------------------
		}
	}