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
<div class="container">
	<div class="row">
		<div class="col-sm-12">
<?php
			global $g_ui_locale;
			if ($g_ui_locale == 'en_US'){			
				print "<h1 class='entry-title'>Database</h1>";
			} else {
				print "<h1 class='entry-title'>Catálogo</h1>";
			}
?>		
			
			<p>
<?php
			
			if ($g_ui_locale == 'en_US'){			
				print "The Database portion of Comedias Sueltas USA is the heart of the website. This searchable union catalog will eventually be a comprehensive source for locating all comedias sueltas held in U.S. academic and research institutions. To find out how many library collections and individual comedias have been entered to date, check the Statistical Table page under ZARZUELA. Researchers can search the database using the browse function and by filtering the results, using a keyword search, or using the advanced search page for an array of search fields in addition to author and title: translator, printer, publisher, bookseller, place and date of publication, provenance, holding institution, and other useful categories. The Zarzuela page will feature news and updates not only of this website, but information about comedias sueltas elsewhere as well.";
			} else {
				print "La base de datos de ComediasSueltasUSA es el centro neurálgico de nuestra web. Este catálogo colectivo digital será con el tiempo una fuente exhaustiva de comedias sueltas en bibliotecas académicas estadounidenses. Actualmente contiene casi 3500 registros bibliográficos de cinco instituciones, Smith College (Massachusetts), Queens College (City University of New York), la Universidad de Texas A&M, la Universidad de Carolina del Norte en Chapel Hill, y la Universidad de Texas en Austin. Los investigadores pueden explorar el catálogo según categorías generales, filtrando los resultados, y pueden hacer búsquedas con palabras clave o mediante la página de búsqueda avanzada, con un conjunto de campos que incluyen, además de autor y título, las categorías de traductor, impresor, editor, librero, año y lugar de publicación, procedencia, propietario institucional y otras igualmente útiles. Os invitamos a consultar nuestra página “Zarzuela” (cuyo enlace está en el menú arriba) para las últimas noticias sobre el estado de este sitio web.";
			}
?>			
			</p>
		</div><!--end col-sm-8-->	
	</div><!-- end row -->
</div> <!--end container-->
<hr>
<?php
	print $this->render("Front/featured_set_slideshow_html.php");
?>