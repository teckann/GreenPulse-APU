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