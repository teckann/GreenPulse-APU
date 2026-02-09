function searchModule() {


    let text = document.querySelector("#searchStudy").value;


    if(document.querySelector('#navStudy1').style.background !== 'transparent'){


        return fetch(`studyBackend.php?searchAvailable=${text}`)
        .then(response => response.text())
        .then(data => {
            document.querySelector('#availableStudy').innerHTML = data;
    })
    }else if (document.querySelector('#navStudy2').style.background !== 'transparent'){

        return fetch(`studyBackend.php?searchCompleted=${text}`)
        .then(response => response.text())
        .then(data => {
            document.querySelector('#completedStudy').innerHTML = data;
    })

}

}



/* ------------------------ start running here---------------------- */
document.addEventListener('DOMContentLoaded',() =>{
    // loadUpcomingEvent();

    document.querySelectorAll('.moduleCard').forEach(card => {
        card.addEventListener('click', function() {
            
            const form = this.closest('.oneModuleEnterForm');
            
            if(form) {
                form.submit(); 
            }
        });
    });


    if(document.querySelector('#oneModuleBack')){
        document.querySelector('#oneModuleBack').addEventListener('click', ()=> {
            history.back();

        })
    }


    if(document.querySelector('#searchStudy')){

        document.querySelector('#searchStudy').addEventListener('keyup', searchModule);

    }


})