<?php
/* ----------------------------------------------------------------------
 * controllers/FeedController.php
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2009-2010 Whirl-i-Gig
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
			$va_recently_added_objects = $t_object->getRecentlyAddedItems(25, array('checkAccess' => caGetUserAccessValues($this->request)));
			
			$va_entries = array();
			$va_object_ids = array();
			foreach($va_recently_added_objects as $va_object) {
				$va_object_ids[] = $va_object['object_id'];
			}

			$va_labels = $t_object->getPreferredDisplayLabelsForIDs($va_object_ids);
			
			// TODO: Need to get object descriptions and last update times properly
			foreach($va_labels as $vn_object_id => $vs_label) {
				$va_entries[] = array(
					'title' => $vs_label,
					'link' =>  $vs_link = $this->request->config->get('site_host').caNavUrl($this->request, '', 'Detail/Object', 'Index', array('object_id' => $vn_object_id)),
					'guid' => $vs_link,
					'lastUpdate' => time(),
					'description' => '',
					'pubDate' => time()
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