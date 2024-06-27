export function loadPopUp() {
    const popups = document.querySelectorAll(".popup");

    popups.forEach(popup => {

        const popupBtnId = popup.dataset.btn;
        const popupBtns = document.querySelectorAll(`[id="${popupBtnId}"]`);
        const popupCloseBtn = popup.querySelector(".popup--close");

        popup.addEventListener("click", function(event) {
            if(event.target === popup){
                popup.classList.remove("popup--open");
                document.body.style.overflow = '';
            } 
        })

        if(!popupCloseBtn) return;

        popupCloseBtn.addEventListener("click", function closePopup() {
            popup.classList.remove("popup--open");
            document.body.style.overflow = '';
        })

        popupBtns.forEach(popupBtn => {
            popupBtn.addEventListener("click", function() {
                popup.classList.add("popup--open");
                document.body.style.overflow = "hidden";
            })
        })

    
    });
}

document.addEventListener("DOMContentLoaded", function() {
    loadPopUp();
})
