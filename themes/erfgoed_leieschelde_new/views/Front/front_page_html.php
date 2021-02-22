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
  $va_access_values = $this->getVar("access_values");
?>
<div class="container frontContainer">
	<div class="row">
		<div class="col-sm-4">
			<div class="frontWelcome">{{{hometextHeading}}}</div>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-3 col-sm-offset-8 col-md-offset-9">
			<div class="frontSearch">
				<form role="search" action="<?php print caNavUrl($this->request, '', 'MultiSearch', 'Index'); ?>">
					<div class="formOutline">
						<div class="form-group">
							<input type="text" class="form-control" id="frontSearchInput" placeholder="Search" name="search" autocomplete="off" aria-label="Search" />
						</div>
						<button type="submit" class="btn-search" id="frontSearchButton"><span class="glyphicon glyphicon-search" aria-label="<?php print _t("Submit Search"); ?>"></span></button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<div class="container introContainer">
	<div class="row">
		<div class="col-sm-6 col-sm-offset-1">
			<div class="frontIntro">{{{hometext}}}</div>
		</div>
	</div>
</div>
<div class="row"><div class="col-sm-12 colNoPadding">

<?php
		print $this->render("Front/featured_set_slideshow_html.php");
?>
</div></div>
<div class="row bgOffwhite">
	<div class="col-sm-12 col-md-8 col-md-offset-2 recentlyAdded">
		<H1>Recently Added</H1>
<?php
	$o_db = new Db();
	$o_recent = $o_db->query("SELECT o.object_id FROM ca_objects o INNER JOIN ca_objects_x_object_representations AS oo ON oo.object_id = o.object_id WHERE o.access IN (".join(", ", $va_access_values).") ORDER BY o.object_id desc LIMIT 10");
	if($o_recent->numRows()){
		$i = 0;
		$c = 0;
		while($o_recent->nextRow()){
			$t_object = new ca_objects($o_recent->get("ca_objects.object_id"));
			if($t_object->get("ca_object_representations.media.iconlarge")){
				$c++;
			
				if($i == 0){
					print "<div class='row'>";
				}
				print "<div class='col-sm-6'><div class='recentlyAddedTile'>".$t_object->getWithTemplate("<l>^ca_object_representations.media.iconlarge</l>").$t_object->getWithTemplate("<l>^ca_objects.preferred_labels.name</l>")."</div>";
				print "</div>";
				$i++;
				if($i == 2){
					print "</div><!-- end row -->";
					$i = 0;
				}
				if($c == 6){
					break;
				}
			}
		}
		if($i > 0){
			print "</div><!-- end row -->";
		}
	}
?>
	</div>
</div>