<?php
	require('../../../setup.php');
	require_once(__CA_LIB_DIR__."/core/Db.php");
	require_once(__CA_MODELS_DIR__."/ca_users.php");
	
	$o_db = new Db();
	$q_users = $o_db->query("select user_id from ca_users");
	$t_user = new ca_users();
	while($q_users->nextRow()){
		$t_user->load($q_users->get("user_id"));
		$t_user->setMode(ACCESS_WRITE);
		$t_user->setPreference("user_profile_field_of_research", $t_user->getVar("field_of_research"));
		$t_user->update();
	}
?>