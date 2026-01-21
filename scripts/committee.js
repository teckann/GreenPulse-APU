const treeStatusFilter = document.querySelectorAll(".filterTree");
// console.log(treeStatusFilter);

for (eachFilter of treeStatusFilter) {
    eachFilter.addEventListener("change", function() {
        eachFilter.form.submit();
        console.log("select box is clickedd")
    })
}

// const itemStatus = document.querySelector('itemStatus');
// const statusText = itemStatus.innerText;

// if (statusText.innerText === "Inactive") {
    
// }

