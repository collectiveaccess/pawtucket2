<?= $this->formTag(['class' => 'row g-4']); ?>

<div class="advSearchContainer">

	<div class="row">

		<?= $this->render("/data/seattleleg/themes/seattleleg/views/Search/ca_objects_advanced_search_navLeft.php"); ?>

		<div class="col-md-12 col-lg-6">
			<main role="main">
				<!-- <h1 class="pageTitle">Combined Legislative Records Search</h1>

				<a class="" data-bs-toggle="collapse" href="#description" role="button" aria-expanded="true" aria-controls="description">
					Description <i class="bi bi-caret-down-fill"></i>
				</a>

				<div class="collapse show mb-3" id="description">
					<p class="mt-4">Use this page to search council bills, ordinances, resolutions and Clerk/Comptroller Files. See individual database pages at left for details of the scope of each collection. For narrower results or advanced searching, you may wish to search the databases separately.</p>
					<hr>
				</div> -->

				<?= $this->render("/data/seattleleg/themes/seattleleg/views/Search/ca_objects_advanced_search_basic_search.php"); ?>

			</main>
		</div>
		
		<?= $this->render("/data/seattleleg/themes/seattleleg/views/Search/ca_objects_advanced_search_navRight.php"); ?>

	</div>
</div>

	<?= $this->formHiddenElements(); ?>
</form>