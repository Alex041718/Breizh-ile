document.addEventListener("DOMContentLoaded", function() {
    const divs = document.querySelectorAll('.content__selector > div');
    const contents = document.querySelectorAll('.content > div:not(:first-child)');

    divs.forEach((div, index) => {
        div.addEventListener('click', function () {
            divs.forEach(item => {
                item.classList.remove('content__selector--current');
            });
            this.classList.add('content__selector--current');

            // Afficher le contenu correspondant
            contents.forEach(content => {
                content.style.display = "none";
            });
            contents[index].style.display = "flex";
        });
    });
});