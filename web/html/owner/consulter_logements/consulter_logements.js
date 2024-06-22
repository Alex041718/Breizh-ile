import { loadPopUp } from "/components/Popup/popup.js";
import { changeVisibility } from "./changerVisibilite.js";
import { Toast } from "/components/Toast/Toast.js";

let housingID = null;
let index = null;

function main() {
    const housings = document.querySelector(".housings");
    const columns = document.querySelectorAll(".title p");

    housings.innerHTML = "Chargement...";
    
    function clearSort() {
        columns.forEach(column => {
            column.classList.remove("title--selected");
        });
    }

    function showReservations(sort="", isReverse=false) {
        let xhr = new XMLHttpRequest();
        let params = (sort === "") ? "" : `sort=${sort}&isReverse=${isReverse}`;

        xhr.open("POST", "/owner/consulter_logements/getHousing.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                housings.innerHTML = this.responseText;

                loadPopUp();
                
                const popUpVisibilityBtns = document.querySelectorAll("[id^='popUpVisibility-btn']");
                const acceptBtn = document.querySelector("[id^='acceptButton']");

                popUpVisibilityBtns.forEach((popUpVisibilityBtn) => {
                    popUpVisibilityBtn.addEventListener("click", () => {
                        housingID = popUpVisibilityBtn.dataset.housingid;
                        index = popUpVisibilityBtn.dataset.index;
                    });
                });

                acceptBtn.addEventListener("click", () => {
                    if (housingID === null || index === null) {
                        Toast("Erreur lors de la modification de la visibilité", "error");
                        return 
                    };
                    changeVisibility(housingID, index);
                    document.querySelector(".popUpVisibility").classList.remove("popup--open");
                    Toast("Visibilité modifiée avec succès", "success");
                });
            }
        };
        xhr.send(params);
    }

    columns.forEach((column) => {
        column.addEventListener("click", () => {
            let sort = column.dataset.sort;

            let isReverse = false;
            if(column.classList.contains("title--selected")) isReverse = true;
            if(column.classList.contains("title--reverse")) isReverse = false;

            clearSort();

            column.classList.add("title--selected");
            column.classList.toggle("title--reverse", isReverse);

            switch (sort) {
                case "title":
                    showReservations("getTitle", isReverse);
                    break;
                case "address":
                    showReservations("getAddress", isReverse);
                    break;
                case "price":
                    showReservations("getPriceIncl", isReverse);
                    break;
                case "nbPerson":
                    showReservations("getNbPerson", isReverse);
                    break;
                case "date-begin":
                    showReservations("getBeginDate", isReverse);
                    break;
                case "date-end":
                    showReservations("getEndDate", isReverse);
                    break;
                case "status":
                    showReservations("getIsOnline", isReverse);
                    break;
                default:
                    showReservations();
                    break;
            }
        });
    });

    showReservations();
}

document.addEventListener("DOMContentLoaded", () => {
    main();
});