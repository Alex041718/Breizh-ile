
document.addEventListener('DOMContentLoaded', function() {

    var header = document.querySelector('.header');
    var profil = document.getElementById('profil');
    var options = document.getElementById('options');
    var oeuil = document.getElementById('oeuil');
    var popup = document.getElementById('popup');
    var taille = document.getElementById('taille');
    var couleurs = document.getElementById('couleurs');
    var font = document.getElementById('font');
    var animations = document.getElementById('animations');
    var parent__taille = document.getElementById('parent__taille');
    

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
        if (popup.style.display === 'none') {
            popup.style.display = "flex";
        } else {
            popup.style.display = 'none';
        }
    })

    taille.addEventListener('click', function() {
            //mettre en plus grand
            
            if (document.body.classList.contains('accessibilite__taille')){
                parent__taille.style.backgroundColor = "#FFF";
                document.body.classList.remove('accessibilite__taille');

            }
            else{
                parent__taille.style.backgroundColor = "#37906c";
                document.body.classList.add('accessibilite__taille');

            }
            
        
    });

    couleurs.addEventListener('click', function() {
 
        if (document.body.classList.contains('accessibilite__couleurs')){
            parent__couleurs.style.backgroundColor = "#FFF";
            document.body.classList.remove('accessibilite__couleurs');

        }
        else{
            parent__couleurs.style.backgroundColor = "#37906c";
            document.body.classList.add('accessibilite__couleurs');

        }
        
    });

    font.addEventListener('click', function() {
 
        if (document.body.classList.contains('accessibilite__font')){
            parent__font.style.backgroundColor = "#FFF";
            document.body.classList.remove('accessibilite__font');

        }
        else{
            parent__font.style.backgroundColor = "#37906c";
            document.body.classList.add('accessibilite__font');

        }
        
    });

    animations.addEventListener('click', function() {
 
        if (document.body.classList.contains('accessibilite__animations')){
            parent__animations.style.backgroundColor = "#FFF";
            document.body.classList.remove('accessibilite__animations');

        }
        else{
            parent__animations.style.backgroundColor = "#37906c";
            document.body.classList.add('accessibilite__animations');

        }
        
    });

    // Popup Settings




    
});