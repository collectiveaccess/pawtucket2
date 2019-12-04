<?php
	MetaTagManager::setWindowTitle($this->request->config->get("app_display_name").": About");
?>

	<div class="row">
		<div class="col-sm-12">
			<H1><?php print _t("About"); ?></H1>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-8">
			<h3>The University of Saskatchewan Art Collection</h3>
			<p>The University of Saskatchewan has collected art objects since 1910, resulting in an eclectic collection that spans many art movements, and consists of a wide variety of styles and subjects.  There have been periods of intense art collection, starting with acquisitions guided by President Walter Murray during the early beginnings of the University through to his retirement in 1937. Augustus Kenderdine, who was the first art professor at the University, is well represented in the collection, and one of our galleries is named in his honor.  He and President Murray were instrumental in starting the Emma Lake / Kenderdine Campus, and many of the artworks collected from the 1930’s through to the 2010’s reflect the artistic activity of that venue, where many international movements and artistic concerns were encountered by attending Saskatchewan artists.  In the 1960’s and 1970’s, the University also had an acquisition initiative that concentrated on the modernist movement in North America and Europe.  With the opening of the Kenderdine Art Gallery in 1991, made possible by the Kenderdine Beamish Trust, the University has received the bulk of its collection through donations by artists and collectors, including art objects that are considered significant cultural property.  </p>
			<p>Collection activities have been varied over the years, with objects entering the Collection in a number of ways: donations, bequests, purchases, and commissions.  The current collection mandate is to acquire art objects that reflect the cultural life and interests of the university community and the Saskatchewan artistic community, as well as the public at large.  This particularly includes the work of Indigenous artists.</p>
			<p>As the property of an educational institution, the primary purpose of the Collection is to utilize art objects as an educational tool and make them available to researchers and educators.  While much of the artwork is displayed throughout the buildings and grounds of the campus, they are also included in curated exhibitions at our galleries.  The educational role of the University of Saskatchewan Art Collection will be enhanced by providing on-line viewers with access to object data and images, and ultimately additional text that provides layered context for each art object.
			
			</p>
			<?php print "<div class='logo' style='width:400px;'>".caGetThemeGraphic($this->request, 'usask_usask_colour.png')."</div>"; ?>
			<br/>
			Visit our website at <a href="https://artsandscience.usask.ca/galleries/">https://artsandscience.usask.ca/galleries/</a>
		</div>
		<div class="col-sm-3 col-sm-offset-1">
			<?php print "<div class='logo'>".caGetThemeGraphic($this->request, 'logo 2013.jpg')."</div>"; ?>
			<h6>&nbsp;</h6><address>Location:<br>
							107 Administration Pl<br>
							University of Saskatchewan Campus<br/>
							Saskatoon, SK S7N 5A2<br/>
							(306) 966-4571</address>
		
			<address>Contact:<br/> Blair Barbeau<br>			<span class="info">Phone</span> — (306) 966 4571<br><a href="mailto:blair.barbeau@usask.ca">blair.barbeau@usask.ca</a></address>
		</div>
	</div>
