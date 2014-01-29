<?php

class Price extends Model {

    protected  $table='Prices';

    protected $attributes=array(
        "id" =>0,
        "name" => "",
        "agent" =>"",
        "date_create" => "",
        "A"=>"",
        "B"=>"",
        "C"=>"",
        "D"=>"",
        "E_light"=>"",
        "E_heavy"=>"",
    );

    protected $validators=array (
        "name" => "text",
        "agent" => "text",
        "A" => "number",
        "A" => "number",
        "B" => "number",
        "C" => "number",
        "D" => "number",
        "E_light" => "number",
        "E_heavy" => "number",

    );

    public function getByLogin($agent="") {
        $MYSQL= DB::getInstance();
        if ($agent!="")
            $data=$MYSQL->get($this->table,array("*"),array("agent"=>$agent),false);
        else
            return 0;

        return $data;
    }

}