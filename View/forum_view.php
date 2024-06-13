<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forum Template</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <h1 class="my-4">Forum</h1>

        <?php
        include("../Entities/forum_entity.php"); // Includes both Forum and Theme classes
        include("../Model/forum_model.php");

        // Initialize the model
        $forumModel = new Forum_model();

        // Fetch and display all themes
        $arrThemes = $forumModel->getAllThemes();
        if ($arrThemes) {
        ?>
            <div>
                <h2>Themes :</h2>
                <div class="btn-group" role="group" aria-label="Themes">
                    <?php
                    foreach ($arrThemes as $arrDetTheme) {
                        $objTheme = new Theme();
                        $objTheme->hydrate($arrDetTheme);
                    ?>
                        <button type="button" class="btn btn-secondary theme-btn" data-theme-id="<?php echo $objTheme->getThemeId(); ?>">
                            <h3 class="mb-0"><?php echo htmlspecialchars($objTheme->getThemeName()); ?></h3>
                        </button>
                    <?php
                    }
                    ?>
                </div>
            </div>
        <?php
        }
        ?>
        <h2>Forums:</h2>
        <div class="forum-list">
            <div class="list-group" id="forums-container">
                <p>Select a theme to view forums.</p>
            </div>
        </div>
    </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const themeButtons = document.querySelectorAll('.theme-btn');
            let currentOpenForumId = null;

            themeButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const themeId = this.getAttribute('data-theme-id');
                    const url = `../index.php?ctrl=forum&action=themes&theme_id=${themeId}`;
                    fetch(url)
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        })
                        .then(data => {
                            const forumsContainer = document.getElementById('forums-container');
                            forumsContainer.innerHTML = '';
                            if (data.error) {
                                forumsContainer.innerHTML = `<p>Error: ${data.error}</p>`;
                                return;
                            }
                            if (data.length > 0) {
                                data.forEach(forum => {
                                    forumsContainer.innerHTML += `
                                        <div>
                                        <a href="#" class="list-group-item list-group-item-action forum-item" data-forum-id="${forum.forum_id}">
                                            <h5 class="mb-1">${forum.forum_titre}</h5>
                                            <p class="mb-1">${forum.forum_message}</p>
                                            <small>${forum.forum_date}</small>
                                        </a>
                                        <div id="${forum.forum_id}_forum_response" style="display: none;"></div>
                                        </div>
                                    `;
                                });
                            } else {
                                forumsContainer.innerHTML = '<p>No forum topics found.</p>';
                            }
                            getResponses();
                        })
                        .catch(error => {
                            document.getElementById('forums-container').innerHTML = '<p>Error fetching forums. Please try again.</p>';
                            console.error('Error fetching forums:', error);
                        });
                });
            });

            function getResponses() {
                const forumItems = document.querySelectorAll('.forum-item');
                forumItems.forEach(forum => {
                    forum.addEventListener('click', function(event) {
                        event.preventDefault();
                        const forumId = this.getAttribute('data-forum-id');
                        const url = `../index.php?ctrl=forum&action=forums&forum_id=${forumId}`;
                        fetch(url)
                            .then(response => {
                                if (!response.ok) {
                                    throw new Error('Network response was not ok');
                                }
                                return response.json();
                            })
                            .then(data => {
                                if (currentOpenForumId !== null && currentOpenForumId !== forumId) {
                                    const currentOpenForumElement = document.getElementById(`${currentOpenForumId}_forum_response`);
                                    if (currentOpenForumElement) {
                                        currentOpenForumElement.style.display = 'none';
                                    }
                                }

                                const responsesContainer = document.getElementById(`${forumId}_forum_response`);
                                if (responsesContainer) {
                                    responsesContainer.innerHTML = '';
                                    if (data.error) {
                                        responsesContainer.innerHTML = `<p>Error: ${data.error}</p>`;
                                        return;
                                    }
                                    if (data.length > 0) {
                                        data.forEach(response => {
                                            responsesContainer.innerHTML += `
                                                <div class="card mb-4">
                                                    <div class=" response-of-user">
                                                        <h5 class=" response-of-user ">${response.user_pseudo}</h5>
                                                        <p class=" response-of-user">${response.reponse_message}</p>
                                                        <small class="text-muted">${response.reponse_date}</small>
                                                    </div>
                                                </div>
                                            `;
                                        });
                                    } else {
                                        responsesContainer.innerHTML = '<p>No responses found.</p>';
                                    }
                                    responsesContainer.style.display = 'block';
                                    currentOpenForumId = forumId;
                                }
                            })
                            .catch(error => {
                                document.getElementById('responses-container').innerHTML = '<p>Error fetching responses. Please try again.</p>';
                                console.error('Error fetching responses:', error);
                            });
                    });
                });
            }
            getResponses();
        });
    </script>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>