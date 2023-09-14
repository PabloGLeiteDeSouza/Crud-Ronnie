<?php
namespace APP\PHP\Classes\Private;

class Produto
{
    protected $nome;
    protected $preco;
    protected $quantidade;

    public function __construct($nome, $preco, $quantidade) {
        $this->nome = $nome;
        $this->preco = $preco;
        $this->quantidade = $quantidade;
    }

    public function getNome() {
        return $this->nome;
    }

    public function getPreco() {
        return $this->preco;
    }

    public function getQuantidade() {
        return $this->quantidade;
    }

    public function setQuantidade($quantidade) {
        if ($quantidade >= 0) {
            $this->quantidade = $quantidade;
        } else {
            echo "A quantidade não pode ser negativa." . PHP_EOL;
        }
    }

    public function exibirDetalhes() {
        echo "Nome: {$this->nome}, Preço: {$this->preco}, Quantidade: {$this->quantidade}" . PHP_EOL;
    }
}
?>