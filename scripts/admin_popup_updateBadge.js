// open & close the popup form (profile - update avatar)
document.addEventListener("DOMContentLoaded", () => {
    // control popup form open & close
    const btnOpen = document.querySelector(".edit-badge-icon");
    const btnClose = document.getElementById("popup-close-menu");
    const popup = document.getElementById("popup-updateBadge");
    const overlay = document.getElementById("popupOverlay");

    // for upload image
    const fileInput = document.getElementById("badge_image");
    const previewImg = document.getElementById("preview-badge");
    const fileNameSpan = document.getElementById("file-name");

    let originAvatar = "";
    if (previewImg) {
        // get origin image to recover while close
        originAvatar = previewImg.src;
    }


    btnOpen.addEventListener("click", (e) => {
        popup.style.display = "block";
        overlay.style.display = "block";
    });


    const closePopup = () => {
        popup.style.display = "none";
        overlay.style.display = "none";

        // always clear the uploaded image & make it as origin image
        // only apply for the situation of uploaded but didnt save chenges
        // once save changes, the page will redirect, so the origin one still the new one
        fileInput.value = "";
        fileNameSpan.textContent = "No file chosen";
        previewImg.src = originAvatar;
    }

    btnClose.addEventListener("click", closePopup);
    overlay.addEventListener("click", closePopup);

    // render the image to preview
    if (fileInput) {
        fileInput.addEventListener("change", function () {
            const file = this.files[0];

            if (file) {
                fileNameSpan.textContent = file.name;

                const reader = new FileReader();
                reader.onload = (e) => {
                    previewImg.src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        });
    }
});