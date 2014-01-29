
<?php

ini_set("display_errors",1);
error_reporting(E_ALL ^ E_NOTICE);

require_once "data/modules/db.php";
require_once "data/modules/db_ex.php";

require_once "data/modules/user.php";

$MYSQL= DB::getInstance();
$User = User::getInstance();

if (!isset($_GET['id']))
    exit();

define('FPDF_FONTPATH','data/controllers/pdf/FPDF/font/');
require('data/controllers/pdf/fpdf_ext.php');

$row=$MYSQL->get("Requests",array("*"), array("id"=>$_GET['id']));

$first_name=$row["first_name"];
$id=$row["id"];
$card_number=$row["card_number"];
$card_in_number=$row["card_in_number"];
$second_name=$row["second_name"];
$third_name=$row["third_name"];
$doc_type=$row["doc_type"];
$seria=$row["seria"];
$number=$row["number"];
$issued_by=$row["issued_by"];
$issued_when=$row["issued_when"];
$reg_number=$row["reg_number"];
$VIN_number=$row["VIN_number"];
$VIN_exist=$row["VIN_exist"];
$brand=$row["brand"];
$model=$row["model"];
$category=$row["category"];
$year_car=$row["year"];
$chassis=$row["chassis"];
$body=$row["body"];
$min_mass=$row["min_mass"];
$max_mass=$row["max_mass"];
$mileage=$row["mileage"];
$wheels=$row["wheels"];
$fuel_type=$row["fuel_type"];
$break_type=$row["break_type"];
$date_exist=$row["date_exist"];
$date_create=$row["date_create"];

$comment=$row["comment"];
if ($comment=="Очередное ТО")
    $comment="";

$year=substr($issued_when,0,4);
$month=substr($issued_when,5,2);
$day=substr($issued_when,8,2);
$issued_when="$day.$month.$year";

$year=substr($date_exist,0,4);
$month=substr($date_exist,5,2);
$day=substr($date_exist,8,2);
$date_exist="$day.$month.$year";

$year=substr($date_create,0,4);
$month=substr($date_create,5,2);
$day=substr($date_create,8,2);
$date_create="$day$month$year";

if ($doc_type==1)
    $doc_full="Свидетельство о регистрации";
if ($doc_type==2)
    $doc_full="Паспорт ТС";


if ($fuel_type==1)
    $fuel_type="Бензин";
if ($fuel_type==2)
    $fuel_type="Дизельное топливо";
if ($fuel_type==3)
    $fuel_type="Сжатый газ";
if ($fuel_type==4)
    $fuel_type="Сжиженный газ";

if ($break_type==1)
    $break_type="Гидравлический";
if ($break_type==2)
    $break_type="Пневматический";
if ($break_type==3)
    $break_type="Комбинированный";
if ($break_type==4)
    $break_type="Механический";

if ($category == "M1")
    $category="Легковая (M1)";

if ($category == "N1")
    $category="Грузовая (N1)";

if ($category == "M2")
    $category="Автобус (M2)";

if ($category == "M3")
    $category="Автобус (M3)";

if ($category == "N2")
    $category="Грузовая (N2)";

if ($category == "N3")
    $category="Грузовая (N3)";

if ($category == "A")
    $category="Мотоцикл (L)";

if ($category == "O1" )
    $category="Прицеп (01)";

if ($category == "O2" )
    $category="Прицеп (O2)";

if ($category == "O3")
    $category="Прицеп (O3)";

if ($category == "O4")
    $category="Прицеп (O4)";

$brand_model=$brand." ".$model;

$expert_full=$MYSQL->get("Experts",array("*"), array("id"=>$row["expert"]));
$expert=$expert_full['first_name']." ".substr($expert_full['second_name'],0,2).". ".substr($expert_full['third_name'],0,2).".";

$row=$MYSQL->get("Stations",array("*"), array("login"=>$row["station"]));





$pdf = new FPDF(); // Создание нового объекта FPDF
$pdf->AddPage(); // Добавить страницу
$pdf->AddFont('DejaVuSerifCondensed','','DejaVuSerifCondensed.php'); // Устанавливаем кастомный шрифт
$pdf->AddFont('Arial-BoldMT','','arial_bold.php'); // Устанавливаем кастомный шрифт
$pdf->SetFont('Arial-BoldMT','',9); // Выбираем этот шрифт
//$pdf->SetFont('Arial','B',9);

// ВЫШЕ НАСТРОЙКИ. МЕНЯТЬ НЕЛЬЗЯ. ТОЛЬКО РАЗМЕР ШРИФТА!!!

$pdf->Image("data/controllers/pdf/first_min.jpg","","","210","300");
//$pdf->SetFont('Arial','B',9);
//------------№ ДК---------------------------------------------
for ($i=0;$i<21;$i++)
{
    $symbol=substr($card_number,$i,1);
    $pdf->SetXY(160.3+($i*1.85),0); // Координаты, куда выводить текст
    $pdf->Cell(3.9,4.4,$symbol,"0","","C"); // Отправляем текст на страницу
}
$pdf->SetFont('Arial-BoldMT','',10); // Выбираем этот шрифт
for ($i=0;$i<15;$i++)
{
    $symbol=substr($card_in_number,$i,1);
    $pdf->SetXY(45.9+($i*5.25),13.1); // Координаты, куда выводить текст
    $pdf->Cell(3.9,4.4,$symbol,"0","","C"); // Отправляем текст на страницу
}
//------------Срок действия ДО---------------------------------

