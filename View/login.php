<div class="container form-container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <form name="login" action="index.php?ctrl=user&action=login" method="post" class="text-center">
                    <div class="mb-3">
                        <label for="email" class="form-label">Adresse mail*</label>
                        <input type="email" class="form-control mx-auto" id="email" name="mail" placeholder="you@example.com" value="<?php echo isset($objUser)?$objUser->getMail():""; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="mdp" class="form-label">Mot de passe*</label>
                        <input type="password" class="form-control mx-auto" id="mdp" name="mdp">
                    </div>
                    <p>
                        <input class="btn btn-primary" type="submit" value="Me connecter" />
                    </p>
                </form>
            </div>
        </div>
    </div>