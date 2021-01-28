<?php 
  require_once("validador_acesso.php");
  $acao = 'recuperar';
  require 'card_controller.php';

  $id_usu = $_SESSION['id'];
  $usuario = $_SESSION['nome'];

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="css/bootstrap.min.css" />

  <!-- FONTAWESOME -->
  <link href="fontawesome/css/all.css" rel="stylesheet" />

  <link rel="stylesheet" type="text/css" href="./css/style.css" />
  <script type="text/javascript">
  function edita(id) {
    location.href = 'registro.php?acao=edita&id=' + id
  }
  </script>
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

  <title>Carteira Virtual</title>
</head>

<body>
  <div id="header">
  <div id="aside">
      <!-- <h4>Carteira Virtual</h4> -->
      <nav class="navbar navbar-default prioridade" role="navigation">
        <div class="container-fluid navbar-header">
          <div class="add">
          
          <nav id="links-menu" class="collapse navbar-collapse">
            <ul class="menu ml-4 nav justify-content-end">
              <li class="nav-item"><a href="./home.php"><i class="fas fa-chart-pie"></i> Dashboard</a></li>
              <li class="nav-item"><a href="./novo_registro.php"><i class="fas fa-edit"></i> Novo registro</a></li>
              <li class="nav-item"><a href="./entradas.php?ev=1&re=1"><i class="fas fa-sign-in-alt"></i> Entradas</a></li>
              <li class="nav-item"><a href="./saidas.php?ev=1&re=1"><i class="fas fa-sign-out-alt"></i> Saídas</a></li>
              <li class="nav-item"><a href="./card_controller.php?acao=sair"><i class="fas fa-times-circle"></i> Sair</a></li>
              
              <div class="toogle mt-4">
                <h6>Light</h6>
                <input type="checkbox" class="checkbox" id="checkbox" />
                <label for="checkbox" class="label">
                  <i class="fas fa-power-off" id="off"></i>
                  <i class="fas fa-power-off"></i>
                  <div class="ball"></div>
                </label>
                <h6>Dark</h6>
              </div>
              
            </ul>
          </nav>
          <button type="button" aria-expanded="true" class="navbar-toggle botaoNav" data-toggle="collapse" data-target="#links-menu">
            <i class="material-icons">menu</i>
          </button>
          <div class="labelPlus">
            <a class="plus" id="plus" href="./novo_registro.php"><i class="fas fa-plus-square fa-2x"></i></a>
            <a class="plus" id="plus" href="./novo_registro.php"><label class="labeladd" >novo registro</label></a>
          </div>
          </div>
        </div>
      </nav>
    </div>
    <div class="usuname">
      <div id="ola">
        <h6>Olá,</h6>
        <div class="emoji"></div>
        <script>
        // EMOJI
        const imgEmogi = document.querySelector('.emoji')

        const emojis = [' 😁', ' 🤑', ' 🙂', ' 🤭', ' 🧐', ' 😮', ' 😝', ' 😜', ' 😛']

        const emoji = () => {
          const indice = Math.floor(Math.random() * emojis.length);
          return emojis[indice]
        }

        imgEmogi.innerHTML = emoji()
        </script>

      </div>
      <h3><?php echo $usuario ?></h3>
    </div>
  </div>



  <div id="content">
    <div class="ContentHeader">
      <form class="mesAno" name="formSelect" id="formSelect" action="card_controller.php?p=d&acao=filtrar"
        method="POST">

        <h2 class="titleDash">Dashboard</h2>

        <div id="selects">

          <select id="meses" class="inputInd selecao" name="meses">
            <option value="">Mês</option>
            <option value="01">Jan</option>
            <option value="02">Fev</option>
            <option value="03">Mar</option>
            <option value="04">Abr</option>
            <option value="05">Mai</option>
            <option value="06">Jun</option>
            <option value="07">Jul</option>
            <option value="08">Ago</option>
            <option value="09">Set</option>
            <option value="10">Out</option>
            <option value="11">Nov</option>
            <option value="12">Dez</option>
          </select>
          <select class="inputInd selecao" name="anos">
            <option value="">Ano</option>
            <?php 
            $dataArray[] = '';
            foreach($cards as $select => $option){ 
              $dataSelect = array_push($dataArray,substr($option->data_cadastro, 0, 4));
              sort($dataArray);
              
            }
            $data = array_unique($dataArray); 

            foreach($data as $value){
            if($value != ''){
            ?>
            <option value="<?php echo $value ?>" id="anos"><?php echo $value ?></option>
            <?php 
            }
            
            }
            ?>

            
          </select>
          <button id="but_salvar" class="inputInd btn btn-success selecao">Filtrar</button>

        </div>

      </form>
    </div>


    <?php
      $freqEntradaRecorrente = 0;
      $freqEntradaEventual = 0;
    
      $freqSaidaRecorrente = 0;
      $freqSaidaEventual = 0;

      $Entrada = 0;
      $Saida = 0;
      $total = 0;

      if(isset($_GET['filtrar'])){
        foreach($cards as $indice => $card) {
          if (preg_match("/{$_GET['filtrar']}/",$card->data_cadastro)) {
            $data_cadastro = $card->data_cadastro;
            
            $tipo = $card->tipo;
            $valor = $card->valor;
            $tipo == 'Entrada' ? $Entrada += $valor : $Saida += $valor;

            $frequencia = $card->frequencia;

            if($tipo == 'Entrada'){
              if($frequencia == 'Recorrente'){
                $freqEntradaRecorrente++;
              }
              if($frequencia == 'Eventual'){
                $freqEntradaEventual++;
              }
            }
            if($tipo == 'Saída'){
              if($frequencia == 'Recorrente'){
                $freqSaidaRecorrente++;
              }
              if($frequencia == 'Eventual'){
                $freqSaidaEventual++;
              }
            }


          }
          $total = $Entrada - $Saida;
        } 
      }else{
        foreach($cards as $indice => $card) {
          $data_cadastro = $card->data_cadastro;
          
          $tipo = $card->tipo;
          $valor = $card->valor;
          $tipo == 'Entrada' ? $Entrada += $valor : $Saida += $valor;


          $frequencia = $card->frequencia;

          if($tipo == 'Entrada'){
            if($frequencia == 'Recorrente'){
              $freqEntradaRecorrente++;
            }
            if($frequencia == 'Eventual'){
              $freqEntradaEventual++;
            }
          }
          if($tipo == 'Saída'){
            if($frequencia == 'Recorrente'){
              $freqSaidaRecorrente++;
            }
            if($frequencia == 'Eventual'){
              $freqSaidaEventual++;
            }
          }
        }
        $total = $Entrada - $Saida;
      }
    ?>
          <div class="containerWallet">
            <div class="walletBox dollar">
              <span>Saldo</span>
              <h1>
                <strong><div class="sifrao">R$</div> <?php echo number_format($total, 2, ',', '.'); ?></strong>
              </h1>
              <small>Atualizado com base nas entradas e saídas</small>
              <img src="img/dollar.svg" />
            </div>

            <div class="walletBox up">
              <span>Entradas</span>
              <h1>
                <strong><div class="sifrao">R$</div> <?php echo number_format($Entrada, 2, ',', '.'); ?></strong>
              </h1>
              <small>Atualizado com base nas entradas e saídas</small>
              <img src="img/arrow-up.svg" />
            </div>

            <div class="walletBox down">
              <span>Saídas</span>
              <h1>
                <strong><div class="sifrao">R$</div> <?php echo number_format($Saida, 2, ',', '.');  ?></strong>
              </h1>
              <small>Atualizado com base nas entradas e saídas</small>
              <img src="img/arrow-down.svg" />
            </div>
          </div>
          <?php 
            $titulo = '';
            $descricao = '';
            $footerDescription = '';
            $icon = '';
            if(number_format($total) == 0 && number_format($Entrada) == 0 && number_format($Saida) == 0){
              $titulo = 'Hmmm...';
              $descricao = 'Parece que você ainda não possui nenhum registro de atividades!';
              $footerDescription = 'Não esqueça de registrar o dinheiro que entra e sai!';
              $icon = 'happy';
            }else if(number_format($total) < 0){
              $titulo = 'Que triste!';
              $descricao = 'Neste mês, você gastou mais do que deveira.';
              $footerDescription = 'Cuidado com seus gastos, tente cortar algumas coisas desnecesárias!';
              $icon = 'sad';
            }else if(number_format($total) == 0){
              $titulo = 'Ufaa!';
              $descricao = 'Neste mês, você gastou exatamente a quantia que recebeu.';
              $footerDescription = 'Bateu na trave, é sábio fazer economias para momentos realmente necessários!';
              $icon = 'shocked';
            }else if(number_format($total) > 0){
              $titulo = 'Muito bom!!';
              $descricao = 'Sua carteira está positiva neste momento! Busque sempre deixa-la positiva!';
              $footerDescription = 'Continue assim! Considere investir seu saldo!';
              $icon = 'happy';
            }
            $entrada = (float)$Entrada;
            $saida = (float)$Saida;
            $totalidade = (($entrada + $saida) !== 0 ? $entrada + $saida : 1);
            $porcentagemEntrada = @((($entrada * 100)/$totalidade) > 0 ? round(($entrada * 100)/$totalidade, 1) : 0);
            $porcentagemSaida = @((($saida * 100)/$totalidade) > 0 ? round(($saida * 100)/$totalidade, 1) : 0);
          ?>
            <div class="containerGraf">
              <div class="MenssageBox">
                <header>
                  <h1 class="orientation">
                    <div class="h1titulo"><?php echo "$titulo" ?></div>
                    <img src="img/<?php echo $icon?>.svg" />
                  </h1>
                  <small><p><b><?php echo $descricao ?></b></p></small>
                </header>
                <footer>
                  <span><?php echo $footerDescription ?></span>
                </footer>
              </div>

              <div class="PieChartBox">
                <div class="SideLeft">
                  <h2>Relação</h2>
                  <div class="legenda">
                    
                    <div class="legendaPalavra">
                      <div class="quadrado verde">
                        <div><?php echo $porcentagemEntrada ?>%</div>
                      </div>
                      <span>Entrada</span>
                    </div>
                    
                    <div class="legendaPalavra">
                      <div class="quadrado vermelho">
                        <div><?php echo $porcentagemSaida ?>%</div>
                      </div>
                      <span>Saída</span>
                    </div>
                  </div>
                </div>
                <div class="SideRight">
                  <canvas id="SideRight"></canvas>
                </div>
              </div>
            </div>

            <div class="historyBox">
              <div class="historyLegenda">
                <h2>Total Anual</h2>
              </div>
              <div class="historyGrafico" id="historyGrafico">
                <canvas class="line-chart" ></canvas>
              </div>
            </div>

            <div class="containerGraf">

              <div class="barChartBox">
                <h2>Entradas</h2>
                <div class="barraDireita">
                  <canvas id="barra1" class="barra"></canvas>
                </div>
              </div>
              

              <div class="barChartBox">
                <h2>Saídas</h2>
                <div class="barraDireita">
                  <canvas id="barra2" class="barra"></canvas>
                </div>
              </div>

            </div>

  <!-- Optional JavaScript -->
  <!-- <script> -->
  <script type="text/javascript" src="js/jquery-3.5.1.min.js"></script>

  <!-- THEME -->
  <script>
    const checkbox = document.querySelector('#checkbox')
    let theme = localStorage.getItem('@theme')

    const themeLight = () => {
      checkbox.checked = false
      document.body.classList.add('light')
      document.body.classList.remove('dark')
      localStorage.setItem('@theme', 'light')
    }

    const themeDark = () => {
      checkbox.checked = true
      document.body.classList.add('dark')
      document.body.classList.remove('light')
      localStorage.setItem('@theme', 'dark')
    }

    if (theme === 'light') {
      themeLight();
    } else if (theme === 'dark') {
      themeDark()
    }

    checkbox.addEventListener('change', () => {
      //encontra o tema no corpo
      theme = localStorage.getItem('@theme')
      if (theme === 'light' || theme === null) {
        localStorage.setItem('@theme', 'dark')
      } else {
        localStorage.setItem('@theme', 'light')
      }
      document.body.classList.toggle('dark')
      console.log('func')
    })
  </script>
  <!-- FIM THEME -->

  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>
    <script type="text/javascript">

      var piec = document.getElementById('SideRight') 

      var myPieChart = new Chart(piec, {
        type: 'pie',
        data: {
          labels: ['Entrada', 'Saída'],
          datasets: [{
            data: [<?php echo $porcentagemEntrada ?>, <?php echo $porcentagemSaida ?>],
            backgroundColor: ['#7ba030', '#dd3737'],
            borderWidth: 1,
          }],
        },
        options: {
          legend: {
            display: false,
          },
          aspectRatio: 1
        }
      })



      </script>
  
