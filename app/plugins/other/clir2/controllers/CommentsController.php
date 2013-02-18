<?php
/* ----------------------------------------------------------------------
 * CommentsController.php
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2009-2011 Whirl-i-Gig
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
 
 	require_once(__CA_LIB_DIR__."/ca/SiteComments.php");
 
 	class CommentsController extends ActionController {
 		# -------------------------------------------------------
 		private $opo_plugin_config;			// plugin config file
 		private $ops_theme;						// current theme
 		private $opo_result_context;			// current result context
 		
 		# -------------------------------------------------------
 		public function __construct(&$po_request, &$po_response, $pa_view_paths=null) {
 			
 			parent::__construct($po_request, $po_response, $pa_view_paths);
			$this->opo_plugin_config = Configuration::load($this->request->getAppConfig()->get('application_plugins').'/clir2/conf/clir2.conf');
 			
 			if (!(bool)$this->opo_plugin_config->get('enabled')) { die(_t('clir2 plugin is not enabled')); }
 			
 			$this->ops_theme = __CA_THEME__;																		// get current theme
 			if(!is_dir(__CA_APP_DIR__.'/plugins/clir2/views/'.$this->ops_theme)) {		// if theme is not defined for this plugin, try to use "default" theme
 				$this->ops_theme = 'default';
 			}
 			
 		}
 		# -------------------------------------------------------
 		public function Index() {
 			#
 			# User-generated comments, tags and ratings
 			#
 			$t_siteComments = new SiteComments();
 			$va_user_comments = $t_siteComments->getComments(null, true);
 			$va_comments = array();
 			if (is_array($va_user_comments)) {
				foreach($va_user_comments as $va_user_comment){
					$va_comment = array();
					if($va_user_comment["comment"]){
						$va_comment["comment"] = $va_user_comment["comment"];
						
						# TODO: format date based on locale
						$va_comment["date"] = date("n/j/Y", $va_user_comment["created_on"]);
						$va_comment["created_on"] = $va_user_comment["created_on"];
						
						# -- get name of commenter
						$t_user = new ca_users($va_user_comment["user_id"]);
						$va_comment["author"] = $t_user->getName();
						
						$va_comment["email"] = $va_user_comment["email"];
						$va_comment["name"] = $va_user_comment["name"];
						$va_comments[] = $va_comment;
					}
				}
			}
 			$this->view->setVar('comments', $va_comments);
 			$this->render('Comments/comments_html.php');
 		}
 		# -------------------------------------------------------
 		public function saveComment() {
 			$va_errors = array();
 			$t_siteComments = new SiteComments();
 			# --- get params from form
 			$pn_rank = $this->request->getParameter('rank', pInteger);
 			$ps_tags = $this->request->getParameter('tags', pString);
 			$ps_comment = $this->request->getParameter('comment', pString);
 			if(!$ps_comment){
 				$va_errors["comment"] = _t("Please enter your comment.");
 			}
 			if($this->request->isLoggedIn()){
 				$ps_email = $this->request->user->get("email");
 			}else{
 				$ps_email = $this->request->getParameter('email', pString);
 				if(!$ps_email){
					$va_errors["email"] = _t("Please enter your email address.");
				}
 				$ps_name = $this->request->getParameter('name', pString);
 				if(!$ps_name){
					$va_errors["name"] = _t("Please enter your name.");
				}
 			}
 			
 			if(sizeof($va_errors) == 0){
 				if(!(($pn_rank > 0) && ($pn_rank <= 5))){
 					$pn_rank = null;
 				}
 				# --- if logged in grab the email address from the user record
 				if($ps_comment || $pn_rank){
 					$t_siteComments->addComment($ps_comment, $pn_rank, $this->request->getUserID(), null, $ps_name, $ps_email, ($this->request->config->get("dont_moderate_comments")) ? 1:0, null);
 				}
 				if($ps_tags){
 					$va_tags = array();
 					$va_tags = explode(",", $ps_tags);
 					foreach($va_tags as $vs_tag){
 						$t_siteComments->addTag(trim($vs_tag), $this->request->getUserID(), null, ($this->request->config->get("dont_moderate_comments")) ? 1:0, null);
 					}
 				}
 				if($ps_comment || $ps_tags){
 					if($this->request->config->get("dont_moderate_comments")){
 						$this->notification->addNotification(_t("Thank you for contributing."), "message");
 					}else{
 						$this->notification->addNotification(_t("Thank you for contributing.  Your comments will be posted on this page after review by site staff."), "message");
 					}
 					# --- check if email notification should be sent to admin
 					if(!$this->request->config->get("dont_email_notification_for_new_comments")){
 						# --- send email confirmation
						# -- generate mail text from template
						ob_start();
						require($this->request->getViewsDirectoryPath()."/mailTemplates/admin_comment_notification.tpl");
							
						$vs_mail_message = ob_get_contents();
						ob_end_clean();
						
						caSendmail($this->request->config->get("ca_admin_email"), $this->request->config->get("ca_admin_email"), "[".$this->request->config->get("app_display_name")."] "._t("New user comment/tag"), $vs_mail_message);
 					}
 				}else{
 					$this->notification->addNotification(_t("Thank you for your contribution."), "message");
 				}
 			}else{
 				$this->view->setVar('errors', $va_errors);
 				$this->view->setVar('name', $ps_name);
 				$this->view->setVar('email', $ps_email);
 				$this->view->setVar('comment', $ps_comment);
 			}
 			
 			$this->Index();
 		}
 		# -------------------------------------------------------
 	}
 ?>