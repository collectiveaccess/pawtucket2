<?= $this->formTag(['class' => 'row g-4']); ?>


<div class="advSearchContainer">

	<div class="row">

		<?= $this->render("/data/seattleleg/themes/seattleleg/views/Search/ca_objects_advanced_search_navLeft.php"); ?>

		<div class="col-md-12 col-lg-6">
			<main role="main">
				<h1 class="pageTitle">City Council Bills/Ordinances</h1>
				<br>

				<a class="" data-bs-toggle="collapse" href="#description" role="button" aria-expanded="false" aria-controls="description">
					Description <i class="bi bi-caret-down-fill"></i>
				</a>

				<div class="collapse mb-3" id="description">
					<p>
						This database contains basic information about <a href="http://www.seattle.gov/cityclerk/agendas-and-legislative-resources/legislative-process/legislative-glossary">council bills and ordinances</a> that have been <a href="http://www.seattle.gov/cityclerk/agendas-and-legislative-resources/legislative-process/how-a-bill-becomes-a-law">acted on</a> by the <a href="http://www.seattle.gov/council">Seattle City Council</a> since <a href="http://www.seattle.gov/cityarchives/seattle-facts/quick-city-info#incorporationdate">1869</a>. New items are added within 30 days of Council action; items under consideration by Council are available in our <a href="http://seattle.legistar.com/">Legislative Information Center</a>.
					</p>
					<p>
						Records for items introduced in 1996 or later include full text (plain text). Scans of earlier items have been posted if we have them; if they are not posted, the documents can be reviewed on <a href="https://www.nedcc.org/free-resources/preservation-leaflets/6.-reformatting/6.1-microfilm-and-microfiche">microfiche</a> in our research room or scanned on request (<a href="http://www.seattle.gov/cityclerk/city-clerk-services/fees-for-materials-and-services">copy fees may apply</a>). Scans of signed legislation are also posted for items passed from 2009 forward.
					</p>
					<hr>
				</div>				

					<div class="well">

						<h4>Retrieve Council Bill or Ordinance by Number</h4><br>

						<div class="row text-center">
							<div class="col-sm-5 d-flex">
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
				<?= $this->render("/data/seattleleg/themes/seattleleg/views/Search/ca_objects_advanced_search_basic_search.php"); ?>
				
			</main>
		</div>
		
		<?= $this->render("/data/seattleleg/themes/seattleleg/views/Search/ca_objects_advanced_search_navRight.php"); ?>

	</div>
</div>

	<?= $this->formHiddenElements(); ?>
</form>