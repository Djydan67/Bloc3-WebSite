document.addEventListener("DOMContentLoaded", function () {
  // Element references
  const deleteThemeButton = document.getElementById("deleteThemeButton");
  const themeSelect = document.getElementById("themeSelect");
  const confirmDeleteThemeButton = document.getElementById(
    "confirmDeleteThemeButton"
  );
  const createThemeButton = document.getElementById("CreateThemeButton");
  const createThemeContainer = document.getElementById("createThemeContainer");
  const createThemeForm = document.getElementById("createThemeForm");
  const themeButtons = document.querySelectorAll(".theme-btn");
  const forumContainer = document.getElementById("forumContainer");
  const paginationControls = document.getElementById("paginationControls");
  const prevPageButton = document.getElementById("prevPageButton");
  const nextPageButton = document.getElementById("nextPageButton");
  const currentPageInfo = document.getElementById("currentPageInfo");
  const showCreateForumFormButton = document.getElementById(
    "showCreateForumForm"
  );
  const hideCreateForumFormButton = document.getElementById(
    "hideCreateForumForm"
  );
  const createForumFormContainer = document.getElementById(
    "createForumFormContainer"
  );
  const createForumForm = document.getElementById("createForumForm");
  const forumSearchInput = document.getElementById("forumSearch");

  let currentPage = 1;
  let totalPages = 1;
  let selectedThemeId = null;
  let allForums = [];

  // Generic functions

  async function fetchData(url, options = {}) {
    try {
      const response = await fetch(url, options);
      if (!response.ok) {
        throw new Error(`HTTP error! status: ${response.status}`);
      }
      return response.json();
    } catch (error) {
      console.error("Fetch error:", error);
      throw error;
    }
  }

  function handleApiResponse(promise, successMessage, reload = false) {
    promise
      .then((data) => {
        if (data.success) {
          alert(successMessage);
          if (reload) {
            window.location.reload();
          }
        } else {
          console.error("Server error:", data.message);
          alert("Error: " + data.message);
        }
      })
      .catch((error) => {
        console.error("Request failed:", error);
        alert("An error occurred. Please try again later.");
      });
  }

  function toggleVisibility(element) {
    element.style.display =
      element.style.display === "none" || element.style.display === ""
        ? "block"
        : "none";
  }

  function toggleButtonText(button, text1, text2) {
    button.innerText = button.innerText === text1 ? text2 : text1;
  }

  function toggleButtonColor(button, color1, color2) {
    button.style.backgroundColor =
      button.style.backgroundColor === color1 ||
      button.style.backgroundColor === ""
        ? color2
        : color1;
  }

  if (droit === "administrateur" || droit === "moderateur") {
    deleteThemeButton.innerText = "Delete Theme";
    createThemeButton.innerText = "Add Theme";
    deleteThemeButton.style.backgroundColor = "#749245";
    createThemeButton.style.backgroundColor = "#749245";

    deleteThemeButton.addEventListener("click", function () {
      toggleButtonText(deleteThemeButton, "Delete Theme", "Cancel");
      toggleVisibility(themeSelect);
      toggleVisibility(confirmDeleteThemeButton);
      toggleButtonColor(
        deleteThemeButton,
        "rgb(116, 146, 69)",
        "rgb(199, 30, 52)"
      ); // Green to Red
    });

    createThemeButton.addEventListener("click", function () {
      toggleButtonText(createThemeButton, "Add Theme", "Cancel");
      toggleVisibility(createThemeContainer);
      toggleButtonColor(
        createThemeButton,
        "rgb(116, 146, 69)",
        "rgb(199, 30, 52)"
      ); // Green to Red
    });

    createThemeForm.addEventListener("submit", function (event) {
      event.preventDefault();
      const themeName = document.getElementById("themeName").value;
      const themeDescription =
        document.getElementById("themeDescription").value;
      const themeColor = document.getElementById("themeColor").value;
      const url = "index.php?ctrl=forum&action=createTheme";
      const options = {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
          theme_name: themeName,
          description: themeDescription,
          color: themeColor,
        }),
      };

      fetchData(url, options)
        .then((data) => {
          if (data.success) {
            alert("Theme created successfully!");
            window.location.reload();
          } else {
            alert("Error creating theme: " + data.error);
          }
        })
        .catch((error) => {
          console.error("Error creating theme:", error);
        });
    });

    confirmDeleteThemeButton.addEventListener("click", function () {
      const selectedThemeId = themeSelect.value;
      if (selectedThemeId) {
        if (confirm("Are you sure you want to delete this theme?")) {
          deleteTheme(selectedThemeId);
        }
      } else {
        alert("Please select a theme to delete.");
      }
    });
  }

  themeButtons.forEach((button) => {
    button.addEventListener("click", function () {
      selectedThemeId = this.dataset.themeId;
      fetchForumsByTheme(selectedThemeId, 1); // Load first page by default
    });
  });

  showCreateForumFormButton.addEventListener("click", function () {
    createForumFormContainer.style.display = "block";
  });

  hideCreateForumFormButton.addEventListener("click", function () {
    createForumFormContainer.style.display = "none";
  });

  forumSearchInput.addEventListener("input", function () {
    const searchQuery = this.value.toLowerCase();
    const filteredForums = allForums.filter(
      (forum) =>
        forum.forum_titre.toLowerCase().includes(searchQuery) ||
        forum.forum_message.toLowerCase().includes(searchQuery)
    );
    displayForums(filteredForums);
  });

  function fetchForumsByTheme(themeId, page = 1) {
    console.log(`Fetching forums for theme ${themeId} on page ${page}`);
    const url = `index.php?ctrl=forum&action=getForumsByTheme&theme_id=${themeId}&page=${page}`;
    fetchData(url)
      .then((data) => {
        if (data.error) {
          alert("Error fetching forums: " + data.error);
          return;
        }
        if (Array.isArray(data.forums)) {
          console.log("Forums fetched: ", data.forums);
          allForums = data.forums; // Store all fetched forums
          displayForums(data.forums);
          updatePagination(data.currentPage, data.totalPages);
        } else {
          console.error("Unexpected response format:", data);
          alert("Unexpected response format.");
        }
      })
      .catch((error) => {
        console.error("Error fetching forums:", error);
      });
  }

  function displayForums(forums) {
    forumContainer.innerHTML = ""; // Clear the current list of forums
    if (forums.length === 0) {
      forumContainer.innerHTML = "<p>No forums available for this theme.</p>";
      return;
    }

    forums.forEach((forum) => {
      const forumCard = document.createElement("div");
      forumCard.className = "forum-card";
      forumCard.dataset.forumId = forum.forum_id;

      const forumCardHeader = document.createElement("div");
      forumCardHeader.className = "forum-card-header";
      forumCardHeader.innerText = forum.forum_titre;

      const forumCardBody = document.createElement("div");
      forumCardBody.className = "forum-card-body";
      forumCardBody.innerHTML = `
        <p>${forum.forum_message}</p>
        <small>Posted on: ${new Date(
          forum.forum_date
        ).toLocaleDateString()}</small>
        <div class="responses-container" id="responses-${
          forum.forum_id
        }" style="display: none;"></div>
        <button class="btn btn-secondary toggle-responses-button" id="toggle-responses-${
          forum.forum_id
        }">Show Responses</button>
      `;

      if (droit === "administrateur" || droit === "moderateur") {
        const deleteButton = document.createElement("button");
        deleteButton.className = "btn btn-danger";
        deleteButton.innerText = "Delete Forum";
        deleteButton.addEventListener("click", () => {
          if (confirm("Are you sure you want to delete this forum?")) {
            deleteForum(forum.forum_id);
          }
        });
        forumCardBody.appendChild(deleteButton);
      }

      forumCard.appendChild(forumCardHeader);
      forumCard.appendChild(forumCardBody);
      forumContainer.appendChild(forumCard);
    });

    // Attach event listeners for the "Show Responses" buttons
    const toggleResponseButtons = document.querySelectorAll(
      ".toggle-responses-button"
    );
    toggleResponseButtons.forEach((button) => {
      button.addEventListener("click", function (event) {
        event.stopPropagation(); // Prevent event from bubbling up to parent elements
        const forumId = this.id.replace("toggle-responses-", "");
        const responsesContainer = document.getElementById(
          `responses-${forumId}`
        );
        if (responsesContainer.style.display === "block") {
          responsesContainer.style.display = "none";
          this.innerText = "Show Responses";
        } else {
          fetchResponses(forumId); // Fetch responses when opening
          responsesContainer.style.display = "block";
          this.innerText = "Close Responses";
        }
      });
    });
  }

  createForumForm.addEventListener("submit", function (event) {
    event.preventDefault();

    const forumTitle = document.getElementById("forumTitle").value.trim();
    const forumMessage = document.getElementById("forumMessage").value.trim();
    const forumTheme = document.getElementById("forumTheme").value;

    if (!forumTitle || !forumMessage || !forumTheme) {
      alert("All fields are required.");
      return;
    }

    const data = {
      titre: forumTitle,
      message: forumMessage,
      user_id: userId,
      theme_id: forumTheme,
    };

    const url = "index.php?ctrl=forum&action=createForum";
    const options = {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify(data),
    };

    fetch(url, options)
      .then((response) => {
        if (!response.ok) {
          throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
      })
      .then((data) => {
        if (data.success) {
          alert("Forum created successfully!");
          createForumForm.reset();
          createForumFormContainer.style.display = "none";
          fetchForumsByTheme(selectedThemeId, currentPage);
        } else {
          alert("Error creating forum: " + data.error);
        }
      })
      .catch((error) => {
        console.error("Error creating forum:", error);
        alert("An error occurred. Please try again later.");
      });
  });

  function deleteForum(forumId) {
    const url = `index.php?ctrl=forum&action=deleteForum`;
    const options = {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ forum_id: forumId }),
    };
    handleApiResponse(
      fetchData(url, options),
      "Forum deleted successfully!",
      true
    );
  }

  function updatePagination(current, total) {
    currentPage = current;
    totalPages = total;

    console.log(
      `Updating pagination: current page = ${currentPage}, total pages = ${totalPages}`
    );

    currentPageInfo.innerText = `Page ${currentPage} of ${totalPages}`;
    prevPageButton.disabled = currentPage === 1;
    nextPageButton.disabled = currentPage === totalPages;
  }

  function createResponse(forumId, message) {
    if (!forumId || !message) {
      console.error("Invalid forum ID or message:", forumId, message);
      alert("Please enter a valid response.");
      return;
    }

    const url = `index.php?ctrl=forum&action=createResponse`;
    const data = {
      forum_id: forumId,
      message: message,
      user_id: userId,
    };

    const options = {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify(data),
    };

    fetchData(url, options)
      .then((data) => {
        if (data.success) {
          alert("Response created successfully!");
          fetchResponses(forumId);
        } else {
          console.error("Error creating response:", data.error);
          alert("Error: " + data.error);
        }
      })
      .catch((error) => {
        console.error("Error creating response:", error);
      });
  }

  function responseForm(forumId) {
    const form = document.createElement("form");
    form.className = "new-response-form";
    form.dataset.forumId = forumId;

    form.innerHTML = `
      <textarea class="form-control" name="response" placeholder="Enter your response here" required></textarea>
      <button class="btn btn-primary" type="submit">Submit Response</button>
    `;

    return form;
  }

  function deleteResponse(responseId) {
    const url = `index.php?ctrl=forum&action=deleteResponse`;
    const options = {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ response_id: responseId }),
    };

    fetchData(url, options)
      .then((data) => {
        if (data.success) {
          alert("Response deleted successfully!");
          // Remove the response element from the DOM
          const responseElement = document.querySelector(
            `.response-card[data-response-id="${responseId}"]`
          );
          if (responseElement) {
            responseElement.remove();
          }
        } else {
          console.error("Error deleting response:", data.error);
          alert("Error: " + data.error);
        }
      })
      .catch((error) => {
        console.error("Error deleting response:", error);
        alert("An error occurred. Please try again later.");
      });
  }

  prevPageButton.addEventListener("click", () => {
    if (currentPage > 1) {
      console.log(`Going to previous page: ${currentPage - 1}`);
      fetchForumsByTheme(selectedThemeId, currentPage - 1);
    }
  });

  nextPageButton.addEventListener("click", () => {
    if (currentPage < totalPages) {
      console.log(`Going to next page: ${currentPage + 1}`);
      fetchForumsByTheme(selectedThemeId, currentPage + 1);
    }
  });

  function deleteTheme(themeId) {
    const url = `index.php?ctrl=forum&action=deleteTheme`;
    fetch(url, {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ theme_id: themeId }),
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
  }

  function fetchResponses(forumId) {
    const url = `index.php?ctrl=forum&action=getForum&forum_id=${forumId}`;
    fetchData(url)
      .then((data) => {
        if (data.error) {
          alert("Error fetching responses: " + data.error);
          return;
        }
        displayResponses(forumId, data);
      })
      .catch((error) => {
        console.error("Error fetching responses:", error);
      });
  }

  function displayResponses(forumId, responses) {
    const responsesContainer = document.getElementById(`responses-${forumId}`);
    responsesContainer.innerHTML = ""; // Clear previous responses
    responsesContainer.style.display = "block"; // Show the responses container

    if (responses.length === 0) {
      responsesContainer.innerHTML =
        "<p>No responses available for this forum.</p>";
    } else {
      responses.forEach((response, index) => {
        const responseCard = document.createElement("div");
        responseCard.className = "response-card";
        responseCard.dataset.responseId = response.reponse_id; // Add dataset attribute
        responseCard.innerHTML = `
          <p>${response.reponse_message}</p>
          <small class="response-info">Posted by: ${
            response.user_pseudo
          } on ${new Date(response.reponse_date).toLocaleDateString()}</small>
        `;

        responseCard.style.backgroundColor =
          index % 2 === 0 ? "#f9f9f9" : "#e9e9e9";

        if (droit === "administrateur" || droit === "moderateur") {
          const deleteButton = document.createElement("button");
          deleteButton.className = "btn btn-danger";
          deleteButton.innerText = "Delete Response";
          deleteButton.addEventListener("click", () => {
            if (confirm("Are you sure you want to delete this response?")) {
              deleteResponse(response.reponse_id);
            }
          });
          responseCard.appendChild(deleteButton);
        }

        responsesContainer.appendChild(responseCard);
      });
    }
    const newResponseForm = responseForm(forumId);
    responsesContainer.appendChild(newResponseForm);
  }

  forumContainer.addEventListener("click", function (event) {
    const forumCard = event.target.closest(".forum-card");
    if (
      forumCard &&
      event.target.classList.contains("toggle-responses-button")
    ) {
      const forumId = forumCard.dataset.forumId;
      const responsesContainer = document.getElementById(
        `responses-${forumId}`
      );
      if (responsesContainer.style.display === "block") {
        responsesContainer.style.display = "none";
        event.target.innerText = "Show Responses";
      } else {
        fetchResponses(forumId);
        responsesContainer.style.display = "block";
        event.target.innerText = "Close Responses";
      }
    }
  });

  forumContainer.addEventListener("submit", function (event) {
    const form = event.target.closest(".new-response-form");
    if (form) {
      event.preventDefault();
      const forumId = form.dataset.forumId;
      const message = form.querySelector("textarea").value.trim();
      if (message) {
        createResponse(forumId, message);
        form.reset();
      } else {
        alert("Please enter a response message.");
      }
    }
  });
});
