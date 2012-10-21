<?php
/* ----------------------------------------------------------------------
 * app/plugins/Chronology/themes/metabolic/views/chronology_html.php
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2012 Whirl-i-Gig
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
 
	$va_silos = $this->getVar('silos');
	$vs_thumbnail = "<img src='".__CA_URL_ROOT__."/app/plugins/Chronology/themes/metabolic/graphics/imagePlaceholder.jpg' border='0'>";
?>
<div id="chronology">
<?php
	foreach($va_silos as $vn_silo_id => $va_silo) {
		if($va_silo[num_actions]){
			if(strtolower($va_silo['name']) == 'historical context'){
				$vn_historical_context_silo_id = $vn_silo_id;
				# --- output historical context timeline
?>
				<div class="historicalContextPlaceHolder" id="historicalContextPlaceHolder">
					<div class="siloTitle"><a href="#" onClick="jQuery('#historicalContextPlaceHolder').hide(); jQuery('.historicalContextContainer').slideDown(); return false;"><?php print _t("historical context"); ?></div><!-- end siloTitle -->
				</div><!-- end historicalContextPlaceHolder -->
				<div class="historicalContextContainer">
					<div class="hcInfo">
						<div class="hcTitle"><?php print _t('historical context'); ?></div><!-- end hcTitle -->
						<div class="hide"><a href="#" onClick="jQuery('.historicalContextContainer').slideUp(400, function() {jQuery('#historicalContextPlaceHolder').show();}); return false;">Hide ></a></div><!-- end hide -->
					</div><!-- end hcInfo -->
					<div class="timelineContainer"><ul id="silo<?php print $vn_silo_id; ?>" class="jcarousel-skin-chronology">
<?php
					foreach($va_silo['actions'] as $vn_action_id => $va_action) {
						$vs_entities = "";
						if($va_action['entities']){
							$vs_entities = "<div class='actionRelatedInfo'><span class='actionHeading'>"._t("People").":</span> ".$va_action['entities']."</div>";
						}
						
						print "<li><div class='action'><div class='actionDate'>".$va_action['date']."</div><div class='actionTitle'>".$va_action['label']."</div>".$vs_entities."</div></li>\n"; // format used on load only
					}
?>
					</ul></div><!-- end timelineContainer -->				
				</div><!-- end historicalContext -->
	
<?php
			}else{
?>
				<div class="siloPlaceHolder" id="siloPlaceHolder<?php print $vn_silo_id; ?>">
					<div class="siloTitle"><a href="#" onClick="jQuery('#siloPlaceHolder<?php print $vn_silo_id; ?>').hide(); jQuery('#siloContainer<?php print $vn_silo_id; ?>').slideDown(); return false;"><?php print $va_silo['name']; ?></a> - <?php print _t("%1 Action%2", $va_silo["num_actions"], (sizeof($va_silo)) ? "s" : ""); ?></div><!-- end siloTitle -->
				</div><!-- end siloPlaceHolder -->
				<div class="siloContainer" id="siloContainer<?php print $vn_silo_id; ?>">
					<div class="siloInfo">
						<div class="siloTitle"><?php print $va_silo['name']; ?></div><!-- end siloTitle -->
						<div style="font-weight:bold;"><?php print _t("%1 Action%2", $va_silo["num_actions"], ($va_silo["num_actions"]) ? "s" : ""); ?></div>
						<div class="hide"><a href="#" onClick="jQuery('#siloMoreInfo<?php print $vn_silo_id; ?>').slideUp(400); jQuery('#siloContainer<?php print $vn_silo_id; ?>').slideUp(400, function() {jQuery('#siloPlaceHolder<?php print $vn_silo_id; ?>').show();}); return false;">Hide ></a></div><!-- end hide -->
					</div><!-- end siloInfo -->
					<div class="timelineContainer"><ul id="silo<?php print $vn_silo_id; ?>" class="jcarousel-skin-chronology">
<?php
					$t_object = new ca_objects();
					foreach($va_silo['actions'] as $vn_action_id => $va_action) {
						$vs_entities = "";
						if($va_action['entities_array']){
							$vs_entities = "<div class='actionRelatedInfo'><span class='actionHeading'>"._t("People").":</span> ".implode(", ", array_slice($va_action['entities_array'], 0, 3)).((sizeof($va_action['entities_array']) > 3) ? " (".(sizeof($va_action['entities_array']) - 3)." more)" : "")."</div>";
						}
						$vs_more = "";
						$vs_clipped_label = "";
						if(strlen($va_action['label']) > 100){
							$vs_clipped_label = mb_substr($va_action['label'], 0, 80, 'utf-8')."...";
							$vs_more = "&nbsp;&nbsp;&nbsp;<a href='#' onMouseOver=\"jQuery('#actionTitleExtended".$vn_action_id."').css('display', 'inline');\">More ></a>";
						}else{
							$vs_clipped_label = $va_action['label'];
						}
						$vs_image_placeholder = "<div class='actionImage'>".$vs_thumbnail."</div>";
						$vs_image = "";
						if($va_action['objectMedia']){
							$vs_image = "<div class='actionImage'>".$va_action['objectMedia']."</div>";
						}else{
							$vs_image = $vs_image_placeholder;
						}
						
						
						print "<li><div class='action' id='actionContainer".$vn_action_id."'><div class='actionDate'>".$va_action['date']."</div><div class='actionTitleExtended' id='actionTitleExtended".$vn_action_id."' onMouseOut=\"jQuery('#actionTitleExtended".$vn_action_id."').css('display', 'none');\">".$va_action['label']."</div><div class='actionTitle'>".$vs_clipped_label.$vs_more."</div>".$vs_image.$vs_entities."<div class='actionMoreInfo'><a href='#' onclick='jQuery(\"#siloMoreInfo".$vn_silo_id."\").load(\"".caNavUrl($this->request, 'Chronology', 'Show', 'getAction', array('action_id' => $vn_action_id, 'silo_id' => $vn_silo_id, 'dontInitiateScroll' => 1))."\", function() { jQuery(\"#siloMoreInfo".$vn_silo_id."\").slideDown(400, function(){ scrollWindow(".$vn_silo_id."); }); }); $(\"#silo".$vn_silo_id."\").find(\".actionHighlighted\").removeClass(\"actionHighlighted\").addClass(\"action\"); jQuery(\"#actionContainer".$vn_action_id."\").removeClass(\"action\").addClass(\"actionHighlighted\"); return false;'>"._t("More Info >")."</a></div></div></li>\n"; // format used on load only
					}
?>
					</ul>
					<div class="sliderSynchContainer">
						<div class='synchButton'><a href='#' id='sync<?php print $vn_silo_id; ?>'><img src='<?php print __CA_URL_ROOT__; ?>/app/plugins/Chronology/themes/metabolic/graphics/clock.png' border='0' title='synch timelines'></a></div>
						<div class="sliderContainer">
							<div class="slider" id="slider<?php print $vn_silo_id; ?>" style="position: relative;">
								<div id="sliderPosInfo<?php print $vn_silo_id; ?>" class="sliderInfo"></div>
							</div><!-- end slider -->
						</div><!-- end sliderContainer -->
					</div><!-- end sliderSynchContainer -->
				</div><!-- end timelineContainer -->
				</div><!-- end siloContainer -->
				<div class='siloMoreInfoContainer' id='siloMoreInfo<?php print $vn_silo_id; ?>'></div><!-- end siloMoreInfoContainer -->
<?php
			}
?>	
			<script type="text/javascript">
				jQuery(document).ready(function() {
					var stateCookieJar = jQuery.cookieJar('caChronoCookieJar');
					if(stateCookieJar.get("caChronoTimeline<?php print $vn_silo_id; ?>")){
						var initIndex = stateCookieJar.get("caChronoTimeline<?php print $vn_silo_id; ?>");
					} else {
						var initIndex = 1;
					}
					jQuery('#silo<?php print $vn_silo_id; ?>').jcarousel({size: <?php print (int)$va_silo['num_actions'] - 1; ?>,  itemLoadCallback: loadActions, start: initIndex});
					jQuery('#silo<?php print $vn_silo_id; ?>').data('actionmap', <?php print json_encode($va_silo['actionmap']); ?>);
					var slider_silo_id = <?php print $vn_silo_id; ?>; 
					var actionmap = jQuery('#silo' + slider_silo_id).data('actionmap');
					if (actionmap && actionmap[0] && actionmap[0]['date']) {
						jQuery('#sliderPosInfo' + slider_silo_id).html(actionmap[0]['date']);
					}
					jQuery('#slider<?php print $vn_silo_id; ?>').slider({min:1, max:<?php print ($va_silo["num_actions"] - 5); ?>, animate: 'fast', 
						start: function(event, ui) {
							jQuery('#sliderPosInfo' + slider_silo_id).css('display', 'block');
						},
						slide: function(event, ui) {
							var actionmap = jQuery('#silo' + slider_silo_id).data('actionmap');
							setTimeout(function() {
								jQuery('#sliderPosInfo' + slider_silo_id).css('left', jQuery(ui.handle).position().left + 15 + "px").html(actionmap[ui.value]['date']);
							}, 10);
						},
						stop: function(event, ui) { 
							jQuery('#sliderPosInfo' + slider_silo_id).css('display', 'none');
							jQuery('#silo' + slider_silo_id).data('jcarousel').scroll(ui.value, jQuery('#silo' + slider_silo_id).data('jcarousel').has(ui.value));
						}
					});
					
					// Update slider with current position
					jQuery('#slider<?php print $vn_silo_id; ?>').slider("value", initIndex);
					
					jQuery('#sync<?php print $vn_silo_id; ?>').click( 
						function(e) { 
							var silo_id = jQuery(this).attr('id').replace(/^sync/, "");
							var actionmap = jQuery('#silo' + silo_id).data('actionmap');
							var carousel = jQuery('#silo' + silo_id).data('jcarousel');
							var i = carousel.last - 2;
							sync(silo_id, actionmap[i]['timestamp']);
							
							return false;
						}
					);
				});
			</script>
<?php		
		}
	}
?>
</div><!-- end chronology -->

	<script type="text/javascript">
		function loadActions(carousel, state) {
			var silo_id = jQuery(carousel.list).attr('id').replace(/^silo/, "");
			var stateCookieJar = jQuery.cookieJar('caChronoCookieJar');
			stateCookieJar.get("caChronoTimeline" + silo_id)
			// set carousel index in cookieJar
			stateCookieJar.set("caChronoTimeline" + silo_id, carousel.first);
			for (var i = carousel.first; i <= (carousel.last + 6); i++) {
				// Check if the item already exists
				if (!carousel.has(i)) {
					jQuery.getJSON('<?php print caNavUrl($this->request, $this->request->getModulePath(), $this->request->getController(), 'getActions'); ?>', {silo_id: silo_id, s: i, n: 10, context: (silo_id == <?php print (int)$vn_historical_context_silo_id; ?>) ? 1 : 0}, function(actions) {
						jQuery.each(actions, function(k, v) {
							var entities = "";
							var numMoreEntities = "";
							var clippedEntities = "";
							var clippedEntitiesText = "";
							
							var vals = [];
							for(var kk in v['entities_array']) {
								vals.push(v['entities_array'][kk]);
							}
							
							if(vals.length > 1){
								if(vals.length > 3){
									numMoreEntities = vals.length - 3;
									clippedEntities = vals.slice(0, 3);
									clippedEntitiesText = clippedEntities.join(", ");
									var entities = "<div class='actionRelatedInfo'><span class='actionHeading'><?php print _t("People"); ?>:</span> " + clippedEntitiesText + " (" + numMoreEntities + " more)</div>";
								}else{
									var entities = "<div class='actionRelatedInfo'><span class='actionHeading'><?php print _t("People"); ?>:</span> " + vals.join(", ") + "</div>";
								}
							}
							//if(v['entities']){
							//	var entities = "<div class='actionRelatedInfo'><span class='actionHeading'><?php print _t("People"); ?>:</span> " + v['entities'] + "</div>";
							//}
							
							// clip label text if too long and this is not the historical context silo
							var more = "";
							var clipped_label = v['label'];
							var titleExtended = "";
							if(silo_id != <?php print (int)$vn_historical_context_silo_id; ?>){
								if(clipped_label.length > 100){
									clipped_label = clipped_label.substr(0, 80) + "...";
									more = "&nbsp;&nbsp;&nbsp;<a href='#' onMouseOver=\"jQuery('#actionTitleExtended" + k + "').css('display', 'inline');\">More ></a>";
									titleExtended = "<div class='actionTitleExtended' id='actionTitleExtended" + k + "' onMouseOut='jQuery(\"#actionTitleExtended" + k + "\").css(\"display\", \"none\");'>" + v['label'] + "</div>";
								}
							}
							var image = "";
							if(v['objectMedia']){
								var image = "<div class='actionImage'>" + v['objectMedia'] + "</div>";
							}else{
								var image = "<div class='actionImage'><?php print $vs_thumbnail; ?></div>";
							}
							
							carousel.add(i, "<li><div id='actionContainer" + k + "' class='action'><div class='actionDate'>" + v['date'] + "</div>" + titleExtended + "<div class='actionTitle'>" + clipped_label + more + "</div>" + image + entities + "<div class='actionMoreInfo'><a href='#' onclick='jQuery(\"#siloMoreInfo" + v['silo_id'] + "\").load(\"<?php print caNavUrl($this->request, 'Chronology', 'Show', 'getAction'); ?>/dontInitiateScroll/1/silo_id/" + v['silo_id'] + "/action_id/" + k + "\", function() { jQuery(\"#siloMoreInfo" + v['silo_id'] + "\").slideDown(400, function(){ scrollWindow(" + v['silo_id'] + ");}); }); $(\"#silo" + v['silo_id'] + "\").find(\".actionHighlighted\").removeClass(\"actionHighlighted\").addClass(\"action\"); jQuery(\"#actionContainer" + k + "\").removeClass(\"action\").addClass(\"actionHighlighted\"); return false;'><?php print _t("More Info >"); ?></a></div></div></li>");	// format used when dynamically loading
							
							
							// Set current highlight
							if (carousel.jcarousel_selected_action_id) {
								console.log("set highlight to " + carousel.jcarousel_selected_action_id + " for silo " + silo_id);
								jQuery("#silo" + silo_id).find(".actionHighlighted").removeClass("actionHighlighted").addClass("action"); jQuery("#actionContainer" + carousel.jcarousel_selected_action_id).removeClass("action").addClass("actionHighlighted");
							}
							i++;
						});
					});
					
					break;
				}
				// Set current highlight
				if (carousel.jcarousel_selected_action_id) {
					console.log("set highlight to " + carousel.jcarousel_selected_action_id + " for silo " + silo_id);
					jQuery("#silo" + silo_id).find(".actionHighlighted").removeClass("actionHighlighted").addClass("action"); jQuery("#actionContainer" + carousel.jcarousel_selected_action_id).removeClass("action").addClass("actionHighlighted");
				}
			}
			
			if ((silo_id != <?php print (int)$vn_historical_context_silo_id; ?>)) {				
				var actionmap = jQuery('#silo' + silo_id).data('actionmap');
				if (actionmap && actionmap[carousel.first + 1]) { 
					var silotime = actionmap[carousel.first + 1]['timestamp'];
					
					if (silotime && (state != 'init')) {
						// Sync historical context
						syncHistoricalContext(silotime);
					}
				}
			}
			
			// Update slider with current position
			jQuery('#slider' + silo_id).slider("value", carousel.first);
			
		}
		
		function sync(silo_id, timestamp) {
			jQuery('.siloContainer').each(function(k, v) {
				var cur_silo_id = jQuery(v).attr('id').replace(/^siloContainer/, "");
				if (cur_silo_id == silo_id) { return 1; }
				var actionmap = jQuery('#silo' + cur_silo_id).data('actionmap');
				
				jQuery(actionmap).each(function(i, info) {
					var silotime = info['timestamp'];
					if (silotime >= timestamp) {
						// scroll to this one
						//console.log("scroll silo " + cur_silo_id + " to " + i + "/" + silotime + "/" + info['date']);
						var carousel = jQuery('#silo' + cur_silo_id).data('jcarousel');
						carousel.scroll(i-2, true);
						return false;
					}
				});
			});
		}
		
		function syncHistoricalContext(timestamp) {
			var actionmap = jQuery('#silo<?php print (int)$vn_historical_context_silo_id; ?>').data('actionmap');
			var i;
			jQuery(actionmap).each(function(i, info) {
				var silotime = info['timestamp'];
				if (parseFloat(silotime) >= parseFloat(timestamp)) {
					// scroll to this one
					var carousel = jQuery('#silo<?php print (int)$vn_historical_context_silo_id; ?>').data('jcarousel');
					carousel.scroll(i-2, true);
					return false;
				}
			});
		}
		
		jQuery("body").delegate(".historicalContextContainer .action", "mouseenter", function () {
			var offset = jQuery(this).parent().offset();
			jQuery(this).css('left', offset.left);
		}).delegate(".historicalContextContainer .action", "mouseleave", function () {
			jQuery(this).css('left', 0);
		});
		  
		function scrollWindow(silo_id) {
			var offset = jQuery('#siloContainer' + silo_id).offset();
			window.scrollTo(offset.left, offset.top);
			jQuery('.scrollPane').jScrollPane({animateScroll: true,});
		}
		
		// Transaction action_id into index in jcarousel
		function getIndexForActionID(silo_id, action_id) {
			var actionmap = jQuery('#silo' + silo_id).data('actionmap');
			
			for(var i=0; i < actionmap.length; i++) {
				if (actionmap[i]['id'] == action_id) { 
					return i;
				}
			}
			
			return undefined;
		}
	</script>