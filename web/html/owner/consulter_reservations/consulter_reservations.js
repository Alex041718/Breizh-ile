import { Toast } from "/components/Toast/Toast.js";

const reservations = document.querySelector(".reservations");
const checkboxes = document.getElementsByName("checkbox");
const checkboxAll = document.getElementsByName("checkboxAll");

let current_tab = 1;

reservations.innerHTML = "Chargement...";
let selected_reservations = [];

function applyCheckboxes() {
    checkboxAll[0].addEventListener("change", () => {
        checkboxes.forEach(checkbox => {
            checkbox.checked = checkboxAll[0].checked;
        });

        selected_reservations = [];

        if (checkboxAll[0].checked) {
            checkboxes.forEach((checkbox) => {
                selected_reservations.push(checkbox.parentElement.parentElement.dataset.reservationid);
            });
        } else {
            selected_reservations = [];
        }

        let isAtLeastOneChecked = selected_reservations.length > 0;
        exportationButton.classList.toggle("button--disabled", !isAtLeastOneChecked);
        exportationButton.disabled = !isAtLeastOneChecked;
    });

    checkboxes.forEach((checkbox, index) => {
        checkbox.addEventListener("change", () => {
            if (!checkbox.checked) {
                checkboxAll[0].checked = false;
                selected_reservations = selected_reservations.filter(reservation => reservation !== index);
            } else {
                selected_reservations.push(checkbox.parentElement.parentElement.dataset.reservationid);
            }

            let isAtLeastOneChecked = selected_reservations.length > 0;
            exportationButton.classList.toggle("button--disabled", !isAtLeastOneChecked);
            exportationButton.disabled = !isAtLeastOneChecked;
        });
    });
}

function showReservations(sort="", isReverse=false, filter=1) {
    let xhr = new XMLHttpRequest();
    let params = (sort === "") ? "" : `sort=${sort}&isReverse=${isReverse}`;

    if (filter !== "") {
        if (params !== "") {
            params += `&filter=${filter}`;
        } else {
            params = `filter=${filter}`;
        }
    }

    xhr.open("POST", "/owner/consulter_reservations/getReservations.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            reservations.innerHTML = this.responseText;
            applyCheckboxes();
        }
    };
    xhr.send(params);
}

function main() {
    const columns = document.querySelectorAll(".title p");

    const exportationButton = document.getElementById("exportationButton");
    const exportSelectionType = document.querySelectorAll(".export-selection")[0];
    const closeButton = document.querySelectorAll(".closeExport")[0];
    const exportCheckboxes = document.querySelectorAll('[name="checkboxCSV"], [name="checkboxICAL"]');

    exportationButton.classList.toggle("button--disabled");
    exportationButton.disabled = true;

    function clearSort() {
        checkboxAll[0].checked = false;
        selected_reservations = [];
        columns.forEach(column => {
            column.classList.remove("title--selected");
        });
    }

    function exportReservations(type) {
        fetch("/owner/consulter_reservations/exportReservations.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: `type=${type}&reservations=${selected_reservations.join(",")}`
        })
        .then(response => response.text())
        .then(data => {
            let a = document.createElement("a");
            let file = new Blob([data], {type: "text/plain"});
            a.href = URL.createObjectURL(file);
            a.download = "reserverations_" + Date.now() + "." + (type === 0 ? "csv" : "ical");
            a.click();
            a.remove();
        });
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
                case "date-resa":
                    showReservations("getCreationDate", isReverse, current_tab);
                    break;
                case "client":
                    showReservations("getClientId", isReverse, current_tab);
                    break;
                case "logement":
                    showReservations("getHousingId", isReverse, current_tab);
                    break;
                case "date-arrivee":
                    showReservations("getBeginDate", isReverse, current_tab);
                    break;
                case "date-depart":
                    showReservations("getEndDate", isReverse, current_tab);
                    break;
                case "methode-paiement":
                    showReservations("getPayMethodId", isReverse, current_tab);
                    break;
                case "status":
                    showReservations("getStatus", isReverse, current_tab);
                    break;
                default:
                    showReservations("", false, current_tab);
                    break;
            }
        });
    });

    exportationButton.addEventListener("click", () => {
        if (!exportSelectionType.classList.contains("export-selection--visible")) {
            exportSelectionType.classList.toggle("export-selection--visible");
            exportationButton.innerHTML = '<i class="fa-solid fa-file-export"></i>' + "Valider l'exportation ?";
        } else {
            exportCheckboxes.forEach((checkbox, index) => {
                if (checkbox.checked) {
                    let type = index;
                    Toast("Exportation réussie !", "success");
                    exportReservations(type);
                }
            });
        }
    });

    closeButton.addEventListener("click", () => {
        exportSelectionType.classList.toggle("export-selection--visible");
        exportationButton.innerHTML = '<i class="fa-solid fa-file-export"></i>' + "Exporter la sélection";
    });

    exportCheckboxes.forEach((checkbox, index) => {
        checkbox.addEventListener("change", () => {
            let isAtLeastOneChecked = Array.from(exportCheckboxes).some(checkbox => checkbox.checked);
            exportationButton.classList.toggle("button--disabled", !isAtLeastOneChecked);
            exportationButton.disabled = !isAtLeastOneChecked;
        });
    });

    showReservations();
}

document.addEventListener("DOMContentLoaded", () => {
    main();

    const tabs = document.querySelectorAll(".top-container__right__button");
    const slidder = document.querySelector(".top-container__right__slider");

    tabs.forEach((tab, index) => {
        tab.addEventListener("click", () => {
            requestAnimationFrame(() => {
                slidder.style.transform = `translateX(${index * 9}rem)`;
            });

            tabs.forEach(tab => {
                tab.style.color = "#082C4C";
            });

            showReservations("", false, index);

            switch (index) {
                case 0:
                    slidder.style.backgroundColor = "#27AE60";
                    requestAnimationFrame(() => {
                        tab.style.color = "#FFF";
                    });
                    break;
                case 1:
                    slidder.style.backgroundColor = "#FFAF45";
                    break;
                case 2:
                    slidder.style.backgroundColor = "#2F80ED";
                    requestAnimationFrame(() => {
                        tab.style.color = "#FFF";
                    });
                    break;
                default:
                    slidder.style.backgroundColor = "#000000";
                    break;
            }

            current_tab = index;
        });
    });
});