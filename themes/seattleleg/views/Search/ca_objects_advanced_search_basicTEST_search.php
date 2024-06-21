<?php
	$va_browse_info = $this->getVar("browseInfo");
	$action = $this->request->getActionExtra();	// form type (Eg. "combined")

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
	}	
?>

	<h1 class="pageTitle"><?= $page_title; ?></h1><br>

	<a class="" data-bs-toggle="collapse" href="#description" role="button" aria-expanded="true" aria-controls="description">Description <i class="bi bi-caret-down-fill"></i></a>

	<div class="collapse show mb-3" id="description"><?= $description; ?><hr></div>

	<?php
		switch($action) {
			case 'bills':
	?>
			<div class="well">
				<h4>Retrieve Council Bill or Ordinance by Number</h4><br>
				<div class="row text-center">
					<div class="col-sm-5 d-flex ">
						<label for="s3" class="me-1">Council Bill No.</label>
						<?= $this->formElement('ca_objects.CBN', ['size' => "70px", 'label' => '', 'description' => _t("")]); ?>
					</div>

					<div class="col-sm-5 d-flex">
						<label for="s4" class="me-1">Ordinance No.</label>
						
						<?= $this->formElement('ca_objects.ORDN', ['size' => "70px", 'label' => '', 'description' => _t("")]); ?>
					</div>

					<div class="col-sm-2">
						<input type="submit" value="Go" class="btn btn-primary">
					</div>
				</div>
			</div>
	<?php
			break;
			case 'resolutions':
	?>
			<div class="well">
				<h4>Retrieve Resolution by Number</h4><br>
				<div class="d-flex text-center">
					<div class="input-group">
						<label for="s3" class="me-1">Resolution No.</label>
						<?= $this->formElement('ca_objects.RESN', ['size' => "70px", 'label' => '', 'description' => _t("")]); ?>
					</div>
					<input type="submit" value="Go" class="btn btn-primary">
				</div>
			</div>
	<?php
			break;
			case 'clerk':
	?>
			<div class="well">
				<h4>Retrieve File by Number</h4><br>
				<div class="d-flex text-center">
					<div class="input-group">
						<label for="s3" class="me-1">File No.</label>
						<?= $this->formElement('ca_objects.CFN', ['size' => "70px", 'label' => '', 'description' => _t("")]); ?>
					</div>
					<input type="submit" value="Go" class="btn btn-primary">
				</div>
			</div>
	<?php
			break;
		}
	?>

	<div class="well">

		<h4>Basic Search</h4><br>

		<div class="basic-search">
			<div class="input-group">
				<label class="col-sm-12 control-label me-1">Terms Anywhere:</label>
				<div class="col-sm-12">
					<?= $this->formElement('_fulltext', ['class' => 'form-control', 'width' => '300px', 'label' => '', 'description' => _t("All fields; includes full text where available")]); ?>
				</div>
			</div>

	<?php
			switch($action) {
				case 'combined':
				case 'bills':
				case 'resolutions':
				case 'clerk':
	?>

			<br>
			<div class="input-group">
				<label class="col-12 control-label me-1">Terms in Title:</label><br>
				<div class="col-12" style="padding-bottom: 10px;">
					<?= $this->formElement('ca_objects.preferred_labels.name', ['class' => 'form-control', 'width' => '300px', 'label' => '', 'description' => _t("Include text only within the title")]); ?>
				</div>
			</div>

	<?php
			break;
		}
	?>

		</div>

		<hr class="advanced-separator">
		

		<h4>Advanced Search</h4><br>

		<div class="advanced-search">

			<h4 class="expandable-controls">
				<a data-bs-toggle="collapse" href="#filterfield" role="button" aria-expanded="false" aria-controls="filterfield">Filter by Field</a>
				<i class="bi bi-caret-right-fill"></i>
			</h4>

			<div class="collapse mb-3" id="filterfield">

				<p>Use as many fields as needed. Each text field can contain either one or multiple terms. Months are optional in date fields.</p><br>

					<label class="col-12 control-label">Search by Field:</label>
					
					
				<?= $this->formBundle($action, [
					'id' => 'field-item', 
					'selectClass' => 'form-control s7target',
					'inputClass' => 'form-control'
				]); ?>
				<div id="field-item">
				
				</div>
				
				<div id="field-item-template" class="input-group advanced-fields mb-1 align-items-center" style="display: none;">
					<div class="field-item-select col-auto me-1"></div>
					<div class="field-item-input col-auto me-3 s7choices s7text"></div>
					<div class="field-item-add col-auto d-flex align-items-center">
						<a role="button" title="Add Row" class="field-item-add-button"><i class="bi bi-plus-lg"></i></a>
					</div>
				</div>

			</div>

		</div>


		<div class="advanced-search">

			<h4 class="expandable-controls">
				<a data-bs-toggle="collapse" href="#filterdate" role="button" aria-expanded="false" aria-controls="filterdate">Filter by Date</a>
				<i class="bi bi-caret-right-fill"></i>
			</h4>

			<div class="collapse mb-3" id="filterdate">
				<p>A date range can be combined with other search terms, or submitted independently. Months are optional.</p><br>

				<div class="input-group ">
					<label class="col-12 control-label">By Date:</label>
					<div class="col-sm-9">

						<?= $this->formElement('date', ['size' => "70px", 'label' => '', 'description' => _t("")]); ?>


						<!-- Change description text for each search type -->
						<p>
							<?php
									switch($action) {
										case 'combined':
							?>
								<em>Date range refers to date of filing or legislative action, depending on the type of record.</em>
							<?php
									break;
										case 'bills':
							?>
							  <em>Searches introduction date, approval date, date of Mayor's signature, and date filed with the City Clerk.</em>
							<?php
									break;
										case 'resolutions':
							?>
								<em>Searches introduction date, approval date, and date filed with the City Clerk.</em>
							<?php
									break;
										case 'clerk':
							?>
								<em>Searches date filed with the City Clerk.</em>
							<?php
									break;
										case 'agenda':
										case 'minutes':
							?>
								<em>Searches meeting date.</em>
							<?php
									break;
										case 'committees':
							?>
								<em>Searches beginning and ending dates.</em>
							<?php
									break;
								}
							?>
						</p>
					</div>
				</div>

			</div>
		</div>

	<?php
			switch($action) {
				case 'combined':
				case 'bills':
				case 'resolutions':
				case 'clerk':
					// NOOP
	?>
	<?php
					break;
		}
	?>

		<div class="advanced-search">
			<h4 class="expandable-controls">
				<a data-bs-toggle="collapse" href="#settings" role="button" aria-expanded="false" aria-controls="settings">Settings</a>
				<i class="bi bi-caret-right-fill"></i>
			</h4>

			<div class="collapse mb-3" id="settings">

				<p>These optional settings apply to all combinations of fields above. Adjacency only applies to multiple terms within the same field.</p><br>

				<div class="input-group">
					<label for="Sect4" class="col-12">Default Operator:</label>
					<div class="col-sm-9">
						<select name="Sect4" id="Sect4" class="form-control" aria-label="select">
							<option value="OR">Or</option>
							<option value="AND" selected="">And</option>
							<option value="ADJ">Adjacent</option>
						</select>
					</div>
				</div>

				<br>

				<div class="input-group">
					<label for="n" class="col-12">Results Per Page:</label>
					<div class="col-sm-9">
						<select name="n" id="n" class="form-control" aria-label="select">
							<option value="5">5</option>
							<option value="10">10</option>
							<option value="25">25</option>
							<option value="50">50</option>
							<option value="100">100</option>
							<option value="200" selected="">200</option>
							<option value="500">500</option>
							<option value="1000">1000</option>
							<option value="2500">2500</option>
						</select>
					</div>
				</div>
			</div>
		</div>

		<div class="form-group" style="margin-top: 5px;">
			<label class="col-sm-3 control-label"></label>
			<div class="col-sm-9">
				<input type="submit" value="Search" class="btn btn-primary">
				<input type="reset" value="Reset" class="btn btn-sm btn-default" style="margin-left: 10px;" onclick="resetAdvForm();">
			</div>
		</div>

	</div>