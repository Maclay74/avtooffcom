<?php
    echo includeJsFile("validate.js");
    echo includeJsFile("requestForm.js");
    $user = USER::getInstance();




    $form = new Form();
    $form->setMethod("POST");
    $form->setName("requestForm");
    $form->addClass("form-horizontal");
    if ($_GET['id']) {
        $form->setHeader("Просмотр заявки");
        $form->addHide($_GET['id'],"requestId");
    }
    else
        $form->setHeader("Новая заявка");
    $form->setValues($data[0]);

    $form->addInput("second_name","Фамилия","text", "text","Иванов","","large",true);
    $form->addInput("first_name","Имя","text", "text","Иван","","large",true);
    $form->addInput("third_name","Отчество","text","","Иванович","","large",false);
    $form->addDropDown("doc_type","Тип документа",array(
        array("id"=>1, "name"=>"Св-во о регистрации"),
        array("id"=>2, "name"=>"Паспорт ТС")
    ));

    $form->addInput("seria","Серия","text","text","78УЕ","","large",true);
    $form->addInput("number","Номер","text","doc_number","423634","","large",true);
    $form->addInput("issued_by","Выдано кем","text","text","ОП МРЭО-4","","large",true);
    //$form->addInput("issued_when","Выдано когда","text","text","12.15.2012","","large",true);
    $form->addDate("issued_when","Выдано когда");
    $form->addInput("reg_number","Гос. знак","text","","Н231РА98","","large",true);
    $form->addInput("VIN_number","VIN-номер","text","VIN","WVWZZZ9NZVY239670","","large",true);
    $form->addInput("brand","Марка","text","text","NISSAN","","large",true);
    $form->addInput("model","Модель","text","text","TEANA","","large",true);

    $form->addDropDown("category","Категория ТС",array(
        array("id"=>"M1", "name"=>"M1(B)"),
        array("id"=>"M2", "name"=>"M2(D)"),
        array("id"=>"M3", "name"=>"M3(D)"),
        array("id"=>"N1", "name"=>"N1(B)"),
        array("id"=>"N2", "name"=>"N2(C)"),
        array("id"=>"N3", "name"=>"N3(C)"),
        array("id"=>"O1", "name"=>"O1(E)"),
        array("id"=>"O2", "name"=>"O2(E)"),
        array("id"=>"O3", "name"=>"O3(E)"),
        array("id"=>"O4", "name"=>"O4(E)"),
        array("id"=>"A", "name"=>"L(A)"),
    ));
    $form->addInput("year","Год","text","year","2001","","large",true);
    $form->addInput("chassis","Шасси","text","","33070080840595","","large",true);
    $form->addInput("body","Кузов","text","","NP-32536234","","large",true);
    $form->addInput("min_mass","Масса без нагрузки","text","number","1540","","large",true);
    $form->addInput("max_mass","Максимальная масса","text","number","3200","","large",true);
    $form->addInput("mileage","Пробег","text","number","153000","","large",true);
    $form->addInput("wheels","Марка шин","text","text","MATADOR","","large",true);
    $form->addDropDown("fuel_type","Тип топлива",array(
        array("id"=>1, "name"=>"Бензин"),
        array("id"=>2, "name"=>"Дизельное топливо"),
        array("id"=>3, "name"=>"Сжатый газ"),
        array("id"=>4, "name"=>"Сжиженный газ"),

    ));
    $form->addDropDown("break_type","Тип тормозной системы",array(
        array("id"=>1, "name"=>"Гидравлическая"),
        array("id"=>2, "name"=>"Пневматическая"),
        array("id"=>3, "name"=>"Комбинированная"),
        array("id"=>4, "name"=>"Механическая"),

    ));

    if($user->type == 2 || $user->type == 0) {
        $form->addDropDown("validate","Срок действия",array(
            array("id"=>12, "name"=>"Один год"),
            array("id"=>6, "name"=>"Полгода"),
            array("id"=>24, "name"=>"Два года"),
            array("id"=>36, "name"=>"Три года"),

        ));
    }

    $form->addDropDown("comment","Комментарий",array(
        array("id"=>"Очередное ТО", "name"=>"Очередное ТО"),
        array("id"=>"Такси", "name"=>"Такси"),
        array("id"=>"Учебная езда", "name"=>"Учебная езда"),
        array("id"=>"Опасные грузы", "name"=>"Опасные грузы"),

    ));



?>

<div class="well offset2 span7">
    <?php echo $form->render(); ?>

    <div id="response"></div>
    <?php if($user->type == 0 || $user->type == 2 || $user->type == 3 ):?>
            <a id="submit" style="margin-left: 10px; " name="submit" onclick="validateForm('requestForm',1);" class="btn btn-default pull-right" >Сохранить </a>
    <?php endif ?>

    <?php if($user->type == 2 || $user->type == 0):?>
        <?php if(!strlen($data[0]['card_number'])):?>
             <a id="submit" name="submit" onclick="save();" class="btn btn-default pull-right">Отправить в ЕАИСТО</a>
        <?php endif ?>
         <?php if($data[0]['status_work'] == 5):?>
            <a id="submit" style="margin-left: 10px;"  name="submit" onclick="deleteRequest();" class="btn btn-default pull-right"> Подтвердить удаление</a>
            <a id="submit" name="submit" onclick="cancelRequest();" class="btn btn-default pull-right">Отменить удаление</a>
        <?php endif ?>
    <?php endif ?>


</div>

