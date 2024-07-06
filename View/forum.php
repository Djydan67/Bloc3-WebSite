<?php
include("Entities/forum_entity.php"); // Includes both Forum and Theme classes
include("Model/forum_model.php"); // Include Forum model

$forumModel = new Forum_model();
$arrThemes = $forumModel->getAllThemes();
$user_id = $_SESSION['user']['user_id'];
$droit_id = $_SESSION['user']['droit_id'];
?>
<script>
    const userId = <?php echo json_encode($user_id); ?>;
    const droitId = <?php echo json_encode($droit_id); ?>;
</script>
<div id="Index" class="forum">
    <div class="container">
        <h1 class="my-4" style="color: white;">Welcome to Forum</h1>

        <div class="forum-container">
            <div class="pageHeader">
                <h2>Themes :</h2>
                <input type="search" class="form-control search-bar" id="themeSearch" placeholder="Search Themes..." aria-label="Search">
            </div>

            <div class="btn-group" role="group" aria-label="Themes" id="themeButtons">
                <?php foreach ($arrThemes as $arrDetTheme) :
                    $objTheme = new Theme();
                    $objTheme->hydrate($arrDetTheme);
                    if ($objTheme->getIsActive() === 0) {
                        continue;
                    }
                ?>
                    <button type="button" style="background-color: <?= htmlspecialchars($objTheme->getColor()) ?>;" class="btn theme-btn" data-theme-id="<?= $objTheme->getThemeId(); ?>">
                        <h3 class="mb-0"><?= htmlspecialchars($objTheme->getThemeName()); ?></h3>
                    </button>
                <?php endforeach;
                // var_dump($_SESSION['user']);
                ?>


            </div>
            <?php if ($_SESSION['user']['droit_id'] === '3') : ?>
                <!-- Display button to delete a theme for admin users -->
                <button type="button" class="btn btn-danger delete-theme-btn" id="delete-theme">Delete Theme</button>
            <?php endif; ?>
        </div>

        <!-- Add this container for delete theme functionality -->
        <div id="deleteThemeContainer" class="delete-theme-container" style="display: none;">
            <select id="themeSelect" class="form-control my-2">
                <?php foreach ($arrThemes as $arrDetTheme) :
                    $objTheme->hydrate($arrDetTheme);
                    echo '<option value="' . $objTheme->getThemeId() . '">' . htmlspecialchars($objTheme->getThemeName()) . '</option>';
                endforeach; ?>
            </select>
            <button id="confirmDeleteTheme" class="btn btn-danger">Confirm Delete</button>
        </div>

        <div class="create-forum-card">
            <button id="showCreateForumForm" class="btn btn-primary my-4">Create Forum</button>
            <div id="createForumFormContainer" class="createForumFormContainer" style="display: none;">
                <h2>Create a Forum</h2>
                <form id="createForumForm">
                    <div class="form-group">
                        <label for="forumTitle">Title</label>
                        <input type="text" class="form-control" id="forumTitle" required>
                    </div>
                    <div class="form-group">
                        <label for="forumMessage">Message</label>
                        <textarea class="form-control" id="forumMessage" rows="3" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="forumTheme">Theme</label>
                        <select class="form-control" id="forumTheme" required>
                            <?php foreach ($arrThemes as $arrDetTheme) :
                                $objTheme->hydrate($arrDetTheme);
                                echo '<option value="' . $objTheme->getThemeId() . '">' . htmlspecialchars($objTheme->getThemeName()) . '</option>';
                            endforeach; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Create Forum</button>
                    <button id="hideCreateForumForm" type="button" class="btn btn-secondary">Close</button>
                </form>
            </div>

            <div class="search-forum">
                <h2>Forums:</h2>
                <input type="text" class="form-control search-bar" id="forumSearch" placeholder="Search Forums...">
                <div class="forum-list">
                    <div class="list-group" id="forums-container">
                        <p>Select a theme to view forums.</p>
                    </div>
                </div>
                <div>
                    <label for="forumsPerPage">Forums per page:</label>
                    <select id="forumsPerPage">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="assets/js/forum.js"></script>