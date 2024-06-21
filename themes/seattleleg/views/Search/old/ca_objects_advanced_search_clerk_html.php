<?= $this->formTag(['class' => 'row g-4']); ?>

<div class="advSearchContainer">

	<div class="row">

		<?= $this->render("/data/seattleleg/themes/seattleleg/views/Search/ca_objects_advanced_search_navLeft.php"); ?>

		<div class="col-md-12 col-lg-6">
			<main role="main">
				<!-- <h1 class="pageTitle">Comptroller/Clerk Files Index</h1>

				<br>

				<a class="" data-bs-toggle="collapse" href="#description" role="button" aria-expanded="false" aria-controls="description">
					Description <i class="bi bi-caret-down-fill"></i>
				</a>

				<div class="collapse mb-3" id="description">
					<p>This database contains basic information about documents that have been filed with the Office of the City Clerk since 1891 and added as numbered entries to the Clerk File (known as the Comptroller File until <a href="http://www.seattle.gov/cityclerk/about/historical-perspective">1992</a>). Some are items that have been <a href="http://www.seattle.gov/cityclerk/agendas-and-legislative-resources/legislative-process/how-a-bill-becomes-a-law">acted on</a> by the <a href="http://www.seattle.gov/council">Seattle City Council</a>; others were filed due to legal requirements or City business practices.  New items are added within a month of Council action; items under consideration by Council are available in our <a href="http://seattle.legistar.com/">Legislative Information Center</a>.</p>

					<p style="margin-bottom: 20px;">Types of documents in this collection include:</p>

					<ul>
						<li style="margin-bottom: 0;">Reports</li>
						<li style="margin-bottom: 0;">Appointments to City boards and commissions (before 2015)</li>
						<li style="margin-bottom: 0;">Appointments of City officials</li>
						<li style="margin-bottom: 0;">Rules</li>
						<li style="margin-bottom: 0;">Agreements (interlocal and interdepartmental)</li>
						<li style="margin-bottom: 0;">Initiatives, referenda, charter amendment proposals</li>
						<li style="margin-bottom: 0;">Department responses to Statements of Legislative Intent</li>
					</ul>

					<p>Records for select document types include full text (plain text). Scans of earlier items have been posted if we have them; if they are not posted, the documents can be reviewed on <a href="https://www.nedcc.org/free-resources/preservation-leaflets/6.-reformatting/6.1-microfilm-and-microfiche">microfiche</a> in our research room or scanned on request (<a href="http://www.seattle.gov/cityclerk/city-clerk-services/fees-for-materials-and-services">copy fees may apply</a>).</p>
					<hr>
				</div> -->

					<!-- <div class="well">

						<h4>Retrieve File by Number</h4><br>

						<div class="d-flex text-center">
							<div class="input-group">
								<label for="s3" class="me-1">File No.</label>
								<input type="text" id="s3" name="s3" style="width:70px" class="form-control"> &nbsp;
								<?= $this->formElement('ca_objects.CFN', ['size' => "70px", 'label' => '', 'description' => _t("")]); ?>
							</div>

							<input type="submit" value="Go" class="btn btn-primary">
						</div>

					</div> -->

				<?= $this->render("/data/seattleleg/themes/seattleleg/views/Search/ca_objects_advanced_search_basic_search.php"); ?>

			</main>
		</div>
		
		<?= $this->render("/data/seattleleg/themes/seattleleg/views/Search/ca_objects_advanced_search_navRight.php"); ?>

	</div>
</div>

	<?= $this->formHiddenElements(); ?>
</form>