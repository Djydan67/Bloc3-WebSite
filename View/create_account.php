<!-- <form name="create_account" action="index.php?ctrl=user&action=create_account" method="post">
    <div class="row g-2">
        <div class="col-sm-3">
            <label for="nom" class="form-label">Nom*</label>
            <input type="text" class="form-control" id="nom" name="nom" value="">
        </div>
        <div class="col-sm-3">
            <label for="prenom" class="form-label">Prénom*</label>
            <input type="text" class="form-control" id="prenom" name="prenom" value="">
        </div>
        <div class="col-sm-3">
            <label for="pseudo" class="form-label">Pseudonyme*</label>
            <input type="text" class="form-control" id="pseudo" name="pseudonyme" value="">
        </div>
        <div class="col-6">
            <label for="mail" class="form-label">Adresse mail*</label>
            <input type="email" class="form-control" id="mail" name="mail" placeholder="you@example.com" value="">
        </div>
        <div class="col-6">
            <label for="mdp" class="form-label">Mot de passe*</label>
            <input type="password" class="form-control" id="mdp" name="mdp" >
        </div>
        <div class="col-6">
            <label for="confirmpwd" class="form-label">Confirmation du mot de passe*</label>
            <input type="password" class="form-control" id="confirmpwd" name="confirmpwd" >
        </div>
        <p>
            <input class="btn btn-primary" type="submit" value="Valider" />
        </p>
    </div>
</form> -->

<div class="container form-container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <form name="create_account" action="index.php?ctrl=user&action=create_account" method="post" class="text-center">
                    <div class="row g-2 justify-content-center">
                        <div class="col-sm-6">
                            <label for="nom" class="form-label">Nom*</label>
                            <input type="text" class="form-control mx-auto" id="nom" name="nom" value="<?php echo isset($objUser)?$objUser->getNom():""; ?>">
                        </div>
                        <div class="col-sm-6">
                            <label for="prenom" class="form-label">Prénom*</label>
                            <input type="text" class="form-control mx-auto" id="prenom" name="prenom" value="<?php echo isset($objUser)?$objUser->getPrenom():""; ?>">
                        </div>
                        <div class="col-sm-6">
                            <label for="pseudo" class="form-label">Pseudonyme*</label>
                            <input type="text" class="form-control mx-auto" id="pseudo" name="pseudonyme" value="<?php echo isset($objUser)?$objUser->getPseudonyme():""; ?>">
                        </div>
                        <div class="col-sm-6">
                            <label for="mail" class="form-label">Adresse mail*</label>
                            <input type="email" class="form-control mx-auto" id="mail" name="mail" placeholder="you@example.com" value="<?php echo isset($objUser)?$objUser->getMail():""; ?>">
                        </div>
                        <div class="col-sm-6">
                            <label for="mdp" class="form-label">Mot de passe*</label>
                            <input type="password" class="form-control mx-auto" id="mdp" name="mdp">
                        </div>
                        <div class="col-sm-6">
                            <label for="confirmpwd" class="form-label">Confirmation du mot de passe*</label>
                            <input type="password" class="form-control mx-auto" id="confirmpwd" name="confirmpwd">
                        </div>
                        <div class="col-12">
                            <p>
                                <input class="btn btn-primary" type="submit" value="Valider" />
                            </p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>