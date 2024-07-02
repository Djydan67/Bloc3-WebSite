<?php

/**
 * Navbar
 * @Creator files Renaud Siegel
 * @author 
 */

?>
<nav id="nav" class="navbar navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">DofusHelp</a>
        <div id="user" class="col-4 d-flex justify-content-end align-items-center">
            <?php if (isset($_SESSION['user'])) { ?>
                <a class="btn btn-sm" href="index.php?ctrl=user&action=login" title="Se connecter">
                    <i class="fa-solid fa-user"></i></i> <?php echo $_SESSION['user']['user_nom']; ?>
                </a>
                |
                <a class="btn btn-sm" href="index.php?ctrl=user&action=logout" title="Se déconnecter">
                    <i class="fas fa-sign-out-alt"></i>
                </a>
            <?php
            } else {
            } else {
            ?>
                <a class="btn btn-sm" href="index.php?ctrl=user&action=create_account" title="Se connecter">
                    <i class="fa-solid fa-user"></i></i>
                </a>
                |
                <a class="btn btn-sm" href="index.php?ctrl=user&action=login" title="Se connecter">
                    <i class="fas fa-sign-in-alt"></i>
                </a>
            <?php
            }
            ?>
        </div>
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
            <div class="offcanvas-header">
                <a href="create_account.php">
                    <button>
                        <span class="fa-regular fa-user" aria-hidden="true"></span>
                        <a class="nav-link" href="index.php?ctrl=user&action=login"></a>
                    </button>
                </a>
                <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Navigation</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="index.php?ctrl=index&action=index">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?ctrl=stuff&action=tousEquipements">Stuff</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?ctrl=forum&action=themes">Forum</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>