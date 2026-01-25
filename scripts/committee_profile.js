document.addEventListener("DOMContentLoaded", () => {
    const btnChangeProfilePhoto = document.querySelector("#btnChangeProfilePhoto");
    const profileOverlay = document.querySelector(".profileOverlay");
    const popUpOverlay = document.querySelector(".showChangePhotoPopUp");
    const btnLetChangePhotoPopUp = document.querySelector("#changeCurrentPhotoBtn");
    const changePhotoPopUpPage = document.querySelector("#itemPopUp2");
    const btnExitChangePhoto = document.querySelector("#btnBackEditChangeProfilePhoto");
    const btnConfirmChangeImage = document.querySelector(".btnConfirmChangeProfilePhoto");
    const btnFileChangeProfilePhoto = document.querySelector("#fileChangeProfilePhoto");
    const btnDeletePhoto = document.querySelector("#deleteCurrentPhotoBtn");
    const deletePhotoPopUp = document.querySelector("#itemPopUp3");

    btnChangeProfilePhoto.addEventListener("click", () => {
        profileOverlay.style.display = "block";
        popUpOverlay.style.display = "flex;"
        popUpOverlay.classList.add("popUpEffect");
    });

    profileOverlay.addEventListener("click", () => {
        // profileOverlay.style.display = "none";
        // popUpOverlay.classList.remove("popUpEffect");
        // changePhotoPopUpPage.style.display = "none";
        reload();
    })

    btnLetChangePhotoPopUp.addEventListener("click", () => {
        popUpOverlay.style.display = "none";
        changePhotoPopUpPage.style.display = "flex";
        btnConfirmChangeImage.classList.add("disableButton");
    })

    btnFileChangeProfilePhoto.addEventListener("change", () => {
        if (btnFileChangeProfilePhoto.value !== "") {
            btnConfirmChangeImage.classList.remove("disableButton");
        } 
        else {
            btnConfirmChangeImage.classList.add("disableButton");
        }
    });

    btnDeletePhoto.addEventListener("click", () => {
        popUpOverlay.style.display = "none";
        deletePhotoPopUp.style.display = "flex";
    });

    btnExitChangePhoto.addEventListener("click", () => {
        reload();
    })
    
    const reload = () => {
        window.location.href="committeeProfile.php";
    }
});