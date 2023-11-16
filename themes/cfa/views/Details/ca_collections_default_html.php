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

MetaTagManager::setWindowTitle($t_item->get('ca_collections.preferred_labels').": ".$t_item->get('ca_collections.type_id', ['convertCodesToDisplayText' => true]).": Chicago Film Archives");

MetaTagManager::addMeta("search-title", $t_item->get('ca_collections.preferred_labels'));
MetaTagManager::addMeta("search-eyebrow", 'Collections');
MetaTagManager::addMeta("search-group", 'Collections');
MetaTagManager::addMeta("search-thumbnail", $t_item->get('ca_object_representations.media.small.url'));
MetaTagManager::addMeta("search-access", ($t_item->get('ca_collections.access') == 2) ? 'restricted' : 'public');

MetaTagManager::addMeta("og:title", $t_item->get('ca_collections.preferred_labels'));
MetaTagManager::addMeta("og:description", $t_item->get('ca_collections.cfaAbstract'));
MetaTagManager::addMeta("og:url", caNavUrl($this->request, '*', '*', '*', [], ['absolute' => true]));
MetaTagManager::addMeta("og:image", $t_item->get('ca_object_representations.media.large.url'));
MetaTagManager::addMeta("og:image:width", $t_item->get('ca_object_representations.media.large.width'));
MetaTagManager::addMeta("og:image:height", $t_item->get('ca_object_representations.media.large.height'));

#--- get collections configuration
$o_collections_config = caGetCollectionsConfig();
$vb_show_hierarchy_viewer = true;
if($o_collections_config->get("do_not_display_collection_browser")){
	$vb_show_hierarchy_viewer = false;	
}
# --- get the collection hierarchy parent to use for exportin finding aid
$vn_top_level_collection_id = array_shift($t_item->get('ca_collections.hierarchy.collection_id', array("returnWithStructure" => true)));

