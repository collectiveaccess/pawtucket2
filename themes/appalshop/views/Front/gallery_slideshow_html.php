

<?php
/** ---------------------------------------------------------------------
 * themes/default/Front/gallery_slideshow_html : Front page of site 
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

	$va_access_values = $this->getVar("access_values");
	$o_config = caGetGalleryConfig();
	
	# --- which type of set is configured for display in gallery section
 	$t_list = new ca_lists();
 	$vn_gallery_set_type_id = $t_list->getItemIDFromList('set_types', $o_config->get('gallery_set_type')); 			
 	$t_set = new ca_sets();
	$va_sets = array();
	if($vn_gallery_set_type_id){
		$va_tmp = array('checkAccess' => $va_access_values, 'setType' => $vn_gallery_set_type_id, 'table' => "ca_objects");
		$va_sets = caExtractValuesByUserLocale($t_set->getSets($va_tmp));
		$va_set_first_items = $t_set->getPrimaryItemsFromSets(array_keys($va_sets), array("version" => "iconlarge", "checkAccess" => $va_access_values));
		
		$o_front_config = caGetFrontConfig();
		$vs_front_page_set = $o_front_config->get('front_page_set_code');
		$vb_omit_front_page_set = (bool)$o_config->get('omit_front_page_set_from_gallery');
		foreach($va_sets as $vn_set_id => $va_set) {
			if ($vb_omit_front_page_set && $va_set['set_code'] == $vs_front_page_set) { 
				unset($va_sets[$vn_set_id]); 
			}
			$va_first_item = $va_set_first_items[$vn_set_id];
			$va_first_item = array_shift($va_first_item);
			$vn_item_id = $va_first_item["item_id"];
		}
	}

	if(is_array($va_sets) && sizeof($va_sets)){
?>
<div class="container">
<div class="row">
<div class="three-items">
	<div class="col-sm-12 col-md-3 col-lg-3 "> 
	<div class="specialProjects">
		<H2>Special Projects</H2>
<?php
			print caGetGallerySetsAsList($this->request, "nav nav-pills nav-stacked");
?>
	</div>
	</div>


<?php
	}
?>

<?php

 	$o_config = $this->getVar("config");
	$va_access_values = $this->getVar("access_values");
	
	$va_spotlight_ids = array();
	if($vs_set_code = $o_config->get("spotlight_set_code")){
		$t_set = new ca_sets();
		$t_set->load(array('set_code' => $vs_set_code));
		$vn_shuffle = 1;
		if($o_config->get("spotlight_set_random")){
			$vn_shuffle = 1;
		}
		# Enforce access control on set
		if((sizeof($va_access_values) == 0) || (sizeof($va_access_values) && in_array($t_set->get("access"), $va_access_values))){
			$vn_spotlight_set_id = $t_set->get("set_id");
			$va_spotlight_ids = array_keys(is_array($va_tmp = $t_set->getItemRowIDs(array('checkAccess' => $va_access_values, 'shuffle' => $vn_shuffle))) ? $va_tmp : array());
			$qr_res = caMakeSearchResult('ca_objects', $va_spotlight_ids);
	
			$vs_caption_template = $o_config->get("spotlight_set_item_caption_template");
			if(!$vs_caption_template){
				$vs_caption_template = "<l>^ca_objects.preferred_labels.name</l>";
			}
			if($qr_res && $qr_res->numHits()){
 
?>   
				<div class="col-sm-12 col-md-6 col-lg-6">
					<div class="frontGrid">
						<h2>Spotlight</h2>
<?php
						$i = $vn_col = 0;
						while($qr_res->nextHit()){
							if($vs_media = $qr_res->getWithTemplate('<l>^ca_object_representations.media.iconlarge</l>', array("checkAccess" => $va_access_values))){
								if($vn_col == 0){
									print "<div class='row'>";
								}
								print "<div class='col-sm-4 col-xs-12 col-md-4 col-lg-4 gridImage'>".$vs_media;
								$vs_caption = $qr_res->getWithTemplate($vs_caption_template);
								if($vs_caption){
									print "<div class='frontGridCaption'>".$vs_caption."</div>";
								}
								print "</div>";
								$vb_item_output = true;
								$i++;
								$vn_col++;
								if($vn_col == 3){
									print "</div>";
									$vn_col = 0;
								}
							}
							if($i == 6){
								break;
							}
						}
						if($vn_col > 0){
							print "</div><!-- end row -->";
						}
?>
					</div>
				</div>

<?php
			}
		}
	}
	global $wp, $wp_query, $wp_the_query, $wpdb;
	define('WP_USE_THEMES', false);
	require('./news/wp-config.php');
	require('./news/wp-blog-header.php');
	$wp->init();
	$wp->parse_request();
	$wp->query_posts();
	$wp->register_globals();
	$wp->send_headers();

	rewind_posts();
?>
	<div class="col-sm-12 col-md-3 col-lg-3 ">
		<div class="news">
		<h2>Latest News</h2>
<?php	
	# Last Wordpress Post
	$posts = query_posts('numberposts=1');
	while (have_posts()) : the_post();
?>
		
<?php
		$i = 0;
		foreach($posts as $post) : setup_postdata($post);
?>
		<!--	<span class="news-item-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></span>
			<p class="news-item"><?php the_excerpt(); ?></p> -->
<?php		
			$i++;
			if($i == 1){
				break;
			}
		endforeach; 
	endwhile;

?>
<?php
// Get the last post.
global $post;
$args = array( 'posts_per_page' => 1 );
$myposts = get_posts( $args );

foreach( $myposts as $post ) :	setup_postdata($post); ?>
<span class="news-item-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></span><p class="news-item"><?php the_excerpt(); ?></p>
<?php endforeach; ?>

		</div>
	</div>
</div>
</div>
</div>