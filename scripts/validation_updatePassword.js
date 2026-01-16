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

            // A. 检查是不是空的
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