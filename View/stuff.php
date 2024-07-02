<div class="container-fluid">
    <div class="row fond">
        <!-- <div id="entete"> -->
        <h1 id="title" class="stuff_boutton">Bibliothèque</h1>
        <div class="col-1">
            <nav class="">
                <ul class="nav flex-column"><!-- <div id="corps"> -->
                    <!-- <div id="filtre"> -->
                    <li class="nav-item m-2">
                        <button type="button" class="btn stuff_boutton">
                            <img src="Assets/Images/logo-amulette.png" alt="logo-amulette" id="Amulette" />
                            <!-- <label>Tête</label>
                                <input type="checkbox" id="tete"> -->
                        </button>
                    </li>
                    <li class="nav-item m-2">
                        <button type="button" class="btn stuff_boutton">
                            <img src="Assets/Images/logo-ceinture.png" alt="logo-amulette" id="Ceinture" />
                            <!-- <label>Torse</label>
                                <input type="che<ul class="nav flex-column bg-success">flexckbox" id="torse">  -->
                        </button>
                    </li>
                    <li class="nav-item m-2">
                        <button type="button" class="btn stuff_boutton">
                            <img src="Assets/Images/logo-dofus_(2).png" alt="logo-amulette" id="Dofus" />
                            <!-- <label>Bras</label>
                                <input type="checkbox" id="bras"> -->
                        </button>
                    </li>
                    <li class="nav-item m-2">
                        <button type="button" class="btn stuff_boutton">
                            <img src="Assets/Images/logo-botte.png" alt="logo-amulette" id="Bottes" />
                            <!-- <label>Botte</label>
                                <input type="checkbox" id="Botte">   -->
                        </button>
                    </li>
                    <li class="nav-item m-2">
                        <button type="button" class="btn stuff_boutton">
                            <img src="Assets/Images/logo-cape.png" alt="logo-amulette" id="Cape" />
                            <!-- <label>Botte</label>
                                <input type="checkbox" id="Botte">   -->
                        </button>
                    </li>
                    <li class="nav-item m-2">
                        <button type="button" class="btn stuff_boutton">
                            <img src="Assets/Images/logo-chapeau.png" alt="logo-amulette" id="Chapeau" />
                            <!-- <label>Botte</label>
                                <input type="checkbox" id="Botte">   -->
                        </button>
                    </li>
                    <li class="nav-item m-2">
                        <button type="button" class="btn stuff_boutton">
                            <img src="Assets/Images/logo-anneaux.png" alt="logo-amulette" id="Anneau" />
                            <!-- <label>Botte</label>
                                    <input type="checkbox" id="Botte">   -->
                        </button>
                    </li>
                    <li class="nav-item m-2">
                        <button type="button" class="btn stuff_boutton">
                            <img src="Assets/Images/logo-trophee.png" alt="logo-amulette" id="Trophee" />
                            <!-- <label>Botte</label>
                                    <input type="checkbox" id="Botte">   -->
                        </button>
                    </li>
                    <li class="nav-item m-2">
                        <button type="button" class="btn stuff_boutton">
                            <img src="Assets/Images/logo-bouclier.png" alt="logo-amulette" id="Bouclier" />
                            <!-- <label>Botte</label>
                                    <input type="checkbox" id="Botte">   -->
                        </button>
                    </li>
                    <li class="nav-item m-2">
                        <button type="button" class="btn stuff_boutton">
                            <img src="Assets/Images/logo-arme.png" alt="logo-amulette" id="Armes" />
                            <!-- <label>Arme</label>
                                <input type="checkbox" id="arme"> -->
                        </button>
                    </li>
                    <!-- </div> -->
                </ul>
            </nav>
        </div>
        <div class="col-11">
            <div class="d-flex justify-content-center" id="stuff_filtreNom">
                <div class="d-flex">
                    <input class="form-control w-25 m-2" type="text" id="NomEquipement" placeholder="Nom de l'équipement">
                    <input class="form-control w-25 m-2" type="number" id="NiveauMin" placeholder="Niveau min">
                    <input class="form-control w-25 m-2" type="number" id="NiveauMax" placeholder="Niveau max">
                    <button id="filter-submit" class="btn stuff_boutton m-2">Filtrer</button>
                    <button id="unfilter" class="btn stuff_boutton m-2">Réinitialiser</button>
                </div>
            </div>
            <div class="row" id="listing"></div>
            <!-- </div>  -->
            <!-- <div> -->
            <div id='pagination'></div>
        </div>
    </div>
</div>
<script src="Assets/JS/stuff.js"></script>