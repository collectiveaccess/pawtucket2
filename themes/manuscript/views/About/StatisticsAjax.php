<?php

$va_public_access = array(1);
$va_restricted_access = array(2);

$va_manuscript_types = caMakeTypeIDList("ca_objects", array("manuscript"), array('dontIncludeSubtypesInTypeRestriction' => true));
$va_untensil_types = caMakeTypeIDList("ca_objects", array("kitchen_utensil"), array('dontIncludeSubtypesInTypeRestriction' => true));


$o_db = new Db();
$q_institutions_public = $o_db->query("SELECT distinct c.collection_id FROM ca_collections c where c.deleted = 0 AND c.access IN (".join(", ", $va_public_access).") AND c.parent_id IS NULL");

$q_manuscripts_public = $o_db->query("SELECT distinct o.object_id FROM ca_objects o where o.type_id IN (".join(",", $va_manuscript_types).") AND o.deleted = 0 AND o.access IN (".join(", ", $va_public_access).")");

$q_utensils_public = $o_db->query("SELECT distinct o.object_id FROM ca_objects o where o.type_id IN (".join(",", $va_untensil_types).") AND o.deleted = 0 AND o.access IN (".join(", ", $va_public_access).")");

?>
<div class="hpStats">
	<b>Manuscript Cookbooks Survey features <?php print $q_manuscripts_public->numRows(); ?> manuscripts and <?php print $q_utensils_public->numRows(); ?> kitchen utensils from <?php print $q_institutions_public->numRows(); ?> institutions.</b>
</div>