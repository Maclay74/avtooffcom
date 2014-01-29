<?php

$table= new Table();
$MYSQL = DB::getInstance();

$data= $MYSQL->get("docs",array("*"),array("agent"=>$_SESSION['login']),0);
$table->setHeaders(array("seller_name"=>"Продавец","buyer_name"=>"Покупатель","brand"=>"Автомобиль","reg_number"=>"Гос. знак","date"=>"Дата оформления"));
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

    <link rel="stylesheet" href="http://img.artlebedev.ru/;-)/links.css" /></head>
<body>

<div class="main">
<a class="btn pull-right" href = 'http://avto-office.com/docs.php?logout'> Выйти</a>
<h3> Конструктор документов</h3>

<legend>  Мои документы   <button onclick="newDocument()" class="btn "><i class="icon-plus"></i></button> </legend>
<?php $table->render();?>


<form method ="POST" id="newDocument" class="form-horizontal" >
<fieldset>

<div class="page1">
    <legend> Продавец</legend>
    <!-- Text input-->
    <div class="control-group">
        <label class="control-label" for="seller_name">ФИО полностью</label>
        <div class="controls">
            <input validatod="text" id="seller_name" name="seller_name" type="text" placeholder="Иванов Иван Иванович" class="input-xlarge" required="">
            <i id="okay" style="display:none" class="icon-ok"></i>
            <i id="remove" style="display:none" class="icon-remove"></i>
        </div>
    </div>

    <!-- Text input-->
    <div class="control-group">
        <label class="control-label" for="seller_date">Дата рождения</label>
        <div class="controls">
            <input validatod="text" id="seller_date" name="seller_date" type="text" placeholder="12 декабря 1968" class="input-xlarge" required="">
            <i id="okay" style="display:none" class="icon-ok"></i>
            <i id="remove" style="display:none" class="icon-remove"></i>
        </div>
    </div>

    <!-- Text input-->
    <div class="control-group">
        <label class="control-label" for="seller_address">Адрес</label>
        <div class="controls">
            <input validatod="text" id="seller_address" name="seller_address" type="text" placeholder="г. Москва, ул. Пушкина, д. 7. кв. 12" class="input-xlarge" required="">
            <i id="okay" style="display:none" class="icon-ok"></i>
            <i id="remove" style="display:none" class="icon-remove"></i>
        </div>
    </div>

    <!-- Text input-->
    <div class="control-group">
        <label class="control-label" for="seller_seria">Серия паспорта</label>
        <div class="controls">
            <input validatod="number" id="seller_seria" name="seller_seria" type="text" placeholder="5232" class="input-xlarge" required="">
            <i id="okay" style="display:none" class="icon-ok"></i>
            <i id="remove" style="display:none" class="icon-remove"></i>
        </div>
    </div>

    <!-- Text input-->
    <div class="control-group">
        <label class="control-label" for="seller_number">Номер паспорта</label>
        <div class="controls">
            <input  validatod="number"  id="seller_number" name="seller_number" type="text" placeholder="634523" class="input-xlarge" required="">
            <i id="okay" style="display:none" class="icon-ok"></i>
            <i id="remove" style="display:none" class="icon-remove"></i>
        </div>
    </div>

    <!-- Text input-->
    <div class="control-group">
        <label class="control-label" for="seller_issued">Место и дата выдачи</label>
        <div class="controls">
            <input  validatod="text" id="seller_issued" name="seller_issued" type="text" placeholder="УФМС г. Москва, 12.12.1968" class="input-xlarge" required="">
            <i id="okay" style="display:none" class="icon-ok"></i>
            <i id="remove" style="display:none" class="icon-remove"></i>
        </div>
    </div>


