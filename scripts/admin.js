// sidebar settings
const sidebar = document.getElementById("sidebar");
const openMenu = document.getElementById("open-menu");
const closeMenu = document.getElementById("close-menu");

openMenu.addEventListener("click", () => {
    sidebar.classList.toggle("show");
});

closeMenu.addEventListener("click", () => {
    sidebar.classList.remove("show");
});

window.addEventListener("click", (e) => {
    // 1. make sure sidebar alr display on screen
    // 2. make sure the area that user click is not on the sidebar
    if (sidebar.classList.contains("show") && !sidebar.contains(e.target)) {
        // very important, if not this condition, every time user open the sidebar will be closed back immediately
        // we should make sure the clicked target is not the openMenu button
        // event bubbling*
        if (!openMenu.contains(e.target)) {
            sidebar.classList.remove("show");
        }
    }
});


// sidebar elements selected effect
const navAnchorTag = document.querySelectorAll(".nav-pages a");
const currentFile = window.location.pathname.split("/").pop(); // current file path

// default: Dashboard will be selected
// ..../admin/index.php sometime will be simplify as ..../admin
if (currentFile === "" || currentFile === "admin") {
    document.getElementById("dashboard").classList.add("active");
}

navAnchorTag.forEach(link => {
    const href = link.getAttribute("href");
    if (href.includes(currentFile)) {
        link.classList.add("active");
    }
});


// execute directly after the HTML document structure is loaded
// https://github.com/chartjs/Chart.js?tab=readme-ov-file
// documentation that I refer: https://www.chartjs.org/docs/2.9.4/
document.addEventListener("DOMContentLoaded", () => {
    // item line graph
    /*
        PHP alr passed the data:
            const lineGraph_labels
            const lineGraph_merchandiseData
            const lineGraph_treeData
            const lineGraph_allData
    */
    const lineGraph = document.getElementById("item-lineGraph");
    const itemSelector = document.getElementById("itemList");

    // initialize graph
    let itemLineGraph = new Chart(lineGraph, {
        type: "line",
        data: {
            // assign lineGraph_labels (from PHP) to labels
            labels: lineGraph_labels,
            datasets: [{
                label: "Redemption Quantity",
                // assign lineGraph_allData (from PHP) to data
                data: lineGraph_allData,
                borderColor: "#194a7a",
                backgroundColor: "rgba(25, 74, 122, 0.1)",
                borderWidth: 2, // bold level of the curve line
                tension: 0.4, // make the curve more smooth
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false, // must false, so can allow CSS adjust
            plugins: {
                legend: { display: false } // hide the legend, alr have dropdown menu
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1 } // only integer
                }
            }
        }
    });

    // listen the dropdown menu
    itemSelector.addEventListener("change", (e) => {
        // get the value (all, merchandise, tree)
        const item = e.target.value;

        let newData = [];
        let newColor = "";

        if (item === "all") {
            newData = lineGraph_allData;
            newColor = "#194a7a";
        }
        else if (item === "merchandise") {
            newData = lineGraph_merchandiseData;
            newColor = "#3b7ddd";
        }
        else if (item === "tree") {
            newData = lineGraph_treeData;
            newColor = "#7fb5ff";
        }

        // update the datasets data
        itemLineGraph.data.datasets[0].data = newData;
        // update the curve color
        itemLineGraph.data.datasets[0].borderColor = newColor;
        // update the background color
        itemLineGraph.data.datasets[0].backgroundColor = newColor + "33";

        itemLineGraph.update();
    });



    // module enrollment bar chart
    /*
        PHP alr passed the data:
            const barChart_labels
            const lineChart_data
    */
    const barChart = document.getElementById("module-barChart");

    new Chart(barChart, {
        type: "bar", // bar chart
        data: {
            labels: barChart_labels,
            datasets: [{
                label: false,
                data: barChart_data,
                borderColor: "#194a7a",
                backgroundColor: "rgba(25, 74, 122, 0.4)",
                borderWidth: 0.4,
                borderRadius: 5,
                barPercentage: 0.5
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false, // must false, so can allow CSS adjust
            plugins: {
                legend: { display: false } // hide the legend, alr have dropdown menu
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1 } // only integer
                }
            }
        }
    });
});



// sidebar (search feature)
/**
 * * Note: the dashboard dont support search feature
 * ! Problem: chart will disappear + HTML / PHP code display on the page
 * ? Small Bug: when search only one character, then HTML / PHP code also display on the page
 */

document.addEventListener("DOMContentLoaded", () => {
    const searchInput = document.getElementById("txtSearchInput");
    const contentArea = document.querySelector(".search-area");

    const removeHighlights = () => {
        // find all tags with the highlight-text class in the search-area
        const highlights = contentArea.querySelectorAll(".highlight-text");

        highlights.forEach(targetElement => {
            // remove the class, so it will back to original one
            targetElement.classList.remove("highlight-text");
        });
    }

    searchInput.addEventListener("keypress", (e) => {
        if (e.key === "Enter") {
            e.preventDefault(); // prevent the auto refresh the page
            let inputValue = searchInput.value.trim();
            searchInput.blur(); // remove the focus of the searchbar

            if (inputValue) {
                removeHighlights();

                // create a regular expression (refer: https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/RegExp)
                // g = global (find all), i = case-insensitive (dont care UpperCase or LowerCase)
                let target = new RegExp(inputValue, "gi");
                // compare with target, only matched element will be replace to the span tag
                // $& = the text that match, put again inside the span tag
                contentArea.innerHTML = contentArea.innerHTML.replace(target, "<span class='highlight-text'>$&</span>");


                // auto scroll to the first result that found
                let firstResult = contentArea.querySelector(".highlight-text");

                if (firstResult) {
                    firstResult.scrollIntoView({
                        behavior: "smooth",
                        block: "center" // make it center on the screen
                    });
                }
            }
            else {
                return;
            }
        }
    });

    // another function to remove the highlight becasue
    // I dont want the user click the searchbar, then the highlight directly remove
    const removeHighlights2 = (e) => {
        // click the searchbar itself, then nothing
        if (e.target === searchInput) {
            return;
        }

        // otherwise, onece it contain highlight-text class, the class will be remove
        if (contentArea.querySelector(".highlight-text")) {
            removeHighlights();
        }
    }

    // I dont want the user click the searchbar, then the highlight directly remove
    // so use removeHighlights2 to prevent the event target to the searchbar
    document.addEventListener("wheel", removeHighlights2); // Mouse wheel, for desktop
    document.addEventListener("touchmove", removeHighlights2); // finger swipe, for mobile
});

// open & close the popup form
document.addEventListener("DOMContentLoaded", () => {
    const btnOpen = document.querySelector(".addNewUser-btn");
    const btnClose = document.getElementById("popup-close-menu");
    const popup = document.getElementById("popup");
    const overlay = document.getElementById("popupOverlay");
    const erroMsg = document.querySelectorAll(".popup-error-text");

    btnOpen.addEventListener("click", () => {
        popup.style.display = "block";
        overlay.style.display = "block";

        erroMsg.forEach((e) => {
            e.style.display = "none";
        });
    });

    function closePopup() {
        popup.style.display = "none";
        overlay.style.display = "none";
    }

    btnClose.addEventListener("click", closePopup);
    overlay.addEventListener("click", closePopup);
});