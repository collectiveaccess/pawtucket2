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

$media = $t_item->get('ca_object_representations.media.large', ['returnAsArray' => true]);
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
            <div id="carouselIndicators" class="carousel slide collection-carousel" data-bs-interval="false">
              <div class="carousel-inner">
<?php
	$active = true;
	foreach($media as $m) {
?>
                <div class="carousel-item <?= ($active ? 'active' : ''); ?>" style="height: auto;">
                  <?= $m; ?>
                </div>
<?php
		$active = false;
	}
?>
              </div>
              <div class="carousel-indicators collection-indicators">
<?php
	$active = true;
	$index = 0;
	foreach($media as $m) {
?>
                <button type="button" data-bs-target="#carouselIndicators" data-bs-slide-to="<?= $index; ?>" class="<?= ($active ? 'active' : ''); ?>" <?= ($active ? 'aria-current="true"' : ''); ?> aria-label="Media <?= $index+ 1; ?>"></button>
<?php
		$index++;
		$active = false;
	}
?>
              </div>
            </div>
            
        </div>

        <div class="item">
          <!-- <div class="container-scroll" style="height: 398.305px;"> -->
          <div class="container-scroll" style="overflow-y: auto;">
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
          <div class="footer link mt-2">
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

    <!-- <div id="carouselIndicators" class="carousel slide m-5 bg-light border collection-carousel" data-bs-interval="false" style="width: 800px; height: 600px;">
      <div class="carousel-indicators">
        <button type="button" data-bs-target="#carouselIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#carouselIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
        <button type="button" data-bs-target="#carouselIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
      </div>
      <div class="carousel-inner">
        <div class="carousel-item active">
          {{{<l>^ca_object_representations.media.large<l>}}}
        </div>
        <div class="carousel-item">
          <img src="cfa_logo.png" class="d-block w-100" width="500" height="600" alt="..." />
        </div>
        <div class="carousel-item">
          <img src="hero_1.jpg" class="d-block w-100" width="500" height="600" alt="..." />
        </div>
      </div>
    </div> -->

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
                        <unit relativeTo="ca_collections.children" delimiter="<br><br>" restrictToTypes="series" sort="ca_collections.idno_sort">
                          <ifdef code="ca_object_representations.media.thumbnail">^ca_object_representations.media.thumbnail</ifdef>
                          <span class="fw-bold" style="font-size: 15px;"><l>^ca_collections.preferred_labels</l></span>
                          <ifdef code="ca_collections.cfaInclusiveDates"><div class="text__eyebrow year color__gray">^ca_collections.cfaInclusiveDates</div></ifdef>
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

