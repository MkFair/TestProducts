<?php 
require_once("CDb.php");


class CProducts{
	protected $LIMIT = 10;
	function __construct(){
		$this->db = CDb::create();
	}
	//генерация товаров
	function generate(){
		$names = ["Пицца","Стол","Компьютер","Яблоко","Попугай","Колесо"];
		
		for($i=0;$i<rand(4,7);$i++){
			$product = [];
			$product["PRODUCT_NAME"] = $names[array_rand($names)];
			$product["PRODUCT_PRICE"] = rand(1000,100000)/100;
			$product["PRODUCT_ARTICLE"] = rand(10000,1000000);
			$product["PRODUCT_QUANTITY"] = rand(1,15);
			$product["PRODUCT_ID"] = rand(1,999999);
			$product["DATE_CREATE"] = ((new DateTime("NOW"))->sub(new DateInterval("P".rand(1,4)."DT".rand(1,4)."H")))->format("Y-m-d H:i:s") ;
			$this->db->product_create($product["PRODUCT_ID"],$product["PRODUCT_NAME"],$product["PRODUCT_PRICE"],$product["PRODUCT_ARTICLE"],$product["PRODUCT_QUANTITY"],$product["DATE_CREATE"]);
		}
		$products = $this->db->products_all($this->LIMIT);
		return $products;
	}
	function all(){
		return $this->db->products_all($this->LIMIT);
	}
	function hide($product_id){
		return $this->db->product_hide($product_id);
	}
	function add($product_id){
		$this->db->product_recount($product_id,1);
		return $this->db->product_count($product_id);
	}
	function sub($product_id){
		$this->db->product_recount($product_id,-1);
		return $this->db->product_count($product_id);
	}
}