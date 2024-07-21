<div class="row">
	<div class="col-md-12" style="text-align: center;">
		<h3><?= _t('Really delete all clippings?'); ?></h3>
	</div>
</div>
<div class="row">
	<div class="col-md-6" style="text-align: right;">
		<?= caFormTag($this->request, 'Delete', 'deleteConfirm', 'Annotations', 'post', 'multipart/form-data', '_top', []); ?>
		<?= caHTMLHiddenInput('confirm', ['value' => 1]); ?>
		<?= caFormSubmitLink($this->request, _t('Delete'), '', 'deleteConfirm', 'deleteConfirmButton', []); ?>
		</form>
	</div>
	<div class="col-md-6" style="text-align: left;">
		<?= caNavLink($this->request, _t('Cancel'), '', '*', '*', 'Index', []); ?>
	</div>
</div>