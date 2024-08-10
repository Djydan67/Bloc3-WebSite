let numeroPage = 0;
let taillePage = 12; // Valeur par défaut
let equipementsAfficher = [];
let equipements = [];
let descriptionAfficher = false;

document.getElementById("Amulette").addEventListener("click", afficheStuff);
document.getElementById("Ceinture").addEventListener("click", afficheStuff);
document.getElementById("Bottes").addEventListener("click", afficheStuff);
document.getElementById("Dofus").addEventListener("click", afficheStuff);
document.getElementById("Cape").addEventListener("click", afficheStuff);
document.getElementById("Chapeau").addEventListener("click", afficheStuff);
document.getElementById("Anneau").addEventListener("click", afficheStuff);
document.getElementById("Trophee").addEventListener("click", afficheStuff);
document.getElementById("Bouclier").addEventListener("click", afficheStuff);
document.getElementById("Armes").addEventListener("click", afficheStuff);

document.getElementById("filter-submit").addEventListener("click", modifFiltre);
document.getElementById("unfilter").addEventListener("click", unfilter);

// Réinitialise les filtres
function unfilter() {
  document.getElementById("NomEquipement").value = "";
  document.getElementById("NiveauMin").value = "";
  document.getElementById("NiveauMax").value = "";

  modifFiltre();
}

// Filtre en fonctions des informations entrées dans les inputs
function modifFiltre() {
  let exact = false;
  numeroPage = 0;
  let nomEquipement = document
    .getElementById("NomEquipement")
    .value.toUpperCase();
  let niveauMin = parseInt(document.getElementById("NiveauMin").value) || 0;
  let niveauMax =
    parseInt(document.getElementById("NiveauMax").value) || Infinity;

  equipementsAfficher = [];

  equipements.forEach((el) => {
    if (el.stuff_name.toUpperCase() === nomEquipement) {
      exact = true;
      equipementsAfficher = [el];
    }

    let nomValide =
      el.stuff_name.toUpperCase().includes(nomEquipement) && !exact;
    let niveauValide =
      el.stuff_level >= niveauMin && el.stuff_level <= niveauMax;

    if (nomValide && niveauValide) {
      equipementsAfficher.push(el);
    }
  });

  affichePage();
}

document.addEventListener("DOMContentLoaded", afficheToutStuff);

// Récupère les données des équipements
function afficheToutStuff() {
  numeroPage = 0;
  document.getElementById("stuff_listing").innerHTML = "";
  fetch(
    "http://localhost/Bloc3-WebSite-main/index.php/?ctrl=stuff&action=getEquipementsJson"
  )
    .then((res) => {
      console.log(res);
      if (!res.ok) {
        throw new Error("Erreur de réseau");
      }
      return res.json();
    })
    .then((data) => {
      console.log(data);
      equipements = data;
      equipementsAfficher = [...equipements];
      affichePage();
    })
    .catch((error) => {
      console.error("Erreur lors de la récupération des données:", error);
    });
}

// Affiche les équipements en fonction de la pièce sélectionnée
function afficheStuff(e) {
  numeroPage = 0;
  document.getElementById("stuff_listing").innerHTML = "";
  let pieceId = e.target.id;
  equipementsAfficher = equipements.filter(
    (item) => item.stuff_pieces === pieceId
  );
  affichePage();
}

// Affiche les équipements sous forme de carte
function affichePage() {
  let container = document.getElementById("stuff_listing");
  container.innerHTML = "";

  for (
    let i = taillePage * numeroPage;
    i < equipementsAfficher.length && i < taillePage * (numeroPage + 1);
    i++
  ) {
    let item = equipementsAfficher[i];
    container.innerHTML +=
      '<div id="card-stuff" class="card col-11">' +
      '<div class="card-title d-flex justify-content-between">' +
      "<p>" +
      item.stuff_name +
      "</p>" +
      '<img class="amulette" src="' +
      item.stuff_imgPath +
      '" alt="Image"/>' +
      "</div>" +
      '<div class="d-flex justify-content-between">' +
      "<p>Niveau " +
      item.stuff_level +
      "</p>" +
      (item.stuff_setType === null ? "" : "<p>Ilevel : " + item.stuff_setType) +
      "<p>" +
      "</div>" +
      "<hr />" +
      '<div class="card-body">' +
      '<p class="stuff_description short-text"><span>' +
      item.stuff_description +
      "</span><p>" +
      "</div>" +
      "</div>";
  }
  affichePagination();
  afficheDetailDescription();
}

