
function enableBtn(btn) {
    btn.disabled = false;
    btn.style.backgroundColor = '#c6ff00'; 
    btn.style.color = '#0a670e'; 
}

function disableBtn(btn) {
    btn.disabled = true;
    btn.style.backgroundColor = '#858585'; 
    btn.style.color = 'white'; 
}


function noRepeatQuestion(changedQuestion) {
    const q1 = document.querySelector("#q1");
    const q2 = document.querySelector("#q2");
    const btn = document.querySelector('#changeQuestionBtn');

    document.querySelector("#emQ1").innerHTML = '';
    document.querySelector("#emQ2").innerHTML = '';


    if (q1.value !== "" && q2.value !== "") {

        if (q1.value === q2.value) {
            
            
            if(changedQuestion === 1){
                q1.value = ""; 
                document.querySelector("#emQ1").innerHTML = 'Please Select Different Question';

    
            }else if(changedQuestion === 2){
                q2.value = ""; 
                document.querySelector("#emQ2").innerHTML = 'Please Select Different Question';
            }

            disableBtn(btn);
            
        }else{
            enableBtn(btn);
 
        }
    }else {
        disableBtn(btn);
    }
}

    function validatePass() {
        const pass1 = document.querySelector('#newPassInput').value;
        const pass2 = document.querySelector('#conPassInput').value;
        const btn = document.querySelector('#changePassBtn');
        const errorMessage = document.querySelector('#emNewPass');
        

        const isLength = pass1.length >= 8 && pass1.length <= 20;
        const isUpper = /[A-Z]/.test(pass1);
        const isLower = /[a-z]/.test(pass1);
        const isNumber = /[0-9]/.test(pass1);
        const isSpecialC = /[!@#$%^&*]/.test(pass1); 

        let isMatch = false;

        if (pass2.length > 0) {
            if (pass1 === pass2) {
                isMatch = true;

                document.querySelector('#emConPass').innerHTML = "";
            } else {
                document.querySelector('#emConPass').innerHTML = "Passwords do not match";
                isMatch = false;
            }
        } else {
            errorMessage.innerHTML = "";
            isMatch = false;
        }

        if(isLength && isUpper && isLower && isNumber && isSpecialC){
            errorMessage.innerHTML = "";
        }else{
            errorMessage.innerHTML = "Passwords must be 8-20 character and contains Number and symbols";
        }


        if (isLength && isUpper && isLower && isNumber && isSpecialC && isMatch) {
            enableBtn(btn)

            
            
        } else {
            disableBtn(btn)


        }
    }





/* ------------------------ start running here---------------------- */
document.addEventListener('DOMContentLoaded',() =>{


    if (document.querySelector('#q1') && document.querySelector('#q2')) {

        document.querySelector('#q1').addEventListener('change', () => noRepeatQuestion(1));
        document.querySelector('#q2').addEventListener('change', () => noRepeatQuestion(2));


    }


    if (document.querySelector('#newPassInput') && document.querySelector('#conPassInput')) {


        document.querySelector('#newPassInput').addEventListener('keyup', validatePass);
        document.querySelector('#conPassInput').addEventListener('keyup', validatePass);

    }



    




})
