<?php
/* ----------------------------------------------------------------------
 * app/templates/summary/ca_collections_summary.php
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
 * @name Collection Finding Aid
 * @type page
 * @pageSize letter
 * @pageOrientation portrait
 * @tables ca_collections
 * @marginTop 0.75in
 * @marginLeft 0.5in
 * @marginRight 0.5in
 * @marginBottom 0.75in
 *
 * ----------------------------------------------------------------------
 */
 
 	$va_licensing_form_elements = $this->getVar("licensing_form_elements");
 	
 	$pn_id = $this->getVar("id");
	$ps_table = $this->getVar("table");
	$va_object_ids = $this->getVar("object_ids");
	$va_object_information = $this->getVar("object_information");
	$vs_site_host = $this->request->config->get("site_host");
?>
	<html>
		<head>
			<title><?php print _t('Image Licensing / Reproduction Form'); ?></title>
			<link type="text/css" href="<?php print $this->getVar('base_path');?>/pdf.css" rel="stylesheet" />
			<meta charset="utf-8" />
		</head>
		<body class="imageLicensingForm">
<?php

	print $this->render("header_image_licensing.php");
	print $this->render("footer_image_licensing.php");	

?>
		<br/><div class="unit"><?php print date("n/j/Y"); ?></div>
				
		<br><p>This agreement licenses the user for one time use of the video, audio recordings, or images below. User agrees to the conditions listed on the last page</p>
		
		<div class="unit"><H2>User Information</H2></div>
		<table border="0" width="100%">
			<tr>
				<td style="width:50%;" valign="middle">	
					<div class="unit"><b>Name</b>: <?php print $this->getVar("name"); ?></div>
					<div class="unit"><b>Company</b>: <?php print $this->getVar("company"); ?></div>
					<div class="unit"><b>Address</b>:<br/><?php print $this->getVar("address")."<br/>".$this->getVar("city").", ".$this->getVar("state")." ".$this->getVar("postal_code")." ".$this->getVar("country"); ?></div>
				</td>
				<td style="width:50%; padding-left:25px;" valign="middle">	
					<div class="unit"><b>Email</b>: <?php print $this->getVar("email"); ?></div>
					<div class="unit"><b>Telephone</b>: <?php print $this->getVar("telephone"); ?></div>
					<div class="unit"><b>Fax</b>: <?php print $this->getVar("fax"); ?></div>
				</td>
			</tr>
		</table>
		
		<div class="unit"><H2>Intended Use</H2></div>
		<p>
			License fees are assessed according to the intended use of the video, audio, or image.<br/><b>License fees are not charged for materials in the public domain.</b>
		</p>
		<table border="0" width="100%">
			<tr>
				<td style="width:50%;" valign="middle">	
					<div class="unit"><b>Use</b>: <?php print $this->getVar("use"); ?></div>
				</td>
				<td style="width:50%; padding-left:25px;" valign="middle">	
			
<?php					
				$va_use_fields = array("use_publication_title", "use_publication_publisher", "use_publication_date", "use_publication_print_run", "use_commercial_print_distribution", "use_commercial_print_print_run", "use_commercial_video_tv_title", "use_commercial_video_air_date", "use_commercial_video_copies", "use_commercial_exhibit_location", "use_commercial_exhibit_duration", "use_other");
				foreach($va_use_fields as $vs_use_field){
					$vs_tmp = $this->getVar($vs_use_field);
					if($vs_tmp){
						print "<div class='unit'><b>".$va_licensing_form_elements[$vs_use_field]["label"]."</b>: ".$vs_tmp."</div>";
					}
				}
?>
				</td>
			</tr>
		</table>
