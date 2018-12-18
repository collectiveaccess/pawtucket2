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
					$va_all_reps = $t_occ->getRepresentations(array("medium"), null, array("checkAccess" => $va_access_values));
					$va_medium_reps = array();
					if(sizeof($va_all_reps) > 1){
						# --- add the primary rep first
						$va_medium_reps[] = $va_reps["tags"]["medium"];
						foreach($va_all_reps as $va_tmp){
							if($va_reps["representation_id"] != $va_tmp["representation_id"]){
								$va_medium_reps[] = $va_tmp["tags"]["medium"];
							}
						}
					}else{
						$va_medium_reps[] = $va_reps["tags"]["medium"];
					}
					$va_events_by_decade[$vs_decade][$vs_start_year][$qr_res->get("ca_occurrences.occurrence_id")] = array("id" => $qr_res->get("ca_occurrences.occurrence_id"), "date" => $qr_res->get("ca_occurrences.timeline_date"), "title" => $qr_res->get("ca_occurrences.preferred_labels"), "public_description" => $qr_res->get("public_description"), "category_code" => $vs_category_code, "category_id" => $vn_category_id, "iconlarge" => $va_reps["tags"]["iconlarge"], "medium" => $va_medium_reps);
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
			 	&nbsp;&nbsp;<a href="https://twitter.com/share?ref_src=twsrc%5Etfw" class="twitter-share-button" data-show-count="false"><i class="fa fa-twitter fa-3x" aria-hidden="true"></i></a><script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>
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
			<a name="timeline"></a><h1>Innovating office environments for over 106 years</h1>
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
<?php
							$vs_card_buf = "";
							$vs_card_buf.= "<div class='frontTimelineCardFull' >";
							$vs_card_buf.= "<div class='frontTimelineDivide ".$va_event["category_code"]."Divide'><div class='pull-right'><a href='".caNavUrl($this->request, "", "Front", "Index", array("filter_id" => $va_event["category_id"]))."#timeline'>".$va_event["category_code"]."</a></div>".$va_event["date"]."</div><div class='frontTimelineCardFullTitle'>".$va_event["title"]."</div>";
							if(sizeof($va_event["medium"]) > 1){
								$media_count = 1;
								$vs_card_buf.= "<div class='frontTimelineCardFullCol'>";							
								$vs_card_buf.= "<div id='carousel".$va_event["id"]."' class='carousel slide' data-ride=carousel' >
										<div class='carousel-inner'>";
											foreach($va_event["medium"] as $vs_medium_rep){
												if ($media_count == 1) { $vs_class = "active"; } else { $vs_class = ""; }
												$vs_card_buf.= "<div class='item ".$vs_class."'>".$vs_medium_rep."</div>";
												$media_count++;
											}
								$vs_card_buf.=	"</div><!-- end carousel-inner -->
										<a class='carousel-control-prev' href='#carousel".$va_event["id"]."' role='button' data-slide='prev'>
    										<span class='carousel-control-prev-icon' aria-hidden='true'><i class='fa fa-chevron-left'></i></span>
    										<span class='sr-only'>Previous</span>
  										</a>
  										<a class='carousel-control-next' href='#carousel".$va_event["id"]."' role='button' data-slide='next'>
    										<span class='carousel-control-next-icon' aria-hidden='true'><i class='fa fa-chevron-right'></i></span>
    										<span class='sr-only'>Next</span>
  										</a>
									</div><!-- end carousel -->";
								$vs_card_buf.= "</div><!-- end frontTimelineCardFullCol --> ";
							}else{
								$vs_card_buf.= "<div class='frontTimelineCardFullCol'>".$va_event["medium"][0]."</div>";
							}
							$vs_card_buf.= "<div class='frontTimelineCardFullCol'><div class='frontTimelineCardFullDesc'>".htmlentities(strip_tags($va_event["public_description"]))."</div><!-- end desc--></div><!-- end fullcol -->";
							$vs_card_buf.= "</div><!-- end frontTimelineCardFull -->";
?>						
							<div class="frontTimelineCard" data-toggle="popover"  tabindex="0" data-trigger="click" data-html="true" <?php print ( $i > 3 ? 'data-placement="left"' : 'data-placement="right"') ;?>data-content="<?php print htmlentities($vs_card_buf);?>">
<?php
							print $va_event["iconlarge"]."<div class='frontTimelineDivide ".$va_event["category_code"]."Divide'></div><div class='frontTimelineCardCaption'><div class='frontTimelineCardCaptionDate'>".$va_event["date"]."</div>".$va_event["title"]."</div>";
?>
							</div><!--end frontTimelineCard -->
							

						</div><!-- end  col -->
<?php
						if($i == 6){
							print "</div><!-- end  row -->";
							$i = 1;
							$vn_row++;
						}else{
							$i++;
						}
					}
				}
				if($i > 1){
					print "</div><!-- end  row -->";
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
	if(!Session::getVar('visited')){
?>
<div id="welcomeMessage">
	<div class="row frontIntro">
		<div class="col-sm-12">	
			<?php print caGetThemeGraphic($this->request, 'hpTruck.jpg');?>
			<div class="frontIntroOverlay">
<!--
				<p>
					Over 100 years ago a group of investors trusted that a metal office furniture company could compete in a city renown for wood manufacturing.
				</p>
 				<p>
 					Looking back, it's clear our company has always been about looking forward. Our past, present and future are all about turning insights into innovations that unlock the promise of people at work and make the world a better place.
 				</p>-->
<p>We opened our doors in 1912 after 11 business men agreed to invest in Peter M. Wege's dream of opening a steel office furniture company in a city renown for wood furniture. Since then we've experienced many changes, including our name, but our business vision of always looking toward the future has remained the same.</p>

<p>Here we'd like to share with you a few hundred of the thousands of noteworthy historical moments from our 105-year plus legacy.</p>


			</div>
		</div>
	</div>			
	<a href="#" onclick="$('#welcomeMessage').fadeOut(200); return false;"><div class="ok btn-default">OK</div></a>
</div>
<?Php
	}
	Session::setVar('visited', true);
?>

		<div style="height:200px"></div>
<script>
	jQuery(document).ready(function() { 		
		$('#welcomeMessage').fadeIn(1000);
		
		$('.frontTimelineCard').popover({
  			trigger: 'click'
		});
		$('.frontTimelineCard').on('click', function (e) {
    		$('.frontTimelineCard').not(this).popover('hide');
		});
		$('#carousel').carousel({
  			interval: 2000
		});
	});
		
	
</script>
