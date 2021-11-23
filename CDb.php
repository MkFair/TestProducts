<?php


//класс базы для сокрытия работы с sql
class CDb{
	
	protected static $db_object;
	public static function create(){
		if(!self::$db_object)
			self::$db_object = new CDb();
		return self::$db_object;
	}


	protected $mysqli;
	public function __construct(){
		require_once"config.php";
		if(empty($config["db"])) throw new Exception("Конфигурация базы не определена");
		
		$this->mysqli = new mysqli($config["db"]["host"],$config["db"]["user"],$config["db"]["password"],$config["db"]["db"]);
		if($this->mysqli->connect_errno) throw new Exception("Ошибка подключения:".$this->mysqli->connect_error);
		$this->mysqli->query("USE CHARSET UTF8");
	}
	//установка таблицы
	public function init(){
		$this->mysqli->query("CREATE TABLE IF NOT EXISTS `Products` (
			`ID` INT NOT NULL AUTO_INCREMENT,
			`PRODUCT_ID` INT,
			`PRODUCT_NAME` VARCHAR(60),
			`PRODUCT_PRICE` NUMERIC(10,2),
			`PRODUCT_ARTICLE` INT,
			`PRODUCT_QUANTITY` INT,
			`DATE_CREATE` DATETIME,
			`IS_HIDDEN` BOOL DEFAULT FALSE,
			PRIMARY KEY(`id`)
		);");
		if($this->mysqli->errno){
			return false;
		}
		return true;
	}
	//методы помошники
	public function clear($data){
		return $this->mysqli->real_escape_string($data);
	}
	public function last_error(){
		return $this->mysqli->error;
	}
	
	//методы для работы с базой товаров
	public function product_count($id){
		$res_db = $this->mysqli->query("SELECT `PRODUCT_QUANTITY` FROM `Products` WHERE `PRODUCT_ID`=".intval($id)." LIMIT 1");
		if($res_db and $res_db->num_rows){
			return $res_db->fetch_assoc()['PRODUCT_QUANTITY'];
		}
		return 0;
	}
	public function product_recount($id,$change_num){
		return $this->mysqli->query("UPDATE `Products` SET `PRODUCT_QUANTITY`=`PRODUCT_QUANTITY`+".intval($change_num)." WHERE `PRODUCT_ID`=".intval($id));
	}
	public function product_hide($id){
		return $this->mysqli->query("UPDATE `Products` SET `IS_HIDDEN`=TRUE WHERE `PRODUCT_ID`=".intval($id));
	}
	public function product_create($id,$name,$price,$article,$quantity,$created="NOW()"){
		$this->mysqli->query("INSERT INTO `Products` (`PRODUCT_ID`,`PRODUCT_NAME`,`PRODUCT_PRICE`,`PRODUCT_ARTICLE`,`PRODUCT_QUANTITY`,`DATE_CREATE`) values (".intval($id).",'".$this->clear($name)."',".floatval($name).",".intval($article).",".intval($quantity).",'{$created}')");
		
		return $this->mysqli->insert_id;
	}
	public function products_all($limit){
		$res_db = $this->mysqli->query("SELECT * FROM `Products` WHERE `IS_HIDDEN`=FALSE ORDER BY `DATE_CREATE` DESC LIMIT ".intval($limit));
		
		if($res_db and $res_db->num_rows){
			return $res_db->fetch_all(MYSQLI_ASSOC);
		}
		return [];
	}
	
}