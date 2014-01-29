<?php

class DB
{
	static private $instance = null;
	static public function getInstance() {
		if (self::$instance == null) {
			self::$instance = new DB();
		}
		return self::$instance;
	}
	
	
	private $host="localhost";
	private $user="avtooffcom";
	private $pass="Htrkfvf2020";
	private $database="avtooffcom";
	
	private function connection()
	{
		mysql_connect($this->host, $this->user,$this->pass) or die("Can't connect to MySQL");
		mysql_select_db($this->database) or die ("Could not connect to database");
		mysql_query("SET NAMES 'utf8'");
		mysql_query("SET CHARACTER SET 'utf8'");
		return true;
	}

	private function __construct()
	{
		$this->connection();
		
	}

	public function query($query, $can_result = true,$to_one= true)
	{
		
		$fields = array();
		
		$result=mysql_query ($query);


        // ОШИБОЧКИ СРАНОГО MYSQL ТУТ ВКЛЮЧАЮТСЯ
        //echo mysql_errno() . ": " . mysql_error() . "\n";
		
		if (!$can_result)
			return true;
			
		while($row = mysql_fetch_assoc($result)) 
		{
			$fields[] = $row;
		}
			
		 
		if (count($fields) == 1)
			if ($to_one==1)
				return $fields[0];
			else
				return $fields; 
		else
			return $fields; 
	}
	
	public function order($table,$field,$type="ASC")
	{
		$query="ALTER TABLE  %s ORDER BY  %s %s";
		$query=sprintf($query,$table, $field, $type);
		$this->query($query,false);
	}
	
	public function get($table, array $select, array $where=array(),$to_one=true, $order = "id")
	{

		$query="SELECT %s FROM %s WHERE %s";
		$select_str=implode(", ", $select);
		$where_str = array();
		foreach ($where as $key=>$value)	{
		    $where_str[]=$key." = '". htmlspecialchars($value)."'";
		}
		$where_str=implode(" AND ", $where_str);

		if(empty($where_str))
			$where_str=1;

		$query=sprintf($query,$select_str, $table, $where_str. " ORDER BY ".$order);


		return $this->query($query, true, $to_one);
	}

	public function getUsers(array $where =array()) {
		return $this->get("Users", array("*"), $where);
	}
	
	
	public function insert($table,array $values)
	{
		$query="INSERT INTO %s (%s) VALUES (%s)";
		$fields = array();
		$values_new = array();
		foreach ($values as $key => $value)
		{
			$fields[]=$key;
			$values_new[]="'".htmlspecialchars($value)."'";
		}
		
		$fields=implode(", ",$fields); 
		$values_new=implode(", ",$values_new);
		$query=sprintf($query, $table, $fields, $values_new);
		$this->query($query, false);
		return mysql_insert_id();
	}
	
	public function update($table, array $values, array $where)
	{
		$query="UPDATE %s SET %s WHERE %s";
		
		if (!count($values)) 
			return false;
			
		$where_str = array();
		$values_str = array();
		foreach ($where as $key=>$value)
		{
			$where_str[]=$key." = '". htmlspecialchars($value)."'";
		}
		foreach ($values as $key=>$value)
		{
			$values_str[]=$key." = '". htmlspecialchars($value)."'";
		}
		
		if(empty($where_str))
			$where_str=1;
		
		$values_str=implode(" , ", $values_str);
		$where_str=implode(" AND ", $where_str);
		
		$query=sprintf($query,$table, $values_str, $where_str);

		$this->query($query, false);
		return true;
	}

	
	public function delete($table, array $where)
	{
		$query="DELETE FROM %s  WHERE %s";
		$where_str = array();
		foreach ($where as $key=>$value)
		{
			$where_str[]=$key." = '". htmlspecialchars($value)."'";
		}
		if(empty($where_str))
			$where_str=1;
		$where_str=implode(" AND ", $where_str);
		
		$query=sprintf($query,$table, $where_str);
		$this->query($query, false);
		return true;
	
	}
}