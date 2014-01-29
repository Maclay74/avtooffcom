<?php


class cashierController extends Controller {

    public $rules = array (
        "0" => "allow",
        "1" => "allow",
        "all" => "deny"
    );

    public function indexAction(){


        $data['agents'] = $this->genAgentsDropDown();
        $data[5] = date('01.m.Y');
        $data[6] = date('d.m.Y',strtotime("1 day"));

        $requestModel = new Request();

        $requests = $requestModel->getAllByLogin("admin");



        $this->render("index.php",$data);


    }

    public function AgentsAction(){


        $agentModel = new Agent();
        $agent = $agentModel->getById($_GET['agent']);
        $login = $agent['login'];
        $agents = $agentModel->getAgentsByLogin($login);



        foreach ($agents as $key => $value) {

            $agents[$key]['name'] = $agents[$key]['second_name']." ".$agents[$key]['first_name'];
        }
        array_unshift($agents, array('id'=>"allagents", 'name' => "Все агенты"));
        array_unshift($agents, array('id'=>"my", 'name' => "Заявки менеджера"));
        array_unshift($agents, array('id'=>"all", 'name' => "Все заявки"));



        $dropdown = new Dropdown();
        $dropdown->setFilter(array("id"=>"name"));
        $dropdown->setSelect(0);
        $dropdown->setData($agents);
        $dropdown->setName('agent');
        $dropdown->setEvent('name','agent');
        $dropdown->render();

    }

    public function RequestAction() {

        $requests = $this->genRequestsByFilter();

        if (count($requests)) {
            if(isset($_GET['page'])) {
                echo $this->genRequests($_GET['page'],$requests);
            }
            else
                echo $this->genRequests(1,$requests);

        }
        else {
            $alert = new Alert();
            $alert->render("Похоже, что заявки по данным критериям не найдены.");
        }
    }

    public function change1cAction() {
       $id = $_GET['id'];
       $requestModel = new Request();
       $requestModel->setAttributes($requestModel->getById($id));
       $status = $requestModel->getAttribute('status_1c');
       $requestModel->setAttribute(array('status_1c'=>1-$status));
        print_r($requestModel->getAttributes());
       $requestModel->save();

    }

    public function PayAction(){
        $selected = json_decode($_GET['selected']);

       foreach ($selected as $key => $value) {
           if ($value) $this->payRequest($key);
           if (!$value) $this->unpayRequest($key);
       }

    }

    private function genRequests($page,array $data) {

        $table= new Table(); // Создаем таблицу
        $table->setHeaders(array('brand'=>'Марка','agent'=>'Агент','third_name'=>'Отчество','date_create'=>'Дата','status_pay'=>'Оплачено','status_work'=>'Обработано','_control'=>'Статус в 1С')); // Устанавливаем заголовки
        $table->setData($data);
        $table->setOptions(array('page'=>$page));
        $table->set1cCol();
        $table->setWorkText();
        $table->set1СText();
        $table->setPayText();
        $table->change1C();
        //$table->setClick("change1c");
        $table->setClick("formRequest");
        return $table->renderOut();
    }

    private function payRequest($request){
       $requestModel = new Request();
       $requestModel->setAttributes($requestModel->getById($request));
       $requestModel->pay();
    }

    private function unpayRequest($request){
        $requestModel = new Request();
        $requestModel->setAttributes($requestModel->getById($request));
        $requestModel->unpay();

    }

    private function genAgentsDropDown($manager = "admin"){

        $requestModel = new Request();
        $agentModel = new Agent();
        //$requests = $requestModel->getAllByLogin("admin");
        $agents = $agentModel->getByParam('manager',$manager);

        foreach ($agents as $key => $value) {

            $agents[$key]['name'] = $agents[$key]['second_name']." ".$agents[$key]['first_name'];
        }

        $dropdown = new Dropdown();
        $dropdown->setFilter(array("id"=>"name"));
        $dropdown->setData($agents);
        $dropdown->setEvent("onchange","getAgents()");
        $dropdown->setName('managers');

        return $dropdown->renderOut();
}

