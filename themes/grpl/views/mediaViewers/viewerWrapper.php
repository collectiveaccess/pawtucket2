<?php
/** ---------------------------------------------------------------------
 * themes/default/views/mediaViewers/viewerWrapper.php :
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2016-2020 Whirl-i-Gig
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
?>
<?php if ($this->getVar('hideOverlayControls')) { ?>
<div class="caMediaOverlayControlsMinimal">
	<div class='close'><a href="#" onclick="caMediaPanel.hidePanel(); return false;" title="close"><?php print caNavIcon(__CA_NAV_ICON_CLOSE__, "18px", [], ['color' => 'white']); ?></a></div>
</div>
<?php } else { ?>
<div class="caMediaOverlayControls">
	<div class='close'><a href="#" onclick="caMediaPanel.hidePanel(); return false;" title="close"><?php print caNavIcon(__CA_NAV_ICON_CLOSE__, "18px", [], ['color' => 'white']); ?></a></div>
	<?php print $this->getVar('controls'); ?>
</div>
<?php } ?>

<div id="caMediaOverlayContent" ><?php print $this->render($this->getVar('viewer').".php"); ?></div>


<script>
	function caMediaOverlayNav(mode, id, representation_id) {
		jQuery("#caMediaPanelContentArea:visible").load("<?= caNavUrl($this->request, '', 'Detail', 'GetMediaOverlay', ['context' => $this->getVar('context'), 'overlay' => 1]); ?>/id/" + id + '/representation_id/' + representation_id);
		jQuery('#' + caMediaPanel.getPanelID()).data('reloadUrl', '<?= caNavUrl($this->request, '', '*', $this->getVar('context')); ?>/' + id);
	}
</script>