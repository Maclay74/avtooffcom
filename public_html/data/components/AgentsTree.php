<?php

class AgentsTree extends Component {

    private $agents = array();

    public function __construct () {
        $this->agents = model::getAllFrom("Agents");
    }

    public function render() {

            $this->renderAgentTree($this->agents[1]);
    }

    public function renderAgentTree($agentName) {
        $agent=model::byLogin("Agents",$agentName);
        $stop = false;
        $tree[]=array(
            "manager" => $agent['manager'],
            "second_name"=> $agent['second_name'],
            "login"=>$agent['login']);
        $testAgent = model::byLogin("Agents",$agent['manager']);
        while ($stop == false) {
            // Agent's manager

            // If it's not "admin"

            if ($testAgent['manager'])  {
                $tree []= array(
                    "manager" => $testAgent['manager'],
                    "second_name"=> $testAgent['second_name'],
                    "login"=>$testAgent['login']);
                $testAgent = model::byLogin("Agents",$testAgent['manager']);
            }
            else
            {
                $stop = true;
            }

        }

        $tree []= array(
            "manager" => "GOD",
            "second_name"=> "Администратор",
            "login"=> "admin");

        $tree = array_reverse($tree);
       foreach ($tree as $agent) {
           echo " <div style='margin-left: 8px; box-shadow: 1px 1px 8px; border-radius: 3px; text-shadow: 1px 1px 2px rgba(150, 150, 150, 1); background-color:whitesmoke; margin-top: 10px; text-align: center; border: 1px solid black; padding: 10px; width:150px' >".$agent['second_name']." </div> ";

       }

        $agentName = $agent['second_name'];


    }
}