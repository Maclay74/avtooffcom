<?php



class Table extends Component
{

    private  $headers=array(); // Заголовки
    private  $data=array(); // Значения полей
    private  $opts=array(); // Настройки
    private  $start; // Начальная позиция
    private  $perPage = 10; // Записей на странице
    private  $count; // Всего записей
    private  $pageCount; // Количество страниц
    private  $page=1; // Текущая страница

    public function render()    {


        if (isset($this->opts['page']))
            $this->page=$this->opts['page'];

        $this->start = $this->page * $this->perPage - $this->perPage;

        if ($this->opts['type']=='agent') {
            $this->setLink("window.location.href=?event='agent&action=reset&id=");

        }

            echo "<table class='table table-bordered table-hover responsive-utilities'>";
            echo "<thead>";
            echo "<tr>";


            foreach ($this->headers as $header => $name)


                echo "<td><b>".$name."</b></td>";

            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";

            $i=0;
            foreach ($this->data as $number => $row) {

                if(($this->start + $this->perPage) <= $i) break;

                if($i >= $this->start) {
                    echo "<tr id=".$row["id"]." style='cursor: pointer;' class='".$row["_class"]."'>";
                    foreach($this->headers as $header => $name) {

                        if ( $header != '_control' && $header != '_agent' && $header != 'card_number')
                            echo "<td  onclick='".$row["_click"]."'>".$row[$header]."</td>";
                        else
                            echo "<td>".$row[$header]."</td>";
                    }
                    echo "</tr>";
                }
                $i++;
            }

            echo "</tbody>";
            echo "</table>";

            if($this->pageCount>1)
            $this->renderPagination();

    }

    private function renderPagination(){
        $before=2;
        $after=2;
        echo "<div align='center' class='pagination'>";
        echo "<ul>";
        echo "<li><a style='cursor:pointer' page='1'>Начало</a></li>";
        for ($i = $this->page - $before; $i <= $this->page + $after; $i++) {
            if ($i>0 && $i <= $this->pageCount)
                echo "<li><a style='cursor:pointer' page=".$i." >". $i ."</a></li>";
        }
        echo "<li><a style='cursor:pointer' page=".$this->pageCount." >Конец</a></li>";
        echo "</ul>";
        echo "</div>";
    }

    public function setHeaders(array $headers=array()) {
        $this->headers=$headers;
    }

    public function setData(array $data=array()) {
        $this->data=$data;
        $this->count=count($data);
        $this->pageCount=ceil($this->count/$this->perPage);

    }

    public function setOptions(array $opt=array()) {
        $this->opts=$opt;
    }

    public function setWorkText() {

        if (empty($this->data)) {
            return 0;
        }

        foreach ($this->data as $number => $data) {
            switch ($this->data[$number]["status_work"]) {
                case 0:
                    $this->data[$number]["status_work"]='Новая'; break;

                case 1:
                    $this->data[$number]["status_work"]='Обработка'; break;

                case 2:
                    $this->data[$number]["status_work"]='Редактирование'; break;

                case 3:
                    $this->data[$number]["status_work"]='Исполнено'; break;

                case 4:
                    $this->data[$number]["status_work"]='Удалено'; break;

                case 5:
                    $this->data[$number]["status_work"]='Требуется отмена'; break;

                case 6:
                    $this->data[$number]["status_work"]='Исполнено'; break;

                default:
                    $this->data[$number]["status_work"]=''; break;
            }
        }
    }

    public function setWorkCol() {

        if (empty($this->data)) {
            return 0;
        }

        foreach ($this->data as $number => $data) {
            switch ($this->data[$number]["status_work"]) {

                case 0:
                    $this->data[$number]["_class"]='info'; break;

                case 1:
                    $this->data[$number]["_class"]=''; break;

                case 2:
                    $this->data[$number]["_class"]='error'; break;

                case 3:
                    $this->data[$number]["_class"]='success'; break;

                case 4:
                    $this->data[$number]["_class"]=''; break;

                case 5:
                    $this->data[$number]["_class"]='warning'; break;

                case 6:
                    $this->data[$number]["_class"]='success'; break;


                default:
                    $this->data[$number]["_class"]=''; break;
            }
        }
    }

