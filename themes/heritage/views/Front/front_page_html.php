<?php
/** ---------------------------------------------------------------------
 * themes/default/Front/front_page_html : Front page of site 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013 Whirl-i-Gig
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
 * @subpackage Core
 * @license http://www.gnu.org/copyleft/gpl.html GNU Public License version 3
 *
 * ----------------------------------------------------------------------
 */
	$t_lists = new ca_lists();
	$vn_world_event_id = $t_lists->getItemID("subjects", "World event");
	
	$pn_filter_id = $this->request->getParameter("filter_id", pInteger);
	# --- subjects to use for color coding timeline events on home page
	$vn_company_id = $t_lists->getItemID("subjects", "Company");
	$vn_leadership_id = $t_lists->getItemID("subjects", "Leadership");
	$vn_products_id = $t_lists->getItemID("subjects", "Products");
	$vn_communities_id = $t_lists->getItemID("subjects", "Communities");
	$vn_sustainability_id = $t_lists->getItemID("subjects", "Sustainability");
	$vn_industry_id = $t_lists->getItemID("subjects", "Industry");
	
	
	$va_access_values = caGetUserAccessValues($this->request);
	# --- browse for all events with category: 
	$o_browse = caGetBrowseInstance("ca_occurrences");
	$o_browse->addCriteria("term_category_facet", 741);
	if($pn_filter_id){
		$o_browse->addCriteria("term_category_facet", $pn_filter_id);
	}
	$o_browse->execute(array('checkAccess' => $va_access_values));
	
	$qr_res = $o_browse->getResults(array("sort" => "ca_occurrences.timeline_date", "sort_direction" => "asc"));
	$va_events_by_decade = array();
	$va_world_events_by_decade = array();
	if($qr_res->numHits()){
		while($qr_res->nextHit()){
			$vs_start_year = $vs_decade = "";
			$va_categories = $qr_res->get("ca_list_items.item_id", array("returnAsArray" => true));
			$va_date_raw = $qr_res->get("ca_occurrences.timeline_date", array("returnWithStructure" => true, "rawDate" => true));
			if(is_array($va_date_raw) && sizeof($va_date_raw)){
				$va_date_raw = array_shift($va_date_raw[$qr_res->get("ca_occurrences.occurrence_id")]);
				$vs_start_year = abs(floor($va_date_raw["timeline_date"]["start"]));
				$vs_decade = floor($vs_start_year / 10) * 10;
				# --- what is the category for color coding
				$vs_category_code = $vn_category_id = "";
				if(in_array($vn_company_id, $va_categories)){
					$vs_category_code = "company";
					$vn_category_id = $vn_company_id;
				}elseif(in_array($vn_leadership_id, $va_categories)){
					$vs_category_code = "leadership";
					$vn_category_id = $vn_leadership_id;
				}elseif(in_array($vn_products_id, $va_categories)){
					$vs_category_code = "products";
					$vn_category_id = $vn_products_id;
				}elseif(in_array($vn_communities_id, $va_categories)){
					$vs_category_code = "communities";
					$vn_category_id = $vn_communities_id;
				}elseif(in_array($vn_sustainability_id, $va_categories)){
					$vs_category_code = "sustainability";
					$vn_category_id = $vn_sustainability_id;
				}elseif(in_array($vn_industry_id, $va_categories)){
					$vs_category_code = "industry";
					$vn_category_id = $vn_industry_id;
				}
				# --- check if this is a world event
				if(in_array($vn_world_event_id, $va_categories)){
					$va_world_events_by_decade[$vs_decade][$qr_res->get("ca_occurrences.occurrence_id")] = array("id" => $qr_res->get("ca_occurrences.occurrence_id"), "date" => $qr_res->get("ca_occurrences.timeline_date"), "title" => $qr_res->get("ca_occurrences.preferred_labels"), "public_description" => $qr_res->get("public_description"), "category_code" => $vs_category_code);
				}else{
					$t_occ = new ca_occurrences($qr_res->get("ca_occurrences.occurrence_id"));
					$va_reps = $t_occ->getPrimaryRepresentation(array("iconlarge", "medium"), null, array("checkAccess" => $va_access_values));
					$va_events_by_decade[$vs_decade][$vs_start_year][$qr_res->get("ca_occurrences.occurrence_id")] = array("id" => $qr_res->get("ca_occurrences.occurrence_id"), "date" => $qr_res->get("ca_occurrences.timeline_date"), "title" => $qr_res->get("ca_occurrences.preferred_labels"), "public_description" => $qr_res->get("public_description"), "category_code" => $vs_category_code, "category_id" => $vn_category_id, "iconlarge" => $va_reps["tags"]["iconlarge"], "medium" => $va_reps["tags"]["medium"]);
				}
			}
		}
	}
	//print "<pre>";
	//print_r($va_events_by_decade);
	//print "</pre>";
