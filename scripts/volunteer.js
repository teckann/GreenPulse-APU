let Navigation = [
    "Home","Point Details","Event","Profile","Study", 
    "Redeem", "Badge","Milestone","Available Event",
    "My Event", "My Tree", "History", "About Us"
];


function navSearching(searchAreaid, dropDownid) {
    const searchArea = document.querySelector(searchAreaid);
    const dropDown = document.querySelector(dropDownid);

    searchArea.addEventListener('keyup', () => {
        const input = searchArea.value.toLowerCase();

        dropDown.innerHTML = '';

        if(input){
            for(nav of Navigation){
                if((nav.toLowerCase()).startsWith(input)){
                    dropDown.innerHTML += `<li class="dropDownItem" data-nav="${nav}">${nav}</li>`;
                }
            }

            if(dropDown.innerHTML !== ''){
                
                dropDown.style.display = 'flex';
                searchArea.style.borderRadius = '10px 10px 0 0';
            }else {
                dropDown.style.display = 'none';
                searchArea.style.borderRadius = '24px';
            }

        }



        document.querySelectorAll('.dropDownItem').forEach(link => {
            link.onclick = () => {
                switch(link.getAttribute('data-nav')){
                    case Navigation[0] : 
                        window.location.href = '../../pages/volunteer/index.php';
                        break;
                    case Navigation[1] : 
                        window.location.href = '../../pages/volunteer/point.php';
                        break;
                    case Navigation[2] : 
                        window.location.href = '../../pages/volunteer/event.php';
                        break;
                    case Navigation[3] : 
                        window.location.href = '../../pages/volunteer/profile.php';
                        break;
                    case Navigation[4] : 
                        window.location.href = '../../pages/volunteer/study.php';
                        break;
                    case Navigation[5] : 
                        window.location.href = '../../pages/volunteer/redeem.php';
                        break;
                    case Navigation[6] : 
                        window.location.href = '../../pages/volunteer/badge.php';
                        break;
                    case Navigation[7] : 
                        window.location.href = '../../pages/volunteer/mileStone.php';
                        break;
                        
                    case Navigation[8] : 
                        window.location.href = '../../pages/volunteer/availableEvent.php';
                        break;
                    case Navigation[9] : 
                        window.location.href = '../../pages/volunteer/myEvent.php';
                        break;
                    case Navigation[10] : 
                        window.location.href = '../../pages/volunteer/myTree.php';
                        break;
                    case Navigation[11] : 
                        window.location.href = '../../pages/volunteer/history.php';
                        break;
                    case Navigation[12] : 
                        window.location.href = '../../pages/volunteer/aboutUs.php';
                        break;
                    default:
                        break;
                }
            }
        })

        document.addEventListener('click', () => {
            dropDown.style.display = 'none';
            searchArea.style.borderRadius = '24px';
            searchArea.value = '';
        });

    })

}

function openPhoneSideBar(){
    const sideBar = document.querySelector('#phoneSideBar');

    if(sideBar.style.display === 'none'){
        sideBar.style.display = 'flex';
    }else{
        sideBar.style.display = 'none';
    }

}


function changingPageStudy(button) {

    document.querySelector('#navStudy1').style.background = 'transparent';
    document.querySelector('#navStudy2').style.background = 'transparent';

    button.parentElement.style.background = '#ffbb00';

    const availableDiv = document.querySelector('#availableStudy');
    const completedDiv = document.querySelector('#completedStudy');

    if(button.id === 'availableStudyNav'){
        availableDiv.style.display = 'flex';
        completedDiv.style.display = 'none';
    }else if(button.id === 'completedStudyNav'){
        availableDiv.style.display = 'none';
        completedDiv.style.display = 'flex';
    }

}

function changingPageRedeem(button) {

    document.querySelector('#navRedeem1').style.background = 'transparent';
    document.querySelector('#navRedeem2').style.background = 'transparent';

    button.parentElement.style.background = '#ffbb00';

    const merchandiseDiv = document.querySelector('#merchandiseRedeem');
    const treeDiv = document.querySelector('#treeRedeem');

    if(button.id === 'merchandiseRedeemNav'){
        merchandiseDiv.style.display = 'flex';
        treeDiv.style.display = 'none';
    }else if(button.id === 'treeStudyNav'){
        merchandiseDiv.style.display = 'none';
        treeDiv.style.display = 'flex';
    }

}
function changingPageBadgeMilestone(button) {

    document.querySelector('#navBadge').style.background = 'transparent';
    document.querySelector('#navMilestone').style.background = 'transparent';

    button.parentElement.style.background = '#ffbb00';

    const badgeDiv = document.querySelector('#badgeDiv');
    const milestoneDiv = document.querySelector('#milestoneDiv');

    if(button.id === 'badgeNav'){
        badgeDiv.style.display = 'grid';
        milestoneDiv.style.display = 'none';
    }else if(button.id === 'milestoneNav'){
        badgeDiv.style.display = 'none';
        milestoneDiv.style.display = 'flex';
    }

}


function searchEvent(e) {

    e.preventDefault();

    let text = document.querySelector("#searchEvent").value;
    const id = document.querySelector('.eventCardContainer').id;

    if(id === 'myEventBox'){

        const selectedFilter = document.querySelector('input[name="filterEvent"]:checked').value;

        return fetch(`eventBackend.php?searchMyEvent=${text}&filtering=${selectedFilter}`)
        .then(response => response.text())
        .then(data => {
            document.querySelector('.eventCardContainer').innerHTML = data;
    })
    }else if (id === 'availableEventBox'){
        return fetch(`eventBackend.php?searchAvailableEvent=${text}`)
        .then(response => response.text())
        .then(data => {
            document.querySelector('.eventCardContainer').innerHTML = data;
    })

    }

}





