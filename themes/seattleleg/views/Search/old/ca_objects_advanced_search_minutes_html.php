<?= $this->formTag(['class' => 'row g-4']); ?>


<div class="advSearchContainer">

	<div class="row">

		<?= $this->render("/data/seattleleg/themes/seattleleg/views/Search/ca_objects_advanced_search_navLeft.php"); ?>

		<div class="col-md-12 col-lg-6">
			<main role="main">
				<!-- <h1 class="pageTitle">City Council Minutes</h1>
				<br>

				<a class="" data-bs-toggle="collapse" href="#description" role="button" aria-expanded="false" aria-controls="description">
					Description <i class="bi bi-caret-down-fill"></i>
				</a>

				<div class="collapse mb-3" id="description">
					<p>This database contains plain text of Seattle City Council meeting minutes (also known as the Journal of Proceedings of the Seattle City Council) from 2002 to present. New items are added within 30 days of being adopted.</p>
					
					<p>More recent minutes are available in our <a href="http://seattle.legistar.com/Calendar.aspx">Legislative Information Center</a>.</p>

					<p>Minutes from 1869 through 2001 are available in our research room. <a href="http://archives.seattle.gov/digital-collections/index.php/Search/objects/search/collection%3A1801-12">Selected early minutes</a> are available online. For copies of signed minutes, please <a href="mailto:cityclerk@seattle.gov">contact us</a>.</p>
					<hr>
				</div>				 -->

				<?= $this->render("/data/seattleleg/themes/seattleleg/views/Search/ca_objects_advanced_search_basic_search.php"); ?>
				
			</main>
		</div>
		
		<?= $this->render("/data/seattleleg/themes/seattleleg/views/Search/ca_objects_advanced_search_navRight.php"); ?>

	</div>
</div>

	<?= $this->formHiddenElements(); ?>
</form>