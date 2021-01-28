<?php 
//TAREFA
class CardMoney {
  private $id;
  private $titulo;
  private $tipo;
  private $data_cadastro;
  private $frequencia;
  private $valor;
  private $descricao;

  public function __get($atributo) {
    return $this->$atributo;
  }

  public function __set($atributo, $valor) {
    $this->$atributo = $valor;
  }
}

?>