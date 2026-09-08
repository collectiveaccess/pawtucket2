<button type="button" class="btn btn-sm btn-white ps-3 pe-0 fw-medium" onClick="copyCurrentURL();" data-bs-toggle="modal" data-bs-target="#copyURLModal"><i class="bi bi-copy"></i> <?= _t('Copy Link'); ?></button>
<script>
function copyCurrentURL() {
	var inputc = document.body.appendChild(document.createElement("input"));
	inputc.value = window.location.href;
	inputc.select();
	document.execCommand('copy');
	inputc.parentNode.removeChild(inputc);
}
</script>

<div class="modal fade" id="copyURLModal" tabindex="-1" aria-labelledby="copyURLModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content text-start">
			<div class="modal-body">
				<div id="copyURLModalLabel"><?= _t("Link Copied to Clipboard."); ?></div>
			</div>
	  		<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?= _t('Close'); ?></button>
	  		</div>
		</div>
	</div>
</div>