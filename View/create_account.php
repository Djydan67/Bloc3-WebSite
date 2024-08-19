<div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="row justify-content-center w-100">
        <div class="col-md-8">
            <div class="card p-4 card-color">
                <div class="card-body">
                    <h5 class="card-title text-center mb-4">Créer un Compte</h5>
                    <form name="create_account" action="index.php?ctrl=user&action=create_account" method="post" class="text-center mx-auto">
                        <div class="row g-2 justify-content-center">
                            <div class="col-sm-6">
                                <label for="prenom" class="form-label">Prénom*</label>
                                <input type="text" class="form-control" id="prenom" name="prenom" value="<?php echo isset($objUser) ? $objUser->getPrenom() : ""; ?>">
                            </div>
                            <div class="col-sm-6">
                                <label for="nom" class="form-label">Nom*</label>
                                <input type="text" class="form-control" id="nom" name="nom" value="<?php echo isset($objUser) ? $objUser->getNom() : ""; ?>">
                            </div>
                            <div class="col-sm-6">
                                <label for="pseudo" class="form-label">Pseudonyme*</label>
                                <input type="text" class="form-control" id="pseudo" name="pseudonyme" value="<?php echo isset($objUser) ? $objUser->getPseudonyme() : ""; ?>">
                            </div>
                            <div class="col-sm-6">
                                <label for="datenaissance" class="form-label">Date de naissance*</label>
                                <input type="date" class="form-control" id="date_de_naissance" name="datenaissance" value="<?php echo isset($objUser) ? $objUser->getDatenaissance() : ""; ?>">
                            </div>
                            <div class="col-sm-6">
                                <label for="mail" class="form-label">Adresse mail*</label>
                                <input type="email" class="form-control" id="mail" name="mail" placeholder="you@example.com" value="<?php echo isset($objUser) ? $objUser->getMail() : ""; ?>">
                            </div>
                            <div class="col-sm-6 position-relative">
                                <label for="mdp" class="form-label">Mot de passe*</label>
                                <input type="password" class="form-control" id="mdp" name="mdp">
                                <div id="tooltip" class="tooltip-text">
                                    Il doit contenir :
                                    <ul>
                                        <li>16 à 20 caractères</li>
                                        <li>1 majuscule</li>
                                        <li>1 minuscule</li>
                                        <li>1 chiffre</li>
                                        <li>1 caractère spécial</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label for="confirmpwd" class="form-label">Confirmation du mot de passe*</label>
                                <input type="password" class="form-control" id="confirmpwd" name="confirmpwd">
                            </div>
                            <div class="col-9">
                                <p>
                                    <input class="btn btn-create" type="submit" value="Valider" />
                                </p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
