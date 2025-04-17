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
$t_subject = $this->getVar('t_subject');
$q = ($rc = ResultContext::getResultContextForLastFind($this->request, 'ca_objects')) ? $rc->getSearchExpression() : '';

$terms = caExtractTermsForSearch($q, ['metsaltoOnly' => true]);
$terms = array_map(function($v) {
	$v = preg_replace('!["\']+!', '', $v);
	$v = preg_replace('![^A-Za-z0-9]+[0-9]*!', '', $v);
	return $v;
}, $terms);

// Find next/previous issues;
$previous_id = $next_id = null;
if(is_array($coll_ids = $t_subject->get('ca_collections.collection_id', ['returnAsArray' => true])) && sizeof($coll_ids)) {
	$coll_id = array_shift($coll_ids);
	if($t_collection = ca_collections::findAsInstance($coll_id)) {
		$object_ids = $t_collection->getRelatedItems('ca_objects', ['returnAs' => 'array', 'idsOnly' => true, 'sort' => 'ca_objects.date.date_value', 'sortDirection' => true]);
		$object_ids = array_map('intval', $object_ids);
		if(($index = array_search((int)$t_subject->getPrimaryKey(), $object_ids, true)) !== false) {
			$previous_id = $object_ids[$index-1] ?? null;
			$next_id = $object_ids[$index+1] ?? null;
		}

	}
}

$tmp = [];
if($previous_id) { 
	$tmp[] = caNavLink($this->request, _t('Previous issue'), 'issueNav issueNavPrevious', '*', '*', 'newspapers/'.$previous_id); 
}
if($next_id) { 
	$tmp[] = caNavLink($this->request, _t('Next issue'), 'issueNav issueNavNext', '*', '*', 'newspapers/'.$next_id); 
}
$tmp[] = caNavLink($this->request, _t('Help'), 'issueNav', '', 'about', 'newspaperhelp');

$navigation_header = (sizeof($tmp) > 0) ? _t('%1', join(' ', $tmp)) : '';
?>
<div id="clover<?= $display_type; ?>"></div>

<script type="text/javascript">	
    window.initApp({
    	app: 'Clover',
    	id: 'clover<?= $display_type; ?>',
    	url: <?= json_encode($this->getVar('data_url').'/render/Newspaper'); ?>,
    	searchUrl: <?= json_encode($this->getVar('search_url')); ?>,
    	clipUrl: <?= json_encode($this->getVar('clip_url').'/mode/iiif'); ?>,
    	clipDownloadUrl: <?= json_encode(caNavUrl($this->request, '', 'Annotations', 'DownloadPDF', ['representation_id' => $t_subject->get('ca_object_representations.representation_id')])); ?>,
    	renderAbout: false,
    	renderResources: false,
    	renderClips: true,   	
		informationPanel: { open: false },
		headerNavigation: <?= json_encode($navigation_header); ?>,
    	backgroundColor: '#000000',
    	canvasWidth: <?= json_encode(caGetOption('width', $display_info, '800').'px'); ?>,
    	canvasHeight: <?= json_encode(caGetOption('height', $display_info, '800').'px'); ?>,
    	initialSearch: <?= json_encode(join(' ', $terms ?? [])); ?>,
    	initialPage: <?= json_encode($this->getVar('initial_page') ?? null); ?>
    });
</script>

