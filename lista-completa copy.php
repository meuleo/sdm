<!DOCTYPE html>
<?php
  function salvarDadosEmJSON($dados, $arquivo)
  {
      $jsonData = json_encode($dados, JSON_PRETTY_PRINT);
      file_put_contents($arquivo, $jsonData);
  }
  
  // Paginas
  
  if(isset($_POST['next']))
  {
   
    $fim = $_POST['fim'];

    $arquivoJSON = 'pages.json';
    $dados = file_exists($arquivoJSON) ? json_decode(file_get_contents($arquivoJSON), true) : [];

    // Adiciona os dados ao array
    $fim = $fim + 24;

    $dados['fim'] = $fim; 

    echo "next ". $fim;

    // Salva os dados em um arquivo JSON
    salvarDadosEmJSON($dados, $arquivoJSON);
  }
  if(isset($_POST['prev']))
  {
   
    $fim = $_POST['fim'];
    
    $arquivoJSON = 'pages.json';
    $dados = file_exists($arquivoJSON) ? json_decode(file_get_contents($arquivoJSON), true) : [];

    // Adiciona os dados ao array
    $fim = $fim -24;

    $dados['fim'] = $fim;

    echo "prev ". $fim;

    // Salva os dados em um arquivo JSON
    salvarDadosEmJSON($dados, $arquivoJSON);
  }
?>

<!-- Fim Paginas -->

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="bootstrap/bootstrap.min.css">

    <style>
        a {
          text-decoration: none;
          color: #fff;
        }

        table {
          text-align: center;
        }
      
        table td {
          padding: 0 5px;
          border: 1px solid #000;
        }
      
        .table-header td {
          padding: 0 10px;
          border-right: 2px solid #000;
        }
      
        .td-end {
          border-right: 2px solid #272727;
          
        }

        #filtro:focus {
            outline: none;
        }

        .filtrar {
            border: 1px solid rgba(0,0,0,0.3);
            border-radius: 2em;
            overflow: hidden;
        }

        .filtrar span {
            opacity: 0.5;
        }

        .active {
          background-color: red;
        }
      </style>
