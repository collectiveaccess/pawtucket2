<?php
/* ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2014-2017 Whirl-i-Gig
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
 * hsftp://seth:@c//data/noguchi/themes/noguchi/views/pageFormat/pageHeader.phpttp://www.CollectiveAccess.org
 *
 * ----------------------------------------------------------------------
 */
?><!DOCTYPE html>
<html lang="en-US" class="collective-access" id="cahtmlWrapper"> 
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	    <title><?php print MetaTagManager::getWindowTitle(); ?></title>
	    
	    <?php print MetaTagManager::getHTML(); ?>

        <!-- <link rel='stylesheet' id='style-all-0-css'  href='assets/css/style.css?ver=<?= rand(); ?>' type='text/css' media='all' />-->
        <script src="<?php print $this->request->getThemeUrlPath(); ?>/assets/css.js"></script>
        <script type='text/javascript' src='<?php print $this->request->getThemeUrlPath(); ?>/jslib/jquery-3.4.0.min.js?ver=<?= rand(); ?>'></script>
        <script type='text/javascript' src='<?php print $this->request->getThemeUrlPath(); ?>/jslib/libs-head-min.js?ver=<?= rand(); ?>'></script>
        
<link rel="stylesheet" type="text/css" href="<?php print $this->request->getAssetsUrlPath(); ?>/diva/diva.css"/>	
<script type="text/javascript" src="<?php print $this->request->getAssetsUrlPath(); ?>/diva/diva.js"></script>
<?php
		# --- set metatag for detail pages
		if(strToLower($this->request->getController()) == "detail"){
			$o_detail_config = caGetDetailConfig();
			$va_detail_types = $o_detail_config->getAssoc('detailTypes');
			
			// expand to aliases
			foreach($va_detail_types as $vs_code => $va_info) {
				if(is_array($va_aliases = caGetOption('aliases', $va_info, null))) {
					foreach($va_aliases as $vs_alias) {
						$va_detail_types[$vs_alias] =& $va_detail_types[$vs_code];
					}
				}
			}
			$vs_action = strtolower($this->request->getAction());
			$ps_id = str_replace("~", "/", urldecode($this->request->getActionExtra())); 
			$vs_table = $va_detail_types[$vs_action]['table'];
			if($vs_table){
				$t_subject = Datamodel::getInstance($vs_table, true);
 				$vs_use_alt_identifier_in_urls = caUseAltIdentifierInUrls($vs_table);
				if ((($vb_use_identifiers_in_urls = caUseIdentifiersInUrls()) || ($vs_use_alt_identifier_in_urls)) && (substr($ps_id, 0, 3) == "id:")) {
					$va_tmp = explode(":", $ps_id);
					$ps_id = (int)$va_tmp[1];
					$vb_use_identifiers_in_urls = $vs_use_alt_identifier_in_urls = false;
				}
 
				if($vs_use_alt_identifier_in_urls && $t_subject->hasElement($vs_use_alt_identifier_in_urls)) {
					$va_load_params = [$vs_use_alt_identifier_in_urls => $ps_id];
				} elseif ($vb_use_identifiers_in_urls && $t_subject->getProperty('ID_NUMBERING_ID_FIELD')) {
					$va_load_params = [$t_subject->getProperty('ID_NUMBERING_ID_FIELD') => $ps_id];
				} else {
					$va_load_params = [$t_subject->primaryKey() => (int)$ps_id];
				}
 			
				if ($t_subject = call_user_func_array($t_subject->tableName().'::find', array($va_load_params, ['returnAs' => 'firstModelInstance']))) {
					$vs_meta_tag_date = "";
					if($vs_action == "bibliography"){
						$vs_meta_tag_date = $t_subject->get("ca_occurrences.bib_year_published");
					}else{
						$va_date = array_pop(array_pop($t_subject->get($vs_table.".date.parsed_date", array("returnWithStructure" => true))));
						if(is_array($va_date) && $va_date["parsed_date_sort_"]){
							$va_date_parts = explode("/", $va_date["parsed_date_sort_"]);
							$va_date_parts_clean = array();
							$vs_tmp = "";
							foreach($va_date_parts as $va_date_part){
								if($vs_tmp != round($va_date_part)){
									$va_date_parts_clean[] = round($va_date_part);
								}
								$vs_tmp = round($va_date_part);
							}
							$vs_meta_tag_date = join("-", $va_date_parts_clean);
						}			
					}
					
					if($vs_meta_tag_date){
						print "<meta name='search:subtitle' content='".$vs_meta_tag_date."' />";
					}
				}
			}
		}
