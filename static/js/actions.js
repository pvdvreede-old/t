$(document).ready(function() {

	$("a.dropdown-toggle").click(function() {
		$(this).parent().toggleClass("open");
		return;
	});
	
	$("a.close").click(function() {
		$(this).parent().remove();
	});

});