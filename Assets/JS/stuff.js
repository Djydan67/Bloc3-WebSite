let numeroPage = 0;
let taillePage = 12; // Valeur par défaut
let equipementsAfficher = [];

document.getElementById('Amulette').addEventListener('click', afficheStuff);
document.getElementById('Ceinture').addEventListener('click', afficheStuff);
document.getElementById('Bottes').addEventListener('click', afficheStuff);
document.getElementById('Dofus').addEventListener('click', afficheStuff);
document.getElementById('Cape').addEventListener('click', afficheStuff);
document.getElementById('Chapeau').addEventListener('click', afficheStuff);
document.getElementById('Anneau').addEventListener('click', afficheStuff);
document.getElementById('Trophee').addEventListener('click', afficheStuff);
document.getElementById('Bouclier').addEventListener('click', afficheStuff);
document.getElementById('Armes').addEventListener('click', afficheStuff);

function afficheStuff(e) {
    numeroPage = 0;
    document.getElementById('listing').innerHTML = '';
    console.log(e.target.id)
    fetch('http://localhost/Bloc3-WebSite/index.php/?ctrl=stuff&action=equipements&pieces=' + encodeURIComponent(e.target.id))
        .then(res => {
            if (!res.ok) {
                throw new Error('Erreur de réseau');
            }
            return res.json();
        })
        .then(data => {
            console.log(data);
            equipementsAfficher = data;
            affichePage();
        })
        .catch(error => {
            console.error('Erreur lors de la récupération des données:', error);
        });
}

function affichePage() {
    let container = document.getElementById('listing');
    container.innerHTML = '';

    for (let i = taillePage * numeroPage; i < equipementsAfficher.length && i < taillePage * (numeroPage + 1); i++) {
        let item = equipementsAfficher[i];
        container.innerHTML += '<div id="card-stuff" class="card col-10">' +
            '<div class="card-title" id="titre">' +
            '<p>' + item.stuff_name + '</p>' +
            '<img class="amulette" src="' + item.stuff_imgPath + '" alt="Image"/>' +
            '</div>' +
            '<div id="sous-titre">' +
            '<p>Niveau ' + item.stuff_level + '</p>' +
            '<p>Ilevel : ' + (item.stuff_setType === null ? '' : item.stuff_setType) + '<p>' +
            '</div>' +
            '<hr />' +
            '<div class="card-body">' +
            '<p>' + item.stuff_description + '<p>' +
            '</div>' +
            '</div>';
    }

    affichePagination();
}

function affichePagination() {
    let container = document.getElementById('listing');
    let nbPages = Math.ceil(equipementsAfficher.length / taillePage);

    let listePage = '<div class="d-flex justify-content-between align-items-center">';
    
    // Sélecteur de taille de page
    listePage += '<select id="pageSizeSelect" class="form-select" style="width: auto;">' +
        '<option value="6"' + (taillePage == 6 ? ' selected' : '') + '>6</option>' +
        '<option value="12"' + (taillePage == 12 ? ' selected' : '') + '>12</option>' +
        '<option value="24"' + (taillePage == 24 ? ' selected' : '') + '>24</option>' +
        '</select>';

    listePage += '<nav aria-label="Page navigation"><ul class="pagination mb-0">';

    // Bouton précédent
    listePage += '<li class="page-item ' + (numeroPage === 0 ? 'disabled' : '') + '">' +
        '<a class="page-link" href="#" aria-label="Previous" id="prev">' +
        '<span aria-hidden="true">&laquo;</span></a></li>';

    // Numéros de page
    if (nbPages <= 6) {
        for (let i = 0; i < nbPages; i++) {
            listePage += '<li class="page-item ' + (i === numeroPage ? 'active' : '') + '">' +
                '<a class="page-link" href="#" id="page-' + i + '">' + (i + 1) + '</a></li>';
        }
    } else {
        // Logique pour les ellipses
        // ...
    }

    // Bouton suivant
    listePage += '<li class="page-item ' + (numeroPage === nbPages - 1 ? 'disabled' : '') + '">' +
        '<a class="page-link" href="#" aria-label="Next" id="next">' +
        '<span aria-hidden="true">&raquo;</span></a></li>';

    listePage += '</ul></nav></div>';

    container.innerHTML += listePage;

    // Écouteurs d'événements pour la pagination
    document.getElementById('prev').addEventListener('click', () => {
        if (numeroPage > 0) {
            numeroPage--;
            affichePage();
        }
    });

    document.getElementById('next').addEventListener('click', () => {
        if (numeroPage < nbPages - 1) {
            numeroPage++;
            affichePage();
        }
    });

    let pageLinks = document.querySelectorAll('.page-link[id^="page-"]');
    pageLinks.forEach(link => {
        link.addEventListener('click', (e) => {
            numeroPage = parseInt(e.target.id.split('-')[1]);
            affichePage();
        });
    });

    // Écouteur d'événements pour le changement de taille de page
    document.getElementById('pageSizeSelect').addEventListener('change', (e) => {
        taillePage = parseInt(e.target.value);
        numeroPage = 0; // Retour à la première page lors du changement de taille
        affichePage();
    });
}