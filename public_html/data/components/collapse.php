<?php

class Collapse extends Component {

    private $data=array();
    private $number;
    private $name;

    public function __construct(array $data=array(),$name='') {
        $this->data=$data;
        $this->name=$name;
    }

    public function setData(array $data=array(),$name='') {
        $this->data=$data;
        $this->name=$name;
    }

    public function render() {

        echo " <div class='accordion' id='accordion".$this->name."'>";

        foreach ($this->data as $key => $value) {
          $this->number++;

            echo "<div class='accordion-group'>";
                echo " <div class='accordion-heading'>";
                    echo " <a class='accordion-toggle' data-toggle='collapse' data-parent='#accordion".$this->name."' href='#collapse".$this->name.$this->number."'>";
                    echo $key;
                    echo "</a>";
                echo "</div>";
                echo " <div id='collapse".$this->name.$this->number."' class='accordion-body collapse '>";
                    echo "<div class='accordion-inner'>";
                         echo $value;
                    echo "</div>";
                echo "</div>";
            echo "</div>";
        }
        echo "</div>";
        $this->number=0;
    }

}