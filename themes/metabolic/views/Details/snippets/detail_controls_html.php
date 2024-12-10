<?php
	$t_object = 			$this->getVar("item");
	$va_access_values = 	$this->getVar("access_values");
    $options = 			    $this->getVar("config_options");
    $comments = 		    $this->getVar("comments");
    $tags = 			    $this->getVar("tags_array");
    $comments_enabled =     $this->getVar("commentsEnabled");
    $pdf_enabled = 		    $this->getVar("pdfEnabled");
    $inquire_enabled = 	    $this->getVar("inquireEnabled");
    $copy_link_enabled = 	$this->getVar("copyLinkEnabled");
    $id =				    $t_object->get('ca_objects.object_id');
?>

<?php
	if($inquire_enabled || $pdf_enabled || $copy_link_enabled){
?>
	<div class="row justify-content-center">
		<div class="col-sm-12 col-md-8">
			<div class="btn-group" role="group" aria-label="Detail Controls">
				<?= $this->render('Details/snippets/lightbox_list_html.php'); ?>
<?php
				if($inquire_enabled) {
					print caNavLink($this->request, "<i class='bi bi-envelope me-1'></i> "._t("Email"), "btn btn-sm btn-white ps-3 pe-0 fw-medium", "", "Contact", "Form", array("inquire_type" => "item_inquiry", "table" => "ca_objects", "id" => $id));
				}
				if($pdf_enabled) {
					print caDetailLink($this->request, "<i class='bi bi-download me-1'></i> "._t('Download'), "btn btn-sm btn-white ps-3 pe-0 fw-medium", "ca_objects", $id, array('view' => 'pdf', 'export_format' => '_pdf_ca_objects_summary'));
				}
				if($copy_link_enabled){
?>
				<button type="button" class="btn btn-sm btn-white ps-3 pe-0 fw-medium"><i class="bi bi-copy"></i> <?= _t('Copy URL'); ?></button>
<?php
				}
?>
			</div>
		</div>
	</div>
<?php
	}
?>
