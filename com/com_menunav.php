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
                <a href='com_home.php' target='_self'>Gráficos</a>
            </div>
    </div>
    <div class='dropdown'>
            <button class='dropbtn'>Mailing</button>
            <div class='dropdown-content'>
                <a href='mailing_negociacao.php' target='_self'>Negociações</a>
                <a href='mailing_agenda.php' target='_self'>Agendamentos</a>
                <a href='mailing_busca.php' target='_self'>Cadastros</a>
                <a href='#' target='_self'>Grupos</a>
            </div>
    </div>
    <div class='dropdown'>
            <button class='dropbtn'>Clientes</button>
            <div class='dropdown-content'>
                <a href='com_cadcnpj.php' target='_self'>Empresa</a>
                <a href='com_cadcrm.php' target='_self'>Doutor / Médico</a>
            </div>
    </div>
    
</div>
";

}else{
    header("location:../index.php");
}
?>