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