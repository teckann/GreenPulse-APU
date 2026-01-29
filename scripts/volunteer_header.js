function openHamburger() {
    const sideBar = document.querySelector('.phoneHamburger');
    const blocking = document.querySelector("#blockEverything");
    const body = document.body;


        sideBar.style.display = "flex";
        blocking.style.display = "block";
        body.classList.add("noScrolling");

}

function closeHamburger() {
    const sideBar = document.querySelector(".phoneHamburger");
    const blocking = document.querySelector("#blockEverything");
    const body = document.body;

        sideBar.style.display = "none";
        blocking.style.display = "none";
        body.classList.remove("noScrolling")



}

document.addEventListener('DOMContentLoaded',() =>{
    // loadUpcomingEvent();

    document.querySelector('#menuButton').addEventListener('click',openHamburger);
    document.querySelector(".close-btn").addEventListener('click', closeHamburger);
    document.querySelector("#blockEverything").addEventListener('click', closeHamburger);
});