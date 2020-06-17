$(document).ready(function(){

	var Special_characters = ["</script>", 
							  "<script", 
							  "script>", 
							  "--", 
							  ">", 
							  ">=", 
							  "<=",  
							  "!=",
							  "COUNT(",
							  "$_POST[",
							  "php?"];

	$('input').on('change', function(){

		if (Special_characters.includes($(this).val()) == true)
		{
			$(this).val("");
			toastr.warning('Detect XSS attack or SQL Injection!');    
		}
	});

	$('textarea').on('change', function(){
		if (Special_characters.includes($(this).val()) == true)
		{
			$(this).val("");
			toastr.warning('Detect XSS attack or SQL Injection!');    
		}
	});
});

