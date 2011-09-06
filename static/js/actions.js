$(document).ready(function() {

	$("a.dropdown-toggle").click(function() {
		$(this).parent().toggleClass("open");
	});
	
	$("a.close").click(function() {
		$(this).parent().remove();
	});

});