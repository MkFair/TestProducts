<?php 
header("Content-Type: application/json");
require_once("CProducts.php");
$event = (!empty($_GET["k"]))?$_GET["k"]:"";
$CP = new CProducts();
switch($event){
	case "hide":
		$product_id = (!empty($_GET["product_id"]))?$_GET["product_id"]:0;
		echo json_encode(["success"=>$CP->hide($product_id)]);
		break;
	case "add":
		$product_id = (!empty($_GET["product_id"]))?$_GET["product_id"]:0;
		echo json_encode($CP->add($product_id));
		break;
	case "sub":
		$product_id = (!empty($_GET["product_id"]))?$_GET["product_id"]:0;
		echo json_encode($CP->sub($product_id));
		break;
	case "generate":
		echo json_encode($CP->generate());
		break;
	case "all":
		echo json_encode($CP->all());
		break;
	
	
}