<?php

  $anoCorrente =  isset($_GET['filtrar']) ? substr($_GET['filtrar'], 0, 4) : date('Y');
  $MesEntrada = [0,'01'=> 0,'02'=> 0,'03'=> 0,'04'=> 0,'05'=> 0,'06'=> 0,'07'=> 0,'08'=> 0,'09'=> 0,'10'=> 0,'11'=> 0,'12'=> 0];
  $MesSaida = [0,'01'=> 0,'02'=> 0,'03'=> 0,'04'=> 0,'05'=> 0,'06'=> 0,'07'=> 0,'08'=> 0,'09'=> 0,'10'=> 0,'11'=> 0,'12'=> 0];
  for($i = 1; $i <= 12; $i++){
    if($i <= 9) $i = '0'.$i; 


    foreach($graficos as $ind => $grafico) {
      $data_cadastro2 = $grafico->data_cadastro;
      $tipo2 = $grafico->tipo;
      $valor2 = $grafico->valor;
      
      if($tipo2 == 'Entrada' && substr($data_cadastro2, 0, -3) == $anoCorrente.'-'.$i){
        $MesEntrada[$i] += $valor2;
      }else if($tipo2 == 'Saída' && substr($data_cadastro2, 0, -3) == $anoCorrente.'-'.$i){
        $MesSaida[$i] += $valor2;
      }
    }
  }



