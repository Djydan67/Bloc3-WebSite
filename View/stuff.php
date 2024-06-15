<div class="fond">
    <div id="entete">
        <h1 id="title">Equipement</h1>
        <nav>
            <div id="corps">
                <img src="Assets/Images/logo-dofus.png" alt="Logo" id="logo" />
                <div id="filtre">
                    <p>
                        <img src="Assets/Images/logo-amulette.png" alt="logo-amulette" id="Amulette" />
                        <!-- <label>Tête</label>
                        <input type="checkbox" id="tete"> -->
                    </p>
                    <p>
                        <img src="Assets/Images/logo-ceinture.png" alt="logo-amulette" id="Ceinture" />
                        <!-- <label>Torse</label>
                        <input type="checkbox" id="torse">  -->
                    </p>
                    <p>
                        <img src="Assets/Images/logo-dofus_(2).png" alt="logo-amulette" id="Dofus" />
                        <!-- <label>Bras</label>
                        <input type="checkbox" id="bras"> -->
                    </p>
                    <p>
                        <img src="Assets/Images/logo-botte.png" alt="logo-amulette" id="Bottes" />
                        <!-- <label>Botte</label>
                        <input type="checkbox" id="Botte">   -->
                    </p>
                    <p>
                        <img src="Assets/Images/logo-cape.png" alt="logo-amulette" id="Cape" />
                        <!-- <label>Botte</label>
                        <input type="checkbox" id="Botte">   -->
                    </p>
                    <p>
                        <img src="Assets/Images/logo-chapeau.png" alt="logo-amulette" id="Chapeau" />
                        <!-- <label>Botte</label>
                        <input type="checkbox" id="Botte">   -->
                    </p>
                    <img src="Assets/Images/logo-anneaux.png" alt="logo-amulette" id="Anneau" />
                    <!-- <label>Botte</label>
                        <input type="checkbox" id="Botte">   -->
                    </p>
                    <img src="Assets/Images/logo-trophee.png" alt="logo-amulette" id="Trophee" />
                    <!-- <label>Botte</label>
                        <input type="checkbox" id="Botte">   -->
                    </p>
                    <img src="Assets/Images/logo-bouclier.png" alt="logo-amulette" id="Bouclier" />
                    <!-- <label>Botte</label>
                        <input type="checkbox" id="Botte">   -->
                    </p>
                    <p>
                        <img src="Assets/Images/logo-arme.png" alt="logo-amulette" id="Armes" />
                        <!-- <label>Arme</label>
                        <input type="checkbox" id="arme"> -->
                    </p>
                </div>
            </div>
        </nav>
    </div>
    <div class="fond">
        <div class="card-header" id="stuff_filtreNom">
            <div class="d-flex justify-content-center w-100" >
                <input class="form-control w-25" type="text" id="NomEquipement" placeholder="Nom de l'équipement">
                <input class="form-control w-25" type="number" id="NiveauMin" placeholder="Niveau min">
                <input class="form-control w-25" type="number" id="NiveauMax" placeholder="Niveau max">
                <button id="filter-submit">Filtrer</button>
                <button id="unfilter">Réinitialiser</button>
            </div>
        </div>
        <div class="row" id="listing"></div>
    </div>
    <!-- <div>
        <div id='tab'></div>
    </div> -->

    <script src="Assets/JS/stuff.js"></script>
