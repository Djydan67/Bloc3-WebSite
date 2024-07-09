document.addEventListener("DOMContentLoaded", function () {
  const themeButtons = document.querySelectorAll(".theme-btn");
  const forumsPerPageSelect = document.getElementById("forumsPerPage");
  let currentOpenForumId = null;
  let forumsPerPage = parseInt(forumsPerPageSelect.value);
  let currentPage = 1;
  let currentThemeId = null;

  themeButtons.forEach((button) => {
    button.addEventListener("click", function () {
      currentThemeId = this.getAttribute("data-theme-id");
      fetchForumsByTheme(currentThemeId, forumsPerPage, currentPage);
    });
  });

  forumsPerPageSelect.addEventListener("change", function () {
    forumsPerPage = parseInt(this.value);
    fetchForumsByTheme(currentThemeId, forumsPerPage, currentPage);
  });

  function fetchForumsByTheme(themeId, forumsPerPage, page) {
    currentThemeId = themeId;
    const url = `index.php?ctrl=forum&action=themes&theme_id=${themeId}&limit=${forumsPerPage}&page=${page}`;
    fetch(url)
      .then((response) => response.json())
      .then((data) => {
        const forumsContainer = document.getElementById("forums-container");
        forumsContainer.innerHTML = "";
        if (data.error) {
          forumsContainer.innerHTML = `<p>Error: ${data.error}</p>`;
          return;
        }
        if (data.forums.length > 0) {
          data.forums.reverse().forEach((forum) => {
            let deleteForum = "";
            if (droitId == 3) {
              deleteForum = `
                <button class="btn btn-primary deleteForum" data-forum-id="${forum.forum_id}">Delete Forum</button>
              `;
            }
            const formattedDate = formatDate(forum.forum_date);
            forumsContainer.innerHTML += `
              <div class="forum-card">
                <a href="#" class="list-group-item list-group-item-action forum-item" data-forum-id="${forum.forum_id}">
                  <h5 class="mb-1">${forum.forum_titre}</h5>
                  <p class="mb-1">${forum.forum_message} ${deleteForum}</p>
                  <small>${formattedDate}</small>
                </a>
                <div id="${forum.forum_id}_forum_response" style="display: none;"></div>
              </div>
            `;
          });
          renderPagination(data.totalForums, forumsPerPage, page);
          attachDeleteEventListeners(); // Attach event listeners to delete buttons
        } else {
          forumsContainer.innerHTML = "<p>No forum topics found.</p>";
        }
        getResponses();
      })
      .catch((error) => {
        const forumsContainer = document.getElementById("forums-container");
        forumsContainer.innerHTML =
          "<p>Error fetching forums. Please try again.</p>";
        console.error("Error fetching forums:", error);
      });
  }

  function attachDeleteEventListeners() {
    const deleteButtons = document.querySelectorAll(".deleteForum");
    deleteButtons.forEach((button) => {
      button.addEventListener("click", function () {
        const forumId = this.getAttribute("data-forum-id");
        deleteForum(forumId);
      });
    });
  }

  function deleteForum(forumId) {
    const url = `index.php?ctrl=forum&action=deleteForum`;
    fetch(url, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({
        forum_id: forumId,
      }),
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.success) {
          alert("Forum deleted successfully!");
          fetchForumsByTheme(currentThemeId, forumsPerPage, currentPage);
        } else {
          alert("Error: " + data.error);
        }
      })
      .catch((error) => {
        console.error("Error deleting forum:", error);
      });
  }

  function renderPagination(totalForums, forumsPerPage, currentPage) {
    const paginationContainer = document.getElementById("pagination-container");
    if (!paginationContainer) {
      console.error("Pagination container not found");
      return;
    }
    paginationContainer.innerHTML = "";
    const totalPages = Math.ceil(totalForums / forumsPerPage);
    for (let i = 1; i <= totalPages; i++) {
      const pageButton = document.createElement("button");
      pageButton.textContent = i;
      pageButton.classList.add("page-button");
      if (i === currentPage) {
        pageButton.classList.add("active");
      }
      pageButton.addEventListener("click", function () {
        fetchForumsByTheme(currentThemeId, forumsPerPage, i);
      });
      paginationContainer.appendChild(pageButton);
    }
  }

  function getResponses() {
    const forumItems = document.querySelectorAll(".forum-item");
    forumItems.forEach((forum) => {
      forum.addEventListener("click", function (event) {
        event.preventDefault();
        const forumId = this.getAttribute("data-forum-id");
        const url = `index.php?ctrl=forum&action=Forums&forum_id=${forumId}`;
        fetch(url)
          .then((response) => response.json())
          .then((data) => {
            if (currentOpenForumId !== null && currentOpenForumId !== forumId) {
              const currentOpenForumElement = document.getElementById(
                `${currentOpenForumId}_forum_response`
              );
              currentOpenForumElement.style.display = "none";
            }

            const responsesContainer = document.getElementById(
              `${forumId}_forum_response`
            );
            responsesContainer.innerHTML = "";
            if (data.error) {
              responsesContainer.innerHTML = `<p>Error: ${data.error}</p>`;
              return;
            }
            if (data.length > 0) {
              data.forEach((response) => {
                const formattedDate = formatDate(response.reponse_date);
                responsesContainer.innerHTML += `
                  <div class="response-card">
                    <div class="card-body">
                      <h5 class="card-title">${response.user_pseudo}</h5>
                      <p class="card-text">${response.reponse_message}</p>
                      <small class="text-muted">${formattedDate}</small>
                    </div>
                  </div>
                `;
              });
            } else {
              responsesContainer.innerHTML = "<p>No responses found.</p>";
            }
            responsesContainer.style.display = "block";
            currentOpenForumId = forumId;

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
          })
          .catch((error) => {
            const responsesContainer = document.getElementById(
              `${forumId}_forum_response`
            );
            responsesContainer.innerHTML =
              "<p>Error fetching responses. Please try again.</p>";
            console.error("Error fetching responses:", error);
          });
      });
    });
  }

  function handleResponseForm() {
    const responseForms = document.querySelectorAll(".createResponseForm");
    responseForms.forEach((form) => {
      form.addEventListener("submit", function (event) {
        event.preventDefault();
        const forumId = this.getAttribute("data-forum-id");
        const message = this.querySelector(".responseMessage").value;

        const url = `index.php?ctrl=forum&action=createResponse`;
        fetch(url, {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify({
            message: message,
            user_id: userId,
            forum_id: forumId,
          }),
        })
          .then((response) => response.json())
          .then((data) => {
            if (data.success) {
              alert("Response created successfully!");
              this.reset();
              fetchResponsesForForum(forumId);
            } else {
              alert("Error: " + data.error);
            }
          })
          .catch((error) => {
            console.error("Error creating response:", error);
          });
      });
    });
  }

  function fetchResponsesForForum(forumId) {
    const url = `index.php?ctrl=forum&action=Forums&forum_id=${forumId}`;
    fetch(url)
      .then((response) => response.json())
      .then((data) => {
        const responsesContainer = document.getElementById(
          `${forumId}_forum_response`
        );
        responsesContainer.innerHTML = "";
        if (data.error) {
          responsesContainer.innerHTML = `<p>Error: ${data.error}</p>`;
          return;
        }
        if (data.length > 0) {
          data.forEach((response) => {
            const formattedDate = formatDate(response.reponse_date);
            responsesContainer.innerHTML += `
              <div class="response-card">
                <div class="card-body">
                  <h5 class="card-title">${response.user_pseudo}</h5>
                  <p class="card-text">${response.reponse_message}</p>
                  <small class="text-muted">${formattedDate}</small>
                </div>
              </div>
            `;
          });
        } else {
          responsesContainer.innerHTML = "<p>No responses found.</p>";
        }
        responsesContainer.style.display = "block";
      })
      .catch((error) => {
        const responsesContainer = document.getElementById(
          `${forumId}_forum_response`
        );
        responsesContainer.innerHTML =
          "<p>Error fetching responses. Please try again.</p>";
        console.error("Error fetching responses:", error);
      });
  }

  document
    .getElementById("showCreateForumForm")
    .addEventListener("click", function () {
      document.getElementById("createForumFormContainer").style.display =
        "block";
      this.style.display = "none";
    });

  document
    .getElementById("hideCreateForumForm")
    .addEventListener("click", function () {
      document.getElementById("createForumFormContainer").style.display =
        "none";
      document.getElementById("showCreateForumForm").style.display = "block";
    });

  document
    .getElementById("createForumForm")
    .addEventListener("submit", function (event) {
      event.preventDefault();
      const title = document.getElementById("forumTitle").value;
      const message = document.getElementById("forumMessage").value;
      const themeId = document.getElementById("forumTheme").value;

      const url = `index.php?ctrl=forum&action=createForum`;
      fetch(url, {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify({
          titre: title,
          message: message,
          user_id: userId, // Use the user ID from session
          theme_id: themeId,
        }),
      })
        .then((response) => response.json())
        .then((data) => {
          if (data.success) {
            alert("Forum created successfully!");
            this.reset();
            fetchForumsByTheme(themeId, forumsPerPage, currentPage);
            document.getElementById("createForumFormContainer").style.display =
              "none";
            document.getElementById("showCreateForumForm").style.display =
              "block";
          } else {
            alert("Error: " + data.error);
          }
        })
        .catch((error) => {
          console.error("Error creating forum:", error);
        });
    });

  document.getElementById("themeSearch").addEventListener("input", function () {
    const searchValue = this.value.toLowerCase();
    const themes = document.querySelectorAll(".theme-btn");
    themes.forEach((theme) => {
      const themeName = theme.querySelector("h3").innerText.toLowerCase();
      theme.style.display = themeName.includes(searchValue) ? "block" : "none";
    });
  });

  document.getElementById("forumSearch").addEventListener("input", function () {
    const searchValue = this.value.toLowerCase();
    const forums = document.querySelectorAll(".forum-item");
    forums.forEach((forum) => {
      const forumTitle = forum.querySelector("h5").innerText.toLowerCase();
      forum.style.display = forumTitle.includes(searchValue) ? "block" : "none";
    });
  });

  // Add this code for delete theme functionality
  if (document.getElementById("delete-theme")) {
    document
      .getElementById("delete-theme")
      .addEventListener("click", function () {
        document.getElementById("deleteThemeContainer").style.display = "block";
      });

    document
      .getElementById("confirmDeleteTheme")
      .addEventListener("click", function () {
        const themeId = document.getElementById("themeSelect").value;
        const url = `index.php?ctrl=forum&action=deleteTheme`;
        fetch(url, {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify({
            theme_id: themeId,
          }),
        })
          .then((response) => response.json())
          .then((data) => {
            if (data.success) {
              alert("Theme deleted successfully!");
              location.reload();
            } else {
              alert("Error: " + data.error);
            }
          })
          .catch((error) => {
            console.error("Error deleting theme:", error);
          });
      });
  }
});
