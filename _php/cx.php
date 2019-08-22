<?php

//CONSTANTES
define('HOST', /*COLOCAR O IP DO BD*/);
define('USER',/*COLOCAR O usuario DO BD*/);
define('SENHA', /*COLOCAR a senha DO BD*/);
define('BD', /*COLOCAR O banco que sera usado DO BD*/);

try {
    $dsn = "mysql:host=".HOST.";dbname=".BD or die(mysqli_error());
    $cx = new PDO($dsn, USER, SENHA) or die(mysqli_error());
    $cx ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $ex) {
    echo "Erro ao conectar com o banco !".$ex->getMessage();
}

?>
