<?php 

//CRUD
  class CardService {

    private $conexao;
    private $cardMoney;

    public function __construct(Conexao $conexao, CardMoney $cardMoney){
      $this->conexao = $conexao->conectar();
      $this->cardMoney = $cardMoney;
    }

    public function inserir(){//CREATE
      $query = 'insert into 
        repositorio(id_usuario, titulo, tipo, data_cadastro, frequencia, valor, descricao)values(:idUso, :titulo, :tipo, :data_cadastro, :frequencia, :valor, :descricao)';
      
      $stmt=$this->conexao->prepare($query);
      $stmt->bindValue(':idUso', $_SESSION['id']);
      $stmt->bindValue(':titulo', $this->cardMoney->__get('titulo'));
      $stmt->bindValue(':tipo', $this->cardMoney->__get('tipo'));
      $stmt->bindValue(':data_cadastro', $this->cardMoney->__get('data_cadastro'));
      $stmt->bindValue(':frequencia', $this->cardMoney->__get('frequencia'));
      $stmt->bindValue(':valor', $this->cardMoney->__get('valor'));
      $stmt->bindValue(':descricao', $this->cardMoney->__get('descricao'));
      $stmt->execute();
    }

    public function recuperar(){//READ
      $query = 'select * from repositorio where id_usuario = :idUso order by data_cadastro desc';
      $stmt = $this->conexao->prepare($query);
      $stmt->bindValue(':idUso', $_SESSION['id']);
      $stmt->execute();
      return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function filtrar(){//READ
      $query = 'select * from repositorio where data_cadastro like %:dataCadastro% order by data_cadastro desc';
      $stmt = $this->conexao->prepare($query);
      $mes = $this->cardMoney->__get('meses');
      $ano = $this->cardMoney->__get('anos');
      $dataCadastro = $ano.'-'.$mes;
      $stmt->bindValue(':dataCadastro', $dataCadastro);
      $stmt->execute();
      return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function atualizar(){//UPDATE
      $query = "update
        repositorio set
          titulo = :titulo, tipo = :tipo, data_cadastro = :data_cadastro, 
          frequencia = :frequencia, valor = :valor, descricao = :descricao
        where id = :id";
      
      $stmt=$this->conexao->prepare($query);
      $stmt->bindValue(':id', $this->cardMoney->__get('id'));
      $stmt->bindValue(':titulo', $this->cardMoney->__get('titulo'));
      $stmt->bindValue(':tipo', $this->cardMoney->__get('tipo'));
      $stmt->bindValue(':data_cadastro', $this->cardMoney->__get('data_cadastro'));
      $stmt->bindValue(':frequencia', $this->cardMoney->__get('frequencia'));
      $stmt->bindValue(':valor', $this->cardMoney->__get('valor'));
      $stmt->bindValue(':descricao', $this->cardMoney->__get('descricao'));
      return $stmt->execute();

    }

    public function remover(){//DELETE
      $query = 'delete from repositorio where id = :id';
      $stmt = $this->conexao->prepare($query);
      $stmt->bindValue(':id', $this->cardMoney->__get('id'));
      $stmt->execute();
    }

    public function editar(){
      $query = 'select * from repositorio where id = :id';
      $stmt = $this->conexao->prepare($query); 
      $stmt->bindValue(':id', $this->cardMoney->__get('id'));
      $stmt->execute();
      return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function cadastrar(){//CREATE
      $query = 'insert into 
        usuario(nome, email, senha)values(:nome, :email, :senha)';
      
      $stmt=$this->conexao->prepare($query);
      $stmt->bindValue(':nome',  ucwords($this->cardMoney->__get('nome')));
      $stmt->bindValue(':email', $this->cardMoney->__get('email'));
      $stmt->bindValue(':senha', crypt($this->cardMoney->__get('senha')));
      $stmt->execute();
    }

    public function recuperarCadastro(){//READ
      $query = 'select * from usuario';
      $stmt = $this->conexao->prepare($query);
      $stmt->execute();
      return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
  }

?>

