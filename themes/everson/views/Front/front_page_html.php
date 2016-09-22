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
		print $this->render("Front/featured_set_slideshow_html.php");
?>
<div class="page-title-container clearfix">
    <h1 class="page-title">American Ceramics & Ceramic National Exhibition Archive</h1>
</div>
			<nav class="navbar navbar-default yamm">
			<form class="navbar-form navbar-right" role="search" action="<?php print caNavUrl($this->request, '', 'MultiSearch', 'Index'); ?>">
				<div class="formOutline">
					<div class="form-group">
						<input type="text" class="form-control" placeholder="Search" name="search">
					</div>
					<button type="submit" class="btn-search"><span class="glyphicon glyphicon-search"></span></button>
				</div>
			</form>	
			<ul class="nav navbar-nav navbar-right">
				<li <?php print ($this->request->getController() == "Collection") ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Collections"), "", "FindingAid", "Collection", "Index"); ?></li>				
				<?php print $this->render("pageFormat/browseMenu.php"); ?>	
				<li <?php print (($this->request->getController() == "Search") && ($this->request->getAction() == "advanced")) ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Advanced Search"), "", "", "Search", "advanced/objects"); ?></li>
				<li <?php print ($this->request->getController() == "Gallery") ? 'class="active"' : ''; ?>><?php print caNavLink($this->request, _t("Gallery"), "", "", "Gallery", "Index"); ?></li>
			</ul>
			</nav>
<div class="container " style="padding-bottom:50px;">

	<div class="row">
		<div class="col-sm-12 pageContent">
			<p>The ceramics collection of the Everson is widely recognized for its magnitude and magnificence. The ceramics collection of the Everson is widely recognized for its magnitude and magnificence. Today, the collection of ceramics numbers over 5,000 pieces that range in date from 1000 CE to the present, including works by ancient Americans of the Southwest to the most cutting-edge examples by contemporary artists.</p>
			<p>Currently one of the largest holdings of American ceramics in the nation, the Everson's collection can be attributed to the decisions made by Carter in the early 20th century. After the initial purchase of Adelaide Alsop Robineau porcelains in 1916, the Everson acquired more of her artworks. Then, in 1932, the Ceramic National exhibitions were established by Anna Wetherill Olmstead at the Museum in Robineau’s memory.</p>
			<p>An important series of exhibitions that ultimately changed the public opinion on ceramics (from craft to art form), the Ceramic Nationals enabled the Everson to amass a singular collection of American ceramics produced in the twentieth century.</p>
			<p>The American Art Pottery collection, a diverse grouping of over 2,000 pieces, includes both hand-crafted ceramics and examples of commercial ware. The Everson has exemplary works by most of the major potters, including Robineau, Rookwood, Fulper, Grueby, Tiffany, George Ohr, Newcomb and Marblehead.</p>
			<p>The period spanning the 1930s to 1960s is documented by significant pieces from the major movements of those decades. In the area of figurative sculpture, there are works by Wayland Gregory, Suzy Singer, Vally Wieselthier, Victor Schreckengost and Guy Cowan. Mid-century pots reflective of European and Japanese influences are by such seminal artists as Warren MacKenzie, Gertrude and Otto Natzler, Ken Ferguson and Paul Soldner. The collection also includes important ceramic works by American innovators Peter Voulkos, Rudy Autio, Beatrice Wood, Robert Arneson and Howard Kottler.</p>
			<p>Recent developments in ceramic sculpture are outlined by works by Michael Lucero, James Makins, Viola Frey, Betty Woodman, Adrian Sax and Ralph Baccera. In addition to the American ceramics collection, the Everson houses collections of ceramics from around the world, numbering around 1,500 pieces. These range in date from a Chinese funerary urn from 3000 BCE to contemporary examples of European and Japanese ceramic art.</p>
			<p>We invite you to visit the Syracuse China Center for the Study of American Ceramics of the Everson Museum of Art to learn more about this collection.</p>
		</div> <!--end col-sm-4-->	
	</div><!-- end row -->
	<hr class="divide">
	<div class="row">
		<div class="col-sm-12 pageContent">
			<div class="pageContentTitle">Access Policy and Terms of Use</div>
				<p>The contents of the Ceramic National Exhibition & American Ceramics Archive, which includes finding aides, guides as well as digital content including correspondence, images, text, audio and video recordings are made publicly available by the Everson Museum of Art as the owner of the contents for use in research, teaching, and private study.</p>
				<p>The nature of historical archival and manuscript collections often makes it difficult to determine the copyright status of a particular item. Whenever possible, the Everson Museum provides available information about copyright owners and other restrictions in the metadata associated with digital images, texts, and audio and video recordings. This information is provided as a service to assist the user in determining the copyright status of an item. Ultimately, however, it is the user's responsibility to use an item according to the terms governing its use.</p>
				<p>The Everson Museum or Art is eager to hear from any copyright owners who are not properly identified so that appropriate information may be provided to researchers and teachers in the future. The museum will work with copyright holders in a timely manner to address the removal material from public view while we address any copyright concerns or other issues such as libel or invasion of privacy.</p>
			<div class="pageContentTitle">Conditions of Use</div>
			<p>By their use of these digital materials, images, texts, and audio and video recordings, users agree to the following conditions:</p>
			<ul>
				<li><b>1.</b>	Responsibility for any use of these materials rests exclusively with the user.</li>
				<li><b>2.</b>	Some materials in these collections may be protected by the U.S. Copyright Law (Title 17, U.S.C.). In addition, the reproduction of some materials may be restricted by terms of gift or purchase agreements, donor restrictions, privacy and publicity rights, licensing and trademarks. Transmission or reproduction of materials protected by copyright beyond that allowed by copyright law requires the written permission of the copyright owners.</li>
				<li><b>3.</b>	In many cases, the Everson Museum of Art does not hold the copyright to materials in its collections. If the work is not in the public domain, it is the responsibility of the researcher to secure permission from the appropriate copyright holder to publish items from the Archive.</li>
				<li><b>4.</b>	Permission to publish must be applied for separately by completing and submitting a Permission & Reproduction form. </li>
				<li><b>5.</b>	The Everson Museum requires the following credit line in citations and bibliographies for research publications:<br/><br/><p>For Archive Material:<br/> <i>Collection of Everson Museum of Art, Ceramic National Exhibition & American Ceramics Archive</i></p><p>For Permanent Collection Material:<br/> <i>Everson Museum of Art, Permanent Collection</i></p></li>
			</ul>
		</div>
	</div>
</div> <!--end container-->