function filterEvent() {
    const filterDiv = document.querySelector('.filter');
    const button = document.querySelector('.filterBtn');
    const allSelection = document.querySelectorAll('input[name="filterEvent"]');
    const dropDown = document.querySelector('#filterDropDown');

    allSelection.forEach(radio => {
        radio.addEventListener('change', () => {

            const selectedRadio = radio.value;

            return fetch(`../../pages/volunteer/eventBackend.php?myfilter=${selectedRadio}`)
            .then(response => response.text())
            .then(data => {
                document.querySelector('#myEventBox').innerHTML = data;

            
        })


        });

    });

    button.addEventListener('click', (e) => {

        e.stopPropagation();

        const currentStyle = dropDown.style.display;


        if(currentStyle === 'none'){
            dropDown.style.display = 'flex';
        }else {
            dropDown.style.display = 'none';
        }

        
    });

    document.addEventListener('click', (e) => {
        if(!dropDown.contains(e.target)){
            dropDown.style.display = 'none';
        }
        
        
    });
}

function getPoint(currentOrTotal){
    if(currentOrTotal === 1){
        return fetch("../../pages/volunteer/pointBackend.php?getPoint=currentpoint")
        .then(response => response.text())
        .then(data => {
            return data;
        })
    }else if(currentOrTotal === 2){
        return fetch("../../pages/volunteer/pointBackend.php?getPoint=totalPoint")
        .then(response => response.text())
        .then(data => {
            return data;
        })
    }
}

function getMilestone($dataToGet){


    return fetch(`../../pages/volunteer/badgeBackend.php?getBadge=${$dataToGet}`)
    .then(response => response.text())
    .then(data => {
        return data;
    })

}
/*
function loadUpcomingEvent() {
    fetch("../../pages/volunteer/eventBackend.php?toload=today")
    .then(respone => respone.text())
    .then(data => {
        document.querySelector("#todayBoxContainer").innerHTML = data;
    })

    fetch("../../pages/volunteer/eventBackend.php?toload=tomorrow")
    .then(respone => respone.text())
    .then(data => {
        document.querySelector("#tomorrowBoxContainer").innerHTML = data;
    })
}
*/
function remainmingPoints() {
    getMilestone('badgePercentage').then(data => {



        let percentage = data*100;



        document.querySelector('.currentProgress').style.width =  `${percentage}%`;


    })
}

/* ------------------------ start running here---------------------- */

document.addEventListener('DOMContentLoaded',() =>{
    // loadUpcomingEvent();

        if(document.querySelector('#uploadProPic')){

        const fileInput = document.querySelector('#uploadProPic');

        document.querySelector('#uploadPicBtn').addEventListener('click', () => {
            fileInput.click();
        });

        fileInput.addEventListener('change', () => {
                document.querySelector('#profilePicForm').submit();
        });

    }



    const btnAvailable = document.querySelector('#availableStudyNav');
    const btnCompleted = document.querySelector('#completedStudyNav');
    
    const btnMerchandise = document.querySelector('#merchandiseRedeemNav');
    const btnTree = document.querySelector('#treeStudyNav');

    const btnBadge = document.querySelector('#badgeNav');
    const btnMilestone= document.querySelector('#milestoneNav');

    if(btnAvailable && btnCompleted) {
        btnAvailable.addEventListener('click', (e) => changingPageStudy(e.target));

        btnCompleted.addEventListener('click', (e) => changingPageStudy(e.target));
    }

    if(btnMerchandise && btnTree) {
        btnMerchandise.addEventListener('click', (e) => changingPageRedeem(e.target));

        btnTree.addEventListener('click', (e) => changingPageRedeem(e.target));
    }
    if(btnBadge && btnMilestone) {
        btnBadge.addEventListener('click', (e) => changingPageBadgeMilestone(e.target));

        btnMilestone.addEventListener('click', (e) => changingPageBadgeMilestone(e.target));
    }



    if(document.querySelector('#oneEventBack')){
        document.querySelector('#oneEventBack').addEventListener('click', ()=> {
            history.back();

        })
    }







    
    document.querySelector('#headerSearchArea').addEventListener('focus', (e) => navSearching('#headerSearchArea','#searchDropDown'));
    document.querySelector('#phoneSearchArea').addEventListener('focus', (e) => navSearching('#phoneSearchArea','#phoneSearchDropDown'));

    getPoint(1).then(data => {
        document.querySelector('.pointAmount').innerHTML = `${data} GP` ;

    });

    getMilestone('requiredPoints').then(data => {

        let toPrintNM = `${data} GP`;

        if(!data){
            toPrintNM = ' You Reach The Highest Milestone';
        }

        
        
        document.querySelector('.nextMilestone').innerHTML = toPrintNM ;
    });

    remainmingPoints();

    filterEvent();


    document.querySelector('#searchEvent').addEventListener('keyup', searchEvent);



})

window.onscroll = () => {
    if(window.innerHeight + window.scrollY >= (document.body.offsetHeight - 50)){
        const reload = document.querySelector('.reloadSpace');
        const reloadIcon = document.querySelector('#reloadIcon');
        reload.style.display = 'grid';
        document.addEventListener('animationend', () => { 
            reloadIcon.style.display = 'none'; 
            document.querySelector('.footerGeneral').style.display = 'flex';
        
        },{once: true});


    }

}
