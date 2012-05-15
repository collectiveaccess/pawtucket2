<div id="objDetailRepVideoViewerContainer">
<div style="position: relative; width: 598px; height: 400px; padding: 0px; margin: 0px; background: #ffffff;">
        <div id="clipListContainer" class="videoViewerClipListContainer">
                        <a href="#" onclick="openClipList(); return false;" style="float:right; padding: 2px; margin: 5px 5px 0px 0px; text-decoration: none; border: 1px solid #000000; font-weight: bold;">X</a>
                        <div style="clear: both;"><!-- empty --></div>
                <div id="clipList" class="videoViewerClipList">
                        <ul class='videoViewerClipList'>
<?php                                $va_annotations = $this->getVar('annotations');                                foreach($va_annotations as $va_annotation) {
                                        print "<li class='videoViewerClipList'><div class='videoViewerClipListTimecode'>[".$va_annotation['startTimecode']."]</div> <a href='#' onclick='flowplayer(0).seek(".$va_annotation['startTimecode_raw']."); return false;'>".$va_annotation['labels']."</a></li>";
                                }
?>
                        </ul>
                </div>
        </div>

        <div class="videoViewer">
<?php
                print $this->getVar('viewer_tag');
?>
        </div>
</div>

<script type="text/javascript">
        function openClipList() {                if (jQuery('#clipListContainer').css('left') == '598px') {
                        // opened... so close
                        jQuery('#clipListContainer').animate({ left: '398px'}, 300, function() { jQuery('#clipListContainer').hide(); }
);
                } else {
                        // closed... so open
                        jQuery('#clipListContainer').show();
                        jQuery('#clipListContainer').animate({ left: '598px'}, 300);
                }
        }
</script>
</div>