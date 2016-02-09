<div class="col1">
	<H1><?php print _t("Actualidad"); ?></H1>
<?php
	$va_sets = array_reverse($this->getVar("sets"), true);
	$va_first_items_from_set = $this->getVar("first_items_from_sets");
	$t_display_set = new ca_sets();
	if(is_array($va_sets) && sizeof($va_sets)){
		foreach(array_keys($va_sets) as $vn_set_id){
			$va_featured_ids = array();
			$t_display_set->load($vn_set_id);
?>
			<div class="actualidadItem">
<?php
				if($vs_img = $t_display_set->get("set_description_image", array("version" => "medium"))){
					print '<figure class="alignLeft">'.$vs_img.'</figure>';
				}
?>
				<h3><?php print $t_display_set->getLabelForDisplay(); ?></h3>
				<?php print ($t_display_set->get("title")) ? "<h4>".$t_display_set->get("title")."</h4>" : ""; ?>
				<?php print ($t_display_set->get("set_description") ? "<p class='mini'>".$t_display_set->get("set_description")."</p>" : ""); ?>
<?php			
			$va_featured_ids = array_keys(is_array($va_tmp = $t_display_set->getItemRowIDs(array('checkAccess' => $va_access_values))) ? $va_tmp : array());
			if(is_array($va_featured_ids) && sizeof($va_featured_ids)){
				$q_set_items = caMakeSearchResult("ca_objects", $va_featured_ids);
				if($q_set_items->numHits()){
?>
					<div style="clear:both;"></div>
					<section>
						<div class="obras">
							<div class="jcarousel-wrapper">
							<div class="mascara jcarousel" id="setObjects<?php print $vn_set_id; ?>">
								<ul class="articulos">
<?php
						$vs_tooltip_tags = "";
						while($q_set_items->nextHit()){
							$va_see_also_output[] = $q_set_items->get("ca_objects.object_id");
							if($vs_img = $q_set_items->get('ca_object_representations.media.widepreview', array("checkAccess" => $va_access_values))){
								print "<li><div id='slideItem".$q_set_items->get("object_id")."_".$vn_set_id."' onMouseOver='showTooltip(\"".$q_set_items->get("object_id")."_".$vn_set_id."\"); return false;' onMouseOut='hideTooltip(\"".$q_set_items->get("object_id")."_".$vn_set_id."\"); return false;'>".caDetailLink($this->request, $vs_img, '', 'ca_objects', $q_set_items->get("object_id"), '', array("alt" => _t("Obras relacionadas")))."</div></li>";
								$vs_tooltip_tags .= "<div class='hiddenToolTip' id='tooltip".$q_set_items->get("object_id")."_".$vn_set_id."' onMouseOver='hideTooltip(\"".$q_set_items->get("object_id")."_".$vn_set_id."\"); return false;'>".$q_set_items->get('ca_object_representations.media.small', array("checkAccess" => $va_access_values))."</div>";
							}
						}
?>
								</ul>
							</div>
						</div></div>
						<a href="#" class="btnminLeft items" id="detailScrollButtonPrevious<?php print $vn_set_id; ?>">left</a> <a href="#" class="btnminRight items" id="detailScrollButtonNext<?php print $vn_set_id; ?>">right</a>
<?php
						print $vs_tooltip_tags;
?>
					</section>

				 <script type='text/javascript'>
					jQuery(document).ready(function() {
						/*
						Carousel initialization
						*/
						$('#setObjects<?php print $vn_set_id; ?>')
							.jcarousel({
								// Options go here
							});
				
						/*
						 Prev control initialization
						 */
						$('#detailScrollButtonPrevious<?php print $vn_set_id; ?>')
							.on('jcarouselcontrol:active', function() {
								$(this).removeClass('inactive');
							})
							.on('jcarouselcontrol:inactive', function() {
								$(this).addClass('inactive');
							})
							.jcarouselControl({
								// Options go here
								target: '-=4'
							});
				
						/*
						 Next control initialization
						 */
						$('#detailScrollButtonNext<?php print $vn_set_id; ?>')
							.on('jcarouselcontrol:active', function() {
								$(this).removeClass('inactive');
							})
							.on('jcarouselcontrol:inactive', function() {
								$(this).addClass('inactive');
							})
							.jcarouselControl({
								// Options go here
								target: '+=4'
							});
					
					});
					/*
					Tooltips
					*/							
					function showTooltip(id) {
						$('#tooltip' + id).css({top: ($('#slideItem' + id).offset().top - $(window).scrollTop() + 70), left: ($('#slideItem' + id).offset().left + 50), position:'fixed'});
						$('#tooltip' + id).show();
					}
												
					function hideTooltip(id) {
						$('#tooltip' + id).hide();
						/*$('#tooltip' + id).offset({top: 0, left: 0});*/
					}
				</script>
<?php
				}
			}
?>
				<div style="clear:both;"></div>
			</div>
<?php
		}
	}
?>
</div>