// Affiche ou cache la description complète de l'équipement
function afficheDetailDescription() {
  document.querySelectorAll(".stuff_description").forEach(function (el) {
    el.addEventListener("click", function () {
      this.classList.toggle("short-text"); //Bascule la classe 'short-text' en fonction de sa présence ou non
    });
  });
}

// Affiche la pagination
function affichePagination() {
  let container = document.getElementById("stuff_listing");
  let nbPages = Math.ceil(equipementsAfficher.length / taillePage); // Calcul du nombre de pages et récupère le nombre entier inférieur

  let listePage = '<div class="d-flex justify-content-between">';

  // Sélecteur de taille de page
  listePage +=
    '<select id="pageSizeSelect" class="form-select" style="width: auto;">' +
    '<option value="6"' +
    (taillePage == 6 ? " selected" : "") +
    ">6</option>" +
    '<option value="12"' +
    (taillePage == 12 ? " selected" : "") +
    ">12</option>" +
    '<option value="24"' +
    (taillePage == 24 ? " selected" : "") +
    ">24</option>" +
    "</select>";

  listePage += '<nav aria-label="Page navigation"><ul class="pagination mb-0">';

  // Bouton précédent
  listePage +=
    '<li class="page-item ' +
    (numeroPage === 0 ? "disabled" : "") +
    '">' +
    '<a class="page-link" href="#" aria-label="Previous" id="prev">' +
    '<span aria-hidden="true">&laquo;</span></a></li>';

  // Numéros de page
  if (nbPages <= 6) {
    for (let i = 0; i < nbPages; i++) {
      listePage +=
        '<li class="page-item ' +
        (i === numeroPage ? "active" : "") +
        '">' +
        '<a class="page-link" href="#" id="page-' +
        i +
        '">' +
        (i + 1) +
        "</a></li>";
    }
  } else {
    let startPage = Math.max(numeroPage - 3, 0);
    let endPage = Math.min(numeroPage + 3, nbPages - 1);

    if (numeroPage - 2 < 0) {
      endPage = Math.min(5, nbPages - 1);
    }
    if (numeroPage + 2 >= nbPages) {
      startPage = Math.max(nbPages - 5, 0);
    }

    for (let i = startPage; i <= endPage; i++) {
      listePage +=
        '<li class="page-item ' +
        (i === numeroPage ? "active" : "") +
        '">' +
        '<a class="page-link" href="#" id="page-' +
        i +
        '">' +
        (i + 1) +
        "</a></li>";
    }
  }

  // Bouton suivant
  listePage +=
    '<li class="page-item ' +
    (numeroPage === nbPages - 1 ? "disabled" : "") +
    '">' +
    '<a class="page-link" href="#" aria-label="Next" id="next">' +
    '<span aria-hidden="true">&raquo;</span></a></li>';

  listePage += "</ul></nav></div>";

  document.getElementById("pagination").innerHTML = listePage;

  // Retourne à la page précédente au clique sur le bouton, si on n'est pas déjà à la première page
  document.getElementById("prev").addEventListener("click", () => {
    if (numeroPage > 0) {
      numeroPage--;
      affichePage();
    }
  });

  // Passe à la page suivante au clique sur le bouton, si on n'est pas déjà à la dernière page
  document.getElementById("next").addEventListener("click", () => {
    if (numeroPage < nbPages - 1) {
      numeroPage++;
      affichePage();
    }
  });

  let pageLinks = document.querySelectorAll('.page-link[id^="page-"]');
  pageLinks.forEach((link) => {
    link.addEventListener("click", (e) => {
      numeroPage = parseInt(e.target.id.split("-")[1]);
      affichePage();
    });
  });

  // Change la taille de la page au changement de la sélection
  document.getElementById("pageSizeSelect").addEventListener("change", (e) => {
    taillePage = parseInt(e.target.value);
    numeroPage = 0; // Retour à la première page lors du changement de taille
    affichePage();
  });
}
