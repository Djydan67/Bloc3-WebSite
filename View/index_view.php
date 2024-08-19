<!-- <?php
        //$strPage	= "index";
        //$strTitleH1	= "Accueil";
        //$strFirstP	= "Page d'acceuil";
        //include("_partial/header.php");
        ?> -->
<div id="Index">
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
                    <a href="https://www.dofus.com/fr/mmorpg/telecharger">
                        <img src="Assets\Images\dldofus.png" alt="Image 1">
                    </a>
                </div>
                <!-- Deuxième diapositive -->
                <div class="slide">
                    <!-- Image de la deuxième diapositive -->
                    <a class="nav-link" href="index.php?ctrl=forum&action=allForums">
                        <img src="Assets\Images\forum-slide.png" alt="Image 2">
                    </a>
                </div>
                <!-- Troisième diapositive -->
                <div class="slide">
                    <!-- Image de la troisième diapositive -->
                    <a class="nav-link" href="index.php?ctrl=article&action=Articles">
                        <img src="Assets\Images\articles-slide.png" alt="Image 3">
                    </a>
                </div>
            </div>
            <!-- Conteneur pour les boutons de navigation -->
            <div class="carousel-controls">
                <!-- Bouton pour passer à la diapositive précédente -->
                <button id="prev">◀</button>
                <!-- Bouton pour passer à la diapositive suivante -->
                <button id="next">▶</button>
            </div>
            <!-- Conteneur pour les points de navigation -->
            <div class="carousel-dots"></div>
        </div>
    </div>
    <script>
        (function() {
            "use stict"
            const slideTimeout = 4000; // Récupère les boutons de navigation
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
    <?php
    include("Entities/article_entity.php");
    foreach ($arrArticles as $arrDetArticle) {
        // Utilisation des objets
        $objArticle = new Article();
        $objArticle->hydrate_arr($arrDetArticle);
    ?>
        <div id="title_article">
            <h1>Venez lire notre dernière article en date ! :</h1>
        </div>
        <article class="col-md-6" id="articles_index">
            <div id="art_info" class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
                <div class="col p-4 d-flex flex-column position-static">
                    <h3 class="mb-0"><?php echo $objArticle->getTitle(); ?></h3>
                    <div class="mb-1 text-body-secondary"><?php echo $objArticle->getCreatedate(); ?> (<?php echo $objArticle->getCreator(); ?>)</div>
                    <p class="mb-auto"><?php echo $objArticle->getResume(); ?></p>
                    <a href="index.php?ctrl=news&action=News&id=<?php echo $objArticle->getId(); ?>" class="icon-link gap-1 icon-link-hover stretched-link">Lire la suite</a>
                </div>
                <div class="col-auto d-none d-lg-block">
                    <img class="bd-placeholder-img" width="200" height="250" alt="<?php echo $objArticle->getTitle(); ?>" src="assets/images/<?php echo $objArticle->getImg(); ?>">
                </div>
            </div>
        </article>
    <?php
    }
    ?>
</div>
</div>