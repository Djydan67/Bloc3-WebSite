<div class="row mb-2" id="article_page">
    <?php
    include("Entities/article_entity.php");
    foreach ($arrArticles as $arrDetArticle) {
        // Utilisation des objets
        $objArticle = new Article();
        $objArticle->hydrate_arr($arrDetArticle);
    ?>
        <article class="col-md-6" id="articles">
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