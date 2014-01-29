<?php

class Model {

     protected $table;
    protected $attributes;
    protected $validators;

    private $validateType = array(
        "text"=>"{[\- _ . , А-Яа-яa-zA-Z ]+}",
        "number"=>"{\d+}",
        "login"=>"{[a-z0-9_-]{3,16}}",
        "password"=>"{[A-Za-z0-9_-]{4,18}}",
    );

    public function save(array $dontSave = array(),$validate = true) {
        foreach ($dontSave as $key => $value) {
            unset($this->attributes[$key]);
        }
         if ($validate)
            if(!$this->validate()) return;

        $MYSQL = DB::getInstance();
        $id = $this->getAttribute('id');

        if ($this->getById($id)) {

            $result = $MYSQL->update($this->table,$this->attributes,array("id"=>$id));
            return $result;
        }
        else {
              $result = $MYSQL->insert($this->table,$this->attributes);
            return $result;

        }
    }

    public function deleteById($id) {
        $user = User::getInstance();
        if (model::byLogin("Requests",$user->login))
            return; 
        $MYSQL = DB::getInstance();
        $MYSQL->delete($this->table, array("id"=> $id));
    }

    public function setAttributes(array $attributes = array(),$debug=0) {

        foreach ($attributes as $key => $value)
            if (isset($this->attributes[$key])){
                $this->attributes[$key]=$value;
            }
    if ($debug)  var_dump($this->getAttributes());


    }

    public function getAttributes() {
       return $this->attributes;
    }

    public function getAttribute($attribute) {
        return $this->attributes[$attribute];
    }

    public function setAttribute(array $attribute = array()) {
        $key= key($attribute);
        if (isset($this->attributes[$key]))
            $this->attributes[$key]=$attribute[$key];
    }

    public function getAll($order = "id") {
        $MYSQL= DB::getInstance();
        $data=$MYSQL->get($this->table,array("*"),array(),false,$order);
        return $data;
    }

    static public function getAllFrom($table) {
        $MYSQL= DB::getInstance();
        $data=$MYSQL->get($table,array("*"),array(),false);
        return $data;
    }

    static public function byId($table,$id) {
        $MYSQL= DB::getInstance();
        if ($id!="")
            $data=$MYSQL->get($table,array("*"),array("id"=>$id));
        else
            return 0;
        return $data;
    }

    static public function byLogin($table,$login) {
        $MYSQL= DB::getInstance();
        if ($login!="")
            $data=$MYSQL->get($table,array("*"),array("login"=>$login));
        else
            return 0;
        return $data;
    }

    public function getById($id = "") {
        $MYSQL= DB::getInstance();

        if ($id!="")
            $data=$MYSQL->get($this->table,array("*"),array("id"=>$id));
        else
            return 0;

        return $data;
    }

    public function getByParam($key, $value) {
        $MYSQL= DB::getInstance();

        if ($value!="")
            $data=$MYSQL->get($this->table,array("*"),array($key=>$value),false);
        else
            return 0;

        return $data;
    }

    public function validate(array $dontCheck = array()) {



        $validate= true;
        foreach ($this->attributes as $key => $value) {
            if (!isset($dontCheck[$key]))
                if (isset($this->validators[$key])) {

                    $pattern=$this->validateType[$this->validators[$key]];
                    if ($pattern)
                        if(!preg_match($pattern,$value)) {
                            echo $key."<br>";
                            $validate = false;
                        }
                }
        }

           return $validate;
    }


};