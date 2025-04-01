<?php
/* ----------------------------------------------------------------------
 * themes/default/views/Lightbox/user_access_list_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2025 Whirl-i-Gig
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
$t_set 		= $this->getVar('t_set');
$set_id 	= $t_set->getPrimaryKey();
$users 		= $t_set->getUsers();
$errors 	= $this->getVar('error_message');
$success 	= $this->getVar('success_message');

if($errors){
?>
  <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
      <p><?= $errors; ?></p>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>

<?php } ?>
  <div id="userShares" class="table-responsive">
    <table class="table table-bordered">
<?php if (!empty($users)) { // Render list only if users exist ?>
      <thead>
        <tr>
          <th><?= _t('User Name'); ?></th>
          <th><?= _t('Email'); ?></th>
          <th><?= _t('Date Available'); ?></th>
          
          <th><?= _t('Downloads'); ?></th>
          <th><?= _t('Actions'); ?></th>
        </tr>
      </thead>
<?php } else { ?>
    <p class="mt-3 text-muted"><?= _t('No shares defined'); ?></p>
<?php } ?>
      <tbody>
<?php 
    foreach ($users as $user) {
    	if(!is_array($user['settings']['download_versions'] ?? null)) { $user['settings']['download_versions'] = []; }
?>
          <tr>
            <td><?= $user['fname'].' '.$user['lname']; ?></td>
            <td style="word-break: break-word;">
              <div class="d-flex align-items-center">
              	<?= $user['email']; ?>
              </div>
            </td>
            <td><?= $user['effective_date']; ?></td>
            <td><?= join('; ', $user['settings']['download_versions']) ?: _t('None'); ?></td>
            <td>
              <button class="btn btn-sm deleteUrl" 
                hx-post="<?= caNavUrl($this->request, '*', '*', 'RemoveUserShare', ['id' => $set_id, 'user_id' => $user['user_id']]); ?>" 
                hx-target="#userShares" 
                hx-swap="outerHTML"
              >
                <i class="bi bi-trash3"></i> <?= _t("Delete"); ?>
              </button>
            </td>
          </tr>
<?php 	
	}
?>
      </tbody>
    </table>
  </div>