</div>
<div class="page2">
    <legend> Покупатель</legend>
    <!-- Text input-->
    <div class="control-group">
        <label class="control-label" for="buyer_name">ФИО полностью</label>
        <div class="controls">
            <input validatod="text" id="buyer_name" name="buyer_name" type="text" placeholder="Иванов Иван Иванович" class="input-xlarge" required="">
            <i id="okay" style="display:none" class="icon-ok"></i>
            <i id="remove" style="display:none" class="icon-remove"></i>
        </div>
    </div>

    <!-- Text input-->
    <div class="control-group">
        <label class="control-label" for="buyer_date">Дата рождения</label>
        <div class="controls">
            <input validatod="text" id="buyer_date" name="buyer_date" type="text" placeholder="12 декабря 1968" class="input-xlarge" required="">
            <i id="okay" style="display:none" class="icon-ok"></i>
            <i id="remove" style="display:none" class="icon-remove"></i>
        </div>
    </div>

    <!-- Text input-->
    <div class="control-group">
        <label class="control-label" for="buyer_address">Адрес</label>
        <div class="controls">
            <input validatod="text" id="buyer_address" name="buyer_address" type="text" placeholder="ул. Пушкина, д. 7. кв. 12" class="input-xlarge" required="">
            <i id="okay" style="display:none" class="icon-ok"></i>
            <i id="remove" style="display:none" class="icon-remove"></i>
        </div>
    </div>

    <!-- Text input-->
    <div class="control-group">
        <label class="control-label" for="buyer_seria">Серия паспорта</label>
        <div class="controls">
            <input validatod="number" id="buyer_seria" name="buyer_seria" type="text" placeholder="5232" class="input-xlarge" required="">
            <i id="okay" style="display:none" class="icon-ok"></i>
            <i id="remove" style="display:none" class="icon-remove"></i>
        </div>
    </div>

    <!-- Text input-->
    <div class="control-group">
        <label class="control-label" for="buyer_number">Номер паспорта</label>
        <div class="controls">
            <input validatod="number" id="buyer_number" name="buyer_number" type="text" placeholder="634523" class="input-xlarge" required="">
            <i id="okay" style="display:none" class="icon-ok"></i>
            <i id="remove" style="display:none" class="icon-remove"></i>
        </div>
    </div>

    <!-- Text input-->
    <div class="control-group">
        <label class="control-label" for="buyer_issued">Место и дата выдачи</label>
        <div class="controls">
            <input validatod="text" id="buyer_issued" name="buyer_issued" type="text" placeholder="УФМС г. Москва, 12.12.1968" class="input-xlarge" required="">
            <i id="okay" style="display:none" class="icon-ok"></i>
            <i id="remove" style="display:none" class="icon-remove"></i>
        </div>
    </div>
