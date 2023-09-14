Include('../js/functions.js', "head");

// Inputs
/**
 * @type HTMLInputElement
 */
const nome = document.getElementById('inputFristName'),
/**
 * @type HTMLInputElement
 */
    sobrenome = document.getElementById('inputLastName'),
/**
 * @type HTMLInputElement
 */
    data_de_nascimento = document.getElementById('inputDataNasc'),
/**
 * @type HTMLInputElement
 */
    usuario = document.getElementById('inputUsername'),
/**
 * @type HTMLInputElement
 */
    email = document.getElementById('inputEmail'),
/**
 * @type HTMLInputElement
 */
    confirm_email = document.getElementById('inputConfirmEmail'),
/**
 * @type HTMLInputElement
 */
    senha = document.getElementById('inputPassword'),
/**
 * @type HTMLInputElement
 */
    confirm_senha = document.getElementById('inputComfirmPassword'),
/**
 * @type HTMLInputElement
 */
    terms = document.getElementById('inputCheckTerms'),
/**
 * @type HTMLInputElement[]
 */
    inputs = [ nome, sobrenome, data_de_nascimento, usuario, email, confirm_email, senha, confirm_senha, terms];
// Error Div Mesages/Input 


const invalid_nome = document.getElementById('id-first-name-feedback-invalid'),
    invalid_sobrenome = document.getElementById('id-last-name-feedback-invalid'),
    invalid_data_de_nascimento = document.getElementById('id-data-de-nascimento-feedback-invalid'),
    invalid_usuario = document.getElementById('id-username-feedback-invalid'),
    invalid_email = document.getElementById('id-email-feedback-invalid'),
    invalid_confirm_email = document.getElementById('id-confirm-email-feedback-invalid'),
    invalid_senha = document.getElementById('id-password-feedback-invalid'),
    invalid_confirm_senha = document.getElementById('id-confirm-password-feedback-invalid'),
    invalid_terms = document.getElementById('id-check-terms-feedback-invalid');

// Error Modals div/Messages

const modal_erro_login_btn = document.getElementById("id-modal-erro-login-btn");

// Buttons
/**
 * @type HTMLButtonElement
 */
const button_submit_register = document.getElementById("id-btn-submit-register");



nome.addEventListener("change", () => { 
    if (nome.value === "") { 
        if (nome.classList.contains('is-invalid')) {
            invalid_nome.innerText = " O campo não pode estar vazio ";  
        } else {
            nome.classList.remove('is-valid');
            nome.classList.add('is-invalid');
            invalid_nome.innerText = "O campo não pode estar vazio";
        }
    } else {
        if (validaNomes(nome)) {
            if(nome.classList.contains('is-invalid')) {
                nome.classList.remove('is-invalid');
            }
            nome.classList.add('is-valid');
        } else {    
            if(nome.classList.contains('is-valid')) nome.classList.remove('is-valid');  i
            invalid_nome.innerText = "Nome não pode ter caracteres especiais";  
            nome.classList.add('is-invalid');   
        }
    }
    validaForm(button_submit_register, inputs);
});

sobrenome.addEventListener("change", () => { 
    if (sobrenome.value === "") { 
        if (sobrenome.classList.contains('is-invalid')) {    
            invalid_sobrenome.innerText = " O campo não pode estar vazio ";  
        } else {    
            sobrenome.classList.remove('is-valid');  
            sobrenome.classList.add('is-invalid');   
            invalid_sobrenome.innerText = "O campo não pode estar vazio";    
        }   
    } else {    
        if (validaNomes(sobrenome)) {    
            if(sobrenome.classList.contains('is-invalid')) { 
                sobrenome.classList.remove('is-invalid');    
            }
            sobrenome.classList.add('is-valid');
        } else {
            if(sobrenome.classList.contains('is-valid')) sobrenome.classList.remove('is-valid');
            invalid_sobrenome.innerText = "Nome não pode ter caracteres especiais";
            sobrenome.classList.add('is-invalid');
        }   
    }
    validaForm(button_submit_register, inputs);   
});

data_de_nascimento.addEventListener("change", () => { 
    if (data_de_nascimento.value === "") { 
        if (data_de_nascimento.classList.contains('is-invalid')) { 
            invalid_data_de_nascimento.innerText = "o campo não pode estar vazio!"; 
        } else { 
            data_de_nascimento.classList.remove('is-valid'); 
            data_de_nascimento.classList.add('is-invalid'); 
            invalid_data_de_nascimento.innerText = "o campo não pode estar vazio!"; 
        } 
    } else {
        const verify = verificarIdade(data_de_nascimento);
        if (data_de_nascimento.classList.contains('is-valid')) { 
            if (!verify.maior_de_idade) { 
                data_de_nascimento.classList.remove('is-valid'); 
                data_de_nascimento.classList.add('is-invalid'); 
                invalid_data_de_nascimento.innerText = "A idade do usuário é inferior a 16 anos"+ ` a sua idade é de: ${verify.idade} anos`; 
            } 
        } else { 
            if (verify.maior_de_idade) { 
                if(data_de_nascimento.classList.contains('is-invalid')) { 
                    data_de_nascimento.classList.remove('is-invalid'); 
                } 
                data_de_nascimento.classList.add('is-valid'); 
            } else { 
                data_de_nascimento.classList.add('is-invalid'); 
                invalid_data_de_nascimento.innerText = "A idade do usuário é inferior a 16 anos"; 
            } 
        } 
    } 
});

