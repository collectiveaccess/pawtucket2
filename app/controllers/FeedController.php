<?php
/* ----------------------------------------------------------------------
 * controllers/FeedController.php
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2009-2012 Whirl-i-Gig
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
 
	require_once(__CA_APP_DIR__."/helpers/accessHelpers.php");
	require_once(__CA_LIB_DIR__."/ca/BaseFeedController.php");
	require_once(__CA_MODELS_DIR__."/ca_objects.php");
 
 	class FeedController extends BaseFeedController {
 		# -------------------------------------------------------
 		
 		# -------------------------------------------------------
 		function recentlyAdded() {
 		
 			// redirect user if not logged in
			if (($this->request->config->get('pawtucket_requires_login')&&!($this->request->isLoggedIn()))||($this->request->config->get('show_bristol_only')&&!($this->request->isLoggedIn()))) {
                $this->response->setRedirect(caNavUrl($this->request, "", "LoginReg", "form"));
            } elseif (($this->request->config->get('show_bristol_only'))&&($this->request->isLoggedIn())) {
            	$this->response->setRedirect(caNavUrl($this->request, "bristol", "Show", "Index"));
            }	
            
			$t_object = new ca_objects();
			if (($vn_num_items = (int)$this->request->config->get('rss_number_of_items')) <= 0) {
				$vn_num_items = 10;
			}
			$va_recently_added_objects = $t_object->getRecentlyAddedItems($vn_num_items, array('checkAccess' => caGetUserAccessValues($this->request)));
			
			$va_entries = array();
			$va_object_ids = array();
			foreach($va_recently_added_objects as $va_object) {
				$va_object_ids[] = $va_object['object_id'];
			}

			$qr_res = $t_object->makeSearchResult('ca_objects', $va_object_ids);
			
			$vs_description_bundle = $this->request->config->get('rss_description');
			while($qr_res->nextHit()) {
				$vn_object_id = $qr_res->get('ca_objects.object_id');
				if (!($vn_creation_time = $t_object->getCreationTimestamp($vn_object_id, array('timestampOnly' => true)))) { $vn_creation_time = time(); }
				if (!($vn_update_time = $t_object->getLastChangeTimestamp($vn_object_id, array('timestampOnly' => true)))) { $vn_update_time = time(); }
				
				$va_entries[] = array(
					'title' => $qr_res->get('ca_objects.preferred_labels.name'),
					'link' =>  $vs_link = $this->request->config->get('site_host').caNavUrl($this->request, '', 'Detail/Object', 'Index', array('object_id' => $vn_object_id)),
					'guid' => $vs_link,
					'lastUpdate' => $vn_update_time,
					'description' => $vs_description_bundle ? $qr_res->getMediaTag("ca_object_representations.media", "preview")."\n".$qr_res->get($vs_description_bundle) : '',
					'pubDate' => $vn_creation_time
				);
			}
			
 			$va_feed_data = array (
				'title'     => _t('Recently added'),
				'link'         => $this->request->getRequestUrl(true),
				'charset'   => 'UTF-8', 
				'entries'     => $va_entries,
			);
 			
 			$o_feed = Zend_Feed::importArray($va_feed_data, 'rss');
 			$this->view->setVar('feed', $o_feed);
 			$this->render('Feed/feed_recently_added_xml.php');
 		}
 		# -------------------------------------------------------
 	}
 ?>