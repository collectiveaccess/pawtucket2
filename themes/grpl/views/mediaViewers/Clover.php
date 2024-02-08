<?php
/** ---------------------------------------------------------------------
 * themes/default/views/mediaViewers/Clover.php :
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2023-2024 Whirl-i-Gig
 *
 * For more information visit http://www.CollectiveAccess.org
 *
 * This program is free software; you may redistribute it and/or modify it under
 * the terms of the provided license as published by Whirl-i-Gig
 *
 * CollectiveAccess is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTIES whatsoever, including any implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * This source code is free and modifiable under the terms of
 * GNU General Public License. (http://www.gnu.org/copyleft/gpl.html). See
 * the "license.txt" file for details, or visit the CollectiveAccess web site at
 * http://www.CollectiveAccess.org
 *
 * @package CollectiveAccess
 * @subpackage Media
 * @license http://www.gnu.org/copyleft/gpl.html GNU Public License version 3
 *
 * ----------------------------------------------------------------------
 */
$display_type = $this->getVar('displayType');
$display_info = $this->getVar('displayInfo');
?>
<div id="clover<?= $display_type; ?>"></div>

<script type="text/javascript">	
    window.initApp({
    	app: 'Clover',
    	id: 'clover<?= $display_type; ?>',
    	url: <?= json_encode($this->getVar('data_url').'/render/Newspaper'); ?>,
    	searchUrl: <?= json_encode($this->getVar('search_url').'?q=injured+teacher'); ?>,
    	renderAbout: false,
    	renderResources: false,
    	renderClips: true,   	
		informationPanel: { open: false },
    	backgroundColor: '#000000',
    	canvasWidth: <?= json_encode(caGetOption('width', $display_info, '800').'px'); ?>,
    	canvasHeight: <?= json_encode(caGetOption('height', $display_info, '800').'px'); ?>
    });
</script>

