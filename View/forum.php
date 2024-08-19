<?php
include("Entities/forum_entity.php");
include("Model/forum_model.php");

$forumModel = new Forum_model();
$arrThemes = $forumModel->getAllThemes();
$userLoggedIn = isset($_SESSION['user']);
// echo var_dump($_SESSION['user']);
$user_id = $userLoggedIn ? $_SESSION['user']['user_id'] : null;
$droit_description = $userLoggedIn ? $_SESSION['user']['droit_description'] : null;
?>

<script>
    const userId = <?php echo json_encode($user_id); ?>;
    const droit = <?php echo json_encode($droit_description); ?>;
    const isLoggedIn = <?php echo json_encode($userLoggedIn); ?>;
</script>
<div id="Index" class="forum">
    <div class="container">
        <h1 class="my-4" style="color: white;">Bienvenu dans Forum Dofus !</h1>
        <div class="forum-container">
            <div class="pageHeader">
                <h2>Choisissez un thème :</h2>
            </div>
            <?php if ($droit_description === 'administrateur' || $droit_description === 'moderateur') : ?>
                <div id="deleteThemeContainer" class="delete-theme-container">
                    <h2>Admin Only!</h2>
                    <div>
                        <button type="button" class="btn admin-theme-btn" id="deleteThemeButton">Delete Theme</button>
                        <select id="themeSelect" class="form-control my-2" style="display:none;">
                            <?php foreach ($arrThemes as $arrDetTheme) :
                                $objTheme = new Theme();
                                $objTheme->hydrate($arrDetTheme);
                                if ($objTheme->getIsActive() === 1) {
                                    echo '<option value="' . $objTheme->getThemeId() . '">' . htmlspecialchars($objTheme->getThemeName()) . '</option>';
                                }
                            endforeach; ?>
                        </select>
                        <button id="confirmDeleteThemeButton" class="btn btn-danger admin-btn" style="display:none;">Confirm Delete</button>
                    </div>
                    <button id="CreateThemeButton" class="btn admin-theme-btn">Add Theme</button>
                    <div id="createThemeContainer" style="display: none;">
                        <h2>Create a New Theme</h2>
                        <form id="createThemeForm">
                            <div class="form-group">
                                <label for="themeName">Theme Name</label>
                                <input type="text" id="themeName" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="themeDescription">Description</label>
                                <textarea id="themeDescription" class="form-control" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="themeColor">Color</label>
                                <input type="color" id="themeColor" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary admin-btn">Create Theme</button>
                        </form>
                    </div>
                </div>
            <?php endif; ?>
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
                <?php endforeach; ?>
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
            </div>
            <div class="list-group" id="forums-container">
                <div class="search-forum">
                    <h2>Forums:</h2>
                    <input type="text" class="form-control search-bar" id="forumSearch" placeholder="rechercher un forum">
                    <p>Sélectionnez un thème pour afficher les forums.</p>
                </div>
                <div id="forumContainer" class="forum-list"></div>
            </div>
        </div>
    </div>
    <script src="Assets/JS/forum.js"></script>
</div>