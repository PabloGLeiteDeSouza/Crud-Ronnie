<?php

namespace App\PHP\Classes\Public;

use App\PHP\Classes\Public\Security\CryptoManager;
use App\PHP\Classes\Public\DatabaseConection;
use DateTime;

class Usuario {

    private $nome;
    private $sobrenome;
    private $dataNascimento;
    private $username;
    private $email;
    private $senha;
    private $connection;

    public function __construct(string $nome = "", string $sobrenome = "", $dataNascimento = "", string $username="", string $email = "", string $senha = "") {
        $this->nome = $nome;
        $this->sobrenome = $sobrenome;
        $this->dataNascimento = $dataNascimento;
        $this->username = $username;
        $this->email = $email;
        $this->senha = $senha;
        $this->connection = new DatabaseConection();
    }

    private function Check_exists(string $sql, array $params = []) : bool {
        return $this->connection->selectExists($sql, $params);
    }

    public function verificar_usuario($username) : bool {
        return $this->connection->selectExists("SELECT * FROM usuario WHERE username=?", [$username]);
    }

    public function verificar_email(string $email) : bool {
        return $this->connection->selectExists("SELECT * FROM usuario WHERE email=?", [$email]);
    }

    /**
     * Cadastrar Usuário
     *
     * @return array
     */
    public function cadastrar() {

        if ($this->nome == "" || $this->sobrenome || $this->dataNascimento || $this->username == "" || $this->email == "" || $this->senha == "") {

            return [ false, "erro"=>[ "code"=> "1", "reason"=>"Os dados precisam ser declarados no instanciamento da classe para este método funcionar" ]];
        }

        if ($this->Check_exists("SELECT * FROM usuario WHERE username = ?", [$this->username])) {
            return [ false, "erro"=>[ "code"=> "2", "reason"=>"Usuário já cadastrado!" ]];
        }
        /**
         * @var CryptoManager $cripto_manager
         */
        $cripto_manager = new CryptoManager($this->username);
        $senha = $cripto_manager->encryptData($this->senha, true);
        $query = "INSERT into usuario ( nome, sobrenome, username, data_de_nascimento, email, senha ) VALUES ( ?, ?, ?, ?, ?, ? )";
        $params = [ $this->nome, $this->sobrenome, $this->username, $this->dataNascimento, $this->email, $senha ];
        if ($this->connection->insert($query,$params)) {
            return [true, "sucess"=>["code"=> "1", "reason"=>"Usuário cadastrado com sucesso!"]];
        } else {
            return [false, "erro"=>["code"=> "3", "reason"=>"Não foi possível cadastrar o usuário!"]];
        }
    }

    public function Login(string $login, string $senha ) : array {

        if (($login == "" || $login == null) && ($senha == "" || $senha == null)) {    return [false, "erro" =>["code"=>"1", "reason"=>"Os dados tem que ser preenchidos e não podem estar vazios"]];  }

        if (!filter_var($login, FILTER_VALIDATE_EMAIL)) {    $query = "SELECT * FROM usuario WHERE username = ?";    } else {    $query = "SELECT * FROM usuario WHERE email = ?";   }
        
        $params = [$login, $senha];

        if (!$this->Check_exists($query, $params)) {    return [false, "erro"=>["code"=>"2", "reason"=>"O usuário ou email informado não corresponde ao de um usuário cadastrado!"]];   }
        
        $retorno = $this->connection->select($query, $params);
        
        if (!$retorno) {    return [false, "erro"=>["code"=>"3", "reason"=>"Não foi possivel localizar o usuário inserido tente novamente!"]];  }

        $username = $retorno[0]["username"];    $senha_encriptada = $retorno[0]["senha"];   $crypto_manager = new CryptoManager($username);
        
        $senha_decriptada = $crypto_manager->decryptData($senha_encriptada);

        

    }

    public function RedefinirSenhaStart($username=null, $email=null) : bool {
        
        // Checagem inicial
        if ($username != null) {
            $param = ["username", $username];
        }elseif ($email != null) {
            $param = ["email", $email];
        }elseif ($username == null && $email == null) {
            return false;
        }

        // Verificação de tipagem
        if ($param[0] == "username") {
            $query = "SELECT * FROM usuario WHERE username= ?";
            return $this->connection->selectExists($query, $param[1]);
        }else {
            $query = "SELECT * FROM usuario WHERE email= ?";
            return $this->connection->selectExists($query, $param[1]);
        }
    }

    public function editarDadosCadastrais($nome=null, $sobrenome=null, $username=null, $dataNascimento=null, $email=null) :bool {
        
        // Atualização dos valores caso ocorram as condicionais
        $this->nome = ($nome !=null) ? $nome: $this->nome;
        $this->sobrenome = ($sobrenome != null) ? $sobrenome: $this->sobrenome;
        $this->username = ($username != null) ? $username: $this->username;
        $this->dataNascimento = ($dataNascimento != null) ? $dataNascimento:$this->dataNascimento;
        $this->email = ($email != null) ? $email: $this->email;
        
        //iniciando a validação e inserção dos dados
        $cripto_manager = new CryptoManager($username);
        $query = "SELECT senha FROM usuarios WHERE username= ? AND email= ?";
        if (!$this->connection->selectExists($query, [$this->username, $this->email])) {
            return false;
        }
        $query = "INSERT into usuario ( nome, sobrenome, username, data_de_nascimento, email ) VALUES ( ?, ?, ?, ?, ? )";
        $params = [ $this->nome, $this->sobrenome, $this->username, $this->dataNascimento, $this->email ];
        return $this->connection->insert($query, $params);
    }

    public function deletarConta() : bool {

        $crypto_manager = new CryptoManager($this->username);

        $sql = "SELECT senha FROM usuarios WHERE usuario = ? AND email = ?";

        if ($retorno = $this->connection->select($sql, [$this->username, $this->email])) {

            $senha_encriptada = $retorno[0]["senha"];

            $senha_decriptada = $crypto_manager->decryptData($senha_encriptada);

            if ($senha_decriptada != false && $senha_decriptada == $this->senha) {

                $sql = "DELETE FROM usuarios WHERE usuario = ? AND email = ? AND senha = ?";

                if ($this->connection->delete($sql, [$this->username, $this->email, $senha_encriptada])) {

                    return true;

                } else {

                    return false;
                }
            }
        } else {

            return false;

        }  
    }
}
?>