usuario.addEventListener("change", async () => {
    if (usuario.value === "") {
        if (usuario.classList.contains('is-invalid')) { 
            invalid_usuario.innerText = "o campo não pode estar vazio!"; 
        } else { 
            usuario.classList.remove('is-valid'); 
            usuario.classList.add('is-invalid'); 
            invalid_usuario.innerText = "o campo não pode estar vazio!"; 
        }
    } else {
        if (validaNomes(usuario)) {
            var user = await verificar_existencia_usuario(usuario.value);
            if (user.status) {
                if(usuario.classList.contains('is-invalid')) {
                    usuario.classList.remove('is-invalid');
                }
                usuario.classList.add('is-valid');
            } else {
                if(usuario.classList.contains('is-valid')) {
                    usuario.classList.remove('is-valid');
                }
                invalid_usuario.innerText = `${user.error.reason} ERRO: ${user.error.code}`;
                usuario.classList.add('is-invalid');
            }
            
        } else {    
            if(usuario.classList.contains('is-valid')) usuario.classList.remove('is-valid');
            invalid_usuario.innerText = "O usuário não pode ter caracteres especiais";  
            usuario.classList.add('is-invalid');   
        }
    }
    validaForm(button_submit_register, inputs);
});

email.addEventListener("change", async () => {
    if (email.value === "") {
        if (email.classList.contains("is-invalid")) {
            invalid_email.innerText = "O campo email não pode estar vazio";
        } else {
            if(email.classList.contains("is-valid")) { 
                email.classList.remove("is-valid"); 
            }
            invalid_email.innerText = "O campo email não pode estar vazio";
            email.classList.add("is-invalid");
        }
    } else {
        const retorno = await validaEmail(email);

        if (retorno.status) {
            if (email.classList.contains("is-invalid")) {
                email.classList.remove("is-invalid");
            }
            email.classList.add("is-valid");
        } else {
            if (email.classList.contains("is-valid")) {
                email.classList.remove("is-valid");
            }
            invalid_email.innerText = `${retorno.error.reason} (${retorno.error.code})`;
            email.classList.add("is-invalid");
        }
    }
    validaForm(button_submit_register, inputs);
});

confirm_email.addEventListener("change", () => {
    if (confirm_email.value === "") {
        if (confirm_email.classList.contains("is-valid")) {
            confirm_email.classList.remove("is-valid");
            invalid_confirm_email.innerText = "O campo email não pode estar vazio";
            confirm_email.classList.add("is-invalid");
            confirm_email.select(); confirm_email.focus();
        } else if (confirm_email.classList.contains("is-invalid")) {
            invalid_confirm_email.innerText = "O campo email não pode estar vazio";
            confirm_email.select(); confirm_email.focus();
        } else {
            invalid_confirm_email.innerText = "O campo email não pode estar vazio";
            confirm_email.classList.add("is-invalid");
            confirm_email.select(); confirm_email.focus();
        }
    } else if (confirm_email.value !== email.value ){
        if (confirm_email.classList.contains("is-invalid")) {
            invalid_confirm_email.innerText = "O campo email confirmar e o campo email estão divergentes";
            confirm_email.select(); confirm_email.focus();
        } else if (confirm_email.classList.contains("is-valid")) {
            confirm_email.classList.remove("is-valid");
            invalid_confirm_email.innerText = "O campo email confirmar e o campo email estão divergentes";
            confirm_email.classList.add("is-invalid");
            confirm_email.select(); confirm_email.focus();
        } else {
            invalid_confirm_email.innerText = "O campo email confirmar e o campo email estão divergentes";
            confirm_email.classList.add("is-invalid");
            confirm_email.select(); confirm_email.focus();
        }
    } else {
        if (confirm_email.classList.contains("is-invalid")) {
            if (validaEmail(email)) {
                confirm_email.classList.remove("is-invalid");
                confirm_email.classList.add("is-valid");
            } else {
                invalid_confirm_email.innerText = "O email está inválido";
                confirm_email.select(); confirm_email.focus();
            }
        } else if (confirm_email.classList.contains("is-valid")) {
            if (!validaEmail(email)) {
                confirm_email.classList.remove("is-valid");
                invalid_confirm_email.innerText = "O email está inválido!";
                confirm_email.classList.add("is-invalid");
                confirm_email.select(); confirm_email.focus();
            }
        } else {
            if (validaEmail(email)) {
                confirm_email.classList.add("is-valid");
            } else {
                invalid_confirm_email.innerText = "O email está inválido!";
                confirm_email.classList.add("is-invalid");
                confirm_email.select(); confirm_email.focus();
            }
        }
    }
    validaForm(button_submit_register, inputs);
});

