function makeClickTagger(options) {
	let tag_list_id = options.id ?? 'tagList';
	let tagList = document.getElementById(tag_list_id);
	
	let tag_count_id = options.id ?? 'tagCounts';
	let tagCounts = document.getElementById(tag_count_id);
	console.log('tag counts is ', tag_count_id);
	//tag_count_id.innerHTML = 'meiw';
}


export default makeClickTagger;
