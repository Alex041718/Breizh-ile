document.addEventListener("DOMContentLoaded", function() {

    const popup_filters = document.querySelector(".popup__filter");
    const popup_filters_close = popup_filters.querySelector("i");
    const popup_filters_submit = popup_filters.querySelector("a");
    const popup_filters_open = document.getElementById("filter_button");
    
    var scene = document.getElementById('scene');
    var parallaxInstance = new Parallax(scene, {
        relativeInput: false
    });

    checkParallax();

    var scrollBtn = document.getElementById("scrolldown");
    var logements = document.querySelector(".logements");

    scrollBtn.addEventListener("click", function() {
        window.scrollTo(0, logements.offsetTop);
    })

    window.addEventListener("resize", function() {
        checkParallax();
    })

    function checkParallax() {
        if(window.innerWidth <= 1024) parallaxInstance.disable();
        else parallaxInstance.enable();
    }

    // popup

    popup_filters_open.addEventListener("click", function() {
        popup_filters.classList.add("popup_enable");
        document.body.style.overflow = "hidden";
    });

    function close_filter_popup() {
        popup_filters.classList.remove("popup_enable");
        document.body.style.overflow = "auto";
    }

    popup_filters_submit.addEventListener("click", close_filter_popup);
    popup_filters_close.addEventListener("click", close_filter_popup);

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
})