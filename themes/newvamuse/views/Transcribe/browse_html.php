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

	$va_views						= $this->getVar('views');
	$vs_current_view				= $this->getVar('view');
	$va_criteria					= $this->getVar('criteria');

	$vs_current_sort				= $this->getVar('sort');
	$vs_current_secondary_sort		= $this->getVar('secondarySort');
	$vs_sort_dir					= $this->getVar('sortDirection');
	if(!$vs_sort_control_type) { $vs_sort_control_type = "dropdown"; }

	$va_lightboxDisplayName 		= caGetLightboxDisplayName();
	$vs_lightbox_displayname 		= $va_lightboxDisplayName["singular"];
	$vs_lightbox_displayname_plural = $va_lightboxDisplayName["plural"];
	$vs_browse_key 					= $this->getVar('key');
	$vn_hits_per_block 	            = (int)$this->getVar('hits_per_block');	// number of hits to display per block
	$vn_start		 	            = (int)$this->getVar('start');			// offset to seek to before outputting results
	$vb_ajax			            = (bool)$this->request->isAjax();

	$t_object 						= new ca_objects();		// ca_objects instance we need to pull representations

	$qr_comments 					= $this->getVar("comments");
	$vn_num_comments 				= $qr_comments ? $qr_comments->numHits() : 0;
	$vs_description_attribute 		= $this->getVar("description_attribute");