//$pdf->SetFont('Arial','B',8);
$pdf->SetFont('Arial-BoldMT','',8);
$pdf->SetXY(47,32); // Координаты, куда выводить текст
$pdf->Cell(30.5,4,iconv("UTF-8", "WINDOWS-1251",$reg_number),"0","","L"); // Отправляем текст на страницу


$pdf->SetXY(47,36.75); // Координаты, куда выводить текст
$pdf->Cell(30.5,4,iconv("UTF-8", "WINDOWS-1251",$VIN_number),0,"","L"); // Отправляем текст на страницу


$pdf->SetXY(47,42); // Координаты, куда выводить текст
$pdf->Cell(30.5,4,iconv("UTF-8", "WINDOWS-1251",$chassis),"0","1","L"); // Отправляем текст на страницу


$pdf->SetXY(47,46.5); // Координаты, куда выводить текст
$pdf->Cell(30.5,4,iconv("UTF-8", "WINDOWS-1251",$body),"0","","L"); // Отправляем текст на страницу


$pdf->SetXY(136,32); // Координаты, куда выводить текст
$pdf->Cell(65.7,4,iconv("UTF-8", "WINDOWS-1251",$brand_model),"0","","L"); // Отправляем текст на страницу


$pdf->SetXY(136,36.75); // Координаты, куда выводить текст
$pdf->Cell(65.7,4,iconv("UTF-8", "WINDOWS-1251",$category),0,"","L"); // Отправляем текст на страницу


$pdf->SetXY(136,41.5); // Координаты, куда выводить текст
$pdf->Cell(65.7,8,iconv("UTF-8", "WINDOWS-1251",$year_car),"0","","L"); // Отправляем текст на страницу


$pdf->SetXY(79,50.7); // Координаты, куда выводить текст
$pdf->MultiCell(80,4,iconv("UTF-8", "WINDOWS-1251","$doc_full $seria № $number выдан $issued_by $issued_when") ,"0",0,"L"); // Отправляем текст на страницу



//Изменить ИНФО О ПТО

$pdf->AddPage(); // Добавить страницу
$pdf->Image("data/controllers/pdf/second_min.jpg","","","210","300");

$pdf->SetXY(43.9,83.3); // Координаты, куда выводить текст
$pdf->Cell(39.3,4.2,iconv("UTF-8", "WINDOWS-1251",$min_mass. " кг"),"0","","L"); // Отправляем текст на страницу


$pdf->SetXY(43.9,89); // Координаты, куда выводить текст
$pdf->Cell(39.3,4.2,iconv("UTF-8", "WINDOWS-1251",$fuel_type),"0","","L"); // Отправляем текст на страницу


$pdf->SetXY(43.9,94.3); // Координаты, куда выводить текст
$pdf->Cell(39.3,4.2,iconv("UTF-8", "WINDOWS-1251",$break_type),"0","","L"); // Отправляем текст на страницу

$pdf->SetXY(43.9,99.9); // Координаты, куда выводить текст
$pdf->Cell(39.3,4.2,iconv("UTF-8", "WINDOWS-1251",$wheels),"0","","L"); // Отправляем текст на страницу

$pdf->SetXY(156.8,83.3); // Координаты, куда выводить текст
$pdf->Cell(40,4.2,iconv("UTF-8", "WINDOWS-1251",$max_mass." кг"),"0","","L"); // Отправляем текст на страницу

$pdf->SetXY(156.8,89); // Координаты, куда выводить текст
$pdf->Cell(40,4.2,iconv("UTF-8", "WINDOWS-1251",$mileage." км"),"0","","L"); // Отправляем текст на страницу

$pdf->SetXY(85,60); // Координаты, куда выводить текст
$pdf->Cell(39.3,4.2,iconv("UTF-8", "WINDOWS-1251",$comment),"0","","C"); // ПРИМЕЧАНИЕ

$pdf->SetXY(116.1,70.5); // Координаты, куда выводить текст
$pdf->Cell(39.3,4.2,iconv("UTF-8", "WINDOWS-1251",$date_exist),"0","","L"); // ПРИМЕЧАНИЕ

$pdf->SetFont('Arial-BoldMT','',9); // Выбираем этот шрифт
//----------------Дата------------------------------------------------------
for ($j=0;$j<8;$j++)
{
    $symbol=substr($date_create,$j,1);
    $pdf->SetXY(17.5+($j*5.2),139); // Координаты, куда выводить текст
    $pdf->Cell(5.3,5.7,$symbol,"0","","C"); // Отправляем текст на страницу
}
//--------------------------------------------------------------------------
/*
$pdf->SetXY(51.7,146.5); // Координаты, куда выводить текст
$pdf->Cell(39.3,4.2,_utf($expert),"0","","L"); // Отправляем текст на страницу
*/
// НИЖЕ ВЫВОД НА ЭКРАН. НЕ НАДО ТРОГАТЬ


if ($reg_number)
    $fileName = $reg_number;
elseif ($VIN_number)
    $fileName = $VIN_number;
elseif ($body)
    $fileName = $body;
elseif ($wheels)
    $fileName = $wheels;
elseif ($second_name)
    $fileName = $second_name;


$pdf->Output("$fileName.pdf", "I");

function _utf($str)
{
    return iconv("UTF-8", "WINDOWS-1251",$str);
}

?>
