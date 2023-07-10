<?php
/* ----------------------------------------------------------------------
 * app/controllers/EntityDetailController.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2023 Whirl-i-Gig
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
 * ----------------------------------------------------------------------
 */
require_once(__CA_LIB_DIR__.'/pawtucket/BasePawtucketController.php');

class EntityDetailController extends BasePawtucketController {
	# -------------------------------------------------------
	public function __construct(&$po_request, &$po_response, $pa_view_paths=null) {
		parent::__construct($po_request, $po_response, $pa_view_paths);
		
	}
	# -------------------------------------------------------
	/**
	 *
	 */ 
	public function collectionsSearch() {
		$search = $this->request->getParameter('search', pString);
		
		$all = $this->request->getParameter('all', pInteger);
		if(!strlen($search)) {
			throw new ApplicationException(_t('No search specified'));
		}
		$s = new CollectionSearch();
		if(!$all) { 
			$s->setTypeRestrictions(['collection']);
		}
		$qr = $s->search($search, ['sort' => 'ca_collections.preferred_labels.name']);
		
		$this->view->setVar('result', $qr);
		$this->view->setVar('count', $qr->numHits());
		$this->render('Search/entity_detail_collections_search_html.php');
	}
	# -------------------------------------------------------
}
