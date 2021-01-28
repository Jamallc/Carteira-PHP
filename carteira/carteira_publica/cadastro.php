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

    <link rel="stylesheet" type="text/css" href="./css/login.css" />
    <script type="text/javascript">
      function validar() {
        let email = form.email.value;
        let nome = form.nome.value;
        let senha = form.senha.value;
        let rep_senha = form.rep_senha.value;

        if(senha.length < 8){
          alert('A senha deve ter no mínimo 8 caracteres');
          form.senha.focus();
          return false;
        }
        
        if (senha != rep_senha) {
          alert('Senhas diferentes');
          form.senha.focus();
          return false;
        }
      }
    </script>

    
    

    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

    
    <title>Carteira Virtual</title>
  </head>
  <body>
  
      <div class="direita">

      <div style="text-align: center;">
        <h1 class="cor1">Carteira Virtual</h1>
        <h6 class="cor1">Controle financeiro</h6>
      </div>
      <?php
    if(isset($_GET['e']) && $_GET['e'] == '1'){
  ?>
  <div class="alert alert-danger mx-auto aleta" role="alert">
    Email já cadastrado!
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
  </div>
  <?php 
    }
  ?>

  <?php
    if(isset($_GET['n']) && $_GET['n'] == '1'){
  ?>
  <div class="alert alert-danger mx-auto aleta" role="alert">
    Usuário já cadastrado!
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
  </div>
  <?php 
    }
  ?>

  
        <div class="cadastro card">
          <h4>Cadastro</h4>
          <form class="espaco" name="form" action="card_controller.php?acao=cadastro" method="post">
            <div>
              Email:
              <input type="text" name="email" required>
            </div>
            <div>
              Usuário:
              <input type="text" name="nome" required>
            </div>
            <div>
              Senha:
              <input type="password" name="senha" required>
            </div>
            <div>
              Confirme sua senha:
              <input type="password" name="rep_senha" required>
            </div>
            
            <input type="submit" value="Cadastrar" onclick="return validar()" id="btnCadastro" class="btn">
          </form>
        </div>
        <div><a class="log" href="login.php">Login</a></div>
      </div>
      


    <!-- Optional JavaScript -->
    <!-- <script> -->
    <script type="text/javascript" src="js/jquery-3.5.1.min.js"></script>
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script
      src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
      integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN"
      crossorigin="anonymous"
    ></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
