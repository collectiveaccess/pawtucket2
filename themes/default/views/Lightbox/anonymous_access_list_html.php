<?php
/* ----------------------------------------------------------------------
 * themes/default/views/Lightbox/anonymous_access_list_html.php : 
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
$t_set = $this->getVar('t_set');
$set_id = $t_set->getPrimaryKey();
$anonymousTokens = $t_set->getAnonymousAccessTokens();
?>
<div id="sharedUrls" class="table-responsive">
  <table class="table table-bordered">
    <thead>
      <tr>
        <th><?= _t('Name'); ?></th>
        <th><?= _t('URL'); ?></th>
        <th><?= _t('Expiration'); ?></th>
        <th><?= _t('Actions'); ?></th>
      </tr>
    </thead>
    <tbody>
<?php 
	foreach ($anonymousTokens as $token): 
		$url = caNavUrl($this->request, '*', '*', 'Detail/'.$token['guid'], [], ['absolute' => true]);
?>
        <tr>
          <td><?= $token['name']; ?></td>
          <td>
            <div class="d-flex align-items-center">
              <a href="<?= $url; ?>" class="me-2" target="_new"><?= $url; ?></a>
              <button class="btn btn-sm btn-secondary copyButton" type="button" aria-label="Copy URL">
                  <i class="bi bi-clipboard"></i>
              </button>
            </div>
          </td>
          <td><?= $token['effective_date']; ?></td>
          <td>
            <button class="btn btn-sm deleteUrl" 
            	hx-post="<?= caNavUrl($this->request, '*', '*', 'RemoveAnonymousAccess', ['id' => $set_id, 'guid' => $token['guid']]); ?>" 
				hx-target="#sharedUrls" 
				hx-swap="outerHTML"
			>
              <i class="bi bi-trash3"></i> <?= _t("Delete"); ?>
            </button>
          </td>
        </tr>
<?php 
	endforeach; 
?>
    </tbody>
  </table>
</div>