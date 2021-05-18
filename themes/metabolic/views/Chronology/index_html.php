<div id="chronology"></div>

<script type="text/javascript">	
    pawtucketUIApps['Chronology'] = {
    	baseUrl: "<?php print __CA_URL_ROOT__."/service.php/Browse"; ?>",
    	selector: '#chronology',
    	chronology: '<?= $this->request->getParameter('id', pString); ?>'
    };
</script>