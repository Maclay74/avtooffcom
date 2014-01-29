<?php



class loginController {

    protected $action;
    protected $name;

    public $rules = array (
        "all" => "allow"
    );

    public  function __construct($action,$name) {

        $this->action=$action;
        $this->name=$name;

    }


    public function indexAction(){
        $User = User::getInstance();


        if ($User->is_auth==1)
            switch ($User->type)
            {
                case 3:
                    header("Location: ?event=index");
                    break;

                case 1:
                    header("Location: ?event=index");
                    break;

                case 2:
                    header("Location: ?event=expert");
                    break;
            }

        if ($User->is_auth==0);
           header("Location: ?event=login&action=form");
    }

    public function logoutAction(){
        $User = User::getInstance();
        $User->logout();
    }

    public function authorizeAction(){
        $login=strtolower($_POST["login"]);  // Избавляемя от инъекций
        $pass=md5($_POST["pass"]);

        $this->authorize_user($login,$pass);
        header("Location: ?event=index");
    }

    public function formAction(){
        require_once "login/form.php";
    }

    private function authorize_user($login,$password)
    {
        $User = User::getInstance();
        $MYSQL = DB::getInstance();
        $db_ex = new SafeMySQL(array('user'=> 'avtooffcom','pass'=>'Htrkfvf2020', 'db' => 'avtooffcom'));
        $result = $db_ex->getRow('SELECT * FROM Users WHERE login = ?s AND password = ?s',$login,$password);
        // $result=$MYSQL->get("Users",array("*"), array("login"=>$login,"password"=>$password));



        if(isset($result['id']))
        {

            $User->_authorize($result);
            return true;
        }
        return false;
    }
}

