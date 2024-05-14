document.addEventListener('DOMContentLoaded', function() {

    var header = document.querySelector('header');

    var profil = document.getElementById('profil');
    var options = document.getElementById('options');

    profil.addEventListener('click', function() {
        if (options.style.display === 'none') {
            options.style.display = 'block';
        } else {
            options.style.display = 'none';
        }
    });

    document.addEventListener("scroll", function() {
        if(document.documentElement.scrollTop > 85) header.classList.add("scroll");
        else header.classList.remove("scroll");
    })



});