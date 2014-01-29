<?php


class requestController extends Controller {


    public $rules = array (
        "1" => "allow",
        "2" => "allow",
        "3" => "allow",
        "4" => "allow",
        "all" => "deny"
    );


    public function formAction() {


        $id = $_GET['id'];

        $requestModel = new Request();

        if (empty($_POST)) {

            $request[0] = $requestModel->getById($id);
            if ($request[0]['status_work'] == 0 && $id > 0)  $requestModel->changeWorkStatus(1,$id);
            $this->render("form.php",$request);
        }
        else {

            $this->saveRequest($id);
            header( 'Location: /' );

        }

    }

    public function sendAction() {
        $user = User::getInstance();
        if ($user->type !=2)
            return;
    $id = $_GET['id'];
    $this->saveRequest($id);
    $this->sendRequest($_GET['id']);

    }

    public function deleteAction() {
        $user = User::getInstance();

        $id = $_GET['id'];
        $requestModel = new Request();
        $request = $requestModel->getById($id);

        if ($request['status_work']==5 && $user->type == 2){
            $requestModel->changeWorkStatus(4,$id);

        }
        else {
            $requestModel->changeWorkStatus(5,$id);
            $message = "";
            $request = $requestModel->getAttributes();

            $message .= "<b> Рег. знак:</b> ".$request['reg_number']."<br>";
            $message .= "<b> ФИО:</b> ".$request['first_name']." ".$request['second_name']." ".$request['third_name']."<br>";
            $message .= "<b> VIN:</b> ".$request['VIN_number']."<br>";
            $message .= "<b> Марка:</b> ".$request['brand']."<br>";
            $message .= "<b> Модель:</b> ".$request['model']."<br>";
            $message .= "<b> Год:</b> ".$request['year']."<br>";
            $message .= "<b> Категория:</b> ".$request['category']."<br>";
            $message .= "<b> Дата создания:</b> ".$request['date_create']."<br>";

            $headers  = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
            $headers .= 'From: avto-office.com' . "\r\n" .
                'X-Mailer: PHP/' . phpversion();

            $agent = Agent::getNameByLogin($request['agent']);

            mail("avtospeya@mail.ru","Запрос на удаление от "." ".$agent[0]['second_name'],$message,$headers);

        }


        header("Location: /");
        return ;
    }

    public function cancelAction() {
        $user = User::getInstance();
        if ($user->type !=2)
            return;
        $id = $_GET['id'];
        $requestModel = new Request();
        $request = $requestModel->getById($id);
        if ($request['status_work'] == 5){
            $requestModel->changeWorkStatus(6,$id);
        }


        header("Location: /");
        return ;
    }

    public function downloadAction() {

       $id = $_GET['id'];
        $request = model::byId('Requests',$id);

        $this->render("index.php",$request);

    }

