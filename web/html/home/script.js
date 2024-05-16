document.addEventListener("DOMContentLoaded", function() {
    
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
})