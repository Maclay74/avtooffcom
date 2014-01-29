<?php

class Form extends Component {

    private $name;
    private $method;
    private $class;
    private $header;
    private $validate = 0;
    private $inputs = array();
    private $values;


    public function render() {


        echo "<form id='".$this->name."' name='".$this->name."' method='".$this->method."'  class='".$this->class."'>";
        echo "<fieldset>";
        echo "<legend>".$this->header."</legend>";


        foreach ($this->inputs as $input) {
           switch($input['type']) {
               case "dropdown":
                   $this->showDropDown($input);
                   break;

               case "date":
                   $this->showDate($input);
                   break;

               case "hide":
                   $this->showHide($input);
                   break;


               default:
                   $this->showInput($input);

           }
        }

        echo "</fieldset>";
        echo "</form>";

    }


    public function setValidate($validate) {
        $this->validate = $validate;
    }

    public function setMethod($method) {
        $this->method = $method;
    }

    public function addClass($class) {
        $this->class.= $class;
    }

    public function setHeader($header){
        $this->header = $header;
    }

    public function setValues($values){
        $this->values = $values;
    }

    public function setName($name){
        $this->name = $name;
    }

    public function addInput($name,$title = "",$type = "text",$validator = "",$tip = "", $placeholder = "" ,$size = "large",$required = false, $value = '') {

        $this->inputs[]=array(
            "name"=>$name,
            "type"=>$type,
            "title"=>$title,
            "placeholder"=>$placeholder,
            "validator"=>$validator,
            "size"=>$size,
            "required"=>$required,
            'tip' => $tip,
        );
    }

    public function addHide($value,$name) {
        $this->inputs[] = array(
            "value" => $value,
            "type" => "hide",
            "name" => $name,
        );

    }
    public function addDropDown($name,$title = "",array $data = array(),$selected = "") {

        $this->inputs[]=array(
            "name" => $name,
            "type" => "dropdown",
            "title"=> $title,
            'data' => $data,
            'selected' =>$selected,

        );
    }

    public function addDate($name,$title = "") {

        $this->inputs[]=array(
            "name" => $name,
            "title" => $title,
            "type" => "date"
        );
    }

    private function showInput(array $input) {
        echo "<div class='control-group'>";
            echo "<label class='control-label' for='".$input['name']."'>".$input['title']."</label>";
            echo "<div class='controls'>";
                echo "<input validatod='".$input['validator']."' id='".$input['name']."' value='".$this->values[$input['name']]."' name='".$input['name']."' type='".$input['type']."' placeholder='".$input['placeholder']."' class='input-".$input['size']."' ".(($input['required'])?" required ":"").">";
                echo "<i id='okay' style='display:none' class='icon-ok'></i>";
                echo "<i id='remove' style='display:none' class='icon-remove'></i>";
                echo "<code class='pull-right'>".$input['tip']."</code>";
            echo "</div>";
        echo "</div>";
    }

    private function showDropDown($input) {

        $dropdown = new Dropdown();
        $dropdown->setData($input['data']);
        $dropdown->setSelect($input['selected']);
        $dropdown->setName($input['name'],$input['title']);
        $dropdown->setSelect($this->values[$input['name']]);
        $dropdown->render();

    }

    private function showHide($input) {
        echo "<input type='text' value=".$input['value']." style='display:none' id = ".$input['name']." name = ".$input['name']." >";
    }

    private function showDate($input) {
        echo "<div class='control-group'> <label class='control-label' for='".$input['name']."'>".$input['title']."</label> <div class='controls'>";
           echo " <div id=".$input['name']." class='input-append date'>";
             echo " <input name='".$input['name']."' type='text' style='width:182px' value='".$this->values[$input['name']]."' ><span class='add-on'><i class='icon-th'></i></span>";
            echo "</div>";

           echo"<script> $('#".$input['name']."').datepicker({";
               echo " format: 'yyyy-mm-dd',";
               echo " language: 'ru',";
               echo " autoclose: true,";
               echo " keyboardNavigation: false";
            echo "}); </script>";
        echo "</div></div>";

    }
}