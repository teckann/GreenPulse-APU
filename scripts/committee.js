const treeStatusFilter = document.querySelectorAll(".filterTree");
// console.log(treeStatusFilter);

for (eachFilter of treeStatusFilter) {
    eachFilter.addEventListener("change", function() {
        eachFilter.form.submit();
        console.log("select box is clicked")
    })
}

// const itemStatus = document.querySelector('itemStatus');
// const statusText = itemStatus.innerText;

// if (statusText.innerText === "Inactive") {
    
// }

const merchandiseStatusFilter = document.querySelectorAll(".filterMerchandise");
// console.log(treeStatusFilter);

for (eachFilter of merchandiseStatusFilter) {
    eachFilter.addEventListener("change", function() {
        eachFilter.form.submit();
        console.log("select box is clicked")
    })
}
