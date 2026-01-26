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


// [Admin] Add New Announcement (pop-up) Validation
document.addEventListener("DOMContentLoaded", () => {
    const btnAddAnnouncement = document.querySelector("#btnSubmit-addNewAnnouncement");
    const newAnnounecment = document.getElementById("newAnnouncement");
    const announcementError = document.getElementById("error-announcement");

    if (newAnnounecment) {
        newAnnounecment.addEventListener("input", () => {
            if (newAnnounecment.value.trim() !== "") {
                announcementError.style.display = "none";
            }
        });
    }

    if (btnAddAnnouncement) {
        btnAddAnnouncement.addEventListener("click", (e) => {
            e.preventDefault();

            if (newAnnounecment.value.trim() === "") {
                announcementError.style.display = "block";
            }
            else {
                announcementError.style.display = "none";

                const form = document.querySelector(".addNewAnnouncem-form");
                form.submit();
            }
        })
    }
});


// [Admin] Add New Badge (pop-up) Validation
document.addEventListener("DOMContentLoaded", () => {
    const btnAddBadge = document.querySelector("#btnSubmit-addNewBadge");

    const badgeName = document.getElementById("badgeName");
    const requiredPoints = document.getElementById("points");
    const badgeImage = document.getElementById("badge_image");

    const badgeNameError = document.getElementById("error-badge-name");
    const requiredPointsError = document.getElementById("error-point-number");
    const fileError = document.getElementById("error-file");

    if (badgeName) {
        badgeName.addEventListener("input", () => {
            if (badgeName.value.trim() !== "") {
                badgeNameError.style.display = "none";
            }
        });
    }

    if (requiredPoints) {
        requiredPoints.addEventListener("input", () => {
            if (requiredPoints.value.trim() !== "") {
                requiredPointsError.style.display = "none";
            }
        });
    }

    if (badgeImage) {
        badgeImage.addEventListener("input", () => {
            if (badgeImage.value.trim() !== "") {
                fileError.style.display = "none";
            }
        });
    }

    if (btnAddBadge) {
        btnAddBadge.addEventListener("click", (e) => {
            e.preventDefault();

            let status = true;

            if (badgeName.value.trim() === "") {
                badgeNameError.style.display = "block";
                status = false;
            }
            else {
                badgeNameError.style.display = "none";
            }

            if (requiredPoints.value.trim() === "") {
                requiredPointsError.style.display = "block";
                status = false;
            }
            else {
                requiredPointsError.style.display = "none";
            }

            if (badgeImage.value.trim() === "") {
                fileError.style.display = "block";
                status = false;
            }
            else {
                fileError.style.display = "none";
            }

            if (status) {
                const form = document.querySelector(".addNewBadge-form");
                form.submit();
            }
        })
    }
});

// [Admin] Update Badge Information Validation
document.addEventListener("DOMContentLoaded", () => {
    const btnUpdateBadge = document.querySelector("#btnSubmit-update-badge-info");

    const badgeName = document.getElementById("badgeName");
    const requiredPoints = document.getElementById("points");

    const badgeNameError = document.getElementById("error-badge-name");
    const requiredPointsError = document.getElementById("error-point-number");

    if (badgeName) {
        badgeName.addEventListener("input", () => {
            if (badgeName.value.trim() !== "") {
                badgeNameError.style.display = "none";
            }
        });
    }

    if (requiredPoints) {
        requiredPoints.addEventListener("input", () => {
            if (requiredPoints.value.trim() !== "") {
                requiredPointsError.style.display = "none";
            }
        });
    }

    if (btnUpdateBadge) {
        btnUpdateBadge.addEventListener("click", (e) => {
            e.preventDefault();

            let status = true;

            if (badgeName.value.trim() === "") {
                badgeNameError.style.display = "block";
                status = false;
            }
            else {
                badgeNameError.style.display = "none";
            }

            if (requiredPoints.value.trim() === "") {
                requiredPointsError.style.display = "block";
                status = false;
            }
            else {
                requiredPointsError.style.display = "none";
            }

            if (status) {
                const form = document.querySelector(".update-badge-info-form");
                form.submit();
            }
        })
    }
});


// [Guest] contact us validation
document.addEventListener("DOMContentLoaded", () => {
    const btnSubmitContact = document.querySelector("#btnSubmit-contact");

    const fullname = document.getElementById("fullname");
    const email = document.getElementById("email");
    const contact = document.getElementById("contactNumber");
    const subject = document.getElementById("subject");
    const description = document.getElementById("description");

    const nameError = document.getElementById("error-fullname");
    const emailError = document.getElementById("error-email");
    const contactError = document.getElementById("error-contactNumber");
    const subjectError = document.getElementById("error-subject");
    const descriptionError = document.getElementById("error-description");

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

    if (subject) {
        subject.addEventListener("change", () => {
            if (subject.value.trim() !== "") {
                subjectError.style.display = "none";
            }
        });
    }

    if (description) {
        description.addEventListener("input", () => {
            if (description.value.trim() !== "") {
                descriptionError.style.display = "none";
            }
        });
    }

    const nameRegex = /^[a-zA-Z\s]+$/;
    const contactRegex = /^\d{10,11}$/;
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    const displayErrorMsg = (element) => {
        element.style.display = "block";
    }

    const closeErrorMsg = (element) => {
        element.style.display = "none";
    }

    if (btnSubmitContact) {
        btnSubmitContact.addEventListener("click", (e) => {
            e.preventDefault();

            const Vfullname = fullname.value;
            const Vemail = email.value;
            const Vcontact = contact.value;
            const Vsubject = subject.value;
            const Vdescription = description.value;

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
            if (Vemail.trim() === "" || !emailRegex.test(Vemail)) {
                displayErrorMsg(emailError);
                validationPass = false;
            }
            else {
                closeErrorMsg(emailError);
            }

            // validate contact
            if (Vcontact.trim() === "" || !contactRegex.test(Vcontact)) {
                displayErrorMsg(contactError);
                validationPass = false;
            }
            else {
                closeErrorMsg(contactError);
            }

            // validate subject
            if (Vsubject.trim() === "") {
                displayErrorMsg(subjectError);
                validationPass = false;
            }
            else {
                closeErrorMsg(subjectError);
            }

            // validate description
            if (Vdescription.trim() === "") {
                displayErrorMsg(descriptionError);
                validationPass = false;
            }
            else {
                closeErrorMsg(descriptionError);
            }

            if (validationPass) {
                const form = document.querySelector(".contact-form");
                form.submit();
            }
        })
    }
});