    public function setPayCol() {

        if (empty($this->data)) {
            return 0;
        }

        foreach ($this->data as $number => $data) {
            switch ($this->data[$number]["status_pay"]) {

                case 0:
                    $this->data[$number]["_class"]='warning'; break;

                case 1:
                    $this->data[$number]["_class"]='success'; break;


                default:
                    $this->data[$number]["_class"]=''; break;
            }
        }
    }

    public function set1cCol() {

        if (empty($this->data)) {
            return 0;
        }

        foreach ($this->data as $number => $data) {
            switch ($this->data[$number]["status_1c"]) {

                case 0:
                    $this->data[$number]["_class"]='warning'; break;

                case 1:
                    $this->data[$number]["_class"]='success'; break;


                default:
                    $this->data[$number]["_class"]=''; break;
            }
        }
    }

    public function set1СText() {

        if (empty($this->data)) {
            return 0;
        }

        foreach ($this->data as $number => $data) {
            switch ($this->data[$number]["status_1c"]) {
                case 1:
                    $this->data[$number]["status_1c"]='Занесено'; break;
                default:
                    $this->data[$number]["status_1c"]='Не занесено'; break;
            }
        }
    }

    public function setPayText() {

        if (empty($this->data)) {
            return 0;
        }

        foreach ($this->data as $number => $data) {
            switch ($this->data[$number]["status_pay"]) {
                case 1:
                    $this->data[$number]["status_pay"]='Оплачено'; break;
                default:
                    $this->data[$number]["status_pay"]='Неоплачено'; break;
            }
        }
    }

    public function setPrice($priceId = null) {



        $priceModel = new Price();
        foreach ($this->data as $number => $data) {

            if (!$priceId)
                $priceId=$this->data[$number]["price"];

            $price=$priceModel->getById($priceId);
            $category=$this->data[$number]["category"];


            switch ($category) {
                case "A":
                    $this->data[$number]["price"]=$price["A"]; break;

                case "M1":
                case "N1":
                    $this->data[$number]["price"]=$price["B"]; break;

                case "N2":
                case "N3":
                    $this->data[$number]["price"]=$price["C"]; break;
                case "M2":
                case "M3":
                    $this->data[$number]["price"]=$price["D"]; break;

                case "O1":
                    $this->data[$number]["price"]=$price["E_light"]; break;
                case "O2":
                case "O3":
                case "O4":
                    $this->data[$number]["price"]=$price["E_light"]; break;

            }

            $priceId=false;

        }

    }

    private function setAgentControl($request) {


        if (empty($request)) {
            return;
        }
        if (!isset($request["status_work"])) {
            return;
        }
        else {


            switch ($request["status_work"]) {
                case 2:
                    $request["_control"].="<a rel='tooltip' data-original-title='Удалить' class='btn btn-small ' onclick='RemoveRequest(".$request['_reg'].",".$request['id'].");' data-toggle='modal' ><i class='icon-trash'></i></a>"."&nbsp;";
                    $request["_control"].="<a rel='tooltip' data-original-title='Загрузить PDF' class='btn btn-small ' href='?event=pdf&no_template&id=".$request['id']."'  data-toggle='modal' ><i class='icon-download-alt'></i></a>";

                break;

                case 0:
                case 1:
                case 4:
                    $request["_control"].="<a rel='tooltip' data-original-title='Отменить' class='btn  btn-small ' onclick='CancelRequest(".$request['id'].");' data-toggle='modal' ><i class='icon-remove'></i></a>"."&nbsp;";


                 break;


                default:
                    $request["_control"]=''; break;
            }


            return $request;

        }
    }

