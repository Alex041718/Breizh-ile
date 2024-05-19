
document.addEventListener('DOMContentLoaded', function() {

    const header = document.querySelector('.header');
    const profil = document.getElementById('profil');
    const options = document.getElementById('options');
    const oeuil = document.getElementById('oeuil');
    const popup = document.getElementById('popup');
    const taille = document.getElementById('taille');
    const couleurs = document.getElementById('couleurs');
    const font = document.getElementById('font');
    const animations = document.getElementById('animations');
    const parent__taille = document.getElementById('parent__taille');

    if (header.dataset.tag != 1) {
        let tagToScroll = document.querySelector("." + header.dataset.tag);

        document.addEventListener("scroll", function() {
            if(document.documentElement.scrollTop > tagToScroll.offsetTop && !header.classList.contains("scrolling")) header.classList.add("scroll");
            else if(!header.classList.contains("scrolling")) header.classList.remove("scroll");
        })
    }

    profil.addEventListener('click', function() {
        if (options.style.display === 'none') {
            options.style.display = 'block';
        } else {
            options.style.display = 'none';
        }
    });

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

});