// only pulling media that has access yes
$media = $t_item->get('ca_object_representations.media.large', ['returnAsArray' => true, 'checkAccess' => [1]]);
?>
<div class="row">
  <main class="flush">

    <section class="hero-single-collection ">
      <div class="wrap">
        <div class="eyebrow text__eyebrow color__gray"></div>
        <h1 class="text-align-center color__white text__headline-1 block-sm"> {{{^ca_collections.preferred_labels}}} </h1>
        <div class="layout grid-flex">
          <div class="item color__white">

            <div class="slider-container module_slideshow slideshow-single-collection over-black autoplay fade-captions">
              <div class="slick-slider dots-white dots-centered">
                <!-- slide -->
                <div class="slide-wrap">
                  <div class="image-sizer ">
                    <div class="img-wrapper rounded">
                      <?php
                        $active = true;
                        foreach($media as $m) {
                      ?>
                          <?= $m; ?>
                      <?php
                          $active = false;
                        }
                      ?>
                    </div>
                  </div>
                </div>
                <!-- slide -->
              </div>

              <ul class="captions text__caption img-caption">
                {{{<ifdef code="ca_object_representations.caption">
                  <li class="color__gray text-start">^ca_object_representations.caption</li>
                </ifdef>}}}
              </ul>
            </div>
    
          </div><!-- item -->

          <div class="item collection-data-links">
            <div class="container-scroll" >
              <div class="content-scroll">
                  {{{
                    <case>
                      <if rule="^access = 'restricted'">
                        <div class="size-column">
                          <ifdef code="ca_collections.cfaInclusiveDates">
                            <div class="max__640 text__eyebrow color__light_gray block-xxxs">Inclusive Dates</div>
                            <div class="max__640 text__body-3 color__white block-sm">^ca_collections.cfaInclusiveDates</div>
                          </ifdef>

                          <ifdef code="ca_collections.cfaAbstract">
                            <div class="max__640 text__eyebrow color__light_gray block-xxxs">Abstract</div>
                            <div class="max__640 text__body-3 color__white block-sm">^ca_collections.cfaAbstract</div>
                          </ifdef>

                          <ifdef code="ca_collections.idno">
                            <div class="max__640 text__eyebrow color__light_gray block-xxxs">Collection Identifier</div>
                            <div class="max__640 text__body-3 color__white block-sm">^ca_collections.idno</div>
                          </ifdef>

                          <ifdef code="ca_collections.cfaCollectionExtent">
                            <div class="max__640 text__eyebrow color__light_gray block-xxxs">Extent of Collection</div>
                            <div class="max__640 text__body-3 color__white block-sm">^ca_collections.cfaCollectionExtent</div>
                          </ifdef>

                          <ifdef code="ca_collections.cfaBulkDates">
                            <div class="max__640 text__eyebrow color__light_gray block-xxxs">
                              Bulk Dates
                              <span class="mb-2 info-icon collections-info" data-toggle="tooltip" title="Bulk dates indicate the chronological or period strength of a collection, especially when the inclusive dates may be misleading.">
                                <div class="trigger-icon color-icon-orange">
                                  <svg width="15" height="16" viewBox="0 0 15 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M7.5 0.5C3.36 0.5 0 3.86 0 8C0 12.14 3.36 15.5 7.5 15.5C11.64 15.5 15 12.14 15 8C15 3.86 11.64 0.5 7.5 0.5ZM7.5 1.65385C11.0031 1.65385 13.8462 4.49692 13.8462 8C13.8462 11.5031 11.0031 14.3462 7.5 14.3462C3.99692 14.3462 1.15385 11.5031 1.15385 8C1.15385 4.49692 3.99692 1.65385 7.5 1.65385Z" fill="#767676" class="color-fill"></path>
                                    <path d="M8.65374 4.68281C8.65374 5.02709 8.51698 5.35727 8.27355 5.60071C8.03012 5.84415 7.69995 5.98092 7.35568 5.98092C7.01141 5.98092 6.68125 5.84415 6.43781 5.60071C6.19438 5.35727 6.05762 5.02709 6.05762 4.68281C6.05762 4.33854 6.19438 4.00836 6.43781 3.76492C6.68125 3.52148 7.01141 3.38471 7.35568 3.38471C7.69995 3.38471 8.03012 3.52148 8.27355 3.76492C8.51698 4.00836 8.65374 4.33854 8.65374 4.68281Z" fill="#767676" class="color-fill"></path>
                                    <path d="M8.73065 11.5724C8.72269 11.8874 8.87038 11.9762 9.22992 12.0131L9.80777 12.0247V12.6154H5.29934V12.0247L5.93431 12.0131C6.31404 12.0016 6.40531 11.8539 6.43358 11.5724V8.01701C6.43761 7.45405 5.70711 7.54244 5.19238 7.55917V6.97371L8.73065 6.84621" fill="#767676" class="color-fill"></path>
                                  </svg>
                                </div>
                              </span>
                            </div>
                            <div class="max__640 text__body-3 color__white block-sm">^ca_collections.cfaBulkDates</div>
                          </ifdef>

                          <div class="max__640 text__body-3 color__white">This collection has been accessioned, but has not yet been fully described. 
                            To inquire about this collection, email the archive at info@chicagofilmarchives.org</div>
                          </div>
                      </if>

                      <if rule="^access = 'yes'">
                        <div class="size-column">
                          <ifdef code="ca_collections.cfaInclusiveDates">
                            <div class="max__640 text__eyebrow color__light_gray block-xxxs">
                              Inclusive Dates
                              <span class="mb-2 info-icon collections-info" data-toggle="tooltip" title="The oldest and most recent known production dates of the items in a collection.">
                                <div class="trigger-icon color-icon-orange">
                                  <svg width="15" height="16" viewBox="0 0 15 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M7.5 0.5C3.36 0.5 0 3.86 0 8C0 12.14 3.36 15.5 7.5 15.5C11.64 15.5 15 12.14 15 8C15 3.86 11.64 0.5 7.5 0.5ZM7.5 1.65385C11.0031 1.65385 13.8462 4.49692 13.8462 8C13.8462 11.5031 11.0031 14.3462 7.5 14.3462C3.99692 14.3462 1.15385 11.5031 1.15385 8C1.15385 4.49692 3.99692 1.65385 7.5 1.65385Z" fill="#767676" class="color-fill"></path>
                                    <path d="M8.65374 4.68281C8.65374 5.02709 8.51698 5.35727 8.27355 5.60071C8.03012 5.84415 7.69995 5.98092 7.35568 5.98092C7.01141 5.98092 6.68125 5.84415 6.43781 5.60071C6.19438 5.35727 6.05762 5.02709 6.05762 4.68281C6.05762 4.33854 6.19438 4.00836 6.43781 3.76492C6.68125 3.52148 7.01141 3.38471 7.35568 3.38471C7.69995 3.38471 8.03012 3.52148 8.27355 3.76492C8.51698 4.00836 8.65374 4.33854 8.65374 4.68281Z" fill="#767676" class="color-fill"></path>
                                    <path d="M8.73065 11.5724C8.72269 11.8874 8.87038 11.9762 9.22992 12.0131L9.80777 12.0247V12.6154H5.29934V12.0247L5.93431 12.0131C6.31404 12.0016 6.40531 11.8539 6.43358 11.5724V8.01701C6.43761 7.45405 5.70711 7.54244 5.19238 7.55917V6.97371L8.73065 6.84621" fill="#767676" class="color-fill"></path>
                                  </svg>
                                </div>
                              </span>
                            </div>
                            <div class="max__640 text__body-3 color__white block-sm">^ca_collections.cfaInclusiveDates</div>
                          </ifdef>

                          <ifdef code="ca_collections.cfaBulkDates">
                            <div class="max__640 text__eyebrow color__light_gray block-xxxs">
                              Bulk Dates
                              <span class="mb-2 info-icon collections-info" data-toggle="tooltip" title="Bulk dates indicate the chronological or period strength of a collection, especially when the inclusive dates may be misleading.">
                                <div class="trigger-icon color-icon-orange">
                                  <svg width="15" height="16" viewBox="0 0 15 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M7.5 0.5C3.36 0.5 0 3.86 0 8C0 12.14 3.36 15.5 7.5 15.5C11.64 15.5 15 12.14 15 8C15 3.86 11.64 0.5 7.5 0.5ZM7.5 1.65385C11.0031 1.65385 13.8462 4.49692 13.8462 8C13.8462 11.5031 11.0031 14.3462 7.5 14.3462C3.99692 14.3462 1.15385 11.5031 1.15385 8C1.15385 4.49692 3.99692 1.65385 7.5 1.65385Z" fill="#767676" class="color-fill"></path>
                                    <path d="M8.65374 4.68281C8.65374 5.02709 8.51698 5.35727 8.27355 5.60071C8.03012 5.84415 7.69995 5.98092 7.35568 5.98092C7.01141 5.98092 6.68125 5.84415 6.43781 5.60071C6.19438 5.35727 6.05762 5.02709 6.05762 4.68281C6.05762 4.33854 6.19438 4.00836 6.43781 3.76492C6.68125 3.52148 7.01141 3.38471 7.35568 3.38471C7.69995 3.38471 8.03012 3.52148 8.27355 3.76492C8.51698 4.00836 8.65374 4.33854 8.65374 4.68281Z" fill="#767676" class="color-fill"></path>
                                    <path d="M8.73065 11.5724C8.72269 11.8874 8.87038 11.9762 9.22992 12.0131L9.80777 12.0247V12.6154H5.29934V12.0247L5.93431 12.0131C6.31404 12.0016 6.40531 11.8539 6.43358 11.5724V8.01701C6.43761 7.45405 5.70711 7.54244 5.19238 7.55917V6.97371L8.73065 6.84621" fill="#767676" class="color-fill"></path>
                                  </svg>
                                </div>
                              </span>
                            </div>
                            <div class="max__640 text__body-3 color__white block-sm">^ca_collections.cfaBulkDates</div>
                          </ifdef>

                          <ifcount code="ca_entities" min="1" restrictToRelationshipTypes="cfa_sponsor">
                              <div class="max__640 text__eyebrow color__light_gray block-xxxs">Preservation Sponsor</div>
                              <unit relativeTo="ca_entities" delimiter="" restrictToRelationshipTypes="cfa_sponsor">
                                <ifdef code="^ca_entities.file">
                                  <div class="max__640 text__body-3 color__white"><img src="^ca_entities.file" style="max-height: 80px; max-width: 450px;"></div>
                                </ifdef>
                                <ifnotdef code="^ca_entities.file">
                                  <div class="max__640 text__body-3 color__white">^ca_entities.preferred_labels.surname</div>
                                </ifnotdef>
                                <br>
                              </unit>
                          </ifcount>

                          <ifdef code="ca_collections.cfaAbstract">
                            <div class="max__640 text__eyebrow color__light_gray block-xxxs">Abstract</div>
                            <div class="max__640 text__body-3 color__white block-sm">^ca_collections.cfaAbstract</div>
                          </ifdef>
                        
                          <ifdef code="ca_collections.cfaDescription">
                            <div class="max__640 text__eyebrow color__light_gray block-xxxs">Description</div>
                            <div class="max__640 text__body-3 color__white block-sm">^ca_collections.cfaDescription</div>
                          </ifdef>
                        </div>
                      </if>
                    </case>
                  }}}
                </div><!-- content-scroll -->
              </div><!-- container-scroll -->
            <div class="footer link">
                <a href="#collection-details" class="text__eyebrow color-class-orange color__white scroll-to" data-offset="100">
                  view More collection Details
                  <span class="arrow-link down">
                    <svg width="10" height="12" viewBox="0 0 10 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="M3.62909 5.99999L0.436768 0.666656L9.99999 5.99999L0.436768 11.3333L3.62909 5.99999Z" fill="#767676" class="color-fill"></path>
                    </svg>
                  </span>
                </a>
            </div>
            <div class="shadow"></div>
          </div><!-- item -->
        </div><!-- layout -->
      </div><!-- wrap -->
    </section>


    <!-- If min of 1 child and no intellectual arrangement -->
    {{{<ifcount code="ca_collections.children" min="1">
      <ifnotdef code="ca_collections.cfaIntellectualArrangement">
        <section class="collection-grid-items">
          <div class="wrap">
            <div class="int module-tabs">
              <div class="header">
                <h4 class="text-align-center text__headline-4 title mb-3">Series In this Collection</h4>
                <div class="series-grid">
                  <ifcount code="ca_collections.children" min="1">
                    <unit relativeTo="ca_collections.children" delimiter="" restrictToTypes="series" sort="ca_collections.idno_sort">
                      <div class="row series-grid-item">
                        <div class="col-auto mb-2 me-2">
                          <ifdef code="ca_object_representations.media.thumbnail">
                            <span class="series-thumbnail"><l>^ca_object_representations.media.thumbnail</l></span>
                          </ifdef>
                          <ifnotdef code="ca_object_representations.media.thumbnail">
                            <l><div class="series-placeholder"></div></l>
                          </ifnotdef>
                        </div>
                        <div class="col-auto align-self-center">
                          <span class="fw-bold" style="font-size: 15px;"><l>^ca_collections.preferred_labels</l></span>
                          <ifdef code="ca_collections.cfaInclusiveDates"><div class="text__eyebrow year color__gray">^ca_collections.cfaInclusiveDates</div></ifdef>
                        </div>
                      </div>
                    </unit>
                  </ifcount>
                </div>
              </div>
            </div>
          </div>
        </section>
      </ifnotdef>
    </ifcount>}}}

    <!-- If min of 1 child and intellectual arrangement -->
    {{{<ifcount code="ca_collections.children" min="1">
      <ifdef code="ca_collections.cfaIntellectualArrangement">
        <section class="collection-grid-items">
          <div class="wrap">
            <div class="int module-tabs">
              <div class="header">
                <h4 class="text-align-center text__headline-4 title">Series In this Collection</h4>
                <div class="row mt-3">
                  <div class="col-6">
                    <ifcount code="ca_collections.children" min="1">
                        <div class="unit">
                          <unit relativeTo="ca_collections.children" delimiter="<br>" restrictToTypes="series" sort="ca_collections.idno_sort">
                            <div class="row">
                              <ifdef code="ca_object_representations.media.thumbnail">
                                <div class="col-auto mb-2 me-2">
                                  <span class="series-thumbnail"><l>^ca_object_representations.media.thumbnail</l></span>
                                </div>
                              </ifdef>
                              <ifnotdef code="ca_object_representations.media.thumbnail">
                                <div class="col-auto mb-2 me-2">
                                  <l><div class="series-placeholder"></div></l>
                                </div>
                              </ifnotdef>
                              <div class="col-auto align-self-center">
                                <span class="fw-bold" style="font-size: 15px;"><l>^ca_collections.preferred_labels</l></span>
                                <ifdef code="ca_collections.cfaInclusiveDates"><div class="text__eyebrow year color__gray">^ca_collections.cfaInclusiveDates</div></ifdef>
                              </div>
                            </div>
                          </unit>
                        </div>
                    </ifcount>
                  </div>

                  <div class="col-6"> 
                    <div class="paragraph">
                          <div class="text__eyebrow color__gray">Intellectual organization and arrangement</div>
                          <div class="text__body-3">
                            <div class="unit">
                                ^ca_collections.cfaIntellectualArrangement
                            </div>
                          </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
      </ifdef>
    </ifcount>}}}

  
