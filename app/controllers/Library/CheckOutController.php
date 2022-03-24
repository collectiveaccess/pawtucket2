<?php
/* ----------------------------------------------------------------------
 * app/controllers/Library/CheckOutController.php :
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2014-2022 Whirl-i-Gig
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
require_once(__CA_LIB_DIR__.'/Search/ObjectSearch.php');
require_once(__CA_MODELS_DIR__.'/ca_object_checkouts.php');
require_once(__CA_LIB_DIR__.'/ResultContext.php');

class CheckOutController extends ActionController {
	# -------------------------------------------------------
	public function __construct(&$request, &$response, $view_paths=null) {
		parent::__construct($request, $response, $view_paths);
		
		if (!$this->request->isLoggedIn() || !$this->request->user->canDoAction('can_do_library_checkout') || !$this->request->config->get('enable_library_services')  || !$this->request->config->get('enable_object_checkout')) { 
			$this->response->setRedirect($this->request->config->get('error_display_url').'/n/2320?r='.urlencode($this->request->getFullUrlPath()));
			return;
		}
		
		AssetLoadManager::register('objectcheckout');
	}
	# -------------------------------------------------------
	/**
	 * Checkout items screen
	 */
	public function Index() {
		$user_id = $this->request->getUserID();
		
		$this->view->setVar('user_id', $user_id);
		$this->view->setVar('checkout_types', ca_object_checkouts::getObjectCheckoutTypes());
		
		$this->render('checkout/items_html.php');
	}
	# -------------------------------------------------------
	/**
	 * Return info via ajax on selected object
	 */
	public function GetObjectInfo() {
		$user_id = $this->request->getParameter('user_id', pInteger);
		$object_id = $this->request->getParameter('object_id', pInteger);
		
		$t_object = new ca_objects($object_id);
		
		$current_user_id = $current_user = $current_user_checkout_date = $reservation_list = null;		// user_id of current holder of item
		
		$vb_is_reserved_by_current_user = false;
		switch($status = $t_object->getCheckoutStatus()) {
			case __CA_OBJECTS_CHECKOUT_STATUS_AVAILABLE__:
				$status_display = _t('Available');
				break;
			case __CA_OBJECTS_CHECKOUT_STATUS_OUT__:
				$t_checkout = ca_object_checkouts::getCurrentCheckoutInstance($object_id);
				$current_user_id = $t_checkout->get('user_id');
				
				$status_display = ($current_user_id == $user_id) ? _t('Out with this user') : _t('Out');
				$current_user_checkout_date = $t_checkout->get('checkout_date', array('timeOmit' => true));
				
				break;
			case __CA_OBJECTS_CHECKOUT_STATUS_OUT_WITH_RESERVATIONS__:
				$t_checkout = ca_object_checkouts::getCurrentCheckoutInstance($object_id);
				$current_user_id = $t_checkout->get('user_id');
				$reservations = $t_object->getCheckoutReservations();
				$num_reservations = is_array($reservations) ? sizeof($reservations) : 0;
				
				$current_user_checkout_date = $t_checkout->get('checkout_date', array('timeOmit' => true));
				
				$status_display = ($num_reservations == 1) ? _t('Out with %1 reservation', $num_reservations) : _t('Out with %1 reservations', $num_reservations);
				break;
			case __CA_OBJECTS_CHECKOUT_STATUS_RESERVED__:
				// get reservations list
				$reservations = $t_object->getCheckoutReservations();
				$num_reservations = is_array($reservations) ? sizeof($reservations) : 0;
				$t_checkout = ca_object_checkouts::getCurrentCheckoutInstance($object_id);
				$current_user_checkout_date = $t_checkout->get('created_on', array('timeOmit' => true));
				
				$status_display = ($num_reservations == 1) ? _t('Reserved') : _t('Available with %1 reservations', $num_reservations);
				
				break;
		}
		
		$vb_is_held_by_current_user = ($user_id == $current_user_id);
		
		if (is_array($reservations)) {
			$tmp = array();
			foreach($reservations as $reservation) {
				$vb_is_reserved_by_current_user = ($reservation['user_id'] == $user_id);
				$t_user = new ca_users($reservation['user_id']);
				$tmp[] = $t_user->get('fname').' '.$t_user->get('lname').(($email = $t_user->get('email')) ? " ({$email})" : "");
			}
			$reservation_list = join(", ", $tmp);
		}
		
		if ($current_user_id) {
			$t_user = new ca_users($current_user_id);
			$current_user = $t_user->get('fname').' '.$t_user->get('lname');
		}
	
		
		$checkout_config = ca_object_checkouts::getObjectCheckoutConfigForType($t_object->getTypeCode());
		
		$holder_display_label = '';
		if ($vb_is_held_by_current_user) {
			$status_display = _t('The user currently has this item');
		} elseif($vb_is_reserved_by_current_user) {
			$status_display = _t('The user has reserved this item');
		} else {
			$reserve_display_label = ($status == 3) ? _t('Currently reserved by %1', $reservation_list) : _t('Will reserve');
			
			if (in_array($status, array(1, 2))) {
				$holder_display_label = _t('held by %1 since %2', $current_user, $current_user_checkout_date);
			}
		}
		$info = array(
			'object_id' => $t_object->getPrimaryKey(),
			'idno' => $t_object->get('idno'),
			'name' => $t_object->get('ca_objects.preferred_labels.name'),
			'media' => $t_object->getWithTemplate('^ca_object_representations.media.icon'),
			'status' => $status,
			'status_display' => $status_display,
			'numReservations' => is_array($reservations) ? sizeof($reservations) : 0,
			'reservations' => $reservations,
			'config' => $checkout_config,
			'current_user_id' => $current_user_id,
			'current_user' => $current_user,
			'current_user_checkout_date' => $current_user_checkout_date,
			'isOutWithCurrentUser' => ($user_id == $current_user_id),
			'isReservedByCurrentUser' => $vb_is_reserved_by_current_user,
			
			'reserve_display_label' => $reserve_display_label,
			'due_on_display_label' => _t('Due on'),
			'notes_display_label' => _t('Notes'),
			'holder_display_label' => $holder_display_label
		);
		$info['title'] = $info['name']." (".$info['idno'].")";
		
		$info['storage_location'] = $t_object->getWithTemplate($checkout_config['show_storage_location_template']);
		
		$this->view->setVar('data', $info);
		$this->render('checkout/ajax_data_json.php');
	}
	# -------------------------------------------------------
	/**
	 * Return info via ajax on selected object
	 */
	public function SaveTransaction() {
		$user_id = $this->request->getParameter('user_id', pInteger);
		$ps_item_list = $this->request->getParameter('item_list', pString);
		$item_list = json_decode(stripslashes($ps_item_list), true);
		if (!is_array($item_list)) { $item_list = []; }
		
		$t_checkout = ca_object_checkouts::newCheckoutTransaction();
		$ret = array('status' => 'OK', 'total' => sizeof($item_list), 'errors' => array(), 'checkouts' => array());
			
		if(is_array($item_list)) {
			$t_object = new ca_objects();
			foreach($item_list as $i => $item) {
				if (!$t_object->load(array('object_id' => $item['object_id'], 'deleted' => 0))) { continue; }
			
				$name = $t_object->getWithTemplate("^ca_objects.preferred_labels.name (^ca_objects.idno)");
				if ($checkout_info = $t_checkout->objectIsOut($item['object_id'])) {
					if ($checkout_info['user_id'] == $user_id) {
						// user already has item so skip it
						$ret['errors'][$item['object_id']] = _t('User already has <em>%1</em>', $name);
						continue;
					}
					try {
						$vb_res = $t_checkout->reserve($item['object_id'], $user_id, $item['note'], array('request' => $this->request));
						if ($vb_res) {
							$ret['checkouts'][$item['object_id']] = _t('Reserved <em>%1</em>', $name);
						} else {
							$ret['errors'][$item['object_id']] = _t('Could not reserve <em>%1</em>: %2', $name, join('; ', $t_checkout->getErrors()));
						}
					} catch (Exception $e) {
						$ret['errors'][$item['object_id']] = _t('Could not reserve <em>%1</em>: %2', $name, $e->getMessage());
					}
				} else {
					try {
						$vb_res = $t_checkout->checkout($item['object_id'], $user_id, $item['note'], $item['due_date'], array('request' => $this->request));
			
						if ($vb_res) {
							$ret['checkouts'][$item['object_id']] = _t('Checked out <em>%1</em>; due date is %2', $name, $item['due_date']);
						} else {
							$ret['errors'][$item['object_id']] = _t('Could not check out <em>%1</em>: %2', $name, join('; ', $t_checkout->getErrors()));
						}
					} catch (Exception $e) {
						$ret['errors'][$item['object_id']] = _t('Could not check out <em>%1</em>: %2', $name, $e->getMessage());
					}
				}
			}
		}
		
		$this->view->setVar('data', $ret);
		$this->render('checkout/ajax_data_json.php');
	}
	# -------------------------------------------------------
}
