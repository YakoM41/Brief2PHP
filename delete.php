<?php

require 'config.php';

if(!isset($_GET['id'])){
    header("location: index.php");
    exit();
}
$id=$_GET['id'];

//requête sql de suppression
$del = $pdo-> prepare("DELETE FROM produits WHERE ID = :id");
$del-> execute(["id" => $id]);

//redirection vers accueil
    header("location: index.php");
    exit();
