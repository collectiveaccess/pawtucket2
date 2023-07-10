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
	
	if(sizeof($va_browse_types)){
		if (!($vs_format = $o_config->get("browseMenuFormat"))) { $vs_format = $o_config->get("browse_menu_format"); }
		switch($vs_format){
			case "list":
				if(sizeof($va_browse_types) > 1){
?>
				<li class="dropdown<?php print ($this->request->getController() == "Browse") ? ' active' : ''; ?>" style="position:relative;"><a href="#" class="dropdown-toggle mainhead top" data-toggle="dropdown"><?php print $o_config->get("browse_menu_button_text") ? $o_config->get("browse_menu_button_text") : _t("Browse"); ?></a>
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
					<li <?php print ($this->request->getController() == "Browse") ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, ($o_config->get("browse_menu_button_text") ? $o_config->get("browse_menu_button_text") : _t("Browse")), "", "", "Browse", key($va_browse_types)); ?></li>
<?php
				}
				break;
			# ------------------------------------------------
			default:
				$vs_first_browse = null;
?>
				 <li class="dropdown yamm-fw<?php print ($this->request->getController() == "Browse") ? ' active' : ''; ?>"> <!-- add class yamm-fw for full width-->
					<a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php print ($o_config->get("browse_menu_button_text") ? $o_config->get("browse_menu_button_text") : _t("Browse")); ?></a>
					<ul class="dropdown-menu" id="browse-menu">
						<li class="browseNavFacet">			
							<div class="browseMenuContent container">
<?php
						if(sizeof($va_browse_types) > 1){
							# --- only show browse targets if there are more than one
?>	
								<div class="row">
									<div class="mainfacet col-sm-12">
										<ul class="nav nav-pills">			
<?php
											foreach($va_browse_types as $vs_browse_name => $va_browse_type){
												print "<li><div class='browseHeadernav caps".((!$vs_first_browse) ? " active" : "")."'><a href='#' onclick='jQuery(\"#browseMenuTypeFacet\").load(\"".caNavUrl($this->request, '', 'Browse', 'getBrowseNavBarByTarget', array('target' => $vs_browse_name))."\"); jQuery(\".browseHeadernav\").removeClass(\"active\"); jQuery(this).parent().addClass(\"active\"); return false;'>".caUcFirstUTF8Safe($va_browse_type['displayName'])."</a><b class='caret'></b></div></li>";
												if(!$vs_first_browse){
													$vs_first_browse = $vs_browse_name;
												}
											}
?>
										</ul>
									</div><!--end main facet-->
								</div>
<?php
						} else {
							$vs_first_browse = key($va_browse_types);
							$va_first_browse = array_pop($va_browse_types);
						}
?>
								<div id="browseMenuTypeFacet" class='row'> </div>
							</div><!-- end browseMenuContent container -->		
						</li><!-- end browseNavFacet -->
					</ul> <!--end dropdown-browse-menu -->	
				 </li><!-- end dropdown -->
					<script type="text/javascript">
						jQuery('.dropdown-toggle').dropdown()
						jQuery(document).ready(function() {		
							jQuery("#browseMenuTypeFacet").load("<?php print caNavUrl($this->request, '', 'Browse', 'getBrowseNavBarByTarget', array('target' => $vs_first_browse)); ?>");
						});
					</script>
<?php
				break;
			# ------------------------------------------------
		}
	}
