<ul class="text-nowrap list-unstyled lh-lg ps-2 ps-lg-0">
	<li><?= caNavlink($this->request, _t("Brice Marden's Paintings: An Overview"), "nav-link".((in_array("Overview", $path_array)) ? " active" : ""), "", "Marden", "Overview", "", ((in_array("Overview", $path_array)) ? array("aria-current" => "page") : null)); ?></li>
	<li><?= caNavlink($this->request, _t("Statement for Master of Fine Arts"), "nav-link".((in_array("Statement", $path_array)) ? " active" : ""), "", "Marden", "Statement", "", ((in_array("Statement", $path_array)) ? array("aria-current" => "page") : null)); ?></li>
	<li><?= caNavlink($this->request, _t("This is what I do, this is what I try to do"), "nav-link".((in_array("WhatIDo", $path_array)) ? " active" : ""), "", "Marden", "WhatIDo", "", ((in_array("WhatIDo", $path_array)) ? array("aria-current" => "page") : null)); ?></li>
	<li><?= caNavlink($this->request, _t("Chronology"), "nav-link".((in_array("Chronology", $path_array)) ? " active" : ""), "", "Marden", "Chronology", "", ((in_array("Chronology", $path_array)) ? array("aria-current" => "page") : null)); ?></li>
</ul>
