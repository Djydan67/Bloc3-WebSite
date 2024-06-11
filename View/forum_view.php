<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forum Template</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: black; }
        .forum-list { margin: 20px 0; }
        .forum-list .list-group-item { margin-bottom: 10px; }
    </style>
</head>
<body>
<div class="container">
    <h1 class="my-4">Forum</h1>
    
    <?php
    include("Entities/forum_entity.php");
    include("Model/forum_model.php");

    // Assume $arrForums is fetched from the database
    $forumModel = new Forum_model();
    $arrForums = $forumModel->getAllByTheme(1); // Example theme ID

    if ($arrForums !== false) {
        foreach ($arrForums as $arrDetForum) {
            // Utilisation des objets
            $objForum = new Forum();
            $objForum->hydrate($arrDetForum);
    ?>
            <h3 class="mb-0"><?php echo htmlspecialchars($objForum->getTitle()); ?></h3>
            <div class="forum-list">
                <div class="list-group">
                    <a href="#" class="list-group-item list-group-item-action">
                        <h5 class="mb-1"><?php echo htmlspecialchars($objForum->getTitle()); ?></h5>
                        <p class="mb-1"><?php echo htmlspecialchars($objForum->getMessage()); ?></p>
                        <small><?php echo htmlspecialchars($objForum->getDate()); ?></small>
                    </a>
                </div>
            </div>
    <?php
        }
    } else {
        echo "No forum topics found.";
    }
    ?>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
