$(function() {
	$("table tr").click(function() {
		url = $(this).find("a:first");
		if(url.length != 1) {
			return false;
		}
		
		window.location = $(url[0]).attr("href");
	});
});