?>
<!--	<div class="row frontIntro">
		<div class="col-sm-5">
			<?php print caGetThemeGraphic($this->request, 'hpTruck2.jpg'); ?>
			<div>
				<h1>Our Story</h1>
				<p>Our story began with a simple innovation, a fireproof metal wastebasket for offices.</p>

				<p>Looking back, it's clear our company has always been about looking forward. Our past, present and future are all about turning insights into innovations that unlock the promise of people at work and make the world a better place.</p>

				<p>So now step back in time. Discover the many turning points in our history that together reveal the bigger picture of who we are and where we're headed. Our story, our future, is just beginning.</p>

			</div>
		</div>
		<div class="col-sm-7">
			<?php print caGetThemeGraphic($this->request, 'hpOffice.jpg'); ?>
		</div>
	</div>-->
	<div class="row frontIntro">
		<div class="col-sm-12">
			<?php print caGetThemeGraphic($this->request, 'hpTruck.jpg'); ?>
			<div class="frontIntroOverlay">
				<h2>Our Story</h2>
				<p>Our story began with a simple innovation, a fireproof metal wastebasket for offices.</p>

				<p>Looking back, it's clear our company has always been about looking forward. Our past, present and future are all about turning insights into innovations that unlock the promise of people at work and make the world a better place.</p>

				<p>So now step back in time. Discover the many turning points in our history that together reveal the bigger picture of who we are and where we're headed. Our story, our future, is just beginning.</p>

			</div>
		</div>
	</div>
	<div class="row frontSocial">
		<div class="col-sm-12 text-right">
			  <div id="fb-root"></div>
				<script>(function(d, s, id) {
				  var js, fjs = d.getElementsByTagName(s)[0];
				  if (d.getElementById(id)) return;
				  js = d.createElement(s); js.id = id;
				  js.src = 'https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.10';
				  fjs.parentNode.insertBefore(js, fjs);
				}(document, 'script', 'facebook-jssdk'));</script>

			 <div class="pull-right">
			 	&nbsp;&nbsp;<a href="https://twitter.com/share?ref_src=twsrc%5Etfw" class="twitter-share-button" data-show-count="false">Tweet</a><script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>
			 </div>
			 <div class="pull-right">
				  <div class="fb-share-button" 
					data-href="<?php print $this->request->config->get("site_host"); ?>" 
					data-layout="button">
				  </div>			 
			 </div>
			<a name="timeline"></a>
		</div>
	</div>
	
	<div class="row">
		<div class="col-sm-9">
			<a name="timeline"></a><h1>Explore the Timeline</h1>
		</div>
		<div class="col-sm-3 text-right">
			<br/><br/><?php print caNavLink($this->request, ($this->request->isLoggedIn()) ? _t("Browse the full Timeline") : _t("Login to browse the full Timeline"), "btn-default", "", "Browse", "occurrences"); ?>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12 frontFilter">
			Filter by: 
<?php 
			print "<a href='".caNavUrl($this->request, "", "Front", "Index")."#timeline' ".((!$pn_filter_id) ? "class='currentFilter'" : "").">All</a>";
			print "<a href='".caNavUrl($this->request, "", "Front", "Index", array("filter_id" => $vn_company_id))."#timeline' ".(($pn_filter_id == $vn_company_id) ? "class='currentFilter company'" : "").">Company</a>";
			print "<a href='".caNavUrl($this->request, "", "Front", "Index", array("filter_id" => $vn_leadership_id))."#timeline' ".(($pn_filter_id == $vn_leadership_id) ? "class='currentFilter leadership'" : "").">Leadership</a>";
			print "<a href='".caNavUrl($this->request, "", "Front", "Index", array("filter_id" => $vn_products_id))."#timeline' ".(($pn_filter_id == $vn_products_id) ? "class='currentFilter products'" : "").">Products</a>";
			print "<a href='".caNavUrl($this->request, "", "Front", "Index", array("filter_id" => $vn_communities_id))."#timeline' ".(($pn_filter_id == $vn_communities_id) ? "class='currentFilter communities'" : "").">Communities</a>";
			print "<a href='".caNavUrl($this->request, "", "Front", "Index", array("filter_id" => $vn_sustainability_id))."#timeline' ".(($pn_filter_id == $vn_sustainability_id) ? "class='currentFilter sustainability'" : "").">Sustainability</a>";
			print "<a href='".caNavUrl($this->request, "", "Front", "Index", array("filter_id" => $vn_industry_id))."#timeline' ".(($pn_filter_id == $vn_industry_id) ? "class='currentFilter industry'" : "").">Industry</a>";
?>
		</div>
	</div>