    private function sendRequest($id) {
        $requestModel = new Request;


        $MYSQL= DB::getInstance();
        $User = User::getInstance();

        // Получаем все сведения из формы
        $form_data = $requestModel->getById($id);
        $form_data['validate']=$_POST['validate'];

        // Узнаем эксперта, который отправляет машину:
        $expert = Model::byLogin("Experts",$User->login);

        $data["Expert"] = array("Name"=>"Алекcей", "FName" => "Плесковский");

        // Создаем подключение к ЕАИСТО:
        $client = new SoapClient('http://eaisto.gibdd.ru/common/ws/arm_expert.php?wsdl');
        $user["Name"] = "speya02"; // Логин
        $user["Password"] = "Ufptkm"; // Пароль


        // Заполняем ФИО владельца:
        $data["Name"] = $form_data["second_name"];// Фамилия;
        $data["FName"] =  $form_data["first_name"]; // Имя
        $data["MName"] = $form_data["third_name"]; // Отчество

        // Заполняем результаты осмотра:
        $data["TestResult"] = "Passed";
        $data["TestType"] = "Primary";
        $data["DateOfDiagnosis"] = date('Y-m-d');


        // Заполняем Данные ТС:
        $data["RegistrationNumber"] = $form_data["reg_number"];
        $vehicle["Make"]=$form_data["brand"];
        $vehicle["Model"]=$form_data["model"];
        $form["Validity"]=date('Y-m-d',strtotime("+ ".$form_data["validate"]." month"));
        $form["Duplicate"]="0";
        if ($form_data["comment"]!="Очередное ТО")
            $form["Comment"]=$form_data["comment"];
        $data["Form"]=$form;
        $data["Vin"] = strtoupper($form_data["VIN_number"]);
        $data["FrameNumber"] = $form_data["chassis"];
        $data["Year"] = $form_data["year"];
        $data["EmptyMass"] = $form_data["min_mass"];
        $data["MaxMass"] =  $form_data["max_mass"];
        $data["VehicleCategory2"] = $form_data["category"];
        $data["Vehicle"] = $vehicle; // Тип ТС
        $data["BodyNumber"] =$_POST["body"]; // Номер кузова

        switch ($form_data["fuel_type"])
        {
            case 1: $data["Fuel"] = "Petrol"; break;
            case 2: $data["Fuel"] = "Diesel"; break;
            case 3: $data["Fuel"] = "PressureGas"; break;
            case 4: $data["Fuel"] = "LiquefiedGas"; break;
        }

        switch ($form_data["break_type"])
        {
            case 4: $data["BrakingSystem"] = "Mechanical"; break;
            case 1: $data["BrakingSystem"] = "Hydraulic"; break;
            case 2: $data["BrakingSystem"] = "Pneumatic"; break;
            case 3: $data["BrakingSystem"] = "Combined"; break;
        }

        switch ($form_data["category"])
        {
            case "A":  $data["VehicleCategory"] = "A"; break;
            case "N1": case "M1" : $data["VehicleCategory"] = "B"; break;
            case "M3": case "M2" : $data["VehicleCategory"] = "D"; break;
            case "N3": case "N2" : $data["VehicleCategory"] = "C"; break;
            case "O1": case "O2": case "O3": case "O4" : $data["VehicleCategory"] = "O"; $data["Fuel"] = "None"; break;
        }

        $data["Tyres"] = $form_data["wheels"];
        $data["Killometrage"] = $form_data["mileage"];


        // Документ регистрационный
        switch ($form_data["doc_type"])
        {
            case 1:  $RegistrationDocument["DocumentType"]="RegTalon"; break;
            case 2:  $RegistrationDocument["DocumentType"]="PTS"; break;
        }
        $RegistrationDocument["Series"]=strtoupper($form_data["seria"]);
        $RegistrationDocument["Number"]=$form_data["number"];
        $RegistrationDocument["Organization"]=$form_data["issued_by"];
        $RegistrationDocument["Date"]=$form_data["issued_when"];
        $data["RegistrationDocument"] = $RegistrationDocument;

        // Собираем все данные вместе:
        $params["card"] = $data;
        $params["user"] = $user;

        // Отправляем данные в ЕАИСТО:


        try
        {
            if ($result = $client->RegisterCard($params))
            {
                $expert_id = "54";
                $expert = model::byId("Experts",$expert_id);
                $expert_count = $expert['count']+1;
                $expert_count = substr("00000",strlen($expert_count)).$expert_count;
                $expert_number = $expert['number'];

                $array = (array)$result;
                $number=$array["Nomer"];
                $id=$_GET['id'];
                $status = ($form_data['status_work'] == 1)? $status = 6 : $status = $form_data['status_work'];
                $MYSQL->update("Experts",array("count"=>$expert['count']+1),array ("id"=> $expert_id));
                $MYSQL->update("Requests",array("card_in_number"=>"05657".$expert_number.date("y").$expert_count ,"card_number"=>$number,"date_create"=>date("Y-m-d H:i:s"),"status_work"=>$status,"date_exist"=>date("Y-m-d",strtotime("+ ".$form_data["validate"]." month"))),array("id"=>$id));
                echo "<div class='alert alert-success' style=' text-align: left; float:left; height:20px;'>";
                echo "<p><strong>Заявка успешно отправлена.</strong> Номер карты: $number</p>";
                echo "</div>";

            }
            else
            {
                throw new Exception();
            }
        }
        catch(Exception $error_send)
        {
            echo "<div class='alert alert-error' style=' text-align: left; margin-bottom:0px;float:left; '>";
            echo "<p>".$error_send->getMessage()."</p>";
            echo "</div>";
        }


    }

