<?php

class Router {
    private $event;
    private $action;
    private $controller;

    public function __construct($event, $action)
	{

		if ($event=="")
			$event="index";

        if ($action=="")
            $action="index";

        $this->event = $event."Controller";
        $this->action = $action."Action";
        $this->controller = $event;

    }

    public function executeController() {

        $this->controller = new $this->event($this->action,$this->controller);

        if (method_exists ($this->controller,$this->action)) {
            $user = User::getInstance();
            $userType = $user->type;

            $rule = $this->controller->rules[$userType];

            if ($this->controller->rules["all"] != "allow"){


                if ($rule == "allow") {
                    $this->controller->{$this->action}();
                    return true;
                } else {
                    echo "Вы не имеете доступа к этому контроллеру. ";
                    die;
                }
            }
            else {
                $this->controller->{$this->action}();
                return true;
            }

        }
        else
            echo 'Метод не найден';
            die;
    }
}