?>


    <script>
      var ctx = document.getElementsByClassName('line-chart')

      // type, data e options
      var chartGraph = new Chart(ctx, {
        type: 'line',
        data: {
          labels: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Aut', 'Nov', 'Dez',],
          datasets: [{
            label: "Entrada",
            data: [
              <?php echo $MesEntrada['01'] ?>,
              <?php echo $MesEntrada['02'] ?>, 
              <?php echo $MesEntrada['03'] ?>,
              <?php echo $MesEntrada['04'] ?>,
              <?php echo $MesEntrada['05'] ?>, 
              <?php echo $MesEntrada['06'] ?>, 
              <?php echo $MesEntrada['07'] ?>, 
              <?php echo $MesEntrada['08'] ?>, 
              <?php echo $MesEntrada['09'] ?>,
              <?php echo $MesEntrada['10'] ?>, 
              <?php echo $MesEntrada['11'] ?>, 
              <?php echo $MesEntrada['12'] ?>
            ],
            borderWidth: 5,
            borderColor: '#7ba030',
            backgroundColor: 'transparent',
          },
          {
            label: "Saída",
            data: [
              <?php echo $MesSaida['01'] ?>,
              <?php echo $MesSaida['02'] ?>, 
              <?php echo $MesSaida['03'] ?>,
              <?php echo $MesSaida['04'] ?>,
              <?php echo $MesSaida['05'] ?>, 
              <?php echo $MesSaida['06'] ?>, 
              <?php echo $MesSaida['07'] ?>, 
              <?php echo $MesSaida['08'] ?>, 
              <?php echo $MesSaida['09'] ?>,
              <?php echo $MesSaida['10'] ?>, 
              <?php echo $MesSaida['11'] ?>, 
              <?php echo $MesSaida['12'] ?>
            ],
            borderWidth: 5,
            borderColor: '#dd3737',
            backgroundColor: 'transparent',
          }]
        },
        options: {
          scales: {
            yAxes: [{
                ticks: {
                    // Include a dollar sign in the ticks
                    callback: function(value, index, values) {
                        return 'R$' + value;
                    }
                }
            }]
          }
        }
      })

      var barra1 = document.getElementById('barra1')

      var myBarChart = new Chart(barra1, {
        type: 'bar',
        data: {
          labels: ['Recorrente', 'Eventual'],
          datasets: [{
            data: [<?php echo $freqEntradaRecorrente ?>, <?php echo $freqEntradaEventual ?>],
            backgroundColor: ['#7ba030', '#dd3737'],
            borderWidth: 1,
          }],
        },
        options: {
          title: 'Entradas',
          scales: {
            yAxes: [{
              ticks: {
                beginAtZero: true
              }
            }]
          },
          legend: {
            display: false,
          },
        }
      })



      var barra2 = document.getElementById('barra2')

      var myBarChart = new Chart(barra2, {
        type: 'bar',
        data: {
          labels: ['Recorrente', 'Eventual'],
          datasets: [{
            data: [<?php echo $freqSaidaRecorrente ?>, <?php echo $freqSaidaEventual ?>],
            backgroundColor: ['#7ba030', '#dd3737'],
            borderWidth: 1,
          }],
        },
        options: {
          scales: {
            yAxes: [{
              ticks: {
                beginAtZero: true
              }
            }]
          },
          legend: {
            display: false,
          },
        }
      })
    </script>




  


  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
    integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous">
  </script>
  <script src="js/bootstrap.min.js"></script>

  
</body>

</html>