<?php
session_start();
ini_set("display_errors",1);
error_reporting(E_ALL ^ E_NOTICE);


require_once('data/modules/db_ex.php');
require_once('data/base/component.php');
require_once('data/modules/db.php');
require_once('data/components/table.php');
require_once('tcpdf/tcpdf.php');
define('FPDF_FONTPATH','ufpdf/font/');

if(isset($_GET['logout'])) {
    session_destroy();
    header('Location: /docs.php');
}

if(isset($_GET['document'])) {
    createDocument();
}

if (isset($_POST['seller_name']))
    saveRequest();

if (!isset($_SESSION['login'])) {

    if (isset($_POST['login']) && isset($_POST['password']) ) {

       if (!autorize($_POST['login'],$_POST['password'])) {
           require_once('docs/loginform.php');
       } else {
           header('Location: /docs.php');
       }
    } else {
        require_once('docs/loginform.php');
    }

}else {
    if($_SESSION['type']==1)
        require_once('docs/userAdmin.php');

    if($_SESSION['type']==2)
        require_once('docs/userAgent.php');
}



function autorize($login,$password) {
    $db = new SafeMySQL();
    $user = $db->getRow("SELECT * FROM docs_users WHERE login=?s AND password=?s",$login,$password);
    if($user) {
        $_SESSION['login']=$user['login'];
        $_SESSION['password']=$user['password'];
        $_SESSION['type']=$user['type'];
        $_SESSION['name']=$user['name'];
        return true;
    }
    return false;

}

function saveRequest(){
    if (!isset($_SESSION['login'])) return ;
    unset($_POST['submit']);
    $_POST['date']=Date('Y-m-d');
    $_POST['agent']=$_SESSION['login'];
    $MYSQL = DB::getInstance();
    $MYSQL->insert('docs',$_POST);
}


/*
function createDocument() {
    $agent = $_SESSION['login'];
    $id = $_GET['document'];
    $db = new SafeMySQL();
        $data = $db->getRow("SELECT * FROM docs WHERE agent=?s AND id=?s",$agent,$id);
    if($_SESSION['type']==1)
        $data = $db->getRow("SELECT * FROM docs WHERE id=?s",$id);
    $date=$data['date'];
    preg_match("{\d{2}(\d+)}",$date,$half_year);
    $half_year = $half_year[1];


    $file = file_get_contents("docs/template.php");

    if($data['category']=="А")
        $car_type="МОТОЦ�?КЛ";
    if($data['category']=="B")
        $car_type="ЛЕГКОВОЕ";
    if($data['category']=="С")
        $car_type="ГРУЗОВОЕ";
    if($data['category']=="D")
        $car_type="АВТОБУС";
    if($data['category']=="E")
        $car_type="ПР�?ЦЕП";

    if($data['vin_number']=="")
        $data['vin_number']="ОТСУТСТВУЕТ";

    if($data['engine']=="")
        $data['engine']="ОТСУТСТВУЕТ";

    if($data['wheels']=="")
        $data['wheels']="ОТСУТСТВУЕТ";

    if($data['body']=="")
        $data['body']="ОТСУТСТВУЕТ";

    if($data['reg_number']=="")
        $data['reg_number']="ОТСУТСТВУЕТ";


    preg_match_all(iconv("UTF-8","CP1251","{([А-Яа-я])[а-я]+ ([А-Яа-я])[а-я]+ ([а-яА-Я]+)}"),iconv("UTF-8","CP1251",$data['seller_name']),$seller_small);
    preg_match_all(iconv("UTF-8","CP1251","{([А-Яа-я])[а-я]+ ([А-Яа-я])[а-я]+ ([а-яА-Я]+)}"),iconv("UTF-8","CP1251",$data['buyer_name']),$buyer_small);
    $seller_small = $seller_small[1][0].". ".$seller_small[2][0].". ".$seller_small[3][0];
    $buyer_small = $buyer_small[1][0].". ".$buyer_small[2][0].". ".$buyer_small[3][0];


    $file= preg_replace("{ID}", $data["id"], $file);
    $file= preg_replace("{half_year}", $half_year, $file);
    $file= preg_replace("{date_full}", $date, $file);
    $file= preg_replace("{city}", $data["city"], $file);

    $file= preg_replace("{seller_name}",  $data["seller_name"], $file);
    $file= preg_replace("{seller_date}", $data["seller_date"], $file);
    $file= preg_replace("{seller_address}", $data["seller_address"], $file);
    $file= preg_replace("{seller_seria}", $data["seller_seria"], $file);
    $file= preg_replace("{seller_number}", $data["seller_number"], $file);
    $file= preg_replace("{seller_issued}", $data["seller_issued"], $file);

    $file= preg_replace("{buyer_name}",  $data["buyer_name"], $file);
    $file= preg_replace("{buyer_date}", $data["buyer_date"], $file);
    $file= preg_replace("{buyer_address}", $data["buyer_address"], $file);
    $file= preg_replace("{buyer_seria}", $data["buyer_seria"], $file);
    $file= preg_replace("{buyer_number}", $data["buyer_number"], $file);
    $file= preg_replace("{buyer_issued}", $data["buyer_issued"], $file);

    $file= preg_replace("{reg_number}", $data["reg_number"], $file);
    $file= preg_replace("{brand}", $data["brand"], $file);
    $file= preg_replace("{vin_number}", $data["vin_number"], $file);
    $file= preg_replace("{car_type}", $car_type, $file);
    $file= preg_replace("{category}", $data["category"], $file);
    $file= preg_replace("{year}", $data["year"], $file);
    $file= preg_replace("{engine_number}", $data["engine"], $file);
    $file= preg_replace("{wheels}", $data["wheels"], $file);
    $file= preg_replace("{BODY}",  $data["body"], $file);

    $file= preg_replace("{color}",  $data["color"], $file);
    $file= preg_replace("{power}",  $data["power"], $file);
    $file= preg_replace("{volume}",  $data["volume"], $file);
    $file= preg_replace("{engine_type}",  $data["engine_type"], $file);
    $file= preg_replace("{class}",  $data["class"], $file);
    $file= preg_replace("{max_mass}",  $data["max_mass"], $file);
    $file= preg_replace("{min_mass}",  $data["min_mass"], $file);
    $file= preg_replace("{passport}",  $data["passport"], $file);
    $file= preg_replace("{registration}",  $data["registration"], $file);
    $file= preg_replace("{price_number}",  $data["price_number"], $file);
    $file= preg_replace("{price_word}",  $data["price_word"], $file);
    $file= preg_replace("{BUYER_SMALL}",  iconv("CP1251","UTF-8",$buyer_small), $file);
    $file= preg_replace("{seller_small}",  iconv("CP1251","UTF-8",$seller_small), $file);

    file_put_contents("pattern/word/document.xml",$file);

    createZip();

    header('Location: /docs/test.docx');


}*/


