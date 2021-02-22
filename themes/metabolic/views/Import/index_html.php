<div id="import" style="margin-top: 20px;"></div>

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