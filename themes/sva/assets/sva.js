$(document).ready(function() {
	
	toc_html = "<ol id='table_of_contents'>\n";
	
	$(".toc-series").each(function() {
		var $this = $(this);
		var seriestitle = $this.find("a").text();
		var anchorloc = $this.attr("id");
		var hierlevel = $this.attr("data-level");
				
		toc_html += "\t<li class='" + ( (seriestitle.indexOf("Subseries") > -1) ? "subseries" : "series") + " level-" + hierlevel + "'><a href='#" + anchorloc + "'>" + seriestitle + "</a></li>\n";
	});
		
	toc_html += "</ol>\n\n";
	
	$("#findingaid-toc").append(toc_html);
	
	
});