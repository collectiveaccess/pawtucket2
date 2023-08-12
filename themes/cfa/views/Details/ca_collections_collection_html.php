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
          <div class="slider-container module_slideshow slideshow-single-collection over-black autoplay fade-captions slideshow-ctrl-init">
            <div class="dots-white dots-centered 1 slick-initialized slick-slider slick-dotted">
              <div class="slick-list draggable">
                <div class="slick-track" style="opacity: 1; width: 1677px;">
                  {{{representationViewer}}}
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
              <li class="" style="opacity: 1;">{{{^ca_object_representations.caption}}}</li>
            </ul>

          </div>
        </div>

        <div class="item">
          <div class="container-scroll" style="height: 398.305px;">
            <div class="content-scroll">
              <div class="size-column">

                <?php
                  $metadata = array(
                    "ca_collections.cfaInclusiveDates" => "Inclusive Dates",
                    "ca_collections.cfaBulkDates" => "Bulk Dates",
                    "ca_collections.cfaPreservationSponsor" => "Preservation Sponsors",
                    "ca_collections.cfaAbstract" => "Abstract",
                    "ca_collections.cfaDescription" => "Description",
                  );
                  foreach($metadata as $field => $fieldLabel){
                ?>
                    {{{
                      <ifdef code="<?php print $field; ?>">
                        <div class="max__640 text__eyebrow color__light_gray block-xxxs"><?php print $fieldLabel; ?></div>
                        <div class="max__640 text__body-3 color__white block-sm">^<?php print $field; ?></div>
                      </ifdef>
                    }}}
                <?php
                  }
                ?>

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

    {{{<ifcount code="ca_collections.children" min="1">

      <section class="collection-grid-items">
        <div class="wrap">
          <div class="int module-tabs">
            <div class="header">
              <h4 class="text-align-center text__headline-4 title">Series In this Collection</h4>
              <div class="row mt-3">
                <div class="col-6">
                  <ifcount code="ca_collections.children" min="1">
                      <div class="unit">
                        <unit relativeTo="ca_collections.children" delimiter="<br/>" restrictToTypes="series" sort="ca_collections.idno_sort">
                          ^ca_object_representations.media.thumbnail  
                          <l>^ca_collections.preferred_labels</l>
                          <div class="text__eyebrow year color__gray">^ca_collections.cfaInclusiveDates</div>
                         
                        </unit>
                      </div>
                  </ifcount>
  
                </div>
                <div class="col-6"> 
                  <div class="paragraph">
                    <ifdef code="ca_collections.cfaIntellectualArrangement">
                        <div class="text__eyebrow color__gray">Intellectual organization and arrangement</div>
                        <div class="text__body-3">
                          <div class="unit">
                              ^ca_collections.cfaIntellectualArrangement
                          </div>
                        </div>
                    </ifdef>
                  </div>
                </div>
              </div>
  
            </div>
          </div>
        </div>
      </section>

    </ifcount>}}}

    <section class="collection-grid-items">
      <div class="wrap">
        <div class="int module-tabs">
          <div class="header">

            <h4 class="text-align-center text__headline-4 title">Collection Items</h4>
            <div class="filters">
            	<ul class="nav nav-tabs" id="myTab" role="tablist">
				  <li class="nav-item" role="presentation">
					<button class="nav-link active" id="itemGrid-tab" data-bs-toggle="tab" data-bs-target="#itemGrid-tab-pane" type="button" role="tab" aria-controls="itemGrid-tab-pane" aria-selected="true">Viewable items</button>
				  </li>
				  <li class="nav-item" role="presentation">
					<button class="nav-link" id="itemList-tab" data-bs-toggle="tab" data-bs-target="#itemList-tab-pane" type="button" role="tab" aria-controls="itemList-tab-pane" aria-selected="false">Item list</button>
				  </li>
				</ul>
            </div>
          </div>

			<div class="tab-content" id="myTabContent">
  				<div class="tab-pane fade show active" id="itemGrid-tab-pane" role="tabpanel" aria-labelledby="itemGrid-tab" tabindex="0">
					<div class="tab-int">
               		 <div class="grid-flex grid-1-3-4 margin-bottom">
					{{{<ifcount code="ca_objects" min="1">
						  <unit relativeTo="ca_objects" delimiter="">
							<div class="item-item item">
							  <ifdef code="ca_object_representations.media.small">
								<div class="collItemImg"><l>^ca_object_representations.media.small<l></div>
							  </ifdef>
							  <ifnotdef code="ca_object_representations.media.small">
								<div class="collItemImgPlaceholder"><a></a></div>
							  </ifnotdef>
							  <div class="text-align-center info ">
								<div class="text__eyebrow color__gray format block-xxxs">^ca_objects.type_id</div>
								<div class="title text__promo-4 block-xxxs"><a href="" class="color-link-orange"><l>^ca_objects.preferred_labels<l></a></div>
								<div class="text__eyebrow year color__gray">^ca_occurrences.cfaDateProduced</div>
							  </div>
							</div>
						  </unit>
					   </ifcount>}}}
					</div>
					</div>
  				</div>
 				<div class="tab-pane fade" id="itemList-tab-pane" role="tabpanel" aria-labelledby="itemList-tab" tabindex="0">
 					<ul class="list columns__text text__body-3" col-num="2">
				{{{<ifcount code="ca_objects" min="1">
						  <unit relativeTo="ca_objects" delimiter="">

							<li>
							  <a href="" class="color-link-inverted-orange"><l>^ca_objects.preferred_labels</l></a>
							  <small class="color__gray">(^relationship_typename)</small>
							  <ifdef code="ca_object_representations.media.small">
								<span class="viewable-media-icon right">
								  <svg width="15" height="13" viewBox="0 0 15 13" fill="none" xmlns="http://www.w3.org/2000/svg">
									<rect x="0.5" y="0.5" width="14" height="12" rx="3.5" stroke="#BDBDBD"></rect>
									<path d="M10 6.5L6 10L6 3L10 6.5Z" fill="#E26C2F"></path>
								  </svg>
								</span>
							  </ifdef>
							</li>

						  </unit>
					   </ifcount>}}}
					   </ul>
  				</div>
			</div>
        </div>
      </div>
    </section>


    <section id="collection-details" class="collection-details">
      <div class="wrap">
        <div class="int">

          <div class="layout columns__text" col-num="2">

          	<?php
							$metadata = array(
								"ca_collections.cfaCustodialHistory" => "Custodial History",
								"ca_collections.cfaRelatedMaterials" => "Related Materials",
								"ca_collections.idno" => "Collection identifier",
								"ca_collections.cfaLanguageMaterials" => "Language Of Materials",	
								"ca_collections.cfaCollectionExtent" => "Extent of Collection",
								"ca_list_items" => "Subject",	
								"ca_collections.cfaAccessRestrictions" => "Access Restrictions",
								"ca_collections.cfaUseRestrictions" => "Use Restrictions",
							);
							foreach($metadata as $field => $fieldLabel){
						?>
								{{{<ifdef code="<?php print $field; ?>">
                  <div class="paragraph">
                    <div class="text__eyebrow color__gray"><?php print $fieldLabel; ?></div>
                    <div class="text__body-3"><unit delimiter="<br/>">^<?php print $field; ?></unit></div>
                  </div>
								</ifdef>}}}
						<?php
							}
						?>

           {{{<ifcount code="ca_collections.children" min="0" max="0">
              <div class="paragraph">
                  <ifdef code="ca_collections.cfaIntellectualArrangement">
                      <div class="text__eyebrow color__gray">Intellectual organization and arrangement</div>
                      <div class="text__body-3">
                        <div class="unit">
                            ^ca_collections.cfaIntellectualArrangement
                        </div>
                      </div>
                  </ifdef>
                </div>
            </ifcount>}}}

            <div class="paragraph">
              {{{<ifcount code="ca_entities" min="1">
                  <div class="text__eyebrow color__gray">Creators</div>
                  <div class="text__body-3">
                    <div class="unit">
                        <unit relativeTo="ca_entities" restrictToRelationshipTypes="creator,complier,source" delimiter="<br/><br/>">
                          <strong><l>^ca_entities.preferred_labels (^relationship_typename)</l></strong>
                          <br/>
                          ^ca_entities.biography%truncate=250%ellipsis
                        </unit>
                    </div>
                  </div>
                </ifcount>}}}
            </div>

            <div class="paragraph">
              {{{<ifcount code="ca_collections" min="1">
                  <div class="text__eyebrow color__gray">Related Collections</div>
                  <div class="text__body-3">
                    <div class="unit">
                        <unit relativeTo="ca_collections.related" delimiter="<br/>"><l>^ca_collections.preferred_labels</l></unit>
                    </div>
                  </div>
              </ifcount>}}}
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

        <h4 class="text-align-center text__headline-4 block-small ">Related Content</h4>


        <div class="slider-container module_slideshow slideshow-related manual-init slideshow-ctrl-init">
          <div class="slick-initialized slick-slider">
            <div class="slick-list draggable">

              <div class="slick-track" style="opacity: 1; width: 3213px;">
                
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
