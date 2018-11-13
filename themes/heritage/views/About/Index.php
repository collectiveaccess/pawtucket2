<?php
	MetaTagManager::setWindowTitle($this->request->config->get("app_display_name").": About");
?>

	<div class="row">
		<div class="col-sm-12">
<?php
		if($this->request->isLoggedIn()){
?>
			<H1><?php print _t("Learn from our past to innovate for the future"); ?></H1>
<?php
		}
?>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-8">
<?php
		if($this->request->isLoggedIn()){
			$t_lists = new ca_lists();
			$vn_findging_aids_id = $t_lists->getItemID("subjects", "Finding Aid");

?>
			<ul class="about">
				<li><i class="fa fa-chevron-circle-right"></i> The Steelcase digital archive provides online access to selected items from the corporate collection of images, documents, publications, video, speeches, and more.</li>
				<li><i class="fa fa-chevron-circle-right"></i> Milestones curated here feed our public timeline; save your favorites to create your own custom timelines.</li>
				<li><i class="fa fa-chevron-circle-right"></i> The items found here are a small representation of physical items housed in the corporate archive stacks.</li>
				<li><i class="fa fa-chevron-circle-right"></i> The majority of the material is brand related and dates from the early 1900s to the late 1990s..</li>
				<li><i class="fa fa-chevron-circle-right"></i> High-level <?php print caNavLink($this->request, "Finding aids", "", "", "Browse", "objects", array("facet" => "term_facet", "id" => $vn_findging_aids_id)); ?> will give you a deeper dive of what's in the stacks.</li>
				<li><i class="fa fa-chevron-circle-right"></i> Downloading files to share outside of Steelcase is not permissible unless permission/clearance from the Archives, Corporate Communications, Brand team and/or Legal departments is obtained.</li>
				<li><i class="fa fa-chevron-circle-right"></i> Hi-res tiff files exist for many of the jpg's; <a href="https://support.steelcase.com/ssp?id=sc_cat_item&sys_id=8d7a1e050fb63600423a590be1050e87" target="_blank">fill out a request form</a> if Tiff files or other records are needed</li>
				<li><i class="fa fa-chevron-circle-right"></i> Please adhere to copyright laws (files with models from agencies; files not published by Steelcase; etc.)</li>
				<li><i class="fa fa-chevron-circle-right"></i> Crowdsourcing encouraged. If you know details about a specific file please share with us by adding Comments and Tags (identifying people, locations, year, product will help create a better experience for others)</li>
			</ul>
<?php		
		}else{
?>
			<p>
				We opened our doors in 1912 after 11 business men agreed to invest in Peter M. Wege's dream of opening a steel office furniture company in a city renown for wood furniture. Since then we've experienced many changes, including our name, but our business vision of always looking toward the future has remained the same. 
 			</p>
 			<p>
				Here we'd like to share with you a few hundred of thousands of noteworthy milestones from our 106-year plus legacy. Steelcase employees and partners can view additional milestones and access the digital archives when logged in.   
			</p>
<?php
		}
?>
<!--
			<ul class="about">
				<li><i class="fa fa-chevron-circle-right"></i> The Steelcase digital archive is a small representation of physical items housed in the corporate archive stacks.</li>
				<li><i class="fa fa-chevron-circle-right"></i> The majority of the material is brand related and dates from the early 1900s to the late 1990s. </li>
				<li><i class="fa fa-chevron-circle-right"></i> High-level Finding aids will give you a deeper dive of what's in the stacks. </li>
				<li><i class="fa fa-chevron-circle-right"></i> The digital items are available only to Steelcase employees and select vendors and partners.</li>
				<li><i class="fa fa-chevron-circle-right"></i> Downloading files to share outside of Steelcase is not permissible unless permission/clearance from the Archives, Corporate Communications, Brand team and/or Legal departments is obtained.</li>
				<li><i class="fa fa-chevron-circle-right"></i> Hi-res tiff files exist for many of the jpg's; contact the archives if a Tiff file is needed</li>
				<li><i class="fa fa-chevron-circle-right"></i> Please adhere to copyright laws (files with models from agencies; files not published by Steelcase; etc.)</li>
				<li><i class="fa fa-chevron-circle-right"></i> If you know details about a specific file please share those with us by adding Comments and Tags (identifying people, locations, year, product will help create a better experience for others)</li>
			</ul>
-->
		</div>
		<div class="col-sm-3 col-sm-offset-1">
			<address>
				<b>Steelcase Archives</b><br>
				901 44th Street SE<br/>
				SULC MEZZ<br/>
				Grand Rapids, MI  49508<br/>
			</address>
		
			<address><b>Kathy Reagan, Program Manager</b>
				<br><span class="info">Phone</span> — 616.437.2246<br>			
				<span class="info">Email</span> — <a href="mailto:kreagan@steelcase.com">kreagan@steelcase.com</a></address>
		</div>
	</div>