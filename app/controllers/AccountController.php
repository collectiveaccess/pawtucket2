<?php
/* ----------------------------------------------------------------------
 * app/controller/AccountController.php
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2012 Whirl-i-Gig
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
 
 	require_once(__CA_LIB_DIR__."/core/Error.php");
 	require_once(__CA_LIB_DIR__."/core/Parsers/TimeExpressionParser.php");
	require_once(__CA_MODELS_DIR__."/ca_sets.php");
	require_once(__CA_MODELS_DIR__."/ca_objects.php");
	require_once(__CA_MODELS_DIR__."/ca_commerce_transactions.php");
	require_once(__CA_MODELS_DIR__."/ca_commerce_communications.php");
	require_once(__CA_MODELS_DIR__."/ca_commerce_orders.php");
 	require_once(__CA_APP_DIR__.'/helpers/accessHelpers.php');
 	require_once(__CA_APP_DIR__.'/helpers/clientServicesHelpers.php');
	require_once(__CA_LIB_DIR__."/core/Parsers/htmlpurifier/HTMLPurifier.standalone.php");
 
 	class AccountController extends ActionController {
 		# -------------------------------------------------------
 		private $opo_client_services_config;
 		# -------------------------------------------------------
 		 public function __construct(&$po_request, &$po_response, $pa_view_paths=null) {
 			parent::__construct($po_request, $po_response, $pa_view_paths);
 			
 			if (!$this->request->isLoggedIn()) { 
 				$this->notification->addNotification(_t("You must be logged in to view your orders"), __NOTIFICATION_TYPE_ERROR__);
 				$this->response->setRedirect(caNavUrl($this->request, '', 'Splash', 'Index'), 302);
 				return;
 			}
 		
 			$this->opo_client_services_config = Configuration::load($this->request->config->get('client_services_config'));
 			$this->view->setVar('client_services_config', $this->opo_client_services_config);
 			$this->view->setVar('currency', $this->opo_client_services_config->get('currency'));
 			$this->view->setVar('currency_symbol', $this->opo_client_services_config->get('currency_symbol'));
 			
			JavascriptLoadManager::register("panel");
 		}
 		# -------------------------------------------------------
 		/**
 		 * "My Account" screen
 		 */
 		function Index() {
 			if (!$this->request->isLoggedIn()) { return; }
 			$t_order = new ca_commerce_orders();
 			$this->view->setVar('t_order', $t_order);
 			
 			# -- open orders
 			$va_open_orders = $t_order->getOrders(array('user_id' => $this->request->getUserID(), 'order_status' => array('OPEN', 'SUBMITTED', 'AWAITING_PAYMENT', 'IN_PROCESSING', 'PROCESSED', 'FULFILLED', 'REOPENED')));
 			$this->view->setVar('open_order_list', $va_open_orders);
 			
 			# --- recent orders
 			$this->view->setVar('recent_orders_age_threshold', $vn_recent_orders_age_threshold = (int)$this->opo_client_services_config->get('recent_orders_age_threshold'));
 			$vn_c = time() - (60*60*24*$vn_recent_orders_age_threshold);
 			$o_tep = new TimeExpressionParser();
 			$o_tep->setUnixTimestamps($vn_c, time());
 			$va_recent_orders = $t_order->getOrders(array('user_id' => $this->request->getUserID(), 'created_on' => $o_tep->getText()));
 			$this->view->setVar('recent_order_list', $va_recent_orders);
 			
 			# -- all orders
 			$va_all_orders = $t_order->getOrders(array('user_id' => $this->request->getUserID()));
 			$this->view->setVar('all_order_list', $va_all_orders);
 			
 			$va_closed_orders = $t_order->getOrders(array('user_id' => $this->request->getUserID(), 'order_status' => array('COMPLETED')));
 			$this->view->setVar('closed_order_list', $va_closed_orders);
 			
			$this->render("Account/my_account_html.php");
 		}
 		# -------------------------------------------------------
 		/**
 		 * 
 		 */
 		public function ViewOrder() {
 			if (!$this->request->isLoggedIn()) { return; }
 			$pn_order_id = $this->request->getParameter('order_id', pInteger);
 			$t_order = new ca_commerce_orders($pn_order_id);
 			if (!$t_order->userHasAccessToOrder($this->request->getUserID())) { 
 				$this->notification->addNotification(_t("Invalid order_id"), __NOTIFICATION_TYPE_ERROR__);
 				$this->response->setRedirect(caNavUrl($this->request, '', 'Account', 'Index'), 302);
 				return;
 			} else {
 				if (!in_array($t_order->get('order_status'), array('AWAITING_PAYMENT', 'PROCESSED', 'COMPLETED', 'REOPENED'))) {
 					$this->notification->addNotification(_t("This order is not yet available for viewing"), __NOTIFICATION_TYPE_ERROR__);
					$this->response->setRedirect(caNavUrl($this->request, '', 'Account', 'Index'), 302);
 					return;
 				}
				$this->view->setVar('t_order', $t_order);
				$this->view->setVar('item_list', $t_order->getItems());
				
				if (!$t_order->getPrimaryKey()) { 
					$this->notification->addNotification(_t("Invalid order_id"), __NOTIFICATION_TYPE_ERROR__);
					$this->response->setRedirect(caNavUrl($this->request, '', 'Account', 'Index'), 302);
 					return;
				} else {
					$this->view->setVar('order_id', $t_order->getPrimaryKey());
				}
				
				$va_months = array();
				$o_tep = new TimeExpressionParser();
				foreach($o_tep->getMonthList() as $vn_m => $vs_month) {
					$va_months[$vs_month] = $vn_m + 1;
				}
				$o_tep = new TimeExpressionParser();
				$this->view->setVar('credit_card_exp_month_list', $va_months);
				
				$va_tmp = getDate(); $vn_current_year = $va_tmp['year'];
				$vn_i = 0;
				$va_credit_card_exp_year_list = array();
				while($vn_i < 8) {
					$va_credit_card_exp_year_list[$vn_current_year + $vn_i] = $vn_current_year + $vn_i;
					$vn_i++;
				}
				$this->view->setVar('credit_card_exp_year_list', $va_credit_card_exp_year_list);
				
				# --- get any messages linked to this order
				$t_comm = new ca_commerce_communications();
				$this->view->setVar('messages', $t_comm->getMessages($this->request->getUserID(), array('transaction_id' => $t_order->get("transaction_id"))));
								
				$this->render('Account/view_order_html.php');
			}
 		}
 		# -------------------------------------------------------
 		/**
 		 * 
 		 */
 		public function Save() {
 			$pn_order_id = $this->request->getParameter('order_id', pInteger);
 			$t_order = new ca_commerce_orders($pn_order_id);
 			
 			if (!$t_order->userHasAccessToOrder($this->request->getUserID())) { 
 				$this->notification->addNotification(_t("Invalid order_id"), __NOTIFICATION_TYPE_ERROR__);
 				$this->response->setRedirect(caNavUrl($this->request, '', 'Account', 'Index'), 302);
 				return;
 			} else {
				$this->view->setVar('t_order', $t_order);
				
				//
				// Process address(s)
				//
				$va_fields = array(
						'shipping_fname', 'shipping_lname', 'shipping_organization', 'shipping_address1', 'shipping_address2',
						'shipping_city', 'shipping_zone', 'shipping_postal_code', 'shipping_country', 'shipping_phone', 'shipping_fax', 'shipping_email',
						'billing_fname', 'billing_lname', 'billing_organization', 'billing_address1', 'billing_address2',
						'billing_city', 'billing_zone', 'billing_postal_code', 'billing_country', 'billing_phone', 'billing_fax', 'billing_email',
						
					);
				foreach($va_fields as $vn_i => $vs_f) {
					if (isset($_REQUEST[$vs_f])) {
						if (!$t_order->set($vs_f, $this->request->getParameter($vs_f, pString))) {
							$va_errors[$vs_f] = $t_order->errors();
						}
					}
				}
			
				$t_order->setMode(ACCESS_WRITE);
				if ($t_order->getPrimaryKey()) {
					$t_order->update();
				} else {
					$this->notification->addNotification("Creation of orders from front-end not supported yet", __NOTIFICATION_TYPE_INFO__);
				}
				
				if ($t_order->numErrors()) {
					$va_errors['general'] = $t_order->errors();
					$this->notification->addNotification(_t('Errors occurred: %1', join('; ', $t_order->getErrors())), __NOTIFICATION_TYPE_ERROR__);
				}
				$this->view->setVar('errors', $va_errors);
				
				if (sizeof($va_errors)) {
					if (is_array($va_errors['general']) && sizeof($va_errors['general'])) {
						$va_general_errors = array();
						foreach($va_errors['general'] as $o_e) {
							$va_general_errors[] = $o_e->getErrorDescription();
						}
						$this->notification->addNotification(_t("There were errors in your order. Please examine your order information and correct any errors below, as well as these general problems: %1", join("; ", $va_general_errors)), __NOTIFICATION_TYPE_ERRORS__);
					} else {
						$this->notification->addNotification(_t("There were errors in your order. Please examine your order information and correct the issues highlighted below."), __NOTIFICATION_TYPE_ERRORS__);
					}
				}
				
				//
				// Process payment
				//
				if(!sizeof($va_errors)) {
					if ($t_order->get('payment_received_on')) {
						$this->notification->addNotification(_t('Order is already paid for'), __NOTIFICATION_TYPE_ERROR__);
					} else {
						// Set payment intrinsics
						foreach(array('payment_method', 'payment_status', 'payment_received_on') as $vs_f) { 				
							if (isset($_REQUEST[$vs_f])) {
								if (!$t_order->set($vs_f, $this->request->getParameter($vs_f, pString))) {
									$va_errors[$vs_f] = $t_order->errors();
								}
							}
						}
						$t_order->setMode(ACCESS_WRITE);
						
						// Set payment-type specific info
						$t_order->setPaymentInfo($_REQUEST);
						if ($t_order->numErrors()) {
							$va_errors['payment_info'] = $t_order->getErrors();
							$this->notification->addNotification(_t('Errors occurred: %1', join('; ', $t_order->getErrors())), __NOTIFICATION_TYPE_ERROR__);
						} else {
							$t_order->update();
							if ($t_order->numErrors()) {
								$va_errors['general'] = $t_order->errors();
								$this->notification->addNotification(_t('Errors occurred: %1', join('; ', $t_order->getErrors())), __NOTIFICATION_TYPE_ERROR__);
							} else {
								if ($t_order->get('payment_received_on')) {
									$this->notification->addNotification(_t('Payment was recorded'), __NOTIFICATION_TYPE_INFO__);	
								} else {
									$this->notification->addNotification(_t('Saved changes'), __NOTIFICATION_TYPE_INFO__);	
								}
							}
						}
						$this->view->setVar('errors', $va_errors);
					}
					
				}
				
				$this->viewOrder();
			}
 		}
 		# -------------------------------------------------------
 		/**
 		 *
 		 */
 		public function Download() {
 			$pn_item_id = $this->request->getParameter('item_id', pInteger);
 			$t_item = new ca_commerce_order_items($pn_item_id);
 			$t_order = new ca_commerce_orders($t_item->get('order_id'));
 			$t_transaction = new ca_commerce_transactions($t_order->get('transaction_id'));
 			$o_media = new Media();
 			
 			if ($t_item->getPrimaryKey() && $t_order->getPrimaryKey()) {
 				// Is the order paid for...
 				if (!in_array($t_order->get('order_status'), array('PROCESSED', 'COMPLETED'))) {
 					$this->notification->addNotification(_t("This order must be processed before you can download items"), __NOTIFICATION_TYPE_ERROR__);
 					$this->Index();
 					return;
 				}
 				// ... and accessible by this user?
 				if ($t_transaction->get('user_id') != $this->request->getUserID()) { 
 					$this->notification->addNotification(_t("You may not download this item"), __NOTIFICATION_TYPE_ERROR__);
 					$this->Index();
 					return;
 				}
 				
 				// Is this item downloadable?
 				if ($t_item->get('fullfillment_method') != 'DOWNLOAD') {
 					$this->notification->addNotification(_t("This item cannot be downloaded"), __NOTIFICATION_TYPE_ERROR__);
 					$this->Index();
 					return;
 				}
 				
 				// Which reps, and what versions?
 				$t_object = new ca_objects($t_item->get('object_id'));
 				
 				$va_services_list = array();
 				if (is_array($va_service_groups = $this->opo_client_services_config->getAssoc("service_groups"))) {
					foreach($va_service_groups as $vs_group => $va_services_in_group) {
						foreach($va_services_in_group['services'] as $vs_service => $va_service_info) {
							$va_services_list[$vs_service] = $va_service_info;
						}	
					}
				}
				
 				if (!($vs_version = $va_services_list[$t_item->get('service')]['download_version'])) { $vs_version = 'small'; }
 				$va_reps = $t_object->getRepresentations(array($vs_version));
 				$va_reps_to_download = $t_item->getRepresentationIDs();
 				
 				$o_zip = new ZipFile();
 				
 				$va_files = array();
 				$vn_size = 0;
 				foreach($va_reps as $va_rep) {
 					if (!isset($va_reps_to_download[$va_rep['representation_id']]) || !$va_reps_to_download[$va_rep['representation_id']]) { continue; }
					
					$va_tmp = explode('.', $va_rep['paths'][$vs_version]);
					$vs_ext = array_pop($va_tmp);
					$vs_filename = $va_rep['original_filename'] ? $va_rep['original_filename'] : $t_object->get('idno')."_".$va_rep['representation_id'].".{$vs_ext}";
			
					$vn_size += $va_files[$va_rep['paths'][$vs_version]] = filesize($va_rep['paths'][$vs_version]);
					$o_zip->addFile($va_rep['paths'][$vs_version], $vs_filename, 0, array('compression' => 0));
				}
 				$this->view->setVar('zip', $o_zip);
 				
 				$this->view->setVar('version_download_name', date('dmY', $t_order->get('created_on', array('GET_DIRECT_DATE' => true))).'-'.$t_order->getPrimaryKey());
 				
 				// Log fulfillment
 				$t_item->logFulfillmentEvent('DOWNLOAD', array('ip_addr' => $_SERVER['REMOTE_ADDR'], 'user_id' => $this->request->getUserID(), 'datetime' => time(), 'user_agent' => $_SERVER['HTTP_USER_AGENT'], 'files' => $va_files, 'size' => $vn_size, 'representation_ids' => $va_reps_to_download));
 				
 				return $this->render('Account/download_binary.php');
 			}
 			$this->notification->addNotification(_t("You may not download this"), __NOTIFICATION_TYPE_ERROR__);
 			$this->Index();
 			return;
 		}
 		# -------------------------------------------------------
 		/**
 		 *
 		 */
 		public function SendReply() {
 			$pn_order_id = $this->request->getParameter('order_id', pInteger);
 			$pn_transaction_id = $this->request->getParameter('transaction_id', pInteger);
 			
 			$o_purifier = new HTMLPurifier();
 			$t_trans = new ca_commerce_transactions();
 			if($t_trans->load($pn_transaction_id)) {
				$t_trans->sendUserMessage($o_purifier->purify($this->request->getParameter('subject', pString)), $o_purifier->purify($this->request->getParameter('message', pString)), $this->request->getUserID());
				$this->notification->addNotification(_t("Sent message"), __NOTIFICATION_TYPE_INFO__);
			}else{
				$this->notification->addNotification(_t("Your message could not be sent"), __NOTIFICATION_TYPE_INFO__);		
			}
			$this->ViewOrder();
 		}
 		# -------------------------------------------------------
 		/**
 		 *
 		 */
 		public function ViewMessage() {
 			$pn_communication_id = $this->request->getParameter('communication_id', pInteger);
 			$t_comm = new ca_commerce_communications($pn_communication_id);
 			
 			if ($t_comm->haveAccessToMessage($this->request->getUserID())) {
 				$this->view->setVar('message', $t_comm);
 				$t_comm->logRead($this->request->getUserID());
 				
				$this->view->setVar('messages', $t_comm->getMessages($this->request->getUserID(), array('transaction_id' => $t_comm->get('transaction_id'))));
 			} else {
 				$this->view->setVar('message', null);
 			}
 			$this->render('Sets/view_communication_html.php');
 		}
 		# -------------------------------------------------------
 	}
 ?>