<?php
		if($vs_message = $this->getVar("message")){
?>

			<div class="unit"><H2>Additional Comments</H2></div>
			<div class="unit"><b>Comments</b>: <?php print $vs_message; ?></div>
<?php
		}

				if(is_array($va_object_information) && sizeof($va_object_information)){
?>
					<div class="unit"><H2>Details of Order</H2></div>
					<table border="0" class="items" width="100%">
<?php
					foreach($va_object_information as $vn_object_id => $va_item_info){
?>					
							<tr>
								<td style="width:30%;" valign="top"><br/>
									<div class="unit">
<?php
										if($vs_img = $va_item_info["image"]){
											print $vs_img;
										}
										
?>
									</div><!-- end unit -->
								<br/></td>
								<td style="width:70%;" valign="top"><br/>
								
<?php
								$vs_url = $vs_site_host.caNavUrl($this->request, "Detail", "objects", $vn_object_id);
										
								foreach($va_item_info["fields"] as $va_field){
									print '<div class="unit"><b>'.$va_field['label'].'</b>: '.$va_field['value'].'</div>'; 
								}
								print "<div class='unit'><b>Item</b>: <a href='".$vs_url."'>".$va_item_info["idno"].": ".$va_item_info["title"]."</a></div>";
								print "<div class='unit'><b>URL</b>: <a href='".$vs_url."'>".$vs_url."</a></div>";
								
?>
								<br/></td>
							</tr>
							<tr>
								<td colspan="2" style="border-bottom:1px solid #EDEDED;"></td>
							</tr>
<?php
					}
?>
					</table>
<?php
				}
?>
<div class="pageBreak"></p>
<br/><H2 style="text-align:center;">THE USER AGREES TO THE FOLLOWING CONDITIONS</H2>
<ol>
	<li>
		<div class="unit">
			Permission is for <b><i>one-time use only</i></b>, as described on this form, with no other rights. Any subsequent use (including subsequent editions, paperback editions, foreign language editions, etc.) constitutes re-usage and must be applied for in writing to the Vancouver Maritime Museum. An additional fee will be charged for re-use of a video, audio recording, or image.
		</div>
	</li>
	<li>
		<div class="unit">
			<b><i><u>All reproductions must be credited to the Vancouver Maritime Museum.</u></i></b>
		</div>
	</li>
	<li>
		<div class="unit">
			Credits (VMM and item number if available) should appear in close proximity to the reproduced item or in a special section devoted to credits. When known, the creator (photographer, filmmaker, etc.) should be credited. Crediting of each individual item is mandatory in all cases.
		</div>
	</li>
	<li>
		<div class="unit">
			With films, filmstrips, or video productions, credit for the materials must appear with other credits at the beginning or the end of the production.
		</div>
	</li>
	<li>
		<div class="unit">
			With display or exhibition, please credit within the display or exhibition area. Exemption from this requirement must be approved by the Vancouver Maritime Museum.
		</div>
	</li>
	<li>
		<div class="unit">
			Any alterations to an image, audio recording, or video must first be approved by the Museum. Accompanying captions must indicate all changes made to the original copy, such as significant cropping, tinting, superimposing, etc.
		</div>
	</li>
	<li>
		<div class="unit">
			One complimentary copy of each publication (including film and videotape) in which a reproduction appears must be sent to the Vancouver Maritime Museum. Please send to the attention of the Librarian.
		</div>
	</li>
	<li>
		<div class="unit">
			The user may not reproduce or permit others to reproduce the reproduction or any facsimile of it. Additional copies must be purchased from the Vancouver Maritime Museum.
		</div>
	</li>
	<li>
		<div class="unit">
			In authorizing the publication of a reproduction, the Vancouver Maritime Museum does not surrender its own right to publish it, or grant permission to others to do so.
		</div>
	</li>
	<li>
		<div class="unit">
			The user assumes all responsibility for possible copyright infringement and invasion of privacy arising from use of reproductions.
		</div>
	</li>
	<li>
		<div class="unit">
			Any exceptions or additions to the above conditions will appear on and be considered part of the License Agreement.
		</div>
	</li>
</ol>

	<table border="0" width="100%">
		<tr>
			<td style="width:50%;" valign="middle">	
				<div class="signatureEntry">
					User's Signature
				</div>
			</td>
			<td style="width:50%;" valign="middle">	
				<div class="signatureEntry">
					Date
				</div>
			</td>
		</tr>
		<tr>
			<td style="width:50%;" valign="middle">	
				<div class="signatureEntry">
					Vancouver Maritime Museum Librarian
				</div>
			</td>
			<td style="width:50%;" valign="middle">	
				<div class="signatureEntry">
					Date
				</div>
			</td>
		</tr>
	</table>
			




<?php
	print $this->render("pdfEnd.php");
?>
