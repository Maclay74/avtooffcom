<?php

class User
{
	static private $instance = null;

	static public function getInstance() {
		if (self::$instance == null) {
			self::$instance = new self();
		}
		return self::$instance;
	}
	
	public $id, $type, $login, $session_id, $is_auth;
	
	private function __construct()
	{
		$this->authorize();
		$this->getParams();
	}
	
	private function getParams() {
		$MYSQL = DB::getInstance();
		$result = $MYSQL->getUsers(array("id"=>$_SESSION["user_id"]));
		$this->id = $result['id'];
		$this->type = $result['type'];
		$this->login = $result['login'];
		$this->session_id = $result['session_id'];
		$this->is_auth = $_SESSION["is_auth"];
	}
	
	public function logout()
	{
	session_destroy();
	$MYSQL = DB::getInstance();
	$MYSQL->update("Users",array("session_id"=>""),array("id"=>$this->id));
	header("Location: ?event=index");
	}
	
	public function authorize($login="",$password="")
	{	
		
		if ($this->is_auth)
			return true;
			

		if(isset($_COOKIE["user_session"]))
		{
			
			$cookie_session=mysql_real_escape_string($_COOKIE["user_session"]); // Сессия из куки
			$MYSQL = DB::getInstance(); 
			$result=$MYSQL->get("Users",array("*"),array("session_id"=>$cookie_session)); // Ищем, сидел ли кто-то с такой же сессией
			
			if(isset($result["id"])) // Если кто-то нашелся
				$this->_authorize($result); // Авторизируем его
				
		}
	}
	
	public function _authorize(array $result)
	{
        $db_ex = new SafeMySQL();
		$MYSQL = DB::getInstance();
		$_SESSION["is_auth"]=1;
		$_SESSION["user_id"]=$result["id"];
		$_SESSION["user_type"]=$result["type"];
		
		setcookie("user_session",session_id(),time()+9999999999);
        //$result = $db_ex->getRow('UPDATE Users SET session_id = ?s WHERE id = ?i ',session_id(),$result["id"]);
		$MYSQL->update("Users",array("session_id"=>session_id()),array("id"=>$result["id"]));
	
		$this->is_auth = true;
	
		return true;
	}

}



