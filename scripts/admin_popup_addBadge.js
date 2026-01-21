document.addEventListener("DOMContentLoaded", () => {
    const btnOpen = document.querySelector(".addnewBadge-btn");

    const btnClose = document.getElementById("popup-add-badge-close-menu");
    const popup = document.getElementById("popup-add-badge");
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