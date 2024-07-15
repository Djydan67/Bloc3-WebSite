document.getElementById("mdp").addEventListener("mouseenter", showTooltip);
document.getElementById("mdp").addEventListener("mouseleave", hideTooltip);

function showTooltip() {
  var tooltip = document.getElementById("tooltip");
  tooltip.style.display = "block";
}

document.addEventListener("click", function (event) {
  var tooltip = document.getElementById("tooltip");
  var passwordInput = document.getElementById("mdp");
  if (
    !passwordInput.contains(event.target) &&
    !tooltip.contains(event.target)
  ) {
    tooltip.style.display = "none";
  }
});

function hideTooltip() {
  var tooltip = document.getElementById("tooltip");
  tooltip.style.display = "none";
}
