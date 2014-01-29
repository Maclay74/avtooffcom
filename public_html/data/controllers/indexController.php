<?php


class indexController {

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


        if ($User->is_auth == 1)
            switch ($User->type)
            {
                case 3:
                    header("Location: ?event=agent");
                    break;

                case 1:
                    header("Location: ?event=cashier");
                    break;

                case 2:
                    header("Location: ?event=expert");
                    break;
            }
        if ($User->is_auth==0) ;
          //  header("Location: ?event=login");



    }


}