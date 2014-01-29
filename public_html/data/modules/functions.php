<?php
function include_from($dir, $ext='php'){
    $opened_dir = opendir($dir);

    while ($element=readdir($opened_dir)){
        $fext=substr($element,strlen($ext)*-1);
        if(($element!='.') && ($element!='..') && ($fext==$ext)){
            include($dir.$element);
        }
    }
    closedir($opened_dir);
}

function getAgents($manager) {
    $MYSQL= DB::getInstance();
    $agents=$MYSQL->get("Agents",array("*"),array("manager"=>$manager),false);
    return $agents;
}

function render ($template, $data='') {
    ob_start();
    require_once("data/".$template);
    $content=ob_get_clean();
    echo $content;
}

function renderOut ($template, $data='') {
    ob_start();
    require("data/".$template);
    $content=ob_get_clean();
    return $content;
}

function filterArray (array $data, $params = array(), $date=0) {

    $GLOBALS['params'] = $params;

    if (!$date)
        $result = array_filter($data,"filterVar");
    else
        $result = array_filter($data,"filterDate");

    unset($GLOBALS['params']);
    return $result;
}

function filterVar($var) {

    $params = $GLOBALS['params'];
    foreach ($params as $key =>$value) {
        if(lowercase($params[$key]) != lowercase($var[$key])) {
            return false;
        }
    }
    return true;
}

function filterDate($var) {

    $params = $GLOBALS['params'];



    if (strtotime($var['date_create']) >= strtotime($params['startDate']) && strtotime($var['date_create']) <= strtotime($params['endDate']))
        return true;


    return false;
}

function includeJsFile($file) {
    $header="<script type='text/javascript'>\n";
    $footer="\n</script>";
    return $header.renderOut("../js/".$file).$footer;
}

define ('UPCASE', 'АБВГДЕЁЖЗИЙКЛМНОПРСТУФХЦЧШЩЪЫЬЭЮЯABCDEFGHIKLMNOPQRSTUVWXYZ');
define ('LOCASE', 'абвгдеёжзийклмнопрстуфхцчшщъыьэюяabcdefghiklmnopqrstuvwxyz');
function mb_str_split($str) {
    preg_match_all('/.{1}|[^\x00]{1}$/us', $str, $ar);
    return $ar[0];
}
function mb_strtr($str, $from, $to) {return str_replace(mb_str_split($from), mb_str_split($to), $str);}

function lowercase($arg=''){return mb_strtr($arg, UPCASE, LOCASE);}
function uppercase($arg=''){return mb_strtr($arg, LOCASE, UPCASE);}

function sorta($a, $b) {
    if ($a['date_create'] < $b['date_create'])
        return 1;
}