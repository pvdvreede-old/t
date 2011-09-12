$(document).ready(function() {      
      
      toggleFields();
  
      $("#id_rollover").click(function(e) {
	  
	  toggleFields();
      });
  
});

function toggleFields() {
     current = $("#id_rollover").attr("value");
     current = (current == "on") ? false : true;
     $("#id_rollover_start").attr("disabled", current);
     $("#id_rollover_initial_amount").attr("disabled", current); 
};