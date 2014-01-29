<?php


class agentController extends Controller {

    public $rules = array (
            "1" => "allow",
            "3" => "allow",
            "all" => "deny"
    );

    public function indexAction(){

        // Агенты
        $data[0]=$this->genMyAgents();

        // Прайсы
        $data[1]=$this->genMyPrices();

        // Даты
        $data[5] = date('01.m.Y');
        $data[6] = date('d.m.Y',strtotime("1 day"));

        $this->render("index.php",$data);
    }

    public function RequestAction() {

        $requests=$this->genRequestsByFilter();

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

    public function StatAction() {
        $requests=$this->genRequestsByFilter();

        // Все заявки
        $data[0] = count($requests);
        $paid = filterArray($requests,array('status_pay'=>1));
        $unpaid = filterArray($requests,array('status_pay'=>0));

        // Оплаченные заявки
        $data[1] = count($paid);

        // Неоплаченные заявки
        $data[2] = count($unpaid);

        // Считаем мои деньги
        $data[7] = $this->getPriceSum($requests);
        $data[8] = $this->getPriceSum($paid);
        $data[9] = $this->getPriceSum($unpaid);

        // Считаем то, что нужно отдать
        $data[10] = $this->getSumByMyPrice($requests);
        $data[11] = $this->getSumByMyPrice($paid);
        $data[12] = $this->getSumByMyPrice($unpaid);
        $data[13] = $data[7] - $data[10];


        render('components/Stat.html',$data);

    }

    public function formAction() {
        $user = User::getInstance();

        $id = $_GET['id'];
        $agentModel = new Agent();

        if (empty($_POST)) {
            $agent[0]=$agentModel->getById($id);
            $agent[1]=$this->genPriceDropdown($id);

            $this->render("form.php",$agent);
        }
        else {

            $agentModel->setAttributes($_POST);
            $agentModel->setAttributes(array("date_create"=>date("Y-m-d"),"manager"=>$user->login));
            if ($_POST["name"]) {
                $price = new Price();
                $price->setAttributes($_POST);
                $price->setAttributes(array("id"=>"","date_create"=>date("Y-m-d"),"agent"=>$user->login));
                $priceId= $price->save();
                $agentModel->setAttributes(array("price"=>$priceId));
            }

            if ($id == null) {
                $userMdodel = new webUser();
                $testLogin = $userMdodel->getByParam("login",$agentModel->getAttribute("login"));
                if(!empty($testLogin)) {
                    $agent[0] = $_POST;
                    $agent[1] = $this->genPriceDropdownbyId(0);
                    $agent["error"] = "Данный логин уже используется в системе";
                    unset($_GET);
                    unset($_POST);

                    $this->render("form.php",$agent);
                    return;

                }
            }

            if($id != null) {
             // Если мы редактируем агента

                $DB = new SafeMySQL();
                $price = $agentModel->getAttribute("price");
                $owner=$agentModel->getById($id);
                if (!$owner) return ;

                if ($agentModel->validate(array("login"=>true))) {
                    $changes = $DB->getRow("SELECT * FROM Changes WHERE `where` = ?s",$owner['login']);
                    if ($changes != null) {
                        $DB->query("UPDATE Changes set `value` =?s WHERE `where` = ?s",$price,$owner['login'] );
                    } else {
                        $DB->query("INSERT INTO Changes (`doing`,`where`, `value`) VALUES (?s,?s,?s)","price",$owner['login'],$price);
                    }
                    $agentModel->setAttributes(array("price"=>$owner['price']));
                }

                $agentModel->save(array("login"=>1),false);
                header( 'Location: /' );

            } else {
            // Если мы создаем нового агента
                if($agentModel->validate())
                    $agentModel->save();
                $userModel = new webUser();
                $userModel->setAttributes($_POST);
                $userModel->setAttribute(array("password" => md5($userModel->getAttribute("password"))));
                $userModel->setAttribute(array("type"=>3));

                if ($userModel->validate()) {
                    $userModel->save();
                }

                header( 'Location: /' );
            }

        }

    }

    public function deleteAction() {

        $id = $_GET['id'];
        $agentModel = new Agent();
        $agentModel->deleteById($id);
        header( 'Location: /' );

    }

    public function resetAction() {

        $id = $_GET['id'];
        $agentModel = new Agent();
        $agentModel->resetById($id);
        header( 'Location: /' );

    }

    private function genRequestsByFilter() {

        $User = User::getInstance();
        $requestsModel = new Request(); // Создаем модель заявок

        $requests=array();

        if(isset($_POST['my']) && $_POST['my']=='on')
            $requests = array_merge($requests,$requestsModel->getByLogin($User->login,0));

        if(isset($_POST['allMy']) && $_POST['allMy']=='on')
            $requests = array_merge($requests,$requestsModel->getAllByLogin($User->login,0));

        if(isset($_POST['payed']) && $_POST['payed']=='on')
            $payed = filterArray($requests,array("status_pay"=>1));

        if(isset($_POST['unpayed']) && $_POST['unpayed']=='on')
            $unpayed = filterArray($requests,array("status_pay"=>0));

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

            $requests = array_merge($requests,$requestsModel->getByLogin($User->login,0));
            $requests = array_merge($requests,$requestsModel->getAllByLogin($User->login,0));

            $requests = $this->findRequestBySearch($requests);
        }




        if(isset($_POST['startDate']) && isset($_POST['endDate'])) {

            preg_match_all ("(\d+)",$_POST['startDate'],$dateArray);
            $startDate = $dateArray[0][2].'-'.$dateArray[0][1].'-'.$dateArray[0][0];

            preg_match_all ("(\d+)",$_POST['endDate'],$dateArray);
            $endDate = $dateArray[0][2].'-'.$dateArray[0][1].'-'.$dateArray[0][0];

            $requests = filterArray($requests,array('startDate' => $startDate, 'endDate' =>$endDate ),1);

        }
        usort($requests, 'sorta');
            return $requests;
    }

