document.addEventListener('DOMContentLoaded', function() {

    var header = document.querySelector('.header');
    var profil = document.getElementById('profil');
    var options = document.getElementById('options');
    var oeuil = document.getElementById('oeuil');

    profil.addEventListener('click', function() {
        if (options.style.display === 'none') {
            options.style.display = 'block';
        } else {
            options.style.display = 'none';
        }
    });

    document.addEventListener("scroll", function() {
        if(document.documentElement.scrollTop > 85 && !header.classList.contains("scrolling")) header.classList.add("scroll");
        else if(!header.classList.contains("scrolling")) header.classList.remove("scroll");
    })

    oeuil.addEventListener('click', function() {
        let newWindow = open('../../index.php', 'example', 'width=300,height=300')
        newWindow.focus();

        newWindow.onload = function() {
        };
    })


});