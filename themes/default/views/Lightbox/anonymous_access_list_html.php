<?php
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
		$url = caNavUrl($this->request, '*', '*', 'View/'.$token['guid'], [], ['absolute' => true]);
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