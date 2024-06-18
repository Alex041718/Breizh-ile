document.addEventListener("DOMContentLoaded", function() {
    const popups = document.querySelectorAll(".popup");

    console.log(popups);

    popups.forEach(popup => {

        const popupBtnId = popup.dataset.btn;
        const popupBtn = document.getElementById(popupBtnId);
        const popupCloseBtn = document.querySelector(".popup--close");

        console.log(popupCloseBtn)

        popup.addEventListener("click", function(event) {
            if(event.target === popup) popup.classList.remove("popup--open");
        })

        popupCloseBtn.addEventListener("click", function closePopup() {
            popup.classList.remove("popup--open");
        })

        popupBtn.addEventListener("click", function() {
            popup.classList.add("popup--open");
        })
        
    });
})

