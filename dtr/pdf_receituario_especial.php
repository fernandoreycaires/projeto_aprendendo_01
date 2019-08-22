<?php
session_start();
include '../_php/cx.php';
if ($_SESSION['cnpj_session'] and $_SESSION['user_session'] and $_SESSION['pass_session']) {

    $cnpj = $_SESSION['cnpj_session'];
    $user = $_SESSION['user_session'];
    $pass = $_SESSION['pass_session'];

//VERIFICA NO BANCO A EXISTENCIA DOS DADOS INFORMADOS
    $acesso = "select * from cnpj_user cu join cnpj c on cu.cnpj_vinc = c.cnpj_c WHERE cnpj_c = '" . $cnpj . "' and pass='" . $pass . "' and usuario='" . $user . "'";
    $acesso_user = $cx->query($acesso);
    while ($perfil = $acesso_user->fetch()) {
        $cnpju = $perfil['cnpj_vinc'];
        $razao = $perfil['razao_c'];
        $telefone = $perfil['tel1_c'];
        $cnpjcep = $perfil['cep_c'];
        $cnpjlogradouro = $perfil['logradouro_c'];
        $cnpjnumlog = $perfil['numerolog_c'];
        $cnpjcomp = $perfil['complemento_c'];
        $cnpjbairro = $perfil['bairro_c'];
        $cnpjcidade = $perfil['cidade_c'];
        $cnpjestado = $perfil['estado_c'];
        $cnpjemail = $perfil['email_c'];
        $cnpjsite = $perfil['site_c'];
    }
    
     //MODIFICANDO MODO DE EXIBIÇÃO DA VARIAVEL "TELEFONE" strlen($variavel) usado para contar quantidade de caracteres na variavel
    if (strlen($telefone) == 10 ){
        $telefonen = substr_replace($telefone, '(', 0, 0);
        $telefonen = substr_replace($telefonen, ')', 3, 0);
        $telefonen = substr_replace($telefonen, '-', 8, 0);
        $telefonen = substr_replace($telefonen, ' ', 4, 0);
    } elseif (strlen($telefone) == 11 ) {
        $telefonen = substr_replace($telefone, '(', 0, 0);
        $telefonen = substr_replace($telefonen, ')', 3, 0);
        $telefonen = substr_replace($telefonen, '-', 9, 0);
        $telefonen = substr_replace($telefonen, ' ', 4, 0);
        $telefonen = substr_replace($telefonen, ' ', 6, 0);
    }
    //MODIFICANDO MODO DE EXIBIÇÃO DA VARIAVEL "CEP"
        $cnpjceppn = substr_replace($cnpjcep, '-', 5, 0);

    $id = $_POST['id_rec_espec'];
//BUSCA NO BANCO NA TABELA receita AS RECEITAS REFERENTES AO NUMERO DO atendimento
    $mostra_sqlrec = "SELECT * FROM receita_especial WHERE id_rec_espec = '" . $id . "' and cnpj = '" . $cnpj . "'";
    $mostrarec = $cx->query($mostra_sqlrec);
    while ($receita = $mostrarec->fetch()) {
        $id_rec = $receita['id_rec_espec'];
        $nome = $receita['nome'];
        $id_cli = $receita['id_cli'];
        $cpf = $receita['cpf'];
        $rg = $receita['rg'];
        $cn = $receita['certnasc'];
        $sexo = $receita['sexo'];
        $nasc = $receita['nasc'];
        $respcli = $receita['nome_resp'];
        $cep = $receita['cep'];
        $logradouro = $receita['logradouro'];
        $numlog = $receita['numlog'];
        $bairro = $receita['bairro'];
        $cidade = $receita['cidade'];
        $estado = $receita['estado'];
        $crm = $receita['crm'];
        $crmuf = $receita['estado_crm'];
        $doutor = $receita['doutor'];
        $cnpj = $receita['cnpj'];
        $razao = $receita['razao'];
        $data = $receita['data'];
        $hora = $receita['hora'];
        $conv = $receita['convenio'];
        $numconv = $receita['carteira'];
        $atendimento = $receita['atendimento'];
        $remedio1 = $receita['remedio1'];
        $tipouso1 = $receita['tipouso1'];
        $modouso1 = $receita['modouso1'];
        $obs1 = $receita['obs1'];
        $remedio2 = $receita['remedio2'];
        $tipouso2 = $receita['tipouso2'];
        $modouso2 = $receita['modouso2'];
        $obs2 = $receita['obs2'];
        $remedio3 = $receita['remedio3'];
        $tipouso3 = $receita['tipouso3'];
        $modouso3 = $receita['modouso3'];
        $obs3 = $receita['obs3'];
        $remedio4 = $receita['remedio4'];
        $tipouso4 = $receita['tipouso4'];
        $modouso4 = $receita['modouso4'];
        $obs4 = $receita['obs4'];
        
        $medicacao1 .= $modouso1."<br>".$remedio1."<br>".$tipouso1."<br>".$obs1."<br>";
        $medicacao2 .= $modouso2."<br>".$remedio2."<br>".$tipouso2."<br>".$obs2."<br>";
        $medicacao3 .= $modouso3."<br>".$remedio3."<br>".$tipouso3."<br>".$obs3."<br>";
        $medicacao4 .= $modouso4."<br>".$remedio4."<br>".$tipouso4."<br>".$obs4."<br>";
    }
    
    //ARRUMA A VARIAVEL sexo PARA EXIBIÇÃO
    if ($sexo == "M"){
        $sexo = 'Masculino';
    }else {
        $sexo = 'Feminino';
    }
    
    //ARRUMA DATA PARA EXIBIR 
    list($anoh, $mesh, $diah) = explode('-', $data);
    
    //-------------------------------------------------
    //CALCULANDO IDADE
    // Separa em dia, mês e ano
    list($ano, $mes, $dia) = explode('-', $nasc);

    // Descobre que dia é hoje e retorna a unix timestamp
    $hoje = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
    // Descobre a unix timestamp da data de nascimento do fulano
    $nascimento = mktime(0, 0, 0, $mes, $dia, $ano);

    // Depois apenas fazemos o cálculo já citado :)
    $idade = floor((((($hoje - $nascimento) / 60) / 60) / 24) / 365.25);
    //print $idade;
    //FIM DO CALCULO DE IDADE
    //-------------------------------------------------
    
    //MODIFICANDO MODO DE EXIBIÇÃO DA VARIAVEL "CPF"
    $cpfn = substr_replace($cpf, '.', 3, 0);
    $cpfn = substr_replace($cpfn, '.', 7, 0);
    $cpfn = substr_replace($cpfn, '-', 11, 0);

    //MODIFICANDO MODO DE EXIBIÇÃO DA VARIAVEL "RG"
    $rgn = substr_replace($rg, '.', 2, 0);
    $rgn = substr_replace($rgn, '.', 6, 0);
    $rgn = substr_replace($rgn, '-', 10, 0);

    //MODIFICANDO MODO DE EXIBIÇÃO DA VARIAVEL "CNPJ"
    $cnpjn = substr_replace($cnpju, '.', 2, 0);
    $cnpjn = substr_replace($cnpjn, '.', 6, 0);
    $cnpjn = substr_replace($cnpjn, '/', 10, 0);
    $cnpjn = substr_replace($cnpjn, '-', 15, 0);
    
    if ($cpf != ''){
        $documento = "CPF";
        $docinfo = $cpfn;
    } else if ($rg != ''){
        $documento = "RG";
        $docinfo = $rgn;
    } else{
        $documento = "";
        $docinfo = "";
    }
/* Carrega a classe DOMPdf */
require_once("../_pdf/dompdf_config.inc.php");

/* Cria a instância */
$dompdf = new DOMPDF();

/* Carrega o HTML */
$dompdf->load_html("

<!DOCTYPE html>
<html lang='pt-br'>
    <head>
        <meta charset='UTF-8'>
        <title>ADM Consultório</title>
        <link rel='shortcut icon' href='../_imagens/Logo_FRC_1.ico' type='image/x-icon' />
        <link href='../_css/dtr_pdf.css' rel='stylesheet' type='text/css'/>
    </head>
    <body>
        
        <header>
        <h4>".$razao."</h4>
        </header>
        
        <div id='pdf'>
            <h1>RECEITUÁRIO CONTROLE ESPECIAL</h1>
            <hr>
            <div id='via'>
                <p>1&ordm; VIA - FARMÁCIA OU DROGARIA</p>
                <p>&nbsp;&nbsp;&nbsp;2&ordm; VIA - PACIENTE</p>
            </div>
            <table>
                <tr><td colspan='3'><span class='negrito'>IDENTIFICAÇÃO DO EMITENTE</span></td></tr>                                         
                <tr><td>Nome:</td><td>".$doutor."</td></tr>                          
                <tr><td>CRM:</td><td>".$crm."</td><td>TELEFONE:</td><td>".$telefonen."</td></tr>
                <tr><td>UF:</td><td>".$crmuf."</td></tr>
                <tr><td>Endereço:</td><td>".$cnpjlogradouro.", ".$cnpjnumlog."</td><td>BAIRRO:</td><td>".$cnpjbairro." </td></tr> 
                <tr><td>CEP:</td><td>".$cnpjceppn."</td><td>CIDADE:</td><td>".$cnpjcidade."</td><td>UF:</td><td>".$cnpjestado."</td></tr>                         
                                                                   
            </table>
            <br>
            <p>Paciente:<span class='negrito'> ".$nome."</span>, ".$documento.":<span class='negrito'>".$docinfo."</span></p>
            <p>Endereço:<span class='negrito'> ".$logradouro.",".$numlog." - ".$bairro." - ".$cidade." - ".$estado." </span></p>
            <p>Certidão de Nascimento:<span class='negrito'>".$cn."</span></p>
            <br>
            <div id='medicacao'>
            <p>".$medicacao1."</p>
            <p>---------------------------</p>
            <p>".$medicacao2."</p>
            <p>---------------------------</p>
            <p>".$medicacao3."</p>
            <p>---------------------------</p>
            <p>".$medicacao4."</p>
            </div>
            <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
            <p>Data: __________________________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Carimbo e assinatura do Médico: _________________________</p>
            <br>
            <table>
                <tr><td><span class='negrito'>IDENTIFICAÇÃO DO COMPRADOR</span></td></tr>                       
                <tr><td>Nome Completo:____________________________</td></tr>        
                <tr><td>Identidade e</td></tr>                                      
                <tr><td>Orgão Emissor: ____________________________</td></tr>        
                <tr><td>Endereço: ________________________________</td></tr>
                <tr><td>Cidade: _____________________ UF: _________</td></tr>               
                <tr><td>Telefone: _________________________________</td></tr>                
            </table>
            
            <table id='fornecedor'>
                <tr><td colspan='2'><span class='negrito'>IDENTIFICAÇÃO DO FORNECEDOR</span></td></tr>
                <tr><td td colspan='2'>__________________________________________</td></tr>
                <tr><td td colspan='2'>__________________________________________</td></tr>
                <tr><td td colspan='2'>__________________________________________</td></tr>
                <tr><td>__________________________</td><td>_________</td></tr>
                <tr><td>Assinatura do Farmaceutico</td><td>Data</td></tr>
            </table>
        </div>                                                              
        <footer>
                <p class='centralizar'>".$razao."</p>
                <p class='centralizar'>".$cnpjlogradouro.", ".$cnpjnumlog." </p>
                <p class='centralizar'>".$cnpjbairro." - ".$cnpjcidade." - ".$cnpjestado." - ".$cnpjceppn." , Tel.:".$telefonen."</p>
                <p class='centralizar'>".$cnpjsite." - ".$cnpjemail." </p>
        </footer>
    </body>
</html>");

/* Renderiza */
$dompdf->render();

/* Exibe */
$dompdf->stream(
    "frsystem.pdf", /* Nome do arquivo de saída */
    array(
        "Attachment" => false /* Para download, altere para true */
    )
);


}else{
    header("location:../index.php");
}
?>
