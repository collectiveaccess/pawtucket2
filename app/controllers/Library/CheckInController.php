<?php
/* ----------------------------------------------------------------------
 * app/controllers/Library/CheckInController.php :
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2014-2023 Whirl-i-Gig
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

require_once(__CA_APP_DIR__.'/helpers/libraryServicesHelpers.php');

class CheckInController extends ActionController {
	# -------------------------------------------------------
	#
	# -------------------------------------------------------
	public function __construct(&$request, &$response, $view_paths=null) {
		parent::__construct($request, $response, $view_paths);
		
		if (!$this->request->isLoggedIn() || !$this->request->user->canDoAction('can_do_library_checkin') || !$this->request->config->get('enable_library_services')  || !$this->request->config->get('enable_object_checkout')) { 
			$this->response->setRedirect($this->request->config->get('error_display_url').'/n/2320?r='.urlencode($this->request->getFullUrlPath()));
			return;
		}
		
		AssetLoadManager::register('objectcheckin');
		
		$this->opo_app_plugin_manager = new ApplicationPluginManager();
	}
	# -------------------------------------------------------
	/**
	 *
	 */
	public function Index() {
		$this->render('checkin/items_html.php');
	}
	# -------------------------------------------------------
	/**
	 * Return info via ajax on selected object
	 */
	public function GetObjectInfo() {
		$checkout_id = $this->request->getParameter('checkout_id', pInteger);

		if (!($t_checkout = ca_object_checkouts::find(['checkout_id' => $checkout_id], ['returnAs' => 'firstModelInstance']))) {
			throw new ApplicationException(_t('Invalid checkout'));
		}
		$user_id = $t_checkout->get('user_id');
		if(!$this->request->user->canDoAction('can_do_library_checkinout_for_anyone') && ($user_id != $this->request->getUserID())) {
			throw new ApplicationException(_t('Checkout is not by current user'));
		}
		if(!($t_object = ca_objects::find(['object_id' => $t_checkout->get('object_id')], ['returnAs' => 'firstModelInstance']))) {
			throw new ApplicationException(_t('Checkout object does not exist'));
		}
		$t_user = $this->request->getUser();
		$status = $t_object->getCheckoutStatus();
		$checkout_config = ca_object_checkouts::getObjectCheckoutConfigForType($t_object->getTypeCode());
		
		$info = array(
			'object_id' => $t_object->getPrimaryKey(),
			'idno' => $t_object->get('idno'),
			'name' => $t_object->get('ca_objects.preferred_labels.name'),
			'media' => $t_object->getWithTemplate('^ca_object_representations.media.icon'),
			'status' => $t_object->getCheckoutStatus(),
			'status_display' => $t_object->getCheckoutStatus(array('returnAsText' => true)),
			'checkout_date' => $t_checkout->get('ca_object_checkouts.checkout_date', array('timeOmit' => true)),
			'user_name' => $t_user->get('ca_users.fname').' '.$t_user->get('ca_users.lname'),
			'config' => $checkout_config
		);
		$info['title'] = $info['name'].' ('.$info['idno'].')';
		$info['borrower'] = _t('Borrowed by %1 on %2', $info['user_name'], $info['checkout_date']);
		$this->view->setVar('data', $info);
		$this->render('checkin/ajax_data_json.php');
	}
	# -------------------------------------------------------
	/**
	 * 
	 */
	public function SaveTransaction() {
		$library_config = Configuration::load(__CA_CONF_DIR__."/library_services.conf");
		$display_template = $library_config->get('checkin_receipt_item_display_template');
		
		$item_list = $this->request->getParameter('item_list', pString);
		$item_list = json_decode(stripslashes($item_list), true);
		
		if (is_array($item_list)) {
			$t_checkout = new ca_object_checkouts();
			$app_name = Configuration::load()->get('app_display_name');
			$sender_email = $library_config->get('notification_sender_email');
			$sender_name = $library_config->get('notification_sender_name');
			$subject = _t('Receipt for check in');
			
			$checked_in_items = [];
			
			$ret = array('status' => 'OK', 'errors' => array(), 'checkins' => array());
			foreach($item_list as $i => $item) {
				if ($t_checkout->load($item['checkout_id'])) {
					$object_id = $t_checkout->get('object_id');
					$t_object = new ca_objects($object_id);
					if ($t_checkout->isOut()) { 
						try {
							$t_checkout->checkin($object_id, $item['note'], array('request' => $this->request));
						
							$t_user = new ca_users($t_checkout->get('user_id'));
							$user_name = $t_user->get('ca_users.fname').' '.$t_user->get('ca_users.lname');
							$borrow_date = $t_checkout->get('ca_object_checkouts.checkout_date', array('timeOmit' => true));
					
							if ($t_checkout->numErrors() == 0) {
								$ret['checkins'][] = _t('Returned <em>%1</em> (%2) borrowed by %3 on %4', $t_object->get('ca_objects.preferred_labels.name'), $t_object->get('ca_objects.idno'), $user_name, $borrow_date);
								$item['_display'] = $t_checkout->getWithTemplate($display_template);
								$checked_in_items[] = $item;
							} else {
								$ret['errors'][] = _t('Could not check in <em>%1</em> (%2): %3', $t_object->get('ca_objects.preferred_labels.name'), $t_object->get('ca_objects.idno'), join("; ", $t_checkout->getErrors()));
							}
						} catch (Exception $e) {
							$ret['errors'][] = _t('<em>%1</em> (%2) is not out', $t_object->get('ca_objects.preferred_labels.name'), $t_object->get('ca_objects.idno'));
						}
					} else {
						$ret['errors'][] = _t('<em>%1</em> (%2) is not out', $t_object->get('ca_objects.preferred_labels.name'), $t_object->get('ca_objects.idno'));
					}
				}
			}
			if($library_config->get('send_item_checkin_receipts') && (sizeof($checked_in_items) > 0) && ($user_email = $this->request->user->get('ca_users.email'))) {
				if (!caSendMessageUsingView(null, $user_email, $sender_email, "[{$app_name}] {$subject}", "library_checkin_receipt.tpl", ['subject' => $subject, 'from_user_id' => $user_id, 'sender_name' => $sender_name, 'sender_email' => $sender_email, 'sent_on' => time(), 'checkin_date' => caGetLocalizedDate(), 'checkins' => $checked_in_items], null, [], ['source' => 'Library checkin receipt'])) {
					global $g_last_email_error;
					$ret['errors'][] = _t('Could not send receipt: %1', $g_last_email_error);
				}
			}
		}
		
		$this->view->setVar('data', $ret);
		$this->render('checkin/ajax_data_json.php');
	}
	# -------------------------------------------------------
}
