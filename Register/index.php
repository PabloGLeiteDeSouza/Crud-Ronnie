<!doctype html>
<html lang="en" data-bs-theme="auto">

  <head>
    <script src="../js/color-modes.js"></script>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Um crud em PHP">
    <meta name="author" content="Swykany Solutions and Contribuitors">
    <title> ..:: Register ::.. </title>
    <link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/modals/">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@docsearch/css@3">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="../Components/Modals/Login/style.css">
    <link rel="stylesheet" href="../Components/Theme/Selector/style.css">
    <link rel="stylesheet" href="style.css">
    <link href="../global.css" rel="stylesheet">
    <link rel="shortcut icon" href="../Public/Imgs/favicon.ico" type="image/x-icon">
    <script src="../js/basic_functions.js"></script>
  </head>
  
  <body>

    <?php
        require_once "../Components/Theme/Selector/Index.php"; 
        require_once "../Components/Modals/Login/Index.php";
        require_once "../Components/Navbar/Index.php";
    ?>
    <main>
      <div class="container-fluid w-50 bg-purple px-5 py-5 rounded mt-5 mb-5">
        <div class="row text-center mb-5">
          <h1>Registre-se Abaixo:</h1>
        </div>
        <form class="row g-3" id="form-register">
          <div class="col-md-6 mb-3">
            <label for="inputFristName" class="form-label">Nome</label>
            <input type="text" class="form-control" id="inputFristName" autocomplete="given-name" required >
            <div class="valid-feedback" id="id-first-name-feedback-valid">
              Nome válido
            </div>
            <div class="invalid-feedback" id="id-first-name-feedback-invalid"></div>
          </div>
          <div class="col-md-6">
            <label for="inputLastName" class="form-label">Sobrenome</label>
            <input type="text" class="form-control" id="inputLastName" autocomplete="family-name" required >
            <div class="valid-feedback" id="id-last-name-feedback-valid">
              Sobrenome válido
            </div>
            <div class="invalid-feedback" id="id-last-name-feedback-invalid"></div>
          </div>
          <div class="col-12 mb-3">
            <label for="inputDataNasc" class="form-label">Data de Nascimento</label>
            <input type="date" class="form-control" id="inputDataNasc" placeholder="" autocomplete="bday" required>
            <div class="valid-feedback" id="id-data-de-nascimento-feedback-valid">
              Data de nascimento válida
            </div>
            <div class="invalid-feedback" id="id-data-de-nascimento-feedback-invalid"></div>
          </div>
          <div class="col-12 mb-3">
            <label for="inputUsername" class="form-label">Username</label>
            <div class="input-group">
              <span class="input-group-text" id="basic-addon1">@</span>
              <input type="text" class="form-control" id="inputUsername" placeholder="Username" autocomplete="username" aria-label="Username" aria-describedby="basic-addon1" required>
              <div class="valid-feedback" id="id-username-feedback-valid">
                Usuário válido
              </div>
              <div class="invalid-feedback" id="id-username-feedback-invalid"></div>
            </div>
          </div>
          <div class="col-12 mb-3">
            <label for="inputEmail" class="form-label">E-mail</label>
            <input type="email" class="form-control" id="inputEmail" placeholder="example@example.com" autocomplete="email" required >
            <div class="valid-feedback" id="id-email-feedback-valid">
              Email válido
            </div>
            <div class="invalid-feedback" id="id-email-feedback-invalid"></div>
          </div>
          <div class="col-12 mb-3">
            <label for="inputConfirmEmail" class="form-label">Confirme seu E-mail</label>
            <input type="email" class="form-control" id="inputConfirmEmail" placeholder="example@example.com" required>
            <div class="valid-feedback" id="id-confirm-email-feedback-valid">
              Emails correspondentes e válidos
            </div>
            <div class="invalid-feedback" id="id-confirm-email-feedback-invalid"></div>
          </div>
          <div class="col-12 mb-3">
            <label for="inputPassword" class="form-label">Senha</label>
            <input type="password" class="form-control" id="inputPassword" placeholder="*********" autocomplete="current-password" required>
            <div class="valid-feedback" id="id-password-feedback-valid">
              Senha válida e segura!
            </div>
            <div class="invalid-feedback" id="id-password-feedback-invalid"></div>
          </div>
          <div class="col-12 mb-3">
            <label for="inputComfirmPassword" class="form-label">Confirme sua Senha</label>
            <input type="password" class="form-control" id="inputComfirmPassword" placeholder="*********" autocomplete="current-password" required>
            <div class="valid-feedback" id="id-confirm-password-feedback-valid">
              Senhas correspondentes, válidas e seguras!
            </div>
            <div class="invalid-feedback" id="id-confirm-password-feedback-invalid"></div>
          </div>
          <div class="col-12">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" id="inputCheckTerms" required>
              <label class="form-check-label" for="inputCheckTerms">
                Concordo com os <a class="link" href="#">Termos de uso</a>
              </label>
              <div class="valid-feedback" id="id-check-terms-feedback-valid">
                Registro já pode ser finalizado!
              </div>
              <div class="invalid-feedback" id="id-check-terms-feedback-invalid"></div>
            </div>
          </div>
          <div class="col-12 justify-content-center d-flex">
            <button disabled type="submit" id="id-btn-submit-register" class="btn btn-primary">Registre-se</button>
          </div>
        </form>
      </div>
    </main>
    
    <?php
      require_once "../Components/Footer/Index.php";
    ?>

    <script>
      document.querySelector('#id-Register-page-link').classList.add("active");
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
    <script src="index.js"></script>
  </body>

</html>