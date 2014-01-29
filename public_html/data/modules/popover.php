<script>

function popover()
{

	
	
	
}

function ChangePassword()
{
	
	var form="";
	obj=window.event.target;
	
    $.get( "?event=station&action=change_password&no_template", function( data ) {
		form=data;
		obj.setAttribute("data-content",form);
		$(obj).popover({html:1});
		
	});

 
		
	
}


</script>

