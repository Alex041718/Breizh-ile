// select in array the element with id "description", "localisation", "specifications", "arrangements", "activities"

const pages_title = ["description", "localisation", "specifications", "arrangements", "activities"];
const pages = pages_title.map(page => document.getElementById(page));

pages.forEach(page => {
    page.addEventListener("click", () => {
        pages.forEach(p => {
            const content = document.querySelector(`.${p.id}`);
            if (content) { content.style.display = "none"; }
            p.classList.remove("active");
        });
        page.classList.add("active");
        const content = document.querySelector(`.${page.id}`);
        if (content) { content.style.display = "flex"; }
    });
});