</div>
<div class="page3">
    <!-- Form Name -->
    <legend>Автомобиль</legend>

    <!-- Text input-->
    <div class="control-group">
        <label class="control-label" for="reg_number">Регистрационный знак</label>
        <div class="controls">
            <input validatod="text" id="reg_number" name="reg_number" type="text" placeholder="Х150ХХ98" class="input-xlarge" required="">
            <i id="okay" style="display:none" class="icon-ok"></i>
            <i id="remove" style="display:none" class="icon-remove"></i>
        </div>
    </div>

    <!-- Text input-->
    <div class="control-group">
        <label class="control-label" for="brand">Марка, модель ТС</label>
        <div class="controls">
            <input validatod="text" id="brand" name="brand" type="text" placeholder="ЛАДА КАЛИНА" class="input-xlarge" required="">
            <i id="okay" style="display:none" class="icon-ok"></i>
            <i id="remove" style="display:none" class="icon-remove"></i>
        </div>
    </div>

    <!-- Text input-->
    <div class="control-group">
        <label class="control-label" for="vin_number">VIN-номер</label>
        <div class="controls">
            <input validatod="VIN" id="vin_number" name="vin_number" type="text" placeholder="WWWKVLFLFLFLFLFTT" class="input-xlarge">
            <i id="okay" style="display:none" class="icon-ok"></i>
            <i id="remove" style="display:none" class="icon-remove"></i>
            <p class="help-block">17 знаков</p>

        </div>
    </div>

    <!-- Select Basic -->
    <div class="control-group">
        <label class="control-label" for="Категория ТС">Категория ТС</label>
        <div class="controls">
            <select id="category" name="category" class="input-xlarge">
                <option value="B">B</option>
                <option value="A">A</option>
                <option value="C">C</option>
                <option value="D">D</option>
                <option value="E">E</option>
            </select>
        </div>
    </div>

    <!-- Text input-->
    <div class="control-group">
        <label class="control-label" for="year">Год выпуска</label>
        <div class="controls">
            <input validatod="number" id="year" name="year" type="text" placeholder="1999" class="input-xlarge" required="">
            <i id="okay" style="display:none" class="icon-ok"></i>
            <i id="remove" style="display:none" class="icon-remove"></i>
        </div>
    </div>

    <!-- Text input-->
    <div class="control-group">
        <label class="control-label" for="engine">Модель, № двигателя</label>
        <div class="controls">
            <input  id="engine" name="engine" type="text" placeholder="WWWKVLFLFLFLFLFTT" class="input-xlarge">
            <i id="okay" style="display:none" class="icon-ok"></i>
            <i id="remove" style="display:none" class="icon-remove"></i>
        </div>
    </div>

    <!-- Text input-->
    <div class="control-group">
        <label class="control-label" for="wheels">Шасси (рама) №</label>
        <div class="controls">
            <input  id="wheels" name="wheels" type="text" placeholder="GSDD-833" class="input-xlarge">
            <i id="okay" style="display:none" class="icon-ok"></i>
            <i id="remove" style="display:none" class="icon-remove"></i>
        </div>
    </div>

    <!-- Text input-->
    <div class="control-group">
        <label class="control-label" for="body">Кузов (прицеп) №</label>
        <div class="controls">
            <input  id="body" name="body" type="text" placeholder="FF-23421" class="input-xlarge">
            <i id="okay" style="display:none" class="icon-ok"></i>
            <i id="remove" style="display:none" class="icon-remove"></i>
        </div>
    </div>

    <!-- Text input-->
    <div class="control-group">
        <label class="control-label" for="color">Цвет кузова (кабины)</label>
        <div class="controls">
            <input validatod="text" id="color" name="color" type="text" placeholder="Белый" class="input-xlarge" required="">
            <i id="okay" style="display:none" class="icon-ok"></i>
            <i id="remove" style="display:none" class="icon-remove"></i>
        </div>
    </div>

    <!-- Text input-->
    <div class="control-group">
        <label class="control-label" for="power">Мощность двигателя л.с. (кВт)</label>
        <div class="controls">
            <input validatod="text" id="power" name="power" type="text" placeholder="79/142" class="input-xlarge" required="">
            <i id="okay" style="display:none" class="icon-ok"></i>
            <i id="remove" style="display:none" class="icon-remove"></i>
        </div>
    </div>

    <!-- Text input-->
    <div class="control-group">
        <label class="control-label" for="volume">Рабочий объем двигателя, куб. см.</label>
        <div class="controls">
            <input validatod="text" id="volume" name="volume" type="text" placeholder="1,2" class="input-xlarge" required="">
            <i id="okay" style="display:none" class="icon-ok"></i>
            <i id="remove" style="display:none" class="icon-remove"></i>
        </div>
    </div>

    <!-- Select Basic -->
    <div class="control-group">
        <label class="control-label" for="engine_type">Тип двигателя</label>
        <div class="controls">
            <select id="engine_type" name="engine_type" class="input-xlarge">
                <option value="БЕНЗИНОВЫЙ">Бензиновый</option>
                <option value="ДИЗЕЛЬНЫЙ">Дизельный</option>
                <option value="ПРИРОДНЫЙ ГАЗ">Природный газ</option>
                <option value="СЖИЖЕННЫЙ ГАЗ">Сжиженный газ</option>
            </select>
        </div>
    </div>

    <!-- Text input-->
    <div class="control-group">
        <label class="control-label" for="class">Экологический класс</label>
        <div class="controls">
            <input validatod="text" id="class" name="class" type="text" placeholder="Пятый" class="input-xlarge" required="">
            <i id="okay" style="display:none" class="icon-ok"></i>
            <i id="remove" style="display:none" class="icon-remove"></i>
        </div>
    </div>

    <!-- Text input-->
    <div class="control-group">
        <label class="control-label" for="max_mass">Разрешенная максимальная масса, кг.</label>
        <div class="controls">
            <input validatod="number" id="max_mass" name="max_mass" type="text" placeholder="1350" class="input-xlarge" required="">
            <i id="okay" style="display:none" class="icon-ok"></i>
            <i id="remove" style="display:none" class="icon-remove"></i>
        </div>
    </div>

    <!-- Text input-->
    <div class="control-group">
        <label class="control-label" for="min_mass">Масса без нагрузки, кг. </label>
        <div class="controls">
            <input validatod="number" id="min_mass" name="min_mass" type="text" placeholder="980" class="input-xlarge" required="">
            <i id="okay" style="display:none" class="icon-ok"></i>
            <i id="remove" style="display:none" class="icon-remove"></i>
        </div>
    </div>

    <!-- Text input-->
    <div class="control-group">
        <label class="control-label" for="passport">Паспорт ТС</label>
        <div class="controls">
            <input validatod="text" id="passport" name="passport" type="text" placeholder="78УУ 143634 М? ?­О-4 12.12.12" class="input-xlarge" required="">
            <i id="okay" style="display:none" class="icon-ok"></i>
            <i id="remove" style="display:none" class="icon-remove"></i>
            <p class="help-block">Серия, номер. когда и кем выдан</p>

        </div>
    </div>

    <!-- Text input-->
    <div class="control-group">
        <label class="control-label" for="registration">Свидетельство о регистрации ТС</label>
        <div class="controls">
            <input validatod="text" id="registration" name="registration" type="text" placeholder="78УУ 143634 М? ?­О-4 12.12.12" class="input-xlarge" required="">
            <i id="okay" style="display:none" class="icon-ok"></i>
            <i id="remove" style="display:none" class="icon-remove"></i>
            <p class="help-block">Серия, номер, когда и кем выдан</p>

        </div>
    </div>

