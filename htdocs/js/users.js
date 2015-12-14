$(document).ready(function() {
   $("#add_to_journal").click(function() {	
	   $.get("ajax/getAddToJournalWindow", function(data){
		   $('#add_to_journal_wrapper').html(data);
	   });
   });
   
   $("#close_add_to_journal").click(function() {
	   $('#add_to_journal_wrapper').html("");
   });
 });
