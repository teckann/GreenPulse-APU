document.addEventListener("DOMContentLoaded", () => {
    const newPassword = document.getElementById("newPassword");
    const confirmPassword = document.getElementById("confirmPassword");

    // error message
    const errorNewEmpty = document.getElementById("error-new-empty");
    const errorConfirmEmpty = document.getElementById("error-confirm-empty");
    const errorDifferent = document.getElementById("error-diffent");

    const ruleLength = document.getElementById("rule-length");
    const ruleUpper = document.getElementById("rule-upper");
    const ruleLower = document.getElementById("rule-lower");
    const ruleNumber = document.getElementById("rule-number");
    const ruleSymbol = document.getElementById("rule-symbol");

    // back button & update button
    const btnUpdate = document.getElementById("btnUpdatePassword");
    const btnBack = document.querySelector(".back-btn");

    const upperRegex = /[A-Z]/;
    const lowerRegex = /[a-z]/;
    const numberRegex = /[0-9]/;
    const symbolRegex = /[!@#$%^&*]/;

    if (newPassword) {
        newPassword.addEventListener("input", () => {
            const inputPassword = newPassword.value;

            // check length
            if (inputPassword.length >= 8 && inputPassword.length <= 20) {
                ruleLength.style.color = "green";
            }
            else {
                ruleLength.style.color = "red";
            }

            // check uppercase
            if (upperRegex.test(inputPassword)) {
                ruleUpper.style.color = "green";
            }
            else {
                ruleUpper.style.color = "red";
            }

            // check lowercase
            if (lowerRegex.test(inputPassword)) {
                ruleLower.style.color = "green";
            }
            else {
                ruleLower.style.color = "red";
            }

            // check number
            if (numberRegex.test(inputPassword)) {
                ruleNumber.style.color = "green";
            }
            else {
                ruleNumber.style.color = "red";
            }

            // check symbol
            if (symbolRegex.test(inputPassword)) {
                ruleSymbol.style.color = "green";
            }
            else {
                ruleSymbol.style.color = "red";
            }

            // hide, when user start enter
            if (inputPassword !== "") {
                errorNewEmpty.style.display = "none";
            }
        });
    }

    if (confirmPassword) {
        confirmPassword.addEventListener("input", () => {
            if (confirmPassword.value !== "") {
                errorConfirmEmpty.style.display = "none";
            }
            // hide, when user start enter
            errorDifferent.style.display = "none";
        });
    }

    if (btnUpdate) {
        btnUpdate.addEventListener("click", (e) => {
            e.preventDefault();

            // get again the value
            const VnewPassword = newPassword.value;
            const VconfirmPassword = confirmPassword.value;

            let status = true;

            if (VnewPassword === "") {
                errorNewEmpty.style.display = "block";
                status = false;
            }
            else {
                errorNewEmpty.style.display = "none";
            }

            if (VconfirmPassword === "") {
                errorConfirmEmpty.style.display = "block";
                status = false;
            }
            else {
                errorConfirmEmpty.style.display = "none";
            }

            // if one of the rule not green, then false it
            if (ruleLength.style.color !== "green" || ruleUpper.style.color !== "green" || ruleLower.style.color !== "green" ||
                ruleNumber.style.color !== "green" || ruleSymbol.style.color !== "green") {
                status = false;
            }


            // check new and confirm same or not, make sure confirm not empty
            if (VnewPassword !== VconfirmPassword && VconfirmPassword !== "") {
                errorDifferent.style.display = "block";
                status = false;
            }
            else {
                errorDifferent.style.display = "none";
            }

            // all pass (true), submit form
            if (status) {
                const form = document.querySelector("#update-password-form");
                form.submit();
            }
        });
    }

    // click back, clear all error
    if (btnBack) {
        btnBack.addEventListener("click", () => {

            // clear the input
            newPassword.value = "";
            confirmPassword.value = "";

            // hide all the error text
            errorNewEmpty.style.display = "none";
            errorConfirmEmpty.style.display = "none";
            errorDifferent.style.display = "none";

            // remove the rules color
            ruleLength.style.color = "";
            ruleUpper.style.color = "";
            ruleLower.style.color = "";
            ruleNumber.style.color = "";
            ruleSymbol.style.color = "";
        });
    }
});


document.addEventListener("DOMContentLoaded", () => {
    const question1 = document.getElementById("securityQuestion1");
    const question2 = document.getElementById("securityQuestion2");
    const answer1 = document.getElementById("answer1");
    const answer2 = document.getElementById("answer2");
    const btnUpdateQuestion = document.getElementById("btnUpdateQuestion");

    const errorQ1 = document.getElementById("error-question1");
    const errorQ2 = document.getElementById("error-question2");
    const errorA1 = document.getElementById("error-answer1");
    const errorA2 = document.getElementById("error-answer2");

    const disableOption = () => {
        const Vquestion1 = question1.value;
        const Vquestion2 = question2.value;

        // action for question 2
        Array.from(question2.options).forEach(option => {
            // enable user select all
            option.disabled = false;

            // if the value same with question1, then disable it
            if (Vquestion1 !== "" && option.value === Vquestion1) {
                option.disabled = true;
            }
        });

        // action for question 1
        Array.from(question1.options).forEach(option => {
            // enable user select all
            option.disabled = false;

            // if the value same with question2, then disable it
            if (Vquestion2 !== "" && option.value === Vquestion2) {
                option.disabled = true;
            }
        });
    };

    // main logic for disableOption() && claer error when user make changes
    // make sure that question 1 & question 2 exist
    if (question1 && question2) {
        question1.addEventListener("change", () => {
            disableOption();
            if (question1.value !== "") {
                errorQ1.style.display = "none";
            }
        });

        question2.addEventListener("change", () => {
            disableOption();
            if (question2.value !== "") {
                errorQ2.style.display = "none";
            }
        });
    }

    // clear error when user make changes
    if (answer1) {
        answer1.addEventListener("input", () => {
            if (answer1.value.trim() !== "") {
                errorA1.style.display = "none";
            }
        });
    }
    if (answer2) {
        answer2.addEventListener("input", () => {
            if (answer2.value.trim() !== "") {
                errorA2.style.display = "none";
            }
        });
    }

    if (btnUpdateQuestion) {
        btnUpdateQuestion.addEventListener("click", (e) => {
            e.preventDefault();

            let status = true;

            // check question 1
            if (question1.value === "") {
                errorQ1.style.display = "block";
                status = false;
            }
            else {
                errorQ1.style.display = "none";
            }

            // check answer 1
            if (answer1.value.trim() === "") {
                errorA1.style.display = "block";
                status = false;
            }
            else {
                errorA1.style.display = "none";
            }

            // check question 2
            if (question2.value === "") {
                errorQ2.style.display = "block";
                status = false;
            }
            else {
                errorQ2.style.display = "none";
            }

            // check answer 2
            if (answer2.value.trim() === "") {
                errorA2.style.display = "block";
                status = false;
            }
            else {
                errorA2.style.display = "none";
            }

            if (status) {
                const form = document.getElementById("update-question-form");
                form.submit();
            }
        });
    }
});