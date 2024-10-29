<div class="pe-lg-4">
<?php
	$va_search_info = $this->getVar("searchInfo");
	$table = $va_search_info["table"];
	$action = strToLower($this->request->getActionExtra());	// form type (Eg. "combined")

	$page_title;
	$description;

	switch($action) {
		case 'combined':
			$page_title = 'Combined Legislative Records Search';
			$description = $this->getVar("combined_search_description");
		break;
		case 'bills':
			$page_title = 'City Council Bills/Ordinances';
			$description = $this->getVar("council_bills_ordinances_search_description");
		break;	
		case 'resolutions':
			$page_title = 'City Council Resolutions';
			$description = $this->getVar("resolutions_search_description");
		break;	
		case 'clerk':
			$page_title = 'Comptroller/Clerk Files Index';
			$description = $this->getVar("comptroller_clerk_files_search_description");
		break;
		case 'agenda':
			$page_title = 'City Council Agendas';
			$description = $this->getVar("agendas_search_description");
		break;
		case 'minutes':
			$page_title = 'City Council Minutes';
			$description = $this->getVar("minutes_search_description");
		break;
		case 'committees':
			$page_title = 'City Council Committee History';
			$description = $this->getVar("committee_search_description");
		break;
		case 'meetings':
			$page_title = 'City Council Meeting History and Agendas';
			$description = $this->getVar("meeting_search_description");
		break;
	}	
?>

	<h2 class="pageTitle"><?= $page_title; ?></h2><br>

	<a class="description-btn collapseControl" data-bs-toggle="collapse" href="#description" role="button" aria-expanded="true" aria-controls="description">Description <i class="bi bi-caret-down-fill"></i></a>

	<div class="collapse show mb-2 pb-2" id="description"><?= $description; ?></div>
<?php
		if(in_array($action, array("bills", "resolutions", "clerk"))){
			print $this->formTag(["method" => "get"]);
		}
		switch($action) {
			case 'bills':
?>
			<div class="well">
				<h3 class="fs-4 mb-4">Retrieve Council Bill or Ordinance by Number</h3>
				<div class="row">
					<div class="col-6">
						<label for="ca_objects_CBN" class="control-label">Council Bill No.</label>
						<?= $this->formElement('ca_objects.CBN'); ?>
					</div>
					<div class="col-6">
						<label for="ca_objects_ORDN" class="control-label">Ordinance No.</label>
						
						<?= $this->formElement('ca_objects.ORDN'); ?>
					</div>
				</div>
				<div class="row mt-3">
					<div class="col-12">
						<input type="submit" value="Go" class="btn btn-primary">
					</div>
				</div>
			</div>
	<?php
			break;
			case 'resolutions':
	?>
			<div class="well">
				<h3 class="fs-4 mb-4">Retrieve Resolution by Number</h3>
						<label for="ca_objects_RESN" class="control-label">Resolution No.</label>
						<?= $this->formElement('ca_objects.RESN'); ?>
				<div class="mt-3">
					<input type="submit" value="Go" class="btn btn-primary">
				</div>
			</div>
	<?php
			break;
			case 'clerk':
	?>
			<div class="well">
				<h3 class="fs-4 mb-4">Retrieve File by Number</h3>
					<div class="row">
						<div class="col-sm-6">
							<label for="ca_objects_CFN" class="control-label">File No.</label><br/>
							<?= $this->formElement('ca_objects.CFN'); ?>
						</div>
						<div class="col-sm-6">
							<label for="ca_objects_appointment" class="control-label">Appointment?</label><br/>
							<?= $this->formElement('ca_objects.appointment', ['class' => 'form-select']); ?>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<div class="mt-3">
								<input type="submit" value="Go" class="btn btn-primary">
							</div>
						</div>
					</div>
			</div>
	<?php
			break;
		}
		if(in_array($action, array("bills", "resolutions", "clerk"))){
			print $this->formHiddenElements();
			print "</form>";
		}
		
	print $this->formTag(["method" => "get"]);
?>

	<div class="well">

		<h3 class="fs-4 mb-4">Basic Search</h3>

		<div class="basic-search">
			<div class="mb-3">
				<label for="adv-_fulltext" class="control-label me-1">Terms Anywhere:</label>
				<?= $this->formElement('_fulltext', ['label' => '', 'description' => _t("All fields; includes full text where available")]); ?>
			</div>

	<?php
			switch($action) {
				case 'combined':
				case 'bills':
				case 'resolutions':
				case 'clerk':
	?>

			<div class="mb-3">
				<label for="adv-ca_objects_preferred_labels" class="control-label me-1">Terms in Title:</label>
				<?= $this->formElement('ca_objects.preferred_labels', ['label' => '', 'description' => _t("Include text only within the title")]); ?>
			</div>

	<?php
			break;
		}
	?>

		</div>

		<hr class="advanced-separator">
		

		<h3 class="fs-4 mb-4">Additional Options</h3>
		<div class="advanced-search">

			<div class="mb-3" id="filterdate">
				<!-- Change description text for each search type -->
			
