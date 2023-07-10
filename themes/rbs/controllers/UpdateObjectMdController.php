<?php
	require_once(__CA_LIB_DIR__."/core/ApplicationError.php");
	require_once(__CA_LIB_DIR__."/core/Datamodel.php");
 	require_once(__CA_APP_DIR__.'/helpers/accessHelpers.php');
 	require_once(__CA_MODELS_DIR__."/ca_objects.php");
	require_once(__CA_LIB_DIR__.'/pawtucket/BasePawtucketController.php');
 	
 	class UpdateObjectMdController extends BasePawtucketController {
 		# -------------------------------------------------------
        /**
         * @var array
         */
 		 protected $opa_fields;
		/**
         * @var HTMLPurifier
         */
        protected $purifier;
        
 		# -------------------------------------------------------
        /**
         * @param RequestHTTP $po_request
         * @param ResponseHTTP $po_response
         * @param null $pa_view_paths
         * @throws ApplicationException
         */
 		public function __construct(&$po_request, &$po_response, $pa_view_paths=null) {
 			parent::__construct($po_request, $po_response, $pa_view_paths);

            if (!($this->request->isLoggedIn())) {
                $this->response->setRedirect(caNavUrl($this->request, "", "LoginReg", "LoginForm"));
                $this->opb_is_login_redirect = true;
                return;
            }
            
 			$this->opa_fields = array("teaching_points");
			$this->purifier = new HTMLPurifier();
 		}
 		# ------------------------------------------------------
        /**
         *
         */
 		function ajaxSave($pa_options = null) {
            if($this->opb_is_login_redirect) { return; }
            if (!$this->request->isAjax()) { $this->response->setRedirect(caNavUrl($this->request, '', 'Lightbox', 'Index')); return; }
 			
 			global $g_ui_locale_id; // current locale_id for user
 			$va_errors = array();
 			
 			$pn_object_id = $this->request->getParameter('object_id', pInteger);
 			$ps_field = $this->request->getParameter('field', pString);
 			$ps_value = $this->purifier->purify($this->request->getParameter($ps_field, pString));
 			if($pn_object_id && $ps_field && (in_array($ps_field, $this->opa_fields))){
 				$t_object = new ca_objects($pn_object_id);
 				if($ps_value){
					$t_object->setMode(ACCESS_WRITE);

					$t_object->replaceAttribute(array($ps_field => $ps_value, 'locale_id' => $g_ui_locale_id), $ps_field);
					$t_object->update();
					if($t_object->numErrors()) {
						$va_errors[] = join("; ", $t_object->getErrors());
						print join("; ", $va_errors);
					}else{
						print $t_object->get($ps_field);
					}
				}else{
					print $t_object->get($ps_field);
				}
			 }
 		}
 		# -------------------------------------------------------
 	}

?>