</div>
<div class="page4">
    <!-- Form Name -->
    <legend> Цена и город</legend>

    <!-- Text input-->
    <div class="control-group">
        <label class="control-label" for="city">Город</label>
        <div class="controls">
            <input validatod="text" id="city" name="city" type="text" placeholder="Санкт-Петербург" class="input-xlarge" required="">
            <i id="okay" style="display:none" class="icon-ok"></i>
            <i id="remove" style="display:none" class="icon-remove"></i>
        </div>
    </div>

    <!-- Text input-->
    <div class="control-group">
        <label class="control-label" for="price_number">Стоимость цифрами</label>
        <div class="controls">
            <input validatod="number" id="price_number" name="price_number" type="text" placeholder="153000" class="input-xlarge" required="">
            <i id="okay" style="display:none" class="icon-ok"></i>
            <i id="remove" style="display:none" class="icon-remove"></i>
        </div>
    </div>

    <!-- Text input-->
    <div class="control-group">
        <label class="control-label" for="price_word">Стоимость словами</label>
        <div class="controls">
            <input validatod="text" id="price_word" name="price_word" type="text" placeholder="Сто пятьдесят три тысячи " class="input-xlarge" required="">
            <i id="okay" style="display:none" class="icon-ok"></i>
            <i id="remove" style="display:none" class="icon-remove"></i>
        </div>
    </div>

    <!-- Button -->
    <div class="control-group">
        <label class="control-label" for="submit"></label>
        <div class="controls">
            <button id="submit" name="submit" class="btn btn-primary">Отправить</button>
        </div>
    </div>
</div>


</fieldset>
</form>

<ul class="pager">
    <li><a onclick="previousPage();"> Назад</a></li>
    <li><a onclick="nextPage();"> Далее</a></li>
</ul>



</div>


<script type="text/javascript">

    var page=1;
    $(document).ready(function(){
        $('.page1').hide();
        $('.page2').hide();
        $('.page3').hide();
        $('.page4').hide();
        $('.pager').hide();
    });

    function newDocument(){
        $('.page'+page).fadeIn();
        $('.pager').fadeIn();

    }

    function nextPage() {
        if (page==4) return;
        if(!validateForm("page"+page)) return;
        $('.page'+page).fadeOut(function(){
            page++;
            $('.page'+page).fadeIn();

        });

    }

    function previousPage() {
        if (page==1) return;
        $('.page'+page).fadeOut(function(){
            page--;
            $('.page'+page).fadeIn();
            console.log(page);
        });

    }

    function validateTypo(element, pattern,vin) {
        if(!pattern)
            pattern = /\S+/

        if (!element)
            return false;
        value= $(element).val();
        parent = $(element).parent().parent();


        if (value.match(pattern)) {
            if (vin) {
                if (value.length==17) {
                    parent.find("#okay").attr("style","");
                    parent.find("#remove").attr("style","display:none");
                    return true;
                }
                else {
                    parent.find("#okay").attr("style","display:none");
                    parent.find("#remove").attr("style","");
                    return false;

                }

            }
            else
            {
                parent.find("#okay").attr("style","");
                parent.find("#remove").attr("style","display:none");
                return true;
            }
        }

        parent.find("#okay").attr("style","display:none");
        parent.find("#remove").attr("style","");
        return false;
    }

    function validateForm(name) {
        result = true;

        form = $("."+name);

        inputs = form.find($("input"));


        for (i=0; i < inputs.length;i++) {
            name = inputs[i].getAttribute("id");
            validate = inputs[i].getAttribute("validatod");
            if (validate) {
                if (validate=="text")
                    if (!validateTypo($("#"+name),/[-,._ a-zA-Zа-яА-Я//]+/)) result = false;

                if (validate=="login")
                    if (!validateTypo($("#"+name),/[_a-zA-Z0-9]{3,15}/)) result = false;

                if (validate=="VIN")
                    if (!validateTypo($("#"+name),/[A-Z0-9]{17}/,1)) result = false;

                if (validate=="password")
                    if (!validateTypo($("#"+name),/[_a-zA-Z0-9]{4,16}/)) result = false;

                if (validate=="number")
                    if (!validateTypo($("#"+name),/\d+/)) result = false;
            }
        }

        return result;
    }


    function downloadDocument(id) {
        window.location.href ="/docs.php?document="+id;
    }

</script>

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