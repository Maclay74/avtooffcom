<?php

class Request extends Model {

    protected  $table='Requests';

    protected $attributes=array(
        "id" =>"",
        "card_number" => "",
        "first_name" => "",
        "second_name" =>"",
        "third_name" => "",
        "doc_type"=>"",
        "seria"=>"",
        "number"=>"",
        "issued_by"=>"",
        "issued_when"=>"",
        "reg_number"=>"",
        "VIN_number"=>"",
        "brand"=>"",
        "model"=>"",
        "category"=>"",
        "year"=>"",
        "chassis"=>"",
        "body"=>"",
        "min_mass"=>"",
        "max_mass"=>"",
        "mileage"=>"",
        "wheels"=>"",
        "fuel_type"=>"",
        "break_type"=>"",
        "status_work"=>"",
        "agent"=>"",
        "date_exist"=>"",
        "date_create"=>"",
        "expert"=>"",
        "comment"=>"",
        "status_pay"=>"",
        "status_1c"=>"",
        "price"=>"",
        "card_in_number"=>"",

    );

    protected $validators=array (

    );


    public function getByLogin($manager="") {
        $MYSQL= DB::getInstance();
        if ($manager!="")
            $data=$MYSQL->get($this->table,array("*"),array("agent"=>$manager),false);
        else
            return array();

        if(!is_array($data))
            $data = array();
        return $data;
    }

    public function getAllByLogin($manager="",$mode=1) {

        $model= new Agent();
        $agents=$model->getAgentsByLogin($manager); // Список моих агентов

        foreach ($agents as $agent) {

            // Берем заявки этого агента
            $this->findByLogin($agent["login"],$agent["login"],$mode);

            // Ищем всех дочерних агентов
            $agentsAll=$model->getAllAgentsByLogin($agent["login"]);

            foreach ($agentsAll as $agentAll) {
                $this->findByLogin($agentAll["login"],$agent["login"],$mode);
            }
        }

        $result = $GLOBALS['requests'];
        unset($GLOBALS['requests']);

        if(!is_array($result))
            $result = array();

        return $result;
    }

    public function getByParams(array $params=array()){
        $MYSQL= DB::getInstance();
        $data=$MYSQL->get($this->table,array("*"),$params,false);
        return $data;
    }

    private function findByLogin($manager,$owner,$mode) {
        $agentModel = new Agent();
        $agent = $agentModel->getByParam("login",$owner);


        $MYSQL= DB::getInstance();
        $data=$MYSQL->get($this->table,array("*"),array("agent"=>$manager),false);

        foreach($data as $request) {

            if($mode)
                $GLOBALS['requests'][$owner][]=$request;
            else {
                $request['agent']=$owner;
                $request['price']=$agent[0]['price'];
                $GLOBALS['requests'][]=$request;
            }
        }

    }

    public function pay(){
        $this->setAttribute(array("status_pay"=>1));
        $this->save();
    }

    public function unpay(){
        $this->setAttribute(array("status_pay"=>0));
        $this->save();
    }

    public function changeWorkStatus($status,$id = false) {

        if ($id) {
            $request = $this->getById($id);
            $this->setAttributes($request);
        }

        $this->setAttribute(array("status_work" =>$status));
        $this->setAttribute(array("date_create" => date("Y-m-d H:i:s")));
        $this->save();
    }


}