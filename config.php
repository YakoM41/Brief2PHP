<?php

//Information de connexion a la BDD

$host = "localhost"; //Sans le port quand on est pas sur Mac
$dbname = "exophp";
$user = "root";
$pass=""; //ou le pssword de la BDD


try {
    //Creation d'un instance PDO (PHP DATA OBJECT)
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);

    //Config de PDO en cas d'exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(PDOException $e){
    //En cas d'erreur
    die("Erreur de connexion : " . $e-> getMessage());
}