<?php
	$access_values = caGetUserAccessValues($this->request);
	$item_count = $viewable_count = 0;
	
	$ids = $t_item->get('ca_collections.branch.collection_id', ['returnAsArray' => true]);
	
	while(sizeof($ids)) {
		$id = array_shift($ids);
		$t_coll = ca_collections::findAsInstance($id);
		
		if($t_coll && ($t_coll->getRelatedItems('ca_objects', ['checkAccess' => $access_values, 'returnAs' => 'count']) > 0)) {
			$qr_objects = $t_coll->getRelatedItems('ca_objects', ['returnAs' => 'searchResult', 'checkAccess' => $access_values]);
			$item_count += $qr_objects->numHits();
		
			while($qr_objects->nextHit()) {
				if($qr_objects->get('ca_object_representations.representation_id', ['checkAccess' => [1]])) {
					$viewable_count++;
				}
			}
		}
	}
?>
    <?php 
      if($viewable_count == 0 && $item_count == 0) {
    ?>
        <section class="collection-grid-items" style="display: none;">
    <?php
      }else{
     ?>
        <section class="collection-grid-items">
    <?php
      }
    ?>
      <div class="wrap">
        <div class="int module-tabs">

          <div class="header">
            <h4 class="text-align-center text__headline-4 title">Collection Items</h4>
            <div class="filters">

            	<ul class="nav nav-tabs" id="myTab" role="tablist" style="border: none;">

                <?php 
                  if($viewable_count == 0) {
                ?>
                  <div style="display: none;"></div>
                  <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="itemList-tab" data-bs-toggle="tab" data-bs-target="#itemList-tab-pane" type="button" role="tab" aria-controls="itemList-tab-pane" aria-selected="false">
                      <span class="title text__eyebrow">Item List (<?= $item_count; ?>)</span>
                    </button>
                  </li>
                <?php
                  }else{
                ?>
                  <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="itemGrid-tab" data-bs-toggle="tab" data-bs-target="#itemGrid-tab-pane" type="button" role="tab" aria-controls="itemGrid-tab-pane" aria-selected="true">
                      <span class="title text__eyebrow">Viewable Media (<?= $viewable_count; ?>)</span>

                      <span class="mb-2 info-icon collections-info" data-toggle="tooltip" title="What does this mean? Not every object in our collection has been digitized yet. This option shows you only items that can be viewed online now.">
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
                <?php
                  }
                ?>
			 </ul>

              <a href="/Browse/Objects" class="text__eyebrow color-class-orange $color__dark_gray">
                Advanced Search 
                <span class="arrow-link">
                  <svg width="10" height="12" viewBox="0 0 10 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M3.62909 5.99999L0.436768 0.666656L9.99999 5.99999L0.436768 11.3333L3.62909 5.99999Z" fill="#767676" class="color-fill"></path>
                  </svg>
                </span>
              </a>

            </div>
          </div>


          <div class="tab-content" id="myTabContent">
            <?php 
              if($viewable_count == 0) {
            ?>
                <div class="tab-pane fade" id="itemGrid-tab-pane" role="tabpanel" aria-labelledby="itemGrid-tab" tabindex="0" style="display: none;">
            <?php
              }else{
            ?>
                <div class="tab-pane fade show active" id="itemGrid-tab-pane" role="tabpanel" aria-labelledby="itemGrid-tab" tabindex="0">
            <?php
              }
            ?>
              <div class="tab-int">
                <div class="grid-flex grid-1-3-4 margin-bottom collection-grid" id="expando-grid">

                  {{{<ifcount code="ca_collections.branch" min="0">
                      <unit relativeTo="ca_collections.branch" delimiter="" sort="ca_collections.idno_sort" filter="/<img/">

                        <ifcount code="ca_objects" min="1">

                          <if rule="^access = 'yes'">
                            <!-- <if rule="^ca_object_representation.type_id =~ /(audio|film|3d_object|back|front|document)/i"> -->

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
                                    <div class="text__eyebrow year color__gray" style="text-transform: none;">^ca_occurrences.cfaDateProduced</div>
                                  </div>
                                </div>
                              </unit>

                            <!-- </if> -->
                          </if>
                        </ifcount>

                      </unit>
                  </ifcount>}}}

                </div>

                <?php 
                  if($viewable_count > 1) {
                  	$lc = ($viewable_count > 4) ? 5 : $viewable_count;
                ?>
                    <div class="text-align-center count-<?= $lc; ?>">
                      <span class="button color-gray pill view-more-btn">View More Items</span>
                    </div>
                <?php
                  }
                ?>

              </div>
            </div> <!-- tab-pane -->

            <?php 
              if($viewable_count == 0) {
            ?>
                <div class="tab-pane fade show active" id="itemList-tab-pane" role="tabpanel" aria-labelledby="itemList-tab" tabindex="0">
            <?php
              }else{
            ?>
                <div class="tab-pane fade" id="itemList-tab-pane" role="tabpanel" aria-labelledby="itemList-tab" tabindex="0">
            <?php
              }
            ?>

              <div class="row pb-4 ps-3">
                <div class="col">
                  <small class="color__gray">To request more information about the items in this collection, please contact the archive at info@chicagofilmarchives.org.</small>
                </div>
                <div class="col text-end">
                  <small class="color__gray">
                    <span class="viewable-media-icon right">
                      <svg width="15" height="13" viewBox="0 0 15 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="0.5" y="0.5" width="14" height="12" rx="3.5" stroke="#BDBDBD"></rect>
                        <path d="M10 6.5L6 10L6 3L10 6.5Z" fill="#E26C2F"></path>
                      </svg>
                    </span>
                    Items with Viewable Media
                  </small>
                </div>
              </div>

              <ul class="list columns__text text__body-3" col-num="2" style="list-style-type: none;">

              {{{
                <!-- collection items -->
                <ifcount code="ca_objects" min="1">
                  <unit relativeTo="ca_objects" delimiter="" sort="ca_objects.preferred_labels">
                    <li>
                    <span class="link-orange"><l>^ca_objects.preferred_labels</l></span>
                    <if rule="^ca_objects.type_id%convertCodesToIdno=1 =~ /(audio|manu|realia|equipment)/i">
                      <small class="color__gray">(^ca_objects.type_id)</small>
                    </if>
                    <if rule="^access = 'yes'">
                      <!-- <if rule="^ca_object_representation.type_id =~ /(audio|film|3d_object|back|front|document)/i"> -->
                        <span class="viewable-media-icon right">
                          <svg width="15" height="13" viewBox="0 0 15 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect x="0.5" y="0.5" width="14" height="12" rx="3.5" stroke="#BDBDBD"></rect>
                            <path d="M10 6.5L6 10L6 3L10 6.5Z" fill="#E26C2F"></path>
                          </svg>
                        </span>
                      <!-- </if> -->
                    </if>
                    </li>
                  </unit> <br><hr><br>
                </ifcount>

                <ifcount code="ca_collections.children" min="1">
                  <!-- series -->
                  <unit relativeTo="ca_collections.children" delimiter="<br>" sort="ca_collections.preferred_labels.name_sort">
                    <span class="fw-bold"><l>^ca_collections.preferred_labels</l></span>
                    <ifcount code="ca_objects" min="0" max="0"><br></ifcount>
                    <ifcount code="ca_objects" min="1">
                      <unit relativeTo="ca_objects" delimiter="" sort="ca_objects.preferred_labels">
                        <li>
                          <span class="link-orange"><l>^ca_objects.preferred_labels</l></span>
                          <if rule="^ca_objects.type_id%convertCodesToIdno=1 =~ /(audio|manu|realia|equipment)/i">
                            <small class="color__gray">(^ca_objects.type_id)</small>
                          </if>
                          <if rule="^access = 'yes'">
                            <!-- <if rule="^ca_object_representation.type_id =~ /(audio|film|3d_object|back|front|document)/i"> -->
                              <span class="viewable-media-icon right">
                                <svg width="15" height="13" viewBox="0 0 15 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                  <rect x="0.5" y="0.5" width="14" height="12" rx="3.5" stroke="#BDBDBD"></rect>
                                  <path d="M10 6.5L6 10L6 3L10 6.5Z" fill="#E26C2F"></path>
                                </svg>
                              </span>
                            <!-- </if> -->
                          </if>
                        </li>
                      </unit> <br>
                    </ifcount>
                    
                    <!-- subseries -->
                    <unit relativeTo="ca_collections.children" delimiter="" sort="ca_collections.preferred_labels.name_sort">
                      <div class="ms-3 mt-3 d-inline">
                        <span class="fw-bold"><l>^ca_collections.preferred_labels</l> <small style="color: #767676;">(^ca_collections.type_id)</small></span>
                        <ifcount code="ca_objects" min="1">
                          <unit relativeTo="ca_objects" delimiter="" sort="ca_objects.preferred_labels">
                            <li class="ms-3">
                              <span class="link-orange"><l>^ca_objects.preferred_labels</l></span>
                              <if rule="^ca_objects.type_id%convertCodesToIdno=1 =~ /(audio|manu|realia|equipment)/i">
                                <small class="color__gray">(^ca_objects.type_id)</small>
                              </if>
                              <if rule="^access = 'yes'">
                                <!-- <if rule="^ca_object_representation.type_id =~ /(audio|film|3d_object|back|front|document)/i"> -->
                                  <span class="viewable-media-icon right">
                                    <svg width="15" height="13" viewBox="0 0 15 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                      <rect x="0.5" y="0.5" width="14" height="12" rx="3.5" stroke="#BDBDBD"></rect>
                                      <path d="M10 6.5L6 10L6 3L10 6.5Z" fill="#E26C2F"></path>
                                    </svg>
                                  </span>
                                <!-- </if> -->
                              </if>
                            </li>
                          </unit> <br>
                        </ifcount>
                      </div>
                    </unit>

                  </unit>
                </ifcount>
                }}}
              </ul>
            </div> <!-- tab-pane -->
          </div><!-- tab-content -->
        </div>
      </div><!-- wrap -->
    </section>
