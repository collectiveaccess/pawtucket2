<h2>Import Media</h2>

<div id="import"></div>

<script type="text/javascript">
	pawtucketUIApps['Import'] = {
        'selector': '#import',
		'key': '<?= $this->getVar('key'); ?>', 
        'data': {
			baseUrl: "<?= __CA_URL_ROOT__."/service.php"; ?>",
			siteBaseUrl: "<?= __CA_URL_ROOT__."/index.php"; ?>/Import"
        }
    };
</script>