</head>
<body>
    <!-- Lista feita -->
    <div class="col-12">
        <div class="fixed-to">
            <div class="row bg-dark px-2">
                <div class="col-8">
            <!-- Nova navbar -->
            <div class="" style="color: #fff;">
            <div class="py-3 ">
                <button class="btn btn-sm btn-dark" style="background-color: #707070;" onclick="goBack()">
                    〈 voltar
                </button>
                <a href="index.php">
                    <button class="btn btn-sm btn-dark" style="background-color: #707070;">
                        Nome
                    </button>
                </a>
                <a href="ticar.php"><button class="btn btn-sm btn-dark" style="background-color: #707070;">
                    Ticar
                </button></a>
                <a href="lista-completa.php"><button class="btn btn-sm btn-dark" style="background-color: rgb(194, 77, 77);">
                    Folha Completa
                </button></a>
                <button class="btn btn-sm btn-dark" style="background-color: #707070; opacity: 0.7;">
                    Importar
                </button>
                <button class="btn btn-sm btn-dark" style="background-color: #707070; opacity: 0.7;">
                    Exportar
                </button>
            </div>
            <h5>Folha de controle de Fidelidade</h5>
            <div class="">
            <!-- Lista Feita -->
            <div class="col-6"><h5 class="py-3">Folha Completa</h5></div>
            </div>
        </div>
        <!-- Fim Nova navbar -->
            </div>
            <div class="col-4">
                <div class="text-center pt-3">
                    <img src="assets/logo2.jpg" alt="" width="80">
                    <p class="pt-2" style="font-size: 0.8em; font-style: italic; color: #fff;">
                        <b> IGREJA ADVENTISTA DO SÉTIMO DIA <br>
                        MISSÃO SUL </b>
                    </p>
                </div>
            </div>
        </div>
        </div>

        <div class="invisible">
            
        <!-- </div class="">
            Fim Nova navbar
            <br><br><br>
            <br><br><br><br>
        </div> -->
        <br>

        </div>

        <div class="d-flex mb-2 pt-4 px-2">
          <div class="col-2">
          <div class="col-8 row">
            <div class="col-9">
              <select id="" name="ano" class="form-select">
                <option value="" selected disabled>Ano</option>
                <option value="2022">2022</option>
                <option value="2022">2023</option>
                <option value="2022">2024</option>
              </select> 
              </div>
              <div class="col-2">
                <input type="submit" value="Ver" class="btn btn-success">
              </div>
            </div>
          </div>  
          <div class="col-5 invisible">
            <button class="btn btn-sm btn-success">Imprimir</button>
          </div>
          <div class="col-2 invisible">
            <div style="position: relative;">
              <div class="filtrar">
                  <input class="col-9 p-1 ps-3" type="text" id="filtro" placeholder="Digite um nome" style="padding: 0.28em; border: none;">
                  <span><img src="assets/procurar.png" alt="" style="width: 35px;"></span>
              </div>
              <div class="col-12 py-1" id="nomes-lista" style="display: none; position: absolute; background: #a7a7a7;"></div>
          </div>
          </div>

          <!-- Next Page -->
          <?php
             $jsonFile = file_get_contents('pages.json');
             // Decodifica o JSON em um array associativo
             $data = json_decode($jsonFile, true);

             $page = $data['fim'];

          ?>

          <div class="col-3 text-end" style="padding-top: 0.45em;">
            <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST">
              
            <!-- Fim -->
              <input type="text" class="d-none" value="<?php echo $page; ?>" name="fim">
            <!-- End Fim -->

              <input type="submit" class="btn btn-sm btn-dark px-3" name="prev" value="〈"> 1-20 
              <input type="submit" class="btn btn-sm btn-dark px-3" name="next" value="〉"> de 50</div>
            </form>
          </div>
          <!-- Prev Page -->

        <div class="table-responsive p-2 px-3" style='height: 100vh;'>
        <div>
          <div class="row px-4" style="font-style: italic;">
              <div class="col-3 text-center" style="display: flex; justify-content: start;">
                  <div>
                    <div>
                      <img src="assets/logo2.jpg" alt="" width="55">
                    </div>
                    <div>
                      <p style="font-size: 0.6em;" class="m-0"><b>IGREJA ADVENTISTA DO SÉTIMO DIA <br> MISSÃO SUL</b></p>
                    </div>
                  </div>
              </div>
              <div class="col-9 text-center" style="display: flex; justify-content: end;">
              <div>
                    <div class="invisible">
                      <img src="assets/logo2.jpg" alt="" width="55">
                    </div>
                    <div>
                      <p style="font-size: 0.6em;" class="m-0"><b>MINISTÉRIO DE MORDOMIA CRISTÃ</b></p>
                    </div>
                  </div>
              </div>
          </div>

          <div class="text-center">
            <h5 class="pb-2" style="font-size: 0.9em;">LIVRO DE CONTROLE DE FIDELIDADE DOS MEMBROS</h5>
          </div>

          <div>
            <div class="row col-11 mx-auto mb-3 border border-dark border-2">
                <div class="col-4 row">
                    <div class="col-4">
                      <b><p class="m-0">Igreja:</p></b>
                    </div>
                    <div class="col-8">

                    </div>
                </div>
                <div class="col-4 row">
                    <div class="col-4">
                      <b><p class="m-0">Distrito:</p></b>
                    </div>
                    <div class="col-8">

                    </div>
                </div>
                <div class="col-4 row">
                   <div class="col-4">
                      <b><p class="m-0">Cidade:</p></b>
                    </div>
                    <div class="col-4">

                    </div>
                    <div class="col-4">
                      <b><p class="m-0">Ano: 20___</p></b>
                    </div>
                </div>
            </div>
          </div>
        </div>  
        <table class="col-12" style="border: 2px solid #000; font-size: 0.8em;">
        
            <tr class="table-header">
              <td>#</td>
              <td colspan="2">Meses</td>
              <td colspan="5">janeiro</td>
              <td colspan="5">Fevereiro</td>
              <td colspan="5">Março</td>
    
              <td colspan="5">Abril</td>
              <td colspan="5">Maio</td>
              <td colspan="5">Junho</td>
    
              <td colspan="5">Julho</td>
              <td colspan="5">Agosto</td>
              <td colspan="5">Setembro</td>
    
              <td colspan="5">Outubro</td>
              <td colspan="5">Novembro</td>
              <td colspan="5">Dezembro</td>
            </tr>
            <tr>
              <td class="td-end">Nº</td>
              <td class="td-end" colspan="2">Nome</td>
    
              <td>1</td>
              <td>2</td>
              <td>3</td>
              <td>4</td>
              <td class="td-end">5</td>
    
              <td>1</td>
              <td>2</td>
              <td>3</td>
              <td>4</td>
              <td class="td-end">5</td>
    
              <td>1</td>
              <td>2</td>
              <td>3</td>
              <td>4</td>
              <td class="td-end">5</td>
    
              <td>1</td>
              <td>2</td>
              <td>3</td>
              <td>4</td>
              <td class="td-end">5</td>
    
              <td>1</td>
              <td>2</td>
              <td>3</td>
              <td>4</td>
              <td class="td-end">5</td>
    
              <td>1</td>
              <td>2</td>
              <td>3</td>
              <td>4</td>
              <td class="td-end">5</td>
    
              <td>1</td>
              <td>2</td>
              <td>3</td>
              <td>4</td>
              <td class="td-end">5</td>
    
              <td>1</td>
              <td>2</td>
              <td>3</td>
              <td>4</td>
              <td class="td-end">5</td>
    
              <td>1</td>
              <td>2</td>
              <td>3</td>
              <td>4</td>
              <td class="td-end">5</td>
    
              <td>1</td>
              <td>2</td>
              <td>3</td>
              <td>4</td>
              <td class="td-end">5</td>
              
              <td>1</td>
              <td>2</td>
              <td>3</td>
              <td>4</td>
              <td class="td-end">5</td>
    
              <td>1</td>
              <td>2</td>
              <td>3</td>
              <td>4</td>
              <td class="td-end">5</td>

<?php
  $jsonFile = file_get_contents('ticar.json');
  // Decodifica o JSON em um array associativo
  $data = json_decode($jsonFile, true);

  // 24 linhas de cada vez
  
  // echo print_r($data);

  foreach($data as $key4 => $value):

  $mes = $value['data'];
  $partes = explode('-', $mes);
  $mes = $partes[1];

  // echo $mes; // Isso imprimirá "08" Se ano for igual a 2023
?>

</tr>

<?php
  $cont = "";

  usort($value['tics'], function ($a, $b) {
      return strcmp($a['nome'], $b['nome']);
  });

  foreach($value['tics'] as $key => $tics):
