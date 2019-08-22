<?php

//CONSTANTES
define('HOST', '25.80.110.220');
define('USER','root');
define('SENHA', 'fer270587');
define('BD', 'frsystemteste');

try {
    $dsn = "mysql:host=".HOST.";dbname=".BD or die(mysqli_error());
    $cx = new PDO($dsn, USER, SENHA) or die(mysqli_error());
    $cx ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $ex) {
    echo "Erro ao conectar com o banco !".$ex->getMessage();
}

?>