<?php
				switch($action) {
						case 'combined':
							$vs_desc = "Date range refers to date of filing or legislative action, depending on the type of record.";
					break;
						case 'bills':
							$vs_desc = "Searches introduction date, approval date, date of Mayor's signature, and date filed with the City Clerk.";
					break;
						case 'resolutions':
							$vs_desc = "Searches introduction date, approval date, and date filed with the City Clerk.";
					break;
						case 'clerk':
							$vs_desc = "Searches date filed with the City Clerk.";
					break;
						case 'agenda':
						case 'minutes':
						case 'meetings':
							$vs_desc = "Searches meeting date.";
					break;
						case 'committees':
							$vs_desc = "Searches beginning and ending dates.";
					break;
				}
				switch($action) {
					case 'committees':
						# --- entities
						print '<label for="ca_entities_comm_date" class="control-label d-block">Date:</label>';
						print $this->formElement('ca_entities.comm_date', ['description' => $vs_desc]);
					break;
					# ---------
					case 'meetings':
						# --- occ
						
						print '<label for="ca_occurrences_DATE" class="control-label d-block">Date:</label>';
						print $this->formElement('ca_occurrences.DATE', ['description' => $vs_desc]);
					break;
					# ---------
					default:
						# --- use access point that searches across various date fields for objects
						print '<label for="'.$table.'_DATE" class="control-label d-block">Date:</label>';
						print $this->formElement('date_combined', ['description' => $vs_desc]);
					break;
					# ---------
				}
						
?>
			</div>
<?php
		if(!in_array($action, array("agenda", "minutes", "meetings", "committees"))){
?>
			<div class="mb-3" id="filtersponsor">
				<label class="control-label" for="ca_objects_SPON">Sponsor:</label>
				<?= $this->formElement('ca_objects.SPON', ['label' => '', 'description' => _t("Search the sponsor of council bills, ordinances, resolutions, comptroller files, and cleark files.")]); ?>
			</div>
<?php
		}
		if(!in_array($action, array("meetings", "committees"))){
?>
			<div class="mb-3" id="filtersponsor">
				<label class="control-label" for="ca_objects_COMM">Committee:</label>
				<?= $this->formElement('ca_objects.COMM', ['label' => '', 'description' => _t("Enter committee name.")]); ?>
			</div>
<?php
		}
		if(!in_array($action, array("meetings", "agenda", "committees"))){
?>
			<div class="mb-3" id="filtersponsor">
				<label class="control-label" for="ca_objects_index">Index Terms:</label>
				<?= $this->formElement('ca_objects.index', ['class' => 'form-select', 'label' => '', 'description' => _t("Search by terms.")]); ?>
			</div>
<?php
		}
?>				
		</div>

		<div class="advanced-search">
			<h3 class="fs-4 mb-4 expandable-controls">
				<a data-bs-toggle="collapse" class="collapseControl"  href="#settings" role="button" aria-expanded="false" aria-controls="settings">Settings <i class="bi bi-caret-right-fill"></i></a>
				
			</h3>

			<div class="collapse mb-3" id="settings">

				<div class="input-group">
					<label for="l" class="col-12 control-label">Results Per Page:</label>
					<div class="col-12">
						<select id="l" name="l" class="form-select" aria-label="select">
							<option value="5">5</option>
							<option value="10">10</option>
							<option value="25">25</option>
							<option value="50">50</option>
							<option value="100">100</option>
							<option value="0" selected="">200</option>
							<option value="500">500</option>
							<option value="1000">1000</option>
							<option value="2500">2500</option>
						</select>
					</div>
				</div>

			</div>
		</div>

		<div class="form-group" style="margin-top: 5px;">
			<div class="col-sm-9">
				<input type="submit" value="Search" class="btn btn-primary">
				<input type="reset" value="Reset" class="btn btn-sm btn-default" style="margin-left: 10px;" onclick="resetAdvForm();">
			</div>
		</div>

	</div>
	<?= $this->formHiddenElements(); ?>
</form>

<script>
		htmx.onLoad(function(content) {
			const collapseButtons = document.querySelectorAll(".collapseControl");
			collapseButtons.forEach(function(collapseButton) {
			  collapseButton.addEventListener("click", function() {
				var icon = collapseButton.querySelector(".bi");
				icon.classList.toggle("bi-caret-right-fill");
				icon.classList.toggle("bi-caret-down-fill");				
			  });
			});

			
		})
	</script>
</div>