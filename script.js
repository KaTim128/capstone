"use strict";

document.addEventListener("DOMContentLoaded", function () {
  const alertContainer = document.getElementById("alertContainer");

  // Check if the alertContainer exists to avoid errors
  if (alertContainer) {
    // Check if there is an alert message in the data attributes
    const alertMessage = alertContainer.getAttribute("data-alert-message");
    const alertType = alertContainer.getAttribute("data-alert-type");

    if (alertMessage) {
      // Make alert container visible
      alertContainer.classList.add("alert-visible");

      // Create the alert element
      const alertElement = document.createElement("div");
      alertElement.className = `alert alert-${alertType} alert-dismissible fade show`;
      alertElement.role = "alert";
      alertElement.innerHTML = `${alertMessage}<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>`;

      // Append the alert element to the container
      alertContainer.appendChild(alertElement);

      // Show the alert and then fade it out
      $(alertElement)
        .hide()
        .slideDown(300)
        .delay(3000)
        .slideUp(300, () => {
          alertElement.remove();
          alertContainer.classList.remove("alert-visible");
        });
    }
  }
});
