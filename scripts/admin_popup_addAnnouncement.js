document.addEventListener("DOMContentLoaded", () => {
    const btnOpen = document.querySelector(".addNewAnnouncement-btn");

    const btnClose = document.getElementById("popup-add-announcement-close-menu");
    const popup = document.getElementById("popup-add-announcement");
    const overlay = document.getElementById("popupOverlay");
    const erroMsg = document.querySelectorAll(".popup-error-text");

    if (btnOpen) {
        btnOpen.addEventListener("click", () => {
            popup.style.display = "block";
            overlay.style.display = "block";

            erroMsg.forEach((e) => {
                e.style.display = "none";
            });
        });
    }

    const closePopup = () => {
        popup.style.display = "none";
        overlay.style.display = "none";
    }

    btnClose.addEventListener("click", closePopup);
    overlay.addEventListener("click", closePopup);
});