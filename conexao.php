<?php 
define('HOST', 'localhost');
define('USER', 'root');
define('PASS', '');
define('DBNAME','perfil');

$conexao = new PDO('mysql:host=' . HOST . ';dbname=' . DBNAME . ';', USER, PASS);

$conn = mysqli_connect("localhost", "root", "", "perfil");