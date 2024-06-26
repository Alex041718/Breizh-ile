function main() {
    const reservations = document.querySelector(".reservations");
    const columns = document.querySelectorAll(".title p");
    const checkboxes = document.getElementsByName("checkbox");
    const checkboxAll = document.getElementsByName("checkboxAll");
    const startDateInput = document.getElementById('start-date');
    const endDateInput = document.getElementById('end-date');
    const form = document.getElementById('generate-subscription-form');
    const urlInput = document.getElementById('subscription-url');
    const subscriptionUrlSection = document.querySelector('.subscription-url');
    const copyButton = document.getElementById('copy-button');
    let exportCheckboxes = document.querySelectorAll('.checkbox__input');

    const rows = document.querySelectorAll('.row');

    rows.forEach(row => {
        let openEye = row.querySelector('.open-eye');
        let closedEye = row.querySelector('.closed-eye');
        let token = row.querySelector('.token');

        closedEye.style.display = "none";
        openEye.addEventListener("click", function() {
            openEye.style.display = "none"
            closedEye.style.display = "block"
            token.classList.add("token--reveal")
        })
        closedEye.addEventListener("click", function() {
            openEye.style.display = "block"
            closedEye.style.display = "none"
            token.classList.remove("token--reveal")
        })
    });
    

    let reservationIDs = [];
    
    startDateInput.addEventListener('change', () => {
        endDateInput.min = startDateInput.value;
    });

    endDateInput.addEventListener('change', () => {
        startDateInput.max = endDateInput.value;
    });

    let selected_reservations = [];

    reservations.innerHTML = "Chargement...";

    function clearSort() {
        checkboxAll[0].checked = false;
        selected_reservations = [];
        columns.forEach(column => {
            column.classList.remove("title--selected");
        });
    }

    function applyCheckboxes() {
        checkboxAll[0].addEventListener("change", () => {
            checkboxes.forEach(checkbox => {
                checkbox.checked = checkboxAll[0].checked;
            });

            if (checkboxAll[0].checked) {
                selected_reservations = Array.from({ length: checkboxes.length }, (_, index) => index);
                exportCheckboxes = document.querySelectorAll('.checkbox__input');
                reservationIDs = [];
                exportCheckboxes.forEach(checkbox => {
                    if(checkbox === checkboxAll[0]) return;
                    reservationIDs.push(checkbox.parentElement.parentElement.dataset.reservationid);
                })
                updateReservationInput();

            } else {
                selected_reservations = [];
                reservationIDs = [];
            }

        });

        checkboxes.forEach((checkbox, index) => {
            checkbox.addEventListener("change", () => {
                if (!checkbox.checked) {
                    checkboxAll[0].checked = false;
                    selected_reservations = selected_reservations.filter(reservation => reservation !== index);
                } else {
                    selected_reservations.push(index);
                }
            });
        });
    }

    function showReservations(sort = "", isReverse = false) {
        let xhr = new XMLHttpRequest();
        let params = (sort === "") ? "" : `sort=${sort}&isReverse=${isReverse}`;

        xhr.open("POST", "/client/consulter_reservations/getReservations.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                reservations.innerHTML = this.responseText;
                exportCheckboxes = document.querySelectorAll('.checkbox__input');
                onRowSpawning();
                applyCheckboxes();
            }
        };
        xhr.send(params);
    }

    columns.forEach((column) => {
        column.addEventListener("click", () => {
            let sort = column.dataset.sort;

            let isReverse = false;
            if (column.classList.contains("title--selected")) isReverse = true;
            if (column.classList.contains("title--reverse")) isReverse = false;

            clearSort();

            column.classList.add("title--selected");
            column.classList.toggle("title--reverse", isReverse);

            switch (sort) {
                case "date-resa":
                    showReservations("getCreationDate", isReverse);
                    break;
                case "client":
                    showReservations("getClientId", isReverse);
                    break;
                case "logement":
                    showReservations("getHousingId", isReverse);
                    break;
                case "date-arrivee":
                    showReservations("getBeginDate", isReverse);
                    break;
                case "date-depart":
                    showReservations("getEndDate", isReverse);
                    break;
                case "methode-paiement":
                    showReservations("getPayMethodId", isReverse);
                    break;
                case "status":
                    showReservations("getStatus", isReverse);
                    break;
                default:
                    showReservations();
                    break;
            }
        });
    });

    console.log(exportCheckboxes);

    function updateReservationInput(checkbox) {
        let inputHidden = document.getElementById("reservationInput");
        
        if(!inputHidden) inputHidden = document.createElement("input");

        inputHidden.type = "hidden";
        inputHidden.id = "reservationInput";
        inputHidden.name = "reservationIDs";
        inputHidden.value = reservationIDs.join(',');

        
        form.appendChild(inputHidden);
    }

    function onRowSpawning() {
        exportCheckboxes.forEach((checkbox, index) => {
            if(index === 0) return;
            checkbox.addEventListener("change", () => {
                if(reservationIDs.includes(checkbox.parentElement.parentElement.dataset.reservationid)) reservationIDs.pop(checkbox.parentElement.parentElement.dataset.reservationid);
                else reservationIDs.push(checkbox.parentElement.parentElement.dataset.reservationid);
                updateReservationInput(checkbox);
                console.log(reservationIDs);
            });
        });
    }

    function generateSubscriptionUrl(event) {
        event.preventDefault();

        const startDate = document.getElementById('start-date').value;
        const endDate = document.getElementById('end-date').value;
        const selectedReservations = Array.from(document.querySelectorAll('input[name="checkbox"]:checked')).map(checkbox => checkbox.value);

        console.log(startDate, endDate, selectedReservations);

        if (!startDate || !endDate || selectedReservations.length === 0) {
            alert("Veuillez remplir tous les champs et sélectionner au moins une réservation.");
            return;
        }

        const xhr = new XMLHttpRequest();
        xhr.open("POST", "/client/consulter_reservations/generer_abonnement.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    try {
                        const response = JSON.parse(xhr.responseText);
                        if (response.success) {
                            console.log(selectedReservations);
                        } else {
                            alert(response.message);
                        }
                    } catch (e) {
                        console.error('Invalid JSON response', e);
                        alert('Une erreur s\'est produite lors de la génération de l\'URL.');
                    }
                } else {
                    alert('Erreur de serveur. Veuillez réessayer plus tard.');
                }
            }
        };

        const requestData = `reservations=${selectedReservations.join(",")}&startDate=${startDate}&endDate=${endDate}`;
        xhr.send(requestData);
    }




    function copyToClipboard() {
        const input = urlInput;
        input.select();
        document.execCommand('copy');
        alert("URL copiée dans le presse-papiers !");
    }

    // form.addEventListener('submit', generateSubscriptionUrl);

    if (copyButton) {
        copyButton.addEventListener('click', copyToClipboard);
    }

    showReservations();
};

function deleteSubscribe(token, index) {

    const row = document.querySelectorAll(".row")[index];

    let xhr = new XMLHttpRequest();
    let params = `token=${token}`;

    xhr.open("POST", "/client/consulter_reservations/delete_abonnement.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    row.outerHTML = "";
    
    xhr.send(params);
}

function modifySubscribe(token, isEditMode) {

    let url = location.protocol + '//' + location.host + location.pathname;
    
    let currentToken = window.location.search.substr(1)
    if(currentToken.includes("=")) currentToken = currentToken.split("=")[1]
    if(currentToken.includes("&")) currentToken = currentToken.split("&")[0];

    url += `?token=${token}`;


    if(!isEditMode || currentToken !== token) {
        url += "&editMode=enable";
    }
    window.location = url;

}

document.addEventListener("DOMContentLoaded", () => {
    main();
});
