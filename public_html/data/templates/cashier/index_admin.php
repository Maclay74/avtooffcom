<?php

echo includeJsFile("cashier.js");

$filterRequest= new Collapse();


$filterRequest->setData(array("Фильтр"=>renderOut("components/CashierPanel.html",array($data[5],$data[6],'agents' => $data['agents'])),"Поиск" => renderOut("components/Search.html",array($data[5],$data[6]))),"Filter");

?>



<div class="well">
        <div style="width: 300px; float:left;">
            <h4>Оплата заявок</h4>
        </div> <br><br>

        <?php
        $filterRequest->render();
        ?>
    <div>
        Итого: <strong id='sum'>0</strong> рублей  <a onclick="sendSelected();" class="btn btn-primary">Оплатить</a><br><br>
    </div>

       <div id="requestTable">

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



