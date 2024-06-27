import { Toast } from "/components/Toast/Toast.js";

const apiKeys = document.querySelector('.content__api__keys');

export function showApiKeys() {
    const xhr = new XMLHttpRequest();
    xhr.open('GET', '/owner/ownerProfile/getApiKeys.php', true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            apiKeys.innerHTML = this.responseText;

            const copyBtns = document.querySelectorAll('.copy');

            copyBtns.forEach((copyBtn) => {
                copyBtn.addEventListener('click', function() {
                    const key = copyBtn.textContent.trim();
                    navigator.clipboard.writeText(key);
                    Toast("Clé copiée", "success");
                });
            });

            const popups = document.querySelectorAll(".popup");
            const acceptBtn = document.querySelector("[id^='acceptButton']");

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

                acceptBtn.addEventListener("click", () => {
                    if (housingID === null || index === null) {
                        Toast("Erreur lors de la modification de la visibilité", "error");
                        return 
                    };
                    changeVisibility(housingID, index);
                    document.querySelector(".popUpVisibility").classList.remove("popup--open");
                    Toast("Visibilité modifiée avec succès", "success");
                });
            });
        }
    };
    xhr.send();
}

document.addEventListener('DOMContentLoaded', () => {
    showApiKeys();
});