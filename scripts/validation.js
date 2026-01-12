// [Admin] Add New Users (pop-up) Validation
document.addEventListener("DOMContentLoaded", () => {
    const btnSubmit = document.querySelector("#btnSubmit-addNewUser");

    btnSubmit.addEventListener("click", (e) => {
        // prevent submit from first
        e.preventDefault();

        // elements that need to validate
        const fullname = document.getElementById("fullname").value;
        const email = document.getElementById("email").value;
        const contact = document.getElementById("contact").value;
        const dob = document.getElementById("dob").value;
        const course = document.getElementById("course").value;
        const genderSelected = document.querySelector("input[name='gender']:checked");
        const nationality = document.getElementById("nationality").value;
        const permission = document.getElementById("permission").value;

        // error message
        const nameError = document.getElementById("error-fullname");
        const emailError = document.getElementById("error-email");
        const contactError = document.getElementById("error-contactNumber");
        const dobError = document.getElementById("error-dob");
        const courseError = document.getElementById("error-course");
        const genderError = document.getElementById("error-gender");
        const nationalityError = document.getElementById("error-nationality");
        const permissionError = document.getElementById("error-permission");

        const displayErrorMsg = (element) => {
            element.style.display = "block";
        }

        const closeErrorMsg = (element) => {
            element.style.display = "none";
        }

        let validationPass = true;

        // validate name
        // regular expression
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

        if (fullname.trim() === "" || !nameRegex.test(fullname)) {
            displayErrorMsg(nameError);
            validationPass = false;
        }
        else {
            closeErrorMsg(nameError);
            validationPass = true;
        }

        // validate email
        /*
           TP - start with TP
           \d{6} - number (6 digits)
        */
        const tpRegex = /^TP\d{6}$/;
        const tp = email.trim().toUpperCase();

        if (tp === "" || !tpRegex.test(tp)) {
            displayErrorMsg(emailError);
            validationPass = false;
        }
        else {
            closeErrorMsg(emailError);
        }

        // validate contact
        /*
           \d{10,11} - number (10-11 digits)
        */
        const contactRegex = /^\d{10,11}$/;

        if (contact.trim() === "" || !contactRegex.test(contact.trim())) {
            displayErrorMsg(contactError);
            validationPass = false;
        }
        else {
            closeErrorMsg(contactError);
        }

        // validate dob
        if (dob === "") {
            displayErrorMsg(dobError);
            validationPass = false;
        }
        else {
            closeErrorMsg(dobError);
        }

        // validate course
        if (course === "") {
            displayErrorMsg(courseError);
            validationPass = false;
        }
        else {
            closeErrorMsg(courseError);
        }

        // validate gender
        if (!genderSelected) {
            displayErrorMsg(genderError);
            validationPass = false;
        }
        else {
            closeErrorMsg(genderError);
        }

        // validate nationality
        if (nationality === "") {
            displayErrorMsg(nationalityError);
            validationPass = false;
        }
        else {
            closeErrorMsg(nationalityError);
        }

        // validate permission
        if (permission === "") {
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
});