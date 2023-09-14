<?php

function verificarSegurancaSenha($senha) {
    
    // Defina suas regras de validação de senha aqui
    $comprimentoMinimo = 8;
    $exigeLetrasMaiusculas = true;
    $exigeLetrasMinusculas = true;
    $exigeNumeros = true;
    $exigeCaracteresEspeciais = true;

    // Verifique as regras de validação
    $senhaSegura = true;
    $mensagem = "Senha segura.";

    if (strlen($senha) < $comprimentoMinimo) {
        $senhaSegura = false;
        $mensagem = "A senha deve ter pelo menos $comprimentoMinimo caracteres.";
    } elseif ($exigeLetrasMaiusculas && !preg_match('/[A-Z]/', $senha)) {
        $senhaSegura = false;
        $mensagem = "A senha deve conter pelo menos uma letra maiúscula.";
    } elseif ($exigeLetrasMinusculas && !preg_match('/[a-z]/', $senha)) {
        $senhaSegura = false;
        $mensagem = "A senha deve conter pelo menos uma letra minúscula.";
    } elseif ($exigeNumeros && !preg_match('/[0-9]/', $senha)) {
        $senhaSegura = false;
        $mensagem = "A senha deve conter pelo menos um número.";
    } elseif ($exigeCaracteresEspeciais && !preg_match('/[^a-zA-Z0-9]/', $senha)) {
        $senhaSegura = false;
        $mensagem = "A senha deve conter pelo menos um caractere especial.";
    }

    // Verificação de senha comprometida
    $comprometida = verificarSenhaComprometida($senha);

    if ($comprometida) {
        return [
            "status" => false,
            "mensagem" => "A senha foi comprometida e não é segura."
        ];
    }

    return [
        "status" => $senhaSegura,
        "mensagem" => $mensagem
    ];
}

/**
 * Função que verifica a integridade da senha
 *
 * @param String $senha
 * @return Bolean
 */
function verificarSenhaComprometida($senha) {

    // Use a API "Have I Been Pwned" para verificar se a senha foi comprometida

    $hash = strtoupper(sha1($senha));

    $prefix = substr($hash, 0, 5);

    $suffix = substr($hash, 5);

    $response = file_get_contents("https://api.pwnedpasswords.com/range/{$prefix}");

    if (strpos($response, $suffix) !== false) {

        return true; // Senha comprometida

    }

    return false; // Senha não comprometida
}


if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["senha"])) {

    $senha = $_POST["senha"];

    $resultado = verificarSegurancaSenha($senha);

    echo json_encode($resultado);

} elseif ($_SERVER["REQUEST_METHOD"] === "GET") {

    header("Location:../../");

} else {

    echo json_encode([
        "status" => false,
        "mensagem" => "Requisição inválida."
    ]);

}
?>