<?php
	$access_values = caGetUserAccessValues($this->request);
	if($t_item->getRelatedItems('ca_objects', ['checkAccess' => $access_values, 'returnAs' => 'count']) > 0) {
		$qr_objects = $t_item->getRelatedItems('ca_objects', ['returnAs' => 'searchResult', 'checkAccess' => $access_values]);
		$item_count = $qr_objects->numHits();
		$viewable_count = 0;
		
		while($qr_objects->nextHit()) {
			if($qr_objects->get('ca_object_representations.representation_id', ['checkAccess' => $access_values])) {
				$viewable_count++;
			}
		}
?>
    <section class="collection-grid-items">
      <div class="wrap">
        <div class="int module-tabs">

          <div class="header">
            <h4 class="text-align-center text__headline-4 title">Collection Items</h4>
            <div class="filters">

            	<ul class="nav nav-tabs" id="myTab" role="tablist" style="border: none;">
                <li class="nav-item" role="presentation">
                  <button class="nav-link active" id="itemGrid-tab" data-bs-toggle="tab" data-bs-target="#itemGrid-tab-pane" type="button" role="tab" aria-controls="itemGrid-tab-pane" aria-selected="true">
                    <span class="title text__eyebrow">Viewable Media (<?= $viewable_count; ?>)</span>
                    <span class="mb-2 info-icon collections-info" data-toggle="tooltip" title="What is Viewable Media?">
                      <div class="trigger-icon color-icon-orange">
                        <svg width="15" height="16" viewBox="0 0 15 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <path d="M7.5 0.5C3.36 0.5 0 3.86 0 8C0 12.14 3.36 15.5 7.5 15.5C11.64 15.5 15 12.14 15 8C15 3.86 11.64 0.5 7.5 0.5ZM7.5 1.65385C11.0031 1.65385 13.8462 4.49692 13.8462 8C13.8462 11.5031 11.0031 14.3462 7.5 14.3462C3.99692 14.3462 1.15385 11.5031 1.15385 8C1.15385 4.49692 3.99692 1.65385 7.5 1.65385Z" fill="#767676" class="color-fill"></path>
                          <path d="M8.65374 4.68281C8.65374 5.02709 8.51698 5.35727 8.27355 5.60071C8.03012 5.84415 7.69995 5.98092 7.35568 5.98092C7.01141 5.98092 6.68125 5.84415 6.43781 5.60071C6.19438 5.35727 6.05762 5.02709 6.05762 4.68281C6.05762 4.33854 6.19438 4.00836 6.43781 3.76492C6.68125 3.52148 7.01141 3.38471 7.35568 3.38471C7.69995 3.38471 8.03012 3.52148 8.27355 3.76492C8.51698 4.00836 8.65374 4.33854 8.65374 4.68281Z" fill="#767676" class="color-fill"></path>
                          <path d="M8.73065 11.5724C8.72269 11.8874 8.87038 11.9762 9.22992 12.0131L9.80777 12.0247V12.6154H5.29934V12.0247L5.93431 12.0131C6.31404 12.0016 6.40531 11.8539 6.43358 11.5724V8.01701C6.43761 7.45405 5.70711 7.54244 5.19238 7.55917V6.97371L8.73065 6.84621" fill="#767676" class="color-fill"></path>
                        </svg>
                      </div>
                    </span>
                  </button>
                </li>
                <li class="mt-2" style="color: #767676;"> | </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link" id="itemList-tab" data-bs-toggle="tab" data-bs-target="#itemList-tab-pane" type="button" role="tab" aria-controls="itemList-tab-pane" aria-selected="false">
                    <span class="title text__eyebrow">Item List (<?= $item_count; ?>)</span>
                  </button>
                </li>
				      </ul>

              <a href="/Search/advanced/collections" class="text__eyebrow color-class-orange $color__dark_gray">
                Advanced Collections Search 
                <span class="arrow-link">
                  <svg width="10" height="12" viewBox="0 0 10 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M3.62909 5.99999L0.436768 0.666656L9.99999 5.99999L0.436768 11.3333L3.62909 5.99999Z" fill="#767676" class="color-fill"></path>
                  </svg>
                </span>
              </a>

            </div>
          </div>

          <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="itemGrid-tab-pane" role="tabpanel" aria-labelledby="itemGrid-tab" tabindex="0">
              <div class="tab-int">
                <div class="grid-flex grid-1-3-4 margin-bottom collection-grid" id="expando-grid">

                  {{{<ifcount code="ca_objects" min="1">
                      <unit relativeTo="ca_objects" delimiter="" filter="/<img/">
                        <div class="item-item item">
                          <ifdef code="ca_object_representations.media.small">
                            <div class="collItemImg"><l>^ca_object_representations.media.large<l></div>
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

                  {{{<ifcount code="ca_collections.children" min="1">
                      <unit relativeTo="ca_collections.children" delimiter="" restrictToTypes="series" sort="ca_collections.idno_sort">
                        <ifcount code="ca_objects" min="1">
                          <unit relativeTo="ca_objects" delimiter="">
                            <div class="item-item item">

                              <ifdef code="ca_object_representations.media.small">
                                <div class="collItemImg"><l>^ca_object_representations.media.large<l></div>
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
                        </ifcount>
                      </unit>
                  </ifcount>}}}

                </div>
<?php 
	if($item_count > 4) {
?>
                <!-- Remove this button if there is 4 or less viewable items -->
                <div class="text-align-center">
                  <!-- <a href="" class="button color-gray pill simple-toggle hide-toggle view-more-btn" data-toggle="grid-next-container" data-class-toggle="open">View More Items</a> -->
                  <span class="button color-gray pill view-more-btn">View More Items</span>
                </div>
<?php
	}
?>
              </div>
            </div> <!-- tab-pane -->
            <div class="tab-pane fade" id="itemList-tab-pane" role="tabpanel" aria-labelledby="itemList-tab" tabindex="0">
              <ul class="list columns__text text__body-3" col-num="2" style="list-style-type: none;">

                {{{<ifcount code="ca_collections.children" min="1">
                  <div class="unit">
                    <unit relativeTo="ca_collections.children" delimiter="" restrictToTypes="series" sort="ca_collections.idno_sort">
                      <ifcount code="ca_objects" min="1">
                        <span class="fw-bold"><l>^ca_collections.preferred_labels</l></span>
                        <unit relativeTo="ca_objects" delimiter="">
                          <li>
                            <span class="link-orange"><l>^ca_objects.preferred_labels</l></span>
                            <if rule="^ca_objects.type_id =~ /audio/ AND ^ca_objects.type_id =~ /manu/"><small class="color__gray">(^ca_objects.type_id)</small></if>
                            <ifdef code="ca_object_representations.media.small">
                              <span class="viewable-media-icon right">
                                <svg width="15" height="13" viewBox="0 0 15 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect x="0.5" y="0.5" width="14" height="12" rx="3.5" stroke="#BDBDBD"></rect>
                                <path d="M10 6.5L6 10L6 3L10 6.5Z" fill="#E26C2F"></path>
                                </svg>
                              </span>
                            </ifdef>
                          </li>
                        </unit><br>
                      </ifcount>
                    </unit>
                  </div>
                </ifcount>}}}

                {{{<ifcount code="ca_objects" min="1">
                  <unit relativeTo="ca_objects" delimiter="">
                    <li>
                      <span class="link-orange"><l>^ca_objects.preferred_labels</l></span>
                      <if rule="^ca_objects.type_id =~ /audio/ AND ^ca_objects.type_id =~ /manu/"><small class="color__gray">(^ca_objects.type_id)</small></if>
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
            </div> <!-- tab-pane -->
          </div><!-- tab-content -->
        </div>
      </div><!-- wrap -->
    </section>
<?php
	}
?>

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

            {{{<ifdef code="ca_list_items">
                <div class="paragraph">
                  <div class="text__eyebrow color__gray">
                    Subject
                    <span class="mb-2 info-icon collections-info" data-toggle="tooltip" title="Subjects">
                      <div class="trigger-icon color-icon-orange">
                        <svg width="15" height="16" viewBox="0 0 15 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <path d="M7.5 0.5C3.36 0.5 0 3.86 0 8C0 12.14 3.36 15.5 7.5 15.5C11.64 15.5 15 12.14 15 8C15 3.86 11.64 0.5 7.5 0.5ZM7.5 1.65385C11.0031 1.65385 13.8462 4.49692 13.8462 8C13.8462 11.5031 11.0031 14.3462 7.5 14.3462C3.99692 14.3462 1.15385 11.5031 1.15385 8C1.15385 4.49692 3.99692 1.65385 7.5 1.65385Z" fill="#767676" class="color-fill"></path>
                          <path d="M8.65374 4.68281C8.65374 5.02709 8.51698 5.35727 8.27355 5.60071C8.03012 5.84415 7.69995 5.98092 7.35568 5.98092C7.01141 5.98092 6.68125 5.84415 6.43781 5.60071C6.19438 5.35727 6.05762 5.02709 6.05762 4.68281C6.05762 4.33854 6.19438 4.00836 6.43781 3.76492C6.68125 3.52148 7.01141 3.38471 7.35568 3.38471C7.69995 3.38471 8.03012 3.52148 8.27355 3.76492C8.51698 4.00836 8.65374 4.33854 8.65374 4.68281Z" fill="#767676" class="color-fill"></path>
                          <path d="M8.73065 11.5724C8.72269 11.8874 8.87038 11.9762 9.22992 12.0131L9.80777 12.0247V12.6154H5.29934V12.0247L5.93431 12.0131C6.31404 12.0016 6.40531 11.8539 6.43358 11.5724V8.01701C6.43761 7.45405 5.70711 7.54244 5.19238 7.55917V6.97371L8.73065 6.84621" fill="#767676" class="color-fill"></path>
                        </svg>
                      </div>
                    </span>
                  </div>

                  <div class="text__body-3">
                    <div class="unit">
                      <unit relativeTo="ca_list_items" delimiter="<br/>">
                        <a href="/Search/objects/search/^ca_list_items.preferred_labels.name_plural"><span class="link-orange">^ca_list_items.preferred_labels.name_plural</span></a>
                      </unit>
                    </div>
                  </div>
                </div>
            </ifdef>}}}

            {{{<ifcount code="ca_entities" min="1">
                <div class="paragraph">
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
                </div>
            </ifcount>}}}

            {{{<ifcount code="ca_collections" min="1">
                <div class="paragraph">
                  <div class="text__eyebrow color__gray">Related Collections</div>
                  <div class="text__body-3">
                    <div class="unit">
                        <unit relativeTo="ca_collections.related" delimiter="<br/>"><l>^ca_collections.preferred_labels</l></unit>
                    </div>
                  </div>
                </div>
            </ifcount>}}}

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

<script>
  $(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();

    $(".view-more-btn").click(function(){
    	let h = jQuery("#expando-grid").prop('scrollHeight');
      	$("#expando-grid").animate({height: h}, 500);
      	$(".view-more-btn").css("display", "none");
    });
  });
</script>
<!-- end row -->