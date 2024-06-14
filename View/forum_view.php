<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forum Template</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            color: #343a40;
        }

        .forum-card {
            background-color: #8f8f8f;
            margin-bottom: 1em;
            padding: 0.4em;
            border-radius: 0.5rem;
        }

        .card-text {
            margin-left: 1em;
        }

        .response-card {
            background-color: #ffffff;
            color: #e0e0e0;
            /* margin-bottom: 0.1em; */
            border: 1px solid #e0e0e0;
            /* border-radius: 0.5rem; */
        }

        .response-card .card-body {
            padding: 0.4rem;
            background-color: #343a40;
            /* border-radius: 0.5rem; */
        }

        .response-card .card-title {
            font-size: 1.25rem;
            color: #e0e0e0;
            font-weight: bold;
        }

        .response-card .card-text,
        .response-card small {
            font-size: 1rem;
        }

        .theme-btn {
            margin-right: 0.5rem;
            margin-bottom: 0.5rem;
            border-radius: 0.5rem;
        }

        .forum-list {
            margin-top: 2rem;
        }

        .search-bar {
            margin-bottom: 1rem;
            border-radius: 0.5rem;
        }

        .list-group-item {
            border: 1px solid #e0e0e0;
            border-radius: 0.5rem;
            margin-bottom: 1rem;
        }

        #createForumFormContainer {
            background-color: #ffffff;
            padding: 2rem;
            border: 1px solid #e0e0e0;
            border-radius: 0.5rem;
            margin-top: 2rem;
        }

        #createForumForm .form-control,
        #createForumForm .btn {
            border-radius: 0.5rem;
        }
    </style>
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
                <input type="text" class="form-control search-bar" id="themeSearch" placeholder="Search Themes...">
                <div class="btn-group" role="group" aria-label="Themes" id="themeButtons">
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

        <!-- Create Forum Button -->
        <button id="showCreateForumForm" class="btn btn-primary my-4">Create Forum</button>

        <!-- Create Forum Form -->
        <div id="createForumFormContainer" style="display: none;">
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
                        <?php
                        foreach ($arrThemes as $arrDetTheme) {
                            $objTheme = new Theme();
                            $objTheme->hydrate($arrDetTheme);
                            echo '<option value="' . $objTheme->getThemeId() . '">' . htmlspecialchars($objTheme->getThemeName()) . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Create Forum</button>
                <button id="hideCreateForumForm" type="button" class="btn btn-secondary">Close</button>
            </form>
        </div>

        <h2>Forums:</h2>
        <input type="text" class="form-control search-bar" id="forumSearch" placeholder="Search Forums...">
        <div class="forum-list">
            <div class="list-group" id="forums-container">
                <p>Select a theme to view forums.</p>
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
                                        <div class="forum-card">
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
                                                <div class="response-card">
                                                    <div class="card-body">
                                                        <h5 class="card-title">${response.user_pseudo}</h5>
                                                        <p class="card-text">${response.reponse_message}</p>
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

                                    // Add form for creating response
                                    responsesContainer.innerHTML += `
                                        <form class="createResponseForm" data-forum-id="${forumId}">
                                            <div class="form-group">
                                                <label for="responseMessage">Your Response</label>
                                                <textarea class="form-control responseMessage" rows="3" required></textarea>
                                            </div>

                                            <button type="submit" class="btn btn-primary">Submit Response</button>
                                        </form>
                                    `;
                                    handleResponseForm();
                                }
                            })
                            .catch(error => {
                                document.getElementById('responses-container').innerHTML = '<p>Error fetching responses. Please try again.</p>';
                                console.error('Error fetching responses:', error);
                            });
                    });
                });
            }

            function handleResponseForm() {
                const responseForms = document.querySelectorAll('.createResponseForm');
                responseForms.forEach(form => {
                    form.addEventListener('submit', function(event) {
                        event.preventDefault();
                        const forumId = this.getAttribute('data-forum-id');
                        const message = this.querySelector('.responseMessage').value;

                        const url = `../index.php?ctrl=forum&action=createResponse&`;
                        fetch(url, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json'
                                },
                                body: JSON.stringify({
                                    message: message,
                                    user_id: "2",
                                    forum_id: forumId
                                })
                            })
                            .then(response => {
                                if (!response.ok) {
                                    throw new Error('Network response was not ok');
                                }
                                return response.json();
                            })
                            .then(data => {
                                if (data.success) {
                                    alert('Response created successfully!');
                                    this.reset();
                                } else {
                                    alert('Error: ' + data.error);
                                }
                            })
                            .catch(error => {
                                console.error('Error creating response:', error);
                            });
                    });
                });
            }

            // Show and hide create forum form
            document.getElementById('showCreateForumForm').addEventListener('click', function() {
                document.getElementById('createForumFormContainer').style.display = 'block';
                this.style.display = 'none';
            });

            document.getElementById('hideCreateForumForm').addEventListener('click', function() {
                document.getElementById('createForumFormContainer').style.display = 'none';
                document.getElementById('showCreateForumForm').style.display = 'block';
            });

            // Handle create forum form submission
            document.getElementById('createForumForm').addEventListener('submit', function(event) {
                event.preventDefault();
                const title = document.getElementById('forumTitle').value;
                const message = document.getElementById('forumMessage').value;
                const themeId = document.getElementById('forumTheme').value;

                const url = `../index.php?ctrl=forum&action=createForum`;
                fetch(url, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            titre: title,
                            message: message,
                            user_id: "1",
                            theme_id: themeId
                        })
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            alert('Forum created successfully!');
                            this.reset();
                            document.getElementById('createForumFormContainer').style.display = 'none';
                            document.getElementById('showCreateForumForm').style.display = 'block';
                        } else {
                            alert('Error: ' + data.error);
                        }
                    })
                    .catch(error => {
                        console.error('Error creating forum:', error);
                    });
            });

            // Theme search functionality
            document.getElementById('themeSearch').addEventListener('input', function() {
                const searchValue = this.value.toLowerCase();
                const themes = document.querySelectorAll('.theme-btn');
                themes.forEach(theme => {
                    const themeName = theme.querySelector('h3').innerText.toLowerCase();
                    if (themeName.includes(searchValue)) {
                        theme.style.display = 'block';
                    } else {
                        theme.style.display = 'none';
                    }
                });
            });

            // Forum search functionality
            document.getElementById('forumSearch').addEventListener('input', function() {
                const searchValue = this.value.toLowerCase();
                const forums = document.querySelectorAll('.forum-item');
                forums.forEach(forum => {
                    const forumTitle = forum.querySelector('h5').innerText.toLowerCase();
                    if (forumTitle.includes(searchValue)) {
                        forum.style.display = 'block';
                    } else {
                        forum.style.display = 'none';
                    }
                });
            });
        });
    </script>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>