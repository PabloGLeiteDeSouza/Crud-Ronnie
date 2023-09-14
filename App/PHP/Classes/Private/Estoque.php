<?php
namespace APP\PHP\Classes\Private;

use App\PHP\Classes\Public\DatabaseConection;

class Estoque extends Produto
{
    private $conn;
    private $produtos = [];

    public function __construct() {
        $this->conn = new DatabaseConection();

    }

    public function adicionarProduto(Produto $produto) {
        
        $nome = $produto->getNome();
        $quantidade = $produto->getQuantidade();
        $preco = $produto->getPreco();

        if ($this->conn->selectExists("SELECT * FROM produto WHERE nome = ?", $nome)) {
            if (isset($this->produtos[$nome])) {
                return [false, "error"=>["code"=> "1", "reason"=>"Produto já existe no estoque"]];
            } else {
                $this->produtos[$nome] = $produto;
                return [false, "error"=>["code"=> "1", "reason"=>"Produto já existe no estoque"]];
            }
        }
        if (isset($this->produtos[$nome])) {
            if ($this->conn->insert("INSERT into produto ( nome, quantidade, preco ) VALUES ( ?, ?, ? )", [$nome, $quantidade, $preco])) {
                return [true, "sucess"=>["code"=> "1", "reason"=>"O produto foi cadastrado com sucesso"]];
            }else {
                return [false, "error"=>["code"=> "2", "reason"=>"Não foi possivel inserir o produto no banco de dados"]];
            }
        } else {
            $this->produtos[$nome] = $produto;
            if ($this->conn->insert("INSERT into produto ( nome, quantidade, preco ) VALUES ( ?, ?, ? )", [$nome, $quantidade, $preco])) {
                return [true, "sucess"=>["code"=> "1", "reason"=>"O produto foi cadastrado com sucesso"]];
            }else {
                return [false, "error"=>["code"=> "2", "reason"=>"Não foi possivel inserir o produto no banco de dados"]];
            }
        }
        
    }

    public function removerProduto(Produto $produto) {

        /**
         * @var string $nome O nome do produto
         */
        $nome = $produto->getNome();

        if (!$this->conn->selectExists("SELECT * FROM produto WHERE nome = ?", $nome)) {
            return [false, "error"=>["code"=> "1", "reason"=>"Produto não existe no estoque"]];
        }
        $nome = $produto->getNome();
        if (isset($this->produtos[$nome])) {
            if ($this->conn->delete("DELETE FROM usuario WHERE nome = ? ", [$nome])) {
                unset($this->produtos[$nome]);
                return [true, "sucess"=> ["code"=>"1", "reason"=> "o produto foi excluído do estoque com sucesso"]];
            } else {
                return [false, "error"=>["code"=> "2", "reason"=>"Não foi possível deletar o Produto do estoque tente novamente"]];
            }
        } else {
            return [false, "error"=>["code"=> "1", "reason"=>"Produto não existe no estoque"]];
        }
    }

    public function listarProdutos(int $tmn = 25) {
        $Produtos =$this->conn->select("SELECT * FROM produto LIMIT $tmn");
        if ($Produtos) {
           return [true, "sucess"=>["conde"=> "1", "reson"=>"Seleção dos produtos realizada com sucesso", "data"=>$Produtos]];
        } else {
            return [false, "error"=>["code"=> "1", "reason"=>"Não foi possível encontrar os produtos no estoque"]];
        }
    }

    // Caso nescessário implemente novos métodos abaixo
}  
?>