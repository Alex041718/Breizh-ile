
document.addEventListener('DOMContentLoaded', function() {


    var header = document.querySelector('.header');
    var profil = document.getElementById('profil');
    var options = document.getElementById('options');
    var oeuil = document.getElementById('oeuil');
    var popup = document.getElementById('popup__access');

    var taille = document.getElementById('taille');
    var couleurs = document.getElementById('couleurs');
    var font = document.getElementById('font');
    var animations = document.getElementById('animations');

    var parent__taille = document.getElementById('parent__taille');
    var parent__couleurs = document.getElementById('parent__couleurs');
    var parent__animations = document.getElementById('parent__animations');
    var parent__font = document.getElementById('parent__font');
    var closeAccess = document.getElementById("closeAccess");

    var closeAccess = document.getElementById("closeAccess");


    if (header.dataset.tag != 1) {
        let tagToScroll = document.querySelector("." + header.dataset.tag);

        document.addEventListener("scroll", function() {
            if(document.documentElement.scrollTop > tagToScroll.offsetTop && !header.classList.contains("scrolling")) header.classList.add("scroll");
            else if(!header.classList.contains("scrolling")) header.classList.remove("scroll");
        })
    }

    popup.addEventListener("click", function(event) {
        if(event.target === popup) closePopup();
    })

    closeAccess.onclick = function() {
        closePopup();
    }
    
    function closePopup() {
        popup.style.display = 'none';
        document.body.style.overflow = 'auto';
    }

    document.addEventListener('click', function(event){
        if (event.target != profil){
            options.style.display = 'none';
        }
    })

  
    profil.addEventListener('click', function() {
        if (options.style.display === 'none') {
            options.style.display = 'block';
        } else {
            options.style.display = 'none';
        }
    });


    popup.style.display = "none";
    oeuil.addEventListener('click', function() {
        if (popup.style.display === 'none') {
            popup.style.display = "flex";
        } else {
            closePopup();
        }
    })

    parent__taille.addEventListener('click', function() {
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

    parent__couleurs.addEventListener('click', function() {
 
        if (document.body.classList.contains('accessibilite__couleurs')){
            parent__couleurs.style.backgroundColor = "#FFF";
            document.body.classList.remove('accessibilite__couleurs');
            document.querySelector('header').classList.remove('accessibilite__couleurs');
            document.querySelector('footer').classList.remove('accessibilite__couleurs');            
        }
        else{
            parent__couleurs.style.backgroundColor = "#37906c";
            document.body.classList.add('accessibilite__couleurs');
            document.querySelector('header').classList.add('accessibilite__couleurs');
            document.querySelector('footer').classList.add('accessibilite__couleurs');
        }
    });
    
    parent__font.addEventListener('click', function() {
 
        if (document.body.classList.contains('accessibilite__font')){
            parent__font.style.backgroundColor = "#FFF";
            document.body.classList.remove('accessibilite__font');

        }
        else{
            parent__font.style.backgroundColor = "#37906c";
            document.body.classList.add('accessibilite__font');

        }
        
    });

    parent__animations.addEventListener('click', function() {
 
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