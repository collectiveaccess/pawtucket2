<div class='col-sm-2 platforms'>
    <h2>Platforms</h2>
<?php
    print "<div>".caNavLink($this->request, 'Carryable', 'platformLink', '', 'Browse', 'objects', array('facet' => 'use_facet', 'id' => 238))."</div>";
    print "<div>".caNavLink($this->request, 'Wearable', 'platformLink', '', 'Browse', 'objects', array('facet' => 'use_facet', 'id' => 239))."</div>";
    print "<div>".caNavLink($this->request, 'Implantable', 'platformLink', '', 'Browse', 'objects', array('facet' => 'use_facet', 'id' => 240))."</div>";
    print "<div>".caNavLink($this->request, 'Ingestible', 'platformLink', '', 'Browse', 'objects', array('facet' => 'use_facet', 'id' => 380))."</div>";
    print "<div>".caNavLink($this->request, 'Embeddable', 'platformLink', '', 'Browse', 'objects', array('facet' => 'use_facet', 'id' => 359))."</div>";
    print "<div>".caNavLink($this->request, 'Robotical', 'platformLink', '', 'Browse', 'objects', array('facet' => 'use_facet', 'id' => 392))."</div>";

    print "<h2>".caNavLink($this->request, "Collections", "", "Listing", "collections", "collections")."</h2>";
    
    require_once(__CA_LIB_DIR__."/Search/CollectionSearch.php");
    require_once(__CA_MODELS_DIR__."/ca_collections.php");
    $o_collection_search = new CollectionSearch();
    $qr_collections = ca_collections::find(['display_homepage' => 'yes', 'access' => 1], ['returnAs' => 'searchResult']); //$o_collection_search->search("ca_collections.display_homepage:yes", array("checkAccess" => $va_access_values));
    $vn_i = 0;
    while ($qr_collections->nextHit()) {
        print "<div>".caNavLink($this->request, $qr_collections->get('ca_collections.preferred_labels'), 'platformLink', '', 'Browse', 'objects/facet/collection_facet/id/'.$qr_collections->get('ca_collections.collection_id'))."</div>";
        $vn_i++;
        if ($vn_i == 5) {
            break;
        }
    }
?>
    <div style="clear:both; height:1px;"><!-- empty --></div>
</div>