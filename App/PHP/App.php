<?php

// Chamada de classes importando seus códigos
require "./Classes/Public/Usuarios.php";
require "./Classes/Public/DatabaseConnection.php";
require "./Server/Functions.php";

// Chamada de classes do médtodo Porgramação Orientado a Objetos (P.O.O) e reaproveitamento de código
use App\PHP\Classes\Public\Usuario;
use APP\PHP\Classes\Public\DatabaseConection;
use APP\PHP\Server\Functions;

/**
 * Função que realiza o Registro do Usuário
 *
 * @return array
 */
function Register() : array {
    
    $Functions = new Functions();
    
    $Database_Conection = new DatabaseConection();

    // Filtro de dados das váriaveis
    $nome = $Functions->Filter_names(filter_input(INPUT_POST, "nome", FILTER_DEFAULT));
    if ($nome) {    return [ false, "error"=>["code"=>"1","reason"=>"O data de nascimento está inválido"]];    }
    $sobrenome = $Functions->Filter_names(filter_input(INPUT_POST, "sobrenome", FILTER_DEFAULT));
    
    $username = $Functions->Filter_username(filter_input(INPUT_POST, "username", FILTER_DEFAULT));
   
    $data_de_nascimento = $Functions->Filtrar_data_de_nascimento(htmlspecialchars(filter_input(INPUT_POST, "data_de_nascimento")));
    if(!$data_de_nascimento) {   return [ false, "error"=>["code"=>"1","reason"=>"O data de nascimento está inválido"]];    }

    $email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
    if (!$email) {    return [ false, "error"=>["code"=>"1","reason"=>"A data de nascimento está inválida"]];    }
    
    $senha = filter_input(INPUT_POST, "senha", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    if (!$senha) {    return [ false, "error"=>["code"=>"1","reason"=>"A senha está inválida"]];    }
    
    $usuario = new Usuario($nome,$sobrenome, $data_de_nascimento, $username,  $email, $senha);
    
    return $usuario->cadastrar();
}

function Login() : array {
    
    // Instanciando classes que serão ultilizadas
    $Functions = new Functions();
    $usuario = new Usuario();
    
    // Verificação usando P.L (Programação Linear);
    $login = (str_contains($_POST["login"], "@")) ? filter_input(INPUT_POST, "login", FILTER_VALIDATE_EMAIL) : $Functions->Filter_username(filter_input(INPUT_POST, "login", FILTER_DEFAULT));
    if (!$login) {    return [false, "error"=>["code"=>"1", "reason"=>"O login está inválido"]];    }
    
    $senha = $Functions->Filter_senha(htmlentities(filter_input(INPUT_POST, "senha")));
    if (!$senha) {    return [ false, "error"=>["code"=>"1","reason"=>"A senha está inválida"]];    }
    
    return $usuario->Login($login, $senha);
    
}

// Código da P.L (Programação Linear)
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (isset($_POST["login"], $_POST["senha"])) {
        echo json_encode(Login());
    } elseif (isset($_POST["nome"], $_POST["sobrenome"], $_POST["username"], $_POST["data_de_nascimento"], $_POST["email"], $_POST["senha"])) {
        echo json_encode(Register());
    } elseif (isset($_POST["validation_requests"])) {

        if ($_POST["validation_requests"] == "validate_user") {
            $usuario = new Usuario();
            echo json_encode([$usuario->verificar_usuario($_POST['username'])]);

        }   elseif ($_POST["validation_requests"] == "validate_email") {
            $usuario = new Usuario();
            if ($usuario->verificar_email($_POST["email"])) {
                echo json_encode([false, "error"=>["code"=>"1", "reason"=>"Email já cadastrado em outro usuário"]]);
            } else {
                if (filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
                    echo json_encode(["status"=>true,"sucess"=>["code"=>"1","reason"=>"Email válido"]]);
                } else {
                    echo json_encode(["status"=>false,"error"=>["code"=>"2","reason"=>"Email inválido"]]);
                }
            }
        }
    }

} else {
    header("Location: ../../../");
}