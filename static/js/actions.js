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
	
	/**
	 * Function to set action to delete on transactions for deletion
	 */
	$("#delete-button").click(function() {
		$("input[name='action']").val("delete");	  
		$("#trans-list-form").submit();
	});
	
	/**
	 * Function to hide and show checkbox context items.
	 */
	$("input[type='checkbox']").click(function() {
		var found = false;
		$("input[type='checkbox']").each(function(i) {
		    if ($(this).attr("checked")) {
			$("#checkbox-actions").slideDown('slow');
			found = true;
			return;
		    }	
		});
		if (!found)
		  $("#checkbox-actions").slideUp('slow');
	});

});