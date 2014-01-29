<?php
require_once "db_ex.php";

ini_set("display_errors",1);
error_reporting(E_ALL ^ E_NOTICE);

$DB = new SafeMySQL();

$changes = $DB->getAll("SELECT * FROM Changes");


foreach($changes as $change) {

   switch ($change["doing"]) {

       case "price":
           changePrice($change);
           break;
   }

}

function changePrice(array $change = array()) {

    $DB = new SafeMySQL();

    $DB->query("UPDATE Agents SET price = ?s WHERE login = ?s",$change['value'],$change["where"]);
    $DB->query("DELETE FROM Changes WHERE id = ?s",$change["id"]);

}