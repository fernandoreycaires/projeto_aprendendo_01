<?php
session_start();
if ($_SESSION['cnpj_session'] and $_SESSION['user_session'] and $_SESSION['pass_session']){
    
    $cnpj = $_SESSION['cnpj_session'];
    $user = $_SESSION['user_session'];
    $pass = $_SESSION['pass_session'];
    
    include '../_php/cx.php';
    
    //INSERINDO PONTUAÇÃO NO CNPJ
    $cnpjn1 = substr_replace($cnpju, '.', 2, 0);
    $cnpjn2 = substr_replace($cnpjn1, '.', 6, 0);
    $cnpjn3 = substr_replace($cnpjn2, '/', 10, 0);
    $cnpjn = substr_replace($cnpjn3, '-', 15, 0);
    
    
   
}else{
    header("location:../index.php");
}