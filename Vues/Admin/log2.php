  <!-- Body Content Wrapper -->
    <div class="ms-content-wrapper ms-auth">
      <div class="ms-auth-container">
        <div class="ms-auth-col">
          <div class="ms-auth-bg"></div>
        </div>
        <div class="ms-auth-col">
          <div class="ms-auth-form">
            <form method="POST" autocomplete="off" class="needs-validation" novalidate="">
              <h3>Se Connecter</h3>
              <div class="mb-3">
                <label for="validationCustom08">Nom d'utilisateur</label>
                <div class="input-group">
                  <input type="text" class="form-control" name="username" id="validationCustom08" placeholder="Nom d'utilisateur" required="">
                  <div class="invalid-feedback">SVP Entrez un nom d'Utilisateur.</div>
                </div>
              </div>
              <div class="mb-2">
                <label for="validationCustom09">Mot de passe</label>
                <div class="input-group">
                  <input type="password" class="form-control" name="pwd" id="validationCustom09" placeholder="Mot de passe" required="">
                  <div class="invalid-feedback">Entrez un mot de passe.</div>
                </div>
              </div>
              <button name="login" class="btn btn-primary mt-4 d-block w-100" type="submit">Se connecter</button> 
            
          <?php  echo $msg; ?>
            </form>
          </div>
        </div>
      </div>
    </div>