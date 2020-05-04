<?php
/* ----------------------------------------------------------------------
 * themes/default/views/Contribute/form_html.php : sample Contribute form
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2014-2016 Whirl-i-Gig
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
 
	$ps_ref_table = $this->request->getParameter("ref_table", pString);
	$pn_ref_row_id = $this->request->getParameter("ref_row_id", pInteger);
	
	if($ps_ref_table && $pn_ref_row_id){
		$o_dm = $this->request->getAppDatamodel();
		$t_instance = $o_dm->getInstanceByTableName($ps_ref_table);
		$t_instance->load($pn_ref_row_id);
		$vs_ref_name = caDetailLink($this->request, $t_instance->get($ps_ref_table.".preferred_labels"), '', $ps_ref_table, $pn_ref_row_id);
	}
?>
	<div class="row">
		<div class="col-sm-12">
<?php
	if($this->request->isAjax()){
?>
			<div class="pull-right pointer" onclick="caMediaPanel.hidePanel(); return false;"><span class="glyphicon glyphicon-remove-circle"></span></div>
<?php
}
?>
			<h1>Contribute to the Girl Scouts of the USA Collection</h1>
			<p>Thank you for your contribution! Your record has been successfully uploaded to the archive for review.</p>
<?php
			if($ps_ref_table && $pn_ref_row_id){
?>
				<div><b>Back to: </b><?php print $vs_ref_name; ?></div>
<?php
			}
?>
		</div>
	</div>
