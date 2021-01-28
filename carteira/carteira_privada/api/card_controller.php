<?php 

  require "../carteira_privada/api/CardMoney.model.php";
  require "../carteira_privada/api/CardMoney.service.php";
  require "../carteira_privada/api/conexao.php";

  $acao = isset($_GET['acao']) ? $_GET['acao'] : $acao;

  if($acao == 'inserir'){

    $cardMoney = new CardMoney();
    $cardMoney->__set('titulo', $_POST['titulo']);
    $cardMoney->__set('tipo', $_POST['tipo']);
    $cardMoney->__set('data_cadastro', $_POST['data_cadastro']);
    $cardMoney->__set('frequencia', $_POST['frequencia']);
    $cardMoney->__set('valor', $_POST['valor']);
    $cardMoney->__set('descricao', $_POST['descricao']);
  
    $conexao = new Conexao();
  
    $cardService = new CardService($conexao, $cardMoney);
    echo $valor;
    $cardService->inserir();
  
    header('Location: novo_registro.php?cadastro=1');
  }else if($acao == 'recuperar'){

    $conexao = new Conexao();
    $cardMoney = new CardMoney();
    
    $cardService = new CardService($conexao, $cardMoney);
    $cards = $cardService->recuperar();
    $graficos = $cardService->recuperar();

  }else if($acao == 'filtrar'){
    
    $cardMoney = new CardMoney();
    
    $cardMoney->__set('meses', $_POST['meses']);
    $cardMoney->__set('anos', $_POST['anos']);
    $cardMoney->__set('recorrente', $_POST['recorrente']);
    $cardMoney->__set('eventual', $_POST['eventual']);

    $conexao = new Conexao();

    $cardService = new CardService($conexao, $cardMoney);
    
    $cards = $cardService->filtrar();
    $eve = '';
    $rec = '';
    $_POST['eventual'] == 'on' ? $eve = '1' : $eve = '0';

    $_POST['recorrente'] == 'on' ? $rec = '1' : $rec = '0';
    
    if($_GET['p'] == 'e'){
      if($_POST['meses'] == '' || $_POST['anos'] == '') {
        header('Location: entradas.php?ev='.$eve.'&re='.$rec);
      }else{
        header('Location: entradas.php?filtrar='.$_POST['anos'].'-'.$_POST['meses'].'&'.'ev='.$eve.'&re='.$rec);
      }
    }else if($_GET['p'] == 's'){
      if($_POST['meses'] == '' || $_POST['anos'] == '') {
        header('Location: saidas.php?ev='.$eve.'&re='.$rec);
      }else{
        header('Location: saidas.php?filtrar='.$_POST['anos'].'-'.$_POST['meses'].'&'.'ev='.$eve.'&re='.$rec);
      }
    }else if($_GET['p'] == 'd'){
      if($_POST['meses'] == '' || $_POST['anos'] == '') {
        header('Location: home.php');
      }else{
        header('Location: home.php?filtrar='.$_POST['anos'].'-'.$_POST['meses']);
      }
    }
    
  }else if($acao == 'edita'){
    $cardMoney = new CardMoney();
    $cardMoney->__set('id', $_GET['id']);
  
    $conexao = new Conexao();
  
    $cardService = new CardService($conexao, $cardMoney);
    $cards = $cardService->editar();
    print_r($cards);
    
  }else if($acao == 'atualizar'){

    $cardMoney = new CardMoney();
    $cardMoney->__set('id', $_POST['id']);
    $cardMoney->__set('titulo', $_POST['titulo']);
    $cardMoney->__set('tipo', $_POST['tipo']);
    $cardMoney->__set('data_cadastro', $_POST['data_cadastro']);
    $cardMoney->__set('frequencia', $_POST['frequencia']);
    $cardMoney->__set('valor', $_POST['valor']);
    $cardMoney->__set('descricao', $_POST['descricao']);
  
    $conexao = new Conexao();
  
    $cardService = new CardService($conexao, $cardMoney);
    $cardService->atualizar();

  
    header('Location: registro.php?a=1&acao=edita&id='.$_POST['id']);
  }else if($acao == 'remover1'){

    $cardMoney = new CardMoney();
    $cardMoney->__set('id', $_GET['id']);

    $conexao = new Conexao();
  
    $cardService = new CardService($conexao, $cardMoney);
    $cardService->remover();    

    header('Location: entradas.php?ev=1&re=1');
  }else if($acao == 'remover2'){

    $cardMoney = new CardMoney();
    $cardMoney->__set('id', $_GET['id']);

    $conexao = new Conexao();
  
    $cardService = new CardService($conexao, $cardMoney);
    $cardService->remover();    

    header('Location: saidas.php?ev=1&re=1');
  }else if($acao == 'cadastro'){

    $cardMoney = new CardMoney();
    $cardMoney->__set('email', $_POST['email']);
    $cardMoney->__set('nome', $_POST['nome']);
    $cardMoney->__set('senha', $_POST['senha']);

  
    $conexao = new Conexao();
  
    $cardService = new CardService($conexao, $cardMoney);
    $lista = $cardService->recuperarCadastro();

    foreach($lista as $indice => $pessoa) {
      if($_POST['email'] == $pessoa->email){
        header('Location: cadastro.php?e=1');
        exit;
      }
      if($_POST['nome'] == $pessoa->nome){
        header('Location: cadastro.php?n=1');
        exit;
      }
    }

    $cardService->cadastrar();
    header('Location: login.php?c=1');

  }else if($acao == 'login'){

    session_start();

    $usuario_autenticado = false;
    $usuario_id = null;


    $cardMoney = new CardMoney();
    $cardMoney->__set('email', $_POST['email']);
    $cardMoney->__set('senha', $_POST['senha']);
  
    $conexao = new Conexao();
  
    $cardService = new CardService($conexao, $cardMoney);
    $lista = $cardService->recuperarCadastro();

    foreach($lista as $indice) {
      if($_POST['email'] == $indice->email && crypt($_POST['senha'],$indice->senha) == $indice->senha){
        $usuario_autenticado = true;
        $usuario_id = $indice->id;
        $usuario = $indice->nome;

        if($usuario_autenticado) {
          $_SESSION['autenticado'] = 'SIM';
          $_SESSION['id'] = $usuario_id;
          $_SESSION['nome'] = $usuario;

          header('Location: home.php');
        } 
        else {
            $_SESSION['autenticado'] = 'NAO';
            header('Location: login.php?login=erro');
        }
      }

      
    }
  }else if($acao == 'sair'){
    session_start();
    session_destroy(); 
    header('Location: index.php');
  }


?>