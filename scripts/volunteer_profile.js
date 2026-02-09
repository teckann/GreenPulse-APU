
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


function validateSelect(changedQuestion) {
    const btn = document.querySelector('#doneButton');

    if (changedQuestion.value === "") {

        disableBtn(btn);

        document.querySelector("#emProfile").innerHTML = 'Please Select a Valid Option';         

    }else {
        enableBtn(btn);

        document.querySelector("#emProfile").innerHTML = '';   
    }
}

function validateText() {
    const input = document.querySelector('#detailToChange');
    const btn = document.querySelector('#doneButton');
    const errorMessage = document.querySelector('#emProfile');

    if (input.value === ''){

        disableBtn(btn);

        errorMessage.innerHTML = 'Please Enter Something';    
    }else {
        enableBtn(btn);

        errorMessage.innerHTML = '';   
    }


    if(input.type === 'tel'){
        const phonePattern = /^[0-9]{10,12}$/;
        
        if (!phonePattern.test(input.value)) {
            disableBtn(btn);

            errorMessage.innerHTML = 'Invalid Phone Number! Please eneter 10-12 numbers';

        }else{
            enableBtn(btn);

            errorMessage.innerHTML = '';   
        }
    }

    if (input.type === 'email') {
        
        if (!input.value.endsWith('@mail.apu.edu.my')) {

            disableBtn(btn);
            errorMessage.innerHTML = 'Please enter APU education Mail (@mail.apu.edu.my)';

        }else{
            enableBtn(btn);

            errorMessage.innerHTML = '';   
        }
    }
}



/* ------------------------ start running here---------------------- */
document.addEventListener('DOMContentLoaded',() =>{


    if (document.querySelector('#nationality')) {
        validateSelect(document.querySelector('#nationality'))

        document.querySelector('#nationality').addEventListener('change', () => validateSelect(document.querySelector('#nationality')));

    }
    if (document.querySelector('#course')) {

        validateSelect(document.querySelector('#course'))

        document.querySelector('#course').addEventListener('change', () => validateSelect(document.querySelector('#course')));



    }


    if (document.querySelector('#detailToChange')) {
        validateText(); 
        

        document.querySelector('#detailToChange').addEventListener('keyup', validateText);
        document.querySelector('#detailToChange').addEventListener('invalid', validateText);

    }


    




})
