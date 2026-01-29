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

function changeQuantity(minusOrPlus) {
    let quantity = 1;
    const onePrice = parseInt(document.querySelector('#pointPerItem').value);

    const qtyShow = document.querySelector('#itemQuantityShow');
    const qtyInput = document.querySelector('#quantityInput');
    const redeemBtn = document.querySelector('#itemRedeemBtn');



    quantity += minusOrPlus;
    if(quantity < 1) {
        quantity = 1; 
    }


    qtyShow.innerHTML = quantity;
    qtyInput.value = quantity;


    const totalCost = onePrice * quantity;
    redeemBtn.innerText = `Redeem (-${totalCost} GP)`;

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




})