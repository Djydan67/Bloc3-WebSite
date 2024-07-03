<!-- <?php
        //$strPage	= "index";
        //$strTitleH1	= "Accueil";
        //$strFirstP	= "Page d'acceuil";
        //include("_partial/header.php");
        ?> -->
<div id="Index">
    <main>
        <div id="background-container">
        </div>
        <div id="IndexText">
            <h2>Bienvenue sur DofusHelp</h2>
            <br>
            <p>
                Sur notre site, vous pourrez tester tout les équipements du jeux avec votre personnage !<br>
                Essayer vos combinaisons pour optimiser votre perso au maximum !
            </p>
        </div>
        <div class="container">
            <!-- Élément carrousel -->
            <div class="carousel">
                <!-- Conteneur interne pour les diapositives -->
                <div class="carousel-inner">
                    <!-- Première diapositive -->
                    <div class="slide">
                        <!-- Image de la première diapositive -->
                        <img src="Assets\Images\dldofus.png" alt="Image 1">
                    </div>
                    <!-- Deuxième diapositive -->
                    <div class="slide">
                        <!-- Image de la deuxième diapositive -->
                        <img src="Assets\Images\forum.png" alt="Image 2">
                    </div>
                    <!-- Troisième diapositive -->
                    <div class="slide">
                        <!-- Image de la troisième diapositive -->
                        <img src="Assets\Images\dofushelp_banner.jpg" alt="Image 3">
                    </div>
                </div>
                <!-- Conteneur pour les boutons de navigation -->
                <div class="carousel-controls">
                    <!-- Bouton pour passer à la diapositive précédente -->
                    <button id="prev">Précédent</button>
                    <!-- Bouton pour passer à la diapositive suivante -->
                    <button id="next">Suivant</button>
                </div>
                <!-- Conteneur pour les points de navigation -->
                <div class="carousel-dots"></div>
            </div>
        </div>
        <script>
            (function() {
                "use stict"
                const slideTimeout = 5000; // Récupère les boutons de navigation
                const prev = document.querySelector('#prev');
                const next = document.querySelector('#next'); // Récupère tous les éléments de type "slide"
                const $slides = document.querySelectorAll('.slide'); // Initialisation de la variable pour les "dots"
                let $dots;
                let intervalId;
                let currentSlide = 1;

                function slideTo(index) {
                    currentSlide = index >= $slides.length || index < 1 ? 0 : index;
                    $slides.forEach($elt => $elt.style.transform = `translateX(-${currentSlide * 100}%)`);
                    $dots.forEach(($elt, key) => $elt.classList = `dot ${key === currentSlide? 'active': 'inactive'}`);
                }

                function showSlide() {
                    slideTo(currentSlide);
                    currentSlide++;
                }
                for (let i = 1; i <= $slides.length; i++) {
                    let dotClass = i == currentSlide ? 'active' : 'inactive';
                    let $dot = `<span data-slidId="${i}" class="dot ${dotClass}"></span>`;
                    document.querySelector('.carousel-dots').innerHTML += $dot;
                }
                $dots = document.querySelectorAll('.dot');
                $dots.forEach(($elt, key) => $elt.addEventListener('click', () => slideTo(key))); // Ajout d'un écouteur d'événement "click" sur le bouton "prev" pour afficher le slide précédent
                prev.addEventListener('click', () => slideTo(--currentSlide)) // Ajout d'un écouteur d'événement "click" sur le bouton "next" pour afficher le slide suivant
                next.addEventListener('click', () => slideTo(++currentSlide))
                intervalId = setInterval(showSlide, slideTimeout)
                $slides.forEach($elt => {
                    let startX;
                    let endX;
                    $elt.addEventListener('mouseover', () => {
                        clearInterval(intervalId);
                    }, false)
                    $elt.addEventListener('mouseout', () => {
                        intervalId = setInterval(showSlide, slideTimeout);
                    }, false);
                    $elt.addEventListener('touchstart', (event) => {
                        startX = event.touches[0].clientX;
                    });
                    $elt.addEventListener('touchend', (event) => {
                        endX = event.changedTouches[0].clientX; // Si la position initiale est plus grande que la position finale, affiche le prochain slide
                        if (startX > endX) {
                            slideTo(currentSlide + 1); // Si la position initiale est plus petite que la position finale, affiche le slide précédent
                        } else if (startX < endX) {
                            slideTo(currentSlide - 1);
                        }
                    });
                })
            })()
        </script>
</div>
</div>