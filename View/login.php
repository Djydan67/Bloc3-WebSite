<div class="d-flex justify-content-center align-items-center min-vh-100">
    <div class="card p-3 shadow-sm card-login">
        <h5 class="card-title text-center mb-3">Connexion</h5>
        <form name="login" action="index.php?ctrl=user&action=login" method="post" class="d-flex flex-column align-items-center">
            <div class="mb-3 w-100" style="max-width: 300px;">
                <label for="email" class="form-label">Adresse mail*</label>
                <input type="email" class="form-control" id="email" name="mail" placeholder="you@example.com" value="<?php echo isset($objUser) ? $objUser->getMail() : ""; ?>">
            </div>
            <div class="mb-3 w-100" style="max-width: 300px;">
                <label for="mdp" class="form-label">Mot de passe*</label>
                <input type="password" class="form-control" id="mdp" name="mdp">
            </div>
            <input class="btn btn-login mt-2" type="submit" value="Me connecter" />
        </form>
    </div>
</div>
