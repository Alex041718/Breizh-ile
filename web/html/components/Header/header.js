
document.addEventListener('DOMContentLoaded', function() {

    var header = document.querySelector('.header');
    var profil = document.getElementById('profil');
    var profilMobile = document.getElementById('mobile-profil');
    var options = document.getElementById('options');
    var optionsMobile = document.getElementById('mobile-options');
    var oeuil = document.getElementById('oeuil');
    var popup = document.getElementById('popup__access');

    var openSearch = document.getElementById('open-search');
    var popupSearch = document.querySelector('.popup__search');


    var taille = document.getElementById('taille');
    var deute = document.getElementById('deute');
    var font = document.getElementById('font');
    var animations = document.getElementById('animations');

    var parent__taille = document.getElementById('parent__taille');
    var parent__deute = document.getElementById('parent__deute');
    var parent__animations = document.getElementById('parent__animations');
    var parent__font = document.getElementById('parent__font');
    var closeAccess = document.getElementById("closeAccess");

    let modeDeuteOn = localStorage.getItem('ModeDeuteVal') ? localStorage.getItem('ModeDeuteVal') : "non";
    let modeAnimationOn = localStorage.getItem('ModeAnimationVal') ? localStorage.getItem('ModeAnimationVal') : "non";
    let modeTailleOn = localStorage.getItem('ModeTailleVal') ? localStorage.getItem('ModeTailleVal') : "non";
    let modeFontOn = localStorage.getItem('ModeFontVal') ? localStorage.getItem('ModeFontVal') : "non";

    if (modeDeuteOn != "non"){
        parent__deute.style.backgroundColor = "brown";
        document.body.classList.add('accessibilite__deute');
        document.querySelector('header').classList.add('accessibilite__deute');
        document.querySelector('footer').classList.add('accessibilite__deute');
        parent__deute.style.color = "#ffffff";

        if (document.body.classList.contains('accessibilite__font')) {
            parent__font.style.backgroundColor = "brown";
            parent__font.style.color = "#ffffff";
        }
        if (document.body.classList.contains('accessibilite__animations')) {
            parent__animations.style.backgroundColor = "brown";
            parent__animations.style.color = "#ffffff";
        }
        if (document.body.classList.contains('accessibilite__taille')) {
            parent__taille.style.backgroundColor = "brown";
            parent__taille.style.color = "#ffffff";
        }
    }
    if (modeAnimationOn != "non"){
        parent__animations.style.backgroundColor = "#37906c";
        document.body.classList.add('accessibilite__animations');
        if (typeof checkParallaxAccessibilite === 'function') {
            checkParallaxAccessibilite();
        }
        parent__animations.style.color = "#ffffff";

        if (document.body.classList.contains('accessibilite__deute')) {
            parent__animations.style.backgroundColor = "brown";
            parent__animations.style.color = "#ffffff";
        }
    }
    if (modeTailleOn != "non"){

        parent__taille.style.backgroundColor = "#37906c";
        parent__taille.style.color = "#ffffff";
        document.body.classList.add('accessibilite__taille');

        if (document.body.classList.contains('accessibilite__deute')) {
            parent__taille.style.backgroundColor = "brown";
            parent__taille.style.color = "#ffffff";
        }

    }
    if (modeFontOn != "non"){
        parent__font.style.backgroundColor = "#37906c";
        document.body.classList.add('accessibilite__font');
        parent__font.style.color = "#ffffff";

        if (document.body.classList.contains('accessibilite__deute')) {
            parent__font.style.backgroundColor = "brown";
            parent__font.style.color = "#ffffff";
        }
    }
  
    if (header.dataset.tag != "" && header.dataset.tag != 1 && header) {
        let tagToScroll = document.querySelector("." + header.dataset.tag);

        document.addEventListener("scroll", function() {
            if(document.documentElement.scrollTop > tagToScroll.offsetTop && !header.classList.contains("scrolling")) header.classList.add("scroll");
            else if(!header.classList.contains("scrolling")) header.classList.remove("scroll");
        })
    }

    // Popup barre de recherche format mobile

    openSearch.addEventListener("click", function() {
        if (popupSearch.style.display === 'none' || !popupSearch.style.display) {
            popupSearch.style.display = 'flex';
            document.body.style.overflow = "hidden";
            popupSearch.classList.remove("popup__search__back");
        } else {
            closeSearch()
        }
    })

    function closeSearch() {
        popupSearch.classList.add("popup__search__back");
            document.body.style.overflow = "auto"
            setTimeout(function() {
                popupSearch.style.display = 'none'
            }, 300);
    }

    // DatePickr

    const begin = document.getElementById("start-date");
    const end = document.getElementById("end-date");

    const endPickrHeader = flatpickr(end, {
        dateFormat: "Y-m-d",
        maxDate: new Date().fp_incr(365),
        disable: [
            function(date) {
                // Désactiver toutes les dates
                return true;
            }
        ]
    });


    const beginPickrHeader = flatpickr(begin, {
        dateFormat: "Y-m-d",
        minDate: "today",
        maxDate: new Date().fp_incr(365),
        onChange: function(selectedDates, dateStr, instance) {
            if(selectedDates == "") {
                endPickrHeader.set('disable', [
                    function(date) {
                        // Désactiver toutes les dates
                        return true;
                    }
                ])

                endPickrHeader.clear()
            }
            else {
                endPickrHeader.set('disable', [])
                endPickrHeader.set('minDate', selectedDates[0].fp_incr(1));
                endPickrHeader.toggle();
            }
        },
    });

    // Autocomplete

    const myHeaders = new Headers();
    myHeaders.append("sec-ch-ua", "\"Chromium\";v=\"124\", \"Google Chrome\";v=\"124\", \"Not-A.Brand\";v=\"99\"");
    myHeaders.append("Referer", "http://localhost:5555/html/StoryBook.php");
    myHeaders.append("sec-ch-ua-mobile", "?0");
    myHeaders.append("User-Agent", "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36");
    myHeaders.append("sec-ch-ua-platform", "\"macOS\"");

    const requestOptions = {
        method: "GET",
        headers: myHeaders,
        redirect: "follow"
    };

    let data;

    // Autocomplete de la barre de recherche mobile

    const textInput = document.getElementById('text-input');

    fetch("https://geo.api.gouv.fr/communes?codeRegion=53", requestOptions)
    .then((response) => response.text())
    .then((result) => {

        // treat the result
        data = JSON.parse(result);

        // data contient des objets de ville, on va les transformer en tableau de string

        let cityNames = [];

        data.forEach((city) => {
            cityNames.push(`${city.nom} (${city.codesPostaux})`);
        });
        
        
        // from autompletionHelper.js
        // mise en place de lautompletion sur l'input

        autocomplete(textInput, cityNames);
    });

    // Popup settings
    
    const popup_filters = document.getElementById("popup__filter");
    const popup_filters_close = document.querySelector(".popup__filter .popup__content i");

    const popup_filters_submit = document.getElementById("filter_submit");
    // const popup_filters_open = document.getElementById("header__settings");
    // const popup_filters_open_mobile = document.getElementById("open-mobile-settings");

    // if(popup_filters_open) popup_filters_open.addEventListener("click", openSettings);
    // popup_filters_open_mobile.addEventListener("click", openSettings);

    // function openSettings() {
    //     popup_filters.classList.add("popup_enable");
    // };

    // function close_filter_popup() {
    //     popup_filters.classList.remove("popup_enable");
    
    // }

    // popup_filters_submit.addEventListener("click", close_filter_popup);
    // popup_filters_close.addEventListener("click", close_filter_popup);

    // Price filter

    //  Script.js 
    const rangevalue =  
    document.querySelector(".slider-container .price-slider"); 
    const rangeInputvalue =  
    document.querySelectorAll(".range-input input"); 

    // Set the price gap 
    let priceGap = 10; 

    // Adding event listners to price input elements 
    const priceInputvalue =  
    document.querySelectorAll(".price-input input"); 
    for (let i = 0; i < priceInputvalue.length; i++) { 
    priceInputvalue[i].addEventListener("input", e => { 

        // Parse min and max values of the range input 
        let minp = parseInt(priceInputvalue[0].value); 
        let maxp = parseInt(priceInputvalue[1].value); 
        let diff = maxp - minp 

        if (minp < 0) { 
            alert("minimum price cannot be less than 0"); 
            priceInputvalue[0].value = 0; 
            minp = 0; 
        } 

        // Validate the input values 
        if (maxp > 1000) { 
            alert("maximum price cannot be greater than 1000"); 
            priceInputvalue[1].value = 1000; 
            maxp = 1000; 
        } 

        if (minp > maxp - priceGap) { 
            priceInputvalue[0].value = maxp - priceGap; 
            minp = maxp - priceGap; 

            if (minp < 0) { 
                priceInputvalue[0].value = 0; 
                minp = 0; 
            } 
        } 

        // Check if the price gap is met  
        // and max price is within the range 
        if (diff >= priceGap && maxp <= rangeInputvalue[1].max) { 
            if (e.target.className === "min-input") { 
                rangeInputvalue[0].value = minp; 
                let value1 = rangeInputvalue[0].max; 
                rangevalue.style.left = `${(minp / value1) * 100}%`; 
            } 
            else { 
                rangeInputvalue[1].value = maxp; 
                let value2 = rangeInputvalue[1].max; 
                rangevalue.style.right =  
                    `${100 - (maxp / value2) * 100}%`; 
            } 
        } 
    }); 

    // Add event listeners to range input elements 
    for (let i = 0; i < rangeInputvalue.length; i++) { 
        rangeInputvalue[i].addEventListener("input", e => { 
            let minVal =  
                parseInt(rangeInputvalue[0].value); 
            let maxVal =  
                parseInt(rangeInputvalue[1].value); 

            let diff = maxVal - minVal 
            
            // Check if the price gap is exceeded 
            if (diff < priceGap) { 
            
                // Check if the input is the min range input 
                if (e.target.className === "min-range") { 
                    rangeInputvalue[0].value = maxVal - priceGap; 
                } 
                else { 
                    rangeInputvalue[1].value = minVal + priceGap; 
                } 
            } 
            else { 
            
                // Update price inputs and range progress 
                priceInputvalue[0].value = minVal; 
                priceInputvalue[1].value = maxVal; 
                rangevalue.style.left = 
                    `${(minVal / rangeInputvalue[0].max) * 100}%`; 
                rangevalue.style.right = 
                    `${100 - (maxVal / rangeInputvalue[1].max) * 100}%`; 
            } 
        }); 
    } 
    }

    // closeAccess.onclick = function() {
    //     closePopup();
    // }

    // Popup compte

    // popup.addEventListener("click", function(event) {
    //     if(event.target === popup) closePopup();
    // })

    // closeAccess.onclick = function() {
    //     closePopup();
    // }
    
    // function closePopup() {
    //     popup.style.display = 'none';
    //     document.body.style.overflow = 'auto';
    // }

    window.addEventListener('resize', function(){
        closeSearch();
    })

    document.addEventListener('click', function(event){
        if (event.target != profil && event.target != profilMobile){
            options.style.display = 'none';
        }
        if (event.target != profilMobile){
            optionsMobile.style.display = 'none';
        }
        if(event.target === popupSearch || event.target === header || event.target === document.getElementById("scene")) {
            closeSearch();
        }
    })

  
    profil.addEventListener('click', function() {
        if (options.style.display === 'none'|| !options.style.display) {
            options.style.display = 'block';
        } else {
            options.style.display = 'none';
        }
    });

    profilMobile.addEventListener('click', function() {
        if (optionsMobile.style.display === 'none' || !optionsMobile.style.display) {
            optionsMobile.style.display = 'flex';
        } else {
            optionsMobile.style.display = 'none';
        }
    });
    
    //popup.style.display = 'none';

    // oeuil.addEventListener('click', function() {
    //     if (popup.style.display === 'none') {
    //         popup.style.display = "flex";
    //         document.body.style.overflow = 'hidden';
    //     } else {
    //         closePopup();
    //     }
    // })

    parent__taille.addEventListener('click', function() {
            //mettre en plus grand
            
            if (document.body.classList.contains('accessibilite__taille')){
                parent__taille.style.backgroundColor = "#FFF";
                document.body.classList.remove('accessibilite__taille');
                parent__taille.style.color = "#000000";

                if (document.body.classList.contains('accessibilite__deute')) {
                    parent__taille.style.backgroundColor = "FFF";
                    parent__taille.style.color = "#000000";
                }
                localStorage.setItem('ModeTailleVal', "non");

            }
            else{
                parent__taille.style.backgroundColor = "#37906c";
                parent__taille.style.color = "#ffffff";
                document.body.classList.add('accessibilite__taille');

                if (document.body.classList.contains('accessibilite__deute')) {
                    parent__taille.style.backgroundColor = "brown";
                    parent__taille.style.color = "#ffffff";
                }

                localStorage.setItem('ModeTailleVal', "accessibilite__taille");

            }
    });

    parent__deute.addEventListener('click', function() {
 
        if (document.body.classList.contains('accessibilite__deute')){
            parent__deute.style.backgroundColor = "#FFF";
            document.body.classList.remove('accessibilite__deute');
            document.querySelector('header').classList.remove('accessibilite__deute');
            document.querySelector('footer').classList.remove('accessibilite__deute');        
            parent__deute.style.color = "#000000";
            
            if (document.body.classList.contains('accessibilite__font')) {
                parent__font.style.backgroundColor = "#37906c";
                parent__font.style.color = "#ffffff";
            }else{
                parent__font.style.backgroundColor = "#ffffff";
            }
            if (document.body.classList.contains('accessibilite__animations')) {
                parent__animations.style.backgroundColor = "#37906c";
                parent__animations.style.color = "#ffffff";
            }else{
                parent__animations.style.backgroundColor = "#ffffff";
            }
            if (document.body.classList.contains('accessibilite__taille')) {
                parent__taille.style.backgroundColor = "#37906c";
                parent__taille.style.color = "#ffffff";
            }else{
                parent__taille.style.backgroundColor = "#ffffff";
            }
            localStorage.setItem('ModeDeuteVal', "non");
        }
        else{
            parent__deute.style.backgroundColor = "brown";
            document.body.classList.add('accessibilite__deute');
            document.querySelector('header').classList.add('accessibilite__deute');
            document.querySelector('footer').classList.add('accessibilite__deute');
            parent__deute.style.color = "#ffffff";

            if (document.body.classList.contains('accessibilite__font')) {
                parent__font.style.backgroundColor = "brown";
                parent__font.style.color = "#ffffff";
            }
            if (document.body.classList.contains('accessibilite__animations')) {
                parent__animations.style.backgroundColor = "brown";
                parent__animations.style.color = "#ffffff";
            }
            if (document.body.classList.contains('accessibilite__taille')) {
                parent__taille.style.backgroundColor = "brown";
                parent__taille.style.color = "#ffffff";
            }

            localStorage.setItem('ModeDeuteVal', "accessibilite__deute");

        }
    });

    
    parent__font.addEventListener('click', function() {
 
        if (document.body.classList.contains('accessibilite__font')){
            parent__font.style.backgroundColor = "#FFF";
            document.body.classList.remove('accessibilite__font');
            parent__font.style.color = "#000000";

            if (document.body.classList.contains('accessibilite__deute')) {
                parent__font.style.backgroundColor = "FFF";
                parent__font.style.color = "#000000";
            }
            localStorage.setItem('ModeFontVal', "non");

            if (document.body.classList.contains('accessibilite__deute')) {
                parent__font.style.backgroundColor = "FFF";
                parent__font.style.color = "#000000";
            }
        }
        else{
            parent__font.style.backgroundColor = "#37906c";
            document.body.classList.add('accessibilite__font');
            parent__font.style.color = "#ffffff";

            if (document.body.classList.contains('accessibilite__deute')) {
                parent__font.style.backgroundColor = "brown";
                parent__font.style.color = "#ffffff";
            }
            localStorage.setItem('ModeFontVal', "accessibilite__font");

        }
    });

    parent__animations.addEventListener('click', function() {
 
        if (document.body.classList.contains('accessibilite__animations')){
            parent__animations.style.backgroundColor = "#FFF";
            document.body.classList.remove('accessibilite__animations');
            if (typeof checkParallaxAccessibilite === 'function') {
                checkParallaxAccessibilite();
            }        
            parent__animations.style.color = "#000000";

            if (document.body.classList.contains('accessibilite__deute')) {
                parent__animations.style.backgroundColor = "FFF";
                parent__animations.style.color = "#000000";
            }
            localStorage.setItem('ModeAnimationVal', "non");

        }
        else{
            parent__animations.style.backgroundColor = "#37906c";
            document.body.classList.add('accessibilite__animations');
            if (typeof checkParallaxAccessibilite === 'function') {
                checkParallaxAccessibilite();
            }
            parent__animations.style.color = "#ffffff";

            if (document.body.classList.contains('accessibilite__deute')) {
                parent__animations.style.backgroundColor = "brown";
                parent__animations.style.color = "#ffffff";
            }
            localStorage.setItem('ModeAnimationVal', "accessibilite__animations");

        }
        
    });

});