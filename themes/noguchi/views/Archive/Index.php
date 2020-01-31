<?php
/** ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013-2019 Whirl-i-Gig
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
 $qr_highlights = $this->getVar("highlights_set_items_as_search_result");
 $qr_featured = $this->getVar("featured_set_items_as_search_result");
 $o_config = $this->getVar("config");
 $va_archive_collections = $o_config->get("archive_collections");
?>


    <main id="main" role="main" class="ca ca_archive_landing">

        <section class="intro">
            <div class="wrap block-large">
                <div class="wrap-max-content">
                    <div class="block-half body-text-l">{{{archiveIntro}}}</div>
                    <div class="block-half body-text-l text-gray">{{{archiveSupport}}}</div>
                </div>
            </div>
        </section>

<?php
		print $this->render("pageFormat/archive_nav.php");
?>

        <section class="block block-top">
            <div class="wrap">

                <div class="columns">

                    <div class="col">

<?php
					if($qr_featured && $qr_featured->numHits()){
?>
                        <div class="module_carousel archive_landing" data-prevnext="false" data-draggable="false">
                            <div class="carousel-main">
<?php
							while($qr_featured->nextHit()){
?>
                                <div class="carousel-cell">
                                    <div class="img-container dark">
<?php
									print print caDetailLink($qr_featured->getWithTemplate('<div class="img-wrapper square contain"><div class="bg-image" style="background-image: url(^ca_object_representations.media.large.url)"></div></div>'), '', 'ca_objects', $qr_featured->get("ca_objects.object_id"), '', array('tabindex' => '-1', 'title' => str_replace(array("'", '"'), "",$qr_featured->get("ca_objects.preferred_labels.name"))));
?>
                                    </div>
                                    <div class="caption caption-text"><?php print caDetailLink($qr_featured->getWithTemplate($o_config->get("archive_featured_item_caption_template")), '', 'ca_objects', $qr_featured->get("ca_objects.object_id"), '', array('tabindex' => '-1', 'title' => str_replace(array("'", '"'), "",$qr_featured->get("ca_objects.preferred_labels.name")))); ?></div>
                                </div>
<?php
							}
?>
                            </div><!-- end carousel-main -->
                        </div><!-- end module_carousel -->
<?php
							}
?>
                    </div>

                    <div class="col">
                        <div class="module_accordion">

                            <div class="items">

                                <div class="item" open="yes">
                                    <div class="trigger">Archival Collections</div>                
                                    <div class="details subheadline text-gray">
                                        <div class="inner">
<?php
											if(is_array($va_archive_collections) && sizeof($va_archive_collections)){
												foreach($va_archive_collections as $vs_archive_collection_title => $vn_archive_collection_id){
													print "<div class='block-quarter'>".caNavLink($vs_archive_collection_title, '', '', 'Browse','archive', array('facet' => 'collection_facet', 'id' => $vn_archive_collection_id))."</div>";                                            
												}
											}
?>
                                        </div>
                                    </div>
                                </div>

                                <div class="item">
                                    <div class="subheadline"><?php print caNavLink("Isamu Noguchi Personal Library", "", "", "Browse", "library"); ?></div>
                                </div>

                                <div class="item">
                                    <div class="trigger">More Resources</div>                
                                    <div class="details subheadline text-gray">
                                        <div class="inner">
                                            <div class="block-quarter"><?php print caNavLink("The Isamu Noguchi Catalogue Raisonné", "", "", "CR", "Index"); ?></div>
                                            <div class="block-quarter"><?php print caNavLink('Study Collection', '', '', 'Browse','archive', array('facet' => 'collection_facet', 'id' => 2094)); ?></div>
                                            <div class="block-quarter"><a href="https://www.noguchi.org/isamu-noguchi/biography/exhibition-history/">Exhibition History</a></div>
                                            <div class="block-quarter"><?php print caNavLink("Bibliography", "", "", "Browse", "bibliography"); ?></div>
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </section>

        <section class="block border">
            <div class="wrap">
                <div class="block-half text-align-center">
                    <h4 class="subheadline-bold">Highlights from the Archive</h4>
                </div>
            </div>
<?php
		if($qr_highlights && $qr_highlights->numHits()){
?>
			<div class="module_carousel archive_related" data-prevnext="false" data-pagedots="false">
				<div class="carousel-main">
<?php
				while($qr_highlights->nextHit()){
?>
					<div class="carousel-cell">

<?php
						$vs_date = $qr_highlights->get("ca_objects.date.display_date");
						if(!$vs_date){
							$vs_date = $qr_highlights->get("ca_objects.date.parsed_date");
						}

						print caDetailLink('
							<div class="img-wrapper archive_thumb block-quarter">'.$qr_highlights->getWithTemplate('<div class="bg-image" style="background-image: url(^ca_object_representations.media.medium.url)"></div>').'
							</div>
							<div class="text block-quarter">
								<div class="ca-identifier text-gray">'.$qr_highlights->get("ca_objects.idno").'</div>
								<div class="more">                                
									<div class="thumb-text clamp" data-lines="2">'.$qr_highlights->get("ca_objects.preferred_labels.name").'</div>

									<div class="ca-identifier text-gray">'.$vs_date.'</div>
								</div>
							</div>', '', 'ca_objects', $qr_highlights->get("ca_objects.object_id"), '', array('tabindex' => '-1', 'title' => str_replace(array("'", '"'), "",$qr_highlights->get("ca_objects.preferred_labels.name") )));
?>

					</div>
<?php
				}
?>

				</div>
			</div>

<?php
		}
?>
        </section>



    </main>