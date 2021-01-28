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
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1, shrink-to-fit=no"
    />

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css" />

    <!-- FONTAWESOME -->
    <link href="fontawesome/css/all.css" rel="stylesheet" />

    <link rel="stylesheet" type="text/css" href="./css/style.css" />
    <script type="text/javascript">

    function edita(id){
      location.href = 'registro.php?ex=1&acao=edita&id='+id
    }
    
      function setTwoNumberDecimal(event) {
    this.value = parseFloat(this.value).toFixed(2);
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
      
            const emoji = () =>{
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
    <h2 id="tituloContent">Entradas</h2>

      <div class="ContentHeader">
        <form class="mesAno row flex-column-reverse flex-md-row ml-1" name="formSelect" id="formSelect" action="card_controller.php?p=e&acao=filtrar" method="POST">
          
          
          <div class="eleFiltro">
            <div class="filtro">
              <div>
                <input type="checkbox" name="recorrente" class="bnt_filtro" id="recorre" onclick="recapagar()"/>
                <label for="recorre" id="rec">Recorrente</label>
              </div>
              <div>
                <input type="checkbox" name="eventual" class="bnt_filtro" id="event" onclick="eveapagar()"/>
                <label for="event" id="eve">Eventual</label>
              </div>
            </div>
          </div>



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
      $eventual = $_GET['ev'];
      $recorrente = $_GET['re'];
      foreach($cards as $indice => $card) { 
        
        if($eventual === '0' && $recorrente === '0' || $eventual === '1' && $recorrente === '1') {
        
          if(isset($_GET['filtrar'])){
            
            if (preg_match("/{$_GET['filtrar']}/",$card->data_cadastro)) {
              if($card->tipo == 'Entrada') {?>
                  
                <div>
                  <div onclick="edita(<?php echo $card->id ?>)" class="moneyCard <?php 
                        if($card->frequencia == 'Recorrente') {
                          echo 'recorrente';
                        } else {
                          echo 'eventual';
                        }
                      ?>">
  
                    <div class="cardFynance">
  
                      <div class="tag <?php 
                          if($card->frequencia == 'Recorrente') {
                            echo 'recorrente';
                          } else {
                            echo 'eventual';
                          }
                        ?>"></div>
  
                      <div class="info">
                        <h5><?php echo $card->titulo ?></h5>
                        <p class="data"><?php echo date('d/m/Y', strtotime($card->data_cadastro)); ?></p>
                      </div>
                    </div>
                    <div>
                      <small class="descricao"><?php echo $card->descricao ?></small>
                    </div>
                    <h4 class="money"><?php echo "R$ ". number_format($card->valor, 2, ',', '.'); ?></h4>
                  </div>
                </div>
              
          <?php 
              } 
            } 
          }
          else {
            if($card->tipo == 'Entrada') {?>
                  
                <div>
                  <div onclick="edita(<?php echo $card->id ?>)" class="moneyCard" id="<?php 
                        if($card->frequencia == 'Recorrente') {
                          echo 'recorrente';
                        } else {
                          echo 'eventual';
                        }
                      ?>">
                    <div class="cardFynance">
  
                      <div class="tag <?php 
                        if($card->frequencia == 'Recorrente') {
                          echo 'recorrente';
                        } else {
                          echo 'eventual';
                        }
                      ?>"></div>
                      <div class="info">
                        <h5><?php echo $card->titulo ?></h5>
                        <p class="data"><?php echo date('d/m/Y', strtotime($card->data_cadastro)); ?></p>
                      </div>
                    </div>
                    <div>
                      <small class="descricao"><?php echo $card->descricao ?></small>
                    </div>
                    <h4 class="money"><?php echo "R$ ". number_format($card->valor, 2, ',', '.'); ?></h4>
                  </div>
            </div>
        <?php
            }
          }
        }
        
        
        else if($eventual === '1' && $recorrente === '0') {
          if($card->frequencia == 'Recorrente') {
            continue;
          }else {
            if(isset($_GET['filtrar'])){
              
              if (preg_match("/{$_GET['filtrar']}/",$card->data_cadastro)) {
                if($card->tipo == 'Entrada') {?>
                    
                  <div>
                    <div class="moneyCard <?php 
                          if($card->frequencia == 'Recorrente') {
                            echo 'recorrente';
                          } else {
                            echo 'eventual';
                          }
                        ?>">
    
                      <div class="cardFynance">
    
                        <div class="tag <?php 
                            if($card->frequencia == 'Recorrente') {
                              echo 'recorrente';
                            } else {
                              echo 'eventual';
                            }
                          ?>"></div>
    
                        <div class="info">
                          <h5><?php echo $card->titulo ?></h5>
                          <p class="data"><?php echo date('d/m/Y', strtotime($card->data_cadastro)); ?></p>
                        </div>
                      </div>
                      <div>
                        <small class="descricao"><?php echo $card->descricao ?></small>
                      </div>
                      <h4 class="money"><?php echo "R$ ". number_format($card->valor, 2, ',', '.'); ?></h4>
                    </divhref=>
                  </div>
                
            <?php 
                } 
              } 
            }
            else {
              if($card->tipo == 'Entrada') {?>
                    
                <div>
                  <div class="moneyCard" id="<?php 
                        if($card->frequencia == 'Recorrente') {
                          echo 'recorrente';
                        } else {
                          echo 'eventual';
                        }
                      ?>">
                    <div class="cardFynance">
  
                      <div class="tag <?php 
                        if($card->frequencia == 'Recorrente') {
                          echo 'recorrente';
                        } else {
                          echo 'eventual';
                        }
                      ?>"></div>
                      <div class="info">
                        <h5><?php echo $card->titulo ?></h5>
                        <p class="data"><?php echo date('d/m/Y', strtotime($card->data_cadastro)); ?></p>
                      </div>
                    </div>
                    <div>
                      <small class="descricao"><?php echo $card->descricao ?></small>
                    </div>
                    <h4 class="money"><?php echo "R$ ". number_format($card->valor, 2, ',', '.'); ?></h4>
                  </divhref=>
                </div>
          <?php
              }
            }
          }
        }
        
        
        else if($eventual === '0' && $recorrente === '1') {
            if($card->frequencia == 'Eventual') {
              continue;
            }else {
              if(isset($_GET['filtrar'])){
                
                if (preg_match("/{$_GET['filtrar']}/",$card->data_cadastro)) {
                  if($card->tipo == 'Entrada') {?>
                      
                    <div>
                      <div class="moneyCard <?php 
                            if($card->frequencia == 'Recorrente') {
                              echo 'recorrente';
                            } else {
                              echo 'eventual';
                            }
                          ?>">
      
                        <div class="cardFynance">
      
                          <div class="tag <?php 
                              if($card->frequencia == 'Recorrente') {
                                echo 'recorrente';
                              } else {
                                echo 'eventual';
                              }
                            ?>"></div>
      
                          <div class="info">
                            <h5><?php echo $card->titulo ?></h5>
                            <p class="data"><?php echo date('d/m/Y', strtotime($card->data_cadastro)); ?></p>
                          </div>
                        </div>
                        <div>
                          <small class="descricao"><?php echo $card->descricao ?></small>
                        </div>
                        <h4 class="money"><?php echo "R$ ". number_format($card->valor, 2, ',', '.'); ?></h4>
                      </divref=>
                    </div>
                  
              <?php 
                  } 
                } 
              }
              else {
                if($card->tipo == 'Entrada') {?>
                      
                    <div>
                      <div class="moneyCard" id="<?php 
                            if($card->frequencia == 'Recorrente') {
                              echo 'recorrente';
                            } else {
                              echo 'eventual';
                            }
                          ?>">
                        <div class="cardFynance">
      
                          <div class="tag <?php 
                            if($card->frequencia == 'Recorrente') {
                              echo 'recorrente';
                            } else {
                              echo 'eventual';
                            }
                          ?>"></div>
                          <div class="info">
                            <h5><?php echo $card->titulo ?></h5>
                            <p class="data"><?php echo date('d/m/Y', strtotime($card->data_cadastro)); ?></p>
                          </div>
                        </div>
                        <div>
                          <small class="descricao"><?php echo $card->descricao ?></small>
                        </div>
                        <h4 class="money"><?php echo "R$ ". number_format($card->valor, 2, ',', '.'); ?></h4>
                      </div>
                </div>
              <?php
                  }
                }
              }
            }
      }
      ?>

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

      if(theme === 'light') {
        themeLight();
      } else if(theme === 'dark') {
        themeDark()
      }

      checkbox.addEventListener('change', () => {
        //encontra o tema no corpo
        theme = localStorage.getItem('@theme')
        if(theme === 'light' || theme === null){
          localStorage.setItem('@theme', 'dark')
        } else {
          localStorage.setItem('@theme', 'light')
        }
        document.body.classList.toggle('dark')
        console.log('func')
      })
    </script>
    <!-- FIM THEME -->
    
    <!-- RECORRENTE E EVENTUAL -->
    <script>
      //selecionar recorrente
      const recorren = document.getElementById('recorre')

      const evente = document.querySelector('#event')

      const labelRecorrente = document.getElementById('rec')
      const labelEventual = document.getElementById('eve')
      

      function recapagar() {
        if(recorren.checked === true) {
          labelRecorrente.style.transition = 'border .2s linear, opacity .2s linear'
          labelRecorrente.style.borderBottom = '8px solid var(--success-color)'
          labelRecorrente.style.opacity = '1'
        }else{
          labelRecorrente.style.transition = 'border .2s linear, opacity .2s linear'
          labelRecorrente.style.borderBottom = ''
          labelRecorrente.style.opacity = '.6'
        }
      }
      function eveapagar() {
        if(evente.checked === true) {
          labelEventual.style.transition = 'border .2s linear, opacity .2s linear'
          labelEventual.style.borderBottom = '8px solid var(--danger-color)'
          labelEventual.style.opacity = '1'
        }else{
          labelEventual.style.transition = 'border .2s linear, opacity .2s linear'
          labelEventual.style.borderBottom = ''
          labelEventual.style.opacity = '.6'
        }
      }
      
    </script>

    <?php if($_GET['ev'] === '1') { ?>
      <script>
        evente.checked = true
        eveapagar()
      </script>
    <?php } if($_GET['re'] === '1') {?>
      <script>
        recorren.checked = true
        recapagar()
      </script>
    <?php } ?>
    <!-- FIM RECORRENTE E EVENTUAL -->

    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script
      src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
      integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN"
      crossorigin="anonymous"
    ></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
