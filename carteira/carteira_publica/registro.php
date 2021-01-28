<?php 
  require_once("validador_acesso.php");
  $acao = 'recuperar';
  require 'card_controller.php';

  $id_usu = $_SESSION['id'];
  $usuario = $_SESSION['nome'];
?>
<!doctype html>
<html lang="pt-br">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">

    <!-- FONTAWESOME -->
    <link href="fontawesome/css/all.css" rel="stylesheet">
    
    
    <link rel="stylesheet" type="text/css" href="./css/style.css">
    
    <script>
      function remover(id, ex){
          location.href = 'entradas.php?acao=remover'+ex+'&id='+id
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
    </div>
    <h3><?php echo $usuario ?></h3>
  </div>
</div>


<div id="content">
  <div class="CabecalhoAtualizar">
    <h2>Atualizar registro</h2>
    <div class="divExcluir">
      <label for="excluir" class="text-danger excluir" onclick="remover(<?php echo $cards[0]->id.','. $_GET['ex'] ?>)">Excluir</label>
      <i class="fas fa-trash-alt fa-lg text-danger" id="excluir" onclick="remover(<?php echo $cards[0]->id.','. $_GET['ex'] ?>)"></i>
    </div>
  </div>
  <?php
    if(isset($_GET['a']) && $_GET['a'] == '1'){
  ?>
  <div class="alert alert-info mx-auto" role="alert">
    Atualização realizada com sucesso!
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
  </div>
  <?php 
    }
  ?>

  <div class="formulario">
    <form class="form registro" action="card_controller.php?acao=atualizar" method="POST">
      <div>
        Título <input value="<?php echo $cards[0]->titulo ?>" type="text" name="titulo" id="titulo" required>
      </div>

      <input type="hidden" name="id" value="<?php echo $cards[0]->id ?>">
        
      <div class="conjInput">
        <div class="inputInd1 ind">
          Tipo <select name="tipo" id="tipo">
            <option <?php echo ($cards[0]->tipo == 'Entrada') ? 'selected' : ''; ?> >Entrada</option>
            <option <?php echo ($cards[0]->tipo == 'Saída') ? 'selected' : ''; ?> >Saída</option>
          </select>
        </div>
  
        <div class="inputInd ind">
          Data <input value="<?php echo $cards[0]->data_cadastro ?>" type="date" name="data_cadastro" id="data" required>
        </div>
  
        <div class="inputInd ind">
          Frequência <select name="frequencia" id="frequencia">
          <option <?php echo ($cards[0]->frequencia == 'Recorrente') ? 'selected' : ''; ?> >Recorrente</option>
          <option <?php echo ($cards[0]->frequencia == 'Eventual') ? 'selected' : ''; ?> >Eventual</option>
          </select>
        </div>
  
        <div class="inputInd4 ind">
          Valor <input  value="<?php echo $cards[0]->valor ?>"  type="number" placeholder="0.00" name="valor" min="0" step=".01" id="valor" required onchange="setTwoNumberDecimal">
        </div>
      </div>

      <div>
        Descrição <textarea name="descricao" id="descricao" cols="10" rows="5" maxlength="255"><?php echo $cards[0]->descricao ?></textarea>
      </div>

      <div class="botao">
        <input type="submit" value="Atualizar" id="botao">
      </div>
    </form>

  </div>
</div>


    <!-- Optional JavaScript -->
    <!-- <script> -->

    <script src="js/main.js"></script>
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>