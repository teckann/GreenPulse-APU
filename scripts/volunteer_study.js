

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



})