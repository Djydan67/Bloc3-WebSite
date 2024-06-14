<?php
session_start();
?>
    
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Assets/Style/style.css" /> <!-- Chemin pour le fichier CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <title>Index DofusHelp</title>
</head>

<body>
    <div class="container-fluid">
        <header class="row">
            <div class="col-md-12">
                <nav id="nav" class="navbar navbar-light bg-light">
                    <div class="container-fluid">
                        <a class="navbar-brand" href="#">Dofus Help</a>
                        <div id="user" class="col-4 d-flex justify-content-end align-items-center">
                        <?php if (isset($_SESSION['user'])){ ?>
                            <a class="btn btn-sm" href="../index.php?ctrl=user&action=login" title="Se connecter">
							<i class="fas fa-user"></i> <?php echo $_SESSION['user']['user_nom']; ?>
						</a>
						|
						<a class="btn btn-sm" href="../index.php?ctrl=user&action=logout" title="Se déconnecter">
							<i class="fas fa-sign-out-alt"></i>
						</a>
                        <?php
                            }else{
                        ?>
						<a class="btn btn-sm" href="../index.php?ctrl=user&action=create_account" title="Se connecter">
							<i class="fas fa-user"></i>
						</a>
						| 
						<a class="btn btn-sm" href="../index.php?ctrl=user&action=login" title="Se connecter">
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
                                    </button>
                                </a>
                                <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Offcanvas</h5>
                                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                            </div>
                            <div class="offcanvas-body">
                                <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                                    <li class="nav-item">
                                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="/Bloc3-WebSite/index.php?ctrl=stuff&action=equipements">Stuff</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </nav>
            </div>
        </header>
    </div>