    public function setClick($doing) {
        foreach ($this->data as $request => $data) {
           $this->data[$request]['_click']=$doing."(".$data['id'].")";
        }
    }

    public function setSmartAgent() {
        foreach ($this->data as $request => $data) {
            $owners = Agent::getManager($this->data[$request]['agent']);

            $this->data[$request]['_agent']="<a onclick='showTreeAgent(\"".$this->data[$request]['agent']."\")' >".$owners['manager']['second_name'].(isset($owners['agent'])?" -> ".$owners['agent']['second_name']:"")."</a>";
        }
    }
    public function change1C() {
        foreach ($this->data as $request => $data) {
            $this->data[$request]['_control']="<a onclick='change1c(\"".$this->data[$request]['id']."\")' >".$this->data[$request]['status_1c']."</a>";
        }
    }

    public function setFullname() {
        $user = User::getInstance();
        foreach ($this->data as $request => $data) {

            $fullname = Agent::getNameByLogin($this->data[$request]['agent']);
            if ($user->login == $fullname[0]['login'])
                $this->data[$request]['_fullname'] = "Моя заявка";
            else
                $this->data[$request]['_fullname'] = $fullname[0]['second_name'];


        }
    }

    public function setBrand() {
        foreach ($this->data as $request => $data) {
            $this->data[$request]['_brand'] = $this->data[$request]['brand']." ".$this->data[$request]['model'];
        }
    }

    public function setReg() {
        foreach ($this->data as $request => $data) {
            if (strlen($this->data[$request]['reg_number'])){
                $this->data[$request]['_reg'] = $this->data[$request]['reg_number'];
            }elseif (strlen($this->data[$request]['VIN_number'])){
                $this->data[$request]['_reg'] = strtoupper($this->data[$request]['VIN_number']);
            }elseif (strlen($this->data[$request]['body'])){
                $this->data[$request]['_reg'] = $this->data[$request]['body'];
            }elseif (strlen($this->data[$request]['chassic'])){
                $this->data[$request]['_reg'] = $this->data[$request]['chassic'];
            }

        }
    }

    public function setDownload() {
        foreach ($this->data as $request => $data) {

            if ($this->data[$request]['status_work'] == 6 || $this->data[$request]['status_work'] == 3) {
                $this->data[$request]['_control']="
                    <a rel='tooltip' data-original-title='Загрузить PDF' onclick='downloadRequest(".$this->data[$request]['id'].");'> <img src='/images/pdf_icon.png'> </a>
                    <a rel='tooltip' data-original-title='Удалить' onclick='deleteDialog(\"".$this->data[$request]['_reg']."\",".$this->data[$request]['id'].");'> <i class='icon-trash'></i> </a>

                    ";
            }
        }
    }

    public function setNumberCard() {
        foreach ($this->data as $request => $data) {
                $this->data[$request]['card_number']="<a onclick='downloadRequest(".$this->data[$request]['id'].");'>".$this->data[$request]['card_number']."</a>";
            }
    }


    public function setLink($page) {
        foreach ($this->data as $request => $data) {
            //$this->data[$request]['_link']=$page.$data['id'];
            $this->data[$request]['_link'] = sprintf($page,$data['id']);

        }
    }

    public function setChangePayStatus() {
        foreach ($this->data as $request => $data) {
            $this->data[$request]['changePayStatus'] = "<input id=".$this->data[$request]['id']." onchange='selectRequest(".$this->data[$request]['id'].",event)' class='large' ".(($this->data[$request]['status_pay'])?"checked":"")."  type='checkbox'> ";

        }
    }

    public function setChange1CStatus() {
        foreach ($this->data as $request => $data) {
            $this->data[$request]['status_1c'] = "<div onclick ='change1c(".$this->data[$request]['id'].") '>". $this->data[$request]['status_1c']." </div> ";

        }
    }

}


