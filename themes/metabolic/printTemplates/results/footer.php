<?php
/* ----------------------------------------------------------------------
 * app/templates/footer.php : standard PDF report footer
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2014 Whirl-i-Gig
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
 * -=-=-=-=-=- CUT HERE -=-=-=-=-=-
 * Template configuration:
 *
 * @name Footer
 * @type fragment
 *
 * ----------------------------------------------------------------------
 */
 	
 	
	$vo_result 				= $this->getVar('result');
	$vn_num_items			= (int)$vo_result->numHits();
	
	 	$t_item = $this->getVar('t_subject');
	
	if($this->request->config->get('summary_footer_enabled')) {
		$vs_footer = "<div class='pagingText' id='pagingText'>"._t('Page')." <span class='page'></span> "._t('of')." <span class='topage'></span></div>";
		
		switch($this->getVar('PDFRenderer')) {
			case 'wkhtmltopdf':
?>
				<!--BEGIN FOOTER-->
				<!DOCTYPE html>
				<html>
				<head>
					<link type="text/css" href="<?php print $this->getVar('base_path');?>/pdf.css" rel="stylesheet" />
					<script>
						function subst() {
						  var vars={};
						  var x=document.location.search.substring(1).split('&');
						  for(var i in x) {var z=x[i].split('=',2);vars[z[0]] = unescape(z[1]);}
						  var x=['frompage','topage','page','webpage','section','subsection','subsubsection'];
						  for(var i in x) {
							var y = document.getElementsByClassName(x[i]);
							for(var j=0; j<y.length; ++j) y[j].textContent = vars[x[i]];
						  }
						}
					</script>
					<meta charset="utf-8" />
				</head>
				<body onLoad="subst()">
					<div id='footer'>
				<?php
					if($this->request->config->get('report_show_search_term')){
						print "<div class='searchTermText' id='searchTermText'>".str_replace("Search: * / ", "", $this->getVar('criteria_summary'))."</div>";
					}
					print "<div class='pagingText' id='pagingText'>"._t('Page')." <span class='page'></span> "._t('of')." <span class='topage'></span></div>";
				?>
					</div>
				</body>
				</html>
				<!--END FOOTER-->
<?php
			break;
			# -----------------------------------
			default:
?>
				<div id='footerdompdf'>
<?php
					if($this->request->config->get('report_show_search_term')){
						print "<div class='searchTermText' id='searchTermText'>".str_replace("Search: * / ", "", $this->getVar('criteria_summary'))."</div>";
					}
?>
					<div class='pagingText' id='pagingText'><?php print _t('Page'); ?> </div>
				</div>
<?php
			break;
		}
	}