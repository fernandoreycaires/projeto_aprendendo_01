<?php
session_start();
include '../_php/cx.php';
if ($_SESSION['cnpj_session'] and $_SESSION['user_session'] and $_SESSION['pass_session']){
    
    $cnpj = $_SESSION['cnpj_session'];
    $user = $_SESSION['user_session'];
    $pass = $_SESSION['pass_session'];


                $atendimento = $_POST['atendimento'];
                $hora = $_POST['hora_final'];
                $data = $_POST['data_final'];
                

                // CRIA COMANDO SQL
                $sql = "UPDATE atendimento SET fim_data='".$data."', fim_hora='".$hora."' WHERE id_atend = '".$atendimento."' LIMIT 1";
                // ENVIA COMANDO SQL INSERIDO NA VARIAVEL ACIMA PARA O BANCO
                $q = $cx->query ($sql);

                if ($q) {
                        header("location:dtr_atendimento.php");
                        
                } else {
                    $message = 'OCORREU UM ERRO AO EFETUAR O CADASTRO ! ';
                }
                echo "<h1> $message </h1>";
           
}else{
    header("location:../index.php");
}
?>