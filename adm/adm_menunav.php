<?php
session_start();
if ($_SESSION['cnpj_session'] and $_SESSION['user_session'] and $_SESSION['pass_session']){
    
    $cnpj = $_SESSION['cnpj_session'];
    $user = $_SESSION['user_session'];
    $pass = $_SESSION['pass_session'];
    
$menunav="
<div id='corpo'>
    <div class='dropdown'>
            <button class='dropbtn'>Inicio</button>
            <div class='dropdown-content'>
                <a href='adm_home.php' target='_self'>Tela Inicial</a>
            </div>
    </div>
    <div class='dropdown'>
            <button class='dropbtn'>Vendas</button>
            <div class='dropdown-content'>
                <a href='#' target='_self'>Relatórios</a>
                <a href='#' target='_self'>Prospecto</a>
                <a href='#' target='_self'>Metas</a>
                <a href='servicos_home.php' target='_self'>Serviços</a>
            </div>
    </div>

    
</div>
";

}else{
    header("location:../index.php");
}
?>