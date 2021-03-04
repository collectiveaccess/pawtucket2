<?php
/** ---------------------------------------------------------------------
 * themes/default/Transcribe/browse_html.php :
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2015 Whirl-i-Gig
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
 * @package CollectiveAccess
 * @subpackage theme/default
 * @license http://www.gnu.org/copyleft/gpl.html GNU Public License version 3
 *
 * ----------------------------------------------------------------------
 */
	$qr_result 						= $this->getVar("result");
	
	$va_access_values 				= caGetUserAccessValues($this->request);

	$va_criteria					= $this->getVar('criteria');

	$vs_current_sort				= $this->getVar('sort');
	$vs_current_secondary_sort		= $this->getVar('secondarySort');
	$vs_sort_dir					= $this->getVar('sortDirection');
	if(!$vs_sort_control_type) { $vs_sort_control_type = "dropdown"; }

	$vs_browse_key 					= $this->getVar('key');
	$hits_per_block 	            = (int)$this->getVar('hits_per_block');	// number of hits to display per block
	$vn_start		 	            = (int)$this->getVar('start');			// offset to seek to before outputting results
	$vb_ajax			            = (bool)$this->request->isAjax();

	$t_object 						= new ca_objects();		// ca_objects instance we need to pull representations

	$transcription_status = $this->getVar('transcriptionStatus');

	if (!$vb_ajax) {
?>

<div class="transcription container textContent">
	<div class="row">
		<div class="col-sm-10 col-sm-offset-1">
			<h1><a href="/Transcribe/Index">Transcribe</a> &gt; Browse</H1>
			<p>
				By transcribing a record, you are creating searchable data that can be used 
				by genealogists, researchers, students, teachers, and everyone else. You are 
				helping museums document their collections and share information in a meaningful way.
			</p>
			
			<?php print "<div class='unit'><span class='name'>".$qr_result->numHits()."</span> transcribable items</div>"; ?>
<?php
				if (sizeof($va_criteria) > 0) {
					print "<div class='bCriteria'>";
					foreach($va_criteria as $va_criterion) {
						print "<strong>".$va_criterion['facet'].':</strong> ';
						print caNavLink($this->request, '<button type="button" class="btn btn-default btn-sm">'.$va_criterion['value'].' <span class="glyphicon glyphicon-remove-circle"></span></button>', 'browseRemoveFacet', '*', '*', '*', array('removeCriterion' => $va_criterion['facet_name'], 'removeID' => $va_criterion['id'], 'key' => $vs_browse_key));
						print " ";
					}
					print caNavLink($this->request, '<button type="button" class="btn btn-default btn-sm">'._t("Start Over").'</span></button>', '', '*', '*', '*', array('key' => $vs_browse_key, 'clear' => 1));
					print "</div>";
				}
?>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-7 col-sm-offset-1">
			<div class="row" id="lbSetResultLoadContainer">
<?php
	}
				if($num_hits = $qr_result->numHits()){
					if ($vn_start < $qr_result->numHits()) {
						$qr_result->seek($vn_start);

						if($qr_result->numHits()){
							$vn_c = 0;


							while($qr_result->nextHit() && ($vn_c < $hits_per_block)) {
								$object_id = $qr_result->get('ca_objects.object_id');
								
								$status_info = caGetTranscriptionStatusInfo($transcription_status, 'items', $object_id);
?>
			<div class="col-sm-3 collectionTile">
				<div class="collectionImageCrop hovereffect">
					<?php print caNavLink($this->request, $qr_result->get('ca_object_representations.media.small'), '', '', 'Transcribe', "Item", ['id' => $object_id]); ?>
					<div class="overlay"><h2><?php print caNavLink($this->request, $qr_result->get('ca_objects.preferred_labels.name'), '', '', 'Transcribe', "Item", ['id' => $object_id]); ?></h2></div>
				</div>
				<?php print caNavLink($this->request, $status_info['status'], "btn btn-sm btn-{$status_info['color']}", '*', 'Transcribe', 'Item', ['id' => $object_id]); ?>
			</div>
<?php
								$vn_c++;
							}
						}

						if ($num_hits > $vn_start + $hits_per_block) {
							print caNavLink($this->request, _t('Next %1', $hits_per_block), 'jscroll-next', '*', '*', '*', array('s' => $vn_start + $hits_per_block, 'key' => $vs_browse_key));
						}
					}
				} else{
					print "<div class='row'><div class='col-sm-12'>"._t("There are no items available for transcription")."</div></div>";
				}
	
	if (!$vb_ajax) {
?>
			</div>
		</div>
		<div class="col-sm-3">
<?php
			print $this->render("Transcribe/browse_refine_subview_html.php");
?>
		</div>
	</div>
</div>

<script type="text/javascript">
    var pageLoadList = [];
    var dataLoading = false;
    jQuery(window).on("scroll", function(e) {
        var $e = jQuery("#lbSetResultLoadContainer");
        var _$scroll = jQuery(window),
            borderTopWidth = parseInt($e.css('borderTopWidth')),
            borderTopWidthInt = isNaN(borderTopWidth) ? 0 : borderTopWidth,
            iContainerTop = parseInt($e.css('paddingTop')) + borderTopWidthInt,
            iTopHeight = _$scroll.scrollTop(),
            innerTop = $e.length ? $e.offset().top : 0,
            iTotalHeight = Math.ceil(iTopHeight - innerTop + _$scroll.height() + iContainerTop);

        var docHeight = jQuery(document).height();
        docHeightOffset = docHeight/2;

        jQuery("#lbSetResultLoadContainer .jscroll-next").html("Loading...");
        if ((jQuery(window).scrollTop() + $(window).height() >= docHeightOffset) && !dataLoading) {
            var href = jQuery("#lbSetResultLoadContainer .jscroll-next").attr('href');

            if (href && (pageLoadList.indexOf(href) == -1)) {
                dataLoading = true;
                jQuery("#lbSetResultLoadContainer .jscroll-next").remove();
                jQuery("#lbSetResultLoadContainer").append('<div id="resultLoadTmp" />');

                jQuery("#lbSetResultLoadContainer #resultLoadTmp").load(href, function(e) {
                    pageLoadList.push(href);

                    jQuery("#resultLoadTmp").children().appendTo("#lbSetResultLoadContainer");
                    jQuery("#resultLoadTmp .jscroll-next").appendTo("#lbSetResultLoadContainer");
                    jQuery("#resultLoadTmp").remove();

                    jQuery(".sortable").sortable('refresh').sortable('refreshPositions');
                    dataLoading = false;
                });
            }
        }
    });
</script>
<?php
	}