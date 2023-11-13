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

$t_root = new ca_collections($t_item->get('ca_collections.hier_collection_id'));

MetaTagManager::setWindowTitle($t_item->get('ca_collections.preferred_labels').": ".$t_item->get('ca_collections.type_id', ['convertCodesToDisplayText' => true]).": Chicago Film Archives");

MetaTagManager::addMeta("search-title", $t_item->get('ca_collections.preferred_labels'));
MetaTagManager::addMeta("search-eyebrow", 'Collections');
MetaTagManager::addMeta("search-group", 'Collections');
MetaTagManager::addMeta("search-thumbnail", $t_item->get('ca_object_representations.media.small.url'));
MetaTagManager::addMeta("search-access", ($t_item->get('ca_collections.access') == 2) ? 'restricted' : 'public');
MetaTagManager::addMeta("search-collection-type", 'subseries');

MetaTagManager::addMeta("og:title", $t_item->get('ca_collections.preferred_labels'));
MetaTagManager::addMeta("og:description", $t_item->get('ca_collections.cfaAbstract'));
MetaTagManager::addMeta("og:url", caNavUrl($this->request, '*', '*', '*', [], ['absolute' => true]));
MetaTagManager::addMeta("og:image", $t_root->get('ca_object_representations.media.large.url'));
MetaTagManager::addMeta("og:image:width", $t_root->get('ca_object_representations.media.large.width'));
MetaTagManager::addMeta("og:image:height", $t_root->get('ca_object_representations.media.large.height'));

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

    <div class="eyebrow text__eyebrow color__gray mx-5 my-3">
			{{{<unit relativeTo="ca_collections.hierarchy" delimiter=" > "><l>^ca_collections.preferred_labels<l></unit>}}}
		</div>
    <br/>
    <h1 class="text-align-center text__headline-1 block-sm">
      {{{^ca_collections.preferred_labels}}}
    </h1>

    <section id="collection-details" class="collection-details">
      <div class="wrap">
        <div class="int">
          
          {{{
            <case>
              <if rule="^access = 'restricted'">
                <div class="layout columns__text" col-num="2">

                  <div class="max__640 text__body-3 mb-3">
                    This subseries has been accessioned, but has not yet been fully described. 
                    To inquire about this subseries, email the archive at info@chicagofilmarchives.org
                  </div>
                  
                  <?php
                    $metadata = array(
                      "ca_collections.cfaInclusiveDates" => "Inclusive Dates",
                      "ca_collections.cfaAbstract" => "Abstract",
                      "ca_collections.idno" => "Subseries Identifier",
                      "ca_collections.cfaBulkDates" => "Bulk Dates",
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

                  <ifdef code="ca_collections.cfaExtent">
                    <div class="paragraph">
                      <div class="text__eyebrow color__gray">Extent</div>
                      <div class="text__body-3">
                        <unit delimiter="<br/>">
                          <ifdef code="ca_collections.cfaExtent.extentAmount">^ca_collections.cfaExtent.extentAmount </ifdef>
                          <ifdef code="ca_collections.cfaExtent.extentType">^ca_collections.cfaExtent.extentType</ifdef>
                        </unit>
                      </div>
                    </div>
                  </ifdef>

                </div>
              </if>

              <if rule="^access = 'yes'">
                <div class="layout columns__text" col-num="2">
                  <?php
                    $metadata = array(
                      "ca_collections.cfaAbstract" => "Abstract",
                      "ca_collections.cfaInclusiveDates" => "Inclusive Dates",
                      "ca_collections.cfaBulkDates" => "Bulk Dates",
                      "ca_collections.idno" => "Subseries Identifier",
                      "ca_collections.cfaDescription" => "Description",	
                      "ca_collections.cfaAccessRestrictions" => "Access Restrictions",
                      "ca_collections.cfaUseRestrictions" => "Use Restrictions",
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

                  <ifdef code="ca_collections.cfaExtent">
                    <div class="paragraph">
                      <div class="text__eyebrow color__gray">Extent</div>
                      <div class="text__body-3">
                        <unit delimiter="<br/>">
                          <ifdef code="ca_collections.cfaExtent.extentAmount">^ca_collections.cfaExtent.extentAmount </ifdef>
                          <ifdef code="ca_collections.cfaExtent.extentType">^ca_collections.cfaExtent.extentType</ifdef>
                        </unit>
                      </div>
                    </div>
                  </ifdef>

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
                              <!-- <a href="/Search/objects/search/^ca_list_items.preferred_labels.name_plural"><span class="link-orange">^ca_list_items.preferred_labels.name_plural</span></a> -->
                              <a href="/Browse/Objects/facet/subject//id/^ca_list_items.item_id"><span class="link-orange">^ca_list_items.preferred_labels.name_plural</span></a>
                            </unit>
                          </div>
                        </div>
                      </div>
                  </ifdef>

                </div>
              </if>
            </case>
          }}}

        </div>
      </div>
    </section>

  
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
				if($qr_objects->get('ca_object_representations.representation_id', ['checkAccess' => $access_values])) {
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
            <h4 class="text-align-center text__headline-4 title wrap">Subseries Items</h4>

            <!-- Draggable module (for mobile) -->
            <div class="draggable-module ready">
              <div class="draggable-content">

                <div class="filters wrap">

                  <ul class="nav nav-tabs" id="myTab" role="tablist" style="border: none;">

                    <?php 
                      if($viewable_count == 0) {
                    ?>
                      <div style="display: none;"></div>
                      <li class="nav-item" role="presentation">
                        <button class="nav-link active ps-0" id="itemList-tab" data-bs-toggle="tab" data-bs-target="#itemList-tab-pane" type="button" role="tab" aria-controls="itemList-tab-pane" aria-selected="false">
                          <span class="title text__eyebrow">Item List (<?= $item_count; ?>)</span>
                          <span class="mb-2 info-icon collections-info" data-toggle="tooltip" title="The item list displays a list of all inventoried items in this collection.">
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
                          <span class="mb-2 info-icon collections-info" data-toggle="tooltip" title="The item list displays a list of all inventoried items in this collection.">
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
                    <?php
                      }
                    ?>

                  </ul>

                  <a href="/Browse/Objects" class="text__eyebrow color-class-orange $color__dark_gray hide-mobile">
                    Browse All Objects
                    <span class="arrow-link">
                      <svg width="10" height="12" viewBox="0 0 10 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M3.62909 5.99999L0.436768 0.666656L9.99999 5.99999L0.436768 11.3333L3.62909 5.99999Z" fill="#767676" class="color-fill"></path>
                      </svg>
                    </span>
                  </a>

                </div>
              </div>
            </div>

          </div>


          <div class="tab-content" id="myTabContent">
            <?php 
              if($viewable_count == 0) {
            ?>
                <div class="tab-pane fade grid-view" id="itemGrid-tab-pane" role="tabpanel" aria-labelledby="itemGrid-tab" tabindex="0" style="display: none;">
            <?php
              }else{
            ?>
                <div class="tab-pane fade grid-view show active" id="itemGrid-tab-pane" role="tabpanel" aria-labelledby="itemGrid-tab" tabindex="0">
            <?php
              }
            ?>
              <div class="tab-int">
                <div class="grid-flex grid-1-3-4 margin-bottom collection-grid grid-collection-items" id="expando-grid">

                  {{{<ifcount code="ca_collections.branch" min="0">
                      <unit relativeTo="ca_collections.branch" delimiter="" sort="ca_collections.idno_sort" filter="/<img/">

                        <ifcount code="ca_objects" min="1">
                          <unit relativeTo="ca_objects" delimiter="" filter="/<img/">
                            <if rule="^access = 'yes'">
                              <if rule="^ca_object_representations.type_id%convertCodesToIdno=1 =~ /(audio|film|3d_object|back|front|document)/i">
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
                                    <div class="text__body-4 year color__gray" style="text-transform: none;">^ca_occurrences.cfaDateProduced</div>
                                  </div>
                                </div>
                              </if>
                            </if>
                          </unit>
                        </ifcount>

                      </unit>
                  </ifcount>}}}

                </div>

                <?php 
                  if($viewable_count > 1) {
                  	$lc = ($viewable_count > 4) ? 5 : $viewable_count;
                ?>
                    <div class="text-align-center count-<?= $lc; ?>">
                      <span class="button color-gray pill view-more-btn mt-2">View More Items</span>
                    </div>
                <?php
                  }
                ?>

              </div>
            </div> <!-- tab-pane -->

            <?php 
              if($viewable_count == 0) {
            ?>
                <div class="tab-pane fade show active list-items" id="itemList-tab-pane" role="tabpanel" aria-labelledby="itemList-tab" tabindex="0">
            <?php
              }else{
            ?>
                <div class="tab-pane fade list-items" id="itemList-tab-pane" role="tabpanel" aria-labelledby="itemList-tab" tabindex="0">
            <?php
              }
            ?>

              <div class="row row-cols-1 row-cols-xs-1 row-cols-sm-1 row-cols-md-2 pb-4 legend text__body-4 color__gray">
                <div class="col mb-2">
                  To request more information about the items in this collection, please contact the archive at 
                  <a href="mailto:info@chicagofilmarchives.org">info@chicagofilmarchives.org</a>.
                </div>
                <div class="col mb-2 d-flex justify-content-md-end">
                  <span class="viewable-media-icon">
                    <svg width="15" height="13" viewBox="0 0 15 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <rect x="0.5" y="0.5" width="14" height="12" rx="3.5" stroke="#BDBDBD"></rect>
                      <path d="M10 6.5L6 10L6 3L10 6.5Z" fill="#E26C2F"></path>
                    </svg>
                  </span>
                  Items with Viewable Media
                </div>
              </div>

              <ul class="list columns__text text__body-3" col-num="2" style="list-style-type: none;">

                {{{
                  <ifcount code="ca_collections.branch" min="1">
                    <unit relativeTo="ca_collections.branch" delimiter="" sort="ca_collections.preferred_labels.name_sort">
                        
                      <ifcount code="ca_objects" min="1">
                        <span class="fw-bold"><l>^ca_collections.preferred_labels</l></span>
                        <unit relativeTo="ca_objects" delimiter="" sort="ca_objects.preferred_labels">
                          <li>
                            <span class="link-orange"><l>^ca_objects.preferred_labels</l></span>
                            <if rule="^ca_objects.type_id%convertCodesToIdno=1 =~ /(audio|manu|realia|equipment)/i">
                              <small class="color__gray">(^ca_objects.type_id)</small>
                            </if>
                            <if rule="^access = 'yes'">
                              <if rule="^ca_object_representations.type_id%convertCodesToIdno=1 =~ /(audio|film|3d_object|back|front|document)/i">
                              <span class="viewable-media-icon right">
                                <svg width="15" height="13" viewBox="0 0 15 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                  <rect x="0.5" y="0.5" width="14" height="12" rx="3.5" stroke="#BDBDBD"></rect>
                                  <path d="M10 6.5L6 10L6 3L10 6.5Z" fill="#E26C2F"></path>
                                </svg>
                              </span>
                              </if>
                            </if>
                          </li>
                        </unit> <br><hr><br>
                      </ifcount>
                      
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

  </main>
</div>

<script>
  $(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();

    $(".view-more-btn").click(function(){
      $(".collection-grid").animate({height: "100%"}, 800);
      // $(".collection-grid").height("100%");
      $(".view-more-btn").css("display", "none");
    });
    function ca_resize_collection_grid() {
		let h = jQuery('.item-item').first().height();
		jQuery('.collection-grid').height(h);
	}

	jQuery(window).on('resize', function(e) {
		if(jQuery(".view-more-btn:visible").length === 0) { return; }
		ca_resize_collection_grid();		
	});
	ca_resize_collection_grid();
  });
</script>
<!-- end row -->
