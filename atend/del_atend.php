<?php
    session_start();
include '../_php/cx.php';
if ($_SESSION['cnpj_session'] and $_SESSION['user_session'] and $_SESSION['pass_session']) {

//RECEBE DADOS DE home_atend REFERENTE AO ATENDIMENTO QUE DESEJA EXCLUIR
    
    $idatend = isset($_POST['atendimento'])?$_POST['atendimento']:'';
    
    //VERIFICA A EXISTENCIA DOS DADOS À SEREM EXCLUIDOS
    $select = "SELECT id_atend FROM atendimento WHERE id_atend = '".$idatend."' limit 1";
    $enviaselect = $cx->query ($select);
    while ($dados = $enviaselect->fetch()){
        $confirma = $dados['id_atend'];
    }
    
    if($confirma != ""){ 
    
    $delsql = "DELETE FROM atendimento WHERE id_atend = '".$idatend."' limit 1 ";
    $enviabanco = $cx->query($delsql);
    if ($enviabanco) {
                header("location:home_atend.php");
                } else {
                $msg_cad = "OCORREU UM ERRO AO ABRIR A TABELA DE ATENDIMENTO ! ";
                }
    
    }else {
        header("location:home_atend.php");
    } 
    
} else {
    header("location:../index.php");
}  
?>

