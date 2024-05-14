document.addEventListener('DOMContentLoaded', function() {
    var profil = document.getElementById('profil');
    var options = document.getElementById('options');
    var oeuil_ouvert = document.getElementById('oeuil_ouvert');
    var oeuil_ferme = document.getElementById('oeuil_ferme');

    profil.addEventListener('click', function() {
        if (options.style.display === 'none') {
            options.style.display = 'block';
        } else {
            options.style.display = 'none';
        }
    });

    oeuil_ouvert.addEventListener('click', function() {
        oeuil_ferme.style.display = 'block';
        oeuil_ouvert.style.display = 'none';
    });

    oeuil_ferme.addEventListener('click', function() {
        oeuil_ouvert.style.display = 'block';
        oeuil_ferme.style.display = 'none';
    });

});