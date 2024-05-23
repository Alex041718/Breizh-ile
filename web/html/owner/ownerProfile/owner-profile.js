document.addEventListener("DOMContentLoaded", function() {
    const infos = document.getElementById('infos');
    const security = document.querySelector('.content__security');

    const infosBtn = document.getElementById('infos__btn');
    const securityBtn = document.getElementById('security__btn');

    const personalData = document.querySelector('.content__personnal-data');

    // Activer par défaut le contenu "Informations Personnelles"


    securityBtn.addEventListener("click", function() {
        toggle();
    })

    infosBtn.addEventListener("click", function() {
        toggle();
    })

    function toggle() {
        securityBtn.classList.toggle("active");
        infosBtn.classList.toggle("active");
        infos.classList.toggle('content__display');
        security.classList.toggle('content__display');
    } 
});
