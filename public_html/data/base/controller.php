<?php

class Controller {

    protected $action;
    protected $name;
    public $rules;

    public  function __construct($action,$name) {

        $this->action=$action;
        $this->name=$name;

        $User = User::getInstance();

        if ($User->is_auth != 1) {
            header("Location: ?event=login&action=form");
        }


    }

    public function render ($template, $data = '') {
        ob_start();
        require_once("data/templates/".$this->name."/".$template);
        $content=ob_get_clean();
        echo $content;
    }




};