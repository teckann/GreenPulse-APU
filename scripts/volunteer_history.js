
function searchHistory() {


    const searchArea = document.querySelector("#searchHistory");
    let text = searchArea.value;
    const typeToSearch = searchArea.dataset.toSearch;



    if(typeToSearch){

        return fetch(`historyBackend.php?${typeToSearch}=${text}`)
        .then(response => response.text())
        .then(data => {
            document.querySelector('#secondaryHistoryContainer').innerHTML = data;
        })
    }



}


/* ------------------------ start running here---------------------- */
document.addEventListener('DOMContentLoaded',() =>{
    // loadUpcomingEvent();

    document.querySelector('#searchHistory').addEventListener('keyup', searchHistory);




})