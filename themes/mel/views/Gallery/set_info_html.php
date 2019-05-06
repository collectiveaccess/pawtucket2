<?php
	$va_set_item = $this->getVar("set_item");
?>
<div class="row">
    <hr/>
    <div class="col-sm-3">
        <?php print caNavLink($this->request, $va_set_item["representation_tag"], "", "", "Gallery", $this->getVar("set_id")); ?>
		<div class="caption"></div>
    </div>
    <div class="col-sm-9">
<?php
        print "<H4>".caNavLink($this->request, $this->getVar("label"), "", "", "Gallery", $this->getVar("set_id"))."</H4>";
?>
    </div>
</div><!-- end row -->