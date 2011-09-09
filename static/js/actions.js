$(document).ready(function() {
  
	/**
	 * Function to open top corner menus on click.
	 */
	$("a.dropdown-toggle").click(function() {
		$(this).parent().toggleClass("open");
		return;
	});
	
	/**
	 * Function to remove message boxes when the 'x' is clicked.
	 */
	$("a.close").click(function() {
		$(this).parent().remove();
	});
	
	/**
	 * Function to mark all checkboxes as checked when the header checkbox is checked.
	 */
	$("#check-all").click(function() {
		$(".id-checkbox").each(function(i) {
		  if (!$("#check-all").attr("checked")) {
		    $(this).attr("checked", false);
		  } else {
		    $(this).attr("checked", true);
		  }
		});
	});
	
	$("#delete-button").click(function() {
		$("input[name='action']").val("delete");	  
		$("#trans-list-form").submit();
	});

});