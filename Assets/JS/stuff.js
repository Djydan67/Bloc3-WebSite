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
    document.getElementById('listing').innerHTML = '';
    fetch('index.php/?ctrl=stuff&action=equipements&pieces=' + encodeURIComponent(e.target.id)
    ).then(res => {            
        console.log(res)

            if (!res.ok) {
                throw new Error('Erreur de réseau');
            }
            return res.json();
        }).then(res => {
            console.log(res.list)
            let container = document.getElementById('listing');
            res.forEach(res => {
                console.log(res.imgPath)
                container.innerHTML += '<div id="card-stuff" class="card col-10">' +
                                            '<div class="card-title" id="titre">' +
                                                '<p>' + res.setName + '</p>' +
                                                '<img class="amulette" src="' + res.imgPath+'" alt="Image"/>' +
                                            '</div>' +
                                            '<div id="sous-titre">' +
                                                '<p>Niveau ' + res.level + '</p>'+ 
                                                '<p>Ilevel : ' + (res.setType === null ? '' : res.setType)  + '<p>' +
                                            '</div>' +
                                            '<hr />' +
                                            '<div class="card-body">' +
                                            '<p>' + res.description + '<p>' +
                                            '</div>'+ 
                                        '</div>';

            }) 
            container.innerHTML +=
                '<nav aria-label="Page navigation example">'+ 
                    '<ul class="pagination">'+
                        '<li class="page-item">'+
                        '<a class="page-link" href="#" aria-label="Previous">'+
                            '<span aria-hidden="true">&laquo;</span>'+
                        '</a>'+
                        '</li>'+
                        '<li class="page-item"><a class="page-link" href="#">1</a></li>'+
                        '<li class="page-item"><a class="page-link" href="#">2</a></li>'+
                        '<li class="page-item"><a class="page-link" href="#">3</a></li>'+
                        '<li class="page-item">'+
                        '<a class="page-link" href="#" aria-label="Next">'+
                            '<span aria-hidden="true">&raquo;</span>'+
                        '</a>'+
                        '</li>'+
                    '</ul>'+
                '</nav>'           
        }).catch(error => {
        console.error('Erreur lors de la récupération des données:', error);
    });
}