function createDocument(){
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Nicola Asuni');
    $pdf->SetTitle('TCPDF Example 001');
    $pdf->SetSubject('TCPDF Tutorial');
    $pdf->SetKeywords('TCPDF, PDF, example, test, guide');
    $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
    $pdf->setFooterData(array(0,64,0), array(0,64,128));
    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
    $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
    $pdf->SetFont('dejavusans', '', 14, '', true);
    $pdf->AddPage();
    $pdf->setFontSubsetting(true);
    $pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));

    $pdf->Cell(0, 0, iconv("windows-1251","utf-8", "�������, � ���� ������� �����!"), 1, 1, 'C', 0, '', 0);

    $pdf->Output('example_001.pdf', 'I');

    die;
}

function rus($text){
    return iconv("UTF-8", "WINDOWS-1251",$text);

}

function createZip() {

    $zip = new ZipArchive;
    $res = $zip->open('docs/test.docx', ZipArchive::OVERWRITE);
    if ($res === TRUE) {

        $zip->addEmptyDir("_rels");
        $zip->addEmptyDir("docProps");
        $zip->addEmptyDir("word");

        $zip->addFile("pattern/[Content_Types].xml","[Content_Types].xml");
        $zip->addFile("pattern/_rels/.rels","_rels/.rels");
        $zip->addFile("pattern/docProps/app.xml","docProps/app.xml");
        $zip->addFile("pattern/docProps/core.xml","docProps/core.xml");
        $zip->addFile("pattern/word/document.xml","word/document.xml");
        $zip->addFile("pattern/word/fontTable.xml","word/fontTable.xml");
        $zip->addFile("pattern/word/numbering.xml","word/numbering.xml");
        $zip->addFile("pattern/word/settings.xml","word/settings.xml");
        $zip->addFile("pattern/word/styles.xml","word/styles.xml");
        $zip->addFile("pattern/word/webSettings.xml","word/webSettings.xml");
        $zip->addFile("pattern/word/_rels/document.xml.rels","word/_rels/document.xml.rels");
        $zip->addFile("pattern/word/theme/theme1.xml","word/theme/theme1.xml");

        $zip->close();
    }
}


