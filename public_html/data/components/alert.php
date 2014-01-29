<?php

class Alert extends Component {

    private $message;
    private $type;

    public function addMessage($message) {
        $this->message .= $message;
    }

    public function setType($type) {
        $this->type = $type;
    }

    public function render($message = "", $type = "") {
        if ($message)
           $this->addMessage($message);

        if ($type)
            $this->setType($type);


        echo "<div class='alert ".$this->type." '>";
             echo" <button type='button' class='close' data-dismiss='alert'>×</button>";
             echo $message;
        echo "</div>";

    }

}