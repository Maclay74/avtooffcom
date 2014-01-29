<?php

class webUser extends Model {

    protected  $table='Users';

    protected $attributes=array(
        "id" => 0,
        "login" => "",
        "type" =>3,
        "password"=>"");

    protected $validators=array(
      "login" =>"login"
    );

    public function getByLogin($manager="") {
        $MYSQL= DB::getInstance();
        if ($manager!="")
            $agents=$MYSQL->get($this->table,array("*"),array("login"=>$manager),false);
        else
            return 0;

        return $agents;
    }

}