<?php
	if(!$vs_mode){
		foreach($va_events_by_decade as $vs_decade => $va_events_by_year){
?>
			<div class="row frontTimeline">
				<div class="col-sm-2 frontDecadeCol">
					<H1><?php print $vs_decade; ?></H1>
<?php
					if(is_array($va_world_events_by_decade[$vs_decade])){
						foreach($va_world_events_by_decade[$vs_decade] as $va_world_event){
							print "<div class='frontTimelineWorldEvent'><div class='frontTimelineWorldEventDate'>".$va_world_event["date"]."</div>".$va_world_event["title"]."</div>";
						}
					}
?>
				</div><!--end col-sm-2-->
				<div class="col-sm-10 frontYearCol"><div class="container">
<?php
				$i = 1;
				$vn_row = 1;
				foreach($va_events_by_year as $vs_year => $va_events){
					foreach($va_events as $va_event){
						if($i == 1){
							print "<div class='row ".(($vn_row > 1) ? $vs_decade."Rows" : "")."'".(($vn_row > 1) ? " style='display:none;'" : "").">";
						}
?>
						<div class="col-md-2 col-sm-3 col-xs-6 frontTimeLineCol" id="col<?php print $va_event["id"]; ?>">
							<div class="frontTimelineCard">
<?php
							print $va_event["iconlarge"]."<div class='frontTimelineDivide ".$va_event["category_code"]."Divide'></div><div class='frontTimelineCardCaption'><div class='frontTimelineCardCaptionDate'>".$va_event["date"]."</div>".$va_event["title"]."</div>";
?>
								<i class="fa fa-search" id="mag<?php print $va_event["id"]; ?>"></i>
							</div><!--end frontTimelineCard -->
							<div class="frontTimelineCardFull" id="full<?php print $va_event["id"]; ?>">
<?php
							print "<div class='frontTimelineDivide ".$va_event["category_code"]."Divide'><div class='pull-right'><a href='".caNavUrl($this->request, "", "Front", "Index", array("filter_id" => $va_event["category_id"]))."#timeline'>".$va_event["category_code"]."</a></div>".$va_event["date"]."</div><div class='frontTimelineCardFullTitle'>".$va_event["title"]."</div>";
							print "<div class='frontTimelineCardFullCol'>".$va_event["medium"]."</div>";
							print "<div class='frontTimelineCardFullCol'><div class='frontTimelineCardFullDesc'>".$va_event["public_description"]."</div>";
							if($this->request->isLoggedIn()){
								print "<div class='text-right'>".caDetailLink($this->request, 'More', '', 'ca_occurrences', $va_event["id"])."</div>";
							}
							print "</div>";
?>
							</div>
						</div>
	<script type="text/javascript">
		jQuery(document).ready(function() {
    		jQuery('#mag<?php print $va_event["id"]; ?>').on('click mouseover',function(e) { jQuery('#full<?php print $va_event["id"]; ?>').show(); });
    		jQuery('#col<?php print $va_event["id"]; ?>').on('mouseleave',function(e) { jQuery('#full<?php print $va_event["id"]; ?>').hide(); });
    		});
	</script>
<?php
						if($i == 6){
							print "</div>";
							$i = 1;
							$vn_row++;
						}else{
							$i++;
						}
					}
				}
				if($i > 1){
					print "</div>";
				}
				if($vn_row > 1){
?>
					<div class="row">
						<div class="col-sm-12 text-center">
							<a href="#" onClick="$('.<?php print $vs_decade; ?>Rows').slideToggle(); $(this).text(($(this).text() == 'More') ? 'Less' : 'More'); return false;" class="btn-default">More</a><br/><br/><br/>
						</div>
					</div>
<?php
				}
?>
				</div></div>
			</div><!-- end row -->
<?php
		}
	}else{
		foreach($va_events_by_decade as $vs_decade => $va_events_by_year){
?>
			<div class="row frontTimeline">
				<div class="col-sm-2 frontDecadeCol">
					<H1><?php print $vs_decade; ?></H1>
<?php
					if(is_array($va_world_events_by_decade[$vs_decade])){
						foreach($va_world_events_by_decade[$vs_decade] as $va_world_event){
							print "<div><br/>".$va_world_event["date"]."<br/>".$va_world_event["title"]."<br/><br/></div>";
						}
					}
?>
				</div><!--end col-sm-2-->
<?php
				foreach($va_events_by_year as $vs_year => $va_events){
?>
					<div class="col-sm-1 frontYearCol">
						<H1><?php print $vs_year;?></h1>
<?php
						foreach($va_events as $va_event){
							print $va_event["iconlarge"]."<div class='frontEventCaption'>".$va_event["title"]."</div>";
						}
?>
					</div>
<?php			
				}
?>
			</div><!-- end row -->
<?php
		}
	}
?>