senha.addEventListener("change", async () => {
    if (senha.value === "") {
        if (senha.classList.contains("is-valid")) {
            senha.classList.remove("is-valid");
            invalid_senha.innerText = "O campo senha não pode estar vazio";
            senha.classList.add("is-invalid");
            senha.select(); senha.focus();
        } else if (senha.classList.contains("is-invalid")) {
            invalid_senha.innerText = "O campo senha não pode estar vazio";
            senha.select(); senha.focus();
        } else {
            invalid_senha.innerText = "O campo senha não pode estar vazio";
            senha.classList.add("is-invalid");
            senha.select(); senha.focus();
        }
    } else {
        const verify = await verificarSenha(senha.value);
        if (senha.classList.contains('is-valid')) {
            if (!verify.seguro) {
                senha.classList.remove("is-valid");
                invalid_senha.innerText = verify.mensagem;
                senha.classList.add("is-invalid");
                senha.select(); senha.focus();
            }
        } else if (senha.classList.contains("is-invalid")) {
            if (verify.seguro) {
                senha.classList.remove("is-invalid");
                senha.classList.add("is-valid");
            }else{
                invalid_senha.innerText = verify.mensagem;
                senha.select(); senha.focus();
            }

        } else {
            if (verify.seguro) {
                senha.classList.add("is-valid");
            } else {
                invalid_senha.innerText = verify.mensagem;
                senha.classList.add("is-invalid");
                senha.select(); senha.focus();
            }
        } 
    }
});


confirm_senha.addEventListener("change", async () => {
    if (confirm_senha.value === "") {
        if (confirm_senha.classList.contains("is-valid")) {
            confirm_senha.classList.remove("is-valid");
            invalid_confirm_senha.innerText = "A confirmação de senha não pode estar vazia";
            confirm_senha.classList.add("is-invalid");
            confirm_senha.select(); confirm_senha.focus();
        } else if (confirm_senha.classList.contains("is-invalid")) {
            invalid_confirm_senha.innerText = "A confirmação de senha não pode estar vazia";
            confirm_senha.select(); confirm_senha.focus();
        } else {
            invalid_confirm_senha.innerText = "A confirmação de senha não pode estar vazia";
            confirm_senha.classList.add("is-invalid");
            confirm_senha.select(); confirm_senha.focus();
        }
    } else if (confirm_senha.value !== senha.value) {
        if (confirm_senha.classList.contains("is-valid")) {
            confirm_senha.classList.remove("is-valid");
            invalid_confirm_senha.innerText = "A confirmação de senha está divergente da original";
            confirm_senha.classList.add("is-invalid");
            confirm_senha.select(); confirm_senha.focus();
        } else if (confirm_senha.classList.contains("is-invalid")) {
            invalid_confirm_senha.innerText = "A confirmação de senha está divergente da original";
            confirm_senha.select(); confirm_senha.focus();
        } else {
            invalid_confirm_senha.innerText = "A confirmação de senha está divergente da original";
            confirm_senha.classList.add("is-invalid");
            confirm_senha.select(); confirm_senha.focus();
        }
    } else {
        if (!confirm_senha.classList.contains("is-valid") && !confirm_senha.classList.contains("is-invalid")) {
            confirm_senha.classList.add("is-valid");
        } else if (confirm_senha.classList.contains("is-invalid")) {
            confirm_senha.classList.remove("is-invalid"); confirm_senha.classList.add("is-valid");
        }
    }
    validaForm(button_submit_register, inputs);
});

terms.addEventListener("change", () => {
    if (terms.checked === true) {
        if (!terms.classList.contains("is-valid") && !terms.classList.contains("is-invalid")) {
            terms.classList.add("is-valid");
        } else if (terms.classList.contains('is-invalid')) {
            terms.classList.remove("is-invalid");
            terms.classList.add("is-valid")
        }
    } else {
        if (!terms.classList.contains("is-valid") && !terms.classList.contains("is-invalid")) {
            invalid_terms.innerText = "Para prosseguir é necessário concordar com os termos de uso!";
            terms.classList.add("is-invalid"); terms.focus();
        } else if (terms.classList.contains("is-valid")) {
            terms.classList.remove("is-valid");
            invalid_terms.innerText = "Para prosseguir é necessário concordar com os termos de uso!";
            terms.classList.add("is-invalid"); terms.focus();
        }
    }
    validaForm(button_submit_register, inputs);
});

button_submit_register.addEventListener("click", (e) => {
    validaForm(button_submit_register, inputs);
    if (button_submit_register.disabled) {
        modal_erro_login_btn.classList.add("show");
        modal_erro_login_btn.style.display = block;
    } else {
        
    }
})