if (!$vb_ajax) {	// !ajax
?>
	<div class="row">
		<div class="col-sm-9 col-md-9 col-lg-8">
<?php
			if($vs_sort_control_type == 'list'){
				if(is_array($va_sorts = $this->getVar('sortBy')) && (sizeof($va_sorts) > 1)) {
					print "<div id='bSortByList'><ul><li><strong>"._t("Sort by:")."</strong></li>\n";
					$i = 0;
					foreach($va_sorts as $vs_sort => $vs_sort_flds) {
						$i++;
						if ($vs_current_sort === $vs_sort) {
							print "<li class='selectedSort'>{$vs_sort}</li>\n";
						} else {
							print "<li>".caNavLink($this->request, $vs_sort, '', '*', '*', '*', array('view' => $vs_current_view, 'key' => $vs_browse_key, 'sort' => $vs_sort))."</li>\n";
						}
						if($i < sizeof($va_sorts)){
							print "<li class='divide'>&nbsp;</li>";
						}
					}
					print "<li>".caNavLink($this->request, '<span class="glyphicon glyphicon-sort-by-attributes'.(($vs_sort_dir == 'asc') ? '' : '-alt').'" aria-label="direction"></span>', '', '*', '*', '*', array('view' => $vs_current_view, 'key' => $vs_browse_key, 'direction' => (($vs_sort_dir == 'asc') ? _t("desc") : _t("asc"))))."</li>";
					print "</ul></div>\n";
				}
			}
?>
			<div class="setsBack"><?php print caNavLink($this->request, "<i class='fa fa-angle-double-left' aria-label='back'></i><div class='small'>Back</div>", "", "", "Transcribe", "Collections"); ?></div><!-- end setsBack -->
			<H1>
				<?php 
					//print "<span id='lbSetName".$t_set->get("set_id")."'>".$t_set->getLabelForDisplay()."</span>"; 
				?>
				<?php print "<span class='lbSetCount'>(<span class='lbSetCountInt'>".$qr_result->numHits()."</span> items)</span>"; ?>
<?php
    //
    // Gear menu
    //
?>
				<div class="btn-group">
					<span class="glyphicon glyphicon-cog bGear" data-toggle="dropdown"></span>
					<ul class="dropdown-menu" role="menu">
<?php
						if(($vs_sort_control_type == "dropdown") && is_array($va_sorts = $this->getVar('sortBy')) && (sizeof($va_sorts) > 1)) {
							print "<li class='dropdown-header'>"._t("Sort by:")."</li>\n";
							foreach($va_sorts as $vs_sort => $vs_sort_flds) {
								if ($vs_current_sort === $vs_sort) {
									print "<li><a href='#'><strong><em>{$vs_sort}</em></strong></a></li>\n";
								} else {
									print "<li>".caNavLink($this->request, $vs_sort, '', '*', '*', '*', array('view' => $vs_current_view, 'key' => $vs_browse_key, 'sort' => $vs_sort))."</li>\n";
								}
							}
							print "<li class='divider'></li>\n";
							if(is_array($va_secondary_sorts = $this->getVar('secondarySortBy')) && sizeof($va_secondary_sorts)){
								print "<li class='dropdown-header'>"._t("Refine sort by:")."</li>\n";
								foreach($va_secondary_sorts as $vs_secondary_sort => $vs_secondary_sort_flds) {
									if($vs_secondary_sort != $vs_current_sort){
										if ($vs_current_secondary_sort === $vs_secondary_sort) {
											print "<li><a href='#'><strong><em>{$vs_secondary_sort}</em></strong></a></li>\n";
										} else {
											print "<li>".caNavLink($this->request, $vs_secondary_sort, '', '*', '*', '*', array('view' => $vs_current_view, 'key' => $vs_browse_key, 'secondary_sort' => $vs_secondary_sort))."</li>\n";
										}
									}
								}
								print "<li class='divider'></li>\n";
							}
							print "<li class='dropdown-header'>"._t("Sort order:")."</li>\n";
							print "<li>".caNavLink($this->request, (($vs_sort_dir == 'asc') ? '<strong><em>' : '')._t("Ascending").(($vs_sort_dir == 'asc') ? '</em></strong>' : ''), '', '*', '*', '*', array('view' => $vs_current_view, 'key' => $vs_browse_key, 'direction' => 'asc'))."</li>";
							print "<li>".caNavLink($this->request, (($vs_sort_dir == 'desc') ? '<strong><em>' : '')._t("Descending").(($vs_sort_dir == 'desc') ? '</em></strong>' : ''), '', '*', '*', '*', array('view' => $vs_current_view, 'key' => $vs_browse_key, 'direction' => 'desc'))."</li>";
							print "<li class='divider'></li>";
						}
?>
						<li><?php print caNavLink($this->request, _t("All %1", $vs_lightbox_displayname_plural), "", "", "Lightbox", "Index"); ?></li>

					</ul>
				</div><!-- end btn-group -->
			</H1>
<?php
				if (sizeof($va_criteria) > 1) {
					print "<div class='bCriteria'>";
					foreach($va_criteria as $va_criterion) {
						if ($va_criterion['facet_name'] != '_search') {
							print "<strong>".$va_criterion['facet'].':</strong> ';
							print caNavLink($this->request, '<button type="button" class="btn btn-default btn-sm">'.$va_criterion['value'].' <span class="glyphicon glyphicon-remove-circle"></span></button>', 'browseRemoveFacet', '*', '*', '*', array('removeCriterion' => $va_criterion['facet_name'], 'removeID' => $va_criterion['id'], 'view' => $vs_current_view, 'key' => $vs_browse_key));
							print " ";
						}
					}
					print caNavLink($this->request, '<button type="button" class="btn btn-default btn-sm">'._t("Start Over").'</span></button>', '', '*', '*', '*', array('view' => $vs_current_view, 'key' => $vs_browse_key, 'clear' => 1));
					print "</div>";
				}
?>
		</div><!-- end col -->
		<div class="col-sm-3 col-md-3 col-lg-3 col-lg-offset-1">
			<div id="lbViewButtons">
<?php
			if(is_array($va_views) && (sizeof($va_views) > 1)){
				foreach($va_views as $vs_view => $va_view_info) {
					if(isset($va_view_info['data'])) {
						if (!$qr_result->hasData($va_view_info['data'])) { continue; }	// don't show view options for which there is no data (eg. map requires mappable data)
					}
					if ($vs_current_view === $vs_view) {
						//print '<a href="#" class="active"><span class="glyphicon '.$va_view_info['icon'].'" aria-label="'.$vs_view.'"></span></a> ';
					} else {
						//print caNavLink($this->request, '<span class="glyphicon '.$va_view_info['icon'].'" aria-label="'.$vs_view.'"></span>', 'disabled', '*', '*', '*', array('view' => $vs_view, 'set_id' => $t_set->get("set_id"), 'key' => $vs_browse_key)).' ';
					}
				}
			}
?>
			</div>
		</div><!-- end col -->
	</div><!-- end row -->
	<div class="row">
		<div class="col-sm-9 col-md-9 col-lg-8">
			<div id="lbSetResultLoadContainer">
<?php
} // !ajax

		$va_view_info = $va_views[$vs_current_view];
		switch($vs_current_view) {
			default:
				// First load is rendered in-template; subsequent loads are via Ajax/continuous scroll
				$t =new Timer();
				if($vn_num_hits = $qr_result->numHits()){
					if ($vn_start < $qr_result->numHits()) {
						$qr_result->seek($vn_start);

						if($qr_result->numHits()){
							$vn_c = 0;

							$va_object_ids = [];
							while($qr_result->nextHit() && ($vn_c < $vn_hits_per_block)) {
								$vn_object_id = $qr_result->get('ca_objects.object_id');
								switch($vs_current_view) {
									case 'list':
										print "<div class='col-xs-12 col-sm-4 lbItem{$vn_item_id}' id='row-{$vn_object_id}'><div class='lbItemContainer'>";
										break;
									default:
										print "<div class='col-xs-6 col-sm-4 col-md-3 col-lg-3 lbItem{$vn_item_id}' id='row-{$vn_object_id}'><div class='lbItemContainer'>";
										break;
								}
								
								$this->setVar('representation', $qr_result->get('ca_object_representations.media.small'));
								$this->setVar('caption', $qr_result->get('ca_objects.preferred_labels.name'));
								$this->setVar('object_id', $qr_result->get('ca_objects.object_id'));
								print $this->render("Transcribe/browse_item_html.php");
								print "</div></div><!-- end col 3 -->";
								$vn_c++;
							}
						}

						if ($vn_num_hits > $vn_start + $vn_hits_per_block) {
							print caNavLink($this->request, _t('Next %1', $vn_hits_per_block), 'jscroll-next', '*', '*', '*', array('s' => $vn_start + $vn_hits_per_block, 'key' => $vs_browse_key, 'view' => $vs_current_view));
						}
					}
				}else{
					print "<div class='row'><div class='col-sm-12'>"._t("There are no items available for transcription")."</div></div>";
				}
				break;
			}
if (!$vb_ajax) {    // !ajax
?>
            </div>
            <!-- end lbSetResultLoadContainer -->
        </div>
        <!-- end col -->
        <div
            class="col-sm-3 col-md-3 col-lg-3 col-lg-offset-1">
<?php
			print $this->render("Browse/browse_refine_subview_html.php");
?>
		</div><!-- end col -->
	</div><!-- end row -->
<script type="text/javascript">
<?php
	if (in_array($vs_current_view, array('list', 'thumbnail'))) {
?>
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
<?php
	}
?>
</script>
<?php
} //!ajax