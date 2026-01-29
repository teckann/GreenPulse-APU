function changeDateToView() {

        const monthChosen = document.querySelector('.monthToShow').value;
        const showing = document.querySelector('.monthToShow').dataset.showingPf;

        return fetch(`../../pages/volunteer/pointFlowBackend.php?jsSelectedMonth=${monthChosen}&showing=${showing}`)
        .then(response => response.text())
        .then(data => {
            document.querySelector('.pointFlowContainer').innerHTML = data;
        })
}
    /* ------------------------ start running here---------------------- */
document.addEventListener('DOMContentLoaded',() =>{
    // loadUpcomingEvent();

    if(document.querySelector('#backFromPoint')){
        document.querySelector('#backFromPoint').addEventListener('click', ()=> {

            history.back()


        })
    }




    const monthInput = document.querySelector('.monthToShow');
    
    if (monthInput) {
        monthInput.addEventListener('change', changeDateToView);

    }



})