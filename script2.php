<?php

@header('Access-Control-Allow-Origin: *');


$mysql_host = "mysql-srv36854.ht-systems.ru";
$mysql_database = "srv36854_results";
$mysql_user = "srv36854_nikey";
$mysql_password = "5AxK1835";

$link = mysql_connect($mysql_host, $mysql_user, $mysql_password) or die(mysql_error());
mysql_select_db($mysql_database, $link) or die('Ошибка при подключении к БД');

//Проверяем наличие передеваемых данных
if(isset($_POST['name'])) $name = $_POST['name'];
if(isset($_POST['score'])) $score = $_POST['score'];

//Проверяем наличие полученных значений
if(isset($name) && isset($score)) {

//Запрос к БД на получение нужной строки
$q1 = mysql_query("SELECT * FROM `result_table` WHERE `name`='".$name."'");

//Проверка количества полученных результатов
if(mysql_num_rows($q1) == 1) {

//Записываем результат в ассоциативный массив
$array = mysql_fetch_array($q1);

//Если полученное значение больше записанного в БД, то обновляем его в таблице нашей БД
if($score > $array['score']) $q3 = mysql_query("UPDATE `result_table` SET `score`='".$score."' WHERE `name`='".$name."'");
}
else //В случае, если строки с таким именем нет, добавляем ее
$q2 = mysql_query("INSERT INTO `result_table`(`name`, `score`) VALUES ('".$name."', '".$score."')");
}

//Запрос на получение всех строк, отсортированных по полю score по убыванию
$q4 = mysql_query("SELECT * FROM `result_table` ORDER BY `score` DESC");

//Цикл вывода 10 первых результатов
$i=0;
while($row = mysql_fetch_row($q4)){

    if($i<5) {
	echo $row[0].' - '.$row[1]."<br>";
	$i=$i+1;
	}
}
//php_code
?>