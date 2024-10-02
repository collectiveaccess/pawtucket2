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


<div class="container" >
	<div class="row my-5">
		<div class="col">
			<div class="text-center bg-light-gray py-2 px-3 shadow">
				<h2 class="mt-2 fs-3 bg-gray pt-3 p-2">Combined search of legislation</h2>
	
				<form class="row g-1 align-items-center" action="<?= caNavUrl($this->request, '', 'Search', 'combined'); ?>">
					<label for="searchTerms" class="visually-hidden">Search Terms</label>
					<input name="_fulltext" id="searchTerms" type="text" class="form-control col-10" style="width: 79%;" placeholder="Search terms">
					<input type="submit" value="Search" class="ms-2 col-2 btn btn-primary" style="width: 20%;">
					<input type="hidden" name="_advanced" value="1">
					<input type="hidden" name="_formElements" value="_fulltext">
				</form>
	
				<p>
					Searches the titles and full text (where available) of <?= caNavLink($this->request, _t("all legislation"), "", "", "Search", "advanced/combined"); ?>.<br>
					<small>(Legislation acted on by the City Council from 1869 to 30 days ago.)</small>
				</p>
	
			</div>
		</div>

	</div>

	<div class="row my-5">

		<div class="col-5">
			<h3>Legislation and meetings</h3>
			
			<div class="tileTextDescription">
				<ul>
					<li><?= caNavLink($this->request, _t("Combined Search"), "", "", "Search", "advanced/combined"); ?></li>
					<li><?= caNavLink($this->request, _t("Ordinances / Council Bills"), "", "", "Search", "advanced/bills"); ?></li>
					<li><?= caNavLink($this->request, _t("Resolutions"), "", "", "Search", "advanced/resolutions"); ?></li>
					<li><?= caNavLink($this->request, _t("Clerk Files"), "", "", "Search", "advanced/clerk"); ?></li>
					<li><?= caNavLink($this->request, _t("Agendas"), "", "", "Search", "advanced/agenda"); ?></li>
					<li><?= caNavLink($this->request, _t("Minutes"), "", "", "Search", "advanced/minutes"); ?></li>
					<li><?= caNavLink($this->request, _t("Committee History"), "", "", "Search", "advanced/committees"); ?></li>
					<li><?= caNavLink($this->request, _t("Meeting History"), "", "", "Search", "advanced/meetings"); ?></li>
				</ul>
			</div>
		</div>

		<div class="text-center taxonomyTile splitTile col-7" style="height: 160px;">
			<h3 class="tileTitle">Know what you're looking for?</h3>
			<form id="numberSearch" action="<?= caNavUrl($this->request, '', 'Search', 'combined'); ?>">
			<div class="row">
				<div class="col-4 mb-1">
					<label for="recordNumber" class="visually-hidden">Record Number</label>
					<input id="recordNumber" name="number" type="number" class="form-control" placeholder="Number" min="1">
				</div>
				<div class="col-6 mb-1">
					<label for="recordType" class="visually-hidden">Record Type</label>
					<select id="recordType" name="field" class="form-select">
						<option value="ca_objects_ORDN">Ordinance</option>
						<option value="ca_objects_CBN">Council Bill</option>
						<option value="ca_objects_RESN">Resolution</option>
						<option value="ca_objects.CFN">Clerk File</option>
					</select>
				</div>
				<div class="col-2 mb-1 text-start">
					<input type="submit" value="Go" class="btn btn-primary">
				</div>
			</div>
				<input id="advQuery" type="hidden" name="advQuery" value="">
				<input type="hidden" name="_advanced" value="1">
				<input type="hidden" name="_formElements" value="ca_objects.ORDN|ca_objects.RESN|ca_objects.CFN|ca_objects.CBN">
				<script>
					const numberForm = document.getElementById('numberSearch');
					numberForm.addEventListener('submit', (e) => {
						 //e.preventDefault();
						 let recordNumber = document.getElementById("recordNumber").value;
						 let recordType = document.getElementById("recordType").value;
						 document.getElementById('advQuery').value = recordNumber;
						 document.getElementById('advQuery').name = recordType;
						// alert("recordNumber" + recordNumber);
						 //alert("recordType" + recordType);
					});
				</script>
			</form>
			<p>Go directly to a record by number.</p>
		</div>

	</div>

</div>
