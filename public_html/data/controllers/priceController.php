<?php


class priceController extends Controller {

   /* public function indexAction() {
        echo "LOL";
    }*/
    public $rules = array (
        "1" => "allow",
        "2" => "allow",
        "3" => "allow",
        "all" => "deny"
    );
    public function formAction() {

        $id = $_GET['id'];
        $priceModel = new Price();


        if (empty($_POST)) {
            $price=$priceModel->getById($id);
            $this->render("form.php",$price);
        }
        else {

            $user = User::getInstance();
            $priceModel->setAttributes($_POST);
            $priceModel->setAttribute(array("agent"=>$user->login, "date_create"=> date("Y-m-d")));

            $priceModel->save();

            header( 'Location: /' );
        }

    }


}