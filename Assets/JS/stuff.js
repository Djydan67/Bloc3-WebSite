fetch('../Controller/StuffController.php?action=affichage').then(res => {
    console.log(res);
    if (!res.ok) {
        throw new Error('Erreur de réseau');
    }
    return res.json();
}).then(data => {
    affichage(data);
}).catch(error => {
    console.error('Erreur lors de la récuperation des données:', error);
});

function affichage(stuffs) {
    let container = document.getElementById('listing');
    stuffs.forEach(stuff => {
        let p = document.createElement('p');
        p.textContent = stuff.setName;
        container.appendChild(p);
    })
}