<?php
	MetaTagManager::setWindowTitle($this->request->config->get("app_display_name").": About");
?>

	<div class="row">
		<div class="col-sm-6 col-sm-offset-1">
			<H1><?php print _t("About the Library and Archives"); ?></H1>
			<p>The Hauck Memorial Library and Archives is named in honor of Mrs. Sarah Embich Hauck (1842–1934), who posthumously provided the Lebanon County Historical Society with its first wholly-owned facility at Sixth and Walnut Streets in Lebanon, Pennsylvania.  It is a non-circulating repository for Lebanon County history and genealogy. </p>

			<p style='font-weight:bold;'>Some of our main genealogical sources include:</p>	
			<ul>
				<li>church histories, records, and cemetery surveys</li>
				<li>federal census records</li>
				<li>local newspapers on microfilm, including Pennsylvania German publications</li>
				<li>historical maps and city business directories</li>
				<li>county marriage records on microfilm from 1886 through 1949</li>
				<li>several hundred compiled family histories</li>
				<li>family and individual manuscript collections on dozens of surnames</li>
				<li>high school yearbooks</li>
			</ul>
			
			<p style='font-weight:bold;'>We also hold a vast collection of local history resources including, but not limited to: </p>	
			<ul>
				<li>a variety of photographs and postcards of local places, businesses, and people</li>
				<li>World War II veterans clipping files</li>
				<li>Bethlehem Steel, Lebanon Steel Foundry, and many other local industry and business records and memorabilia</li>
				<li>Railroad, Union Canal, and other transportation industry records</li>
				<li>the Coleman collection (MG-182; see LCHS website) </li>
				<li>school publications, photographs, and records</li>
				<li>Firefighters' Association and local fire company records</li>
				<li>Woman's Club, YMCA, Boy Scout, Chamber of Commerce, and many other organization records</li>
				<li>historical publications from the surrounding counties</li>
				<li>a library of Pennsylvania history books</li>
			</ul>			
			<p style='font-weight:bold;'>Please read our policies on the research archives page (link below) if you anticipate a visit or would like to make a research enquiry.</p>
			<div>
				The Hauck Memorial Library and Archives<br/>
				Lebanon County Historical Society <br/>
				924 Cumberland Street<br/>
				Lebanon, Pennsylvania 17042<br/>	
			</div>
			<br/>
			<div>
				Dr. Adam T. Bentz<br/>
				Archivist & Librarian<br/>
				717-272-1473<br/>
				<a href='mailto:archive@lchsociety.org'>archive@lchsociety.org</a> (preferred)
			</div>			
		</div>
		<div class="col-sm-4 building">
<?php
			print caGetThemeGraphic($this->request, 'about1.jpg');
			print "<br/><br/>";
			print caGetThemeGraphic($this->request, 'about2.jpg');
?>		
		</div>
	</div>