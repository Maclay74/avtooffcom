<?php


if (isset($_GET['who'])) {
    echo "
Ну давай разберем по частям, тобою написанное )) Складывается впечатление что ты реально контуженный , обиженный жизнью имбицил )) Могу тебе и в глаза сказать, готов приехать послушать?) Вся та хуйня тобою написанное это простое пиздабольство , рембо ты комнатный)) от того что ты много написал, жизнь твоя лучше не станет)) пиздеть не мешки ворочить, много вас таких по весне оттаяло )) Про таких как ты говорят: Мама не хотела, папа не старался) Вникай в моё послание тебе< постарайся проанализировать и сделать выводы для себя)

    ";

    die;


}
session_start();
ini_set("display_errors",1);
error_reporting(E_ALL ^ E_NOTICE);
require_once "data/modules/db.php";
require_once "data/modules/functions.php";
require_once "data/modules/db_ex.php";
require_once "data/modules/user.php";
require_once "data/modules/crypt.php";
require_once "data/router.php";
require_once "data/controllers/pdf/fpdf_ext.php";

include_from("data/base/");

require_once "data/controllers/agentController.php";
require_once "data/controllers/indexController.php";
require_once "data/controllers/loginController.php";
require_once "data/controllers/priceController.php";
require_once "data/controllers/requestController.php";
require_once "data/controllers/cashierController.php";
require_once "data/controllers/expertController.php";


include_from("data/components/");
include_from("data/models/");




$MYSQL= DB::getInstance();
$User = User::getInstance();

if(is_array($_POST))
{	
	foreach ($_POST as $k => $v) 
	{
		$_POST[$k]=mysql_real_escape_string($v);
	}
}

if(is_array($_GET))
{	
	foreach ($_POST as $k => $v) 
	{
		$_GET[$k]=mysql_real_escape_string($v);
	}	
}



$router = new Router($_GET['event'], $_GET['action']);
ob_start();

if(!$router->executeController())
	echo "File is not exist";
	
	$content=ob_get_clean();

	require "data/templates/main.php";

