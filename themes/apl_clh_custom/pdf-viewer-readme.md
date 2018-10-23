## CA Files of Interest ##
### System Files ###

 - item one
 - [/app/lib/ca/BaseEditorController.php](https://github.com/collectiveaccess/pawtucket2/blob/b31c62468d1460c24df9738edbea776cf94ff30d/app/lib/ca/BaseEditorController.php "BaseEditorController.php")
   GetPageListAsJSON function is defined here. However the pertinent part for us is $va_pages array which is pulled from cache *caDocumentViewerPageListCache*. Cache is created by [representation_viewer_html.php](themes/default/views/bundles/representation_viewer_html.php "representation_viewer_html.php") See theme files below for more info.
 - [/app/controllers/DetailController.php](https://github.com/collectiveaccess/pawtucket2/blob/b31c62468d1460c24df9738edbea776cf94ff30d/app/controllers/DetailController.php "DetailController.php")
   GetPageListAsJSON function is defined here too. Seems very similar to /app/lib/ca/BaseEditorController.php above.
 - placeholder
 - [/assets/ca/js/ca.bookreader.js](https://github.com/collectiveaccess/pawtucket2/blob/b31c62468d1460c24df9738edbea776cf94ff30d/assets/ca/js/ca.bookreader.js "ca.bookreader.js")
   Defines the *caUI.initBookReader* js function that calls *DV.load* method to initialize the PDF Doc Viewer. Also defines the config options sent to *DV.load*.
 - [/assets/DV/viewer.js](https://github.com/collectiveaccess/pawtucket2/blob/b31c62468d1460c24df9738edbea776cf94ff30d/assets/DV/viewer.js "viewer.js")
   All the Document Viewer (DV) stuff is here  


----------
### Theme Files ###

 - [/themes/default/conf/media_processing.conf](https://github.com/collectiveaccess/pawtucket2/blob/b31c62468d1460c24df9738edbea776cf94ff30d/themes/sva/conf/media_processing.conf "media_processing.conf")
   Controls which derivatives are created for each media type. You can specify additional derivatives and the rules for those. Look under ca_object_representation_multifiles: MEDIA_TYPES -> pdf -> VERSIONS. The corresponding rules are under MEDIA_TRANSFORMATION_RULES. Right now, PDFs generate these derivatives:
    1. preview
    2. large_preview
    3. page_preview
    4. original
 - listed too
 - [/themes/default/views/bundles/media_page_list_json.php](https://github.com/collectiveaccess/pawtucket2/blob/b31c62468d1460c24df9738edbea776cf94ff30d/themes/default/views/bundles/media_page_list_json.php "media_page_list_json.php")
   Outputs the JSON to the browser. [Example here](http://libraryarchives.arlingtonva.us/index.php/Detail/GetPageListAsJSON/ca_objects/object_id/1180/representation_id/154/content_mode/multifiles/download/1/data/documentData.json "documentData.json"). See also *GetPageListAsJSON* function above. List of image files available for PDF Viewer are under resources->pageList. Values for pageList provided by $va_pages array defined in file below.
 - [/themes/default/views/bundles/representation_viewer_html.php](https://github.com/collectiveaccess/pawtucket2/blob/b31c62468d1460c24df9738edbea776cf94ff30d/themes/default/views/bundles/representation_viewer_html.php "representation_viewer_html.php")
   The values for va_pages array are established here. Kind of tricky, this array is created in 4 different places inside if/then blocks. Also creates cache used by *GetPageListAsJSON* function above. Add more derivative image file locations to $va_pages array here.   
 - [themes/default/views/bundles/attribute_media_viewer_html.php](https://github.com/collectiveaccess/pawtucket2/blob/b31c62468d1460c24df9738edbea776cf94ff30d/themes/default/views/bundles/attribute_media_viewer_html.php "attribute_media_viewer_html.php") Very similar to representation_viewer_html.php above.
 - placeholder
 - placeholder
 - [/themes/default/views/bundles/mediaviewer_html.php](https://github.com/collectiveaccess/pawtucket2/blob/b31c62468d1460c24df9738edbea776cf94ff30d/themes/default/views/bundles/mediaviewer_html.php "mediaviewer_html.php")
 - [/themes/default/views/bundles/bookviewer_html.php](https://github.com/collectiveaccess/pawtucket2/blob/b31c62468d1460c24df9738edbea776cf94ff30d/themes/default/views/bundles/bookviewer_html.php "bookviewer")
    Calls the *caUI.initBookReader* function defined in [ca.bookreader.js](https://github.com/collectiveaccess/pawtucket2/blob/b31c62468d1460c24df9738edbea776cf94ff30d/assets/ca/js/ca.bookreader.js "ca.bookreader.js") above. Also supplies instance specific config data like url for JSON representation of currently viewed PDF. overwrite the **caUI.initBookReader** js method to add callback function to *afterLoad* DV event.


----------
| PDF Versions  | Transformation Rules     | Scale        |
| ------------- |:------------------------:| ------------:|
| preview       | rule_preview_image       | width = 180  |
| large_preview | rule_large_preview_image | width = 700  |
| page_preview  | rule_page_preview_image  | width = 1000 |
| original      | rule_original_image      | width = auto |

[PDF test link](http://libraryarchives.arlingtonva.us/index.php/Detail/objects/1180 "Test link on CA site")

> Written with [StackEdit](https://stackedit.io/).