<?php
	//}
?>


    {{{<case>
      
      <if rule="^access = 'restricted'">
        <section id="collection-details" class="collection-details d-none">
          <div class="wrap">
            <div class="int">
              <div class="layout columns__text h-100" col-num="2"></div>
            </div>
          </div>
        </section>
        <br>
      </if>
              
      <if rule="^access = 'yes'">
        <section id="collection-details" class="collection-details">
          <div class="wrap">
            <div class="int">
              <div class="layout columns__text" col-num="2">
                <?php
                  $metadata = array(
                    "ca_collections.idno" => "Collection Identifier",
                    "ca_collections.cfaCollectionExtent" => "Extent of Collection",
                    "ca_collections.cfaLanguageMaterials" => "Language Of Materials",
                  );
                  foreach($metadata as $field => $fieldLabel){
                ?>
                    <ifdef code="<?php print $field; ?>">
                      <div class="paragraph">
                        <div class="text__eyebrow color__gray"><?php print $fieldLabel; ?></div>
                        <div class="text__body-3"><unit delimiter="<br/>">^<?php print $field; ?></unit></div>
                      </div>
                    </ifdef>
                <?php
                  }
                ?>

                <ifdef code="ca_list_items">
                    <div class="paragraph">
                      <div class="text__eyebrow color__gray">
                        Subject
                        <span class="mb-2 info-icon collections-info" data-toggle="tooltip" title="Objects in this collection relate to some of the following subjects.">
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
                </ifdef>

                <?php
                  $metadata = array(
                    "ca_collections.cfaCustodialHistory" => "Custodial History",
                    "ca_collections.cfaRelatedMaterials" => "Related Materials",
                  );
                  foreach($metadata as $field => $fieldLabel){
                ?>
                    <ifdef code="<?php print $field; ?>">
                      <div class="paragraph">
                        <div class="text__eyebrow color__gray"><?php print $fieldLabel; ?></div>
                        <div class="text__body-3"><unit delimiter="<br/>">^<?php print $field; ?></unit></div>
                      </div>
                    </ifdef>
                <?php
                  }
                ?>

                <ifcount code="ca_collections.related" min="1">
                    <div class="paragraph">
                      <div class="text__eyebrow color__gray">Related Collections</div>
                      <div class="text__body-3">
                        <div class="unit">
                            <unit relativeTo="ca_collections.related" delimiter="<br/>">
                              <span class="link-orange"><l>^ca_collections.preferred_labels.name</l></span>
                            </unit>
                        </div>
                      </div>
                    </div>
                </ifcount>

                <?php
                  $metadata = array(
                    "ca_collections.cfaAccessRestrictions" => "Access Restrictions",
                    "ca_collections.cfaUseRestrictions" => "Use Restrictions",
                  );
                  foreach($metadata as $field => $fieldLabel){
                ?>
                    <ifdef code="<?php print $field; ?>">
                      <div class="paragraph">
                        <div class="text__eyebrow color__gray"><?php print $fieldLabel; ?></div>
                        <div class="text__body-3"><unit delimiter="<br/>">^<?php print $field; ?></unit></div>
                      </div>
                    </ifdef>
                <?php
                  }
                ?>

                <ifcount code="ca_entities" min="1">
                    <div class="paragraph">
                      <div class="text__eyebrow color__gray">Creators</div>
                      <div class="text__body-3">
                        <div class="unit">
                          <unit relativeTo="ca_entities" restrictToRelationshipTypes="creator,complier,source" delimiter="<br/>">
                            <span class="link-orange">
                              <strong>
                                <a href="/Search/objects/search/^ca_entities.preferred_labels">^ca_entities.preferred_labels</a>
                              </strong>
                            </span>
                            (^relationship_typename)
                            <!-- <br/> -->
                            <span class="trimText">^ca_entities.biography</span>
                          </unit>
                        </div>
                      </div>
                    </div>
                </ifcount>

                <ifcount code="ca_collections.children" min="0" max="0">
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
                </ifcount>
              </div>
            </div>
          </div>
        </section>
      </if>
    </case>}}}



    <!-- TODO: Hide this if there is no related content -->
    <section class="section-slideshow-related " id="related-content-div" style="display: none;">
      <div class="wrap"><div class="line"></div></div>
      <div class="int wrap-not-mobile">

        <h4 class="text-align-center text__headline-4 block-small ">Related Content</h4>

        <div class="slider-container module_slideshow slideshow-related manual-init">
          <!-- <div class="slick-slider">
            <div id="related-content"></div>
          </div> -->

          <div id="related-content" class="slick-slider"></div>

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
    	let h = $("#expando-grid").prop('scrollHeight');
      	$("#expando-grid").animate({height: h}, 500);
      	$(".view-more-btn").css("display", "none");
    });
    
    $('.trimText').readmore({
      speed: 150,
      maxHeight: 100
    });
	
    $('#related-content').load('https://cfarchives.wpengine.com/wp-admin/admin-ajax.php?action=ca_related&id=<?= $t_item->get("ca_collections.collection_id"); ?>', {}, ca_init_slider);

    function ca_init_slider(responseText, textStatus, xhr) {
    	if(!responseText || (responseText.length == 0)) {
    		return false;
    	}
    	
    	$('#related-content-div').show();
    	CFA_APP.WIDGETS.initSlideShows( true, $( '.section-slideshow-related' ) );
	}


  });
</script>
<!-- end row -->
