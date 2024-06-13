<!-- <?php
        //include("_partial/header.php");
        ?> -->
<!-- <header id="entete"> -->
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Assets/Style/style.css" /> <!-- Chemin pour le fichier CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <title>Index DofusHelp</title>
</head>

<div class="fond">
    <div id="entete">
        <h1 id="title">Equipement</h1>
        <nav>
            <div id="corps">
                <img src="../Assets/Images/logo-dofus.png" alt="Logo" id="logo" />
                <div id="filtre">
                    <p>
                        <img src="../Assets/Images/logo-amulette.png" alt="logo-amulette" id="Amulette" />
                        <!-- <label>Tête</label>
                        <input type="checkbox" id="tete"> -->
                    </p>
                    <p>
                        <img src="../Assets/Images/logo-ceinture.png" alt="logo-amulette" id="Ceinture" />
                        <!-- <label>Torse</label>
                        <input type="checkbox" id="torse">  -->
                    </p>
                    <p>
                        <img src="../Assets/Images/logo-dofus_(2).png" alt="logo-amulette" id="Dofus" />
                        <!-- <label>Bras</label>
                        <input type="checkbox" id="bras"> -->
                    </p>
                    <p>
                        <img src="../Assets/Images/logo-botte.png" alt="logo-amulette" id="Bottes" />
                        <!-- <label>Botte</label>
                        <input type="checkbox" id="Botte">   -->
                    </p>
                    <p>
                        <img src="../Assets/Images/logo-cape.png" alt="logo-amulette" id="Cape" />
                        <!-- <label>Botte</label>
                        <input type="checkbox" id="Botte">   -->
                    </p>
                    <p>
                        <img src="../Assets/Images/logo-chapeau.png" alt="logo-amulette" id="Chapeau" />
                        <!-- <label>Botte</label>
                        <input type="checkbox" id="Botte">   -->
                    </p>
                    <img src="../Assets/Images/logo-anneaux.png" alt="logo-amulette" id="Anneau" />
                    <!-- <label>Botte</label>
                        <input type="checkbox" id="Botte">   -->
                    </p>
                    <img src="../Assets/Images/logo-trophee.png" alt="logo-amulette" id="Trophee" />
                    <!-- <label>Botte</label>
                        <input type="checkbox" id="Botte">   -->
                    </p>
                    <img src="../Assets/Images/logo-bouclier.png" alt="logo-amulette" id="Bouclier" />
                    <!-- <label>Botte</label>
                        <input type="checkbox" id="Botte">   -->
                    </p>
                    <p>
                        <img src="../Assets/Images/logo-arme.png" alt="logo-amulette" id="Armes" />
                        <!-- <label>Arme</label>
                        <input type="checkbox" id="arme"> -->
                    </p>
                </div>
            </div>
        </nav>
    </div>
    <div class="fond">
        <div class="row" id="listing"></div>
    </div>
    <div id='tab'></div>

    <script src="../Assets/JS/stuff.js"></script>
    <?php
    include("_partial/footer.php");
    ?>