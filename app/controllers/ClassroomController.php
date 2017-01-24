<?php
/* ----------------------------------------------------------------------
 * controllers/ClassroomController.php
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2015-2017 Whirl-i-Gig
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
 
 
  	require_once(__CA_APP_DIR__."/controllers/LightboxController.php");
 
 	class ClassroomController extends LightboxController {
 		# -------------------------------------------------------
        /**
         * @var array
         */
 		 protected $opa_user_groups;

        /**
         * @var Configuration
         */
 		 protected $opo_config;

        /**
         * @var
         */
 		 protected $ops_classroom_display_name;
 		 protected $ops_classroom_display_name_plural;
 		 protected $ops_classroom_section_heading;

        /**
         * @var
         */
        protected $opb_is_login_redirect = false;
        
        /**
         * @var HTMLPurifier
         */
        protected $purifier;
        
        /**
         * @var string
         */
        protected $ops_tablename = 'ca_objects';

 		# -------------------------------------------------------
        /**
         * @param RequestHTTP $po_request
         * @param ResponseHTTP $po_response
         * @param null $pa_view_paths
         * @throws ApplicationException
         */
 		public function __construct(&$po_request, &$po_response, $pa_view_paths=null) {
 			parent::__construct($po_request, $po_response, $pa_view_paths);

            // Catch disabled classroom
            if ($this->request->config->get('disable_classroom')) {
 				throw new ApplicationException('Classroom is not enabled');
 			}
 			if (!($this->request->isLoggedIn())) {
                $this->response->setRedirect(caNavUrl($this->request, "", "LoginReg", "LoginForm"));
                $this->opb_is_login_redirect = true;
                return;
            }
            if (($this->request->config->get('deploy_bristol'))&&($this->request->isLoggedIn())) {
            	print "You do not have access to view this page.";
            	die;
            }

 			$t_user_groups = new ca_user_groups();
 			$this->opa_user_groups = $t_user_groups->getGroupList("name", "desc", $this->request->getUserID());
 			$this->view->setVar("user_groups", $this->opa_user_groups);

 			$this->opo_config = caGetClassroomConfig();
 			caSetPageCSSClasses(array("sets", "classroom"));
 			
 			$va_classroomDisplayName = caGetClassroomDisplayName($this->opo_config);
 			$this->view->setVar('classroom_config', $this->opo_config);
 			
			$this->ops_classroom_section_heading = $va_classroomDisplayName["section_heading"];
			$this->ops_classroom_display_name = $va_classroomDisplayName["singular"];
			$this->ops_classroom_display_name_plural = $va_classroomDisplayName["plural"];
			$this->view->setVar('classroom_section_heading', $this->ops_classroom_section_heading);
			$this->view->setVar('classroom_display_name', $this->ops_classroom_display_name);
			$this->view->setVar('classroom_display_name_plural', $this->ops_classroom_display_name_plural);
			
			$this->purifier = new HTMLPurifier();
			
			$this->view->setVar('educator_role', 'EDUCATOR');
			$this->view->setVar('student_role', 'STUDENT');
			$this->view->setVar('user_role', $this->request->user->getPreference("user_profile_classroom_role"));
			
 		}
 		# -------------------------------------------------------
        /**
         *
         */
 		function index($pa_options = null) {
 			parent::index(array('view' => 'Classroom/list_html.php'));
 		}
 		# -------------------------------------------------------
 		function setForm($pa_options = null) {
 			$this->view->setVar('parent_id', $this->request->getParameter('parent_id', pInteger));
 			parent::setForm(array('view' => 'Classroom/form_set_info_html.php'));
 		}
 		# -------------------------------------------------------
 		function userGroupForm($pa_options = null) {
 			parent::userGroupForm(array('user_group_heading' => _t('Group')));
 		}
 		# -------------------------------------------------------
 		function saveUserGroup($pa_options = null) {
 			parent::saveUserGroup(array('user_group_terminology' => _t('group')));
 		}
 		# -------------------------------------------------------
 		function ajaxSaveSetInfo($pa_options = null) {
 			parent::ajaxSaveSetInfo(array('set_list_item_function' => 'caClassroomSetListItem', 'display_name' => $this->ops_classroom_display_name));
 		}
 		# -------------------------------------------------------
 		function setDetail($pa_options = null) {
 			parent::setDetail(array('view' => 'Classroom/set_detail_html.php', 'display_name' => $this->ops_classroom_display_name));
 		}
 		# ------------------------------------------------------
 		function shareSetForm($pa_options = null) {
           parent::shareSetForm(array('display_name' => $this->ops_classroom_display_name));
 		}
 		# -------------------------------------------------------
 		function saveShareSet($pa_options = null) {
           parent::saveShareSet(array('display_name' => $this->ops_classroom_display_name, 'display_name_plural' => $this->ops_classroom_display_name_plural));
 		}
 		# -------------------------------------------------------
 		function setAccess($pa_options = null) {
           parent::setAccess(array('view' => 'Classroom/set_access_html.php'));
 		}
 		# -------------------------------------------------------
 		function addItemForm($pa_options = null) {
 			parent::addItemForm(array('display_name' => $this->ops_classroom_display_name, 'display_name_plural' => $this->ops_classroom_display_name_plural));
 		}
 		# -------------------------------------------------------
 		function ajaxAddItem($pa_options = null) {
 			parent::ajaxAddItem(array('display_name' => $this->ops_classroom_display_name, 'display_name_plural' => $this->ops_classroom_display_name_plural));
 		}
 		# -------------------------------------------------------
 		function present($pa_options = null) {
 			parent::present(array('controller' => 'Classroom', 'display_name' => $this->ops_classroom_display_name, 'display_name_plural' => $this->ops_classroom_display_name_plural));
 		}
 		# -------------------------------------------------------
 	}