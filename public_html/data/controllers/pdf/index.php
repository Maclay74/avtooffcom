
<?php

ini_set("display_errors",1);
error_reporting(E_ALL ^ E_NOTICE);

require_once "../../../data/modules/db.php";
require_once "../../../data/modules/db_ex.php";

require_once "../../../data/modules/user.php";




$MYSQL= DB::getInstance();
$User = User::getInstance();

if (!isset($_GET['id']))
	exit();

define('FPDF_FONTPATH','../../../data/controllers/pdf/FPDF/font/');
require('fpdf_ext.php');

$row=$MYSQL->get("Requests",array("*"), array("id"=>$_GET['id']));

$first_name=$row["first_name"];
$id=$row["id"];
$card_number=$row["card_number"];
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
$year=$row["year"];
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

$year=substr($issued_when,0,4);
$month=substr($issued_when,5,2);
$day=substr($issued_when,8,2);
$issued_when="$day.$month.$year";

$year=substr($date_exist,0,4);
$month=substr($date_exist,5,2);
$day=substr($date_exist,8,2);
$date_exist="$day$month$year";

$year=substr($date_create,0,4);
$month=substr($date_create,5,2);
$day=substr($date_create,8,2);
$date_create="$day$month$year";

if ($doc_type==1)
	$doc_full="����";
if ($doc_type==0)
	$doc_full="���";


if ($fuel_type==1)
	$fuel_type="������";
if ($fuel_type==2)
	$fuel_type="��������� �������";
if ($fuel_type==3)
	$fuel_type="������ ���";
if ($fuel_type==4)
	$fuel_type="��������� ���";
	
if ($break_type==1)
	$break_type="��������������";
if ($break_type==2)
	$break_type="��������������";
if ($break_type==3)
	$break_type="���������������";
if ($break_type==4)
	$break_type="������������";	
	
if ($category == "M1" || $category == "N1")
	$category="B";
if ($category == "�2" || $category == "M3")
	$category="D";	
if ($category == "N2" || $category == "N3")
	$category="C";	
if ($category == "L")
	$category="A";
if ($category == "O1" || $category == "O2" || $category == "O3" || $category == "O4")
	$category="������";

$brand_model=$brand." ".$model;

$expert_full=$MYSQL->get("Experts",array("*"), array("id"=>$row["expert"]));
$expert=$expert_full['first_name']." ".substr($expert_full['second_name'],0,2).". ".substr($expert_full['third_name'],0,2).".";

$row=$MYSQL->get("Stations",array("*"), array("login"=>$row["station"]));

$full_name=htmlspecialchars_decode($row["full_name"]);
$point_address=htmlspecialchars_decode ($row["point_address"]);
$number=htmlspecialchars_decode ($row["number_eaisto"]);
$type=htmlspecialchars_decode($row["type"]);
$full_address=htmlspecialchars_decode ($row["full_address"]);
$small_name=htmlspecialchars_decode ($row["small_name"]);



$pdf = new FPDF(); // �������� ������ ������� FPDF
$pdf->AddPage(); // �������� ��������


$pdf->AddFont('DejaVuSerifCondensed','','DejaVuSerifCondensed.php'); // ������������� ��������� �����
$pdf->AddFont('DejaVuSerifCondensed-Bold','','DejaVuSerifCondensed-Bold.php'); // ������������� ��������� �����
$pdf->SetFont('DejaVuSerifCondensed-Bold','',7); // �������� ���� �����

// ���� ���������. ������ ������. ������ ������ ������!!!

$pdf->Image("first.jpg","","","210","300");
$pdf->SetFont('DejaVuSerifCondensed','',8); // �������� ���� �����
//------------� ��---------------------------------------------
for ($i=0;$i<21;$i++)
{
$symbol=substr($card_number,$i,1);
$pdf->SetXY(24.2+($i*3.9),20.3); // ����������, ���� �������� �����
$pdf->Cell(3.9,4.4,$symbol,"0","","C"); // ���������� ����� �� ��������
}
//------------���� �������� ��---------------------------------
for ($j=0;$j<8;$j++)
{
$symbol=substr($date_exist,$j,1);
$pdf->SetXY(149.4+($j*3.9),20.3); // ����������, ���� �������� �����
$pdf->Cell(3.9,4.4,$symbol,"0","","C"); // ���������� ����� �� ��������
}
//-------------------------------------------------------------

$pdf->SetXY(5.5,26.2); // ����������, ���� �������� �����
// ��� ���� ���������� �����-������.
$spaces="                                                                                                                              ";
$pdf->MultiCell(199,3,_utf($spaces.$type)." "._utf($full_name)." ("._utf($small_name)."), � � ������� ����������: "._utf($number).", ����� ��������� ��: "._utf($full_address).", ����� ������ ��: "._utf($point_address),-0.5,"","L"); // ���������� ����� �� ��������


