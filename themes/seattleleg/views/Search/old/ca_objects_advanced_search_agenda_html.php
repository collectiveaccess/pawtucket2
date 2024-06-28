<?= $this->formTag(['class' => 'row g-4']); ?>


<div class="advSearchContainer">

	<div class="row">

		<?= $this->render("/data/seattleleg/themes/seattleleg/views/Search/ca_objects_advanced_search_navLeft.php"); ?>

		<div class="col-md-12 col-lg-6">
			<main role="main">
				
				<!-- <h1 class="pageTitle">City Council Agendas</h1>
				<br>

				<a class="" data-bs-toggle="collapse" href="#description" role="button" aria-expanded="false" aria-controls="description">
					Description <i class="bi bi-caret-down-fill"></i>
				</a>

				<div class="collapse mb-3" id="description">
					<p>This database contains plain text of published agendas for City Council and committee meetings held from 2002 to 30 days ago. New items are added within a month of the meeting taking place.
					</p>

					<p>Agendas available here are generally the same as the published agenda that was circulated prior to a meeting. Actual proceedings at a meeting may differ from the published agenda, as agendas are subject to amendment.
					</p>

					<p>Published agendas for upcoming meetings are available from the Meetings section of our 
						<a href="http://seattle.legistar.com/Calendar.aspx">Legislative Information Center</a>.
					</p>

					<p>Some earlier agendas (currently 1964-1991) are available on the Seattle Municipal Archives 	
						<a href="http://archives.seattle.gov/digital-collections/index.php/Detail/collections/801">Digital Collections website</a>.
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