?>
<!-- Primeira linha -->
            <tr>

              <td class="td-end" rowspan="2"><?php echo $key4+1  ; ?></td>
              <td rowspan="2"><?php echo $tics['nome']; ?></td>

              <td class="td-end">D</td>

              <!-- (1) Janeiro -->
              <td>
                <?php 
                  if($value['sabado'] == '1' && $mes == '01'){
                      if($tics['checkbox']['check1'] == 'true'){
                        echo 'x';
                      }
                  }
                ?>
              </td>
              <td>
                <?php 
                  if($value['sabado'] == '2' && $mes == '01'){
                    if($tics['checkbox']['check1'] == 'true'){
                        echo 'x';
                      }
                  }
                ?>
              </td>
              <td>
                <?php 
                  if($value['sabado'] == '3' && $mes == '01'){
                    if($tics['checkbox']['check1'] == 'true'){
                        echo 'x';
                      }
                  }
                ?>
              </td>
              <td>
                <?php 
                  if($value['sabado'] == '4' && $mes == '01'){
                    if($tics['checkbox']['check1'] == 'true'){
                        echo 'x';
                      }
                  }
                ?>
              </td>
              <td class="td-end">
                <?php 
                  if($value['sabado'] == '5' && $mes == '01'){
                    if($tics['checkbox']['check1'] == 'true'){
                        echo 'x';
                      }
                  }
                ?>
              </td>

            <!-- (2) Fevereiro  -->
            <td>
                <?php 
                  if($value['sabado'] == '1' && $mes == '02'){
                    if($tics['checkbox']['check1'] == 'true'){
                        echo 'x';
                      }
                  }
                ?>
              </td>
              <td>
                <?php 
                  if($value['sabado'] == '2' && $mes == '02'){
                    if($tics['checkbox']['check1'] == 'true'){
                        echo 'x';
                      }
                  }
                ?>
              </td>
              <td>
                <?php 
                  if($value['sabado'] == '3' && $mes == '02'){
                    if($tics['checkbox']['check1'] == 'true'){
                        echo 'x';
                      }
                  }
                ?>
              </td>
              <td>
                <?php 
                  if($value['sabado'] == '4' && $mes == '02'){
                    if($tics['checkbox']['check1'] == 'true'){
                        echo 'x';
                      }
                  }
                ?>
              </td>
              <td class="td-end">
                <?php 
                  if($value['sabado'] == '5' && $mes == '02'){
                    if($tics['checkbox']['check1'] == 'true'){
                        echo 'x';
                      }
                  }
                ?>
              </td>

              <!-- (3) Março -->
              <td>
                <?php 
                  if($value['sabado'] == '1' && $mes == '03'){
                    if($tics['checkbox']['check1'] == 'true'){
                        echo 'x';
                      }
                  }
                ?>
              </td>
              <td>
                <?php 
                  if($value['sabado'] == '2' && $mes == '03'){
                    if($tics['checkbox']['check1'] == 'true'){
                        echo 'x';
                      }
                  }
                ?>
              </td>
              <td>
                <?php 
                  if($value['sabado'] == '3' && $mes == '03'){
                    if($tics['checkbox']['check1'] == 'true'){
                        echo 'x';
                      }
                  }
                ?>
              </td>
              <td>
                <?php 
                  if($value['sabado'] == '4' && $mes == '03'){
                    if($tics['checkbox']['check1'] == 'true'){
                        echo 'x';
                      }
                  }
                ?>
              </td>
              <td class="td-end">
                <?php 
                  if($value['sabado'] == '5' && $mes == '03'){
                    if($tics['checkbox']['check1'] == 'true'){
                        echo 'x';
                      }
                  }
                ?>
              </td>

              <!-- (4) Abril -->
              <td>
                <?php 
                  if($value['sabado'] == '1' && $mes == '04'){
                    if($tics['checkbox']['check1'] == 'true'){
                        echo 'x';
                      }
                  }
                ?>
              </td>
              <td>
                <?php 
                  if($value['sabado'] == '2' && $mes == '04'){
                    if($tics['checkbox']['check1'] == 'true'){
                        echo 'x';
                      }
                  }
                ?>
              </td>
              <td>
                <?php 
                  if($value['sabado'] == '3' && $mes == '04'){
                    if($tics['checkbox']['check1'] == 'true'){
                        echo 'x';
                      }
                  }
                ?>
              </td>
              <td>
                <?php 
                  if($value['sabado'] == '4' && $mes == '04'){
                    if($tics['checkbox']['check1'] == 'true'){
                        echo 'x';
                      }
                  }
                ?>
              </td>
              <td class="td-end">
                <?php 
                  if($value['sabado'] == '5' && $mes == '04'){
                    if($tics['checkbox']['check1'] == 'true'){
                        echo 'x';
                      }
                  }
                ?>
              </td>

              <!-- (5) Maio -->
              <td>
                <?php 
                  if($value['sabado'] == '1' && $mes == '05'){
                    if($tics['checkbox']['check1'] == 'true'){
                        echo 'x';
                      }
                  }
                ?>
              </td>
              <td>
                <?php 
                  if($value['sabado'] == '2' && $mes == '05'){
                    if($tics['checkbox']['check1'] == 'true'){
                        echo 'x';
                      }
                  }
                ?>
              </td>
              <td>
                <?php 
                  if($value['sabado'] == '3' && $mes == '05'){
                    if($tics['checkbox']['check1'] == 'true'){
                        echo 'x';
                      }
                  }
                ?>
              </td>
              <td>
                <?php 
                  if($value['sabado'] == '4' && $mes == '05'){
                    if($tics['checkbox']['check1'] == 'true'){
                        echo 'x';
                      }
                  }
                ?>
              </td>
              <td class="td-end">
                <?php 
                  if($value['sabado'] == '5' && $mes == '05'){
                    if($tics['checkbox']['check1'] == 'true'){
                        echo 'x';
                      }
                  }
                ?>
              </td>

              <!-- (6) Junho -->
              <td>
                <?php 
                  if($value['sabado'] == '1' && $mes == '06'){
                    if($tics['checkbox']['check1'] == 'true'){
                        echo 'x';
                      }
                  }
                ?>
              </td>
              <td>
                <?php 
                  if($value['sabado'] == '2' && $mes == '06'){
                    if($tics['checkbox']['check1'] == 'true'){
                        echo 'x';
                      }
                  }
                ?>
              </td>
              <td>
                <?php 
                  if($value['sabado'] == '3' && $mes == '06'){
                    if($tics['checkbox']['check1'] == 'true'){
                        echo 'x';
                      }
                  }
                ?>
              </td>
              <td>
                <?php 
                  if($value['sabado'] == '4' && $mes == '06'){
                    if($tics['checkbox']['check1'] == 'true'){
                        echo 'x';
                      }
                  }
                ?>
              </td>
              <td class="td-end">
                <?php 
                  if($value['sabado'] == '5' && $mes == '06'){
                    if($tics['checkbox']['check1'] == 'true'){
                        echo 'x';
                      }
                  }
                ?>
              </td>

              <!-- (7) Julho -->
              <td>
                <?php 
                  if($value['sabado'] == '1' && $mes == '07'){
                    if($tics['checkbox']['check1'] == 'true'){
                        echo 'x';
                      }
                  }
                ?>
              </td>
              <td>
                <?php 
                  if($value['sabado'] == '2' && $mes == '07'){
                    if($tics['checkbox']['check1'] == 'true'){
                        echo 'x';
                      }
                  }
                ?>
              </td>
              <td>
                <?php 
                  if($value['sabado'] == '3' && $mes == '07'){
                    if($tics['checkbox']['check1'] == 'true'){
                        echo 'x';
                      }
                  }
                ?>
              </td>
              <td>
                <?php 
                  if($value['sabado'] == '4' && $mes == '07'){
                    if($tics['checkbox']['check1'] == 'true'){
                        echo 'x';
                      }
                  }
                ?>
              </td>
              <td class="td-end">
                <?php 
                  if($value['sabado'] == '5' && $mes == '07'){
                    if($tics['checkbox']['check1'] == 'true'){
                        echo 'x';
                      }
                  }
                ?>
              </td>

              <!-- (8) Agosto -->
              <td>
                <?php 
                  if($value['sabado'] == '1' && $mes == '08'){
                    if($tics['checkbox']['check1'] == 'true'){
                        echo 'x';
                      }
                  }
                ?>
              </td>
              <td>
                <?php 
                  if($value['sabado'] == '2' && $mes == '08'){
                    if($tics['checkbox']['check1'] == 'true'){
                        echo 'x';
                      }
                  }
                ?>
              </td>
              <td>
                <?php 
                  if($value['sabado'] == '3' && $mes == '08'){
                    if($tics['checkbox']['check1'] == 'true'){
                        echo 'x';
                      }
                  }
                ?>
              </td>
              <td>
                <?php 
                  if($value['sabado'] == '4' && $mes == '08'){
                    if($tics['checkbox']['check1'] == 'true'){
                        echo 'x';
                      }
                  }
                ?>
              </td>
              <td class="td-end">
                <?php 
                  if($value['sabado'] == '5' && $mes == '08'){
                    if($tics['checkbox']['check1'] == 'true'){
                        echo 'x';
                      }
                  }
                ?>
              </td>

              <!-- (9) Setembro -->
              <td>
                <?php 
                  if($value['sabado'] == '1' && $mes == '09'){
                    if($tics['checkbox']['check1'] == 'true'){
                        echo 'x';
                      }
                  }
                ?>
              </td>
              <td>
                <?php 
                  if($value['sabado'] == '2' && $mes == '09'){
                    if($tics['checkbox']['check1'] == 'true'){
                        echo 'x';
                      }
                  }
                ?>
              </td>
              <td>
                <?php 
                  if($value['sabado'] == '3' && $mes == '09'){
                    if($tics['checkbox']['check1'] == 'true'){
                        echo 'x';
                      }
                  }
                ?>
              </td>
              <td>
                <?php 
                  if($value['sabado'] == '4' && $mes == '09'){
                    if($tics['checkbox']['check1'] == 'true'){
                        echo 'x';
                      }
                  }
                ?>
              </td>
              <td class="td-end">
                <?php 
                  if($value['sabado'] == '5' && $mes == '09'){
                    if($tics['checkbox']['check1'] == 'true'){
                        echo 'x';
                      }
                  }
                ?>
              </td>

              <!-- (10) Outubro -->
              <td>
                <?php 
                  if($value['sabado'] == '1' && $mes == '10'){
                    if($tics['checkbox']['check1'] == 'true'){
                        echo 'x';
                      }
                  }
                ?>
              </td>
              <td>
                <?php 
                  if($value['sabado'] == '2' && $mes == '10'){
                    if($tics['checkbox']['check1'] == 'true'){
                        echo 'x';
                      }
                  }
                ?>
              </td>
              <td>
                <?php 
                  if($value['sabado'] == '3' && $mes == '10'){
                    if($tics['checkbox']['check1'] == 'true'){
                        echo 'x';
                      }
                  }
                ?>
              </td>
              <td>
                <?php 
                  if($value['sabado'] == '4' && $mes == '10'){
                    if($tics['checkbox']['check1'] == 'true'){
                        echo 'x';
                      }
                  }
                ?>
              </td>
              <td class="td-end">
                <?php 
                  if($value['sabado'] == '5' && $mes == '10'){
                    if($tics['checkbox']['check1'] == 'true'){
                        echo 'x';
                      }
                  }
                ?>
              </td>

              <!-- (11) Novembro -->
              <td>
                <?php 
                  if($value['sabado'] == '1' && $mes == '11'){
                    if($tics['checkbox']['check1'] == 'true'){
                        echo 'x';
                      }
                  }
                ?>
              </td>
              <td>
                <?php 
                  if($value['sabado'] == '2' && $mes == '11'){
                    if($tics['checkbox']['check1'] == 'true'){
                        echo 'x';
                      }
                  }
                ?>
              </td>
              <td>
                <?php 
                  if($value['sabado'] == '3' && $mes == '11'){
                    if($tics['checkbox']['check1'] == 'true'){
                        echo 'x';
                      }
                  }
                ?>
              </td>
              <td>
                <?php 
                  if($value['sabado'] == '4' && $mes == '11'){
                    if($tics['checkbox']['check1'] == 'true'){
                        echo 'x';
                      }
                  }
                ?>
              </td>
              <td class="td-end">
                <?php 
                  if($value['sabado'] == '5' && $mes == '11'){
                    if($tics['checkbox']['check1'] == 'true'){
                        echo 'x';
                      }
                  }
                ?>
              </td>

              <!-- (12) Dezembro -->
              <td>
                <?php 
                  if($value['sabado'] == '1' && $mes == '12'){
                    if($tics['checkbox']['check1'] == 'true'){
                        echo 'x';
                      }
                  }
                ?>
              </td>
              <td>
                <?php 
                  if($value['sabado'] == '2' && $mes == '12'){
                    if($tics['checkbox']['check1'] == 'true'){
                        echo 'x';
                      }
                  }
                ?>
              </td>
              <td>
                <?php 
                  if($value['sabado'] == '3' && $mes == '12'){
                    if($tics['checkbox']['check1'] == 'true'){
                        echo 'x';
                      }
                  }
                ?>
              </td>
              <td>
                <?php 
                  if($value['sabado'] == '4' && $mes == '12'){
                    if($tics['checkbox']['check1'] == 'true'){
                        echo 'x';
                      }
                  }
                ?>
              </td>
              <td class="td-end">
                <?php 
                  if($value['sabado'] == '5' && $mes == '12'){
                    if($tics['checkbox']['check1'] == 'true'){
                        echo 'x';
                      }
                  }
                ?>
              </td>
            </tr>

            <!-- linha 2 primeiro nome -->
            <tr>
              <td class="td-end">O</td>
              <!-- (1) Janeiro -->
              <td>
                <?php 
                  if($value['sabado'] == '1' && $mes == '01'){
                      if($tics['checkbox']['check2'] == 'true'){
                        echo 'x';
                      }
                  }
                ?>
              </td>
              <td>
                <?php 
                  if($value['sabado'] == '2' && $mes == '01'){
                    if($tics['checkbox']['check2'] == 'true'){
                        echo 'x';
                      }
                  }
                ?>
              </td>
              <td>
                <?php 
                  if($value['sabado'] == '3' && $mes == '01'){
                    if($tics['checkbox']['check2'] == 'true'){
                        echo 'x';
                      }
                  }
                ?>
              </td>
              <td>
                <?php 
                  if($value['sabado'] == '4' && $mes == '01'){
                    if($tics['checkbox']['check2'] == 'true'){
                        echo 'x';
                      }
                  }
                ?>
              </td>
              <td class="td-end">
                <?php 
                  if($value['sabado'] == '5' && $mes == '01'){
                    if($tics['checkbox']['check2'] == 'true'){
                        echo 'x';
                      }
                  }
                ?>
              </td>

            <!-- (2) Fevereiro  -->
            <td>
                <?php 
                  if($value['sabado'] == '1' && $mes == '02'){
                    if($tics['checkbox']['check2'] == 'true'){
                        echo 'x';
                      }
                  }
                ?>
              </td>
              <td>
                <?php 
                  if($value['sabado'] == '2' && $mes == '02'){
                    if($tics['checkbox']['check2'] == 'true'){
                        echo 'x';
                      }
                  }
                ?>
              </td>
              <td>
                <?php 
                  if($value['sabado'] == '3' && $mes == '02'){
                    if($tics['checkbox']['check2'] == 'true'){
                        echo 'x';
                      }
                  }
                ?>
              </td>
              <td>
                <?php 
                  if($value['sabado'] == '4' && $mes == '02'){
                    if($tics['checkbox']['check2'] == 'true'){
                        echo 'x';
                      }
                  }
                ?>
              </td>
              <td class="td-end">
                <?php 
                  if($value['sabado'] == '5' && $mes == '02'){
                    if($tics['checkbox']['check2'] == 'true'){
                        echo 'x';
                      }
                  }
                ?>
              </td>

              <!-- (3) Março -->
              <td>
                <?php 
                  if($value['sabado'] == '1' && $mes == '03'){
                    if($tics['checkbox']['check2'] == 'true'){
                        echo 'x';
                      }
                  }
                ?>
              </td>
              <td>
                <?php 
                  if($value['sabado'] == '2' && $mes == '03'){
                    if($tics['checkbox']['check2'] == 'true'){
                        echo 'x';
                      }
                  }
                ?>
              </td>
              <td>
                <?php 
                  if($value['sabado'] == '3' && $mes == '03'){
                    if($tics['checkbox']['check2'] == 'true'){
                        echo 'x';
                      }
                  }
                ?>
              </td>
              <td>
                <?php 
                  if($value['sabado'] == '4' && $mes == '03'){
                    if($tics['checkbox']['check2'] == 'true'){
                        echo 'x';
                      }
                  }
                ?>
              </td>
              <td class="td-end">
                <?php 
                  if($value['sabado'] == '5' && $mes == '03'){
                    if($tics['checkbox']['check2'] == 'true'){
                        echo 'x';
                      }
                  }
                ?>
              </td>

              <!-- (4) Abril -->
              <td>
                <?php 
                  if($value['sabado'] == '1' && $mes == '04'){
                    if($tics['checkbox']['check2'] == 'true'){
                        echo 'x';
                      }
                  }
                ?>
              </td>
              <td>
                <?php 
                  if($value['sabado'] == '2' && $mes == '04'){
                    if($tics['checkbox']['check2'] == 'true'){
                        echo 'x';
                      }
                  }
                ?>
              </td>
              <td>
                <?php 
                  if($value['sabado'] == '3' && $mes == '04'){
                    if($tics['checkbox']['check2'] == 'true'){
                        echo 'x';
                      }
                  }
                ?>
              </td>
              <td>
                <?php 
                  if($value['sabado'] == '4' && $mes == '04'){
                    if($tics['checkbox']['check2'] == 'true'){
                        echo 'x';
                      }
                  }
                ?>
              </td>
              <td class="td-end">
                <?php 
                  if($value['sabado'] == '5' && $mes == '04'){
                    if($tics['checkbox']['check2'] == 'true'){
                        echo 'x';
                      }
                  }
                ?>
              </td>

              <!-- (5) Maio -->
              <td>
                <?php 
                  if($value['sabado'] == '1' && $mes == '05'){
                    if($tics['checkbox']['check2'] == 'true'){
                        echo 'x';
                      }
                  }
                ?>
              </td>
              <td>
                <?php 
                  if($value['sabado'] == '2' && $mes == '05'){
                    if($tics['checkbox']['check2'] == 'true'){
                        echo 'x';
                      }
                  }
                ?>
              </td>
              <td>
                <?php 
                  if($value['sabado'] == '3' && $mes == '05'){
                    if($tics['checkbox']['check2'] == 'true'){
                        echo 'x';
                      }
                  }
                ?>
              </td>
              <td>
                <?php 
                  if($value['sabado'] == '4' && $mes == '05'){
                    if($tics['checkbox']['check2'] == 'true'){
                        echo 'x';
                      }
                  }
                ?>
              </td>
              <td class="td-end">
                <?php 
                  if($value['sabado'] == '5' && $mes == '05'){
                    if($tics['checkbox']['check2'] == 'true'){
                        echo 'x';
                      }
                  }
                ?>
              </td>

              <!-- (6) Junho -->
              <td>
                <?php 
                  if($value['sabado'] == '1' && $mes == '06'){
                    if($tics['checkbox']['check2'] == 'true'){
                        echo 'x';
                      }
                  }
                ?>
              </td>
              <td>
                <?php 
                  if($value['sabado'] == '2' && $mes == '06'){
                    if($tics['checkbox']['check2'] == 'true'){
                        echo 'x';
                      }
                  }
                ?>
              </td>
              <td>
                <?php 
                  if($value['sabado'] == '3' && $mes == '06'){
                    if($tics['checkbox']['check2'] == 'true'){
                        echo 'x';
                      }
                  }
                ?>
              </td>
              <td>
                <?php 
                  if($value['sabado'] == '4' && $mes == '06'){
                    if($tics['checkbox']['check2'] == 'true'){
                        echo 'x';
                      }
                  }
                ?>
              </td>
              <td class="td-end">
                <?php 
                  if($value['sabado'] == '5' && $mes == '06'){
                    if($tics['checkbox']['check2'] == 'true'){
                        echo 'x';
                      }
                  }
                ?>
              </td>

              <!-- (7) Julho -->
              <td>
                <?php 
                  if($value['sabado'] == '1' && $mes == '07'){
                    if($tics['checkbox']['check2'] == 'true'){
                        echo 'x';
                      }
                  }
                ?>
              </td>
              <td>
                <?php 
                  if($value['sabado'] == '2' && $mes == '07'){
                    if($tics['checkbox']['check2'] == 'true'){
                        echo 'x';
                      }
                  }
                ?>
              </td>
              <td>
                <?php 
                  if($value['sabado'] == '3' && $mes == '07'){
                    if($tics['checkbox']['check2'] == 'true'){
                        echo 'x';
                      }
                  }
                ?>
              </td>
              <td>
                <?php 
                  if($value['sabado'] == '4' && $mes == '07'){
                    if($tics['checkbox']['check2'] == 'true'){
                        echo 'x';
                      }
                  }
                ?>
              </td>
              <td class="td-end">
                <?php 
                  if($value['sabado'] == '5' && $mes == '07'){
                    if($tics['checkbox']['check2'] == 'true'){
                        echo 'x';
                      }
                  }
                ?>
              </td>

              <!-- (8) Agosto -->
              <td>
                <?php 
                  if($value['sabado'] == '1' && $mes == '08'){
                    if($tics['checkbox']['check2'] == 'true'){
                        echo 'x';
                      }
                  }
                ?>
              </td>
              <td>
                <?php 
                  if($value['sabado'] == '2' && $mes == '08'){
                    if($tics['checkbox']['check2'] == 'true'){
                        echo 'x';
                      }
                  }
                ?>
              </td>
              <td>
                <?php 
                  if($value['sabado'] == '3' && $mes == '08'){
                    if($tics['checkbox']['check2'] == 'true'){
                        echo 'x';
                      }
                  }
                ?>
              </td>
              <td>
                <?php 
                  if($value['sabado'] == '4' && $mes == '08'){
                    if($tics['checkbox']['check2'] == 'true'){
                        echo 'x';
                      }
                  }
                ?>
              </td>
              <td class="td-end">
                <?php 
                  if($value['sabado'] == '5' && $mes == '08'){
                    if($tics['checkbox']['check2'] == 'true'){
                        echo 'x';
                      }
                  }
                ?>
              </td>

              <!-- (9) Setembro -->
              <td>
                <?php 
                  if($value['sabado'] == '1' && $mes == '09'){
                    if($tics['checkbox']['check2'] == 'true'){
                        echo 'x';
                      }
                  }
                ?>
              </td>
              <td>
                <?php 
                  if($value['sabado'] == '2' && $mes == '09'){
                    if($tics['checkbox']['check2'] == 'true'){
                        echo 'x';
                      }
                  }
                ?>
              </td>
              <td>
                <?php 
                  if($value['sabado'] == '3' && $mes == '09'){
                    if($tics['checkbox']['check2'] == 'true'){
                        echo 'x';
                      }
                  }
                ?>
              </td>
              <td>
                <?php 
                  if($value['sabado'] == '4' && $mes == '09'){
                    if($tics['checkbox']['check2'] == 'true'){
                        echo 'x';
                      }
                  }
                ?>
              </td>
              <td class="td-end">
                <?php 
                  if($value['sabado'] == '5' && $mes == '09'){
                    if($tics['checkbox']['check2'] == 'true'){
                        echo 'x';
                      }
                  }
                ?>
              </td>

              <!-- (10) Outubro -->
              <td>
                <?php 
                  if($value['sabado'] == '1' && $mes == '10'){
                    if($tics['checkbox']['check2'] == 'true'){
                        echo 'x';
                      }
                  }
                ?>
              </td>
              <td>
                <?php 
                  if($value['sabado'] == '2' && $mes == '10'){
                    if($tics['checkbox']['check2'] == 'true'){
                        echo 'x';
                      }
                  }
                ?>
              </td>
              <td>
                <?php 
                  if($value['sabado'] == '3' && $mes == '10'){
                    if($tics['checkbox']['check2'] == 'true'){
                        echo 'x';
                      }
                  }
                ?>
              </td>
              <td>
                <?php 
                  if($value['sabado'] == '4' && $mes == '10'){
                    if($tics['checkbox']['check2'] == 'true'){
                        echo 'x';
                      }
                  }
                ?>
              </td>
              <td class="td-end">
                <?php 
                  if($value['sabado'] == '5' && $mes == '10'){
                    if($tics['checkbox']['check2'] == 'true'){
                        echo 'x';
                      }
                  }
                ?>
              </td>

              <!-- (11) Novembro -->
              <td>
                <?php 
                  if($value['sabado'] == '1' && $mes == '11'){
                    if($tics['checkbox']['check2'] == 'true'){
                        echo 'x';
                      }
                  }
                ?>
              </td>
              <td>
                <?php 
                  if($value['sabado'] == '2' && $mes == '11'){
                    if($tics['checkbox']['check2'] == 'true'){
                        echo 'x';
                      }
                  }
                ?>
              </td>
              <td>
                <?php 
                  if($value['sabado'] == '3' && $mes == '11'){
                    if($tics['checkbox']['check2'] == 'true'){
                        echo 'x';
                      }
                  }
                ?>
              </td>
              <td>
                <?php 
                  if($value['sabado'] == '4' && $mes == '11'){
                    if($tics['checkbox']['check2'] == 'true'){
                        echo 'x';
                      }
                  }
                ?>
              </td>
              <td class="td-end">
                <?php 
                  if($value['sabado'] == '5' && $mes == '11'){
                    if($tics['checkbox']['check2'] == 'true'){
                        echo 'x';
                      }
                  }
                ?>
              </td>

              <!-- (12) Dezembro -->
              <td>
                <?php 
                  if($value['sabado'] == '1' && $mes == '12'){
                    if($tics['checkbox']['check2'] == 'true'){
                        echo 'x';
                      }
                  }
                ?>
              </td>
              <td>
                <?php 
                  if($value['sabado'] == '2' && $mes == '12'){
                    if($tics['checkbox']['check2'] == 'true'){
                        echo 'x';
                      }
                  }
                ?>
              </td>
              <td>
                <?php 
                  if($value['sabado'] == '3' && $mes == '12'){
                    if($tics['checkbox']['check2'] == 'true'){
                        echo 'x';
                      }
                  }
                ?>
              </td>
              <td>
                <?php 
                  if($value['sabado'] == '4' && $mes == '12'){
                    if($tics['checkbox']['check2'] == 'true'){
                        echo 'x';
                      }
                  }
                ?>
              </td>
              <td class="td-end">
                <?php 
                  if($value['sabado'] == '5' && $mes == '12'){
                    if($tics['checkbox']['check2'] == 'true'){
                        echo 'x';
                      }
                  }
                ?>
              </td>
            </tr>

                <?php endforeach; ?>

            <?php endforeach; ?>

          </table>

          <div class="col-11 mx-auto my-3 border border-dark border-2 ps-3">
            <ul class="pb-0 m-0">
              <li style="font-size: 0.9em;">
                  <b> 
                    Inserir no Mapa os nomes de todos membros batizados e dos não batizados.
                    Acrescer os recens-batizados.
                  </b>
              </li>
              <li style="font-size: 0.9em;">
                <b>
                  Todo membro será ajudado pela comissão de Mordomia, 
                  tão logo que se registe o bloqueio da devolução sistemática.
                </b>
              </li>
            </ul>
          </div>

          <div>
            <button class="btn btn-sm btn-success">Guardar</button>
          </div>

        </div>
      </div>
    <!-- End lista feita -->

    <div id="Exportar" class="fixed-top d-flex d-none" style="justify-content: center; align-items: center; height: 100vh;">
        <div class="modal-exportar bg-success col-3 rounded-2 border border-dark border-1" style="height: 70%; box-shadow: 0px 0px 8px 0px rgba(0,0,0,0.7);">
            <div>
                <div class="row px-2">
                    <div class="col-6">
                        <h5 class="invisible">Exportar</h5>
                    </div>
                    <div class="col-6 text-end pt-2">
                        <h5><button class="btn" onclick="hideExportar()"><b>X</b></button></h5>
                    </div>
                </div>
                <div class="ps-4" >
                    <h5>Exportar</h5>
                    <a href=""><p class="mb-1" style="color: #000;">» Exportar nomes</p></a>
                    <a href=""><p style="color: #000;">» Exportar Tics</p></a>
                </div>
                <div style="padding-top: 16em; opacity: 0.6;">
                    <p class="text-center">
                        by: <a href="http://devaholic.ao" style="color: blue; text-decoration: underline;">DevAholic</a>
                    </p>
                </div>
            </div>
        </div>
    </div>


    <?php
    // Verifica se o arquivo existe
    $nomeArquivo = 'nomes.json';
    if (!file_exists($nomeArquivo)) {
        die("O arquivo $nomeArquivo não existe.");
    }

    // Lê o conteúdo do arquivo
    $jsonString = file_get_contents($nomeArquivo);

    // Decodifica o JSON para uma variável PHP
    $nomesArray = json_decode($jsonString, true);

    $nomesJson = json_encode($nomesArray);

    // Verifica se houve algum erro na decodificação
    if ($nomesArray === null && json_last_error() !== JSON_ERROR_NONE) {
        die("Erro ao decodificar o JSON: " . json_last_error_msg());
    }

    // Agora, $nomesArray contém o conteúdo do arquivo JSON
    // print_r($nomesArray);
