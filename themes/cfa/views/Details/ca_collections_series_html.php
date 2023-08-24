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

  	<div class="eyebrow text__eyebrow color__gray mx-5 my-3">
			{{{<unit relativeTo="ca_collections.parent"><l>^ca_collections.preferred_labels<l></unit> > <l>^ca_collections.preferred_labels<l>}}}
		</div>

    <br/>
    <h1 class="text-align-center text__headline-1 block-sm">
      {{{^ca_collections.preferred_labels}}}
    </h1>

    <section id="collection-details" class="collection-details">
      <div class="wrap">
        <div class="int">

          <div class="layout columns__text" col-num="2">

          	<?php
							$metadata = array(
								"ca_collections.cfaAbstract" => "Abstract",
								"ca_collections.cfaPreservationSponsor" => "Preservation Sponsor",
								"ca_collections.cfaInclusiveDates" => "Inclusive Dates",
								"ca_collections.cfaBulkDates" => "Bulk Dates",
								"ca_collections.idno" => "Series identifier",
								"ca_collections.cfaDescription" => "Description",	
								"ca_collections.cfaCollectionExtent" => "Extent of Collection",
								"ca_collections.cfaAccessRestrictions" => "Access Restrictions",
								"ca_collections.cfaUseRestrictions" => "Use Restrictions",
								"ca_collections.cfaRelatedMaterials" => "Related Materials",
								"ca_list_items" => "Subject",	
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
          </div>
        </div>
      </div>
    </section>

    <section class="collection-grid-items">
      <div class="wrap">
        <div class="int module-tabs">

          <div class="header">
            <h4 class="text-align-center text__headline-4 title">Series Items</h4>
            <div class="filters">

            	<ul class="nav nav-tabs" id="myTab" role="tablist" style="border: none;">
                <li class="nav-item" role="presentation">
                  <button class="nav-link active" id="itemGrid-tab" data-bs-toggle="tab" data-bs-target="#itemGrid-tab-pane" type="button" role="tab" aria-controls="itemGrid-tab-pane" aria-selected="true">
                    <span class="title text__eyebrow">Viewable Media</span>
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
                    <span class="title text__eyebrow">Item List</span>
                  </button>
                </li>
				      </ul>

              <a href="/index.php/Search/advanced/collections" class="text__eyebrow color-class-orange $color__dark_gray">
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
                <div class="grid-flex grid-1-3-4 margin-bottom collection-grid">
                  {{{<ifcount code="ca_objects" min="1">
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

                <div class="text-align-center">
                  <span class="button color-gray pill view-more-btn">View More Items</span>
                </div>

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

  </main>
</div>

<script>
  $(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();

    $(".view-more-btn").click(function(){
      $(".collection-grid").animate({height: "100%"}, 8000);
      // $(".collection-grid").height("100%");
      $(".view-more-btn").css("display", "none");
    });
  });
</script>
<!-- end row -->
