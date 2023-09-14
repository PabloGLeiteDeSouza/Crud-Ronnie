/**
 * Valida se o input contém apenas letras e espaços.
 * @param {HTMLInputElement} input - O elemento de input a ser validado.
 * @returns {boolean} Retorna true se o input for válido, caso contrário, false.
 */
function validaNomes(input) {
  const regex = /^[A-Za-z\s]+$/;
  return regex.test(input.value);
}

/**
 * @param {string} usuario
 * @returns {Promise<Object>} Retorna verdadeiro se o usuário existe, falso caso contrário
 */
async function verificar_existencia_usuario(usuario) {
  try {
    const response = await fetch("../App/PHP/App.php", {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded'
      },
      body: `username=${encodeURIComponent(usuario)}&validation_requests=${encodeURIComponent("validate_user")}`
    });

    if (!response.ok) {
      return { status: false, error: { code: "2", reason: "Não foi possível válidar o usuário." } }
    }

    const text = await response.text();

    try {
      const data = JSON.parse(text);
      
      if (Array.isArray(data) && data.length > 0) {
        if (!data[0]) {
          return { status: true, sucess: { code: "1", reason: "Usuário verificado!" }};
        } else {
          return { status: false, error: { code: "5", reason: "Usuário Já cadastrado tente novamente" } };
        }
      } else {
        return { status: false, error: { code: "4", reason: "Não foi possível válidar o usuário" } };
      }
    } catch (jsonError) {
      console.error('Erro ao analisar a resposta JSON:', jsonError);
      return { status: false, error: { code: "3", reason: "Não foi possível válidar o usuário" } } // Retorna falso em caso de erro de análise JSON.
    }
  } catch (error) {
    console.error(error);
    return { status: false, error: { code: "1", reason: "Não foi possível válidar o usuário." } } // Retorna falso em caso de erro.
  }
}


/**
 * Calcula a idade com base na data de nascimento e verifica se é maior de idade.
 * @param { HTMLInputElement } dataNascimento - O elemento de input contendo a data de nascimento.
 * @returns Um objeto contendo a idade calculada e um indicador se é maior de idade.
 */
function verificarIdade(dataNascimento) {
  const dataNasc = new Date(dataNascimento.value);
  const dataAtual = new Date();
  
  let idade = dataAtual.getFullYear() - dataNasc.getFullYear();
  
  if (
    dataAtual.getMonth() < dataNasc.getMonth() ||
    (dataAtual.getMonth() === dataNasc.getMonth() && dataAtual.getDate() < dataNasc.getDate())
  ) {
    idade--;
  }
  
  return { idade: idade, maior_de_idade: (idade >= 16) };
}


/**
 * Valida se o input contém um endereço de email válido.
 * @param {HTMLInputElement} email - O elemento de input contendo o endereço de email.
 * @returns {boolean} Retorna true se o email for válido, caso contrário, false.
 */
async function validaEmail(email) {
  try {
    const response = await fetch("../App/PHP/App.php", {
      method: "POST",
      headers: {
        "Content-type": 'application/x-www-form-urlencoded',
      },
      body: `validation_requests=${encodeURIComponent("validate_email")}&email=${encodeURIComponent(email.value)}`,
    });

    if (!response.ok) {
      return { status: false, error: { code: "2", reason: "Não foi possível válidar o email." } }
    }
    const text = await response.text();
    try {
      const data = JSON.parse(text);
        if (data.status) {
          return { status: true, sucess: { code: "1", reason: data.sucess.reason }};
        } else {
          return { status: false, error: { code: "4", reason: data.error.reason } };
        }      
    } catch (jsonError) {
      console.error('Erro ao analisar a resposta JSON:', jsonError);
      return { status: false, error: { code: "3", reason: "Não foi possível válidar o email" } } // Retorna falso em caso de erro de análise JSON.
    }
  } catch (error) {
    console.error(error);
    return { status: false, error: { code: "1", reason: "Não foi possível válidar o email." } } // Retorna falso em caso de erro.
  }
}  

/**
 * Habilita o botão se todos os inputs forem válidos.
 * @param {HTMLButtonElement} button - O botão a ser habilitado.
 * @param {HTMLInputElement[]} inputs - Os elementos de input a serem verificados.
 */
function validaForm(button, inputs) {
  let validCount = 0;

  for (const input of inputs) {
    if (input && input.classList.contains("is-valid")) {
      validCount++;
    }
  }

  if (validCount === inputs.length) {
    button.disabled = false;
  } else {
    button.disabled = true;
  }
}

/**
 * Verifica a segurança de uma senha.
 * @param {string} senha - A senha a ser verificada.
 * @returns Um objeto com informações sobre a segurança da senha.
 */

async function verificarSenha(senha) {
  const comprimentoMinimo = 8,
  caracteresEspeciais = '!@#$%^&*()_+{}[]:";<>,.?/\\|',
  caracteresMaiusculos = /[A-Z]/,
  caracteresMinusculos = /[a-z]/,
  numeros = /[0-9]/,
  palavrasProibidas = ['senha', '123456', 'qwerty'],
  retorno = await verificarSegurancaSenha(senha);

  if (senha.length < comprimentoMinimo) {

    return { seguro: false, mensagem: 'A senha deve ter pelo menos ' + comprimentoMinimo + ' caracteres.' };

  }

  if (!caracteresMaiusculos.test(senha) || !caracteresMinusculos.test(senha) || !numeros.test(senha)) {

    return { seguro: false, mensagem: 'A senha deve conter pelo menos uma letra maiúscula, uma letra minúscula e um número.' };

  }

  if (!caracteresEspeciais.split('').some(char => senha.includes(char))) {

    return { seguro: false, mensagem: 'A senha deve conter caracteres especiais.' };

  }

  if (palavrasProibidas.some(proibida => senha.includes(proibida))) {

    return { seguro: false, mensagem: 'A senha não pode conter palavras proibidas.' };
  }
  if(!retorno.status){

    return { seguro: false, mensagem: retorno.mensagem };

  } else {

    return { seguro: true, mensagem: "Senha segura!" };

  }

}

async function verificarSegurancaSenha(senha) {
  return await fetch('../App/PHP/Server/password.php', {
      method: 'POST',
      headers: {
          'Content-Type': 'application/x-www-form-urlencoded'
      },
      body: `senha=${encodeURIComponent(senha)}`
  })
  .then(response => response.json())
  .then(resultado => {
      return resultado;
  })
  .catch(error => {
      console.error("Erro ao verificar senha:", error);
      return JSON.stringify(error);
  });
}
