<?php 
  class Conexao {
    private $host = 'localhost';
    private $dbname = 'carteira';
    private $user = 'banco';
    private $pass = 'banco';

    public function conectar() {
      try {
        $conexao = new PDO(
          "mysql:host=$this->host;dbname=$this->dbname",
          "$this->user",
          "$this->pass"
        );

        return $conexao;
      } catch (PDOException $e) {
        echo '<p>'. $e->getMessage() .'<p>';
      }
    } 
  }

?>