<?php
/* ----------------------------------------------------------------------
 * views/pageFormat/pageFooter.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2015 Whirl-i-Gig
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
?>
<div style="clear:both; height:1px;"><!-- empty --></div>
	</div><!-- end pageArea --></div><!-- end col --></div><!-- end row --></div><!-- end container -->
	<footer id="footer">
	<div class="container">		
		<div class="row">
		<div class="col-xs-12 col-sm-5 col-md-4">					
		<div class="logo-section" style="display:inline-block;line-height: 0.9em;float:left;margin-right:12px;">
				<div class="clearfix">	
			<a href="http://www.umontreal.ca"><img class="img-responsive" src="/themes/umontreal/assets/pawtucket/graphics/logo_udm_blanc.png" style="height:80px;width:auto"></a>								
			</div>
			</div>
			<div class= inline-block>
		<br>
		<br>
		<br>	
		<br>
		<br>
		<ul style="margin-left: 20 px">
			<li><a href="http://www.umontreal.ca/#udemwww-search-sites"><span class="glyphicon glyphicon-search"></span>RÉPERTOIRES</a></li>
			<li><a href="https://admission.umontreal.ca/"><span class="glyphicon glyphicon-check"></span>ADMISSION ET PROGRAMMES</a></li>
			<li><a href="http://www.umontreal.ca/facultes-et-ecoles"><span class="glyphicon glyphicon-star"></span>FACULTÉS ET ÉCOLES</a></li>
			<li><a href="http://www.bib.umontreal.ca"><span class="glyphicon glyphicon-book"></span>BIBLIOTHÈQUES</a></li>
			<li><a href="http://plancampus.umontreal.ca/montreal"><span class="glyphicon glyphicon-map-marker"></span>PLAN CAMPUS</a></li>
			<li><a href="http://www.umontreal.ca/sites-a-z"><span class="glyphicon glyphicon-cog"></span>SITES A-Z</a></li>
			<li><a href="https://monportail.umontreal.ca"><span class="glyphicon glyphicon-user"></span>MON PORTAIL UdeM</a></li>
		</ul>
		</div>
			</div>		
		<div class="col-xs-12 col-sm-7 col-md-8">
		<div class="row">
		<div class="col-xs-6 col-sm-6 col-md-6">
			<h6><a href="http://anthropo.umontreal.ca/accueil">Département d'<b>anthropologie</b></a></h6>
		<ul>
			<li><a href="http://anthropo.umontreal.ca/programmes-cours">Programmes, cours et horaires</a></li>
			<li><a href="http://anthropo.umontreal.ca/recherche">La recherche</a></li>
			<li><a href="http://anthropo.umontreal.ca/ressources-services">Ressources et services</a></li>
			<li><a href="http://anthropo.umontreal.ca/repertoire-departement">Répertoire du département</a></li>
			<li><a href="http://anthropo.umontreal.ca/departement">Notre département</a></li>
		</ul>
		<br>
			<p> Adresse :<br/>
				Pavillon Lionel-Groulx<br/>
				3150 Jean-Brillant<br/>
				Montréal QC H3T 1N8<br/>
				T : 514 343-6560
			</p>
		</div>

		<div class="col-xs-6 col-sm-6 col-md-6">
			<h6><a href="http://anthropo.lescollections.org" style="text-decoration: none">Collection <b>ethnographique</b></a></h6>

		<ul>
			<li><a href="index.php/About/Le_laboratoire">Présentation</a></li>
			<li><a href="index.php/About/Enseignement">Activités</a></li>
			<li><a href="index.php/About/Partenaires">Partenaires</a></li>
		</ul>

		<ul>
			<li><a href="index.php/About/Collections">Collections</a></li>
			<li><a href="index.php/Browse/objects">Recherche</a></li>
		</ul>

		<ul>
			<li><a href="index.php/Browse/occurrences">Expositions</a></li>
			<li><a href="index.php/Gallery/Index">Parcours thématiques</a></li>
		</ul>
		<br>
		<p><a href="index.php/About/Contact" style="text-decoration: none"><span class="glyphicon glyphicon-envelope"></span>Nous joindre</a></p>

	</div>			
	</div>				
		<div><p style="text-align: right;color:lightgray;"><small>Utilise <a style="color:lightgray;" href="http://www.collectiveaccess.org">CollectiveAccess</a> déployé par <a style="color:lightgray;" href="http://www.ideesculture.com">idéesculture</a></small></p></div>
	</div>	
		</div>	
		</footer><!-- end footer -->
<?php
	//
	// Output HTML for debug bar
	//
	if(Debug::isEnabled()) {
		print Debug::$bar->getJavascriptRenderer()->render();
	}
?>
	
		<?php print TooltipManager::getLoadHTML(); ?>
		<div id="caMediaPanel"> 
			<div id="caMediaPanelContentArea">
			
			</div>
		</div>
		<script type="text/javascript">
			/*
				Set up the "caMediaPanel" panel that will be triggered by links in object detail
				Note that the actual <div>'s implementing the panel are located here in views/pageFormat/pageFooter.php
			*/
			var caMediaPanel;
			jQuery(document).ready(function() {
				if (caUI.initPanel) {
					caMediaPanel = caUI.initPanel({ 
						panelID: 'caMediaPanel',										/* DOM ID of the <div> enclosing the panel */
						panelContentID: 'caMediaPanelContentArea',		/* DOM ID of the content area <div> in the panel */
						exposeBackgroundColor: '#FFFFFF',						/* color (in hex notation) of background masking out page content; include the leading '#' in the color spec */
						exposeBackgroundOpacity: 0.7,							/* opacity of background color masking out page content; 1.0 is opaque */
						panelTransitionSpeed: 400, 									/* time it takes the panel to fade in/out in milliseconds */
						allowMobileSafariZooming: true,
						mobileSafariViewportTagID: '_msafari_viewport',
						closeButtonSelector: '.close'					/* anything with the CSS classname "close" will trigger the panel to close */
					});
				}
			});
			/*(function(e,d,b){var a=0;var f=null;var c={x:0,y:0};e("[data-toggle]").closest("li").on("mouseenter",function(g){if(f){f.removeClass("open")}d.clearTimeout(a);f=e(this);a=d.setTimeout(function(){f.addClass("open")},b)}).on("mousemove",function(g){if(Math.abs(c.x-g.ScreenX)>4||Math.abs(c.y-g.ScreenY)>4){c.x=g.ScreenX;c.y=g.ScreenY;return}if(f.hasClass("open")){return}d.clearTimeout(a);a=d.setTimeout(function(){f.addClass("open")},b)}).on("mouseleave",function(g){d.clearTimeout(a);f=e(this);a=d.setTimeout(function(){f.removeClass("open")},b)})})(jQuery,window,200);*/
			
			$(document).ready(function() {
				$("BODY > DIV.container").on("click", function() {
					$("#bs-main-navbar-collapse-1").collapse("hide");
					$("#user-navbar-toggle").collapse("hide");
				});
				$("BODY > FOOTER").on("click", function() {
					$("#bs-main-navbar-collapse-1").collapse("hide");
					$("#user-navbar-toggle").collapse("hide");
				});
			});
		</script>
	</body>
</html>
