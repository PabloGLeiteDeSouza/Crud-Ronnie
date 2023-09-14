 <!-- Modal Login -->
<div class="modal fade modal-sheet" id="loginModal" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
        <div class="modal-content rounded-4 shadow">
            <div class="modal-header p-5 pb-4 border-bottom-0">
                <h1 class="fw-bold mb-0 fs-2">Faça o Login</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-5 pt-0">
                <form class="" autocomplete="on">
                    <div class="form-floating mb-3">
                        <input type="email" class="form-control rounded-3" id="inputLoginEmail" placeholder="name@example.com" autocomplete="email" required>
                        <label for="inputEmail">Email</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="password" class="form-control rounded-3" id="inputLoginPassword" placeholder="Password" autocomplete="current-password" required>
                        <label for="inputLoginPassword">Senha</label>
                    </div>
                   
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="inputCheckConection" required>
                        <label class="form-check-label" for="inputCheckConection">
                            Manter-se conectado
                        </label>
                    </div>
                    
                    <button class="w-100 mb-3 btn btn-lg rounded-3 btn-primary" type="submit">Login</button>
                    
                </form>
            </div>
        </div>
    </div>
</div>