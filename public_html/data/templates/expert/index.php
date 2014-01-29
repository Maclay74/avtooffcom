<?php

echo includeJsFile("expert.js");

$filterRequest= new Collapse();


$filterRequest->setData(array("Поиск" => renderOut("components/Search.html",array($data[5],$data[6]))),"Filter");

?>

<input name="page" id = "page" value ='1' hidden="true"/>

<div class="well">
    <div style="width: 300px; float:left;">
        <h4>Обработка заявок</h4>
    </div> <br><br>

    <?php
    $filterRequest->render();
    ?>


    <div id="requestTable">

    </div>


</div>

<!-- Button to trigger modal -->


<!-- Modal -->
<div id="agentInfo" class="modal hide fade" style="width: 220px; left: 60%;" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">Дерево агента</h3>
    </div>
    <div class="modal-body">
        <p> </p>
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



