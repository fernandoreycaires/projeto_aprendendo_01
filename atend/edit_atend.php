<?php
    session_start();
include '../_php/cx.php';
if ($_SESSION['cnpj_session'] and $_SESSION['user_session'] and $_SESSION['pass_session']) {

//RECEBE DADOS DE home_atend REFERENTE AO ATENDIMENTO QUE DESEJA EXCLUIR
    
    $idatend = isset($_POST['atendimento'])?$_POST['atendimento']:'';
    $nomeatend = isset($_POST['nome'])?$_POST['nome']:'';
    $cpfatend = isset($_POST['cpf'])?$_POST['cpf']:'';
    $rgatend = isset($_POST['rg'])?$_POST['rg']:'';
    $cnatend = isset($_POST['cn'])?$_POST['cn']:'';
    
    //VERIFICA A EXISTENCIA DOS DADOS À SEREM EXCLUIDOS
    $select = "SELECT id_atend FROM atendimento WHERE id_atend = '".$idatend."' limit 1";
    $enviaselect = $cx->query ($select);
    while ($dados = $enviaselect->fetch()){
        $confirma = $dados['id_atend'];
    }
    
    if($confirma != ""){ 
    
    $editsql = "UPDATE atendimento SET nome = '".$nomeatend."', cpf = '".$cpfatend."', certnasc = '".$cnatend."', rg = '".$rgatend."' WHERE id_atend = '".$idatend."' limit 1 ";
    $enviabanco = $cx->query($editsql);
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