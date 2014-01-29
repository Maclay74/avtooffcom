   
<div id='myModal' style="width:580px; " class='modal hide fade' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
  <div class='modal-header'>
	<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
	<h3 id='myModalLabel'>Modal header</h3>
  </div>
  <div id="modal_content" style="max-height:none; overflow:auto; height:500px;" class='modal-body'>
	<p>Загрузка...</p>
  </div>
  <div class='modal-footer' style="/*height: 40px;*/">
	<div id="modal_response">
		
	</div>
	<button style="margin-top: 5px;" id="cancel_modal_button" class='btn' data-dismiss='modal' aria-hidden='true'>Отмена</button>
	<button style="margin-top: 5px;" id="modal_button" class='btn btn-primary'>Save changes</button>
	</div> 
	
  
</div>

<script>
	$(document).ready(function() {
		$('#modal_response').hide();
	});
	
	function NewStation()
	{		
		$('#modal_response').hide();
		$('#modal_content').height("500px");
		$('#modal_content').load("?event=admin&action=new_station&no_template", function()
		{
			$('#myModal').modal('show');
		});
		
		document.getElementById("myModalLabel").innerHTML="<p>Добавить станцию</p>";
		document.getElementById("modal_button").innerHTML="Добавить";
		document.getElementById("modal_button").setAttribute("onclick","isValid();");
	}	
	 
	function RemoveStation(id)
	{		
		$('#modal_response').hide();
		$('#modal_content').height("30px");
		document.getElementById("modal_response").innerHTML="";
		$('#modal_content').load("?event=admin&action=remove_station&no_template&id="+id);
		$('#myModal').modal('show');
		document.getElementById("myModalLabel").innerHTML="<p>Удалить станцию</p>";
		document.getElementById("modal_button").innerHTML="Удалить";
		document.getElementById("modal_button").setAttribute("onclick","Delete();");
	}
	
	function NewRequest()
	{		
		$('#modal_button').show();
		$('#cancel_modal_button').show();
		$('#modal_response').hide();
		$('#modal_content').height("500px");
		$('#modal_content').load("?event=agent&action=new_request&no_template");
		$('#myModal').modal('show');
		document.getElementById("myModalLabel").innerHTML="<p>Добавить заявку</p>";
		document.getElementById("modal_button").innerHTML="Добавить";
		document.getElementById("modal_button").setAttribute("onclick","isValid();");
	}
	
	function CancelRequest(id)
	{		
		$('#modal_button').show();
		$('#cancel_modal_button').show();
		$('#modal_response').hide();
		$('#modal_content').load("?event=agent&action=cancel_request&no_template&id="+id);
		$('#myModal').modal('show');
		$('#modal_content').height("30px");
		document.getElementById("myModalLabel").innerHTML="<p>Отменить заявку</p>";
		document.getElementById("modal_button").innerHTML="Отменить";
		document.getElementById("modal_button").setAttribute("onclick","Cancel();");
	}
	
	function RemoveRequest(id)
	{		
		$('#modal_button').show();
		$('#cancel_modal_button').show();
		$('#modal_response').hide();
		$('#modal_content').load("?event=agent&action=remove_request&no_template&id="+id);
		$('#myModal').modal('show');
		$('#modal_content').height("30px");
		document.getElementById("myModalLabel").innerHTML="<p>Удалить заявку</p>";
		document.getElementById("modal_button").innerHTML="Удалить";
		document.getElementById("modal_button").setAttribute("onclick","Remove();");
	}
	
	function EditRequest(id)
	{		
		$('#modal_button').show();
		$('#cancel_modal_button').show();
		$('#modal_response').hide();
		$('#modal_content').load("?event=agent&action=edit_request&no_template&id="+id);
		$('#myModal').modal('show');
		$('#modal_content').height("500px");
		document.getElementById("myModalLabel").innerHTML="<p>Изменить заявку</p>";
		document.getElementById("modal_button").innerHTML="Сохранить";
		document.getElementById("modal_button").setAttribute("onclick","Save();");
	}
	
	function Start()
	{		
		$('#modal_response').hide();
		$('#myModal').modal('show');
		$('#modal_content').load("?event=agent&action=start&no_template");
		$('#modal_content').height("500px");
		$('#modal_button').hide();
		$('#cancel_modal_button').hide();

		
		document.getElementById("myModalLabel").innerHTML="<h2>Добро пожаловать в систему АСТО</h2>";
		document.getElementById("modal_button").innerHTML="Добавить";

	}
	
	function NewAgent()
	{		
		$('#modal_button').show();
		$('#cancel_modal_button').show();
		$('#modal_response').hide();
		$('#modal_content').height("500px");
		$('#modal_content').load("?event=station&action=new_agent&no_template");
		$('#myModal').modal('show');
		document.getElementById("myModalLabel").innerHTML="<p>Добавить агента</p>";
		document.getElementById("modal_button").innerHTML="Добавить";
		document.getElementById("modal_button").setAttribute("onclick","isValid();");
	}
	
	function RemoveAgent(id)
	{		
		$('#modal_button').show();
		$('#cancel_modal_button').show();
		$('#modal_response').hide();
		$('#modal_content').load("?event=station&action=remove_agent&no_template&id="+id);
		$('#myModal').modal('show');
		$('#modal_content').height("30px");
		document.getElementById("myModalLabel").innerHTML="<p>Удалить агента</p>";
		document.getElementById("modal_button").innerHTML="Удалить";
		document.getElementById("modal_button").setAttribute("onclick","Remove();");
	}
	
	function EditAgent(id)
	{		
		$('#modal_button').show();
		$('#cancel_modal_button').show();
		$('#modal_response').hide();
		$('#modal_content').load("?event=station&action=edit_agent&no_template&id="+id);
		$('#myModal').modal('show');
		$('#modal_content').height("500px");
		document.getElementById("myModalLabel").innerHTML="<p>Изменить агента</p>";
		document.getElementById("modal_button").innerHTML="Сохранить";
		document.getElementById("modal_button").setAttribute("onclick","isValid();");
	}
	
	function NewExpert()
	{		
		$('#modal_button').show();
		$('#cancel_modal_button').show();
		$('#modal_response').hide();
		$('#modal_content').height("400px");
		$('#modal_content').load("?event=station&action=new_expert&no_template");
		$('#myModal').modal('show');
		document.getElementById("myModalLabel").innerHTML="<p>Добавить эксперта</p>";
		document.getElementById("modal_button").innerHTML="Добавить";
		document.getElementById("modal_button").setAttribute("onclick","isValid();");
	}
	
	function RemoveExpert(id)
	{		
		$('#modal_button').show();
		$('#cancel_modal_button').show();
		$('#modal_response').hide();
		$('#modal_content').load("?event=station&action=remove_expert&no_template&id="+id);
		$('#myModal').modal('show');
		$('#modal_content').height("30px");
		document.getElementById("myModalLabel").innerHTML="<p>Удалить эксперта</p>";
		document.getElementById("modal_button").innerHTML="Удалить";
		document.getElementById("modal_button").setAttribute("onclick","Remove();");
	}
	
	function EditExpert(id)
	{		
		$('#modal_button').show();
		$('#cancel_modal_button').show();
		$('#modal_response').hide();
		$('#modal_content').load("?event=station&action=edit_expert&no_template&id="+id);
		$('#myModal').modal('show');
		$('#modal_content').height("400px");
		document.getElementById("myModalLabel").innerHTML="<p>Изменить эксперта</p>";
		document.getElementById("modal_button").innerHTML="Сохранить";
		document.getElementById("modal_button").setAttribute("onclick","isValid();");
	}
	
	function NewManager()
	{		
		$('#modal_button').show();
		$('#cancel_modal_button').show();
		$('#modal_response').hide();
		$('#modal_content').height("250px");
		$('#modal_content').load("?event=station&action=new_manager&no_template");
		$('#myModal').modal('show');
		document.getElementById("myModalLabel").innerHTML="<p>Добавить менеджера</p>";
		document.getElementById("modal_button").innerHTML="Добавить";
		document.getElementById("modal_button").setAttribute("onclick","isValid();");
	}
	
	function RemoveManager(id)
	{		
		$('#modal_button').show();
		$('#cancel_modal_button').show();
		$('#modal_response').hide();
		$('#modal_content').load("?event=station&action=remove_manager&no_template&id="+id);
		$('#myModal').modal('show');
		$('#modal_content').height("30px");
		document.getElementById("myModalLabel").innerHTML="<p>Удалить менеджера</p>";
		document.getElementById("modal_button").innerHTML="Удалить";
		document.getElementById("modal_button").setAttribute("onclick","Remove();");
	}
	
	function EditManager(id)
	{		
		$('#modal_button').show();
		$('#cancel_modal_button').show();
		$('#modal_response').hide();
		$('#modal_content').load("?event=station&action=edit_manager&no_template&id="+id);
		$('#myModal').modal('show');
		$('#modal_content').height("250px");
		document.getElementById("myModalLabel").innerHTML="<p>Изменить менеджера</p>";
		document.getElementById("modal_button").innerHTML="Сохранить";
		document.getElementById("modal_button").setAttribute("onclick","isValid();");
	}
	
	function FormRequest(id)
	{		
		$('#modal_button').show();
		$('#cancel_modal_button').show();
		$('#modal_response').hide();
		$('#myModal').modal('show');
		$('#modal_content').height("500px");
		document.getElementById("myModalLabel").innerHTML="<p>Заявка</p>";
		document.getElementById("modal_button").innerHTML="Отправить в ЕАИСТО";
		$('#modal_content').load("?event=station&action=form_request&no_template&id="+id);
		document.getElementById("modal_button").setAttribute("onclick","isValid();");
	}
	
	function RemoveRequest_Ex(id)
	{		
		$('#modal_button').show();
		$('#cancel_modal_button').show();
		$('#modal_response').hide();
		$('#modal_content').load("?event=station&action=remove_request&no_template&id="+id);
		$('#myModal').modal('show');
		$('#modal_content').height("30px");
		document.getElementById("myModalLabel").innerHTML="<p>Удалить менеджера</p>";
		document.getElementById("modal_button").innerHTML="Удалить";
		document.getElementById("modal_button").setAttribute("onclick","Remove();");
	}
	
	function CancelRequest_Ex(id)
	{		
		$('#modal_button').show();
		$('#cancel_modal_button').show();
		$('#modal_response').hide();
		$('#modal_content').load("?event=station&action=cancel_request&no_template&id="+id);
		$('#myModal').modal('show');
		$('#modal_content').height("30px");
		document.getElementById("myModalLabel").innerHTML="<p>Отклонинть заявку</p>";
		document.getElementById("modal_button").innerHTML="Отклонить";
		document.getElementById("modal_button").setAttribute("onclick","Cancel();");
	}
	
	function NewRequest_Ex()
	{		
		$('#modal_button').show();
		$('#cancel_modal_button').show();
		$('#modal_response').hide();
		$('#modal_content').height("500px");
		$('#modal_content').load("?event=station&action=new_request&no_template");
		$('#myModal').modal('show');
		document.getElementById("myModalLabel").innerHTML="<p>Добавить заявку</p>";
		document.getElementById("modal_button").innerHTML="Добавить";
		document.getElementById("modal_button").setAttribute("onclick","isValid();");
	}
	
	function Search()
	{		
		$('#modal_response').hide();
		$('#myModal').modal('show');
		//$('#modal_content').load("?event=agent&action=start&no_template");
		$('#modal_content').height("500px");
		
		document.getElementById("myModalLabel").innerHTML="Поиск";
		document.getElementById("modal_button").innerHTML="Найти";

	}
	
	
</script>













