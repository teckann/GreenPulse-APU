toastr.options = {
    "closeButton": true,
    "progressBar": true,
    "positionClass": "toast-bottom-right",
    "timeOut": "2500"
};

// manage users section
const btnAction = document.querySelector(".action-btn");
btnAction.addEventListener("click", () => {
    toastr.success("Account Status Successfully Updated");
});