    private function genRequestsByFilter() {



        $requestModel = new Request();
        $manager = Agent::byId("Agents",$_POST['managers']);


        if(isset($_POST['car']) || isset($_POST['name']) ) {
            $requests = $this->findRequestBySearch($requestModel->getAll());
            return $requests;
        }

        $requests = $requestModel->getAllByLogin($manager['login']);


        if (isset($_POST['agent'])) {
            if ($_POST['agent'] == "allagents") {

                $tempReq = $requests;
                $requests = array();
                foreach ($tempReq as $agent => $reqs) {
                   foreach ($tempReq[$agent] as $num => $req) {
                       $requests[]=$req;
                   }
                }

            }
            elseif ($_POST['agent'] == "all") {
                $tempReq = $requests;
                $requests = array();
                foreach ($tempReq as $agent => $reqs) {
                    foreach ($tempReq[$agent] as $num => $req) {
                        $requests[]=$req;
                    }
                }

                $requests = array_merge($requestModel->getByLogin($manager['login']),$requests);

            }
            else {

                $agent = Agent::byId("Agents",$_POST['agent']);
                $requests = $requests[$agent['login']];

                if ($_POST['agent']=="my") {
                    $requests = $requestModel->getByLogin($manager['login']);

                }
            }


        } else {

            $tempReq = $requests;
            $requests = array();
            foreach ($tempReq as $agent => $reqs) {
                foreach($tempReq[$agent] as $number=>$value) {
                    $requests[]= $value;
                }
            }

        }

       if ($requests == NULL) $requests=array();



        if(isset($_POST['payed']) && $_POST['payed']=='on')
            $payed = filterArray($requests,array("status_1c"=>1));

        if(isset($_POST['unpayed']) && $_POST['unpayed']=='on')
            $unpayed = filterArray($requests,array("status_1c"=>0));

        if(isset($_POST['payed']) && $_POST['payed']=="on" && isset($_POST['unpayed']) && $_POST['unpayed']=="on"){

        }
        else{
            $requests = array();
            if (isset($_POST['payed'])){
                $requests = $payed;
            }
            if (isset($_POST['unpayed'])){
                $requests = $unpayed;
            }
        }

        if(isset($_POST['car']) || isset($_POST['name']) ) {

            $requests = array_merge($requests,$requestModel->getByLogin($User->login,0));
            $requests = array_merge($requests,$requestModel->getAllByLogin($User->login,0));

            $requests = $this->findRequestBySearch($requests);
        }

        if(isset($_POST['startDate']) && isset($_POST['endDate'])) {

            preg_match_all ("(\d+)",$_POST['startDate'],$dateArray);
            $startDate = $dateArray[0][2].'-'.$dateArray[0][1].'-'.$dateArray[0][0];

            preg_match_all ("(\d+)",$_POST['endDate'],$dateArray);
            $endDate = $dateArray[0][2].'-'.$dateArray[0][1].'-'.$dateArray[0][0];

            $requests = filterArray($requests,array('startDate' => $startDate, 'endDate' =>$endDate ),1);

        }

        return $requests;

    }

    private function findRequestBySearch($requests) {


        $number = $_POST['car'];
        $name = $_POST['name'];

        if($name == "" && $number == "")
            return array();


        if ($name) {
            $result = filterArray($requests,array("second_name"=>$name));

            if(!count($result))
                $result = filterArray($requests,array("first_name"=>$name));

            if(!count($result))
                $result = filterArray($requests,array("third_name"=>$name));

            if(!count($result))
                $result = filterArray($requests,array("reg_number"=>$number));
        }

        if ($number) {
            if(!count($result))
                $result = filterArray($requests,array("VIN_number"=>$number));

            if(!count($result))
                $result = filterArray($requests,array("body"=>$number));

            if(!count($result))
                $result = filterArray($requests,array("wheels"=>$number));
        }


        return $result;
    }
}