    private function saveRequest($id) {

        $user = User::getInstance();
        $requestModel = new Request();
        $agentModel = model::byLogin("Agents",$user->login);
        $request = $requestModel->getById($id);



        if (!empty($request)) {
            $requestModel->setAttributes($request);


        if (($request['status_work'] == 0 || $request['status_work'] == 2 || $request['status_work'] == 1 || $request['status_work'] == 3)){

            $message = "";
            $request = $requestModel->getAttributes();

            $message .= "<b> Рег. знак:</b> ".$request['reg_number']."<br>";
            $message .= "<b> ФИО:</b> ".$request['first_name']." ".$request['second_name']." ".$request['third_name']."<br>";
            $message .= "<b> VIN:</b> ".$request['VIN_number']."<br>";
            $message .= "<b> Марка:</b> ".$request['brand']."<br>";
            $message .= "<b> Модель:</b> ".$request['model']."<br>";
            $message .= "<b> Год:</b> ".$request['year']."<br>";
            $message .= "<b> Категория:</b> ".$request['category']."<br>";
            $message .= "<b> Дата создания:</b> ".$request['date_create']."<br>";

            $headers  = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
            $headers .= 'From: avto-office.com' . "\r\n" .
                'X-Mailer: PHP/' . phpversion();

            $agent = Agent::getNameByLogin($request['agent']);

            mail("avtospeya@mail.ru","Запрос на исправления от "." ".$agent[0]['second_name'],$message,$headers);
        }

        }




        // А этот агент владеет этой заявкой?.. Мошенник, не иначе!
        if ($user->type == 3 && !empty($request)) {

            if (strtolower($request['agent']) != strtolower($user->login)){
                header("Location: /");
                return ;
                die;
            }

            if ($request['status_work'] == 6 || $request['status_work'] == 1 || $request['status_work'] == 3)
                $requestModel->changeWorkStatus(2,$id);

        }

        if ($user->type == 2) {
            $requestModel->setAttribute(array("date_exist"=>date("Y-m-d",strtotime("+ ".$_POST["validate"]." month"))));
            if ($request['status_work'] == 2)
                $requestModel->changeWorkStatus(6,$id);
        }

        $requestModel->setAttributes($_POST);



        $requestModel->setAttribute(array("id" => $id));
        $requestModel->setAttributes(array(
            'agent' => (!empty($request))? $request['agent'] : $user->login,
            'date_create' => date('Y-m-d H:i:s'),
            'price' => ($user->type == 3)? $agentModel['price'] : $request['price']

        ));

        $requestModel->save(array(),false);


        // Уведомляем по email
        if (empty($request)){
            $message = "";
            $request = $requestModel->getAttributes();

            $message .= "<b> Рег. знак:</b> ".$request['reg_number']."<br>";
            $message .= "<b> ФИО:</b> ".$request['first_name']." ".$request['second_name']." ".$request['third_name']."<br>";
            $message .= "<b> VIN:</b> ".$request['VIN_number']."<br>";
            $message .= "<b> Марка:</b> ".$request['brand']."<br>";
            $message .= "<b> Модель:</b> ".$request['model']."<br>";
            $message .= "<b> Год:</b> ".$request['year']."<br>";
            $message .= "<b> Категория:</b> ".$request['category']."<br>";
            $message .= "<b> Дата создания:</b> ".$request['date_create']."<br>";

            $headers  = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
            $headers .= 'From: avto-office.com' . "\r\n" .
                'X-Mailer: PHP/' . phpversion();

            $agent = Agent::getNameByLogin($request['agent']);

            mail("avtospeya@mail.ru","Новая заявка от "." ".$agent[0]['second_name'],$message,$headers);
        }

    }


}

// Внутренние валидаторы!

/*
 * Сохранение заявки
 * При создании агента
 * Мое имя на "Моя заявка"
 * Поля эксперта
 *
 */