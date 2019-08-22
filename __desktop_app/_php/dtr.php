<?php
    session_start();
    if ($_SESSION['cnpj_session'] and $_SESSION['user_session'] and $_SESSION['pass_session']){
        
    include '../_php/cx.php';
    
    $cnpj = $_SESSION['cnpj_session'];
    $user = $_SESSION['user_session'];
    $pass = $_SESSION['pass_session'];

    //BUSCA DADOS DO DOUTOR/MEDICO NO BANCO
    $acesso = "select * from cnpj_user cu join cnpj c on cu.cnpj_vinc = c.cnpj_c WHERE cnpj_c = '".$cnpj."' and pass='".$pass."' and usuario='".$user."'";
    $acesso_user = $cx->query ($acesso);

    while ($perfil = $acesso_user->fetch()){
        $id = $perfil['id_u_cnpj'];
        $nome = $perfil['nome_u'];
        $cnpju = $perfil['cnpj_vinc'];
        $crm = $perfil['crm'];
        $nome_fantasia = $perfil['nfantasia_c'];
    }  
    
    
    
    //PEGA DATA ATUAL 
    $data_atual = date('Y-m-d'); 

    //VERIFICA QUANTOS AGENDAMENTOS TEM NO DIA
    $agenda = "SELECT COUNT(*) FROM agenda WHERE cnpj = '".$cnpj."' AND crm = '".$crm."' AND inicio LIKE '".$data_atual."%' GROUP BY inicio LIKE '".$data_atual."%'";
    $recebe_sql = $cx->query ($agenda);
    while ($agendamento = $recebe_sql->fetch()){
        $qtdagenda = $agendamento['COUNT(*)'];
    }
    if ($qtdagenda == ''){
        $qtdagenda = "0";
    }
    
    //VERIFICA QUANTOS LEADS TEM ATIVOS
    $leads = "SELECT COUNT(*) FROM `lead` WHERE cnpj = '".$cnpj."' AND interesse = 'S' GROUP BY interesse = 'S'";
    $leads_sql = $cx->query ($leads);
    while ($leads_ativo = $leads_sql->fetch()){
        $qtdleadS = $leads_ativo['COUNT(*)'];
    }
    if ($qtdleadS == ''){
        $qtdleadS = "0";
    }
    
    //VERIFICA QUANTOS LEADS TEM SEM INTERESSE
    $leadn = "SELECT COUNT(*) FROM `lead` WHERE cnpj = '".$cnpj."' AND interesse = 'N' GROUP BY interesse = 'N'";
    $leadn_sql = $cx->query ($leadn);
    while ($leadn_s_int = $leadn_sql->fetch()){
        $qtdleadN = $leadn_s_int['COUNT(*)'];
    }
    if ($qtdleadN == ''){
        $qtdleadN = "0";
    }
    
}else{
    header("location:../index.php");
}