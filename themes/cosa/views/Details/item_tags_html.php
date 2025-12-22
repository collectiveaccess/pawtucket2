<?php
$table = $this->getVar('table');
$id = $this->getVar('id');
$detail_type = $this->getVar('detail');

$tag_list = $this->getVar("itemTagsAvailable");
$selected_tags = $this->getVar("itemTagsSelected");
$tag_counts = $this->getVar("itemTagsCounts");
?>
<div class="col-md-4" id="tagCounts">
	<H2 class="fs-4">What People Are Saying</H2>
	<ul class="list-group list-group-flush mb-5">
<?php
	if(is_array($tag_counts)) {
		foreach($tag_counts as $tag_id => $tag_info) {
			$l = $tag_info['name_singular'];
			$c = $tag_info['count'];
?><li class="list-group-item"><?= ($c != 1) ? _t('%1 person says <strong>%2</strong>', $c, $l) : _t('%1 people say <strong>%2</strong>', $c, $l); ?></li>
<?php
		}
	}
?>
	</ul>
</div>
<div class="col-md-8">
	<H2 class="fs-4">Add Your Review</H2>
	<div role="group" class="text-center" aria-label="Tag reviews" id="tagList">
<?php
	foreach($tag_list as $tag_id => $tag){
		$url = caNavUrl($this->request, '*', '*', 'ToggleItemTag', ['detail' => $detail_type, 'id' => $id, 'tag' => $tag_id]);
		
		$clr = isset($selected_tags[$tag_id]) ? 'dark' : 'light';
		print "<button type='button' class='btn btn-{$clr} mx-2 mb-2' hx-trigger='click' hx-target='#itemTags' hx-swap='innerHTML' hx-post='{$url}'>{$tag}</button>";				
	}
?>
	</div>
</div>