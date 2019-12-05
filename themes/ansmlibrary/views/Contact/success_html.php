<?php
    require_once(__CA_MODELS_DIR__."/ca_objects.php");
    $t_object = new ca_objects($this->request->getParameter('object_id', pInteger));
    
    $name = null;
    if ($t_object->get('ca_objects.access') == 1) {
        $name = $t_object->get('ca_objects.ns_title');
    }
?>
<div class='detailContentContainer'>
    <H1><?php print _t("Book request"); ?></H1>
<?php
    if ($name) {
?>
    <div>Your request for <?php print caDetailLink($this->request, $name, '', 'ca_objects', $t_object->getPrimaryKey()); ?> has been submitted. We'll be in touch soon.</div>
<?php
    } else {
?>
    <div>Your request has been submitted. We'll be in touch soon.</div>
<?php
    }
?>
</div>