<div class="row mb-2">
    <?php
    include("Entities/news_entity.php");

    if (isset($arrNews) && is_array($arrNews)) {
        // Utilisation des objets
        $objNews = new News();
        $objNews->hydrate_news($arrNews); // On hydrate avec l'unique article

    ?>
        <div id="news" class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
            <div class="col p-4 d-flex flex-column position-static">
                <h3 class="mb-0"><?php echo $objNews->getTitle(); ?></h3>
                <div class="mb-1 text-body-secondary"><?php echo $objNews->getCreatedate(); ?> (<?php echo $objNews->getCreator(); ?>)</div>
                <p class="mb-auto"><?php echo $objNews->getContent(); ?></p>
            </div>
        </div>
    <?php
    } else {
        echo "<p>Aucune nouvelle disponible.</p>";
    }
    ?>
</div>