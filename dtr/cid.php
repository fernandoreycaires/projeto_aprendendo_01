<?php
session_start();
include '../_php/cx.php';
if ($_SESSION['cnpj_session'] and $_SESSION['user_session'] and $_SESSION['pass_session']) {

    $cnpj = $_SESSION['cnpj_session'];
    $user = $_SESSION['user_session'];
    $pass = $_SESSION['pass_session'];

    //RECEBE DADOS DE diagnostico_cad.php 
    $atend = isset($_POST['atend']) ? $_POST['atend'] : 'Atendimento não informado';

    //BUSCA NO BANCO NA TABELA his_med AS INFORMAÇÕES REFERENTES AO NUMERO DO atendimento
    $mostra_sqlh = "SELECT * FROM his_med where atendimento = '" . $atend . "' and cnpj = '" . $cnpj . "'";
    $mostrah = $cx->query($mostra_sqlh);
    //IRA MOSTRAR NA TELA ENQUANTO TIVER LINHA NA TABELA
    while ($dadosh = $mostrah->fetch()) {
        $diag_atend = $dadosh['atendimento'];
        $diag_relato = $dadosh['relato'];
        $diag_diag = $dadosh['diagnostico'];
        $diag_obs = $dadosh['obs'];
        $diag_data = $dadosh['data_h'];
        $diag_hora = $dadosh['hora'];
        $diag_cpf = $dadosh['cpf'];
        $diag_pac = $dadosh['nome_pac'];
        
    }
    
    
    

    ?>
    <!DOCTYPE html>
    <html lang="pt-br">
        <head>
            <meta charset="utf-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <title>ADM Consultório</title>
            <link rel='shortcut icon' href='../_imagens/Logo_FRC_1.ico' type='image/x-icon' />
            <link href="../_css/estilo.css" rel="stylesheet" type="text/css"/>
            <link href="../_css/cabecalho.css" rel="stylesheet" type="text/css"/>
            <link href="../_css/atend.css" rel="stylesheet" type="text/css"/>
            <link href='../_css/cid.css' rel='stylesheet'>
            <link href='../_css/bootstrap.min.css' rel='stylesheet'>
            <script src='../_javascript/bootstrap.min.js'></script>
            <script src='../_javascript/jquery.min.js'></script>
            <style>
                        table tr{
                            vertical-align: top;

                        }

                        .form-control-text {
                            
                            width: 180px;
                            height:25px;
                            padding:6px 12px;
                            font-size:10pt;
                            line-height:1.42857143;
                            border:1px solid #ccc;
                            border-radius:4px;
                            -webkit-box-shadow:inset 0 1px 1px rgba(0,0,0,.075);
                            box-shadow:inset 0 1px 1px rgba(0,0,0,.075);
                            -webkit-transition:border-color ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;
                            -o-transition:border-color ease-in-out .15s,box-shadow ease-in-out .15s;
                            transition:border-color ease-in-out .15s,box-shadow ease-in-out .15s
                        }
                        
                        /* ALTERA AS CONFIGURAÇÕES de plano de fundo da janela modal*/
                        .modal-backdrop {
                            background-color: #1C1C1C;
                        }

                        /* ALTERA AS CONFIGURAÇÕES de conteudo da Janela Modal */
                        .modal-content {
                            background-color: rgb(38,42,48);
                        }

                        .modal-content input {
                            background-color: rgb(38,42,48);
                            color: rgba(255,255,255,1);
                        }

                        .modal-content textarea {
                            background-color: rgb(38,42,48);
                            color: rgba(255,255,255,1);
                        }

                        .modal-content select {
                            background-color: rgb(38,42,48);
                            color: rgba(255,255,255,1);
                        }

                        .modal-content table tr td {
                            background-color: rgb(38,42,48);
                            color: rgba(255,255,255,1);
                        }
                         

                         
                </style>
                

        </head>
        <body>
                <div class="container-fluid theme-showcase estilo" role="main">
                    <div class="logo1"></div>
                    <div class="page-header">
                        <h1 align="center">Doutores - Busca C.I.D.</h1>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div id="esquerda">
                                <p>Referente ao Atendimento:<span class="banco"> <?php echo $atend; ?></span></p>&nbsp;&nbsp;&nbsp;
                                <p>Paciente: <span class="banco"><?php echo $diag_pac; ?></span> </p>
                                <form method="post" action="cid.php">
                                    <input type="hidden" name="atend" value="<?php echo $atend ?>">
                                    <p>CID: <input type="text" name="cid" class="form-control-text ">&nbsp;&nbsp;&nbsp;<button type="submit" class="btn btn-xs btn-primary">Buscar</button></p>
                                </form>

                            <?php
                            $buscacid = isset($_POST['cid']) ? $_POST['cid'] : "";
                            $mostra_sqlcid = "SELECT * FROM cid_10_subcategorias WHERE SUBCAT = '" . $buscacid . "'";
                            $mostracid = $cx->query($mostra_sqlcid);
                            while ($cid = $mostracid->fetch()) {
                                $cid_subcat = $cid['SUBCAT'];
                                $cid_desc = $cid['DESCRICAO'];
                                ?>
                                    <form method="post" action="cid_cad.php">
                                        <input type="hidden" name="atendimento" value="<?php echo $atend; ?>">
                                        <input type="hidden" name="cidsubcat" value="<?php echo $cid_subcat; ?>">
                                        <input type="hidden" name="ciddesc" value="<?php echo $cid_desc; ?>">
                                        <p>Autoriza a divulgação do CID: <label for="s"><input type="radio" id="s" name="CIDdiv" value="S" checked>SIM&nbsp;&nbsp;&nbsp;</label>
                                                                         <label for="n"><input type="radio" id="n" name="CIDdiv"  value="N" >NÃO</label>
                                        </p>
                                        <p><span class="banco"><?php echo $cid_subcat; ?> - <?php echo $cid_desc ?>&nbsp;&nbsp;</span> 
                                            <button type="submit" class="btn btn-xs btn-warning">Adicionar</button>
                                        </p>
                                    </form>
                                <?php
                            }
                            ?>
                                <form method="post" action="diagnostico.php">
                                    <input type="hidden" name="atendimento" value="<?php echo $atend; ?>">
                                    <button type="submit" class="btn btn-xs btn-danger">Cancelar</button>
                                </form>  
                                <br>
                            </div>

                            <div id="direita">
                                
                                <h4 align="center">CATÁLOGO C.I.D.</h4>
                                <?php
                                $oc_capitulo = isset($_POST['oc_capitulo'])?$_POST['oc_capitulo']:'';
                                ?>
                                
                                <!--DIV REFERENTE AOS CAPITULOS-->
                                <div class="<?php echo $oc_capitulo;?>">
                                    <h5 align="center">CAPÍTULOS</h5>
                                    <table class="table">
                                        <thead>
                                            <th>INI</th>
                                            <th>FIM</th>
                                            <th>DESCRIÇÃO</th>
                                        </thead>
                                    <?php
                                    //BUSCA NO BANCO NA TABELA CID10CAPITULOS 
                                    $cid10_cap = "SELECT * FROM cid_10_capitulos";
                                    $cid10dados = $cx->query($cid10_cap);
                                    while ($cid10cap = $cid10dados->fetch()) {
                                        $cap_cid10_id = $cid10cap['id'];
                                        $cap_cid10_desc = $cid10cap['DESCRICAO'];
                                        $cap_cid10_inic = $cid10cap['CATINIC'];
                                        $cap_cid10_fim = $cid10cap['CATFIM'];
                                    ?>
                                        
                                            <form method="post" action="cid.php">
                                                    <input type="hidden" value="<?php echo $atend;?>" name="atend">
                                                    <input type="hidden" value="oc" name="oc_capitulo">
                                                    <input type="hidden" value="mostra" name="oc_grupos">
                                                    <input type="hidden" value="<?php echo $cap_cid10_inic;?>" name="capini">
                                                    <input type="hidden" value="<?php echo $cap_cid10_fim;?>" name="capfim">
                                                    
                                                    <tr>
                                                        <td><?php echo $cap_cid10_inic;?></td>
                                                        <td> <?php echo $cap_cid10_fim;?></td> 
                                                        <td><button type="submit" class="cidbutton"> <?php echo $cap_cid10_desc;?></button></td>
                                                    </tr>
                                                
                                            </form>
                                                    
                                        
                                    <?php
                                    }
                                    ?>
                                    </table>
                                </div>
                                
                                <!--DIV REFERENTE AOS GRUPOS-->
                                
                                <?php
                                $oc_grupos = isset($_POST['oc_grupos'])?$_POST['oc_grupos']:'oc';
                                ?>
                                
                                
                                <div class="<?php echo $oc_grupos;?>">
                                    <h5 align="center">GRUPOS</h5>
                                    <form action="cid.php" method="post">
                                        <input type="hidden" value="<?php echo $atend;?>" name="atend">
                                        <input type="hidden" value="mostra" name="oc_capitulo">
                                        <input type="hidden" value="oc" name="oc_grupos">
                                        <input type="hidden" value="oc" name="oc_categoria">
                                        <input type="hidden" value="oc" name="oc_subcategoria">
                                        <button type="submit" class="btn btn-xs btn-primary">VOLTAR P/ CAPÍTULOS</button>
                                    </form>
                                <table class="table">
                                        <thead>
                                            <th>INI</th>
                                            <th>FIM</th>
                                            <th>DESCRIÇÃO</th>
                                        </thead>
                                        <?php
                                        //RECEBE DADOS DO SELECT ACIMA
                                        $gruinic = isset($_POST['capini'])?$_POST['capini']:'Não Informado';
                                        $grufim = isset($_POST['capfim'])?$_POST['capfim']:'Não Informado';

                                        //BUSCA NO BANCO NA TABELA CID10GRUPOS 
                                        $cid10_gru = "SELECT * FROM cid_10_grupos WHERE CATINIC >= '".$gruinic."' AND CATFIM <= '".$grufim."'";
                                        $cid10dados_gru = $cx->query($cid10_gru);
                                        while ($cid10gru = $cid10dados_gru->fetch()) {
                                            $gru_cid10_id = $cid10gru['id_grupos'];
                                            $gru_cid10_desc = $cid10gru['DESCRICAO'];
                                            $gru_cid10_inic = $cid10gru['CATINIC'];
                                            $gru_cid10_fim = $cid10gru['CATFIM'];
                                        ?>
                                        
                                            <form method="post" action="cid.php">
                                                    <input type="hidden" value="<?php echo $atend;?>" name="atend">
                                                    <input type="hidden" value="oc" name="oc_capitulo">
                                                    <input type="hidden" value="oc" name="oc_grupos">
                                                    <input type="hidden" value="mostrar" name="oc_categoria">
                                                    <input type="hidden" value="<?php echo $gru_cid10_inic;?>" name="gruini">
                                                    <input type="hidden" value="<?php echo $gru_cid10_fim;?>" name="grufim">
                                                    <input type="hidden" value="<?php echo $gruinic;?>" name="capini">
                                                    <input type="hidden" value="<?php echo $grufim;?>" name="capfim">
                                                
                                                    <tr>
                                                        <td><?php echo $gru_cid10_inic;?></td>
                                                        <td><?php echo $gru_cid10_fim;?></td>
                                                        <td><button type="submit" class="cidbutton"><?php echo $gru_cid10_desc;?></button></td>
                                                    </tr>
                                            </form>
                                        
                                        <?php
                                            }
                                        ?>
                                </table>
                                </div>
                                
                                <!--DIV REFERENTE AOS CATEGORIAS-->
                                <?php
                                $oc_categoria = isset($_POST['oc_categoria'])?$_POST['oc_categoria']:'oc';
                                $oc_grupoini = isset($_POST['capini'])?$_POST['capini']:'oc';
                                $oc_grupofim = isset($_POST['capfim'])?$_POST['capfim']:'oc';
                                ?>
                                
                                <div class="<?php echo $oc_categoria;?>">
                                    <h5 align="center">CATEGORIAS</h5>
                                    <form action="cid.php" method="post">
                                        <input type="hidden" value="<?php echo $atend;?>" name="atend">
                                        <input type="hidden" value="oc" name="oc_capitulo">
                                        <input type="hidden" value="mostra" name="oc_grupos">
                                        <input type="hidden" value="oc" name="oc_categoria">
                                        <input type="hidden" value="oc" name="oc_subcategoria">
                                        <input type="hidden" value="<?php echo $oc_grupoini;?>" name="capini">
                                        <input type="hidden" value="<?php echo $oc_grupofim;?>" name="capfim">
                                        <button type="submit" class="btn btn-xs btn-primary">VOLTAR P/ GRUPOS</button>
                                    </form>
                                    <table class="table">
                                        <thead>
                                            <th>CATEGORIA</th>
                                            <th>CLASSIF</th>
                                            <th>DESCRIÇÃO</th>
                                        </thead>
                                        <?php
                                        //RECEBE DADOS DO SELECT ACIMA
                                        $catinic = isset($_POST['gruini'])?$_POST['gruini']:'Não Informado';
                                        $catfim = isset($_POST['grufim'])?$_POST['grufim']:'Não Informado';

                                        //BUSCA NO BANCO NA TABELA CID10CATEGORIAS 
                                        $cid10_cat = "SELECT * FROM cid_10_categorias WHERE CAT_id >= '".$catinic."' AND CAT_id <= '".$catfim."'";
                                        $cid10dados_cat = $cx->query($cid10_cat);
                                        while ($cid10cat = $cid10dados_cat->fetch()) {
                                            $cat_cid10_id = $cid10cat['CAT_id'];
                                            $cat_cid10_desc = $cid10cat['DESCRICAO'];
                                            $cat_cid10_classif = $cid10cat['CLASSIF'];
                                        ?>
                                        <li>
                                            <form method="post" action="cid.php">
                                                    <input type="hidden" value="<?php echo $atend;?>" name="atend">
                                                    <input type="hidden" value="oc" name="oc_capitulo">
                                                    <input type="hidden" value="oc" name="oc_grupos">
                                                    <input type="hidden" value="oc" name="oc_categoria">
                                                    <input type="hidden" value="mostra" name="oc_subcategoria">
                                                    <input type="hidden" value="<?php echo $catinic;?>" name="catini">
                                                    <input type="hidden" value="<?php echo $catfim;?>" name="catfim">
                                                    <input type="hidden" value="<?php echo $oc_grupoini;?>" name="capini">
                                                    <input type="hidden" value="<?php echo $oc_grupofim;?>" name="capfim">
                                                    <input type="hidden" value="<?php echo $cat_cid10_id;?>" name="categoria">
                                                
                                                    <tr>
                                                        <td><?php echo $cat_cid10_id;?></td>
                                                        <td><?php echo $cat_cid10_classif;?></td>
                                                        <td><button type="submit" class="cidbutton"><?php echo $cat_cid10_desc;?></button></td>
                                                    </tr>
                                            </form>
                                        </li>
                                        <?php
                                            }
                                        ?>
                                    </table>
                                </div>
                                
                                
                                <!--DIV REFERENTE AOS SUBCATEGORIAS-->
                                <?php
                                $oc_subcategoria = isset($_POST['oc_subcategoria'])?$_POST['oc_subcategoria']:'oc';
                                $oc_categoriaini = isset($_POST['catini'])?$_POST['catini']:'oc';
                                $oc_categoriafim = isset($_POST['catfim'])?$_POST['catfim']:'oc';
                                $oc_capituloini = isset($_POST['capini'])?$_POST['capini']:'oc';
                                $oc_capitulofim = isset($_POST['capfim'])?$_POST['capfim']:'oc';
                                $atend = $_POST['atend'];
                                ?>
                                
                                <div class="<?php echo $oc_subcategoria;?>">
                                    <h5 align="center">SUB-CATEGORIAS</h5>
                                    <form action="cid.php" method="post">
                                        <input type="hidden" value="<?php echo $atend;?>" name="atend">
                                        <input type="hidden" value="oc" name="oc_capitulo">
                                        <input type="hidden" value="oc" name="oc_grupos">
                                        <input type="hidden" value="mostra" name="oc_categoria">
                                        <input type="hidden" value="oc" name="oc_subcategoria">
                                        <input type="hidden" value="<?php echo $oc_categoriaini;?>" name="gruini">
                                        <input type="hidden" value="<?php echo $oc_categoriafim;?>" name="grufim">
                                        <input type="hidden" value="<?php echo $oc_capituloini;?>" name="capini">
                                        <input type="hidden" value="<?php echo $oc_capitulofim;?>" name="capfim">
                                        <button type="submit" class="btn btn-xs btn-primary">VOLTAR P/ CATEGORIAS</button>
                                    </form>
                                    <table class="table">
                                        <thead>
                                            <th>SUB-CATEGORIA</th>
                                            <th>DESCRIÇÃO</th>
                                        </thead>
                                        <?php
                                        //RECEBE DADOS DO SELECT ACIMA
                                        $subcat = isset($_POST['categoria'])?$_POST['categoria']:'Não Informado';
                                        
                                        //BUSCA NO BANCO NA TABELA CID10CATEGORIAS 
                                        $cid10_subcat = "SELECT * FROM cid_10_subcategorias WHERE SUBCAT LIKE '".$subcat."%'";
                                        $cid10dados_subcat = $cx->query($cid10_subcat);
                                        while ($cid10subcat = $cid10dados_subcat->fetch()) {
                                            $subcat_cid10_id = $cid10subcat['id_subcat'];
                                            $subcat_cid10_desc = $cid10subcat['DESCRICAO'];
                                            $subcat_cid10_descabrev = $cid10subcat['DESCRABREV'];
                                            $subcat_cid10_classif = $cid10subcat['CLASSIF'];
                                            $subcat_cid10_subcat = $cid10subcat['SUBCAT'];
                                            $subcat_cid10_restsx = $cid10subcat['RESTRSEXO'];
                                            $subcat_cid10_obito = $cid10subcat['CAUSAOBITO'];
                                            $subcat_cid10_refer = $cid10subcat['REFER'];
                                            $subcat_cid10_exclui = $cid10subcat['EXCLUIDOS'];
                                            
                                            if ($subcat_cid10_restsx == 'F'){
                                                $sexo = 'FEMININO';
                                            } else if ($subcat_cid10_restsx == 'M'){
                                                $sexo = 'MASCULINO';
                                            } else if ($subcat_cid10_restsx == ''){
                                                $sexo = '';
                                            }
                                            
                                            if ($subcat_cid10_obito == 'F'){
                                                $obito = 'FEMININO';
                                            } else if ($subcat_cid10_obito == 'M'){
                                                $obito = 'MASCULINO';
                                            } else if ($subcat_cid10_obito == ''){
                                                $obito = '';
                                            }
                                            
                                            
                                        ?>
                                        
                                                <tr>
                                                    <td><?php echo $subcat_cid10_subcat;?></td>
                                                    <td>
                                                        <button type="button" class="cidbutton" data-toggle="modal" data-target="#modalcid<?php echo $subcat_cid10_id;?>"><?php echo $subcat_cid10_desc;?></button>
                                                        
                                                        <!-- MODAL REFERENTE À EXIBIÇÃO DA SUBCATEGORIA DO C.I.D. -->
                                                            <div class="modal fade" id="modalcid<?php echo $subcat_cid10_id;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                                                <div class="modal-dialog" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                            <h4 class="modal-title text-center" id="myModalLabel">Classificação Internacional de Doenças - <?php echo $subcat_cid10_subcat; ?></h4>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <form method="post" action="cid_cad.php">
                                                                                <input type="hidden" name='atendimento' value="<?php echo $atend; ?>">
                                                                                <input type="hidden" name='cidsubcat' value="<?php echo $subcat_cid10_subcat; ?>">
                                                                                <input type="hidden" name='ciddesc' value="<?php echo $subcat_cid10_desc; ?>">

                                                                                <p align='center'>DESCRIÇÃO DESTA SUB-CATEGORIA DE ACORDO COM O C.I.D.</p>
                                                                                <table class="table">
                                                                                    <tr><td>Subcategoria:</td><td><?php echo $subcat_cid10_subcat;?></td></tr>
                                                                                    <tr><td>Classif.:</td><td><?php echo $subcat_cid10_classif;?></td></tr>
                                                                                    <tr><td>Restr. Sexo:</td><td><?php echo $sexo;?></td></tr>
                                                                                    <tr><td>Causa Óbito:</td><td><?php echo $obito;?></td></tr>
                                                                                    <tr><td>Descrição:</td><td><?php echo $subcat_cid10_desc;?></td></tr>
                                                                                    <tr><td>Referência:</td><td><?php echo $subcat_cid10_refer;?></td></tr>
                                                                                    <tr><td>Excluidos:</td><td><?php echo $subcat_cid10_exclui;?></td></tr>
                                                                                    <tr><td colspan="4"><p align='center'>Autoriza a divulgação do CID: <label for="s"><input type="radio" id="s" name="CIDdiv" value="S" checked>SIM&nbsp;&nbsp;&nbsp;</label>
                                                                                                                                                        <label for="n"><input type="radio" id="n" name="CIDdiv"  value="N" >NÃO</label></p></td></tr>
                                                                                    <tr><td colspan="4"><p align='center'><button type="submit" class="btn btn-xs btn-success">Salvar C.I.D.</button></p></td></tr>
                                                                                </table>
                                                                            </form>
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                            </div>
                                                            <!-- FIM DO MODAL REFERENTE À EXIBIÇÃO DA SUBCATEGORIA DO C.I.D. -->
                                                    </td>
                                                </tr>
                                            
                                        
                                        <?php
                                            }
                                        ?>
                                    </table>
                                </div>
                                
                            </div>
                            
                    </div>
                </div>
                <br>
                <footer id="rodape">
                    <p>Copyright &copy; 2018 - by Fernando Rey Caires <br>
                        <a href="https://www.facebook.com/frtecnology/" target="_blank">Facebook</a> | Web </p> 
                </footer>
            </div>  
        </body>
        <script src='../_javascript/bootstrap.min.js'></script>
        <script src='../_javascript/jquery.min.js'></script>
    </html>
    <?php
} else {
    header("location:../index.php");
}
?>