// [Admin] Add New Users (pop-up) Validation
document.addEventListener("DOMContentLoaded", () => {
    // regular expression

    // validate name
    /*
        /* - start
        &/ - end

        [] - character set
        a-z - allow lowercase
        A-Z - allow uppercase
        \s - allow space
        + - allow more than one character
    */
    const nameRegex = /^[a-zA-Z\s]+$/;


    // validate email
    /*
        TP - start with TP
        \d{6} - number (6 digits)
    */
    const tpRegex = /^TP\d{6}$/;


    // validate contact
    /*
        \d{10,11} - number (10-11 digits)
    */
    const contactRegex = /^\d{10,11}$/;

    // elements that need to validate
    const fullname = document.getElementById("fullname");
    const email = document.getElementById("email");
    const contact = document.getElementById("contact");
    const dob = document.getElementById("dob");
    const course = document.getElementById("course");
    const gender = document.querySelectorAll("input[name='gender']");
    const nationality = document.getElementById("nationality");
    const permission = document.getElementById("permission");

    // error message
    const nameError = document.getElementById("error-fullname");
    const emailError = document.getElementById("error-email");
    const contactError = document.getElementById("error-contactNumber");
    const dobError = document.getElementById("error-dob");
    const courseError = document.getElementById("error-course");
    const genderError = document.getElementById("error-gender");
    const nationalityError = document.getElementById("error-nationality");
    const permissionError = document.getElementById("error-permission");

    if (fullname) {
        fullname.addEventListener("input", () => {
            if (fullname.value.trim() !== "") {
                nameError.style.display = "none";
            }
        });
    }

    if (email) {
        email.addEventListener("input", () => {
            if (email.value.trim() !== "") {
                emailError.style.display = "none";
            }
        });
    }

    if (contact) {
        contact.addEventListener("input", () => {
            if (contact.value.trim() !== "") {
                contactError.style.display = "none";
            }
        });
    }

    if (dob) {
        dob.addEventListener("change", () => {
            if (dob.value.trim() !== "") {
                dobError.style.display = "none";
            }
        });
    }

    if (course) {
        course.addEventListener("change", () => {
            if (course.value.trim() !== "") {
                courseError.style.display = "none";
            }
        });
    }

    if (gender.length > 0) {
        gender.forEach((radio) => {
            radio.addEventListener("change", () => {
                genderError.style.display = "none";
            });
        });
    }

    if (nationality) {
        nationality.addEventListener("change", () => {
            if (nationality.value.trim() !== "") {
                nationalityError.style.display = "none";
            }
        });
    }

    if (permission) {
        permission.addEventListener("change", () => {
            if (permission.value.trim() !== "") {
                permissionError.style.display = "none";
            }
        });
    }

    const displayErrorMsg = (element) => {
        element.style.display = "block";
    }

    const closeErrorMsg = (element) => {
        element.style.display = "none";
    }


    const btnAddNewUser = document.querySelector("#btnSubmit-addNewUser");
    const btnUpdateInfo = document.querySelectorAll("#btnSubmit-updateInfo");

    if (btnAddNewUser) {
        btnAddNewUser.addEventListener("click", (e) => {
            // prevent submit from first
            e.preventDefault();

            // elements that need to validate
            const Vfullname = fullname.value;
            const Vemail = email.value;
            const Vcontact = contact.value;
            const Vdob = dob.value;
            const Vcourse = course.value;
            const VgenderSelected = document.querySelector("input[name='gender']:checked");
            const Vnationality = nationality.value;
            const Vpermission = permission.value;

            let validationPass = true;

            // validate name
            if (Vfullname.trim() === "" || !nameRegex.test(Vfullname)) {
                displayErrorMsg(nameError);
                validationPass = false;
            }
            else {
                closeErrorMsg(nameError);
            }

            // validate email
            const tp = Vemail.trim().toUpperCase();

            if (tp === "" || !tpRegex.test(tp)) {
                displayErrorMsg(emailError);
                validationPass = false;
            }
            else {
                closeErrorMsg(emailError);
            }

            // validate contact
            if (Vcontact.trim() === "" || !contactRegex.test(Vcontact.trim())) {
                displayErrorMsg(contactError);
                validationPass = false;
            }
            else {
                closeErrorMsg(contactError);
            }

            // validate dob
            if (Vdob === "") {
                displayErrorMsg(dobError);
                validationPass = false;
            }
            else {
                closeErrorMsg(dobError);
            }

            // validate course
            if (Vcourse === "") {
                displayErrorMsg(courseError);
                validationPass = false;
            }
            else {
                closeErrorMsg(courseError);
            }

            // validate gender
            if (!VgenderSelected) {
                displayErrorMsg(genderError);
                validationPass = false;
            }
            else {
                closeErrorMsg(genderError);
            }

            // validate nationality
            if (Vnationality === "") {
                displayErrorMsg(nationalityError);
                validationPass = false;
            }
            else {
                closeErrorMsg(nationalityError);
            }

            // validate permission
            if (Vpermission === "") {
                displayErrorMsg(permissionError);
                validationPass = false;
            }
            else {
                closeErrorMsg(permissionError);
            }

            // main logic
            if (validationPass) {
                const form = document.querySelector(".popup-form");
                form.submit();
            }
        });
    }

    if (btnUpdateInfo.length > 0) {
        btnUpdateInfo.forEach((btn) => {
            btn.addEventListener("click", (e) => {
                e.preventDefault();

                // elements that need to validate
                const Vfullname = fullname.value;
                const Vemail = email.value;
                const Vcontact = contact.value;
                const Vdob = dob.value;
                const Vcourse = course.value;
                const Vnationality = nationality.value;

                let validationPass = true;

                // validate name
                if (Vfullname.trim() === "" || !nameRegex.test(Vfullname)) {
                    displayErrorMsg(nameError);
                    validationPass = false;
                }
                else {
                    closeErrorMsg(nameError);
                }

                // validate email
                const tpRegex = /^TP\d{6}$/;
                const tp = Vemail.trim().toUpperCase();

                if (tp === "" || !tpRegex.test(tp)) {
                    displayErrorMsg(emailError);
                    validationPass = false;
                }
                else {
                    closeErrorMsg(emailError);
                }

                // validate contact
                const contactRegex = /^\d{10,11}$/;

                if (Vcontact.trim() === "" || !contactRegex.test(Vcontact.trim())) {
                    displayErrorMsg(contactError);
                    validationPass = false;
                }
                else {
                    closeErrorMsg(contactError);
                }

                // validate dob
                if (Vdob === "") {
                    displayErrorMsg(dobError);
                    validationPass = false;
                }
                else {
                    closeErrorMsg(dobError);
                }

                // validate course
                if (Vcourse === "") {
                    displayErrorMsg(courseError);
                    validationPass = false;
                }
                else {
                    closeErrorMsg(courseError);
                }

                // validate nationality
                if (Vnationality === "") {
                    displayErrorMsg(nationalityError);
                    validationPass = false;
                }
                else {
                    closeErrorMsg(nationalityError);
                }

                // main logic
                if (validationPass) {
                    const form = document.querySelector(".popup-form");
                    form.submit();
                }
            });
        });
    }
});