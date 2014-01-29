<?php

class Component {

    public function renderOut() {
        ob_start();
        $this->render();
        $result=ob_get_clean();
        return $result;
    }




}