?>

<script>
var nomes1 = []

var dados = <?php echo $nomesJson; ?>;
console.log(dados);

dados.forEach(el => {
    nomes1.push(el.nome)
    console.log("nome: " + nomes1)
})

// Array de nomes (pode ser qualquer array que desejar)
const nomes = nomes1

// Função para atualizar a lista de nomes filtrados
function atualizarListaFiltrada(filtro) {
  const lista = document.getElementById("nomes-lista");
  lista.innerHTML = "";

  if (filtro.trim() === "") {
    lista.style.display = "none"; // Oculta a lista se o filtro estiver vazio
  } else {
    const nomesFiltrados = nomes.filter((nome) =>
      nome.toLowerCase().includes(filtro.toLowerCase())
    );

    nomesFiltrados.forEach((nome) => {
      const li = document.createElement("p");
      li.textContent = nome;
      lista.appendChild(li);
    });

    lista.style.display = "block"; // Mostra a lista se houver nomes filtrados
  }
}

// Função para lidar com o evento de input no campo de filtro
function handleFiltroChange() {
  const filtro = document.getElementById("filtro").value;
  atualizarListaFiltrada(filtro);
}

// Adicionar um event listener para o campo de filtro
document.getElementById("filtro").addEventListener("input", handleFiltroChange);
</script>

    <script>
      function goBack() {
          window.history.back();
      }
  </script>


