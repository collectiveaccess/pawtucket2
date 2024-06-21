<?= $this->formTag(['class' => 'row g-4']); ?>


<div class="advSearchContainer">

	<div class="row">

		<?= $this->render("/data/seattleleg/themes/seattleleg/views/Search/ca_objects_advanced_search_navLeft.php"); ?>

		<div class="col-md-12 col-lg-6">
			<main role="main">
				<!-- <h1 class="pageTitle">City Council Committee History</h1>
				<br>

				<a class="" data-bs-toggle="collapse" href="#description" role="button" aria-expanded="false" aria-controls="description">
					Description <i class="bi bi-caret-down-fill"></i>
				</a>

				<div class="collapse mb-3" id="description">
					<p>This database contains descriptions, membership information, and dates of existence for Seattle City Council committees from 1946 to the present.
					</p>
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