
document.addEventListener("DOMContentLoaded", function() {

    const page1 = document.getElementById("page1");
    const page2 = document.getElementById("page2");
    const page3 = document.getElementById("page3");
    const page4 = document.getElementById("page4");

    const submitBtn = document.getElementById("submitBtn");
    const previousBtn = document.getElementById("previousBtn");
    const nextBtn = document.getElementById("nextBtn");


    
    page1.style.display = "block";
    page2.style.display = "none";
    page3.style.display = "none";
    page4.style.display = "none";
    submitBtn.style.display = "none";
    previousBtn.style.opacity = "0";
    previousBtn.style.pointerEvents = "none"

    previousBtn.addEventListener("click", function() {
        nextBtn.style.display = "block";
        submitBtn.style.display = "none";
        if(page4.style.display === "block") {
            page4.style.display = "none";
            page3.style.display = "block";
        }
        else if(page3.style.display === "block") {
            page2.style.display = "block";
            page3.style.display = "none";
        }
        else {
            page2.style.display = "none";
            page1.style.display = "block";
            previousBtn.style.opacity = "0";
            previousBtn.style.pointerEvents = "none"
        }
    })

    nextBtn.addEventListener("click", function() {
        previousBtn.style.opacity = "1";
        previousBtn.style.pointerEvents = "all"
        
        if(page1.style.display === "block") {
            page1.style.display = "none";
            page2.style.display = "block";
        }
        else if(page2.style.display === "block") {
            page2.style.display = "none";
            page3.style.display = "block";
        }
        else {
            page3.style.display = "none";
            page4.style.display = "block";
            submitBtn.style.display = "block";
            nextBtn.style.display = "none";
        }
    })

})