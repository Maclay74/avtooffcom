<?php


class expertController extends Controller {

    public $rules = array (
        "0" => "allow",
        "2" => "allow",
        "all" => "deny"
    );

    public function indexAction(){
        $this->render("index.php");
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


private function genRequests($page,array $data) {

    $table= new Table(); // Создаем таблицу
    $table->setHeaders(array('card_number'=>'Номер ЕАИСТО','_reg'=>'Рег. данные','_brand'=>'Марка, модель','date_create'=>'Дата','_agent'=>'Агент','status_work'=>'Статус','status_1c'=>'Статус 1С')); // Устанавливаем заголовки
    $table->setData($data);
    $table->setOptions(array('page'=>$page));
    $table->setWorkCol();
    $table->setWorkText();
    $table->set1СText();
    $table->setSmartAgent();
    $table->setNumberCard();
    $table->setBrand();
    $table->setReg();
    $table->setClick("formRequest");
    $table->setPayText();
    return $table->renderOut();
}

public function TreeAction() {

    $tree = new AgentsTree();
    $tree->renderAgentTree($_GET['agent']);

}

private function genRequestsByFilter() {
    $requestModel = new Request();
    $requests = $requestModel->getAll("date_create DESC");
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