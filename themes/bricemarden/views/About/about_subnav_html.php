<?php
	$action = strToLower($this->request->getAction());
?>
<ul class="text-nowrap list-unstyled lh-lg d-none d-xl-block">
	<li><?= caNavlink($this->request, _t('Note to the Reader'), "nav-link".($action == "NoteReader") ? " active" : ""), "", "About", "NoteReader", "", ($action == "NoteReader") ? array("aria-current" => "page") : null)); ?></li>
	<li><?= caNavlink($this->request, _t('Catalogue Raisonné Team'), "nav-link".($action == "Team") ? " active" : ""), "", "About", "Team", "", ($action == "Team") ? array("aria-current" => "page") : null)); ?></li>
	<li><?= caNavlink($this->request, _t('Acknowledgments'), "nav-link".($action == "Acknowledgments") ? " active" : ""), "", "About", "Acknowledgments", "", ($action == "Acknowledgments") ? array("aria-current" => "page") : null)); ?></li>
</ul>