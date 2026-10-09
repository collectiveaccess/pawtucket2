<?php
	$action = strToLower($this->request->getAction());
?>
<ul class="text-nowrap list-unstyled lh-lg">
	<li><?= caNavlink($this->request, _t("Brice Marden's Paintings: An Overview"), "nav-link".(($action == "overview") ? " active" : ""), "", "Marden", "Overview", "", (($action == "overview") ? array("aria-current" => "page") : null)); ?></li>
	<li><?= caNavlink($this->request, _t("Statement for Master of Fine Arts"), "nav-link".(($action == "statement") ? " active" : ""), "", "Marden", "Statement", "", (($action == "statement") ? array("aria-current" => "page") : null)); ?></li>
	<li><?= caNavlink($this->request, _t("This is what I do, this is what I try to do"), "nav-link".(($action == "whatido") ? " active" : ""), "", "Marden", "WhatIDo", "", (($action == "whatido") ? array("aria-current" => "page") : null)); ?></li>
	<li><?= caNavlink($this->request, _t("Chronology"), "nav-link".(($action == "chronology") ? " active" : ""), "", "Marden", "Chronology", "", (($action == "chronology") ? array("aria-current" => "page") : null)); ?></li>
</ul>
