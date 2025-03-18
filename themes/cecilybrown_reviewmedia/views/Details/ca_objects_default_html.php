<?php
/* ----------------------------------------------------------------------
 * themes/default/views/bundles/ca_objects_default_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013-2024 Whirl-i-Gig
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
$t_object = 		$this->getVar("item");
$access_values = 	$this->getVar("access_values");
$options = 			$this->getVar("config_options");
$comments = 		$this->getVar("comments");
$tags = 			$this->getVar("tags_array");
$comments_enabled = $this->getVar("commentsEnabled");
$pdf_enabled = 		$this->getVar("pdfEnabled");
$inquire_enabled = 	$this->getVar("inquireEnabled");
$copy_link_enabled = 	$this->getVar("copyLinkEnabled");
$id =				$t_object->getPrimaryKey();
$show_nav = 		($this->getVar("previousLink") || $this->getVar("resultsLink") || $this->getVar("nextLink")) ? true : false;
$map_options = $this->getVar('mapOptions') ?? [];
$media_options = $this->getVar('media_options') ?? [];

$lightboxes = $this->getVar('lightboxes') ?? [];
$in_lightboxes = $this->getVar('inLightboxes') ?? [];

$media_options = array_merge($media_options, [
	'id' => 'mediaviewer'
]);

$next_url = $this->getVar('nextURL');

?>
<script>
	pawtucketUIApps['geoMapper'] = <?= json_encode($map_options); ?>;
	pawtucketUIApps['mediaViewerManager'] = <?= json_encode($media_options); ?>;
</script>
<?php

// echo "<pre>";
// print_r($options);
// echo "</pre>";

if($show_nav){
?>
	<div class="row mt-n3">
		<div class="col text-center text-md-end">
			<nav aria-label="result">
				<button id="toggleNavBtn" class="btn btn-secondary btn-sm">Hide Header</button>
				{{{previousLink}}}{{{resultsLink}}}{{{nextLink}}}
			</nav>
		</div>
	</div>
<?php
}
?>
	<div class="row">
		<div class="col-md-12">
			{{{<ifdef code="ca_objects.type_id|ca_objects.idno"><H1 class="fs-5 fw-medium mb-3"><ifdef code="ca_objects.type_id">^ca_objects.type_id</ifdef><ifdef code="ca_objects.idno">, ^ca_objects.idno</ifdef></H1></ifdef>}}}
			<hr class="mb-1">
		</div>
	</div>
<?php
	if(caDisplayLightbox($this->request) || $inquire_enabled || $pdf_enabled || $copy_link_enabled){
?>
	<div class="row">

		<div class="col text-center text-md-end">

<?php
$is_media_review_enabled = $options['media_review_enabled'];
$media_review_element = strval($options['media_review_element']);
$media_review_type = $options['media_review_type'];
$complete_value = $options['media_review_complete_value'];
$incomplete_value = $options['media_review_incomplete_value'];

$review_complete_status = $t_object->get($media_review_element, ['convertCodesToIdno' => true]);
$object_type = $t_object->getTypeCode();
$user_is_admin = ($this->request->isLoggedIn() && $this->request->user->canDoAction('is_administrator'));

// echo "<pre>";
// echo "Is Enabled: ";
// var_dump($is_media_review_enabled);
// echo "<br>Review Element: ";
// var_dump($media_review_element);
// echo "<br>Review Complete Status: ";
// var_dump($review_complete_status);
// echo "<br>Complete Value: ";
// var_dump($complete_value);
// echo "<br>Object Type: ";
// var_dump($object_type);
// echo "<br>Expected Type: ";
// var_dump($media_review_type);
// echo "<br>User is Admin: ";
// var_dump($user_is_admin);
// echo "</pre>";

if($is_media_review_enabled && ($review_complete_status !== $complete_value) && ($object_type == $media_review_type) && $user_is_admin) {
	if(!preg_match("![\d]+$!", $next_url)) {
	    $next_url .= $id;
	}
?>
			<a class="text-decoration-none" href="<?= $next_url;?>/reviewComplete/<?= $id; ?> ">
				<button class="btn btn-sm btn-outline-success"><i class="bi bi-check2-circle"></i> Review Complete</button>
			</a>
<?php
}
?>


<!-- <?php
$review_complete_status = $t_object->get('ca_objects.media_reviewed', ['convertCodesToIdno' => true]);
$object_type = $t_object->getTypeCode();
$user_is_admin = ($this->request->isLoggedIn() && $this->request->user->canDoAction('is_administrator'));
if(($review_complete_status !== 'yes') && ($object_type === 'artwork') && $user_is_admin) {
?>
			<a href="{{{nextURL}}}/reviewComplete/<?= $id; ?> ">
				<button class="btn btn-sm btn-outline-success"><i class="bi bi-check2-circle"></i> Review Complete</button>
			</a>
<?php
}
?> -->

			<div class="btn-group" role="group" aria-label="Detail Controls">
<?php
				if($inquire_enabled) {
					print caNavLink($this->request, "<i class='bi bi-envelope me-1'></i> "._t("Inquire"), "btn btn-sm btn-white ps-3 pe-0 fw-medium", "", "Contact", "Form", array("inquire_type" => "item_inquiry", "table" => "ca_objects", "id" => $id));
				}
				if($pdf_enabled) {
					print caDetailLink($this->request, "<i class='bi bi-download me-1'></i> "._t('Download as PDF'), "btn btn-sm btn-white ps-3 pe-0 fw-medium", "ca_objects", $id, array('view' => 'pdf', 'export_format' => '_pdf_ca_objects_summary'));
				}
				if($copy_link_enabled){
					print $this->render('Details/snippets/copy_link_html.php');
				}
?>				
			</div>
			<?= $this->render('Details/snippets/lightbox_list_html.php'); ?>
	
		</div>


	</div>
<?php
	}
?>

	<div class="row my-4">
		<div class="col-md-7">
			{{{media_viewer}}}
		</div>
		<div class="col-md-5">
			<div class="bg-light py-3 px-4 h-100"><!-- height is to make the gray background of box same height as the containing row -->				
				<div class="mb-3">
					{{{
						<ifcount code="ca_entities" min="1" restrictToRelationshipTypes="artist">
							<unit relativeTo="ca_entities" restrictToRelationshipTypes="artist" delimiter=", ">
								<dd>^ca_entities.preferred_labels.displayname</dd>
							</unit>
						</ifcount>

						<ifdef code="ca_objects.preferred_labels">
							<dd><i>^ca_objects.preferred_labels</i></dd>
						</ifdef>

						<ifdef code="ca_objects.alternate_id_container.alternate_id">
							<dt><?= _t('Alternate/Former ID'); ?></dt>
							<dd>
								^ca_objects.alternate_id_container.alternate_id
								<ifdef code="ca_objects.alternate_id_container.alternate_id_source">
									, (Source) ^ca_objects.alternate_id_container.alternate_id_source
								</ifdef>
							</dd>
						</ifdef>
						
						<ifdef code="ca_objects.date_container.date">
							<dt><?= _t('Date'); ?></dt>
							<dd>^ca_objects.date_container.date</dd>
						</ifdef>

						<ifdef code="ca_objects.medium_container.medium">
							<dt><?= _t('Medium'); ?></dt>
							<dd>^ca_objects.medium_container.medium</dd>
						</ifdef>

						<ifdef code="ca_objects.dimensions_container.display_dimensions">
							<dt><?= _t('Dimensions'); ?></dt>
							<dd>^ca_objects.dimensions_container.display_dimensions</dd>
						</ifdef>

						<ifdef code="ca_objects.edition_size">
							<dd>^ca_objects.edition_size</dd>
						</ifdef>

						<ifdef code="ca_objects.edition_item.edition_item_number">
							<dd>^ca_objects.edition_item.edition_item_number</dd>
						</ifdef>
					}}}
				</div>

				{{{<ifcount code="ca_objects.children" min="1">
					<dl class="mb-0">
						<dt>Edition Contains:</dt>
						<unit relativeTo="ca_objects.children" delimiter=" ">
							<dd>
							<l><ifdef code="ca_objects.edition_item.edition_item_number">^ca_objects.edition_item.edition_item_number</ifdef></l>
							</dd>
						</unit>
					</dl>
						
				</ifcount>}}}

				{{{<ifdef code="ca_objects.parent_id">
					<dl class="mb-0">
						<dt>Part of Edition:</dt>
						<unit relativeTo="ca_objects.parent" delimiter=" ">
							<dd>
							<l>
								<ifdef code="ca_objects.preferred_labels"><i>^ca_objects.preferred_labels</i></ifdef>

								<ifdef code="ca_objects.date_container.date,ca_objects.preferred_labels">, </ifdef>
								<ifdef code="ca_objects.date_container.date">^ca_objects.date_container.date</ifdef>
								<ifdef code="ca_objects.date_container.date|ca_objects.preferred_labels"><br/></ifdef>

								<ifdef code="ca_objects.medium_container.medium">^ca_objects.medium_container.medium<br/></ifdef>

								<ifdef code="ca_objects.dimensions_container.display_dimensions">^ca_objects.dimensions_container.display_dimensions<br/></ifdef>

								<ifdef code="ca_objects.edition_size">^ca_objects.edition_size</ifdef>
							</l>
							</dd>
						</unit>
					</dl>
						
				</ifdef>}}}
			</div>
		</div>
	</div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const navbar = document.getElementById("mainNavbar");
            const toggleBtn = document.getElementById("toggleNavBtn");

            // Retrieve state from localStorage
            const isNavbarVisible = localStorage.getItem("navbarVisible") !== "false"; 
            if (!isNavbarVisible) {
                navbar.classList.add("d-none");
                toggleBtn.textContent = "Show Header";
            }

            // Toggle navbar visibility
            toggleBtn.addEventListener("click", function () {
                const isHidden = navbar.classList.toggle("d-none");

                // Update localStorage
                localStorage.setItem("navbarVisible", !isHidden);

                // Update button text
                toggleBtn.textContent = isHidden ? "Show Header" : "Hide Header";
            });
        });
    </script>