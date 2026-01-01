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


// item line chart
/*
    PHP alr passed the data:
        const lineGraph_labels
        const lineGraph_merchandiseData
        const lineGraph_treeData
        const lineGraph_allData
*/
// execute directly after the HTML document structure is loaded
document.addEventListener("DOMContentLoaded", () => {
    const chart = document.getElementById("item-lineChart");
    const itemSelector = document.getElementById("itemList");

    // debug purpose
    // if (!chart) return

    // initialize graph
    let itemLineChart = new Chart(chart, {
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
        const item = e.target.value; // get the value (all, merchandise, tree)

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
        else if (item === 'tree') {
            newData = lineGraph_treeData;
            newColor = "#7fb5ff";
        }

        // update the datasets data
        itemLineChart.data.datasets[0].data = newData;
        // update the curve color
        itemLineChart.data.datasets[0].borderColor = newColor;
        // update the background color
        itemLineChart.data.datasets[0].backgroundColor = newColor + "33";

        itemLineChart.update();
    });
});