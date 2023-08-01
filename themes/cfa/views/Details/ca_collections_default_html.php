<?php
/* ----------------------------------------------------------------------
 * themes/default/views/bundles/ca_collections_default_html.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013-2022 Whirl-i-Gig
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
 
	$t_item = $this->getVar("item");
	$va_comments = $this->getVar("comments");
	$vn_comments_enabled = 	$this->getVar("commentsEnabled");
	$vn_share_enabled = 	$this->getVar("shareEnabled");
	$vn_pdf_enabled = 		$this->getVar("pdfEnabled");
	
	# --- get collections configuration
	$o_collections_config = caGetCollectionsConfig();
	$vb_show_hierarchy_viewer = true;
	if($o_collections_config->get("do_not_display_collection_browser")){
		$vb_show_hierarchy_viewer = false;	
	}
	# --- get the collection hierarchy parent to use for exportin finding aid
	$vn_top_level_collection_id = array_shift($t_item->get('ca_collections.hierarchy.collection_id', array("returnWithStructure" => true)));

?>

<div class="row">
  <main class="flush">
    <section class="hero-single-collection wrap">
      <br/>
      <h1 class="text-align-center color__white text__headline-1 block-sm">
        {{{^ca_collections.preferred_labels}}}
      </h1>

      <div class="layout grid-flex">
        <div class="item color__white">
          <div>*** Need to fix slider, Need to have slider load correct media for the collection</div>
          <div class="slider-container module_slideshow slideshow-single-collection over-black autoplay fade-captions slideshow-ctrl-init">
            <div class="dots-white dots-centered 1 slick-initialized slick-slider slick-dotted">
              <div class="slick-list draggable">
                <div class="slick-track" style="opacity: 1; width: 1677px;">
                  <div class="slick-slide" data-slick-index="0" aria-hidden="true" style="width: 559px; position: relative; left: 0px; top: 0px; z-index: 998; opacity: 0; transition: opacity 800ms ease 0s;" role="tabpanel" id="slick-slide40" aria-describedby="slick-slide-control40" tabindex="-1">
                    <div>
                      <div class="slide-wrap" style="width: 100%; display: inline-block;">
                        <div class="image-sizer ">
                          <div class="img-wrapper no-background-color rounded" data-width="2560" data-height="1914">
                            <img src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-srcset="https://cfarchives.wpengine.com/wp-content/uploads/2023/05/Screen-Shot-2022-08-19-at-10.55.47-AM-scaled.jpg 2560w, https://cfarchives.wpengine.com/wp-content/uploads/2023/05/Screen-Shot-2022-08-19-at-10.55.47-AM-1536x1148.jpg 1536w, https://cfarchives.wpengine.com/wp-content/uploads/2023/05/Screen-Shot-2022-08-19-at-10.55.47-AM-2048x1531.jpg 2048w, https://cfarchives.wpengine.com/wp-content/uploads/2023/05/Screen-Shot-2022-08-19-at-10.55.47-AM-170x127.jpg 170w, https://cfarchives.wpengine.com/wp-content/uploads/2023/05/Screen-Shot-2022-08-19-at-10.55.47-AM-80x60.jpg 80w, https://cfarchives.wpengine.com/wp-content/uploads/2023/05/Screen-Shot-2022-08-19-at-10.55.47-AM-400x299.jpg 400w, https://cfarchives.wpengine.com/wp-content/uploads/2023/05/Screen-Shot-2022-08-19-at-10.55.47-AM-600x449.jpg 600w, https://cfarchives.wpengine.com/wp-content/uploads/2023/05/Screen-Shot-2022-08-19-at-10.55.47-AM-800x598.jpg 800w, https://cfarchives.wpengine.com/wp-content/uploads/2023/05/Screen-Shot-2022-08-19-at-10.55.47-AM-1200x897.jpg 1200w, https://cfarchives.wpengine.com/wp-content/uploads/2023/05/Screen-Shot-2022-08-19-at-10.55.47-AM-1600x1196.jpg 1600w, https://cfarchives.wpengine.com/wp-content/uploads/2023/05/Screen-Shot-2022-08-19-at-10.55.47-AM-2400x1794.jpg 2400w" data-sizes="auto" alt="Screen Shot 2022 08 19 At 10.55.47 AM" class=" lazyload-persist lazyautosizes ls-is-cached lazyloaded " data-pin-nopin="true" draggable="false" sizes="441px" srcset="https://cfarchives.wpengine.com/wp-content/uploads/2023/05/Screen-Shot-2022-08-19-at-10.55.47-AM-scaled.jpg 2560w, https://cfarchives.wpengine.com/wp-content/uploads/2023/05/Screen-Shot-2022-08-19-at-10.55.47-AM-1536x1148.jpg 1536w, https://cfarchives.wpengine.com/wp-content/uploads/2023/05/Screen-Shot-2022-08-19-at-10.55.47-AM-2048x1531.jpg 2048w, https://cfarchives.wpengine.com/wp-content/uploads/2023/05/Screen-Shot-2022-08-19-at-10.55.47-AM-170x127.jpg 170w, https://cfarchives.wpengine.com/wp-content/uploads/2023/05/Screen-Shot-2022-08-19-at-10.55.47-AM-80x60.jpg 80w, https://cfarchives.wpengine.com/wp-content/uploads/2023/05/Screen-Shot-2022-08-19-at-10.55.47-AM-400x299.jpg 400w, https://cfarchives.wpengine.com/wp-content/uploads/2023/05/Screen-Shot-2022-08-19-at-10.55.47-AM-600x449.jpg 600w, https://cfarchives.wpengine.com/wp-content/uploads/2023/05/Screen-Shot-2022-08-19-at-10.55.47-AM-800x598.jpg 800w, https://cfarchives.wpengine.com/wp-content/uploads/2023/05/Screen-Shot-2022-08-19-at-10.55.47-AM-1200x897.jpg 1200w, https://cfarchives.wpengine.com/wp-content/uploads/2023/05/Screen-Shot-2022-08-19-at-10.55.47-AM-1600x1196.jpg 1600w, https://cfarchives.wpengine.com/wp-content/uploads/2023/05/Screen-Shot-2022-08-19-at-10.55.47-AM-2400x1794.jpg 2400w">
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="slick-slide" data-slick-index="1" aria-hidden="true" style="width: 559px; position: relative; left: -559px; top: 0px; z-index: 998; opacity: 0; transition: opacity 800ms ease 0s;" role="tabpanel" id="slick-slide41" aria-describedby="slick-slide-control41" tabindex="-1">
                    <div>
                      <div class="slide-wrap" style="width: 100%; display: inline-block;">
                        <div class="image-sizer ">
                          <div class="img-wrapper no-background-color rounded" data-width="600" data-height="450">
                            <img src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-srcset="https://cfarchives.wpengine.com/wp-content/uploads/2023/05/image-4.jpg 600w, https://cfarchives.wpengine.com/wp-content/uploads/2023/05/image-4-170x128.jpg 170w, https://cfarchives.wpengine.com/wp-content/uploads/2023/05/image-4-80x60.jpg 80w, https://cfarchives.wpengine.com/wp-content/uploads/2023/05/image-4-400x300.jpg 400w" data-sizes="auto" alt="Image 4" class=" lazyload-persist left_top lazyautosizes ls-is-cached lazyloaded " data-pin-nopin="true" draggable="false" sizes="441px" srcset="https://cfarchives.wpengine.com/wp-content/uploads/2023/05/image-4.jpg 600w, https://cfarchives.wpengine.com/wp-content/uploads/2023/05/image-4-170x128.jpg 170w, https://cfarchives.wpengine.com/wp-content/uploads/2023/05/image-4-80x60.jpg 80w, https://cfarchives.wpengine.com/wp-content/uploads/2023/05/image-4-400x300.jpg 400w">
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="slick-slide slick-current slick-active" data-slick-index="2" aria-hidden="false" style="width: 559px; position: relative; left: -1118px; top: 0px; z-index: 999; opacity: 1;" role="tabpanel" id="slick-slide42" aria-describedby="slick-slide-control42">
                    <div>
                      <div class="slide-wrap" style="width: 100%; display: inline-block;">
                        <div class="image-sizer ">
                          <div class="img-wrapper no-background-color rounded" data-width="400" data-height="300">
                            <img src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-srcset="https://cfarchives.wpengine.com/wp-content/uploads/2023/05/42296_ca_object_representations_media_1817_medium.jpg 400w, https://cfarchives.wpengine.com/wp-content/uploads/2023/05/42296_ca_object_representations_media_1817_medium-170x128.jpg 170w, https://cfarchives.wpengine.com/wp-content/uploads/2023/05/42296_ca_object_representations_media_1817_medium-80x60.jpg 80w" data-sizes="auto" alt="42296 Ca Object Representations Media 1817 Medium" class=" lazyload-persist left_top lazyautosizes ls-is-cached lazyloaded " data-pin-nopin="true" draggable="false" sizes="441px" srcset="https://cfarchives.wpengine.com/wp-content/uploads/2023/05/42296_ca_object_representations_media_1817_medium.jpg 400w, https://cfarchives.wpengine.com/wp-content/uploads/2023/05/42296_ca_object_representations_media_1817_medium-170x128.jpg 170w, https://cfarchives.wpengine.com/wp-content/uploads/2023/05/42296_ca_object_representations_media_1817_medium-80x60.jpg 80w">
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <ul class="slick-dots" style="" role="tablist">
                <li class="" role="presentation">
                  <button type="button" role="tab" id="slick-slide-control40" aria-controls="slick-slide40" aria-label="1 of 3" tabindex="-1">1</button>
                </li>
                <li role="presentation" class="">
                  <button type="button" role="tab" id="slick-slide-control41" aria-controls="slick-slide41" aria-label="2 of 3" tabindex="-1">2</button>
                </li>
                <li role="presentation" class="slick-active">
                  <button type="button" role="tab" id="slick-slide-control42" aria-controls="slick-slide42" aria-label="3 of 3" tabindex="0" aria-selected="true">3</button>
                </li>
              </ul>
            </div>
            <ul class="captions text__caption img-caption">
              <li class="" style="opacity: 1;">In a Vacuum, 1962. </li>
            </ul>

          </div>
        </div>

        <div class="item">
          <div class="container-scroll" style="height: 398.305px;">
            <div class="content-scroll">
              <div class="size-column">

                <div>*** We need a list of required metadata elements for this hero section ***</div>

                <div class="max__640 text__eyebrow color__light_gray block-xxxs">inclusive dates</div>
                <div class="max__640 text__body-3 color__white block-sm">
                    {{{<ifdef code="ca_collections.cfaInclusiveDates">^ca_collections.cfaInclusiveDates</ifdef>}}}
                </div>
                <div class="max__640 text__eyebrow color__light_gray block-xxxs">bulk dates</div>
                <div class="max__640 text__body-3 color__white block-sm">{{{<ifdef code="ca_collections.cfaBulkDates">^ca_collections.cfaBulkDates</ifdef>}}}</div>
                <div class="max__640 text__eyebrow color__light_gray block-xxxs">Preservation Sponsors</div>
                *** is this subject to change?
                <ul class="sponsors block-xxxs">
                  <li>
                    <div class="img-wrapper no-background-color contain sponsor" data-width="410" data-height="100">
                      <img src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-srcset="https://cfarchives.wpengine.com/wp-content/uploads/2023/05/sponsot.png 410w, https://cfarchives.wpengine.com/wp-content/uploads/2023/05/sponsot-170x41.png 170w, https://cfarchives.wpengine.com/wp-content/uploads/2023/05/sponsot-80x20.png 80w, https://cfarchives.wpengine.com/wp-content/uploads/2023/05/sponsot-400x98.png 400w" data-sizes="auto" alt="Sponsot" class=" lazyload-persist lazyautosizes ls-is-cached lazyloaded " data-pin-nopin="true" draggable="false" sizes="205px" srcset="https://cfarchives.wpengine.com/wp-content/uploads/2023/05/sponsot.png 410w, https://cfarchives.wpengine.com/wp-content/uploads/2023/05/sponsot-170x41.png 170w, https://cfarchives.wpengine.com/wp-content/uploads/2023/05/sponsot-80x20.png 80w, https://cfarchives.wpengine.com/wp-content/uploads/2023/05/sponsot-400x98.png 400w">
                    </div>
                  </li>
                </ul>
                <div class="max__640 text__body-3 color__white block-sm">
                    {{{
						<ifdef code="ca_collections.cfaPreservationSponsor">
							<div class="unit">
                                <unit relativeTo="ca_collections.cfaPreservationSponsor" delimiter="<br/>">
                                    ^ca_collections.cfaPreservationSponsor
                                </unit>
                            </div>
						</ifdef>
					}}}
                </div>
                <div class="max__640 text__eyebrow color__light_gray block-xxxs">abstract</div>
                <div class="max__640 text__body-3 color__white block-sm">
                    {{{<ifdef code="ca_collections.cfaAbstract">^ca_collections.cfaAbstract</ifdef>}}}
                </div>
                <div class="max__640 text__eyebrow color__light_gray block-xxxs">Description</div>
                <div class="max__640 text__body-3 color__white block-sm">
                    {{{<ifdef code="ca_collections.cfaDescription">^ca_collections.cfaDescription</ifdef>}}}
                </div>
              </div>
            </div>
            <!-- content-scroll -->
          </div>
          <!-- container-scroll -->
          <div class="footer link">
            <a href="#collection-details" class="text__eyebrow color-class-orange color__white scroll-to" data-offset="100">view More collection Details <span class="arrow-link down">
                <svg width="10" height="12" viewBox="0 0 10 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M3.62909 5.99999L0.436768 0.666656L9.99999 5.99999L0.436768 11.3333L3.62909 5.99999Z" fill="#767676" class="color-fill"></path>
                </svg>
              </span>
            </a>
          </div>
          <div class="shadow"></div>
        </div>
        <!-- item -->
      </div>
      <!-- layout -->
    </section>



    <section class="collection-grid-items ">
      <div class="wrap">
        <div class="int module-tabs">
          <div class="header">

            <div> This content is subject to change, Where are these going to be loaded from?</div>

            <h4 class="text-align-center text__headline-4 title">Collection Items</h4>
            <div class="filters">
              <ul class="tabs">
                <li class="tab active" data-index="0">
                  <span class="title text__eyebrow">Viewable Media</span>
                  <span class="info-icon collections-info">
                    <div class="trigger-icon color-icon-orange">
                      <svg width="15" height="16" viewBox="0 0 15 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M7.5 0.5C3.36 0.5 0 3.86 0 8C0 12.14 3.36 15.5 7.5 15.5C11.64 15.5 15 12.14 15 8C15 3.86 11.64 0.5 7.5 0.5ZM7.5 1.65385C11.0031 1.65385 13.8462 4.49692 13.8462 8C13.8462 11.5031 11.0031 14.3462 7.5 14.3462C3.99692 14.3462 1.15385 11.5031 1.15385 8C1.15385 4.49692 3.99692 1.65385 7.5 1.65385Z" fill="#767676" class="color-fill"></path>
                        <path d="M8.65374 4.68281C8.65374 5.02709 8.51698 5.35727 8.27355 5.60071C8.03012 5.84415 7.69995 5.98092 7.35568 5.98092C7.01141 5.98092 6.68125 5.84415 6.43781 5.60071C6.19438 5.35727 6.05762 5.02709 6.05762 4.68281C6.05762 4.33854 6.19438 4.00836 6.43781 3.76492C6.68125 3.52148 7.01141 3.38471 7.35568 3.38471C7.69995 3.38471 8.03012 3.52148 8.27355 3.76492C8.51698 4.00836 8.65374 4.33854 8.65374 4.68281Z" fill="#767676" class="color-fill"></path>
                        <path d="M8.73065 11.5724C8.72269 11.8874 8.87038 11.9762 9.22992 12.0131L9.80777 12.0247V12.6154H5.29934V12.0247L5.93431 12.0131C6.31404 12.0016 6.40531 11.8539 6.43358 11.5724V8.01701C6.43761 7.45405 5.70711 7.54244 5.19238 7.55917V6.97371L8.73065 6.84621" fill="#767676" class="color-fill"></path>
                      </svg>
                    </div>
                    <div class="info-window">
                      <div class="close">
                        <svg width="13" height="13" viewBox="0 0 13 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <path fill-rule="evenodd" clip-rule="evenodd" d="M0.455115 12.1882L11.8837 0.759628L12.4551 1.33105L1.02654 12.7596L0.455115 12.1882Z" fill="#222222"></path>
                          <path fill-rule="evenodd" clip-rule="evenodd" d="M1.02668 0.759803L12.4552 12.1883L11.8838 12.7598L0.455252 1.33123L1.02668 0.759803Z" fill="#222222"></path>
                        </svg>
                      </div>
                      <div class="title text__eyebrow">What is Viewable Media?</div>
                      <div class="text text__body-4">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</div>
                    </div>
                  </span>
                </li>
                <li class="tab" data-index="1">
                  <span class="title text__eyebrow">Item List</span>
                </li>
              </ul>

              <div> Needs to link to the advanced search</div>
              <a href="#" class="text__eyebrow color-class-orange $color__dark_gray">Advanced Collections Search <span class="arrow-link">
                  <svg width="10" height="12" viewBox="0 0 10 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M3.62909 5.99999L0.436768 0.666656L9.99999 5.99999L0.436768 11.3333L3.62909 5.99999Z" fill="#767676" class="color-fill"></path>
                  </svg>
                </span>
              </a>
            </div>
          </div>
          <div class="tabs-content">
            <div class="tab active grid-view" data-index="0">
              <div class="tab-int">
                <div class="grid-flex grid-1-3-4 margin-bottom">
                  <div class="item-item item">
                    <a href="https://cfarchives.wpengine.com/collection/item/cicero-march/">
                      <div class="overlay-image block-xxs">
                        <div class="img-wrapper " data-width="475" data-height="356">
                          <img src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-srcset="https://cfarchives.wpengine.com/wp-content/uploads/2023/06/74347_ca_object_representations_media_4203_mediumlarge.jpg 475w, https://cfarchives.wpengine.com/wp-content/uploads/2023/06/74347_ca_object_representations_media_4203_mediumlarge-170x127.jpg 170w, https://cfarchives.wpengine.com/wp-content/uploads/2023/06/74347_ca_object_representations_media_4203_mediumlarge-80x60.jpg 80w, https://cfarchives.wpengine.com/wp-content/uploads/2023/06/74347_ca_object_representations_media_4203_mediumlarge-400x300.jpg 400w" data-sizes="auto" alt="74347 Ca Object Representations Media 4203 Mediumlarge" class=" lazyload-persist lazyautosizes ls-is-cached lazyloaded " data-pin-nopin="true" draggable="false" sizes="200px" srcset="https://cfarchives.wpengine.com/wp-content/uploads/2023/06/74347_ca_object_representations_media_4203_mediumlarge.jpg 475w, https://cfarchives.wpengine.com/wp-content/uploads/2023/06/74347_ca_object_representations_media_4203_mediumlarge-170x127.jpg 170w, https://cfarchives.wpengine.com/wp-content/uploads/2023/06/74347_ca_object_representations_media_4203_mediumlarge-80x60.jpg 80w, https://cfarchives.wpengine.com/wp-content/uploads/2023/06/74347_ca_object_representations_media_4203_mediumlarge-400x300.jpg 400w">
                        </div>
                      </div>
                    </a>
                    <div class="text-align-center info ">
                      <div class="text__eyebrow color__gray format block-xxxs"></div>
                      <div class="title text__promo-4 block-xxxs">
                        <a href="https://cfarchives.wpengine.com/collection/item/cicero-march/" class="color-link-orange">Cicero March</a>
                      </div>
                      <div class="text__eyebrow year color__gray"></div>
                    </div>
                  </div>
                  <div class="item-item item">
                    <a href="https://cfarchives.wpengine.com/collection/item/salute-to-old-friends-agnes-de-mille-2/">
                      <div class="overlay-image block-xxs">
                        <div class="img-wrapper " data-width="602" data-height="460">
                          <img src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-srcset="https://cfarchives.wpengine.com/wp-content/uploads/2023/05/image-2-1-1-1.jpg 602w, https://cfarchives.wpengine.com/wp-content/uploads/2023/05/image-2-1-1-1-170x130.jpg 170w, https://cfarchives.wpengine.com/wp-content/uploads/2023/05/image-2-1-1-1-80x61.jpg 80w, https://cfarchives.wpengine.com/wp-content/uploads/2023/05/image-2-1-1-1-400x306.jpg 400w, https://cfarchives.wpengine.com/wp-content/uploads/2023/05/image-2-1-1-1-600x458.jpg 600w" data-sizes="auto" alt="Image 2 1 1 1" class=" lazyload-persist lazyautosizes ls-is-cached lazyloaded " data-pin-nopin="true" draggable="false" sizes="200px" srcset="https://cfarchives.wpengine.com/wp-content/uploads/2023/05/image-2-1-1-1.jpg 602w, https://cfarchives.wpengine.com/wp-content/uploads/2023/05/image-2-1-1-1-170x130.jpg 170w, https://cfarchives.wpengine.com/wp-content/uploads/2023/05/image-2-1-1-1-80x61.jpg 80w, https://cfarchives.wpengine.com/wp-content/uploads/2023/05/image-2-1-1-1-400x306.jpg 400w, https://cfarchives.wpengine.com/wp-content/uploads/2023/05/image-2-1-1-1-600x458.jpg 600w">
                        </div>
                        <svg width="60" height="61" viewBox="0 0 60 61" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <g clip-path="url(#clip0_1849_15820)">
                            <path d="M36.0897 25.6518C35.6295 25.1831 34.927 25.2091 34.491 25.6778C34.055 26.1726 34.0792 26.9278 34.5153 27.3965C35.2662 28.1778 35.6779 29.1934 35.6779 30.3131C35.6779 31.4329 35.2662 32.4485 34.5153 33.2297C34.055 33.6984 34.055 34.4797 34.491 34.9484C34.709 35.2088 35.0239 35.313 35.3146 35.313C35.6053 35.313 35.8717 35.2088 36.1139 34.9745C37.3009 33.7505 37.9549 32.0839 37.9549 30.2871C37.9306 28.5684 37.2766 26.9018 36.0897 25.6518Z" fill="white"></path>
                            <path d="M39.0936 22.546C38.6313 22.1047 37.9014 22.1307 37.4877 22.6498C37.0741 23.143 37.0984 23.9218 37.5851 24.363C39.2639 25.9724 40.2372 28.2827 40.2372 30.6968C40.2372 33.1109 39.2639 35.4212 37.5851 37.0306C37.1228 37.4719 37.0741 38.2506 37.4877 38.7438C37.7067 39.0034 38.023 39.1592 38.3393 39.1592C38.607 39.1592 38.8746 39.0553 39.0936 38.8477C41.2591 36.771 42.4999 33.8118 42.4999 30.6968C42.5243 27.5819 41.2834 24.6226 39.0936 22.546Z" fill="white"></path>
                            <path d="M29.9675 20.8506L22.6169 26.436H18.2273C17.8117 26.436 17.5 26.7801 17.5 27.1772V34.192C17.5 34.6155 17.8377 34.9332 18.2273 34.9332H22.6169L29.9675 40.545C30.461 40.9156 31.1364 40.5715 31.1364 39.9362V21.433C31.1364 20.8242 30.4351 20.48 29.9675 20.8506Z" fill="white"></path>
                            <path d="M30 59.6973C46.0163 59.6973 59 46.7136 59 30.6973C59 14.681 46.0163 1.6973 30 1.6973C13.9837 1.6973 1 14.681 1 30.6973C1 46.7136 13.9837 59.6973 30 59.6973Z" stroke="white" stroke-width="2"></path>
                          </g>
                          <defs>
                            <clipPath id="clip0_1849_15820">
                              <rect width="60" height="61" fill="white"></rect>
                            </clipPath>
                          </defs>
                        </svg>
                      </div>
                    </a>
                    <div class="text-align-center info ">
                      <div class="text__eyebrow color__gray format block-xxxs">FILM: 16MM</div>
                      <div class="title text__promo-4 block-xxxs">
                        <a href="https://cfarchives.wpengine.com/collection/item/salute-to-old-friends-agnes-de-mille-2/" class="color-link-orange">Salute to Old Friends: Agnes de Mille</a>
                      </div>
                      <div class="text__eyebrow year color__gray">1956</div>
                    </div>
                  </div>
                  <div class="item-item item">
                    <a href="https://cfarchives.wpengine.com/collection/item/salute-to-old-friends-agnes-de-mille/">
                      <div class="overlay-image block-xxs">
                        <div class="img-wrapper " data-width="602" data-height="460">
                          <img src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-srcset="https://cfarchives.wpengine.com/wp-content/uploads/2023/05/image-2-1-1.jpg 602w, https://cfarchives.wpengine.com/wp-content/uploads/2023/05/image-2-1-1-170x130.jpg 170w, https://cfarchives.wpengine.com/wp-content/uploads/2023/05/image-2-1-1-80x61.jpg 80w, https://cfarchives.wpengine.com/wp-content/uploads/2023/05/image-2-1-1-400x306.jpg 400w, https://cfarchives.wpengine.com/wp-content/uploads/2023/05/image-2-1-1-600x458.jpg 600w" data-sizes="auto" alt="Image 2 1 1" class=" lazyload-persist lazyautosizes ls-is-cached lazyloaded " data-pin-nopin="true" draggable="false" sizes="200px" srcset="https://cfarchives.wpengine.com/wp-content/uploads/2023/05/image-2-1-1.jpg 602w, https://cfarchives.wpengine.com/wp-content/uploads/2023/05/image-2-1-1-170x130.jpg 170w, https://cfarchives.wpengine.com/wp-content/uploads/2023/05/image-2-1-1-80x61.jpg 80w, https://cfarchives.wpengine.com/wp-content/uploads/2023/05/image-2-1-1-400x306.jpg 400w, https://cfarchives.wpengine.com/wp-content/uploads/2023/05/image-2-1-1-600x458.jpg 600w">
                        </div>
                      </div>
                    </a>
                    <div class="text-align-center info ">
                      <div class="text__eyebrow color__gray format block-xxxs">FILM: 16MM</div>
                      <div class="title text__promo-4 block-xxxs">
                        <a href="https://cfarchives.wpengine.com/collection/item/salute-to-old-friends-agnes-de-mille/" class="color-link-orange">Salute to Old Friends: Agnes de Mille</a>
                      </div>
                      <div class="text__eyebrow year color__gray">1956</div>
                    </div>
                  </div>
                  <div class="item-item item">
                    <a href="https://cfarchives.wpengine.com/collection/item/popular-music-al-jolson-you-made-me-love-you/">
                      <div class="overlay-image block-xxs">
                        <div class="img-wrapper " data-width="602" data-height="460">
                          <img src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-srcset="https://cfarchives.wpengine.com/wp-content/uploads/2023/05/image-2.jpg 602w, https://cfarchives.wpengine.com/wp-content/uploads/2023/05/image-2-170x130.jpg 170w, https://cfarchives.wpengine.com/wp-content/uploads/2023/05/image-2-80x61.jpg 80w, https://cfarchives.wpengine.com/wp-content/uploads/2023/05/image-2-400x306.jpg 400w, https://cfarchives.wpengine.com/wp-content/uploads/2023/05/image-2-600x458.jpg 600w" data-sizes="auto" alt="Image 2" class=" lazyload-persist lazyautosizes ls-is-cached lazyloaded " data-pin-nopin="true" draggable="false" sizes="200px" srcset="https://cfarchives.wpengine.com/wp-content/uploads/2023/05/image-2.jpg 602w, https://cfarchives.wpengine.com/wp-content/uploads/2023/05/image-2-170x130.jpg 170w, https://cfarchives.wpengine.com/wp-content/uploads/2023/05/image-2-80x61.jpg 80w, https://cfarchives.wpengine.com/wp-content/uploads/2023/05/image-2-400x306.jpg 400w, https://cfarchives.wpengine.com/wp-content/uploads/2023/05/image-2-600x458.jpg 600w">
                        </div>
                      </div>
                    </a>
                    <div class="text-align-center info ">
                      <div class="text__eyebrow color__gray format block-xxxs">FILM: 16MM</div>
                      <div class="title text__promo-4 block-xxxs">
                        <a href="https://cfarchives.wpengine.com/collection/item/popular-music-al-jolson-you-made-me-love-you/" class="color-link-orange">Popular Music: Al Jolson “You Made Me Love You”</a>
                      </div>
                      <div class="text__eyebrow year color__gray">1942</div>
                    </div>
                  </div>
                </div>
                <!-- grid -->
                <div class="grid-next-container">
                  <div class="grid-flex grid-1-3-4">
                    <div class="item-item item">
                      <a href="https://cfarchives.wpengine.com/collection/item/o-lost/">
                        <div class="overlay-image block-xxs">
                          <div class="img-wrapper " data-width="602" data-height="460">
                            <img src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-srcset="https://cfarchives.wpengine.com/wp-content/uploads/2023/05/image-1-1-1-1.jpg 602w, https://cfarchives.wpengine.com/wp-content/uploads/2023/05/image-1-1-1-1-170x130.jpg 170w, https://cfarchives.wpengine.com/wp-content/uploads/2023/05/image-1-1-1-1-80x61.jpg 80w, https://cfarchives.wpengine.com/wp-content/uploads/2023/05/image-1-1-1-1-400x306.jpg 400w, https://cfarchives.wpengine.com/wp-content/uploads/2023/05/image-1-1-1-1-600x458.jpg 600w" data-sizes="auto" alt="Image 1 1 1 1" class=" lazyload-persist lazyautosizes ls-is-cached lazyloaded " data-pin-nopin="true" draggable="false" sizes="200px" srcset="https://cfarchives.wpengine.com/wp-content/uploads/2023/05/image-1-1-1-1.jpg 602w, https://cfarchives.wpengine.com/wp-content/uploads/2023/05/image-1-1-1-1-170x130.jpg 170w, https://cfarchives.wpengine.com/wp-content/uploads/2023/05/image-1-1-1-1-80x61.jpg 80w, https://cfarchives.wpengine.com/wp-content/uploads/2023/05/image-1-1-1-1-400x306.jpg 400w, https://cfarchives.wpengine.com/wp-content/uploads/2023/05/image-1-1-1-1-600x458.jpg 600w">
                          </div>
                        </div>
                      </a>
                      <div class="text-align-center info ">
                        <div class="text__eyebrow color__gray format block-xxxs">FILM: 16MM</div>
                        <div class="title text__promo-4 block-xxxs">
                          <a href="https://cfarchives.wpengine.com/collection/item/o-lost/" class="color-link-orange">O Lost</a>
                        </div>
                        <div class="text__eyebrow year color__gray">1942</div>
                      </div>
                    </div>
                    <div class="item-item item">
                      <a href="https://cfarchives.wpengine.com/collection/item/no-peace-on-earth/">
                        <div class="overlay-image block-xxs">
                          <div class="img-wrapper " data-width="602" data-height="460">
                            <img src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-srcset="https://cfarchives.wpengine.com/wp-content/uploads/2023/05/image-1-1-1.jpg 602w, https://cfarchives.wpengine.com/wp-content/uploads/2023/05/image-1-1-1-170x130.jpg 170w, https://cfarchives.wpengine.com/wp-content/uploads/2023/05/image-1-1-1-80x61.jpg 80w, https://cfarchives.wpengine.com/wp-content/uploads/2023/05/image-1-1-1-400x306.jpg 400w, https://cfarchives.wpengine.com/wp-content/uploads/2023/05/image-1-1-1-600x458.jpg 600w" data-sizes="auto" alt="Image 1 1 1" class=" lazyload-persist lazyautosizes ls-is-cached lazyloaded " data-pin-nopin="true" draggable="false" sizes="200px" srcset="https://cfarchives.wpengine.com/wp-content/uploads/2023/05/image-1-1-1.jpg 602w, https://cfarchives.wpengine.com/wp-content/uploads/2023/05/image-1-1-1-170x130.jpg 170w, https://cfarchives.wpengine.com/wp-content/uploads/2023/05/image-1-1-1-80x61.jpg 80w, https://cfarchives.wpengine.com/wp-content/uploads/2023/05/image-1-1-1-400x306.jpg 400w, https://cfarchives.wpengine.com/wp-content/uploads/2023/05/image-1-1-1-600x458.jpg 600w">
                          </div>
                        </div>
                      </a>
                      <div class="text-align-center info ">
                        <div class="text__eyebrow color__gray format block-xxxs">FILM: 16MM</div>
                        <div class="title text__promo-4 block-xxxs">
                          <a href="https://cfarchives.wpengine.com/collection/item/no-peace-on-earth/" class="color-link-orange">No Peace on Earth</a>
                        </div>
                        <div class="text__eyebrow year color__gray">1945</div>
                      </div>
                    </div>
                    <div class="item-item item">
                      <a href="https://cfarchives.wpengine.com/collection/item/in-a-vacuum-2/">
                        <div class="overlay-image block-xxs">
                          <div class="img-wrapper " data-width="602" data-height="460">
                            <img src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-srcset="https://cfarchives.wpengine.com/wp-content/uploads/2023/05/image-1-1.jpg 602w, https://cfarchives.wpengine.com/wp-content/uploads/2023/05/image-1-1-170x130.jpg 170w, https://cfarchives.wpengine.com/wp-content/uploads/2023/05/image-1-1-80x61.jpg 80w, https://cfarchives.wpengine.com/wp-content/uploads/2023/05/image-1-1-400x306.jpg 400w, https://cfarchives.wpengine.com/wp-content/uploads/2023/05/image-1-1-600x458.jpg 600w" data-sizes="auto" alt="Image 1 1" class=" lazyload-persist lazyautosizes ls-is-cached lazyloaded " data-pin-nopin="true" draggable="false" sizes="200px" srcset="https://cfarchives.wpengine.com/wp-content/uploads/2023/05/image-1-1.jpg 602w, https://cfarchives.wpengine.com/wp-content/uploads/2023/05/image-1-1-170x130.jpg 170w, https://cfarchives.wpengine.com/wp-content/uploads/2023/05/image-1-1-80x61.jpg 80w, https://cfarchives.wpengine.com/wp-content/uploads/2023/05/image-1-1-400x306.jpg 400w, https://cfarchives.wpengine.com/wp-content/uploads/2023/05/image-1-1-600x458.jpg 600w">
                          </div>
                          <svg width="60" height="61" viewBox="0 0 60 61" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g clip-path="url(#clip0_1849_15820)">
                              <path d="M36.0897 25.6518C35.6295 25.1831 34.927 25.2091 34.491 25.6778C34.055 26.1726 34.0792 26.9278 34.5153 27.3965C35.2662 28.1778 35.6779 29.1934 35.6779 30.3131C35.6779 31.4329 35.2662 32.4485 34.5153 33.2297C34.055 33.6984 34.055 34.4797 34.491 34.9484C34.709 35.2088 35.0239 35.313 35.3146 35.313C35.6053 35.313 35.8717 35.2088 36.1139 34.9745C37.3009 33.7505 37.9549 32.0839 37.9549 30.2871C37.9306 28.5684 37.2766 26.9018 36.0897 25.6518Z" fill="white"></path>
                              <path d="M39.0936 22.546C38.6313 22.1047 37.9014 22.1307 37.4877 22.6498C37.0741 23.143 37.0984 23.9218 37.5851 24.363C39.2639 25.9724 40.2372 28.2827 40.2372 30.6968C40.2372 33.1109 39.2639 35.4212 37.5851 37.0306C37.1228 37.4719 37.0741 38.2506 37.4877 38.7438C37.7067 39.0034 38.023 39.1592 38.3393 39.1592C38.607 39.1592 38.8746 39.0553 39.0936 38.8477C41.2591 36.771 42.4999 33.8118 42.4999 30.6968C42.5243 27.5819 41.2834 24.6226 39.0936 22.546Z" fill="white"></path>
                              <path d="M29.9675 20.8506L22.6169 26.436H18.2273C17.8117 26.436 17.5 26.7801 17.5 27.1772V34.192C17.5 34.6155 17.8377 34.9332 18.2273 34.9332H22.6169L29.9675 40.545C30.461 40.9156 31.1364 40.5715 31.1364 39.9362V21.433C31.1364 20.8242 30.4351 20.48 29.9675 20.8506Z" fill="white"></path>
                              <path d="M30 59.6973C46.0163 59.6973 59 46.7136 59 30.6973C59 14.681 46.0163 1.6973 30 1.6973C13.9837 1.6973 1 14.681 1 30.6973C1 46.7136 13.9837 59.6973 30 59.6973Z" stroke="white" stroke-width="2"></path>
                            </g>
                            <defs>
                              <clipPath id="clip0_1849_15820">
                                <rect width="60" height="61" fill="white"></rect>
                              </clipPath>
                            </defs>
                          </svg>
                        </div>
                      </a>
                      <div class="text-align-center info ">
                        <div class="text__eyebrow color__gray format block-xxxs">AUDIO: MP3</div>
                        <div class="title text__promo-4 block-xxxs">
                          <a href="https://cfarchives.wpengine.com/collection/item/in-a-vacuum-2/" class="color-link-orange">In a Vacuum</a>
                        </div>
                        <div class="text__eyebrow year color__gray">1956</div>
                      </div>
                    </div>
                    <div class="item-item item">
                      <a href="https://cfarchives.wpengine.com/collection/item/in-a-vacuum/">
                        <div class="overlay-image block-xxs">
                          <div class="img-wrapper " data-width="602" data-height="460">
                            <img src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-srcset="https://cfarchives.wpengine.com/wp-content/uploads/2023/05/image-1.jpg 602w, https://cfarchives.wpengine.com/wp-content/uploads/2023/05/image-1-170x130.jpg 170w, https://cfarchives.wpengine.com/wp-content/uploads/2023/05/image-1-80x61.jpg 80w, https://cfarchives.wpengine.com/wp-content/uploads/2023/05/image-1-400x306.jpg 400w, https://cfarchives.wpengine.com/wp-content/uploads/2023/05/image-1-600x458.jpg 600w" data-sizes="auto" alt="Image 1" class=" lazyload-persist lazyautosizes ls-is-cached lazyloaded " data-pin-nopin="true" draggable="false" sizes="200px" srcset="https://cfarchives.wpengine.com/wp-content/uploads/2023/05/image-1.jpg 602w, https://cfarchives.wpengine.com/wp-content/uploads/2023/05/image-1-170x130.jpg 170w, https://cfarchives.wpengine.com/wp-content/uploads/2023/05/image-1-80x61.jpg 80w, https://cfarchives.wpengine.com/wp-content/uploads/2023/05/image-1-400x306.jpg 400w, https://cfarchives.wpengine.com/wp-content/uploads/2023/05/image-1-600x458.jpg 600w">
                          </div>
                        </div>
                      </a>
                      <div class="text-align-center info ">
                        <div class="text__eyebrow color__gray format block-xxxs">FILM: 16MM</div>
                        <div class="title text__promo-4 block-xxxs">
                          <a href="https://cfarchives.wpengine.com/collection/item/in-a-vacuum/" class="color-link-orange">In a Vacuum</a>
                        </div>
                        <div class="text__eyebrow year color__gray">1941</div>
                      </div>
                    </div>
                  </div>
                  <!-- grid -->
                </div>
                <!-- grid-next-container -->
                <div class="text-align-center">
                  <a href="#" class="button color-gray pill simple-toggle hide-toggle" data-toggle="grid-next-container" data-class-toggle="open">View More Items</a>
                </div>
              </div>
            </div>
            <!-- tab -->
            <div class="tab list-items" data-index="1">
              <div class="tab-int">
                <div class="legend text__body-4 color__gray">
                  <div class="">Items listed without links to media have not yet been cataloged. To request access please contact <a href="mailto:info@chicagofilmarchives.org">info@chicagofilmarchives.org</a>. </div>
                  <div>
                    <span class="viewable-media-icon">
                      <svg width="15" height="13" viewBox="0 0 15 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="0.5" y="0.5" width="14" height="12" rx="3.5" stroke="#BDBDBD"></rect>
                        <path d="M10 6.5L6 10L6 3L10 6.5Z" fill="#E26C2F"></path>
                      </svg>
                    </span>Items with Viewable Media
                  </div>
                </div>
                <ul class="list columns__text text__body-3" col-num="2">
                  <li>
                    <a href="https://cfarchives.wpengine.com/collection/item/cicero-march/" class="color-link-inverted-orange">Cicero March</a>
                    <span class="viewable-media-icon right">
                      <svg width="15" height="13" viewBox="0 0 15 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="0.5" y="0.5" width="14" height="12" rx="3.5" stroke="#BDBDBD"></rect>
                        <path d="M10 6.5L6 10L6 3L10 6.5Z" fill="#E26C2F"></path>
                      </svg>
                    </span>
                  </li>
                  <li>
                    <a href="https://cfarchives.wpengine.com/collection/item/salute-to-old-friends-agnes-de-mille-2/" class="color-link-inverted-orange">Salute to Old Friends: Agnes de Mille</a>
                    <span class="viewable-media-icon right">
                      <svg width="15" height="13" viewBox="0 0 15 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="0.5" y="0.5" width="14" height="12" rx="3.5" stroke="#BDBDBD"></rect>
                        <path d="M10 6.5L6 10L6 3L10 6.5Z" fill="#E26C2F"></path>
                      </svg>
                    </span>
                  </li>
                  <li>
                    <a href="https://cfarchives.wpengine.com/collection/item/salute-to-old-friends-agnes-de-mille/" class="color-link-inverted-orange">Salute to Old Friends: Agnes de Mille</a>
                    <span class="viewable-media-icon right">
                      <svg width="15" height="13" viewBox="0 0 15 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="0.5" y="0.5" width="14" height="12" rx="3.5" stroke="#BDBDBD"></rect>
                        <path d="M10 6.5L6 10L6 3L10 6.5Z" fill="#E26C2F"></path>
                      </svg>
                    </span>
                  </li>
                  <li>
                    <a href="https://cfarchives.wpengine.com/collection/item/popular-music-al-jolson-you-made-me-love-you/" class="color-link-inverted-orange">Popular Music: Al Jolson “You Made Me Love You”</a>
                    <span class="viewable-media-icon right">
                      <svg width="15" height="13" viewBox="0 0 15 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="0.5" y="0.5" width="14" height="12" rx="3.5" stroke="#BDBDBD"></rect>
                        <path d="M10 6.5L6 10L6 3L10 6.5Z" fill="#E26C2F"></path>
                      </svg>
                    </span>
                  </li>
                  <li>
                    <a href="https://cfarchives.wpengine.com/collection/item/o-lost/" class="color-link-inverted-orange">O Lost</a>
                    <span class="viewable-media-icon right">
                      <svg width="15" height="13" viewBox="0 0 15 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="0.5" y="0.5" width="14" height="12" rx="3.5" stroke="#BDBDBD"></rect>
                        <path d="M10 6.5L6 10L6 3L10 6.5Z" fill="#E26C2F"></path>
                      </svg>
                    </span>
                  </li>
                  <li>
                    <a href="https://cfarchives.wpengine.com/collection/item/no-peace-on-earth/" class="color-link-inverted-orange">No Peace on Earth</a>
                    <span class="viewable-media-icon right">
                      <svg width="15" height="13" viewBox="0 0 15 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="0.5" y="0.5" width="14" height="12" rx="3.5" stroke="#BDBDBD"></rect>
                        <path d="M10 6.5L6 10L6 3L10 6.5Z" fill="#E26C2F"></path>
                      </svg>
                    </span>
                  </li>
                  <li>
                    <a href="https://cfarchives.wpengine.com/collection/item/in-a-vacuum-2/" class="color-link-inverted-orange">In a Vacuum</a>
                    <span class="viewable-media-icon right">
                      <svg width="15" height="13" viewBox="0 0 15 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="0.5" y="0.5" width="14" height="12" rx="3.5" stroke="#BDBDBD"></rect>
                        <path d="M10 6.5L6 10L6 3L10 6.5Z" fill="#E26C2F"></path>
                      </svg>
                    </span>
                  </li>
                  <li>
                    <a href="https://cfarchives.wpengine.com/collection/item/in-a-vacuum/" class="color-link-inverted-orange">In a Vacuum</a>
                    <span class="viewable-media-icon right">
                      <svg width="15" height="13" viewBox="0 0 15 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="0.5" y="0.5" width="14" height="12" rx="3.5" stroke="#BDBDBD"></rect>
                        <path d="M10 6.5L6 10L6 3L10 6.5Z" fill="#E26C2F"></path>
                      </svg>
                    </span>
                  </li>
                </ul>
              </div>
            </div>
            <!-- tab -->
          </div>
          <!-- tabs-content -->
        </div>
      </div>
    </section>


    <section id="collection-details" class="collection-details">
      <div class="wrap">
        <div class="int">

          <div>*** We need a list of required metadata elements for this details section ***</div>

          <div class="layout columns__text" col-num="2">
            <div class="paragraph">
              <div class="text__eyebrow color__gray">Creators</div>
              <div class="text__body-3">

              </div>
            </div>
            <div class="paragraph">
              <div class="text__eyebrow color__gray">Custodial History</div>
              <div class="text__body-3">
                {{{<ifdef code="ca_collections.cfaCustodialHistory">^ca_collections.cfaCustodialHistory</ifdef>}}}
              </div>
            </div>
            <div class="paragraph">
              <div class="text__eyebrow color__gray">Related Materials</div>
              <div class="text__body-3">{{{<ifdef code="ca_collections.cfaRelatedMaterials">^ca_collections.cfaRelatedMaterials</ifdef>}}}</div>
            </div>
            <div class="paragraph">
              <div class="text__eyebrow color__gray">Related Collections</div>
              <div class="text__body-3">
                {{{<ifcount code="ca_collections" min="1">
                    <div class="unit">
                        <unit relativeTo="ca_collections" delimiter="<br/>"><l>^ca_collections.preferred_labels</l></unit>
                    </div>
                </ifcount>}}}
                <!-- SERIES II: Company Dances SERIES I: Solo Dances -->
                </div>
            </div>
            <div class="paragraph">
              <div class="text__eyebrow color__gray">Collection identifier</div>
              <div class="text__body-3">{{{<ifdef code="ca_collections.idno">^ca_collections.idno</ifdef>}}}</div>
            </div>
            <div class="paragraph">
              <div class="text__eyebrow color__gray">Language of Materials</div>
              <div class="text__body-3"></div>
            </div>
            <div class="paragraph">
              <div class="text__eyebrow color__gray">Extent of Collection</div>
              <div class="text__body-3">{{{<ifdef code="ca_collections.cfaCollectionExtent">^ca_collections.cfaCollectionExtent</ifdef>}}}</div>
            </div>
            <div class="paragraph">
              <div class="text__eyebrow color__gray">Subjects</div>
              <div class="text__body-3">
                <!-- {{{
                    <ifdef code="ca_list_items">
                        <div class="unit">
                            <unit relativeTo="ca_list_items" delimiter="<br/>">
                                ^ca_list_items
                            </unit>
                        </div>
                    </ifdef>
                }}} -->
              </div>
            </div>
            <div class="paragraph">
              <div class="text__eyebrow color__gray">Access Restriction</div>
              <div class="text__body-3">{{{<ifdef code="ca_collections.cfaAccessRestrictions">^ca_collections.cfaAccessRestrictions</ifdef>}}}</div>
            </div>
            <div class="paragraph">
              <div class="text__eyebrow color__gray">Use Restrictions</div>
              <div class="text__body-3">{{{<ifdef code="ca_collections.cfaUseRestrictions">^ca_collections.cfaUseRestrictions</ifdef>}}}</div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section class="section-slideshow-related ">
      <div class="wrap">
        <div class="line"></div>
      </div>
      <div class="int wrap-not-mobile">

        <div> This content is subject to change, Where are these going to be loaded from?</div>
        <h4 class="text-align-center text__headline-4 block-small ">Related Content</h4>


        <div class="slider-container module_slideshow slideshow-related manual-init slideshow-ctrl-init">
          <div class="slick-initialized slick-slider">
            <div class="slick-list draggable">

              <div class="slick-track" style="opacity: 1; width: 3213px; transform: translate3d(-945px, 0px, 0px);">
                <div class="slick-slide slick-cloned" data-slick-index="-5" id="" aria-hidden="true" style="width: 189px;" tabindex="-1">
                  <div>
                    <div class="sizer" style="width: 100%; display: inline-block;">
                      <div class="item-related item">
                        <a href="https://cfarchives.wpengine.com/calendar/event/5th-annual-cfa-media-mixer/" tabindex="-1">
                          <div class="img-wrapper block-xxs" data-width="2006" data-height="1475">
                            <img src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-srcset="https://cfarchives.wpengine.com/wp-content/uploads/2016/06/Media-Mixer-Logo_cropped.png 2006w, https://cfarchives.wpengine.com/wp-content/uploads/2016/06/Media-Mixer-Logo_cropped-1536x1129.png 1536w, https://cfarchives.wpengine.com/wp-content/uploads/2016/06/Media-Mixer-Logo_cropped-170x125.png 170w, https://cfarchives.wpengine.com/wp-content/uploads/2016/06/Media-Mixer-Logo_cropped-80x59.png 80w, https://cfarchives.wpengine.com/wp-content/uploads/2016/06/Media-Mixer-Logo_cropped-400x294.png 400w, https://cfarchives.wpengine.com/wp-content/uploads/2016/06/Media-Mixer-Logo_cropped-600x441.png 600w, https://cfarchives.wpengine.com/wp-content/uploads/2016/06/Media-Mixer-Logo_cropped-800x588.png 800w, https://cfarchives.wpengine.com/wp-content/uploads/2016/06/Media-Mixer-Logo_cropped-1200x882.png 1200w, https://cfarchives.wpengine.com/wp-content/uploads/2016/06/Media-Mixer-Logo_cropped-1600x1176.png 1600w" data-sizes="auto" alt="" class=" lazyload-persist lazyautosizes ls-is-cached lazyloaded " data-pin-nopin="true" draggable="false" sizes="169px" srcset="https://cfarchives.wpengine.com/wp-content/uploads/2016/06/Media-Mixer-Logo_cropped.png 2006w, https://cfarchives.wpengine.com/wp-content/uploads/2016/06/Media-Mixer-Logo_cropped-1536x1129.png 1536w, https://cfarchives.wpengine.com/wp-content/uploads/2016/06/Media-Mixer-Logo_cropped-170x125.png 170w, https://cfarchives.wpengine.com/wp-content/uploads/2016/06/Media-Mixer-Logo_cropped-80x59.png 80w, https://cfarchives.wpengine.com/wp-content/uploads/2016/06/Media-Mixer-Logo_cropped-400x294.png 400w, https://cfarchives.wpengine.com/wp-content/uploads/2016/06/Media-Mixer-Logo_cropped-600x441.png 600w, https://cfarchives.wpengine.com/wp-content/uploads/2016/06/Media-Mixer-Logo_cropped-800x588.png 800w, https://cfarchives.wpengine.com/wp-content/uploads/2016/06/Media-Mixer-Logo_cropped-1200x882.png 1200w, https://cfarchives.wpengine.com/wp-content/uploads/2016/06/Media-Mixer-Logo_cropped-1600x1176.png 1600w">
                          </div>
                        </a>
                        <div class="text-align-center info">
                          <div class="text__eyebrow color__gray block-xxxs">events</div>
                          <div class="title text__promo-4">
                            <a href="https://cfarchives.wpengine.com/calendar/event/5th-annual-cfa-media-mixer/" class="color-link-bright-blue" tabindex="-1">5th Annual CFA MEDIA MIXER</a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="slick-slide slick-cloned" data-slick-index="-4" id="" aria-hidden="true" style="width: 189px;" tabindex="-1">
                  <div>
                    <div class="sizer" style="width: 100%; display: inline-block;">
                      <div class="item-related item">
                        <a href="https://cfarchives.wpengine.com/news/2018/03/2007-interview-with-millie-goldsholl/" tabindex="-1">
                          <div class="img-wrapper block-xxs" data-width="602" data-height="461">
                            <img src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-srcset="https://cfarchives.wpengine.com/wp-content/uploads/2023/05/default.jpg 602w, https://cfarchives.wpengine.com/wp-content/uploads/2023/05/default-170x130.jpg 170w, https://cfarchives.wpengine.com/wp-content/uploads/2023/05/default-80x61.jpg 80w, https://cfarchives.wpengine.com/wp-content/uploads/2023/05/default-400x306.jpg 400w, https://cfarchives.wpengine.com/wp-content/uploads/2023/05/default-600x459.jpg 600w" data-sizes="auto" alt="Default" class=" lazyload-persist lazyautosizes ls-is-cached lazyloaded " data-pin-nopin="true" draggable="false" sizes="169px" srcset="https://cfarchives.wpengine.com/wp-content/uploads/2023/05/default.jpg 602w, https://cfarchives.wpengine.com/wp-content/uploads/2023/05/default-170x130.jpg 170w, https://cfarchives.wpengine.com/wp-content/uploads/2023/05/default-80x61.jpg 80w, https://cfarchives.wpengine.com/wp-content/uploads/2023/05/default-400x306.jpg 400w, https://cfarchives.wpengine.com/wp-content/uploads/2023/05/default-600x459.jpg 600w">
                          </div>
                        </a>
                        <div class="text-align-center info">
                          <div class="text__eyebrow color__gray block-xxxs">news</div>
                          <div class="title text__promo-4">
                            <a href="https://cfarchives.wpengine.com/news/2018/03/2007-interview-with-millie-goldsholl/" class="color-link-bright-blue" tabindex="-1">2007 Interview with Millie Goldsholl</a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="slick-slide slick-cloned" data-slick-index="-3" id="" aria-hidden="true" style="width: 189px;" tabindex="-1">
                  <div>
                    <div class="sizer" style="width: 100%; display: inline-block;">
                      <div class="item-related item">
                        <a href="https://cfarchives.wpengine.com/collection/view/the-morrison-shearer-collection/" tabindex="-1">
                          <div class="img-wrapper block-xxs" data-width="2560" data-height="1914">
                            <img src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-srcset="https://cfarchives.wpengine.com/wp-content/uploads/2023/05/Screen-Shot-2022-08-19-at-10.55.47-AM-scaled.jpg 2560w, https://cfarchives.wpengine.com/wp-content/uploads/2023/05/Screen-Shot-2022-08-19-at-10.55.47-AM-1536x1148.jpg 1536w, https://cfarchives.wpengine.com/wp-content/uploads/2023/05/Screen-Shot-2022-08-19-at-10.55.47-AM-2048x1531.jpg 2048w, https://cfarchives.wpengine.com/wp-content/uploads/2023/05/Screen-Shot-2022-08-19-at-10.55.47-AM-170x127.jpg 170w, https://cfarchives.wpengine.com/wp-content/uploads/2023/05/Screen-Shot-2022-08-19-at-10.55.47-AM-80x60.jpg 80w, https://cfarchives.wpengine.com/wp-content/uploads/2023/05/Screen-Shot-2022-08-19-at-10.55.47-AM-400x299.jpg 400w, https://cfarchives.wpengine.com/wp-content/uploads/2023/05/Screen-Shot-2022-08-19-at-10.55.47-AM-600x449.jpg 600w, https://cfarchives.wpengine.com/wp-content/uploads/2023/05/Screen-Shot-2022-08-19-at-10.55.47-AM-800x598.jpg 800w, https://cfarchives.wpengine.com/wp-content/uploads/2023/05/Screen-Shot-2022-08-19-at-10.55.47-AM-1200x897.jpg 1200w, https://cfarchives.wpengine.com/wp-content/uploads/2023/05/Screen-Shot-2022-08-19-at-10.55.47-AM-1600x1196.jpg 1600w, https://cfarchives.wpengine.com/wp-content/uploads/2023/05/Screen-Shot-2022-08-19-at-10.55.47-AM-2400x1794.jpg 2400w" data-sizes="auto" alt="Screen Shot 2022 08 19 At 10.55.47 AM" class=" lazyload-persist lazyautosizes ls-is-cached lazyloaded " data-pin-nopin="true" draggable="false" sizes="169px" srcset="https://cfarchives.wpengine.com/wp-content/uploads/2023/05/Screen-Shot-2022-08-19-at-10.55.47-AM-scaled.jpg 2560w, https://cfarchives.wpengine.com/wp-content/uploads/2023/05/Screen-Shot-2022-08-19-at-10.55.47-AM-1536x1148.jpg 1536w, https://cfarchives.wpengine.com/wp-content/uploads/2023/05/Screen-Shot-2022-08-19-at-10.55.47-AM-2048x1531.jpg 2048w, https://cfarchives.wpengine.com/wp-content/uploads/2023/05/Screen-Shot-2022-08-19-at-10.55.47-AM-170x127.jpg 170w, https://cfarchives.wpengine.com/wp-content/uploads/2023/05/Screen-Shot-2022-08-19-at-10.55.47-AM-80x60.jpg 80w, https://cfarchives.wpengine.com/wp-content/uploads/2023/05/Screen-Shot-2022-08-19-at-10.55.47-AM-400x299.jpg 400w, https://cfarchives.wpengine.com/wp-content/uploads/2023/05/Screen-Shot-2022-08-19-at-10.55.47-AM-600x449.jpg 600w, https://cfarchives.wpengine.com/wp-content/uploads/2023/05/Screen-Shot-2022-08-19-at-10.55.47-AM-800x598.jpg 800w, https://cfarchives.wpengine.com/wp-content/uploads/2023/05/Screen-Shot-2022-08-19-at-10.55.47-AM-1200x897.jpg 1200w, https://cfarchives.wpengine.com/wp-content/uploads/2023/05/Screen-Shot-2022-08-19-at-10.55.47-AM-1600x1196.jpg 1600w, https://cfarchives.wpengine.com/wp-content/uploads/2023/05/Screen-Shot-2022-08-19-at-10.55.47-AM-2400x1794.jpg 2400w">
                          </div>
                        </a>
                        <div class="text-align-center info">
                          <div class="text__eyebrow color__gray block-xxxs">collection</div>
                          <div class="title text__promo-4">
                            <a href="https://cfarchives.wpengine.com/collection/view/the-morrison-shearer-collection/" class="color-link-orange" tabindex="-1">The Morrison Shearer Collection</a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="slick-slide slick-cloned" data-slick-index="-2" id="" aria-hidden="true" style="width: 189px;" tabindex="-1">
                  <div>
                    <div class="sizer" style="width: 100%; display: inline-block;">
                      <div class="item-related item">
                        <a href="https://cfarchives.wpengine.com/exhibition/view/test-exhibition-2/" tabindex="-1">
                          <div class="img-wrapper block-xxs" data-width="464" data-height="355">
                            <img src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-srcset="https://cfarchives.wpengine.com/wp-content/uploads/2023/05/Image.jpg 464w, https://cfarchives.wpengine.com/wp-content/uploads/2023/05/Image-170x130.jpg 170w, https://cfarchives.wpengine.com/wp-content/uploads/2023/05/Image-80x61.jpg 80w, https://cfarchives.wpengine.com/wp-content/uploads/2023/05/Image-400x306.jpg 400w" data-sizes="auto" alt="Image" class=" lazyload-persist lazyautosizes ls-is-cached lazyloaded " data-pin-nopin="true" draggable="false" sizes="169px" srcset="https://cfarchives.wpengine.com/wp-content/uploads/2023/05/Image.jpg 464w, https://cfarchives.wpengine.com/wp-content/uploads/2023/05/Image-170x130.jpg 170w, https://cfarchives.wpengine.com/wp-content/uploads/2023/05/Image-80x61.jpg 80w, https://cfarchives.wpengine.com/wp-content/uploads/2023/05/Image-400x306.jpg 400w">
                          </div>
                        </a>
                        <div class="text-align-center info">
                          <div class="text__eyebrow color__gray block-xxxs">digital exhibitions</div>
                          <div class="title text__promo-4">
                            <a href="https://cfarchives.wpengine.com/exhibition/view/test-exhibition-2/" class="color-link-violet" tabindex="-1">Test Exhibition 2</a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="slick-slide slick-cloned" data-slick-index="-1" id="" aria-hidden="true" style="width: 189px;" tabindex="-1">
                  <div>
                    <div class="sizer" style="width: 100%; display: inline-block;">
                      <div class="item-related item">
                        <a href="https://cfarchives.wpengine.com/calendar/event/2017-benefit-with-joe-swanberg/" tabindex="-1">
                          <div class="img-wrapper block-xxs" data-width="771" data-height="386">
                            <img src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-srcset="https://cfarchives.wpengine.com/wp-content/uploads/2017/10/Eventbrite2017logo.jpg 771w, https://cfarchives.wpengine.com/wp-content/uploads/2017/10/Eventbrite2017logo-170x85.jpg 170w, https://cfarchives.wpengine.com/wp-content/uploads/2017/10/Eventbrite2017logo-80x40.jpg 80w, https://cfarchives.wpengine.com/wp-content/uploads/2017/10/Eventbrite2017logo-400x200.jpg 400w, https://cfarchives.wpengine.com/wp-content/uploads/2017/10/Eventbrite2017logo-600x300.jpg 600w" data-sizes="auto" alt="" class=" lazyload-persist lazyautosizes ls-is-cached lazyloaded " data-pin-nopin="true" draggable="false" sizes="169px" srcset="https://cfarchives.wpengine.com/wp-content/uploads/2017/10/Eventbrite2017logo.jpg 771w, https://cfarchives.wpengine.com/wp-content/uploads/2017/10/Eventbrite2017logo-170x85.jpg 170w, https://cfarchives.wpengine.com/wp-content/uploads/2017/10/Eventbrite2017logo-80x40.jpg 80w, https://cfarchives.wpengine.com/wp-content/uploads/2017/10/Eventbrite2017logo-400x200.jpg 400w, https://cfarchives.wpengine.com/wp-content/uploads/2017/10/Eventbrite2017logo-600x300.jpg 600w">
                          </div>
                        </a>
                        <div class="text-align-center info">
                          <div class="text__eyebrow color__gray block-xxxs">events</div>
                          <div class="title text__promo-4">
                            <a href="https://cfarchives.wpengine.com/calendar/event/2017-benefit-with-joe-swanberg/" class="color-link-bright-blue" tabindex="-1">2017 Benefit with Joe Swanberg</a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="slick-slide slick-current slick-active" data-slick-index="0" aria-hidden="false" style="width: 189px;">
                  <div>
                    <div class="sizer" style="width: 100%; display: inline-block;">
                      <div class="item-related item">
                        <a href="https://cfarchives.wpengine.com/news/2020/08/the-first-degree/" tabindex="0">
                          <div class="img-wrapper block-xxs" data-width="468" data-height="340">
                            <img src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" data-srcset="https://cfarchives.wpengine.com/wp-content/uploads/2020/08/FirstDegree-e1596223509383.png 468w, https://cfarchives.wpengine.com/wp-content/uploads/2020/08/FirstDegree-e1596223509383-170x124.png 170w, https://cfarchives.wpengine.com/wp-content/uploads/2020/08/FirstDegree-e1596223509383-80x58.png 80w, https://cfarchives.wpengine.com/wp-content/uploads/2020/08/FirstDegree-e1596223509383-400x291.png 400w" data-sizes="auto" alt="" class=" lazyload-persist lazyautosizes ls-is-cached lazyloaded " data-pin-nopin="true" draggable="false" sizes="169px" srcset="https://cfarchives.wpengine.com/wp-content/uploads/2020/08/FirstDegree-e1596223509383.png 468w, https://cfarchives.wpengine.com/wp-content/uploads/2020/08/FirstDegree-e1596223509383-170x124.png 170w, https://cfarchives.wpengine.com/wp-content/uploads/2020/08/FirstDegree-e1596223509383-80x58.png 80w, https://cfarchives.wpengine.com/wp-content/uploads/2020/08/FirstDegree-e1596223509383-400x291.png 400w">
                          </div>
                        </a>
                        <div class="text-align-center info">
                          <div class="text__eyebrow color__gray block-xxxs">news</div>
                          <div class="title text__promo-4">
                            <a href="https://cfarchives.wpengine.com/news/2020/08/the-first-degree/" class="color-link-bright-blue" tabindex="0">‘Lost’ Film From 1923 Uncovered in CFA Collection</a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="arrows">
            <div class="arrow arrow-left left reveal slick-arrow" style="visibility: visible;">
              <svg width="31" height="30" viewBox="0 0 31 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g opacity="0.5" class="color-opacity">
                  <circle cx="15.373" cy="15" r="14.5" transform="rotate(-180 15.373 15)" stroke="#222222" class="color-stroke"></circle>
                  <g clip-path="url(#clip0_854_22844)">
                    <path d="M16.0647 14.9999L18.459 18.9999L11.2866 14.9999L18.459 10.9999L16.0647 14.9999Z" fill="#222222" class="color-fill"></path>
                  </g>
                </g>
                <defs>
                  <clipPath id="clip0_854_22844">
                    <rect width="7.17241" height="8" fill="white" transform="translate(18.459 18.9999) rotate(-180)"></rect>
                  </clipPath>
                </defs>
              </svg>
            </div>
            <div class="arrow arrow-right right slick-arrow" style="visibility: visible;">
              <svg width="31" height="30" viewBox="0 0 31 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g opacity="0.5" class="color-opacity">
                  <circle cx="15.373" cy="15" r="14.5" stroke="#222222" class="color-stroke"></circle>
                  <g clip-path="url(#clip0_854_22839)">
                    <path d="M14.6813 15L12.2871 11L19.4595 15L12.2871 19L14.6813 15Z" fill="#222222" class="color-fill"></path>
                  </g>
                </g>
                <defs>
                  <clipPath id="clip0_854_22839">
                    <rect width="7.17241" height="8" fill="white" transform="translate(12.2871 11)"></rect>
                  </clipPath>
                </defs>
              </svg>
            </div>
          </div>

        </div>
      </div>
    </section>
    
  </main>
</div>
<!-- end row -->
