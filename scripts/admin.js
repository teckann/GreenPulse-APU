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


// select box
document.addEventListener("DOMContentLoaded", () => {
    const userFilter1 = document.querySelector("#userRole");
    const userFilter2 = document.querySelector("#userStatus");

    const eventFilter = document.querySelector("#eventStatus");

    const itemFilter1 = document.querySelector("#itemCategory");
    const itemFilter2 = document.querySelector("#itemStatus");

    const moduleFilter = document.querySelector("#moduleStatus");

    const submissionFilter = document.querySelector("#submission-status");

    const logFilter1 = document.querySelector("#logSort");
    const logFilter2 = document.querySelector("#logStatus");

    if (userFilter1 || userFilter2) {
        const form = document.getElementById("user-form");

        userFilter1.addEventListener("change", () => {
            form.submit();
        });

        userFilter2.addEventListener("change", () => {
            form.submit();
        });
    }

    if (eventFilter) {
        eventFilter.addEventListener("change", () => {
            const form = document.getElementById("event-form");
            form.submit();
        });
    }

    if (itemFilter1 || itemFilter2) {
        const form = document.getElementById("item-form");

        itemFilter1.addEventListener("change", () => {
            form.submit();
        });

        itemFilter2.addEventListener("change", () => {
            form.submit();
        });
    }

    if (moduleFilter) {
        moduleFilter.addEventListener("change", () => {
            const form = document.getElementById("module-form");
            form.submit();
        });
    }

    if (submissionFilter) {
        submissionFilter.addEventListener("change", () => {
            const form = document.getElementById("submission-form");
            form.submit();
        });
    }

    if (logFilter1 || logFilter2) {
        const form = document.getElementById("log-form");

        logFilter1.addEventListener("change", () => {
            form.submit();
        });

        logFilter2.addEventListener("change", () => {
            form.submit();
        });
    }
});

// contact submission button listen
// asking yes or not, if not prevent default, else continue do the default action
document.addEventListener("DOMContentLoaded", () => {
    const confirmButtons = document.querySelectorAll(".confirm-btn");

    if (confirmButtons.length > 0) {
        confirmButtons.forEach((btn) => {
            btn.addEventListener("click", (e) => {
                const status = confirm("Are you sure you have contacted the sender?");

                if (!status) {
                    e.preventDefault();
                }
            });
        });
    }
});