?>
    
    </head>
    <body class="collective-access" id="pawtucketApp" itemscope itemtype="http://schema.org/WebPage">
		<script type="text/javascript">
			let pawtucketUIApps = {};
		</script>
<?php
		print $this->render("pageFormat/header_include.php");
?>

        <div id="barba-wrapper">
            <div class="barba-container">
<?php
 		# --- no header on CR landing
 		if((strToLower($this->request->getController()) != "cr") || ((strToLower($this->request->getController()) == "cr") && (strToLower($this->request->getAction()) != "index"))){
?>
                <section class="module_pageheader">

                    <div class="wrap text-align-center">
                        <h3 class="subheadline">
<?php
						switch(strToLower($this->request->getController())){
							case "archive":
							case "loginreg":
							case "archiveinfo":
							case "lightbox":
							case "mydocuments":
								print caNavLink("The Isamu Noguchi Archive", "", "", "Archive", "Index");
							break;
							# ---------------------------------------
							case "cr":
									print caNavLink("The Isamu Noguchi Catalogue Raisonné", "", "", "CR", "Index");
							break;
							# ---------------------------------------
							case "detail":
								switch(strToLower($this->request->getAction())){
									case "archival":
									case "library":
									case "bibliography":
										print caNavLink("The Isamu Noguchi Archive", "", "", "Archive", "Index");
									break;
									# ---------------------------------------
									case "artwork":
										print caNavLink("The Isamu Noguchi Catalogue Raisonné", "", "", "CR", "Index");
									break;
									# ---------------------------------------
									case "exhibition":
										print caNavLink("Exhibitions", "", "", "Browse", "exhibitions");
									break;
									# ---------------------------------------
								}
							break;
							# ---------------------------------------
							case "browse":
								switch(strToLower($this->request->getAction())){
									case "archive":
									case "library":
									case "bibliography":
										print caNavLink("The Isamu Noguchi Archive", "", "", "Archive", "Index");
									break;
									# ---------------------------------------
									case "cr":
										print caNavLink("The Isamu Noguchi Catalogue Raisonné", "", "", "CR", "Index");
									break;
									# ---------------------------------------
									case "exhibitions":
											print caNavLink("Exhibitions", "", "", "Browse", "exhibitions");
									break;
									# ---------------------------------------
								}
							break;
							# ---------------------------------------
						}
?>
                        </h3>
<?php
			$vb_show_user_menu = false;
			switch(strToLower($this->request->getController())){
				case "archive":
				case "loginreg":
				case "archiveinfo":
				case "lightbox":
				case "mydocuments":
					$vb_show_user_menu = true;
				break;
				# -----------------------------------------
				case "browse":
					if(in_array(strToLower($this->request->getAction()), array('archive', 'library'))){
						$vb_show_user_menu = true;
					}
				break;
				# -----------------------------------------
				case "detail":
					if(in_array(strToLower($this->request->getAction()), array('archival', 'library'))){
						$vb_show_user_menu = true;
					}
				break;
				# -----------------------------------------
			}
			if($vb_show_user_menu){
				if($this->request->isLoggedIn()) { 
?>
						<div class="utility utility_menu hide-for-mobile">
							<a href="#" class="trigger"><?php print $this->request->user->get("fname")." ".$this->request->user->get("lname"); ?></a>
							<div class="options">
<?php
								print caNavLink("Profile", "", "", "LoginReg", "profileForm");
								print "<a href='#'>My Documents</a>";
								#print caNavLink("My Documents", "", "", "Lightbox", "Index");
								print caNavLink("Logout", "", "", "LoginReg", "logout");
?>
							</div>
						</div>
<?php
				} else {
?>
						 <div class="utility hide-for-mobile">
<?php
							print caNavLink("Researcher Login", "trigger", "", "LoginReg", "loginForm");
?>
						</div>
<?php
				}

			}
?>                     
                    </div>
                </section>
<?php
		}
?>
