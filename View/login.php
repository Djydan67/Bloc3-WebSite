<form name="login" action="index.php?ctrl=user&action=login" method="post">
    <div class="row g-3">
        <div class="col-12">
            <label for="email" class="form-label">Adresse mail*</label>
            <input type="email" class="form-control" id="email" name="mail" placeholder="you@example.com" value="<?php echo isset($objUser)?$objUser->getMail():""; ?>">
        </div>
        <div class="col-12">
            <label for="mdp" class="form-label">Mot de passe*</label>
            <input type="password" class="form-control" id="mdp" name="mdp" >
        </div>
        <p>
            <input class="btn btn-primary" type="submit" value="Me connecter" />
        </p>
    </div>
</form>