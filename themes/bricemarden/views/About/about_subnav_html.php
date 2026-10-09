<ul class="text-nowrap list-unstyled lh-lg ps-2 ps-lg-0">
	<li><?= caNavlink($this->request, _t('Note to the Reader'), "nav-link".((in_array("NoteReader", $path_array)) ? " active" : ""), "", "About", "NoteReader", "", ((in_array("NoteReader", $path_array)) ? array("aria-current" => "page") : null)); ?></li>
	<li><?= caNavlink($this->request, _t('Catalogue Raisonné Team'), "nav-link".((in_array("Team", $path_array)) ? " active" : ""), "", "About", "Team", "", ((in_array("Team", $path_array)) ? array("aria-current" => "page") : null)); ?></li>
	<li><?= caNavlink($this->request, _t('Acknowledgments'), "nav-link".((in_array("Acknowledgments", $path_array)) ? " active" : ""), "", "About", "Acknowledgments", "", ((in_array("Acknowledgments", $path_array)) ? array("aria-current" => "page") : null)); ?></li>
</ul>
