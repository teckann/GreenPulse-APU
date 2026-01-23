function searchItem() {


    let text = document.querySelector("#searchRedeem").value;


    if(document.querySelector('#navRedeem1').style.background !== 'transparent'){


        return fetch(`itemBackend.php?searchMerchandise=${encodeURIComponent(text)}`)
        .then(response => response.text())
        .then(data => {
            document.querySelector('#merchandiseRedeem').innerHTML = data;
    })
    }else if (document.querySelector('#navRedeem2').style.background !== 'transparent')

        return fetch(`itemBackend.php?searchTree=${encodeURIComponent(text)}`)
        .then(response => response.text())
        .then(data => {
            document.querySelector('#treeRedeem').innerHTML = data;
    })



}



/* ------------------------ start running here---------------------- */

document.addEventListener('DOMContentLoaded',() =>{
    // loadUpcomingEvent();

    document.querySelector('#searchRedeem').addEventListener('keyup', searchItem);




})