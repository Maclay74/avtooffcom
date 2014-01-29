<?php

echo includeJsFile("agent.js");

$filterRequest= new Collapse();

//$filterRequest->setData(array("Фильтр"=>renderOut("components/Filter.html",array($data[5],$data[6])),"Поиск" => renderOut("components/Search.html",array($data[5],$data[6])), "Статистика"=>renderOut("components/Stat.html")),"Filter");
$filterRequest->setData(array("Фильтр"=>renderOut("components/Filter.html",array($data[5],$data[6])),"Поиск" => renderOut("components/Search.html",array($data[5],$data[6]))),"Filter");

?>



<div class="row">	
	<div class="span12">
		<div class="tabbable tabs-left">
			<ul class="nav nav-tabs">
                <li class ="active"><a href="#tab2" data-toggle="tab">Заявки</a></li>
                <li><a href="#tab1" data-toggle="tab">Агенты</a></li>
                <li><a href="#tab3" data-toggle="tab">Прайсы</a></li>
                <li><a href="#tab4" data-toggle="tab">Система</a></li>
			</ul>
		
			<div class="tab-content">
				<div class="tab-pane " id="tab1">
					<div class="well"> 
						<ul class="nav nav-pills">
						 
							<div style="width: 300px; float:left;">
								<h4>Агенты</h4>
							</div>
							<div style="float:right; padding-top:3px;">
									<li><a class="btn btn-primary"  href="?event=agent&action=form" ><i class=" icon-plus icon-white"></i> Добавить</a></li>


							</div>
								
						</ul>
                        <?php echo $data[0];?>
					
				    </div>
			    </div>

                <div class="tab-pane active" id="tab2">
                    <div class="well">
                        <ul class="nav nav-pills">

                            <div style="width: 300px; float:left;">
                                <h4>Заявки</h4>
                            </div>

                            <div style="float:right; padding-top:3px;">
                                <li><a class="btn btn-primary" href="?event=request&action=form" ><i class=" icon-plus icon-white"></i> Добавить</a></li>
                            </div>

                        </ul>

                        <?php
                            $filterRequest->render();
                        ?>

                        <div id="requestTable">

                        </div>

                    </div>
                </div>

                <div class="tab-pane" id="tab3">
                    <div class="well">
                        <ul class="nav nav-pills">

                            <div style="width: 300px; float:left;">
                                <h4>Прайсы</h4>
                            </div>
                            <div style="float:right; padding-top:3px;">
                                <li><a class="btn btn-primary"  href="?event=price&action=form" ><i class=" icon-plus icon-white"></i> Добавить</a></li>


                            </div>

                        </ul>

                        <?php echo $data[1];?>



                    </div>
                </div>

            </div>
	</div>
</div>


    <div id="deleteDialog" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="myModalLabel">Удаление заявки</h3>
        </div>
        <div class="modal-body">
            <p class="text"> </p>
        </div>
        <div class="modal-footer">
            <button class="btn" data-dismiss="modal" aria-hidden="true">Отмена</button>
            <button id="confirm" onclick="" class="btn btn-primary">Удалить</button>
        </div>
    </div>
<script>
	$(function() {
    $('body').tooltip({
        selector: "[rel=tooltip]", // можете использовать любой селектор
        placement: "top"
    });
	});


    $( document ).ready(function()
     {
          updateRequests(1);

     });



</script>



