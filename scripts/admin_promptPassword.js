document.addEventListener("DOMContentLoaded", () => {
    const btnPrompt = document.querySelectorAll(".prompt-btn");

    if (btnPrompt) {
        btnPrompt.forEach((btn) => {
            btn.addEventListener("click", () => {
                const password = prompt("Please enter password to proceed: ");

                if (password !== null && password.trim() !== "") {
                    const form = document.createElement("form");
                    form.action = "";
                    form.method = "POST";

                    const inputType = document.createElement("input");
                    inputType.name = "formType";
                    inputType.value = "checkPassword";  // new form type
                    inputType.type = "hidden";
                    form.appendChild(inputType);

                    const inputPassword = document.createElement("input");
                    inputPassword.name = "inputPassword";
                    inputPassword.value = password;  // assign prompt value to value
                    inputPassword.type = "hidden";
                    form.appendChild(inputPassword);

                    // append & submit the form
                    document.body.appendChild(form);
                    form.submit();
                }
                else {
                    window.location.href = "profile.php";
                }
            });
        });
    }
});