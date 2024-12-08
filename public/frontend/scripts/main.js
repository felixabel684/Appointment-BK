/*==================== SCROLL SECTIONS ACTIVE LINK ====================*/
const sections = document.querySelectorAll("section[id]");

function scrollActive() {
    const scrollY = window.pageYOffset;

    sections.forEach((current) => {
        const sectionHeight = current.offsetHeight;
        const sectionTop = current.offsetTop - 50;
        const sectionId = current.getAttribute("id");

        if (window.scrollY > sectionTop && window.scrollY <= sectionTop + sectionHeight) {
            document.querySelector(`.nav_menu a[href*="${sectionId}"]`).classList.add('active-link');
        } else {
            document.querySelector(`.nav_menu a[href*="${sectionId}"]`).classList.remove('active-link');
        }
    });
}
window.addEventListener("scroll", scrollActive);

/*==================== LOAD MORE ====================*/
let loadMoreBtn = document.querySelector("#load-more");
let currentItem = 3;

let boxes = [
    ...document.querySelectorAll(".doctors .row-member .member-content"),
];

for (var i = 0; i < currentItem; i++) {
    if (boxes[i]) {
        boxes[i].style.display = "inline-block";
    }
}

loadMoreBtn.onclick = () => {
    for (let i = currentItem; i < currentItem + 3; i++) {
        if (boxes[i]) {
            boxes[i].style.display = "inline-block";
        }
    }

    currentItem += 3;

    if (currentItem >= boxes.length) {
        loadMoreBtn.style.display = "none";
    }
};
