<?php
	$o_result_context = $this->getVar('context');
	
	$va_results_list = $o_result_context->getResultList();
	
	$va_data = ['draw' => $this->request->getParameter('draw', pInteger), 'data' => []];
	
	$vn_start = $this->request->getParameter('start', pInteger);
	$vn_length = $this->request->getParameter('length', pInteger);
	
	$pa_order = $this->request->getParameter('order', pArray);
	
	$va_sorts = array(
		'ca_entities.preferred_labels.surname',
		'ca_entities.preferred_labels.surname',
		'ca_objects.preferred_labels.name_sort',
		null,
		'ca_objects_x_entities.date_out',
		'ca_objects_x_entities.date_in',
		'ca_objects_x_entities.fine'
	);
	$vs_sort = isset($va_sorts[$pa_order[0]['column']]) ? $va_sorts[$pa_order[0]['column']] : 'ca_objects.preferred_labels.name_sort';
	$vs_sort_dir = $pa_order[0]['dir'];
	
	if (is_array($va_results_list) && sizeof($va_results_list)) { 
		if ($qr_res = caMakeSearchResult('ca_objects_x_entities', $va_results_list, array('sort' => [$vs_sort], 'sortDirection' => $vs_sort_dir))) {
			$qr_res->seek($vn_start);
			$vn_i = 0;
			$va_books = [];
			
			while($qr_res->nextHit()) {
				$va_books[] = $qr_res->get('ca_objects_x_entities.object_id');
				$vn_i++;
				if ($vn_i > $vn_length) { break; }
			}
			$qr_res->seek($vn_start);
			
			$qr_books = caMakeSearchResult('ca_objects', array_unique($va_books));
			
			$va_authors = $va_authors_sort = array();
			
			$va_parents = array();
			while($qr_books->nextHit()) {
				$vn_object_id = $qr_books->get('ca_objects.object_id');
				if ($vn_parent_id = $qr_books->get('ca_objects.parent_id')) { $va_parents[$vn_parent_id] = $vn_object_id; }
				
				$va_labels = $qr_books->get('ca_entities.preferred_labels', array('returnAsArray' => true, 'assumeDisplayField' => false, 'restrictToRelationshipTypes' => array('author'), 'checkAccess' => $this->getVar("access_values")));
				foreach($va_labels as $va_label) {
					$va_authors[$vn_object_id] = (($va_authors[$vn_object_id]) ? "; " : "").caNavLink($this->request, $va_label['displayname'], '', '', 'Detail', 'entities/'.$va_label['entity_id']);
					$va_authors_sort[$vn_object_id] = (($va_authors[$vn_object_id]) ? "; " : "").addslashes($va_label['surname'].', '.$va_label['forename']);
				}
			}
			
			if(sizeof($va_parents)) {
				$qr_books = caMakeSearchResult('ca_objects', array_keys($va_parents));
				while($qr_books->nextHit()) {
					$vn_id = $qr_books->get('ca_objects.object_id');
					$vn_object_id = $va_parents[$vn_id];
					if (isset($va_authors[$vn_id])) { continue; }
					
					$va_labels = $qr_books->get('ca_entities.preferred_labels', array('returnAsArray' => true, 'assumeDisplayField' => false, 'restrictToRelationshipTypes' => array('author'), 'checkAccess' => $this->getVar("access_values")));
					foreach($va_labels as $va_label) {
						$va_authors[$vn_object_id] = (($va_authors[$vn_object_id]) ? "; " : "").caNavLink($this->request, $va_label['displayname'], '', '', 'Detail', 'entities/'.$va_label['entity_id']);
						$va_authors_sort[$vn_object_id] = (($va_authors[$vn_object_id]) ? "; " : "").addslashes($va_label['surname'].', '.$va_label['forename']);
					}
				}
			}
		
			$va_data['recordsTotal'] = $va_data['recordsFiltered'] = $qr_res->numHits();
			
			$vn_i = 0;
			while($qr_res->nextHit()) {
				if ($vs_title = $qr_res->get('ca_objects.parent.preferred_labels.name', array('returnAsLink' => true))) {
					$vs_title_sort = addslashes($qr_res->get('ca_objects.parent.preferred_labels.name_sort'));
					$vs_volume = $qr_res->get('ca_objects.preferred_labels.name', array('returnAsLink' => true));
					$vs_volume_sort = addslashes($qr_res->get('ca_objects.preferred_labels.name_sort'));
				} else {
					$vs_title = $qr_res->get('ca_objects.preferred_labels.name', array('returnAsLink' => true));
					$vs_title_sort = addslashes($qr_res->get('ca_objects.preferred_labels.name_sort'));
					$vs_volume = $vs_volume_sort = '';
				}
				$vs_trans_title = "<br/>Transcribed: ".$qr_res->get('ca_objects_x_entities.book_title');
				if ($qr_res->get("ca_objects_x_entities.see_original", array('convertCodesToDisplayText' => true)) == "Yes"){
					$vs_uncertain = "&nbsp;".caNavLink($this->request, "<i class='fa fa-exclamation-triangle'></i>", '', '', 'Detail', 'objects/'.$qr_res->get("ca_objects_x_entities.see_original_link", array('idsOnly' => true)));
					//TooltipManager::add('.fa-exclamation-triangle', "Uncertain transcription. See scanned image."); 						
				} else { $vs_uncertain = null; }	
				
				$vn_object_id = $qr_res->get("ca_objects_x_entities.object_id");
						
				$vs_author = $va_authors[$vn_object_id];
				$vs_author_sort = $va_authors_sort[$vn_object_id];
				$vs_borrower = $qr_res->get('ca_entities.preferred_labels.displayname', array('returnAsLink' => true));
				$vs_borrower_sort = $qr_res->get('ca_entities.preferred_labels.surname').", ".$qr_res->get('ca_entities.preferred_labels.forename');
				$vs_date_out = $qr_res->get('ca_objects_x_entities.date_out');
				$vs_date_in = $qr_res->get('ca_objects_x_entities.date_in');
				
				
				$va_data['data'][] = [
					"<span title='{$vs_borrower_sort}'></span>{$vs_borrower}", 
					"<span title='{$vs_author_sort}'></span>{$vs_author}", 
					"<div class='bookTitle'><span title='{$vs_title_sort}'></span>{$vs_title}{$vs_trans_title}{$vs_uncertain}</div>",
					"<span title='{$vs_volume_sort}'>{$vs_volume}</span>",
					"{$vs_date_out}",
					"{$vs_date_in}",
					$qr_res->get('ca_objects_x_entities.fine'),
					caNavLink($this->request, '<i class="fa fa-file-text"></i>', '', '', 'Detail', 'objects/'.$qr_res->get("ca_objects_x_entities.see_original_link", array('idsOnly' => true)))
				];
				
				$vn_i++;
				
				if ($vn_i >= $vn_length) { break; }
			}
		}
	}
	
	print json_encode($va_data);