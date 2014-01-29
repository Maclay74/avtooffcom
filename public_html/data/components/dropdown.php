<?php

class Dropdown extends Component {

    private $data;
    private $name="dropdown";
    private $key="id";
    private $value="name";
    private $title;
    private $selected;
    private $icon;
    private $iconLink;
    private $event;
    private $function;


    public function setData(array $data = array()){

        foreach ($data as $row) {
            $this->data[]=array($this->key => $row[$this->key],$this->value => $row[$this->value]);
        }
    }

    public function setName($name,$title=""){
        $this->name=$name;
        $this->title=$title;
    }

    public function setSelect($value) {
        $this->selected=$value;
    }

    public function render() {


       echo"<div style='display:inline-block' class='control-group'>";
         echo" <label style='margin:0px'  class='control-label' for='".$this->name."'>".$this->title."</label>";
            echo "<div  class='controls'>";
                echo "<select ".$this->event." = '".$this->function."' id='".$this->name."' name='".$this->name."' style='width: 224px;' class='input-large'>";

                    foreach ($this->data as $row)
                     echo"<option ".($row[$this->key]==$this->selected?"selected":"")." value='".$row[$this->key]."'>".$row[$this->value]."</option>";

            echo "</select>";
        if ($this->icon)
            echo " <i onclick='".$this->iconLink."' id='add' class='icon-".$this->icon."'></i>";
          echo "</div>";
        echo "</div>";


    }

    public function setFilter(array $filter = array("id"=>"name")) {
        $this->key = key($filter);
        $this->value = $filter[$this->key];
    }

    public function setEvent($event, $function) {
        $this->event = $event;
        $this->function = $function;
    }

    public function setIcon($icon, $link){
        $this->icon = $icon;
        $this->iconLink=$link;

    }
}