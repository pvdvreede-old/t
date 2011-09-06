$(document).ready(function() {

	$("a.dropdown-toggle").click(function() {
		$(this).parent().toggleClass("open");
	});

});