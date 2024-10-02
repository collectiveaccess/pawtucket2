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
			$description = "
				<p class='mt-4'>Use this page to search council bills, ordinances, resolutions and Clerk/Comptroller Files. See individual database pages at left for details of the scope of each collection. For narrower results or advanced searching, you may wish to search the databases separately.</p>
			";
		break;
		case 'bills':
			$page_title = 'City Council Bills/Ordinances';
			$description = "
					<p>
						This database contains basic information about <a href='http://www.seattle.gov/cityclerk/agendas-and-legislative-resources/legislative-process/legislative-glossary'>council bills and ordinances</a> that have been <a href='http://www.seattle.gov/cityclerk/agendas-and-legislative-resources/legislative-process/how-a-bill-becomes-a-law'>acted on</a> by the <a href='http://www.seattle.gov/council'>Seattle City Council</a> since <a href='http://www.seattle.gov/cityarchives/seattle-facts/quick-city-info#incorporationdate'>1869</a>. New items are added within 30 days of Council action; items under consideration by Council are available in our <a href='http://seattle.legistar.com/'>Legislative Information Center</a>.
					</p>
					<p>
						Records for items introduced in 1996 or later include full text (plain text). Scans of earlier items have been posted if we have them; if they are not posted, the documents can be reviewed on <a href='https://www.nedcc.org/free-resources/preservation-leaflets/6.-reformatting/6.1-microfilm-and-microfiche'>microfiche</a> in our research room or scanned on request (<a href='http://www.seattle.gov/cityclerk/city-clerk-services/fees-for-materials-and-services'>copy fees may apply</a>). Scans of signed legislation are also posted for items passed from 2009 forward.
					</p>
			";
		break;	
		case 'resolutions':
			$page_title = 'City Council Resolutions';
			$description = "
					<p>This database contains basic information about <a href='http://www.seattle.gov/cityclerk/agendas-and-legislative-resources/legislative-process/legislative-glossary'>resolutions</a> that have been <a href='http://www.seattle.gov/cityclerk/agendas-and-legislative-resources/legislative-process/how-a-bill-becomes-a-law'>acted on</a> by the <a href='http://www.seattle.gov/council'>Seattle City Council</a> since 1894. New items are added within 30 days of Council action; items under consideration by Council are available in our <a href='http://seattle.legistar.com/'>Legislative Information Center</a>.</p>
					<p>Records for items introduced in 1996 or later include full text (plain text). Scans of earlier items have been posted if we have them; if they are not posted, the documents can be reviewed on <a href='https://www.nedcc.org/free-resources/preservation-leaflets/6.-reformatting/6.1-microfilm-and-microfiche'>microfiche</a> in our research room or scanned on request (<a href='http://www.seattle.gov/cityclerk/city-clerk-services/fees-for-materials-and-services'>copy fees may apply</a>). Scans of signed legislation are also posted for items passed from 2009 forward.</p>
			";
		break;	
		case 'clerk':
			$page_title = 'Comptroller/Clerk Files Index';
			$description = "
					<p>This database contains basic information about documents that have been filed with the Office of the City Clerk since 1891 and added as numbered entries to the Clerk File (known as the Comptroller File until <a href='http://www.seattle.gov/cityclerk/about/historical-perspective'>1992</a>). Some are items that have been <a href='http://www.seattle.gov/cityclerk/agendas-and-legislative-resources/legislative-process/how-a-bill-becomes-a-law'>acted on</a> by the <a href='http://www.seattle.gov/council'>Seattle City Council</a>; others were filed due to legal requirements or City business practices.  New items are added within a month of Council action; items under consideration by Council are available in our <a href='http://seattle.legistar.com/'>Legislative Information Center</a>.</p>

					<p>Types of documents in this collection include:</p>

					<ul>
						<li>Reports</li>
						<li>Appointments to City boards and commissions (before 2015)</li>
						<li>Appointments of City officials</li>
						<li>Rules</li>
						<li>Agreements (interlocal and interdepartmental)</li>
						<li>Initiatives, referenda, charter amendment proposals</li>
						<li>Department responses to Statements of Legislative Intent</li>
					</ul>

					<p>Records for select document types include full text (plain text). Scans of earlier items have been posted if we have them; if they are not posted, the documents can be reviewed on <a href='https://www.nedcc.org/free-resources/preservation-leaflets/6.-reformatting/6.1-microfilm-and-microfiche'>microfiche</a> in our research room or scanned on request (<a href='http://www.seattle.gov/cityclerk/city-clerk-services/fees-for-materials-and-services'>copy fees may apply</a>).</p>
			";
		break;
		case 'agenda':
			$page_title = 'City Council Agendas';
			$description = "
					<p>This database contains plain text of published agendas for City Council and committee meetings held from 2002 to 30 days ago. New items are added within a month of the meeting taking place.
					</p>

					<p>Agendas available here are generally the same as the published agenda that was circulated prior to a meeting. Actual proceedings at a meeting may differ from the published agenda, as agendas are subject to amendment.
					</p>

					<p>Published agendas for upcoming meetings are available from the Meetings section of our 
						<a href='http://seattle.legistar.com/Calendar.aspx'>Legislative Information Center</a>.
					</p>

					<p>Some earlier agendas (currently 1964-1991) are available on the Seattle Municipal Archives 	
						<a href='http://archives.seattle.gov/digital-collections/index.php/Detail/collections/801'>Digital Collections website</a>.
					</p>
			";
		break;
		case 'minutes':
			$page_title = 'City Council Minutes';
			$description = "
					<p>This database contains plain text of Seattle City Council meeting minutes (also known as the Journal of Proceedings of the Seattle City Council) from 2002 to present. New items are added within 30 days of being adopted.</p>
					
					<p>More recent minutes are available in our <a href='http://seattle.legistar.com/Calendar.aspx'>Legislative Information Center</a>.</p>

					<p>Minutes from 1869 through 2001 are available in our research room. <a href='http://archives.seattle.gov/digital-collections/index.php/Search/objects/search/collection%3A1801-12'>Selected early minutes</a> are available online. For copies of signed minutes, please <a href='mailto:cityclerk@seattle.gov'>contact us</a>.</p>
			";
		break;
		case 'committees':
			$page_title = 'City Council Committee History';
			$description = "
					<p>This database contains descriptions, membership information, and dates of existence for Seattle City Council committees from 1946 to the present.</p>
			";
		break;
		case 'meetings':
			$page_title = 'City Council Meeting History';
			$description = "
					<p>This database contains descriptions, membership information, and dates of existence for Seattle City Council committees from 1946 to the present.</p>
			";
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
						print '<label for="'.$table.'_DATE" class="control-label d-block">Date:</label>';
						print $this->formElement($table.'.date', ['description' => $vs_desc]);
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