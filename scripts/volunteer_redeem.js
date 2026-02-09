function searchItem() {


    let text = document.querySelector("#searchRedeem").value;


    if(document.querySelector('#navRedeem1').style.background !== 'transparent'){


        return fetch(`itemBackend.php?searchMerchandise=${text}`)
        .then(response => response.text())
        .then(data => {
            document.querySelector('#merchandiseRedeem').innerHTML = data;
    })
    }else if (document.querySelector('#navRedeem2').style.background !== 'transparent'){

        return fetch(`itemBackend.php?searchTree=${text}`)
        .then(response => response.text())
        .then(data => {
            document.querySelector('#treeRedeem').innerHTML = data;
    })


    }
}

function getGivenName() {
    const type = document.querySelector('#typeAndId').name;
    const form = document.querySelector('#redeemOrAdoptForm');
    
    if (type === 'tree') {
        let name = prompt("Name Your Tree (Enter N to cancel adoption):");

        
        if (name != null && name.trim() !== "" && name.trim() !== "N") {

            document.querySelector('#givenNameInput').value = name;
            
            form.submit();
        } else {
            alert("Adoption Failed, Please give a name for your tree.");
        }
    } else {
        let confirm = prompt("confirm Redeem? (enter 'Y' is Yes):");
        if(confirm.trim() === "Y"){
            form.submit();
        }else{
            alert("Redemption Cancelled.");
        }
        
    }
}

function changeQuantity(minusOrPlus) {
    
    const onePrice = parseInt(document.querySelector('#pointPerItem').value);

    const qtyShow = document.querySelector('#itemQuantityShow');
    const qtyInput = document.querySelector('#quantityInput');
    const redeemBtn = document.querySelector('#itemRedeemBtn');

    let quantity = parseInt(qtyInput.value);

    quantity += minusOrPlus;

    if(quantity < 1) {
        quantity = 1; 
    }

    

    qtyShow.innerHTML = quantity;



    qtyInput.value = quantity;


    const totalCost = onePrice * quantity;
    document.querySelector('#toalCostInput').value = totalCost;

    redeemBtn.innerHTML = `Redeem (-${totalCost} GP)`;

}



/* ------------------------ start running here---------------------- */

document.addEventListener('DOMContentLoaded',() =>{
    // loadUpcomingEvent();
    if(document.querySelector('#searchRedeem')){

        document.querySelector('#searchRedeem').addEventListener('keyup', searchItem);

    }

    if(document.querySelector('#minusBtn')){

        document.querySelector('#minusBtn').addEventListener('click', () => {
            changeQuantity(-1);
        })
    }
    if(document.querySelector('#plusBtn')){

        document.querySelector('#plusBtn').addEventListener('click', () => {

            changeQuantity(1);
        })
    }

    if(document.querySelector('#itemRedeemBtn')){
        
        document.querySelector('#itemRedeemBtn').addEventListener('click', getGivenName);
    }




})