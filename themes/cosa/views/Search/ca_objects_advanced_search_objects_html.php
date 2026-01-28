<div class="row mb-5">
	<div class="col-md-8">
		<h1><?= _t("Advanced Search"); ?></h1>
        <div class="my-3 fs-4"><?= _t("Enter your search terms in the fields below."); ?></div>

			<?= $this->formTag(['class' => 'row g-4']); ?>
			<?= $this->formElement('_fulltext', ['label' => _t('Keyword'), 'description' => _t("Search across all fields in the database.")]); ?>
			
			<?= $this->formElement('ca_objects.preferred_labels', ['label' => _t('Title'), 'description' => _t("Limit your search to Artwork Titles only.")]); ?>			

			<?= $this->formElement('ca_entities.preferred_labels', ['label' => _t('Artist'), 'description' => _t("Search by artist name.")]); ?>
			
			<?= $this->formElement('ca_places.preferred_labels', ['label' => _t('Location'), 'description' => _t("Search by the Artwork's location.")]); ?>
			
			<?= $this->formElement('ca_objects.artwork_category', ['class' => 'form-select w-100', 'label' => _t('Artwork Category'), 'description' => _t("Limit your search to artwork categories.")]); ?>

			<?= $this->formElement('ca_objects.artwork_type', ['class' => 'form-select w-100', 'label' => _t('Artwork Type'), 'description' => _t("Limit your search to artwork types.")]); ?>

			<?= $this->formElement('ca_objects.date_completed', ['label' => _t('Date'), 'description' => _t("Search by the Artwork's date.")]); ?>

			<?= $this->formElement('ca_objects.on_display', ['class' => 'form-select w-100', 'label' => _t('On Display?'), 'description' => _t("Find Artworks currently on display.")]); ?>

			<div class="col-12 mb-3">
				<?= $this->formHiddenElements(); ?>
				<button type="submit" class="btn btn-primary me-2"><?= _t("Search"); ?></button>
				<button type="reset" class="btn btn-primary"><?= _t("Reset"); ?></button>
			</div>
		</form>
	</div>

	<div class="col-md-4">
		<div class="bg-light px-4 py-4">
			<h2 class="fs-2">How to Get Better Search Results</h2>
			<h3 class="fs-4">Use AND to combine ideas</h3>
			<p>Use <b>AND</b> when you want results that match all your search terms.</p>
			
			<p class="pt-3"><b>Example:</b></p>
			<code class="bg-white p-2">mural AND downtown</code>
			<p class="pt-3">> shows only artworks that are murals <b>located downtown</b></p>
			
			<hr/>
			
			<h3 class="fs-4">Use Or to see more options</h3>
			<p>Use <b>OR</b> to broaden your search and include results that match any of your terms.</p>
			
			<p class="pt-3"><b>Example:</b></p>
			<code class="bg-white p-2">sculpture OR installation</code>
			<p class="pt-3">> shows artworks that are either sculptures or installations.</p>
			<hr/>
			
			<h3 class="fs-4">Use NOT to exclude things</h3>
			<p>Use <b>NOT</b> to remove results you don't want.</p>
			
			<p class="pt-3"><b>Example:</b></p>
			<code class="bg-white p-2">mural NOT temporary</code>
			<p class="pt-3">> shows murals that are <b>not</b> temporary</p>
			
			<hr/>
			<h3 class="fs-4">If you don't type AND or OR, the system assumes AND</h3>
			<p>Typing multiple words automatically means you're searching for <b>all</b> of them</p>
			<p class="pt-3"><b>Example:</b></p>
			<code class="bg-white p-2">river walk mural</code>
			<p class="pt-3">> same as typing</p>
			<p class="pb-3"><code class="bg-white p-2">river AND walk AND mural</code></p>
			
			<hr/>
			
			<h3 class="fs-4">Use quotation marks for exact matches</h3>
			<p>Put quotes around phrases if you need a specific title or name.</p>
			<p class="pt-3"><b>Example:</b></p>
			<code class="bg-white p-2">"La Veladora"</code>
			<p class="pt-3">> find artworks with that exact title</p>
			
			<hr/>
			
			<h3 class="fs-4">Wildcards (Partial Word Search)</h3>
			<p>Use and asterisk * to match word variations.</p>
			<p class="pt-3"><b>Example:</b></p>
			<code class="bg-white p-2">sculpt*</code>
			<p class="pt-3">> returns: <i>sculpture, sculptures, sculptural, sculpted</i></p>
			<p>This helps when you aren't sure about spelling or want broader results.</p>
		</div>
	</div>

</div><!-- end row -->
