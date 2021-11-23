<?php
require_once"CDb.php";
try{
	$db = CDb::create();
	if($db->init()) echo"База успешно инициализирована";
	else echo "Ошибка при создании таблицы - ".$db->last_error();
}catch(Exception $e){
	echo "Ошибка:".$e->getMessage();
}