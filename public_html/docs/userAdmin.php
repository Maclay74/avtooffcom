<?php

$table= new Table();
$MYSQL = DB::getInstance();

$data= $MYSQL->get("docs",array("*"),array(),0);
$table->setHeaders(array("agent" => "Агент", "seller_name"=>"Продавец","buyer_name"=>"Покупатель","brand"=>"Автомобиль","reg_number"=>"Гос. знак","date"=>"Дата оформления"));
$table->setData($data);
$table->setClick("downloadDocument");

?>

<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Strict//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml' xml:lang='ru' lang='ru'>
<head>
    <title>Конструктор Документов</title>
    <meta http-equiv='Content-Type' content='text/html; charset=utf-8'/>
    <link href='bootstrap/css/bootstrap.min.css' rel='stylesheet'/>
    <script type='text/javascript' src='http://code.jquery.com/jquery-latest.js'></script>
    <script type='text/javascript' src='bootstrap/js/bootstrap.min.js'></script>
    <style type="text/css">
        body {
            background-color: #f5f5f5;

        }
        .main {
            margin-right: auto;
            margin-left: auto;
            width: 940px;
            margin-top: 30px;
            background-color: #ffffff;
            border-radius: 4px;
            border: 1px solid rgba(0,0,0,0.15);
            -webkit-border-radius: 4px;
            -moz-border-radius: 4px;
            -moz-box-shadow: 0px 0px 6px rgba(0,0,0,0.05);
            -webkit-box-shadow: 0px 0px 6px rgba(0,0,0,0.05);
            box-shadow: 0px 0px 6px rgba(0,0,0,0.05);
            padding: 15px;
        }


    </style>

    <link rel="stylesheet" href="http://img.artlebedev.ru/;-)/links.css" /><link rel="stylesheet" href="http://img.artlebedev.ru/;-)/links.css" /></head>
<body>

<div class="main">
    <a class="btn pull-right underline" href = 'http://avto-office.com/docs.php?logout'> Выйти</a>
    <h3> Конструктор документов</h3>

    <legend>  Мои документы   <button onclick="newDocument()" class="btn "><i class="icon-plus"></i></button> </legend>
    <?php $table->render();?>
</div>

<script type="text/javascript">
    var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
    document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script><script type="text/javascript">
    var pageTracker = _gat._getTracker("UA-1013490-2");
    pageTracker._setDomainName("none");
    pageTracker._initData();
    pageTracker._trackPageview();
</script>
</body>

</html>

<script>
    function downloadDocument(id) {
        window.location.href ="/docs.php?document="+id;
    }
</script>