    private function findRequestBySearch($requests) {


        $number = $_POST['car'];
        $name = $_POST['name'];

        if($name == "" && $number == "")
            return $requests;


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

    private function genMyAgents() {

        $User = User::getInstance();
        $agentsModel= new Agent(); // Создаем модель агентов
        $table= new Table(); // Создаем таблицу

        $table->setHeaders(array('second_name'=>'ФИО', "price"=>"Прайс")); // Устанавливаем заголовки
        $table->setData($agentsModel->getAgentsByLogin($User->login)); // Строим с ними таблицу
        $table->setClick("editAgent");

        return $table->renderOut();

    }

    private function genRequests($page,array $data) {

        $table= new Table(); // Создаем таблицу
        $table->setHeaders(array('_fullname'=>'ФИО агента','_reg'=>'Рег. данные','_brand'=>'Марка, модель','date_create'=>'Дата','status_pay'=>'Оплата','status_work'=>'Статус',"price"=>"Стоимость","_control"=>"Управление")); // Устанавливаем заголовки
        $table->setData($data);
        $table->setOptions(array('page'=>$page));
        $table->setReg();
        $table->setDownload();
        $table->setWorkCol();
        $table->setWorkText();
        $table->setClick("formRequest");
        $table->setPayText();
        $table->setFullname();
        $table->setBrand();

        $table->setPrice();
        return $table->renderOut();
    }

    private function genMyPrices() {

        $User = User::getInstance();
        $priceModel = new Price();
        $table = new Table();

        $prices = $priceModel->getByParam("agent",$User->login);

        $table->setHeaders(array("name" => "Название","date_create"=>"Дата создания","B" => "Легковые", "C" => "Грузовые"));
        $table->setData($prices);

        return $table->renderOut();

    }

    private function getPriceSum( array $requests = array()) {
        $priceModel= new Price();
        $amount=0;

        foreach ($requests as $request) {
            $priceId = $request["price"];
            $price = $priceModel->getById($priceId);
            $category = $request["category"];

            switch ($category) {
                case "A":
                    $amount += $price["A"]; break;

                case "M1":
                case "N1":
                     $amount += $price["B"]; break;

                case "N2":
                case "N3":
                     $amount += $price["C"]; break;
                case "M2":
                case "M3":
                     $amount += $price["D"]; break;

                case "O1":
                    $amount += $price["E_light"]; break;
                case "O2":
                case "O3":
                case "O4":
                    $amount += $price["E_light"]; break;

            }

        }
        return $amount;
    }

    private function getSumByMyPrice($requests) {
        $priceModel= new Price();
        $userModel = new Agent();
        $user = User::getInstance();

        $user=$userModel->getByParam("login",$user->login);
        $priceId=$user[0]["price"];
        $price=$priceModel->getById($priceId);

        $amount=0;

        foreach ($requests as $request) {
            $category = $request["category"];

            switch ($category) {
                case "A":
                    $amount += $price["A"]; break;

                case "M1":
                case "N1":
                    $amount += $price["B"]; break;

                case "N2":
                case "N3":
                    $amount += $price["C"]; break;
                case "M2":
                case "M3":
                    $amount += $price["D"]; break;

                case "O1":
                    $amount += $price["E_light"]; break;
                case "O2":
                case "O3":
                case "O4":
                    $amount += $price["E_light"]; break;
            }

        }
        return $amount;
    }

    private function genPriceDropdown($id) {
        $user = User::getInstance();
        $agentModel = new Agent();
        $dropdown = new Dropdown();
        $priceModel = new Price();

        $agent = $agentModel->getById($id);
        $selectId = $agent["price"];
        $myPrices = $priceModel->getByParam("agent", $user->login);
        $dropdown->setData($myPrices);
        $dropdown->setSelect($selectId);
        $dropdown->setIcon("plus","showNewPrice(event)");
        $dropdown->setName("price","Прайс");

        return $dropdown->renderOut();

        die;
    }

    private function genPriceDropdownbyId($id) {
        $user = User::getInstance();
        $agentModel = new Agent();
        $dropdown = new Dropdown();
        $priceModel = new Price();

        $agent = $agentModel->getById($user->$id);
        $price = $priceModel->getById($id);

        if ($price['agent'] == $user->login) {
            $dropdown->setSelect($id);
        }

        $myPrices = $priceModel->getByParam("agent", $user->login);
        $dropdown->setData($myPrices);
        $dropdown->setIcon("plus","showNewPrice(event)");
        $dropdown->setName("price","Прайс");

        return $dropdown->renderOut();


    }


}

// НУЖНО СДЕЛАТЬ:
// Добавить проверку на владение агентом\заявкой\прайсом


//Почистить базу.