<script>
    // Seus dados JSON (exemplo)
    var dados = [
        { "id": 1, "nome": "Item 1" },
        { "id": 2, "nome": "Item 2" },
        // ... (outros itens)
    ];

    var itemsPerPage = 10;
    var currentPage = 1;

    var container = document.getElementById('data-container');
    var previousButton = document.getElementById('previous');
    var nextButton = document.getElementById('next');

    function displayData(page) {
        container.innerHTML = '';

        var startIndex = (page - 1) * itemsPerPage;
        var endIndex = startIndex + itemsPerPage;

        for (var i = startIndex; i < endIndex && i < dados.length; i++) {
            var item = dados[i];
            var itemDiv = document.createElement('div');
            itemDiv.textContent = `ID: ${item.id}, Nome: ${item.nome}`;
            container.appendChild(itemDiv);
        }

        previousButton.disabled = page === 1;
        nextButton.disabled = endIndex >= dados.length;
    }

    displayData(currentPage);

    previousButton.addEventListener('click', function () {
        if (currentPage > 1) {
            currentPage--;
            displayData(currentPage);
        }
    });

    nextButton.addEventListener('click', function () {
        if (currentPage * itemsPerPage < dados.length) {
            currentPage++;
            displayData(currentPage);
        }
    });
</script>

<!-- <div style="padding: 0.2rem 2.5rem;" id="aguarde">
	Concluido...<br>Nome do ficheiro: <b><span id="fnome">Relatório_Sábado_<?php echo $ndata; ?></b></span> <br> 
	Localize o ficheiro na pasta download<br>
	Ou noutra pasta definida para salvar ficheiros...
  </div>


<div style="padding: 0.5rem 2.5rem;">
  <button class="btn btn-success"onclick="downloadPDF()" >Concluir</button>
</div>

<span class="d-none" id="fnome"><?php //echo $ndata; ?></span>

  <script src="cdnjs/html2pdf.bundle.min.js"></script>
  <script>
    function downloadPDF() {
		document.getElementById("aguarde").style.display="block";
		var fnome = document.getElementById("fnome").innerText;

        html2pdf()
        .set({
        filename: fnome,
        margin: [1,1,0,1],
        html2canvas: {
        scale: 2,
        }
        }).from(document.querySelector(".Content")).save();

        }

  </script> -->

  <script>
        function showExportar() {
            document.getElementById('Exportar').classList.remove('d-none');
        }
        
        function hideExportar() {
            document.getElementById('Exportar').classList.add('d-none');
        }
    </script>
</body>
</html>