$pdf->SetFont('DejaVuSerifCondensed-Bold','',8);
$pdf->SetXY(5.5,26.2); // ����������, ���� �������� �����
$pdf->MultiCell(199,3,"�������� ������������ �������/����� ������������ �������: ",-0.7); // ���������� ����� �� ��������

$pdf->SetFont('DejaVuSerifCondensed-Bold','',7);
$pdf->SetXY(69.5,36.9); // ����������, ���� �������� �����
$pdf->Cell(30.5,4,iconv("UTF-8", "WINDOWS-1251",$reg_number),"1","","C"); // ���������� ����� �� ��������

$pdf->SetXY(69.5,40.9); // ����������, ���� �������� �����
$pdf->Cell(30.5,4,iconv("UTF-8", "WINDOWS-1251",$VIN_number),"1","","C"); // ���������� ����� �� ��������

$pdf->SetXY(69.5,44.9); // ����������, ���� �������� �����
$pdf->Cell(30.5,4,iconv("UTF-8", "WINDOWS-1251",$body),"0","1","C"); // ���������� ����� �� ��������

$pdf->SetXY(69.5,49); // ����������, ���� �������� �����
$pdf->Cell(30.5,4,iconv("UTF-8", "WINDOWS-1251",$chassis),"0","","C"); // ���������� ����� �� ��������

$pdf->SetXY(139,36.9); // ����������, ���� �������� �����
$pdf->Cell(65.7,4,iconv("UTF-8", "WINDOWS-1251",$brand_model),"0","","C"); // ���������� ����� �� ��������

$pdf->SetXY(139,40.9); // ����������, ���� �������� �����
$pdf->Cell(65.7,4,iconv("UTF-8", "WINDOWS-1251",$category),"0","","C"); // ���������� ����� �� ��������

$pdf->SetXY(139,44.9); // ����������, ���� �������� �����
$pdf->Cell(65.7,8,iconv("UTF-8", "WINDOWS-1251",$year),"0","","C"); // ���������� ����� �� ��������

$pdf->SetFont('DejaVuSerifCondensed','',8);

$pdf->SetXY(69.5,53); // ����������, ���� �������� �����
$pdf->Cell(135,4,$doc_full.", ".iconv("UTF-8", "WINDOWS-1251","$seria, $number, $issued_by, $issued_when") ,"0","","L"); // ���������� ����� �� ��������



//�������� ���� � ���

$pdf->AddPage(); // �������� ��������
$pdf->Image("second.jpg","","","210","300");

$pdf->SetXY(65.4,75.7); // ����������, ���� �������� �����
$pdf->Cell(39.3,4.2,$min_mass,"0","","L"); // ���������� ����� �� ��������

$pdf->SetXY(65.4,80.3); // ����������, ���� �������� �����
$pdf->Cell(39.3,4.2,$fuel_type,"0","","L"); // ���������� ����� �� �������� 

$pdf->SetXY(65.4,84.7); // ����������, ���� �������� �����
$pdf->Cell(39.3,4.2,$break_type,"0","","L"); // ���������� ����� �� ��������

$pdf->SetXY(65.4,89.3); // ����������, ���� �������� �����
$pdf->Cell(39.3,4.2,iconv("UTF-8", "WINDOWS-1251",$wheels),"0","","L"); // ���������� ����� �� ��������

$pdf->SetXY(164.8,75.7); // ����������, ���� �������� �����
$pdf->Cell(40,4.2,$max_mass,"0","","L"); // ���������� ����� �� ��������

$pdf->SetXY(164.8,80.2); // ����������, ���� �������� �����
$pdf->Cell(40,4.2,$mileage,"0","","L"); // ���������� ����� �� ��������

$pdf->SetXY(25.2,57.8); // ����������, ���� �������� �����
$pdf->Cell(39.3,4.2,$comment,"0","","L"); // ����������

//----------------����------------------------------------------------------
for ($j=0;$j<8;$j++)
{
$symbol=substr($date_create,$j,1);
$pdf->SetXY(31.6+($j*5.3),136.4); // ����������, ���� �������� �����
$pdf->Cell(5.3,5.7,$symbol,"0","","C"); // ���������� ����� �� ��������
}
//--------------------------------------------------------------------------

$pdf->SetXY(51.7,146.5); // ����������, ���� �������� �����
$pdf->Cell(39.3,4.2,iconv("UTF-8", "WINDOWS-1251",$expert),"0","","L"); // ���������� ����� �� ��������

// ���� ����� �� �����. �� ���� ������� 
$pdf->Output($second_name." ($reg_number).pdf" ,"D"); 

function _utf($str)
{
	return iconv("UTF-8", "WINDOWS-1251",$str);
}

?>
