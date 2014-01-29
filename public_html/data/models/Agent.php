<?php

class Agent  extends Model{

    protected $table = 'Agents';
    protected $attributes = array(
        "id" => 0,
        "second_name" => "",
        "login" => "",
        "price" => "",
        "manager" => "",
        "date_create"=>"");

    protected $validators = array (
        "second_name" => "text",
        "login" => "login",
        );

    // Возвращаем моих агентов
    public function getAgentsByLogin($manager="") {
        $MYSQL= DB::getInstance();
        if ($manager!="")
            $agents=$MYSQL->get($this->table,array("*"),array("manager"=>$manager),false);
        else
            return 0;

        return $agents;
    }

    // Возвращаем всех моих агентов
    public function getAllAgentsByLogin($manager="") {
        $GLOBALS['agents']=array();

        $this->findChilds($manager);

        $result=$GLOBALS['agents'];
        unset($GLOBALS['agents']);

        foreach($result as $field => $value)
            if ($value=='')
                unset($result[$field]);
        return $result;
    }

    private function findChilds($manager) {
        $MYSQL= DB::getInstance();
        $agents=$MYSQL->get("Agents",array("*"),array("manager"=>$manager),false);
        foreach($agents as $agent) {
            array_push($GLOBALS['agents'],$agent);
            array_push($GLOBALS['agents'],$this->findChilds($agent['login']));
        }
    }

    public function resetById() {

        $id = $_GET['id'];
        $userModel = new webUser();
        $agentModel = new Agent();
        $agent=$agentModel->getById($id);
        $login = $agent["login"];
        $user= $userModel->getByLogin($login);
        $userId=$user[0]['id'];

        $userModel->setAttributes(array("id"=>$userId,"login"=>$login, "password"=>md5($login)));
        $userModel->save();

    }

    static function all(){
        $MYSQL= DB::getInstance();
        $data=$MYSQL->get("Agents",array("*"),array(),false);
        return $data;
    }

    static function getNameByLogin($login) {
        $MYSQL= DB::getInstance();
        $data=$MYSQL->get("Agents",array("*"),array("login"=>$login),false);
        return $data;
    }

    static function getManager($agentLogin) {
        $agents = model::getAllFrom("Agents");
        $agent = model::byLogin("Agents",$agentLogin);

        $testManager = $agent;
        $stop = true;
            while ($stop != false) {



                if ($testManager['manager'])  {
                    $tree []= array(
                        "manager" => $testManager['manager'],
                        "second_name"=> $testManager['second_name'],
                        "login"=>$testManager['login']);
                    $testManager = model::byLogin("Agents",$testManager['manager']);

                }
                else
                {
                    $stop = false;
                }

            }


        $manager = array_pop($tree);
        $agent = array_pop($tree);
            return array("manager"=>$manager,"agent"=>$agent);

    }
}