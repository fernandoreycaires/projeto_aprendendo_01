<?php
session_start();
include '../_php/cx.php';
if ($_SESSION['cnpj_session'] and $_SESSION['user_session'] and $_SESSION['pass_session']){
    
    $cnpj = $_SESSION['cnpj_session'];
    $user = $_SESSION['user_session'];
    $pass = $_SESSION['pass_session'];

//VERIFICA NO BANCO A EXISTENCIA DOS DADOS INFORMADOS
$acesso = "select * from cnpj_user cu join cnpj c on cu.cnpj_vinc = c.cnpj_c WHERE cnpj_c = '".$cnpj."' and pass='".$pass."' and usuario='".$user."'";
$acesso_user = $cx->query ($acesso);

while ($perfil = $acesso_user->fetch()){
    $id = $perfil[id_u_cnpj];
    $nome = $perfil[nome_u];
    $cnpju = $perfil[cnpj_vinc];
    $razao = $perfil[razao_c];
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
        <h4>HOSPITAL SALVALUS</h4>
        <p>Data de impressão: 05/09/2018</p>
        </header>
        <div id='pdf'>
        
            <h1>RELATÓRIO MÉDICO</h1>
            <br><br>
            <table>
                <tr><td>Prontuário:</td><td>00607866</td><td>Atendimento:</td><td>15197978</td></tr>
                <tr><td>Paciente:</td><td>GRAZIELLY MAROSTEGAM HUMPHREYS REY CAIRES</td><td>Acomodação:</td><td>APARTAMENTO STANDARD</td></tr>
                <tr><td>Idade:</td><td>25a 2m 7d</td><td>Data de Atendimento:</td><td>22/07/2018</td></tr>
                <tr><td>Sexo:</td><td>FEMININO</td><td>Médico Resp.:</td><td>RAUL ALBERTO VALIENTE</td></tr>
                <tr><td>Tipo:</td><td>Internação</td><td>Crm:</td><td>126006</td></tr>
            </table>
            <br><br>
            <hr>
            <br>
            <p><span class='negrito'>HISTORICO CLINICO ANTERIOR:</span> Dor Lombar</p>
            <br>
            <p><span class='negrito'>EVOLUÇÃO CLINICA DA INTERNAÇÃO:</span> Paciente reinterna por dor lombar refrataria a analgesicos, evoluiu com melhora durante a hospitalização após otimizar a analgesia</p>
            <br><br>
            <h4>EXAMES REALIZADOS:</h4> 
            <br><br>
            <p>CIRURGIAS/PROCEDIMENTO REALIZADOS:</p>
            <table>
                <tr><td>1.____________________________</td><td>COD.:________</td><td>DATA:_____</td></tr> 
                <tr><td>1.____________________________</td><td>COD.:________</td><td>DATA:_____</td></tr> 
                <tr><td>1.____________________________</td><td>COD.:________</td><td>DATA:_____</td></tr>  
            </table>
            <br>
            <p><span class='negrito'>TRATAMENTOS REALIZADOS:</span>&nbsp;&nbsp;Clinico</p>
            <p><span class='negrito'>DIAGNÓSTICOS:</span>&nbsp;&nbsp;Dor lombar baixa</p>
            <p><span class='negrito'>ORIENTAÇÃO TERAPEUTICA:</span>&nbsp;&nbsp;tto conservador</p>
            <p><span class='negrito'>EMCAMINHAMENTOS:</span>&nbsp;&nbsp;amb de Fisiatria</p>
            <p><span class='negrito'>CID:</span>M545</p>
            <p><span class='negrito'>DATA DA ALTA:</span>&nbsp;&nbsp;24/07/2018 13:07</p>
            <p><span class='negrito'>TIPO DE ALTA:</span>&nbsp;&nbsp;Alta melhorada</p>
            <br><br>
            <div id='assdoutor'>
                <!--Espaço para carimbo e assinatura do Dr.-->
                <p>______________________________________________________________</p>
                <p>Assinatura e carimbo <span class='negrito'>Dr(a).: RAUL ALBERTO VALIENTE  CRM: 126006 </span></p>
            </div> 
        </div>                                                              
        <footer>
                <p class='centralizar'>HOSPITAL SALVALUS</p>
                <p class='centralizar'>Rua Bresser, 1.954 - Mooca - São Paulo - SP , Tel.:(11) 2662-2000 </p>
                <p class='centralizar'>www.greenlinesaude.com.br </p>
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
