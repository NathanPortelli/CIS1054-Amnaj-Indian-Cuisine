<?php

$config = parse_ini_file('../../config.ini'); 
$conn = mysqli_connect($config['server'],$config['username'],$config['password'],$config['dbname']);

if(!$conn){
	die("Connection Failed: ".mysqli_connect_error());
}