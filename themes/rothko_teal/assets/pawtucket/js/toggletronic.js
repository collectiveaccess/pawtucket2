function tronicTheToggles() {
    jQuery('.togglertronic').off().on('click', function(e) {
        var state = jQuery(this).data('togglestate');
    
        var toggle = this;
        if (state == 'open') {
            jQuery('#' + jQuery(toggle).data('togglediv')).slideUp(200, function() {
                jQuery(toggle).data('togglestate', 'closed').find('.drawerToggle').hide().attr("class", "fa fa-plus drawerToggle").show();
            });
        } else {
            jQuery('#' + jQuery(toggle).data('togglediv')).slideDown(200, function() {
                jQuery(toggle).data('togglestate', 'open').find('.drawerToggle').hide().attr("class", "fa fa-minus drawerToggle").show();
            });
        
        }
        e.preventDefault();
        return false;
    });	
}